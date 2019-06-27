<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * User related functions
 * @author Teamtweaks
 *
 */

class Order extends MY_Controller { 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('order_model');$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('contact_model');
		
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->order_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		
		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->order_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		
		$this->data['loginCheck'] = $this->checkLogin('U');
    }
    
  
	/**
	 * 
	 * Loading Order Page
	 */
	
	public function index(){
	     
		$this->data['heading'] = 'Order Confirmation'; 
		if($this->uri->segment(2) == 'success'){
						
			if($this->uri->segment(5)==''){
				$transId = $_REQUEST['txn_id'];
				$Pray_Email = $_REQUEST['payer_email'];
			}else{
				$transId = $this->uri->segment(5);
				$Pray_Email = '';
			}	
			
			$UserNo = $this->uri->segment(3);
			$DealCodeNo = $this->uri->segment(4);
				
			$PaymentSuccessCheck = $this->order_model->get_all_details(PAYMENT,array('user_id' => $UserNo, 'dealCodeNumber' => $DealCodeNo,'status'=>'Paid'));
			
			//echo '<pre>'; print_r($PaymentSuccessCheck->result_array());	
			
		//if($PaymentSuccessCheck->num_rows() == 0){
		
		
		
		$EnquiryUpdate = $this->order_model->get_all_details(PAYMENT,array('dealCodeNumber'=>$DealCodeNo));
		//echo "<pre>";print_r($EnquiryUpdate->result());die;	
		 $eprd_id = $EnquiryUpdate->row()->product_id;
		 $eInq_id = $EnquiryUpdate->row()->EnquiryId;
		 
		 
		 /******** coupon   *********/
		 
		 $coupon = $this->session->userdata('coupon_strip');
         $coupon = explode('-', $coupon);
		 
		 if($coupon['0'] != ''){
		 
		 $data = array('is_coupon_used' => 'Yes',
		               'discount_type' => $coupon['4'],
					   'coupon_code' => $coupon['0'],
					   'discount' => $coupon['2'],
					   'dval' => $coupon['1'],
					   'total_amt' => $coupon['3']
					  );

		 $this->session->unset_userdata('coupon_strip');
		 
		 $this->order_model->update_details(PAYMENT,$data,array('dealCodeNumber'=>$DealCodeNo));
		 $data = array('totalAmt' => $coupon['2']);
		 $this->order_model->update_details(RENTALENQUIRY,$data,array('id'=>$eInq_id));
		 
		 $data = array('code' => trim($coupon['0']));
		 $couponi = $this->order_model->get_all_details(COUPONCARDS,$data);
		 
		 
		 
		 $data = array('purchase_count' => $couponi->row()->purchase_count+1,
		               'card_status' => 'redeemed');
		 
		 

		 $this->order_model->update_details(COUPONCARDS,$data,array('id'=>$couponi->row()->id));
		}
		
		
		/******** coupon end  *************/
		
		$this->data['invoicedata'] = $this->order_model->get_all_details(RENTALENQUIRY,array('id'=>$eInq_id));		
		//print_r($this->data['invoicedata']->result_array());die;
		$condition1 = array('user_id'=>$UserNo,'prd_id'=>$eprd_id,'id'=>$eInq_id);
		$dataArr1 = array('booking_status'=>'Booked');
		
		$this->order_model->update_details(RENTALENQUIRY,$dataArr1,$condition1);
		//echo $this->db->last_query();
		//$this->order_model->commonInsertUpdate(RENTALENQUIRY,'update',$excludeArr1,$dataArr1,$condition1);					
								
		$this->data['Confirmation'] = $this->order_model->PaymentSuccess($this->uri->segment(3),$this->uri->segment(4),$transId,$Pray_Email);
									
		$SelBookingQty =$this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $eInq_id));
			
		//booking update
		$productId = $SelBookingQty->row()->prd_id;
		$arrival = $SelBookingQty->row()->checkin;
		$depature = $SelBookingQty->row()->checkout;
		$dates = $this->getDatesFromRange($arrival, $depature);
		$i=1;
		$dateMinus1= count($dates)-1; 
		
		foreach($dates as $date){
			if($i <= $dateMinus1){
				$BookingArr=$this->contact_model->get_all_details(CALENDARBOOKING,array('PropId' => $productId,'id_state' => 1,'id_item' => 1,'the_date' => $date));
				if($BookingArr->num_rows() > 0){
				
				}else{
					$dataArr = array('PropId' => $productId,
									 'id_state' => 1,
									 'id_item' => 1,
									 'the_date' => $date
									);
					$this->contact_model->simple_insert(CALENDARBOOKING,$dataArr);
				}
		   }
		   $i++;
		}
										
		//SCHEDULE calendar
		$DateArr=$this->product_model->get_all_details(CALENDARBOOKING,array('PropId'=>$productId));
		$dateDispalyRowCount=0;
		
		if($DateArr->num_rows > 0){
			$dateArrVAl .='{';
			foreach($DateArr->result() as $dateDispalyRow){
									
				if($dateDispalyRowCount==0){
					$dateArrVAl .='"'.$dateDispalyRow->the_date.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"booked"}';
				}else{
					$dateArrVAl .=',"'.$dateDispalyRow->the_date.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"booked"}';
				}
				$dateDispalyRowCount=$dateDispalyRowCount+1;
			}
			$dateArrVAl .='}';
		}
									
		$inputArr4=array();
		$inputArr4 = array('id' =>$productId,'data' => trim($dateArrVAl));
									
		$this->product_model->update_details(SCHEDULE,$inputArr4,array('id' =>$productId));
									
		//End SCHEDULE calendar
									//echo 'dscsdkcsdk';die;
		/*$condition=array('user_id'=>$user_ID);
		$dataArr = array( 'package_status' => "Paid");	
		$this->product_model->commonInsertUpdate(USERS,'update',array('user_id'),array( 'package_status' => "Paid"),array('id'=>$user_ID));*/
		$this->booking_conform_mail($DealCodeNo);
		$this->booking_conform_mail_admin($DealCodeNo);
		$this->booking_conform_mail_host($DealCodeNo);
		//die;							
		//Siva}
						
		$this->data['Confirmation'] = 'Success';
		$this->load->view('site/order/order.php',$this->data);
		
	}elseif($this->uri->segment(2) == 'failure'){
		$this->data['Confirmation'] = 'Failure';
		$this->data['errors'] = $this->uri->segment(3);
		$this->load->view('site/order/order.php',$this->data);
	}elseif($this->uri->segment(2) == 'notify'){
		$this->data['Confirmation'] = 'Failure';			
		$this->load->view('site/order/order.php',$this->data);
	}elseif($this->uri->segment(2) == 'confirmation'){
		$this->data['Confirmation'] = 'Success';
		$this->load->view('site/order/order.php',$this->data);
	}elseif($this->uri->segment(2) == 'pakagesuccess') {
		$this->memberPackageUpdate($this->uri->segment(3)); 
	}	
				
}		
	


	
	
	
	
	
		
		
		public function memberPackageUpdate($user_ID) {
		
		 $condition=array('user_id'=>$user_ID);
		 $dataArr = array( 'package_status' => "Paid");	
		 $this->product_model->commonInsertUpdate(USERS,'update',array('user_id'),array( 'package_status' => "Paid"),array('id'=>$user_ID));	 
		 $this->product_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,$dataArr,$condition);
		 $this->memberPackagePurchaseEmail($user_ID);
		 redirect(base_url('plan'));
		
		}
		
		public function memberPackagePurchaseEmail($user_ID) {
				$this->data['order_details'] = $this->product_model->get_membership_order_details($user_ID);
				$username=ucfirst($this->data['order_details']->row()->firstname).' '.ucfirst($this->data['order_details']->row()->lastname);
				$newsid='11';
		  		$template_values=$this->product_model->get_newsletter_template_details($newsid);
				$adminnewstemplateArr=array('logo'=> $this->data['logo'],'meta_title'=>$this->config->item('meta_title'),'username'=>$username,'packagename'=>ucfirst($this->data['order_details']->row()->name),'price'=>ucfirst($this->data['order_details']->row()->price),'valid_date'=>ucfirst($this->data['order_details']->row()->valid_date));
        extract($adminnewstemplateArr);
		$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
  		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>'.$template_values['news_subject'].'</title><body>';
		include('./newsletter/registeration'.$newsid.'.php');	
		
		$message .= '</body>
			</html>';
				
				
                if($template_values['sender_name']=='' && $template_values['sender_email']==''){
                    $sender_email=$this->data['siteContactMail'];
                    $sender_name=$this->data['siteTitle'];
                }else{
                    $sender_name=$template_values['sender_name'];
                    $sender_email=$template_values['sender_email'];
                }
				//add inbox from mail 
				$this->product_model->simple_insert(INBOX,array('sender_id'=>$sender_email,'user_id'=>$this->data['order_details']->row()->email,'mailsubject'=>$subject,'description'=>stripslashes($message)));
				
                $email_values = array('mail_type'=>'html',
                                    'from_mail_id'=>$sender_email,
                                    'mail_name'=>$sender_name,
									'to_mail_id'=>$this->data['order_details']->row()->email,
									'cc_mail_id'=>$sender_email,
									'subject_message'=>$subject,
									'body_messages'=>$message
									);
				$email_send_to_common = $this->product_model->common_email_send($email_values);
		
		
		}
		
		
public function booking_conform_mail($paymentid){

	$PaymentSuccess = $this->order_model->get_all_details(PAYMENT,array('dealCodeNumber' => $paymentid)); 
					
    $Renter_details = $this->order_model->get_all_details(USERS,array('id'=>$PaymentSuccess->row()->sell_id));
	//echo '<br>'.$this->db->last_query();
					//var_dump($Renter_details->row());die;
	//echo $PaymentSuccess->row()->user_id; die;
	$user_details = $this->order_model->get_all_details(USERS,array('id'=>$PaymentSuccess->row()->user_id));
					
	$Rental_details = $this->order_model->get_all_details(PRODUCT,array('id'=>$PaymentSuccess->row()->product_id));
    $Contact_details = $this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $PaymentSuccess->row()->EnquiryId));
	$RentalPhoto = $this->order_model->get_all_details(PRODUCT_PHOTOS,array('product_id'=>$PaymentSuccess->row()->product_id));
					
	//$total = $Renter_details->row()->price * $Contact_details->row()->numofdates;
	$total = $Contact_details->row()->totalAmt-$Contact_details->row()->serviceFee;
	
	//---------------email to user---------------------------
	$newsid='29';
	$template_values=$this->order_model->get_newsletter_template_details($newsid);
					
	$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
	$proImages=base_url().PRODUCTPATH.$RentalPhoto->row()->product_image;
	$chkIn = date('d-m-y',strtotime($Contact_details->row()->checkin));
	$chkOut = date('d-m-y',strtotime($Contact_details->row()->checkout));
	$adminnewstemplateArr=array(
				'email_title'=>$this->config->item('email_title'),
				'logo'=>$this->data['logo'],
				'first_name'=>$user_details->row()->firstname,
				'last_name'=>$user_details->row()->lastname,
				'NoofGuest'=>$Contact_details->row()->NoofGuest,
				'numofdates'=>$Contact_details->row()->numofdates,
				'booking_status'=>$Contact_details->row()->booking_status,
				'user_email'=>$user_details->row()->email,
				'ph_no'=>$Renter_details->row()->phone_no,
				'Enquiry'=>$Contact_details->row()->Enquiry,
				'checkin'=>$chkIn,
				'checkout'=>$chkOut,
				'price'=>$Renter_details->row()->price,
				'amount'=>$total,
				'netamount'=>$Contact_details->row()->totalAmt,
				'noofnights'=>$Contact_details->row()->numofdates,
				'serviceFee'=>$Contact_details->row()->serviceFee,
				'renter_id'=>$PaymentSuccess->row()->sell_id,
				'prd_id'=>$PaymentSuccess->row()->product_id,
				'renter_fname'=>$Renter_details->row()->firstname,
				'renter_lname'=>$Renter_details->row()->lastname,
				'owner_email'=>$Renter_details->row()->email,
				'owner_phone'=>$Renter_details->row()->phone_no,
				'rental_name'=>$Rental_details->row()->product_title,
				'rental_image'=>$proImages);
                    
                    
	extract($adminnewstemplateArr);

	$header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";
	
	$message .= '<!DOCTYPE HTML>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width"/><body>';
	
	
	include('./newsletter/registeration'.$newsid.'.php');	
	
	$message .= '</body>';
		
	
	if($template_values['sender_name']=='' && $template_values['sender_email']==''){
		$sender_email=$this->data['siteContactMail'];
		$sender_name=$this->data['siteTitle'];
	}else{
		$sender_name=$template_values['sender_name'];
		$sender_email=$template_values['sender_email'];
	}
	
	/*$sender_name=ucfirst($Renter_details->row()->first_name).' '.ucfirst($Renter_details->row()->last_name);
	$sender_email=$Renter_details->row()->email;*/
	//echo $PaymentSuccess->row()->user_id; die;
	//add inbox from mail 
	$this->order_model->simple_insert(INBOX,array('sender_id'=>$sender_email,'user_id'=>$PaymentSuccess->row()->user_id,'mailsubject'=>$template_values['news_subject'],'description'=>stripslashes($message)));
	$this->session->set_userdata('ContacterEmail',$user_details->row()->email);
	
	$email_values = array('mail_type'=>'html',
						'from_mail_id'=>$sender_email,
						'mail_name'=>$sender_name,
						'to_mail_id'=>$this->data['userDetails']->row()->email,
						'subject_message'=>$template_values['news_subject'],
						'body_messages'=>$message
						);
					//print_r(stripslashes($message));die;	
					
	//echo '<pre>'; print_r($email_values);					
	$email_send_to_common = $this->order_model->common_email_send($email_values);
	
	//$this->mail_owner_admin_booking($adminnewstemplateArr);
}	
	
public function booking_conform_mail_admin($paymentid){

	$PaymentSuccess = $this->order_model->get_all_details(PAYMENT,array('dealCodeNumber' => $paymentid)); 
					
	$condition = array('id'=>$PaymentSuccess->row()->sell_id);
	$Renter_details = $this->order_model->get_all_details(USERS,$condition);

	$condition3 = array('id'=>$PaymentSuccess->row()->user_id);
	$user_details = $this->order_model->get_all_details(USERS,$condition3);
	
	$condition1 = array('id'=>$PaymentSuccess->row()->product_id);
	$Rental_details = $this->order_model->get_all_details(PRODUCT,$condition1);
	$Contact_details = $this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $PaymentSuccess->row()->EnquiryId));
	$RentalPhoto = $this->order_model->get_all_details(PRODUCT_PHOTOS,array('product_id'=>$PaymentSuccess->row()->product_id));
					
	/* $total = $Renter_details->row()->price * $Contact_details->row()->numofdates; */
	$total = $Contact_details->row()->totalAmt-$Contact_details->row()->serviceFee;
		//---------------email to user---------------------------
	$newsid='33';
	$template_values=$this->order_model->get_newsletter_template_details($newsid);
	
	
	$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
	$proImages=base_url().PRODUCTPATH.$RentalPhoto->row()->product_image;
	$chkIn = date('d-m-y',strtotime($Contact_details->row()->checkin));
	$chkOut = date('d-m-y',strtotime($Contact_details->row()->checkout));
	$adminnewstemplateArr=array(
			'email_title'=>$this->config->item('email_title'),
			'logo'=>$this->data['logo'],
			'first_name'=>$user_details->row()->firstname,
			'last_name'=>$user_details->row()->lastname,
			'NoofGuest'=>$Contact_details->row()->NoofGuest,
			'numofdates'=>$Contact_details->row()->numofdates,
			'booking_status'=>$Contact_details->row()->booking_status,
			'user_email'=>$user_details->row()->email,
			'ph_no'=>$user_details->row()->phone_no,
			'Enquiry'=>$Contact_details->row()->Enquiry,
			'checkin'=>$chkIn,
			'checkout'=>$chkOut,
			'price'=>$Renter_details->row()->price,
			'amount'=>$total,
			'netamount'=>$Contact_details->row()->totalAmt,
			'noofnights'=>$Contact_details->row()->numofdates,
			'serviceFee'=>$Contact_details->row()->serviceFee,
			'renter_id'=>$PaymentSuccess->row()->sell_id,
			'prd_id'=>$PaymentSuccess->row()->product_id,
			'renter_fname'=>$Renter_details->row()->firstname,
			'renter_lname'=>$Renter_details->row()->lastname,
			'owner_email'=>$Renter_details->row()->email,
			'owner_phone'=>$Renter_details->row()->phone_no,
			'rental_name'=>$Rental_details->row()->product_title,
			'rental_image'=>$proImages);
	
	
	extract($adminnewstemplateArr);

	$header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";
	
	$message .= '<body>';
	
	
	include('./newsletter/registeration'.$newsid.'.php');	
	
	$message .= '</body>
		</html>';
	
	if($template_values['sender_name']=='' && $template_values['sender_email']==''){
		$sender_email=$this->data['siteContactMail'];
		$sender_name=$this->data['siteTitle'];
	}else{
		$sender_name=$template_values['sender_name'];
		$sender_email=$template_values['sender_email'];
	}
	
	/* $sender_name=ucfirst($Renter_details->row()->first_name).' '.ucfirst($Renter_details->row()->last_name);
	$sender_email=$Renter_details->row()->email; */
	
	//add inbox from mail 
	$this->order_model->simple_insert(INBOX,array('sender_id'=>$sender_email,'user_id'=>$PaymentSuccess->row()->user_id,'mailsubject'=>$template_values['news_subject'],'description'=>stripslashes($message)));
	$this->session->set_userdata('ContacterEmail',$user_details->row()->email);
	
	$email_values = array('mail_type'=>'html',
						'from_mail_id'=>$sender_email,
						'mail_name'=>$sender_name,
						'to_mail_id'=>$sender_email,
						'subject_message'=>$template_values['news_subject'],
						'body_messages'=>$message
						);
	//echo '<pre>'; print_r($email_values);			
	$email_send_to_common = $this->order_model->common_email_send($email_values);

					//$this->mail_owner_admin_booking($adminnewstemplateArr);
}


public function booking_conform_mail_host($paymentid){
	$PaymentSuccess = $this->order_model->get_all_details(PAYMENT,array('dealCodeNumber' => $paymentid));
					
	$condition = array('id'=>$PaymentSuccess->row()->sell_id);
	$Renter_details = $this->order_model->get_all_details(USERS,$condition);
	$condition = array('id'=>$PaymentSuccess->row()->sell_id);
	$Renter_email = $this->order_model->get_all_details(USERS,$condition);


	$condition3 = array('id'=>$PaymentSuccess->row()->user_id);
	$user_details = $this->order_model->get_all_details(USERS,$condition3);
					
					
	$condition1 = array('id'=>$PaymentSuccess->row()->product_id);
	$Rental_details = $this->order_model->get_all_details(PRODUCT,$condition1);
	$Contact_details = $this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $PaymentSuccess->row()->EnquiryId));
	$RentalPhoto = $this->order_model->get_all_details(PRODUCT_PHOTOS,array('product_id'=>$PaymentSuccess->row()->product_id));
	
	/* $total = $Renter_details->row()->price * $Contact_details->row()->numofdates; */
	$total = $Contact_details->row()->totalAmt-$Contact_details->row()->serviceFee;
		//---------------email to user---------------------------
	$newsid='34';
	$template_values=$this->order_model->get_newsletter_template_details($newsid);
	
	
	$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
	$proImages=base_url().PRODUCTPATH.$RentalPhoto->row()->product_image;
	$chkIn = date('d-m-y',strtotime($Contact_details->row()->checkin));
	$chkOut = date('d-m-y',strtotime($Contact_details->row()->checkout));
	$adminnewstemplateArr=array(
			'email_title'=>$this->config->item('email_title'),
			'logo'=>$this->data['logo'],
			'first_name'=>$user_details->row()->firstname,
			'last_name'=>$user_details->row()->lastname,
			'NoofGuest'=>$Contact_details->row()->NoofGuest,
			'numofdates'=>$Contact_details->row()->numofdates,
			'booking_status'=>$Contact_details->row()->booking_status,
			'user_email'=>$user_details->row()->email,
			'ph_no'=>$user_details->row()->phone_no,
			'Enquiry'=>$Contact_details->row()->Enquiry,
			'checkin'=>$chkIn,
			'checkout'=>$chkOut,
			'price'=>$Renter_details->row()->price,
			'amount'=>$total,
			'netamount'=>$Contact_details->row()->totalAmt,
			'noofnights'=>$Contact_details->row()->numofdates,
			'serviceFee'=>$Contact_details->row()->serviceFee,
			'renter_id'=>$PaymentSuccess->row()->sell_id,
			'prd_id'=>$PaymentSuccess->row()->product_id,
			'renter_fname'=>$Renter_details->row()->firstname,
			'renter_lname'=>$Renter_details->row()->lastname,
			'owner_email'=>$Renter_details->row()->email,
			'owner_phone'=>$Renter_details->row()->phone_no,
			'rental_name'=>$Rental_details->row()->product_title,
			'rental_image'=>$proImages);
	
	
	extract($adminnewstemplateArr);

	$header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";
	
	$message .= '<!DOCTYPE HTML>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width"/><body>';
	
	
	include('./newsletter/registeration'.$newsid.'.php');	
	
	$message .= '</body>
		</html>';
	
	if($template_values['sender_name']=='' && $template_values['sender_email']==''){
		$sender_email=$this->data['siteContactMail'];
		$sender_name=$this->data['siteTitle'];
	}else{
		$sender_name=$template_values['sender_name'];
		$sender_email=$template_values['sender_email'];
	}
	
	/* $sender_name=ucfirst($Renter_details->row()->first_name).' '.ucfirst($Renter_details->row()->last_name);
	$sender_email=$Renter_details->row()->email; */
	
	//add inbox from mail 
	$this->order_model->simple_insert(INBOX,array('sender_id'=>$sender_email,'user_id'=>$PaymentSuccess->row()->user_id,'mailsubject'=>$template_values['news_subject'],'description'=>stripslashes($message)));
	$this->session->set_userdata('ContacterEmail',$user_details->row()->email);
	
	$email_values = array('mail_type'=>'html',
						'from_mail_id'=>$sender_email,
						'mail_name'=>$sender_name,
						'to_mail_id'=>$Renter_email->row()->email,
						'subject_message'=>$template_values['news_subject'],
						'body_messages'=>$message
						);
	//echo '<pre>'; print_r($email_values);				
	$email_send_to_common = $this->order_model->common_email_send($email_values);
					
					//$this->mail_owner_admin_booking($adminnewstemplateArr);
}		
		
	








public function mail_owner_admin_booking($got_values)
			{//print_r($got_values);die;
			
					
			
					//email to admin
					$header='';
					$adminnewstemplateArr=array();
					$subject='';
					$cfmurl='';
					$sender_email='';
					$sender_name='';
					$newsid='9';
					$template_values=$this->order_model->get_newsletter_template_details($newsid);
					
					$adminnewstemplateArr=array('email_title'=> $this->config->item('email_title'),
												'logo'=> $this->data['logo']
												);
												
					extract($adminnewstemplateArr);
					extract($got_values);
					
					$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
					$header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";
					
					$message .= '<!DOCTYPE HTML>
						<html>
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						<meta name="viewport" content="width=device-width"/><body>';
					include('./newsletter/registeration'.$newsid.'.php');	
					
					$message .= '</body>
						</html>';
						
					if($template_values['sender_name']=='' && $template_values['sender_email']=='')
						{
							$sender_email=$this->data['siteContactMail'];
							$sender_name=$this->data['siteTitle'];
						}
					else
						{
							$sender_name=$template_values['sender_name'];
							$sender_email=$template_values['sender_email'];
						}
					
					//add inbox from mail 
					$this->order_model->simple_insert(INBOX,array('sender_id'=>$this->session->userdata('ContacterEmail'),'user_id'=>$sender_email,'mailsubject'=>$template_values['news_subject'],'description'=>stripslashes($message)));
					$email_values2 = array('mail_type'=>'html',
										'from_mail_id'=>$sender_email,
										'mail_name'=>$sender_email,
										'to_mail_id'=>$sender_email,
										'subject_message'=>$template_values['news_subject'],
										'body_messages'=>$message
										);
					$email_send_to_common1 = $this->order_model->common_email_send($email_values2);
					
					
					//Email to owner
					
					if($got_values['renter_id'] > 0)
						{
							$UserDetails = $this->user_model->get_all_details(USERS,array('id'=>$got_values['renter_id']));
							$emailid=$UserDetails->row()->email;
							$this->order_model->simple_insert(INBOX,array('sender_id'=>$this->session->userdata('ContacterEmail'),'user_id'=>$emailid,'mailsubject'=>$template_values['news_subject'],'description'=>stripslashes($message)));
							$email_values = array('mail_type'=>'html',
												'from_mail_id'=>$sender_email,
												'mail_name'=>$sender_name,
												'to_mail_id'=>$emailid,
												'subject_message'=>$template_values['news_subject'],
												'body_messages'=>$message
												);
							//echo"admin<pre>"; print_r($email_values2);echo "<br>";
							//echo"owner"; print_r($email_values); die;
							$this->session->unset_userdata('ContacterEmail');
							$email_send_to_common = $this->order_model->common_email_send($email_values);
						}
						
						//echo '<pre>';print_r($email_values);die;
			}
	
	public function ipnpayment(){

		mysql_query('CREATE TABLE IF NOT EXISTS '.TRANSACTIONS.' ( `id` int(255) NOT NULL AUTO_INCREMENT,`payment_cycle` varchar(500) NOT NULL,`txn_type` varchar(500) NOT NULL, `last_name` varchar(500) NOT NULL,`next_payment_date` varchar(500) NOT NULL, `residence_country` varchar(500) NOT NULL, `initial_payment_amount` varchar(500) NOT NULL, `currency_code` varchar(500) NOT NULL, `time_created` varchar(500) NOT NULL, `verify_sign` varchar(750) NOT NULL, `period_type` varchar(500) NOT NULL, `payer_status` varchar(500) NOT NULL, `test_ipn` varchar(500) NOT NULL, `tax` varchar(500) NOT NULL, `payer_email` varchar(500) NOT NULL, `first_name` varchar(500) NOT NULL, `receiver_email` varchar(500) NOT NULL, `payer_id` varchar(500) NOT NULL, `product_type` varchar(500) NOT NULL, `shipping` varchar(500) NOT NULL, `amount_per_cycle` varchar(500) NOT NULL, `profile_status` varchar(500) NOT NULL, `charset` varchar(500) NOT NULL, `notify_version` varchar(500) NOT NULL, `amount` varchar(500) NOT NULL, `outstanding_balance` varchar(500) NOT NULL, `recurring_payment_id` varchar(500) NOT NULL, `product_name` varchar(500) NOT NULL,`custom_values` varchar(500) NOT NULL, `ipn_track_id` varchar(500) NOT NULL, `tran_date` datetime NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;');

		mysql_query("insert into ".TRANSACTIONS." set  payment_cycle='".$_REQUEST['payment_cycle']."', txn_type='".$_REQUEST['txn_type']."', last_name='".$_REQUEST['last_name']."',
next_payment_date='".$_REQUEST['next_payment_date']."', residence_country='".$_REQUEST['residence_country']."', initial_payment_amount='".$_REQUEST['initial_payment_amount']."',
currency_code='".$_REQUEST['currency_code']."', time_created='".$_REQUEST['time_created']."', verify_sign='".$_REQUEST['verify_sign']."', period_type= '".$_REQUEST['period_type']."', payer_status='".$_REQUEST['payer_status']."', test_ipn='".$_REQUEST['test_ipn']."', tax='".$_REQUEST['tax']."', payer_email='".$_REQUEST['payer_email']."', first_name='".$_REQUEST['first_name']."', receiver_email='".$_REQUEST['receiver_email']."', payer_id='".$_REQUEST['payer_id']."', product_type='".$_REQUEST['product_type']."', shipping='".$_REQUEST['shipping']."', amount_per_cycle='".$_REQUEST['amount_per_cycle']."', profile_status='".$_REQUEST['profile_status']."', charset='".$_REQUEST['charset']."',
notify_version='".$_REQUEST['notify_version']."', amount='".$_REQUEST['amount']."', outstanding_balance='".$_REQUEST['payment_status']."', recurring_payment_id='".$_REQUEST['txn_id']."', product_name='".$_REQUEST['product_name']."', custom_values ='".$_REQUEST['custom']."', ipn_track_id='".$_REQUEST['ipn_track_id']."', tran_date=NOW()");


		$this->data['heading'] = 'Order Confirmation'; 

		if($_REQUEST['payment_status'] == 'Completed'){
			$newcustom = explode('|',$_REQUEST['custom']);
	
			if($newcustom[0]=='Product'){
				$userdata = array('fc_session_user_id' => $newcustom[1],'randomNo' => $newcustom[2]);
				$this->session->set_userdata($userdata);	
				$transId = $_REQUEST['txn_id'];
				$Pray_Email = $_REQUEST['payer_email'];
				$this->data['Confirmation'] = $this->order_model->PaymentSuccess($newcustom[1],$newcustom[2],$transId,$Pray_Email);	
				//$userdata = array('fc_session_user_id' => $newcustom[1],'randomNo' => $newcustom[2]);
				$this->session->unset_userdata($userdata);
			}elseif($newcustom[0]=='Gift'){
				$userdata = array('fc_session_user_id' => $newcustom[1]);
				$this->session->set_userdata($userdata);
				$transId = $_REQUEST['txn_id'];
				$Pray_Email = $_REQUEST['payer_email'];
				$this->data['Confirmation'] = $this->order_model->PaymentGiftSuccess($newcustom[1],$transId,$Pray_Email);	
				//$userdata = array('fc_session_user_id' => $newcustom[1]);
				$this->session->unset_userdata($userdata);
			}

		}	
			
	}
	
	
	public function insert_product_comment(){
	 			$uid= $this->checkLogin('U');
				$returnStr['status_code'] = 0;
				$comments = $this->input->post('comments');
				$product_id = $this->input->post('cproduct_id');
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time();
				$conditionArr = array('comments'=>$comments,'user_id'=>$uid,'product_id'=>$product_id,'status'=>'InActive','dateAdded'=>mdate($datestring,$time));
				$this->order_model->simple_insert(PRODUCT_COMMENTS,$conditionArr);
				$cmtID = $this->order_model->get_last_insert_id();
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time();
				$createdTime = mdate($datestring,$time);
				$actArr = array(
					'activity'		=>	'own-product-comment',
					'activity_id'	=>	$product_id,
					'user_id'		=>	$this->checkLogin('U'),
					'activity_ip'	=>	$this->input->ip_address(),
					'created'		=>	$createdTime,
					'comment_id'	=> $cmtID
				);
				$this->order_model->simple_insert(NOTIFICATIONS,$actArr);
				$this->send_comment_noty_mail($cmtID,$product_id);
				$returnStr['status_code'] = 1;
				echo json_encode($returnStr);
	}
	
	public function send_comment_noty_mail($cmtID='0',$pid='0'){
		if ($this->checkLogin('U')!=''){
			if ($cmtID != '0' && $pid != '0'){
				$productUserDetails = $this->product_model->get_product_full_details($pid);
				if ($productUserDetails->num_rows()==1){
					$emailNoty = explode(',', $productUserDetails->row()->email_notifications);
					if (in_array('comments', $emailNoty)){
						$commentDetails = $this->product_model->view_product_comments_details('where c.id='.$cmtID);
						if ($commentDetails->num_rows() == 1){
							if ($productUserDetails->prodmode == 'seller'){
								$prodLink = base_url().'things/'.$productUserDetails->row()->id.'/'.url_title($productUserDetails->row()->product_name,'-');
							}else {
								$prodLink = base_url().'user/'.$productUserDetails->row()->user_name.'/things/'.$productUserDetails->row()->seller_product_id.'/'.url_title($productUserDetails->row()->product_name,'-');
							}
							
							$newsid='1';
							$template_values=$this->order_model->get_newsletter_template_details($newsid);
							$adminnewstemplateArr=array('email_title'=> $this->config->item('email_title'),'logo'=> $this->data['logo'],'full_name'=>$commentDetails->row()->full_name,'product_name'=>$productUserDetails->row()->product_name,'user_name'=>$commentDetails->row()->user_name);
							extract($adminnewstemplateArr);
							$subject = $this->config->item('email_title').' - '.$template_values['news_subject'];
							
							$message .= '<!DOCTYPE HTML>
								<html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
								<meta name="viewport" content="width=device-width"/>
								<title>'.$template_values['news_subject'].'</title>
								<body>';
							include('./newsletter/registeration'.$newsid.'.php');	
							
							$message .= '</body>
								</html>';
							
							if($template_values['sender_name']=='' && $template_values['sender_email']==''){
								$sender_email=$this->data['siteContactMail'];
								$sender_name=$this->data['siteTitle'];
							}else{
								$sender_name=$template_values['sender_name'];
								$sender_email=$template_values['sender_email'];
							}
							
							//add inbox from mail 
							$this->order_model->simple_insert(INBOX,array('user_id'=>$productUserDetails->row()->email,'sender_id'=>$sender_email,'mailsubject'=>$subject,'description'=>stripslashes($message)));
							
							$email_values = array('mail_type'=>'html',
												'from_mail_id'=>$sender_email,
												'mail_name'=>$sender_name,
												'to_mail_id'=>$productUserDetails->row()->email,
												'subject_message'=>$subject,
												'body_messages'=>$message
												);
							$email_send_to_common = $this->product_model->common_email_send($email_values);
						}
					}
				}
			}
		}
	}
	
	public function getDatesFromRange($start, $end){
    	$dates = array($start);
    	while(end($dates) < $end){
        	$dates[] = date('Y-m-d', strtotime(end($dates).' +1 day'));
    	}
		return $dates;
	}	
	
	
	
}  /* Main controller end */

