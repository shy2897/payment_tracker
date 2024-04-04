<?php

namespace App\Http\Controllers\UserPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Capex;
use App\Models\Budget;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalNotification;
use Illuminate\Support\Facades\Auth;
use App\Mail\AdminApprovalNewReject;


class CapexController extends Controller
{
    
    public function index(){

        $products = Capex::get();
        $monthlyData = Capex::selectRaw('YEAR(invoice_date) as year, sub_category as sub_category')
        ->groupBy('year', 'sub_category')
        ->orderBy('year', 'desc')
        ->get();

        foreach ($products as $product) {
            $product->status_color = $this->getStatusColor($product->status);
        }

        $budgets = Budget::where('category', 'capex')->get();
        foreach($budgets as $budget){
            $budget->balance = $budget->subtraction + $budget->budget;
            $budget->save();
        }
        $categories = Category::where('category', 'capex')->get();
        foreach($categories as $category){
            $category->balance = $category->subtraction + $category->budget;
            $category->save();
        }


        return view('capexs.index', ['products' => $products, 'budgets' => $budgets, 'categories' => $categories, 'monthlyData' => $monthlyData]);
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

    public function budget(Request $request, $budgetId)
    {
        $budget = Budget::where('id',$budgetId)->first();
        
        $budget->budget = $request->edit;
        $budget->b_edited_by = Auth::user()->name;
        $budget->save();

        return back()->withSuccess('Budget Updated !!!');    
    }

    public function sub_category_budget(Request $request, $budgetId)
    {
        $budget = Category::where('id',$budgetId)->first();
        
        $budget->budget = $request->edit;
        // $budget->b_edited_by = Auth::user()->name;
        $budget->save();

        return back()->withSuccess('Budget Updated !!!');    
    }

    public function usd_rate(Request $request, $id){
         
        $product = Capex::where('id',$id)->first();
        
        $product->usd_rate = $request->usd_rate;
        $product->prev_currency = $product->currency;
        $product->currency = 'BTN';
        $product->prev_amount = $product->amount;
        $product->amount = $product->usd_rate*$product->amount;
        $product->rate = $product->usd_rate*$product->rate;
        $product->tds = $product->usd_rate*$product->tds;
        $product->amc = $product->usd_rate*$product->amc;
        $product->save();

        $successMessage = 'USD converted to BTN with  currency rate: ' . $product->usd_rate . '!!!';

        return back()->withSuccess($successMessage);

    }

    public function sub_category(Request $request){
        $request->validate([
            'year' => 'required',
            'sub_category' => 'required',
        ]);

        $category = new Category;
        $category->year = $request->year;
        $category->sub_category = $request->sub_category;
        $category->category = $request->category;
        $category->save();

        return back()->withSuccess('New subcategory added to year: ' . $category->year);
    }

    public function sub_category_year($year, $category) {
        $categories = Category::where('year', $year)
        -> where('category', $category)->get();
        return response()->json($categories);
    }

    public function create(){
        $category = Category::where('category', 'capex')->get();
        return view('capexs.create', ['category' => $category]);
    }

    public function create_approval(){
        return view('capexs.approval_create');
    }

    public function store(Request $request){

        //validate data
        $request->validate([
            'invoice_no' => 'unique:products,invoice_no',
            'description' => 'required',
            'amount' => 'required',
            'rate' => 'required',
            'radio' => 'required',
            'sub_category' => 'required',
            'file' => 'mimes:pdf,docx,xlsx,xls,csv|max:300000'
        ]);

        $product = new Capex;
        
        if ($request->hasFile('file')) {
            $fileName = time().'.'.$request->file->extension();
            $request->file->move(public_path('capexs'), $fileName);
            $product->file = $fileName;
        } else {
            // Handle the case where no file was uploaded
            $product->file = null; 
        }

        $product->invoice_no = $request->invoice_no;
        $product->invoice_date = $request->invoice_date;
        $product->vendor = $request->vendor;
        $product->units = $request->units;
        $product->deadline_date = $request->deadline_date;
        $product->comment = $request->comment;
        $product->description = $request->description;
        $product->currency = $request->currency;
        $product->rate = $request->rate;
        $product->tds = $request->tds;
        $product->amc = $request->amc;
        $product->amount = $request->amount;
        $product->status = $request->radio;
        $product->created_by = Auth::user()->name;
        $product->sub_category = $request->sub_category;
        $product->save();

        $year = date('Y', strtotime($product->invoice_date));
        $budget = Budget::where('category', 'capex')->where('year', $year)->first();
        $category = Category::where('category', 'capex')->where('sub_category', $product->sub_category)->first();


        if ($product->status === 'pending') {
            // Mail::to('shaiprd2897@gmail.com')->send(new ApprovalNotification($product));
            return back()->withSuccess('Record created and status is pending !!!');

        }
        else{
            if($product->currency === 'BTN' || $product->currency === 'INR'){
                $product->status = 'approved';
                $product->approved_by = Auth::user()->name;
                $product->save();
    
                $budget->subtraction = $budget->subtraction - $product->amount;
                $budget->save();

                $category->subtraction = $category->subtraction - $product->amount;
                $category->save();
                // Mail::to('shaiprd2897@gmail.com')->send(new AdminApprovalNewAccept($product));
                return back()->withSuccess('Record Created and subtracted from budget balance !!!');
            }
            else{      
                
                $product->delete();
                return back()->withSuccess('Convert USD to BTN first!!!(Status cannot Approved for USD)');
            }
        }
    
    }

    public function edit($id){

        $product = Capex::where('id',$id)->first();
        return view('capexs.edit',['product' => $product]);
    }
    
    public function update(Request $request, $id){
         //validate data
         $request->validate([
            'invoice_no' => 'required',
            'description' => 'required',
            'invoice_date' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'file' => 'mimes:pdf,docx,xlsx,xls,csv|max:300000'
        ]);
        
        $product = Capex::where('id',$id)->first();

        if(isset($request->file)){
            //upload image
            $fileName = time().'.'.$request->file->extension();
            $request->file->move(public_path('capexs'), $fileName);
            $product->file = $fileName;
        }
        
        $product->invoice_no = $request->invoice_no;
        $product->invoice_date = $request->invoice_date;
        $product->vendor = $request->vendor;
        $product->units = $request->units;
        $product->deadline_date = $request->deadline_date;
        $product->comment = $request->comment;
        $product->description = $request->description;
        $product->currency = $request->currency;
        $product->rate = $request->rate;
        $product->tds = $request->tds;
        $product->amc = $request->amc;
        $product->amount = $request->amount;
        $product->edited_by = Auth::user()->name;
        $product->sub_category = $request->sub_category;

        $product->save();

        return back()->withSuccess('Record Updated !!!');
    }

    public function destroy($id){
        $product = Capex::where('id',$id)->first();
        $year = date('Y', strtotime($product->invoice_date));
        $budget = Budget::where('category', 'capex')->where('year', $year)->first();
        $category = Category::where('category', 'capex')->where('sub_category', $product->sub_category)->first();

        if($product->status === 'approved'){
            $budget->subtraction = $budget->subtraction + $product->amount;
            $budget->balance = $budget->subtraction + $budget->balance;
            $budget->save();

            $category->subtraction = $category->subtraction + $product->amount;
            $category->balance = $category->subtraction + $category->balance;
            $category->save();

            $product->delete();
            return back()->withSuccess('Record Deleted and amount added back to balance amount !!!');
        }
        else {
            $product->delete();
            return back()->withSuccess('Record Deleted !!!');
        }

    }

    public function show($id){
    $product = Capex::where('id', $id)->first();
    
    return view('capexs.show', ['product' => $product]);
    }


    public function search_data(Request $request){
        $data = $request->input('search');
        
        // Combine conditions into a single query
        $products = DB::table('capexes')
            ->where(function($query) use ($data) {
                $query->where('invoice_no', 'like', '%' . $data . '%')
                      ->orWhere('description', 'like', '%' . $data . '%');
            })
            ->get();
    
        // Use Eloquent for better readability and maintainability
        $monthlyData = Capex::selectRaw('YEAR(invoice_date) as year, sub_category as sub_category')
            ->where('invoice_no', 'like', '%' . $data . '%')
            ->orWhere('description', 'like', '%' . $data . '%')
            ->groupBy('year', 'sub_category')
            ->orderBy('year', 'desc')
            ->get();
    
        // Update budgets and categories in bulk
        Budget::where('category', 'capex')
            ->update(['balance' => DB::raw('subtraction + budget')]);
    
        Category::where('category', 'capex')
            ->update(['balance' => DB::raw('subtraction + budget')]);
    
        // Apply status color to products
        foreach ($products as $product) {
            $product->status_color = $this->getStatusColor($product->status);
        }
    
        // Fetch budgets and categories after updates
        $budgets = Budget::where('category', 'capex')->get();
        $categories = Category::where('category', 'capex')->get();
    
        return view('capexs.search', ['products' => $products, 'budgets' => $budgets, 'categories' => $categories, 'monthlyData' => $monthlyData]);
    }
    
       
    

    public function test(){

        $products = Capex::get();
        $monthlyData = Capex::selectRaw('YEAR(invoice_date) as year, MONTH(invoice_date) as month')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

        foreach ($products as $product) {
            $product->status_color = $this->getStatusColor($product->status);
        }

        $budgets = Budget::where('category', 'capex')->get();
        foreach($budgets as $budget){
            $budget->balance = $budget->subtraction + $budget->budget;
            $budget->save();
        }


        return view('capexs.test', ['products' => $products, 'budgets' => $budgets, 'monthlyData' => $monthlyData]);
    }


    public function generatePdf($year, $month){
        $products = Capex::get(); // Retrieve all products (You might want to filter them based on the year and month)
        $monthlyData = Capex::selectRaw('YEAR(invoice_date) as year, sub_category as sub_category')
        ->groupBy('year', 'sub_category')
        ->orderBy('year', 'desc')
        ->get();
    
        // Filter the products based on the year and month
        $filteredProducts = $products->filter(function ($product) use ($year, $month) {
            return date("Y", strtotime($product->invoice_date)) == $year && $product->sub_category == $month;
        });
    
        // Load the Blade view with the filtered products
        $pdf = PDF::loadView('pdf.monthly_table', [
            'year' => $year,
            'month' => $month,
            'products' => $filteredProducts,
        ]);
    
        return $pdf->stream();
    }

    public function approve(Request $request, $id) {
         
        $product = Capex::where('id',$id)->first();
        $year = date('Y', strtotime($product->invoice_date));
        $budget = Budget::where('category', 'capex')->where('year', $year)->first();
        $category = Category::where('category', 'capex')->where('sub_category', $product->sub_category)->first();


        if($product->currency === 'BTN' || $product->currency === 'INR'){
            $product->status = 'approved';
            $product->approved_by = Auth::user()->name;
            $product->save();

            $budget->subtraction = $budget->subtraction - $product->amount;
            $budget->save();

            $category->subtraction = $category->subtraction - $product->amount;
            $category->save();
            // Mail::to('shaiprd2897@gmail.com')->send(new AdminApprovalNewAccept($product));
            return back()->withSuccess('Record Approved !!!');
        }
        else{
            return back()->withSuccess('Convert USD to BTN first !!!');
        }
    }

    public function reject(Request $request, $id){
        $product = Capex::where('id',$id)->first();
        if($product->status === 'approved') {
            return back()->withSuccess('Record cannot be rejected once approved!!!');
         }
        else{
            $product->status = 'rejected';
            $product->rejection_reason = $request->remarks;
            $product->save();
            // Mail::to('shaiprd2897@gmail.com')->send(new AdminApprovalNewReject($product));
            return back()->withSuccess('Record Rejected !!!');
        }
    }
}
