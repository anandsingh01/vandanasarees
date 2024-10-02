<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\UserAddress;
use App\Models\WishlistModel;
use Illuminate\Http\Request;
use App\Models\AboutModels;
use App\Models\AnnualReportModel;
use App\Models\BannerModel;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CollaborationModel;
use App\Models\FounderModel;
use App\Models\MetalModel;
use App\Models\MissionModel;
use App\Models\Product;
use App\Models\ProjectDetail;
use App\Models\ProjectModel;
use App\Models\ServiceModel;
use App\Models\SupportModel;
use App\Models\Team;
use App\Models\User;
use App\Models\WhoWeAre;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Hash;

use Auth;
class UserController extends Controller
{
    function dashboard(){
        if(Auth::check() && Auth::user()->role == '2'){
            $data['orders'] = Order::orderBy('id','DESC')
                ->where('user_id',Auth::user()->id)
//                ->orWhere('ip_address',$_SERVER['REMOTE_ADDR'])
                ->where('status','!=','0')
                ->get();

            $data['wishlist'] = WishlistModel::orderBy('id','DESC')
                ->with('product')
                ->where( 'user_id' , Auth::user()->id )
                ->get();

            $data['user_address'] = UserAddress::orderBy('id','DESC')
                ->where( 'user_id' , Auth::user()->id )
                ->get();
//            print_r($data['wishlist']);die;
            return view('web.users.dashboard',$data);
        }else{
            return redirect(url('login'));
        }
    }

    public function update(Request $request)
    {
        $userid = Auth::user();
        $user = User::find(Auth::user()->id);

        // Update user's name and email
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile_number = $request->input('mobile_number');

        // Update password if provided
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
            $user->salt_password = $request->input('password');
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    function view_order($id){
        if(Auth::check()){
//            if(Auth::user()->role == '2'){
//
//            }
            $data['page_heading'] = 'View Order';
            $data['orders'] = Order::with('get_order_products')->find($id);
            if(!empty($data['orders'])){
                return view('web.users.view-order',$data);
            }else{
                return abort('404','Order not found');
            }
        }else{
            return redirect(url('login'));
        }

    }

    function view_order_guest($id){
//        print_r($id);
//        die;
        $data['page_heading'] = 'View Order';
        $data['orders'] = Order::with('get_order_products')->find($id);
//        print_r($data);die;
        if(!empty($data['orders'])){
            return view('web.users.view-order-guest',$data);
        }else{
            return abort('404','Order not found');
        }

    }

    function my_orders(){

        if(!Auth::check()){
            return redirect(url('/login'));
        }
        $data['page_heading'] = 'Order';
        $data['orders'] = Order::orderBy('id','DESC')
            ->where('user_id',Auth::user()->id)
//            ->orWhere('ip_address',$_SERVER['REMOTE_ADDR'])
            ->where('status','!=','0')
            ->get();
//            print_r($data);die;
        return view('web.users.my-order',$data);
    }

    function all_user(){
        if(!Auth::check()){
            return  redirect(url('admin/login'));
        }else{
            if(Auth::user()->role != 1){
                return abort(403,'Unauthorized');
            }
        }
        $data['page_heading'] = 'All Users';
        $data['users'] = User::with('get_address')->where('role','!=','1')->get();
//        print_r($data);die;
        return view('admin.users.all_users',$data);
    }

}
