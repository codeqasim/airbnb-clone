<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * User related functions
 * @author Teamtweaks
 *
 */

class Product extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email','text','html'));
		$this->load->library(array('encrypt','form_validation','image_lib','upload','session','resizeimage'));
		$this->load->model('product_model');
$this->load->model('contact_model');		
		$this->load->model(array('product_model','user_model','review_model','cms_model'));
		
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->product_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		
		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->product_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
		$ListingStepsArr=array('manage_listing','price_listing','overview_listing','photos_listing','amenities_listing','address_listing','space_listing','detail_list','cancel_policy');
		//echo $this->uri->segment(1,0);
	 	if ($this->data['loginCheck'] != ''){
	 		$this->data['likedProducts'] = $this->product_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
			
			//print_r($ListingStepsArr);die;
			if(in_array($this->uri->segment(1,0),$ListingStepsArr)){
			
				$id = $this->uri->segment(2,0);
				$this->data['Steps_title'] = $this->product_model->get_selected_fields_records('id',PRODUCT,' where id='.$id.' and product_title =""');
				$this->data['Steps_price'] = $this->product_model->get_selected_fields_records('id',PRODUCT,' where id='.$id.' and price ="0.00"');
				//echo $this->db->last_query();die;
				$this->data['Steps_calendar'] = $this->product_model->get_selected_fields_records('id',PRODUCT_BOOKING,' where product_id='.$id.' and datefrom ="0000-00-00" and dateto="0000-00-00"');
				//echo $this->db->last_query();die;
				$this->data['Steps_img'] = $this->product_model->get_selected_fields_records('id',PRODUCT_PHOTOS,' where product_id='.$id);
				$this->data['Steps_ament'] = $this->product_model->get_selected_fields_records('id',PRODUCT,' where id='.$id.' and list_name =""');
				$this->data['Steps_address'] = $this->product_model->get_selected_fields_records('id,zip,street',PRODUCT_ADDRESS_NEW,' where productId='.$id);
				
				$this->data['Steps_list'] = $this->product_model->get_selected_fields_records('id',PRODUCT,' where id='.$id.' and listings =""');
				
				$this->data['Steps_cancel'] = $this->product_model->get_selected_fields_records('id',PRODUCT,' where id='.$id.' and cancellation_policy =""'); 
				
				$this->data['calendar_shedule'] = $this->product_model->get_selected_fields_records('data','schedule',' where id='.$id.'');
				
				if($this->data['Steps_title']->num_rows() > 0){
					$this->data['Steps_count1']=1;
				}
				if($this->data['Steps_price']->num_rows() > 0){
		
					$this->data['Steps_count2']=1;
				}
				if($this->data['Steps_calendar']->num_rows() > 0){
					$this->data['Steps_count3']=1;
				}
				if($this->data['Steps_img']->num_rows() > 0){
				
				}else{
					$this->data['Steps_count4']=1;
				}
				if($this->data['Steps_ament']->num_rows() > 0){
					$this->data['Steps_count5']=1;
				}
				if($this->data['Steps_address']->num_rows() > 0 && $this->data['Steps_address']->row()->zip != '' || $this->data['Steps_address']->row()->street != '' ){
				
				}else{
					$this->data['Steps_count6']=1;
				}
				if($this->data['Steps_list']->num_rows() > 0){
					$this->data['Steps_count7']=1;
				}
				if($this->data['Steps_cancel']->num_rows() > 0){
					$this->data['Steps_count8']=1;
				}
				
				$this->data['Steps_tot']=$this->data['Steps_count1']+$this->data['Steps_count2']+$this->data['Steps_count3']+$this->data['Steps_count4']+$this->data['Steps_count5']+$this->data['Steps_count6']+$this->data['Steps_count7']+$this->data['Steps_count8'];
			}
			
			$this->data ['hosting_commission_status']=$this->product_model->get_all_details(COMMISSION,array('commission_type'=>'Host Listing'));		
	 	}
    }
	
	
	
	 public function dragimageuploadinsert()
		{
			$val = $this->uri->segment(4,0);
			$this->data['prod_id']=$val;
			
			$this->load->view('site/product/dragndrop',$this->data);
			//$this->load->view('site/product/photos_listing');
		}
	
	
	
	
	 public function InsertProductImage() {
	 
	 
	  $prd_id = $this->input->post('prdiii');
	  
	  
	    if(isset($_FILES['support_images']['name']) && !empty($_FILES['support_images']['name']))
	        {
	          
				$file_name_all="";
	            for($i=0; $i<count($_FILES['support_images']['name']); $i++) 
	            {
	                  
					   $tmpFilePath = $_FILES['support_images']['tmp_name'][$i];    
	                   if ($tmpFilePath != "")
	                   {    
	                       $path = "server/php/rental/";
	                       $name = $_FILES['support_images']['name'][$i];
	                       $size = $_FILES['support_images']['size'][$i];
	       
	                       list($txt, $ext) = explode(".", $name);
	                       //$file= time().substr(str_replace(" ", "_", $txt), 0);
						   $file= substr(str_replace(" ", "_", $txt), 0);
	                       $info = pathinfo($file);
	                       $filename = time().$file.".".$ext;
						   
						   if(move_uploaded_file($_FILES['support_images']['tmp_name'][$i], $path.$filename)) 
	                       { 
	                          date_default_timezone_set ("Asia/Calcutta");
	                          $currentdate=date("d M Y");
	                          $file_name_all.=$filename.",";
	                       }
						   
					@copy('server/php/rental/'.$filename,'server/php/rental/thumbnail/'.$filename);
                       
					   if (!$this->imageResizeWithSpace(300, 200, $_FILES['support_images']['tmp_name'][$i], 'server/php/rental/thumbnail/'))
                       {
                               //$error = array('error' => $this->upload->display_errors());
                       }
                       else
                       {
                               $sliderUploadedData = array($this->upload->data());
                       } 
	                 }
	            }
	            $filepath = rtrim($file_name_all, ','); //imagepath if it is present    
	        }
	        else
	        {
	            $filepath="";
	        }
			//print_r($filepath); die;
			
			if($filepath!= "") {
			
			$filepath = explode(",",$filepath);			
			$prd_id = $this->input->post('prdiii'); print_r($prd_id); 
			//$img_nameurl = $this->input->post('imgUploadUrl');
			//$img_name =$this->input->post('imgUpload');	
			
					
			for($i=0;$i<count($filepath);$i++) {				
				$filePRoductUploadData = array('product_id'=>$prd_id,'product_image'=>$filepath[$i]);
			    $this->product_model->simple_insert(PRODUCT_PHOTOS,$filePRoductUploadData);
		    }
			
			}
			redirect('photos_listing/'.$prd_id);
			
			
			
			
			
			
			
			
			
			
			
			
/*		$imageName = @implode(',',$this->input->post('support_images'));
		$imageNameNew = @explode(',',$imageName);
		
		$s=0;
		foreach($this->input->post('imgUploadUrl') as $imgUrl){

				//echo '<br>'.$imgUrl.$imageNameNew[$s]; die;
				copy($imgUrl, './images/product/rentals/'.$imageNameNew[$s]);
				unlink('server/php/files/'.$imageNameNew[$s]);
				unlink('server/php/files/thumbnail/'.$imageNameNew[$s]);
			$s++;
		}
		
		
		    $prd_id = $this->input->post('prod_id');
			$img_nameurl = $this->input->post('imgUploadUrl');
			$img_name =$this->input->post('imgUpload');			
			for($i=0;$i<count($img_name);$i++) {				
				$filePRoductUploadData = array('product_id'=>$prd_id,'product_image'=>$img_name[$i]);
			    $this->product_model->simple_insert(PRODUCT_PHOTOS,$filePRoductUploadData);
			
				
			}
*/		
		
		
		/*$s=0;
		foreach($this->input->post('imgUploadUrl') as $imgUrl){

				//echo '<br>'.$imgUrl.$imageNameNew[$s];
				copy($imgUrl, './images/product/rentals'.$imageNameNew[$s]);
				unlink('server/php/files/'.$imageNameNew[$s]);
				unlink('server/php/files/thumbnail/'.$imageNameNew[$s]);
			$s++;
		}*/
		
		 
	 }
	
	
	
	/* image uploaded function added by muhammed 26-11-2014 */
		
	public function ajaxImageUpload() {
		
	//print_r('jose');die;
	
	echo $prd_id = $this->input->post('prd_id');
	
	$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	
    //$uploaddir = "uploads/";
    $uploaddir = "server/php/rental/";	//a directory inside
    foreach ($_FILES['photos']['name'] as $name => $value)
    {
		
        $filename = stripslashes($_FILES['photos']['name'][$name]);
		$size=filesize($_FILES['photos']['tmp_name'][$name]);
		$width_height = getimagesize($_FILES['photos']['tmp_name'][$name]);
        //get the extension of the file in a lower case format
        $ext = $this->getExtension($filename);
        $ext = strtolower($ext);
     	if( $width_height[0] > 100)
		{
		if(in_array($ext,$valid_formats))
        {
		  if ($size > 0)
	       {
			$renameArr = explode('.', $filename);
			$imgTitle = strtolower($renameArr[0]);
			$imgTitle = mysql_real_escape_string($imgTitle);
			$imgTitle = trim($imgTitle);
			$imgTitle = str_replace("'","",$imgTitle);
			$imgTitle = str_replace("&","",$imgTitle);
			$imgTitle = str_replace("'","",$imgTitle);
			$imgTitle = @ereg_replace("[^A-Za-z0-9]", " ", $imgTitle);
			$imgTitle = preg_replace( "/\s+/", " ", $imgTitle);
			$imgTitle = str_replace(" ","-", $imgTitle);
			$filename = $imgTitle.'.'.$ext;
			$image_name=$filename;
			echo "<img src='".$uploaddir.$image_name."' class='imgList'>";
		  
			$newname=$uploaddir.$image_name;
			if (move_uploaded_file($_FILES['photos']['tmp_name'][$name], $newname)) 
			{
				$this->watermarkimages($uploaddir,$image_name);
				@copy($filename, './server/php/rental/mobile/'.$filename);
				$target_file=$uploaddir.$image_name;
				$imageName=$filename; 
				$option=$this->getImageShape(500,350,$target_file);
				$renameArr = explode('.', $imageName);
				$newName = $renameArr[0].'.jpg';
				$resizeObj = new Resizeimage($target_file);	
				$resizeObj -> resizeImage(500, 350, $option);
				$resizeObj -> saveImage($uploaddir.'mobile/'.$newName, 100);
				$this->ImageCompress($uploaddir.'mobile/'.$newName);
				@copy($uploaddir.'mobile/'.$newName, $uploaddir.'mobile/'.$newName);
			// echo "INSERT INTO fc_rental_photos(product_image,product_id) VALUES('$image_name','$prd_id')"; die;
				mysql_query("INSERT INTO fc_rental_photos(product_image,product_id) VALUES('$image_name','$prd_id')");
				
			}
			else
			{
				echo '<span class="imgList">You have exceeded the size limit! so moving unsuccessful! </span>';
            }
		}
		else
		{
			echo '<span class="imgList">You have exceeded the size limit!</span>';
        }
       }
       else
       { 
	   	echo "<script> alert('invalid')</script>";
       }
	}
	else
	{
		echo "<script>alert('Please Choose High Resolution image'); window.location = 'photos_listing/.$prd_id';</script>";
	}
   }
}

	}
	
	
	
	public function getExtension($str)
{
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}
	
	
	
	
	public function Rental_photoDelete() {
	if($this->data['loginCheck'] !=''){
			$product_id=$this->uri->segment(4,0);
			$this->product_model->commonDelete(PRODUCT_PHOTOS,array('id' => $product_id));
			
			
			
			$this->setErrorMessage('success','Rental Images Deleted Successfully');
			redirect('site/product/photos_listing/'.$product_id);
	}
	}
	
	
	
	
	
	public function saveOverviewListDesc() {
		
		
				if ($this->checkLogin('U') != '')
				{
				    $catID = $this->input->post('catID');
					$description = $this->input->post('title');
					$this->product_model->update_details(PRODUCT,array('description'=>$description),array('id'=>$catID));
					//print_r($this->db->query('SELECT * FROM  `fc_product` WHERE `id` =149')->row());
//echo $this->db->last_query();					
					
				}
		
	}
	
	public function edit_enquiry_details() {
		
				 /* update message board */
				 $excludeArr = array('rental_id','caltophone','Enquiry','phone_no',enquiry_timezone,'caltophone');
				 $dataArr = array('user_id'=>$this->checkLogin('U'),'guide_id'=>$this->input->post('guide_id'),'message'=>$this->input->post('Enquiry'));
				 $condition =array();
				 
				 $this->product_model->commonInsertUpdate(INBOXNEW,'insert',$excludeArr,$dataArr,$condition);
				
				
				
				
				 
				    $rental_id = $this->input->post('rental_id');$caltophone = $this->input->post('caltophone');
					$Enquiry = $this->input->post('Enquiry');
					$phone_no = $this->input->post('phone_no');
					$enquiry_timezone = $this->input->post('enquiry_timezone');
					$caltophone = $this->input->post('caltophone');
					
					
					
					$this->product_model->update_details(RENTALENQUIRY,array('Enquiry'=>$Enquiry,'caltophone'=>$caltophone,'phone_no'=>$phone_no,'enquiry_timezone'=>$enquiry_timezone),array('id'=>$this->session->userdata('EnquiryId')));	
					
					$res['id']='1';
					
					echo json_encode($res);
					
				
		
	}
	
	
	public function saveOverviewtitle()
		{
			if ($this->checkLogin('U') != '')
				{
					$catID = $this->input->post('catID');
					$title = $this->input->post('title');
					$seourl = url_title($title, '-', TRUE);	
					$this->product_model->update_details(PRODUCT,array('product_title'=>$title,'seourl'=>$seourl),array('id'=>$catID));
				}
		}
	
	
	
	
		public function saveDetailPage()
		{
			if ($this->checkLogin('U') != '')
				{
					$catID = $this->input->post('catID');
					
					$title = $this->input->post('title');
					$chk= $this->input->post('chk');
					$this->product_model->update_details(PRODUCT,array($chk=>$title),array('id'=>$catID));
					
		  if($chk == 'price'){			
			$product_id = $this->input->post('catID');
			$DateUpdateCheck = $this->product_model->get_all_details(PRODUCT_BOOKING,array('product_id'=>$product_id));
				
				if($DateUpdateCheck->num_rows() == '1'){
$DateArr=$this->GetDays($DateUpdateCheck->row()->datefrom, $DateUpdateCheck->row()->dateto); 
						$dateDispalyRowCount=0;
						if(!empty($DateArr)){
							$dateArrVAl .='{';
							foreach($DateArr as $dateDispalyRow){
							
								if($dateDispalyRowCount==0){
								
									$dateArrVAl .='"'.$dateDispalyRow.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$title.'","promo":"","status":"available"}';
								}else{
									$dateArrVAl .=',"'.$dateDispalyRow.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$title.'","promo":"","status":"available"}';
								}
								$dateDispalyRowCount=$dateDispalyRowCount+1;
							}
							$dateArrVAl .='}';
						}
						$inputArr4=array();
						$inputArr4 = array(
									'id' =>$product_id,
									'data' => trim($dateArrVAl)
						);
						$this->product_model->update_details(SCHEDULE,$inputArr4,array('id'=>$product_id));
						
					}
				}
				
			}
		}
		
		public function saveDetailPage_old()
		{
		
				echo $this->input->post();die;
			
					$catID = $this->input->post('catID');
					
					$title = $this->input->post('title');
					$chk= $this->input->post('chk');
								$price_range = '';
								if ($price>0 && $price<21){
								$price_range = '1-20';
								}else if ($price>20 && $price<101){
								$price_range = '21-100';
								}else if ($price>100 && $price<201){
								$price_range = '101-200';
								}else if ($price>200 && $price<501){
								$price_range = '201-500';
								}else if ($price>500){
								$price_range = '501+';
								}
	$this->product_model->update_details(PRODUCT,array($chk=>$title),array('id'=>$catID));
					
		  if($chk == 'price'){			
			$product_id = $this->input->post('catID');
			$DateUpdateCheck = $this->product_model->get_all_details(PRODUCT_BOOKING,array('product_id'=>$product_id));
				
				if($DateUpdateCheck->num_rows() == '1'){
$DateArr=$this->GetDays($DateUpdateCheck->row()->datefrom, $DateUpdateCheck->row()->dateto); 
						$dateDispalyRowCount=0;
						if(!empty($DateArr)){
							$dateArrVAl .='{';
							foreach($DateArr as $dateDispalyRow){
							
								if($dateDispalyRowCount==0){
								
									$dateArrVAl .='"'.$dateDispalyRow.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$title.'","promo":"","status":"available"}';
								}else{
									$dateArrVAl .=',"'.$dateDispalyRow.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$title.'","promo":"","status":"available"}';
								}
								$dateDispalyRowCount=$dateDispalyRowCount+1;
							}
							$dateArrVAl .='}';
						}
						$inputArr4=array();
						$inputArr4 = array(
									'id' =>$product_id,
									'data' => trim($dateArrVAl)
						);
						$this->product_model->update_details(SCHEDULE,$inputArr4,array('id'=>$product_id));
						
					}
				}
				
		
		}
	

	public function Save_Listing_Details()
	{
		if ($this->checkLogin('U') != '')
			{
				$catID = $this->input->post('catID');
				$title = $this->input->post('title');
				$chk = $this->input->post('chk');
				$checkListing = $this->product_model->get_all_details(PRODUCT,array('id'=>$catID));
				$listings_DetailsEncode = $this->product_model->get_all_details(LISTINGS,array('id'=>1))->row();
				
				$listings_DetailsDecode = json_decode($listings_DetailsEncode->listing_values);
				$listinsJson = json_decode($checkListing->row()->listings);
				if(count($listinsJson) != 0)
				{
					$resultArr = array();
					foreach ($listinsJson as $key => $value) {
					$productListingName[$key] = $key ;
					$productListingvalue[$key] = $value;
				}
				foreach($listings_DetailsDecode as $lisingTableName => $lisingTablevalue )
				{
					if( $lisingTableName == $chk )
					{
						if($chk == 'minimum_stay'){
						$this->product_model->update_details(PRODUCT,array('minimum_stay'=>$title),array('id' => $catID));
						$resultArr[$lisingTableName] = $title;						
						}
						else{
							$resultArr[$lisingTableName] = $title;
					}
					}
					else if($lisingTableName == $productListingName[$lisingTableName])
					{ 
						$resultArr[$lisingTableName] = $productListingvalue[$lisingTableName];
					}
					else if($lisingTableName != 'minimum_stay' ){
						$resultArr[$lisingTableName] = '';
					}
				}
					 
				
					$json_result = json_encode($resultArr);
					$FinalsValues = array('listings'=>$json_result);
					//print_r($json_result); 
					$this->product_model->update_details(PRODUCT,$FinalsValues,array('id' => $catID));
					//echo $this->db->last_query();
				}
				else
				{
					$listingsRslt = $this->product_model->get_all_details(LISTING_TYPES,array());
					foreach($listingsRslt->result() as $listing)
					{
						if($listing->name != 'accommodates' && $listing->name != 'can_policy')
						{
							
						 if( $listing->name == $chk ){
							if($chk == 'minimum_stay'){
								$this->product_model->update_details(PRODUCT,array('minimum_stay'=>$title),array('id' => $catID));	
								}
						else{
							$resultArr[$listing->name] = $title;
							}
						}
						else if($listing->name != 'minimum_stay' )
							{
								$resultArr[$listing->name] = '';
							}
						}
					}
					//echo "<pre>"; print_r($resultArr); die;
					$json_result=json_encode($resultArr);
					$FinalsValues= array('listings'=>$json_result);
								
					$this->product_model->update_details(PRODUCT, $FinalsValues, array('id' => $catID));
					
				}
			}
	}
	
	
	public function saveSpaceListPage()
		{
			if ($this->checkLogin('U') != '')
				{
					$catID = $this->input->post('catID');
					$title = $this->input->post('title');
					$chk= $this->input->post('chk');
					$this->product_model->update_details(PRODUCT,array($chk=>$title),array('id'=>$catID));
				}
		}
	
	
	
  public function saveCalender() {
	  			
	  			$id =$this->input->post('prd_id');
				$product_id =$this->input->post('prd_id');
				$this->product_model->commonDelete(PRODUCT_BOOKING,array('product_id' => $product_id));
	           
				$inputArr3=array();
				
				$inputArr3 = array(
							'product_id' =>$this->input->post('prd_id'),
							'dateto' => date('Y-m-d',strtotime($this->input->post('dateto'))),
							'datefrom' => date('Y-m-d',strtotime($this->input->post('datefrom')))
							
				);
				$this->product_model->simple_insert(PRODUCT_BOOKING,$inputArr3);
				 //echo $this->db->last_query();die;
				
				/*$DateUpdateCheck = $this->product_model->get_all_details(PRODUCT_BOOKING,array('product_id'=>$product_id,'dateto'=>$this->input->post('dateto'),'datefrom'=>$this->input->post('datefrom')));
				$price='';
			if($DateUpdateCheck->num_rows() == '1'){}else{
			
			
				$DateArr=$this->GetDays($this->input->post('datefrom'), $this->input->post('dateto')); 
					$dateDispalyRowCount=0;
					if(!empty($DateArr)){
						$dateArrVAl .='{';
						foreach($DateArr as $dateDispalyRow){
						
							if($dateDispalyRowCount==0){
							
								$dateArrVAl .='"'.$dateDispalyRow.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"available"}';
							}else{
								$dateArrVAl .=',"'.$dateDispalyRow.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"available"}';
							}
							$dateDispalyRowCount=$dateDispalyRowCount+1;
						}
						$dateArrVAl .='}';
					}
					$inputArr4=array();
					$inputArr4 = array(
								'id' =>$product_id,
								'data' => trim($dateArrVAl)
					);
					$this->product_model->update_details(SCHEDULE,$inputArr4,array('id'=>$product_id));
				}*/
				
				/*$inputArr3=array();
				$inputArr3 = array(
							'dateto' => $this->input->post('dateto'),
							'datefrom' => $this->input->post('datefrom'),
							'price' => $this->input->post('price'),
				);
				$this->product_model->update_details(PRODUCT_BOOKING,$inputArr3,$condition1);*/
				
				
				
	            redirect('manage_listing/'.$id);
  }
	
	
	
	
	
	
	
	public function saveAmenitieslist() {
			//print_r($this->input->post()); die;
		    $listname = $this->input->post('list_name');
			$id = $this->input->post('id');	
			$facility = @implode(',',$this->input->post('list_name'));
			$sublist = 	@implode(',',$this->input->post('sub_list'));	
			$dataArr = array('list_name' => $facility,'sub_list' => $sublist);
			$condition=array('id'=>$this->input->post('id'));
			$this->product_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,$dataArr,$condition);
			redirect('amenities_listing/'.$id);	
	}
	
	public function saveAmenitieslist_ajax() {
			$excludeArr = array('string','id');
			$dataArr = array('list_name' => $this->input->post('string'));
			$condition=array('id'=>$this->input->post('id'));
			$this->product_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,$dataArr,$condition);
			redirect('amenities_listing/'.$id);	
	}
	
	
	
	public function saveSpacelist() {
		
		
		    $home_type = $this->input->post('home_type');			
			$id = $this->input->post('id');
			$dataArr = array('home_type' =>$home_type);
			$condition=array('id'=>$this->input->post('id'));
			$this->product_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,$dataArr,$condition);
			redirect('space_listing/'.$id);	
		
	}
	
	
	
		public function saveDetaillist() {
		
		
		    $space = $this->input->post('space');
			
			
			$id = $this->input->post('id');
			$dataArr = array('space' =>$space);
			$condition=array('id'=>$this->input->post('id'));
			$this->product_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,$dataArr,$condition);
			redirect('site/product/detail_list/'.$id);	
		
	}
	
	
	
	
	/************************* amenties list display  --------------------- 12/05/2014  ******************/
	
	
	
	public function amenities_listing($prdid='') {
		if ($this->checkLogin('U') != '')
		{
			$condition = array('id'=>$prdid,'user_id'=>$this->checkLogin('U'));
			$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);
			if($this->data['listDetail']->num_rows() > 0)
			{				
				$this->data['listItems'] = $this->product_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
			
				$this->data['SublistDetail'] = $this->product_model->get_all_details(LIST_SUB_VALUES,$contition);
				$this->load->view('site/product/amenities_listing',$this->data);
			}
			else
			redirect();
	
		}
		else
		{
			redirect();
		}
	}
	
	public function detail_list($prdid='') {
	if ($this->checkLogin('U') != '')
		{
		$condition = array('id'=>$prdid);
		$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);	
		$this->load->view('site/product/detail_list',$this->data);
		}
		else
		{
			redirect();
		}
	}
	
	
	
	
	
    
	public function onboarding(){
		if ($this->checkLogin('U') == ''){
			redirect(base_url());
		}else {
			$this->data['userDetails'] = $this->product_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
			if ($this->data['userDetails']->num_rows() == 1){
				if ($this->data['mainCategories']->num_rows()>0){
					foreach ($this->data['mainCategories']->result() as $cat){
//						$condition = " where p.category_id like '".$cat->id.",%' OR p.category_id like '%,".$cat->id."' OR p.category_id like '%,".$cat->id.",%' OR p.category_id='".$cat->id."' order by p.created desc";
						$condition = " where FIND_IN_SET('".$cat->id."',p.category_id) and p.quantity>0 and p.status='Publish' and u.group='Seller' and u.status='Active' or p.status='Publish' and p.quantity > 0 and p.user_id=0 and FIND_IN_SET('".$cat->id."',p.category_id) order by p.created desc";
						$this->data['productDetails'][$cat->cat_name] = $this->product_model->view_product_details($condition);
					}
				}
				$this->load->view('site/user/onboarding',$this->data);
			}else {
				redirect(base_url());
			}
		}
	}
	
	public function onboarding_get_products_categories(){
		$returnCnt = '<div id="onboarding-category-items"><ol class="stream vertical">';
		$left = $top = $count = 0;
		$width = 220;
		$productArr = array();
		$catID = explode(',', $this->input->get('categories'));
		if (count($catID)>0){
			foreach ($catID as $cat){
//				$condition = " where p.category_id like '".$cat.",%' AND p.status = 'Publish' OR p.category_id like '%,".$cat."' AND p.status = 'Publish' OR p.category_id like '%,".$cat.",%' AND p.status = 'Publish' OR p.category_id='".$cat."' AND p.status = 'Publish'";
				$condition = " where FIND_IN_SET('".$cat."',p.category_id) and p.quantity>0 and p.status='Publish' and u.group='Seller' and u.status='Active' or p.status='Publish' and p.quantity > 0 and p.user_id=0 and FIND_IN_SET('".$cat."',p.category_id) order by p.created desc";
				$productDetails = $this->product_model->view_product_details($condition);
				if ($productDetails->num_rows()>0){
					foreach ($productDetails->result() as $productRow){
						if (!in_array($productRow->id, $productArr)){
							array_push($productArr, $productRow->id);
							$img = '';
							$imgArr = explode(',', $productRow->image);
							if (count($imgArr)>0){
								foreach ($imgArr as $imgRow){
									if ($imgRow != ''){
										$img = $imgRow;
										break;
									}
								}
							}
							if ($img!=''){
								$count++;
								$leftPos = $count%3;
								$leftPos = ($leftPos==0)?3:$leftPos;
								$leftPos--;
								if ($count%3 == 0){
									$topPos = $count/3;
								}else {
									$topPos	= ceil($count/3);
								}
								$topPos--;
								$leftVal = $leftPos*$width;
								$topVal = $topPos*$width;
								$returnCnt .='
									<li style="opacity: 1; top: '.$topVal.'px; left: '.$leftVal.'px;" class="start_marker_"><span class="pre hide"></span>
										<div class="figure-item">
											<a class="figure-img">
												<span style="background-image:url(\''.base_url().'images/product/'.$img.'\')" class="figure">
													<em class="back"></em>
													<img height="200" data-height="640" data-width="640" src="'.base_url().'images/product/'.$img.'"/>
												</span>
											</a>
											<a tid="'.$productRow->seller_product_id.'" class="button fancy noedit" href="#"><span><i></i></span>'.LIKE_BUTTON.'</a>
										</div>
									</li>
								';
							}
						}
					}
				}
			}
		}
		$returnCnt .= '
			</div>
		';
		echo $returnCnt;
	}
	
	public function onboarding_get_users_follow(){
		$catID = explode(',', $this->input->get('categories'));
		$productArr = array();
		$userArr = array();
		$userCountArr = array();
		$returnArr = array();
		
		/************Get Suggested Users List******************************/
		
		$returnArr['suggested'] = '<ul class="suggest-list">';
		if (count($catID)>0){
			foreach ($catID as $cat){
//				$condition = " where p.category_id like '".$cat.",%' AND p.status = 'Publish' OR p.category_id like '%,".$cat."' AND p.status = 'Publish' OR p.category_id like '%,".$cat.",%' AND p.status = 'Publish' OR p.category_id='".$cat."' AND p.status = 'Publish'";
				$condition = " where FIND_IN_SET('".$cat."',p.category_id) and p.quantity>0 and p.status='Publish' and u.group='Seller' and u.status='Active' or p.status='Publish' and p.quantity > 0 and p.user_id=0 and FIND_IN_SET('".$cat."',p.category_id)";
				$productDetails = $this->product_model->view_product_details($condition);
				if ($productDetails->num_rows()>0){
					foreach ($productDetails->result() as $productRow){
						if (!in_array($productRow->id, $productArr)){
							array_push($productArr, $productRow->id);
							if ($productRow->user_id != ''){
								if (!in_array($productRow->user_id, $userArr)){
									array_push($userArr, $productRow->user_id);
									$userCountArr[$productRow->user_id] = 1;
								}else {
									$userCountArr[$productRow->user_id]++;
								}
							}
						}
					}
				}
			}
		}
		arsort($userCountArr);
		$limitCount = 0;
		foreach ($userCountArr as $user_id => $products){
			if ($user_id!=''){
				$condition = array('id'=>$user_id,'is_verified'=>'Yes','status'=>'Active');
				$userDetails = $this->product_model->get_all_details(USERS,$condition);
				if ($userDetails->num_rows()==1){
					$condition = array('user_id'=>$user_id,'status'=>'Publish');
					$userProductDetails = $this->product_model->get_all_details(PRODUCT,$condition);
					if ($limitCount<10){
						$userImg = $userDetails->row()->image;
						if ($userImg == ''){
							$userImg = 'user-thumb1.png';
						}
						$returnArr['suggested'] .= '
							<li><span class="vcard"><img src="'.base_url().'images/users/'.$userImg.'"></span>
							<b>'.$userDetails->row()->full_name.'</b><br>
							'.$userDetails->row()->followers_count.' followers<br>
							'.$userProductDetails->num_rows().' things<br>
							<a uid="'.$user_id.'" class="follow-user-link" href="javascript:void(0)">Follow</a>
							<span class="category-thum">';
						$plimit = 0;
                           if ($userProductDetails->num_rows()>0){
                           	foreach ($userProductDetails->result() as $userProduct){
                           		if ($plimit>3){break;}
                                 $img = '';
                                 $imgArr = explode(',', $userProduct->image);
                                 if (count($imgArr)>0){
                                 	foreach ($imgArr as $imgRow){
                                 		if ($imgRow != ''){
                                 			$img = $imgRow;
                                 			break;
                                 		}
                                 	}
                                 }
                                 if ($img != ''){
                                 
						$returnArr['suggested'] .='<img alt="'.$userProduct->product_name.'" src="'.base_url().'images/product/'.$img.'">';
							    $plimit++;
                                 }
                           	}
                           } 
                            
						$returnArr['suggested'] .='</span>
							</li>
						';
						$limitCount++;
					}
				}
			}
		}
		$returnArr['suggested'] .='</ul>';
		
		/***********************************************************/
		
		/****************Get Top Users For All Categories**********/
		$returnArr['categories'] = '';
		if ($this->data['mainCategories']->num_rows()>0){
			foreach ($this->data['mainCategories']->result() as $catRow){
				if ($catRow->id != '' && $catRow->cat_name != ''){
					$returnArr['categories'] .= '
					<div style="display:none;" class="intxt '.url_title($catRow->cat_name,'_',TRUE).'">
					<p class="stit"><span>'.$catRow->cat_name.'</span>
					<button class="btns-blue-embo btn-followall">Follow All</button></p>
					<ul class="suggest-list">';
					$userCountArr = $this->product_model->get_top_users_in_category($catRow->id);
					$limitCount = 0;
					foreach ($userCountArr as $user_id => $products){
						if ($user_id!=''){
							$condition = array('id'=>$user_id,'is_verified'=>'Yes','status'=>'Active');
							$userDetails = $this->product_model->get_all_details(USERS,$condition);
							if ($userDetails->num_rows()==1){
								$condition = array('user_id'=>$user_id,'status'=>'Publish');
								$userProductDetails = $this->product_model->get_all_details(PRODUCT,$condition);
								if ($limitCount<10){
									$userImg = $userDetails->row()->image;
									if ($userImg == ''){
										$userImg = 'user-thumb1.png';
									}
									$returnArr['categories'] .= '
											<li><span class="vcard"><img src="'.base_url().'images/users/'.$userImg.'"></span>
											<b>'.$userDetails->row()->full_name.'</b><br>
											'.$userDetails->row()->followers_count.' followers<br>
											'.$userProductDetails->num_rows().' things<br>
											<a uid="'.$user_id.'" class="follow-user-link" href="javascript:void(0)">Follow</a>
											<span class="category-thum">';
									$plimit = 0;
									if ($userProductDetails->num_rows()>0){
										foreach ($userProductDetails->result() as $userProduct){
										if ($plimit>3){break;}
											$img = '';
											$imgArr = explode(',', $userProduct->image);
											if (count($imgArr)>0){
												foreach ($imgArr as $imgRow){
													if ($imgRow != ''){
														$img = $imgRow;
														break;
													}
												}
											}
											if ($img != ''){
												 
												$returnArr['categories'] .='<img alt="'.$userProduct->product_name.'" src="'.base_url().'images/product/'.$img.'">';
													$plimit++;
											}
										}
									}

									$returnArr['categories'] .='</span>
											</li>
										';
									$limitCount++;
								}
							}
						}
					}
					$returnArr['categories'] .='</ul></div>';
				}
			}
		}
		
		/**********************************************************/
		
		echo json_encode($returnArr);
	}
	
	public function insertEditProduct(){
	
		if ($this->checkLogin('U') == ''){
			redirect(base_url());
		}else {
			$product_id = $this->input->post('product_id');
			
			
			$img_name =  $this->input->post('imgUpload');
			$img_nameURL =  $this->input->post('imgUploadUrl');
			
			print_r($img_name); print_r($img_nameURL); die;
			
			
			
			
			
				$old_product_details = $this->product_model->get_all_details(PRODUCT,array('id'=>$product_id));
			
			
			$list_val_str = '';
			
			$list_val_arr = $this->input->post('list_value');
			if (is_array($list_val_arr) && count($list_val_arr)>0){
				$list_val_str = implode(',', $list_val_arr);
			}
				
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			
				$inputArr = array(
							'modified' => mdate($datestring,$time),
							'list_name' => $list_name_str,
							'list_value' => $list_val_str
				);
			if ($product_id != ''){
			
				$this->update_old_list_values($product_id,$list_val_arr,$old_product_details);
			}
			$dataArr = $inputArr;
			
			
			$this->product_model->update_details(PRODUCT,array('list_value'=>$list_val_str),array('id'=>$product_id));
			
			
			
			//Update the list table
			if (is_array($list_val_arr)){
				foreach ($list_val_arr as $list_val_row){
					$list_val_details = $this->product_model->get_all_details(LIST_VALUES,array('id'=>$list_val_row));
					if ($list_val_details->num_rows()==1){
						$product_count = $list_val_details->row()->product_count;
						$products_in_this_list = $list_val_details->row()->products;
						$products_in_this_list_arr = explode(',', $products_in_this_list);
						if (!in_array($product_id, $products_in_this_list_arr)){
							array_push($products_in_this_list_arr, $product_id);
							$product_count++;
							$list_update_values = array(
								'products'=>implode(',', $products_in_this_list_arr),
								'product_count'=>$product_count
							);
							$list_update_condition = array('id'=>$list_val_row);
							
							$this->product_model->update_details(LIST_VALUES,$list_update_values,$list_update_condition);
							
						}
					}
				}
			}
			
			
				//redirect('site/product/display_product_list');
				
		}
	}
	
	
	public function display_product_shuffle(){
		$productDetails = $this->product_model->view_product_details(' where p.quantity>0 and p.status="Publish" and u.group="Seller" and u.status="Active" or p.status="Publish" and p.quantity > 0 and p.user_id=0');
		if ($productDetails->num_rows()>0){
			$productId = array();
			foreach ($productDetails->result() as $productRow){
				array_push($productId, $productRow->id);
			}
			array_filter($productId);
			shuffle($productId);
			$pid = $productId[0];
			$productName = '';
			foreach ($productDetails->result() as $productRow){
				if ($productRow->id == $pid){
					$productName = $productRow->product_name;
				}
			}
			if ($productName == ''){
				redirect(base_url());
			}else {
				$link = 'things/'.$pid.'/'.url_title($productName,'-');
				redirect($link);
			}
		}else {
			redirect(base_url());
		}
	}
	
	public function display_product_detail(){
		$pid = $this->uri->segment(2,0);
		$limit = 0;
		$relatedArr = array();
		$relatedProdArr = array();
		$condition = "  where p.quantity>0 and p.status='Publish' and u.group='Seller' and u.status='Active' and p.id='".$pid."' or p.status='Publish' and p.quantity > 0 and p.user_id=0 and p.id='".$pid."'";
		$this->data['productDetails'] = $this->product_model->view_product_details($condition);
		$this->data['PrdAttrVal'] = $this->product_model->view_subproduct_details_join($pid);
		
		if ($this->data['productDetails']->num_rows()==1){
		$this->data['productComment'] = $this->product_model->view_product_comments_details('where c.product_id='.$this->data['productDetails']->row()->seller_product_id.' order by c.dateAdded desc');
	
			$catArr = explode(',', $this->data['productDetails']->row()->category_id);
			if (count($catArr)>0){
				foreach ($catArr as $cat){
					if ($limit>2)break;
					if ($cat != ''){
//						$condition = " where p.category_id like '".$cat.",%' AND p.status = 'Publish' AND p.id != '".$pid."' OR p.category_id like '%,".$cat."' AND p.status = 'Publish' AND p.id != '".$pid."' OR p.category_id like '%,".$cat.",%' AND p.status = 'Publish' AND p.id != '".$pid."' OR p.category_id='".$cat."' AND p.status = 'Publish' AND p.id != '".$pid."'";
						$condition =' where FIND_IN_SET("'.$cat.'",p.category_id) and p.quantity>0 and p.status="Publish" and u.group="Seller" and u.status="Active" and p.id != "'.$pid.'" or p.status="Publish" and p.quantity > 0 and p.user_id=0 and FIND_IN_SET("'.$cat.'",p.category_id) and p.id != "'.$pid.'"';
						$relatedProductDetails = $this->product_model->view_product_details($condition);
						if ($relatedProductDetails->num_rows()>0){
							foreach ($relatedProductDetails->result() as $relatedProduct){
								if (!in_array($relatedProduct->id, $relatedArr)){
									array_push($relatedArr, $relatedProduct->id);
									$relatedProdArr[] = $relatedProduct;
									$limit++;
								}
							}
						}
					}
				}
			}
		}
		$this->data['relatedProductsArr'] = $relatedProdArr;
		$recentLikeArr = $this->product_model->get_recent_like_users($this->data['productDetails']->row()->seller_product_id);
		$recentUserLikes = array();
		if ($recentLikeArr->num_rows()>0){
			foreach ($recentLikeArr->result() as $recentLikeRow){
				if ($recentLikeRow->user_id != ''){
					$recentUserLikes[$recentLikeRow->user_id] = $this->product_model->get_recent_user_likes($recentLikeRow->user_id,$this->data['productDetails']->row()->seller_product_id);
				}
			}
		}
		$this->data['recentLikeArr'] = $recentLikeArr;
		$this->data['recentUserLikes'] = $recentUserLikes;
		if ($this->checkLogin('U') != ''){
			$this->data['userDetails'] = $this->product_model->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
		}else {
			$this->data['userDetails'] = array();
		}
		
		//wishlist details
		//$pid
		
		$this->data['heading'] = $this->data['productDetails']->row()->product_name;
		if ($this->data['productDetails']->row()->meta_title != ''){
			$this->data['meta_title'] = $this->data['productDetails']->row()->meta_title;
		}
		if ($this->data['productDetails']->row()->meta_keyword != ''){
	    	$this->data['meta_keyword'] = $this->data['productDetails']->row()->meta_keyword;
		}
		if ($this->data['productDetails']->row()->meta_description != ''){
	    	$this->data['meta_description'] = $this->data['productDetails']->row()->meta_description;
		}
	 $this->load->view('site/product/product_detail',$this->data);
	}
	
	public function delete_featured_find(){
		$uid = $this->checkLogin('U');
		$dataArr = array('feature_product'=>'');
		$condition = array('id'=>$uid);
		$this->product_model->update_details(USERS,$dataArr,$condition);
		echo '1';
	}
	
	
	/* Ajax update for Product Details product */
	public function ajaxProductDetailAttributeUpdate(){
	
		$attrPriceVal = $this->product_model->get_all_details(SUBPRODUCT,array('pid'=>$this->input->post('attId'),'product_id'=>$this->input->post('prdId')));
		/*$shopattrVal = $this->product_model->get_all_details(SHOPPING_CART,array('user_id'=>$this->checkLogin('U'),'attribute_values'=>$attrPriceVal->row()->attr_id,'product_id'=>$this->input->post('prdId')));
		if($shopattrVal->row()->quantity != ''){ $ShopVals = $shopattrVal->row()->quantity; }else{ $ShopVals = 0;} .'|'.$ShopVals*/
		
		echo $attrPriceVal->row()->attr_id.'|'.$attrPriceVal->row()->attr_price;
		
	}
	
	public function add_featured_find(){
		$pid = $this->input->post('tid');
		$uid = $this->checkLogin('U');
		$dataArr = array('feature_product'=>$pid);
		$condition = array('id'=>$uid);
		$this->product_model->update_details(USERS,$dataArr,$condition);
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$createdTime = mdate($datestring,$time);
		$actArr = array(
			'activity'		=>	'featured',
			'activity_id'	=>	$pid,
			'user_id'		=>	$this->checkLogin('U'),
			'activity_ip'	=>	$this->input->ip_address(),
			'created'		=>	$createdTime
		);
		$this->product_model->simple_insert(NOTIFICATIONS,$actArr);
		$this->send_feature_noty_mail($pid);
		echo '1';
	}
	
	public function share_with_someone(){
		$returnStr['status_code'] = 0;
		$thing = array();
		$thing['url'] = $this->input->post('url');
		$thing['name'] = $this->input->post('name');
		$thing['id'] = $this->input->post('oid');
		$thing['refid'] = $this->input->post('ooid');
		$thing['msg'] = $this->input->post('message');
		$thing['uname'] = $this->input->post('uname');
		$thing['timage'] = base_url().$this->input->post('timage');
		$email = $this->input->post('emails');
		$users = $this->input->post('users');
		if (valid_email($email)){
			$this->send_thing_share_mail($thing,$email);
			$returnStr['status_code'] = 1;
		}else {
			$returnStr['message'] = 'Invalid email';
		}
		echo json_encode($returnStr);
	}
	
	public function send_thing_share_mail($thing='',$email=''){
	
							$newsid='2';
							$template_values=$this->product_model->get_newsletter_template_details($newsid);
							$adminnewstemplateArr=array('meta_title'=> $this->config->item('meta_title'),'logo'=> $this->data['logo'],'uname'=>ucfirst($thing['uname']),'name'=>$thing['name'],'url'=>$thing['url'],'msg'=>$thing['msg'],'email_title'=>$this->config->item('email_title'));
							extract($adminnewstemplateArr);
							$subject = ucfirst($thing['uname']).' '.$template_values['news_subject'].' '.$this->config->item('email_title');
							$message .= '<!DOCTYPE HTML>
								<html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
								<meta name="viewport" content="width=device-width"/>
								<title>'.$adminnewstemplateArr['meta_title'].' - Share Things</title>
								<body>';
							include('./newsletter/registeration'.$newsid.'.php');	
							
							$message .= '</body>
								</html>';
		if($template_values['sender_name']=='' && $template_values['sender_email']==''){
			$sender_email=$this->config->item('site_contact_mail');
			$sender_name=$this->config->item('email_title');
		}else{
			$sender_name=$template_values['sender_name'];
			$sender_email=$template_values['sender_email'];
		}
		
		//add inbox from mail 
		$this->product_model->simple_insert(INBOX,array('sender_id'=>$sender_email,'user_id'=>$email,'mailsubject'=>$subject,'description'=>stripslashes($message)));
		
		
		
		$email_values = array('mail_type'=>'html',
							'from_mail_id'=>$sender_email,
							'mail_name'=>$sender_name,		
							'to_mail_id'=>$email,
							'subject_message'=>$subject,
							'body_messages'=>$message
							);
		$email_send_to_common = $this->product_model->common_email_send($email_values);
		
/*		echo $this->email->print_debugger();die;
*/	
	}
	
	public function add_have_tag(){
		$returnStr['status_code'] = 0;
		$tid = $this->input->post('thing_id');
		$uid = $this->checkLogin('U');
		if ($uid != ''){
			$ownArr = explode(',', $this->data['userDetails']->row()->own_products);
			$ownCount = $this->data['userDetails']->row()->own_count;
			if (!in_array($tid, $ownArr)){
				array_push($ownArr, $tid);
				$ownCount++;
				$dataArr = array('own_products'=>implode(',', $ownArr),'own_count'=>$ownCount);
				$wantProducts = $this->product_model->get_all_details(WANTS_DETAILS,array('user_id'=>$this->checkLogin('U')));
				if ($wantProducts->num_rows() == 1){
					$wantProductsArr = explode(',', $wantProducts->row()->product_id);
					if (in_array($tid, $wantProductsArr)){
						if (($key = array_search($tid, $wantProductsArr))!== false){
							unset($wantProductsArr[$key]);
						}
						$wantsCount = $this->data['userDetails']->row()->want_count;
						$wantsCount--;
						$dataArr['want_count'] = $wantsCount;
						$this->product_model->update_details(WANTS_DETAILS,array('product_id'=>implode(',', $wantProductsArr)),array('user_id'=>$uid));
					}
				}
				$this->product_model->update_details(USERS,$dataArr,array('id'=>$uid));
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);
	}
	
	public function delete_have_tag(){
		$returnStr['status_code'] = 0;
		$tid = $this->input->post('thing_id');
		$uid = $this->checkLogin('U');
		if ($uid != ''){
			$ownArr = explode(',', $this->data['userDetails']->row()->own_products);
			$ownCount = $this->data['userDetails']->row()->own_count;
			if (in_array($tid, $ownArr)){
				if ($key = array_search($tid, $ownArr) !== false){
					unset($ownArr[$key]);
					$ownCount--;
				}
				$this->product_model->update_details(USERS,array('own_products'=>implode(',', $ownArr),'own_count'=>$ownCount),array('id'=>$uid));
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);
	}
	
	public function upload_product_image(){
		$returnStr['status_code'] = 0;
		$config['overwrite'] = FALSE;
    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
//	    $config['max_size'] = 2000;
	    $config['upload_path'] = './images/product';
	    $this->load->library('upload', $config);
		if ( $this->upload->do_upload('thefile')){
	    	$imgDetails = $this->upload->data();
	    	$returnStr['image']['url'] = base_url().'images/product/'.$imgDetails['file_name'];
	    	$returnStr['image']['width'] = $imgDetails['image_width'];
	    	$returnStr['image']['height'] = $imgDetails['image_height'];
	    	$returnStr['image']['name'] = $imgDetails['file_name'];
	    	$this->imageResizeWithSpace(300, 200, $imgDetails['file_name'], './images/product/');
	    	$returnStr['status_code'] = 1;
		}else {
			$returnStr['message'] = 'Can\'t be upload';
		}
		echo json_encode($returnStr);
	}
	
	public function add_new_thing(){
		$returnStr['status_code'] = 0;
		$returnStr['message'] = '';
		if ($this->checkLogin('U') != ''){
			$pid = $this->product_model->add_user_product($this->checkLogin('U'));
			$returnStr['status_code'] = 1;
			$userDetails = $this->data['userDetails'];
			$total_added = $userDetails->row()->products;
			$total_added++;
			$this->product_model->update_details(USERS,array('products'=>$total_added),array('id'=>$this->checkLogin('U')));
			$returnStr['thing_url'] = 'user/'.$userDetails->row()->user_name.'/things/'.$pid.'/'.url_title($this->input->post('name'),'-');
		}
		echo json_encode($returnStr);
	}
	
	public function display_user_thing(){
		$uname = $this->uri->segment(2,0);
		$pid = $this->uri->segment(4,0);
		$this->data['productUserDetails'] = $this->product_model->get_all_details(USERS,array('user_name'=>$uname));
		$this->data['productDetails'] = $this->product_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$pid,'status'=>'Publish'));
		if ($this->data['productDetails']->num_rows() == 1){
			$this->data['heading'] = $this->data['productDetails']->row()->product_name;
			$categoryArr = explode(',', $this->data['productDetails']->row()->category_id);
			$catID = 0;
			if (count($categoryArr)>0){
				foreach ($categoryArr as $catRow){
					if ($catRow != ''){
						$catID = $catRow;
						break;
					}
				}
			}
			$this->data['relatedProductsArr'] = $this->product_model->get_products_by_category($catID);
			if ($this->data['productDetails']->row()->meta_title != ''){
				$this->data['meta_title'] = $this->data['productDetails']->row()->meta_title;
			}
			if ($this->data['productDetails']->row()->meta_keyword != ''){
		    	$this->data['meta_keyword'] = $this->data['productDetails']->row()->meta_keyword;
			}
			if ($this->data['productDetails']->row()->meta_description != ''){
		    	$this->data['meta_description'] = $this->data['productDetails']->row()->meta_description;
			}
			$this->load->view('site/product/display_user_product',$this->data);
		}else {
			$this->load->view('site/product/product_detail',$this->data);
//			$this->setErrorMessage('error','Product details not available');
	//		redirect(base_url());
		}
	}
	
	public function sales_create(){
		if ($this->checkLogin('U') == ''){
			redirect('login');
		}else {
			$userType = $this->data['userDetails']->row()->group;
			if ($userType == 'Seller'){
				$pid = $this->input->get('ntid');
				$productDetails = $this->product_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$pid));
				if ($productDetails->num_rows()==1){
					if ($productDetails->row()->user_id == $this->data['userDetails']->row()->id){
						$this->data['productDetails'] = $productDetails;
						$this->data['editmode'] = '0';
						$this->load->view('site/product/edit_seller_product',$this->data);
					}else {
						show_404();
					}
				}else {
					show_404();
				}
			}else {
				redirect('seller-signup');
			}
		}
	}

	/**
	 * 
	 * Ajax function for delete the product pictures
	 */
	public function editPictureProducts(){
		$ingIDD = $this->input->post('imgId');
		$currentPage = $this->input->post('cpage');
		$id = $this->input->post('val');
		$productImage = explode(',',$this->session->userdata('product_image_'.$ingIDD));
		if(count($productImage) < 2) {
			echo json_encode("No");exit();
		} else {
			$empImg = 0;
			foreach ($productImage as $product) {
				if ($product != ''){
					$empImg++;
				}
			}
			if ($empImg<2){
				echo json_encode("No");exit();
			}
			$this->session->unset_userdata('product_image_'.$ingIDD);
			$resultVar = $this->setPictureProducts($productImage,$this->input->post('position'));
			$insertArrayItems = trim(implode(',',$resultVar)); //need validation here...because the array key changed here
			
			$this->session->set_userdata(array('product_image_'.$ingIDD => $insertArrayItems));	
			$dataArr = array('image' => $insertArrayItems);
			$condition = array('id' => $ingIDD);
			$this->product_model->update_details(PRODUCT,$dataArr,$condition);
			echo json_encode($insertArrayItems);
		}
	}
	
	
	public function edit_product_detail(){
		if ($this->checkLogin('U')==''){
			redirect('login');
		}else {
			$pid = $this->uri->segment(2,0);
			$viewMode = $this->uri->segment(4,0);
			$productDetails = $this->product_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$pid));
			if ($productDetails->num_rows()==1){
				if ($productDetails->row()->user_id == $this->checkLogin('U')){
					$this->data['productDetails'] = $productDetails;
					$this->load->view('site/product/edit_user_product',$this->data);
				}else {
					show_404();
				}
			}else {
				$productDetails = $this->product_model->get_all_details(PRODUCT,array('seller_product_id'=>$pid));
				$this->data['categoryView'] = $this->product_model->get_category_details($productDetails->row()->category_id);
				$this->data['atrributeValue'] = $this->product_model->view_atrribute_details();
				$this->data['PrdattrVal'] = $this->product_model->view_product_atrribute_details();	
				$this->data['SubPrdVal'] = $this->product_model->view_subproduct_details($productDetails->row()->id);
				if ($productDetails->num_rows()==1){
					if ($productDetails->row()->user_id == $this->checkLogin('U')){
						$this->data['productDetails'] = $productDetails;
						$this->data['editmode'] = '1';
						if ($viewMode == ''){
							$this->load->view('site/product/edit_seller_product',$this->data);
						}else {
							$this->load->view('site/product/edit_seller_product_'.$viewMode,$this->data);
						}
					}else {
						show_404();
					}
				}else {
					show_404();
				}
			}
		}
	}
	
	
	public function edit_user_product_process(){
		$mode = $this->input->post('submit');
		$pid = $this->input->post('productID');
		if ($pid != ''){
			if ($mode == 'Upload'){
				$config['overwrite'] = FALSE;
		    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
//			    $config['max_size'] = 2000;
			    $config['upload_path'] = './images/product';
			    $this->load->library('upload', $config);
				if ( $this->upload->do_upload('uploadphoto')){
			    	$imgDetails = $this->upload->data();
			    	$this->imageResizeWithSpace(600, 600, $imgDetails['file_name'], './images/product/');
			    	$dataArr['image'] = $imgDetails['file_name'];
			    	$this->product_model->update_details(USER_PRODUCTS,$dataArr,array('seller_product_id'=>$pid));
					$this->setErrorMessage('success','Photo changed successfully');
					echo '<script>window.history.go(-1)</script>';
				}else {
					$this->setErrorMessage('error','Can\'t able to upload');
					echo '<script>window.history.go(-1)</script>';
				}
			}else {
				$excludeArr = array('productID','submit','uploadphoto');
				$dataArr = array(
					'seourl'	=>	url_title($this->input->post('product_name'),'-'),
					'modified'	=>	'now()'
				);
				$this->product_model->commonInsertUpdate(USER_PRODUCTS,'update',$excludeArr,$dataArr,array('seller_product_id'=>$pid));
				$this->setErrorMessage('success','Details updated successfully');
				redirect('user/'.$this->data['userDetails']->row()->user_name.'/things/'.$pid.'/'.url_title($this->input->post('product_name'),'-'));
				//	/*echo '<script>window.history.go(-1)/script>';*/
			}
		}
	}
	
	public function sell_it(){ 
		$mode = $this->uri->segment(4,0);
		$pid = $this->input->post('PID');
		$nextMode = $this->input->post('nextMode');
		$excludeArr = array('PID','nextMode','changeorder','imaged','gateway_tbl_length','category_id','attribute_name','attribute_val','product_attribute_name','product_attribute_val','attr_name1','attr_val1');
		$dataArr = array('seller_product_id'=>$pid);
		$checkProduct = $this->product_model->get_all_details(PRODUCT,$dataArr);
		if ($mode == '1'){
			$price_range = 0;
			$price = $this->input->post('sale_price');
			if ($price>0 && $price<21){
				$price_range = '1-20';
			}else if ($price>20 && $price<101){
				$price_range = '21-100';
			}else if ($price>100 && $price<201){
				$price_range = '101-200';
			}else if ($price>200 && $price<501){
				$price_range = '201-500';
			}else if ($price>500){
				$price_range = '501+';
			}
			
			if ($checkProduct->num_rows()==0){
				$userProduct = $this->product_model->get_all_details(USER_PRODUCTS,$dataArr);
				if ($userProduct->num_rows()==1){
					$dataArr['image']	=	$userProduct->row()->image;
					$dataArr['seourl']	=	url_title($this->input->post('product_name'),'-');
					$dataArr['user_id'] =	$userProduct->row()->user_id;
					$dataArr['price_range'] =	$price_range;
					$dataArr['category_id']	=	$userProduct->row()->category_id;
					$this->product_model->commonInsertUpdate(PRODUCT,'insert',$excludeArr,$dataArr);
					$this->product_model->commonDelete(USER_PRODUCTS,array('seller_product_id'=>$pid));
					$this->setErrorMessage('success','Yeah ! changes have been saved');
					$addedProd = $this->session->userdata('prodID');
					if ($addedProd == ''){
						$addedProd = array();
					}
					array_push($addedProd, $pid);
					$this->session->set_userdata('prodID',$addedProd);
					redirect('things/'.$pid.'/edit/'.$nextMode);
				}
			}else {
				$dataArr['seourl']	=	url_title($this->input->post('product_name'),'-');
				$dataArr['price_range'] =	$price_range;
				$this->product_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,$dataArr,array('seller_product_id'=>$pid));
				$this->setErrorMessage('success','Yeah ! changes have been saved');
				redirect('things/'.$pid.'/edit');
			}
		}else if ($mode == 'seo'){
			$this->product_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,array(),array('seller_product_id'=>$pid));
			$this->setErrorMessage('success','Yeah ! changes have been saved');
			redirect('things/'.$pid.'/edit/'.$nextMode);
		}else if ($mode == 'images'){
			$config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
//		    $config['max_size'] = 2000;
	    	$config['upload_path'] = './images/product';
		    $this->load->library('upload', $config);
			//echo "<pre>";print_r($_FILES);die;
			$ImageName = '';
		    if ( $this->upload->do_multi_upload('product_image')){
		    	$logoDetails = $this->upload->get_multi_upload_data();
			    foreach ($logoDetails as $fileDetails){
			    	$this->imageResizeWithSpace(600, 600, $fileDetails['file_name'], './images/product/');
		    		$ImageName .= $fileDetails['file_name'].',';
		    	}
			}
			$existingImage = $this->input->post('imaged');
		 
			$newPOsitionArr = $this->input->post('changeorder');
			$imagePOsit = array();
			 
			for($p=0;$p<sizeof($existingImage);$p++) {
				$imagePOsit[$newPOsitionArr[$p]] = $existingImage[$p];
			}
	
			ksort($imagePOsit);
			foreach ($imagePOsit as $keysss => $vald) {
			 $imgArraypos[]=$vald;
			}
			$imagArraypo0 = @implode(",",$imgArraypos);
			$allImages = $imagArraypo0.','.$ImageName;
			
			$dataArr = array( 'image' => $allImages);
			$this->product_model->update_details(PRODUCT,$dataArr,array('seller_product_id'=>$pid));
			$this->setErrorMessage('success','Yeah ! changes have been saved');
			redirect('things/'.$pid.'/edit/'.$nextMode);
		}else if ($mode == 'categories'){
			if ($this->input->post('category_id') != ''){
				$category_id = implode(',', $this->input->post('category_id'));
			}else {
				$category_id = '';
			}
			$dataArr = array( 'category_id' => $category_id);
			$this->product_model->update_details(PRODUCT,$dataArr,array('seller_product_id'=>$pid));
			$this->setErrorMessage('success','Yeah ! changes have been saved');
			redirect('things/'.$pid.'/edit/'.$nextMode);
		}else if ($mode == 'list') {
			$list_name_str = $list_val_str = '';
			$list_name_arr = $this->input->post('attribute_name');
			$list_val_arr = $this->input->post('attribute_val');
			if (is_array($list_name_arr) && count($list_name_arr)>0){
				$list_name_str = implode(',', $list_name_arr);
				$list_val_str = implode(',', $list_val_arr);
			}
			$dataArr = array( 'list_name' => $list_name_str,'list_value'=>$list_val_str);
			$this->product_model->update_details(PRODUCT,$dataArr,array('seller_product_id'=>$pid));
			
			//Update the list table
			if (is_array($list_val_arr)){
				foreach ($list_val_arr as $list_val_row){
					$list_val_details = $this->product_model->get_all_details(LIST_VALUES,array('id'=>$list_val_row));
					if ($list_val_details->num_rows()==1){
						$product_count = $list_val_details->row()->product_count;
						$products_in_this_list = $list_val_details->row()->products;
						$products_in_this_list_arr = explode(',', $products_in_this_list);
						if (!in_array($pid, $products_in_this_list_arr)){
							array_push($products_in_this_list_arr, $pid);
							$product_count++;
							$list_update_values = array(
								'products'=>implode(',', $products_in_this_list_arr),
								'product_count'=>$product_count
							);
							$list_update_condition = array('id'=>$list_val_row);
							$this->product_model->update_details(LIST_VALUES,$list_update_values,$list_update_condition);
						}
					}
				}
			}
			
			$this->setErrorMessage('success','Yeah ! changes have been saved');
			redirect('things/'.$pid.'/edit/'.$nextMode);
		
		}else if ($mode == 'attribute') {
			
			$prodId = $checkProduct->row()->id;
			$Attr_name_str = $Attr_val_str = '';
			$Attr_name_arr = $this->input->post('product_attribute_name');
			$Attr_val_arr = $this->input->post('product_attribute_val');
			if (is_array($Attr_name_arr) && count($Attr_name_arr)>0){				
				for($k=0;$k<sizeof($Attr_name_arr);$k++){
					$dataSubArr = '';
					$dataSubArr = array('product_id'=> $prodId,'attr_id'=>$Attr_name_arr[$k],'attr_price'=>$Attr_val_arr[$k]);
					//echo '<pre>'; print_r($dataSubArr); 
					$this->product_model->add_subproduct_insert($dataSubArr);
				}
			}
		
			$this->setErrorMessage('success','Yeah ! changes have been saved');
			redirect('things/'.$pid.'/edit/'.$nextMode);
		
		}else {
			show_404();
		}
	}
	
	public function delete_product(){
		$pid = $this->uri->segment(2,0);
		if ($this->checkLogin('U')==''){
			redirect('login');
		}else {
			$productDetails = $this->product_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$pid));
			if ($productDetails->num_rows()==1){
				if ($productDetails->row()->user_id == $this->checkLogin('U')){
					$this->product_model->commonDelete(USER_PRODUCTS,array('seller_product_id'=>$pid));
					$productCount = $this->data['userDetails']->row()->products;
					$productCount--;
					$this->product_model->update_details(USERS,array('products'=>$productCount),array('id'=>$this->checkLogin('U')));
					$this->product_model->commonDelete(SUBPRODUCT,array('product_id' => $productDetails->row()->id));
					$this->setErrorMessage('success','Product deleted successfully');
					redirect('user/'.$this->data['userDetails']->row()->user_name.'/added');
				}else {
					show_404();
				}
			}else {
				$productDetails = $this->product_model->get_all_details(PRODUCT,array('seller_product_id'=>$pid));
				if ($productDetails->num_rows()==1){
					if ($productDetails->row()->user_id == $this->checkLogin('U')){
						$this->product_model->commonDelete(PRODUCT,array('seller_product_id'=>$pid));
						$productCount = $this->data['userDetails']->row()->products;
						$productCount--;
						$this->product_model->update_details(USERS,array('products'=>$productCount),array('id'=>$this->checkLogin('U')));
						$this->product_model->commonDelete(SUBPRODUCT,array('product_id' => $productDetails->row()->id));
						$this->setErrorMessage('success','Product deleted successfully');
						redirect('user/'.$this->data['userDetails']->row()->user_name.'/added');
					}else {
						show_404();
					}
				}else {
					show_404();
				}
			}
		}
	}
	
	public function add_reaction_tag(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') == ''){
			$returnStr['message'] = 'You must login';
		}else {
			$tid = $this->input->post('thing_id');
			$checkProductLike = $this->user_model->get_all_details(PRODUCT_LIKES,array('product_id'=>$tid,'user_id'=>$this->checkLogin('U')));
			if ($checkProductLike->num_rows() == 0){
				$productDetails = $this->user_model->get_all_details(PRODUCT,array('seller_product_id'=>$tid));
				if ($productDetails->num_rows() == 0){
					$productDetails = $this->user_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$tid));
					$productTable = USER_PRODUCTS;
				}else {
					$productTable = PRODUCT;
				}
				if ($productDetails->num_rows()==1){
					$likes = $productDetails->row()->likes;
					$dataArr = array('product_id'=>$tid,'user_id'=>$this->checkLogin('U'),'ip'=>$this->input->ip_address());
					$this->user_model->simple_insert(PRODUCT_LIKES,$dataArr);
					$actArr = array(
						'activity_name'	=>	'fancy',
						'activity_id'	=>	$tid,
						'user_id'		=>	$this->checkLogin('U'),
						'activity_ip'	=>	$this->input->ip_address()
					);
					$this->user_model->simple_insert(USER_ACTIVITY,$actArr);
					$likes++;
					$dataArr = array('likes'=>$likes);
					$condition = array('seller_product_id'=>$tid);
					$this->user_model->update_details($productTable,$dataArr,$condition);
					$totalUserLikes = $this->data['userDetails']->row()->likes;
					$totalUserLikes++;
					$this->user_model->update_details(USERS,array('likes'=>$totalUserLikes),array('id'=>$this->checkLogin('U')));
/*
 * -------------------------------------------------------
 * Creating list automatically when user likes a product 
 * -------------------------------------------------------
 *
					$listCheck = $this->user_model->get_list_details($tid,$this->checkLogin('U'));
					if ($listCheck->num_rows() == 0){
						$productCategoriesArr = explode(',', $productDetails->row()->category_id);
						if (count($productCategoriesArr)>0){
							foreach ($productCategoriesArr as $productCategoriesRow){
								if ($productCategoriesRow != ''){
									$productCategory = $this->user_model->get_all_details(CATEGORY,array('id'=>$productCategoriesRow));
									if ($productCategory->num_rows()==1){
										
									}
								}
							}
						}
					}
*/
					$returnStr['status_code'] = 1;
				}else {
					$returnStr['message'] = 'Product not available';
				}
			}else {
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);	
	
	}
	
	public function delete_reaction_tag(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U') == ''){
			$returnStr['message'] = 'You must login';
		}else {
			$tid = $this->input->post('thing_id');
			$checkProductLike = $this->user_model->get_all_details(PRODUCT_LIKES,array('product_id'=>$tid,'user_id'=>$this->checkLogin('U')));
			if ($checkProductLike->num_rows() == 1){
				$productDetails = $this->user_model->get_all_details(PRODUCT,array('seller_product_id'=>$tid));
				if ($productDetails->num_rows()==0){
					$productDetails = $this->user_model->get_all_details(USER_PRODUCTS,array('seller_product_id'=>$tid));
					$productTable = USER_PRODUCTS;
				}else {
					$productTable = PRODUCT;
				}
				if ($productDetails->num_rows()==1){
					$likes = $productDetails->row()->likes;
					$conditionArr = array('product_id'=>$tid,'user_id'=>$this->checkLogin('U'));
					$this->user_model->commonDelete(PRODUCT_LIKES,$conditionArr);
					$actArr = array(
						'activity_name'	=>	'unfancy',
						'activity_id'	=>	$tid,
						'user_id'		=>	$this->checkLogin('U'),
						'activity_ip'	=>	$this->input->ip_address()
					);
					$this->user_model->simple_insert(USER_ACTIVITY,$actArr);
					$likes--;
					$dataArr = array('likes'=>$likes);
					$condition = array('seller_product_id'=>$tid);
					$this->user_model->update_details($productTable,$dataArr,$condition);
					$totalUserLikes = $this->data['userDetails']->row()->likes;
					$totalUserLikes--;
					$this->user_model->update_details(USERS,array('likes'=>$totalUserLikes),array('id'=>$this->checkLogin('U')));
					$returnStr['status_code'] = 1;
				}else {
					$returnStr['message'] = 'Product not available';
				}
			}else {
				$returnStr['status_code'] = 1;
			}
		}
		echo json_encode($returnStr);	
	}
	
	public function loadListValues(){
		$returnStr['listCnt'] = '<option value="">--Select--</option>';
		$lid = $this->input->post('lid');
		$lvID = $this->input->post('lvID');
		if ($lid != ''){
			$listValues = $this->product_model->get_all_details(LIST_VALUES,array('list_id'=>$lid));
			if ($listValues->num_rows()>0){
				foreach ($listValues->result() as $listRow){
					$selStr = '';
					if ($listRow->id == $lvID){
						$selStr = 'selected="selected"';
					}
					$returnStr['listCnt'] .= '<option '.$selStr.' value="'.$listRow->id.'">'.$listRow->list_value.'</option>';
				}
			}
		}
		echo json_encode($returnStr);
	}
	
	public function approve_comment(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U')!=''){
			$cid = $this->input->post('cid');
			$this->product_model->update_details(PRODUCT_COMMENTS,array('status'=>'Active'),array('id'=>$cid));
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			$createdTime = mdate($datestring,$time);
			$product_id = $this->input->post('tid');
			$user_id = $this->input->post('uid');
			$this->product_model->commonDelete(NOTIFICATIONS,array('comment_id'=>$cid));
			$actArr = array(
				'activity'		=>	'comment',
				'activity_id'	=>	$product_id,
				'user_id'		=>	$user_id,
				'activity_ip'	=>	$this->input->ip_address(),
				'comment_id'	=>	$cid,
				'created'		=>	$createdTime
			);
			$this->product_model->simple_insert(NOTIFICATIONS,$actArr);
			$this->send_comment_noty_mail($product_id,$cid);
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}
	
	public function delete_comment(){
		$returnStr['status_code'] = 0;
		if ($this->checkLogin('U')!=''){
			$cid = $this->input->post('cid');
			$this->product_model->commonDelete(PRODUCT_COMMENTS,array('id'=>$cid));
			$returnStr['status_code'] = 1;
		}
		echo json_encode($returnStr);
	}
	
	public function send_feature_noty_mail($pid='0'){
		if ($pid!= '0'){
			$productUserDetails = $this->product_model->get_product_full_details($pid);
			if ($productUserDetails->num_rows()>0){
				$emailNoty = explode(',', $productUserDetails->row()->email_notifications);
				if (in_array('featured', $emailNoty)){
					if ($productUserDetails->prodmode == 'seller'){
						$prodLink = base_url().'things/'.$productUserDetails->row()->id.'/'.url_title($productUserDetails->row()->product_name,'-');
					}else {
						$prodLink = base_url().'user/'.$productUserDetails->row()->user_name.'/things/'.$productUserDetails->row()->seller_product_id.'/'.url_title($productUserDetails->row()->product_name,'-');
					}
                    
                    $newsid='10';
		  		$template_values=$this->product_model->get_newsletter_template_details($newsid);
		$adminnewstemplateArr=array('logo'=> $this->data['logo'],'meta_title'=>$this->config->item('meta_title'),'full_name'=>$productUserDetails->row()->full_name,'cfull_name'=>$this->data['userDetails']->row()->full_name,'product_name'=>$productUserDetails->row()->product_name,'user_name'=>$this->data['userDetails']->row()->user_name);
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
					$this->product_model->simple_insert(INBOX,array('sender_id'=>$sender_email,'user_id'=>$productUserDetails->row()->email,'mailsubject'=>$subject,'description'=>stripslashes($message)));
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

	public function add_space()
		{
	//echo '<pre>'; print_r($_POST); die;
	//$this->input->post('room_type');
	
	    $hometype =($this->input->post('other')=='')?$this->input->post('home_type'):$this->input->post('other'); 
		$address = $this->input->post('city');
		
			 
			if ($this->checkLogin('U')=='')
				{
					$this->setErrorMessage('error','Please sign in before listing your rental');
					redirect(base_url());
				}
			else
				{
					$id =$this->checkLogin('U');
					$condition = array('id'=>$id,'status'=>'Active');
					$this->data['checkUser'] = $this->user_model->get_all_details(USERS,$condition);
					$cityArr = explode(',',$this->input->post('city'));
					if($this->data['checkUser']->num_rows() == 1)
						{
							$data = array('room_type'=>$this->input->post('room_type_1'),
										 'accommodates'=>$this->input->post('accommodates'),
										 'home_type'=>$this->input->post('home_type_1'),
										 'user_id'=>$id,
										 'status'=>'UnPublish',
										);
										
										//echo '<pre>'; print_r($data); die;
							$this->product_model->simple_insert(PRODUCT,$data);
							//echo $this->db->last_query();die;
							$getInsertId=$this->product_model->get_last_insert_id();
							
							//$dataArr = array('productId' => $getInsertId,'street' => $street,'area' => $area,'location' => $location,'city' => $city,'state' => $state,'country' => $country,'lang' => $lang,'lat' => $lat,'zip' => $zip);
							$dataArr = array('productId' => $getInsertId, 'address' => $address);
		
							$this->cms_model->simple_insert(PRODUCT_ADDRESS_NEW,$dataArr);
							
							
							$inputArr3=array();
							$inputArr3 = array(
										'product_id' =>$getInsertId
										
							);
							$this->product_model->simple_insert(PRODUCT_BOOKING,$inputArr3);
							
							
							$inputArr4=array();
							$inputArr4 = array(
										'id' =>$getInsertId
										
							);
							$this->product_model->simple_insert(SCHEDULE,$inputArr4);
							$this->product_model->update_details(USERS,array('group'=>'Seller'),array('id'=>$id));
							redirect('manage_listing/'.$getInsertId);
							
						}
					else
						{
							$this->setErrorMessage('error','Please register before you start listing your property');
							redirect(base_url());
						}
				}
				
		}
		
	public function space_listing($prdid='')
		{
			if ($this->checkLogin('U') != '')
			{
				$condition = array('id'=>$prdid,'user_id'=>$this->checkLogin('U'));
				$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);
				if($this->data['listDetail']->num_rows() > 0)
				{				
					$this->data['listValues'] = $this->product_model->get_all_details(LISTINGS,array('id'=>1));	
					$this->data['listTypeValues'] = $this->product_model->get_all_details(LISTING_TYPES, array());	
					foreach($this->data['listValues'] as $result)
					{
						$data = $result->listing_values;	
					}
					$this->data['finalVal'] = json_decode($data);
					$list_values = $this->data['listDetail']->row()->listings;
					$this->data['listings'] = json_decode($list_values);
					
					$condition1=array('status'=>'Active');
					$this->data['listspace'] = $this->product_model->get_all_details(LISTSPACE,$condition1);
					$this->load->view('site/product/space_listing',$this->data);
				}
				else
				redirect();
			}
			else
			{
				redirect();
			}
		}
		
	public function cancel_policy($prdid='')
		{
		    if ($this->checkLogin('U') != '')
		
			{
				$cancellation_policy_query='SELECT * FROM '.CMS.' WHERE seourl="cancellation-policy"';
				$cancellation_policy=$this->db->query($cancellation_policy_query);
				$this->data['cancellation_policy']=$cancellation_policy;
				$this->data['listValues'] = $this->product_model->get_all_details(LISTINGS,array('id'=>1));
				$condition = array('id'=>$prdid,'user_id'=>$this->checkLogin('U'));
				$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);
			  //  echo $condition;
				//echo "<pre>"; print_r($this->data['listDetail']->row()); die;
				if($this->data['listDetail']->num_rows() > 0)
				{
					$this->load->view('site/product/cancel_policy',$this->data);
				}
				else
				redirect();
			}
			else
			{
				redirect();
			}
		}
		
	public function list_space()
		{
			 $condition=array('status'=>'Active');
			 $this->data['listspace'] = $this->product_model->get_all_details(LISTSPACE,$condition);
			 $this->data['listValues'] = $this->product_model->get_all_details(LISTINGS,array('id'=>1));
			$this->load->view('site/product/list_space',$this->data);
		}
		
	public function manage_listing($prdid='')
		{
			if ($this->checkLogin('U') != '')
			{
				$condition = array('id'=>$prdid,'user_id'=>$this->checkLogin('U'));
				$userId = $this->checkLogin('U');
				$this->data['listDetail'] = $this->product_model->view_product_details1("where p.id=$prdid and p.user_id=$userId");
				if($this->data['listDetail']->num_rows() > 0)
				{
					$this->load->view('site/product/manage_listing',$this->data);
				}
				else
				redirect();
			}
			else
			{
				redirect();
			}
			
			
		}
		
	public function price_listing($prdid='')
		{
			if ($this->checkLogin('U') != '')
			{
				$condition = array('id'=>$prdid,'user_id'=>$this->checkLogin('U'));
				$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);
				if($this->data['listDetail']->num_rows() > 0)
				{
					$this->data['currencyDetail'] = $this->product_model->get_all_details(CURRENCY,array('status'=>'Active'),array(array('field'=>'default_currency','type'=>'desc')));
					if($this->data['listDetail']->row()->currency != '')
					{
						$currentCurrency = $this->product_model->get_all_details(CURRENCY,array('currency_type'=>$this->data['listDetail']->row()->currency));
						$this->data['currentCurrency'] = $currentCurrency->row()->currency_symbols;
					}
					$this->load->view('site/product/price_listing',$this->data);
				}
				else
				redirect();
			}
			else
			{
				redirect();
			}
		}
		
	public function overview_listing($prdid='')
		{
			if ($this->checkLogin('U') != '')
			{
				$condition = array('id'=>$prdid,'user_id'=>$this->checkLogin('U'));
				$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);
				if($this->data['listDetail']->num_rows() > 0)
				{				
					$this->load->view('site/product/overview_listing',$this->data);
				}
				else
				redirect();
			}
			else
			{
				redirect();
			}
		}
		
		
		
	public function photos_listing($prdid='')
		{
			if ($this->checkLogin('U') != '')
			{
				$condition = array('id'=>$prdid,'user_id'=>$this->checkLogin('U'));
				$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);
				if($this->data['listDetail']->num_rows() > 0)
				{
					$this->data['imgDetail'] = $this->product_model->get_images($prdid);
					$this->load->view('site/product/photos_listing',$this->data);
				}
				else
				redirect();
			}
			else
			{
				redirect();
			}
		}
	
	public function changeImagetitle()
		{
			if ($this->checkLogin('U') != '')
				{
					$catID = $this->input->post('catID');
					$title = $this->input->post('title');
					$this->product_model->update_details(PRODUCT_PHOTOS	,array('imgtitle'=>$title),array('id'=>$catID));
				}
		}
		
	public function amenities_listing1($prdid='')
		{
			$condition = array('id'=>$prdid);
			$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);
			
				$this->data['listNameCnt'] = $this->product_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
				$this->data['listValueCnt'] = $this->product_model->get_all_details(LIST_VALUES,array('status'=>'Active'));
				$list_valueArr=explode(',',$this->data['listDetail']->row()->list_value);
				$listIdArr=array();
				foreach($this->data['listValueCnt']->result_array() as $listCountryValue){
				$listIdArr[]=$listCountryValue['list_id'];
				}
				
				if($this->data['listNameCnt']->num_rows() > 0){
			
				foreach($this->data['listNameCnt']->result_array() as $listCountryName){
				
					$this->data['listCountryValue'] .='
					<script language="javascript">
$(function(){
 
    $("#selectall'.$listCountryName['id'].'").click(function () {
          $(".cb'.$listCountryName['id'].'").attr("checked", this.checked);
    });
 
    $(".cb'.$listCountryName['id'].'").click(function(){
 
        if($(".cb'.$listCountryName['id'].'").length == $(".cb:checked").length) {
            $("#selectall'.$listCountryName['id'].'").attr("checked", "checked");
        } else {
            $("#selectall'.$listCountryName['id'].'").removeAttr("checked");
        }
 
    });
});
</script>
				
					
					<div class="dashboard_price_main">
            
            	<div class="dashboard_price">
            
                    <div class="dashboard_price_left"><h3>'.ucfirst($listCountryName['attribute_name']).'</h3>'.$listCountryName['description'].'<br /><br /><br />Select All<input type="checkbox" id="selectall'.$listCountryName['id'].'"/></div><div class="dashboard_price_right"><ul class="facility_listed">';
					
						foreach($this->data['listValueCnt']->result_array() as $listCountryValue){
						
							//if(in_array($listCountryName['id'],$listIdArr)){
							if($listCountryValue['list_id']==$listCountryName['id']){
						
						if (in_array($listCountryValue['id'],$list_valueArr)){ 
							$checkStr = 'checked="checked"';
						}else {
							$checkStr = '';
						}
						
						
						
						
								$this->data['listCountryValue'] .='<li><input type="checkbox" name="list_value[]" class="checkbox_check cb'.$listCountryName['id'].'" '.$checkStr.'value="'.$listCountryValue['id'].'"/><span>'.ucfirst($listCountryValue['list_value']).'</span></li>';
								
							}
						
						}$this->data['listCountryValue'] .='</ul>
                    
                    
                    </div>
                
                </div> 
                
                
                
            
            </div>';
					
				}
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		/*	
			$this->data['listNameCnt'] = $this->product_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
				$this->data['listValueCnt'] = $this->product_model->get_all_details(LIST_VALUES,array('status'=>'Active'));
				$list_valueArr=explode(',',$this->data['product_details']->row()->list_value);
				$listIdArr=array();
				foreach($this->data['listValueCnt']->result_array() as $listCountryValue){
				$listIdArr[]=$listCountryValue['list_id'];
				}
				
				if($this->data['listNameCnt']->num_rows() > 0){
			
				foreach($this->data['listNameCnt']->result_array() as $listCountryName){
				
					$this->data['listCountryValue'] .='
					<script language="javascript">
$(function(){
 
    $("#selectall'.$listCountryName['id'].'").click(function () {
          $(".cb'.$listCountryName['id'].'").attr("checked", this.checked);
    });
 
    $(".cb'.$listCountryName['id'].'").click(function(){
 
        if($(".cb'.$listCountryName['id'].'").length == $(".cb:checked").length) {
            $("#selectall'.$listCountryName['id'].'").attr("checked", "checked");
        } else {
            $("#selectall'.$listCountryName['id'].'").removeAttr("checked");
        }
 
    });
});
</script>
					
					
					<br /><span class="cat1"><!-- <input name="list_name[]" class="checkbox" type="checkbox" value="'.$listCountryName['id'].'" tabindex="7"> --><strong>'.ucfirst($listCountryName['attribute_name']).' &nbsp;</strong><input type="checkbox" id="selectall'.$listCountryName['id'].'"/></span><br />';
					
						foreach($this->data['listValueCnt']->result_array() as $listCountryValue){
						
							//if(in_array($listCountryName['id'],$listIdArr)){
							if($listCountryValue['list_id']==$listCountryName['id']){
						
						if (in_array($listCountryValue['id'],$list_valueArr)){ 
							$checkStr = 'checked="checked"';
						}else {
							$checkStr = '';
						}
						
						
						
						
								$this->data['listCountryValue'] .='
								<div style="float:left; margin-left:10px;">
										<span>
										<input name="list_value[]" class="checkbox cb'.$listCountryName['id'].'" '.$checkStr.' type="checkbox" value="'.$listCountryValue['id'].'" tabindex="7">
										<label class="choice">'.ucfirst($listCountryValue['list_value']).'</label></span></div>';
								
							}
						
						}
					
				}$this->data['listCountryValue'] .='';
			}
				*/
				
				//echo '<pre>'; print_r($this->data['SubPrdVal']->result()); die;
				$this->load->view('site/product/amenities_listing',$this->data);
		}
		
	public function address_listing($prdid='')
		{
			if ($this->checkLogin('U') != '')
			{
				$condition = array('id'=>$prdid,'user_id'=>$this->checkLogin('U'));
				$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);
				if($this->data['listDetail']->num_rows() > 0)
				{				
					$this->data['rental_address'] = $this->product_model->get_all_details(PRODUCT_ADDRESS_NEW,array('productId'=>$prdid));
					$this->load->view('site/product/address_listing',$this->data);
				}
				else
				redirect();
			}
			else
			{
				redirect();
			}
				
		}
		
		
		public function address_listing_old($prdid='')
		{
			if ($this->checkLogin('U') != '')
			{
				$condition = array('id'=>$prdid);
				$sortArr1 = array('field'=>'name','type'=>'asc');
				$sortArr = array($sortArr1);
				$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);
				
				$this->data['rental_address'] = $this->product_model->get_all_details(PRODUCT_ADDRESS,array('product_id'=>$prdid));
				//var_dump($this->data['rental_address']->row());die;
				$this->data['rental_address_country']=$this->data['rental_address']->row()->country;
				$this->data['rental_address_state']=$this->data['rental_address']->row()->state;
				$this->data['rental_address_city']=$this->data['rental_address']->row()->city;
				if($this->data['rental_address']->row()->city== ''){
					$this->data['RentalCityArr'] =  $this->product_model->get_all_details(CITY,array('name'=>$this->data['listDetail']->row()->city),$sortArr);
					$this->data['RentalStateArr'] = $this->product_model->get_all_details(STATE_TAX,array('id'=>$this->data['RentalCityArr']->row()->stateid),$sortArr);
					$this->data['RentalCountry'] = $this->product_model->get_all_details(COUNTRY_LIST,array('id'=>$this->data['RentalStateArr']->row()->countryid),$sortArr);
					
					$this->data['rental_address_country']=$this->data['RentalCountry']->row()->id;
					$this->data['rental_address_state']=$this->data['RentalStateArr']->row()->id;
					$this->data['rental_address_city']=$this->data['RentalCityArr']->row()->id;
				}
				
				
				
				$this->data['RentalCountry'] = $this->product_model->get_all_details(COUNTRY_LIST,array('status'=>'Active'),$sortArr);
				$this->data['RentalState'] = $this->product_model->get_all_details(STATE_TAX,array('status'=>'Active'),$sortArr);
				$this->data['RentalCity'] =  $this->product_model->get_all_details(CITY,array('status'=>'Active'),$sortArr);
				$this->data['NeiborCity'] =  $this->product_model->get_all_details(NEIGHBORHOOD,array('status'=>'Active'),$sortArr);
				$this->load->view('site/product/address_listing',$this->data);
			}
			else
			{
				redirect();
			}
				
		}
		
	public function insert_calendar()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$product_id = array('product_id'=>$prd_id);
					$dataArr = array('datefrom'=>$this->input->post('date_from'),
									'dateto'=>$this->input->post('date_to')
									);
					$data = array_merge($dataArr,$product_id);
					$this->data['bookingDetails'] = $this->product_model->get_all_details(PRODUCT_BOOKING,array('product_id'	=>	$prd_id));
					if($this->data['bookingDetails']->num_rows() > 0)
						{
							$this->product_model->update_details(PRODUCT_BOOKING,$dataArr,array('product_id'=>$prd_id));
						}
					else
						{
							$this->product_model->simple_insert(PRODUCT_BOOKING,$data);
						}
				}
			echo "<script>window.history.go(-1)</script>";exit();
		}
		
	public function insert_home_type()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$value = $this->input->post('value');
					$this->product_model->update_details(PRODUCT,array('home_type'=>$value),array('id'=>$prd_id));
				}
		}
	
	public function insert_room_type()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$value = $this->input->post('value');
					$this->product_model->update_details(PRODUCT,array('room_type'=>$value),array('id'=>$prd_id));
				}
		}
		
	public function insert_accommodates()
		{
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$value = $this->input->post('value');
					$this->product_model->update_details(PRODUCT,array('accommodates'=>$value),array('id'=>$prd_id));
				}
		}
		
	public function insert_bedrooms()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$value = $this->input->post('value');
					$this->product_model->update_details(PRODUCT,array('bedrooms'=>$value),array('id'=>$prd_id));
				}
		}
		
	public function insert_beds()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$value = $this->input->post('value');
					$this->product_model->update_details(PRODUCT,array('beds'=>$value),array('id'=>$prd_id));
				}
		}
		
	public function insert_bed_type()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$value = $this->input->post('value');
					$this->product_model->update_details(PRODUCT,array('bed_type'=>$value),array('id'=>$prd_id));
				}
		}
		
	public function insert_bathrooms()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$value = $this->input->post('value');
					$this->product_model->update_details(PRODUCT,array('bathrooms'=>$value),array('id'=>$prd_id));
				}
		}
		
	public function ch_price()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$price = $this->input->post('value');
					$price_range = '';
						if ($price>0 && $price<21){
							$price_range = '1-20';
						}else if ($price>20 && $price<101){
							$price_range = '21-100';
						}else if ($price>100 && $price<201){
							$price_range = '101-200';
						}else if ($price>200 && $price<501){
							$price_range = '201-500';
						}else if ($price>500){
							$price_range = '501+';
						}
					$this->product_model->update_details(PRODUCT,array('price'=>$price,'price_range'=>$price_range),array('id'=>$prd_id));
				}
		}
				
	public function ch_currency()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$value = $this->input->post('value');
					$this->product_model->update_details(PRODUCT,array('currency'=>$value),array('id'=>$prd_id));
				}
		}
		
	public function ch_title()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$value = $this->input->post('value');
					$this->product_model->update_details(PRODUCT,array('product_name'=>$value),array('id'=>$prd_id));
				}
		}
		
	public function ch_description()
		{
		
			if ($this->checkLogin('U') != '')
				{
					$prd_id = $this->input->post('prd_id');
					$value = $this->input->post('value');
					$this->product_model->update_details(PRODUCT,array('product_name'=>$value),array('id'=>$prd_id));
				}
		}
		
	public function ul_photo()
		{
			
			
			$prd_id = $this->input->post('prd_id');
			$this->product_model->commonDelete(PRODUCT_PHOTOS,array('product_id'=>$prd_id));
			$img_nameurl = $this->input->post('imgUploadUrl');
			$img_name =$this->input->post('imgUpload');			
			for($i=0;$i<count($img_name);$i++) {				
				$filePRoductUploadData = array('product_id'=>$prd_id,'product_image'=>$img_name[$i]);
			    $this->product_model->simple_insert(PRODUCT_PHOTOS,$filePRoductUploadData);
			
				
			}
			redirect(photos_listing."/".$prd_id);
			
					
				/*	$logoDirectory ='images/product';
                       if(!is_dir($logoDirectory))
                    	   {
                               mkdir($logoDirectory,0777);
                       	   }
                       //$config['overwrite'] = FALSE;
                    $config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
		    //$config['max_size'] = 2000;
		    $config['upload_path'] = 'images/product';
		    $this->load->library('upload', $config);
			if ( $this->upload->do_upload('rental_image')){
		    	$imgDetails = $this->upload->data();
		    	$inputArr['image'] = $imgDetails['file_name'];
				$imgGet=$imgDetails['file_name'];
			}*/
		
			
			
		}
		
	public function insert_address()
		{ 
			if ($this->checkLogin('U') != '')
				{
					//echo '<pre>';print_r($_POST);die;
					$prd_id = $this->input->post('product_id');
					$product_id = array('productId'=>$prd_id);
					$newAddress = '';
					if($this->input->post('address') != '')
					$newAddress .= ','.$this->input->post('address');
					if($this->input->post('city') != '')
					$newAddress .= ','.$this->input->post('city');
					if($this->input->post('state') != '')
					$newAddress .= ','.$this->input->post('state');
					if($this->input->post('country') != '')
					$newAddress .= ','.$this->input->post('country');
					if($this->input->post('post_code') != '')
					$newAddress .= ','.$this->input->post('post_code');
					$address = $this->input->post('address_location');
					$address = str_replace(" ", "+", $newAddress);
					$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$google_map_api");
					$json = json_decode($json);
					$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
					$lang = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
					
					$NeighborhoodStr = @implode(',',$this->input->post('neighborhood'));
			
					$dataArr = array('address'=>$this->input->post('address_location'),
									'country'=>$this->input->post('country'),
									'state'=>$this->input->post('state'),
									'city'=>$this->input->post('city'),
									'street'=>$this->input->post('address'),
									'zip'=>$this->input->post('post_code'),
									'lat'=> $lat,
									'lang'=> $lang
									);
									
					$data = array_merge($dataArr,$product_id);
					
					$this->data['productDetail'] = $this->product_model->get_all_details(PRODUCT_ADDRESS_NEW,array('productId'=>$prd_id));
					if($this->data['productDetail']->num_rows() > 0 )
						{
							$this->product_model->update_details(PRODUCT_ADDRESS_NEW,$dataArr,array('productId'=>$prd_id));
						}
					else
						{
							$this->product_model->simple_insert(PRODUCT_ADDRESS_NEW,$data);
						}
				}
			//redirect(current_url());
			echo "<script>window.history.go(-1)</script>";exit();
		}
		
	public function city_autocomplete($city)
	{
		$searchResult = explode('?',$_SERVER['REQUEST_URI']);
		$search = '(1=1';
		if(count($searchResult)>1)
		{
			$search_var = $searchResult[1];
			$search_array = explode('&',$search_var);
			if(!empty($search_array))
			{
				foreach($search_array as $key => $value)
				{
					$var = explode('=',$value);
					if($var[0]=='p'&&$var[1]!='')
					{
						$search .= ' and p.price_range="'.$var[1].'" ';
					}
					if($var[0]=='city'&&$var[1]!='')
					{
						$search .= ' and (c.name like "%'.$var[1].'%" or c.name = "%'.$var[1].'%") ';
					}
					if($var[0]=='datefrom'&&$var[1]!='')
					{
						$search .= ' and b.datefrom > "'.$var[1].'"  ';
					}
					if($var[0]=='expiredate'&&$var[1]!='')
					{
						$search .= ' and b.expiredate < "'.$var[1].'"  ';
					}
				}
			}
		}
		if($city!='search'&&$city!='')
		{
			$search .= ' and c.seourl = "'.$city.'"  ';
		}
		$search .= ' ) and ';
		$this->data['heading'] = '';
		$this->data['productList'] = $this->product_model->view_product_details_site('  where '.$search.' (u.group="Seller" and u.status="Active" or p.user_id=0 ) order by p.created desc');
		/*$this->data['product_image'] = $this->product_model->Display_product_image_details();
		$this->data['image_count'] = $this->product_model->Display_product_image_details_all();*/
		$this->load->view('site/product/listing',$this->data);
	}
	/***********For autocomplete***************/
	public function search_text()
	{
		$data = $this->input->post();
		$cities = $this->product_model->view_cities($data['text']);
		//echo $this->db->last_query();
		//print_r($cities);exit;
		if(!empty($cities))echo '<ul id="click_close">';
		$row_set = array();
			$state_arr = array();
			foreach ($cities as $row){
				if (!in_array($row['State'],$state_arr)){
					$row_set[] = array(
						'label' => htmlentities(stripslashes(ucwords(ucfirst($row['State']).','.strtoupper($row['country_name']).''))).'',
						'value' => ucfirst($row['State']).','.$row['country_code']
					);
					//echo stripslashes(ucwords(ucfirst($row['State']).','.strtoupper($row['country_name']).''));
					echo '<li class="for_auto_complete_text" style="text-transform:capitalize">';
					echo stripslashes(ucwords(ucfirst($row['State']).','.strtoupper($row['country_name']).''));
					echo '</li>';
					$state_arr[] = $row['State'];
				}
				$row_set[] = array(
					'label' => htmlentities(stripslashes(ucwords($row['name'].','.ucfirst($row['State']).','.strtoupper($row['country_name']).''))).'',
					'value' => htmlentities(stripslashes(ucwords(strtolower($row['name'])))).''.' ,'.ucfirst($row['State']).','.$row['country_code']
				);
				//echo stripslashes(ucwords($row['name'].','.ucfirst($row['State']).','.strtoupper($row['country_name']).''));
				echo '<li class="for_auto_complete_text" style="text-transform:capitalize">';
				echo stripslashes(ucwords($row['name'].','.ucfirst($row['State']).','.strtoupper($row['country_name']).''));
				echo '</li>';
      
      		}
			if(!empty($cities))echo '</ul>';
		exit;
	}
	
	public function update_old_list_values($product_id,$list_val_arr,$old_product_details=''){
		if ($old_product_details == '' || count($old_product_details)==0){
			$old_product_details = $this->product_model->get_all_details(PRODUCT,array('id'=>$product_id));
		}
		$old_product_list_values = array_filter(explode(',', $old_product_details->row()->list_value));
		if (count($old_product_list_values)>0){
			if (!is_array($list_val_arr)){
				$list_val_arr = array();
			}
			foreach ($old_product_list_values as $old_product_list_values_row){
				if (!in_array($old_product_list_values_row, $list_val_arr)){
					$list_val_details = $this->product_model->get_all_details(LIST_VALUES,array('id'=>$old_product_list_values_row));
					if ($list_val_details->num_rows()==1){
						$product_count = $list_val_details->row()->product_count;
						$products_in_this_list = $list_val_details->row()->products;
						$products_in_this_list_arr = array_filter(explode(',', $products_in_this_list));
						if (in_array($product_id, $products_in_this_list_arr)){
							if (($key = array_search($product_id, $products_in_this_list_arr))!==false){
								unset($products_in_this_list_arr[$key]);
							}
							$product_count--;
							$list_update_values = array(
								'products'=>implode(',', $products_in_this_list_arr),
								'product_count'=>$product_count
							);
							$list_update_condition = array('id'=>$old_product_list_values_row);
							$this->product_model->update_details(LIST_VALUES,$list_update_values,$list_update_condition);
						}
					}
				}
			}
		}
		
		if ($old_product_details != '' && count($old_product_details)>0 && $old_product_details->num_rows()==1){
		
		/*** Delete product id from lists which was created by users ***/
		
			$user_created_lists = $this->product_model->get_user_created_lists($old_product_details->row()->seller_product_id);
			if ($user_created_lists->num_rows()>0){
				foreach ($user_created_lists->result() as $user_created_lists_row){
					$list_product_ids = array_filter(explode(',', $user_created_lists_row->product_id));
					if (($key=array_search($old_product_details->row()->seller_product_id,$list_product_ids )) !== false){
						unset($list_product_ids[$key]);
						$update_ids = array('product_id'=>implode(',', $list_product_ids));
						$this->product_model->update_details(LISTS_DETAILS,$update_ids,array('id'=>$user_created_lists_row->id));
					}
				}
			}
		
		/*** Delete product id from product likes table and decrease the user likes count ***/
		
			$like_list = $this->product_model->get_like_user_full_details($old_product_details->row()->seller_product_id);
			if ($like_list->num_rows()>0){
				foreach ($like_list->result() as $like_list_row){
					$likes_count = $like_list_row->likes;
					$likes_count--;
					if ($likes_count<0)$likes_count=0;
					$this->product_model->update_details(USERS,array('likes'=>$likes_count),array('id'=>$like_list_row->id));
				}
				$this->product_model->commonDelete(PRODUCT_LIKES,array('product_id'=>$old_product_details->row()->seller_product_id));
			}
			
		/*** Delete product id from activity, notification and product comment tables ***/
			
			$this->product_model->commonDelete(USER_ACTIVITY,array('activity_id'=>$old_product_details->row()->seller_product_id));	
			$this->product_model->commonDelete(NOTIFICATIONS,array('activity_id'=>$old_product_details->row()->seller_product_id));
			$this->product_model->commonDelete(PRODUCT_COMMENTS,array('product_id'=>$old_product_details->row()->seller_product_id));	
		
		}
	}
	
	
	/**************/

	public function send_comment_noty_mail($pid='0',$cid='0'){
		if ($pid!= '0' && $cid != '0'){
			$likeUserList = $this->product_model->get_like_user_full_details($pid);
			if ($likeUserList->num_rows()>0){
				$productUserDetails = $this->product_model->get_product_full_details($pid);
				$commentDetails = $this->product_model->view_product_comments_details('where c.id='.$cid);
				if ($productUserDetails->num_rows()>0 && $commentDetails->num_rows()==1){
					foreach ($likeUserList->result() as $likeUserListRow){
						$emailNoty = explode(',', $likeUserListRow->email_notifications);
						if (in_array('comments_on_fancyd', $emailNoty)){
							if ($productUserDetails->prodmode == 'seller'){
								$prodLink = base_url().'things/'.$productUserDetails->row()->id.'/'.url_title($productUserDetails->row()->product_name,'-');
							}else {
								$prodLink = base_url().'user/'.$productUserDetails->row()->user_name.'/things/'.$productUserDetails->row()->seller_product_id.'/'.url_title($productUserDetails->row()->product_name,'-');
							}
                            
                            $newsid='8';
                            $template_values=$this->product_model->get_newsletter_template_details($newsid);
                            $adminnewstemplateArr=array('logo'=> $this->data['logo'],'meta_title'=>$this->config->item('meta_title'),'full_name'=>$likeUserListRow->full_name,'cfull_name'=>$commentDetails->row()->full_name,'user_name'=>$commentDetails->row()->user_name,'product_name'=>$productUserDetails->row()->product_name);
                            extract($adminnewstemplateArr);
                            $subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
                            $message = '<!DOCTYPE HTML>
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
							$this->product_model->simple_insert(INBOX,array('sender_id'=>$sender_email,'user_id'=>$likeUserListRow->email,'mailsubject'=>$subject,'description'=>stripslashes($message)));
							
							$email_values = array('mail_type'=>'html',
												'from_mail_id'=>$sender_email,
												'mail_name'=>$sender_name,
												'to_mail_id'=>$likeUserListRow->email,
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
	
	public function language_change(){
		$language_code= $this->uri->segment('2');
		$selectedLangCode = $this->session->set_userdata('language_code',$language_code);
		$selectedLangCode=$this->session->userdata('language_code');
		//header("Location:".base_url());
		redirect('');
	}

	public function gen_search($rental)
	{
		$searchResult = explode('?',$_SERVER['REQUEST_URI']);
		if(count($searchResult)>1)
			{
				$search_var = $searchResult[1];
				$search_array = explode('&',$search_var);
			}
		$res =  explode('=',$search_array[0]); 
		if($res[1]!='search'&&$res[1]!='')
			{
				$this->data['heading']='Search keyword is '.trim(str_replace('+', ' ', $res[1]));
				$this->data['gensearch']='search';
				$search = ' c.name = "'.trim(str_replace('+', ' ', $res[1])).'" and';
				$this->data['productList'] = $this->product_model->view_product_details_sitemapview('  where '.$search.' (u.group="Seller" and u.status="Active" or p.user_id=0 ) group by p.id order by p.created desc');
				//echo $this->db->last_query();die;
				
				//$this->data['productList'] = $this->product_model->view_product_details_site('  where '.$search.' and p.status="Publish" group by p.id order by p.created desc');
			}else{ 
				$this->setErrorMessage('error','Empty searches are not allowed');
				redirect(base_url());
			}
		$this->data['product_image'] = $this->product_model->Display_product_image_details();
		$this->data['image_count'] = $this->product_model->Display_product_image_details_all();
		$this->data['CityListDisplay'] = $this->product_model->get_all_details(CITY,array());
		$this->load->view('site/rentals/rental_list',$this->data);
	}
	
	
	function ajaxdateCalculate(){
		$id=$this->input->post('pid');
		$Price = $this->input->post('price');
		$CalendarDateArr = explode(',',$this->input->post('dateval'));
		
		foreach($CalendarDateArr as $CalendarDateRow){
			$CalendarTimeDateArr = explode(' GMT',$CalendarDateRow);
			$sadfsd=trim($CalendarTimeDateArr[0]);
			$startDate = strtotime($sadfsd);    
			$result[] =  date("Y-m-d",$startDate);
		}
		$DateCalCul=0;
		$this->data['ScheduleDatePrice'] = $this->product_model->get_all_details(SCHEDULE,array('id'=>$id));
		if($this->data['ScheduleDatePrice']->row()->data !=''){
			$dateArr=json_decode($this->data['ScheduleDatePrice']->row()->data);
			$finaldateArr=(array)$dateArr;
			foreach($result as $Rows){
				if (array_key_exists($Rows, $finaldateArr)) {
					$DateCalCul= $DateCalCul+$finaldateArr[$Rows]->price;
				}else{
					$DateCalCul= $DateCalCul+$Price;
				}l;
			}
		}else{
			$DateCalCul = (count($result) * $Price);
		}
		$service_tax_query='SELECT * FROM '.COMMISSION.' WHERE commission_type="Guest Booking" AND status="Active"';
		$service_tax=$this->product_model->ExecuteQuery($service_tax_query);
		if($service_tax->num_rows() == 0)
		{
			$this->data['taxValue'] = '0.00';
			$this->data['taxString'] = 'No Tax';
		}
		else 
		{
			$this->data['commissionType'] = $service_tax->row()->promotion_type;
			$this->data['commissionValue'] = $service_tax->row()->commission_percentage;
			if($service_tax->row()->promotion_type=='flat')
			{
				$this->data['taxValue'] = $service_tax->row()->commission_percentage;
				$this->data['taxString'] = $service_tax->row()->commission_percentage * $this->session->userdata('currency_r');
			}
			else
			{
				$finalTax = ( $service_tax->row()->commission_percentage * $DateCalCul)/100;
				$this->data['taxValue'] = $finalTax;
				$this->data['taxString'] = $finalTax * $this->session->userdata('currency_r');
			}
		}
		$this->data['total_nights'] = count($result);
		$this->data['total_value'] = stripslashes($DateCalCul) * $this->session->userdata('currency_r');
		$this->data['net_total_string'] = $this->data['total_value'] + $this->data['taxString'];
		$this->data['net_total_value'] = stripslashes($DateCalCul) + $this->data['taxValue'];
		$this->data['requestType'] = 'booking_request';
		$this->load->view('site/rentals/price_value',$this->data);
	}
	
	function ajaxdateCalculateContact(){
		$id=$this->input->post('pid');
		$Price = $this->input->post('price');
		$CalendarDateArr = explode(',',$this->input->post('dateval'));
		
		foreach($CalendarDateArr as $CalendarDateRow){
			$CalendarTimeDateArr = explode(' GMT',$CalendarDateRow);
			$sadfsd=trim($CalendarTimeDateArr[0]);
			$startDate = strtotime($sadfsd);    
			$result[] =  date("Y-m-d",$startDate);
		}
		$DateCalCul=0;
		$this->data['ScheduleDatePrice'] = $this->product_model->get_all_details(SCHEDULE,array('id'=>$id));
		if($this->data['ScheduleDatePrice']->row()->data !=''){
			$dateArr=json_decode($this->data['ScheduleDatePrice']->row()->data);
			$finaldateArr=(array)$dateArr;
			foreach($result as $Rows){
				if (array_key_exists($Rows, $finaldateArr)) {
					$DateCalCul= $DateCalCul+$finaldateArr[$Rows]->price;
				}else{
					$DateCalCul= $DateCalCul+$Price;
				}l;
			}
		}else{
			$DateCalCul = (count($result) * $Price);
		}
		$service_tax_query='SELECT * FROM '.COMMISSION.' WHERE commission_type="Guest Booking" AND status="Active"';
		$service_tax=$this->product_model->ExecuteQuery($service_tax_query);
		if($service_tax->num_rows() == 0)
		{
			$this->data['taxValue'] = '0.00';
			$this->data['taxString'] = 'No Tax';
		}
		else 
		{
			$this->data['commissionType'] = $service_tax->row()->promotion_type;
			$this->data['commissionValue'] = $service_tax->row()->commission_percentage;
			if($service_tax->row()->promotion_type=='flat')
			{
				$this->data['taxValue'] = $service_tax->row()->commission_percentage;
				$this->data['taxString'] = $service_tax->row()->commission_percentage * $this->session->userdata('currency_r');
			}
			else
			{
				$finalTax = ( $service_tax->row()->commission_percentage * $DateCalCul)/100;
				$this->data['taxValue'] = $finalTax;
				$this->data['taxString'] = $finalTax * $this->session->userdata('currency_r');
			}
		}
		$this->data['total_nights'] = count($result);
		$this->data['total_value'] = stripslashes($DateCalCul) * $this->session->userdata('currency_r');
		$this->data['net_total_string'] = $this->data['total_value'] + $this->data['taxString'];
		$this->data['net_total_value'] = stripslashes($DateCalCul) + $this->data['taxValue'];
		$this->data['requestType'] = 'contact_host';
		$this->load->view('site/rentals/price_value',$this->data);
	}
		
	function ajaxdateCalculateOld()
		{
		#echo 'sssss';die;
			$CalendarDateArr = explode(',',$this->input->post('dateval'));
			
			echo $Price = $this->input->post('price'); die;
			
			foreach($CalendarDateArr as $CalendarDateRow){
				$CalendarTimeDateArr = explode(' GMT',$CalendarDateRow);
				
				$sadfsd=trim($CalendarTimeDateArr[0]);
				$startDate = strtotime($sadfsd);    
				$result[] =  date("Y-m-d",$startDate);
			}
			
			$this->data['ScheduleDatePrice'] = $this->product_model->get_all_details(SCHEDULE,array('id'=>$this->input->post('pid')));
			
			if($this->data['ScheduleDatePrice']->row()->data !=''){
			
				$getDateArrs=explode('},"',$this->data['ScheduleDatePrice']->row()->data);
				foreach($getDateArrs as $details1)
				{
					$getDateArrs1[]=explode('":{"',$details1);//echo $details1."<br>";	 
				
				}
				
				/********** Get the date values as array start ************/
				$date_array = array();
				foreach($getDateArrs1 as $details1)
				{//echo $statusChk[1];
					$statusChk=explode('"status":"',$details1[1]);
					//echo $statusChk[1].'//';
					if(trim($statusChk[1])=='booked"'){
						$date_array[]=$details1[0];//echo $details1."<br>";	 
					}
				}
				
				$date_array1 = array();
				foreach($date_array as $date_array_dtls)
				{
				
					$date_array1[] =  str_replace('{"', '', $date_array_dtls);
					
				
				}
				
				/********** Get the date values as array end ************/
				
				/********** Get the date values result as array start ************/
				
				
				$date_result_array1 = array();
				$date_result_array_explode = array();
				foreach($getDateArrs1 as $getDateArr_result)
				{
					$date_result_array1[] = $getDateArr_result[1];
					$date_result_array_explode[] = explode(',"',$getDateArr_result[1]);
					
				}
				//":
				//echo "<pre>";print_r($date_result_array_explode);
				$date_result_array_explode1 = array();
				$date_result_array_explode2 = array();
				$date_result_array_explode3 = array();
				$date_result_array_explode4 = array();
				$date_result_array_final = array();
				$loop_start_val = 0;
				foreach($date_result_array_explode as $date_result_array_explode1)
				{	
					
					foreach($date_result_array_explode1 as $date_result_array_explode2)
					{
						
						$date_result_array_explode3  = explode('":',$date_result_array_explode2);
						$date_result_array_final[$loop_start_val][$date_result_array_explode3[0]] = str_replace('"', '', $date_result_array_explode3[1]);
						
					}
					
					$loop_start_val = $loop_start_val+1;
				}
				//echo '<pre>';print_r($result);print_r($date_array1);print_r($getDateArrs1);die;
				foreach($result as $RowDate){
					if(in_array($RowDate,$date_array1)){
						echo 'Date Already Booked';
						return;
					}
				}
				
				
				foreach ($date_result_array_final as $key => $value) {
						if(in_array($date_array1[$key],$result)){
						 	$DateCalCul+= $value['price'];
							$DateCalCuluArr[]= $date_array1[$key];
						 }/*else{
						  	$DateCalCul= $DateCalCul + $Price;
							$DateCalCuls .= $date_array1[$key].',';
						 }*/
				 		
				}
				
				foreach($result as $Rows){
						if(!in_array($Rows,$DateCalCuluArr)){
						 	$DateCalCul+= $Price;
						 }
				}
			}else{
				
					$DateCalCul = (count($result) * $Price);
				}			
			
			echo $DateCalCul.'/'.count($result);
		}
		
		
		
		public function edit_calendar(){
			//$user_id = $this->uri->segment(4,0);
			//$price = $this->uri->segment(5,0);
			$user_id = $this->input->get('pid'); 
			$price = $this->input->get('price'); 
			$this->data['productList'] = $user_id;	
			
			//$this->load->view('site/product/front_calendar',$this->data);
		
			
			/*
			echo '
        <link rel="stylesheet" type="text/css" href="'.base_url().'css/jquery.dop.BackendBookingCalendarPRO.css" />

<link rel="stylesheet" type="text/css" href="'.base_url().'css/style.css" />
<script type="text/JavaScript" src="'.base_url().'js/jquery-latest.js"></script>

<script type="text/JavaScript" src="'.base_url().'js/jquery.dop.BackendBookingCalendarPRO.js"></script>

<script type="text/JavaScript">
            $(function(){

				$("#backend").DOPBackendBookingCalendarPRO({
		"ID": '.$user_id.',
		"DataURL": "'.base_url().'dopbcp/php-database/load.php"
	});
            });
        </script>
<div id="wrapper">
     <div id="backend-container">
      <div id="backend"></div>
  </div>
</div>
';*/


echo '

<link rel="stylesheet" type="text/css" href="'.base_url().'css/jquery.dop.BackendBookingCalendarPRO.css" />
<link rel="stylesheet" type="text/css" href="'.base_url().'css/style.css" />
<script type="text/JavaScript" src="'.base_url().'js/jquery-latest.js"></script>
<script type="text/JavaScript" src="'.base_url().'js/jquery.dop.BackendBookingCalendarPRO.js"></script>

<script type="text/JavaScript">
            $(document).ready(function(){
			    $("#backend").DOPBackendBookingCalendarPRO({
				"ID": '.$user_id.',
		"DataURL": "'.base_url().'dopbcp/php-database/load.php",
       "SaveURL": "'.base_url().'dopbcp/php-database/save.php"
});


                $("#backend").DOPBackendBookingCalendarPRO({"DataURL": "dopbcp/php-database/load.php",
                                                            "SaveURL": "dopbcp/php-database/save.php"});

                $("#backend-refresh").click(function(){
                    $("#backend").DOPBackendBookingCalendarPRO({"Reinitialize": true});
              
                    $("#backend").DOPBackendBookingCalendarPRO({"Reinitialize": true,
                                                                "DataURL": "dopbcp/php-database/load.php",
                                                                "SaveURL": "dopbcp/php-database/save.php"});
                });
            });
        </script>
	<input type="hidden" value="'.$price.'" name="comprice" id="comprice">	
</head>
<body>
<div id="wrapper">
  <div id="backend-container">

    <div id="backend"></div>
  </div>
</div>
<b style="color:#FF0000">Note:</b> Click once on the start date and slide until to the end date and click once on end date, to select the inbetween dates and select "available" from the status field, enter the "price" in price field and click submit to book the dates
';

			
	}
	
	public function add_review()
	{
		if($_POST['proid']!=''){
			$dataArr = array( 'review'=>$_POST['review'], 'status'=>'Inactive', 'product_id'=>$_POST['proid'], 'user_id'=>$_POST['user_id'], 'reviewer_id'=>$_POST['reviewer_id'], 'email'=>$_POST['reviewer_email'], 'bookingno'=>$_POST['bookingno'], 'total_review'=>$_POST['total_review']);

			$insertquery = $this->product_model->add_review($dataArr);
			$this->setErrorMessage('success','Review received, will be added after approval');
		}
		redirect('trips/upcoming');
	}
	
	public function display_review(){
		if($this->data['loginCheck'] !=''){
			$this->data['ReviewDetails']=$this->review_model->get_productreview_aboutyou($this->data['loginCheck']);
			$this->data['uId']=$this->data['loginCheck'];
			$this->load->view('site/user/review',$this->data);
		}
		else{
			redirect(base_url());
		}
	}
	
	public function display_review1(){
		if($this->data['loginCheck'] !=''){
		$this->data['ReviewDetails']=$this->review_model->get_productreview_byyou($this->data['loginCheck']);
		$this->data['uId']=$this->data['loginCheck'];
		$this->load->view('site/user/reviewbyyou',$this->data);
		}else{
		redirect(base_url());
		}
	}
	
	public function delete_property_details(){
		//$this->setErrorMessage('success','Review received, will be added after approval');
		if($this->data['loginCheck'] !=''){
			$product_id=$this->uri->segment(4,0);
			$this->product_model->commonDelete(PRODUCT,array('id' => $product_id));
			$this->product_model->commonDelete(PRODUCT_PHOTOS,array('product_id' => $product_id));
			$this->product_model->commonDelete(PRODUCT_ADDRESS,array('product_id' => $product_id));
			$this->product_model->commonDelete(PRODUCT_BOOKING,array('product_id' => $product_id));
			$this->product_model->commonDelete(SCHEDULE,array('id' => $product_id));
			//$this->product_model->commonDelete(CONTACT,array('rental_id' => $product_id));
			
			
			$this->setErrorMessage('success','Rental Deleted Successfully');
			redirect(base_url().'listing/all');
		}else{
		
			
			$this->setErrorMessage('error','Invalid Delete Rentals Details');
			redirect(base_url());
		}
	}
	public function GetDays($sStartDate, $sEndDate){  
      // Firstly, format the provided dates.  
      // This function works best with YYYY-MM-DD  
      // but other date formats will work thanks  
      // to strtotime().  
      $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
      $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));  
      
      // Start the variable off with the start date  
      $aDays[] = $sStartDate;  
      
      // Set a 'temp' variable, sCurrentDate, with  
      // the start date - before beginning the loop  
      $sCurrentDate = $sStartDate;  
      
      // While the current date is less than the end date  
      while($sCurrentDate < $sEndDate){  
        // Add a day to the current date  
        $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
      
        // Add this new day to the aDays array  
        $aDays[] = $sCurrentDate;  
      }  
      
      // Once the loop has finished, return the  
      // array of days.  
      return $aDays;  
    }
	
	public function change_currency(){
	  $c_id = $this->uri->segment(2,0);
	  $s_id = $this->input->post('store_id');
	  $pid = $this->uri->segment(2,0);
	  if($c_id >=1){
		    $currency_values = $this->product_model->get_all_details(CURRENCY,array('status'=>'Active','id'=>$c_id));
		    if($currency_values->num_rows() ==1){
			foreach($currency_values->result() as $currency_v){
			$this->session->set_userdata('currency_type',$currency_v->currency_type) ;
			$this->session->set_userdata('currency_s',$currency_v->currency_symbols) ; 
			$this->session->set_userdata('currency_r',$currency_v->currency_rate) ;
			if(isset($_SERVER['HTTP_REFERER']))
			{
			$a=$_SERVER['HTTP_REFERER'];
			redirect($a);
			}
			else
			{
			echo '<script>window.history.go(-1)</script>';
			}
		 }}
		}else{
			if(isset($_SERVER['HTTP_REFERER']))
			{
			$a=$_SERVER['HTTP_REFERER'];
			redirect($a);
			}
			else
			{
			echo '<script>window.history.go(-1)</script>';
			}
		}
	}
	
	
	/* redirect base url */
	
	
	public function redirect_base() {
	if ($this->checkLogin ( 'U' ) == '') {
		redirect ( 'default_controller' );
		}else{
	$hosting_commission_status='SELECT * FROM '.COMMISSION.' WHERE commission_type="Host Listing"';
	$this->data ['hosting_commission_status']=$this->product_model->ExecuteQuery($hosting_commission_status);
			
	if($this->uri->segment(4)=='completed')
	{
	$this->session->set_userdata('enable_complete_popup','yes');
    //$this->setErrorMessage('success','Your space have been added successfully ! Waiting for approval ');
	$pid = $this->uri->segment(5);
	$this->data['productdetail'] = $this->product_model->get_all_details(PRODUCT,array("id"=>$this->uri->segment(5)));
	//$productdetail->row()->user_id;
	//$this->data['userdetail'] = $this->product_model->get_all_details(USER,array("id"=>$productdetail->row()->user_id));
	$this->guideapproval($pid);
	$this->guideapprovalbyhost($pid);
	
	redirect(base_url('listing/all'));
	
	}
	else if($this->uri->segment(4)=='payment')
	{
	//$this->data['productList'] = $this->product_model->view_product_details_booking(' where p.id="'.$Rental_id.'" group by p.id order by p.created desc limit 0,1');
	
	$payment_query='SELECT * FROM '.COMMISSION.' WHERE commission_type="Host Listing"';
	$this->data['hosting_payment_details']=$this->product_model->ExecuteQuery($payment_query);

	$ProductDetail_query='SELECT * FROM '.PRODUCT.' WHERE id='.$this->uri->segment(5);
	$this->data['ProductDetail']=$this->product_model->ExecuteQuery($ProductDetail_query);
	//echo "<pre>"; print_r($ProductDetail->row()); die;
    $this->afterlistcompleted($this->uri->segment(5));
	$this->afterlistedadmin($this->uri->segment(5));
	
	     $uniid = "A".time();
		 $this->data['RefNo'] = $uniid;
		 $source ="DbQhpCuQpPM07244".$uniid."100MYR";		
		 $val = sha1($source);		
		$rval = $this->hex2bin($val);
		$this->data['signature']=  base64_encode($rval);
		 
	
	
    $this->load->view('site/product/payment',$this->data);
	}
	else{
	        $condition = array('id'=>$this->uri->segment(4));
			$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,$condition);
			$this->load->view('site/product/phone_verification',$this->data);
		}
		}
	}
	
	function hex2bin( $str ) {
        $sbin = "";
        $len = strlen( $str );
        for ( $i = 0; $i < $len; $i += 2 ) {
            $sbin .= pack( "H*", substr( $str, $i, 2 ) );
        }

        return $sbin;
    }
	
	/* mail to */
	public function guideapproval($id) {
	
	$this->data['detail'] = $this->cms_model->get_all_details(PRODUCT,array('id'=>$id));
	
	$this->data['userdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->user_id));
	
	
	$this->data['hostdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->user_id));
	
	$RentalPhoto = $this->cms_model->get_all_details(PRODUCT_PHOTOS,array('product_id'=>$id));
	
	//$this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT,array('id'=>$this->data['detail']->row()->prd_id));
	
	
	   $newsid = '32';
		$template_values = $this->cms_model->get_newsletter_template_details ($newsid);
		$proImages=base_url().PRODUCTPATH.$RentalPhoto->row()->product_image;
		$pieces = explode(" ", $this->data['productdetail']->row()->created);
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ('email_title' ),
				'logo' => $this->data ['logo'],
				'travelername'=>$this->data['userdetail']->row()->firstname."  ".$this->data['userdetail']->row()->lastname,
				'propertyname'=>$this->data['productdetail']->row()->product_title,
				'propertydate'=>$pieces[0],
				'propertytime'=>$pieces[1],
				'propertyid'=>$this->data['productdetail']->row()->id,
				'propertyprice'=>$this->data['productdetail']->row()->price,
				'hostname'=>$this->data['hostdetail']->row()->firstname." ".$this->data['hostdetail']->row()->lastname,
				'rental_image'=>$proImages
				
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
	
	$this->data['detail'] = $this->cms_model->get_all_details(PRODUCT,array('id'=>$id));
	
	$this->data['userdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->user_id));
	
	
	$this->data['hostdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->user_id));
	
	//$this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT,array('id'=>$this->data['detail']->row()->prd_id));
	
	
	   $newsid = '31';
		$template_values = $this->cms_model->get_newsletter_template_details ($newsid);
		$pieces = explode(" ", $this->data['productdetail']->row()->created);
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ('email_title' ),
				'logo' => $this->data ['logo'],
				'travelername'=>$this->data['userdetail']->row()->firstname."  ".$this->data['userdetail']->row()->lastname,
				'propertydate'=>$pieces[0],
				'propertytime'=>$pieces[1],
				'propertyname'=>$this->data['productdetail']->row()->product_title,
				'propertyid'=>$this->data['productdetail']->row()->id,
				'propertyprice'=>$this->data['productdetail']->row()->price,
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
				'to_mail_id' => $template_values ['sender_email'],				
				'subject_message' => $template_values ['news_subject'],
				'body_messages' => $message 
		);
		//echo '<pre>'; print_r($email_values);die;
					 
			$this->cms_model->common_email_send($email_values);
	
	
	}
	
	
	
	
	
	
	
	public function afterlistcompleted($id) {
	
	 $condition = array('id'=>$id);
	 $this->data['property'] = $this->product_model->get_all_details(PRODUCT,$condition);
	 
	 $this->data['user'] = $this->product_model->get_all_details(USERS,array('id'=>$this->data['property']->row()->user_id));
	 $createdDate = $this->data['property']->row()->created;
	 $dateAndTime = explode(" ", $createdDate);
	 $cdate = $dateAndTime[0];
	 $ctime = $dateAndTime[1];
	
	 
	 
	 
	
	    $newsid = '21';
		$template_values = $this->user_model->get_newsletter_template_details ( $newsid );
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ('email_title'),
				'logo' => $this->data ['logo'],
				'propertyname'=>$this->data['property']->row()->product_title,
				'propertyid'=>$this->data['property']->row()->id,				
				'price'=>$this->data['property']->row()->price,
				'host_name'=> $this->data['user']->row()->firstname." ".$this->data['user']->row()->lastname,
				'cdate'=>$cdate,
				'ctime'=>$ctime
				
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ('email_title') . ' - ' . $template_values ['news_subject'];
		$header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		
		$message .= '<body>';
		include ('./newsletter/registeration' . $newsid . '.php');
		
		$message .= '</body>';
		
		if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
			$sender_email = $this->config->item ('site_contact_mail');
			$sender_name = $this->config->item ('email_title');
		} else {
			$sender_name = $template_values ['sender_name'];
			$sender_email = $template_values ['sender_email'];
		}
		
		
		
		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $this->data['user']->row()->email, 
				'subject_message' => 'List added confirmation Mail',
				'body_messages' => $message 
		);
			
		//echo '<pre>'; print_r($email_values); die;	 
		$this->contact_model->common_email_send($email_values);
	
	}
	
	
	
	
	
	
	public function afterlistedadmin($id)
	{
	 $condition = array('id'=>$id);
	 $this->data['property'] = $this->product_model->get_all_details(PRODUCT,$condition);
	
	 $this->data['user'] = $this->product_model->get_all_details(USERS,array('id'=>$this->data['property']->row()->user_id));
	 $createdDate = $this->data['property']->row()->created;
	 $dateAndTime = explode(" ", $createdDate);
	 $cdate = $dateAndTime[0];
	 $ctime = $dateAndTime[1];
	
	 
	
		$newsid = '22';
		$template_values = $this->user_model->get_newsletter_template_details ( $newsid );
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ('email_title'),
				'logo' => $this->data ['logo'],
				'propertyname'=>$this->data['property']->row()->product_title,
				'propertyid'=>$this->data['property']->row()->id,				
				'price'=>$this->data['property']->row()->price,
				'host_name'=> $this->data['user']->row()->firstname.$this->data['user']->row()->lastname,
				'cdate'=>$cdate,
				'ctime'=>$ctime
				
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ('email_title') . ' - ' . $template_values ['news_subject'];
		$header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		
		$message .= '<body>';
		include ('./newsletter/registeration' . $newsid . '.php');
		
		$message .= '</body>';
		
		if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
			$sender_email = $this->config->item ('site_contact_mail');
			$sender_name = $this->config->item ('email_title');
		} else {
			$sender_name = $template_values ['sender_name'];
			$sender_email = $template_values ['sender_email'];
		}
		
		
		
		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $this->data['user']->row()->email, 
				'subject_message' => 'List added confirmation Mail',
				'body_messages' => $message 
		);
			
			 
		$this->contact_model->common_email_send($email_values);
	}
	
	
	
	
	public function get_sublist_values(){
		
		$list_value_id = $this->input->post('list_value_id');
		//echo $list_value_id;
		$this->data['result'] = $this->product_model->get_all_details(LIST_SUB_VALUES,array('list_value_id' => $list_value_id));
		//print_r($this->data['result']); die;
		$returnstr['amenities'] = $this->load->view('site/product/display_li',$this->data,true);
		echo json_encode($returnstr);
	}
	
	
	
	public function deleteProductImage()
	{
		$returnArr['resultval']='';
		

			$prdID = $this->input->post('prdID');

			$condition =array('id'=>$prdID);
            $this->product_model->commonDelete(PRODUCT_PHOTOS,array('id' => $prdID));
			
			$returnArr['resultval']=$prdID;
			echo json_encode($returnArr);
		
	}
	
	public function product_verification()
	{
	if($this->data['loginCheck'] =="")
	{
	redirect(base_url());
	}
	
$mobile_code_query='SELECT country_mobile_code FROM '.LOCATIONS.' WHERE id='.$this->data['userDetails']->row()->country;
	$mobile_code=$this->product_model->ExecuteQuery($mobile_code_query);
	$mobile_code=$mobile_code->row()->country_mobile_code;
	
require_once('twilio/Services/Twilio.php');
//$account_sid = 'AC86dee6bbb798dfa194415808420c6518'; 
//$auth_token = '0a4495ba71d620a5981f0527743e5de4'; 
$account_sid = $this->config->item('twilio_account_sid'); 
$auth_token = $this->config->item('twilio_account_token');
 
$random_confirmation_number = mt_rand(100000, 999999);
            $excludeArr=array('product_id');
            $dataArr=array('mobile_verification_code'=>$random_confirmation_number);
			$condition=array('id'=>$this->input->post('product_id'));
			$this->product_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,$dataArr,$condition);

$from=$this->config->item('twilio_phone_number');
$to=$mobile_code.$this->data['userDetails']->row()->phone_no;

/* $client = new Services_Twilio($account_sid, $auth_token); 
$client->account->messages->create(array( 
	//'To' => "+919962886314",
	//'From' => "+14703308893",
    'To' => $to,	
	'From' =>$from, 
	'Body' => "Hi This is from Staynest and Your Verification Code is ".$random_confirmation_number,   
   )); */
   echo 'success';
}
	
	public function check_phone_verification()
	{
	
	       
            $mobile_verification_code=$this->input->post('mobile_verification_code');
            $phone_verify_query='SELECT * FROM '.USERS.' WHERE id='.$this->checkLogin('U').' AND mobile_verification_code="'.$mobile_verification_code.'"';
			$match_row=$this->db->query($phone_verify_query);
			if($match_row->num_rows()==1)
			{
			$this->db->select('*');
			$this->db->from(USERS);
			$this->db->where('id',$this->checkLogin('U'));
			$row=$this->db->get();
			if($row->num_rows()==1)
			{
			$excludeArr=array('mobile_verification_code');
            $dataArr=array('ph_verified'=>'Yes');
            $condition=array('id'=>$this->checkLogin('U'));
			$this->product_model->commonInsertUpdate(USERS,'update',$excludeArr,$dataArr,$condition);
			}
			else{
			$excludeArr=array('mobile_verification_code');
            $dataArr=array('id'=>$this->checkLogin('U'),'ph_verified'=>'Yes');
            $condition=array();
			$this->product_model->commonInsertUpdate(USERS,'insert',$excludeArr,$dataArr,$condition);
			}
            echo 'success';
			$this->setErrorMessage('success','Phone Number Verified Successfully');
			}
			else{
			echo 'fail';
			}
			
			
	}
	
	
	public function HostPayment(){
	    $product_id = $this->uri->segment(4);
		
		//delete failed payment for particular user
		$host_payment=$this->product_model->get_all_details(HOSTPAYMENT,array('product_id' => $product_id,'host_id'=>$this->checkLogin('U')));
		if($host_payment->num_rows() >0)
		{
		$delete_failed_payment='DELETE FROM '.HOSTPAYMENT.' WHERE product_id='.$product_id.' AND host_id='.$this->checkLogin('U');
		$this->product_model->ExecuteQuery($delete_failed_payment);
		}
		
	
		$product = $this->product_model->get_all_details(PRODUCT,array('id' => $product_id));
		$seller = $this->product_model->get_all_details(USERS,array('id' => $product->row()->user_id));
             /*Paypal integration start */
			$this->load->library('paypal_class');
			
			$item_name = $this->config->item('email_title').' Products';
			
			$totalAmount = $this->uri->segment(5);
			
			$usdvalue = $this->product_model->get_all_details(CURRENCY,array('currency_type'=>'MYR'));
            $totalAmount = $totalAmount * $usdvalue->row()->currency_rate;
            $loginUserId = $this->checkLogin('U');
			
			//$lastFeatureInsertId = $this->session->userdata('randomNo');
			
			$quantity = 1;
            $insertIds = array();
			
			$now = date("Y-m-d H:i:s");
			$paymentArr=array(
			'product_id'=>$product_id,
			'amount'=>$totalAmount,
            'host_id'=>$loginUserId,
            'payment_status' => 'Pending',
			'payment_type' => 'paypal'
			);
			$this->product_model->simple_insert(HOSTPAYMENT,$paymentArr);
			 $insertIds[]=$this->db->insert_id();
			$paymtdata = array(
								'randomNo' => $dealCodeNumber,
								'randomIds' => $insertIds
							);
							
			$this->session->set_userdata($paymtdata);
			 
			$paypal_settings=unserialize($this->config->item('payment_0'));
			
			$paypal_settings=unserialize($paypal_settings['settings']);
			if($paypal_settings['mode'] == 'sandbox'){
				$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
			}else{
				$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
			}
			$ctype = ($paypal_settings['mode'] == 'sandbox')?"USD":"MYR";
			
			// To change the currency type for below line >> Sandbox: USD, Live: MYR
			$CurrencyType = $this->product_model->get_all_details(CURRENCY,array('currency_type' => $ctype )); 
			
			
			$this->paypal_class->add_field('currency_code', $CurrencyType->row()->currency_type); //   USD
			
			$totAmt = $totalAmount * $CurrencyType->row()->currency_rate;
			
            $this->paypal_class->add_field('business',$paypal_settings['merchant_email']); // Business Email
			
			$this->paypal_class->add_field('return',base_url().'host-payment-success/'.$product_id); // Return URL
			
			$this->paypal_class->add_field('cancel_return', base_url().'order/failure'); // Cancel URL
			
			$this->paypal_class->add_field('notify_url', base_url().'order/ipnpayment'); // Notify url
			
			$this->paypal_class->add_field('custom', 'Product|'.$loginUserId.'|'.$lastFeatureInsertId); // Custom Values			
			
			$this->paypal_class->add_field('item_name', $item_name); // Product Name
			
			$this->paypal_class->add_field('user_id', $loginUserId);
			
			$this->paypal_class->add_field('quantity', $quantity); // Quantity
			//echo $totalAmount;die;
			 // $this->paypal_class->add_field('amount', $totalAmount); // Price
			  $this->paypal_class->add_field('amount', number_format($totAmt,2,'.',''));
			//$this->paypal_class->add_field('amount', 1); // Price
			
			//echo base_url().'order/success/'.$loginUserId.'/'.$lastFeatureInsertId; die;
			
			$this->paypal_class->submit_paypal_post(); 
						
	}
	
	public function hostpayment_success()
	{
	
			$transId = $_REQUEST['txn_id'];
			$Pray_Email = $_REQUEST['payer_email'];			
			$payment_gross = $_REQUEST['payment_gross'];
			//var_dump($_REQUEST);die;
			$bookingId = 'EN'.time();
			$this->data['payment_gross'] = $payment_gross;
			$this->data['bookingId'] = $bookingId;
	        $dataArr = array('paypal_txn_id' => $transId,'paypal_email' => $Pray_Email,'payment_status'=>'paid', 'bookingId'=>$bookingId);
			
			$condition=array('product_id'=>$this->uri->segment(2));	
			
			$this->product_model->update_details(HOSTPAYMENT,$dataArr,$condition);
			
			$this->host_payment_mail($transId);
			$this->host_payment_mailbyadmin($transId);
			
			//die;
			
			$this->setErrorMessage('success','Payment Made Successfull, please wait for Approval to list your Product');
			
			$this->load->view ( 'site/order/host_success', $this->data );
			
			//redirect('listing/all');
	}
	
	
	
	public function host_payment_mail($transId) {
	
	//echo $transId;
	 $this->data['paymentdetail'] = $this->product_model->view_payment_details($transId);
	// echo '<pre>'; print_r($this->data['paymentdetail']->result_array());
	 $hostemail = $this->data['paymentdetail']->row()->email;
	 $hostname = $this->data['paymentdetail']->row()->firstname;
	 $prdname = $this->data['paymentdetail']->row()->prd_name;
	 $amount = $this->data['paymentdetail']->row()->amount;
	 $created = $this->data['paymentdetail']->row()->created;
	 
	 $dateAndTime = $created;
	 $cdata ='';
	 $ctime ='';
	 
	 
	 
		//$newsid = '21';
		$newsid = '26';
		$template_values = $this->user_model->get_newsletter_template_details ($newsid);
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'email_title' ),
				'logo' => $this->data ['logo'],
				'hostname'=>	$hostname,
				'prdname'=>$prdname,
				'amount'=> $amount
				
				
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];
		$header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		
		$message .= '<body>';
		include ('./newsletter/registeration' . $newsid . '.php');
		
		$message .= '</body>
			';
		
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
				'to_mail_id' => $hostemail, 
				'cc_mail_id' => $template_values ['sender_email'],
				'subject_message' => $template_values['news_subject'],
				'body_messages' => $message 
		);
		
		//echo '<pre>'; print_r($email_values);
			
			 
	$this->product_model->common_email_send($email_values);
	}
	
	public function host_payment_mailbyadmin($transId) {
	
	
	 $this->data['paymentdetail'] = $this->product_model->view_payment_details($transId);
	// echo '<pre>'; print_r($this->data['paymentdetail']->result_array());
	 $hostemail = $this->data['paymentdetail']->row()->email;
	 $hostname = $this->data['paymentdetail']->row()->firstname;
	 $prdname = $this->data['paymentdetail']->row()->prd_name;
	 $amount = $this->data['paymentdetail']->row()->amount;
	 $created = $this->data['paymentdetail']->row()->created;
	 $cdata ='';
	 $ctime ='';
	 
	 
		//$newsid = '22';
		$newsid = '27';
		$template_values = $this->user_model->get_newsletter_template_details ($newsid);
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'email_title' ),
				'logo' => $this->data ['logo'],
				'hostname'=>	$hostname,
				'prdname'=>$prdname,
				'amount'=> $amount
				
				
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];
		$header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		
		$message .= '<body>';
		include ('./newsletter/registeration' . $newsid . '.php');
		
		$message .= '</body>
			';
		
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
				'to_mail_id' => $template_values ['sender_email'], 				
				'subject_message' => $template_values['news_subject'],
				'body_messages' => $message 
		);
		
	//	echo '<pre>'; print_r($email_values);
			
			 
	$this->product_model->common_email_send($email_values);
	}
	
	
	
	
	
	
		
	public function get_currency_symbol()
	{
	$currency_type=$this->input->post('currency_type');
	$currency_symbol_query='SELECT * FROM '.CURRENCY.' WHERE currency_type="'.$currency_type.'"';
	$currency_symbol=$this->product_model->ExecuteQuery($currency_symbol_query);
	
	if($currency_symbol->num_rows() > 0)
	{
    echo json_encode(array('currency_symbol'=>$currency_symbol->row()->currency_symbols));
	}
	else{
	echo json_encode(array('currency_symbol'=>'no'));
	}
	
	}
	
	public function SavePhotoCaption()
	{
	        $excludeArr=array('id');
            $dataArr=array();
			$condition=array('id'=>$this->input->post('id'));
            $this->product_model->commonInsertUpdate(PRODUCT_PHOTOS,'update',$excludeArr,$dataArr,$condition);
			echo json_encode(array('status_code'=>1));
	}
	
	
	
	
	/* COD function */
	public function shippingdetails() {
	
	
	        $dprice = $this->input->post('disamounts');			
			if($dprice == 0){
			$price = $this->input->post('total_amt');
			}else{
			$price = $dprice;
			}
			$payment_type="COD";
			$dealCodeNumber = time();
			$created = date('Y-m-d');
	
	
			   
		   if(isset($_POST['checkbox'])) {
			  
			 
			$excludeArr=array('name', 'email', 'mobileno', 'address', 'checkbox','shippingname', 'shippingemail', 'shippingmobileno', 'shippingaddress', 'product_id', 'sell_id', 'user_id', 'price', 'payment_type','dprice','disamounts','distype','dval','dcouponcode');
			
			
			
			
			$dataArr = array('shippingname' => $this->input->post('shippingname'),'shippingemail' => $this->input->post('shippingemail'),'shippingmobileno' => $this->input->post('shippingmobileno'),'shippingaddress' => $this->input->post('shippingaddress'),'user_id'=>$this->input->post('user_id'),'sell_id'=>$this->input->post('sell_id'),'product_id'=>$this->input->post('product_id'),'price'=>$price,'coupon_code'=>$this->input->post('dcouponcode'),'discount'=>$this->input->post('dval'),'total_amt'=>$this->input->post('total_amt'),'discount_type'=>$this->input->post('distype'),'payment_type'=>$payment_type,'dealCodeNumber'=>$dealCodeNumber,'total'=>$price,'created'=>$created);


			$condition =array();
			$this->product_model->commonInsertUpdate(PAYMENT,'insert',$excludeArr,$dataArr,$condition);
			//redirect('site/landing');
			}
			else{
			
			
			$excludeArr=array('name', 'email', 'mobileno', 'address', 'checkbox', 'shippingname', 'shippingemail', 'shippingmobileno', 'shippingaddress', 'product_id', 'sell_id', 'user_id', 'price', 'payment_type','dprice','disamounts','distype','dval','dcouponcode');
			
			
			
			$dataArr1 = array('shippingname' => $this->input->post('name'),'shippingemail' => $this->input->post('email'),'shippingmobileno' => $this->input->post('mobileno'),'shippingaddress' => $this->input->post('address'),'user_id'=>$this->input->post('user_id'),'sell_id'=>$this->input->post('sell_id'),'product_id'=>$this->input->post('product_id'),'price'=>$price,'coupon_code'=>$this->input->post('dcouponcode'),'discount'=>$this->input->post('dval'),'total_amt'=>$this->input->post('total_amt'),'discount_type'=>$this->input->post('distype'),'payment_type'=>$payment_type,'dealCodeNumber'=>$dealCodeNumber,'total'=>$price,'created'=>$created);

			$condition1 =array();
			$this->product_model->commonInsertUpdate(PAYMENT,'insert',$excludeArr,$dataArr1,$condition1);
			
			}
			$this->setErrorMessage('success','Payment Made Successfull');
			 redirect('site/landing');
	}
	
	
	/* COD End */
	
   public function coupons()
	{
	      $coupon = $this->input->post('couponcode');
		  $totprice = $this->input->post('total');
		  $userid = $this->input->post('tuser_id');
		  $RefNo = $this->input->post('RefNo');
		  
		  $today = date("Y-m-d");
		  $condition=array('code'=>$this->input->post('couponcode'),'status'=>'Active');
		  $chkval = $this->product_model->get_all_details(COUPONCARDS,$condition);
		  $totalAvail = $chkval->row()->quantity;
		  $purchase_count = $chkval->row()->purchase_count;
		
		  $condition1=array('couponCode'=>$this->input->post('couponcode'));
		  $countUsedRslt = $this->product_model->get_all_details(PAYMENT,$condition1);
		  $countUsed = $countUsedRslt->num_rows();
		  
		  if($totalAvail <= $purchase_count)
		  {
			$chk ='0-Coupon code already Used';
			echo json_encode($chk);exit;
		  }
		 /* date comaparision */
			$date1 = $chkval->row()->dateto;
			$datefrom = $chkval->row()->datefrom;
			$date2 = date('Y-m-d');
			$dateTimestamp1 = strtotime($date1);
			$dateTimestamp2 = strtotime($date2);
			$dateTimestamp3 = strtotime($datefrom);
			 
		   if ($dateTimestamp1 >= $dateTimestamp2 && $dateTimestamp2 >= $dateTimestamp3):
			 $chk =  "Coupon code Valid";
		    else:
			 $chk = "0-Coupon code Expired";
			 echo json_encode($chk);exit;
		   endif;
		 
         /* date comparision */
		   
		   $flat = $chkval->row()->price_value;
		   $value = $chkval->row()->price_value;
		   $distype = '0';
		   if($chkval->row()->price_type != '1'){
		      $distype = '1';
			  $per = $chkval->row()->price_value;
		      $flat1 = $per/100;
			  $flat = $flat1*$totprice;
              $value = round($chkval->row()->price_value, 2)."%";
		    }

		 $chk1 = $totprice-$flat;
		  
		 if ($totprice <= $flat):
             $chk = "0-Not valid coupon";
			 echo json_encode($chk);exit;
		    endif;
		  
		  $singAmnt = $chk1*100;
		  $chk1 = number_format((float)$chk1, 2, '.', '');
			
		  $source ="DbQhpCuQpPM07244".$RefNo.$singAmnt."MYR";
		  $val = sha1($source);
		  $rval = $this->hex2bin($val);
		  $signatureId =  base64_encode($rval);
		  $chk = $coupon."-".$value."-".$chk1."-".$totprice."-".$distype."-".$signatureId;
		  $userid = $this->input->post('user_id');
		  $payment_id = $this->input->post('payment_id');
		  $coupon_strip = array('coupon_strip' => $chk);
		  $this->session->set_userdata($coupon_strip);
	 
	     echo json_encode($chk);exit;
    }
			
		public function save_lat_lng()
		{
			$dataArr=array('lat'=>$this->input->post('latitude'),'lang'=>$this->input->post('longitude'),'city'=>$this->input->post('city'),'state'=>$this->input->post('state'),'country'=>$this->input->post('country'),'address'=>$this->input->post('address'),'area'=>$this->input->post('area'),'street'=>$this->input->post('street'),'location'=>$this->input->post('location'));
			//print_r $dataArr;die;
			$this->product_model->update_details(PRODUCT_ADDRESS_NEW,$dataArr,array('productId'=>$this->input->post('product_id')));
			//echo $this->db->last_query();die;
		}
	
	
	/* Test upload */
	
	
	public function ImageUploadTest() {
	
	$prd_id = $this->input->post('prd_id');
	
	//echo '<pre>'; print_r($_FILES); die;
	$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	
    //$uploaddir = "uploads/";
      $uploaddir = "server/php/rental/";	//a directory inside
    foreach ($_FILES['photostest']['name'] as $name => $value)
    {
	
        $filename = stripslashes($_FILES['photostest']['name'][$name]);
        $size=filesize($_FILES['photostest']['tmp_name'][$name]);
		$width_height = getimagesize($_FILES['photostest']['tmp_name'][$name]);
        //get the extension of the file in a lower case format
          $ext = $this->getExtension($filename);
          $ext = strtolower($ext);
     	
         if(in_array($ext,$valid_formats))
         {
	       if ($size > 0)
	       {
		   
		  
			
		   $image_name=time().$filename;
		   echo "<img src='".$uploaddir.$image_name."' class='imgList'>";
		  
           $newname=$uploaddir.$image_name;
		  
       if (move_uploaded_file($_FILES['photostest']['tmp_name'][$name], $newname)) 
           {
		   
		   // echo '<pre>'; print_r($_FILES); die;
			 // if($width_height[0]<1364 && $width_height[1]<910)
			  // {
            // $this->imageResizeWithSpace(1364, 910, $newname);
			  // } 
			$time=time();
			//$this->watermarkimages($uploaddir,$image_name);
			
			
         mysql_query("INSERT INTO fc_rental_photos(product_image,product_id) VALUES('$image_name','$prd_id')");
           }
	       else
	       {
	        echo '<span class="imgList">You have exceeded the size limit! so moving unsuccessful! </span>';
            }

	       }
		   else
		   {
			echo '<span class="imgList">You have exceeded the size limit!</span>';
          
	       }
       
          }
          else
         { 
	     	echo '<span class="imgList">Unknown extension!</span>';
           
	     }
           
     }
}

 redirect('photos_listing/'.$prd_id);
	}
	
	
	public function get_location() {
		$address = $this->input->post('address');
		
		
		$retrnstr['street'] = '';
		$retrnstr['street1'] = '';
		$retrnstr['area'] = '';
		$retrnstr['location'] = '';
		$retrnstr['city'] = '';
		$retrnstr['state'] = '';
		$retrnstr['country'] = '';
		$retrnstr['lat'] = '';
		$retrnstr['long'] = '';
		$retrnstr['zip'] = '';
		$address = str_replace(" ", "+", $address);
		$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$google_map_api");
		$json = json_decode($json);
		//echo '<pre>';print_r($json);die;
		$newAddress = $json->{'results'}[0]->{'address_components'};
		foreach($newAddress as $nA)
		{
			if($nA->{'types'}[0] == 'route')$retrnstr['street'] = $nA->{'long_name'};
			if($nA->{'types'}[0] == 'sublocality_level_2')$retrnstr['street1'] = $nA->{'long_name'};
			if($nA->{'types'}[0] == 'sublocality_level_1')$retrnstr['area'] = $nA->{'long_name'};
			if($nA->{'types'}[0] == 'locality')$retrnstr['location'] = $nA->{'long_name'};
			if($nA->{'types'}[0] == 'administrative_area_level_2')$retrnstr['city'] = $nA->{'long_name'};
			if($nA->{'types'}[0] == 'administrative_area_level_1')$retrnstr['state'] = $nA->{'long_name'};
			if($nA->{'types'}[0] == 'country')$retrnstr['country'] = $nA->{'long_name'};
			if($nA->{'types'}[0] == 'postal_code')$retrnstr['zip'] = $nA->{'long_name'};
		}
		if($retrnstr['city'] == '')
		$retrnstr['city'] = $retrnstr['location'];

		$retrnstr['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$retrnstr['lang'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		
		echo json_encode($retrnstr);
	}
	public function edit_user_email() {
		
				 /* update message board */
				 $excludeArr = array('email_id', 'user_id');
				 $dataArr = array('email'=>$this->input->post('email_id'));
				 $condition =array('id'=>$this->input->post('user_id'));
				 $this->product_model->commonInsertUpdate(USERS,'update',$excludeArr,$dataArr,$condition);
				 
	}
	
	public function add_discussion()
	{
	//print_r($_POST);die;
	$redirect=$this->input->post('redirect');
	$excludeArr = array('redirect','discussion');
	$now = time();
	
	
		$dataArr = array(
			'productId' => $this->input->post('rental_id'),
			'bookingNo' => $this->input->post('bookingno'),
			'senderId' => $this->checkLogin ( 'U' ),
			'receiverId' => $this->input->post('receiver_id'),
			'subject' => 'Booking Request : '.$this->input->post('bookingno'),
			'message' => $this->input->post('message')
		);
	
		$this->user_model->simple_insert(MED_MESSAGE, $dataArr);
	$dataArr = array('convId'=>$now);
	$condition =array();
    $this->product_model->commonInsertUpdate(DISCUSSION,'insert',$excludeArr,$dataArr,$condition);
	$this->setErrorMessage('success','Your message was successfully sent');
	redirect($redirect);
	}
	
	public function add_reply()
	{
	//print_r($_POST);die;
	$redirect=$this->input->post('redirect');
	$excludeArr = array('redirect','discussion');
	$now = $this->input->post('convId');
	$dataArr = array();
	$condition =array('convId'=>$now);
    $this->product_model->commonInsertUpdate(DISCUSSION,'insert',$excludeArr,$dataArr,$condition);
	$this->setErrorMessage('success','Your message was successfully sent');
	redirect($redirect);
	}
	
	public function resize_all_products()
	{
		$dir    = FCPATH.'server/php/rental';
		$files = scandir($dir);
		
		foreach($files as $file)
		{
			$uploaddir = $dir.'/mobile/';
			$source = $dir.'/'.$file;
			$renameArr = explode('.', $file);
			$newName = $renameArr[0].'.jpg';
			echo $target = $dir.'/mobile/'.$newName;
			echo '<br>';
			if (!copy($source, $target)) {
				if(is_file($target))
				{
					$option=$this->getImageShape(500,350,$target);
					$renameArr = explode('.', $target);
					$newName = $renameArr[0].'.jpg';
					$resizeObj = new Resizeimage($target);	
					$resizeObj -> resizeImage(500, 350, $option);
					$resizeObj -> saveImage($uploaddir.$newName, 100);
					$this->ImageCompress($uploaddir.$newName);
					@copy($uploaddir.$newName, $uploaddir.$newName);
				}
			}
		}
	}
	
	public function resize_all_cities()
	{
		$dir    = FCPATH.'images/city';
		$files = scandir($dir);
		
		foreach($files as $file)
		{
			$uploaddir = $dir.'/mobile/';
			$source = $dir.'/'.$file;
			$renameArr = explode('.', $file);
			$newName = $renameArr[0].'.jpg';
			echo $target = $dir.'/mobile/'.$newName;
			echo '<br>';
			if (!copy($source, $target)) {
				if(is_file($target))
				{
					$option=$this->getImageShape(500,350,$target);
					$renameArr = explode('.', $target);
					$newName = $renameArr[0].'.jpg';
					$resizeObj = new Resizeimage($target);	
					$resizeObj -> resizeImage(500, 350, $option);
					$resizeObj -> saveImage($uploaddir.$newName, 100);
					$this->ImageCompress($uploaddir.$newName);
					@copy($uploaddir.$newName, $uploaddir.$newName);
				}
			}
		}
	}
	
	/* Dispute function  */
	
	public function add_dispute(){
	
		$prd_id = $this->input->post('prd_id');
		$trip_url = $this->input->post('trip_url');
		
		$excludeArr = array('trip_url','dispute_message');
		$dataArr = array('prd_id'=>$prd_id,
						'message'=>$this->input->post('message'),
						'user_id'=>$this->checkLogin('U')
						);
						
		$this->product_model->commonInsertUpdate(DISPUTE,'insert',$excludeArr,$dataArr,$condition);
		$this->setErrorMessage('success','Successfully Dispute Added !!..');
		redirect('trips/'.$trip_url);
	}
	
	/* Dispute function */
	
}
/*End of file product.php */
/* Location: ./application/controllers/site/product.php */