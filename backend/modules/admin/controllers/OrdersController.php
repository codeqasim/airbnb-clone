<?php

namespace backend\modules\admin\controllers;
/*
 * This controller controls all the order related funcions such as payment from admin to host and guest for approved orders, cancelled orders and declined orders
*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
*/
use Yii;
use backend\components\Myclass;
use backend\models\Reservations;
use backend\models\Claim;
use backend\models\Users;
use backend\models\Reservationssearch;
use backend\models\Sitesettings;
use backend\models\Invoices;
use backend\models\Invoicessearch;
use backend\models\Cancellation;
use backend\models\Userdevices;
use backend\models\Listing;
use frontend\models\Logs;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Reservations model.
 */
class OrdersController extends Controller
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
     * Lists all Reservations models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->getSession ()->setFlash ( 'error', 'Invalid access' ); 
            return $this->redirect(['/']); 
       /* $searchModel = new Reservationssearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
    }

    /**
     * Displays a single Reservations model.
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
     * Creates a new Reservations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reservations();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Reservations model.
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
     * Deletes an existing Reservations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /*
     * Function to display the approved reservations
     */
    public function actionApprovedpayment()
    {
        $searchModel = new Reservationssearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('approvedpayment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /*
     * Function to display the paid reservations
     */
    public function actionApprovedorders()
    {
        $searchModel = new Reservationssearch();
        $dataProvider = $searchModel->searchpaid(Yii::$app->request->queryParams);

        return $this->render('approvedorders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /*
     * Function to display the pending reservations
     */
    public function actionPendingorders()
    {
        $searchModel = new Reservationssearch();
        $dataProvider = $searchModel->searchpending(Yii::$app->request->queryParams);

        return $this->render('pendingorders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /*
     * Function to display the invoices for the orders
     */
    public function actionInvoicemanagement()
    {
        $searchModel = new Invoicessearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('invoicemanagement', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }      
    
    /*
     * Function to view the order details
     */
    public function actionVieworder($id)
    {
    	$reservation = Reservations::find()->where(['id'=>$id])->one();
        if(count($reservation) > 0) {
            $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
        	$hostdata = $reservation->getHost()->where(['id'=>$reservation->hostid])->one();
        	$guestdata = $reservation->getUser0()->where(['id'=>$reservation->userid])->one();
        	$listdata = $reservation->getList()->where(['id'=>$reservation->listid])->one();
            
            //listing currency
            $rate2= Myclass::getcurrencyprice($reservation->currencycode);
            //user currency
            $rate= Myclass::getcurrencyprice($reservation->convertedcurrencycode); 

            return $this->render('vieworder', [
                    'model' => $this->findModel($id),
                    'hostdata' => $hostdata,
                    'guestdata' => $guestdata,
                    'listdata' => $listdata,
                    'rate' => $rate,
                    'rate2' => $rate2, 
                    ]);    
        } else {
            Yii::$app->getSession ()->setFlash ( 'error', 'Invalid access' ); 
            return $this->redirect(['/']);   
        } 

    }
    
    /*
     * Function to view the invoice for the order
     */
    public function actionViewinvoice()
    {
        $id = $_POST['orderid'];
    	$reservation = Reservations::find()->where(['id'=>$id])->one();
        $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    	$hostdata = $reservation->getHost()->where(['id'=>$reservation->hostid])->one();
    	$guestdata = $reservation->getUser0()->where(['id'=>$reservation->userid])->one();
        $invoice = $reservation->getInvoices()->where(['orderid'=>$reservation->id])->one();
    	$listdata = $reservation->getList()->where(['id'=>$reservation->listid])->one();
        if($reservation->booking=='pernight'){ 
    	return $this->renderPartial('viewinvoice', [
    			'model' => $this->findModel($id),
    			'hostdata' => $hostdata,
    			'guestdata' => $guestdata,
    			'listdata' => $listdata,
                'invoice' => $invoice
    			]);   
        }
        else if($reservation->booking=='perhour' && $sitesettings->hour_booking=='yes'){
            return $this->renderPartial('viewinvoice', [
                'model' => $this->findModel($id),
                'hostdata' => $hostdata,
                'guestdata' => $guestdata,
                'listdata' => $listdata,
                'invoice' => $invoice
                ]);     
        }
        else
        {
            return $this->renderPartial('viewinvoice', [
                'model' => $this->findMrenderPartialodel($id),
                'hostdata' => $hostdata,
                'guestdata' => $guestdata,
                'listdata' => $listdata,
                'invoice' => $invoice
                ]);  

        } 	
    }    
    
    /*
     * Function to get the values to pay for the host
     */
    public function actionPayapproveorder()
    {
        //echo Yii::$app->getUrlManager()->getBaseUrl();
        $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    	$reserveid = $_POST['reserveid'];
    	$reservation = Reservations::find()->where(['id'=>$reserveid])->one();
    	$hostdata = $reservation->getHost()->where(['id'=>$reservation->hostid])->one();
    	$guestdata = $reservation->getUser0()->where(['id'=>$reservation->userid])->one();
    	$listdata = $reservation->getList()->where(['id'=>$reservation->listid])->one();
    	return $this->renderPartial('payapproveorder',[
    			'reservation' => $reservation,
    			'hostdata' => $hostdata,
    			'guestdata' => $guestdata,
    			'listdata' => $listdata,
                'sitesettings' => $sitesettings
    			]);
    }
    
    /*
     * Function to change the order status as "paid" after the successful payment of admin to the host
     */
    public function actionPaidorders($status = null)
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
    			$reservation->orderstatus = 'paid';
    			$reservation->save();

                $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
                $siteName = $sitesetting->sitename;
                $receiverid = $reservation->hostid;
                $senderid = Yii::$app->user->identity->id;
                $models = new Users();
                $receiverdata = $models->findIdentity ( $receiverid ); 
                $email = $receiverdata->email;

                $notifymessage = 'Your accont has been credited by '.$siteName.' for this approved order : '.$reservation->id;
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
                            $messages = 'Your accont has been credited by '.$siteName.' for this approved order : '.$reservation->id;
                            Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                        }
                    }
                }

                Yii::$app->mailer->compose ( 'adminpayment', [
                        'name' => $receiverdata->firstname,
                        'siteName' => $siteName,
                        'sitesetting' => $sitesetting,
                        'status' => 'approved',
                        'id' => $reservation->id,
                        ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Admin paid the amount' )->send ();                  
               
			  return $this->render('success',[
			   'setngs' => $sitesettings]);    			
    		}
    		else
    		{
			  return $this->render('cancelled',[
			   'setngs' => $sitesettings]);  		
    		}
    	//}
    }
    
    public function actionCancelledpayment()
    {
    	$searchModel = new Reservationssearch();
    	$cancellation = new Cancellation();
    	$policies = Cancellation::find('all')->all();
    	$dataProvider = $searchModel->searchcancelled(Yii::$app->request->queryParams);    	
    	return $this->render('cancelledpayment',[
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'policies' => $policies
    			]);	
    }
    
    public function actionDeclinedpayment()
    {
    	$searchModel = new Reservationssearch();
    	$dataProvider = $searchModel->searchdeclined(Yii::$app->request->queryParams);
    	return $this->render('declinedpayment',[
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,    			
    			]);
    }

    public function actionPaydeclinedorder()
    {
        $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    	$reserveid = $_POST['reserveid'];
    	$reservation = Reservations::find()->where(['id'=>$reserveid])->one();
    	$hostdata = $reservation->getHost()->where(['id'=>$reservation->hostid])->one();
    	$guestdata = $reservation->getUser0()->where(['id'=>$reservation->userid])->one();
    	$listdata = $reservation->getList()->where(['id'=>$reservation->listid])->one();
    	return $this->renderPartial('paydeclinedorder',[
    			'reservation' => $reservation,
    			'hostdata' => $hostdata,
    			'guestdata' => $guestdata,
    			'listdata' => $listdata,
                'sitesettings' => $sitesettings
    			]);    	
    }
    
    public function actionPaiddeclinedorders($status = null)
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
    			$reservation->orderstatus = 'paid';
    			$reservation->save();

                $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
                $siteName = $sitesetting->sitename;
                $receiverid = $reservation->userid;
                $senderid = Yii::$app->user->identity->id;
                $models = new Users();
                $receiverdata = $models->findIdentity ( $receiverid ); 
                $email = $receiverdata->email;

                $notifymessage = 'Your accont has been credited by '.$siteName.' for this declined order : '.$reservation->id;
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
                            $messages = 'Your accont has been credited by '.$siteName.' for this declined order : '.$reservation->id;
                            Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                        }
                    }
                }

                Yii::$app->mailer->compose ( 'adminpayment', [
                        'name' => $receiverdata->firstname,
                        'siteName' => $siteName,
                        'sitesetting' => $sitesetting,
                        'status' => 'declined',
                        'id' => $reservation->id,
                        ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Admin paid the amount' )->send ();               
		
			  return $this->render('success',[
			   'setngs' => $sitesettings]); 
    		}
    		else
    		{
			  return $this->render('cancelled',[
			   'setngs' => $sitesettings]); 
    		}
    	//}
    } 

    public function actionPaidipnprocess()
    {
        $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();

			$postFields = 'cmd=_notify-validate';
			//$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			//$url = 'https://www.paypal.com/cgi-bin/webscr';
			
			if($sitesettings->paymenttype == 'sandbox'){
				$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			}else if($sitesettings->paymenttype == 'live'){
				$url = 'https://www.paypal.com/cgi-bin/webscr';
			}
			
			
			foreach($_POST as $key => $value)
			{
				$postFields .= "&$key=".urlencode(stripslashes($value));
				$keyarray[urldecode($key)] = urldecode($value);
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

			if ($result == 'VERIFIED' && $keyarray['payment_status'] == 'Completed') {
                $custom = $keyarray['custom'];
                $currencyCode = $keyarray['mc_currency'];
                $reservation = Reservations::find()->where(['id'=>$custom])->one();
                $reservation->orderstatus="paid";
                $reservation->save();
            }
    }
    
    public function actionDeclinedipnprocess()
    {
        $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();

			$postFields = 'cmd=_notify-validate';
			//$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			//$url = 'https://www.paypal.com/cgi-bin/webscr';
			
			if($sitesettings->paymenttype == 'sandbox'){
				$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			}else if($sitesettings->paymenttype == 'live'){
				$url = 'https://www.paypal.com/cgi-bin/webscr';
			}
			
			
			foreach($_POST as $key => $value)
			{
				$postFields .= "&$key=".urlencode(stripslashes($value));
				$keyarray[urldecode($key)] = urldecode($value);
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

			if ($result == 'VERIFIED' && $keyarray['payment_status'] == 'Completed') {
                $custom = $keyarray['custom'];
                $reservation = Reservations::find()->where(['id'=>$custom])->one();
                $reservation->orderstatus="paid";
                $reservation->save();
            }    	
    }
    
    public function actionPaycancelledorder()
    {
    	$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    	if($sitesettings->paymenttype == 'sandbox'){
			$paypalurl = "https://sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=";
			$apiurl = "https://svcs.sandbox.paypal.com/AdaptivePayments/";
    	}else if($sitesettings->paymenttype == 'live'){
			$paypalurl = "https://www.paypal.com/webscr?cmd=_ap-payment&paykey=";
			$apiurl = "https://svcs.paypal.com/AdaptivePayments/";
		}
		$baseUrl = Yii::$app->urlManager->createAbsoluteUrl("");
    	$adminItem = array();
    	$sellerItem = array();
        $guestItem = array();
    	$adminCommission = 0;
    	$sellerAmount = 0;
        $guestAmount = 0;
    	
        $reserveid = $_POST['reserveid'];
        $adminamt = $_POST['adminamt'];
        $selleramt = $_POST['selleramt'];
        $guestamt = $_POST['guestamt'];
        $reservationdata = Reservations::find()->where(['id'=>$reserveid])->one();
        $userdata = $reservationdata->getUser0()->where(['id'=>$reservationdata->userid])->one();
        $hostdata = $reservationdata->getHost()->where(['id'=>$reservationdata->hostid])->one();
        
    	$useremail = $userdata->paypalid;
        $selleremail = $hostdata->paypalid;
        $listdata = $reservationdata->getList()->where(['id'=>$reservationdata->listid])->one();
        $listid = $listdata->id;
        $currency = $reservationdata->currencycode;
        $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
        $adminemail = $sitesetting->paypalid;
        
    	$adminPrice = $adminamt;
    	$sellerPrice = $selleramt;
        $guestPrice = $guestamt;

    	$adminCommission = $adminPrice;
    	$sellerAmount = $sellerPrice;
        $guestAmount = $guestPrice;
        //echo $adminCommission."***".$sellerAmount."***".$guestAmount;
        //echo '<br />';
       // echo $adminPrice.'***'.$sellerPrice.'***'.$guestPrice;
    	
    	$adminItem[] = array(
    			"name" => $listdata->listingname,
    			"price" => round($adminPrice,2),
    			"itemPrice" => $adminPrice,
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
    	$guestItem[] = array(
    			"name" => $listdata->listingname,
    			"price" => round($guestPrice,2),
    			"itemPrice" => $guestPrice,
    			"itemCount" => '1',
    			"identifier" => $listid
    	);        
    	
    	$requestEnvelope = array(
    			"errorLanguage" =>"en_US",
    			"detailLevel" => "ReturnAll"
    	);
    	$adminAmount = round($adminCommission,2);
    	$sellerAmount = round($sellerAmount,2);
        $guestAmount = round($guestAmount,2);
        if($sellerAmount!=0)
        {
        	$returnurl = Yii::$app->urlManager->createAbsoluteUrl ('/admin/orders/success');
        	$cancelurl = Yii::$app->urlManager->createAbsoluteUrl ('/admin/orders/cancelled');
        	$ipnurl = Yii::$app->urlManager->createAbsoluteUrl ('/admin/orders/adaptiveipnprocess');        	
            $createPacket = array(
                    "actionType" => "PAY",
                    "currencyCode" => $currency,
                    "receiverList" => array(
                            "receiver" => array(
                                    array (
                                            "amount" => "$adminAmount",
                                            "email" => "$adminemail",
                                            'Primary' => 'false'
                                    ),
                                    array(
                                            "amount" => "$sellerAmount",
                                            "email" => "$selleremail",
                                            'Primary' => 'true'
                                    ),
                                    array(
                                            "amount" => "$guestAmount",
                                            "email" => "$useremail",
                                            'Primary' => 'true'
                                    ),                                
                            ),
                    ),
                    "returnUrl" => "".$returnurl."",
                    "cancelUrl" => "".$cancelurl."",
                    "ipnNotificationUrl" => "".$ipnurl."",//'http://dev.hitasoft.com/new/success.php',
                    "memo" => $reserveid,
                    "requestEnvelope" => $requestEnvelope
            );
        }
        else
        {
            $returnurl = Yii::$app->urlManager->createAbsoluteUrl ('/admin/orders/success');
            $cancelurl = Yii::$app->urlManager->createAbsoluteUrl ('/admin/orders/cancelled');
            $ipnurl = Yii::$app->urlManager->createAbsoluteUrl ('/admin/orders/adaptiveipnprocess');
            $createPacket = array(
                    "actionType" => "PAY",
                    "currencyCode" => $currency,
                    "receiverList" => array(
                            "receiver" => array(
                                    array (
                                            "amount" => "$adminAmount",
                                            "email" => "$adminemail",
                                            'Primary' => 'false'
                                    ),
                                    array(
                                            "amount" => "$guestAmount",
                                            "email" => "$useremail",
                                            'Primary' => 'true'
                                    ),                                
                            ),
                    ),
                    "returnUrl" => "".$returnurl."",
                    "cancelUrl" => "".$cancelurl."",
                    "ipnNotificationUrl" => "".$ipnurl."",//'http://dev.hitasoft.com/new/success.php',
                    "memo" => $reserveid,
                    "requestEnvelope" => $requestEnvelope
            );            
        }
    	$result = $this->adaptiveCall($apiurl, $createPacket, "Pay");
    	//echo json_encode($result);die;
    	if ($result['responseEnvelope']['ack'] == 'Success') {
    		$payKey =  $result['payKey'] ;
            if($sellerAmount!=0)
            {
                $payDetails = array(
                        "requestEnvelope" => $requestEnvelope,
                        "payKey" => $payKey,
                        "receiverOptions" => array(
                                array(
                                        "receiver" => array("email"=>$adminemail),
                                        "invoiceData" => array(
                                                "item" => $adminItem
                                        )
                                ),
                                array(
                                        "receiver" => array("email"=>"$selleremail"),
                                        "invoiceData" => array(
                                                "item" => $sellerItem,
                                        )
                                ),
                                array(
                                        "receiver" => array("email"=>"$useremail"),
                                        "invoiceData" => array(
                                                "item" => $guestItem,
                                        )
                                )                            
                        ),
            
                );
            }
            else
            {
                $payDetails = array(
                        "requestEnvelope" => $requestEnvelope,
                        "payKey" => $payKey,
                        "receiverOptions" => array(
                                array(
                                        "receiver" => array("email"=>$adminemail),
                                        "invoiceData" => array(
                                                "item" => $adminItem
                                        )
                                ),
                                array(
                                        "receiver" => array("email"=>"$useremail"),
                                        "invoiceData" => array(
                                                "item" => $guestItem,
                                        )
                                )                            
                        ),
            
                );                
            }
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
    	}elseif($sitesettings->paymenttype=='live'){
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
    		}elseif($sitesettings->paymenttype=='live'){
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

            $guestamounttotal = explode(' ',$keyarray['transaction'][1]['amount']);
            $guestamount = $guestamounttotal[1];
    		
    		$reserveid = $custom[0];
            $reservation = Reservations::find()->where(['id'=>$reserveid])->one();
            $reservation->orderstatus = "paid";
            $reservation->save();

            $admindata = Users::find()->where(['username'=>'admin'])->one();
            $senderid = $admindata->id;            

            $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
            $siteName = $sitesetting->sitename;

            $guestpayamount = $reservation->total - $reservation->servicefees;
            if($guestpayamount!=$guestamount)
            {
                $hostid = $reservation->hostid;
                $notifymessage = 'Your accont has been credited by '.$siteName.' for this cancelled order : '.$reservation->id;
                $message = '';
                $logdatas = $this->addlog('adminpayment',$senderid,$hostid,'',$notifymessage,$message);            
                
                $userdevicedet = Userdevices::find()->where(['user_id'=>$hostid])->all();
                if(count($userdevicedet) > 0){
                    foreach($userdevicedet as  $userdevice){
                        $deviceToken = $userdevice->deviceToken;
                        $badge = $userdevice->badge;
                        $badge +=1;
                        $userdevice->badge = $badge;
                        $userdevice->deviceToken = $deviceToken;
                        $userdevice->save(false);
                        if(isset($deviceToken)){
                            $messages = 'Your accont has been credited by '.$siteName.' for this cancelled order : '.$reservation->id;
                            Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                        }
                    }
                }            

                
                $reserveuserid = $reservation->hostid;
                $userform = new Users();
                $userdata = $userform->findIdentity ( $reserveuserid ); 
                Yii::$app->mailer->compose ( 'adminpayment', [
                        'name' => $userdata->firstname,
                        'siteName' => $siteName,
                        'status' => 'cancelled',
                        'id' => $reservation->id,
                        'sitesetting' => $sitesetting,
                        ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $userdata->email )->setSubject ( 'Admin paid the amount' )->send ();                   
            }


            $receiverid = $reservation->userid;
            $notifymessage = 'Your accont has been credited by '.$siteName.' for this cancelled order : '.$reservation->id;
            $message = '';
            $logdatas = $this->addlog('adminpayment',$senderid,$receiverid,'',$notifymessage,$message);            
			
            $userdevicedet = Userdevices::find()->where(['user_id'=>$reservation->userid])->all();
            if(count($userdevicedet) > 0){
                foreach($userdevicedet as  $userdevice){
                    $deviceToken = $userdevice->deviceToken;
                    $badge = $userdevice->badge;
                    $badge +=1;
                    $userdevice->badge = $badge;
                    $userdevice->deviceToken = $deviceToken;
                    $userdevice->save(false);
                    if(isset($deviceToken)){
                        $messages = 'Your accont has been credited by '.$siteName.' for this cancelled order : '.$reservation->id;
                        Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                    }
                }
            }            

			
			$reserveuserid = $reservation->userid;
    		$userform = new Users();
    		$userdata = $userform->findIdentity ( $reserveuserid );	
			Yii::$app->mailer->compose ( 'adminpayment', [
					'name' => $userdata->firstname,
                    'siteName' => $siteName,
                    'status' => 'cancelled',
					'id' => $reservation->id,
					'sitesetting' => $sitesetting,
					] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $userdata->email )->setSubject ( 'Admin paid the amount' )->send ();  			
    	}
    }
    
    public function actionSuccess()
    {
		$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
			  return $this->render('success',[
			   'setngs' => $sitesettings]);        
    }
    
    public function actionCancelled()
    {
    	$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    		return $this->render('cancelled',[
    			'setngs' => $sitesettings]);        
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
     * Finds the Reservations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reservations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reservations::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }




   /*** STRIPE PAYMENT ***/
   public function actionCompletereservations() {
      $searchModel = new Reservationssearch();
      $dataProvider = $searchModel->searchcompletereservations(Yii::$app->request->queryParams);
      return $this->render('completereservations',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
   }

   public function actionIncompletereservations() {
      $searchModel = new Reservationssearch();
      $dataProvider = $searchModel->searchincompletereservations(Yii::$app->request->queryParams);
      return $this->render('incompletereservations',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,             
            ]);
   }

   public function actionCompleteclaim() {
      $searchModel = new Reservationssearch();
      $dataProvider = $searchModel->searchcompleteclaim(Yii::$app->request->queryParams);
      return $this->render('completeclaim',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,             
            ]);
   }

   public function actionIncompleteclaim() {
      $searchModel = new Reservationssearch();
      $dataProvider = $searchModel->searchincompleteclaim(Yii::$app->request->queryParams);
      return $this->render('incompleteclaim',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,             
            ]);
   }

   public function actionCancelledorder() {
     /* $rid = base64_decode(trim($_POST['reserveid']));  
      $reservation = Reservations::find()->where(['id'=>$rid])->one();
      $flag = 0; $cancelpercentage = 0; $policies = NULL; $deduct_amount = 0; $host_fund = 0;
      $host_account_id = "";

      if(count($reservation) > 0 && empty($reservation->other_transaction) && empty($reservation->claim_transaction)) {

         $listdata = Listing::find()->where(['id'=>$reservation->listid])->one();
         $reserve_date = date('Y-m-d', $reservation['fromdate']);
         $today_date =  date('Y-m-d', time());

         $diff=date_diff(date_create($today_date),date_create($reserve_date));
         $datediff = $diff->format("%a");

         if(!empty(trim($listdata->cancellation))) {
            $policies = Cancellation::find()->where(['<=','cancelfrom', $datediff])->andwhere(['>=','cancelto', $datediff])->andwhere(['=','id', trim($listdata->cancellation)])->one();
         }

         if($reservation->booking == 'perhour') {
            $total_listingprice = $reservation->pricepernight * $reservation->totalhours;
         } else if($reservation->booking == 'pernight') {
            $total_listingprice = $reservation->pricepernight * $reservation->totaldays;
         } else {
            $total_listingprice = $reservation->pricepernight;
         }

         $reservation_total = round(($reservation->total * $reservation->convertedprice),2);
         $refundpart_one = $reservation_total - ($reservation->sitefees + $total_listingprice);

         if(count($policies) > 0) {
            $cancelpercentage = $policies->cancelpercentage;
            $deduct_amount = round(($total_listingprice * ($cancelpercentage / 100)),2);
            $total_listingprice = $total_listingprice - $deduct_amount;
         } 

         $total_amount = $total_listingprice + $refundpart_one;

         $rate= Myclass::getcurrencyprice($reservation->convertedcurrencycode); //user paid currency 
         $rate2= Myclass::getcurrencyprice($reservation->currencycode); //listing currency
         
         if($reservation->convertedcurrencycode == "JPY" || $reservation->convertedcurrencycode == "jpy"){
            $refund_amount = round(($rate * ($total_amount/$rate2)),2);
            if($deduct_amount > 0) {
                $host_fund = round(($rate * ($deduct_amount/$rate2)),2);
            }
         } else {
            $refund_amount = round(($rate * ($total_amount/$rate2)),2) * 100;
            if($deduct_amount > 0) {
                $host_fund = round(($rate * ($deduct_amount/$rate2)),2) * 100;
            }
         }
         
         //Retrieve Host Details
         $hostData = Users::find()->where(['id'=>$reservation->hostid])->one();

         if($hostData['stripe_status'] == "verified" && $hostData['stripe_account_id'] != NULL && $hostData['stripe_account_id'] != "" && $hostData['stripe_account_info'] != NULL && $hostData['stripe_account_info'] != "") {
            $host_account = json_decode($hostData['stripe_account_id'], true);
            $host_account_id = $host_account['accountid'];
         }

         $invoice = $reservation->getInvoices()->where(['orderid'=>$reservation->id])->one();

         if(!empty($invoice->stripe_transactionid) && $host_account_id!="") {
            $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
        
            \Stripe\Stripe::setApiKey($sitesettings->stripe_secretkey);

            $refund = \Stripe\Refund::create([
               'charge' => $invoice->stripe_transactionid,
               'amount' => $refund_amount,
            ]);
            $striperesult = $refund->jsonSerialize();

            if ($striperesult['status'] == 'succeeded' && !empty($striperesult['id']) && !empty($striperesult['balance_transaction'])) {
               $result['refund_id'] = $striperesult['id'];
               $result['status'] = $striperesult['status'];
               $result['amount'] = $striperesult['amount'];
               $result['type'] = $striperesult['object'];
               $result['charge'] = $striperesult['charge'];
               $result['currency'] = $reservation->convertedcurrencycode;
               $result['percentage'] = $cancelpercentage;
               $result['cdate'] = time();
               $reservation->bookstatus = 'refunded';
               $reservation->orderstatus = 'paid';
               $reservation->sdstatus = 'paid';
               $reservation->other_transaction = json_encode($result);
               $reservation->save();

               if($host_fund > 0) {
                   $cardDetails = json_decode($sitesettings->stripe_card_details, true);
                   $tokJson = \Stripe\Token::create(array(
                     "card" => array(
                       "number" => trim($cardDetails['stripe_card']),
                       "exp_month" => trim($cardDetails['stripe_month']),
                       "exp_year" => trim($cardDetails['stripe_year']),
                       "cvc" => trim($cardDetails['stripe_cvc'])
                     )
                   ));
                   $tok = $tokJson->jsonSerialize();
                   
                   $chargeJson = \Stripe\Charge::create(array(
                     "amount" => $host_fund,
                     "currency" => strtolower($reservation->convertedcurrencycode),
                     "source" => $tok['id'],
                     "destination" => array(
                       "account" => $host_account_id
                     ),
                   ));

                   $striperesult = $chargeJson->jsonSerialize();
                   $result = array();
                   
                   if ($striperesult['status'] == 'succeeded' && !empty($striperesult['id']) && !empty($striperesult['balance_transaction'])) {
                      $result['deduct_id'] = $striperesult['id'];
                      $result['status'] = $striperesult['status'];
                      $result['amount'] = $striperesult['amount'];
                      $result['type'] = $striperesult['object'];
                      $result['currency'] = $reservation->convertedcurrencycode;
                      $result['paid'] = $host_fund;
                      $result['cdate'] = time();
                      $reservation->claim_transaction = json_encode($result);
                      $reservation->save();
                   }
                }
               $flag = 1;
            }  
         }
      }
      echo $flag;*/
      $flag = 0; echo $flag;
   }


      public function actionClaimorder()
      {
        $reserveid = $_POST['reserveid'];
        $status = $_POST['status'];

        $model = new Reservations();
        $reservation = Reservations::find()->where(['id'=>$reserveid])->one();
        $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
        $hostdata = Users::find()->where(['id'=>$reservation->hostid])->one();
        $userdata = Users::find()->where(['id'=>$reservation->userid])->one(); 
        $flag = 0;
       
         if(count($reservation) > 0 && empty($reservation->claim_transaction) && $reservation->bookstatus == "claimed" && $reservation->claim_status == "pending" && $hostdata->stripe_status == "verified" && $reservation->securityfees > 0 && !empty($reservation->securityfees)) {
            
            $host_amount = 0; $guest_amount = 0; $guest_pay=0;

            if($reservation->booking == 'perhour') {
               $total_listingprice = $reservation->pricepernight * $reservation->totalhours;
            } else if($reservation->booking == 'pernight') {
               $total_listingprice = $reservation->pricepernight * $reservation->totaldays;
            } else {
               $total_listingprice = $reservation->pricepernight;
            }
         
            if($status=="approve") {
               $other_amount = $reservation->securityfees + $reservation->taxfees + $reservation->cleaningfees + $reservation->servicefees;
               $total_amount = $total_listingprice + $other_amount;
            } elseif ($status == "decline") {
               $other_amount = $reservation->taxfees + $reservation->cleaningfees + $reservation->servicefees;
               $total_amount = $total_listingprice + $other_amount;

               $guest_amount = $reservation->securityfees; 
            }
            
            $rate = $reservation->convertedprice; 
            
            if($status=="approve") {
               if($reservation->convertedcurrencycode == "JPY" || $reservation->convertedcurrencycode == "jpy"){
                  $host_amount = round(($total_amount/$rate),2);
               } else {
                  $host_amount = round(($total_amount/$rate),2) * 100; 
               }

               $cardDetails = json_decode($sitesetting->stripe_card_details, true);
               \Stripe\Stripe::setApiKey($sitesetting->stripe_secretkey);

               $tokJson = \Stripe\Token::create(array(
                 "card" => array(
                   "number" => $cardDetails['stripe_card'],
                   "exp_month" => $cardDetails['stripe_month'],
                   "exp_year" => $cardDetails['stripe_year'],
                   "cvc" => $cardDetails['stripe_cvc']
                 )
               ));
               $tok = $tokJson->jsonSerialize();
               $host_account_id = json_decode($hostdata->stripe_account_id, true);

               $chargeJson = \Stripe\Charge::create(array(
                 "amount" => $host_amount,
                 "currency" => strtolower($reservation->convertedcurrencycode),
                 "source" => $tok['id'],
                 "destination" => array(
                   "account" => $host_account_id['accountid']
                 ),
               ));

               $striperesult = $chargeJson->jsonSerialize();
               $result = array();
               if ($striperesult['status'] == 'succeeded' && !empty($striperesult['id']) && !empty($striperesult['balance_transaction'])) { 
                  $result['claim_id'] = $striperesult['id'];
                  $result['status'] = $striperesult['status'];
                  $result['amount'] = $striperesult['amount'];
                  $result['type'] = $striperesult['object'];
                  $result['currency'] = $reservation->convertedcurrencycode;
                  $result['cdate'] = time();
                  $result['paid'] = $host_amount;
                  $reservation->bookstatus = 'claimed';
                  $reservation->orderstatus = 'paid';
                  $reservation->sdstatus = 'paid';
                  $reservation->claim_status = 'approved';
                  $reservation->claim_transaction = json_encode($result); 
                  $reservation->save();

                  $usernotifications = json_decode($hostdata->notifications,true);

                  if($usernotifications['reservationnotify'] == 1) {
                     $listingid = $reservation->listid;
                     $userid = Yii::$app->user->identity->id;
                     $hostid = $reservation->hostid;
                     $notifymessage = 'Your claim amount has credited with security deposit';
                     $message = '';
                     $logdatas = $this->addlog('claim',$userid,$hostid,$listingid,$notifymessage,$message);   
                  } 

                  /*$userdevicedet = Userdevices::find()->where(['user_id'=>$hostid])->all();

                  if( count($userdevicedet) > 0 && $hostdata->pushnotification == '1' ){ 
                     foreach($userdevicedet as  $userdevice){
                       $deviceToken = $userdevice->deviceToken;
                       $badge = $userdevice->badge;
                       $badge +=1;
                       $userdevice->badge = $badge;
                       $userdevice->deviceToken = $deviceToken;
                       $userdevice->save(false);
                       if(isset($deviceToken)){
                           $messages = array();
                           $messages['message'] = 'You got reservation from '.$userdata->firstname.' at '.$listdata->listingname;
                           $messages['id'] = $reservation->inquiryid;
                           $messages['type'] = 'reservation';
                           $messages['senderId'] = $reservation->userid;
                           $messages['receiverId'] = $reservation->hostid; 
                           Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                       }
                     }
                  } */

               }
               $flag = 1;
            } elseif ($status == "decline") {

               if($reservation->convertedcurrencycode == "JPY" || $reservation->convertedcurrencycode == "jpy"){
                  $host_amount = round(($total_amount/$rate),2);
                  $guest_pay = round(($guest_amount/$rate),2);
               } else {
                  $host_amount = round(($total_amount/$rate),2) * 100;
                  $guest_pay = round(($guest_amount/$rate),2) * 100;
               } 
               $invoice = $reservation->getInvoices()->where(['orderid'=>$reservation->id])->one();

               \Stripe\Stripe::setApiKey($sitesetting->stripe_secretkey);
               if(!empty($invoice->stripe_transactionid)) {

                  $refund = \Stripe\Refund::create([
                     'charge' => $invoice->stripe_transactionid,
                     'amount' => $guest_pay,
                  ]);
                  $striperesult = $refund->jsonSerialize();
                  $result = array();

                  if ($striperesult['status'] == 'succeeded' && !empty($striperesult['id']) && !empty($striperesult['balance_transaction'])) {
                     $result['refund_id'] = $striperesult['id'];
                     $result['status'] = $striperesult['status'];
                     $result['amount'] = $striperesult['amount'];
                     $result['type'] = $striperesult['object'];
                     $result['charge'] = $striperesult['charge'];
                     $result['currency'] = $reservation->convertedcurrencycode;
                     $result['paid'] = $guest_pay;
                     $result['cdate'] = time();
                     $reservation->bookstatus = 'claimed';
                     $reservation->orderstatus = 'paid';
                     $reservation->sdstatus = 'paid';
                     $reservation->other_transaction = json_encode($result);
                     $reservation->save();

                     $usernotifications = json_decode($userdata->notifications,true);

                     if($usernotifications['reservationnotify'] == 1) {
                        $listingid = $reservation->listid;
                        $userid = Yii::$app->user->identity->id;
                        $notifyid = $reservation->userid;
                        $notifymessage = 'Your security deposit has refunded on your trip';
                        $message = '';
                        $logdatas = $this->addlog('claim',$userid,$notifyid,$listingid,$notifymessage,$message);  
                     } 
                  } 
               }

               $cardDetails = json_decode($sitesetting->stripe_card_details, true);

               $tokJson = \Stripe\Token::create(array(
                 "card" => array(
                   "number" => $cardDetails['stripe_card'],
                   "exp_month" => $cardDetails['stripe_month'],
                   "exp_year" => $cardDetails['stripe_year'],
                   "cvc" => $cardDetails['stripe_cvc']
                 )
               ));
               $tok = $tokJson->jsonSerialize();
               $host_account_id = json_decode($hostdata->stripe_account_id, true);

               $chargeJson = \Stripe\Charge::create(array(
                 "amount" => $host_amount,
                 "currency" => strtolower($reservation->convertedcurrencycode),
                 "source" => $tok['id'],
                 "destination" => array(
                   "account" => $host_account_id['accountid']
                 ),
               )); 

               $striperesult = $chargeJson->jsonSerialize();
               $result = array();
                
               if ($striperesult['status'] == 'succeeded' && !empty($striperesult['id']) && !empty($striperesult['balance_transaction'])) {
                  $result['claim_id'] = $striperesult['id'];
                  $result['status'] = $striperesult['status'];
                  $result['amount'] = $striperesult['amount'];
                  $result['type'] = $striperesult['object'];
                  $result['currency'] = $reservation->convertedcurrencycode;
                  $result['paid'] = $host_amount;
                  $result['cdate'] = time();
                  $reservation->bookstatus = 'claimed';
                  $reservation->orderstatus = 'paid';
                  $reservation->sdstatus = 'paid';
                  $reservation->claim_status = 'declined'; 
                  $reservation->claim_transaction = json_encode($result);
                  $reservation->save();

                  $usernotifications = json_decode($hostdata->notifications,true);

                  if($usernotifications['reservationnotify'] == 1) {
                     $listingid = $reservation->listid;
                     $userid = Yii::$app->user->identity->id;
                     $notifyid = $reservation->hostid;
                     $notifymessage = 'Your claim amount has credited without security deposit';
                     $message = ''; 
                     $logdatas = $this->addlog('claim',$userid,$notifyid,$listingid,$notifymessage,$message);    
                  } 
               } 
             $flag = 1;  
            }
         }
         echo $flag;
      }




}
