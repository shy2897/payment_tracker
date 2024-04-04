<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Change;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminApprovalChangeAccept;
use App\Mail\AdminApprovalChangeReject;


class AdminChangeController extends Controller
{
    public function index(){

        $changes = Change::get();
        $monthlyData = Change::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
        foreach ($changes as $change) {
            $change->status_color = $this->getStatusColor($change->status);
        }

        return view('admin.changes.index',['changes'=>$changes], compact('monthlyData'));
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
        $change = Change::where('id', $id)->first();
        
        return view('admin.changes.show', ['change' => $change]);
    }

       
    public function approve(Request $request, $id){
         
        $change = Change::where('id',$id)->first();
        
        $change->status = 'approved';
        
        $change->save();

        Mail::to('shaiprd2897@gmail.com')->send(new AdminApprovalChangeAccept($change));

        return back()->withSuccess('Record Approved !!!');
    }

    public function reject(Request $request, $id){
         
        $change = Change::where('id',$id)->first();
        
        $change->status = 'rejected';
        $change->remarks = $request->remarks;
        
        $change->save();

        Mail::to('shaiprd2897@gmail.com')->send(new AdminApprovalChangeReject($change));

        return back()->withSuccess('Record Rejected !!!');
    }


    public function search_data(Request $request){
        $data = $request->input('search');
    
        // Check if the search data is in the format "Month Year"
        $isMonthYearSearch = preg_match('/^\w+ \d{4}$/', $data);
    
        if ($isMonthYearSearch) {
            list($month, $year) = explode(' ', $data);
    
            $changes = DB::table('changes')
                ->whereRaw("DATE_FORMAT(invoice_date, '%M %Y') = ?", ["$month $year"])
                ->get();
    
            $monthlyData = Change::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
                ->whereRaw("DATE_FORMAT(invoice_date, '%M %Y') = ?", ["$month $year"])
                ->groupBy('year', 'month')
                ->orderByDesc('year', 'month')
                ->get();
            
        } else {
            // Handle other types of searches (invoice_no, invoice_date, or description)
            $changes = DB::table('annuals')
                ->where('invoice_no', 'like', '%' . $data . '%')
                ->orWhere('invoice_date', 'like', '%' . $data . '%')
                ->orWhere('description', 'like', '%' . $data . '%')
                ->get();
    
            $monthlyData = Change::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
            ->where('invoice_no', 'like', '%' . $data . '%')
            ->orWhere('invoice_date', 'like', '%' . $data . '%')
            ->orWhere('description', 'like', '%' . $data . '%')
            ->groupBy('year', 'month')
            ->orderByDesc('year', 'month')
            ->get();
        }

        foreach ($changes as $change) {
            $change->status_color = $this->getStatusColor($change->status);
        }
    
        return view('admin.changes.index', compact('changes', 'monthlyData'));
    }
       
    

    public function generatePdf($year, $month){
        $changes = Change::get(); // Retrieve all products (You might want to filter them based on the year and month)
        $monthlyData = Change::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
        ->groupBy('year', 'month')
        ->orderByDesc('year', 'month')
        ->get();
    
        // Filter the products based on the year and month
        $filteredProducts = $changes->filter(function ($change) use ($year, $month) {
            return date("Y", strtotime($change->invoice_date)) == $year && date("n", strtotime($change->invoice_date)) == $month;
        });
    
        // Load the Blade view with the filtered products
        $pdf = PDF::loadView('pdf.change_monthly_table', [
            'year' => $year,
            'month' => $month,
            'changes' => $filteredProducts,
        ]);
    
        return $pdf->stream();
    }
}
