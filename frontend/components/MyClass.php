<?php
namespace frontend\components;
use backend\models\Sitesettings;
use backend\models\Currency;
use frontend\models\Timezone;

class MyClass {

	public static function getLogo() {
		$id = 1;
		$setting = Sitesettings::find()->where(['id'=>'1'])->one();
		return $setting;
	}

	public static function getEcode($details) {
		for ($i=0; $i <=2 ; $i++) { 
			$details = base64_encode($details);
		}
		return $details;
	}

	public static function getDcode($details) {
		for ($i=0; $i <=2 ; $i++) { 
			$details = base64_decode($details);
		}
		return $details;
	}


	public static function getDecimal($details) {
		$details = substr($details,0,strpos($details,".") + 3);
		return $details;
	}

	public static function getcurrencyprice($currencyCode) {
		

			$defaultCur = Currency::find()->where(['currencycode'=>$currencyCode])->one();
			if(!empty($defaultCur))
		{
			
			$CurrencyPrice=$defaultCur->price;
			
			return $CurrencyPrice;

		}
		else
		{
			return 1;
		}		
		 
	} 

	public static function getTime($id)
	{
		$timezone = Timezone::find()->where(['id' => $id])->one(); 

		if(count($timezone) > 0) {
			$date = $timezone->zonecode; 
			date_default_timezone_set($date);   
			return date('Y-m-d H:i:s', time());  
		} else {
			return "";
		} 
	}  


}
