<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Listing;
$this->title = 'Dashboard';
?>
<div class="profile_head">
	<div class="container">    
    	<ul class="profile_head_menu list-unstyled">
        <?php 
        echo '<li class="active"><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
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
              echo '<li><a href="'.$baseUrl.'/user/listing/calendar">'.Yii::t('app','Calender').'</a></li>';
            }
        } 
    ?>
        </ul>
    </div> <!--container end -->
</div> <!--profile_head end -->

<?php
$username = \Yii::$app->user->identity->firstname;
?>
<div class="container">
	<div class="row">
    	
        <div class="col-xs-12 margin_top20">
        	<div class="bg-success pos_rel padding20">
            	<a href="#" class="text_gray pos_abs" style="right:15px;"><i class="fa fa-times dashboard_icon"></i></a>
            	<div class="table1">
                	<div class="tab_cel">                    
                    <div class="pos_rel dashboard_bg text-center ">
                    <i class="fa fa-inr fa-2x dashboard_icon"></i>                    
                    </div>
                    </div>
                    <h4 class="margin_left20"><b>Earn <i class="fa fa-inr"></i> 6,656 travel credit </b>   </h4>
                    <p class="margin_left20 text_gray1">Give your friends ₹1,331 off their first trip on Airbnb and you'll get up to ₹6,656 travel credit. </p>
                    <button class="btn btn_dashboard margin_left20 margin_top20">Invite Friends</button>
                    <button class="btn btn_google margin_top20">Later</button>
            		</div>
                    
            </div>  <!--dashboard_offer end-->
        </div> <!--col-xs-12 end-->
    	
    	<div class="col-xs-12 col-sm-3 margin_top20 margin_bottom20">	
                    <div class="profile_img pos_rel" style="background-image:url(../images/user_pic-225x225.png);" >
                        <div class="profile_photo text-center">
                        <a href="#"><i class="fa fa-camera"></i> Add Profile Photo</a>
						
 <?php $form = ActiveForm::begin([
 'options' => ['id' => 'fileupload', 'enctype' => 'multipart/form-data']	
 //	'fieldConfig' => ['class' => ActiveField::className()],
 ]); 
 $upload = new yii\xupload\models\XUploadForm;
 			 echo yii\xupload\XUpload::widget([
 							'url' => \Yii::$app->getUrlManager()->createUrl("albums/albums/upload"),
 							'model' => $upload,
 							'attribute' => 'file',
 	 						'multiple' => true,
 							'clientOptions'=> [
 									'maxNumberOfFiles' => 4,
 									'maxFileSize'=>2000000,
  									'acceptFileTypes' =>  new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
 							//		'beforeSend' => 'js:function(event, files, index, xhr, handler, callBack) {
 							//		handler.uploadRow.find(".upload_start button").click(callBack);
 							//		}',
 									'onComplete' => new yii\web\JsExpression('function (event, files, index, xhr, handler, callBack) {
 									$("#photo").hide().html(\'<img src="../../images/profiles/\'+handler.response.name +\'?\'+ d.getTime() +\'"/>\' ).fadeIn(\'fast\');
 									}')],
 				]);						
		?>				
		<!--?php
		echo "<div class='upload-image-head'>".Yii::t('app','Add photos of your item')."</div>";
		$this->widget( 'xupload.XUpload', array(
                'url' => Yii::$app->urlManager->createUrl( "/item/products/upload"),
		//our XUploadForm
                'model' => 'SignupForm',
		//We set this for the widget to be able to target our own form
                'htmlOptions' => array('id'=>'products-form'),
                'attribute' => 'file',
                'multiple' => true,
            	'showForm' => false,
				'options' => array(
					'maxFileSize' => 2097152, //2MB in bytes
					'acceptFileTypes' => "js:/(\.|\/)(jpe?g|png)$/i",
					'completed' => "js:function (e, data) {
										productImage++;
										$('#image_error').text('');
										console.log('Uploaded Image: '+productImage);
					                }",
					'destroyed' => "js:function (e, data) {
					                    productImage--;
										if (productImage == 0)
										$('#image_error').text(Yii.t('admin','Upload atleast a single product image'));
										console.log('Uploaded Image: '+productImage);
					                }",
					'added' => "js:function (e, data) {
						addImage++;
						if(addImage == addImageError)
							$('.start-container').fadeOut('fast');
						else if(addImage > 0)
							$('.start-container').fadeIn();
						console.log('added Image: '+addImage);
						console.log('added Image Error: '+addImageError);
					}",
					'started' => "js:function (e, data) {
						addImage = 0;
						if(addImage <= 0)
							$('.start-container').fadeOut('fast');
						console.log('Started upload');
					}",
					'failed' => "js:function (e, data) {
						addImage = addImage > 0 ? --addImage : 0;
						if(addImage == addImageError)
							$('.start-container').fadeOut('fast');
						else if(addImage <= 0)
							$('.start-container').fadeOut('fast');
						console.log('Stopped upload: '+addImage);
					}",
		),
		//Note that we are using a custom view for our widget
		//Thats becase the default widget includes the 'form'
		//which we don't want here
		//'formView' => 'application.views.products._form',
		)
		);
		?-->						
                        </div>
                    </div> <!--profile_img end-->
            		
                     <div class="border1 margin_bottom20">
                            <div class="row padd_10_15">
                            	<div class="text-center margin_top10 margin_bottom10">
                            	<h1><?php echo $username; ?></h1>
                                <a href="#" class="text-danger">View Profile</a>
                                <br/>
                                <button class="btn btn_email margin_top10">Complete Profile</button>
                                </div>
                             </div> <!--row end -->                    
                    </div> <!--border1 end -->
                    
            		<div class="panel panel-default">
                      <div class="panel-heading profile_menu1">
                        <h3 class=" panel-title">Verifications 
                        <i class="fa fa-question-circle hover_tool pos_rel pull-right">
                       <div class="tooltip_text">
                        	<p class="font_size12">Verifications help build trust between guests and hosts and can make booking easier. <a href="#" class="text-danger">Learn more ».</a></p>
                       </div><!--tooltip_text end-->
						</i>
                        </h3>
                      </div>
                      <div class="panel-body">
                        <div class="row padd_10_15"> 
                                <div class="table1">
                                <div class="tab_cel text-center ">
                                <i class="fa fa-check-circle-o fa-1x text-success"></i>
                                </div>	
                                    <p>Google</p>
                                    <p class="text_gray1">Validated </p>
                                                                       
                                </div>   
                                <br/>  
                                <a href="trust.html" class="text-danger margin_left20">Add Verifications </a>
                             </div> <!--row end --> 
                      </div>
                    </div> <!--Panel end -->
                    
                    <div class="panel panel-default">
                      <div class="panel-heading profile_menu1">
                        <h3 class=" panel-title">
                        Quick Links
                        </h3>
                      </div>
                      <div class="panel-body">
                        <div class="row padd_10_15">
                            	<ul class="list-unstyled quick_link">                                 
                                <li><a href="#" class="text-danger margin_left20">View/Manage Listing </a></li>
                                <li><a href="#" class="text-danger margin_left20">Reservations </a></li>
                                <li><a href="#" class="text-danger margin_left20">Reviews & References </a></li>
                                </ul>
                             </div> <!--row end --> 
                      </div>
                   </div> <!--Panel end -->                   
                    
        </div> <!--col-sm-3 end -->
        
        
        <div class="col-xs-12 col-sm-9 margin_top20 margin_bottom20">
        
        		<div class="panel panel-default">
          <div class="panel-heading profile_menu1">
            <h3 class="panel-title ">Welcome to Airbnb, Aravind!</h3>
          </div>
          <div class="panel-body">
           <div class="row ">                
                                        <div class="">
                                            <div class="col-xs-12 ">                                                       
                                            <p>This is your Dashboard, the place to manage your rental, check messages in your Inbox, respond to Reservation Requests, view upcoming Trip Information, and much more!  </p>                                    <br/>
                                            <a href="#" class="text-danger"><b>Edit Your Properties</b></a>
                                            <p>Update availability and pricing for all of your properties.</p>
                                            <br/>
                                            <a href="#" class="text-danger"><b>Build Your Reputation</b></a>
                                            <p>Ask friends to write you references.</p>
                                            <br/>
                                            <a href="#" class="text-danger"><b>Follow @airbnb on Twitter</b></a>
                                            <p>Say Hi to us and we'll get back!</p>
                                            <br/>
                                            <a href="#" class="text-danger"><b>Learn How It Works</b></a>
                                            <p>Watch a short video that shows you how Airbnb works.</p>
                                            <br/>
                                            <a href="#" class="text-danger"><b>Get Help!</b></a>
                                            <p>View our help section and FAQs to get started on Airbnb.</p>
                                            
                                            </div>  
                                        </div> <!--col-xs-12 end -->                            
                                     </div> <!--row end -->
          </div>
        </div> <!--Panel end -->
        	
      
<div class="panel panel-default">
  <div class="panel-heading profile_menu1">
    <h3 class="panel-title">Notifications </h3>
  </div>
  <div class="panel-body">
    <div class="row padding10">                
                                <div class="">
                                    
                                    <ul class="list-unstyled">
                                    <li>
                                    <a href="#" class="text-danger margin_left10">Please tell us how to pay you. <i class="fa fa-caret-right"></i> </a>
                                    <hr/>
                                    </li>
                                    <li>
                                    <a href="#" class="text-danger margin_left10">Get references from friends—it’s easier to book a place when hosts know a little about you.  <i class="fa fa-caret-right"></i> </a>
                                    <a href="#" class="pull-right text_gray1"><i class="fa fa-times"></i></a>
                                    <hr/>
                                    </li>
                                    <li>
                                    <button class="btn btn_fb margin_left10" style="padding:0px 2px;"><i class="fa fa-facebook-square"></i> Log In</button>
                                    <span>Connect with Facebook to complete your profile and make it easy to log in.</span>
                                    <a href="#" class="pull-right text_gray1"><i class="fa fa-times"></i></a>
                                    <hr/>
                                    </li>
                                    <li>
                                    <p class="margin_left10">Please confirm your email address by clicking on the link we just emailed you. If you cannot find the email, you can
                                     <a href="#" class="text-danger">request a new confirmation email</a> or <a href="#" class="text-danger">change your email address.</a> </p>
                                    </li>
                                    </ul>                                    
                                      
                                </div> <!--col-xs-12 end -->                            
                             </div> <!--row end -->
  </div>
</div> <!--Panel end -->     	
                    
                    
 <div class="panel panel-default">
  <div class="panel-heading profile_menu1">
    <h3 class="panel-title">Messages (0 new)</h3>
  </div>
  <div class="panel-body">
   <div class="row ">                
                                <div class="col-xs-12">                              
                                    <p class="">When you message hosts or send reservation requests, you’ll see their responses here. </p>                                   
                                </div> <!--col-xs-12 end -->                            
                             </div> <!--row end -->
  </div>
</div> <!--Panel end -->                      
                   
                   
        </div> <!-- col-sm-9 end -->
    </div> <!-- row end -->

</div> <!-- container end -->
