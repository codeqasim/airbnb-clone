<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 *
 * CMS related functions
 *
 * @author Teamtweaks
 *        
 */
class Cms extends MY_Controller {
	function __construct() {
		
		parent::__construct ();
		$this->load->helper ( array (
				'cookie',
				'date',
				'form',
				'email' 
		) );
		$this->load->library ( array (
				'encrypt',
				'form_validation'
				
		) );
		$this->load->model ( array (
				'product_model',
				'admin_model',
				'cms_model' ,
				'slider_model'
		) );
		if ($_SESSION ['sMainCategories'] == '') {
			$sortArr1 = array (
					'field' => 'cat_position',
					'type' => 'asc' 
			);
			$sortArr = array (
					$sortArr1 
			);
			$_SESSION ['sMainCategories'] = $this->product_model->get_all_details ( CATEGORY, array (
					'rootID' => '0',
					'status' => 'Active' 
			), $sortArr );
		}
		$this->data ['mainCategories'] = $_SESSION ['sMainCategories'];
		
		if ($_SESSION ['sColorLists'] == '') {
			$_SESSION ['sColorLists'] = $this->product_model->get_all_details ( LIST_VALUES, array (
					'list_id' => '1' 
			) );
		}
		$this->data ['mainColorLists'] = $_SESSION ['sColorLists'];
		
		$this->data ['loginCheck'] = $this->checkLogin ( 'U' );
		$this->data ['likedProducts'] = array ();
		if ($this->data ['loginCheck'] != '') {
			$this->data ['likedProducts'] = $this->product_model->get_all_details ( PRODUCT_LIKES, array (
					'user_id' => $this->checkLogin ( 'U' ) 
			) );
		}
		 $this->load->library("pagination");
	}
	public function index() {
		$seourl = $this->uri->segment ( 2 );
		if($this->session->userdata('language_code') == ''){
		$pageDetails = $this->product_model->get_all_details ( CMS, array (
				'seourl' => $seourl,
				'status' => 'Publish',
				'lang_code' => 'en'
				
		) );
		}else{
		$pageDetails = $this->product_model->get_all_details ( CMS, array (
				'seourl' => $seourl,
				'status' => 'Publish',
				'lang_code' => $this->session->userdata('language_code')
				
		) );
		}
		if ($pageDetails->num_rows () == 0) {
			show_404 ();
		} else {
			if ($pageDetails->row ()->meta_title != '') {
				$this->data ['heading'] = $pageDetails->row ()->meta_title;
				$this->data ['meta_title'] = $pageDetails->row ()->meta_title;
			}
			if ($pageDetails->row ()->meta_tag != '') {
				$this->data ['meta_keyword'] = $pageDetails->row ()->meta_tag;
			}
			if ($pageDetails->row ()->meta_description != '') {
				$this->data ['meta_description'] = $pageDetails->row ()->meta_description;
			}
			$this->data ['heading'] = $pageDetails->row ()->meta_title;
			$this->data ['pageDetails'] = $pageDetails;
			$this->data ['admin_settings'] = $this->admin_model->getAdminSettings ();
			//$this->data ['cmsList'] = $this->cms_model->get_all_details ( CMS, $condition );
			$this->load->view ( 'site/cms/display_cms', $this->data );
		}
	}
	public function page_by_id() {
		$cid = $this->uri->segment ( 2 );
		$pageDetails = $this->product_model->get_all_details ( CMS, array (
				'id' => $cid,
				'status' => 'Publish' 
		) );
		if ($pageDetails->num_rows () == 0) {
			show_404 ();
		} else {
			if ($pageDetails->row ()->meta_title != '') {
				$this->data ['heading'] = $pageDetails->row ()->meta_title;
				$this->data ['meta_title'] = $pageDetails->row ()->meta_title;
			}
			if ($pageDetails->row ()->meta_tag != '') {
				$this->data ['meta_keyword'] = $pageDetails->row ()->meta_tag;
			}
			if ($pageDetails->row ()->meta_description != '') {
				$this->data ['meta_description'] = $pageDetails->row ()->meta_description;
			}
			$this->data ['heading'] = $pageDetails->row ()->meta_title;
			$this->data ['pageDetails'] = $pageDetails;
			$this->load->view ( 'site/cms/display_cms', $this->data );
		}
	}
	
	/* End of file cms.php */
	/* Location: ./application/controllers/site/product.php */
	
	/* User Dashboard */
	public function dashboard_account() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			$this->data ['heading'] = 'Dashboard-Account';
			$this->data ['Details'] = $this->cms_model->get_all_details ( USERS, array (
					'id' => $this->checkLogin ( 'U' ) 
			) );
			$this->load->view ( 'site/user/dashboard-account', $this->data );
		}
	}
	public function dashboard_account_payout() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			$this->data ['userpay'] = $this->cms_model->get_all_details ( USERS, array (
					'id' => $this->checkLogin ( 'U' ) 
			) );
			$this->data ['heading'] = 'Dashboard-Account payout';
			$country_query = 'SELECT id,name FROM ' . LOCATIONS . ' WHERE status="Active" order by name';
			$this->data ['active_countries'] = $this->cms_model->ExecuteQuery ( $country_query );
			
			$this->load->view ( 'site/user/dashboard-account-payout', $this->data );
		}
	}
	public function dashboard_account_trans() {
		if ($this->checkLogin ( 'U' ) == '')
			redirect ( base_url () );
		else {
			$this->data ['heading'] = 'Dashboard-Account transaction history';
			$this->data ['RentalList'] = $this->cms_model->get_rental_list ( $this->checkLogin ( 'U' ) );
			$this->data ['gross_earn'] = $this->cms_model->get_all_details(HOSTPAYMENT,array('host_id'=>$this->checkLogin ( 'U' )));
			//print_r($this->data ['gross_earn']->result());die;
			
			
			if ($this->uri->segment ( 1 ) == 'account-trans') {
				$Pending_booked_Rental = $this->cms_model->booked_rental_trans ( $this->checkLogin ( 'U' ) );
				$this->data ['PendingbookedRental'] = $Pending_booked_Rental ['rental'];
				$this->data ['booked_rental_count'] = $Pending_booked_Rental ['booked_rental_count'];
				$this->data ['pending_rental_count'] = $Pending_booked_Rental ['pending_rental_count'];
			}
			//echo '<pre';print_r($this->data ['PendingbookedRental']->result());die;
			if ($this->uri->segment ( 1 ) == 'gross-earning' || ($this->uri->segment ( 1 ) == 'account-trans' && $this->uri->segment ( 2 ) == '')) {
				$this->data ['gross_earning_rental'] = $this->cms_model->gross_earning();
			}
			//echo '<pre';print_r($this->data ['gross_earning_rental']->result());die;
			$this->load->view ( 'site/user/dashboard-account-transaction', $this->data );
		}
	}
	public function dashboard_account_privacy() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			$this->data ['heading'] = 'Dashboard-Account privacy';
			$this->data ['userDetails'] = $this->cms_model->get_all_details ( USERS, array (
					'id' => $this->checkLogin ( 'U' ) 
			) );
			$this->load->view ( 'site/user/dashboard-account-privacy', $this->data );
		}
	}
	public function dashboard_account_security() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			$this->data ['heading'] = 'Dashboard-Account Security';
			$this->load->view ( 'site/user/dashboard-account-security', $this->data );
		}
	}
	public function dashboard_account_setting() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			
			if ($_POST) {
				$dataArr = array (
						'country' => $this->input->post ( 'country' ) 
				);
				$this->cms_model->commonInsertUpdate ( USERS, 'update', array (), $dataArr, array (
						'id' => $this->checkLogin ( 'U' ) 
				) );
				$this->setErrorMessage ( 'success', 'Country Updated successfully.' );
				redirect ( 'account-setting' );
			}
			
			$this->data ['heading'] = 'Country of Residence';
			$this->data ['countries'] = $this->cms_model->get_countries();
			$this->load->view ( 'site/user/dashboard-account-settings', $this->data );
		}
	}
	public function dashboard_inbox() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
		
		$this->data ['heading'] = 'Dashboard-Inbox';//echo $this->data ['userDetails']->row ()->id;
		$inbox_sent_messages = $this->cms_model->get_all_discussion($this->data['userDetails']->row ()->id);
		$this->data ['dashboardinbox']=$inbox_sent_messages['inbox'];
		$this->data ['dashboardsent']=$inbox_sent_messages['sent']; //var_dump($this->data 
   
		$updateArr = array(
               'msg_read' => 'yes'
			  );

		$this->db->where('receiver_id', $this->data ['userDetails']->row ()->id);
		$this->db->update(DISCUSSION, $updateArr); 
        $inbox_count_query='SELECT * FROM '.DISCUSSION.' WHERE receiver_id='.$this->data ['userDetails']->row ()->id.' ORDER BY date_created DESC';
		$inbox_count=$this->cms_model->ExecuteQuery($inbox_count_query);
		
        $config = array();
        $config["base_url"] = base_url() . "inbox/";
        $config["total_rows"] = $inbox_count->num_rows();
        //$config["per_page"] = $this->config->item('message_pagination_per_page');
		$config["per_page"] = 10;
        $config["uri_segment"] = 2;
 
        $this->pagination->initialize($config);
 
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$inbox_details_query='SELECT * FROM '.DISCUSSION.' WHERE receiver_id='.$this->data ['userDetails']->row ()->id.' GROUP BY convId ORDER BY date_created DESC LIMIT '.$page.','.$config["per_page"];
		
       $this->data ['dashboardinbox'] =$this->cms_model->ExecuteQuery($inbox_details_query);
		
        $this->data ["links"] = $this->pagination->create_links();
        $this->data ["userId"] = $this->checkLogin ( 'U' );
				
   $this->data ['user_details']=$inbox_sent_messages['userDetails'];
   $this->load->view ( 'site/user/dashboard-inbox', $this->data);
		}
	}
	
	public function dashboard_sentbox() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
		
			$this->data ['heading'] = 'Dashboard-Sent box';//echo $this->data ['userDetails']->row ()->id;
			$inbox_sent_messages = $this->cms_model->get_all_discussion($this->data ['userDetails']->row ()->id);
			$this->data ['dashboardinbox']=$inbox_sent_messages['inbox'];
			$this->data ['dashboardsent']=$inbox_sent_messages['sent']; //var_dump($this->data 
   
   
        $inbox_count_query='SELECT * FROM '.DISCUSSION.' WHERE sender_id='.$this->data ['userDetails']->row ()->id.' ORDER BY date_created DESC';
		$inbox_count=$this->cms_model->ExecuteQuery($inbox_count_query);
		
        $config = array();
        $config["base_url"] = base_url() . "sentbox/";
        $config["total_rows"] = $inbox_count->num_rows();
        //$config["per_page"] = $this->config->item('message_pagination_per_page');
        $config["per_page"] = 10;
        $config["uri_segment"] = 2;
 
        $this->pagination->initialize($config);
 
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$inbox_details_query='SELECT * FROM '.DISCUSSION.' WHERE sender_id='.$this->data ['userDetails']->row ()->id.' ORDER BY date_created DESC LIMIT '.$page.','.$config["per_page"];
		
       $this->data ['dashboardinbox'] =$this->cms_model->ExecuteQuery($inbox_details_query);
		
        $this->data ["links"] = $this->pagination->create_links();
		
   $this->data ['user_details']=$inbox_sent_messages['userDetails'];
   $this->load->view ( 'site/user/dashboard-sentbox', $this->data);
		}
	}
	public function dashboard_listing() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
		
		if($this->uri->segment(3)=='completed')
		{
		$this->data ['enable_complete_popup']='yes';
		}
			$status = $this->uri->segment ( 2, 0 );
			$this->data ['heading'] = 'Dashboard-Listing';
			if ($status == 'all') {
				$sortArr1 = array (
						'field' => 'id',
						'type' => 'desc' 
				);
				$sortArr = array (
						$sortArr1 
				);
				// $this->data['rentalDetail'] = $this->cms_model->get_all_details(PRODUCT,array('user_id'=>$this->checkLogin('U')),$sortArr);
				$this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list ( $this->checkLogin ( 'U' ) );
			} else if ($status == 'UnPublish') {
				$sortArr1 = array (
						'field' => 'id',
						'type' => 'desc' 
				);
				$sortArr = array (
						$sortArr1 
				);
				// $this->data['rentalDetail'] = $this->cms_model->get_all_details(PRODUCT,array('user_id'=>$this->checkLogin('U')),$sortArr);
				$this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list ( $this->checkLogin ( 'U' ), $status );
			} else if ($status == 'Publish') {
				$sortArr1 = array (
						'field' => 'id',
						'type' => 'desc' 
				);
				$sortArr = array (
						$sortArr1 
				);
           $this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list ( $this->checkLogin ( 'U' ), $status );
			} else {
				$sortArr1 = array (
						'field' => 'id',
						'type' => 'desc' 
				);
				$sortArr = array (
						$sortArr1 
				);
				$this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list ( $this->checkLogin ( 'U' ) );
			}
			
			$hosting_commission_status='SELECT * FROM '.COMMISSION.' WHERE commission_type="Host Listing"';
			$this->data ['hosting_commission_status']=$this->cms_model->ExecuteQuery($hosting_commission_status);
			
			$this->load->view ( 'site/user/dashboard-listing', $this->data );
		}
	}
	public function rental_detail_count() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			$this->data ['rentalDetail'] = $this->cms_model->get_all_details ( PRODUCT, array (
					'user_id' => $this->checkLogin ( 'U' ) 
			) );
			$this->data ['rentalAddress'] = $this->cms_model->get_all_details ( PRODUCT_ADDRESS, array (
					'product_id' => $this->data ['rentalDetail']->row ()->id 
			) );
			$this->data ['rentalBooking'] = $this->cms_model->get_all_details ( PRODUCT_BOOKING, array (
					'product_id' => $this->data ['rentalDetail']->row ()->id 
			) );
			
			foreach ( $rentalDetail->result () as $row ) {
				$listingCount = 0;
				if ($row->bedrooms != '')
					$listingCount ++;
				if ($row->beds != '')
					$listingCount ++;
				if ($row->bed_type != '')
					$listingCount ++;
				if ($row->bathrooms != '')
					$listingCount ++;
				if ($row->home_type != '')
					$listingCount ++;
				if ($row->room_type != '')
					$listingCount ++;
				if ($row->accommodates != '')
					$listingCount ++;
				
				if ($listingCount == 7)
					$listingComplete = 'yes';
				else
					$listingComplete = 'no';
			}
			foreach ( $rentalAddress->result () as $row ) {
				$addressCount = 0;
				if ($row->country != '')
					$addressCount ++;
				if ($row->state != '')
					$addressCount ++;
				if ($row->city != '')
					$addressCount ++;
				if ($row->address != '')
					$addressCount ++;
				
				if ($addressCount == 4)
					$addressComplete = 'yes';
				else
					$addressComplete = 'no';
			}
			foreach ( $rentalDetail->result () as $row ) {
				$photoCount = 0;
				if ($row->image != '')
					$photoCount ++;
			}
			foreach ( $rentalDetail->result () as $row ) {
				$overviewCount = 0;
				if ($row->product_name != '')
					$overviewCount ++;
				if ($row->description != '')
					$overviewCount ++;
			}
			foreach ( $rentalDetail->result () as $row ) {
				$pricingCount = 0;
				if ($row->price != '')
					$pricingCount ++;
			}
			foreach ( $rentalBooking->result () as $row ) {
				$calendarCount = 0;
				if ($row->datefrom != '')
					$calendarCount ++;
				if ($row->dateto != '')
					$calendarCount ++;
			}
		}
	}
	public function dashboard_listing_reservation() {
		if ($this->checkLogin ( 'U' ) == '')
			redirect ( base_url () );
		else {
			$this->data ['heading'] = 'Dashboard-Listing Reservation';
			// echo $this->checkLogin('U');die;
			$this->data ['bookedRental'] = $this->cms_model->booked_rental ( $this->checkLogin ( 'U' ) );
			//echo '<pre>'; print_r($this->data ['bookedRental']->result_array()); die;
			$this->load->view ( 'site/user/dashboard-listing-reservation', $this->data );
		}
	}
	
	/* bookin detail added 30/05/2014 */
	public function dashboard_booking() {
		if ($this->checkLogin ( 'U' ) == '')
			redirect ( base_url () );
		else {
			
			$this->data ['heading'] = 'Dashboard-Booking';
			$this->data ['bookedRental'] = $this->cms_model->booking_rental ( $this->checkLogin ( 'U' ) );
			$this->data ['datebyPropid'] = $this->cms_model->DategroupbyPropID ( 1 );
			
			$this->load->view ( 'site/user/dashboard-booking', $this->data );
		}
	}
	
	
	
	
	/* Enquiry Details Show added 30/05/2014 */
	public function dashboard_listing_enquiry() {
		if ($this->checkLogin ( 'U' ) == '')
			redirect ( base_url () );
		else {
			$this->data ['heading'] = 'Dashboard-Enqiury';
			$this->data ['bookedRental'] = $this->cms_model->booking_Enquiry ( $this->checkLogin ( 'U' ) );
			$this->data ['datebyPropid'] = $this->cms_model->DategroupbyPropID ( 1 );
			
			$this->load->view ( 'site/user/dashboard-listing-enquiry', $this->data );
		}
	}
	
	/**
	 * Plan Display load *
	 */
	public function dashboard_plan() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			$this->data ['heading'] = 'Dashboard-Account';
			$this->data ['Details'] = $this->cms_model->get_all_details ( USERS, array (
					'id' => $this->checkLogin ( 'U' ) 
			) );
			$this->data ['membershipDetails'] = $this->product_model->get_membership_order_details ( $this->checkLogin ( 'U' ) );
			
			// print_r($this->data['membershipDetails']->result());die;
			$this->data ['membershipplan'] = $this->product_model->getMembershipPackage ();
			// echo $this->db->last_query();die;
			
			$this->load->view ( 'site/user/dashboard-plan', $this->data );
		}
	}
	public function dashboard_listing_requirement() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			$this->data ['heading'] = 'Dashboard-Listing Requirement';
			$this->data ['userDetail'] = $this->cms_model->get_all_details ( USERS, array (
					'id' => $this->checkLogin ( 'U' ) 
			) );
			$this->data ['RequestDetail'] = $this->cms_model->get_all_details ( REQUIREMENTS, array (
					'user_id' => $this->checkLogin ( 'U' ) 
			) );
			
			//echo $this->db->last_query();die;
			$this->load->view ( 'site/user/dashboard-listing-res-reqmt', $this->data );
		}
	}
	public function dashboard_trips() {
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			$keyword = "";
			if ($_POST) {
				$keyword = $this->input->post ('product_title');
			}
			$this->load->model('admin_model');
			$this->data ['heading'] = 'Dashboard-Trips';
			$this->data ['bookedRental'] = $this->cms_model->booked_rental_trip( $this->checkLogin ('U'), $keyword );
			$this->data ['login'] =$this->checkLogin ('U');
			//echo '<pre>'; print_r($this->data ['bookedRental']->result_array()); die;
			
			
			$this->load->view ( 'site/user/dashboard-trips', $this->data );
		}
	}
	public function dashboard_trips_prve() { 
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			
			if ($_POST) {
				$product_title = $this->input->post ( 'product_title' );
			}

			$this->data ['heading'] = 'Dashboard-Trips previous';
			$this->data ['bookedRental'] = $this->cms_model->booked_rental_trip_prev ( $this->checkLogin ( 'U' ), $product_title );
			//echo '<pre>'; print_r($this->data ['bookedRental']->result_array()); die;
			// echo $this->db->last_query();die;
			$this->load->view ( 'site/user/dashboard-trips-prev', $this->data );
		}
	}
	public function social_recommend_profile_search() {
		$update_field = $this->input->post ( 'update_field' );
		$update_value = $this->input->post ( 'update_value' );
		$dataArr = array (
				$update_field => $update_value 
		);
		$this->cms_model->commonInsertUpdate ( USERS, 'update', array (
				'update_field',
				'update_value' 
		), $dataArr, array (
				'id' => $this->checkLogin ( 'U' ) 
		) );
		echo 'yes'; // details updated successfully
	}
	public function contactus_businesstravel() {
		if ($this->uri->segment ( 1 ) == 'contact-us') {
				$this->data['cmscontactus'] = $this->cms_model->get_cmscontact_details();
				
			$this->load->view ( 'site/cms/contactus', $this->data );
		} else if ($this->uri->segment ( 1 ) == 'business-travel') {
			$this->data['SliderList'] = $this->slider_model->get_slider_details('WHERE status="Active"');
			$this->data['cmsbusinesstravel'] = $this->cms_model->get_cmsbusiness_details();
			//echo $this->data['cmsbusinesstravel']->row()->description;die;
			$this->load->view ( 'site/cms/business-travel', $this->data );
		}
	}
	public function contactus() {
		$name = $this->input->post ( 'name' );
		$email = $this->input->post ( 'email' );
		$subject = $this->input->post ( 'subject' );
		$message = $this->input->post ( 'msg' );
		// $security_code=$this->input->post ( 'security_code' );
		require_once './captcha/securimage.php';
		$securimage = new Securimage ();
		$captcha = $this->input->post ( 'ct_captcha' );
		if ($securimage->check ( $captcha ) == false) {
			// $generalDAO->setErrorMessage('error', 'Incorrect security code entered.');
			$this->setErrorMessage ( 'error', 'Incorrect security code entered.' );
			redirect ( 'contact-us' );
		} else {
			$dataArr = array (
					'name' => $name,
					'email' => $email,
					'subject' => $subject,
					'message' => $message
			)
			;
			$this->cms_model->simple_insert ( CONTACTUS, $dataArr );
			$newsid='20';
			$template_values=$this->product_model->get_newsletter_template_details($newsid);
			if($template_values['sender_name']=='' && $template_values['sender_email']==''){
				$sender_email=$this->data['siteContactMail'];
				$sender_name=$this->data['siteTitle'];
			}else{
				$sender_name=$template_values['sender_name'];
				$sender_email=$template_values['sender_email'];
			}
			$email_values = array('mail_type'=>'html',
					'from_mail_id'=>$this->input->post('email'),
					'to_mail_id'=> $sender_email,
					'subject_message'=>$this->input->post('subject'),
					'body_messages'=>$this->input->post('msg'),
			);
			//echo("<pre>");print_r($email_values);die;
			$email_send_to_common = $this->product_model->common_email_send($email_values);
			$this->setErrorMessage ( 'success', 'Your message sent successfully.' );
		}
		redirect ( 'contact-us' );
	}
	
	
	public function learnmore() {
		$this->data['cmslearnmore'] = $this->cms_model->get_cms_learnmore();
		//echo $this->db->last_query();die;
		//print_r($this->data['cmslearnmore']);die;
	$this->load->view ( 'site/cms/learnhost', $this->data );
	}
	
	public function howitwork() {
		
		$this->data['cmshowitwork'] = $this->cms_model->get_cms_details();
		//print_r($this->data['cmsList']);die;
	$this->load->view ( 'site/cms/howitwork', $this->data );
	
	$city=$this->input->post('city');
	
	}
	
	
	public function cancelmyaccount() {
	
	$user_id = $this->uri->segment(4);
	
	$condition = array('id'=>$user_id);
	$excludeArr = array();
    $dataArr = array('status'=>'Inactive');
	$this->cms_model->commonInsertUpdate(USERS,'update',$excludeArr,$dataArr,$condition);
	$this->setErrorMessage ( 'success', 'Your Account deactive successfully.' );
	redirect ('site/user/deactive_user');
	}
	
	/* Guide Approval fucntionality */
	
	public function guide_approval() {	
			$user_id = $this->uri->segment(4);
			$status = 'Accept';
			$newdata = array('approval' => $status);
			 $condition = array('id' => $user_id);			 
			$this->cms_model->update_details(RENTALENQUIRY,$newdata,$condition); 
			$this->guideapproval($user_id);
			$this->guideapprovalbyhost($user_id);
			$this->setErrorMessage('success','You have just confirmed a booking'); 
			redirect('listing-reservation');
	
	}
	
	
	public function guideapproval($id) {
	
	$this->data['detail'] = $this->cms_model->get_all_details(RENTALENQUIRY,array('id'=>$id));
	
	$this->data['userdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->user_id));
	
	
	$this->data['hostdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->renter_id));
	
	$this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT,array('id'=>$this->data['detail']->row()->prd_id));
	
	
	   $newsid = '23';
		$template_values = $this->cms_model->get_newsletter_template_details ($newsid);
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ('email_title' ),
				'logo' => $this->data ['logo'],
				'travelername'=>$this->data['userdetail']->row()->firstname."  ".$this->data['userdetail']->row()->lastname,
				'propertyname'=>$this->data['productdetail']->row()->product_title,
				'hostname'=>$this->data['hostdetail']->row()->firstname." ".$this->data['hostdetail']->row()->lastname
				
		);
		//echo '<pre>'; print_r($adminnewstemplateArr);
		//echo $propertyname; die;
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];
		
		$header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		
		$message .= '<body>';
		include ('./newsletter/registeration' . $newsid . '.php');
		
		$message .= '</body>';
		
		if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
			$sender_email = $this->config->item ( 'site_contact_mail' );
			$sender_name = $this->config->item ( 'email_title' );
		} else {
			$sender_name = $template_values ['sender_name'];
			$sender_email = $template_values ['sender_email'];
		}
		
		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $this->data['userdetail']->row()->email,				
				'subject_message' => $template_values ['news_subject'],
				'body_messages' => $message 
		);
		//echo '<pre>'; print_r($email_values);die;
					 
			$this->cms_model->common_email_send($email_values);
	
	
	}
	
	
	public function guideapprovalbyhost($id) {
	
	$this->data['detail'] = $this->cms_model->get_all_details(RENTALENQUIRY,array('id'=>$id));
	
	$this->data['userdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->user_id));
	
	
	$this->data['hostdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->renter_id));
	
	$this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT,array('id'=>$this->data['detail']->row()->prd_id));
	
	    //$newsid = '24';  local
		$newsid = '30';
		$template_values = $this->cms_model->get_newsletter_template_details ($newsid);
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ('email_title' ),
				'logo' => $this->data ['logo'],
				'travelername'=>$this->data['userdetail']->row()->firstname."  ".$this->data['userdetail']->row()->lastname,
				'propertyname'=>$this->data['productdetail']->row()->product_title,
				'hostname'=>$this->data['hostdetail']->row()->firstname." ".$this->data['hostdetail']->row()->lastname
				
		);
		//echo '<pre>'; print_r($adminnewstemplateArr);
		//echo $propertyname; die;
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];
		
		$header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		
		$message .= '<body>';
		include ('./newsletter/registeration' . $newsid . '.php');
		
		$message .= '</body>';
		
		if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
			$sender_email = $this->config->item ( 'site_contact_mail' );
			$sender_name = $this->config->item ( 'email_title' );
		} else {
			$sender_name = $template_values ['sender_name'];
			$sender_email = $template_values ['sender_email'];
		}
		
		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $this->data['hostdetail']->row()->email,				
				'subject_message' => $template_values ['news_subject'],
				'body_messages' => $message 
		);
		/* echo '<pre>'; print_r($adminnewstemplateArr);
		echo '<pre>'; print_r($email_values);die; */
					 
			$this->cms_model->common_email_send($email_values);
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function guide_decline() {	
			$user_id = $this->uri->segment(4);
			$status = 'Decline';
			$newdata = array('approval' => $status);
			 $this->guidedecline($user_id);
			 $this->guidedeclinebyuser($user_id);
			 $condition = array('id' => $user_id);
			$this->cms_model->update_details(RENTALENQUIRY,$newdata,$condition); 
			$this->setErrorMessage('success','You have just declined a booking');
			redirect('listing-reservation');
	
	}
	
	public function guidedecline($id) {
	
	$this->data['detail'] = $this->cms_model->get_all_details(RENTALENQUIRY,array('id'=>$id));
	
	$this->data['userdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->user_id));
	
	
	$this->data['hostdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->renter_id));
	
	$this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT,array('id'=>$this->data['detail']->row()->prd_id));
	
	
	   $newsid = '24';
		$template_values = $this->cms_model->get_newsletter_template_details ($newsid);
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ('email_title' ),
				'logo' => $this->data ['logo'],
				'travelername'=>$this->data['userdetail']->row()->firstname."  ".$this->data['userdetail']->row()->lastname,
				'propertyname'=>$this->data['productdetail']->row()->product_title,
				'hostname'=>$this->data['hostdetail']->row()->firstname." ".$this->data['hostdetail']->row()->lastname
				
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];
		
		$header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		
		$message .= '<body>';
		include ('./newsletter/registeration' . $newsid . '.php');
		
		$message .= '</body>';
		
		if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
			$sender_email = $this->config->item ( 'site_contact_mail' );
			$sender_name = $this->config->item ( 'email_title' );
		} else {
			$sender_name = $template_values ['sender_name'];
			$sender_email = $template_values ['sender_email'];
		}
		
		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $this->data['hostdetail']->row()->email,				
				'subject_message' => $template_values ['news_subject'],
				'body_messages' => $message 
		);
					 
			$this->cms_model->common_email_send($email_values);
	//'cc_mail_id' => $this->data['hostdetail']->row()->email,
	
	}
	
	
	
	public function guidedeclinebyuser($id) {
	
	$this->data['detail'] = $this->cms_model->get_all_details(RENTALENQUIRY,array('id'=>$id));
	
	$this->data['userdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->user_id));
	
	
	$this->data['hostdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->renter_id));
	
	$this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT,array('id'=>$this->data['detail']->row()->prd_id));
	
	
	   $newsid = '25';
		$template_values = $this->cms_model->get_newsletter_template_details ($newsid);
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ('email_title' ),
				'logo' => $this->data ['logo'],
				'travelername'=>$this->data['userdetail']->row()->firstname."  ".$this->data['userdetail']->row()->lastname,
				'propertyname'=>$this->data['productdetail']->row()->product_title,
				'hostname'=>$this->data['hostdetail']->row()->firstname." ".$this->data['hostdetail']->row()->lastname
				
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];
		
		$header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		
		$message .= '<body>';
		include ('./newsletter/registeration' . $newsid . '.php');
		
		$message .= '</body>';
		
		if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
			$sender_email = $this->config->item ( 'site_contact_mail' );
			$sender_name = $this->config->item ( 'email_title' );
		} else {
			$sender_name = $template_values ['sender_name'];
			$sender_email = $template_values ['sender_email'];
		}
		
		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $this->data['userdetail']->row()->email,				
				'subject_message' => $template_values ['news_subject'],
				'body_messages' => $message 
		);
					 
			$this->cms_model->common_email_send($email_values);
	
	
	}
	
	
	
	
	
	
	
	
	
	
/* Controller End */
}