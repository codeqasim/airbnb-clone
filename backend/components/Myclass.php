<?php
namespace backend\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use backend\models;
use frontend\models\Country;
use frontend\models\Sitesettings;
use frontend\models\Reservations;
use backend\models\Currency;
use backend\models\Userdevices;
use frontend\models\Timezone; 

class Myclass {

	public static function getLogo() {
		$id = 1;
		$setting = Sitesettings::find()->where(['id'=>'1'])->one();
		return $setting;
	}
	
	public static function getCurrencyList($cur = null) {
		$currency =  array(''=>'Select Currency','$-Australian Dollar-AUD' => 'AUD', 
				'R$-Brazilian Rea-BRL' => 'BRL', 'C$-Canadian Dollar-CAD' => 'CAD', 
				'Kč-Czech Koruna-CZK' => 'CZK', 'kr.-Danish Krone-DKK' => 'DKK', 
				'€-Euro-EUR' => 'EUR', 'HK$-Hong Kong Dollar-HKD' => 'HKD', 
				'Ft-Hungarian Forint-HUF' => 'HUF', '₪-Israeli New Sheqel-ILS' => 'ILS', 
				'¥-Japanese Yen-JPY' => 'JPY', 'RM-Malaysian Ringgit-MYR' => 'MYR', 
				'Mex$-Mexican Peso-MXN' => 'MXN', 'kr-Norwegian Krone-NOK' => 'NOK', 
				'$-New Zealand Dollar-NZD' => 'NZD', '₱-Philippine Peso-PHP' => 'PHP', 
				'zł-Polish Zloty-PLN' => 'PLN', '£-Pound Sterling-GBP' => 'GBP', 
				'руб-Russian Ruble-RUB' => 'RUB', 'S$-Singapore Dollar-SGD' => 'SGD', 
				'kr-Swedish Krona-SEK' => 'SEK', 'CHF-Swiss Franc-CHF' => 'CHF', 
				'NT$-Taiwan New Dolla-TWD' => 'TWD', '฿-Thai Baht-THB' => 'THB', 
				'も-Turkish Lira-TRY' => 'TRY', '$-U.S. Dollar-USD' => 'USD' );
		if(!empty($cur)) {
			return $currency[$cur];
		} else {
			return $currency;
		}
	}
	
	public static function getCountryList($country = null){
		$countries = Country::find()->all();
		$countryArray[""] = "Select Country";
		foreach ($countries as $countryDetail){
			$countryArrayIndex = $countryDetail->code.'-'.$countryDetail->countryname;
			$countryArray[$countryArrayIndex] = $countryDetail->countryname;
		}
		if($country == null){
			return $countryArray;
		}else{
			return $countryArray[$country];
		}
		
	}
	
	public static function getCountries($country = null){
		$countries = Country::find()->all();
		$countryArray[""] = "Select Country";
		foreach ($countries as $countryDetail){
			$countryArrayIndex = $countryDetail->id.'-'.$countryDetail->countryname;
			$countryArray[$countryArrayIndex] = $countryDetail->countryname;
		}
		if($country == null){
			return $countryArray;
		}else{
			return $countryArray[$country];
		}
		
	}	

	public static function getRequsted($sdate,$edate)
	{
		$reservations = Reservations::find()->where(['bookstatus'=>'requested'])
											->andwhere(['between', 'cdate', $sdate, $edate])
											->all();
		return count($reservations);
	}

	public static function getAccepted($sdate,$edate)
	{
		$reservations = Reservations::find()->where(['bookstatus'=>'accepted'])
											->andwhere(['between', 'cdate', $sdate, $edate ])
											->all();
		return count($reservations);
	}	

	public static function getDeclined($sdate,$edate)
	{
		$reservations = Reservations::find()->where(['bookstatus'=>'declined'])
											->andwhere(['between', 'cdate', $sdate, $edate ])
											->all();
		return count($reservations);
	}		

	public static function getCancelled($sdate,$edate)
	{
		$reservations = Reservations::find()->where(['bookstatus'=>'cancelled'])
											->andwhere(['between', 'cdate', $sdate, $edate ])
											->all();
		return count($reservations);
	}	

	public function getTurnover($sdate,$edate)
	{
		$reservations = Reservations::find()->where(['not in','bookstatus',['cancelled','declined']])
											->andwhere(['between', 'cdate', $sdate, $edate ])
											->all();
		$total = 0;
		foreach($reservations as $reservation)
		{
			$total += $reservation->total;
		}
		return $total;
	}

	public static function currencyConverter($from_Currency,$to_Currency,$amount) { 

		/* $url = 'http://www.xe.com/currencyconverter/convert/?Amount='.$amount.'&From='.$from_Currency.'&To='.$to_Currency;
             $rawdata = file_get_contents($url);
             $data = explode('uccResultAmount', $rawdata);
             @$data = explode('uccToCurrencyCode', $data[1]);
             $amount = preg_replace('/[^0-9,.]/', '', $data[0]);
            return round($amount, 2);*/
       $url = 'https://www.x-rates.com/calculator/?from='.strtoupper($from_Currency).'&to='.strtoupper($to_Currency).'&amount=1';
             $rawdata = file_get_contents($url); 
              $data = explode('ccOutputRslt">', $rawdata);
              $data1 = explode('ccOutputTrail">', $rawdata);
              $data = explode('<span', $data[1]);   
              $data1 = explode('</span', $data1[1]);   
              return trim($data[0]).trim($data1[0]);      
             
	} 

		public static function currencyUpdateCron() {
			// Developer - AK
			$Sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
			if($Sitesettings->autoupdate_currency==1)
        	{
				$defaultCur = Currency::find()->where(['defaultcurrency'=>'1'])->one();
				if(!empty($defaultCur))
				{
					$defaultcurrency=$defaultCur->currencycode;
					$model = Currency::find()->all();
					foreach ($model as $key => $models) {
						$staticCurrency=$models->currencycode;
						$curId=$models->id;
						$amtConverted = Myclass::currencyConverter($defaultcurrency,$staticCurrency,1);//from,to,amt
						
						//echo json_encode($defaultcurrency." / ".$staticCurrency." / ".$amtConverted."<br>");
						$currencyTbl = Currency::find()->where(['id'=>$curId])->one();
						$currencyTbl->price=$amtConverted;
						$currencyTbl->save(false);
						# code....
					} 
					return "updated";	 
				}//new 
			} 
			die;
 
		}


	public static function currencyconverstion($from_Currency,$to_Currency,$amount) {
		

			$defaultCur = Currency::find()->where(['currencycode'=>$from_Currency])->one();
			if(!empty($defaultCur))
			{
				$defaultCurrencyCode=$defaultCur->currencycode;
				$defaultCurrencyPrice=$defaultCur->price;
				$convertDefault=$amount/$defaultCurrencyPrice;
				$sndCur = Currency::find()->where(['currencycode'=>$to_Currency])->one();
				if(!empty($sndCur))
				{
					$finalAmt=$convertDefault*$sndCur->price;
					$finalAmt=round($finalAmt, 2);
				}
				else
				{
					$url = 'https://www.x-rates.com/calculator/?from='.strtoupper($defaultCurrencyCode).'&to='.strtoupper($to_Currency).'&amount='.$convertDefault;
             $rawdata = file_get_contents($url); 
              $data = explode('ccOutputRslt">', $rawdata);
             $data = explode('</span>', $data[1]);  
             $finalAmt= trim($data[0]); 
				}
				return $finalAmt;

			}		
		 
	}

	public static function getcurrencyprice($currencyCode) {
		$defaultCur = Currency::find()->where(['currencycode'=>$currencyCode])->one();
		if(!empty($defaultCur))
		{		
			$CurrencyPrice=$defaultCur->price;	
			return $CurrencyPrice;
		} else {
			return 1;
		}		
	}

	public static function getcurrencyidprice($currencyId) {
		$defaultCur = Currency::find()->where(['id'=>$currencyId])->one();
		if(!empty($defaultCur))
		{		
			$CurrencyPrice=$defaultCur->price;	
			return $CurrencyPrice;
		} else {
			return 1;
		}		
	} 

	public static function getcurrencydefaultprice() {
		$defaultCur = Currency::find()->where(['defaultcurrency'=>'1'])->one();
		if(!empty($defaultCur))
		{		
			$CurrencyPrice=$defaultCur->price;	
			return $CurrencyPrice;
		} else {
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
	
	public static function getdecimal($details) {
		$details = number_format(round($details,2),2,".","");   // 55.267 to 55.27
		$details = substr($details,0,strpos($details,".") + 3);  // 55.267 to 55.26 
  		return $details;	
	}


	public static function pushnot($deviceToken = NULL, $message = NULL, $badge = NULL, $notifytype="notification"){
		$userdevicedatas = Userdevices::find()->where(['deviceToken'=>$deviceToken])->one();
		if($userdevicedatas->type == 0){
				Myclass::sendall_push_notification($deviceToken,$message,$notifytype,$userdevicedatas->type);
		}else{ 
			Myclass::sendall_push_notification($deviceToken,$message,$notifytype,$userdevicedatas->type);
		}
	}

	public static function sendall_push_notification($registatoin_ids, $message, $notifytype, $device_type) {

		$fcm_url = 'https://fcm.googleapis.com/fcm/send';
		$setting = Sitesettings::find()->where(['id'=> '1'])->one();
		$message = json_encode($message);
		$registatoin_ids = array($registatoin_ids);
		if($device_type == 0) {
			$fcmMsg = array(
				'body' => $message,
				'sound' => "default" 
			);
			$fcmFields = array(
				'registration_ids' => $registatoin_ids,
			   'priority' => 'high',
				'notification' => $fcmMsg
			);
		} elseif ($device_type == 1) {
			$messageToBeSent = array();
			$messageToBeSent['data']['message'] = json_decode($message, true);
			$messageToBeSent['data']['type'] = $notifytype;

			$fcmFields = array(
	             'registration_ids' => $registatoin_ids,
	             'data' => $messageToBeSent
		        );
		}

		$headers = array(
			'Authorization: key=' . $setting->fcmKey,
			'Content-Type: application/json'
		);
		 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, $fcm_url );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
		$result = json_decode(curl_exec($ch));
		curl_close( $ch );
		if($result->success == 1) {

		}

	}




	


}
