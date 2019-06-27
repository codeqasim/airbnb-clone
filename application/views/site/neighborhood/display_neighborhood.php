<?php 
$this->load->view('site/templates/header');
?>


<link rel='stylesheet' href='css/site/<?php echo SITE_COMMON_DEFINE ?>camera.css' type='text/css' media='all'> 
<style>ul.ui-widget-content {
    background: url("images/ui-bg_highlight-hard_100_f5f3e5_1x100.png") repeat-x scroll 50% top #f5f3e5 !important;
    border: 1px solid #dfd9c3 !important;
    color: #312e25 !important;
    display: block !important;
    left: 24.4% !important;
    position: absolute !important;
    top: 41px !important;
    width: 299px !important;
}
ul.ui-widget-content li{padding:5px 10px;}

ul.ui-widget-content li:hover{background:#6FB42C; color:#fff}
ul.ui-widget-content li:hover a{background:#6FB42C; color:#fff; text-decoration:none}
</style>
<style>


.camera_prev, .camera_next, .camera_commands{
	display:none !important;
}
.camera_wrap{
	height:670px !important;
}

.camera_fakehover, .cameraContent{
	height:670px !important;
}

</style>


    <script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.min.js"></script>
    <script type='text/javascript' src='js/site/<?php echo SITE_COMMON_DEFINE ?>jquery.mobile.customized.min.js'></script>
    <script type='text/javascript' src='js/site/<?php echo SITE_COMMON_DEFINE ?>jquery.easing.1.3.js'></script> 
    <script type='text/javascript' src='js/site/<?php echo SITE_COMMON_DEFINE ?>camera.min.js'></script> 
    
    <script>
		jQuery(function(){
			
			jQuery('#camera_wrap_2').camera({
				thumbnails: true
			});
		});
	</script>


<!---CONTENT-->



<?php  //die(var_dump($CityDetails->result_array())); ?>


<div class="content">
	
    
    <div class="static_banner">
    
    		<div class="camera_wrap camera_azure_skin" id="camera_wrap_2">
             
             
             

 <?php
			/*if($CityDetails->num_rows() > 0){*/
				foreach($CityDetails->result() as $CityRow){ ?>
					<!--//echo '<li><a href="neighborhood/'.$CityRow->cityurl.'">'.ucfirst($CityRow->name).'</a></li>';-->
                    <div data-src="images/city/<?php echo $CityRow->citylogo; ?>" style="height:700px;">
                     <div class="camera_caption caption fadeFromBottom">
                	<div class="slidebanner_content">
        
        				<span><a href="<?php echo "neighborhood/".$CityRow->cityurl; ?>"><?php echo ucfirst($CityRow->name); ?></a></span>
        
                        <!--<span><?php //echo ucfirst($CityRow->name); ?><!--,<strong><?php //echo ucfirst($CityRow->cityurl); ?></strong>-->
        
        
        			</div>
                </div>
					</div>
			  <?php	} 
			/*}*/
			
			 ?>




             
             
             
                        
            
            <!--<div data-src="images/city/334138.jpg" style="height:700px;">
            
                <div class="camera_caption caption fadeFromBottom">
                	<div class="slidebanner_content">
        
        				<span>Dumbo,<strong>New York</strong></span>
        
        			</div>
                </div>
                
            </div>-->
            
            
            
        </div>
    
    
    
    <!--<div id="slidebanner">
    
    	<div class="slidebanner_content">
        
        	<span>Dumbo,<strong>New York</strong></span>
        
        </div>
          
<?php /*?>         <?php 
	$citybgimage='empty_banner.jpeg';
	 ?><?php */?>
    	<img src="images/city/334138.jpg" class="active" height="500" />
        
        <img src="images/city/536216.jpg" />
        
        <img src="images/city/444289_(1).jpg" />
        
        <img src="images/city/462786_(1).jpg" />
          
       
        </div>-->
        
        
   
        <div class="static_banner_txt">
        
        	<h1><?php if($this->lang->line('neighborhoods') != '') { echo stripslashes($this->lang->line('neighborhoods')); } else echo "Neighborhoods";?></h1>
           <div class="container"><ul class="neibr-menu">
            <?php
			if($CityDetails->num_rows() > 0){
				foreach($CityDetails->result() as $CityRow){
					echo '<li><a href="neighborhood/'.$CityRow->cityurl.'">'.ucfirst($CityRow->name).'</a></li>';
				}
			}
			
			 ?>
             </ul></div>
        </div>
         
    </div>
    
</div>
<!---CONTENT-->
<?php 
// $this->load->view('site/templates/content_above_footer');
 $this->load->view('site/templates/footer');
?>