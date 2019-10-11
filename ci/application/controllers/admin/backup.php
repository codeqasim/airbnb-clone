<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to Order management 
 * @author Teamtweaks
 *
 */ 

class Backup extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));				
		$this->load->model('account_model');
		$this->load->model('order_model');
		if ($this->checkPrivileges('Backup',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/backup/dbBackup');
		}
	}
	public function dbBackup(){
		
		/* $host = DBB_HOST;
		$user = DBB_USER;
		$pass = DBB_PASS;
		$name = DBB_NAME; */
		
		$tables = '*';
		{
			//$con = mysql_connect($host,$user,$pass);
			//mysql_select_db($name,$con);
			if($tables == '*')
			{
				$tables = array();
				$result = mysql_query('SHOW TABLES');
				while($row = mysql_fetch_row($result))
				{
					$tables[] = $row[0];
				}
			}
			else
			{
				$tables = is_array($tables) ? $tables : explode(',',$tables);
			}
			$return = "";
			foreach($tables as $table)
			{
				$result = mysql_query('SELECT * FROM '.$table);
				$num_fields = mysql_num_fields($result);
				//$return.= 'DROP TABLE '.$table.';';
				$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
				$return.= $row2[1].";";

				while($row = mysql_fetch_row($result))
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++)
					{
						$row[$j] = addslashes($row[$j]);
						//$row[$j] = preg_replace("#n#","n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");";
				}
				$return.="";
			}

			$fileName = 'dbbackup/backupdb.sql';
			$handle = fopen($fileName,'w+');
			fwrite($handle,$return);
			fclose($handle);
		}
		if (glob("*.sql") != false)
		{
			$filecount = count(glob("*.sql"));
			$arr_file = glob("*.sql");
		}


		$path = dirname($_SERVER['PHP_SELF']);
		$position = strrpos($path,'/') + 1;
		$folder_name = substr($path,$position);


		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("../$folder_name/"));	
		
		echo "<script>window.location='".base_url()."dbbackup/fileUpload.php';</script>";

	
	}
	/* public function dbBackup(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else 
		{
			$bURL = base_url();
			//ENTER THE RELEVANT INFO BELOW
			$mysqlDatabaseName = DBB_NAME;
			$mysqlUserName = DBB_USER;
			$mysqlPassword = DBB_PASS;
			$mysqlExportPath ='Database-'.date('m/d/Y H:i:s', time()).'.sql';
			//DO NOT EDIT BELOW THIS LINE
			$mysqlHostName = DBB_HOST;
			//Export the database and output the status to the page
			$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ~/' .$mysqlExportPath;
			exec($command,$output=array(),$worked);
			switch($worked){
				case 0:
					echo 'Database <b>' .$mysqlDatabaseName .'</b> successfully exported to <b>~/' .$mysqlExportPath .'</b>';
					break;
				case 1:
					echo 'There was a warning during the export of <b>' .$mysqlDatabaseName .'</b> to <b>~/' .$mysqlExportPath .'</b>';
					break;
				case 2:
					echo 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
					break;
			}
		}
	} */
}

/* End of file order.php */
/* Location: ./application/controllers/admin/backup.php */