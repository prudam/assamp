<?php

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
require __DIR__.'/frontend.php';


/** Admin Login Route */
Route::get('/admin/login', 'Admin\AdminLoginController@showAdminLoginForm')->name('admin.login');
Route::get('/register/admin', 'Admin\AdminRegisterController@showAdminRegisterForm')->name('admin.register');
Route::get('/admin/logout', 'Admin\AdminLoginController@logout')->name('admin.logout');

Route::post('/admin/login', 'Admin\AdminLoginController@adminLogin');
Route::post('/register/admin', 'Admin\AdminRegisterController@createAdmin');
/** End of Admin Login Route */

Route::group(['middleware'=>'auth:admin','prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::get('dashboard', 'AdminDashboardController@index')->name('admin.dashboard');

    Route::get('change-password', 'AdminDashboardController@showChangePasswordForm')->name('admin.change_password');
    Route::post('update-password', 'AdminDashboardController@updatePassword')->name('admin.update_password');

    /** Cart Quantity **/
    Route::get('cart-quantity', 'AdminDashboardController@showCartQuanitytForm')->name('admin.cart_quantity');
    Route::post('update-cart-quantity', 'AdminDashboardController@updateCartQuanityt')->name('admin.update_cart_quantity');

    Route::group(['namespace'=>'TopCategory'],function(){
    	Route::get('all-top-category', 'TopCategoryController@allTopCategory')->name('admin.all_top_category');
    	Route::get('edit-top-category/{slug}/{topCategoryId}', 'TopCategoryController@showEditTopCategoryForm')->name('admin.edit_top_category');
    	Route::put('update-top-category/{topCategoryId}', 'TopCategoryController@updateTopCategory')->name('admin.update_top_category');
        Route::get('update-status/{topCategoryId}/{status}', 'TopCategoryController@updateStatus')->name('admin.update_status');
    });

    Route::group(['namespace'=>'SubCategory'],function(){
    	Route::get('new-sub-category', 'SubCategoryController@showSubCategoryForm')->name('admin.new_sub_category');
    	Route::put('add-sub-category', 'SubCategoryController@addSubCategory')->name('admin.add_sub_category');
    	Route::get('all-sub-category', 'SubCategoryController@allSubCategory')->name('admin.all_sub_category');
    	Route::get('edit-sub-category/{slug}/{subCategoryId}', 'SubCategoryController@showEditSubCategoryForm')->name('admin.edit_sub_category');
    	Route::put('update-sub-category/{subCategoryId}', 'SubCategoryController@updateSubCategory')->name('admin.update_sub_category');
        Route::get('sub-category-update-status/{subCategoryId}/{status}', 'SubCategoryController@updateStatus')->name('admin.sub_category_update_status');
    });

    // Route::group(['namespace'=>'Color'],function(){
    //     Route::get('new-color', 'ColorController@showColorForm')->name('admin.new_color');
    //     Route::post('add-color', 'ColorController@addColor')->name('admin.add_color');
    //     Route::get('all-color', 'ColorController@allColor')->name('admin.all_color');
    //     Route::get('edit-color/{slug}/{colorId}', 'ColorController@showEditColorForm')->name('admin.edit_color');
    //     Route::post('update-color/{colorId}', 'ColorController@updateColor')->name('admin.update_color');

    //     Route::get('new-mappping-color', 'ColorController@showMappingColorForm')->name('admin.new_mappping_color');
    //     Route::post('add-mappping-color', 'ColorController@addMappingColor')->name('admin.add_mappping_color');
    //     Route::get('edit-mappping-color/{color_mapping_id}', 'ColorController@showEditMappingColorForm')->name('admin.edit_mappping_color');
    //     Route::post('update-mappping-color/{color_mapping_id}', 'ColorController@updateMappingColor')->name('admin.update_mappping_color');
    // });

    Route::group(['namespace'=>'Product'],function(){

        /** New Product **/
        Route::get('new-product', 'ProductController@showProductForm')->name('admin.new_product');
        Route::put('add-product', 'ProductController@addProduct')->name('admin.add_product');
        
        /** Stock Entry **/
        Route::get('product-stock-entry/{slug}/{product_id}', 'ProductController@productStockEntry')->name('admin.product_stock_entry');
        Route::post('add-stock-entry/{product_id}', 'ProductController@addStockEntry')->name('admin.add_stock_entry');

        /** Products List **/
        Route::get('prouduct-list', 'ProductController@productList')->name('admin.product_list');
        Route::post('prouduct-list-data', 'ProductController@productListData')->name('admin.product_list_data');

        /** Active and In-Active Products List **/
        Route::get('active-prouduct-list', 'ProductController@activeProductList')->name('admin.active_product_list');
        Route::get('in-active-prouduct-list', 'ProductController@inactiveProductList')->name('admin.in_active_product_list');
        Route::post('active-in-active-prouduct-list-data', 'ProductController@activeInactiveProductListData')->name('admin.active_in_active_product_list_data');

        /** Product Banner Change **/
        Route::get('edit-prouduct-banner/{product_id}', 'ProductController@showEditProductBanner')->name('admin.edit_product_banner');
        Route::put('update-prouduct-banner/{product_id}', 'ProductController@updateProductBanner')->name('admin.update_product_banner');

        /** Product Additional Image **/
        Route::get('additional-prouduct-image-list/{product_id}', 'ProductController@showProductImageList')->name('admin.additional_product_image_list');
        Route::put('update-prouduct-additional-image/{additional_image_id}', 'ProductController@updateProductAdditionalImage')->name('admin.update_product_additional_image');

        /** Image URL Generate **/
        Route::get('banner_image/{product_id}', 'ProductController@bannerImage')->name('admin.banner_image');
        Route::get('additional_image/{additional_image_id}', 'ProductController@additionalImage')->name('admin.additional_image');

        /** Product View **/
        Route::get('view-product/{slug}/{product_id}', 'ProductController@viewProduct')->name('admin.view_product');

        /** Edit Product **/
        Route::get('edit-product/{slug}/{product_id}', 'ProductController@showEditProduct')->name('admin.edit_product');
        Route::put('update-product/{product_id}', 'ProductController@updateProduct')->name('admin.update_product');

        /** Upload Aditional Image **/
        Route::put('upload-product-slider_image/{product_id}', 'ProductController@uploadProductSlider')->name('admin.upload_product_slider');
        /** Remove Addtional Image **/
        Route::get('remove-product-slider-image/{image_id}', 'ProductController@removeProductSliderImage')->name('admin.remove_product_slider_image');

        /** Edit Product Color **/
        // Route::get('edit-product-color/{slug}/{product_id}', 'ProductController@showEditProductColor')->name('admin.edit_product_color');
        // Route::post('update-product-color/{product_id}', 'ProductController@updateProductColor')->name('admin.update_product_color');

        /** Product Color Status **/
        // Route::get('change-product-color-status/{product_mapping_id}/{status}', 'ProductController@changeProductColorStatus')->name('admin.change_product_color_status'); 

        /** Delete Product **/
        Route::get('delete-product/{product_id}', 'ProductController@deleteProduct')->name('admin.delete_product'); 

        /** Product Update Stock **/
        Route::get('edit-product-stock/{slug}/{product_id}', 'ProductController@showEditProductStock')->name('admin.edit_product_stock');
        Route::post('update-product-stock/{product_id}', 'ProductController@updateProductStock')->name('admin.update_product_stock'); 

        /** Product Status **/
        Route::get('change-product-status/{product_id}/{status}', 'ProductController@changeProductStatus')->name('admin.change_product_status'); 

        /** Product Feature Product **/
        Route::get('make-feature-product/{product_id}', 'ProductController@makeFeatureProduct')->name('admin.make_feature_product');
        Route::get('remove-feature-product/{product_id}', 'ProductController@removeFeatureProduct')->name('admin.remove_feature_product');

        /** Most Popular Product **/
        // Route::get('most-popular-product/{product_id}', 'ProductController@mostPopularProduct')->name('admin.most_popular_product');

        /** Best Seller Product **/
        // Route::get('best-seller-product/{product_id}', 'ProductController@bestSellerProduct')->name('admin.best_seller_product');  

        /** Ajax Route **/
        Route::post('retrive-sub-category', 'ProductController@retriveSubCategory');
        Route::post('product-price-type', 'ProductController@productPriceType');
        // Route::post('retrive-color', 'ProductController@retriveColor');

        Route::group(['namespace'=>'Metal'], function(){

            /** New Metal Product **/
            Route::get('new-metal-product', 'MetalController@showMetalProductForm')->name('admin.new_metal_product');
            Route::put('add-metal-product', 'MetalController@addMetalProduct')->name('admin.add_metal_product');

            /** Metal Product List **/
            Route::get('metal-prouduct-list', 'MetalController@metalProductList')->name('admin.metal_product_list');
            Route::post('metal-prouduct-list-data', 'MetalController@metalProductListData')->name('admin.metal_product_list_data');

            /** Metal Product Banner Change **/
            Route::get('edit-metal-prouduct-banner/{product_id}', 'MetalController@showEditMetalProductBanner')->name('admin.edit_metal_product_banner');
            Route::put('update-metal-prouduct-banner/{product_id}', 'MetalController@updateMetalProductBanner')->name('admin.update_metal_product_banner');

            /** Metal Product Additional Image **/
            Route::get('metal-additional-prouduct-image-list/{product_id}', 'MetalController@showMetalProductImageList')->name('admin.metal_additional_product_image_list');
            Route::put('update-metal-prouduct-additional-image/{additional_image_id}', 'MetalController@updateMetalProductAdditionalImage')->name('admin.update_metal_product_additional_image');

            /** MEtal Product Status **/
            Route::get('change-metal-product-status/{product_id}/{status}', 'MetalController@changeMetalProductStatus')->name('admin.change_metal_product_status');

            /** MEtal Product Status **/
            Route::get('delete-metal-product/{product_id}', 'MetalController@deleteProduct')->name('admin.delete_metal_product');

            /** Metal Product View **/
            Route::get('view-metal-product/{slug}/{product_id}', 'MetalController@viewMetalProduct')->name('admin.view_metal_product'); 

             /** Edit Metal Product **/
            Route::get('edit-metal-product/{slug}/{product_id}', 'MetalController@showMetalEditProduct')->name('admin.edit_metal_product');
            Route::put('update-metal-product/{product_id}', 'MetalController@updateMetalProduct')->name('admin.update_metal_product');

            /** Image URL Generate **/
            Route::get('metal-banner-image/{product_id}', 'MetalController@metalBannerImage')->name('admin.metal_banner_image');
            Route::get('metal-additional-image/{additional_image_id}', 'MetalController@metalAdditionalImage')->name('admin.metal_additional_image');

            /** Upload Aditional Image **/
            Route::put('upload-metal-product-slider-image/{product_id}', 'MetalController@uploadProductSlider')->name('admin.upload_metal_product_slider');
            /** Remove Addtional Image **/
            Route::get('remove-metal-product-slider-image/{image_id}', 'MetalController@removeProductSliderImage')->name('admin.remove_metal_product_slider_image');

            /** Metal Product Feature Product **/
            Route::get('make-feature-metal-product/{product_id}', 'MetalController@makeFeatureProduct')->name('admin.make_feature_metal_product');
        });
    });

    Route::group(['namespace'=>'Coupon'],function(){
        Route::get('new-coupon', 'CouponController@showCouponForm')->name('admin.new_coupon');
        Route::post('add-coupon', 'CouponController@addCoupon')->name('admin.add_coupon');
        Route::get('all-coupon', 'CouponController@allCoupon')->name('admin.all_coupon');
        Route::get('edit-coupon/{couponId}', 'CouponController@showEditCouponForm')->name('admin.edit_coupon');
        Route::put('update-coupon/{couponId}', 'CouponController@updateCoupon')->name('admin.update_coupon');

        Route::get('coupon-status-update/{coupon_id}/{status}', 'CouponController@couponStatusUpdate')->name('admin.coupon_status_update');
    });

    Route::group(['namespace'=>'Users'],function(){

        /** Users List **/
        Route::get('users-list', 'UsersController@usersList')->name('admin.users_list');

        /** New seller list **/
        Route::get('new-seller-list', 'UsersController@newSellerList')->name('admin.new_seller_list');
        /** Confirm seller list **/
        Route::get('confirm-seller/{user_id}', 'UsersController@confirmSeller')->name('admin.confirm_seller');

        /** Ajax User Datatable **/
        Route::post('users-list-data', 'UsersController@usersListData')->name('admin.users_list_data');

        /** User Profile **/
        Route::get('users-profile/{user_id}', 'UsersController@usersProfile')->name('admin.users_profile');

        /** Delete User **/
        Route::get('delete-user/{user_id}', 'UsersController@deleteUser')->name('admin.delete_user');
    });

    Route::group(['namespace'=>'Orders'],function(){

        /** New Orders List **/
        Route::get('new-orders-list', 'OrdersController@newOrdersList')->name('admin.new_orders_list');

        /** Out for Delivery Orders List **/
        Route::get('out-for-delivery-orders-list', 'OrdersController@outForDeliveryOrdersList')->name('admin.out_for_delivery_orders_list');

        /** Delivered Orders List **/
        Route::get('delivered-orders-list', 'OrdersController@deliveredOrdersList')->name('admin.delivered_orders_list');

        /** Delivered Orders List **/
        Route::get('canceled-orders-list', 'OrdersController@canceledOrdersList')->name('admin.canceled_orders_list');

        /** User Order History List **/
        Route::get('users-orders-history-list/{user_id}', 'OrdersController@usersOrdersHistoryList')->name('admin.users_orders_history_list');

        /** Ajax Order Datatable **/
        Route::post('orders-list-data', 'OrdersController@ordersListData')->name('admin.orders_list_data');
        Route::post('orders-history-list-data', 'OrdersController@ordersHistoryListData')->name('admin.orders_history_list_data');

        /** View Order Details **/
        Route::get('order-detail/{order_id}', 'OrdersController@orderDetail')->name('admin.order_detail');

        /** Order Status Update **/
        Route::get('order-status-update/{order_id}/{status}', 'OrdersController@orderStatusUpdate')->name('admin.order_status_update');

        /** Delete Order **/
        Route::get('delete-order/{order_id}', 'OrdersController@deleteOrder')->name('admin.delete_order');
    });

    Route::group(['namespace'=>'Review'],function(){

        /** New Reviews List **/
        Route::get('new-reviews-list', 'ReviewController@newReviewList')->name('admin.new_reviews_list');

        /** Verified Reviews List **/
        Route::get('verified-reviews-list', 'ReviewController@verifiedReviewList')->name('admin.verified_reviews_list');

        /** Ajax Order Datatable **/
        Route::post('reviews-list-data', 'ReviewController@reviewsListData')->name('admin.reviews_list_data');
        // Route::post('orders-history-list-data', 'OrdersController@ordersHistoryListData')->name('admin.orders_history_list_data');

        /** Verified Review **/
        Route::get('verified-review/{user_id}/{product_id}', 'ReviewController@verifiedReview')->name('admin.verified_review');

        /** Delete Review **/
        Route::get('delete-review/{user_id}/{product_id}', 'ReviewController@deleteReview')->name('admin.delete_review');

        /** Invoice **/
        // Route::get('invoice/{order_id}', 'OrdersController@invoice')->name('admin.invoice');

        /** Order Status Update **/
        // Route::get('order-status-update/{order_id}/{status}', 'OrdersController@orderStatusUpdate')->name('admin.order_status_update');
    });

    Route::group(['namespace'=>'Header'],function(){

        /** Slider List **/
        Route::get('slider-list', 'HeaderController@sliderList')->name('admin.slider_list');
        Route::get('slider-setting/{slider_id}', 'HeaderController@sliderSetting')->name('admin.slider_setting');
        Route::post('slider-setting/update', 'HeaderController@sliderSettingUpdate')->name('admin.slider_setting_update');

        /** Slider Form **/
        Route::get('slider-form', 'HeaderController@showSliderForm')->name('admin.slider_form');
        Route::put('upload-slider', 'HeaderController@uploadSlider')->name('admin.upload_slider');
        Route::get('slider-delete/{id}', 'HeaderController@deleteSlider')->name('admin.slider_delete');

        /** Header Color Update **/
        Route::get('header-form', 'HeaderController@showHeaderForm')->name('admin.header_form');
        Route::put('header-update-color/{id}', 'HeaderController@headerUpdateColor')->name('admin.header_update_color');

        /** Ajax Order Datatable **/
        // Route::post('reviews-list-data', 'ReviewController@reviewsListData')->name('admin.reviews_list_data');
        // Route::post('orders-history-list-data', 'OrdersController@ordersHistoryListData')->name('admin.orders_history_list_data');

        /** Verified Review **/
        // Route::get('verified-review/{user_id}/{product_id}', 'ReviewController@verifiedReview')->name('admin.verified_review');

        /** Delete Review **/
        // Route::get('delete-review/{user_id}/{product_id}', 'ReviewController@deleteReview')->name('admin.delete_review');

        /** Invoice **/
        // Route::get('invoice/{order_id}', 'OrdersController@invoice')->name('admin.invoice');

        /** Order Status Update **/
        // Route::get('order-status-update/{order_id}/{status}', 'OrdersController@orderStatusUpdate')->name('admin.order_status_update');
    });
});
