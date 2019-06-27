<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site/landing";
$route['404_override'] = '';

$route['admin'] = "admin/adminlogin";
$route['signup'] = "site/user/signup_form";
$route['login'] = "site/user/login_form";
$route['logout'] = "site/user/logout_user";
$route['forgot-password'] = "site/user/forgot_password_form";
$route['onboarding'] = "site/product/onboarding";
$route['gift-cards'] = "site/giftcard";
$route['checkout/(:any)'] = "site/checkout";
$route['order/(:any)'] = "site/order";
$route['order/ipnpayment'] = "site/order/ipnpayment"; 
$route['settings'] = "site/user_settings/display_user_settings"; 
$route['settings/password'] = "site/user_settings/password_settings";
$route['settings/preferences'] = "site/user_settings/preferences_settings";
$route['settings/notifications'] = "site/user_settings/notifications_settings";
$route['purchases'] = "site/user_settings/user_purchases";
$route['verification'] = "site/user/verification";
$route['verification/(:any)'] = "site/user/verification/$1";
$route['photo-video'] = "site/user/change_profile_photo";    
$route['orders'] = "site/user_settings/user_orders";
$route['settings/shipping'] = "site/user_settings/shipping_settings";
$route['credits'] = "site/user_settings/user_credits";
$route['host-payment-success/(:any)'] = "site/product/hostpayment_success/$1";
$route['settings/giftcards'] = "site/user_settings/user_giftcards";
$route['things/(:any)/edit'] = "site/product/edit_product_detail/$1";
$route['things/(:any)/edit/(:any)'] = "site/product/edit_product_detail/$1";
$route['things/(:any)/delete'] = "site/product/delete_product/$1";
$route['things/shuffle'] = "site/product/display_product_shuffle";
$route['things/(:any)'] = "site/product/display_product_detail/$1";
$route['user/(:any)/added'] = "site/user/display_user_added";
$route['user/(:any)/lists'] = "site/user/display_user_lists";
$route['user/(:any)/lists/(:num)'] = "site/user/display_user_lists_home";
$route['user/(:any)/lists/(:num)/followers'] = "site/user/display_user_lists_followers";
$route['user/(:any)/lists/(:num)/settings'] = "site/user/edit_user_lists";
$route['user/(:any)/wants'] = "site/user/display_user_wants";
$route['user/(:any)/owns'] = "site/user/display_user_owns";
$route['user/(:any)/following'] = "site/user/display_user_following/$1";
$route['user/(:any)/followers'] = "site/user/display_user_followers/$1";
$route['user/(:any)/things/(:any)/(:any)'] = "site/product/display_user_thing/$1/$2";
$route['user/(:any)/wishlists/(:any)/edit'] = "site/user/display_user_lists_edit";
$route['user/(:any)/wishlists/(:any)'] = "site/user/display_user_lists_home";
$route['user/(:any)'] = "site/user/display_user_profile/$1";
$route['shopby/(:any)'] = "site/searchShop/search_shopby/$1";
$route['shop'] = "site/shop";

$route['sales/create'] = "site/product/sales_create";
$route['seller-signup'] = "site/user/seller_signup_form";

$route['pages/(:num)/(:any)'] = "site/cms/page_by_id";
$route['pages/(:any)'] = "site/cms";

$route['create-brand'] = "site/user/create_brand_form";
$route['view-purchase/(:any)'] = "site/user/view_purchase"; 
$route['view-order/(:any)'] = "site/user/view_order";
$route['order-review/(:num)/(:num)/(:any)'] = "site/user/order_review";
$route['order-review/(:num)'] = "admin/order/order_review";

$route['image-crop/(:any)'] = "site/user/image_crop";
$route['lang/(:any)'] = "site/product/language_change/$1";

$route['notifications'] = "site/notify/display_notifications";

$route['payment-success'] = "admin/commission/display_payment_success";
$route['payment-failed'] = "admin/commission/display_payment_failed";

$route['bookmarklet'] = "site/bookmarklet";
$route['bookmarklets'] = "site/bookmarklet/display_bookmarklet";
$route['invite-friends'] = "site/user/invite_friends";
$route['contact-us'] = "site/cms/contactus_businesstravel";
$route['business-travel'] = "site/cms/contactus_businesstravel";

//Rentals website routes

//neighborhood city display
$route['neighborhood/(:any)/(:any)'] = "site/neighborhood/display_city_neighborhood/$1/$2";

//neighborhood display
$route['neighborhood/(:any)'] = "site/neighborhood/display_neighborhood/$1";

//neighborhood List display
$route['neighborhood'] = "site/neighborhood";

//City all neighborhood List display
$route['locations/(:any)/neighborhoods'] = "site/neighborhood/display_city_all_neighborhoods/$1";

//List details about Rent property
$route['list_space'] = "site/product/list_space";
$route['manage_listing/(:any)'] = "site/product/manage_listing/$1";
$route['space_listing/(:any)'] = "site/product/space_listing/$1";
$route['cancel_policy/(:any)'] = "site/product/cancel_policy/$1";
$route['price_listing/(:any)'] = "site/product/price_listing/$1";
$route['overview_listing/(:any)'] = "site/product/overview_listing/$1";
$route['photos_listing/(:any)'] = "site/product/photos_listing/$1";
$route['amenities_listing/(:any)'] = "site/product/amenities_listing/$1";
$route['address_listing/(:any)'] = "site/product/address_listing/$1";
$route['detail_list/(:any)'] = "site/product/detail_list/$1";
$route['InsertProductImage'] = "site/product/InsertProductImage";
$route['list_space'] = "site/product/list_space";


//For search
$route['city/search'] = "site/product/city_autocomplete";

//For search search result
$route['property'] = "site/rentals/mapview/$1";
$route['property/(:any)'] = "site/rentals/mapview/$1";
$route['s/(:any)'] = "site/rentals/mapview/$1";
//For product Details result
$route['rental/(:any)'] = 'site/landing/display_product_detail/$1';

//For auto complete of city search
$route['search/search_text'] = 'site/product/search_text';
$route['undefinedsearch/search_text'] = 'site/product/search_text';

//Signup mail sending
$route['send-confirm-mail'] = "site/user/send_quick_register_mail";

//For Detail page
$route['detail-page'] = "site/rentals/detail_page";

//For user Dashboard
$route['dashboard'] = "site/user_settings";
$route['account'] = "site/cms/dashboard_account";
$route['inbox'] = "site/cms/dashboard_inbox";
$route['inbox/(:any)'] = "site/cms/dashboard_inbox/$1";
$route['sentbox'] = "site/cms/dashboard_sentbox";
$route['sentbox/(:any)'] = "site/cms/dashboard_sentbox/$1";
$route['listing/(:any)'] = "site/cms/dashboard_listing/$1"; 

$route['listing-reservation'] = "site/cms/dashboard_listing_reservation";
$route['listing-booking'] = "site/cms/dashboard_booking"; 
$route['listing_enquiry'] = "site/cms/dashboard_listing_enquiry";
$route['plan'] = "site/cms/dashboard_plan";
$route['edit_inquiry_details/(:any)'] = "site/rentals/edit_inquiry_details/$1";



$route['listing-requirement'] = "site/cms/dashboard_listing_requirement"; 
$route['trips/upcoming'] = "site/cms/dashboard_trips";
$route['trips/previous'] = "site/cms/dashboard_trips_prve";
$route['account-payout'] = "site/cms/dashboard_account_payout";
$route['account-trans'] = "site/cms/dashboard_account_trans";
$route['account-trans/(:any)'] = "site/cms/dashboard_account_trans/$1";
$route['account-trans/(:any)/(:any)/(:any)'] = "site/cms/dashboard_account_trans/$1/$2/$3";
$route['gross-earning'] = "site/cms/dashboard_account_trans";
$route['gross-earning/(:any)/(:any)'] = "site/cms/dashboard_account_trans/$1/$2";
$route['account-privacy'] = "site/cms/dashboard_account_privacy";
$route['account-security'] = "site/cms/dashboard_account_security";
$route['account-setting'] = "site/cms/dashboard_account_setting";

$route['users/edit/(:any)'] = "site/user_settings/user_edit/$1";

$route['users/show/(:any)'] = "site/user_settings/user_profile";


//$route['lang/(:any)'] = "site/product/language_change/$1";

$route['popular'] = "site/rentals/popular_list";
$route['download'] = "admin/download/display_download";
$route['browsefriends'] = "site/rentals/browsefriends_list";
$route['booking/(:any)'] = "site/rentals/rental_guest_booking";



//wishlist
$route['users/(:any)/wishlists'] = "site/wishlists";

//review
$route['display-review'] = "site/product/display_review";
$route['display-review1'] = "site/product/display_review1";

//change currency
$route['change-currency/(:any)'] = "site/product/change_currency/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */