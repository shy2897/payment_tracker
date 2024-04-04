<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminApprovalNewAccept;
use App\Mail\AdminApprovalNewReject;


class AdminController extends Controller
{
    public function index(){

        $products = Product::get();
        $monthlyData = Product::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
        foreach ($products as $product) {
            $product->status_color = $this->getStatusColor($product->status);

            if($product->status === 'pending'){
                $product->notification += 1;
            }
            
        }

        return view('admin.products.index',['products'=>$products], compact('monthlyData'));
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
        $product = Product::where('id', $id)->first();
        
        return view('admin.products.show', ['product' => $product]);
    }

       
    public function approve(Request $request, $id){
         
        $product = Product::where('id',$id)->first();
        
        $product->status = 'approved';
        
        $product->save();

        Mail::to('shaiprd2897@gmail.com')->send(new AdminApprovalNewAccept($product));

        return back()->withSuccess('Record Approved !!!');
    }

    public function reject(Request $request, $id){
         
        $product = Product::where('id',$id)->first();
        
        $product->status = 'rejected';
        $product->remarks = $request->remarks;
        
        $product->save();

        Mail::to('shaiprd2897@gmail.com')->send(new AdminApprovalNewReject($product));

        return back()->withSuccess('Record Rejected !!!');
    }


    public function search_data(Request $request){
        $data = $request->input('search');
    
        // Check if the search data is in the format "Month Year"
        $isMonthYearSearch = preg_match('/^\w+ \d{4}$/', $data);
    
        if ($isMonthYearSearch) {
            list($month, $year) = explode(' ', $data);
    
            $products = DB::table('products')
                ->whereRaw("DATE_FORMAT(invoice_date, '%M %Y') = ?", ["$month $year"])
                ->get();
    
            $monthlyData = Product::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
                ->whereRaw("DATE_FORMAT(invoice_date, '%M %Y') = ?", ["$month $year"])
                ->groupBy('year', 'month')
                ->orderByDesc('year', 'month') 
                ->get();
            
        } else {
            // Handle other types of searches (invoice_no, invoice_date, or description)
            $products = DB::table('products')
                ->where('invoice_no', 'like', '%' . $data . '%')
                ->orWhere('invoice_date', 'like', '%' . $data . '%')
                ->orWhere('description', 'like', '%' . $data . '%')
                ->get();
    
            $monthlyData = Product::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
            ->where('invoice_no', 'like', '%' . $data . '%')
            ->orWhere('invoice_date', 'like', '%' . $data . '%')
            ->orWhere('description', 'like', '%' . $data . '%')
            ->groupBy('year', 'month')
            ->orderByDesc('year', 'month')
            ->get();
        }

        foreach ($products as $product) {
            $product->status_color = $this->getStatusColor($product->status);
        }
    
        return view('admin.products.index', compact('products', 'monthlyData'));
    }
       
    

    public function generatePdf($year, $month){
        $products = Product::get(); // Retrieve all products (You might want to filter them based on the year and month)
        $monthlyData = Product::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
        ->groupBy('year', 'month')
        ->orderByDesc('year', 'month')
        ->get();
    
        // Filter the products based on the year and month
        $filteredProducts = $products->filter(function ($product) use ($year, $month) {
            return date("Y", strtotime($product->invoice_date)) == $year && date("n", strtotime($product->invoice_date)) == $month;
        });
    
        // Load the Blade view with the filtered products
        $pdf = PDF::loadView('pdf.monthly_table', [
            'year' => $year,
            'month' => $month,
            'products' => $filteredProducts,
        ]);
    
        return $pdf->stream();
    }
}
