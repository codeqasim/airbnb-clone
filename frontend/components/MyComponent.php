<?php
namespace frontend\components;
 
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use frontend\models\Userdevices;
use frontend\web\PushNotification;
use backend\models\Sitesettings;
use backend\models\Help;
use backend\models\Roomtype;
use backend\models\Currency;
use backend\models\Listingproperties;
 
class MyComponent extends Component
{
	public function productSlug($str) {
		$old = $str;
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '', $str);
		$str = preg_replace('/-+/', "", $str);
		$str = substr($str, 0, 10);
		if(!empty($str))
		return $str;
		else return trim($old);
	}
	public static function getLogo() {
		$id = 1;
		$setting = Sitesettings::find()->where(['id'=>'1'])->one();
		return $setting;
	}
	public static function getHelp() {
		$id = 1;
		$helppages = Help::find('all')->limit('15')->all();
		return $helppages;
	}	
	public static function getRoomtype() {
		$roomtypes = Roomtype::find('all')->all();
		return $roomtypes;
	}	
	public static function getCurrency() {
		$currencies = Currency::find('all')->all();
		return $currencies;
	}
	public static function getListingproperty() {
		$id = 1;
		$listingproperty = Listingproperties::find()->where(['id'=>'1'])->one();
		return $listingproperty;
	}

	public static function pushnot($deviceToken = NULL, $message = NULL, $badge = NULL, $notifytype="notification"){
		$userdevicedatas = Userdevices::find()->where(['deviceToken'=>$deviceToken])->one();
		if($userdevicedatas->type == 0){
			/*$filepath = Yii::getAlias('@frontend'). '/web/certificate/PushNotification.php';
			
				if($userdevicedatas->mode == 1){
							$certifcUrl =  Yii::getAlias('@frontend'). '/web/certificate/joyDevelopment.pem';
							$push = new PushNotification("sandbox",$certifcUrl);
				}else{
							$certifcUrl =  Yii::getAlias('@frontend'). '/web/certificate/joysaleProduction.pem';
							$push = new PushNotification("production",$certifcUrl);
				}
				$push->setDeviceToken($deviceToken);
				$push->setPassPhrase("");
				$push->setBadge($badge);
				$push->setMessageBody($message);
				$push->sendNotification(); */
				
				MyComponent::sendall_push_notification($deviceToken,$message,$notifytype,$userdevicedatas->type);
		}else{
				//MyComponent::send_push_notification($deviceToken, $message);
			MyComponent::sendall_push_notification($deviceToken,$message,$notifytype,$userdevicedatas->type);
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

	/*public static function send_push_notification($registatoin_ids, $message){
	
			$url = 'https://android.googleapis.com/gcm/send';
			$registatoin_ids = array($registatoin_ids);
			$message = array("price" => $message);
			$fields = array(
					'registration_ids' => $registatoin_ids,
					'data' => $message,
			);
		
			$headers = array(
					'Authorization: key=AIzaSyAK--ZYqqD8OjueQb_YB98llQMFIGkCYyw',
					'Content-Type: application/json'
			);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$result = curl_exec($ch);
			if ($result === FALSE) {
				
			}
			$errormsg = curl_error($ch);
			curl_close($ch);
			
	}	 */
 
}
?>