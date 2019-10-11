<?php 
$this->load->view('site/templates/header');
//url/locations/san-francisco/neighborhoods
?>

<style>
.containerss {
    
    background-repeat: no-repeat;
   	width: 100%;
    height: 120px;
    border: 1px solid #ddd;
}
.neighborhood_txt{
	top:38px;
	width:auto !important;
}
.neighborhood_txt h1 {
    color: #fff;
    font-size: 40px;
    text-align: left;
    text-shadow: 0 1px 7px #000000;
}
.cover { background-size: cover; }
</style>
<!---CONTENT-->
<div class="content">
	<div class="top_content_links">
    	<div class="container">
        	<ul id="neighborhood_nav" class="crumbs">
            <li><a href="<?php echo base_url(); ?>"><?php if($this->lang->line('header_home') != '') { echo stripslashes($this->lang->line('header_home')); } else echo "Home";?></a></li>
           		 <li><a href="neighborhood"><?php if($this->lang->line('cities') != '') { echo stripslashes($this->lang->line('cities')); } else echo "Cities";?></a></li>
            	 <li><a class="" style="cursor:default; text-decoration:none;" href="javascript:void(0);"><?php echo ucfirst($CityList->row()->name);?></a></li>
            </ul>
            <ul class="crumbs right">
                <li>
                            <a href="javascript:void(0);" ><span class="message"><?php if($this->lang->line('saved_neighborhoods') != '') { echo stripslashes($this->lang->line('saved_neighborhoods')); } else echo "Saved neighborhoods";?></span> <span id="saveCount" class="pip neighborhood-count"><?php echo $SavedNeibur->num_rows(); ?></span></a>
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
                  <a class="to-p2" target="_blank" href="#">
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
    	<img class="containerss cover" style="background-image: url(<?php echo base_url().'images/city/'.$citybgimage; ?>);" />
        <div class="main">
        	<div class="static_banner_txt neighborhood_txt">
        	<h1><?php if($this->lang->line('find_neighbor') != '') { echo stripslashes($this->lang->line('find_neighbor')); } else echo "Find a Neighborhood in";?> <?php echo ucfirst($CityList->row()->name);?></h1>
        </div>
        	<div class="section section-offset clearfix" style="border:none;" id="options" >
                    <div class="container">
                      <div class="row">
                        <div class="span12">
                          <h3 style="text-align:left;">What kind of neighborhood are you looking for?</h3>
                        </div>
                      </div>
                      
                      <ul id="filters" class="traits option-set clearfix" data-option-key="filter">
                		<li class="trait"><a href="#filter" data-option-value="*" class="trait-link large btn selected">
                		<span class="check"><!--<i class="icon icon-ok"></i>--></span>
                        <span class="name">All</span>
                        </a></li>
                        <?php if($categoryArr->num_rows() > 0){ foreach($categoryArr->result() as $CatRow){?>
                        <li class="trait"><a href="#filter" data-option-value=".<?php echo $CatRow->attr_name; ?>" class="trait-link large btn ">
                		<span class="check"><!--<i class="icon icon-ok"></i>--></span>
                        <span class="name"><?php echo $CatRow->attr_name; ?></span>
                        <!--<span class="count">10</span>--></a></li>
                    	<?php } }?>
                   
                </ul>
                
                
                
                    </div>
                  </div>
        
        </div>
    </div>
    
</div>

<section class="featured-neighborhoods section" style="background:#f7f7f7; border:1px solid #dbdbdb;">
      <div class="container">
        <div class="row">
          <div class="span12  center">
            <h4 class="shiftbold" align="left">
              <span id="NeiCount"></span><?php //echo $NeighborhoodList->num_rows();?> <?php if($this->lang->line('match_neighbor') != '') { echo stripslashes($this->lang->line('match_neighbor')); } else echo "neighborhoods match Touristy.";?>
              <!--<a target="_blank" href="#">See all listings »</a>-->
            </h4>
            <ul class=" neighborhoods clearfix" id="container" >
            <?php if($NeighborhoodList->num_rows() > 0){
		  			foreach($NeighborhoodList->result() as $NeighborhoodRow){ ?>
                    
      			<li style="" data-neighborhood-permalink="nolita" data-neighborhood-id="486" class=" element tile <?php $NeicategoryArr=@explode(',',$NeighborhoodRow->category); if(!empty($NeicategoryArr)){foreach($NeicategoryArr as $Row){ echo $Row.' ';}} ?>">
        <div class="photo">
  <h3 class="shiftbold"><a class="" href="neighborhood/<?php echo $CityList->row()->seourl;?>/<?php echo $NeighborhoodRow->seourl; ?>"><?php echo $NeighborhoodRow->name; ?></a></h3>
  <a class="" href="neighborhood/<?php echo $CityList->row()->seourl;?>/<?php echo $NeighborhoodRow->seourl; ?>"><img width="315" height="210" src="images/city/<?php echo $NeighborhoodRow->citythumb; ?>" alt="<?php echo $NeighborhoodRow->name; ?>"></a>
</div>
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
  <p>
  </p>
</div>
      </li>
      		<?php 
			  		}
			  
			  } ?>
			</ul>
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
          <?php if($NeighborhoodList->num_rows() > 0){
		  			foreach($NeighborhoodList->result() as $NeighborhoodRow){ ?>
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
  <script src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
  <script src="<?php echo base_url(); ?>js/site/jquery.isotope.min.js"></script>
  <script>
    $(function(){
      
      var $container = $('#container');

      $container.isotope({
        itemSelector : '.element'
      });
      
      
      var $optionSets = $('#options .option-set'),
          $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
          return false;
        }
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected');
  		
        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[ key ] = value;
        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
          // changes in layout modes need extra logic
          changeLayoutMode( $this, options )
        } else {
          // otherwise, apply new options
          $container.isotope( options );
		  // COUNT
        var $filtered = $('#container').data('isotope').$filteredAtoms;
        // get count of all filtered item
        $('#NeiCount').html($filtered.length);
        }
        
        return false;
      });

      
    });
  </script>

<!---CONTENT-->
<?php 
 $this->load->view('site/templates/footer');
?>