<?php

namespace App\Http\Controllers;

use App\Models\ReviewModel;
use App\Models\ServiceModel;
use Illuminate\Support\Str;
use Session;
use App\Models\Review;
use Illuminate\Http\Request;


class ReviewController extends Controller
{
    function index(){
        $data['page_heading'] = 'Review';
        $data['reviews'] = ReviewModel::select('review.*','products.title as product_title')
            ->leftJoin('products','review.product_id','products.id')
            ->orderBy('review.id','DESC')
            ->get();
//        print_r($data);die;
        return view('admin.review.index',$data);
    }

    function add (){
        $data['page_heading'] = 'Review';
        $data['review'] = ReviewModel::get();
        return view('admin.review.create',$data);
    }

    function save(Request $request){
//        print_r($request->all());die;
        $project = new ReviewModel();
        $data = $request->all();
        $year = date("Y");
        $month = date("m");
        $filename = "uploads/blogs";
        $filename2 = "uploads/blogs/";
        # MAKE DIRECTORY IF NOT EXISTS STARTS
        if(file_exists($filename)){
            if(file_exists($filename2)==false){
                mkdir($filename2,777, true);
            }
        }else{
            mkdir($filename, 777,true);
            mkdir($filename2,777, true);
        }

        if($request->hasFile('user_image')){
            $destinationPath2 = $filename2.'serve/'; // upload path
            $extension = $data['user_image']->getClientOriginalExtension(); // getting image extension
            $theam_image7 = rand(11111, 99999) . time() . '.' . $extension; // renameing image
            $data['user_image']->move($destinationPath2, $theam_image7); // uploading file to given path
            $wdws_image_3 = $destinationPath2.$theam_image7;
            $project->user_image = $wdws_image_3;
        }

        $project->heading = $request->heading;
        $project->username = $request->username;
        $project->rating = $request->rating;
        $project->review = $request->review;
        $project->added_by = $request->added_by;
        $project->show_on_home = 1;
        $project->status = 0;

        if($project->save()){
            Session::flash('success','Saved');
            return redirect(url('admin/all-reviews'));
        }

    }

    function save_userreviews(Request $request){
//        print_r($request->all());die;
        $project = new ReviewModel();
        $data = $request->all();
        $year = date("Y");
        $month = date("m");
        $filename = "uploads/blogs";
        $filename2 = "uploads/blogs/";
        # MAKE DIRECTORY IF NOT EXISTS STARTS
        if(file_exists($filename)){
            if(file_exists($filename2)==false){
                mkdir($filename2,777, true);
            }
        }else{
            mkdir($filename, 777,true);
            mkdir($filename2,777, true);
        }

        if($request->hasFile('user_image')){
            $destinationPath2 = $filename2.'serve/'; // upload path
            $extension = $data['user_image']->getClientOriginalExtension(); // getting image extension
            $theam_image7 = rand(11111, 99999) . time() . '.' . $extension; // renameing image
            $data['user_image']->move($destinationPath2, $theam_image7); // uploading file to given path
            $wdws_image_3 = $destinationPath2.$theam_image7;
            $project->user_image = $wdws_image_3;
        }

        $project->heading = $request->heading;
        $project->username = $request->username;
        $project->rating = $request->rating;
        $project->review = $request->review;
        $project->product_id = $request->product_id;
        $project->user_id =  $request->user_id;
        $project->added_by =  $request->user_id;
        $project->status = 0;

        if($project->save()){
            Session::flash('success','Saved');
            return redirect(url($_SERVER['HTTP_REFERER']));
        }

    }


    function edit($id){
        $data['page_heading'] = 'Service';
        $data['reviews'] = ReviewModel::find($id);
//        print_r($project);die;
        return view('admin.review.edit',$data);
    }


    function update(Request $request){
        $project = ReviewModel::find($request->id);
        $data = $request->all();
        $year = date("Y");
        $month = date("m");
        $filename = "uploads/blogs";
        $filename2 = "uploads/blogs/";
        # MAKE DIRECTORY IF NOT EXISTS STARTS
        if(file_exists($filename)){
            if(file_exists($filename2)==false){
                mkdir($filename2,777, true);
            }
        }else{
            mkdir($filename, 777,true);
            mkdir($filename2,777, true);
        }

        if($request->hasFile('user_image')){
            $destinationPath2 = $filename2.'serve/'; // upload path
            $extension = $data['user_image']->getClientOriginalExtension(); // getting image extension
            $theam_image7 = rand(11111, 99999) . time() . '.' . $extension; // renameing image
            $data['user_image']->move($destinationPath2, $theam_image7); // uploading file to given path
            $wdws_image_3 = $destinationPath2.$theam_image7;
            $project->user_image = $wdws_image_3;
        }

        $project->heading = $request->heading;
        $project->username = $request->username;
        $project->rating = $request->rating;
        $project->review = $request->review;
        $project->added_by = $request->added_by;
        $project->show_on_home = 1;
        $project->status = 1;

        if($project->save()){
            Session::flash('success','Saved');
            return redirect(url('admin/all-reviews'));
        }

    }


    public function destroy($id)
    {
        $delete = ReviewModel::where('id', $id)->delete();
        if ($delete == 1) {
            $success = true;
            $message = "Deleted";
        } else {
            $success = true;
            $message = "not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function change_status(Request $request){
        $category = ReviewModel::find($request->id);
        if($request->status == '1'){
            $category->status = '1';
        }else{
            $category->status = '0';
        }
        $category->save();
        return response()->json(['success'=>' status change successfully.']);
    }

    public function show_on_homet_status(Request $request){
        $category = ReviewModel::find($request->id);
//        print_r($request->all());die;
        if($request->show_on_home == '1'){
            $category->show_on_home = '0';
        }else{
            $category->show_on_home = '1';
        }
        $category->save();
        return response()->json(['success'=>' status change successfully.']);
    }
}
