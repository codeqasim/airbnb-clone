<?php 
$this->load->view('site/templates/header');
//url/neighborhood/newark/el-raval
?>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<!---CONTENT-->
<?php //die(var_dump($CityList->result_array())); ?>

<div class="content">
	<div class="top_content_links">
    	<div class="container">
        	<ul id="neighborhood_nav" class="crumbs">
            	<li><a href="<?php echo base_url(); ?>"><?php if($this->lang->line('header_home') != '') { echo stripslashes($this->lang->line('header_home')); } else echo "Home";?></a></li>
           		 <li><a href="neighborhood"><?php if($this->lang->line('cities') != '') { echo stripslashes($this->lang->line('cities')); } else echo "Cities";?></a></li>
            	 <li><a class="" href="neighborhood/<?php echo $NeighborhoodName->row()->seourl; ?>"><?php echo ucfirst($NeighborhoodName->row()->name);?></a></li>
                 <!--neighborhood/<?php //echo $NeighborhoodName->row()->seourl; ?>/<?php //echo $CityList->row()->seourl;?>-->
                 <li><a class="" style="cursor:default; text-decoration:none;"  href="javascript:void();"><?php echo ucfirst($CityList->row()->name);?></a></li>
            </ul>
            <ul class="crumbs right">
                <li>
                            <a href="javascript:void(0);" onclick="SavedNeighborhoods('<?php echo $CityList->row()->seourl;?>','<?php echo $NeighborhoodName->row()->seourl;?>');"><span class="message"><?php if($this->lang->line('saved_neighborhoods') != '') { echo stripslashes($this->lang->line('saved_neighborhoods')); } else echo "Saved neighborhoods";?></span> <span id="saveCount" class="pip neighborhood-count"><?php echo $SavedNeibur->num_rows(); ?></span></a>
                            <div  id="saved_details" style="display:none;">
                            	<ul>
                            <?php 
								if($SavedNeibur->num_rows() > 0){
									foreach($SavedNeibur->result() as $Rows){
									echo '<li id="row_'.$Rows->id.'"><a href="'.$Rows->url.'">'.ucfirst(str_replace('-',' ',$Rows->neighborhood)).'</a><a class="remove" onclick="DeleteNeighborhoods('.$Rows->id.');" href="javascript:void(0);">&times;</a></li>';
									}
								
								}
							
							?>
                            	</ul>
                            </div>
                            <div class="flyout"><ul class="saved-neighborhoods"></ul>
                <h4>
                  <a class="to-p2" target="_blank" href="property?city=<?php echo $CityList->row()->name;?>">
                    <?php if($this->lang->line('see_all_neighborhoods') != '') { echo stripslashes($this->lang->line('see_all_neighborhoods')); } else echo "See listings in all saved neighborhoods »";?>
                  </a>
                </h4>
                </div>
                          </li>
                            
                        
      		</ul>
        </div>
    </div>
    
    <div class="static_banner">
    <?php 
	$citybgimage='empty_banner.jpeg';
	if($CityList->row()->citylogo !=''){
		$citybgimage=$CityList->row()->citylogo;
	} ?>
    	<img src="images/city/<?php echo $citybgimage; ?>" />
        <div class="static_banner_txt">
  
         <div class="container"><ul>
            <?php
			$val = explode(",",$CityList->row()->category);
			
				foreach($val as $key){
					echo '<li><a href="locations/'.$NeighborhoodName->row()->seourl.'/neighborhoods">'.ucfirst($key).'</a></li>';
				}
			
			
			 ?>
             </ul></div>       
        
        
        
           
            
        	<div align="center"><br /><h1 ><?php echo ucfirst($CityList->row()->name);?></h1></div>
            <h2><?php echo $CityList->row()->short_description; ?></h2>
           <!-- <a class="btn large gray" style="text-transform:none" href="locations/<?php echo $CityList->row()->seourl; ?>/neighborhoods">Find a neighborhood</a>-->
        </div>
    </div>
    
</div>
<div class="main"><div class="neig-middle"><div class="neibr-left">
<?php echo $CityList->row()->description; ?>
<a style="font-weight: bold; padding: 10px 50px; font-size: 14px;" id="listings_button" class="btn" target="_blank" href="property?city=<?php echo @str_replace(' ','+',$NeighborhoodName->row()->name);?>&neighborhood=<?php echo  $CityList->row()->seourl; ?>"> See places to stay </a>
</div>

<div  style="float:right">

<h2>The community says:</h2>

<ul class="tags">
<?php 
if($CityList->row()->tags !=''){
 foreach(explode(',',$CityList->row()->tags) as $TagRow){
 	echo '<li style="opacity: 0.95"> '.$TagRow.' </li>';
 }
}?>

</ul>

</div>
</div></div>

<!--<section class="section section-offset" id="city_summary">
    <div class="container">
      <div class="row space2">
          <div class="span3 widget">
            <h5><?php if($this->lang->line('get_around_with') != '') { echo stripslashes($this->lang->line('get_around_with')); } else echo "Get around with";?></h5>
              <big class="shiftbold"><?php //if($this->lang->line('public_transit') != '') { echo stripslashes($this->lang->line('public_transit')); } else echo "Public Transit";?><?php echo $CityList->row()->get_around; ?></big>
             
          </div>
          <div class="span3 widget">
            <h5><?php if($this->lang->line('place_to_stay') != '') { echo stripslashes($this->lang->line('place_to_stay')); } else echo "Places to stay";?></h5>
            <big class="shiftbold"><?php echo $RentalsCount->row()->total; ?></big>
            <a target="_blank" href="property?city=<?php echo @str_replace(' ','+',$CityList->row()->name);?>">See <?php echo $RentalsCount->row()->total; ?> listings »</a>
          </div>
          <div class="span6 widget">
              <h5>Known for</h5>
              <p><?php echo $CityList->row()->known_for; ?></p>
          </div>

      </div>

    </div>
  </section>-->
  
<section class="featured-neighborhoods section" >
      <div class="container">
        <div class="row">
          <div class="span12  center">
            <h2 class="shiftbold">
            <?php //echo ucfirst($CityList->row()->name);?>
            </h2>
			<?php //echo $CityList->row()->description;?>
            <br /><div class="clear"></div>
            <iframe width='900' height='350' frameborder='1' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.com/maps?q=<?php echo $CityList->row()->name; ?>&hl=en&amp;ie=UTF8&amp;ll=<?php echo $CityList->row()->latitude; ?>,<?php echo $CityList->row()->longitude; ?>&amp;t=m&amp;z=5&amp;output=embed'></iframe>

          </div>
        </div>
      </div>
    </section>
<!---CONTENT-->
<?php 
// $this->load->view('site/templates/content_above_footer');
 $this->load->view('site/templates/footer');
?>