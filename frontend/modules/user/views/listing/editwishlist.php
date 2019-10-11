<?php

/*
 * This page displays the user verification information. User can verify their phone number and email here.
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
$this->title = 'Edit Wish List';
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;
//echo $userdata['firstname'];die;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$id = $userdata['id'];
$username = base64_encode($id."-".rand(0,999));
$userimage = $userdata['profile_image'];
if($userimage=="")
$userimage = "usrimg.jpg";
$userimageurl = $baseUrl.'/albums/images/users/'.$userimage;
$listurl = base64_encode($list->id.'_'.rand(1,99999));
?>
<div class="profile_head">
	<div class="container">    
    	<ul class="profile_head_menu list-unstyled">
        <!--li><a href="popular.html">Popular</a></li>
        <li><a href="picks.html">Airbnb Picks</a></li-->
        <li class="active"><a href="<?php echo $baseUrl.'/user/listing/mywishlists';?>"><?php echo Yii::t('app','Your Lists'); ?></a></li> 
        
        </ul>
    </div> <!--container end -->
</div> <!--profile_head end -->


<div class="bg_gray1">
<div class="container">
	<div class="row">
    	
        <div class="editwish-page col-xs-12 margin_top20 margin_bottom20">
                	<div class="wish-left-img text-center imgleft">
						<?php
						echo '<span class="profile_pict inlinedisplay" style="background-image:url('.$userimageurl.');"></span>';
						?>
                    </div>
                    <div class="user-name-title">
						<?php echo Yii::t('app','Edit List'); ?> 
                    </div> 
                   	<!--<div class="col-sm-2">
                    <button class="btn btn_google pull-right " data-toggle="modal" data-target="#myModal">Create a New Lists</button>
                    </div>-->
        </div>
    </div> <!-- row end -->
    
    <div class="row">	
        <?php
		if(isset($list) && !empty($list))
		{
				$wishlists = $list->getWishlists()->where(['listid'=>$list->id])
				->andWhere(['userid'=>$userid])
				->all();
				$wishlist = $list->getWishlists()->where(['listid'=>$list->id])
				->andWhere(['userid'=>$userid])
				->orderBy('id desc')
				->one();
				$wishcount = count($wishlists);
				if(isset($wishlist) && !empty($wishlist))
				{
					$listdata = $wishlist->getListing()->where(['id'=>$wishlist->listingid])->one();
					$photos = $listdata->getPhotos()->where(['listid'=>$listdata->id])->one();
					$imageurl = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$photos->image_name);
					$wishlistid = base64_encode($list->id.'_'.rand(1,9999));
					$wishlisturl = Yii::$app->urlManager->createAbsoluteUrl ('/user/listing/wishlist/'.$wishlistid);
				}
				else
				{
					$wishlisturl = "";
					$imageurl = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/users/usrimg.jpg');
				}
				$listresizeurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$imageurl.'&w=370&h=340');
				echo '<div class="col-xs-12 col-sm-4  margin_bottom20 "> 
                  <a href="'.$wishlisturl.'" class="wish_list">
                  <div style="background-image:url('.$listresizeurl.');" class=" bg_img mywish text-center "> 
                  <h2 class="padding_top120 text_white pos_rel z_1">'.$list->listname.'</h2> 
                  <button class="min-blue-bg btn btn_wish pos_rel z_1">'.$wishcount.' Listings</button>         
                  </div>                  
                  </a>
				</div>';
				echo '<div class="col-xs-12 col-sm-8  margin_bottom20">
				<label>Title</label><br />
				<input type="text" id="listname" class="form-control mediumlargediv" value="'.$list->listname.'"><br /><br /><br/>
				<div class="clear"></div>
				<input type="button" class="btn btn-danger" value="Save Changes" onclick="edit_list_name('.$list->id.')">
				<a href="'.$baseUrl.'/user/listing/wishlist/'.$listurl.'"><input type="button" class="btn btn-default" value="Cancel"></a>
				<img id="loadingimg" src="'.$baseUrl.'/images/load.gif" class="loading" style="margin-top: 0;">
				<input type="hidden" value="'.$baseUrl.'/user/listing/wishlist/'.$listurl.'" id="editwishlisturl">
				</div>';

		}
		?>
		<?php
					
					?>		<br />		
				


   
    </div> <!-- row end -->

</div> <!-- container end -->
</div>
  
