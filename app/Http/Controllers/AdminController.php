<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Order;
use App\Models\Product;
use Auth;
use Hash;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        if(Auth::check()) {
            if (Auth::user()->role == '1') {
//                echo "login";
                return redirect(url('admin/dashboard'));
            }
        }else{
//            echo "nothing";
            return redirect('/login');
        }
    }
    public function salesReport(Request $request)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $bestSellingProducts = DB::table('order_product')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->select('order_product.product_id', DB::raw('SUM(order_product.quantity) as total_sales'))
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('order_product.product_id')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();

        $bestSellingProductNames = [];
        $bestSellingProductSales = [];

        foreach ($bestSellingProducts as $product) {
            $productData = Product::find($product->product_id);
            if ($productData) {
                $bestSellingProductNames[] = $productData->title;
                $bestSellingProductSales[] = $product->total_sales;
            }
        }

        $revenueData = Order::select(DB::raw('DATE(created_at) as order_date'),
            DB::raw('SUM(final_amount) as total_revenue'))
            ->where('status', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('order_date')
            ->get();

        $revenueDates = [];
        $revenueAmounts = [];

        foreach ($revenueData as $data) {
            $revenueDates[] = date('d-m-Y', strtotime($data->order_date));
            $revenueAmounts[] = $data->total_revenue;
        }


        return response()->json([
            'bestSellingProductNames' => $bestSellingProductNames,
            'bestSellingProductSales' => $bestSellingProductSales,
            'revenueDates' => $revenueDates,
            'revenueAmounts' => $revenueAmounts,
        ]);
    }



    function dashboard(Request $request){
        if(Auth::check()) {
            if (Auth::user()->role == '1') {
                // Calculate the date range for the previous month
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();

//                $startDate = $request->input('start_date');
//                $endDate = $request->input('end_date');

                $bestSellingProducts = DB::table('order_product')
                    ->join('orders', 'order_product.order_id', '=', 'orders.id')
                    ->select('order_product.product_id', DB::raw('SUM(order_product.quantity) as total_sales'))
                    ->whereBetween('orders.created_at', [$startDate, $endDate])
                    ->groupBy('order_product.product_id')
                    ->orderByDesc('total_sales')
                    ->limit(5)
                    ->get();

                $bestSellingProductNames = [];
                $bestSellingProductSales = [];

                foreach ($bestSellingProducts as $product) {
                    $productData = Product::find($product->product_id);
                    if ($productData) {
                        $bestSellingProductNames[] = $productData->title;
                        $bestSellingProductSales[] = $product->total_sales;
                    }
                }

                $revenueData = Order::select(DB::raw('DATE(created_at) as order_date'),
                    DB::raw('SUM(final_amount) as total_revenue'))
                    ->where('status', 1)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('order_date')
                    ->get();

                $revenueDates = [];
                $revenueAmounts = [];

                foreach ($revenueData as $data) {
                    $revenueDates[] = date('d-m-Y', strtotime($data->order_date));
                    $revenueAmounts[] = $data->total_revenue;
                }

//                print_r($revenueData);die;

                return view('admin.dashboard', [
                    'bestSellingProductNames' => array_values($bestSellingProductNames),
                    'bestSellingProductSales' => array_values($bestSellingProductSales),
                    'bestSellingProducts' => $bestSellingProducts,
                    'revenueDates' => $revenueDates,
                    'revenueAmounts' => $revenueAmounts,
                ]);
            } else {
                abort('403', 'You Are Not Admin !!! Access Denied');
            }

        } else {
            return redirect(route('login'));
        }
    }


    function my_profile(){
        if(Auth::check()){
            if(Auth::user()->role == 1){
                $data['password'] = Auth::user()->salt_password;
                return view('admin.my_profile',$data);
            }else{
                abort('403','Your Are Not Admin !!! Access Denied');
            }
        }else{
            return redirect(route('login'));
        }
    }

    function update_profile(Request $request){
        if(!Auth::check()){
            return  redirect(url('admin/login'));
        }else{
            if(Auth::user()->role != 1){
                return abort(403,'Unauthorized');
            }
        }
        $sql = User::find(Auth::user()->id);
        $sql->password = Hash::make($request->password);
        $sql->salt_password = $request->password;
        if($sql->save()){
            Session::flash('success','Profile Updated');
            return redirect(url('admin/my-profile'));
        }else{
            Session::flash('error','Profile not Updated');
            return redirect(url('admin/my-profile'));
        }
    }

    function all_enquiry(){
        if(!Auth::check()){
            return  redirect(url('admin/login'));
        }else{
            if(Auth::user()->role != 1){
                return abort(403,'Unauthorized');
            }
        }
        $data['page_heading'] = 'Enquiry';
        $data['enquiry'] = Enquiry::orderBy('created_at', 'DESC')->get();
        return view('admin.enquiry',$data);
    }
    function newsletter(){
        if(!Auth::check()){
            return  redirect(url('admin/login'));
        }else{
            if(Auth::user()->role != 1){
                return abort(403,'Unauthorized');
            }
        }
        $data['page_heading'] = 'NEWSLETTER';
        $data['newsletter'] = \App\Models\Newsletter::orderBy('created_at', 'DESC')->get();
        return view('admin.users.newsletter',$data);
    }

}
