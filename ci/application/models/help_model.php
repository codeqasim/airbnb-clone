<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to user management
 * @author Teamtweaks
 *
 */
class Help_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	 public function getallmainmenu(){
   		$this->db->select('*');
		$this->db->from('fc_help_page');
		
		$this->db->where('status','1');
		$googleQuery = $this->db->get();
		return $googleResult = $googleQuery->result(); 
   }
   public function deleterel($id)
   {
   $this->db->where('id', $id);
   $this->db->delete('fc_help_main');
   
   $this->db->where('main', $id);
   $this->db->delete('fc_help_sub');
   
   $this->db->where('main', $id);
   $this->db->delete('fc_help_question');
   }
   public function submenuhelp()
   {
       $this->db->select('*');
		$this->db->from('fc_help_sub');
		$this->db->where('main',$_POST['id']);
		$this->db->where('status','Active');
		$this->db->where('lang','en');
		$googleQuery = $this->db->get();
		return $googleResult = $googleQuery->result(); 
		 //echo $this->db->last_query(); exit;
   }
    public function get_all_submenu($table='',$condition='')
	{
	    $this->db->select('fc_help_sub.*,fc_help_main.name as mainname');
		$this->db->from('fc_help_sub');
		
		$this->db->join('fc_help_main', 'fc_help_main.id = fc_help_sub.main');
		$this->db->where($condition);
        return $this->db->get();
		
	}
	
	public function getallquestion($table='',$condition='')
	{
	
	   $this->db->select('fc_help_question.*,fc_help_main.name as mainname,fc_help_sub.name as subname');
		$this->db->from('fc_help_question');
		
		$this->db->join('fc_help_main', 'fc_help_main.id = fc_help_question.main');
		
		$this->db->join('fc_help_sub', 'fc_help_sub.id = fc_help_question.sub');
		$this->db->where($condition);
        return $this->db->get();
	
	}
   public function get_all_main($table='',$condition=''){
	//print_r($condition);die;
		
		
		return $this->db->get_where($table,$condition);
		
	}
	
	public function get_all_mainmenu($table=''){
	//print_r($condition);die;
		
		
		return $this->db->get($table);
		
	}
	public function get_all_submainmenu($table='')
	{
	return $this->db->get($table);
	}
   public function getallsubmenu($var){
   		$array = array();

   		foreach($var as $row){
	   		
	   		$this->db->select('*');
			$this->db->from('fc_help_sub_menu');
			$this->db->where('group_id',$row->id);
			$this->db->where('status','1');
			$googleQuery = $this->db->get();

			$array[$row->id][] = $googleQuery->result();

		}
		return $array; 
   }
	
	
}