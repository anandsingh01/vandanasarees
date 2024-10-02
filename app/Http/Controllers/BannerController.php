<?php

namespace App\Http\Controllers;

use App\Models\BannerModel;
use Illuminate\Http\Request;
use \App\Models\Team;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class BannerController extends Controller
{
    public function index()
    {
        $banner = BannerModel::get();
//        $banner = BannerModel::where('display_area','!=','4')->get();
        $page_heading = 'Banner';
        return view('admin.banner.index',compact('banner','page_heading'));
    }

    public function add()
    {
        $page_heading = 'Banner';
        return view('admin.banner.create', compact('page_heading'));
    }

    public function save(Request $request)
    {
//        print_r($request->all());die;
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

        $banner = new BannerModel() ;
        $banner->banner_heading = $request->banner_heading;
        $banner->banner_subheading = $request->banner_subheading;
        $banner->banner_link = $request->banner_link;
        $banner->banner_text = $request->banner_text;
        $banner->display_area = $request->display_area;
        $banner->banner_description = $request->banner_description;

        $banner->status = '1';

        if ($request->hasFile('banner')) {
            $newimage = $request->file('banner');

            // Define the path where you want to store the uploaded image
            $path = 'images';
            $path2 = 'images/webp';
            $uniqueimagename = rand(1111,9999).time();
            $uniqueimage_original = $uniqueimagename.'.'.$newimage->getClientOriginalExtension();

            $other_format_path  = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2.'/'.$uniqueimagename.'.webp');
            $complete_path = $path2.'/'.$uniqueimagename.'.webp';

            $banner->banner = $complete_path;
        }

        if($banner->save()){
            return redirect('/admin/all-banner');
        }

    }

    public function status(Request $request){
        $category = BannerModel::find($request->brand_id);
        if($request->status == '1'){
            $category->status = '1';
        }else{
            $category->status = '0';
        }
        $category->save();
        return response()->json(['success'=>' status change successfully.']);
    }

    public function destroy($id)
    {
        $delete = BannerModel::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = " deleted successfully";
        } else {
            $success = true;
            $message = " not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    function edit($id){
        $page_heading = 'Banner';
        $banner = BannerModel::find($id);
//        print_r($banner);die;
        return view('admin.banner.edit',compact('banner','page_heading'));
    }

    function update(Request $request){
        $banner = BannerModel::find($request->id);
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
        $banner->banner_heading = $request->banner_heading;
        $banner->banner_subheading = $request->banner_subheading;
        $banner->banner_link = $request->banner_link;
        $banner->banner_text = $request->banner_text;
        $banner->display_area = $request->display_area;
        $banner->banner_description = $request->banner_description;

        $banner->status = '1';
        if ($request->hasFile('banner')) {
            $newimage = $request->file('banner');

            // Define the path where you want to store the uploaded image
            $path = 'images';
            $path2 = 'images/webp';
            $uniqueimagename = rand(1111,9999).time();
            $uniqueimage_original = $uniqueimagename.'.'.$newimage->getClientOriginalExtension();

            $other_format_path  = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2.'/'.$uniqueimagename.'.webp');
            $complete_path = $path2.'/'.$uniqueimagename.'.webp';

            $banner->banner = $complete_path;
        }

        if($banner->save()){
            return redirect('/admin/all-banner');
        }

    }


}
