<?php 
$this->load->view('site/templates/header');
//url/neighborhood/newark
?>
<!---CONTENT-->
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>

<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<div class="content">
  <div class="top_content_links">
    <div class="container">
      <ul id="neighborhood_nav" class="crumbs">
      <li><a href="<?php echo base_url(); ?>"><?php if($this->lang->line('header_home') != '') { echo stripslashes($this->lang->line('header_home')); } else echo "Home";?></a></li>
           		 <li><a href="neighborhood"><?php if($this->lang->line('cities') != '') { echo stripslashes($this->lang->line('cities')); } else echo "Cities";?></a></li>
        <!-- neighborhood/<?php //echo $CityList->row()->seourl;?>-->
        <li><a class="" style="cursor:default; text-decoration:none;" href="javascript:void(0);"><?php echo ucfirst($CityList->row()->name);?></a></li>
      </ul>
      <ul class="crumbs right">
        <li> <a href="javascript:void(0);"><span class="message"><?php if($this->lang->line('saved_neighborhoods') != '') { echo stripslashes($this->lang->line('saved_neighborhoods')); } else echo "Saved neighborhoods";?></span> <span id="saveCount" class="pip neighborhood-count"><?php echo $SavedNeibur->num_rows(); ?></span></a>
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
          <div class="flyout">
            <ul class="saved-neighborhoods">
            </ul>
            <h4> <a class="to-p2" target="_blank" href="#"> <?php if($this->lang->line('see_all_neighborhoods') != '') { echo stripslashes($this->lang->line('see_all_neighborhoods')); } else echo "See listings in all saved neighborhoods »";?></a> </h4>
          </div>
        </li>
      </ul>
    </div>
  </div>
  <div class="static_banner">
  
  	<div class="static_banner_box">
    <?php 
	$citybgimage='empty_banner.jpeg';
	if($CityList->row()->citylogo !=''){
		$citybgimage=$CityList->row()->citylogo;
	} ?>
    <img src="images/city/<?php echo $citybgimage; ?>" />
    </div>
    <div class="static_banner_txt">
      <h1><?php echo ucfirst($CityList->row()->name);?></h1>
      <h2><?php echo $CityList->row()->short_description; ?></h2>
      <a class="btn large gray" style="text-transform:none" href="locations/<?php echo $CityList->row()->seourl; ?>/neighborhoods"><?php if($this->lang->line('find_neighbor') != '') { echo stripslashes($this->lang->line('find_neighbor')); } else echo "Find a neighborhood";?></a> </div>
  </div>
</div>
<section class="section section-offset" id="city_summary">
  <div class="container">
    <div class="row space2">
      <div class="span3 widget">
        <h5><?php if($this->lang->line('get_around_with') != '') { echo stripslashes($this->lang->line('get_around_with')); } else echo "Get around with";?></h5>
        <big class="shiftbold"><?php echo $CityList->row()->get_around; ?></big>
        <div class="extra">
          <p>New Yorkers get around primarily via the subway and taxi system. New York's subway system is one of the best in the world and you can get virtually anywhere in the city for a flat fee of $2.50 24 hours a day. Taxis are readily available across central and downtown Manhattan and conveniently, they take credit cards. Driving your own car is only possible in the outer neighborhoods unless you want to spend a fortune on parking and pass many hours sitting in traffic.</p>
        </div>
      </div>
      <div class="span3 widget">
        <h5><?php if($this->lang->line('place_to_stay') != '') { echo stripslashes($this->lang->line('place_to_stay')); } else echo "Places to stay";?></h5>
        <big class="shiftbold"><?php echo $RentalsCount->row()->total; ?></big> <a href="property?city=<?php echo @str_replace(' ','+',$CityList->row()->name);?>">See <?php echo $RentalsCount->row()->total; ?> listings »</a> </div>
      <div class="span6 widget">
        <h5>Known for</h5>
        <p><?php echo $CityList->row()->known_for; ?></p>
      </div>
    </div>
    <div class="row space2">
    	<div class="span6">
    		<div class="fact row-fluid panel-border">
            <div class="fact-icon span3">
              <img width="60" height="60" src="images/locals-love.png" alt="Locals Love">
            </div>
            <div class="fact-text span8">
              <h4>Locals Love</h4>
              <p>Bank holidays, free museums, the footy, street markets, smart sarcasm, Sunday roasts, real ale pubs, pop-ups, curry, tea and cake, the NHS, minding the gap</p>
            </div>
        </div>
        </div>
        
        <div class="span6">
    		<div class="fact row-fluid panel-border">
                <div class="fact-icon span3">
                  <img width="60" height="60" src="images/locals-complain.png" alt="Locals Complain About">
                </div>
                <div class="fact-text span8">
                  <h4>Locals Complain About</h4>
                  <p>The weather, highrents, rising tube fares, queues, commute times, slow walkers, the NHS, politiciansand bankers, people who stand on the left</p>
                </div>
            </div>
        </div>
    
    </div>
  </div>
</section>
<section class="featured-neighborhoods section" style="background:#f7f7f7;">
  <div class="container">
    <div class="row">
      <div class="span12  center">
        <h2 class="shiftbold"> <?php if($this->lang->line('feature_neighborhoods') != '') { echo stripslashes($this->lang->line('feature_neighborhoods')); } else echo "Featured Neighborhoods ";?></h2>
        <p class="lede">Explore <?php echo ucfirst($CityList->row()->name);?> neighborhoods. Which are right for you?</p>
        <ul class=" neighborhoods">
          <?php if($NeighborhoodList->num_rows() > 0){
				$ncount=0;
		  			foreach($NeighborhoodList->result() as $NeighborhoodRow){ 
					$ncount=$ncount+1;
						//if($ncount < 4){ ?>
          <li <?php if($ncount < 4){echo 'class="lessthree tile"'; }else{echo 'class="grethree tile"';} ?> data-neighborhood-permalink="nolita" data-neighborhood-id="486">
            <div class="photo">
              <h3 class="shiftbold"><a class="" href="neighborhood/<?php echo $CityList->row()->seourl;?>/<?php echo $NeighborhoodRow->seourl; ?>"><?php echo $NeighborhoodRow->name; ?></a></h3>
              <a class="" href="neighborhood/<?php echo $CityList->row()->seourl;?>/<?php echo $NeighborhoodRow->seourl; ?>"><img width="315" height="210" src="images/city/<?php echo $NeighborhoodRow->citythumb; ?>" alt="<?php echo $NeighborhoodRow->name; ?>"></a> </div>
            <div class="blurb">
              <p><?php echo $NeighborhoodRow->short_description;?></p>
              <ul class="tags">
                <?php 
	if($NeighborhoodRow->tags!=''){
	$tagsArr=explode(',',$NeighborhoodRow->tags);

	foreach($tagsArr as $TagRow){
	echo '<li>'.ucfirst($TagRow).'</li>';
	}
	}?>
              </ul>
            </div>
            <div style="display: none;" class="sub friends">
              <ul>
              </ul>
              <p> </p>
            </div>
          </li>
          <?php 
						//}
			  		}
			  
			  }else{ ?>
          <li style="text-align:center; color:#FF0000;"><?php if($this->lang->line('no_neighborhoods') != '') { echo stripslashes($this->lang->line('no_neighborhoods')); } else echo "No neighborhoods found.";?></li>
          <?php }?>
        </ul>
        <?php if($NeighborhoodList->num_rows() > 3){ ?>
        <!--href="locations/<?php //echo $CityList->row()->seourl; ?>/neighborhoods"onclick="CityViewAll();"-->
        <a class="view_cities btn large center" style="text-transform:none; font-size:15px;" href="locations/<?php echo $CityList->row()->seourl; ?>/neighborhoods" >More neighborhoods »</a>
        <?php  } ?>
      </div>
    </div>
  </div>
</section>
<section class="neighborhood-list section section-offset">
  <div class="container">
    <div class="row">
      <div class="span12">
        <h4><?php if($this->lang->line('all_neighborhoods') != '') { echo stripslashes($this->lang->line('all_neighborhoods')); } else echo "All Neighborhoods";?></h4>
      </div>
    </div>
    <div class="row"> <a name="all-neighborhoods"></a>
      <div class="span3">
        <ul>
          <?php if($AllNeighborhoodList->num_rows() > 0){
		  			foreach($AllNeighborhoodList->result() as $NeighborhoodRow){ ?>
          <li><a href="neighborhood/<?php echo $CityList->row()->seourl;?>/<?php echo $NeighborhoodRow->seourl; ?>"><?php echo ucfirst($NeighborhoodRow->name); ?></a></li>
          <?php 
			  		}
			  
			  }else{?>
          <li><?php if($this->lang->line('no_neighborhoods') != '') { echo stripslashes($this->lang->line('no_neighborhoods')); } else echo "No neighborhoods found.";?></li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</section>
<!---CONTENT-->
<script type="text/javascript">
$(document).ready( function(){
	$('.grethree').hide();
});
function CityViewAll(){
	$('.grethree').show();
	$('.view_cities').hide();
}
</script>
<?php 
 $this->load->view('site/templates/footer');
?>
