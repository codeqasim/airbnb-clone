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
use frontend\models\Listing;
$this->title = $listdata->listname;
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;
//echo $userdata['firstname'];die;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$id = $userdata['id'];
$username = base64_encode($id."-".rand(0,999));
$userimage = $userdata['profile_image'];
if($userimage=="")$baseUrl.
$userimage = "usrimg.jpg";
$userimageurl = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/users/'.$userimage);
$resized_userimageurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimageurl.'&w=60&h=60');
$listurl = base64_encode($listdata->id.'_'.rand(1,99999));
?>
<div class="profile_head">
	<div class="container">    
    	<ul class="col-sm-12 profile_head_menu list-unstyled">
    		<?php /*
        echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li> 
       <li><a href="'.$baseUrl.'/user/messages/inbox/traveling">'.Yii::t('app','Inbox').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listings').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/trips">'.Yii::t('app','Trips').'</a></li>
        <li><a href="'.$baseUrl.'/editprofile">'.Yii::t('app','Profile').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Account').'</a></li>';
        if (!Yii::$app->user->isGuest) {
	        $loguserid = Yii::$app->user->identity->id;
	        $userHostStatus = Yii::$app->user->identity->hoststatus;
	        $userListings = Listing::find()->where(['userid'=>$loguserid])->all();

	        	if($userHostStatus == 1 && count($userListings) > 0) {
	        		echo '<li class="active"><a href="'.$baseUrl.'/user/listing/calendar">'.Yii::t('app','Calender').'</a></li>';
	        	}
	      }*/
		?> 
        <li><a href="<?php echo $baseUrl.'/user/listing/mywishlists';?>"><?php echo Yii::t('app','Lists'); ?></a></li> 
        <!-- li><a href="<?php // echo $baseUrl.'/user/listing/popularwishlists';?>"><?php //  echo Yii::t('app','Popular Lists'); ?></a></li --> 
        </ul>
    </div> <!--container end --> 
</div> <!--profile_head end -->


<div class="bg_gray1">
<div class="container">
	<div class="col-sm-12 no-hor-padding">
    	
        <div class="col-xs-12 margin_top20 margin_bottom20">
			<div class="col-sm-12 no-hor-padding">
			<h3><?php echo $listdata->listname;?>
			<?php
			if($listdata->user_create!=0)
			{
			?>
			<a href="<?php echo $baseUrl.'/user/listing/editwishlist/'.$listurl;?>"><i class="fa fa-pencil-white"></i></a>
			<?php
			}
			?>
			</h3>
			</div>
                	<div class="wish-left-img text-center imgleft">
						<?php
						echo '<span class="airfcfx-user-icon wish-left-proimg profile_pict inlinedisplay" style="background-image:url('.$resized_userimageurl.');"></span>';
						?>
                    </div>
                    <div class="user-name-title">
                    <span class="text-danger"><b><?php echo $firstname;?>'s Lists</b></span>
                    </div> 
        </div>
    </div> <!-- row end -->
	<hr>
    
    <div class="col-sm-12">	
        <?php
 
		foreach($wishlists as $wishlist)
		{
			echo '<div id="wish'.$wishlist->id.'">';
			$listingdata = $wishlist->getListing()->where(['id'=>$wishlist->listingid])->one();
			$photos = $listingdata->getPhotos()->where(['listid'=>$wishlist->listingid])->all();
			$listurl = base64_encode($listingdata->id.'_'.rand(1,9999));
			$listingurl = Yii::$app->urlManager->createAbsoluteUrl("/user/listing/view/".$listurl);
			$listcode = base64_encode($wishlist->listingid."_".rand(1,9999));
			$listingurl = Yii::$app->urlManager->createAbsoluteUrl('/user/listing/view/'.$listcode);
			echo '<div class="col-xs-12 col-sm-4  no-hor-padding">';
			/*if(isset($photos[0]->image_name))
			{
				$image0 = $photos[0]->image_name;
			}
			else
			$image0 = 'usrimg.jpg';
				$listimage0 = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$image0);
				$listresizeurl0 = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimage0.'&w=650&h=330');
			echo '<a href="'.$listingurl.'"><div class="col-xs-12" >
				<a href="'.$listingurl.'"><div class="banner1" style="background-image:url('.$listresizeurl0.');width:100%;height:315px;"></div></a>
				</div></a>';*/

			echo '<div id="carousel-example-generic'.$wishlist->id.'" class="whislist-lslide carousel slide" data-ride="carousel">';

  echo '<div class="carousel-inner" role="listbox">';
  foreach ($photos as $photoKey => $photo){
			if(isset($photo->image_name))
			{
				$image1 = $photo->image_name;
				$listimage = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$image1);
			}
			else
			$listimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');
			$header_response = get_headers($listimage, 1);
			if ( strpos( $header_response[0], "404" ) !== false )
			{
				$listimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');
			}
			else
			{
				$image1 = $photo->image_name;
				$listimage = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$image1);				
			}
			$listresizeurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimage.'&w=370&h=340');
  			if ($photoKey == 0){
  ?>
  <a href="<?php echo $listingurl; ?>" target="_blank" title="<?php echo $listingdata->listingname; ?>"
  	 class="banner1 item active" style="background-image:url(<?php echo $listresizeurl; ?>);">
    
  </a>
   <?php }else { ?>
   <a href="<?php echo $listingurl; ?>" target="_blank" title="<?php echo $listingdata->listingname; ?>"
   	 class="banner1 item" style="background-image:url(<?php echo $listresizeurl; ?>);">
  </a>
    <?php } } ?>
  </div>

  <!-- Controls -->
  <?php if(count($photos) > 1) { ?>
  <a class="left carousel-control" href="#carousel-example-generic<?php echo $wishlist->id; ?>" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only"><?php echo Yii::t('app','Previous');?></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic<?php echo $wishlist->id; ?>" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only"><?php echo Yii::t('app','Next');?></span>
  </a>
  <?php } ?>
  
  
  <?php
  echo '


  
</div><!--carousel-example-generic end-->';       

			echo '</div>';
			echo '<div class="col-xs-12 col-sm-8 wishrightalgn">';
			echo '<div class="col-xs-12 col-sm-8 no-hor-padding"><h3 class="airfcfx-listing-name"><a href="'.$listingurl.'">'.$listingdata->listingname.'</a></h3><p class="margin_bottom20">'.$listingdata->city.'</p></div>';
			echo '<div class="col-xs-12 col-sm-4 no-hor-padding" onclick="remove_wish_list('.$wishlist->id.')">
				  <div class="airfcfx-listing-remove"><span class="fa fa-remove"></span><span style="padding-left:5px;">Remove</span></div></div>
				  </div><div class="clear"></div>
					<br /><hr class="wishlistborder">';  
			echo '</div>';

		}
		?>

         
   <br /><br />
                                 <?php
echo '<div align="center" class="clear">';
 echo LinkPager::widget([
     'pagination' => $pages,
]);
 echo '</div>'
 ?>    
    </div> <!-- row end -->

</div> <!-- container end -->
</div>
<script type="text/javascript">
$('.carousel').carousel({
  interval: false
})
</script>
<style type="text/css">
	.airfcfx-listing-remove {
		cursor: pointer !important;	 
	}
</style>
  
