<?php
use \yii\web\Request;
use frontend\models\Shippingaddress;
use backend\models\Country; 

$baseUrl = Yii::$app->request->baseUrl;
$fronturl = str_replace('/backend/web', '', (new Request)->getBaseUrl());
$userid = $userdata->id;
$profileimage = $userdata->profile_image;

echo '<div class="col-sm-12">
			<div class="col-sm-3">'. Yii::t('app','Name:').'</div>
			<div class="col-sm-9">'.$userdata->firstname.' '.$userdata->lastname.'</div>
		</div>';

if($profileimage=="")
$profileimage = "usrimg.jpg";
echo '<div class="col-sm-12">
			<div class="col-sm-3">'. Yii::t('app','User Image:').'</div>
			<div class="col-sm-9"><img src="'.$fronturl.'/albums/images/users/'.$profileimage.'" style="width:100px;height:100px;border-radius:55px;"></div>
		</div>'; 

echo '<div class="col-sm-12">
			<div class="col-sm-3">'. Yii::t('app','Birthday:').'</div>
			<div class="col-sm-9">'.$userdata->birthday.'</div>
		</div>
		
		<div class="col-sm-12">
			<div class="col-sm-3">'. Yii::t('app','Gender:').'</div>
			<div class="col-sm-9">'.$userdata->gender.'</div>
		</div>

		<div class="col-sm-12">
			<div class="col-sm-3">'. Yii::t('app','Email:').'</div>
			<div class="col-sm-9">'.$userdata->email.'</div>
		</div>  

		<div class="col-sm-12">
			<div class="col-sm-3">'. Yii::t('app','Phone Number:').'</div>
			<div class="col-sm-9">'.$userdata->verifycountrycode." ".$userdata->verifyno.'</div> 
		</div>

		<div class="col-sm-12">
			<div class="col-sm-3">'. Yii::t('app','State:').'</div>
			<div class="col-sm-9">'.$userdata->state.'</div>
		</div>

		<div class="col-sm-12">
			<div class="col-sm-3">'. Yii::t('app','Referred:').'</div>
			<div class="col-sm-9">'.count($referred).'</div>
		</div>';

		$emergencyContact[] = "";  
		if($userdata->emergencyno!="" || $userdata->emergencyname!="" || $userdata->emergencyemail!="") {
			echo '<div class="col-sm-12">
				<div class="col-sm-3">'. Yii::t('app','Emergency Contact').'</div>';

				if($userdata->emergencyname!="") 
					$emergencyContact[] = ucfirst(trim($userdata->emergencyname))." (".ucfirst(trim($userdata->emergencyrelation)).")";  
				if($userdata->emergencyemail!="")
					$emergencyContact[] = ucfirst(trim($userdata->emergencyemail));
				if($userdata->emergencyno!="") 
					$emergencyContact[] = ucfirst(trim($userdata->emergencyno)); 

				$emergencyContact = implode(',<br>', $emergencyContact);
				echo '<div class="col-sm-9">'.$emergencyContact.'.</div> 
			</div>';   
		}

		$shippingaddress = Shippingaddress::find()->where(['userid'=>$userdata->id])->one();
		$residenceContact[] = "";
		if(count($shippingaddress) > 0) {
			if(trim($shippingaddress->address1) != "") 
					$residenceContact[] = ucfirst(trim($shippingaddress->address1));  
			if(trim($shippingaddress->address2) != "") 
					$residenceContact[] = ucfirst(trim($shippingaddress->address2)); 
			if(trim($shippingaddress->city) != "") 
					$residenceContact[] = ucfirst(trim($shippingaddress->city)); 
			if(trim($shippingaddress->state) != "") 
					$residenceContact[] = ucfirst(trim($shippingaddress->state));  
			if(trim($shippingaddress->country) != "") {
					$countryData = Country::find()->where(['id'=>$shippingaddress->country])->one();
					$residenceContact[] = (count($countryData) > 0) ? ucfirst(trim($countryData->countryname)) : "";  
			}
			if(trim($shippingaddress->zipcode) != "") 
					$residenceContact[] = ucfirst(trim($shippingaddress->zipcode));  

			$residenceContact = implode(',<br>', $residenceContact); 
 
			if($residenceContact != "") {
				echo '<div class="col-sm-12">
					<div class="col-sm-3">'. Yii::t('app','Residence Address:').'</div>
					<div class="col-sm-9">'.$residenceContact.'</div> 
				</div>';
			} 
		}

		if($userdata->emailverify=="1") {
			echo '<div class="col-sm-12">
				<div class="col-sm-3">'. Yii::t('app','Email Verification:').'</div>
				<div class="col-sm-9"><i class="fa fa-fw fa-check tick"></i></div>
			</div>';
		} else {
			echo '<div class="col-sm-12">
				<div class="col-sm-3">'. Yii::t('app','Email Verification:').'</div>
				<div class="col-sm-9"><i class="fa fa-fw fa-times wrong"></i></div>
			</div>';
		}

		if($userdata->mobileverify=="1") {
			echo '<div class="col-sm-12">
				<div class="col-sm-3">'. Yii::t('app','Mobile Verfication:').'</div>
				<div class="col-sm-9"><i class="fa fa-fw fa-check tick"></i></div>
			</div>'; 
		} else {
			echo '<div class="col-sm-12">
				<div class="col-sm-3">'. Yii::t('app','Mobile Verfication:').'</div>
				<div class="col-sm-9"><i class="fa fa-fw fa-times wrong"></i></div>
			</div>'; 
		} 

echo '<div class="col-sm-12"><input type="button" class="btn btn-primary" value="'. Yii::t('app','Message').'" onclick="show_message_popup('.$userid.')"></div>'; 

?>


<style type="text/css">
	#userdetails > div {
		padding: 0px !important; 
	}
</style>
