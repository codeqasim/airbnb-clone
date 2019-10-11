<?php
/*
 * This page is for displaying the information about the user. It is the profile page of the user.
*
* @author: Muthumareeswari
* @package: Views
* @PHPVersion: 5.4
*/
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use frontend\models\Reservations;
use frontend\models\Weekendprice;
use backend\components\Myclass;

$this->title = 'Create Listing';
?>

<?php
$baseUrl = Yii::$app->request->baseUrl;
$reservations = Reservations::find()->where(['listid'=>$id])
->andWhere(['or', ['=',"bookstatus", 'requested'], ['=',"bookstatus", 'accepted'], ])
->andWhere(['other_transaction'=>NULL]) 
->andWhere(['claim_transaction'=>NULL])   
->count();    
?>

<!-- Multidate picker.css -->
<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl.'/css/bootstrap-multidatepicker.css'; ?>">
<!-- Multi Ends --> 


<!--?= DatePicker::widget([
    'model' => $model,
    'attribute' => 'date',
    'template' => '{addon}{input}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd-M-yyyy'
        ]
]);?-->
<!--?= FileUploadUI::widget([
    'model' => $model,
    'attribute' => 'image',
    'url' => ['media/upload', 'id' => $tour_id],
    'gallery' => false,
    'fieldOptions' => [
            'accept' => 'image/*'
    ],
    'clientOptions' => [
            'maxFileSize' => 2000000
    ],
    // ...
    'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
            'fileuploadfail' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
    ],
]);
?-->

<div class="container bg_gray1">

	<div class="mrgnset">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 margin_top30 margin_bottom0 sdecls sdecls-side">
				<nav class="navbar navbar-inverse mang-list">
					<div class="navbar-header">
				      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>                        
				      </button>
				      <a class="navbar-brand res-disp" href="#">Manage List</a>
				    </div>
			   <div class="collapse navbar-collapse" id="myNavbar">
					<ul class="profile_left list-unstyled" id="listpropul">
						<li class="mang-title"><b><?php echo Yii::t('app','Listing');?></b></li>
						<li onclick="show_basics_div(this);" style="background: #ddd;border-left: 3px solid #008489;" id="showBasi"><?php echo Yii::t('app','Basics');?></li>
						<li onclick="show_description_div(this);" id="showDesc"><?php echo Yii::t('app','Description');?></li>
						<li onclick="show_location_div(this);"  id="showLoc"><?php echo Yii::t('app','Location');?></li>
						<li onclick="show_amenities_div(this);" id="showAmenities"><?php echo Yii::t('app','Amenities');?></li>
						<li onclick="show_photos_div(this);" id="showPhoto"><?php echo Yii::t('app','Photos');?></li>
						<li onclick="show_homesafety_div(this);" id="showHomesafe"><?php echo Yii::t('app','Home Safety');?></li>
						<li class="mang-title"><b><?php echo Yii::t('app','Hosting');?></b></li>
						<li onclick="show_pricing_div(this);" id="showPricing"><?php echo Yii::t('app','Pricing');?></li>
						<li onclick="show_booking_div(this);" id="showBooking"><?php echo Yii::t('app','Booking');?></li>
						<li onclick="show_calendar_div(this);" id="showCalendar"><?php echo Yii::t('app','Availability');?></li>
					</ul> 
				</div>
			</nav>
		</div>
		<!--col-sm-3 end -->
		<?php $sitesetting = Yii::$app->mycomponent->getLogo(); $hour_booking= $sitesetting->hour_booking;?>
		<input type="hidden" name="hour_booking" id="hour_booking" value="<?php echo $hour_booking;?>"/>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 sdecls sdecls-main">

			<div class="panel panel-default panelcls">
				<div class="panel-body">
					<div class="row">

						<div class="col-xs-12 margin_top10 margin_bottom20 commcls" id="basicsdiv">
							<h3><?php echo Yii::t('app','Help travelers find the right fit');?></h3>
							<?php echo Yii::t('app','People searching on '.$sitesetting->sitename.' can filter by listing basics to find a space that matches their needs.');?>
							<hr />
							<?php 
									$stripe_USD = Myclass::getcurrencyprice('USD'); 
	                    		$list_CUR = Myclass::getcurrencyidprice($listdata->currency); 
	                    		$stripe_money = ceil(($stripe_USD * 10) * ($list_CUR));  
							?>
							<input type="hidden" value="<?php echo $id;?>" id="listingid">
							<input type="hidden" value="<?php echo $stripe_money;?>" id="stripemoney">
							<div class="col-sm-6 coldiv">   
								<h3><?php echo Yii::t('app','Listing');?></h3>
								<?php $form = ActiveForm::begin(); ?>
								<?php
								$priority= ['1' => '1', '2' => '2','3' => '3'];
								$homeData=ArrayHelper::map($hometype,'id','hometype');
								$roomData=ArrayHelper::map($roomtype,'id','roomtype');
								echo '<div class="airfcfx-xs-selectalign selectalign">';
								echo '<label>'. Yii::t('app','Property Type').'</label>';
								$homeid = $listdata->hometype;
								$roomid = $listdata->roomtype;
								$accommodates = $listdata->accommodates;
								$bedrooms = $listdata->bedrooms;
								$beds = $listdata->beds;
								$bathrooms = $listdata->bathrooms;
								$model->hometype = $homeid;
								$model->roomtype = $roomid;
								echo $form->field($model, 'hometype')->dropDownList(
										$homeData,
										['name'=>'hometype',
										'id'=>'hometype',
										'class'=>'form-control listselect selectsze'])->label(false);
								echo '</div>';
								echo '<div class="airfcfx-xs-selectalign selectalign">';
								echo '<label>'. Yii::t('app','Room Type').'</label>';
								echo $form->field($model, 'roomtype')->dropDownList(
										$roomData,
										['name'=>'roomtype',
										'id'=>'roomtype',
										'class'=>'form-control listselect selectsze'])->label(false);
								echo '</div>';
								echo '<div class="airfcfx-xs-selectalign selectalign">';
								echo '<label>'. Yii::t('app','Accommodates').'</label>';
								echo '<select name="accommodates" id="accommodates" class="form-control listselect selectsze">';
								for($i=1;$i<=$listingproperties->accommodates;$i++)
								{
									if($accommodates==$i)
										echo '<option value='.$i.' selected>'.$i.'</option>';
									else
										echo '<option value='.$i.'>'.$i.'</option>';
								}
								echo '</select>';
								echo '</div>';
								?>

							</div>
							<div class="col-sm-6 coldiv">
								<hr />
								<h3><?php echo Yii::t('app','Rooms and Beds');?></h3>
								<?php
								echo '<div class="airfcfx-xs-selectalign selectalign">';
								echo '<label>'. Yii::t('app','Bedrooms').'</label>';
								echo '<select name="bedrooms" id="bedrooms" class="form-group form-control listselect selectsze">';
								for($i=1;$i<=$listingproperties->bedrooms;$i++)
								{
									if($bedrooms==$i)
										echo '<option value='.$i.' selected>'.$i.'</option>';
									else
										echo '<option value='.$i.'>'.$i.'</option>';
								}
								echo '</select>';
								echo '</div>';
								echo '<div class="airfcfx-xs-selectalign selectalign">';
								echo '<label>'. Yii::t('app','Beds').'</label>';
								echo '<select name="beds" id="beds" class="form-group form-control listselect selectsze">';
								for($i=1;$i<=$listingproperties->beds;$i++)
								{
									if($beds==$i)
										echo '<option value='.$i.' selected>'.$i.'</option>';
									else
										echo '<option value='.$i.'>'.$i.'</option>';
								}
								echo '</select>';
								echo '</div>';
								echo '<div class="airfcfx-xs-selectalign selectalign">';
								echo '<label>'. Yii::t('app','Bathrooms').'</label>';
								echo '<select name="bathrooms" id="bathrooms" class="form-group form-control listselect selectsze">';
								for($i=1;$i<=$listingproperties->bathrooms;$i++)
								{
									if($bathrooms==$i)
										echo '<option value='.$i.' selected>'.$i.'</option>';
									else
										echo '<option value='.$i.'>'.$i.'</option>';
								}
								echo '</select>';
								echo '</div>';
								?>
								
								
							</div>
							<?php //if($hour_booking=='yes'){?>
							<div class="col-sm-6 coldiv">
								<hr />
								<h3><?php echo Yii::t('app','Duration');?></h3>
								<?php
								echo '<div class="airfcfx-xs-selectalign selectalign">';
								echo '<select name="booking" id="booking" class="form-group form-control listselect selectsze">';
								$hour=""; $pernight=""; $perday=""; 
								if($listdata->booking=='perhour'){ $hour="selected"  ; }
								else if($listdata->booking=='pernight'){ $pernight="selected"  ; }
								else{ $perday="selected"  ; }
								echo '<option value="perhour" '.$hour.'>Hourly based</option>';
								echo '<option value="pernight" '.$pernight.'>Per Night</option>';
								/*echo '<option value="perday" '.$perday.'>Both Duration</option>';*/
								echo '</select>';
								echo '</div></div>';
								?>
							<?php // }?>
							<div class="col-sm-6 coldiv"><hr /></div>
								<div class="col-sm-12"><input type="button" value="<?php echo Yii::t('app','Next');?>" class="btn btn_email nextbtn" onclick="show_description();"></div>
								
							

							<?php ActiveForm::end(); ?>
						</div>
						<!--col-xs-12 end -->
						<div class="col-xs-12 margin_top10 margin_bottom20 hiddencls commcls" id="descriptiondiv">
							<h3><?php echo Yii::t('app','Tell travelers about your space');?></h3>
							<?php echo Yii::t('app','Every space on ').$sitesetting->sitename.Yii::t('app',' is unique. Highlight what makes your listing welcoming so that it stands out to guests who want to stay in your area.');?>
							<hr />
						
							<div class="col-sm-6 coldiv">
							<?php $strleng = 35 - strlen($listdata->listingname); 
									$strdescleng = 2500 - strlen($listdata->description);?> 
								<label class="airfcfx-manage-label"><?php echo Yii::t('app','Listing Name');?><p class="charleft" id="charaNum" style="right: 0;"><?php echo $strleng; ?> <?php echo Yii::t('app','characters left');?></p></label>
								<?= $form->field($model, 'listingname')->textInput(['id'=>'listingname','maxlength' => '35', 'value'=>''.$listdata->listingname.'','class' => 'form-control margin_bottom10'])->label(false); ?>
								<label class="airfcfx-manage-label"><?php echo Yii::t('app','Description');?><p class="charleft" id="chardescNum" style="right: 0;"><?php echo $strdescleng; ?>  <?php echo Yii::t('app','characters left');?></p></label>
								<?= $form->field($model, 'description')->textArea(['id'=>'description','maxlength' => '2500','value'=>''.$listdata->description.'','rows' => '6','class' => 'form-control margin_bottom10'])->label(false); ?>  
								<hr/>

								<input type="button" value="<?php echo Yii::t('app','Next');?>" class="btn btn_email nextbtn" onclick="show_location();">
								<a href="javascript:void(0);" onclick="show_basics();" class="backbtn"><?php echo Yii::t('app','Back');?></a>
							</div>
						</div>
						<div class="col-xs-12 margin_top10 margin_bottom20 hiddencls commcls" id="locationdiv">
							<h3><?php echo Yii::t('app','Help guests find your place');?></h3>
							<?php echo Yii::t('app','Travelers will use this information to find a place that’s in the right spot.');?>
							<hr />
							
							<div class="col-sm-6 coldiv">
								
									<?php
									$countryData=ArrayHelper::map($country,'id','countryname');
									$model->country = $listdata->country;
									$model->timezone = $listdata->timezone; 
									$city = $listdata->city;
									$state = $listdata->state;
									echo '<label>'. Yii::t('app','Country').'</label>';
									echo $form->field($model, 'country')->dropDownList(
										$countryData,
										['prompt'=>'Select...',
										'onchange'=>'update_timezone()',
										'name'=>'country',
										'id'=>'country',
										'class'=>'airfcfx-timezone-dd form-control listselect selectsze'])->label(false);
									
									$timeZoneData=ArrayHelper::map($countryZoneData,'id','timezone');
									echo '<label>'. Yii::t('app','Timezone').'</label>';
									echo $form->field($model, 'timezone')->dropDownList(
										$timeZoneData,
										[ 
										'name'=>'timezone',
										'id'=>'timezone',
										'class'=>'airfcfx-timezone-dd form-control listselect selectsze'])->label(false);
									?> 

								<label><?php echo Yii::t('app','Street Address');?></label>
								<?= $form->field($model, 'streetaddress')->textInput(['id'=>'streetaddress','value'=>''.$listdata->streetaddress.'', 'class' => 'form-control margin_bottom10'])->label(false); ?>
								<label><?php echo Yii::t('app','Apt, Suite, Bldg. (optional)');?></label>
								<?= $form->field($model, 'accesscode')->textInput(['id'=>'accesscode','value'=>''.$listdata->accesscode.'', 'class' => 'form-control margin_bottom10'])->label(false); ?>
								<div class="leftdiv">
								<label><?php echo Yii::t('app','City');?></label>
								<?= $form->field($model, 'city')->textInput(['id'=>'city', 'value'=>''.$city.'','class' => 'form-control margin_bottom10 divmediumtext'])->label(false); ?>
								</div>
								<div class="leftdiv">
								<label><?php echo Yii::t('app','State');?></label>
								<?= $form->field($model, 'state')->textInput(['id'=>'state','value'=>''.$state.'', 'class' => 'form-control margin_bottom10 divmediumtext'])->label(false); ?>
								</div>
								<div style="clear: both;">
								<label><?php echo Yii::t('app','Zip Code');?></label>
								<?= $form->field($model, 'zipcode')->textInput(['id'=>'zipcode', 'maxlength'=>'20', 'value'=>''.$listdata->zipcode.'','class' => 'form-control margin_bottom10 mediumtext'])->label(false); ?>
								<input type="hidden" id="latbox"><input type="hidden" id="lonbox">
								<div class="errcls" style="clear: both;"></div>
								<hr/>
								<input type="button" value="<?php echo Yii::t('app','Save Address');?>" class="btn btn_email leftbtn" onclick="showAddress();">
								</div>
							</div>
						</div>
						<div class="col-xs-12 margin_top10 margin_bottom20 hiddencls commcls" id="amenitiesdiv">
							<h3><?php echo Yii::t('app','Tell travelers about your space');?></h3>
							<?php echo Yii::t('app','Every space on ').$sitesetting->sitename.Yii::t('app',' is unique. Highlight what makes your listing welcoming so that it stands out to guests who want to stay in your area.');?>
							<hr />
							
							<div class="col-sm-6 coldiv">
								<h3><?php echo Yii::t('app','Common Amenities');?></h3>
								<?php
								if(isset($commonlistings))
								{
									foreach($commonlistings as $commonlistid)
									{
										$commonlistids[] = $commonlistid->amenityid;
									}
								}
								foreach($commonamenities as $common)
								{
									if(isset($commonlistids) && !empty($commonlistids) && in_array($common->id,$commonlistids))
									echo '<input type="checkbox" name="commonamenities[]" id="commonamenities'.$common->id.'" value="'.$common->id.'" checked><label style="display:block" for="commonamenities'.$common->id.'" class="airfcfx-search-checkbox-text">'.$common->name.'</label>';
									else
									echo '<input type="checkbox" name="commonamenities[]" id="commonamenities'.$common->id.'"value="'.$common->id.'"><label style="display:block" for="commonamenities'.$common->id.'" class="airfcfx-search-checkbox-text">'.$common->name.'</label>';
									echo '<br />';
								}
								?>
								<hr />
								<h3><?php echo Yii::t('app','Additional Amenities');?></h3>
								<?php
								if(isset($additionallistings))
								{
									foreach($additionallistings as $additionallistid)
									{
										$additionallistids[] = $additionallistid->amenityid;
									}
								}								
								foreach($additionalamenities as $additional)
								{
									if(isset($additionallistids) && !empty($additionallistids) && in_array($additional->id,$additionallistids))
									echo '<input type="checkbox" name="additionalamenities[]" id="additionalamenities'.$additional->id.'" value="'.$additional->id.'" checked><label style="display:block" for="additionalamenities'.$additional->id.'" class="airfcfx-search-checkbox-text">'.$additional->name.'</label>';
									else
									echo '<input type="checkbox" name="additionalamenities[]" id="additionalamenities'.$additional->id.'" value="'.$additional->id.'"><label style="display:block" for="additionalamenities'.$additional->id.'" class="airfcfx-search-checkbox-text">'.$additional->name.'</label>';
									echo '<br />';
								}
								?>
								<hr />
								<h3><?php echo Yii::t('app','Special Features');?></h3>
								<?php
								if(isset($speciallistings))
								{
									foreach($speciallistings as $speciallistid)
									{
										$speciallistids[] = $speciallistid->specialid;
									}
								}								
								foreach($specialfeatures as $special)
								{
									if(isset($speciallistids) && !empty($speciallistids) && in_array($special->id,$speciallistids))
									echo '<input type="checkbox" name="specialfeatures[]" id="specialfeatures'.$special->id.'" value="'.$special->id.'" checked><label style="display:block" for="specialfeatures'.$special->id.'" class="airfcfx-search-checkbox-text">'.$special->name.'</label>';
									else
									echo '<input type="checkbox" name="specialfeatures[]" id="specialfeatures'.$special->id.'" value="'.$special->id.'"><label style="display:block" for="specialfeatures'.$special->id.'" class="airfcfx-search-checkbox-text">'.$special->name.'</label>';
									echo '<br/>';
								}
								?>
								<div class="amentierrcls" style="clear: both;"></div>
								<hr />
								<input type="button" value="<?php echo Yii::t('app','Next');?>" class="btn btn_email nextbtn" onclick="show_photos();">
								<a href="javascript:void(0);" onclick="show_backlocation();" class="backbtn"><?php echo Yii::t('app','Back');?></a>
							</div>
						</div>
						<div class="col-xs-12 margin_top10 margin_bottom20 hiddencls commcls" id="photosdiv">
							<h3><?php echo Yii::t('app','Photos can bring your space to life');?></h3>
							<?php echo Yii::t('app','Add at least 1 photo of areas guests have access to. You can always come back later and add more.');?>
							<hr />
							
							<div class="col-sm-6 coldiv">
								<div class="col-xs-12 col-sm-12 airfcfx-xs-center">
									<div class="addphotos">
										<a href="javascript:void(0);" style="top: 10px;position: relative;text-decoration:none;cursor:pointer;"><i class="fa fa-camera"></i><?php echo Yii::t('app','Add Photo');?> </a>
										<input type="file" name="XUploadForm[file][]" onchange="update_file_name();" multiple="true" id="uploadfile" accept=".png, .jpg, .jpeg" style="opacity:0;width:100%;height:35px;margin-top:-20px;cursor:pointer;">
									</div>
								</div>

							<div class="col-xs-12 col-sm-12 airfcfx-xs-center">
							<input type="button" class="btn btn-success" value="<?php echo Yii::t('app','Start Upload');?>" onclick="start_file_upload()" id="startuploadbtn">
							<?php
							echo '<img id="loadingimg" src="'.$baseUrl.'/images/load.gif" class="loading" style="margin-top:0px;">';
							?>
							</div>
							<div id="imagenames" class="clear col-sm-12"></div>
							<div id="imagepreview" class="clear col-sm-12">
							<?php
							if(!empty($imagesdata))
							{
								foreach($imagesdata as $images)
								{
									$imagenames[] = $images->image_name;
									$img = $images->image_name;
									echo '<div class="listimgdiv"><img src="'.$baseUrl.'/albums/images/listings/'.$images->image_name.'" id="image_'.$img.'" style="width:70px;height:70px;">
									<i class="listclose fa fa-trash" style="cursor:pointer; font-style:normal;" id="remove_'.$img.'" onclick="remove_image(this,\''.$img.'\')"></i>
									</div>'; 
								}
								$listimages = json_encode($imagenames);
							}
							else
							$listimages = "";
							?>
							</div>
							<input type="hidden" value='<?php echo $listimages;?>' name="uploadedfiles" id="uploadedfiles">

							<div class="col-sm-6 coldiv margin_bottom10">
								<label><?php echo Yii::t('app','Youtube URL');?></label>
									<?= $form->field($model, 'youtubeurl')->textInput(['id'=>'youtubeurl','value'=>''.$listdata->youtubeurl.'', 'class' => 'form-control margin_bottom100', 'placeholder'=>'Youtube Url'])->label(false); ?>
							</div>

							<div class="clear"></div>
							<div class="photoerrcls" style="clear: both;"></div>

							<div class="col-sm-6 coldiv"><hr /></div>
								<div class="col-sm-12"><input type="button" value="<?php echo Yii::t('app','Next');?>" class="btn btn_email nextbtn" onclick="show_safety();">
								<a href="javascript:void(0);" onclick="show_backamenities();" class="backbtn"><?php echo Yii::t('app','Back');?></a>
								</div>
							</div>
						</div>
						<div class="col-xs-12 margin_top10 margin_bottom20 hiddencls commcls" id="safetydiv">
							<h3><?php echo Yii::t('app','Home Safety');?></h3>
							<?php echo Yii::t('app','Though rare, emergencies happen. Help your guests be prepared. Learn more about Safety.');?>  
							<hr />
							
							<div class="col-sm-6 coldiv">
								<h3><?php echo Yii::t('app','Safety Checklist');?></h3>
								<?php
								if(isset($safetylistings))
								{
									foreach($safetylistings as $safetylistid)
									{
										$safetylistids[] = $safetylistid->safetyid;
									}
								}						
								foreach($safetycheck as $safety)
								{
									echo '<div class="col-sm-12 no-hor-padding margin_bottom20">';
									if(isset($safetylistids) && !empty($safetylistids) && in_array($safety->id,$safetylistids))
									echo '<input type="checkbox" name="safetycheck[]"id="safetycheck'.$safety->id.'" value="'.$safety->id.'" checked><label style="display:block" for="safetycheck'.$safety->id.'" class="airfcfx-search-checkbox-text">'.$safety->name.'</label>';
									else
									echo '<input type="checkbox" name="safetycheck[]" id="safetycheck'.$safety->id.'" value="'.$safety->id.'"><label style="display:block" for="safetycheck'.$safety->id.'" class="airfcfx-search-checkbox-text">'.$safety->name.'</label>';

									if(trim($safety->description)!="")
									{
										echo '<span class="safety_desc_text">'.$safety->description.'</span>';
									}
									echo '</div>';
								}
								?>
								<?php /*
								<hr />
								<h3><?php echo Yii::t('app','Safety Card');?></h3>
								<p><?php echo Yii::t('app','Where are safety features located?');?></p>
								<br />
								<label class="selectalign"><?php echo Yii::t('app','Fire extinguisher');?></label>
								<div class="mediumlargediv">
								<?= $form->field($model, 'fireextinguisher')->textInput(['id'=>'fireextinguisher','value'=>''.$listdata->fireextinguisher.'','class' => 'form-control margin_bottom10 divmediumtext'])->label(false); ?>
								</div>
								<label class="selectalign"><?php echo Yii::t('app','Fire alarm');?></label>
								<div class="mediumlargediv">
								<?= $form->field($model, 'firealarm')->textInput(['id'=>'firealarm','value'=>''.$listdata->firealarm.'','class' => 'form-control margin_bottom10 divmediumtext'])->label(false); ?>
								</div>
								<label class="selectalign"><?php echo Yii::t('app','Gas shutoff valve');?></label>
								<div class="mediumlargediv">
								<?= $form->field($model, 'gasshutoffvalve')->textInput(['id'=>'gasshutoffvalve','value'=>''.$listdata->gasshutoffvalve.'','class' => 'form-control margin_bottom10 divmediumtext'])->label(false); ?>
								</div>
								<label><?php echo Yii::t('app','Emergency exit instructions');?></label>
								<?= $form->field($model, 'emergencyexitinstruction')->textArea(['id'=>'emergencyexitinstruction','value'=>''.$listdata->emergencyexitinstruction.'','rows' => '4','class' => 'form-control margin_bottom10'])->label(false); ?>
								<label><?php echo Yii::t('app','Emergency phone numbers');?></label>
								<input type="button" value="<?php echo Yii::t('app','Edit');?>" class="default-txt" data-toggle="modal" data-target="#myModal"> */?>
								<br />
								<div class="safeerrcls" style="clear: both;"></div>
								<div class="col-sm-6 coldiv"><hr /></div>
								<div class="col-sm-12"><input type="button" value="<?php echo Yii::t('app','Next');?>" class="btn btn_email nextbtn" onclick="show_price();">
								<a href="javascript:void(0);" onclick="show_backphotos();" class="backbtn"><?php echo Yii::t('app','Back');?></a>
								</div>
							</div>
						</div>							
						<div class="col-xs-12 margin_top10 margin_bottom20 hiddencls commcls" id="pricediv">
							<h3><?php echo Yii::t('app','Set a nightly price for your space');?></h3>
							<?php echo Yii::t('app','You can set a price to reflect the space, amenities, and hospitality you’ll be providing.');?>
							<hr />
							
							<div class="col-sm-6 coldiv">
								<h3><?php echo Yii::t('app','Base Price');?></h3>
								<?php $style=""; if($listdata->booking=='pernight' || $listdata->booking=='perday') { 
									$style="";
									}else{
										$style="display: none;";
										}?>
								<label class="pernightpanel" style="<?php echo $style;?>"><?php echo Yii::t('app','Nightly Price');?></label>
								<div class="pernightpanel" style="<?php echo $style;?>">
								<div class="symbolcls">
									<?php
									if(!empty($currencies))
									{
										$tipSymbol = $currencies['currencysymbol'];
									?>
									<span id="currencysymbol" class="symboltxt currencysymbol"><?php echo $currencies['currencysymbol'];?></span>
									<?php
									}
									else
									{
										$tipSymbol = $defaultcurrency->currencysymbol; 
									?>
									<span id="currencysymbol" class="symboltxt currencysymbol"><?php echo $defaultcurrency->currencysymbol;?></span>
									<?php
									}
									?>
								</div>
								<input type="text" maxlength="6" name="Listing[nightlyprice]" value="<?php echo $listdata->nightlyprice;?>" class="form-control margin_bottom10 smalltext" id="nightlyprice">

								<div id="nightpricetip" class="coldiv pricetip"> 
									<?php echo Yii::t('app','Base Price'); ?>: <span id="nightsymboltip"><?php echo $tipSymbol; ?></span>
									<span id="nightpricetipvalue"><?php echo $stripe_money;?></span>									
								</div>

									<div class="nightlypriceerr " style="clear: both;"></div><br/>
								</div>
								<?php if(($listdata->booking=='perday') || ($listdata->booking=='perhour')) {$style="";}else{$style="display: none;";}?>
								<label class="hourpanel" style="<?php echo $style;?>"><?php echo Yii::t('app','Price Per Hour');?></label>
								<div class="hourpanel" style="<?php echo $style;?>">
								<div class="symbolcls">
									<?php
									if(!empty($currencies))
									{
										$tipSymbol = $currencies['currencysymbol'];
									?>
										<span id="currencysymbol" class="symboltxt currencysymbol"><?php echo $currencies['currencysymbol'];?></span>
									<?php
									}
									else
									{
										$tipSymbol = $defaultcurrency->currencysymbol;  
									?>
									<span id="currencysymbol" class="symboltxt currencysymbol"><?php echo $defaultcurrency->currencysymbol;?></span>
									<?php
									}
									?>
								</div>
								<input type="text" maxlength="6" name="Listing[hourlyprice]" value="<?php echo $listdata->hourlyprice;?>" class="form-control margin_bottom10 smalltext hourlyprice" id="hourlyprice">

								<div id="hourpricetip" class="coldiv pricetip"> 
									<?php echo Yii::t('app','Base Price'); ?>: <span id="hoursymboltip"><?php echo $tipSymbol; ?></span>
									<span id="hourpricetipvalue"><?php echo $stripe_money;?></span> 									
								</div> 

									<div class="hourlypriceerr errcls" style="clear: both;"></div><br/>
								</div>
									
								<div>
									<label><?php echo Yii::t('app','Security Deposit');?></label>
									<input type="text" maxlength="6" name="Listing[securitydeposit]" value="<?php echo $listdata->securitydeposit;?>" class="form-control margin_bottom10 smalltext" id="securitydeposit" placeholder = "(Optional)">
									
									<div class="securityerrcls" style="clear: both;"></div><br/>
								</div>
								<label><?php echo Yii::t('app','Currency');?></label>
								<?php
									$currencyData=ArrayHelper::map($currency,'id','currencycode');
									if(!empty($currencies))
									$model->currency = $currencies->id;
									/*else
									$model->currency = $currency[0]->id;*/
									echo $form->field($model, 'currency')->dropDownList(
										$currencyData,
										['prompt'=>'Select Currency',
										'onchange'=>'update_currency()',
										'name'=>'currency',
										'id'=>'currency',
										'class'=>'airfcfx-timezone-dd form-control listselect selectsze'])->label(false);
									?>


								<!-- Weekend Price -->
								<input name="weekend_status" id="weekend_status" value="1" type="checkbox" <?=  ($listdata->weekendprice == 1) ? 'checked' : ''; ?>>
								<label style="display:block" for="weekend_status" class="airfcfx-search-checkbox-text margin_bottom20">Weekend Price</label>
								<!-- End Weekend Price -->
								<div style="clear: both;"></div>
								<?php
										if($listdata->weekendprice == 1)
										{
											$weekendPrice = Weekendprice::find()->select('weekend_price')->where(['listid'=>$listdata->id])->One();
											$value = $weekendPrice->weekend_price;
											$style_new = 'block';
										}else{
											$value = 0;
											$style_new = 'none';
										}

									?>
								<div class="weekendprice">
									<div class="weekendpernightpanel">
									<label class="weekendpernightpanel"><?php echo Yii::t('app','Weekend Price');?></label>
									<div style="float: left; width: 64%;">
										<div class="symbolcls">
											<?php
											if(!empty($currencies))
											{
												$tipSymbol = $currencies['currencysymbol'];
											?>
											<span id="currencysymbol" class="symboltxt currencysymbol"><?php echo $currencies['currencysymbol'];?></span>
											<?php
											}
											else
											{
												$tipSymbol = $defaultcurrency->currencysymbol; 
											?>
											<span id="currencysymbol" class="symboltxt currencysymbol"><?php echo $defaultcurrency->currencysymbol;?></span>
											<?php
											}
											?>
										</div> 
									
										<input type="text" maxlength="6" name="Listing[weekendprice]" value="<?= 
										(isset($value) && $value != 0) ? $value : ''; ?>" class="form-control margin_bottom10 smalltext" id="weekendprice">

										<div id="weekpricetip" class="coldiv pricetip"> 
											<?php echo Yii::t('app','Base Price'); ?>: <span id="weeksymboltip"><?php echo $tipSymbol; ?></span>
											<span id="weekpricetipvalue"><?php echo $stripe_money;?></span> 									
										</div> 

										<div class="errweekendprice errcls"></div>
									</div> 
									<div class="weekendpricevalid"></div>
									<?php
									if($listdata->booking=='pernight')
									{
										echo '<p>This is a nightly price. It will replace your base price for every Friday and Saturday.</p>';
									}else{
										echo '<p>This is a hourly price. It will replace your base price for every Friday and Saturday. </p>';
									}
									?>
									
									<!--<div class="nightlypriceerr " style="clear: both;"></div><br/>-->
								</div>
								</div>

								<div style="clear: both;"></div>
								<!-- Additional Fees Structures -->
								<label class="margin_top30"><?php echo Yii::t('app','Cleaning fees');?></label> 

								<?php
								$cleaningValue = (isset($listdata->cleaningfees) && $listdata->cleaningfees != 0) ? $listdata->cleaningfees : '0';
								echo $form->field($model, 'cleaningfees')->textInput(['id'=>'cleaningfees','maxlength' => '6', 'value'=>''.$cleaningValue.'','class' => 'form-control margin_bottom10'])->label(false);
								?>
								<div class="cleaningfeeserr errcls" style="clear: both; display: none;"></div><br/>
								<div class="cleaningfeesvalid" style="clear: both; display: none;"></div>


								<label><?php echo Yii::t('app','Service fees');?></label>
								<?php
									$serviceValue = (isset($listdata->servicefees) && $listdata->servicefees != 0) ? $listdata->servicefees : '0'; 
									echo $form->field($model, 'servicefees')->textInput(['id'=>'servicefees','maxlength' => '6', 'value'=>''.$serviceValue.'','class' => 'form-control margin_bottom10'])->label(false); 
								?>
								<div class="servicefeeserr errcls" style="clear: both; display: none;"></div>
								<div class="servicepricevalid" style="clear: both; display: none;"></div>
							</div>

							<div class="col-sm-6 coldiv"><hr /></div>
								<!-- Additional Fees Structures End-->
							<div class="col-sm-12">
								<input type="button" value="<?php echo Yii::t('app','Next');?>" class="btn btn_email nextbtn" onclick="show_booking();">
								<a href="javascript:void(0);" onclick="show_backsafety();" class="backbtn"><?php echo Yii::t('app','Back');?></a>
							</div>
						</div>
						<div class="col-xs-12 margin_top10 margin_bottom20 hiddencls commcls" id="bookingdiv">
							<input type="hidden" id="bookingstyle" name="bookingstyle" value="<?php echo $listdata->bookingstyle;?>">
							<div id="bookingtype">
								<h3 class="margin_top20"><?php echo Yii::t('app','Cancellation Policies'); ?></h3> 
								<div class="col-sm-12 coldiv">
																		
									<?php
									$cancellationData=ArrayHelper::map($cancellationlists,'id','policyname');
									if(!empty($listdata->cancellation) && $listdata->cancellation!= NULL)
										$model->cancellation = $listdata->cancellation;
									
									echo $form->field($model, 'cancellation')->dropDownList(
										$cancellationData,
										['prompt'=>Yii::t('app','Select Cancellation'),
										//'onchange'=>'update_currency()',
										'name'=>'cancellationpolicy',
										'id'=>'cancellationpolicy',
										'class'=>'airfcfx-timezone-dd form-control listselect'])->label(false);
									?>

									<div class="cancellationpolicydesc">
										<?php	foreach($cancellationlists as $cancellations) {	

											if($cancellations->id == $listdata->cancellation) {
												echo $cancellations->canceldesc; 
											}
											
										} ?>
									</div>

									<div class="cancellationpolicyerror help-block-error">
									</div>
									
								</div>
								<div class="col-sm-12 border_bottom margin_top20 margin_bottom20"></div>

								<h3><?php echo Yii::t('app','Choose how your guests book');?></h3>
								<?php echo Yii::t('app','Get ready for guests by choosing your booking style.');?>
											
								<div class="col-sm-6 coldiv margin_top20">
									<div class="gridcls bookinggrid">
										<div class="gridinner">
											<div class="gridcls"><?php echo Yii::t('app','Review each request');?>
											</div>
											<div class="requestcls">
											</div>
											<div class="clear"></div>
											<hr />
											<div class="clear gridinnercls">
											<li class="licls"><?php echo Yii::t('app','Guests send booking requests to host.');?></li>
											<li class="licls"><?php echo Yii::t('app','Approve or decline within 48 hours.');?></li>
											</div>
											<?php
											if(isset($listdata->bookingstyle) && $listdata->bookingstyle=="request")
											echo '<input type="button" class="btn btn-default width100" style="background-color:#4d4d4d !important;" value="'.Yii::t('app','Select').'" onclick="show_request_book();">';
											else
											echo '<input type="button" class="btn btn-default width100" value="'. Yii::t('app','Select').'" onclick="show_request_book();">';
											?>
										</div>
									</div>
									<div class="gridcls bookinggrid">
										<div class="gridinner">
											<div class="gridcls"><?php echo Yii::t('app','Guests Book Instantly');?>
											</div>
											<div class="instantcls">
											</div>
											<div class="clear"></div>
											<hr />
											<div class="clear gridinnercls">
											<li class="licls"><?php echo Yii::t('app','Set controls for who books and when.');?></li>
											<li class="licls"><?php echo Yii::t('app','Guest book without needing approval.');?></li>
											</div>
											<?php
											if(isset($listdata->bookingstyle) && $listdata->bookingstyle=="instant")
												echo '<input type="button" class="btn btn-default width100" style="background-color:#4d4d4d !important;" value="Select" onclick="show_instant_book();">';
											else
												echo '<input type="button" class="btn btn-default width100" value="'. Yii::t('app','Select').'" onclick="show_instant_book();">';
											?>
										</div>
									</div>

								</div>

								
							</div>
							<div id="requestbook" class="col-sm-12 hiddencls">
								<h3><?php echo Yii::t('app','Guests request to book');?></h3>
								<div class="clretxt">
								<?php echo Yii::t('app','You respond to each request within 48 hours. If you do not accept the request within 48 hours the reservation will be declined automatically.');?> <a href="javascript:void(0);" class="text-danger cls_changes" onclick="show_request_type();"><?php echo Yii::t('app','Change');?></a></div>
								<input type="button" value="<?php echo Yii::t('app','Next');?>" class="btn btn_email nextbtn" onclick="show_calendar();">
								<a href="javascript:void(0);" onclick="show_backprice();" class="backbtn"><?php echo Yii::t('app','Back');?></a>								
							</div>
							<div id="instantbook" class="col-sm-12 hiddencls">
								<h3><?php echo Yii::t('app','Instant Book');?></h3>
								<?php echo Yii::t('app','Guests can book without sending requests.');?> <a href="javascript:void(0);" class="text-danger" onclick="show_instant_type();"><?php echo Yii::t('app','Change');?></a>
								<div>
								<h3><?php echo Yii::t('app','House Rules (Optional)');?></h3>
								<?= $form->field($model, 'houserules')->textArea(['id'=>'houserules','maxlength'=>'250','value'=>''.$listdata->houserules.'','rows' => '6','class' => 'form-control margin_bottom10'])->label('House rules (Max 250 characters)') ?>
								</div>
								<input type="button" value="<?php echo Yii::t('app','Next');?>" class="btn btn_email nextbtn" onclick="show_calendar();">
								<a href="javascript:void(0);" onclick="show_backprice();" class="backbtn"><?php echo Yii::t('app','Back');?></a>								
							</div>
						</div>
							<div class="col-xs-12 margin_top10 margin_bottom20 hiddencls commcls" id="calendardiv">
								<h3><?php echo Yii::t('app','Show guests when they can book');?></h3>
								<?php echo Yii::t('app','An accurate calendar is the most important first step for hosting.');?>
								<hr>
								<div id="bookavailability">
									<h4><?php echo Yii::t('app','When are you available?');?></h4><br>
									<input type="hidden" id="bookingavailability" name="bookingavailability"
									value="<?= (isset($listdata->bookingavailability)) ? $listdata->bookingavailability : ''; ?>"/>
									<div class="alwaysdiv">
										<center>
											<?php
											if(isset($listdata->bookingavailability) && $listdata->bookingavailability=="always")
											{
												echo '<div class="alwaysinnerdiv" onclick="update_booktype(\'always\',this);" style="background-color:#fff;">
													<div class="always"></div><br />
													<div>'. Yii::t('app','Always').'</div>
													<div>'. Yii::t('app','Any day is bookable.').'</div>
												</div>';
											}
											else
											{
												echo '<div class="alwaysinnerdiv" onclick="update_booktype(\'always\',this);">
													<div class="always"></div><br />
													<div>'. Yii::t('app','Always').'</div>
													<div>'. Yii::t('app','Any day is bookable.').'</div>
												</div>';												
											}
											?>
										</center>
									</div>

									<div class="alwaysdiv">
										<center>
											<?php
											if(isset($listdata->bookingavailability) && $listdata->bookingavailability=="onetime")
											{
												echo '<div class="alwaysinnerdiv" onclick="update_booktype(\'onetime\',this);" style="background-color:#fff;">
													<div class="always"></div><br />
													<div>'. Yii::t('app','One time').'</div>
													<div>'. Yii::t('app','Host for just one period of time.').'</div>
												</div>';
											}
											else
											{
												echo '<div class="alwaysinnerdiv" onclick="update_booktype(\'onetime\',this);">
													<div class="always"></div><br />
													<div>'. Yii::t('app','One time').'</div>
													<div>'. Yii::t('app','Host for just one period of time.').'</div>
												</div>';												
											}
											?>
										</center>
									</div>
								</div>
								
								<div id="bookdate" class="hiddencls">
									<div class="datediv">
										<div class="alwaysinnerdiv dateleftdiv" onclick="update_booktype('onetime',this);">
											<div class="always"></div><br />
											<div><?php echo Yii::t('app','One time');?></div>
											<div><?php echo Yii::t('app','Host for just one period of time.');?></div>
										</div>
										<div class="daterightdiv">
											<div class="">
												<?php echo Yii::t('app','When can guests book?');?><br /><br />
												<div class="alwaysdiv">
												<?php if(!empty($listdata->startdate)){
														$listdata->startdate	= $listdata->startdate;								
												}else{
														$listdata->startdate = time();												
												}?>
												<p><?php echo Yii::t('app','Start Date');?></p>
												<?= $form->field($model, 'startdate')->textInput(['id'=>'startdate','value'=>''.date('m/d/Y',$listdata->startdate).'','class' => 'form-control cal margin_bottom10 selectsze','placeholder'=>'Start Date'])->label(false); ?>
												</div>
												<div class="alwaysdiv">
												<?php if(!empty($listdata->enddate)){
														$listdata->enddate	= $listdata->enddate;								
												}else{
														$listdata->enddate = strtotime("+1 day");												
												}?>
												<p><?php echo Yii::t('app','End Date');?></p>
												<?= $form->field($model, 'enddate')->textInput(['id'=>'enddate','value'=>''.date('m/d/Y',$listdata->enddate).'','class' => 'form-control cal margin_bottom10 selectsze','placeholder'=>'End Date'])->label(false); ?>
												</div>
											</div>
										</div>										
									</div>
								</div>
								<br/><div class="field-listing-bookavailability"></div>
								<?php $style=""; if($listdata->booking=='pernight' || $listdata->booking=='perday') { $style=""; } else{$style="display:none;";}
								if($hour_booking=='no'){
									//$style="display:none";
								}  
								?>

								<div id="calendarsettings" class="clear pricepernightpanel" style="<?php echo $style;?>">
									<br /><hr />
									<h4><?php echo Yii::t('app','Calendar Settings');?></h4>
									<div class="gridcls">
										<div class="gridcls bookinggrid">
											<label><?php echo Yii::t('app','Minimum Stay');?></label>
											<?php
											$minstay = $listdata->minstay;
											if($minstay=="")
											$minstay = 1;
											?>
											<input type="text" maxlength="2" name="Listing[minstay]" value="<?php echo $minstay;?>" class="form-control margin_bottom10 mediumtext" id="minstay">
											
											<div class="nightcls">
												<span class="symboltxt"><?php echo Yii::t('app','nights'); ?></span>
											</div>											
										</div>
										<div class="gridcls bookinggrid">
											<label><?php echo Yii::t('app','Maximum Stay');?></label>
											<input type="text" maxlength="2" name="Listing[maxstay]" value="<?php echo $listdata->maxstay;?>" class="form-control margin_bottom10 mediumtext" id="maxstay">
											<div class="nightcls">
												<span class="symboltxt"><?php echo Yii::t('app','nights');?></span>
											</div>
										</div>
									</div>
									<div class="col-sm-12 no-hor-padding stayerrcls margin_top10" style="clear: both;"></div>   
								</div> 
								<div id="specialsettings" class="clear">
									<?php 
									$opentime=''; 
									$closetime=''; 
									if(!empty($listdata->pernight_availablity)){
										$listdata->pernight_availablity	= $listdata->pernight_availablity;
										$pernight_availablity=explode('*|*',$listdata->pernight_availablity);
										$opentime=trim($pernight_availablity[0]);
										$closetime=trim($pernight_availablity[1]);
									}    
								?>
								<div class="clear pricepernightpanel" style="<?php echo $style;?>" >
									<br/><hr />
									<h4><?php echo Yii::t('app','Check in-out time for pernight');?></h4><br>
									 <div class="row">
									        <div class="col-md-4 bookinggrid">
										      <input id="opentime" placeholder="Check in Time" type="text" class="form-control margin_bottom10 perhour" value="<?php echo date("h:i A", strtotime($opentime));?>">
									         </div>
									        <div class="col-md-4 bookinggrid">
									          <input id="closetime" placeholder="Check Out Time" type="text" class="form-control margin_bottom10"  
									          value="<?php echo date("h:i A", strtotime($closetime));?>">
									        </div>
									  </div>
									    <div class="timeavailerrcls errcls" style="clear: both;"></div>
								</div>
								
								<?php if($listdata->booking=='perhour' || $listdata->booking=='perday') {  $style=""; }
								else{$style="display:none;"; }
								?>
								<?php if(!empty($listdata->hourly_availablity)){
											$listdata->hourly_availablity	= $listdata->hourly_availablity;
											$pernight_availablity=explode(',',$listdata->hourly_availablity);
										}?>

										</div>
								<div id="addmorehours">
								<div  class="clear pricehourpanel" style="<?php echo $style;?>">
									<br><hr />
									<h4><?php echo Yii::t('app','Check in-out time for perhour');?></h4>
									 <div class="row">
									        <div class="col-md-3 bookinggrid">
										       <input id="addhourstart" type="text" placeholder="Check in time" class="form-control margin_bottom10 perhour">
										       <div class="checkinerr"></div>
								            </div>
									        <div class="col-md-3 bookinggrid">
									            <input id="addhourend" type="text" placeholder="Check out Time" class="form-control margin_bottom10 perhour">
									            <div class="checkouterr"></div>
									        </div>

									        <!-- div class="col-md-3 bookinggrid">
									        	<select name="liststatus" class="form-control" id="liststatus">
									        		<option value="" selected="selected">Select</option>
									        		<option value="available">Available</option>
									        		<option value="blocked">Blocked</option>
									        	</select>
									        	<div class="liststatuserr"></div>
									        </div>

									        <input type="hidden" name="listing_status" id="listing_status" value="">
									        <div class="col-md-3 bookinggrid">
									            <input id="price" type="text" placeholder="Price(Optional)" class="form-control margin_bottom10 perhour">
									        </div -->

									    <div class="callndr-reset" style="clear: both;">
									        <div class="col-xs-4 col-md-2">
									        	<div class="bookinggrid">
											        <div class="input-group">
												        <button class="btn btn-primary" onclick="addmorehours();">
												        <span>Add</span>
														</button>
													</div>
												</div>
									        </div>
									        <div class="col-xs-4 col-md-2">
									        	<div class="bookinggrid">
											        <div class="input-group">
											        	<?php if($reservations ==0){?>
												        <button class="btn btn-primary" onclick="removehours();">
												         Reset
														</button>
														<?php }?>
													</div>
												</div>
									        </div>
									    </div>
									 </div>
									<div class="houravailerrcls errcls" style="clear: both;"></div>
								</div>
								<?php $endTime=""; if(!empty($listdata->hourly_availablity)){
								$hourly_availablity=explode(',',$listdata->hourly_availablity);
								$hourly_availablity = array_values(array_filter($hourly_availablity));  
								$hourly_availablity_count=count($hourly_availablity);
								for($i=0;$i<$hourly_availablity_count;$i++){
									$houravail=explode('*|*',$hourly_availablity[$i]);
								?>
								<div class="clear addpricehourpanel" style="<?php echo $style;?>">
									<hr />
									<div class="row">
										<div class="col-md-4 bookinggrid">
											<div class="input-group bootstrap-timepicker timepicker">
												<input name="hourtime[]" type="text" class="form-control margin_bottom10" value="<?php echo date("h:i A", strtotime($houravail[0]));?>" readonly>
											</div>
										</div>
										<div class="col-md-4 bookinggrid">
											<div class="input-group bootstrap-timepicker timepicker">
												<input name="hourtime[]" type="text" class="form-control margin_bottom10 " value="<?php echo date("h:i A", strtotime($houravail[1]));?>" readonly >
											</div>
										</div>
										<?php // IF NEEDED TIME REMOVE OPTION PLEASE ENABLE BELOW CODE
										if($reservations < 0) { ?>
											<div class="col-md-2 bookinggrid">
												<div class="input-group removehours" style="display:none;"><i class="glyphicon glyphicon-remove"></i></div>
											</div> 
										<?php } ?> 
									</div>
								</div> 
								<?php $endTime= date("h:i A", strtotime($houravail[1]));
								}
								}?>
								
								</div>
								<hr/>
								<div class="completelisting errcls" style="clear: both;"></div>
								
									<input type="button" value="<?php echo Yii::t('app','Save');?>" class="btn btn_email nextbtn" onclick="savefullist();">
									<a href="javascript:void(0);" onclick="show_backbooking();" class="backbtn"><?php echo Yii::t('app','Back');?></a>
								
							</div>
							<div class="col-xs-12 margin_top10 margin_bottom20 hiddencls commcls" id="profilediv">
								<h3><?php echo Yii::t('app','Complete your profile');?></h3>
								<?php echo Yii::t('app','Both guests and hosts must fill out a complete profile.');?>
								<hr />
								
								<div class="col-sm-6 coldiv">
									<a href="javascript:void(0);" onclick="show_backcalendar();" class="backbtn"><?php echo Yii::t('app','Back');?></a>
								</div>
							</div>
						</div>
					</div>
					<!--row end -->
				</div>
			</div>
			<!--Panel end -->





		</div>
		<!--col-sm-9 end -->

	</div>
	<!-- container end -->


</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog emergency_width" role="document">
    <div class="modal-content">
      <div class="modal-header no_border clearfix">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body text-center">
			<label class="selectalign"><?php echo Yii::t('app','Medical');?></label>
			<div class="mediumlargediv">
			<?= $form->field($model, 'medicalno')->textInput(['id'=>'medicalno','value'=>''.$listdata->medicalno.'','class' => 'form-control margin_bottom10 divmediumtext'])->label(false); ?>
			</div>			
			<br />
			<label class="selectalign"><?php echo Yii::t('app','Fire');?></label>
			<div class="mediumlargediv">
			<?= $form->field($model, 'fireno')->textInput(['id'=>'fireno','value'=>''.$listdata->fireno.'','class' => 'form-control margin_bottom10 divmediumtext'])->label(false); ?>
			</div>			
			<br />
			<label class="selectalign"><?php echo Yii::t('app','Police');?></label>
			<div class="mediumlargediv">
			<?= $form->field($model, 'policeno')->textInput(['id'=>'policeno','value'=>''.$listdata->policeno.'','class' => 'form-control margin_bottom10 divmediumtext'])->label(false); ?>
			</div>			
			<br />
			<div class="numbererrcls" style="clear: both;"></div><br/>
	  </div>
      <div class="modal-footer clear">
		<input type="button" value="<?php echo Yii::t('app','Save');?>" class="btn btn_email" data-dismiss="modal">
      </div>            
  </div>
</div>
</div>
<!--script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script-->
<script type="text/javascript">
function showAddress() {
	var check = 0;
	city = $("#city").val();
	state = $("#state").val();
	countries = $("#country option:selected").text();
	countryval = $("#country").val();

	timezoneval = $("#timezone").val();
	 
	zipcode = $("#zipcode").val();
	streetaddress = $("#streetaddress").val();
	accesscode = $("#accesscode").val();
	listingid = $("#listingid").val();
	if(countries == 'Select...'){
		country = "";
	}else{
		country = countries;
	}
	
	if($.trim(country) == ''){
		$(".field-listing-country").addClass("has-error");
    	$("#country").next(".help-block-error").html("Select Country");
    	check = 1;
    	$("#country").change(function(){
        	$(".field-listing-country").removeClass("has-error");
        	$("#country").next(".help-block-error").html("");
    	});
	
	}

	if($.trim(timezoneval) <= 0 || $.trim(timezoneval)==""){ 
		$(".field-listing-timezone").addClass("has-error");
    	$("#timezone").next(".help-block-error").html("Select Timezone");
    	check = 1;
    	$("#timezone").change(function(){
        	$(".field-listing-timezone").removeClass("has-error");
        	$("#timezone").next(".help-block-error").html("");
    	});
	
	}

	if($.trim(city) == ''){
		$(".field-listing-city").addClass("has-error");
    	$("#city").next(".help-block-error").html("City cannot be blank");
    	check = 1;
    	$("#city").keydown(function(){
        	$(".field-listing-city").removeClass("has-error");
        	$("#city").next(".help-block-error").html("");
    	});
	
	}
	if($.trim(streetaddress) == ''){
		$(".field-listing-streetaddress").addClass("has-error");
    	$("#streetaddress").next(".help-block-error").html("Street Address cannot be blank");
    	check = 1;
    	$("#streetaddress").keydown(function(){
        	$(".field-listing-streetaddress").removeClass("has-error");
        	$("#streetaddress").next(".help-block-error").html("");
    	});
	
	}
	if($.trim(zipcode) == ''){
		$(".field-listing-zipcode").addClass("has-error");
    	$("#zipcode").next(".help-block-error").html("Zipcode cannot be blank");
    	check = 1;
    	$("#zipcode").keydown(function(){
        	$(".field-listing-zipcode").removeClass("has-error");
        	$("#zipcode").next(".help-block-error").html("");
    	});
	
	}	

	
	if(check == 1){
		return false;
	}
	else
	{
		address = streetaddress+','+city+','+state+','+country+','+zipcode;
		var geocoder = new google.maps.Geocoder();
		
		geocoder.geocode( { 'address': address}, function(results, status) {
		
		if (status == google.maps.GeocoderStatus.OK) {
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();
				$("#latbox").val(latitude);
				$("#lonbox").val(longitude);
				if($.trim(latitude) == "" || $.trim(longitude) == "")
				{
					$(".errcls").show();
					$(".errcls").html("Cannot get latitude and longitude. Please enter valid address");
						setTimeout(function() {
							$(".errcls").slideUp();
							$('.errcls').html('');
						}, 5000);
						check = 1;
				}	
				else
				{
				    $.ajax({
				        type : 'POST',
				        url : baseurl + '/user/listing/savelocationlist',
				        async: false,
				        data : {
				        	country : countryval,
				        	timezone : timezoneval,  
				        	streetaddress : streetaddress,
				        	accesscode : accesscode,
				        	city : city,
				        	state : state,
				        	zipcode : zipcode,
				        	listingid : listingid,
				        	latitude: latitude,
				        	longitude: longitude
				        },
				        success : function(data) {
				    		$("#showLoc").css('background','none');
				    		$("#showAmenities").css('background','#ddd');
				    		$('#showAmenities').css('border-left','3px solid #008489');
            			$('#showLoc').css('border-left',''); 
				    		$("#locationdiv").hide();
				    		$("#amenitiesdiv").show();
				        }
				    });			
				}
				//$("#locationdiv").hide();
				//$("#amenitiesdiv").show();		
			}
			else
			{ 
				$("#latbox").val("");
				$("#lonbox").val("");
					$(".errcls").show();
					$(".errcls").html("Cannot get latitude and longitude. Please enter valid address");
						setTimeout(function() {
							$(".errcls").slideUp();
							$('.errcls').html('');
						}, 5000);
						check = 1;				
			}
		});
	}
}
</script>
<!--<link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/css/bootstrap-timepicker.css">
<script type="text/javascript" src="<?php //echo $baseUrl.'/js/bootstrap-timepicker.js';?>"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/css/classic.css">
<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/css/classic.date.css">
<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/css/classic.time.css">
<script type="text/javascript" src="<?php echo $baseUrl.'/js/picker.date.js';?>"></script>
<script type="text/javascript" src="<?php echo $baseUrl.'/js/picker.js';?>"></script>
<script type="text/javascript" src="<?php echo $baseUrl.'/js/picker.time.js';?>"></script>

<script type="text/javascript" src="<?php echo $baseUrl.'/js/moment.js';?>"></script>
<script type="text/javascript" src="<?php echo $baseUrl.'/js/daterangepicker.js';?>"></script>

<script type="text/javascript">
$(document).on('click', '.removehours', function(events){
   	enddatetime=$('#addhourstart').val().trim();
	var endtime= $('#addhourstart').pickatime().pickatime('picker');
	endtime.set('min',enddatetime);
	$(this).closest('div.addpricehourpanel').remove();

});

function removehours()
{
	if (confirm("Are you sure you want to reset the hour timing ? ")) {
	/* Reset action for listings */
	$('.addpricehourpanel').html('');
	$('#addhourend').val('');
	$('#addhourstart').val('');

	var starttime= $('#addhourstart').pickatime().pickatime('picker');
	var endtime= $('#addhourend').pickatime().pickatime('picker');
	starttime.set('min','12:00 AM');
	endtime.set('min','12:00 AM');
	}
}

 $("select#liststatus").change(function () {
 	    var end = this.value;
        $('#listing_status').val(end);
        return false;
    });

function addmorehours()
{
	//For hours addtionaly we have added the price and liststatus.
	var booking=$('#booking').val();
	startdatetime=$('#addhourstart').val().trim();
	enddatetime=$('#addhourend').val().trim();
	closetime=$('#closetime').val().trim();


	if(startdatetime == '')
	{
		$(".checkinerr").html("Please select check-in hour").css('display','block');
        setTimeout(function() {
                                $(".checkinerr").hide();
                                $('.checkinerr').html('');
                        }, 5000);
        return false;
	}else{
		$(".checkinerr").hide();
	}

	if(enddatetime == '')
	{
		$(".checkouterr").html("Please select check-out hour").css('display','block');
        setTimeout(function() {
                                $(".checkouterr").hide();
                                $('.checkouterr').html('');
                        }, 5000);
        return false;
	}else{
		$(".checkouterr").hide();
	}

	if(startdatetime!="" && enddatetime!="" && startdatetime!=enddatetime)
	{
		var starttime= $('#addhourstart').pickatime().pickatime('picker');
		starttime.set('min',enddatetime);
		var endtime= $('#addhourend').pickatime().pickatime('picker');
		endtime.set('min',enddatetime);
		 
		$('#addmorehours').append('<div class="clear addpricehourpanel"><hr /><div class="row"><div class="col-md-4 bookinggrid"><div class="input-group bootstrap-timepicker timepicker"></span><input name="hourtime[]" value="'+startdatetime+'" type="text" class="form-control margin_bottom10" readonly></div></div><div class="col-md-4 bookinggrid"><div class="input-group bootstrap-timepicker timepicker"></span><input name="hourtime[]" type="text" value="'+enddatetime+'" class="form-control margin_bottom10" readonly></div></div><div class="col-md-2 bookinggrid"><div class="input-group removehours" style="display:none;" ><i class="glyphicon glyphicon-remove"></i></div></div></div></div>');
  
		$('#addhourstart').val('');
		$('#addhourend').val('');
	}
	else
	{
		$(".houravailerrcls").html("Select checkin and checkout time").css('display','block');
        setTimeout(function() {
                                $(".houravailerrcls").hide();
                                $('.houravailerrcls').html('');
                        }, 5000);
        return false;
        
	}
}


$(document).ready(function () {
		$("#nightpricetip").click(function () {
			$("#nightlyprice").val($.trim($("#stripemoney").val()));
		});

		$("#hourpricetip").click(function () {
			$("#hourlyprice").val($.trim($("#stripemoney").val()));
		});

		$("#weekpricetip").click(function () {
			$("#weekendprice").val($.trim($("#stripemoney").val()));
		});  
}); 


$(function () {
var endTime='<?php echo $endTime; ?>';
if(endTime!="" && endTime!=null){
var starttime= $('#addhourstart').pickatime().pickatime('picker');
starttime.set('min',endTime);starttime.set('interval',60);
var endtime= $('#addhourend').pickatime().pickatime('picker');
endtime.set('min',endTime);endtime.set('interval',60);
starttime.on({
  set: function() { 
  		$('#addhourend').val('');
		enddate=$('#addhourstart').val().trim();
		var endtime= $('#addhourend').pickatime().pickatime('picker');
		endtime.set('min',enddate);
	 },
 
})
}
var $input = $( '#opentime' ).pickatime({
	 interval:60,
	 onSet: function(context) {
	 	/*booking=$('#booking').val();
	 	if(booking=='perday')
	 	{	
	 		$('#addhourstart').val('');
	 		$('#addhourend').val('');
	 		$('.addpricehourpanel').html('');
	 		enddate=$('#opentime').val().trim();
			if(enddate!="" && enddate!=null)
			{	$('#closetime').val('');
				var endtime= $('#closetime').pickatime().pickatime('picker');
		   		endtime.set('max',enddate);
		   		var addhourstarttime= $('#addhourstart').pickatime().pickatime('picker');
		   		addhourstarttime.set('min',enddate);
			}
	 	}*/
	 }
	 });

var $input = $( '#closetime' ).pickatime({
	interval:60,
	onSet: function(context) {
	 	/*booking=$('#booking').val();
	 	if(booking=='perday')
	 	{	
	 		$('#addhourstart').val('');
	 		$('#addhourend').val('');
	 		$('.addpricehourpanel').html('');
	 	}*/
	 }
	});

var $starttime = $('#addhourstart' ).pickatime({
	interval:60,
	onSet: function(context) {
		enddate=$('#addhourstart').val().trim();
		if(enddate!="" && enddate!=null)
		{	$('#addhourend').val('');
			var endtime= $('#addhourend').pickatime().pickatime('picker');
	   		endtime.set('min',enddate);
		}
		
	 }
});

var $endtime = $('#addhourend').pickatime({
	interval:60,
	});

var picker = $starttime.pickatime('picker')
picker.open();

$("#startdate").datepicker({
	minDate:new Date(),
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#enddate").datepicker("option", "minDate", dt);time
        }
    });
edate = new Date();
edate.setDate(edate.getDate()+1);
    $("#enddate").datepicker({
		minDate:edate,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#startdate").datepicker("option", "maxDate", dt);
        }
    });

	});
</script>
<script type="text/javascript">
//Get Input Date Range to select date.
$(function() {
    $('input[name="selectdaterange"]').daterangepicker();
});


//Show weekend price for the price calculations.
$('#weekend_status').click(function(){
	//alert('status functions');
	//return false;
	var isChecked = $('#weekend_status:checked').val();

	if(isChecked == 1){
		$('div.weekendprice').show();
		//$('div.pernightpanel').show();
	}else{
		$('div.weekendprice').hide();
		//$('div.pernightpanel').hide();
	}
});

var isChecked = $('#weekend_status:checked').val();
if(isChecked == 1){
		$('div.weekendprice').show();
		//$('div.pernightpanel').show();
	}else{
		$('div.weekendprice').hide();
		//$('div.pernightpanel').hide();
	}


	$("#cleaningfees").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 13 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $(".cleaningfeesvalid").html("Numbers Only").css('display','block');
        $(".cleaningfeesvalid").css('color','#ff5a5f');
        return false;
    }else{
        $(".cleaningfeesvalid").html("Numbers Only").css('display','none');
    }
   });




	$("#servicefees").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 13 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $(".servicepricevalid").html("Numbers Only").css('display','block');
        	$(".servicepricevalid").css('color','#ff5a5f');
            return false;
    }else{
        $(".servicepricevalid").html("Numbers Only").css('display','none');
    }
   });


	$("#weekendprice").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 13 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $(".errweekendprice").html("Numbers Only").css('display','block');
        
            return false;
    }else{
        $(".errweekendprice").html("Numbers Only").css('display','none'); 
    }
   });

	$(document).ready(function(){ 
		if($('#specialprice_status').val() == 1)
		{
			$('.speicalprice_settings').show();
		}else{
			$('.speicalprice_settings').hide();
		}

	});

	$('input#specialprice_status').click(function(){	
		var isChecked = $('#specialprice_status:checked').val();

		if(isChecked == 1 || isChecked == 0){ 
			$('.speicalprice_settings').show();
		}else{
			$('.speicalprice_settings').hide();
		}
	});


	$(document).ready(function(){ 
		$("#specialprice").keypress(function (e) {
     		if (e.which != 8 && e.which != 0 && e.which != 13 && (e.which < 48 || e.which > 57))
     		{
	        //display error message
	        $(".specialpriceerr").html("Numbers Only").css('display','block');
	         setTimeout(function() {
                    $(".specialpriceerr").slideUp();
                    $('.specialpriceerr').html('');
            }, 5000);
	         return false;
	    	}
	   });

	   $("#specialprice").keyup(function (e) {
	    	specialprice = $("#specialprice").val();
	    	
	    	if (specialprice == "0") {
	        $("#specialprice").val("");
	        $(".specialpriceerr").html("Price shoud be greater than 0").css('display','block');
	         setTimeout(function() {
                    $(".specialpriceerr").slideUp();
                    $('.specialpriceerr').html('');
            }, 5000);        
	    	}
	   }); 

	});



	$('#liststatus').change(function(){

		if($('#liststatus option:selected').val() == 'available')
		{
			$('.pricebar').show();
			$('.specialnote').show();
		}else if($('#liststatus option:selected').val() == 'blocked') {
			$('.pricebar').hide();
			$('.specialnote').show();
		} else {
			$('.pricebar').hide();
			$('.specialnote').hide();
		}
	});
</script>

<?php 
	 $availDates = "";
    $blockDates = "";
    $todaydate = date('m/d/Y');
    $today = strtotime($todaydate);
      if(trim($listdata->splpricestatus) == 1) {
         if(trim($listdata->specialprice) !="") {
            $specialpricedata = json_decode($listdata->specialprice);

            if(count($specialpricedata) > 0 ) {
               foreach ($specialpricedata as $key => $special) {
                  if(strtotime($special->specialendDate) >= $today) {
                     $c_sdate = strtotime(trim($special->specialstartDate));
                     $c_edate = strtotime(trim($special->specialendDate));

                     if ($c_edate >= $c_sdate) {
                        for ($pDates=$c_sdate; $pDates <= $c_edate; $pDates+=86400) {
                           $pDate = date('j/n/Y', $pDates);
                           $availDates.= "'".$pDate."',";
                        }
                     }
                  }
               }
            }
         }

         if(trim($listdata->blockedspecialprice) !="") {
            $specialpricedata = json_decode($listdata->blockedspecialprice);

            if(count($specialpricedata) > 0 ) {
               foreach ($specialpricedata as $key => $special) {
                  if(strtotime($special->specialendDate) >= $today) {
                     $c_sdate = strtotime(trim($special->specialstartDate));
                     $c_edate = strtotime(trim($special->specialendDate));

                     if ($c_edate >= $c_sdate) {
                        for ($pDates=$c_sdate; $pDates <= $c_edate; $pDates+=86400) {
                           $pDate = date('j/n/Y', $pDates);
                           $blockDates.= "'".$pDate."',";
                        }
                     }
                  }
               }
            }
         }
      }

?>

<style type="text/css">
	.checkinerr, .checkouterr, .liststatuserr{
		color: #ff5a5f;
	}

	.field-listing-bookavailability{
		margin: 10px;
		color: #ff5a5f;
	}
	.datepicker-days .table-condensed {
		cursor: default;
	}
	.safety_desc_text {
		color:#aaaaaa; 
		padding: 0px 30px;
	}
	.removehours {
		display: block;
		margin: 12px 0px; 
		width: 15px;
	}
	.pricetip {
		color: #008489 !important; 
		display: table-cell !important; 
	}
	.pricetip:hover {
    	text-decoration: underline !important;
	} 

	#description.form-control {
		height: auto !important;
	}
</style>
<script type="text/javascript">
	$('#cancellationpolicy').on('change', function() {
		cancellationid = $("#cancellationpolicy").val();
		$('.cancellationpolicyerror').html('');

		if($.trim(cancellationid)!="" && parseInt(cancellationid) > 0) {
			$.ajax({
				type : 'POST',
				url : baseurl + '/user/listing/changecanceldesc',
				data : {
				   cancellationid : cancellationid,
				},   
				success : function(data) {
				  	if($.trim(data)!="empTy" && $.trim(data)!="") {
				  		$('.cancellationpolicyerror').removeClass('help-block-error'); 
				  		$('.cancellationpolicydesc').html($.trim(data));
				  	}
	      	}
    		}); 
		} else {
			$('.cancellationpolicyerror').addClass('help-block-error');
			$('.cancellationpolicyerror').html('Please select cancellation policy');
			$('.cancellationpolicydesc').html('');  
		}
	});

	function update_timezone() {
		var countryid = $("#country").val();

		if($.trim(countryid)!="" && parseInt(countryid) > 0) {
			$.ajax({
				type : 'POST',
				url : baseurl + '/user/listing/changetimezone',
				data : {
				   countryid : countryid,
				},   
				success : function(data) {
				  	if($.trim(data)!="empTy" && $.trim(data)!="") {
				  		$('.field-listing-country > .help-block').removeClass('help-block-error'); 
				  		$('#timezone').html($.trim(data));
				  	}  
	      	}
    		}); 
		} else {
			$('.field-listing-country > .help-block').addClass('help-block-error');
			$('.field-listing-country > .help-block').html('Country not found');
			$('.field-listing-country > .help-block').html('');   
		}
	}
</script>