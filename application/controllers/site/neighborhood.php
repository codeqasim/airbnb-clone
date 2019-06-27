<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Shop related functions
 * @author Teamtweaks
 * 
 */

class Neighborhood extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('product_model','shop');
		$this->load->model('city_model');
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->shop->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		
		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->shop->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
		
	 	if ($this->data['loginCheck'] != ''){
	 		$this->data['likedProducts'] = $this->shop->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	}
    }
    
	public function index(){
		$this->data['heading'] = 'Neighborhood Cities';
		//$this->data['CityDetails'] = $this->city_model->State_city();
		$this->data['CityDetails'] = $this->city_model->Featured_city();
		$this->data['CityDetails1'] = $this->city_model->Featured_city1();
		
		
		// die(var_dump($this->data['CityDetails1']->result_array()));
		
		
				
		$this->load->view('site/neighborhood/display_neighborhood',$this->data);
    }
	//display nighborhood city list
	public function display_neighborhood(){
		$cityid = $this->uri->segment(2,0);
		$this->data['CityList'] = $this->shop->get_all_details(CITY,array('status'=>'Active','seourl'=>$cityid));
		$this->data['NeighborhoodList'] = $this->shop->get_all_details(NEIGHBORHOOD,array('status'=>'Active','featured'=>'1','neighborhoods'=>$this->data['CityList']->row()->id));
		$this->data['AllNeighborhoodList'] = $this->shop->get_all_details(NEIGHBORHOOD,array('status'=>'Active','neighborhoods'=>$this->data['CityList']->row()->id));
		$this->data['SavedNeibur'] = $this->shop->get_all_details(SAVED_NEIGHBORHOOD,array('user_id'=>$this->checkLogin('U')));
		/*and state=".$this->data['CityList']->row()->stateid."*/
		$this->data['RentalsCount'] = $this->product_model->get_total_records_CityCount("where c.city =".$this->data['CityList']->row()->id." and p.status='Publish' ");
		//echo $this->db->last_query();
		//die;
		//print_r($this->data['RentalsCount']->result());die;
		//$this->data['heading'] = ucfirst(str_replace('-',' ',$cityid)).' Travel Guide';
		
		$this->data['heading'] = $this->data['CityList']->row()->name.' Guide';
		if ($this->data['CityList']->row()->meta_title != ''){
			$this->data['meta_title'] = $this->data['CityList']->row()->meta_title;
		}
		if ($this->data['CityList']->row()->meta_keyword != ''){
	    	$this->data['meta_keyword'] = $this->data['CityList']->row()->meta_keyword;
		}
		if ($this->data['CityList']->row()->meta_description != ''){
	    	$this->data['meta_description'] = $this->data['CityList']->row()->meta_description;
		}
		$this->load->view('site/neighborhood/display_neighborhood_list',$this->data);
    }
	
	//display city all neighborhood list
	public function display_city_all_neighborhoods(){
		$cityid = $this->uri->segment(2,0);
		$this->data['CityList'] = $this->shop->get_all_details(CITY,array('status'=>'Active','seourl'=>$cityid));
		$this->data['categoryArr'] = $this->shop->get_all_details(PRODUCT_ATTRIBUTE,array('status' =>'Active'));
		$this->data['NeighborhoodList'] = $this->shop->get_all_details(NEIGHBORHOOD,array('status'=>'Active','neighborhoods'=>$this->data['CityList']->row()->id));
		$this->data['SavedNeibur'] = $this->shop->get_all_details(SAVED_NEIGHBORHOOD,array('user_id'=>$this->checkLogin('U')));
		$this->data['heading'] = ucfirst(str_replace('-',' ',$cityid)).' Neighborhood Guide';
		$this->load->view('site/neighborhood/display_city_all_neighborhoods',$this->data);
    }
	//display nighborhood city details
	public function display_city_neighborhood(){
	
		$stateid = $this->uri->segment(2,0);
		$cityid = $this->uri->segment(3,0);
		$this->data['CityList'] = $this->shop->get_all_details(NEIGHBORHOOD,array('status'=>'Active','seourl'=>$cityid));		
		$this->data['NeighborhoodName'] = $this->shop->get_all_details(CITY,array('status'=>'Active','seourl'=>$stateid));
		$this->data['SavedNeibur'] = $this->shop->get_all_details(SAVED_NEIGHBORHOOD,array('user_id'=>$this->checkLogin('U')));
		
		$this->data['RentalsCount'] = $this->shop->get_total_records(PRODUCT_ADDRESS,"where city =".$this->data['CityList']->row()->id." ");
		//echo $this->db->last_query();die;
		$this->data['heading'] = ucfirst(str_replace('-',' ',$cityid)).' Travel Guide';
		$this->load->view('site/neighborhood/display_city_neighborhood_list',$this->data);
    }
	
	//saved neighborhoods
	public function saved_neighborhoods(){
	$returnStr['status_code'] = 0;
	$savename = $this->input->post('neighborhood');
	$city_name = $this->input->post('city_name');
	$returnStr['msg'] = "Please login your account.";
	$returnStr['count'] =0;
		if($this->checkLogin('U')!=''){
			$this->data['CityList'] = $this->shop->get_all_details(SAVED_NEIGHBORHOOD,array('neighborhood'=>$savename,'user_id'=>$this->checkLogin('U')));
			if($this->data['CityList']->num_rows()==0){
				//$GetNeiburDetails = $this->shop->get_all_details(NEIGHBORHOOD,array('seourl'=>$savename));
				$GetCityDetails = $this->shop->get_all_details(CITY,array('seourl'=>$city_name));
				//base_url()/property?city=San+Francisco&neighborhood=grace-cathedral
				$link=base_url().'property?city='.str_replace(' ','+',$GetCityDetails->row()->name).'&neighborhood='.$savename;
				$dataArr=array('neighborhood'=>$savename,'user_id' => $this->checkLogin('U'),'url' => $link);
				
				$this->shop->simple_insert(SAVED_NEIGHBORHOOD,$dataArr);
				$SavedCount = $this->shop->get_all_details(SAVED_NEIGHBORHOOD,array('user_id'=>$this->checkLogin('U')));
				$SavedCount_details.='<ul>';
				foreach($SavedCount->result() as $rows){
				$SavedCount_details.='<li id="row_'.$rows->id.'"><a href="'.$rows->url.'">'.ucfirst(str_replace('-',' ',$rows->neighborhood)).'</a><a class="remove" onclick="DeleteNeighborhoods('.$rows->id.');" href="javascript:void(0);">&times;</a></li>';
				}
				$SavedCount_details.='</ul>';
				
				$returnStr['status_code'] = 1;
				$returnStr['details'] =$SavedCount_details;
				$returnStr['count'] =$SavedCount->num_rows();
				$returnStr['msg'] = "Saved this neighborhood";
			}else{
				$returnStr['msg'] = "Already saved this neighborhood";
			}
		}
		echo json_encode($returnStr);	
    }
	//delete neighborhoods
	public function delete_neighborhoods(){
	$returnStr['status_code'] = 0;
	$savename = $this->input->post('id');
	
	$returnStr['count'] =0;
		if($this->checkLogin('U')!=''){
				$condition = array('id' => $savename);
				$this->shop->commonDelete(SAVED_NEIGHBORHOOD,$condition);
				$SavedCount = $this->shop->get_all_details(SAVED_NEIGHBORHOOD,array('user_id'=>$this->checkLogin('U')));
				$returnStr['status_code'] = 1;
				$returnStr['count'] =$SavedCount->num_rows();
				$returnStr['msg'] = "Deleted This neighborhood";
		}
		echo json_encode($returnStr);	
    }
}
/*End of file cms.php */
/* Location: ./application/controllers/site/product.php */