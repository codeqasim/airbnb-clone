<?php
$this->load->view('site/templates/header');
?>
<!-- <link rel="stylesheet" type="text/css" media="all" href="css/site/<?php echo SITE_COMMON_DEFINE ?>timeline.css"/> -->
<style type="text/css" media="screen">


#edit-details {
    color: #FF3333;
    font-size: 11px;
}
.option-area select.option {
    border: 1px solid #D1D3D9;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 1px 1px 1px #EEEEEE;
    height: 22px;
    margin: 5px 0 12px;
}
a.selectBox.option {
    margin: 5px 0 10px;
    padding: 3px 0;
}
a.selectBox.option .selectBox-label {
    font: inherit !important;
    padding-left: 10px;

}
.button:hover {
	background: #3e73b7;
}
.button {
	cursor: pointer;
	overflow: visible;
	margin: 5px 0px;
	padding: 8px 8px 10px 7px;
	border: 0;
	border-radius: 4px;
	font-weight: bold;
	font-size: 15px;
	line-height: 22px;
	text-align: center;
	color: #fff;
	background: #588cc7;
}
</style>



 <!-- Section_start -->
<div class="lang-en wider no-subnav thing signed-out winOS">

<div id="container-wrapper">
	<div class="container ">
<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
	<?php 
	if ($productDetails->num_rows()==1){
		$img = 'dummyProductImage.jpg';
		$imgArr = explode(',', $productDetails->row()->image);
		if (count($imgArr)>0){
			foreach ($imgArr as $imgRow){
				if ($imgRow != ''){
					$img = $pimg = $imgRow;
					break;
				}
			}
		}
		$fancyClass = 'fancy';
		$fancyText = LIKE_BUTTON;
		if (count($likedProducts)>0 && $likedProducts->num_rows()>0){
			foreach ($likedProducts->result() as $likeProRow){
				if ($likeProRow->product_id == $productDetails->row()->seller_product_id){
					$fancyClass = 'fancyd';$fancyText = LIKED_BUTTON;break;
				}
			}
		}
	?>	

				<div class="wrapper-content right-sidebar">
			<div id="content">
				<div class="figure-row first">
					<div class="figure-product figure-640 big">
						
						<figure>
							<span class="wrapper-fig-image">
								<span class="fig-image"><img src="<?php echo base_url();?>images/product/<?php echo $img;?>" alt="<?php echo $productDetails->row()->product_name;?>" height="640" width="640"></span>
							</span>
                            
                            <figcaption><?php echo $productDetails->row()->product_name;?></figcaption>
						    
                        </figure>
						
						<br class="hidden">
						
						<p>by <a href="<?php if ($productDetails->row()->user_id != '0'){echo base_url().'user/'.$productDetails->row()->user_name;}else {echo base_url().'user/administrator';}?>" class="username"><?php if ($productDetails->row()->user_id != '0'){echo $productDetails->row()->full_name;}else {echo 'administrator';}?></a> + <?php echo $productDetails->row()->likes;?> <?php if($this->lang->line('product_others') != '') { echo stripslashes($this->lang->line('product_others')); } else echo "others"; ?></p>
						
<?php if ($loginCheck != ''  && ($userDetails->row()->id == $productDetails->row()->user_id)){?>
						
                             <a id="edit-details" href="things/<?php echo $productDetails->row()->seller_product_id;?>/edit"><?php if($this->lang->line('product_edit_dtls') != '') { echo stripslashes($this->lang->line('product_edit_dtls')); } else echo "Edit details"; ?></a>
                                
                               
                             <a style="font-size: 11px; color: #f33;" uid="<?php echo $productDetails->row()->user_id;?>" thing_id="<?php echo $productDetails->row()->seller_product_id;?>" ntid="7220865" class="remove_new_thing" href="things/<?php echo $productDetails->row()->seller_product_id;?>/delete"><?php if($this->lang->line('shipping_delete') != '') { echo stripslashes($this->lang->line('shipping_delete')); } else echo "Delete"; ?></a>
                                
						<?php }?>     
						<br class="hidden">
						
						<a href="#" item_img_url="images/product/<?php echo $img;?>" tid="<?php echo $productDetails->row()->seller_product_id;?>" class="button <?php echo $fancyClass;?>" <?php if ($loginCheck==''){?>require_login="true"<?php }?>><span><i></i></span><?php echo $fancyText;?></a>
						

					</div>
					<!-- / figure-product figure-640 -->
				</div>
				<!-- / figure-row -->

                 <section class="comments comments-list comments-list-new">
                    
                    <!--<button id="btn-viewall-comments" class="toggle">View all 28 comments <i></i></button>
					<button id="toggle-comments" class="toggle"><span>View all 28 comments</span> <i></i></button>-->
                    
					<!-- template for normal comments -->
					
					<!-- template for reported comments -->
					
					<ol user_id="">
						
						<li class="loading"><span>Loading...</span></li>
					</ol>
					<ol user_id="">
						<?php 
						if ($productComment->num_rows() > 0){
							foreach ($productComment->result() as $cmtrow){
								if ($cmtrow->status == 'Active'){
									
							
						?>
						
						<li class="comment">
							<a class="milestone" id="comment-1866615"></a>
							<span class="vcard"><a href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>" class="url"><img src="images/users/<?php if($cmtrow->image!=''){ echo $cmtrow->image;}else{echo 'user-thumb.png';}?>" alt="" class="photo"><span class="fn nickname"><?php echo ucfirst($cmtrow->user_name);?></span></a></span>
							<p class="c-text"><?php echo $cmtrow->comments;?></p>
							
                            
						</li>
						
						<?php 
								}else {
									if ($loginCheck == $productDetails->row()->user_id){
						?>
						<li class="comment">
							<a class="milestone" id="comment-1866615"></a>
							<span class="vcard"><a href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>" class="url"><img src="images/users/<?php if($cmtrow->image!=''){ echo $cmtrow->image;}else{echo 'user-thumb.png';}?>" alt="" class="photo"><span class="fn nickname"><?php echo ucfirst($cmtrow->user_name);?></span></a></span>
							<p class="c-text"><?php echo $cmtrow->comments;?></p>
							<p style="float:left;width:100%;text-align:left;">
								<a style="font-size: 11px; color: #188A0E;" onclick="javascript:approveCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>">Approve</a>
								<a style="font-size: 11px; color: #f33;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>">Delete</a>
							</p>	
                            
						</li>
						<?php 		
									}else {
										if ($loginCheck == $cmtrow->CUID){
						?>
						<li class="comment">
							<a class="milestone" id="comment-1866615"></a>
							<span class="vcard"><a href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>" class="url"><img src="images/users/<?php if($cmtrow->image!=''){ echo $cmtrow->image;}else{echo 'user-thumb.png';}?>" alt="" class="photo"><span class="fn nickname"><?php echo ucfirst($cmtrow->user_name);?></span></a></span>
							<p class="c-text"><?php echo $cmtrow->comments;?></p>
							<p style="float:left;width:100%;text-align:left;font-size: 11px; color: #188A0E;">
								Waiting for approval
								<a style="font-size: 11px; color: #f33;margin-left:10px" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>">Delete</a>
							</p>	
                            
						</li>
						<?php 
										}
									}
								}
							}
						}?>
						
					</ol>
					

				</section>
				<!-- / comments -->
 <!-- Comment start -->  
  <script type="text/javascript">
$(function() {

$(".submit").click(function() {
	var requirelogin = $(this).attr('require-login');
	if(requirelogin){
		var thingURL = $(this).parent().next().find('a:first').attr('href');
		window.location = baseURL+thingURL;
		return false;
	}
	var comments = $("#comments").val();
	var product_id = $("#cproduct_id").val();
    var dataString = '&comments=' + comments + '&cproduct_id=' + product_id;
	
	if(comments=='')
     {
    alert('Your comment is empty');
     }
	else
	{
	$("#flash").show();
	$("#flash").fadeIn(400).html('<img src="images/ajax-loader.gif" align="absmiddle">&nbsp;<span class="loading">Loading Comment...</span>');
     
	 $.ajax({
		type: "POST",
        url: baseURL+'site/order/insert_product_comment',
        data: dataString,
        cache: false,
        dataType:'json',
        success: function(json){
		   if(json.status_code == 1){
				alert('Your comment is waiting for approval');
				window.location.reload();
			}
			document.getElementById('comments').value='';
			$("#flash").hide();
		}
 });
}
return false;
});
});


</script> 

        <div id="flash" align="left"  ></div>
        <div >
                <form action="#" method="post">
                    <input type="hidden" name="cproduct_id" id="cproduct_id" value="<?php echo $productDetails->row()->seller_product_id;?>"/>
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $loginCheck ;?>"/>
                    <textarea class="text" name="comments" placeholder="<?php if($this->lang->line('header_write_comment') != '') { echo stripslashes($this->lang->line('header_write_comment')); } else echo "Write a comment"; ?>..." id="comments"></textarea><br />
                    <input type="submit" <?php if($loginCheck==''){ ?>require-login='true'<?php }?> class="submit button" value=" <?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "Post Comment"; ?> " />
                </form>
                
                
                
                <?php if($loginCheck==''){ ?>
                	<p><?php if($this->lang->line('product_please') != '') { echo stripslashes($this->lang->line('product_please')); } else echo "Please"; ?> <a href="login?next=things/<?php echo $productDetails->row()->id;?>/<?php echo url_title($productDetails->row()->product_name,'-');?>"><?php if($this->lang->line('product_login') != '') { echo stripslashes($this->lang->line('product_login')); } else echo "login"; ?></a> <?php if($this->lang->line('credit_or') != '') { echo stripslashes($this->lang->line('credit_or')); } else echo "or"; ?> <a href="signup?next=things/<?php echo $productDetails->row()->id;?>/<?php echo url_title($productDetails->row()->product_name,'-');?>"><?php if($this->lang->line('product_signup') != '') { echo stripslashes($this->lang->line('product_signup')); } else echo "signup"; ?></a> <?php if($this->lang->line('product_to_post') != '') { echo stripslashes($this->lang->line('product_to_post')); } else echo "to post comments"; ?></p>
                <?php }?>
        </div>
<!--Comment End-->
				<?php 
				if (count($relatedProductsArr)>0){
				?>
				<div class="might-fancy">
					<h3><?php if($this->lang->line('giftcard_you_might') != '') { echo stripslashes($this->lang->line('giftcard_you_might')); } else echo "You might also"; ?> <?php echo LIKE_BUTTON;?>...</h3>
					<div style="height: 259px;" class="figure-row fancy-suggestions anim">
					<?php 
					$limitCount = 0;
					foreach ($relatedProductsArr as $relatedRow){
						if ($limitCount<3){
							$limitCount++;
						$img = 'dummyProductImage.jpg';
						$imgArr = explode(',', $relatedRow->image);
						if (count($imgArr)>0){
							foreach ($imgArr as $imgRow){
								if ($imgRow != ''){
									$img = $imgRow;
									break;
								}
							}
						}
						$fancyClass = 'fancy';
						$fancyText = LIKE_BUTTON;
						if (count($likedProducts)>0 && $likedProducts->num_rows()>0){
							foreach ($likedProducts->result() as $likeProRow){
								if ($likeProRow->product_id == $relatedRow->seller_product_id){
									$fancyClass = 'fancyd';$fancyText = LIKED_BUTTON;break;
								}
							}
						}
					?>
							<div class="figure-product figure-200">
								<a href="<?php echo base_url();?>things/<?php echo $relatedRow->id;?>/<?php echo url_title($relatedRow->product_name,'-');?>">
								<figure>
								<span class="wrapper-fig-image">
									<span class="fig-image">
										<img style="width: 200px; height: 200px;" src="<?php echo base_url();?>images/product/<?php echo $img;?>">
									</span>
								</span>
								<figcaption><?php echo $relatedRow->product_name;?></figcaption>
								</figure>
								</a>
								<br class="hidden">
								<span class="username"><a href="<?php if ($relatedRow->user_id != '0'){echo 'user/'.$relatedRow->user_name;}else {echo 'user/administrator';}?>"><?php if ($relatedRow->user_id != '0'){echo $relatedRow->full_name;}else {echo 'administrator';}?></a> <em>+ <?php echo $relatedRow->likes;?></em></span>
								<br class="hidden">
								<a href="#" item_img_url="images/product/<?php echo $img;?>" tid="<?php echo $relatedRow->seller_product_id;?>" class="button <?php echo $fancyClass;?>" <?php if ($loginCheck==''){?>require_login="true"<?php }?>><span><i></i></span><?php echo $fancyText;?></a>
							</div>
					<?php 
					}}
					?>
							</div>
				</div>
				<?php }?>
				<?php 
				if ($recentLikeArr->num_rows()>0){
				?>
				<h3 id="recently-fancied-by">Recently <?php echo LIKED_BUTTON;?> by...</h3>

				<div class="recently-fancied">
					<?php 
					foreach ($recentLikeArr->result() as $userRow){
						if ($userRow->user_id != '' && $userRow->user_id != $loginCheck){
							$userImg = 'user-thumb1.png';
							if ($userRow->image != ''){
								$userImg = $userRow->image;
							}
							$followClass = 'follow';
					        $followText = 'Follow';
					        if ($loginCheck != ''){
						        $followingListArr = explode(',', $userDetails->row()->following);
						        if (in_array($userRow->user_id, $followingListArr)){
						        	$followClass = 'following';
						        	$followText = 'Following';
						        }
					        } 
					?>
					<div class="figure-row">
						<div class="user">
							<div class="vcard">
								<a href="<?php echo base_url().'user/'.$userRow->user_name;?>" class="url"><img width="40px" height="40px" src="<?php echo base_url();?>images/users/<?php echo $userImg;?>" alt="<?php echo $userRow->full_name;?>" class="photo"></a>
								<a href="<?php echo base_url().'user/'.$userRow->user_name;?>"><strong class="fn nickname"><?php echo $userRow->full_name;?></strong></a>
							</div>
							<!-- / vcard -->
							
							<a href="#" <?php if ($loginCheck==''){?>require_login="true"<?php }?> uid="<?php echo $userRow->user_id;?>" class="follow-link <?php echo $followClass;?>"><?php echo $followText;?></a>
							
						</div>
						<!-- /user -->
					<?php 
					if ($recentUserLikes[$userRow->user_id]->num_rows()>0){
						foreach ($recentUserLikes[$userRow->user_id]->result() as $userLikeRow){
							if ($userLikeRow->product_name != ''){
								$img = 'dummyProductImage.jpg';
								$imgArr = explode(',',$userLikeRow->image);
								if (count($imgArr)>0){
									foreach ($imgArr as $imgRow){
										if ($imgRow != ''){
											$img = $imgRow;
											break;
										}
									}
								}
					?>
						
						<div class="figure-product figure-140">
						
						
						
						<a href="<?php echo base_url().'things/'.$userLikeRow->PID.'/'.url_title($userLikeRow->product_name,'-');?>"><figure><span class="wrapper-fig-image"><span class="fig-image"><img width="140px" src="<?php echo base_url();?>images/product/<?php echo $img;?>" alt="<?php echo $userLikeRow->product_name;?>"></span></span></figure></a>
						
						
						</div>
					<?php 
							}
						}
					}
					?>	
						
					</div>
					<!-- / figure-row -->
				<?php 
						}
				}
				?>
				</div>
				<!-- / recently-fancied -->
				<?php 
				}
				?>
			</div>
            
			<!-- / content -->

			<aside id="sidebar">
          
				<section class="thing-section gift-section">
					
                    <h3><?php echo $productDetails->row()->product_name;?></h3>

					<div class="thing-description">
					<?php 
					$short_des = word_limiter($productDetails->row()->excerpt,25);
					if ($short_des == ''){
						$short_des = word_limiter($productDetails->row()->description,25);
					}
					?>	
						<p><?php echo $short_des;?> <a href="<?php echo 'things/'.$productDetails->row()->id.'/'.url_title($productDetails->row()->product_name);?>">more</a></p>
						
					</div>
                    <div class="quick-shipping" <?php if($productDetails->row()->ship_immediate == 'true'){?>style="display: block;"<?php }?>>
                        <span class="icon truck"></span> <?php if($this->lang->line('header_immed_ship') != '') { echo stripslashes($this->lang->line('header_immed_ship')); } else echo "Immediate Shipping"; ?> <span class="tooltip"><i class="icon"></i> <small><?php if($this->lang->line('header_ship_within') != '') { echo stripslashes($this->lang->line('header_ship_within')); } else echo "Ships within 1-3 business days"; ?> <b></b></small></span>
					</div>

					<ul class="figure-list after">
					
						<?php 
						$limitCount = 0;
						$imgArr = explode(',', $productDetails->row()->image);
						if (count($imgArr)>0){
							foreach ($imgArr as $imgRow){
								if ($limitCount>5)break;
								if ($imgRow != '' && $imgRow != $pimg){
									$limitCount++;
						?>
						  <li><a href="<?php echo base_url();?>images/product/<?php echo $imgRow;?>" data-bigger="<?php echo base_url();?>images/product/<?php echo $imgRow;?>" style="background-image:url(<?php echo base_url();?>images/product/<?php echo $imgRow;?>)"></a></li>
						<?php 
								}
							}
						}
						?>
					</ul>
                                        
					<p class="prices">
						<strong class="price"><?php echo $currencySymbol;?><span id="SalePrice"><?php echo $productDetails->row()->sale_price;?></span></strong> <?php echo $currencyType;?><br>
						
					</p>
					
					<div class="option-area">
					<?php 
/*					$attributes = unserialize($productDetails->row()->option);
					if (is_array($attributes) && count($attributes)>0 && isset($attributes['attribute_name']) && is_array($attributes['attribute_name'])){
						$attrArr = array();
						$attrKeyArr = array();
						foreach ($attributes['attribute_name'] as $key=>$val){
							if (!in_array($val, $attrArr)){
								array_push($attrArr, $val);
								$attrKeyArr[$val] = $key;
							}else {
								$attrKeyArr[$val] .= ','.$key;
							}
						}
						
						foreach ($attrArr as $attOption){
					?>	
							<label for="option1"><?php echo $attOption;?></label>
							<select style="display: block;visibility:visible;" data-price="0" name="<?php echo 'attr_'.$attOption;?>" id="<?php echo 'attr_'.$attOption;?>" class="option select-white selectBox">
								<option weight="" value="0" >Select</option>
							<?php 
							$attOptions = explode(',', $attrKeyArr[$attOption]);
							if (count($attOptions)>0){
								foreach ($attOptions as $attOptionVal){
							?>
								<option weight="<?php echo $attributes['attribute_weight'][$attOptionVal];?>" value="<?php echo $attributes['attribute_price'][$attOptionVal];?>" ><?php echo $attributes['attribute_val'][$attOptionVal];?></option>
							<?php 
								}
							}
							?>
							</select>
					<?php 
						}
					}
*/					?>
					<input type="hidden" id="original_sale_price" value="<?php echo $productDetails->row()->sale_price;?>"/>	
						<label for="quantity"><?php if($this->lang->line('header_quant_Avail') != '') { echo stripslashes($this->lang->line('header_quant_Avail')); } else echo "Quantity"; ?> </label>
						<span style="display: inline-block; position: relative;" class="input-number">
							<input name="quantity" id="quantity" data-mqty="<?php echo $productDetails->row()->max_quantity;?>" class="option quantity" value="1" min="1" onkeyup="javascript:changeQty(this);" type="number">
							<a style="position: absolute; top: 5px; right: 0px; height: 11px; padding: 0px 7px;" class="btn-up" onclick="javascript:increaseQty();" href="javascript:void(0);"><span></span></a>
							<a style="position: absolute; top: 17px; right: 0px; height: 11px; padding: 0px 7px;" class="btn-down" onclick="javascript:decreaseQty();" href="javascript:void(0);"><span></span></a>
						</span>
                        <div style="color:#FF0000;" id="QtyErr"></div>
                        
                        
                   <?php  $attrValsSetLoad = ''; //echo '<pre>'; print_r($PrdAttrVal->result_array()); 
					if($PrdAttrVal->num_rows>0){ $attrValsSetLoad = $PrdAttrVal->row()->pid; ?>
                   <label for="quantity"><?php if($this->lang->line('header_attr') != '') { echo stripslashes($this->lang->line('header_attr')); } else echo "Attribute"; ?></label>
                   	<select name="attr_name_id" id="attr_name_id" class="option  selectBox" style="border:1px solid #D1D3D9;" onchange="ajaxCartAttributeChange(this.value,'<?php echo $productDetails->row()->id; ?>');" >
                        <option value="0">--------------- Select ---------------</option>
                        <?php foreach($PrdAttrVal->result_array() as $Prdattrvals ){ ?>
                        <option value="<?php echo $Prdattrvals['pid']; ?>"><?php echo $Prdattrvals['attr_name']; ?></option>
                        <?php } ?>
                        </select>
				<div style="color:#FF0000;" id="AttrErr"></div>
				<div id="loadingImg_<?php echo $productDetails->row()->id; ?>"></div>
              <?php } ?>
    
                        
                        
					</div>
                    <div style="color:#FF0000;" id="ADDCartErr"></div>
					
				<!--	<button class="greencart add_to_cart soldout hidden" require_login="true"><i class="ic-cart"></i><strong>Sold Out</strong></button>-->
                <input type="hidden" class="option number" name="product_id" id="product_id" value="<?php echo $productDetails->row()->id;?>">
                <input type="hidden" class="option number" name="cateory_id" id="cateory_id" value="<?php echo $productDetails->row()->category_id;?>">                
                <input type="hidden" class="option number" name="sell_id" id="sell_id" value="<?php echo $productDetails->row()->user_id;?>">
                <input type="hidden" class="option number" name="price" id="price" value="<?php echo $productDetails->row()->sale_price;?>">
                <input type="hidden" class="option number" name="product_shipping_cost" id="product_shipping_cost" value="<?php echo $productDetails->row()->shipping_cost;?>"> 
                <input type="hidden" class="option number" name="product_tax_cost" id="product_tax_cost" value="<?php echo $productDetails->row()->tax_cost;?>">
                <input type="hidden" class="option number" name="attribute_values" id="attribute_values" value="<?php echo $attrValsSetLoad; ?>">

				<input type="button" class="greencart add_to_cart" <?php if ($loginCheck==''){echo 'require_login="true"';}?> name="addtocart" value="<?php if($this->lang->line('header_add_cart') != '') { echo stripslashes($this->lang->line('header_add_cart')); } else echo "Add to Cart"; ?>" onclick="ajax_add_cart('<?php echo $PrdAttrVal->num_rows; ?>');" />
                    
					<!--<button sii="57397" sisi="616001" tid="387657140413666789" class="greencart add_to_cart" require_login="true" html_url="/sales/57397/distressed-denim-shorts"><i class="ic-cart"></i><strong></strong></button>
					<a href="#" class="notify hidden" require_login="true" item_id="57397"><i></i>Notify me when available</a>
					<a href="#" class="btn-campaign for-gifting" title="Distressed Denim Shorts" require_login="true" item_id="57397" img_url="http://cf4.thefancy.com/commerce/original/20130624/f660ec0fcabd4aa3b0d640b4fa4a6b58.jpg"><i class="ic-gift"></i>Organize a group gift</a>-->
					
					
					<hr>
                    
					<ul class="thing-info">
<?php 
	$img = 'dummyProductImage.jpg';
		$imgArr = explode(',', $productDetails->row()->image);
		if (count($imgArr)>0){
			foreach ($imgArr as $imgRow){
				if ($imgRow != ''){
					$img = $pimg = $imgRow;
					break;
				}
			}
		}
		$colorID = '0';
		$listNameArr = explode(',', $productDetails->row()->list_name);
		$listValueArr = explode(',', $productDetails->row()->list_value);
		if (count($listNameArr)>0){
			for ($i=0;$i<count($listNameArr);$i++){
				if ($listNameArr[$i] == '1'){
					if ($listValueArr[$i] != ''){
						$colorID = $listValueArr[$i];break;
					}
				}
			}
		}
		$color = '';
		if ($colorID != '0'){
			$listArr = $this->product_model->get_all_details(LIST_VALUES,array('id'=>$colorID));
			if ($listArr->num_rows()>0){
				$color = $listArr->row()->list_value;	
			}
		}
		$ownClass = '';
		if ($loginCheck != ''){
			$ownArr = explode(',', $userDetails->row()->own_products);
			if (in_array($productDetails->row()->seller_product_id, $ownArr)){
				$ownClass = 'own-selected';
			}
		}
?>
						<li><a href="things/<?php echo $productDetails->row()->id;?>/<?php echo url_title($productDetails->row()->product_name,'-');?>" id="show-someone" class="show" uid="<?php echo $loginCheck;?>" tid="<?php echo $productDetails->row()->id;?>" tname="<?php echo $productDetails->row()->product_name;?>" tuser="<?php if ($productDetails->row()->user_id != '0'){echo $productDetails->row()->full_name;}else {echo 'administrator';}?>" data-timage="<?php //echo base_url();?>images/product/<?php echo $img;?>" price="<?php echo $productDetails->row()->sale_price;?>" reacts="<?php echo $productDetails->row()->likes;?>" username="<?php if ($loginCheck != ''){if (count($userDetails)>0){echo $userDetails->row()->user_name;}}?>" action="buy" require_login="<?php if (count($userDetails)>0){echo 'false';}else {echo 'true';}?>"><i></i><?php if($this->lang->line('header_share') != '') { echo stripslashes($this->lang->line('header_share')); } else echo "Share"; ?></a></li>
						<li><a href="#" onclick="" require_login="<?php if (count($userDetails)>0){echo 'false';}else {echo 'true';}?>" class="list" id="show-add-to-list"><i></i><?php if($this->lang->line('header_add_list') != '') { echo stripslashes($this->lang->line('header_add_list')); } else echo "Add to List"; ?></a></li>
						<li><a href="#" tid="<?php echo $productDetails->row()->seller_product_id;?>" class="<?php if (count($userDetails)>0){if ($productDetails->row()->seller_product_id == $userDetails->row()->feature_product){ echo 'feature-selected';}else {echo 'feature';}}else {echo 'feature';}?>" require_login="<?php if (count($userDetails)>0){echo 'false';}else {echo 'true';}?>"><i></i><?php if($this->lang->line('product_feature') != '') { echo stripslashes($this->lang->line('product_feature')); } else echo "Feature on my profile"; ?> </a></li>
						<li><a href="#" class="own <?php echo $ownClass;?>" require_login="<?php if (count($userDetails)>0){echo 'false';}else {echo 'true';}?>" tid="<?php echo $productDetails->row()->seller_product_id;?>"><i></i><?php if($this->lang->line('product_i_ownit') != '') { echo stripslashes($this->lang->line('product_i_ownit')); } else echo "I own it"; ?></a></li>
						<li><a href="<?php base_url();?>shopby/all?c=<?php echo $color;?>" class="color"><i></i><?php if($this->lang->line('product_find_similar') != '') { echo stripslashes($this->lang->line('product_find_similar')); } else echo "Find similar colors"; ?></a></li>
                        

                    </ul>
<!--                     
					<a href="#" class="report-link" <?php if ($loginCheck==''){?>require_login="true"<?php }?>><i class="ic-report"></i>Report</a>
 -->					<hr>
					
					
					
				</section>
          
				<!-- / thing-section -->
				<hr>
			</aside>
			<!-- / sidebar -->
			<?php 
     $this->load->view('site/templates/footer_menu');
     ?>
		
		<a href="#header" id="scroll-to-top"><span>Jump to top</span></a>
				</div>
			<?php 
	}else {
	?>
			<div class="wrapper-content right-sidebar" style="width:100%;">
			<p style="float:left;width:80%;padding:10%;text-align:center;font-size:17px;"><?php if($this->lang->line('fancy_prod_unavail') != '') { echo stripslashes($this->lang->line('fancy_prod_unavail')); } else echo "This product details not available"; ?></p>
			<?php 
     $this->load->view('site/templates/footer_menu');
     ?>
		
		<a href="#header" id="scroll-to-top"><span><?php if($this->lang->line('signup_jump_top') != '') { echo stripslashes($this->lang->line('signup_jump_top')); } else echo "Jump to top"; ?></span></a>
		</div>
	<?php }?>
		</div>
		<!-- / wrapper-content -->

		

	

	<!-- / container -->
</div>

</div>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>filesjquery_zoomer.js" type="text/javascript"></script>
<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>selectbox.js"></script>
<script type="text/javascript" src="js/site/thing_page.js"></script>
<script type="text/javascript">
function increaseQty(){
	$('#QtyErr').html('');
	var mqty = $('#quantity').data('mqty');
	var oldQty = $('#quantity').val();
	if(oldQty-oldQty != 0){
		oldQty = 0;
	}
	if(oldQty<0){
		oldQty = 0;
	}
	oldQty++;
	if(oldQty>mqty){
		$('#QtyErr').html('Maximum Purchase Quantity at a time is '+mqty);
		oldQty = mqty;
	}
	$('#quantity').val(oldQty);
}
function decreaseQty(){
	$('#QtyErr').html('');
	var mqty = $('#quantity').data('mqty');
	var oldQty = $('#quantity').val();
	if(oldQty-oldQty != 0){
		oldQty = 1;
	}
	if(oldQty<0){
		oldQty = 1;
	}
	if(oldQty>1){
		oldQty--;
	}
	if(oldQty<1){
		oldQty = 1;
	}
	if(oldQty>mqty){
		$('#QtyErr').html('Maximum Purchase Quantity at a time is '+mqty);
		oldQty = mqty;
	}
	$('#quantity').val(oldQty);
}
function changeQty(e){
	$('#QtyErr').html('');
	$('.add_to_cart').disable(false);
	var mqty = $('#quantity').data('mqty');
	var oldQty = $(e).val();
	if(oldQty-oldQty != 0){
		oldQty = 1;
	}
	if(oldQty<0){
		oldQty = 1;
	}
	if(oldQty=='' || oldQty == '0'){
		$('.add_to_cart').disable();
	}
	if(oldQty>mqty){
		$('#QtyErr').html('Maximum Purchase Quantity at a time is '+mqty);
		oldQty = mqty;
	}
	$('#quantity').val(oldQty);
}

</script>
<?php
$this->load->view('site/templates/footer');
?>