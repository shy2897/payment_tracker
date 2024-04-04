<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Annual;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminApprovalAnnualAccept;
use App\Mail\AdminApprovalAnnualReject;


class AdminAnnualController extends Controller
{
    public function index(){

        $annuals = Annual::get();
        $monthlyData = Annual::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
        foreach ($annuals as $annual) {
            $annual->status_color = $this->getStatusColor($annual->status);
        }

        return view('admin.annuals.index',['annuals'=>$annuals], compact('monthlyData'));
    }

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'pending':
                return 'yellow';
            case 'approved':
                return 'green';
            case 'rejected':
                return 'red';
        }
    }

    public function show($id){
        $annual = Annual::where('id', $id)->first();
        
        return view('admin.annuals.show', ['annual' => $annual]);
    }

       
    public function approve(Request $request, $id){
         
        $annual = Annual::where('id',$id)->first();
        
        $annual->status = 'approved';
        
        $annual->save();

        Mail::to('shaiprd2897@gmail.com')->send(new AdminApprovalAnnualAccept($annual));

        return back()->withSuccess('Record Approved !!!');
    }

    public function reject(Request $request, $id){
         
        $annual = Annual::where('id',$id)->first();
        
        $annual->status = 'rejected';
        $annual->remarks = $request->remarks;
        
        $annual->save();

        Mail::to('shaiprd2897@gmail.com')->send(new AdminApprovalAnnualReject($annual));

        return back()->withSuccess('Record Rejected !!!');
    }


    public function search_data(Request $request){
        $data = $request->input('search');
    
        // Check if the search data is in the format "Month Year"
        $isMonthYearSearch = preg_match('/^\w+ \d{4}$/', $data);
    
        if ($isMonthYearSearch) {
            list($month, $year) = explode(' ', $data);
    
            $annual = DB::table('annuals')
                ->whereRaw("DATE_FORMAT(invoice_date, '%M %Y') = ?", ["$month $year"])
                ->get();
    
            $monthlyData = Annual::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
                ->whereRaw("DATE_FORMAT(invoice_date, '%M %Y') = ?", ["$month $year"])
                ->groupBy('year', 'month')
                ->orderByDesc('year', 'month')
                ->get();
            
        } else {
            // Handle other types of searches (invoice_no, invoice_date, or description)
            $annuals = DB::table('annuals')
                ->where('invoice_no', 'like', '%' . $data . '%')
                ->orWhere('invoice_date', 'like', '%' . $data . '%')
                ->orWhere('description', 'like', '%' . $data . '%')
                ->get();
    
            $monthlyData = Annual::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
            ->where('invoice_no', 'like', '%' . $data . '%')
            ->orWhere('invoice_date', 'like', '%' . $data . '%')
            ->orWhere('description', 'like', '%' . $data . '%')
            ->groupBy('year', 'month')
            ->orderByDesc('year', 'month')
            ->get();
        }

        foreach ($annuals as $annual) {
            $annual->status_color = $this->getStatusColor($annual->status);
        }
    
        return view('admin.annuals.index', compact('annuals', 'monthlyData'));
    }
       
    

    public function generatePdf($year, $month){
        $annuals = Annual::get(); // Retrieve all products (You might want to filter them based on the year and month)
        $monthlyData = Annual::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
        ->groupBy('year', 'month')
        ->orderByDesc('year', 'month')
        ->get();
    
        // Filter the products based on the year and month
        $filteredProducts = $annuals->filter(function ($annual) use ($year, $month) {
            return date("Y", strtotime($annual->invoice_date)) == $year && date("n", strtotime($annual->invoice_date)) == $month;
        });
    
        // Load the Blade view with the filtered products
        $pdf = PDF::loadView('pdf.annual_monthly_table', [
            'year' => $year,
            'month' => $month,
            'annuals' => $filteredProducts,
        ]);
    
        return $pdf->stream();
    }
}
