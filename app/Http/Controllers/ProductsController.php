<?php

namespace App\Http\Controllers;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Gallery;
use App\Models\ProductAttribut;
use App\Models\Product_size;
use App\Models\ProductReturn;
use Illuminate\Support\Facades\File;


use Session;
use App\Models\Brand;
use App\Models\Section;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['page_heading'] = 'All Products';
        $data['products'] = Product::with('sections','product_category')->get();
        return view('admin.products.index',$data);
    }

    public function create()
    {
        $data['page_heading'] = 'Add Products';
        $data['sections'] = Section::get();
        $data['category'] = Category::where(['category_type' => 'category'])->get();
        return view('admin.products.create',$data);
    }

    public function storee(Request $request)
    {
//        print_r($request->all());die;
//        $category = implode(',',$request->category_ids);

        $sql = new Product;
        $sql->title = $request->title;
        $sql->section_id = $request->section_id;
        $sql->brands_id = $request->brands_id;
        $sql->product_desc = $request->product_desc;
        $sql->product_actual_price = $request->product_actual_price;
        $sql->product_selling_price = $request->product_selling_price;
        $sql->product_max_selling_price = $request->product_max_selling_price;
        $sql->product_min_order = $request->product_min_order;
        $sql->product_max_order = $request->product_max_order;
        $sql->category_id = $request->category_ids;
        $sql->stock = $request->stock;
        $sql->status = $request->status;
        $sql->color_and_care = $request->color_and_care;
        $sql->supplier_info = $request->supplier_info;
        $sql->custom_duties = $request->custom_duties;

//        $sql->product_sku_id = $request->product_sku_id;

        $publicPath = public_path();
        $imagesPath = $publicPath . '/images';
        $webpPath = $publicPath . '/images/webp';

        if (!File::exists($imagesPath)) {
            File::makeDirectory($imagesPath, 0755, true);
        }

        if (!File::exists($webpPath)) {
            File::makeDirectory($webpPath, 0755, true);
        }


        if ($request->hasFile('photo')) {
            $newimage = $request->file('photo');

            // Define the path where you want to store the uploaded image
            $path = 'images';
            $path2 = 'images/webp';
            $uniqueimagename = time().rand(1111,9999);
            $uniqueimage_original = $uniqueimagename.'.'.$newimage->getClientOriginalExtension();

            $other_format_path  = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2.'/'.$uniqueimagename.'.webp');
            $complete_path = $path2.'/'.$uniqueimagename.'.webp';

            $sql->photo = $complete_path;
        }
        if ($request->hasFile('cert_of_auth')) {
            $newimage = $request->file('cert_of_auth');

            // Define the path where you want to store the uploaded image
            $path = 'images';
            $path2 = 'images/webp';
            $uniqueimagename = time().rand(1111,9999);
            $uniqueimage_original = $uniqueimagename.'.'.$newimage->getClientOriginalExtension();

            $other_format_path  = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2.'/'.$uniqueimagename.'.webp');
            $complete_path = $path2.'/'.$uniqueimagename.'.webp';

            $sql->cert_of_auth = $complete_path;
        }


        $sql->img_alt = $request->img_alt;


        $sql->is_featured = $request->is_featured;

        $sql->flash_sale = $request->flash_sale;

        if(isset($request->flash_price)){
            $sql->flash_price = $request->flash_price;
        }else{
            $sql->flash_price = NULL;
        }

        if(isset($request->flash_price)){
            $sql->flash_price_start_date = $request->flash_price_start_date;
        }else{
            $sql->flash_price_start_date = NULL;
        }

        if(isset($request->flash_price)){
            $sql->flash_price_end_date = $request->flash_price_end_date;
        }else{
            $sql->flash_price_end_date = NULL;
        }

        if(isset($request->flash_price)){
            $sql->flash_product_status = $request->flash_product_status;
        }else{
            $sql->flash_product_status = NULL;
        }


        $sql->special_product = $request->special_product;

        if(isset($request->special_price)){
            $sql->special_price = $request->special_price;
        }else{
            $sql->special_price = NULL;
        }

        if(isset($request->special_price_start_date)){
            $sql->special_price_start_date = $request->special_price_start_date;
        }else{
            $sql->special_price_start_date = NULL;
        }

        if(isset($request->special_price_end_date)){
            $sql->special_price_end_date = $request->special_price_end_date;
        }else{
            $sql->special_price_end_date = NULL;
        }

        if(isset($request->special_product_status)){
            $sql->special_product_status = $request->special_product_status;

        }else{
            $sql->special_product_status = NULL;
        }


        if(isset($request->product_short_desc)){
            $sql->product_short_desc = $request->product_short_desc;
        }else{
            $sql->product_short_desc = NULL;
        }

        if(isset($request->product_coupon)){
            $sql->product_coupon = $request->product_coupon;
        }else{
            $sql->product_coupon = NULL;
        }

        if(isset($request->category_discount)){
            $sql->category_discount = $request->category_discount;
        }else{
            $sql->category_discount = NULL;
        }

        if(isset($request->category_discount_type)){
            $sql->category_discount_type = $request->category_discount_type;
        }else{
            $sql->category_discount_type = NULL;
        }

        if(isset($request->meta_title)){
            $sql->meta_title = $request->meta_title;
        }else{
            $sql->meta_title = NULL;
        }

        if(isset($request->meta_desc)){
            $sql->meta_desc = $request->meta_desc;
        }else{
            $sql->meta_desc = NULL;
        }
        if(isset($request->meta_keywords)){
            $sql->meta_keywords = $request->meta_keywords;
        }else{
            $sql->meta_keywords = NULL;
        }

        if(isset($request->slug)){
            $slug = Str::slug(str_replace(' ', '-',$request->slug));
            $slug_count = Product::where('slug',$slug)->count();
            if($slug_count > 0){
                $slug .= time().'-'.$request->slug;
            }
            $sql->slug = $slug;
        }else{
            $slug = Str::slug(str_replace(' ', '-',$request->title));
            $slug_count = Product::where('slug',$slug)->count();
            if($slug_count > 0){
                $slug .= time().'-'.$request->slug;
            }
            $sql->slug = $slug;
        }

        $sql->is_approved = 'yes';


//        die;

        if($sql->save()){
            if ($request->hasFile('productgallery')) {
                $images = $request->file('productgallery');
                $webpImagePaths = [];

                // Define the path where you want to store the uploaded image
                $path = 'images';
                $path2 = 'images/webp';

                foreach ($images as $image) {
                    $uniqueimagename = time().rand(1111,9999);
                    $imageName = $uniqueimagename.'.'.$image->getClientOriginalExtension();
                    $other_format_path2 = $image->move($path, $imageName);

                    // Use the Image facade to create an image instance
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($other_format_path2);

                    $encoded = $image->toWebp()->save($path2.'/'.$uniqueimagename.'.webp');
                    $webpImagePath = $path2.'/'.$uniqueimagename.'.webp';
//                    print_r($webpImagePath);die;
                    $gallery = new \App\Models\Gallery;
                    $gallery->product_id = $sql->id;
                    $gallery->image = $webpImagePath;
                    $gallery->type = 'gallery';
                    $gallery->save();
                }
            }



            $products_id = $sql->id;
//            return redirect('admin/products/add/attribute/display/' . $products_id);
            return redirect('admin/all-products/');
        }
    }


    public function edit($id){
        $data['page_heading'] = 'Edit Products';

        $data['product_details'] = Product::find($id);
        $data['sections'] = Section::get();
        $data['category'] = Category::where(['category_type' => 'category'])->get();
        return view('admin.products.edit',$data);
    }

    function update(Request $request,$id){

        $sql =  Product::find($id);
//        $category = implode(',',$request->category_ids);
        $sql->title = $request->title;

        $sql->tagline = $request->tagline;
        $sql->section_id = $request->section_id;
        $sql->brands_id = $request->brands_id;
        $sql->product_desc = $request->product_desc;
        $sql->product_actual_price = $request->product_actual_price;
        $sql->product_selling_price = $request->product_selling_price;
        $sql->product_max_selling_price = $request->product_max_selling_price;
        $sql->product_min_order = $request->product_min_order;
        $sql->product_max_order = $request->product_max_order;
        $sql->category_id = $request->category_ids;

        $sql->color_and_care = $request->color_and_care;
        $sql->supplier_info = $request->supplier_info;
        $sql->custom_duties = $request->custom_duties;
        // Define the path where you want to store the uploaded image
        $path = 'images';
        $path2 = 'images/webp';
        if ($request->hasFile('photo')) {
            $newimage = $request->file('photo');


            $uniqueimagename = time().rand(1111,9999);
            $uniqueimage_original = $uniqueimagename.'.'.$newimage->getClientOriginalExtension();

            $other_format_path  = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2.'/'.$uniqueimagename.'.webp');
            $complete_path = $path2.'/'.$uniqueimagename.'.webp';

            $sql->photo = $complete_path;
        }
        if ($request->hasFile('cert_of_auth')) {
            $newimage = $request->file('cert_of_auth');

            // Define the path where you want to store the uploaded image
            $path = 'images';
            $path2 = 'images/webp';
            $uniqueimagename = time().rand(1111,9999);
            $uniqueimage_original = $uniqueimagename.'.'.$newimage->getClientOriginalExtension();

            $other_format_path  = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2.'/'.$uniqueimagename.'.webp');
            $complete_path = $path2.'/'.$uniqueimagename.'.webp';

            $sql->cert_of_auth = $complete_path;
        }

        $sql->img_alt = $request->img_alt;


        $sql->is_featured = $request->is_featured;

        $sql->flash_sale = $request->flash_sale;

        if(isset($request->flash_price)){
            $sql->flash_price = $request->flash_price;
        }else{
            $sql->flash_price = NULL;
        }

        if(isset($request->flash_price)){
            $sql->flash_price_start_date = $request->flash_price_start_date;
        }else{
            $sql->flash_price_start_date = NULL;
        }

        if(isset($request->flash_price)){
            $sql->flash_price_end_date = $request->flash_price_end_date;
        }else{
            $sql->flash_price_end_date = NULL;
        }

        if(isset($request->flash_price)){
            $sql->flash_product_status = $request->flash_product_status;
        }else{
            $sql->flash_product_status = NULL;
        }


        $sql->special_product = $request->special_product;

        if(isset($request->special_price)){
            $sql->special_price = $request->special_price;
        }else{
            $sql->special_price = NULL;
        }

        if(isset($request->special_price_start_date)){
            $sql->special_price_start_date = $request->special_price_start_date;
        }else{
            $sql->special_price_start_date = NULL;
        }

        if(isset($request->special_price_end_date)){
            $sql->special_price_end_date = $request->special_price_end_date;
        }else{
            $sql->special_price_end_date = NULL;
        }

        if(isset($request->special_product_status)){
            $sql->special_product_status = $request->special_product_status;

        }else{
            $sql->special_product_status = NULL;
        }


        if(isset($request->product_short_desc)){
            $sql->product_short_desc = $request->product_short_desc;
        }else{
            $sql->product_short_desc = NULL;
        }

        if(isset($request->product_coupon)){
            $sql->product_coupon = $request->product_coupon;
        }else{
            $sql->product_coupon = NULL;
        }

        if(isset($request->category_discount)){
            $sql->category_discount = $request->category_discount;
        }else{
            $sql->category_discount = NULL;
        }

        if(isset($request->category_discount_type)){
            $sql->category_discount_type = $request->category_discount_type;
        }else{
            $sql->category_discount_type = NULL;
        }

        if(isset($request->meta_title)){
            $sql->meta_title = $request->meta_title;
        }else{
            $sql->meta_title = NULL;
        }

        if(isset($request->meta_desc)){
            $sql->meta_desc = $request->meta_desc;
        }else{
            $sql->meta_desc = NULL;
        }
        if(isset($request->meta_keywords)){
            $sql->meta_keywords = $request->meta_keywords;
        }else{
            $sql->meta_keywords = NULL;
        }

        if($sql->save()){
            if ($request->hasFile('productgallery')) {
                $images = $request->file('productgallery');
                $webpImagePaths = [];

                // Define the path where you want to store the uploaded image
                $path = 'images';
                $path2 = 'images/webp';

                foreach ($images as $image) {
                    $uniqueimagename = time().rand(1111,9999);
                    $imageName = $uniqueimagename.'.'.$image->getClientOriginalExtension();
                    $other_format_path2 = $image->move($path, $imageName);

                    // Use the Image facade to create an image instance
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($other_format_path2);

                    $encoded = $image->toWebp()->save($path2.'/'.$uniqueimagename.'.webp');
                    $webpImagePath = $path2.'/'.$uniqueimagename.'.webp';

                    $gallery = new \App\Models\Gallery;
                    $gallery->product_id = $sql->id;
                    $gallery->image = $webpImagePath;
                    $gallery->type = 'gallery';
                    $gallery->save();
                }
            }

            return redirect('admin/all-products');
        }
    }

    function destroy($id){
        $sql = Product::find($id);
        $deleteProductAttr = ProductAttribut::where('product_id',$id)->delete();
        $sql->delete();
        if ($sql == 1) {
            $success = true;
            $message = "Product deleted successfully";
        } else {
            $success = true;
            $message = "Product not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    function remove_image(Request $request){
        $imageId = $request->input('image_id');

        // Delete the image from the database
        $image = Gallery::find($imageId);
        if ($image) {
            $image->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function changeProductStatus(Request $request){
//        print_r($request->all());die;
        $products = Product::find($request->id);
        if($products->status == '1'){
            $products->status = '0';
        }else{
            $products->status = '1';
        }
        $products->save();
        return response()->json(['success'=>'Category status change successfully.']);
    }

    public function highlight_status(Request $request){
//        print_r($request->all());die;
        $products = Product::find($request->id);
        if($products->highlights == '1'){
            $products->highlights = '0';
        }else{
            $products->highlights = '1';
        }
        $products->save();
        return response()->json(['success'=>'Category status change successfully.']);
    }

    public function fav_status(Request $request){
//        print_r($request->all());die;
        $products = Product::find($request->id);
        if($products->fav == '1'){
            $products->fav = '0';
        }else{
            $products->fav = '1';
        }
        $products->save();
        return response()->json(['success'=>'Category status change successfully.']);
    }








    function getcategoriesBySectionOnProduct(Request $request){
        $id = $request->section_id;
        $categories =  Category::where('parent_id',$id)->get();
        return response()->json($categories);
    }

    // Product Attribute & options
    function addProductSizeOptions($id){
        $data['product_details'] =  Product::where('id',$id)->first();
        $data['page_heading'] = 'Add Attribute To : '.$data['product_details']->title;
//        $data['defaultProductAttrList'] = ProductAttribut::select('product_attributes.*',
//            'attributes.title as attr_title',
//            'attributes_values.attribute_value as attr_val'
//        )
//            ->leftJoin('attributes','attributes.id','product_attributes.attribute_id')
//            ->leftJoin('attributes_values','attributes_values.id','product_attributes.attribute_value')
//            ->where('product_attributes.product_id',$id)->where('product_attributes.is_default','yes')->get();

        $data['addtionalProductAttrList'] = ProductAttribut::select('product_attributes.*',
            'attributes.title as attr_title',
            'attributes_values.attribute_value as attr_val'
        )
            ->leftJoin('attributes','attributes.id','product_attributes.attribute_id')
            ->leftJoin('attributes_values','attributes_values.id','product_attributes.attribute_value')
            ->where('product_attributes.product_id',$id)
//            ->where('product_attributes.is_default','no')
            ->get();

        $data['getAttributes'] = Attribute::where('category_id',$data['product_details']->parent_id)->get();
        return view('admin.products.addAttribute',$data);
    }

    function addProductAttrOptions($id){

        $data['product_details'] =  Product::where('id',$id)->first();

        $data['page_heading'] = 'Add Attribute To : '.$data['product_details']->title;
//        $data['defaultProductAttrList'] = ProductAttribut::select('product_attributes.*',
//            'attributes.title as attr_title',
//            'attributes_values.attribute_value as attr_val'
//        )
//            ->leftJoin('attributes','attributes.id','product_attributes.attribute_id')
//            ->leftJoin('attributes_values','attributes_values.id','product_attributes.attribute_value')
//            ->where('product_attributes.product_id',$id)->where('product_attributes.is_default','yes')->get();

        $data['addtionalProductAttrList'] = ProductAttribut::select('product_attributes.*',
            'attributes.title as attr_title',
            'attributes_values.attribute_value as attr_val',
            'attributes_values.image as attr_image',

        )
            ->leftJoin('attributes','attributes.id','product_attributes.attribute_id')
            ->leftJoin('attributes_values','attributes_values.id','product_attributes.attribute_value')
            ->where('product_attributes.product_id',$id)
//            ->where('product_attributes.is_default','no')
            ->get();

//        print_r($data['addtionalProductAttrList']);die;
        $data['productsize'] = Product_size::where('product_id',$id)->get();
        $data['getAttributes'] = Attribute::where('category_id',$data['product_details']->parent_id)->get();

        return view('admin.products.addAttribute',$data);
    }
    function editProductSizeAttrValue($id){
        $data['attr_id'] = $id;
        $data['attr_details'] = Product_size::find($id);
        $data['product_details'] =  Product::where('id',$data['attr_details']->product_id)->first();
        $data['page_heading'] = 'Add Attribute To : '.$data['product_details']->title;
        return view('admin.products.editDefaultProductAttr',$data);
    }

    function productSizeAttribute(Request $request, $id){
        print_r($request->all());die;
        $sql = new Product_size;
        $sql->product_id = $request->id;
        $sql->sku = strtoupper($request->sku);
        $sql->size = $request->size;
        $sql->price = $request->price;
        $sql->msp = $request->msp;
        $sql->qty = $request->qty;
        $sql->flash_sale = $request->flash_sale;
        $sql->flash_price = $request->flash_price;
        $sql->desc = $request->short_desc;

        $sql->length = $request->length;
        $sql->width = $request->width;
        $sql->height = $request->height;


        $discountPrcnt = '';
        if(!empty($request->msp)){
            $discountPrcnt = (ceil(($request->msp - $request->price)/$request->msp*100));
        }
        // Check if the image file was uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Define the path where you want to store the uploaded image
            $path = 'images';

            // Generate a unique name for the image to avoid overwriting
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Move the uploaded image to the specified path
            $image->move($path, $imageName);

            // Convert the image to WebP format and save it with a new name
            $webpImagePath = 'images/webp/' .time().rand(1111,9999). '.webp';
            Image::make($path . '/' . $imageName)->encode('webp')->save($webpImagePath, 80);

            // Save the image name or path to your database as needed
            // For example, you can store the image name in a 'image' column of the offers table
            $sql->image = $webpImagePath;

            // Optionally, you can also save the original image path if needed
            // $offer->image = 'images/' . $imageName;
        }
        $sql->discount_pecent = $discountPrcnt;
        if($sql->save()){
            return redirect('admin/products/add/attribute/display/' . $id);
        }
    }

    function saveProductAdditionalAttributes(Request $request, $id){
//        print_r($id);die;
        $sql = new ProductAttribut;
        $sql->product_id = $request->id;
        $sql->attribute_id = $request->attribute_id;
        $sql->attribute_value = $request->attribute_value;
        if ($request->hasFile('attribute_image')) {
            $image = $request->file('attribute_image');
            $path = 'images';

            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move($path, $imageName);

            $webpImagePath = 'images/webp/' .time().rand(1111,9999). '.webp';
            Image::make($path . '/' . $imageName)->encode('webp')->save($webpImagePath, 80);

            $sql->image = $webpImagePath;
        }
        $sql->is_default = 'no';
        if($sql->save()){
            return redirect($_SERVER['HTTP_REFERER']);
        }
    }


    function editAdditionalProductAttrValue($id){
        $data['attr_id'] = $id;
        $data['attr_details'] = ProductAttribut::find($id);
        $data['product_details'] =  Product::where('id',$data['attr_details']->product_id)->first();
        $data['getAllAttributes'] = Attribute::where('category_id',$data['product_details']->parent_id)->get();
        $data['getAllAttributesValues'] = AttributeValue::where('attribute_option',$data['attr_details']->attribute_id)->get();
        $data['page_heading'] = 'Add Attribute To : '.$data['product_details']->title;

//        print_r($data['attr_details']);die;
        return view('admin.products.editAdditionalProductAttr',$data);
    }


    function updateproductAttribute(Request $request){
        $sql = ProductAttribut::find($request->id);
//        $sql->product_id = $request->id;
        $sql->attribute_id = $request->attribute_id;
        $sql->attribute_value = $request->attribute_value;
        if ($request->hasFile('attribute_image')) {
            $image = $request->file('attribute_image');
            $path = 'images';

            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move($path, $imageName);

            $webpImagePath = 'images/webp/' .time().rand(1111,9999). '.webp';
            Image::make($path . '/' . $imageName)->encode('webp')->save($webpImagePath, 80);

            $sql->image = $webpImagePath;
        }
        $sql->is_default = 'no';
        if($sql->save()){
            return redirect('admin/product/attribute/additional-edit-value/' . $request->id);
        }
    }

    function updateproductSizeAttribute(Request $request, $id){
        $sql = Product_size::find($id);
        $sql->sku = strtoupper($request->sku);
        $sql->qty = $request->qty;
        $sql->size = $request->size;
        $sql->price = $request->price;
        $sql->msp = $request->msp;
        $sql->desc = $request->short_desc;


        $sql->length = $request->length;
        $sql->width = $request->width;
        $sql->height = $request->height;

        $sql->flash_sale = $request->flash_sale;
        $sql->flash_price = $request->flash_price;

        // Check if the image file was uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Define the path where you want to store the uploaded image
            $path = 'images';

            // Generate a unique name for the image to avoid overwriting
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Move the uploaded image to the specified path
            $image->move($path, $imageName);

            // Convert the image to WebP format and save it with a new name
            $webpImagePath = 'images/webp/' .time().rand(1111,9999). '.webp';
            Image::make($path . '/' . $imageName)->encode('webp')->save($webpImagePath, 80);

            // Save the image name or path to your database as needed
            // For example, you can store the image name in a 'image' column of the offers table
            $sql->image = $webpImagePath;

            // Optionally, you can also save the original image path if needed
            // $offer->image = 'images/' . $imageName;
        }
        $discountPrcnt = '';
        if(!empty($request->msp)){
            $discountPrcnt = (ceil(($request->msp - $request->price)/$request->msp*100));
        }
        $sql->discount_pecent = $discountPrcnt;

        $getCart = Cart::where(['product_id'=>$request->product_id,'size' => $sql->id,'status'=>'yes'])->get();
        if(!empty($getCart)){
            foreach($getCart as $getCarts){
                $updateSubTotal = $getCarts->cartqty * $request->price;
                $updateCart = Cart::where(['product_id'=>$request->product_id,'size' => $sql->id,'status'=>'yes'])
                    ->update([
                        'price' => $request->price,
                        'subtotal' => $updateSubTotal
                    ]);
            }

        }
        if($sql->save()){
            return redirect('admin/products/add/attribute/display/' . $request->product_id);
        }
    }

    function delete_product_size($id){
//        print_r($id);
//        die;
        $delete = Product_size::find($id);
        $delete = Product_size::where('id', $id)->delete();
        if ($delete == 1) {
            $success = true;
            $message = "Size deleted successfully";
        } else {
            $success = true;
            $message = "Size not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    function deleteProductAddtionalAttr($id){
        $delete = ProductAttribut::where('id', $id)->delete();
        if ($delete == 1) {
            $success = true;
            $message = "Attribute deleted successfully";
        } else {
            $success = true;
            $message = "Attribute not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    function getAttrValueFromOptions(Request $request){
        $id = $request->attribute_id;
        $sql =  AttributeValue::where('attribute_option',$id)->get();
        $options = [];
        if(!empty($sql)){
            foreach($sql as $key => $attVal){
                $options[] .= '<option value="'.$attVal->id.'">'.$attVal->attribute_value.'</option>';
            }
        }
        return $options;
    }


    function getSubcategoriesByCategoriesOnProduct(Request $request){
        $id = $request->parent_id;
        $sql =  Category::where('parent_id',$id)->get();
        return json_decode(json_encode($sql),true);
    }



}
