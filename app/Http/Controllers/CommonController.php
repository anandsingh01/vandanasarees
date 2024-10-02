<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use \App\Models\CommonModel;
use Intervention\Image\Drivers\Gd\Driver;

use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;

class CommonController extends Controller
{

    public function common_settings()
    {
        $data['page_heading'] = 'Common';
        $data['common'] = CommonModel::first();
        return view('admin.common.common',$data);
    }

    public function update_common(Request $request)
    {
        $post = $request->all();
//        print_r($post);die;
        $updateCommon = CommonModel::find($request->id);
        $updateCommon->site_title = $request->site_title;
        $updateCommon->about_footer = $request->about_footer;
        $updateCommon->copyright = $request->copyright;
        $updateCommon->contact_address = $request->contact_address;
        $updateCommon->contact_email = $request->contact_email;
        $updateCommon->contact_phone = $request->contact_phone;
        $updateCommon->facebook_url = $request->facebook_url;
        $updateCommon->twitter_url = $request->twitter_url;
        $updateCommon->instagram_url = $request->instagram_url;
        $updateCommon->linkedin_url = $request->linkedin_url;

        $updateCommon->block_text_1 = $request->block_text_1;
        $updateCommon->block_heading_1 = $request->block_heading_1;
        $updateCommon->block_text_2 = $request->block_text_2;
        $updateCommon->block_heading_2 = $request->block_heading_2;
        $updateCommon->block_text_3 = $request->block_text_3;
        $updateCommon->block_heading_3 = $request->block_heading_3;

        $updateCommon->about_us_content = $request->about_us_content;
        $updateCommon->price_info_content = $request->price_info_content;
        $updateCommon->return_content = $request->return_content;
        $updateCommon->return_status = $request->return_status;
        $updateCommon->privacy_policy_content = $request->privacy_policy_content;
        $updateCommon->shipping_policy_content = $request->shipping_policy_content;
        $updateCommon->refund_content = $request->refund_content;


        if ($request->hasFile('logo_header')) {
            $newimage = $request->file('logo_header');

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

            $updateCommon->logo_header = $complete_path;

        }


        if ($request->hasFile('logo_footer')) {
            $newimage = $request->file('logo_footer');

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

            $updateCommon->logo_footer = $complete_path;

        }

        if ($request->hasFile('favicon')) {
            $newimage = $request->file('favicon');

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

            $updateCommon->favicon = $complete_path;

        }






//        if (!empty($request->favicon)) {
//            $file =$request->file('favicon');
//            $extension = $file->getClientOriginalExtension();
//            $filename = rand(111,999).time().'.' . $extension;
//            $file->move(public_path('uploads/'), $filename);
//
//            $updateCommon->favicon = 'uploads/'.$filename;
//        }

        if($updateCommon->save()){
            return redirect($_SERVER['HTTP_REFERER']);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function generateSitemap ()
    {
        $posts = Blog::all(); // Fetch your dynamic data

        return response()->view('sitemap', compact('posts'))->header('Content-Type', 'text/xml');
    }
}
