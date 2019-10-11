<?php

namespace frontend\modules\user\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */
/* Developer - AK Aslan */
use Yii;
use backend\components\Myclass; 
use frontend\models\Messages;
use frontend\models\Inquiry;
use frontend\models\Listing;
use frontend\models\Users;
use frontend\models\Country;
use frontend\models\Currency; 
use frontend\models\Messagessearch;
use frontend\models\SignupForm;
use frontend\models\Reservations;
use frontend\models\Weekendprice;
use frontend\models\Userdevices; 
use frontend\models\Sitesettings;
use frontend\models\Commission;
use frontend\models\Sitecharge;
use frontend\models\Tax;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * MessagesController implements the CRUD actions for Messages model.
 */
class MessagesController extends Controller
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
    
    public function beforeAction($action)
    {
    	if ($this->action->id == 'getcontactmessage') {
    		Yii::$app->controller->enableCsrfValidation = false;
    	}
    	$model = new SignupForm ();
    	if (!(Yii::$app->user->isGuest)) {
            $loguserid = \Yii::$app->user->identity->id;
            $logUserDetails = Users::find()->where(['id' => $loguserid])->One();
            if(isset($logUserDetails->userstatus)) {
                if($logUserDetails->userstatus == "0") {
                    return $this->redirect(['/']);
                }
            } else {
                return $this->redirect(['/']); 
            }  
        }  


    	return true;
    }   

    /**
     * Lists all Messages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Messagessearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Messages model.
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
     * Creates a new Messages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Messages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Messages model.
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
     * Deletes an existing Messages model.
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
	 * Function to display the messages
	 */
    public function actionInbox($details)
    {
    	if (Yii::$app->user->isGuest) {
    		return $this->goHome ();
    	} else {
            if($details == "traveling" || $details == "hosting") {
                $usertype = trim($details); 
                $msgtype = "all";
            } else {
                $details = explode('*|*', base64_decode($details));
                if(count($details) == 3) {
                    $usertype = trim($details[1]); 
                    $msgtype = trim($details[2]);
                } else {
                    Yii::$app->getSession ()->setFlash ( 'success', 'Not Found' );
                    return $this->redirect(['/dashboard']);
                }
            }

            $loguserid = Yii::$app->user->identity->id;
            if($usertype == "traveling") {
                $allmessages = new \yii\db\Query;
                    $allmessages->select(['count(*)'])
                    ->from('hts_messages')
                    ->leftJoin('hts_inquiry', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.senderid', $loguserid])
                    //->orderBy('hts_inquiry.mdate desc');
                    ->orderBy('hts_messages.cdate desc');

                if($msgtype == "unread") {
                    $query = new \yii\db\Query;
                    $query->select(['hts_inquiry.*','hts_messages.message','hts_messages.messagetype'])
                    ->from('hts_messages')
                    ->leftJoin('hts_inquiry', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.senderid', $loguserid])
                    ->andWhere(['=', 'hts_messages.receiverid', $loguserid]) 
                    ->andWhere(['=', 'hts_messages.receiverread', '0'])
                    //->orderBy('hts_inquiry.mdate desc');
                    ->orderBy('hts_messages.cdate desc');

                } elseif($msgtype == "trips") {
                    $query = new \yii\db\Query;
                    $query->select(['hts_inquiry.*','hts_messages.message','hts_messages.messagetype','hts_reservations.bookstatus'])
                    ->from('hts_inquiry')
                    ->join('INNER JOIN', 'hts_reservations', 'hts_inquiry.id = hts_reservations.inquiryid')
                    ->join('INNER JOIN', 'hts_messages', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.senderid', $loguserid])
                    //->orderBy('hts_inquiry.mdate desc');
                    ->orderBy('hts_messages.cdate desc');

                } elseif($msgtype == "inquiry") {
                    $query = new \yii\db\Query;
                    $query->select(['hts_inquiry.*','hts_messages.message','hts_messages.messagetype'])
                    ->from('hts_inquiry')
                    ->join('INNER JOIN', 'hts_messages', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.senderid', $loguserid])
                    ->andWhere(['=', 'hts_inquiry.type', 'inquiry'])
                    //->orderBy('hts_inquiry.mdate desc');
                    ->orderBy('hts_messages.cdate desc');

                } else {
                    $query = new \yii\db\Query;
                    $query->select(['hts_inquiry.*','hts_messages.message','hts_messages.messagetype'])
                    ->from('hts_messages')
                    ->leftJoin('hts_inquiry', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.senderid', $loguserid])
                    //->orderBy('hts_inquiry.mdate desc');
                    ->orderBy('hts_messages.cdate desc');
                }
            } elseif ($usertype == "hosting") {
                $allmessages = new \yii\db\Query;
                    $allmessages->select(['count(*)'])
                    ->from('hts_messages')
                    ->leftJoin('hts_inquiry', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.receiverid', $loguserid])
                    //->orderBy('hts_inquiry.mdate desc');
                    ->orderBy('hts_messages.cdate desc');

                if($msgtype == "unread") {
                    $query = new \yii\db\Query;
                    $query->select(['hts_inquiry.*','hts_messages.message','hts_messages.messagetype'])
                    ->from('hts_messages')
                    ->leftJoin('hts_inquiry', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.receiverid', $loguserid])
                    ->andWhere(['=', 'hts_messages.receiverid', $loguserid]) 
                    ->andWhere(['=', 'hts_messages.receiverread', '0'])
                    //->orderBy('hts_inquiry.mdate desc');
                    ->orderBy('hts_messages.cdate desc');
                } elseif($msgtype == "reservations") {
                    $query = new \yii\db\Query;
                    $query->select(['hts_inquiry.*','hts_messages.message','hts_messages.messagetype','hts_reservations.bookstatus'])
                    ->from('hts_inquiry')
                    ->join('INNER JOIN', 'hts_reservations', 'hts_inquiry.id = hts_reservations.inquiryid')
                    ->join('INNER JOIN', 'hts_messages', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.receiverid', $loguserid])
                    //->orderBy('hts_inquiry.mdate desc');
                    ->orderBy('hts_messages.cdate desc');

                } elseif($msgtype == "inquiry") {
                    $query = new \yii\db\Query;
                    $query->select(['hts_inquiry.*','hts_messages.message','hts_messages.messagetype'])
                    ->from('hts_inquiry')
                    ->join('INNER JOIN', 'hts_messages', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.receiverid', $loguserid])
                    ->andWhere(['=', 'hts_inquiry.type', 'inquiry'])  
                    //->orderBy('hts_inquiry.mdate desc');
                    ->orderBy('hts_messages.cdate desc');
                } else { 
                    $query = new \yii\db\Query;
                    $query->select(['hts_inquiry.*','hts_messages.message','hts_messages.messagetype'])
                    ->from('hts_messages')
                    ->leftJoin('hts_inquiry', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.receiverid', $loguserid])
                    //->orderBy('hts_inquiry.mdate desc');
                    ->orderBy('hts_messages.cdate desc');  
                }
            } else {
                Yii::$app->getSession ()->setFlash ( 'success', 'Not Found' );
                return $this->redirect(['/dashboard']);
            }
            $countQuery = clone $allmessages;
            $allmessages = $countQuery->createCommand()->queryScalar();

            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>10]);
            $messages = $query->offset($pages->offset)
            ->limit($pages->limit)->createCommand()->queryAll();
        }  	
    
        $exploreListingurl = Yii::$app->urlManager->createUrl(['search/type/anywhere']);    
        
        return $this->render('inbox',[
           'messages' => $messages,
           'loguserid' => $loguserid,
           'exploreUrl' => $exploreListingurl,
           'pages' => $pages,
           'usertype' => $usertype,
           'msgtype' => $msgtype,
           'allmessagescount' => $allmessages
        ]);
    }

    public function actionViewmessage($details)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome ();
        } else {
            $details = base64_decode($details);
            $details = explode(".",$details);

            if(count($details) == 3) { 
                $userType = trim($details[2]);
                $details = trim(hex2bin($details[1]));
                $inquiryData = Inquiry::find()->where(['id'=> $details])->one();
                if(!empty($inquiryData)) {
                    $senderid = trim($inquiryData->senderid);
                    $receiverid = trim($inquiryData->receiverid);
                    $listingid = trim($inquiryData->listingid);

                    $userform = new SignupForm();
			    	$loguserid = Yii::$app->user->identity->id;
			    	$userdata = $userform->findIdentity($loguserid);

			    	if($loguserid == $receiverid || $loguserid == $senderid) { 
			    		$updateReceiver = Messages::find()->Where(['inquiryid'=>$details, 'receiverid'=>$loguserid, 'receiverread'=>0])->count();
			    		if($updateReceiver > 0) {
			    			Messages::updateAll(['receiverread' => 1], ['and',['=', 'receiverid', $loguserid], ['=', 'inquiryid', $details], ['=', 'receiverread', 0]]);
			    		}
			    	} 

			    	$messages = Messages::find()->Where(['listingid'=>$listingid, 'inquiryid'=>$details])->orderBy('cdate desc')->all();

                    $senderdata = Users::find()->where(['id'=>$senderid])->one();
                    $receiverdata = Users::find()->where(['id'=>$receiverid])->one();
						
                    if($loguserid != $receiverid)				
			    	    $otherUser = $inquiryData->receiverid;
                    else 
                        $otherUser = $inquiryData->senderid;

			    	$models = new SignupForm();
			    	$otherUserData = Users::find()->where(['id'=>$otherUser])->one();
			    	$shippingaddress = $otherUserData->getShippingaddresses()->where(['userid'=>$otherUserData->id])->one();
			    	if(isset($shippingaddress) && !empty($shippingaddress)) {
			    		$countryid = $shippingaddress->country;
			    		$countrydata = Country::find()->where(['id'=>$countryid])->one();
			    	} else {
			    		$countrydata = "";
			    	}

                    //Reservation and Inquiry Details.
                    $reservations = Reservations::find()->where(['inquiryid'=>$inquiryData->id])
                    ->andWhere(['=','userid',$inquiryData->senderid])
                    ->andWhere(['=','hostid',$inquiryData->receiverid])
                    ->andWhere(['=','listid',$inquiryData->listingid])
                    ->one();


                    //Any guest Done reservation on requested day
                    $reservelistdata = Listing::find()->where(['id'=>$listingid])->one();
                    $reservedurationType = trim($reservelistdata->booking);
                    $status = array('accepted','claimed','requested');

                    if($reservedurationType == "pernight") {
                        $s_datetime = strtotime(date('m/d/Y', strtotime($inquiryData->checkin)));
                        $e_datetime = strtotime(date('m/d/Y', strtotime($inquiryData->checkout.'-1 days'))); 
                        $otherguestreservations = Reservations::find()->where(['listid'=>$inquiryData->listingid])

                        ->andWhere(['or', ['between','fromdate',$s_datetime, $e_datetime], ['between','todate', $s_datetime, $e_datetime], ['and', ['between','fromdate',$s_datetime, $e_datetime], ['between','todate', $s_datetime, $e_datetime]]])   

                        //->andWhere(['=','fromdate',$s_datetime])
                        //->andWhere(['=','todate',$e_datetime]) 
                        ->andWhere(['IN','bookstatus', $status])
                        ->one();
                    } else {
                        $s_datetime = $inquiryData->checkin;
                        $e_datetime = $inquiryData->checkout;

                        $otherguestreservations = Reservations::find()->where(['listid'=>$inquiryData->listingid])
                        ->andWhere(['=','checkin',$s_datetime])
                        ->andWhere(['=','checkout',$e_datetime])
                        ->andWhere(['IN','bookstatus', $status])
                        ->one();
                    } 
 
                    $weekend_count = 0;
                    $totalpercent = 0;
                    $listtotalprice = 0;
                    $weekendTotalFee = 0;
                    $commissionamount = 0;
                    $siteamount = 0;

                    $listpricearray = array();
                    $pricearray = array();
                    $resultarray = array();
                   // $pricearray['special'] = NULL;
                    $pricearray['weekend_price'] = 0;
                    $pricearray['weekend_count'] = 0;
                    $pricearray['normal_price'] = 0;
                    $pricearray['normal_count'] = 0;
                    $pricearray['special_price'] = 0; 
                    $pricearray['special_count'] = 0; 
                    $guestPayed = NULL; 
                    $blockStatus = "disabled";

                    if(count($reservations) == 0) {
                        $listdata = Listing::find()->where(['id'=>$listingid])->one();
                        $durationType = $listdata->booking;
                        $viewType = "Inquiry";

                        if($listdata->booking == "perhour") {
                            $start_date = date('m/d/Y', strtotime($inquiryData->checkin));
                            $end_date = date('m/d/Y', strtotime($inquiryData->checkout));
                            $fromtime = strtotime($inquiryData->checkin);
                            $totime = strtotime($inquiryData->checkout);
                            $total_period = round(($totime - $fromtime)/3600, 1);
                        } else {
                            $start_date = date('m/d/Y', strtotime($inquiryData->checkin));
                            $end_date = date('m/d/Y', strtotime($inquiryData->checkout));
                            $total_period = strtotime($end_date) - strtotime($start_date);
                            $total_period =  round($total_period / (60 * 60 * 24));
                        }

                        $blockPrice = ($listdata->blockedspecialprice!="" && $listdata->blockedspecialprice != NULL) ? json_decode($listdata->blockedspecialprice) : NULL;

                        if(count($blockPrice) > 0) {
                            $count=count($blockPrice);
                            $blockedCount = 0;
                            for($i=0; $i<$count; $i++) {
                                $cell = $blockPrice[$i];

                                if($cell->liststatus == 'blocked') {
                                    $night_date = ($listdata->booking == "pernight") ? date("m/d/Y",strtotime($end_date.'-1 days')) : $end_date;

                                    for ($pDate=strtotime($start_date); $pDate <= strtotime($night_date); $pDate+=86400) {
                                        if($pDate >= strtotime($cell->specialstartDate) && $pDate <= strtotime($cell->specialendDate)) {
                                            ++$blockedCount;
                                        }
                                    }
                                }
                            }

                            if($blockedCount > 0) {
                                $blockStatus = "enabled";
                            }
                        }

                        $total_days = $total_period;
                        $weDate = ($listdata->booking == "pernight") ? date("m/d/Y",strtotime($end_date.'-1 days')) : $end_date;

                        for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) {
                            $a_day = (strtolower(date('l', $pDate))); 
                            if($a_day == "friday" || $a_day == "saturday") {
                                ++$weekend_count;
                            }
                        }

                        if($listdata->splpricestatus == 1 && !empty($listdata->specialprice) && count($listdata->specialprice) > 0) {
                            for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) {
                                $specialPriceVal = json_decode($listdata->specialprice);

                                foreach ($specialPriceVal as $akey => $splVal) {
                                    $a_startdate = strtotime(trim($splVal->specialstartDate));
                                    $a_enddate = strtotime(trim($splVal->specialendDate));

                                    if ($a_startdate==$pDate || $a_enddate==$pDate || ($pDate>$a_startdate && $pDate<$a_enddate)) {
                                        $a_day = (strtolower(date('l', $pDate))); 
                                        if($a_day == "friday" || $a_day == "saturday") {
                                            --$weekend_count;
                                        }
                                        $listpricearray[count($listpricearray)] = trim($splVal->specialprice);
                                        //$pricearray['special'][count($pricearray['special'])]['date'] = $pDate; 
                                      //$pricearray['special'][count($pricearray['special'])]['price'] = trim($splVal->specialprice);
                                    } 
                                }
                            }
                        }

                        if($listdata->weekendprice == 1 && $weekend_count > 0)  {
                            $weekendData = Weekendprice::find()->where(['listid'=>$listdata->id])->one();
                            if(count($weekendData) > 0) {
                                if($listdata->booking == "perhour" && $listdata->hourlyprice != NULL)
                                    $weekendTotalFee = $weekendData->weekend_price * $total_days;
                                else
                                    $weekendTotalFee = $weekendData->weekend_price * $weekend_count;

                                $pricearray['weekend_price'] = $weekendTotalFee;
                                $pricearray['weekend_count'] = $weekend_count;
                            }
                        }   

                        if($listdata->splpricestatus == 1 && count($listpricearray) > 0) {
                            
                            if($listdata->booking == "perhour" && $listdata->hourlyprice != NULL) {
                                $listtotalprice = $listtotalprice + (array_sum($listpricearray) * $total_days);
                                $pricearray['special_price'] = array_sum($listpricearray); 
                                $pricearray['special_count'] = $total_days;
                                $total_days = 0;
                            } else {
                                $total_days = $total_days - count($listpricearray);
                                $listtotalprice = $listtotalprice + array_sum($listpricearray);
                                $pricearray['special_price'] = array_sum($listpricearray);
                                $pricearray['special_count'] = count($listpricearray);
                            }

                            
                        }
                        if($listdata->weekendprice == 1 && $weekend_count > 0) {
                            if($listdata->booking == "perhour" && $listdata->hourlyprice != NULL)
                                $total_days = 0;
                            else
                                $total_days = $total_days - $weekend_count;

                            $listtotalprice = $listtotalprice + $weekendTotalFee;
                        }
                        if($total_days > 0) {
                            if($listdata->booking == "perhour" && $listdata->hourlyprice != NULL) {
                                $normalprice = $total_days * $listdata->hourlyprice;
                            } else {
                                $normalprice = $total_days * $listdata->nightlyprice;
                            }

                            $listtotalprice = $listtotalprice + $normalprice;

                            $pricearray['normal_price'] = $normalprice;   
                            $pricearray['normal_count'] = $total_days; 

                        }

                        if(count($listpricearray) == 0 && $weekend_count == 0) {
                            $unitprice = ($listdata->booking == "perhour") ? $listdata->hourlyprice : $listdata->nightlyprice;      
                        } else {
                            $unitprice = round(($listtotalprice / $total_period),2);
                        }
                     
                        $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();

                        $commissiondatas = Commission::find('all')->all();
                        $sitecharges = Sitecharge::find('all')->all();
                        $taxdatas = Tax::find()->where(['countryid'=>$listdata->country])->all();
                        
                        foreach($commissiondatas as $commission) {
                            $minval = $commission->min_value;
                            $maxval = $commission->max_value;
                            if($unitprice>=$minval && $unitprice<=$maxval) {
                                $percentage = $commission->percentage;
                                $commissionamount = ($unitprice * $percentage) / 100;
                            }
                        }

                        foreach($sitecharges as $sitecharge) {
                            $min_val = $sitecharge->min_value;
                            $max_val = $sitecharge->max_value;
                            if($listtotalprice>=$min_val && $listtotalprice<=$max_val) {
                                $percent = $sitecharge->percentage;
                                $siteamount = ($listtotalprice * $percent) / 100;
                            }  
                        }
                        
                        if(count($taxdatas) > 0) {
                            foreach($taxdatas as $tax) {
                                $totalpercent += $tax->percentage;
                            }
                        }

                        $taxamount = ($listtotalprice * $totalpercent) / 100;

                        $securitydeposit = ($listdata->securitydeposit >= 0) ? $listdata->securitydeposit : 0; 
                        $cleaningfees = ($listdata->cleaningfees >= 0) ? $listdata->cleaningfees : 0; 
                        $servicefees = ($listdata->servicefees >= 0) ? $listdata->servicefees : 0; 

                        $currencydata = Currency::find()->where(['id'=>$listdata->currency])->one();
                    } else {
                        
                        $start_date = date('m/d/Y', $reservations->fromdate);
                        $end_date = date('m/d/Y', $reservations->todate);
                        $durationType = $reservations->booking; 
                        $viewType = "Reservation";

                        if($reservations->booking == "pernight") {
                            $listtotalprice = $reservations->pricepernight * $reservations->totaldays;
                            $total_period = $reservations->totaldays;
                        } else {
                            $listtotalprice = $reservations->pricepernight * $reservations->totalhours;
                            $total_period = $reservations->totalhours;
                        }

                        $unitprice = $reservations->pricepernight;

                        if($reservations->pricedetails !="" && $reservations->pricedetails !=NULL) {
                            $r_check = json_decode($reservations->pricedetails, true);

                            $pricearray['normal_price'] = $r_check['normal']['price'];  
                            $pricearray['normal_count'] = $r_check['normal']['days']; 
                            $pricearray['special_price'] = $r_check['special_price'];
                            $pricearray['special_count'] = $r_check['special_count'];
                            $pricearray['weekend_price'] = $r_check['week']['price'];
                            $pricearray['weekend_count'] = $r_check['week']['days'];

                            /*foreach ($r_check['special'] as $key => $value) {
                                if(trim($value['price']) > 0 && trim($value['price'])!="") {
                                    $listpricearray[count($listpricearray)] = $value['price'];
                                }
                            }
                            echo array_sum($listpricearray)."<br><BR>".count($listpricearray); */
                        }

                        $commissionamount = $reservations->commissionfees;
                        $siteamount = $reservations->sitefees;
                        $taxamount = $reservations->taxfees;
                        $securitydeposit = ($reservations->securityfees >= 0) ? $reservations->securityfees : 0;  
                        $cleaningfees = ($reservations->cleaningfees >= 0) ? $reservations->cleaningfees : 0; 
                        $servicefees = ($reservations->servicefees >= 0) ? $reservations->servicefees : 0; 

                        $guestPayed = $reservations->convertedcurrencycode." ".$reservations->total;

                        $currencydata = Currency::find()->where(['currencycode'=>$reservations->currencycode])->one();

                        $resultarray['reserveStatus'] = $reservations->bookstatus;
                        $resultarray['reserveType'] = $reservations->booktype;
                    }

                    if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="") {
                       $currency_code = $_SESSION['currency_code'];
                       $currency_symbol = $_SESSION['currency_symbol'];

                       //listing currency
                       $rate2= Myclass::getcurrencyprice($currencydata->currencycode);
                       //user currency
                       $rate= Myclass::getcurrencyprice($currency_code); 
                    } else {
                       $rate = "1";    $rate2 = "1";
                       $currency_code = $currencydata->currencycode;
                       $currency_symbol = $currencydata->currencysymbol;
                    }

                    //To check the amount before the conversion happen proceed here.

                    //Price Conversion Calculation;
                    $pricearray['normal_price'] = round($rate * ($pricearray['normal_price']/$rate2),2);
                    $pricearray['special_price'] = round($rate * ($pricearray['special_price']/$rate2),2);
                    $pricearray['weekend_price'] = round($rate * ($pricearray['weekend_price']/$rate2),2);

                    $taxamount = round($rate * ($taxamount/$rate2),2);
                    $siteamount = round($rate * ($siteamount/$rate2),2);
                    $commissionamount = round($rate * ($commissionamount/$rate2),2);
                    $securitydeposit = round($rate * ($securitydeposit/$rate2),2);
                    $servicefees = round($rate * ($servicefees/$rate2),2);
                    $cleaningfees = round($rate * ($cleaningfees/$rate2),2);
                    
                    $listtotalprice = round($rate * ($listtotalprice/$rate2),2);
                    $unitprice = round($rate * ($unitprice/$rate2),2); 

                    $grandTotal = $taxamount + $siteamount + $commissionamount + $listtotalprice + $securitydeposit + $servicefees + $cleaningfees;

                    //$grandTotal = Myclass::getdecimal($rate * ($grandTotal/$rate2));
                    // Price Calculation Ends 

                    $resultarray['grandTotal'] = $grandTotal;  

                    $resultarray['guestPayed'] = $guestPayed;
                    $resultarray['totalDays'] = $total_period;
                    $resultarray['durationType'] = $durationType;
                    $resultarray['viewType'] = $viewType;
                    $resultarray['totalListingPrice'] = $listtotalprice;
                    $resultarray['unitPrice'] = $unitprice;
                    $resultarray['totalPriceList'] = $pricearray;
                    
                    $resultarray['commissionAmount'] = $commissionamount;
                    $resultarray['siteAmount'] = $siteamount;
                    $resultarray['taxAmount'] = $taxamount;
                    $resultarray['securityDeposit'] = $securitydeposit;
                    $resultarray['cleaningFees'] = $cleaningfees;
                    $resultarray['serviceFees'] = $servicefees; 
                    
                    $resultarray['currencyCode'] = $currency_code;
                    $resultarray['currencySymbol'] = $currency_symbol;

			        return $this->render('viewmessage',[
			        		'loguserid' => $loguserid,
			        		'userdata' => $userdata,
			        		'id' => $listingid,
                            'listdata' => $reservelistdata, 
			        		'message' => $inquiryData,
							'senderid' => $senderid,
							'receiverid' => $receiverid,
			        		'otherUserData' => $otherUserData,
                            'reservations' => $reservations,
			        		'shippingaddress' => $shippingaddress,
			        		'countrydata' => $countrydata,
                            'senderdata' => $senderdata,
                            'receiverdata' => $receiverdata,
                            'messages' => $messages,
                            'inquiryId' => $details,
                            'resultarray' => $resultarray,
                            'blockStatus' => $blockStatus,  
                            'otherguestreservations' => $otherguestreservations,
                            'userType' => $userType  
			        		]);
                } else {
                    Yii::$app->getSession ()->setFlash ( 'success', 'Not Found' );
                    return $this->redirect(['inbox', 'details' => 'traveling']);
                }
            } else {

                if(isset($details[2]) && (trim($details[2])=="traveling" || trim($details[2])=="hosting")) {  
                    Yii::$app->getSession ()->setFlash ( 'success', 'Not Found' );
                    return $this->redirect(['/user/messages/inbox/'.$details[2]]);  
                } else {
                    Yii::$app->getSession ()->setFlash ( 'success', 'Invalid access' );
                    return $this->goHome ();  
                }
            }
        } 	
    }
    /*
     * Function to update all the messages
    */
    public function actionUpdatemessage() 
    {
        if (Yii::$app->user->isGuest) {
            echo "failed";
        } else if(count($_POST) <= 0 || count($_POST) > 5) {
            echo "failed";
        } else {
            if(Yii::$app->request->isAjax){
                $senderid = trim($_POST['senderid']);
                $receiverid = trim($_POST['receiverid']);
                $listingid = trim($_POST['listingid']);
                $inquiryid = trim($_POST['inquiryid']);
                $messages = trim($_POST['message']);
                $loguserid = Yii::$app->user->identity->id;

                $senderdata = Users::find()->where(['id'=>$senderid])->one();
                $receiverdata = Users::find()->where(['id'=>$receiverid])->one(); 

                $logUserImg =$senderdata->profile_image;
                if($logUserImg==""){
                    $logUserImg = "usrimg.jpg";
                }

                $logUserImg = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$logUserImg);
                $resize_logUserImg = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$logUserImg.'&w=60&h=60'); 
                $senderurl = base64_encode($senderid."-".rand(0,999));

                $outputData['profileURL'] = Yii::$app->urlManager->createAbsoluteUrl('/profile/'.$senderurl);
                $outputData['userImg'] = $resize_logUserImg;
                $outputData['userName'] = $senderdata->firstname; 
                $outputData['newMessage'] = $messages; 
                $outputData['loguserid'] = $loguserid;
                $outputData['senderid'] = $senderdata->id;
                $outputData['receiverid'] = $receiverdata->id;
                $outputData['date'] = date('d,M Y',strtotime(date('Y-m-d H:i:s'))); 

                if($loguserid == $receiverid) { 
                    $updateReceiver = Messages::find()->Where(['inquiryid'=>$inquiryid, 'receiverid'=>$receiverid, 'receiverread'=>0])->count();
                    if($updateReceiver > 0) {
                        Messages::updateAll(['receiverread' => 1], ['and',['=', 'receiverid', $receiverid], ['=', 'inquiryid', $inquiryid], ['=', 'receiverread', 0]]);
                    }
                }

                echo json_encode($outputData);
                die;
            }
        }

    }
	/*
	 * Function to view all the messages
	 */
    public function actionSendmessage() 
    { 
        if (Yii::$app->user->isGuest) {
            echo "0";
        } else if(count($_POST) <= 0 || count($_POST) > 5) {
            echo "0";
        } else {
            $senderid = trim($_POST['senderid']);
            $receiverid = trim($_POST['receiverid']);
            $messages = trim($_POST['messages']);
            $listingid = trim($_POST['listingid']);
            $inquiryid = trim($_POST['inquiryid']);

            $loguserid = Yii::$app->user->identity->id;

            $listingdata = Listing::find()->where(['id'=>$listingid])->one();
            $inquiryData = Inquiry::find()->Where(['and',
                                        ['senderid'=> $senderid],
                                        ['receiverid'=> $receiverid]])
                                    ->orFilterWhere(['and',
                                        ['senderid'=> $receiverid],
                                        ['receiverid'=> $senderid]])
                                    ->andFilterWhere(['listingid'=>$listingid])
                                    ->andFilterWhere(['id'=>$inquiryid])
                                    ->one();

            if(count($inquiryData) > 0) {
                $signupmodel = new SignupForm();
                $userdevicedet = Userdevices::find()->where(['user_id'=>$receiverid])->all();
                $senderdata = $signupmodel->findIdentity($senderid);

                $receiverdata = $signupmodel->findIdentity($receiverid);
                
                if($receiverdata->pushnotification == "1") {
                    if(count($userdevicedet) > 0) {
                        foreach($userdevicedet as  $userdevice) {
                            $deviceToken = $userdevice->deviceToken;
                            $badge = $userdevice->badge;
                            $badge +=1;
                            $userdevice->badge = $badge;
                            $userdevice->deviceToken = $deviceToken;
                            $userdevice->save(false);
                            if(isset($deviceToken)){
                                 $pushmessages = array();
                                $pushmessages['message'] = $senderdata->firstname.' sent you a message';
                                 $pushmessages['id'] = $inquiryid;
                                 $pushmessages['type'] = 'chat';
                                 $pushmessages['senderId'] = $senderid;
                                 $pushmessages['receiverId'] = $receiverid;  
                                Yii::$app->mycomponent->pushnot($deviceToken,$pushmessages,$badge); 
                            }
                        }
                    }
                }                

                $contactmessage = new Messages();
                $contactmessage->inquiryid = $inquiryid;
                $contactmessage->senderid = $senderid;
                $contactmessage->receiverid = $receiverid;
                $contactmessage->listingid = $listingid;
                $contactmessage->message = $messages; 
                $contactmessage->receiverread = 0;
                $contactmessage->messagetype = "user";
                $contactmessage->cdate = date('Y-m-d H:i:s');
                $contactmessage->save(false); 

                $inquiryData = Inquiry::find()->where(['id'=>$inquiryData->id])->one();
                $inquiryData->lastmessageid = $contactmessage->id;
                $inquiryData->save(false);
                
                $senderdata = Users::find()->where(['id'=>$senderid])->one();
                $receiverdata = Users::find()->where(['id'=>$receiverid])->one(); 
                $baseUrl = Yii::$app->request->baseUrl;
                $adminimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');

                $logUserDetails = Users::find()->where(['id' => $loguserid])->One();
                $logUserImg =$logUserDetails->profile_image;
                if($logUserImg==""){
                    $logUserImg = "usrimg.jpg";
                }

                $logUserImg = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$logUserImg);
                $resize_logUserImg = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$logUserImg.'&w=60&h=60'); 
                $senderurl = base64_encode($loguserid."-".rand(0,999));

                $outputData['profileURL'] = Yii::$app->urlManager->createAbsoluteUrl('/profile/'.$senderurl);
                $outputData['userImg'] = $resize_logUserImg;
                $outputData['userName'] = $logUserDetails->firstname;
                $outputData['newMessage'] = $messages;  
                $outputData['loguserid'] = $loguserid;
                $outputData['senderid'] = $senderdata->id;
                $outputData['receiverid'] = $receiverdata->id;
                $outputData['date'] = date('d,M Y',strtotime(date('Y-m-d H:i:s')));
                $outputData['time'] = strtotime(date('Y-m-d H:i:s'));    // For App    

                echo json_encode($outputData);
            } else {
                echo "0";
            }
        }
          	
    }
	
	/*
	 * Function to view all the admin messages
	 */ 
	public function actionAdminviewmessage($details)
	{
		if (Yii::$app->user->isGuest) {
			return $this->goHome ();
		}
		$ids = base64_decode($details);
		$idval = explode("_",$ids);
		$adminid = $idval[0];
		$receiverid = $idval[1];
		
    	$userform = new SignupForm();
    	$loguserid = Yii::$app->user->identity->id;
    	$userdata = $userform->findIdentity ( $loguserid );		
		$messages = Messages::find()->where(['senderid'=>$adminid,'receiverid'=>$receiverid])->orderBy('id desc')->all();
    	foreach($messages as $msg)
    	{
			if($loguserid==$msg->receiverid)
			{
				$msg->receiverread = 1;
				$msg->save();
			}
    	}
		$message = Messages::find()->where(['senderid'=>$adminid,'receiverid'=>$receiverid])->one();
        return $this->render('adminviewmessage',[
        		'messages' => $messages,
        		'userdata' => $userdata,
        		'message' => $message,
				'senderid' => $adminid,
				'receiverid' => $receiverid
        		]);		
	}
    
    public function actionGetcontactmessage()
    {
    	$listingid = $_POST['listingid'];
		$senderid = $_POST['senderid'];
		$receiverid = $_POST['receiverid'];
    	$loguserid = Yii::$app->user->identity->id;
    	$messages = Messages::find()->Where(['and',
										['senderid'=> $senderid],
										['receiverid'=> $receiverid]])
									->orFilterWhere(['and',
										['senderid'=> $receiverid],
										['receiverid'=> $senderid]])
									->andFilterWhere(['listingid'=>$listingid])
									->orderBy('id desc')
									->all();
    	$message = Messages::find()->Where(['and',
										['senderid'=> $senderid],
										['receiverid'=> $receiverid]])
									->orFilterWhere(['and',
										['senderid'=> $receiverid],
										['receiverid'=> $senderid]])	
									->andFilterWhere(['listingid'=>$listingid])
    							   ->one();
    	$senderdata = $message->getSender()->where(['id'=>$message->senderid])->one();
    	$receiverdata = $message->getReceiver()->where(['id'=>$message->receiverid])->one(); 
    	return $this->renderPartial('getcontactmessage',[
    			'messages' => $messages,
    			'loguserid' => $loguserid,
    			'senderdata' => $senderdata,
    			'receiverdata' => $receiverdata
    			]);
    	
    }
	
	public function actionGetadmincontactmessage()
	{
		$senderid = $_POST['senderid'];
		$receiverid = $_POST['receiverid'];
		$messages = Messages::find()->where(['senderid'=>$senderid,'receiverid'=>$receiverid])->orderBy('id desc')->all();
		$message = Messages::find()->where(['senderid'=>$senderid,'receiverid'=>$receiverid])->one();
		$senderdata = $message->getSender()->where(['id'=>$message->senderid])->one();
		$receiverdata = $message->getReceiver()->where(['id'=>$message->receiverid])->one();
    	return $this->renderPartial('getadmincontactmessage',[
    			'messages' => $messages,
    			'senderdata' => $senderdata,
    			'receiverdata' => $receiverdata
    			]);
	}
    
    public function actionGetmessages()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome ();
        } else {
        	$loguserid = Yii::$app->user->identity->id;

            if(isset($_POST['msgtype']) && isset($_POST['usertype'])) {
                $_SESSION['msgtype'] = trim($_POST['msgtype']);
                $_SESSION['usertype'] = trim($_POST['usertype']);
                echo "success";
            } else {
                $_SESSION['msgtype'] = "";
                $_SESSION['usertype'] = "";
                echo "failed";
            }   
        }
    } 

    /**
     * Finds the Messages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Messages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Messages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
