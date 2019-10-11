<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Claim;
use backend\models\Claimmessage;
use backend\models\Reservations;
use backend\models\Reservationssearch;
use backend\models\Claimsearch;
use backend\models\Sitesettings;
use backend\models\Userdevices;
use backend\models\Users;
use frontend\models\Logs;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SecurityController implements the CRUD actions for Claim model.
 */
class SecurityController extends Controller
{
    public function behaviors()
    {
        return [
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],*/
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        if (Yii::$app->user->isGuest) {
          return $this->goHome ();
        } 

        return parent::beforeAction($action);
    }
    
    /**
     * Lists all Claim models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Claimsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Claim model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Claim model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Claim();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Claim model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Claim model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionClaimedpayment()
    {
        
        $searchModel = new Claimsearch();
        $dataProvider = $searchModel->searchclaimed(Yii::$app->request->queryParams);

        return $this->render('claimedpayment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionNonrespondedclaimpayment()
    {
        $searchModel = new Claimsearch();
        $dataProvider = $searchModel->searchnonresponded(Yii::$app->request->queryParams);

        return $this->render('nonrespondedclaimpayment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }     
    
    public function actionGuestsecuritypayment()
    {
        $searchModel = new Claimsearch();
        $dataProvider = $searchModel->searchguest(Yii::$app->request->queryParams);

        return $this->render('guestsecuritypayment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }    
    
    public function actionHostsecuritypayment()
    {
        $searchModel = new Claimsearch();
        $dataProvider = $searchModel->searchhost(Yii::$app->request->queryParams);

        return $this->render('hostsecuritypayment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionGuesthostsecuritypayment()
    {
        $searchModel = new Claimsearch();
        $dataProvider = $searchModel->searchguesthost(Yii::$app->request->queryParams);

        return $this->render('guesthostsecuritypayment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }       

    public function actionPayguestsecurity()
    {
        //echo Yii::$app->getUrlManager()->getBaseUrl();
    	$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    	$reserveid = $_POST['reserveid'];
    	$reservation = Reservations::find()->where(['id'=>$reserveid])->one();
    	$hostdata = $reservation->getHost()->where(['id'=>$reservation->hostid])->one();
    	$guestdata = $reservation->getUser0()->where(['id'=>$reservation->userid])->one();
    	$listdata = $reservation->getList()->where(['id'=>$reservation->listid])->one();
    	return $this->renderPartial('payguestsecurity',[
    			'reservation' => $reservation,
    			'hostdata' => $hostdata,
    			'guestdata' => $guestdata,
    			'listdata' => $listdata,
    			'sitesettings' => $sitesettings
    			]);
    }
    
    public function actionPaidguestsecurity($status = null)
    {
        $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    	/*if($status=="paid")
    	{*/
    		$transactionId =  Yii::$app->getRequest()->getQueryParam('tx');
    		$custom =  Yii::$app->getRequest()->getQueryParam('cm');
    		$status =  Yii::$app->getRequest()->getQueryParam('st');
    		if($status=='Completed')
    		{
    			$reservation = Reservations::find()->where(['id'=>$custom])->one();
    			$reservation->sdstatus = 'paid';
    			$reservation->save(false);
                $claimdata = Claim::find()->where(['reservationid'=>$custom])->one();
				if(!empty($claimdata))
				{
					$claimdata->sdstatus = 'paid';
					$claimdata->save(false);
				}

                $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
                $siteName = $sitesetting->sitename;
                $receiverid = $reservation->userid;
                $admindata = Users::find()->where(['username'=>'admin'])->one();
                $senderid = $admindata->id;  
                $models = new Users();
                $receiverdata = $models->findIdentity ( $receiverid ); 
                $email = $receiverdata->email;

                $notifymessage = 'Your accont has been credited by '.$siteName.' for this claim : '.$reservation->id;
                $message = '';
                $logdatas = $this->addlog('adminpayment',$senderid,$receiverid,'',$notifymessage,$message);

                $userdevicedet = Userdevices::find()->where(['user_id'=>$receiverid])->all();
                if(count($userdevicedet) > 0){
                    foreach($userdevicedet as  $userdevice){
                        $deviceToken = $userdevice->deviceToken;
                        $badge = $userdevice->badge;
                        $badge +=1;
                        $userdevice->badge = $badge;
                        $userdevice->deviceToken = $deviceToken;
                        $userdevice->save(false);
                        if(isset($deviceToken)){
                            $messages = 'Your accont has been credited by '.$siteName.' for this claim : '.$reservation->id;
                            Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                        }
                    }
                }

                Yii::$app->mailer->compose ( 'adminpayment', [
                        'name' => $receiverdata->firstname,
                        'siteName' => $siteName,
                        'sitesetting' => $sitesetting,
                        'status' => 'claim',
                        'id' => $reservation->id,
                        ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Admin paid the amount' )->send (); 

    			//Yii::$app->session->setFlash ( 'success', 'Payment Successful' );
                return $this->render('success',[
			   'setngs' => $sitesettings]);    			
    		}
    		else
    		{
    			//Yii::$app->session->setFlash ( 'success', 'Error during transaction.Please try again..' );
                return $this->render('cancelled',[
			   'setngs' => $sitesettings]);   			
    		}
    	//}
    }
    
    public function actionGuestipnprocess()
    {
        
    }
    
    public function actionPayhostsecurity()
    {
        //echo Yii::$app->getUrlManager()->getBaseUrl();
    	$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    	$reserveid = $_POST['reserveid'];
    	$reservation = Reservations::find()->where(['id'=>$reserveid])->one();
    	$hostdata = $reservation->getHost()->where(['id'=>$reservation->hostid])->one();
    	$guestdata = $reservation->getUser0()->where(['id'=>$reservation->userid])->one();
    	$listdata = $reservation->getList()->where(['id'=>$reservation->listid])->one();
    	return $this->renderPartial('payhostsecurity',[
    			'reservation' => $reservation,
    			'hostdata' => $hostdata,
    			'guestdata' => $guestdata,
    			'listdata' => $listdata,
    			'sitesettings' => $sitesettings
    			]);
    }
    
    public function actionPaidhostsecurity($status = null)
    {
        $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    	/*if($status=="paid")
    	{*/
    		$transactionId =  Yii::$app->getRequest()->getQueryParam('tx');
    		$custom =  Yii::$app->getRequest()->getQueryParam('cm');
    		$status =  Yii::$app->getRequest()->getQueryParam('st');
    		if($status=='Completed')
    		{
    			$reservation = Reservations::find()->where(['id'=>$custom])->one();
    			$reservation->sdstatus = 'paid';
    			$reservation->save(false);
                $claimdata = Claim::find()->where(['reservationid'=>$custom])->one();
				if(!empty($claimdata))
				{
					$claimdata->sdstatus = 'paid';
					$claimdata->save(false);
				}

                $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
                $siteName = $sitesetting->sitename;
                $receiverid = $reservation->hostid;
                $admindata = Users::find()->where(['username'=>'admin'])->one();
                $senderid = $admindata->id;  
                $models = new Users();
                $receiverdata = $models->findIdentity ( $receiverid ); 
                $email = $receiverdata->email;

                $notifymessage = 'Your accont has been credited by '.$siteName.' for this claim : '.$reservation->id;
                $message = '';
                $logdatas = $this->addlog('adminpayment',$senderid,$receiverid,'',$notifymessage,$message);

                $userdevicedet = Userdevices::find()->where(['user_id'=>$receiverid])->all();
                if(count($userdevicedet) > 0){
                    foreach($userdevicedet as  $userdevice){
                        $deviceToken = $userdevice->deviceToken;
                        $badge = $userdevice->badge;
                        $badge +=1;
                        $userdevice->badge = $badge;
                        $userdevice->deviceToken = $deviceToken;
                        $userdevice->save(false);
                        if(isset($deviceToken)){
                            $messages = 'Your accont has been credited by '.$siteName.' for this claim : '.$reservation->id;
                            Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                        }
                    }
                }

                Yii::$app->mailer->compose ( 'adminpayment', [
                        'name' => $receiverdata->firstname,
                        'siteName' => $siteName,
                        'sitesetting' => $sitesetting,
                        'status' => 'claim',
                        'id' => $reservation->id,
                        ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Admin paid the amount' )->send ();                 

    			//Yii::$app->session->setFlash ( 'success', 'Payment Successful' );
                return $this->render('success',[
			   'setngs' => $sitesettings]);   			
    		}
    		else
    		{
    			//Yii::$app->session->setFlash ( 'success', 'Error during transaction.Please try again..' );
                return $this->render('cancelled',[
			   'setngs' => $sitesettings]);   			
    		}
    	//}
    }
    
    public function actionHostipnprocess()
    {
        
    }
    
    public function actionPayguesthostsecurity()
    {
    	$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    	if($sitesettings->paymenttype == 'sandbox'){
			$paypalurl = "https://sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=";
			$apiurl = "https://svcs.sandbox.paypal.com/AdaptivePayments/";
    	}else if($sitesettings->paymenttype == 'live'){
			$paypalurl = "https://www.paypal.com/webscr?cmd=_ap-payment&paykey=";
			$apiurl = "https://svcs.paypal.com/AdaptivePayments/";
		}
    	
    	$adminItem = array();
    	$sellerItem = array();
    	$adminCommission = 0;
    	$sellerAmount = 0;
    	
        $reserveid = $_POST['reserveid'];
        $guestamt = $_POST['guestamt'];
        $hostamt = $_POST['hostamt'];
        $reservationdata = Reservations::find()->where(['id'=>$reserveid])->one();
        $userdata = $reservationdata->getUser0()->where(['id'=>$reservationdata->userid])->one();
        $hostdata = $reservationdata->getHost()->where(['id'=>$reservationdata->hostid])->one();
    	$useremail = $userdata->paypalid;
        $selleremail = $hostdata->paypalid;
        $listdata = $reservationdata->getList()->where(['id'=>$reservationdata->listid])->one();
        $claimdata = Claim::find()->where(['reservationid'=>$reserveid])->one();
        $listid = $listdata->id;
        $currency = $reservationdata->currencycode;
        
        
    	$userPrice = $guestamt;
    	$sellerPrice = $hostamt;

    	$userCommission = $userPrice;
    	$sellerAmount = $sellerPrice;
    	
    	$userItem[] = array(
    			"name" => $listdata->listingname,
    			"price" => round($userPrice,2),
    			"itemPrice" => $userPrice,
    			"itemCount" => '1',
    			"identifier" => $listid
    	);
    	$sellerItem[] = array(
    			"name" => $listdata->listingname,
    			"price" => round($sellerPrice,2),
    			"itemPrice" => $sellerPrice,
    			"itemCount" => '1',
    			"identifier" => $listid
    	);
    	
    	$requestEnvelope = array(
    			"errorLanguage" =>"en_US",
    			"detailLevel" => "ReturnAll"
    	);
    	
    	$userAmount = round($userCommission,2);
    	$sellerAmount = round($sellerAmount,2);
        $returnurl = Yii::$app->urlManager->createAbsoluteUrl ('/admin/security/success');
        $cancelurl = Yii::$app->urlManager->createAbsoluteUrl ('/admin/security/cancelled');
        $ipnurl = Yii::$app->urlManager->createAbsoluteUrl ('/admin/security/adaptiveipnprocess');
    	$createPacket = array(
    			"actionType" => "PAY",
    			"currencyCode" => $currency,
    			"receiverList" => array(
    					"receiver" => array(
    							array(
    									"amount" => "$sellerAmount",
    									"email" => "$selleremail",
    									'Primary' => 'true'
    							),                            
    							array (
    									"amount" => "$userAmount",
    									"email" => "$useremail",
    									'Primary' => 'false'
    							)
    					),
    			),
    			"returnUrl" => "".$returnurl."",
    			"cancelUrl" => "".$cancelurl."",
    			"ipnNotificationUrl" => "".$ipnurl."",//'http://dev.hitasoft.com/new/success.php',
    			"memo" => $reserveid,
    			"requestEnvelope" => $requestEnvelope
    	);
    	$result = $this->adaptiveCall($apiurl, $createPacket, "Pay");
    	//echo json_encode($result);die;
    	if ($result['responseEnvelope']['ack'] == 'Success') {
    		$payKey =  $result['payKey'] ;
    		$payDetails = array(
    				"requestEnvelope" => $requestEnvelope,
    				"payKey" => $payKey,
    				"receiverOptions" => array(
    						array(
    								"receiver" => array("email"=>"$selleremail"),
    								"invoiceData" => array(
    										"item" => $sellerItem,
    								)
    						),                        
    						array(
    								"receiver" => array("email"=>"$useremail"),
    								"invoiceData" => array(
    										"item" => $userItem
    								)
    						)
    				),
    	
    		);
    		//echo "<pre>";print_r($payDetails);die;
    		$result = $this->adaptiveCall($apiurl, $payDetails, "SetPaymentOptions");
    		//echo "<pre>";print_r($result);
    		if ($result['responseEnvelope']['ack'] == 'Success') {
    			$packet = array(
    					"requestEnvelope" => $requestEnvelope,
    					"payKey" => $payKey
    			);
    			$result = $this->adaptiveCall($apiurl, $packet, "GetPaymentOptions");
    	
    	
    			//echo "<pre>";print_r($result);die;
    			if ($result['responseEnvelope']['ack'] == 'Success') {
    				echo "<script> window.location = '".$paypalurl.$payKey."';</script>";
    			}else{
    				echo "get payment option  problem";
    			}
    		}else{
    			echo "payment settings problem";
    		}
    	}else{
    		echo "create packet problem";
    	}
    	return false;        
    }
    
	public function adaptiveCall ($apiurl, $data, $action) {
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		$paypalsettings = $sitesetting->paypaladaptive;
		$paypaladaptive = json_decode($paypalsettings,true);         
			$data = json_encode($data);
			$header = array(
					"X-PAYPAL-SECURITY-USERID:".$paypaladaptive['apiUserId']."",
					"X-PAYPAL-SECURITY-PASSWORD:".$paypaladaptive['apiPassword']."",
					"X-PAYPAL-SECURITY-SIGNATURE:".$paypaladaptive['apiSignature']."",
					"X-PAYPAL-APPLICATION-ID:".$paypaladaptive['apiApplicationId']."",
					"X-PAYPAL-REQUEST-DATA-FORMAT:JSON",
					"X-PAYPAL-RESPONSE-DATA-FORMAT:JSON"
			);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $apiurl.$action);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt ( $ch , CURLOPT_SSLVERSION , CURL_SSLVERSION_TLSv1 ) ;
            curl_setopt ( $ch , CURLOPT_SSL_CIPHER_LIST , ' TLSv1 ' ) ;
			//curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
			
			//curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'SSLv3');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			//curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$result = curl_exec($ch);
			/* $info = curl_getinfo($ch);
			
			echo "<pre>";print_r($info);
			if ($result){
				echo $result; */
			if(!curl_errno($ch))
			{
				return json_decode($result,true);
			}else{
				return curl_errno($ch)." - ".curl_error($ch);
			}
		}    
    
	/*
	 * Function to generate the reservation request and instant booking
	 */
    public function actionAdaptiveipnprocess(){
    	$postFields = 'cmd=_notify-validate';
    	$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    	if($sitesettings->paymenttype == 'sandbox'){
    		$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    	}else if($sitesettings->paymenttype == 'live'){
    		$url = 'https://www.paypal.com/cgi-bin/webscr';
    	}
    		
    	$raw_post = file_get_contents("php://input");
    	$raw_post = $this->decodePayPalIPN($raw_post);
    
    	foreach($raw_post as $key => $value)
    	{
    		if ($key == 'transaction') {
    			$transactionCount = count($raw_post['transaction']);
    			foreach ($raw_post['transaction'] as $map => $transaction) {
    				foreach ($transaction as $tranName => $tranValue){
    					$postFields .= "&transaction[".$map."].".$tranName."=".urlencode($tranValue);
    					$keyarray['transaction'][$map][urldecode($tranName)] = urldecode($tranValue);
    				}
    			}
    		}else {
    			$postFields .= "&$key=".urlencode($value);
    			$keyarray[urldecode($key)] = urldecode($value);
    		}
    	}
    
    	$ch = curl_init();
    		
    	curl_setopt_array($ch, array(
    			CURLOPT_URL => $url,
    			CURLOPT_RETURNTRANSFER => true,
    			CURLOPT_SSL_VERIFYPEER => false,
    			CURLOPT_POST => true,
    			CURLOPT_POSTFIELDS => $postFields
    	));
    		
    	$result = curl_exec($ch);
    	curl_close($ch);
    
    	//$keyarray['pay_key']));
    
    	if ($result == 'VERIFIED' && $keyarray['status'] == 'COMPLETED') {
    		if($sitesettings->paymenttype == 'sandbox'){
    			$paypalurl = "https://sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=";
    			$apiurl = "https://svcs.sandbox.paypal.com/AdaptivePayments/";
    		}else if($sitesettings->paymenttype == 'live'){
    			$paypalurl = "https://www.paypal.com/webscr?cmd=_ap-payment&paykey=";
    			$apiurl = "https://svcs.paypal.com/AdaptivePayments/";
    		}
    		$requestEnvelope = array(
    				'errorLanguage' =>"en_US",
    				"detailLevel" => "ReturnAll"
    		);
    		$custom = explode('-_-', $keyarray['memo']);
    		$payKey = $keyarray['pay_key'];
    		$packet = array(
    				"requestEnvelope" => $requestEnvelope,
    				"payKey" => $payKey
    		);
    
    		while(1){
    			$result = $this->adaptiveCall($apiurl, $packet, "GetPaymentOptions");
    			$resultCount = count($result);
    			if($resultCount > 0)
    				break;
    		}
    
    		$currencyCode = explode(' ',$keyarray['transaction'][0]['amount']);
    		$currencycode = $currencyCode[0];
    		
    		$reserveid = $custom[0];
            $reservation = Reservations::find()->where(['id'=>$reserveid])->one();
            $reservation->sdstatus = "paid";
            $reservation->save();
            $claimdata = Claim::find()->where(['reservationid'=>$reserveid])->one();
            $claindata->sdstatus = "paid";
            $claimdata->save(false);

                $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
                $siteName = $sitesetting->sitename;
                $receiverid = $reservation->userid;
                $admindata = Users::find()->where(['username'=>'admin'])->one();
                $senderid = $admindata->id;  
                $models = new Users();
                $receiverdata = $models->findIdentity ( $receiverid ); 
                $email = $receiverdata->email;

                $notifymessage = 'Your accont has been credited by '.$siteName.' for this claim : '.$reservation->id;
                $message = '';
                $logdatas = $this->addlog('adminpayment',$senderid,$receiverid,'',$notifymessage,$message);

                $userdevicedet = Userdevices::find()->where(['user_id'=>$receiverid])->all();
                if(count($userdevicedet) > 0){
                    foreach($userdevicedet as  $userdevice){
                        $deviceToken = $userdevice->deviceToken;
                        $badge = $userdevice->badge;
                        $badge +=1;
                        $userdevice->badge = $badge;
                        $userdevice->deviceToken = $deviceToken;
                        $userdevice->save(false);
                        if(isset($deviceToken)){
                            $messages = 'Your accont has been credited by '.$siteName.' for this claim : '.$reservation->id;
                            Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                        }
                    }
                }

                Yii::$app->mailer->compose ( 'adminpayment', [
                        'name' => $receiverdata->firstname,
                        'siteName' => $siteName,
                        'sitesetting' => $sitesetting,
                        'status' => 'claim',
                        'id' => $reservation->id,
                        ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Admin paid the amount' )->send ();    
                        
                $receiverid = $reservation->hostid;
                $admindata = Users::find()->where(['username'=>'admin'])->one();
                $senderid = $admindata->id;  
                $models = new Users();
                $receiverdata = $models->findIdentity ( $receiverid ); 
                $email = $receiverdata->email;

                $notifymessage = 'Your accont has been credited by '.$siteName.' for this claim : '.$reservation->id;
                $message = '';
                $logdatas = $this->addlog('adminpayment',$senderid,$receiverid,'',$notifymessage,$message);

                $userdevicedet = Userdevices::find()->where(['user_id'=>$receiverid])->all();
                if(count($userdevicedet) > 0){
                    foreach($userdevicedet as  $userdevice){
                        $deviceToken = $userdevice->deviceToken;
                        $badge = $userdevice->badge;
                        $badge +=1;
                        $userdevice->badge = $badge;
                        $userdevice->deviceToken = $deviceToken;
                        $userdevice->save(false);
                        if(isset($deviceToken)){
                            $messages = 'Your accont has been credited by '.$siteName.' for this claim : '.$reservation->id;
                            Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                        }
                    }
                }

                Yii::$app->mailer->compose ( 'adminpayment', [
                        'name' => $receiverdata->firstname,
                        'siteName' => $siteName,
                        'sitesetting' => $sitesetting,
                        'status' => 'claim',
                        'id' => $reservation->id,
                        ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Admin paid the amount' )->send ();                                 
    	}
    }        
    
    public function actionNonclaimedsecuritypayment()
    {
    	$searchModel = new Reservationssearch();
    	$dataProvider = $searchModel->searchnonclaimed(Yii::$app->request->queryParams);
    	
    	return $this->render('nonclaimedsecuritypayment', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			]);    	
    }
    
    /*
     * Function to view the conversation messages between guest and host
     */
    public function actionViewconversation($id)
    {
    	$claimmessages = Claimmessage::find()->where(['claimid'=>$id])->orderBy('id desc')->all();
    	$claimdata = Claimmessage::find()->where(['claimid'=>$id])->one();
    	$userdata = $claimdata->getUser()->where(['id'=>$claimdata->userid])->one();
    	$hostdata = $claimdata->getHost()->where(['id'=>$claimdata->hostid])->one();  
    	return $this->render('viewconversation',[
    			'claimmessages' => $claimmessages,
    			'userdata' => $userdata,
    			'hostdata' => $hostdata,
    			]);
    }
    
    public function actionViewclaimconversation($id)
    {
    	$claimmessages = Claimmessage::find()->where(['claimid'=>$id])->orderBy('id desc')->all();
    	$claimdata = Claimmessage::find()->where(['claimid'=>$id])->one();
    	$userdata = $claimdata->getUser()->where(['id'=>$claimdata->userid])->one();
    	$hostdata = $claimdata->getHost()->where(['id'=>$claimdata->hostid])->one();
    	$claim = Claim::find()->where(['id'=>$id])->one();
    	return $this->render('viewclaimconversation',[
    			'claimmessages' => $claimmessages,
    			'userdata' => $userdata,
    			'hostdata' => $hostdata,
    			'claim' => $claim
    			]);
    }    
    
    public function actionSendadminclaimmessage()
    {
    	$tripid = $_POST['tripid'];
    	$userid = $_POST['userid'];
    	$hostid = $_POST['hostid'];
    	$message = $_POST['messages'];
    	$claimmodel = new Claimmessage();
    	$claimmodel->claimid = $tripid;
    	$claimmodel->userid = $userid;
    	$claimmodel->hostid = $hostid;
    	$claimmodel->message = $message;
    	$claimmodel->sentby = 'Admin';
    	$claimmodel->save();    	
    }
    
    public function actionGetadminclaimmessage()
    {
    	$reserveid = $_POST['reserveid'];
    	$claimmessages = Claimmessage::find()->where(['claimid'=>$reserveid])
    	->orderBy('id desc')
    	->all();
    	$claimdata = Claimmessage::find()->where(['claimid'=>$reserveid])->one();
    	$userdata = $claimdata->getUser()->where(['id'=>$claimdata->userid])->one();
    	$hostdata = $claimdata->getHost()->where(['id'=>$claimdata->hostid])->one();
    	return $this->renderPartial('getadminclaimmessage',[
    			'claimmessages'=>$claimmessages,
    			'userdata' => $userdata,
    			'hostdata' => $hostdata
    			]);
    }    

    public function addlog($logtype,$userid,$notifyto,$listingid,$notifymessage,$message)
    {
        $log = new Logs();
        $log->type = $logtype;
        $log->userid = $userid;
        $log->notifyto = $notifyto;
        $log->listingid = $listingid;
        $log->notifymessage = $notifymessage;
        $log->messageread = '1'; 
        $log->message = $message;
        $log->cdate = time();
        $log->save();
    }    
    
    /**
     * Finds the Claim model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Claim the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Claim::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
