<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Session;
Route::get('/optimize-clear', function () {
    try {
        Artisan::call('optimize:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return 'Optimization cache cleared successfully.';
    } catch (\Exception $e) {
        return 'Error clearing optimization cache: ' . $e->getMessage();
    }
});
// Route to destroy the session
Route::get('/destroy-session', function () {
    // Destroy the session
    if (Session::has('discounted_total')) {
        // Remove the cart session
        Session::forget('discounted_total');
        return "Cart session destroyed successfully!";
    } else {
        return "Cart session does not exist!";
    }
    die;
    Session::flush(); // This will remove all session data

});
// Route to destroy the session
Route::get('otp', function () {

    $senderid = 'Groovv';
    $sendto = '7355420160';
    $message = "Hurray! You're truly special to us. Make your own statement with India's leading audio brand -Grooves . For special discounts, visit www.grooveslifestyle.com";
    $templateid = '1707170453825822776';

    $username = 'grooves';
    $password = '887200';
    $senderId = $senderid;
    $sendTo = $sendto; // Replace with the actual phone number
    $message = $message;
    $PEID = '';
    $templateId = $templateid;

// Build the API URL
    $apiUrl = "http://45.249.108.134/api.php";

// Set up the curl request
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'username' => $username,
        'password' => $password,
        'sender' => $senderId,
        'sendto' => $sendTo,
        'message' => $message,
        'PEID' => $PEID,
        'templateid' => $templateId,
    ]);

// Execute the request
    $response = curl_exec($ch);

// Close the curl session
    curl_close($ch);

// Process the response as needed
    echo $response;

});

Route::get('/remove-coupon', function () {
    // Destroy the session
    Session::forget('discounted_total');
    return redirect($_SERVER['HTTP_REFERER']);

});
Route::get('/otp_for_cod',[HomeController::class,'otp_for_cod']);

Route::post('/verify-codotp',[HomeController::class,'verify_codotp']);

// web.php
Route::get('/instagram/authorize', [InstagramController::class, 'authorizeUser']);
Route::get('/instagram/callback', [InstagramController::class, 'handleCallback']);
Route::get('/instagram/posts', [InstagramController::class, 'fetchPosts']);


Route::get('/verify-otp',[LoginController::class,'verify_otp']);
Route::get('/sitemap.xml',[CommonController::class,'generateSitemap']);
Route::post('/subscribe-newsletter',[HomeController::class,'subscribe_newseletter']);



 Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
 Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
 Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
 Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Route::get('password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm']);


Route::get('login', [LoginController::class, 'login_page']);
Route::post('check-login', [LoginController::class, 'check_login']);

Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('login/facebook', [LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/facebook/callback', [LoginController::class, 'handleFacebookCallback']);


Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::get('/sent-login-otp',[LoginController::class,'send_otp']);
//Route::get('email/verify', function () {
//    return view('auth.verify');
//})->name('verification.notice');
//
//Route::get('/home', function () {
//    return redirect(url('/'));
//});


Route::get('account/verify/{token}', [\App\Http\Controllers\Auth\VerificationController::class, 'verifyAccount']);


//Route::post('/email/verify/resend',  [\App\Http\Controllers\Auth\VerificationController::class, 'resend']);
Route::get('resent-email-verification',  [\App\Http\Controllers\Auth\VerificationController::class, 'resend']);


Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('HtmlMinifier');
Route::get('shop', [App\Http\Controllers\HomeController::class, 'shop']);
Route::get('shop/{slug}', [App\Http\Controllers\HomeController::class, 'product_by_category']);
Route::get('brands', [App\Http\Controllers\HomeController::class, 'brands']);
Route::get('brands/{slug}', [App\Http\Controllers\HomeController::class, 'product_by_brands']);



Route::post('send-enquiry', [App\Http\Controllers\HomeController::class, 'send_enquiry']);

Route::get('contact-us', [App\Http\Controllers\HomeController::class, 'contactus']);
Route::post('save-contact-us', [App\Http\Controllers\HomeController::class, 'savecontactus']);

Route::get('testing-otp', [App\Http\Controllers\HomeController::class, 'testingotp']);
//Route::get('testing-otp', [App\Http\Controllers\HomeController::class, 'testingotp']);


Route::get('privacy-policy', function (){
    return view('web.privacy-policy');
});

Route::get('shipping-policy', function (){
    return view('web.shipping-policy');
});


Route::get('products/{url}', [HomeController::class, 'products_details']);
Route::post('register-product', [HomeController::class, 'register_product']);
Route::post('claim-warranty', [HomeController::class, 'claim_warranty']);
Route::get('/search', [HomeController::class, 'searchTitle']);
Route::get('/filter', [HomeController::class, 'filter']);
Route::get('/filter-by-price', [HomeController::class, 'filter_by_price']);
Route::get('offers/{url}', [HomeController::class, 'sustainability_overview']);
Route::get('social-impact/{url}', [HomeController::class, 'social_impact']);
//Route::get('offers/stewardship', [HomeController::class, 'sustainability_stewardship']);
Route::get('service/{url}', [HomeController::class, 'get_service']);

Route::get('/addToWishlist', [App\Http\Controllers\CartController::class,'addToWishlist'])->name('addToWishlist');
Route::post('/addToCart', [App\Http\Controllers\CartController::class,'addToCart'])->name('addToCart');
Route::post('/updateSizeCart', [App\Http\Controllers\CartController::class,'updateSizeCart'])->name('updateSizeCart');
Route::post('/updateQtyCart', [App\Http\Controllers\CartController::class,'updateQtyCart'])->name('updateQtyCart');
Route::get('/checkout/cart', [App\Http\Controllers\CartController::class,'getAllCartsProducts'])->name('checkout.cart');
Route::get('/getProductDetails/{id}', [App\Http\Controllers\HomeController::class,'getProductDetails'])->name('products.details');

Route::get('/checkout', [App\Http\Controllers\CartController::class,'checkout']);
Route::get('/guest-checkout', [App\Http\Controllers\CartController::class,'guest_checkout1']);
Route::get('/iz', [App\Http\Controllers\CartController::class,'guest_checkoutq'])->name('category.products');

Route::post('save-address', [CheckoutController::class, 'userdashboardsave_address']);
Route::post('/checkout/save-address', [CheckoutController::class, 'save_address'])->name('checkout.saveAddress');
Route::post('/checkout/update-address', [CheckoutController::class, 'update_address'])->name('checkout.updateAddress');
Route::post('/checkout/submit', [CheckoutController::class, 'checkout_submit'])->name('checkout.submit');
Route::get('/remove-address/{id}', [CheckoutController::class, 'remove_address'])->name('remove.address');
Route::get('redirect-to-pay/{id}', [CheckoutController::class, 'redirecTopay']);
Route::post('/payment-successsss', [CheckoutController::class, 'paymentSuccess']);

//Route::get('/checkout/payment', [CheckoutController::class, 'stripe_integrate'])
//    ->name('checkout.payment');
//Route::post('/stripe/submit', [CheckoutController::class, 'stripe_submit'])->name('stripe.post');
//Route::get('/payment/success', [CheckoutController::class, 'payment_success']);

Route::post('/payment/callback', [CheckoutController::class, 'phonepe_callback']);
//Route::get('/payment/success', [CheckoutController::class, 'payment_success']);


Route::post('updateCart', [App\Http\Controllers\CartController::class,'updateCart']);
//Route::post('checkCoupon', [App\Http\Controllers\CartController::class,'checkCoupon']);
Route::post('/apply-coupon', [App\Http\Controllers\CartController::class,'checkCoupon'])->name('cart.apply_coupon');

Route::get('/delete-from-cart/{id}', [App\Http\Controllers\CartController::class,'deleteFromCart']);
Route::get('/delAllCartsProducts', [App\Http\Controllers\CartController::class,'delAllCartsProducts']);

Route::get('user/dashboard', [App\Http\Controllers\UserController::class,'dashboard']);
Route::get('my-profile', [App\Http\Controllers\UserController::class,'dashboard']);
Route::get('my-orders', [App\Http\Controllers\UserController::class,'my_orders']);
Route::post('/update-profile', [App\Http\Controllers\UserController::class,'update'])->name('update-profile');
Route::get('/view-orders/{id}', [App\Http\Controllers\UserController::class,'view_order']);
Route::get('/view-orders-details/{id}', [App\Http\Controllers\UserController::class,'view_order_guest']);
Route::get('blogs', [App\Http\Controllers\HomeController::class,'blogs']);
Route::get('blog-details/{url}', [App\Http\Controllers\HomeController::class,'blogs_details']);
Route::get('/get-shipping-options', [CheckoutController::class,'get_shipping_details']);


Route::get('ship',[HomeController::class,'ship']);
Route::get('faq',[HomeController::class,'faq']);

Route::post('/calculate-tax', [CheckoutController::class,'calculateTax']);
Route::post('/save-review', [HomeController::class,'save_review']);

Route::post('return-product', [App\Http\Controllers\OrderController::class, 'returnProduct']);

Route::get('/enquiry-form', function (){
    return view('web.enquiry');
});
Route::get('/contact-us', function (){
    return view('web.contact');
});
Route::post('/send-contact', [HomeController::class,'send_enquiry']);

Route::get('/privacy-policy', function (){
    return view('web.privacy-policy');
});
Route::get('/refund-policy', function (){
    return view('web.refund-policy');
});

Route::get('/return-policy', function (){
    return view('web.return-policy');
});

Route::get('/pricing-information', function (){
    return view('web.pricing-ordering-information');
});
Route::get('/terms-and-conditions', function (){
    return view('web.terms');
});

Route::get('/return-and-replacement', function (){
    return view('web.returnreplacementpolicy');
});

Route::get('/about-us', function (){
    return view('web.aboutus');
});

Route::get('/register-product', function (){
    $category = \App\Models\Category::all();
    return view('web.support.register_support',compact('category'));
});

Route::get('/track-order', function (){
    $category = \App\Models\Category::all();
    return view('web.support.track-order',compact('category'));
});

Route::get('/company-policy', function (){
    $category = \App\Models\Category::all();
    return view('web.support.company-policy',compact('category'));
});

Route::get('/claim-warranty', function (){
    $category = \App\Models\Category::where('category_type','section')->get();
    return view('web.support.claim-warranty',compact('category'));
});

Route::post('/order-status', function (){
    return view('web.order-status');
});


Route::post('/save-reviews', [App\Http\Controllers\ReviewController::class, 'save']);
Route::post('/save-reviews', [App\Http\Controllers\ReviewController::class, 'save_userreviews']);


Route::get('/home',function (){
    if(Auth::check()){
        if(Auth::user()->role == '1'){
            return redirect('admin/dashboard');
        }else{
            return redirect(url('/'));
        }
    }else{
        return redirect(url('/'));
    }
//    return abort(403,'You\'re on wrong page');
});




Route::group(['prefix'=>'admin'], function(){
    Route::get('/home',function (){
        if(Auth::check()){
            if(Auth::user()->role == '1'){
                return redirect('admin/dashboard');
            }
        }else{
            return redirect(url('/'));
        }
//        return abort(403,'You\'re on wrong page');
    });

    Auth::routes();
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::get('/', [App\Http\Controllers\AdminController::class, 'index']);
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/my-profile', [App\Http\Controllers\AdminController::class, 'my_profile'])->name('admin.myprofile');
    Route::post('/update-profile', [App\Http\Controllers\AdminController::class, 'update_profile'])->name('admin.update_profile');


    Route::get('/all-banner', [App\Http\Controllers\BannerController::class, 'index']);
    Route::get('/add-banner', [App\Http\Controllers\BannerController::class, 'add']);
    Route::post('/save-banner', [App\Http\Controllers\BannerController::class, 'save']);
    Route::get('/update-banner-Status', [App\Http\Controllers\BannerController::class, 'status']);
    Route::get('/delete-banner/{id}', [App\Http\Controllers\BannerController::class, 'destroy']);
    Route::get('/edit-banner/{id}', [App\Http\Controllers\BannerController::class, 'edit']);
    Route::post('/update-banner/', [App\Http\Controllers\BannerController::class, 'update']);



    Route::get('categories',[CategoryController::class,'index']);
    Route::post('create-category',[CategoryController::class,'create'])->name('create.category');
    Route::get('change-status',[CategoryController::class,'change_status'])->name('change.status.category');
    Route::get('delete/category/{id}',[CategoryController::class,'destroy'])->name('delete.category');
    Route::get('edit-category/{id}',[CategoryController::class,'edit'])->name('edit.category');
    Route::post('update-category',[CategoryController::class,'update'])->name('update.category');
//    Route::post('uploadCategoryContent',[CategoryController::class,'uploadCategoryContent'])->name('uploadContent');
    Route::get('change_home_status',[CategoryController::class,'show_on_homet_status']);
    Route::post('upload_category_Content',[CategoryController::class,'uploadCategoryContent'])->name('categoryuploadContent');


    Route::get('section',[SectionController::class,'index']);
    Route::post('create-section',[SectionController::class,'create'])->name('create.section');
    Route::get('change-section-status',[SectionController::class,'change_status'])->name('change.status.section');
    Route::get('delete/section/{id}',[SectionController::class,'destroy'])->name('delete.section');
    Route::get('edit-section/{id}',[SectionController::class,'edit'])->name('edit.section');
    Route::post('update-section',[SectionController::class,'update'])->name('update.section');
    Route::post('uploadsectionContent',[SectionController::class,'uploadCategoryContent'])->name('uploadContent');
    Route::get('change_sectionhome_status',[SectionController::class,'show_on_homet_status']);


    Route::get('post-format',[BlogController::class,'index']);
    Route::get('add-posts',[BlogController::class,'create']);
    Route::post('create-post',[BlogController::class,'store']);
    Route::post('update-post',[BlogController::class,'update']);
    Route::get('all-post',[BlogController::class,'all_posts']);
    Route::get('edit-blog/{id}',[BlogController::class,'edit']);

    Route::get('ad-spaces',[AdController::class,'index']);
    Route::post('update-ads',[AdController::class,'update']);

    Route::get('delete/blog/{id}',[BlogController::class,'destroy']);

    Route::get('common-settings',[CommonController::class,'common_settings']);
    Route::post('update-common',[CommonController::class,'update_common']);

    // common-settings

    Route::get('/our-team', [App\Http\Controllers\TeamController::class, 'index']);
    Route::get('/add-teams', [App\Http\Controllers\TeamController::class, 'add']);
    Route::post('/save-team', [App\Http\Controllers\TeamController::class, 'save']);
    Route::get('/update-teams-Status', [App\Http\Controllers\TeamController::class, 'status']);
    Route::get('/delete-teams/{id}', [App\Http\Controllers\TeamController::class, 'destroy']);
    Route::get('/edit-teams/{id}', [App\Http\Controllers\TeamController::class, 'edit']);
    Route::post('/update-team/', [App\Http\Controllers\TeamController::class, 'update']);


    Route::get('/our-role', [App\Http\Controllers\RoleController::class, 'index']);
    Route::get('/add-role', [App\Http\Controllers\RoleController::class, 'add']);
    Route::post('/save-role', [App\Http\Controllers\RoleController::class, 'save']);
    Route::get('/update-role-Status', [App\Http\Controllers\RoleController::class, 'status']);
    Route::get('/delete-role/{id}', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('/edit-role/{id}', [App\Http\Controllers\RoleController::class, 'edit']);
    Route::post('/update-role/', [App\Http\Controllers\RoleController::class, 'update']);



    Route::get('/all-services', [App\Http\Controllers\ServiceController::class, 'index']);
    Route::get('/add-services', [App\Http\Controllers\ServiceController::class, 'add']);
    Route::post('/save-services', [App\Http\Controllers\ServiceController::class, 'save']);
    Route::get('/update-services-Status', [App\Http\Controllers\ServiceController::class, 'status']);
    Route::get('/delete-services/{id}', [App\Http\Controllers\ServiceController::class, 'destroy']);
    Route::get('/edit-service/{id}', [App\Http\Controllers\ServiceController::class, 'edit']);
    Route::post('/update-services', [App\Http\Controllers\ServiceController::class, 'update']);
    Route::get('change-status-service',[App\Http\Controllers\ServiceController::class,'change_status']);
    Route::get('change-status-services-show_on_homet',[App\Http\Controllers\ServiceController::class,'show_on_homet_status']);

    Route::get('/founders-note', [App\Http\Controllers\TeamController::class, 'founders_note']);
    Route::post('/update-founder-note', [App\Http\Controllers\TeamController::class, 'updatefoundernote']);



    Route::get('/all-collaborations', [App\Http\Controllers\CollaborationController::class, 'index']);
    Route::get('/add-collaborations', [App\Http\Controllers\CollaborationController::class, 'add']);
    Route::post('/save-collaborations', [App\Http\Controllers\CollaborationController::class, 'save']);
    Route::get('/update-collaborations-Status', [App\Http\Controllers\CollaborationController::class, 'status']);
    Route::get('/delete-collaborations/{id}', [App\Http\Controllers\CollaborationController::class, 'destroy']);
    Route::get('/edit-collaborations/{id}', [App\Http\Controllers\CollaborationController::class, 'edit']);
    Route::post('/update-collaborations/', [App\Http\Controllers\CollaborationController::class, 'update']);
    Route::get('change-collaborations-status',[App\Http\Controllers\CollaborationController::class,'change_status']);
    Route::get('change-collaborations-show_on_homet',[App\Http\Controllers\CollaborationController::class,'show_on_homet_status']);

    Route::get('/all-annual-reports', [App\Http\Controllers\AnnualReportController::class, 'index']);
    Route::get('/add-annual-reports', [App\Http\Controllers\AnnualReportController::class, 'add']);
    Route::post('/save-annual-reports', [App\Http\Controllers\AnnualReportController::class, 'save']);
    Route::get('/update-annual-reports-Status', [App\Http\Controllers\AnnualReportController::class, 'status']);
    Route::get('/delete-annual-reports/{id}', [App\Http\Controllers\AnnualReportController::class, 'destroy']);
    Route::get('/edit-annual-reports/{id}', [App\Http\Controllers\AnnualReportController::class, 'edit']);
    Route::post('/update-annual-reports/', [App\Http\Controllers\AnnualReportController::class, 'update']);
    Route::get('change-annual-reports-status',[App\Http\Controllers\AnnualReportController::class,'change_status']);
    Route::get('change-annual-reports-show_on_homet',[App\Http\Controllers\AnnualReportController::class,'show_on_homet_status']);


    Route::get('/who-we-are', [App\Http\Controllers\AboutController::class, 'who_we_are']);
    Route::post('update-aboutus',[App\Http\Controllers\AboutController::class,'updatewhoweare']);

    Route::get('/our-mission', [App\Http\Controllers\AboutController::class, 'our_mission']);
    Route::post('/update-our-mission', [App\Http\Controllers\AboutController::class, 'updateour_mission']);

    Route::get('/core-compentancy', [App\Http\Controllers\AboutController::class, 'core_compentancy']);
    Route::post('/update-core-compentancy', [App\Http\Controllers\AboutController::class, 'update_core_compentancy']);

    Route::get('/offers-{url}', [App\Http\Controllers\Sustainability::class, 'overview']);
    Route::post('/update-offers-{url}', [App\Http\Controllers\Sustainability::class, 'update_overview']);

    Route::get('/social-impacts', [App\Http\Controllers\SocialImpact::class, 'overview']);
    Route::post('/update-social-impacts', [App\Http\Controllers\SocialImpact::class, 'update_overview']);

//    Route::get('/offers-approach', [App\Http\Controllers\Sustainability::class, 'approach']);
//    Route::post('/update-offers-approach', [App\Http\Controllers\Sustainability::class, 'update_approach']);
//
//    Route::get('/offers-stewardship', [App\Http\Controllers\Sustainability::class, 'stewardship']);
//    Route::post('/update-offers-stewardship', [App\Http\Controllers\Sustainability::class, 'update_stewardship']);


    Route::get('offers', [OfferController::class, 'index'])->name('offers.index');
    Route::post('offers/create', [OfferController::class, 'store'])->name('offers.create');
    Route::get('edit-offer/{id}', [OfferController::class, 'edit'])->name('offers.edit');
    Route::post('update-offer', [OfferController::class, 'update'])->name('offers.update');
    Route::delete('offers/{id}', [OfferController::class, 'destroy'])->name('offers.destroy');
    Route::get('change-offer-status',[App\Http\Controllers\OfferController::class,'change_status']);
    Route::get('change-offer-on-homepage-status',[App\Http\Controllers\OfferController::class,'homepage_status']);
    Route::get('/delete/offer/{id}', [App\Http\Controllers\OfferController::class, 'destroy']);


//    Products Attributes
    Route::get('products/all-attributes', [App\Http\Controllers\AttributesController::class,'index']);
    Route::get('products/add-attributes', [App\Http\Controllers\AttributesController::class,'create']);
    Route::post('products/save-attributes', [App\Http\Controllers\AttributesController::class,'store']);
    Route::get('products/edit-attributes/{id}', [App\Http\Controllers\AttributesController::class,'edit']);
    Route::post('products/update-attributes/{id}', [App\Http\Controllers\AttributesController::class,'update']);
    Route::get('products/update-attributes-Status', [App\Http\Controllers\AttributesController::class,'changeAttributesstatus']);
    Route::get('product/delete-product-size/{id}', [App\Http\Controllers\ProductsController::class,'delete_product_size']);
    Route::get('products/delete-attributes-values/{id}', [App\Http\Controllers\AttributesController::class,'destroyAttrValue']);

    Route::get('products/attributes/options/{id}', [App\Http\Controllers\AttributesController::class,'viewOptionsValues']);
    Route::get('products/add-attributes-values', [App\Http\Controllers\AttributesController::class,'addOptionsValues']);
    Route::post('products/attributes/save-attributes-values/{id}', [App\Http\Controllers\AttributesController::class,'saveAttributesValues']);
    Route::get('products/attributes/edit-attribute-value/{id}', [App\Http\Controllers\AttributesController::class,'editAttributesValues']);
    Route::post('products/attributes/update-attributes-values/{id}', [App\Http\Controllers\AttributesController::class,'updateAttributesValues']);

// Products Units
    Route::get('products/all-units', [App\Http\Controllers\UnitsController::class,'index']);
    Route::get('products/add-units', [App\Http\Controllers\UnitsController::class,'create']);
    Route::post('products/save-units', [App\Http\Controllers\UnitsController::class,'store']);
    Route::get('products/edit-units/{id}', [App\Http\Controllers\UnitsController::class,'edit']);
    Route::post('products/update-units/{id}', [App\Http\Controllers\UnitsController::class,'update']);
    Route::get('products/update-units-Status', [App\Http\Controllers\UnitsController::class,'changeuUnitstatus']);
    Route::get('products/delete-units/{id}', [App\Http\Controllers\UnitsController::class,'destroy']);

    // Products # ADD, UPDATE ,DELETE...
    Route::get('/all-products', [App\Http\Controllers\ProductsController::class,'index']);
    Route::get('/add-products', [App\Http\Controllers\ProductsController::class,'create']);
    Route::post('/save-products', [App\Http\Controllers\ProductsController::class,'storee']);
    Route::get('/edit-products/{id}', [App\Http\Controllers\ProductsController::class,'edit']);
    Route::post('/update-products/{id}', [App\Http\Controllers\ProductsController::class,'update']);
    Route::get('/update-products-Status', [App\Http\Controllers\ProductsController::class,'changeProductstatus']);
    Route::get('/delete-products/{id}', [App\Http\Controllers\ProductsController::class,'destroy']);
    Route::get('/update-products-Status', [App\Http\Controllers\ProductsController::class,'changeProductStatus']);
    Route::get('/get-categories-by-section', [App\Http\Controllers\ProductsController::class,'getcategoriesBySectionOnProduct']);
    Route::get('/getSubcategoriesByCategoriesOnProduct', [App\Http\Controllers\ProductsController::class,'getSubcategoriesByCategoriesOnProduct']);
    Route::get('highlight-status',[App\Http\Controllers\ProductsController::class,'highlight_status']);
    Route::get('fav-status',[App\Http\Controllers\ProductsController::class,'fav_status']);



    Route::get('/products/add/attribute/display/{id}', [App\Http\Controllers\ProductsController::class,'addProductAttrOptions']);
    Route::get('/products/all/attribute/display/{id}', [App\Http\Controllers\ProductsController::class,'getAllProductAttrOptions']);
    Route::post('/products/update/productAdditionAttribute', [App\Http\Controllers\ProductsController::class,'updateproductAttribute']);
    Route::get('/products/deleteProductAddtionalAttr/{id}', [App\Http\Controllers\ProductsController::class,'deleteProductAddtionalAttr']);
    Route::get('/deleteProductAddtionalAttr/{id}', [App\Http\Controllers\ProductsController::class,'destroy']);


    Route::post('/products/save/productSizeAttribute/{id}', [App\Http\Controllers\ProductsController::class,'productSizeAttribute']);
    Route::post('/products/save/productAttribute/{id}', [App\Http\Controllers\ProductsController::class,'saveProductAdditionalAttributes']);
    Route::get('/products/getAttrValueFromOptions', [App\Http\Controllers\ProductsController::class,'getAttrValueFromOptions']);
    Route::get('/product/attribute/default-edit-value/{id}', [App\Http\Controllers\ProductsController::class,'editProductSizeAttrValue']);
    Route::post('/products/update/productSizeAttribute/{id}', [App\Http\Controllers\ProductsController::class,'updateproductSizeAttribute']);

    Route::post('/products/update/productSizeAttribute/{id}', [App\Http\Controllers\ProductsController::class,'updateproductSizeAttribute']);

    Route::get('product/attribute/additional-edit-value/{id}', [App\Http\Controllers\ProductsController::class,'editAdditionalProductAttrValue']);
//    Route::post('/products/update/productAttribute/', [App\Http\Controllers\ProductsController::class,'updateproductAttribute']);


    Route::get('product/attribute/additional-edit-value/{id}', [App\Http\Controllers\ProductsController::class,'editAdditionalProductAttrValue']);
    Route::get('remove_image', [App\Http\Controllers\ProductsController::class,'remove_image']);


    // Products # ADD, UPDATE ,DELETE...
    Route::get('/all-orders', [App\Http\Controllers\OrderController::class,'index']);
    Route::get('/view-orders/{id}', [App\Http\Controllers\OrderController::class,'view_order']);
    Route::get('/print-order/{id}', [App\Http\Controllers\OrderController::class,'print_order']);
    Route::get('/add-products', [App\Http\Controllers\ProductsController::class,'create']);
    Route::post('/save-products', [App\Http\Controllers\ProductsController::class,'storee']);
    Route::get('/edit-products/{id}', [App\Http\Controllers\ProductsController::class,'edit']);
    Route::post('/update-products/{id}', [App\Http\Controllers\ProductsController::class,'update']);
    Route::get('/update-products-Status', [App\Http\Controllers\ProductsController::class,'changeProductstatus']);
    Route::get('/delete-products/{id}', [App\Http\Controllers\ProductsController::class,'destroy']);
    Route::get('/update-products-Status', [App\Http\Controllers\ProductsController::class,'changeProductStatus']);
    Route::get('/getcategoriesBySectionOnProduct', [App\Http\Controllers\ProductsController::class,'getcategoriesBySectionOnProduct']);
    Route::get('/getSubcategoriesByCategoriesOnProduct', [App\Http\Controllers\ProductsController::class,'getSubcategoriesByCategoriesOnProduct']);


    Route::get('/fetch-order-data', [App\Http\Controllers\AdminController::class,'salesReport'])->name('fetch-order-data');
    Route::get('/sales-report', [App\Http\Controllers\AdminController::class,'salesReport'])->name('sales.report');

    // Products # ADD, UPDATE ,DELETE...
    Route::get('/all-users', [App\Http\Controllers\UserController::class,'all_user']);
    Route::get('/view-orders/{id}', [App\Http\Controllers\OrderController::class,'view_order']);
    Route::get('/update-order-Status', [App\Http\Controllers\OrderController::class,'update_order_status']);
    Route::get('/add-products', [App\Http\Controllers\ProductsController::class,'create']);
    Route::post('/save-products', [App\Http\Controllers\ProductsController::class,'storee']);
    Route::get('/edit-products/{id}', [App\Http\Controllers\ProductsController::class,'edit']);
    Route::post('/update-products/{id}', [App\Http\Controllers\ProductsController::class,'update']);
    Route::get('/update-products-Status', [App\Http\Controllers\ProductsController::class,'changeProductstatus']);
    Route::get('/delete-products/{id}', [App\Http\Controllers\ProductsController::class,'destroy']);
    Route::get('/update-products-Status', [App\Http\Controllers\ProductsController::class,'changeProductStatus']);
    Route::get('/getcategoriesBySectionOnProduct', [App\Http\Controllers\ProductsController::class,'getcategoriesBySectionOnProduct']);
    Route::get('/getSubcategoriesByCategoriesOnProduct', [App\Http\Controllers\ProductsController::class,'getSubcategoriesByCategoriesOnProduct']);

    Route::get('/return-refunds', [App\Http\Controllers\OrderController::class,'return_refunds']);
    Route::get('/view-return-orders/{id}', [App\Http\Controllers\OrderController::class,'view_return_order']);

    Route::get('refund-status',[App\Http\Controllers\OrderController::class,'refund_status']);
    Route::get('enquiry',[App\Http\Controllers\AdminController::class,'all_enquiry']);

//    Route::get('/sales-report', 'ReportController@salesReport')->name('sales.report');

    Route::get('/all-faqs', [App\Http\Controllers\FaqController::class, 'index']);
    Route::get('/add-faqs', [App\Http\Controllers\FaqController::class, 'add']);
    Route::post('/save-faqs', [App\Http\Controllers\FaqController::class, 'save']);
    Route::get('/update-faqs-Status', [App\Http\Controllers\FaqController::class, 'status']);
    Route::get('/delete-faqs/{id}', [App\Http\Controllers\FaqController::class, 'destroy']);
    Route::get('/edit-faqs/{id}', [App\Http\Controllers\FaqController::class, 'edit']);
    Route::post('/update-faqs/', [App\Http\Controllers\FaqController::class, 'update']);
    Route::get('change-status-faqs',[App\Http\Controllers\FaqController::class,'change_status']);
    Route::get('change-status-show_on_homet',[App\Http\Controllers\FaqController::class,'show_on_homet_status']);

    Route::get('/all-reviews', [App\Http\Controllers\ReviewController::class, 'index']);
    Route::get('/add-reviews', [App\Http\Controllers\ReviewController::class, 'add']);
    Route::post('/save-reviews', [App\Http\Controllers\ReviewController::class, 'save']);
    Route::get('/update-reviews-Status', [App\Http\Controllers\ReviewController::class, 'status']);
    Route::get('/delete-reviews/{id}', [App\Http\Controllers\ReviewController::class, 'destroy']);
    Route::get('/edit-reviews/{id}', [App\Http\Controllers\ReviewController::class, 'edit']);
    Route::post('/update-reviews/', [App\Http\Controllers\ReviewController::class, 'update']);
    Route::get('change-status-reviews',[App\Http\Controllers\ReviewController::class,'change_status']);
    Route::get('change-status-show_reviews_on_homet',[App\Http\Controllers\ReviewController::class,'show_on_homet_status']);


    Route::get('newsletter',[App\Http\Controllers\AdminController::class,'newsletter']);


});

Route::group(['prefix'=>'user'], function(){

    Auth::routes();
});
