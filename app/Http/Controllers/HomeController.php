<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Annual;
use App\Models\Change;
use App\Models\Capex;
use App\Models\Opex;
use App\Models\Budget;
use App\Models\Category;



class HomeController extends Controller
{
    public function index(){

        $category = Category::get();
        $records = Category::selectRaw('year as year')
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->get();

        $products = Product::get();
        $annuals = Annual::get();
        $changes = Change::get();
        $capexs = Capex::get();
        $opexs = Opex::get();

        $product_approved = 0; $product_rejected = 0; $product_pending = 0;
        $annual_approved = 0; $annual_rejected = 0; $annual_pending = 0;
        $change_approved = 0; $change_rejected = 0; $change_pending = 0;
        $capex_approved = 0; $capex_rejected = 0; $capex_pending = 0;
        $opex_approved = 0; $opex_rejected = 0; $opex_pending = 0;
        $total_approved = 0; $total_rejected = 0; $total_pending = 0;
        $total_records = 0;


        

        foreach ($products as $product) {
            $total_records += 1;
            if ($product->status === 'approved') {
                $product_approved += 1;
                $total_approved += 1;
            } 
            elseif ($product->status === 'rejected') {
                $product_rejected += 1;
                $total_rejected += 1;

            } 
            else {
                // Assuming 'pending' is the default status if it's not 'approved' or 'rejected'
                $product_pending += 1;
                $total_pending += 1;

            }     
        }

        foreach ($annuals as $annual) {
            $total_records += 1;
            if ($annual->status === 'approved') {
                $annual_approved += 1;
                $total_approved += 1;

            } 
            elseif ($annual->status === 'rejected') {
                $annual_rejected += 1;
                $total_rejected += 1;

            } 
            else {
                // Assuming 'pending' is the default status if it's not 'approved' or 'rejected'
                $annual_pending += 1;
                $total_pending += 1;

            }     
        }

        foreach ($changes as $change) {
            $total_records += 1;

            if ($change->status === 'approved') {
                $change_approved += 1;
                $total_approved += 1;

            } 
            elseif ($change->status === 'rejected') {
                $change_rejected += 1;
                $total_rejected += 1;

            } 
            else {
                // Assuming 'pending' is the default status if it's not 'approved' or 'rejected'
                $change_pending += 1;
                $total_pending += 1;

            }     
        }

        foreach ($capexs as $capex) {
            $total_records += 1;

            if ($capex->status === 'approved') {
                $capex_approved += 1;
                $total_approved += 1;

            } 
            elseif ($capex->status === 'rejected') {
                $capex_rejected += 1;
                $total_rejected += 1;

            } 
            else {
                // Assuming 'pending' is the default status if it's not 'approved' or 'rejected'
                $capex_pending += 1;
                $total_pending += 1;

            }     
        }

        foreach ($opexs as $opex) {
            $total_records += 1;

            if ($opex->status === 'approved') {
                $opex_approved += 1;
                $total_approved += 1;

            } 
            elseif ($opex->status === 'rejected') {
                $opex_rejected += 1;
                $total_rejected += 1;

            } 
            
            else {
                // Assuming 'pending' is the default status if it's not 'approved' or 'rejected'
                $opex_pending += 1;
                $total_pending += 1;

            }     
        }

        return view('home', compact('product_approved', 'product_rejected', 'product_pending', 
        'annual_approved', 'annual_rejected', 'annual_pending', 
        'change_approved', 'change_rejected', 'change_pending',
        'capex_approved', 'capex_rejected', 'capex_pending',
        'opex_approved', 'opex_rejected', 'opex_pending',
        'total_approved', 'total_rejected', 'total_pending',
        'total_records', 'records'));
    }

    public function admin(){

        $products = Product::get();
        $annuals = Annual::get();
        $changes = Change::get();

        $product_approved = 0; $product_rejected = 0; $product_pending = 0;
        $annual_approved = 0; $annual_rejected = 0; $annual_pending = 0;
        $change_approved = 0; $change_rejected = 0; $change_pending = 0;

        foreach ($products as $product) {
            if ($product->status === 'approved') {
                $product_approved += 1;
            } 
            elseif ($product->status === 'rejected') {
                $product_rejected += 1;
            } 
            else {
                // Assuming 'pending' is the default status if it's not 'approved' or 'rejected'
                $product_pending += 1;
            }     
        }

        foreach ($annuals as $annual) {
            if ($annual->status === 'approved') {
                $annual_approved += 1;
            } 
            elseif ($annual->status === 'rejected') {
                $annual_rejected += 1;
            } 
            else {
                // Assuming 'pending' is the default status if it's not 'approved' or 'rejected'
                $annual_pending += 1;
            }     
        }

        foreach ($changes as $change) {
            if ($change->status === 'approved') {
                $change_approved += 1;
            } 
            elseif ($change->status === 'rejected') {
                $change_rejected += 1;
            } 
            else {
                // Assuming 'pending' is the default status if it's not 'approved' or 'rejected'
                $change_pending += 1;
            }     
        }


        return view('admin_home', compact('product_approved', 'product_rejected', 'product_pending', 'annual_approved', 'annual_rejected', 'annual_pending', 'change_approved', 'change_rejected', 'change_pending'));
    }
}
