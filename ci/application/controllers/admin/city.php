<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * 
 * This controller contains the functions related to city management 
 * @author Teamtweaks
 *
 */

class City extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation','resizeimage'));		
		$this->load->model('city_model');
		if ($this->checkPrivileges('City',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the city list page
     */
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/city/display_city_list');
		}
	}
	
	/**
	 * 
	 * This function loads the city list page
	 */
	public function display_city_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'City List';
			$condition = array();
			$this->data['cityList'] = $this->city_model->get_all_details(CITY,$condition);
			//echo '<pre>';print_r($this->data['cityList']->result());die;
			$condition1 = array('id' => $this->data['cityList']->row()->stateid);
			$this->data['StateList'] = $this->city_model->get_all_details(STATE_TAX,$condition1);
			
			
			
			$this->load->view('admin/city/display_city',$this->data);
		}
	}
	
	public function display_featured_cities(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Featured Locations';
			$condition = array('featured'=>'1');
			$this->data['cityList'] = $this->city_model->get_all_details(CITY,$condition);
			$condition1 = array('id' => $this->data['cityList']->row()->stateid);
			$this->data['StateList'] = $this->city_model->get_all_details(STATE_TAX,$condition1);
			$this->load->view('admin/city/featured_cities',$this->data);
		}
	}
	
	public function save_list_order(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$condition = array('id'=>$this->input->post('id'));
			$data = array('view_order'=>$this->input->post('value'));
			$this->city_model->update_details(CITY,$data,$condition);
		}
	}
	/**
	 * 
	 * This function loads the city list page
	 */
	public function display_city_statelist(){ 
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'State city List';
			$statecity_id = $this->uri->segment(4,0);
			$condition = array('country_id' => $statecity_id);
			$this->data['cityList'] = $this->city_model->get_all_details(CITY,$condition);
			$this->load->view('admin/city/display_city',$this->data);
		}
	}
	
	
	/**
	 * 
	 * This function loads the add new city form
	 */
	public function add_city_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New city';
			$this->data['PrimaryNhDisplay'] = $this->city_model->SelectAllPrimaryCities();
			$this->data['stateDisplay'] = $this->city_model->SelectAllCountry();
			$this->data['countryDisplay'] = $this->city_model->get_all_details(LOCATIONS,array('status'=>'Active'));
			$this->load->view('admin/city/add_city',$this->data);
		}
	}
	
	public function add_featured_location(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New featured location';
			$this->data['PrimaryNhDisplay'] = $this->city_model->SelectAllPrimaryCities();
			$this->data['stateDisplay'] = $this->city_model->SelectAllCountry();
			$this->data['countryDisplay'] = $this->city_model->get_all_details(LOCATIONS,array('status'=>'Active'));
			$this->load->view('admin/city/add_featured_location',$this->data);
		}
	}
	
	
	/**
	 * 
	 * This function insert and edit a city
	 */
	public function insertEditcity(){
	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$city_id = $this->input->post('city_id');
			$city_name = $this->input->post('name');
			
			$s_name =$this->input->post('stateid');
			$stateval = $this->city_model->get_all_details(STATE_TAX,array('id' => $s_name));
			//echo '<pre>'; print_r($stateval->result_array()); die;
			$state_name = $stateval->row()->name;
			
			
			
			//$tags = $this->input->post('tags');
			$seourl = url_title($city_name, '-', TRUE);
			
			$seourl_state = url_title($state_name, '-', TRUE);
			
			if ($city_id == ''){
				$condition = array('name' => $city_name);
				$duplicate_name = $this->city_model->get_all_details(CITY,$condition);
				if ($duplicate_name->num_rows() > 0){
					$this->setErrorMessage('error','City name already exists');
					redirect('admin/city/add_city_form');
				}
			}
			$excludeArr = array("city_id","status","citylogo","citythumb","featured","neighborhoods");
			$excludeArr1 = array("city_id","status","citylogo","citythumb","featured","neighborhoods","get_around","known_for","stateid","tags","short_description","name");
			$inputArr['seourl']= $seourl;
			if ($this->input->post('status') != ''){
				$city_status = 'Active';
			}else {
				$city_status = 'InActive';
			}
			if ($this->input->post('featured') != ''){
				$featured = '1';
			}else {
				$featured = '0';
				
			}
			$inputArr['neighborhoods']='';
			$inputArr['neighborhoods']=$this->input->post('neighborhoods');
			
			
			$city_data=array();
			$inputArr['status']= $city_status;
		
			$inputArr['featured']= $featured;
			$uploaddir = "images/city/";
			$config['overwrite'] = FALSE;
		    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
			    $config['max_size'] = 2000;
			    $config['upload_path'] = './images/city';
			    $this->load->library('upload', $config);
				if ( $this->upload->do_upload('citylogo')){
			    	$logoDetails = $this->upload->data();
					$logoDetails['file_name'];
					
					$this->imageResizeWithSpaceCity(1300, 700, $logoDetails['file_name'], './images/city/');
					
			    	$inputArr['citylogo'] = $logoDetails['file_name'];
			    	
				}
				if ( $this->upload->do_upload('citythumb')){
					$feviconDetails = $this->upload->data();
			    	$inputArr['citythumb'] = $feviconDetails['file_name'];
					$filename = $feviconDetails['file_name'];
					$image_name=$filename;
					
					
					$timeImg=time();
					@copy($filename, './images/city/mobile/'.$timeImg.'-'.$filename);
					$target_file=$uploaddir.$image_name;
					$imageName=$timeImg.'-'.$filename; 
					$option=$this->getImageShape(800,800,$target_file);
					
					$resizeObj = new Resizeimage($target_file);	
					$resizeObj -> resizeImage(800, 800, $option);
					$resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
					$this->ImageCompress($uploaddir.'mobile/'.$imageName);
					@copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);
					$inputArr['citylogo'] = $imageName;
				}
			$dataArr = array_merge($inputArr,$city_data);
		   // $dataArr1 = $inputArr1;	
			$condition = array('id' => $city_id);
			
			//print_r($inputArr1);die;
			
			if ($city_id == ''){
			 
				$this->city_model->commonInsertUpdate(CITY,'insert',$excludeArr,$dataArr,$condition);
				
			
				
				$this->setErrorMessage('success','City added successfully');
			}else {
				$this->city_model->commonInsertUpdate(CITY,'update',$excludeArr,$dataArr,$condition);
				
				
				
				
				$this->setErrorMessage('success','City updated successfully');
			}
			redirect('admin/city/display_city_list');
		}
	}
	
	public function insertEditFeatureLocation(){
	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$city_id = $this->input->post('city_id');
			$city_name = $this->input->post('name');
			
			$s_name =$this->input->post('stateid');
			$stateval = $this->city_model->get_all_details(STATE_TAX,array('id' => $s_name));
			//echo '<pre>'; print_r($stateval->result_array()); die;
			$state_name = $stateval->row()->name;
			
			
			
			//$tags = $this->input->post('tags');
			$seourl = url_title($city_name, '-', TRUE);
			
			$seourl_state = url_title($state_name, '-', TRUE);
			
			if ($city_id == ''){
				$condition = array('name' => $city_name);
				$duplicate_name = $this->city_model->get_all_details(CITY_LOCATIONS,$condition);
				if ($duplicate_name->num_rows() > 0){
					$this->setErrorMessage('error','Location name already exists');
					redirect('admin/city/add_featured_location');
				}
			}
			$excludeArr = array("city_id","status","citylogo","citythumb","featured","neighborhoods");
			$excludeArr1 = array("city_id","status","citylogo","citythumb","featured","neighborhoods","get_around","known_for","stateid","tags","short_description","name");
			$inputArr['seourl']= $seourl;
			if ($this->input->post('status') != ''){
				$city_status = 'Active';
			}else {
				$city_status = 'InActive';
			}
			if ($this->input->post('featured') != ''){
				$featured = '1';
			}else {
				$featured = '0';
				
			}
			$inputArr['neighborhoods']='';
			$inputArr['neighborhoods']=$this->input->post('neighborhoods');
			
			
			$city_data=array();
			$inputArr['status']= $city_status;
		
			$inputArr['featured']= $featured;
			$uploaddir = "images/city/";
			$config['overwrite'] = FALSE;
		    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
			    $config['max_size'] = 2000;
			    $config['upload_path'] = './images/city';
			    $this->load->library('upload', $config);
				if ( $this->upload->do_upload('citylogo')){
			    	$logoDetails = $this->upload->data();
					$logoDetails['file_name'];
					
					$this->imageResizeWithSpaceCity(1300, 700, $logoDetails['file_name'], './images/city/');
					
			    	$inputArr['citylogo'] = $logoDetails['file_name'];
			    	
				}
				if ( $this->upload->do_upload('citythumb')){
					$feviconDetails = $this->upload->data();
			    	$inputArr['citythumb'] = $feviconDetails['file_name'];
					$filename = $feviconDetails['file_name'];
					$image_name=$filename;
					
					
					$timeImg=time();
					@copy($filename, './images/city/mobile/'.$timeImg.'-'.$filename);
					$target_file=$uploaddir.$image_name;
					$imageName=$timeImg.'-'.$filename; 
					$option=$this->getImageShape(800,800,$target_file);
					
					$resizeObj = new Resizeimage($target_file);	
					$resizeObj -> resizeImage(800, 800, $option);
					$resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
					$this->ImageCompress($uploaddir.'mobile/'.$imageName);
					@copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);
					$inputArr['citylogo'] = $imageName;
				}
			$dataArr = array_merge($inputArr,$city_data);
		   // $dataArr1 = $inputArr1;	
			$condition = array('id' => $city_id);
			
			//print_r($inputArr1);die;
			
			if ($city_id == ''){
			 
				$this->city_model->commonInsertUpdate(CITY_LOCATIONS,'insert',$excludeArr,$dataArr,$condition);
				
			
				
				$this->setErrorMessage('success','Location added successfully');
			}else {
				$this->city_model->commonInsertUpdate(CITY_LOCATIONS,'update',$excludeArr,$dataArr,$condition);
				
				
				
				
				$this->setErrorMessage('success','Location updated successfully');
			}
			redirect('admin/city/display_featured_cities');
		}
	}
	
	/**
	 * 
	 * This function loads the edit city form
	 */
	public function edit_city_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit city';
			$city_id = $this->uri->segment(4,0);
			$condition = array('id' => $city_id);
			$this->data['PrimaryNhDisplay'] = $this->city_model->SelectAllPrimaryCities();
			$this->data['stateDisplay'] = $this->city_model->SelectAllCountry();
			$this->data['countryDisplay'] = $this->city_model->get_all_details(LOCATIONS,array('status'=>'Active'));
			$this->data['city_details'] = $this->city_model->get_all_details(CITY,$condition);
			if ($this->data['city_details']->num_rows() == 1){
			
				$this->load->view('admin/city/edit_city',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	public function edit_location_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit city';
			$city_id = $this->uri->segment(4,0);
			$condition = array('id' => $city_id);
			$this->data['PrimaryNhDisplay'] = $this->city_model->SelectAllPrimaryCities();
			$this->data['stateDisplay'] = $this->city_model->SelectAllCountry();
			$this->data['countryDisplay'] = $this->city_model->get_all_details(LOCATIONS,array('status'=>'Active'));
			$this->data['city_details'] = $this->city_model->get_all_details(CITY_LOCATIONS,$condition);
			if ($this->data['city_details']->num_rows() == 1){
			
				$this->load->view('admin/city/edit_featured_location',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function change the city status
	 */
	public function change_city_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'InActive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			$this->city_model->update_details(CITY,$newdata,$condition);
			$this->setErrorMessage('success','City Status Changed Successfully');
			redirect('admin/city/display_city_list');
		}
	}
	
	/**
	 * 
	 * This function loads the city view page
	 */
	public function view_city(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View city';
			$city_id = $this->uri->segment(4,0);
			$condition = array('id' => $city_id);
			$this->data['stateDisplay'] = $this->city_model->SelectAllCountry();
			$this->data['PrimaryNhDisplay'] = $this->city_model->SelectAllPrimaryCities();
			$this->data['city_details'] = $this->city_model->get_all_details(CITY,$condition);
			if ($this->data['city_details']->num_rows() == 1){
				$this->load->view('admin/city/view_city',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	public function view_location(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View city';
			$city_id = $this->uri->segment(4,0);
			$condition = array('id' => $city_id);
			$this->data['stateDisplay'] = $this->city_model->SelectAllCountry();
			$this->data['PrimaryNhDisplay'] = $this->city_model->SelectAllPrimaryCities();
			$this->data['city_details'] = $this->city_model->get_all_details(CITY_LOCATIONS,$condition);
			if ($this->data['city_details']->num_rows() == 1){
				$this->load->view('admin/city/view_location',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function delete the city record from db
	 */
	public function delete_city(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$city_id = $this->uri->segment(4,0);
			$condition = array('id' => $city_id);
			$this->city_model->commonDelete(CITY,$condition);
			$this->setErrorMessage('success','City deleted successfully');
			redirect('admin/city/display_city_list');
		}
	}
	
	public function delete_location(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$city_id = $this->uri->segment(4,0);
			$condition = array('id' => $city_id);
			$this->city_model->commonDelete(CITY_LOCATIONS,$condition);
			$this->setErrorMessage('success','Location deleted successfully');
			redirect('admin/city/display_featured_cities');
		}
	}
	
	public function load_states(){
		$returnStr['success'] = 0;
		$returnStr['msg'] = '';
		$returnStr['states_list'] = '';
		if ($this->checkLogin('A') == ''){
			$returnStr['msg'] = 'Login required';
		}else {
			$cid = $this->input->post('cid');
			if ($cid!=''){
				$this->data['states_list_value'] = $this->city_model->get_all_details(STATE_TAX,array('countryid'=>$cid));
				//print_r($this->data['states_list_value']->result()];
				$returnStr['states_list'] = $this->load->view('admin/city/load_states',$this->data,true);
				$returnStr['success'] = 1;
			}
		}
		echo json_encode($returnStr);
	}
	
}

/* End of file city.php */
/* city: ./application/controllers/admin/city.php */