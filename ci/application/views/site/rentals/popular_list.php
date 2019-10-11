<?php 
$this->load->view('site/templates/header');
?>
 <div class="yourlisting bgcolor">
<div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li class="active"><a href="<?php echo base_url(); ?>popular" class="write_title"><?php if($this->lang->line('popular') != '') { echo stripslashes($this->lang->line('popular')); } else echo "Popular"; ?></a></li>
          <?php if($loginCheck!=''){ ?>
          <li><a href="<?php echo base_url(); ?>browsefriends" class="write_title"><?php if($this->lang->line('Friends') != '') { echo stripslashes($this->lang->line('Friends')); } else echo "Friends"; ?></a></li>
          <li><a href="<?php echo base_url(); ?>users/<?php echo $loginCheck; ?>/wishlists" class="write_title"><?php if($this->lang->line('MyWishLists') != '') { echo stripslashes($this->lang->line('MyWishLists')); } else echo "My Wish Lists"; ?></a></li>
          <?php } ?>
              <li></li>
            </ul> </div></div></div>

<div class="body_content">
	<div class="container">


    <div>
      <ul class="popular-listing">
   <?php  //echo("<pre>");print_r($product->result());die; ?>
       <?php  $count=0;
       if($product->num_rows()>0)
   {
   	foreach($product->result_array() as $product_image )
   	{ $count++;
   	if(($count%5)==0)
   	{ 
   		$li_class_name='big-poplr';
   	}else {
   		$li_class_name='';
   	}
   	?>
   <li class="<?php echo $li_class_name; ?>">
   <div class="img-top">
           <div class="figures-cobnt">
         <?php   if(($product_image['product_image']!='') &&(file_exists('./server/php/rental/'.$product_image['product_image'])))
           {?>
            <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>">
         
            <img src="<?php echo base_url();?>server/php/rental/<?php echo $product_image['product_image'];?>">
               </a>
              <?php }else{?> 
               <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>">
              <img src="<?php echo  base_url();?>server/php/rental/dummyProductImage.jpg">
              </a>
              <?php }?>
            </div>
           <div class="posi-abs">
            <!-- <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>"  class="heart"> </a>-->
			<?php if($loginCheck==''){?>
              <a class="ajax cboxElement heart reg-popup" href="site/rentals/AddWishListForm/<?php echo $product_image['id'];?>"></a>
			 
			 <?php } else { ?>
            <a class="ajax cboxElement <?php if(in_array($product_image['id'],$newArr))echo 'heart-exist'; else echo 'heart';?>" href="site/rentals/AddWishListForm/<?php echo $product_image['id'];?>"></a>
			<?php }?>
            
           <label class="pric-tag"><?php  echo $currencySymbol.$product_image['price'];?></label>
          <a class="aurtors num2" href="<?php echo base_url();?>users/show/<?php echo $product_image['user_id'];?>">
<img src="<?php echo base_url();?><?php if($product_image['user_image']!=''){echo 'images/users/'.$product_image['user_image'];}else{echo 'images/user_unknown.jpg';}?>" style="border-radius: 50%;">
</a>
          </div>
           </div>
           <div class="img-bottom">
            <span class="headlined23"><?php  echo $product_image['product_title'];?></span>
             <p class="describ"><?php  echo $product_image['city'];?></p>
            </div>
          
            </li>
           
  <?php  	
   }} ?>
             
             
          


    


    </ul>
<div id="infscr-loading" style="display: none;">
					<!--img alt='Loading...' src="/_ui/images/site/common/ajax-loader.gif"-->
					<span class="loading">Loading...</span>
				</div>
				<div class="pagination" style="display: block" id="sample">
				<?php echo $paginationDisplay; ?>
				</div>
   <!--<ul class="wishlists-list popuar-wish">
   
  <?php  
 if (($wishlist != '' && $wishlist->num_rows()>0)){
   foreach( $wishlist->result() as $product_image)
   	{ 	
         		$Count = 0;
         		if ($product_image->product_id != ''){
         			$Count = count(array_filter(explode(',', $product_image->product_id)));
         		}
         		?>
  
   <li class="wishlists-list-item has-photo-pile">
	    <div class="photo-heart-container">
	    <a href="user/<?php echo $product_image->user_id;?>/wishlists/<?php echo $product_image->id;?>">
	    <div class="photo-pile">
	    <div class="matte-media-box">
	    <div class="wishlist-label-outer-container">
	    <div class="wishlist-label-inner-container">
	      <img style="min-height: 100%;min-width: 100%;" src=" <?php echo base_url();?>server/php/rental/<?php echo $popular_image1[$product_image->id] ?>">
	    <div class="wishlist-label panel-background-dark-trans inner-glow panel-border">
	    <h4 class="color-white weight-normal"><?php  echo $product_image->name; ?></h4>
	    <span class="color-gray font-tiny listings-count"><?php echo $Count;?> Listings</span>
	    </div>
	    </div>
	    </div>
	    </div>
	    </div>
	    </a>
	    </div>
    </li> <?php }}?>
    
 
    
</ul>-->

</div></div>
    </div>
    
  <script>
    var $win     = $(window);
    var loading=false;
    	$(window).scroll(function()  
    //function xx(evt)
    { 
    		if(($(window).scrollTop() + $(window).height()) > ($(document).height()-500)) //user scrolled to bottom of the page?
    		{
        		
    		  	var surl= $('.btn-more').attr('href');
    	if(!surl) surl='';
    			if(surl != '' && loading==false) //there's more data to load
    			{
        			
    				loading = true; //prevent further ajax loading
    				//$('#infscr-loading').show(); 
    	$.ajax({
    					type : 'get',
    						url : surl,
    						
    						dataType : 'html',
    						success : function(response)
    						{
        				
    				var responce_html=$(response);
    				var res_val=responce_html.find('ul.popular-listing li');
    				$('ul.popular-listing').append(res_val);
    				$('.pagination a').remove();
    				var respo_val=responce_html.find('a.btn-more');
    				$('.pagination').append(respo_val);
    	            $('#infscr-loading').hide(); //hide loading image once data is received
    					
    					loading = false; 
    					after_ajax_load();
    				
    						}
    					});return false;
    	}}});
    </script> 

 <?php
$this->load->view('site/templates/footer');
?>
<!-- <div class="popular_2up_listings_view feed_item_view row list-item">
    <?php 
		if($loginCheck!=''){
		$WishRentArr=array();
			$WishListCat = $this->product_model->get_list_details_wishlist($loginCheck);
			$WishRentals='';
			if($WishListCat->num_rows() > 0){
				foreach($WishListCat->result() as $WishArr ){
					$WishRentals.=$WishRentals.','.$WishArr->product_id;
				}
			}
			$WishRentArr=@array_filter(@array_unique(@explode(',',$WishRentals)));
			
		}
		if(count($productList->result()) > 0){
			
			foreach($productList->result() as $Row_Rental){
				if($Row_Rental->product_image !=''){
					$ImgSrc=$Row_Rental->product_image;
				}else{
					$ImgSrc='dummyProductImage.jpg';
				} ?>
  		<div class="span6 photo-heart-container">
       <?php  if($loginCheck!=''){  ?><a href="site/rentals/AddWishListForm/<?php echo $Row_Rental->id;?>" data-tooltip-position="right" class="wish_list_button ajax cboxElement" ><i class="icon icon-heart icon-size-2 fa fa-heart <?php if(in_array($Row_Rental->id,$WishRentArr)){echo 'pink icon-pink';} ?>"></i></a>
       
       
       
       <?php }else{?>
  <button data-tooltip-position="right" class="wish_list_button reg-popup">
      <i class="icon icon-heart icon-size-2 fa fa-heart"></i>
    </button><?php } ?>
    <a href="rental/<?php echo $Row_Rental->id; ?>" class="beveled-media-box rect">
      <img src="<?php echo PRODUCTPATH.$ImgSrc; ?>" alt="" class="" height="322" width="483">
      
      
    
      <div class="img_shadow_box">
      
          <div class="caption caption-fade rect">
            <h4><?php echo $Row_Rental->product_title; ?></h4>
            <p><i class="icon icon-map-marker"></i><span><?php echo $Row_Rental->room_type; ?> , <?php echo $Row_Rental->city_name; ?></span></p>
          </div>
          
          
      <div class="price-tag-center">
        <div class="price-tag-currency"><?php echo $currencySymbol; ?></div>
        <div class="price-tag-price"><?php echo $Row_Rental->price * $this->session->userdata('currency_r'); ?></div>
        <div class="price-tag-per-night">per night</div>
      </div>
    
	  </div>

    </a>
    
    <!--<button class="wish_list_button not_saved heart btn gray large" data-hosting_id="1338967" data-img="https://a0.muscache.com/pictures/21556113/medium.jpg" data-name="cosy apartment, Canal Saint-Martin" data-address="Rue Marie et Louise, Paris, Île-de-France 75010, France" rel="tooltip" title="Save to Wish List" data-tooltip-position="right">
      <i class="icon icon-product-wishlist pink"></i>
    </button>-->
     
    <?php 	}
		} ?>
    
 
 

    
   