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
$this->title = 'Wish Lists';
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
$userimageurl = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/users/'.$userimage);
$resized_userimageurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimageurl.'&w=60&h=60');	
if($totallists=="")
$total_lists=0;
else
$total_lists = count($totallists);
?>
<div class="profile_head wishlisr">
	<div class="container">    
    	<ul class="col-sm-12 profile_head_menu list-unstyled">
        <li><a href="<?php echo $baseUrl.'/user/listing/mywishlists';?>"><?php echo Yii::t('app','Your Lists'); ?></a></li>
		    <li class="active"><a href="<?php echo $baseUrl.'/user/listing/popularwishlists';?>"><?php echo Yii::t('app','Popular Lists'); ?></a></li>
        
        </ul>
    </div> <!--container end -->
</div> <!--profile_head end -->


<div class="bg_gray1">
<div class="container">
	<div class="col-sm-12 no-hor-padding">
  	<?php if($total_lists == 0) {?>
        <div class="col-sm-12">
        <div class="col-xs-12 margin_top20 margin_bottom20">
                    <div class="col-sm-12">
                    <a href="#" class="text-danger"><h4 class="margin_top0" style="text-align:center;"><b>'Add the favourite listing to wishlist.....'</b></h4></a>
                    </div> 
                   	<!--div class="col-sm-2">
                    <button class="btn btn_google pull-right " data-toggle="modal" data-target="#myModal">Create a New Lists</button>
                    </div-->
        </div>
        </div>
    	<?php } else {?>
        <div class="col-xs-12 margin_top20 margin_bottom20">
                	<div class="wish-left-img text-center imgleft">
						<?php
						echo '<span class="airfcfx-user-icon  wish-left-proimg profile_pict inlinedisplay" style="background-image:url('.$resized_userimageurl.');"></span>';
						?>
                    </div>
                    <div class="user-name-title">
                    <a href="#" class="text-danger"><h4 class="margin_top0"><b><?php echo $firstname;?>'s Lists</b></h4></a>
                    <p> Lists: <b><?php echo $total_lists;?></b></p>
                    </div> 
                   	<!--div class="col-sm-2">
                    <button class="btn btn_google pull-right " data-toggle="modal" data-target="#myModal">Create a New Lists</button>
                    </div-->
        </div>
    
    <div class="col-sm-12">	
        <?php
		if(isset($lists) && !empty($lists))
		{
			foreach($lists as $listnew)
			{
				$list = $listnew[0];
				$wishlists = $list->getWishlists()->where(['listid'=>$list->id])
				->andWhere(['userid'=>$userid])
				->all();
				$wishlist = $list->getWishlists()->where(['listid'=>$list->id])
				->andWhere(['userid'=>$userid])
				->orderBy('id desc')
				->one();
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
					$imageurl = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/users/usrimg.jpg');
					$wishlisturl = "";
				}
				$listresizeurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$imageurl.'&w=370&h=340');
				$wishcount = count($wishlists);
				echo '<div class="col-xs-12 col-sm-4  margin_bottom20 "> 
                  <a href="'.$wishlisturl.'" class="wish_list">
                  <div style="background-image:url('.$listresizeurl.');" class=" bg_img mywish text-center "> 
                  <h2 class="padding_top120 text_white pos_rel z_1">'.$list->listname.'</h2> 
                  <button class="min-blue-bg btn btn_wish pos_rel z_1">'.$wishcount.' Listings</button>         
                  </div>                  
                  </a>
				</div>';				
			}
		}
}
		?>

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
  
