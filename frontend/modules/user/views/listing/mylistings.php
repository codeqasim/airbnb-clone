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
$this->title = 'Your Listings';
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;
//echo $userdata['firstname'];die;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$id = $userdata['id'];
$username = base64_encode($id."-".rand(0,999));
?>
<div class="profile_head">
	<div class="container">    
    	<ul class="profile_head_menu list-unstyled">
		<?php 
        echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
       <li><a href="'.$baseUrl.'/user/messages/inbox/traveling">'.Yii::t('app','Inbox').'</a></li>
        <li class="active"><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listing').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/trips">'.Yii::t('app','Trips').'</a></li> 
        <li><a href="'.$baseUrl.'/editprofile">'.Yii::t('app','Profile').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Account').'</a></li>';

         if (!Yii::$app->user->isGuest) {
	        $loguserid = Yii::$app->user->identity->id;
	        $userHostStatus = Yii::$app->user->identity->hoststatus;
	        $userListings = Listing::find()->where(['userid'=>$loguserid])->all();

	        	if($userHostStatus == 1 && count($userListings) > 0) {
	        		echo '<li><a href="'.$baseUrl.'/user/listing/calendar">'.Yii::t('app','Calender').'</a></li>'; 
	        	}
	      }
		?>
        </ul>
    </div> <!--container end -->
</div> <!--profile_head end -->

<div class="bg_gray1">
  <div class="container">    
        <div class="col-xs-12 col-sm-3 margin_top20 margin_bottom20">
        	<ul class="profile_left list-unstyled">
			<?php
			echo '<li class="active"><a href="'.$baseUrl.'/user/listing/mylistings" class="active">'.Yii::t('app','Active Listing').'</a></li>            
			<li><a href="'.$baseUrl.'/user/listing/pendinglistings">'.Yii::t('app','Pending Listing').'</a></li>
            <li><a href="'.$baseUrl.'/user/listing/reservations">'.Yii::t('app','Your Reservations').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/futurereservations">'.Yii::t('app','Unapproved Reservations').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/requirements" class="active">'.Yii::t('app','Reservation Requirements').'</a></li>';
			//<li><a href="'.$baseUrl.'/user/listing/requirements">Reservation Requirements</a></li>';
           // echo '<li><a href="reservation_requirement.html">Reservation Requirements</a></li>  ';
			?>         
            </ul>
			<a href="<?php echo $baseUrl.'/user/listing/listcreate';?>">
            <button class="bold-font btn btn_dashboard margin_top20"><?php echo Yii::t('app','Add New Listings');?></button>
			</a>
        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 margin_top20">        
        
        <div class="airfcfx-panel panel panel-default">
          <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
            <h3 class="panel-title"><?php echo Yii::t('app','Your Listings');?></h3>
          </div>

          <div class="panel-body">
            <div class="row">
				<?php
				if(!empty($listdata))
				{
					foreach($listdata as $list)
					{
						$roomtype = $list->getRoomtype0()->where(['id'=>$list->roomtype])->one(); 
						$photos = $list->getPhotos()->where(['listid'=>$list->id])->orderBy('id asc')->all();
						$listurl = base64_encode($list->id.'_'.rand(1,9999));
						if(isset($photos[0]->image_name) && $photos[0]->image_name!="")
						{
							$listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$photos[0]->image_name);
							$header_response = get_headers($listimagename, 1);
							if ( strpos( $header_response[0], "404" ) !== false )
							{
								$listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/images/room_default.png');
								$listresizeurl = $listimagename;
							} 
							else 
							{
								$listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$photos[0]->image_name);
								$listresizeurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimagename.'&w=215&h=75');
							}							
						}
						else
						{
							$listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/images/room_default.png');
							$listresizeurl = $listimagename;
						}
						echo '<div class="airfcfx-listing-row clear">
							<div class="col-xs-12 col-sm-5 col-md-4">
							<a href="#"><div class="airfcfx-listing_img listing_img" style="background-image:url('.$listresizeurl.');"></div></a>
							</div>
							<div class="col-xs-12 col-sm-7 col-md-8">
							<a href="#" class="airfcfx-text_black text_black"><h4>'.Yii::t('app',$roomtype->roomtype).' in '.$list->city.'</h4></a>';
							if($list->listingname!="")
							{
								$listingName = ucfirst(strtolower($list->listingname));
								echo '<a class="margin_top_5 text-muted listingname" href="'.$baseUrl.'/user/listing/view/'.$listurl.'">'.Yii::t('app',$listingName).'</a>';
							}
							else
							{
								echo '<a class="margin_top_5 text-muted" href="'.$baseUrl.'/user/listing/managelist/'.$list->id.'">'.Yii::t('app','Managing Listing and Calender').'</a>';
							}
							//echo '<br/>';
							//echo $list->booking.'kalidass';
							$bookingType = (isset($list->booking) && $list->booking == "perhour") ? Yii::t('app','Per hour') : Yii::t('app','Per night');
							echo '<div style="display:inline-block;"> - '.$bookingType.'</div>';
							echo '</div>
							<div class="airfcfx-listing-btn-cnt col-xs-12 col-sm-6">';
							if($list->listingname!="" && $list->liststatus==1)
							{
								
								echo '<a href="'.$baseUrl.'/user/listing/managelist/'.$list->id.'" class="airfcfx-edit-list-btn">
								<button class="btn bold-font airfcfx-red-btn margin_top20 pull-right">'.Yii::t('app','Edit listing').'</button>
								</a>';
								echo '<a href="'.$baseUrl.'/user/listing/view/'.$listurl.'" class="airfcfx-view-list-btn">
								<button class="btn btn-border margin_top20 pull-right">'.Yii::t('app','View list').'</button>
								</a>';
							}
							else
							{
								echo '<a href="'.$baseUrl.'/user/listing/managelist/'.$list->id.'">
								<button class="btn bold-font airfcfx-red-btn margin_top20 pull-right">'.Yii::t('app','Manage listing').'</button>
								</a>';							
							}
							echo '</div>
							
						</div> <!--col-xs-12 end -->';
					}
				}
				else
				{
					echo '<div class="margin_top10 margin_bottom20">
                        <div class="col-xs-12 col-sm-6 ">
                    '. Yii::t('app','You have no listings.').'<br />
                        </div>

                        
                    </div> <!--col-xs-12 end -->';
				}
					?>
					
					
                          <?php
 echo LinkPager::widget([
     'pagination' => $pages,
]);
 echo '</div>';
 echo '<div align="center">';
 ?>
                 </div> <!--row end -->

          </div>
          
        </div> <!--Panel end -->
        
         
        
        
        
    </div> <!--container end -->
	</div>
  
<style type="text/css">
	.margin_top_5.text-muted.listingname
	{
		margin: 10px 10px;
		display: inline-block;
		font-weight: bold;
		font-size: 17px;
	}
</style>