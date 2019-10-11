<?php

namespace frontend\modules\user\controllers;
/*
* This controller controls all the listing related functions such as add listing, manage reservations, payment for the reservation
*
* @Company: Hitasoft Technology Solutions Private Limited
* @Framework : Yii
* @Version: 2.0
*/
use Yii;
use backend\components\Myclass;
use frontend\models\Listing;
use frontend\models\Listingsearch; 
use frontend\models\SignupForm;
use frontend\models\Additionalamenities;
use frontend\models\Commonamenities;
use frontend\models\Hometype;
use frontend\models\Roomtype;
use frontend\models\Listingproperties;
use frontend\models\Safetycheck;
use frontend\models\Specialfeatures;
use frontend\models\Country;
use frontend\models\Currency;
use frontend\models\Photos;
use frontend\models\Commonlisting;
use frontend\models\Additionallisting;
use frontend\models\Speciallisting;
use backend\models\Profilereports;
use backend\models\Userreports;
use frontend\models\Safetylisting;
use frontend\models\Commission;
use frontend\models\Sitecharge;
use frontend\models\Tax;
use frontend\models\Reservations;
use frontend\models\Invoices;
use frontend\models\Sitesettings;
use frontend\models\Claim;
use frontend\models\Homecountries;
use frontend\models\Claimmessage;
use frontend\models\Wishlists;
use frontend\models\Lists;
use frontend\models\Messages;
use frontend\models\Logs;
use frontend\models\Reviews;
use frontend\models\Profile;
use frontend\models\Userdevices;
use frontend\models\Weekendprice;
use frontend\models\Cancellation;
use frontend\models\Inquiry;
use frontend\models\Shippingaddress;
use frontend\models\Timezone; 
use common\models\User;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\Pagination;
use yii\CurrencyConverter\CurrencyConverter;

use yii\helpers\ArrayHelper;

/**
* ListingController implements the CRUD actions for Listing model.
*/
class ListingController extends Controller
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
        if (!(Yii::$app->user->isGuest)) {
            $loguserid = \Yii::$app->user->identity->id;
            $logUserDetails = User::find()->where(['id' => $loguserid])->One();
            if(isset($logUserDetails->userstatus)) {
                if($logUserDetails->userstatus == "0") {
                    return $this->redirect(['/']);
                }
            } else {
                return $this->redirect(['/']); 
            } 
        }

        if ($this->action->id == 'managelist') {
            Yii::$app->controller->enableCsrfValidation = false;
        }

        return true;
    }

    /**
     * Lists all Listing models.
     * @return mixed  
     */

    public function actionIndex()
    {
        $searchModel = new Listingsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single Listing model.
     * @param integer $id
     * @return mixed
     */

public function actionSendlistemail()
{
    $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
        if($_POST['email'] != '')
        {
            $input_email = explode(',',trim($_POST['email'])); 
            Yii::$app->mailer->compose ( 'sendlist', [
                    'message' => $_POST['messages'], 
                    'sender' => \Yii::$app->user->identity->firstname,
                    'senderid' => \Yii::$app->user->identity->id,
                    'listurls' => $_POST['listurl'],
                    'listingname' => $_POST['listingname'],
                    'sitesetting' => $sitesettings,
                ] )->setFrom ( $sitesettings->noreplyemail )->setSubject ( 'New listing is waiting for you!' )->setTo( $input_email )->send();    
        }else{
            Yii::$app->mailer->compose ( 'sendlist', [
                'message' => $_POST['messages'], 
                'listurls' => $_POST['listurl'],
                'senderid' => \Yii::$app->user->identity->id,
                'listingname' => $_POST['listingname'],
                'sender' => \Yii::$app->user->identity->firstname,
                'sitesetting' => $sitesettings,
                ] )->setFrom ( $sitesettings->noreplyemail )->setTo( $_POST['recipient_email'] )->setSubject ( 'New listing is waiting for you!' )->send();    
        }
}
public function actionView($details)
{
    $this->layout = 'search';
    $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    $_SESSION['place'] = "";
    
    if(isset($_POST) && isset($_POST['sendemail-button']))
    {
        if($_POST['hiddenemailfield'] != '')
        {
            $input_email = explode(',',$_POST['hiddenemailfield']);
            foreach($input_email as $mail)
            {
                Yii::$app->mailer->compose ( 'sendlist', [
                    'message' => $_POST['messages'], 
                    'sender' => \Yii::$app->user->identity->firstname,
                    'senderid' => \Yii::$app->user->identity->id,
                    'listurls' => $_POST['listurl'],
                    'listingname' => $_POST['listingname'],
                    'listingproperty' => $_POST['listingproperty'],
                    'description' => $_POST['description'],
                    'sitesetting' => $sitesettings,
                    ] )->setFrom ( $sitesettings->noreplyemail )->setTo( $mail )->setSubject ( 'Welcome email' )->send();    

            }
        }else{
            Yii::$app->mailer->compose ( 'sendlist', [
                'message' => $_POST['messages'], 
                'listurls' => $_POST['listurl'],
                'senderid' => \Yii::$app->user->identity->id,
                'listingname' => $_POST['listingname'],
                'listingproperty' => $_POST['listingproperty'],
                'description' => $_POST['description'],
                'sender' => \Yii::$app->user->identity->firstname,
                'sitesetting' => $sitesettings,
                ] )->setFrom ( $sitesettings->noreplyemail )->setTo( $_POST['recipient_email'] )->setSubject ( 'Welcome email' )->send();    
        }
        Yii::$app->getSession ()->setFlash ( 'success', 'Email has been successfully sent.' );
    }

    if(isset($_POST['formtype']) && $_POST['formtype']=='contacthost')  {
        Yii::$app->mailer->compose ( 'contacthost', [
                    'message' => $_POST['messages'], 
                    'sender' => \Yii::$app->user->identity->firstname,
                    'senderid' => \Yii::$app->user->identity->id,
                    'checkindate' => $_POST['checkindate'],
                    'checkoutdate' => $_POST['checkoutdate'],
                    'guests' => $_POST['guests'],
                    'sitesetting' => $sitesettings,
                    ] )->setFrom ( $sitesettings->noreplyemail )->setTo( $mail )->setSubject ( 'Welcome email' )->send();    
    }
    
    $detail = base64_decode($details); 
    $idval = explode('_',$detail);
    if(count($idval) != 2){
        Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Access' );
        return $this->goHome ();    
    }
    $id = $idval[0];
    $listmodel = new Listing();
    $loguserid = "";
    if (!(Yii::$app->user->isGuest)) {
        $loguserid = \Yii::$app->user->identity->id;
        $logUserDetails = User::find()->where(['id' => $loguserid])->One();
        if($logUserDetails->userstatus != '1') { 
            Yii::$app->getSession ()->setFlash ( 'success', 'Sorry user access blocked by admin.' );
            Yii::$app->user->logout ();
            return $this->goHome ();     
          }
        }        

    $listdata = Listing::find()->where(['id'=>$id])->one();
    if(count($listdata) == 0){
        Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Access' );
        return $this->goHome (); 
    }   
    if($listdata->liststatus == 2) {
        Yii::$app->getSession ()->setFlash ( 'success', 'Sorry it has been Blocked or Removed' );
        return $this->goHome ();
    }
    if (!(Yii::$app->user->isGuest) && $loguserid != $listdata->userid && $loguserid > 0) { 
        $models = new SignupForm();
        $loguserid = \Yii::$app->user->identity->id;
        $userdata =$models->findIdentity ( $loguserid );
        if($userdata->listids=="")
        {
            $listidss = array($id);
            $listids = json_encode($listidss);
            $userdata->id = $userdata->id;
            $userdata->listids = $listids;
            $userdata->save();
        }else{
            $listidss1 = array($id);
            $listidss = $userdata->listids;
            $listids = json_decode($listidss, true);
            $listcount = sizeof($listids);

            if($listcount >= 10){
                array_unshift($listids,$id);
                array_pop($listids);
                $arrlistids = array_map('trim', array_merge($listidss1,$listids));
                $uniqlistids = array_values(array_unique($arrlistids));
                $listids2 = json_encode($uniqlistids);
            }else{
                $arrlistids = array_map('trim', array_merge($listidss1,$listids)); 
                $uniqlistids = array_values(array_unique($arrlistids));
                $listids2 = json_encode($uniqlistids);
            }

            $userdata->id = $userdata->id;
            $userdata->listids = $listids2;
            $userdata->save();
        }  
    }   
    
    $models = new SignupForm();
    $photos = Photos::find()->where(['listid'=>$id])->all();
    $userid = $listdata->userid;
    $roomtypeid = $listdata->roomtype;
    $city = $listdata->city;
    $similarlisting = Listing::find()->where(['roomtype'=>$roomtypeid,'city'=>$city,'liststatus'=>'1'])
    ->andWhere(['!=','id',$id])
    ->limit('3')
    ->all();
    $slist = 0;

    //foreach($similarlisting as $addlisting)
    //{
        //$assignrating = Reviews::getRatingbylisting( $addlisting->id );
        //$similarlisting[$slist.'_rating'] = $assignrating['rating'];
       // $similarlisting[$slist.'_n_rating'] = $assignrating['n_rating'];
        //$slist++;
    //}

    $country = $listdata->getCountry0()->where(['id'=>$listdata->country])->one();
    $currency = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();
    $hometype = $listdata->getHometype0()->where(['id'=>$listdata->hometype])->one();
    $roomtype = $listdata->getRoomtype0()->where(['id'=>$listdata->roomtype])->one();
    $commondata = Commonlisting::find()->where(['listingid'=>$id])->all();
    $todaydate = date('m/d/Y');
    $today = strtotime($todaydate);
    $reservations="";
    if($listdata->booking=='pernight' || $listdata->booking=='perday')
    {
        $reservations = Reservations::find()->where(['listid'=>$id])
        ->andWhere(['!=','bookstatus','cancelled'])
        ->andWhere(['!=','bookstatus','declined'])
        ->andWhere(['!=','bookstatus','refunded'])
        ->andWhere(['>','inquiryid', 0])
        ->andWhere(['>=','todate',$today])
        ->all();
    }
    $hourreservations="";
    if($listdata->booking=='perhour' || $listdata->booking=='perday')
    {
        $connection = Yii::$app->getDb();
        $hourly_availablity=$listdata->hourly_availablity;
        $hourly_availablity=explode(',',$hourly_availablity);
        $hourly_availablity=array_filter($hourly_availablity);
        $hourly_availablity_count=count($hourly_availablity);
        $reservationhours = $connection->createCommand ( "SELECT count(todate),fromdate,todate,listid FROM hts_reservations WHERE listid='".$id."' and todate >= $today and inquiryid != 'null' and bookstatus!='cancelled' and bookstatus!='declined' and bookstatus!='refunded' group by todate HAVING COUNT(todate) >= '".$hourly_availablity_count."'");
        $hourreservations = $reservationhours->queryAll();
    } 
    /*$perdaynightreservations="";
    if($listdata->booking=='perday')
    {
        $perdaynightreservations = Reservations::find()->where(['listid'=>$id,'booking'=>'pernight'])
                                    ->andWhere(['!=','bookstatus','cancelled'])
                                    ->andWhere(['!=','bookstatus','declined'])
                                    ->andWhere(['>=','todate',$today])
                                    ->groupBy('todate')
                                    ->all();
                                }*/

                                $perdayhourreservations="";
                                if($listdata->booking=='perday')
                                {
        /*$perdayhourreservations = Reservations::find()->where(['listid'=>$id,'booking'=>'perhour'])
                                    ->andWhere(['!=','bookstatus','cancelled'])
                                    ->andWhere(['!=','bookstatus','declined'])
                                    ->andWhere(['>=','todate',$today])
                                    ->groupBy('todate')

                                    ->all();*/

                                    $perreservationhours = $connection->createCommand ( "SELECT count(todate),fromdate,todate,listid FROM hts_reservations WHERE listid='".$id."' and todate >= $today and bookstatus!='cancelled' and bookstatus!='declined' and booking='perhour' group by todate HAVING COUNT(todate) > 0");

                                    $perdayhourreservations = $perreservationhours->queryAll();
                                }

    //Ratings
                                $ratings = Reviews::getRatingbylisting($id);

                                $query = Reviews::find()->where(['listid'=>$id]);
                                $totalReviews = Reviews::find()->where(['listid'=>$id])->all();
                                $countQuery = clone $query;
                                $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>5]);  
                                $allreviews = $query->offset($pages->offset)
                                ->limit($pages->limit)
                                ->all(); 
                                if (!(Yii::$app->user->isGuest)) {
                                    $listnames = Lists::find()->where(['createdby'=>$loguserid])
                                    ->orWhere(['user_create'=>0])->all();
                                    $wishlists = Wishlists::find()->where(['userid'=>$loguserid,'listingid'=>$listdata->id])->all();
                                    $status = array('accepted','claimed','refunded');  

                                    $trips = Reservations::find()->where(['userid'=>$loguserid,'listid'=>$id])
                                    ->andWhere(['!=','checkin','0000-00-00 00:00:00'])
                                    ->andWhere(['!=','checkout','0000-00-00 00:00:00'])
                                    ->andwhere(['IN','bookstatus', $status]) 
                                    ->andWhere(['<','todate',time()])  
                                    ->all();
                                    foreach($trips as $trip)
                                    {
                                        $tripids[] = $trip->id;
                                    }
                                    $reviews = Reviews::find()->where(['userid'=>$loguserid,'listid'=>$id])->all();
                                    $reviewcount = count($trips) - count($reviews);  
                                    if($reviewcount==1)
                                    {
                                        foreach($reviews as $review)
                                        {
                                            $reviewids[] = $review->reservationid;
                                        }
                                        /*** Saravanan **/
                                        if(count($reviews) != '0') {
                                            $diff = array_diff($tripids,$reviewids);
                                            foreach($diff as $diffid)
                                            {
                                                $tripid = $diffid;
                                            }
                                        } else if(count($trips) == '1') {
                                            foreach($trips as $trip)
                                            {
                                                $tripid = $trip->id;
                                            }
                                        }
                                        else
                                        {
                                            $tripid = '';
                                        }
                                        /*** --- ***/
                                    }
                                    else
                                    {
                                        $tripid = "";
                                    }
                                }
                                else
                                {
                                    $listnames = "";
                                    $wishlists = "";
                                    $reviewcount = "";
                                    $tripid = "";
                                }
                                $commonamenities = array();
                                $commonamenityimage = array();
                                foreach($commondata as $common)
                                {       
                                    $commonamenity = $common->getAmenity()->where(['id'=>$common->amenityid])->one();
                                    $commonamenities[] = json_encode(array($commonamenity->name,$commonamenity->commonimage,'common'));
                                    $commonname = $commonamenity->name;
                                    $commonamenityimage[''.$commonname.''] = $commonamenity->commonimage;

                                }
                                $additionaldata = Additionallisting::find()->where(['listingid'=>$id])->all();
                                $additionalamenities = array();
                                $additionalamenityimage = array();
                                foreach($additionaldata as $additional)
                                {
                                    $additionalamenity = $additional->getAmenity()->where(['id'=>$additional->amenityid])->one();
                                    $additionalamenities[] = json_encode(array($additionalamenity->name,$additionalamenity->additionalimage,'additional'));
                                    $additionalname = $additionalamenity->name;
                                    if(isset($additionalamenity->additionalimage) && $additionalamenity->additionalimage!="")
                                      $additionalamenityimage[''.$additionalname.''] = $additionalamenity->additionalimage;
                                  else
                                    $additionalamenityimage[''.$additionalname.''] = "";

                            }       
                            $specialdata = Speciallisting::find()->where(['listingid'=>$id])->all();
                            $specialfeatures = array();
                            if(count($specialdata > 0)) {
                                foreach($specialdata as $special)
                                {
                                    $specialfeature = $special->getSpecial()->where(['id'=>$special->specialid])->one();
                                    if(isset($specialfeature->name) && isset($specialfeature->specialimage)) {
                                        $specialfeatures[] = json_encode(array($specialfeature->name,$specialfeature->specialimage,'special'));
                                    }  

                                } 
                            } 
                            $safetydata = Safetylisting::find()->where(['listingid'=>$id])->all();
                            $safetychecklist = array();
                            foreach($safetydata as $safety)
                            {
                                $safetycheck = $safety->getSafety()->where(['id'=>$safety->safetyid])->one();
                                $safetychecklist[] = $safetycheck->name;

                            }
                            $userdata = $models->findIdentity( $userid );
                            $userrating = Reviews::getRatingbyuser($userid);

                            $getReports = Profilereports::find()->where(['report_type'=>'list'])->all();

                            $listReports = Userreports::find()->where(['listid'=>$id, 'userid'=>$loguserid])->one();

                            $getCalendardatas = json_decode($listdata->blockedspecialprice);

                            $disableDate =''; 
                            $reservationsCheck = array();
                            $hourreservationsCheck = array();

                            if($listdata->booking=='pernight' && count($reservations) > 0) {
                                foreach ($reservations as $rskey => $chk) {
                                    $from_date = date('Y-m-d', $chk->fromdate);
                                    $to_date =  date('Y-m-d', $chk->todate);

                                    $diff=date_diff(date_create($to_date),date_create($from_date));
                                    $datediff = $diff->format("%a");
                                    $initialDate = $chk->fromdate+86400;

                                    if($initialDate==$chk->todate && $chk->fromdate>=$today && $datediff==1) {
                                        $rCount = count($reservationsCheck);
                                        $reservationsCheck[$rCount]['fromdate'] = $chk->fromdate;
                                        $reservationsCheck[$rCount]['todate'] = $chk->fromdate;
                                    } else if($initialDate < $chk->todate && $datediff >= 2) {
                                        $rFlag = 0;
                                        $newDate = "";   
                                        $endDate = strtotime(date("m/d/Y",$chk->todate).'-1 days');

                                        for ($pDate=$chk->fromdate; $pDate < $chk->todate; $pDate+=86400) {
                                            if($pDate >= $initialDate && $pDate >= $today) {
                                                if(empty(trim($disableDate))) {
                                                   $disableDate .= '"'.date('Y-m-d',$pDate).'"';
                                                } else {
                                                   $disableDate .= ',"'.date('Y-m-d',$pDate).'"';
                                                }
                                            }
                                            if($pDate >= $today && $rFlag == 0) {
                                               $newDate = $pDate;
                                               $rFlag = 1;
                                            }
                                        }
                                        if($newDate != "") {
                                            $rCount = count($reservationsCheck);
                                            $reservationsCheck[$rCount]['fromdate'] = $newDate;
                                            $reservationsCheck[$rCount]['todate'] = $endDate; 
                                        }
                                    }
                                }
                            }

                            if($listdata->booking=='perhour' && count($hourreservations) > 0) {
                                foreach ($hourreservations as $rskey => $chk) {
                                    $from_date = date('Y-m-d', $chk['fromdate']);
                                    $to_date =  date('Y-m-d', $chk['todate']);

                                    $diff=date_diff(date_create($to_date),date_create($from_date));
                                    $datediff = $diff->format("%a");

                                    if($chk['fromdate']==$chk['todate'] && $chk['fromdate']>=$today && $datediff==0) {
                                        if(empty(trim($disableDate))) {
                                           $disableDate .= '"'.date('Y-m-d',$chk['fromdate']).'"';
                                        } else {
                                           $disableDate .= ',"'.date('Y-m-d',$chk['fromdate']).'"';
                                        }

                                        $rCount = count($hourreservationsCheck);
                                        $hourreservationsCheck[$rCount]['fromdate'] = $chk['fromdate'];
                                        $hourreservationsCheck[$rCount]['todate'] = $chk['todate'];
                                    }
                                }
                            }

                            if(count($getCalendardatas) > 0)
                            {
                                $count=count($getCalendardatas);
                                for($i=0; $i < $count; $i++) {
                                    $cell=$getCalendardatas[$i];

                                    if($listdata->booking == 'pernight') {
                                        if((strtotime($cell->specialstartDate) == strtotime($cell->specialendDate)) && (strtotime($cell->specialstartDate) >= $today)) {

                                            $rCount = count($reservationsCheck);
                                            $reservationsCheck[$rCount]['fromdate'] = strtotime($cell->specialstartDate);
                                            $reservationsCheck[$rCount]['todate'] = strtotime($cell->specialendDate);
                                        } else if(strtotime($cell->specialstartDate) < strtotime($cell->specialendDate)) {
                                            $initialDate = strtotime($cell->specialstartDate)+86400;
                                            $rFlag = 0;
                                            $newDate = "";
                                            for ($pDate=strtotime($cell->specialstartDate); $pDate <= strtotime($cell->specialendDate); $pDate+=86400) {
                                                if($pDate >= $initialDate && $pDate >= $today) {
                                                    if(empty(trim($disableDate))) {
                                                       $disableDate .= '"'.date('Y-m-d',$pDate).'"';
                                                    } else {
                                                       $disableDate .= ',"'.date('Y-m-d',$pDate).'"';
                                                    }
                                                }
                                                if($pDate >= $today && $rFlag == 0) {
                                                   $newDate = $pDate;
                                                   $rFlag = 1;
                                                }
                                            }
                                            if($newDate != "") {
                                                $rCount = count($reservationsCheck);
                                                $reservationsCheck[$rCount]['fromdate'] = $newDate;
                                                $reservationsCheck[$rCount]['todate'] = strtotime($cell->specialendDate);
                                            } 
                                        }
                                    } else if($listdata->booking == 'perhour') {
                                        $rFlag = 0;
                                        $newDate = "";
                                        for ($pDate=strtotime($cell->specialstartDate); $pDate <= strtotime($cell->specialendDate); $pDate+=86400) {
                                            if($pDate >= $today) {
                                                if(empty(trim($disableDate))) {
                                                   $disableDate .= '"'.date('Y-m-d',$pDate).'"';
                                                } else {
                                                   $disableDate .= ',"'.date('Y-m-d',$pDate).'"';
                                                }
                                            }
                                            if($pDate >= $today && $rFlag == 0) {
                                               $newDate = $pDate;
                                               $rFlag = 1;
                                            }
                                        }
                                        if($newDate != "") {
                                            $rCount = count($hourreservationsCheck);
                                            $hourreservationsCheck[$rCount]['fromdate'] = $newDate;
                                            $hourreservationsCheck[$rCount]['todate'] = strtotime($cell->specialendDate);
                                        }
                                    }
                                }
                            }

                            $checkinDisableDate = "";
                            if(count($reservationsCheck) > 0) {
                                foreach ($reservationsCheck as $rKey => $rValue) {
                                    for ($pDate=$rValue['fromdate']; $pDate <= $rValue['todate']; $pDate+=86400) {
                                        if(empty(trim($checkinDisableDate))) {
                                           $checkinDisableDate .= '"'.date('Y-m-d',$pDate).'"';
                                        } else {
                                           $checkinDisableDate .= ',"'.date('Y-m-d',$pDate).'"';
                                        }  
                                    }
                                }
                            } elseif (count($hourreservationsCheck) > 0) {
                                foreach ($hourreservationsCheck as $rKey => $rValue) {
                                    for ($pDate=$rValue['fromdate']; $pDate <= $rValue['todate']; $pDate+=86400) {
                                        if(empty(trim($checkinDisableDate))) {
                                           $checkinDisableDate .= '"'.date('Y-m-d',$pDate).'"';
                                        } else {
                                           $checkinDisableDate .= ',"'.date('Y-m-d',$pDate).'"';
                                        }  
                                    }
                                }
                            }
                                                          
                            /* For social sharing */
                            if(isset($photos[0]->image_name))
                            {
                                $image1 = $photos[0]->image_name;
                                $listimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$image1);
                            }else{
                                $listimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');
                            }

            Yii::$app->controller->view->registerMetaTag(['property'=>'og:image:type', 'content'=>'image/jpeg'], 'og:image:type');
            Yii::$app->controller->view->registerMetaTag(['property'=>'og:image:width', 'content'=>"476"], 'og:image:width');
            Yii::$app->controller->view->registerMetaTag(['property'=>'og:image:height', 'content'=>"249"], 'og:image:height');
            Yii::$app->controller->view->registerMetaTag(['property'=>'og:image', 'content'=>$listimage], 'og:image');
            /* End social sharing */
    $cancelList = '';
    if($listdata->cancellation!="" && $listdata->cancellation!=NULL) {
        $cancelList = Cancellation::find()->where(['id'=>$listdata->cancellation])->one();
    }
        
        /* Kalidass
        Get Weekend price
        */
        $weekendDiscount = $listdata->weekendprice;
        if($weekendDiscount == '1'){
            $queryWeekend = Weekendprice::find()->where(['listid'=>$listdata->id])->one();
            $weekendPrice = $queryWeekend->weekend_price;
        }else{
            $weekendPrice = '';
        }

        $medicalno = $listdata->medicalno;
        $fireno = $listdata->fireno;
        $policeno = $listdata->policeno;
 
        $emergencyNumbers = array('medicalno'=>$medicalno, 'fireno'=>$fireno,'policeno'=>$policeno);

                            return $this->render('view', [
                                'model' => $listdata,
                                'photos' => $photos,
                                'userdata' => $userdata,
                                'user_rating'=>$userrating,
                                'country' => $country,
                                'currency' => $currency,
                                'weekendprice' => $weekendPrice,
                                'disabledDate'=>$disableDate,
                                'checkinDisableDate'=>$checkinDisableDate, 
                                'hometype' => $hometype,
                                'roomtype' => $roomtype,
                                'rating' => $ratings,
                                'listReports'=>$listReports,
                                'commonamenities' => $commonamenities,
                                'getReports' => $getReports,
                                'additionalamenities' => $additionalamenities,
                                'specialfeatures' => $specialfeatures,
                                'safetychecklist' => $safetychecklist,
                                'reservations' => $reservationsCheck, 
                                'hourreservations' => $hourreservationsCheck,
                                'listnames' => $listnames,
                                'wishlists' => $wishlists,
                                'emergencynumbers' => $emergencyNumbers,
                                'loguserid' => $loguserid,
                                'reviewcount' => $reviewcount,
                                'tripid' => $tripid,
                                'allreviews' => $allreviews,
                                'totalReviews' => $totalReviews,  
                                'pages' => $pages,
                                'similarlisting' => $similarlisting,
                                'additionalamenityimage' => $additionalamenityimage,
                                'commonamenityimage' => $commonamenityimage,
                                'perdayhourreservations'=>$perdayhourreservations,
                                'cancellation' => $cancelList
                                ]);
                        } 

/**
 * Creates a new Listing model.
 * If creation is successful, the browser will be redirected to the 'view' page.
 * @return mixed
 */
public function actionListcreate()
{
    $model = new Listing();
    $models = new SignupForm ();
    $additionalform = new Additionalamenities();
    $commonform = new Commonamenities();
    $listingform = new Listingproperties();
    $roomform = new Roomtype();
    $homeform = new Hometype();
    $safetyform = new Safetycheck();
    $specialform = new Specialfeatures();
    
    $listingproperties = $listingform->findIdentity();
    $additionalamenities = $additionalform->findallidentity();
    $commonamenities = $commonform->findallidentity();
    $hometype = $homeform->findallidentity();
    $roomtype = $roomform->findallidentity();
    $safetycheck = $safetyform->findallidentity();
    $specialfeatures = $specialform->findallidentity();
    $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    
    if (Yii::$app->user->isGuest) { 
        return $this->goHome ();
    } else if (! Yii::$app->user->isGuest) {
        $userid = \Yii::$app->user->identity->id;
        $userdata = $models->findIdentity ( $userid );
        if($userdata->hoststatus == 0)
        {
            Yii::$app->getSession ()->setFlash ( 'success', 'Sorry host access Blocked by admin' );
            return $this->goHome ();
        } else if($userdata->stripe_status!="verified" || $userdata->stripe_account_id=="") {
            Yii::$app->getSession ()->setFlash ( 'success', 'Please add stripe account details to add listings' );   
            return $this->redirect(['/paysettings/default']);
        } 
    }         
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->id]);
    } else {
        return $this->render('listcreate', [
            'model' => $model,
            'userdata'=>$userdata,
            'listingproperties'=>$listingproperties,
            'additionalamenities'=>$additionalamenities,
            'commonamenities'=>$commonamenities,
            'hometype'=>$hometype,
            'roomtype'=>$roomtype,
            'safetycheck'=>$safetycheck,
            'specialfeatures'=>$specialfeatures,
            'sitesettings' => $sitesettings
            ]);
    }
}

/*
Function to create new wish list
*/
public function actionCreatenewlist()
{
    $userid = \Yii::$app->user->identity->id;

    $newlistname = $_POST['newlistname'];

    $Listsdata = Lists::find()->where(['listname'=>$newlistname,'createdby'=>$userid])->all();
    
    if(empty($Listsdata)) {
        $Lists = new Lists();
        $Lists->listname = $newlistname;
        $Lists->createdby = $userid;
        $Lists->user_create = 1;
        $Lists->save();
        echo $Lists->id;
    }else{
        echo "exists";
    }
}

/*
Function to save the listing to the wish lists
*/
public function actionSavewishlists() 
{
    $listarr = $_POST['listarr'];
    if($listarr[0]==0)
    {
        $listarr = array();
    }
    $listingid = $_POST['listingid'];
    $userid = \Yii::$app->user->identity->id;
    $totalwishlists = Wishlists::find()->where(['userid'=>$userid,'listingid'=>$listingid])->all();
    foreach($totalwishlists as $wishlist)
    {
        if(!in_array($wishlist->listid,$listarr))
        {
            $removelist = Wishlists::find()->where(['id'=>$wishlist->id])->one();
            $removelist->delete();            
        }
    }
    foreach($listarr as $lists)
    {
        $wishlists = Wishlists::find()->where(['userid'=>$userid,'listid'=>$lists,'listingid'=>$listingid])->one();
        if(count($wishlists)==0)
        {
            $newwishlist = new Wishlists();
            $newwishlist->userid = $userid;
            $newwishlist->listid = $lists;
            $newwishlist->listingid = $listingid;
            $newwishlist->save();
        }
    }
    $totalwishlists = Wishlists::find()->where(['userid'=>$userid,'listingid'=>$listingid])->all();
    if(count($totalwishlists) > 0){
      echo "created";
    } else {
      echo "deleted"; 
    }
    die;
}

/*
Displays all the wish lists created by the user
*/
public function actionMywishlists()
{   
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    }
    $userform = new SignupForm();
    $userid = \Yii::$app->user->identity->id;
    $userdata = $userform->findIdentity ( $userid );
    /*$lists = Lists::find()->where(['createdby'=>$userid])
    ->orWhere(['user_create'=>0])->all();*/
    
    $query = Lists::find()->where(['createdby'=>$userid])
    ->orWhere(['user_create'=>0]);
    $totallists = Lists::find()->where(['createdby'=>$userid])
    ->orWhere(['user_create'=>0])->all();
    $wishlists = Wishlists::find()->where(['userid'=>$userid])->count();
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>15]);
    $lists = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->all();

    return $this->render('mywishlists',[
        'userdata' => $userdata,
        'lists' => $lists,
        'userid' => $userid,
        'pages' => $pages,
        'totallists' => $totallists,
        'wishlists' => $wishlists
        ]);
}

/*
Displays all the wish lists created by the user based on the popularity
*/
public function actionPopularwishlists()
{
    Yii::$app->getSession ()->setFlash ( 'success', 'Page not found.' );
    return $this->redirect(['/']);  

    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    }
    $userform = new SignupForm();
    $userid = \Yii::$app->user->identity->id;
    $userdata = $userform->findIdentity ( $userid );

    $query = Wishlists::find()
    ->select(['listid','COUNT(listid) AS count'])
    ->where(['userid' => $userid])
    ->groupBy(['listid'])
    ->orderBy(['count' => SORT_DESC]);
    $totallists = Wishlists::find()
    ->select(['listid','COUNT(listid) AS count'])
    ->where(['userid' => $userid])
    ->groupBy(['listid'])
    ->orderBy(['count' => SORT_DESC])->all();
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>15]);
    $wishlists = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->all();
    foreach($wishlists as $list)
    {
        $listids[] = $list->listid;
    }
    foreach($wishlists as $wishlist)
    {
        $lists[] = Lists::find()->where(['id'=>$wishlist->listid])->all();
    }
    if(empty($lists))
        $lists="";
    return $this->render('popularwishlists',[
        'userdata' => $userdata,
        'lists' => $lists,
        'userid' => $userid,
        'pages' => $pages,
        'totallists' => $totallists
        ]);      
}

/*
Display all the listings under the wish list
*/
public function actionWishlist($details)
{
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    }       
    $userform = new SignupForm();
    $detail = base64_decode($details);
    $idval = explode('_',$detail);

    if(count($idval) == 2) {
        $id = $idval[0];
        $userid = \Yii::$app->user->identity->id;
        $userdata = $userform->findIdentity ( $userid );
        //$wishlists = Wishlists::find()->where(['listid'=>$id,'userid'=>$userid])->all();
        $listdata = Lists::find()->where(['id'=>$id])->one();
        
        $query = Wishlists::find()->where(['listid'=>$id,'userid'=>$userid]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
        $wishlists = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();        
        
        return $this->render('wishlist',[
            'wishlists' => $wishlists,
            'listdata' => $listdata,
            'userdata' => $userdata,
            'pages' => $pages
            ]);
    } else {
        Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Access');
        return $this->redirect(['/user/listing/mywishlists']);  
    }
}

/*
Function to remove the wishlist
*/
public function actionRemovewishlist()
{
    $wishlistid = $_POST['wishlistid'];
    $wishlist = Wishlists::find()->where(['id'=>$wishlistid])->one();
    $wishlist->delete();
}

/*
Display the edit option for the wish list
*/
public function actionEditwishlist($details)
{
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    }       
    $userform = new SignupForm();
    $detail = base64_decode($details);
    $idval = explode('_',$detail);
    $id = $idval[0];
    $userid = \Yii::$app->user->identity->id;
    $userdata = $userform->findIdentity ( $userid );
    $list = Lists::find()->where(['id'=>$id])->one();
    return $this->render('editwishlist',[
        'list' => $list,
        'userdata' => $userdata,
        'userid' => $userid
        ]);     
}

/*
Function to edit the wish list and to change the wish list name
*/
public function actionEditlistname()
{
    $listid = $_POST['listid'];
    $listname = $_POST['listname'];
    $listdata = Lists::find()->where(['id'=>$listid])->one();
    $listdata->listname = $listname;
    $listdata->save();
}

/**
 * Updates an existing Listing model.
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
 * Deletes an existing Listing model.
 * If deletion is successful, the browser will be redirected to the 'index' page.
 * @param integer $id
 * @return mixed
 */
public function actionDelete($id)
{
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
}

/**
 * Finds the Listing model based on its primary key value.
 * If the model is not found, a 404 HTTP exception will be thrown.
 * @param integer $id
 * @return Listing the loaded model
 * @throws NotFoundHttpException if the model cannot be found
 */
protected function findModel($id)
{
    if (($model = Listing::findOne($id)) !== null) {
        return $model;
    } else {
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}


/*
 * Function to save the initial listing information
*/
public function actionSaveinitiallist()
{

    $model = new Listing();
    $userform = new SignupForm();
    $userid = \Yii::$app->user->identity->id;
    $userdata = $userform->findIdentity ( $userid );
    $emailverify = Yii::$app->user->identity->emailverify;
   
   // $paypalid = Yii::$app->user->identity->paypalid;
    if($emailverify!=1 && ($userdata->stripe_status!="verified" || $userdata->stripe_account_id=="")){
        echo "error";die;
    }elseif($emailverify!=1){
        echo "emailerror";die;
    }elseif($userdata->stripe_status!="verified" || $userdata->stripe_account_id==""){
        echo "paypalerror";die;
    }
    if($userdata->hoststatus=="0")
       $userdata->hoststatus = "0";
    else
        $userdata->hoststatus = "1";

    $userdata->save();
    $hometype = $_POST['hometype'];
    $roomtype = $_POST['roomtype'];
    $accommodate = $_POST['accommodate'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $booking = $_POST['booking'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    if(trim($country) != "") { 
        $countrydata = Country::find()->where(['countryname'=>$country])->orWhere(['like','alternative',strtolower(trim($country))])->one(); 
            //echo $hometype.'<br />'.$roomtype.'<br />'.$accommodate.'<br />'.$city;
        $model->userid = $userid;
        $model->hometype = $hometype;
        $model->roomtype = $roomtype;
        $model->liststatus = '0';
        $model->accommodates = $accommodate;
        $model->latitude = $latitude;
        $model->longitude = $longitude;  
        $model->city = $city;
        $model->state = $state;
        $model->country = $countrydata->id;
        $model->booking = $booking;
        $model->cdate = time(); 
        $model->save(false);      
        return $this->redirect(['/user/listing/managelist/'.$model->id]);
    } else {
        Yii::$app->getSession ()->setFlash ( 'success', 'Country Location Error.' );
         return $this->redirect(['/user/listing/listcreate']);  
    }
}

/*
Function to save the basic informations such as home type, room type, accommodates etc
*/
public function actionSavebasicslist()
{
    $hometype = $_POST['hometype'];
    $roomtype = $_POST['roomtype'];
    $accommodates = $_POST['accommodates'];
    $bedrooms = $_POST['bedrooms'];
    $beds = $_POST['beds'];
    $bathrooms = $_POST['bathrooms'];
    $listingid = $_POST['listingid'];
    $booking = $_POST['booking']; 

    $listingUpdate = Listing::find()->where(['id'=>$listingid])->one();
    $listdata = Listing::find()->where(['id'=>$listingid])->one();

    $duration_type = trim($_POST['booking']);
    $listing_duration = trim($listingUpdate->booking); 
    $changeLog = "disable";
    if($duration_type != $listing_duration) {
        $listingUpdate->booking = $duration_type;
        $listingUpdate->nightlyprice = NULL;
        $listingUpdate->hourlyprice = NULL;
        $listingUpdate->hourly_availablity = NULL; 
        $listingUpdate->pernight_availablity = NULL;  
        $listingUpdate->minstay = NULL;  
        $listingUpdate->maxstay = NULL;  
        $listingUpdate->liststatus = 0; 
        $listingUpdate->save(false);
        $changeLog = "enable";   
    } else {
       $listdata->booking = $booking; 
    }

    $listdata->hometype = $hometype;
    $listdata->roomtype = $roomtype;
    $listdata->accommodates = $accommodates;
    $listdata->bedrooms = $bedrooms;
    $listdata->beds = $beds;
    $listdata->bathrooms = $bathrooms;
    
    if($booking=='pernight'){ $listdata->hourly_availablity=NULL;}
    if($booking=='perhour'){ $listdata->pernight_availablity=NULL;}
    $listdata->save(false);  
    echo $changeLog; 
}

/*
Function to save the listing name and description
*/
public function actionSavedescriptionlist()
{
    $listingname = $_POST['listingname'];
    $description = $_POST['descri'];
    $listingid = $_POST['listingid'];
    
    $listdata = Listing::find()->where(['id'=>$listingid])->one();
    $listdata->listingname = $listingname;
    $listdata->description = $description;
    $listdata->save(false); 
}

/*
Function to save the location of the listing
*/
public function actionSavelocationlist()
{
    $country = $_POST['country'];
    $timezone = $_POST['timezone'];
    $streetaddress = $_POST['streetaddress'];
    $accesscode = $_POST['accesscode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $listingid = $_POST['listingid'];
    
    $listdata = Listing::find()->where(['id'=>$listingid])->one();
    $listdata->country = $country;
    $listdata->timezone = $timezone; 
    $listdata->streetaddress = $streetaddress;
    if(isset($accesscode))
        $listdata->accesscode = $accesscode;
    $listdata->city = $city;
    if(isset($state))
        $listdata->state = $state;
    if(isset($zipcode))
        $listdata->zipcode = $zipcode;
    if($_POST['latitude']!="")
        $listdata->latitude = $_POST['latitude'];
    if($_POST['longitude']!="")
        $listdata->longitude = $_POST['longitude'];
    $listdata->save(false);  
}

/*
 *Function to save the amenities
 */
public function actionSaveamenitylist() 
{
    $commonamenities = $_POST['commonamenity'];
    $additionalamenities = $_POST['additionalamenity'];
    $specialfeatures = $_POST['specialfeature'];
    $listid = $_POST['listingid'];
    for($j=0;$j<count($commonamenities);$j++)
    {
        $commonlisting = new Commonlisting();
        $commondata = $commonlisting->find()->where(['listingid'=>$listid,'amenityid'=>$commonamenities[$j]])->one();
        if(count($commondata)==0)
        {
            $commonlisting->listingid = $listid;
            $commonlisting->amenityid = $commonamenities[$j];
            $commonlisting->save();
        }
    }
    for($j=0;$j<count($additionalamenities);$j++)
    {
        $additionallisting = new Additionallisting();
        $additionaldata = $additionallisting->find()->where(['listingid'=>$listid,'amenityid'=>$additionalamenities[$j]])->one();
        if(count($additionaldata)==0)
        {
            $additionallisting->listingid = $listid;
            $additionallisting->amenityid = $additionalamenities[$j];
            $additionallisting->save();
        }
    }  
    for($j=0;$j<count($specialfeatures);$j++)
    {
        $speciallisting = new Speciallisting();
        $specialdata = $speciallisting->find()->where(['listingid'=>$listid,'specialid'=>$specialfeatures[$j]])->one();
        if(count($specialdata)==0)
        {
            $speciallisting->listingid = $listid;
            $speciallisting->specialid = $specialfeatures[$j];
            $speciallisting->save();
        }
    }       
}

/*
 *Funtion to save the images for the listings
 */
public function actionSavephotolist()
{
    $filenames = json_decode($_POST['uploadimg'],true);
    $listid = $_POST['listingid'];
    $youtubeurl = $_POST['youtubeurl'];
    $photodata = Photos::find()->where(['listid'=>$listid])->all();
    if(count($photodata)>0)
    {
        foreach($photodata as $photo)
        {
            $imagenames[] = $photo->image_name;
            echo $imagename = $photo->image_name;
            if(!in_array($imagename,$filenames))
            {
                $deletephoto = Photos::find()->where(['listid'=>$listid,'image_name'=>$imagename])->one();
                $deletephoto->delete();
            }               
        }
    }
    for($i=0;$i<count($filenames);$i++)
    {
        $photos = new Photos();
        $photodatas = Photos::find()->where(['listid'=>$listid,'image_name'=>$filenames[$i]])->one();
        if(count($photodatas)==0)
        {
            $photos->listid = $listid;
            $photos->image_name = $filenames[$i]; 
            $photos->save();
        }
    }  

    $listdata = Listing::find()->where(['id'=>$listid])->one();
    $listdata->youtubeurl = $youtubeurl;
    $listdata->save(false);      
}


/*
 *Function to save the safety check list for the listings
 */
public function actionSavebookinglist()
{
    $cancellationpolicy = (isset($_POST['cancellationpolicy']) && $_POST['cancellationpolicy']!="") ? $_POST['cancellationpolicy'] : ""; 
    $bookingstyle = (isset($_POST['bookingstyle']) && $_POST['bookingstyle']!="") ? $_POST['bookingstyle'] : ""; 
    $houserules = (isset($_POST['houserules']) && $_POST['houserules']!="") ? $_POST['houserules'] : "";  
    $listingid = $_POST['listingid'];  
    
   $listdata = Listing::find()->where(['id'=>$listingid])->one();
  /* $listdata->fireextinguisher = $_POST['fireextinguisher'];
   $listdata->firealarm = $_POST['firealarm'];
   $listdata->gasshutoffvalve = $_POST['gasshutoffvalve'];
   $listdata->emergencyexitinstruction = $_POST['emergencyexitinstruction'];
   $listdata->medicalno = $_POST['medicalno'];
   $listdata->fireno = $_POST['fireno'];
   $listdata->policeno = $_POST['policeno'];*/   
   $listdata->cancellation = $cancellationpolicy; 
   $listdata->bookingstyle = $bookingstyle;  
   $listdata->houserules = $houserules;   

   $listdata->save(false);  
}
/*
 *Function to save the safety check list for the listings
 */
public function actionSavesafetylist()
{
    if(isset($_POST['safetylist']) && $_POST['safetylist']!="")
    {
       $safetychecklist = $_POST['safetylist']; 
   }

   $listingid = $_POST['listingid'];
   $listdata = Listing::find()->where(['id'=>$listingid])->one();
  /* $listdata->fireextinguisher = $_POST['fireextinguisher'];
   $listdata->firealarm = $_POST['firealarm'];
   $listdata->gasshutoffvalve = $_POST['gasshutoffvalve'];
   $listdata->emergencyexitinstruction = $_POST['emergencyexitinstruction'];
   $listdata->medicalno = $_POST['medicalno'];
   $listdata->fireno = $_POST['fireno'];
   $listdata->policeno = $_POST['policeno'];*/   
   $listdata->save();

   if(isset($_POST['safetylist']) && $_POST['safetylist']!="")
   {
    Safetylisting::deleteAll([
        'listingid' => $listingid,
        ]);
    for($j=0;$j<count($safetychecklist);$j++)
    {
        $safetylisting = new Safetylisting();
        $safetydata = $safetylisting->find()->where(['listingid'=>$listingid,'safetyid'=>$safetychecklist[$j]])->one();
        if(count($safetydata)==0)
        {
            $safetylisting->listingid = $listingid;
            $safetylisting->safetyid = $safetychecklist[$j];
            $safetylisting->save();
        }
    }
}       
}

/*
 *Function to save the price for the listing
 */
public function actionSavepricelist()
{
    //Store calendar datas.
    if(isset($_POST['weekendprice_status']) && $_POST['weekendprice_status'] > 0)
    {
        $WeekendpriceCount = Weekendprice::find()->where(['listid'=>$_POST['listingid']])->one();
        if(count($WeekendpriceCount) == 0)
        {
            $weekendprice = new Weekendprice();
            $weekendprice->listid = $_POST['listingid'];
            $weekendprice->weekend_price = $_POST['weekendprice'];
            $weekendprice->save(false);
        }else{
            $WeekendpriceCount->listid = $_POST['listingid'];
            $WeekendpriceCount->weekend_price = $_POST['weekendprice'];
            $WeekendpriceCount->save(false);
        }
    }
    
    $nightlyprice = $_POST['nightlyprice'];
    $hourlyprice = $_POST['hourlyprice'];
    $cleaningfees = $_POST['cleaningfees'];
    $servicefees = $_POST['servicefees'];


    $securitydeposit = trim($_POST['securitydeposit']);
    $currency = $_POST['currency'];
    $listingid = $_POST['listingid'];
    $listdata = Listing::find()->where(['id'=>$listingid])->one();

    if(empty($securitydeposit) || $securitydeposit <= 0)
        $securitydeposit = 0;

    if(isset($_POST['nightlyprice']) && $_POST['nightlyprice'] != '' && $_POST['nightlyprice'] != 0)
    {
        $listdata->nightlyprice = $nightlyprice;
        $listdata->hourlyprice = NULL;
    }elseif(isset($_POST['hourlyprice']) && $_POST['hourlyprice'] != '' && $_POST['hourlyprice'] != 0)
    {
        $listdata->hourlyprice = $hourlyprice;
        $listdata->nightlyprice = NULL;
    }


    $listdata->cleaningfees = $cleaningfees;
    $listdata->servicefees = $servicefees;
    $listdata->weekendprice = $_POST['weekendprice_status'];
    $listdata->securitydeposit = $securitydeposit;
    $listdata->currency = $currency;
    $listdata->save(false);

}

/*
 * Function to edit and add the listing information
 * 
 */
public function actionManagelist($id)
{
    $this->enableCsrfValidation = false;
    if (Yii::$app->user->isGuest) {
      return $this->goHome ();
    }  
    $loguserid = \Yii::$app->user->identity->id; 
    $listdata = Listing::find()->where(['id'=>$id])->one();

    if(empty($loguserid) || count($listdata) <= 0 || $loguserid != $listdata->userid) {
        Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request.' );
        return $this->goHome ();
    }

    $model = new Listing();
    $models = new SignupForm();
    $additionalform = new Additionalamenities();
    $commonform = new Commonamenities();
    $listingform = new Listingproperties();
    $roomform = new Roomtype();
    $homeform = new Hometype();
    $safetyform = new Safetycheck();
    $specialform = new Specialfeatures();
    $photos = new Photos();

    if(!empty($listdata->country) && trim($listdata->country) > 0) {
        $query = Timezone::find();
        $query->leftJoin('hts_country', 'hts_country.code = hts_timezone.code');
        $query->where(['=', 'hts_country.id', $listdata->country]);  
        $query->orderBy('hts_timezone.id asc'); 
        $countryZoneData = $query->all(); 
    } else {
        $countryZoneData = Timezone::find('all')->all();
    }
    
    
    $commonlistings = $listdata->getCommonlistings()->where(['listingid'=>$id])->all();
    $additionallistings = $listdata->getAdditionallistings()->where(['listingid'=>$id])->all();
    $safetylistings = $listdata->getSafetylistings()->where(['listingid'=>$id])->all();
    $speciallistings = $listdata->getSpeciallistings()->where(['listingid'=>$id])->all();
    $listingproperties = $listingform->findIdentity();
    $additionalamenities = $additionalform->findallidentity();
    $commonamenities = $commonform->findallidentity();
    $hometype = $homeform->findallidentity();
    $roomtype = $roomform->findallidentity();
    $safetycheck = $safetyform->findallidentity();
    $specialfeatures = $specialform->findallidentity(); 
    $country = Country::find('all')->all();  
    $currency = Currency::find('all')->all(); 
    $defaultcurrency = Currency::find()->where(['defaultcurrency'=>1])->one(); 

    $currencyid = $listdata->currency;
    if(isset($currencyid))
    {
        $currencies = Currency::find()->where(['id'=>$currencyid])->one();
    }
    else
        $currencies = "";


    $cancellationList = Cancellation::find()->all();
    
    

    
    $imagesdata = Photos::find()->where(['listid'=>$id])->all();
    return $this->render('managelist',[
        'id'=>$id,
        'model'=>$model,
        'listdata'=>$listdata,
        'listingproperties'=>$listingproperties,
        'additionalamenities'=>$additionalamenities,
        'commonamenities'=>$commonamenities,
        'hometype'=>$hometype, 
        'cancellationlists'=>$cancellationList,
        'roomtype'=>$roomtype,
        'safetycheck'=>$safetycheck,
        'specialfeatures'=>$specialfeatures,
        'country'=>$country,
        'currency'=>$currency,
        'currencies'=>$currencies,
        'imagesdata'=>$imagesdata,
        'commonlistings' => $commonlistings,
        'additionallistings' => $additionallistings,
        'safetylistings' => $safetylistings,
        'speciallistings' => $speciallistings,
        'defaultcurrency'=>$defaultcurrency,
        'countryZoneData'=>$countryZoneData, 
        ]);
}

/**
 * Function to save the listing information
 * @return boolean
 */
public function actionSavelist()
{
    $model = new Listing();

    if(isset($_POST['cancellationpolicylists']))
    {
        $canceledlists = $_POST['cancellationpolicylists']; 
    }else{
        $canceledlists = '';
    }
    $listid = $_POST['listid'];
    $userid = \Yii::$app->user->identity->id;
    $listdata = Listing::find()->where(['id'=>$listid])->one();
    $booking=$listdata->booking;
    $listdata->userid = $userid;
    $listdata->hometype = $_POST['hometype'];
    $listdata->roomtype = $_POST['roomtype'];
    $listdata->accommodates = $_POST['accommodates'];
    $listdata->bedrooms = $_POST['bedrooms'];
    $listdata->beds = $_POST['beds'];
    $listdata->bathrooms = $_POST['bathrooms'];
    $listdata->listingname = $_POST['listingname'];
    $listdata->youtubeurl = $_POST['youtubeurl'];
    $listdata->cancellation = $canceledlists;
    $listdata->cleaningfees = $_POST['cleaningfees'];
    $listdata->servicefees = $_POST['servicefees'];
    $listdata->weekendprice = $_POST['weekendprice_status'];
    $listdata->description = $_POST['description'];
    $listdata->country = $_POST['country'];
    $listdata->timezone = trim($_POST['timezone']);     
    $listdata->streetaddress = $_POST['streetaddress'];
    if(isset($_POST['accesscode'])){
        $listdata->accesscode = $_POST['accesscode'];
    }
    $listdata->city = $_POST['city'];
    if(isset($_POST['state'])){
        $listdata->state = $_POST['state'];
    }
    if(isset($_POST['zipcode'])){
        $listdata->zipcode = $_POST['zipcode'];
    }
    if(isset($_POST['latitude']) && $_POST['latitude']!="")
        $listdata->latitude = $_POST['latitude'];
    if(isset($_POST['longitude']) && $_POST['longitude']!="")
        $listdata->longitude = $_POST['longitude'];
    $commonamenities = $_POST['commonamenities'];
    
    //$listdata->commonamenities = $commonamenities;
    $additionalamenities = $_POST['additionalamenities'];
    //$listdata->additionalamenities = $additionalamenities;
    $specialfeatures = $_POST['specialfeatures'];
    //$listdata->specialfeatures = $specialfeatures;
    if(isset($_POST['safetychecklist']) && $_POST['safetychecklist']!=""){
        $safetychecklist = $_POST['safetychecklist'];
    }
    //$listdata->safetychecklist = $safetychecklist;  
   /* $listdata->fireextinguisher = $_POST['fireextinguisher'];
    $listdata->firealarm = $_POST['firealarm'];
    $listdata->gasshutoffvalve = $_POST['gasshutoffvalve'];
    $listdata->emergencyexitinstruction = $_POST['emergencyexitinstruction'];
    $listdata->medicalno = $_POST['medicalno'];
    $listdata->fireno = $_POST['fireno'];
    $listdata->policeno = $_POST['policeno']; */

    $splcheckprice = NULL;
    if(isset($_POST['nightlyprice']) && $_POST['nightlyprice']!="" && $booking!='perhour') {
        $listdata->nightlyprice = $_POST['nightlyprice'];
        $splcheckprice = $_POST['nightlyprice'];
    } else {
        $listdata->nightlyprice = NULL;  
    }

    if(isset($_POST['hourlyprice']) && $_POST['hourlyprice']!="" && $booking!='pernight') {
        $listdata->hourlyprice = $_POST['hourlyprice'];
        $splcheckprice = $_POST['hourlyprice'];
    } else {
        $listdata->hourlyprice = NULL;
    }
    
    $securitydeposit = $_POST['securitydeposit'];       

    if(empty($securitydeposit) || $securitydeposit <= 0)
        $listdata->securitydeposit = 0;
    else
        $listdata->securitydeposit = $securitydeposit; 
    
    $listdata->currency = $_POST['currency'];
    $listdata->bookingstyle = $_POST['bookingstyle'];
    $listdata->bookingavailability = $_POST['bookingavailability'];
    $listdata->minstay = $_POST['minstay'];
    $maxstay = $_POST['maxstay'];
    if($maxstay!="")
        $listdata->maxstay = $maxstay;
    if(isset($listdata->liststatus) && $listdata->liststatus=="0")
        $listdata->liststatus = "1";
    else if($listdata->liststatus=="2")
        $listdata->liststatus = "2";
    else
        $listdata->liststatus = "1";
    if($_POST['bookingstyle']=="instant")
    {
        $listdata->houserules = $_POST['houserules'];
    }
    if($_POST['bookingavailability']=='onetime')
    {
        $dstartdate=strtotime($_POST['startdate']);
        $denddate=strtotime($_POST['enddate']);
        $listdata->startdate = trim($dstartdate);
        $listdata->enddate = trim($denddate);
    }
    else if($_POST['bookingavailability']=='always')
    {
        $listdata->startdate = NULL;
        $listdata->enddate = NULL;             
    }
    $starttime="";
    $endtime ="";
    $listdata->pernight_availablity =$starttime.$endtime;
    if(isset($_POST['opentime']) && $_POST['opentime']!="" &&  $booking!='perhour')
    {
       $starttime =date("H:i", strtotime($_POST['opentime']));
    }

    if(isset($_POST['closetime']) && $_POST['closetime']!="" && $booking!='perhour')
    {
      $endtime = date("H:i", strtotime($_POST['closetime']));
      $listdata->pernight_availablity =$starttime.'*|*'.$endtime;  
    }
    $hourlydetails="";
    if(isset($_POST['hourtimes']) && $_POST['hourtimes']!="" && $booking!='pernight')
    {
      $hourlytiming=$_POST['hourtimes'];
      $hourlytimingcount=count($_POST['hourtimes']);
      $hourlydetails='';
      $j=0;
      for($i=0;$i<$hourlytimingcount/2;$i++)
      {
        $hourlydetails.=date("H:i", strtotime($hourlytiming[$j])).'*|*'.date("H:i", strtotime($hourlytiming[$j+1]));
        $hourlydetails.=',';
        $j=$j+2;
      }
    }
      
$listdata->hourly_availablity =  $hourlydetails;
$filenames = json_decode($_POST['files'],true);
$listdata->cdate = time(); 
$listdata->save(false);
$photodata = Photos::find()->where(['listid'=>$listid])->all();



    //Store calendar datas.
if(isset($_POST['weekendprice_status']) && $_POST['weekendprice_status'] > 0)
{
    $WeekendpriceCount = Weekendprice::find()->where(['listid'=>$_POST['listid']])->one();
    if(count($WeekendpriceCount) == 0)
    {
        $weekendprice = new Weekendprice();
        $weekendprice->listid = $listid;
        $weekendprice->weekend_price = $_POST['weekendprice'];
        $weekendprice->save(false);
    }else{
        $WeekendpriceCount->listid = $listid;
        $WeekendpriceCount->weekend_price = $_POST['weekendprice'];
        $WeekendpriceCount->save(false);
    }
}
if(count($photodata)>0)
{
    foreach($photodata as $photo)
    {
        $imagenames[] = $photo->image_name;
        $imagename = $photo->image_name;
        if(!in_array($imagename,$filenames))
        {
            $deletephoto = Photos::find()->where(['listid'=>$listid,'image_name'=>$imagename])->one();
            $deletephoto->delete();
        }               
    }
}
for($i=0;$i<count($filenames);$i++)
{
    $photos = new Photos();
    $photodatas = Photos::find()->where(['listid'=>$listid,'image_name'=>$filenames[$i]])->one();
    if(count($photodatas)==0)
    {
        $photos->listid = $listid;
        $photos->image_name = $filenames[$i]; 
        $photos->save();
    }
}
for($j=0;$j<count($commonamenities);$j++)
{
    $commonlisting = new Commonlisting();
    $commondata = $commonlisting->find()->where(['listingid'=>$listid,'amenityid'=>$commonamenities[$j]])->one();
    if(count($commondata)==0)
    {
        $commonlisting->listingid = $listid;
        $commonlisting->amenityid = $commonamenities[$j];
        $commonlisting->save();
    }
}
for($j=0;$j<count($additionalamenities);$j++)
{
    $additionallisting = new Additionallisting();
    $additionaldata = $additionallisting->find()->where(['listingid'=>$listid,'amenityid'=>$additionalamenities[$j]])->one();
    if(count($additionaldata)==0)
    {
        $additionallisting->listingid = $listid;
        $additionallisting->amenityid = $additionalamenities[$j];
        $additionallisting->save();
    }
}  




for($j=0;$j<count($specialfeatures);$j++)
{
    $speciallisting = new Speciallisting();
    $specialdata = $speciallisting->find()->where(['listingid'=>$listid,'specialid'=>$specialfeatures[$j]])->one();
    if(count($specialdata)==0)
    {
        $speciallisting->listingid = $listid;
        $speciallisting->specialid = $specialfeatures[$j];
        $speciallisting->save();
    }
}
if(isset($_POST['safetychecklist']) && $_POST['safetychecklist']!=""){
    Safetylisting::deleteAll([
        'listingid' => $listid,
        ]);
    for($j=0;$j<count($safetychecklist);$j++)
    {
        $safetylisting = new Safetylisting();
        $safetydata = $safetylisting->find()->where(['listingid'=>$listid,'safetyid'=>$safetychecklist[$j]])->one();
        if(count($safetydata)==0)
        {
            $safetylisting->listingid = $listid;
            $safetylisting->safetyid = $safetychecklist[$j];
            $safetylisting->save();
        }
    }
  }
    $randno =  base64_encode($listdata->id."_".rand(1,9999));
    $redirecturl = Yii::$app->urlManager->createAbsoluteUrl("/user/listing/view/".$randno);
    echo $redirecturl;
}

/*
 * Function to get the currency symbol
 */
public function actionGetcurrencysymbol()
{
    $currencyid = $_POST['currencyid'];
    $model = new Currency();
    $currencydata = Currency::find()->where(['id'=>$currencyid])->one();
    
    $stripe_USD = Myclass::getcurrencyprice('USD'); 
    $list_CUR = $currencydata->price; 
    
    $stripe_money = ceil(($stripe_USD * 10) * ($list_CUR));

    echo $currencydata->currencysymbol."***".$stripe_money; 
    return false;
}


public function object_to_array($obj) {
    if(is_object($obj)) $obj = (array) dismount($obj);
    if(is_array($obj)) {
        $new = array();
        foreach($obj as $key => $val) {
            $new[$key] = object_to_array($val);
        }
    }
    else $new = $obj;
    return $new;
  } 

function return_bytes($val) {
    $last = strtolower($val[strlen($val)-1]);

    if($last == "g" || $last == "m" || $last == "k") {
        $split = explode($last, strtolower($val));
        $val = $split[0];
    } else {
        $last = false; 
    }

    switch($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;  
}   

/*
 * Function to upload the listing image
 */
public function actionStartfileupload()
{
    $image = array();
    $baseUrl = Yii::$app->request->baseUrl;
    $cnt = 0;
    foreach ($_FILES["images"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $name = $_FILES["images"]["name"][$key];
            $max_upload = $this->return_bytes(ini_get('upload_max_filesize'));
            $filesize = filesize($_FILES["images"]["tmp_name"][$key]);
            if($filesize<=$max_upload)
            {
                $ext = strrchr($name, '.');
                $userid = \Yii::$app->user->identity->id;
                $newname = time().'_'.$userid.'_'.$key.$ext;
                $path = realpath ( Yii::$app->basePath . "/web/albums/images/listings/" ) . "/";
                move_uploaded_file( $_FILES["images"]["tmp_name"][$key], $path .$newname);
                array_push($image,$newname);
                echo '<div class="listimgdiv"><img src="'.$baseUrl.'/albums/images/listings/'.$newname.'" style="width:70px;height:70px;">
                <i class="fa fa-remove listclose" style="cursor:pointer;" id="remove_'.$newname.'" onclick="remove_image(this,\''.$newname.'\')"></i>
            </div>
            ';
        }
        else if($filesize>$max_upload)
        {
            $cnt++;
        }
    }
    else
    {
        $cnt++;
    }
}
if($cnt==0)
{
    echo "***";echo json_encode($image);
}
else
{
        //echo "error";
}
return false;   
}

/*
 * Function to get the price details for the list after selecting the checkin and checkout date and before payment
 */
public function actionShowpricedetail()
{
    /*if (Yii::$app->user->isGuest) {
       echo "invalid";
    } else {*/ 
        if(isset($_POST['listid']) && isset($_POST['start_date']) && isset($_POST['end_date'])) {
            $start_date = trim($_POST['start_date']);
            $end_date = trim($_POST['end_date']);
            $listid = trim($_POST['listid']);

            $checkStartDate  = explode('/', $start_date);
            $checkEndDate  = explode('/', $end_date);

            if (count($checkStartDate) == 3 && count($checkEndDate) == 3 && $listid > 0) {
                if (checkdate(trim($checkStartDate[0]), trim($checkStartDate[1]), trim($checkStartDate[2])) && checkdate(trim($checkEndDate[0]), trim($checkEndDate[1]), trim($checkEndDate[2]))) {

                    $listdata = Listing::find()->where(['id'=>$listid])->one();
                    if($listdata->booking == "perhour") {
                        $booking_timing = (isset($_POST['booking_time'])) ? trim($_POST['booking_time']):"";
                        $bookingTiming = explode('-',$booking_timing);
                        if(count($bookingTiming) == 2) {
                            $fromtime = strtotime($start_date." ".$bookingTiming[0]);
                            $totime = strtotime($end_date." ".$bookingTiming[1]);
                            $total_period = round(($totime - $fromtime)/3600, 1);
                        }          
                    } else {
                       $fromtime = date('m/d/Y', strtotime($start_date));
                       $totime = date('m/d/Y', strtotime($end_date));
                       $total_period = strtotime($totime) - strtotime($fromtime);
                       $total_period =  round($total_period / (60 * 60 * 24));
                    }

                    if($total_period <= 0) {
                        echo "invalid"; die;
                    }

                    // Declaration & Initialisation.
                    $weekend_count = 0;   $totalpercent = 0;   $listtotalprice = 0;    
                    $commissionamount = 0;   $siteamount = 0;    $weekendTotalFee = 0;
                    $listpricearray = array();
                    $pricearray = array();

                    $pricearray['list'] = array();
                    $pricearray['push'] = array();
                    $pricearray['date'] = array(); 
                    $pricearray['week_days'] = NULL;
                    $pricearray['normal_days'] = NULL;
                    $pricearray['special_price'] = NULL; 
                    $pricearray['special_count'] = NULL;  
                      

                    // Assign
                    $total_days = $total_period;

                    if($listdata->booking == "pernight")
                        $nameofdays = ($total_period > 1) ? "Nights" : "Night";
                    else
                        $nameofdays = ($total_period > 1) ? "Hours" : "Hour";

                    //Calculate Number of weekends
                    $currencydata = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();

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

                    $pricearray['currency_code'] = $currency_code; 
                    $pricearray['currency_symbol'] = $currency_symbol; 

                    $weDate = ($listdata->booking == "pernight") ? date("m/d/Y",strtotime($end_date.'-1 days')) : $end_date;

                    for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) {
                        $a_day = (strtolower(date('l', $pDate))); 
                        if($a_day == "friday" || $a_day == "saturday") {
                            ++$weekend_count;
                        }
                        array_push($pricearray['date'], trim(date('m/d/y',$pDate)));
                    }

                    $specialPriceVal = json_decode($listdata->specialprice);
                    if($listdata->splpricestatus == 1 && !empty($listdata->specialprice) && count($specialPriceVal) > 0) {
                        for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) { 
                      
                            foreach ($specialPriceVal as $akey => $splVal) {
                                $a_startdate = strtotime(trim($splVal->specialstartDate));
                                $a_enddate = strtotime(trim($splVal->specialendDate));

                                if ($a_startdate==$pDate || $a_enddate==$pDate || ($pDate>$a_startdate && $pDate<$a_enddate)) {
                                    $a_day = (strtolower(date('l', $pDate))); 
                                    if($a_day == "friday" || $a_day == "saturday") {
                                      --$weekend_count;
                                    }
                                    $listpricearray[count($listpricearray)] = trim($splVal->specialprice);

                                    array_push($pricearray['push'], trim(date('m/d/y',$pDate)));  
                                    $count = $pDate;
                                    $pricearray['list'][$count]['date'] = date('m/d/y',$pDate); 
                                    $pricearray['list'][$count]['timestamp'] = $pDate; 
                                    $pricearray['list'][$count]['price'] = number_format(round($rate * (trim($splVal->specialprice)/$rate2),2),2,".","");
                                    $pricearray['list'][$count]['listprice'] = trim($splVal->specialprice);
                                    $pricearray['list'][$count]['type'] = "special";  
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

                            $pricearray['week_days'] = $weekend_count;

                            if(count($pricearray['push']) < count($pricearray['date'])) {
                                $arrayDiff = array_diff($pricearray['date'],$pricearray['push']);

                                foreach($arrayDiff as $val) {
                                    $a_day = (strtolower(date('l', strtotime($val)))); 
                                    if($a_day == "friday" || $a_day == "saturday") {
                                        array_push($pricearray['push'], trim(date('m/d/y',strtotime($val)))); 
                                        $count = strtotime($val); 
                                        $pricearray['list'][$count]['date'] = date('m/d/y',strtotime($val)); 
                                        $pricearray['list'][$count]['timestamp'] = strtotime($val); 
                                        $pricearray['list'][$count]['price'] = number_format(round($rate * (trim($weekendData->weekend_price)/$rate2),2),2,".","");
                                        $pricearray['list'][$count]['listprice'] = trim($weekendData->weekend_price);
                                        $pricearray['list'][$count]['type'] = "week";
                                    } 
                                }
                            } 
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
                           $normalprice = $listdata->hourlyprice;
                        } else {
                           $normalprice = $listdata->nightlyprice;
                        }
                        $listtotalprice = $listtotalprice + ($normalprice * $total_days);
                        $pricearray['normal_days'] = $total_days;

                        if(count($pricearray['push']) < count($pricearray['date'])) {
                            $arrayDiff = array_diff($pricearray['date'],$pricearray['push']);

                            foreach($arrayDiff as $val) {
                                
                                array_push($pricearray['push'], trim(date('m/d/y',strtotime($val)))); 
                                $count = strtotime($val);   
                                $pricearray['list'][$count]['date'] = date('m/d/y',strtotime($val)); 
                                $pricearray['list'][$count]['timestamp'] = strtotime($val); 
                                $pricearray['list'][$count]['price'] = number_format(round($rate * (trim($normalprice)/$rate2),2),2,".","");   
                                $pricearray['list'][$count]['listprice'] = trim($normalprice);  
                                $pricearray['list'][$count]['type'] = "normal";   

                            }
                        }
                    }

                    if(count($listpricearray) == 0 && $weekend_count == 0) {
                        $unitprice = ($listdata->booking == "perhour") ? $listdata->hourlyprice : $listdata->nightlyprice;
                    } else {
                        $unitprice = round(($listtotalprice / $total_period),2);
                    }

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

                    $unitprice = number_format(round(($rate * ($unitprice/$rate2)),2),2,".","");
                    $taxamount = round($rate * ($taxamount/$rate2),2);  
                    $siteamount = round($rate * ($siteamount/$rate2),2);
                    $commissionamount = round($rate * ($commissionamount/$rate2),2);
                    $securitydeposit = round($rate * ($securitydeposit/$rate2),2);
                    $servicefees = round($rate * ($servicefees/$rate2),2);
                    $cleaningfees = round($rate * ($cleaningfees/$rate2),2);

                    $listtotalprice = round($rate * ($listtotalprice/$rate2),2);

                    $totalamount = $taxamount + $siteamount + $commissionamount + $listtotalprice + $securitydeposit + $servicefees + $cleaningfees; 

                    $stripe_USD = Myclass::getcurrencyprice('USD');
                    $list_CUR = Myclass::getcurrencyprice($currency_code); 
                    $stripe_money = round($stripe_USD * ($totalamount/$list_CUR),2);
 
                    $noofAssigneddate = "0";
                    $specialsPrice = "0"; 

                    asort($pricearray['list']); 
                    unset($pricearray['push']);
                    unset($pricearray['date']);
                    $pricePopup = " "; 
                    $pricePopupCalc = 0;   
                    $pricePopupShow = 0;

                    if($listdata->booking == "pernight") {
                        if($pricearray['week_days'] > 0 || $pricearray['special_count'] > 0) {
                            $pricePopupShow = 1;
                        }
                        foreach ($pricearray['list'] as $key => $value) {
                            $pricePopup .= '<tr class="border_bottom">
                                <td class="popCol" colspan="2">'.$value['date'].'</td>
                                <td class="popCol pricepopCol">'.$currency_symbol.' '.$value['price'].'</td> 
                            </tr>';
                            $pricePopupCalc += $value['price']; 
                        }
                        $pricePopup = '<svg role="presentation" focusable="false" style="right: 25px;"><path class="path1" d="M0,0 20,0 10,10z"></path>
                          <path class="path2" d="M0,0 10,10 20,0"></path>
                        </svg>
                        <div class="calcPopup">   
                            <table class="">
                                <tbody>
                                    <tr class="border_bottom">
                                      <td class="popCol" colspan="3"> 
                                        <span class="">'.Yii::t('app','Base Price Breakdown').'</span>
                                      </td>
                                    </tr>'.$pricePopup.'<tr class="border_bottom">
                                      <td class="popCol" colspan="2">
                                        <span class="">'.Yii::t('app','Total Base Price').'</span>
                                      </td>
                                      <td class="popCol">  
                                        <span class="">'.$currency_symbol.' '.number_format(round($pricePopupCalc,2),2,".","").'</span> 
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="popCol" colspan="3">'.Yii::t('app','Average nightly rate is rounded').'.</td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>';    
                    } 
                    
                    echo $unitprice."***".$listtotalprice."***".$commissionamount."***".$siteamount."***".$taxamount."***".$securitydeposit."***".$total_period."***".$nameofdays."***".$noofAssigneddate."***".$specialsPrice."***".$cleaningfees."***".$servicefees."***".$totalamount."***".$pricePopup."***".$pricePopupShow."***".$stripe_money;    

                    die;
                }
            }
        }
        echo "invalid"; 
    /*} */
      
}

/*
 * Function to show booking time
 */
public function actionShowbookingtime()
{
    $startdate = strtotime($_POST['date']);
    $booking = $_POST['booking'];
    $listid = $_POST['listid'];
    $flag = trim($_POST['flag']);

    if($flag == "contacthost") {
        $bookid = "contact_booking_time";
    } else {
        $bookid = "booking_time"; 
    }

    $pernightbooked=0;
    $todaydate = date('m/d/Y');
    $today = strtotime($todaydate);
    $listing = Listing::find()->where(['id'=>$listid])->one();
    $hourly_availablity=explode(',',$listing->hourly_availablity);  
    $hourly_availablity=array_filter($hourly_availablity);

    if($booking=='perhour'){
        $reservations = Reservations::find()->where(['listid'=>$listid])
        ->andWhere(['!=','bookstatus','cancelled'])
        ->andWhere(['!=','bookstatus','declined'])
        ->andWhere(['!=','bookstatus','refunded'])
        ->andWhere(['>','inquiryid', 0]) 
        ->andWhere(['=','todate',$startdate])
        ->all();
        $reservation_count=count($reservations);
        $hourly_availablity_array=array();
        $newhourly_availablity_array=array();
        if($reservation_count>0)
         {  
            foreach($reservations as $res)
                {
                    $reservation_hours=$res->hourly_booked;
                    if($res->booking=='perhour')
                    {
                        array_push($hourly_availablity_array,$reservation_hours);
                    }
                    else
                    {
                        $pernightbooked=1;
                    }
                    
                }
                $diff = array_values(array_diff($hourly_availablity,$hourly_availablity_array));
                if($pernightbooked==1){
                    $listinghours=explode('*|*',$listing->pernight_availablity);
                    $listinghours_end=$listinghours[1];
                }
                else
                {
                    $listinghours_end=0;
                }

                 $currentTimezone = Myclass::getTime($listing->timezone);
                  date_default_timezone_set('UTC'); 
                  $currenttime=strtotime($currentTimezone);

                if($startdate==$today)
                {
                    $currenttime=date("H:i",$currenttime);
                    for($b=0;$b<count($diff);$b++)
                    {
                        $diffhours=explode('*|*',$diff[$b]);
                        if($diffhours[0]>$listinghours_end && $diffhours[0]>$currenttime)
                        {   
                            array_push($newhourly_availablity_array,$diff[$b]);

                        }
                    }
                }
                else
                {
                    $currenttime=date("H:i",$currenttime);
                    for($b=0;$b<count($diff);$b++)
                    {
                        $diffhours=explode('*|*',$diff[$b]);
                        if($diffhours[0]>$listinghours_end)
                        {   
                            array_push($newhourly_availablity_array,$diff[$b]);
                        }  
                    }
                    
                }

                
                $diff=array();
                $diff=$newhourly_availablity_array;
                echo '<label>'. Yii::t('app','Booking Time').'</label>
                <select class="form-control" id="'.$bookid.'" onchange="changehours();">';
                    $hourly_availablity_count=count($diff);
                    if($hourly_availablity_count>0){echo'<option value="">Select Booking</option>';}else{
                        echo'<option value="">No Booking Available</option>';
                    }
                    for($a=0;$a<$hourly_availablity_count;$a++)
                    {
                        $currentTimezone = Myclass::getTime($listing->timezone);
                        date_default_timezone_set('UTC'); 

                        $hours = str_replace('*|*', '-', $diff[$a]);
                        $booking_times=explode('-',$hours);
                        $booking_start=date("h:i A", strtotime($booking_times[0]));
                        $booking_end=date("h:i A", strtotime($booking_times[1]));
                        $booking_hourtiming=$booking_times[0].'-'.$booking_times[1];
                        $booking_hours=$booking_start.'-'.$booking_end;

                        $timezoneStartDate = date('m/d/Y',$startdate);
                        $timezoneDate = strtotime($timezoneStartDate." ".trim($booking_times[0].":00")); 
                        if($timezoneDate > $currentTimezone)
                           echo '<option value="'.$booking_hourtiming.'">'.$booking_hours.'</option>';  
                    }
                    echo '</select>
                    <div class="errcls centertxt" id="booking_time_err"></div>';


         }
         else
         {
              if($startdate==$today)
              {
                  
                  $currentTimezone = Myclass::getTime($listing->timezone);
                  date_default_timezone_set('UTC'); 
                  $currenttime=strtotime($currentTimezone);
                  $currenttime=date("H:i",$currenttime);
                  for($b=0;$b<count($hourly_availablity);$b++)
                  {
                      $diffhours=explode('*|*',$hourly_availablity[$b]);
                      if($diffhours[0]>$currenttime) 
                      {   
                          array_push($newhourly_availablity_array,$hourly_availablity[$b]);

                      }
                  } 
                  $hourly_availablity=array();
                  $hourly_availablity=$newhourly_availablity_array;
              }

              echo '<label>'. Yii::t('app','Booking Time').'</label>
              <select class="form-control" id="'.$bookid.'" onchange="changehours();">';
                  $hourly_availablity_count=count($hourly_availablity); 
                  if($hourly_availablity_count>0){echo'<option value="">Select Booking</option>';}else{
                      echo'<option value="">No Booking Available</option>';
                  } 
                  for($a=0;$a<$hourly_availablity_count;$a++)
                  {
                      $hours = str_replace('*|*', '-', $hourly_availablity[$a]);
                      $booking_times=explode('-',$hours);
                      $booking_start=  date("h:i A", strtotime($booking_times[0]));
                      $booking_end=  date("h:i A", strtotime($booking_times[1]));
                      $booking_hourtiming=$booking_times[0].'-'.$booking_times[1];
                      $booking_hours=$booking_start.'-'.$booking_end;
                      echo '<option value="'.$booking_hourtiming.'">'.$booking_hours.'</option>';
                  }
                  echo '</select>
                  <div class="errcls centertxt" id="booking_time_err"></div>';
              }
          }
          else
          {   
              echo '';
          }
      }



            public function actionShowbookingtimemobile()
            {
                $startdate = strtotime($_POST['date']);
                $booking = $_POST['booking'];
                $listid = $_POST['listid'];
                $pernightbooked=0;
                $todaydate = date('m/d/Y');
                $today = strtotime($todaydate);
                $listing = Listing::find()->where(['id'=>$listid])->one();
                $hourly_availablity=explode(',',$listing->hourly_availablity);  
                $hourly_availablity=array_filter($hourly_availablity);
                if($booking=='perhour'){
                    $reservations = Reservations::find()->where(['listid'=>$listid])
                    ->andWhere(['!=','bookstatus','cancelled'])
                    ->andWhere(['!=','bookstatus','declined'])
                    ->andWhere(['=','todate',$startdate])
                    ->all();
                    $reservation_count=count($reservations);
                    $hourly_availablity_array=array();
                    $newhourly_availablity_array=array();
                    if($reservation_count>0)
                        {  foreach($reservations as $res) {
                                $reservation_hours=$res->hourly_booked;
                                if($res->booking=='perhour')
                                {
                                    array_push($hourly_availablity_array,$reservation_hours);
                                }
                                else
                                {
                                    $pernightbooked=1;
                                }
                            }
                            $diff = array_values(array_diff($hourly_availablity,$hourly_availablity_array));
                            if($pernightbooked==1){
                                $listinghours=explode('*|*',$listing->pernight_availablity);
                                $listinghours_end=$listinghours[1];
                            }
                            else
                            {
                                $listinghours_end=0;
                            }
                            if($startdate==$today){
                                $currenttime=time();
                                $currenttime=date("H:i",$currenttime);
                                for($b=0;$b<count($diff);$b++)
                                {
                                    $diffhours=explode('*|*',$diff[$b]);
                                    if($diffhours[1]>$listinghours_end && $diffhours[1]>$currenttime)
                                    {   
                                        array_push($newhourly_availablity_array,$diff[$b]);

                                    }
                                }
                            }
                            else
                            {
                                $currenttime=time();
                                $currenttime=date("H:i",$currenttime);
                                for($b=0;$b<count($diff);$b++)
                                {
                                    $diffhours=explode('*|*',$diff[$b]);
                                    if($diffhours[1]>$listinghours_end)
                                    {   
                                        array_push($newhourly_availablity_array,$diff[$b]);
                                    }
                                }
                            }
                            $diff=array();
                            $diff=$newhourly_availablity_array;
                //print_r($diff);
                //die;
                            echo '<select class="mobile-cal-input-100 airfcfx-guest-count form-control form_text2 guest-count" id="booking_time_mobile" onchange="changehours_mobile();">';
                            $hourly_availablity_count=count($diff);
                            if($hourly_availablity_count>0){echo'<option value="">Select Booking Time</option>';}else{
                                echo'<option value="">No Booking Available</option>';
                            }
                            for($a=0;$a<$hourly_availablity_count;$a++)
                            {
                                $hours = str_replace('*|*', '-', $diff[$a]);
                                $booking_times=explode('-',$hours);
                                $booking_start=date("h:i A", strtotime($booking_times[0]));
                                $booking_end=date("h:i A", strtotime($booking_times[1]));
                                $booking_hourtiming=$booking_times[0].'-'.$booking_times[1];
                                $booking_hours=$booking_start.'-'.$booking_end;
                                echo '<option value="'.$booking_hourtiming.'">'.$booking_hours.'</option>';
                            }
                            echo '</select>
                            <div class="errcls centertxt" id="booking_time_err"></div>';


                        }
                        else
                        {
                            if($startdate==$today){
                                $currenttime=time();
                                $currenttime=date("H:i",$currenttime);
                                for($b=0;$b<count($hourly_availablity);$b++)
                                {
                                    $diffhours=explode('*|*',$hourly_availablity[$b]);
                                    if($diffhours[1]>$currenttime)
                                    {   
                                        array_push($newhourly_availablity_array,$hourly_availablity[$b]);

                                    }
                                }
                                $hourly_availablity=array();
                                $hourly_availablity=$newhourly_availablity_array;
                            }

                            echo '<select class="mobile-cal-input-100 airfcfx-guest-count form-control form_text2 guest-count" id="booking_time_mobile" onchange="changehours_mobile();">';
                            $hourly_availablity_count=count($hourly_availablity);
                            if($hourly_availablity_count>0){echo'<option value="">Select Booking Time</option>';}else{
                                echo'<option value="">No Booking Available</option>';
                            }
                            for($a=0;$a<$hourly_availablity_count;$a++)
                            {
                                $hours = str_replace('*|*', '-', $hourly_availablity[$a]);
                                $booking_times=explode('-',$hours);
                                $booking_start=  date("h:i A", strtotime($booking_times[0]));
                                $booking_end=  date("h:i A", strtotime($booking_times[1]));
                                $booking_hourtiming=$booking_times[0].'-'.$booking_times[1];
                                $booking_hours=$booking_start.'-'.$booking_end;
                                echo '<option value="'.$booking_hourtiming.'">'.$booking_hours.'</option>';
                            }
                            echo '</select>
                            <div class="errcls centertxt" id="booking_time_err"></div>';
                        }
                    }
                    else
                    {   
                        echo '';
                    }
                }

/*********************************** STRIPE CODE ***********************************/

public function actionSendrequest()
{  
    $this->layout = "payment";
    if (Yii::$app->user->isGuest) {
        $randno =  base64_encode(trim($_POST['checkoutpay_listid'])."_".rand(1,9999));  
        $_SESSION['RedirectUrl'] = $randno;
        $_SESSION['RedirectCategory'] = "Listing"; 
        return $this->redirect(['/signin']); 
    } else if(isset($_POST['checkoutpay_listid']) && isset($_POST['checkoutpay_book_type']) && (trim($_POST['checkoutpay_book_type'])=="reserve" || trim($_POST['checkoutpay_book_type'])=="inquiry")) 
    {
      $listid = trim($_POST['checkoutpay_listid']);
      $callType = trim($_POST['checkoutpay_book_type']);

      $loguserid = \Yii::$app->user->identity->id;
      $logUserDetails = User::find()->where(['id' => $loguserid])->One();

      if($logUserDetails->emailverify != '1') {
        Yii::$app->getSession ()->setFlash ( 'success', 'Kindly verify your email before purchase.' );
        return $this->redirect(['/trust']);     
      }

      if($logUserDetails->userstatus != '1') {  
        Yii::$app->getSession ()->setFlash ( 'success', 'Sorry user access blocked by admin.' );
        Yii::$app->user->logout ();
        return $this->goHome ();     
      }

      if(count($_POST) < 5 && $callType == "reserve") {
         Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request' );
        $randno =  base64_encode($listid."_".rand(1,9999));
        return $this->redirect(['/user/listing/view/'.$randno]);
      } elseif (count($_POST) < 2 && $callType == "inquiry") {
         Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request' );
         return $this->redirect(['/user/messages/inbox/traveling']);
      } else {
         // Declaration & Initialisation.
         $total_period = 0;
         $booking_timing = "";
         $inquiryId = "";
         if($callType == "inquiry") {
            $inquiryId = trim($_POST['checkoutpay_inquiryid']);
            $inquiryData = Inquiry::find()->where(['id'=> $inquiryId])->one();
            $listdata = Listing::find()->where(['id'=>$inquiryData->listingid])->one();

            $reservedurationType = trim($listdata->booking);
            if($reservedurationType == "pernight") {
                $s_datetime = strtotime(date('m/d/Y', strtotime($inquiryData->checkin)));
                $e_datetime = strtotime(date('m/d/Y', strtotime($inquiryData->checkout.'-1 days')));

                $otherguestreservations = Reservations::find()->where(['listid'=>$inquiryData->listingid]) 
                ->andWhere(['=','fromdate',$s_datetime])
                ->andWhere(['=','todate',$e_datetime])
                ->andWhere(['!=','bookstatus','refunded'])
                ->andWhere(['!=','bookstatus','declined']) 
                ->one();
            } else {
                $s_datetime = $inquiryData->checkin;
                $e_datetime = $inquiryData->checkout;

                $otherguestreservations = Reservations::find()->where(['listid'=>$inquiryData->listingid])
                ->andWhere(['=','checkin',$s_datetime])
                ->andWhere(['=','checkout',$e_datetime])
                ->andWhere(['!=','bookstatus','refunded'])
                ->andWhere(['!=','bookstatus','declined']) 
                ->one(); 
            }

            if(count($otherguestreservations) > 0){
                Yii::$app->getSession ()->setFlash ( 'success', 'Guest already booked this listing' );
                return $this->goHome (); 
            }

            if(count($inquiryData) <= 0 || $loguserid != $inquiryData->senderid || $listdata->userid != $inquiryData->receiverid) {
               Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request');
               return $this->redirect(['/user/messages/inbox/traveling']);
            }

            $guests = trim($inquiryData->guest);
            
            if($listdata->booking == "perhour") {
                $start_date = date('m/d/Y', strtotime($inquiryData->checkin));
                $end_date = date('m/d/Y', strtotime($inquiryData->checkout));
                $fromtime = strtotime($inquiryData->checkin);
                $totime = strtotime($inquiryData->checkout);
                $total_period = round(($totime - $fromtime)/3600, 1);
                $booking_timing = date("H:i",$fromtime)."-".date("H:i",$totime);
            } else {
                $start_date = date('m/d/Y', strtotime($inquiryData->checkin));
                $end_date = date('m/d/Y', strtotime($inquiryData->checkout));
                $total_period = strtotime($end_date) - strtotime($start_date);
                $total_period =  round($total_period / (60 * 60 * 24));
            }
         } else {
            $listdata = Listing::find()->where(['id'=>$listid])->one();
            $guests = trim($_POST['checkoutpay_guests']);
            $start_date = trim($_POST['checkoutpay_startdate']);
            $end_date = trim($_POST['checkoutpay_enddate']);

            if($listdata->booking == "perhour") {
               $booking_timing = (isset($_POST['checkoutpay_booking_time'])) ? trim($_POST['checkoutpay_booking_time']):"";
               $bookingTiming = explode('-',$booking_timing);
               if(count($bookingTiming) == 2) {
                  $fromtime = strtotime($start_date." ".$bookingTiming[0]);
                  $totime = strtotime($end_date." ".$bookingTiming[1]);
                  $total_period = round(($totime - $fromtime)/3600, 1);
               }             
            } else {
               $fromtime = date('m/d/Y', strtotime($start_date));
               $totime = date('m/d/Y', strtotime($end_date));
               $total_period = strtotime($totime) - strtotime($fromtime);
               $total_period =  round($total_period / (60 * 60 * 24));
            }
         }

        if($total_period <= 0 || $guests <= 0) {
            Yii::$app->getSession ()->setFlash ( 'success', 'Something Went Wrong.' );
            $randno =  base64_encode($listdata->id."_".rand(1,9999));
            return $this->redirect(['/user/listing/view/'.$randno]);
        } 

        $blockedCount = 0;
        $blockPrice = ($listdata->blockedspecialprice!="" && $listdata->blockedspecialprice != NULL) ? json_decode($listdata->blockedspecialprice) : NULL;
        $weDate = ($listdata->booking == "pernight") ? date("m/d/Y",strtotime($end_date.'-1 days')) : $end_date;

        if(count($blockPrice) > 0) {
            $count=count($blockPrice);
            for($i=0; $i<$count; $i++) {
                $cell = $blockPrice[$i];

                if($cell->liststatus == 'blocked') {
                    for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) {
                        if($pDate >= strtotime($cell->specialstartDate) && $pDate <= strtotime($cell->specialendDate)) {
                            ++$blockedCount;
                        }
                    }
                }
            }
        }

        if($blockedCount > 0) {
            Yii::$app->getSession ()->setFlash ( 'success', 'Preferred booking date are blocked.' );
            $randno =  base64_encode($listdata->id."_".rand(1,9999));
            return $this->redirect(['/user/listing/view/'.$randno]);
        } 

         // Declaration & Initialisation.
         $weekend_count = 0;   $totalpercent = 0;   $listtotalprice = 0;    
         $commissionamount = 0;   $siteamount = 0;    $weekendTotalFee = 0;
         $listpricearray = array();

         // Assign
         $total_days = $total_period;

         //Calculate Number of weekends

         for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) {
             $a_day = (strtolower(date('l', $pDate))); 
             if($a_day == "friday" || $a_day == "saturday") {
                 ++$weekend_count;
             }
         }

         $specialPriceVal = json_decode($listdata->specialprice);
         if($listdata->splpricestatus == 1 && !empty($listdata->specialprice) && count($specialPriceVal) > 0) {
            for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) { 
              
              foreach ($specialPriceVal as $akey => $splVal) {
                  $a_startdate = strtotime(trim($splVal->specialstartDate));
                  $a_enddate = strtotime(trim($splVal->specialendDate));

                  if ($a_startdate==$pDate || $a_enddate==$pDate || ($pDate>$a_startdate && $pDate<$a_enddate)) {
                      $a_day = (strtolower(date('l', $pDate))); 
                      if($a_day == "friday" || $a_day == "saturday") {
                          --$weekend_count;
                      }
                      $listpricearray[count($listpricearray)] = trim($splVal->specialprice);
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
            }
         }   

         if($listdata->splpricestatus == 1 && count($listpricearray) > 0) {             
            if($listdata->booking == "perhour" && $listdata->hourlyprice != NULL) {
               $listtotalprice = $listtotalprice + (array_sum($listpricearray) * $total_days);
               $total_days = 0;
            } else {
               $total_days = $total_days - count($listpricearray);
               $listtotalprice = $listtotalprice + array_sum($listpricearray);
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
            $normalprice = ($listdata->booking == "perhour" && $listdata->hourlyprice != NULL) ? $total_days * $listdata->hourlyprice : $total_days * $listdata->nightlyprice;        

            $listtotalprice = $listtotalprice + $normalprice;
         }

         if(count($listpricearray) == 0 && $weekend_count == 0) {
             $unitprice = ($listdata->booking == "perhour") ? $listdata->hourlyprice : $listdata->nightlyprice;
         } else {
             $unitprice = round(($listtotalprice / $total_period),2);
         }

         $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
         $currencydata = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();

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
         }

         $paycurrency = Currency::find()->where(['currencycode'=>$currency_code])->one();

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

         $taxamount = round($rate * ($taxamount/$rate2),2);
         $siteamount = round($rate * ($siteamount/$rate2),2);
         $commissionamount = round($rate * ($commissionamount/$rate2),2);
         $securitydeposit = round($rate * ($securitydeposit/$rate2),2);
         $servicefees = round($rate * ($servicefees/$rate2),2);
         $cleaningfees = round($rate * ($cleaningfees/$rate2),2);

         $listtotalprice = round($rate * ($listtotalprice/$rate2),2);

         $grandTotal = $taxamount + $siteamount + $commissionamount + $listtotalprice + $securitydeposit + $servicefees + $cleaningfees;
                
         return $this->render('payrequest',[
         'adminprice' => $grandTotal, // Grand Total
         'paycurrency' => $paycurrency,
         'sitesetting' => $sitesetting,
         //'days' => $total_period, //Total days
         'guests' => $guests,
         'sdate' => $start_date, // date format
         'edate' => $end_date,
        // 'booking' => $listdata->booking,
         'booking_timing' => $booking_timing,
         'listid' => $listdata->id,
         'callType' => $callType,
         'inquiryId' => $inquiryId

         ]);  
      }
   } else {
      Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request.' );
      return $this->goHome ();
   }
}

public function actionPayprocess()
{ 
   if(isset($_POST['listid']) && isset($_POST['calltype']) && (trim($_POST['calltype'])=="reserve" || trim($_POST['calltype'])=="inquiry")) {
    
      $listid = trim($_POST['listid']);
      $callType = trim($_POST['calltype']);
      $loguserid = \Yii::$app->user->identity->id;

      if(count($_POST) < 7 && $callType == "reserve") {
         Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request' );
        $randno =  base64_encode($listid."_".rand(1,9999));
        return $this->redirect(['/user/listing/view/'.$randno]);
      } elseif (count($_POST) < 5 && $callType == "inquiry") {
         Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request' );
         return $this->redirect(['/user/messages/inbox/traveling']);
      } elseif (!isset($_POST['paytoken']) || !isset($_POST['paycurrency'])) {
         Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request.' );
         return $this->goHome ();
      } else {
         $total_period = 0;
         $booking_timing = "";
         $inquiryId = "";

         if($callType == "inquiry") {
            $inquiryId = trim($_POST['inquiryid']);
            $inquiryData = Inquiry::find()->where(['id'=> $inquiryId])->one();

            if(count($inquiryData) > 0 && $loguserid == $inquiryData->senderid && $inquiryData->type=="inquiry") 
            {
                $listdata = Listing::find()->where(['id'=>$inquiryData->listingid])->one();

                if(count($listdata) > 0 && $listdata->userid == $inquiryData->receiverid) {
                  $guests = trim($inquiryData->guest);
               
                  if($listdata->booking == "perhour") {
                      $start_date = date('m/d/Y', strtotime($inquiryData->checkin));
                      $end_date = date('m/d/Y', strtotime($inquiryData->checkout));
                      $fromtime = strtotime($inquiryData->checkin);
                      $totime = strtotime($inquiryData->checkout);
                      $total_period = round(($totime - $fromtime)/3600, 1);
                      $booking_timing = date("H:i",$fromtime)."-".date("H:i",$totime);
                  } else {
                      $start_date = date('m/d/Y', strtotime($inquiryData->checkin));
                      $end_date = date('m/d/Y', strtotime($inquiryData->checkout));
                      $total_period = strtotime($end_date) - strtotime($start_date);
                      $total_period =  round($total_period / (60 * 60 * 24));
                  }
               } else {
                  Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request');
                  return $this->redirect(['/user/messages/inbox/traveling']);
               }
            } else {
               Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request');
               return $this->redirect(['/user/messages/inbox/traveling']);
            }
         } else {
            $listdata = Listing::find()->where(['id'=>$listid])->one();
            $guests = trim($_POST['guests']);
            $start_date = trim($_POST['sdate']);
            $end_date = trim($_POST['edate']);

            if($listdata->booking == "perhour") {
               $booking_timing = (isset($_POST['booking_timing'])) ? trim($_POST['booking_timing']):"";
               $bookingTiming = explode('-',$booking_timing);
               // if need please check booking time to list hourly time
               if(count($bookingTiming) == 2) {
                  $fromtime = strtotime($start_date." ".$bookingTiming[0]);
                  $totime = strtotime($end_date." ".$bookingTiming[1]);
                  $total_period = round(($totime - $fromtime)/3600, 1);
               }             
            } else {
               $fromtime = date('m/d/Y', strtotime($start_date));
               $totime = date('m/d/Y', strtotime($end_date));
               $total_period = strtotime($totime) - strtotime($fromtime);
               $total_period =  round($total_period / (60 * 60 * 24));
            }
         }

         if($total_period <= 0 || $guests <= 0) {
            Yii::$app->getSession ()->setFlash ( 'success', 'Something Went Wrong.' );
            $randno =  base64_encode($listdata->id."_".rand(1,9999));
            return $this->redirect(['/user/listing/view/'.$randno]);
         } 

         // Declaration & Initialisation.
         $weekend_count = 0;   $totalpercent = 0;   $listtotalprice = 0;    
         $commissionamount = 0;   $siteamount = 0;    $weekendTotalFee = 0;
         $listpricearray = array();
         $pricearray = array();

         $pricearray['special'] = NULL;
         $pricearray['week'] = NULL;
         $pricearray['normal'] = NULL; 
         $pricearray['special_price'] = NULL; 
         $pricearray['special_count'] = NULL; 

         // Assign
         $total_days = $total_period;
         $paycurrency = trim($_POST['paycurrency']);

         //Calculate Number of weekends

        $weDate = ($listdata->booking == "pernight") ? date("m/d/Y",strtotime($end_date.'-1 days')) : $end_date;

        $blockedCount = 0;
        $blockPrice = ($listdata->blockedspecialprice!="" && $listdata->blockedspecialprice != NULL) ? json_decode($listdata->blockedspecialprice) : NULL;
       
        if(count($blockPrice) > 0) {
            $count=count($blockPrice);
            for($i=0; $i<$count; $i++) {
                $cell = $blockPrice[$i];

                if($cell->liststatus == 'blocked') {
                    for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) {
                        if($pDate >= strtotime($cell->specialstartDate) && $pDate <= strtotime($cell->specialendDate)) {
                            ++$blockedCount;
                        }
                    }
                }
            }
        }

        if($blockedCount > 0) {
            Yii::$app->getSession ()->setFlash ( 'success', 'Preferred booking date are blocked.' );
            return $this->goHome ();  
        } 

        for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) {
             $a_day = (strtolower(date('l', $pDate))); 
             if($a_day == "friday" || $a_day == "saturday") {
                 ++$weekend_count;
             }
        }

         $specialPriceVal = json_decode($listdata->specialprice);
         if($listdata->splpricestatus == 1 && !empty($listdata->specialprice) && count($specialPriceVal) > 0) {
            for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) { 
              
              foreach ($specialPriceVal as $akey => $splVal) {
                  $a_startdate = strtotime(trim($splVal->specialstartDate));
                  $a_enddate = strtotime(trim($splVal->specialendDate));

                  if ($a_startdate==$pDate || $a_enddate==$pDate || ($pDate>$a_startdate && $pDate<$a_enddate)) {
                      $a_day = (strtolower(date('l', $pDate))); 
                      if($a_day == "friday" || $a_day == "saturday") {
                          --$weekend_count;
                      }
                      $listpricearray[count($listpricearray)] = trim($splVal->specialprice);

                      $count = count($pricearray['special']);
                      $pricearray['special'][$count]['date'] = $pDate; 
                      $pricearray['special'][$count]['price'] = trim($splVal->specialprice);
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

               $pricearray['week']['price'] = $weekendData->weekend_price; 
               $pricearray['week']['days'] = $weekend_count;
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
               $pricearray['normal']['price'] = $listdata->hourlyprice;
            } else {
               $normalprice = $total_days * $listdata->nightlyprice;
               $pricearray['normal']['price'] = $listdata->nightlyprice;
            }
            $listtotalprice = $listtotalprice + $normalprice;
            $pricearray['normal']['days'] = $total_days;
         } 

         if(count($listpricearray) == 0 && $weekend_count == 0) {
             $unitprice = ($listdata->booking == "perhour") ? $listdata->hourlyprice : $listdata->nightlyprice;
         } else {
             $unitprice = round(($listtotalprice / $total_period),2);
         }

         $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
         $currencydata = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();

         if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="") {
            $currency_code = $_SESSION['currency_code'];          
         } else {
            $currency_code = "";
         }

         if($paycurrency != $currency_code) {
            Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Conversion Request.' );
            return $this->goHome ();
         } elseif ($paycurrency == $currency_code) {
            if($paycurrency == $currencydata->currencycode) {
               $rate = "1";    $rate2 = "1";    $convert_rate = "1";
            } else {
               //listing currency
               $rate2= Myclass::getcurrencyprice($currencydata->currencycode);
               //user currency
               $rate= Myclass::getcurrencyprice($currency_code);

               $convert_rate = $rate2 / $rate;
            }
         }

         $currency_code = $paycurrency;
         
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

         //$totalamount = $taxamount + $siteamount + $commissionamount + $listtotalprice + $securitydeposit + $servicefees + $cleaningfees;

         $tax_amount = round($rate * ($taxamount/$rate2),2);
         $site_amount = round($rate * ($siteamount/$rate2),2);
         $commission_amount = round($rate * ($commissionamount/$rate2),2);
         $security_deposit = round($rate * ($securitydeposit/$rate2),2);
         $service_fees = round($rate * ($servicefees/$rate2),2);
         $cleaning_fees = round($rate * ($cleaningfees/$rate2),2);

         $list_totalprice = round($rate * ($listtotalprice/$rate2),2);

         $totalamount = $tax_amount + $site_amount + $commission_amount + $list_totalprice + $security_deposit + $service_fees + $cleaning_fees; 
         
         $startdate = strtotime(trim($start_date));
         $enddate = strtotime(trim($end_date));

         if($paycurrency == "JPY" || $paycurrency == "jpy"){
            $payamout = ceil($totalamount);
            $totalamount = ceil($totalamount);
         } else {
            $payamout = $totalamount * 100;
            $totalamount = $totalamount;
         }

         $useremail = Yii::$app->user->identity->email;         
         $userform = new SignupForm();
         $userdata = $userform->findByEmail($useremail);
         $paytoken = trim($_POST['paytoken']);

         // stripe settlement
          $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();

         //set api key
         $stripe = array(
          "secret_key"      => $sitesettings->stripe_secretkey,
          "publishable_key" => $sitesettings->stripe_publishkey
         );
        
         \Stripe\Stripe::setApiKey($stripe['secret_key']);
        
         if($userdata->stripe_customer_id == NULL || empty($userdata->stripe_customer_id)) {
	        	//add customer to stripe
	        	$customer = \Stripe\Customer::create(array(
	           'email' => $useremail,
	           'source'  => $paytoken
	        	));
	        	$userdata->stripe_customer_id = $customer->id;
	        	$userdata->save();
	        	$stripe_customer_id = $customer->id;
	      } else {
	        	$stripe_customer_id = trim($userdata->stripe_customer_id);
	      }

         $charge = \Stripe\Charge::create(array(
            'customer' => $stripe_customer_id, 
            'amount'   => $payamout,
            'currency' => $paycurrency,
            'description' => 'charge from '.$useremail
         ));

         $striperesult = $charge->jsonSerialize();

         if ($striperesult['status'] == 'succeeded' && !empty($striperesult['id']) && !empty($striperesult['balance_transaction'])) {

            if($listdata->booking == "perhour") {
               $bookingtimeSplit = explode('-', $booking_timing);
               $checkInDateTime = date('Y-m-d H:i:s', strtotime(trim($start_date)." ".$bookingtimeSplit[0]));
               $checkOutDateTime = date('Y-m-d H:i:s', strtotime(trim($end_date)." ".$bookingtimeSplit[1]));
            } else {
               //$bookingtimeSplit = explode('*|*', $listingdata->pernight_availablity);
               $checkInDateTime = date('Y-m-d H:i:s', strtotime(trim($start_date)));
               $checkOutDateTime = date('Y-m-d H:i:s', strtotime(trim($end_date)));
            }

            $inquiryAll = Inquiry::find()->where(['senderid'=>$userdata->id, 'receiverid'=>$listdata->userid, 'listingid'=>$listid, 'checkin'=> $checkInDateTime, 'checkout'=> $checkOutDateTime])->orderBy('id desc')->all();  

            $inquiryData = Inquiry::find()->where(['senderid'=>$userdata->id, 'receiverid'=>$listdata->userid, 'listingid'=>$listid, 'checkin'=> $checkInDateTime, 'checkout'=> $checkOutDateTime, 'type'=>'inquiry'])->orderBy('id desc')->one(); 

            $reserveCount = new \yii\db\Query;
            $reserveCount->select(['hts_inquiry.*'])
            ->from('hts_inquiry')
            ->leftJoin('hts_reservations', 'hts_reservations.inquiryid = hts_inquiry.id')
            ->where(['hts_inquiry.senderid'=>$userdata->id, 'hts_inquiry.receiverid'=>$listdata->userid, 'hts_inquiry.listingid'=>$listid, 'hts_inquiry.checkin'=> $checkInDateTime, 'hts_inquiry.checkout'=> $checkOutDateTime, 'hts_inquiry.type'=>'booked'])
            ->andWhere(['or', ['=','hts_reservations.bookstatus','refunded'], ['=','hts_reservations.bookstatus','declined'] ]);

            $countQuery = clone $reserveCount; 
            $reserveCount = $countQuery->count();

            $reservationMessage = "Reservation made on your listing"." - ".trim($listdata->listingname);   

            if(count($inquiryAll) == 0 || ($callType == "reserve" && (count($inquiryAll) == $reserveCount))) {  
               $inquiryData = new Inquiry();
               $inquiryData->senderid = $userdata->id;
               $inquiryData->receiverid = $listdata->userid;
               $inquiryData->listingid = $listid;
               $inquiryData->type = 'booked';
               $inquiryData->checkin = $checkInDateTime;
               $inquiryData->checkout = $checkOutDateTime;
               $inquiryData->guest = $guests;
               $inquiryData->cdate = time();
               $inquiryData->mdate = time();
               $inquiryData->save(false);

               $messageData = new Messages();
               $messageData->inquiryid = $inquiryData->id;
               $messageData->senderid = $userdata->id;
               $messageData->receiverid = $listdata->userid;
               $messageData->listingid = $listid;
               $messageData->message = $reservationMessage;
               $messageData->receiverread = 0;
               $messageData->messagetype = "user";
               $messageData->cdate = date('Y-m-d H:i:s');
               $messageData->save(false); 

               $inquiryData = Inquiry::find()->where(['id'=>$inquiryData->id])->one();
               $inquiryData->lastmessageid = $messageData->id;
               $inquiryData->save(false);
            } else {  
               $messageData = new Messages();
               $messageData->inquiryid = $inquiryData->id;
               $messageData->senderid = $userdata->id;
               $messageData->receiverid = $listdata->userid;
               $messageData->listingid = $listid;
               $messageData->message = $reservationMessage;
               $messageData->receiverread = 0;
               $messageData->messagetype = "user";
               $messageData->cdate = date('Y-m-d H:i:s');
               $messageData->save(false); 

               $inquiryData->guest = $guests;
               $inquiryData->type = 'booked'; 
               $inquiryData->lastmessageid = $messageData->id;
               $inquiryData->mdate = time();
               $inquiryData->save(false);
            }

            if($listdata->booking == "pernight") {
               $bookingtimeSplit = explode('*|*', $listdata->pernight_availablity); 
               $checkInDateTime = date('Y-m-d H:i:s', strtotime(trim($start_date)." ".$bookingtimeSplit[0]));
               $checkOutDateTime = date('Y-m-d H:i:s', strtotime(trim($end_date)." ".$bookingtimeSplit[1])); 
            }

            $reservation = new Reservations();
            $reservation->userid = $userdata->id;   
            $reservation->hostid = $listdata->userid;
            $reservation->listid = $listid;
            $reservation->inquiryid = $inquiryData->id;
            $reservation->fromdate = $startdate;
            $reservation->todate = $enddate;
            $reservation->checkin = $checkInDateTime;
            $reservation->checkout = $checkOutDateTime;
            $reservation->guests = $guests;
            $reservation->booking = $listdata->booking;

            if(!empty($booking_timing) && $listdata->booking == 'perhour')
                $reservation->hourly_booked =str_replace('-', '*|*', $booking_timing);
            else if($listdata->booking == 'pernight')
                $reservation->hourly_booked =$listdata->pernight_availablity; 

            if($listdata->booking == 'perhour'){
                $reservation->totalhours = $total_period;
            } else {
                $reservation->totaldays = $total_period;
            }

            $reservation->pricepernight = $unitprice;

            if(count($pricearray['special']) > 0 || count($pricearray['week']) > 0)
               $reservation->pricedetails = json_encode($pricearray);   
                      
            if(!empty($currencydata))
                $reservation->currencycode = $currencydata->currencycode;
            else
                $reservation->currencycode = "";

            $reservation->convertedcurrencycode = $currency_code;
            $reservation->convertedprice = $convert_rate;
            $reservation->commissionfees = $commissionamount;
            $reservation->sitefees = $siteamount;
            $reservation->cleaningfees = $cleaningfees;
            $reservation->servicefees = $servicefees;
            $reservation->taxfees = $taxamount;
            $reservation->securityfees = $securitydeposit;
            if($securitydeposit!="")
                $reservation->sdstatus = "pending";
            $reservation->total = $totalamount;
            $reservation->booktype = $listdata->bookingstyle;
            if($listdata->bookingstyle=="instant")
                $reservation->bookstatus = "accepted";
            else
                $reservation->bookstatus = "requested";

            $reservation->orderstatus = "pending";
            $reservation->timezone =  $listdata->timezone; 
            $reservation->save();
            
            $orderid = $reservation->id;
            $invoicemodel = new Invoices();
            $invoicemodel->orderid = $orderid;
            $invoicemodel->invoiceno = "INV".$userdata->id;
            $invoicemodel->invoicedate = time();
            $invoicemodel->paymentmethod = 'Stripe';
            //if(isset($keyarray['txn_id']))
            $invoicemodel->stripe_transactionid = $striperesult['id'];
            $invoicemodel->paypaltransactionid = "";
            $invoicemodel->save();          
            
            $hostdata = $userform->findIdentity ( $listdata->userid );
            $hostnotifications = json_decode($hostdata->notifications,true);
            $hostemails = json_decode($hostdata->emailsettings,true);
            
            $usernotifications = json_decode($userdata->notifications,true);
            $useremails = json_decode($userdata->emailsettings,true);
            if($usernotifications['reservationnotify'] == 1)
            {
                $notifyuserid = $listdata->userid;
                $notifyto = $userdata->id;
                $listingid = $listid;
                $notifymessage = "You made a reservation on";
                $logdatas = $this->addlog('request',$notifyuserid,$notifyto,$listingid,$notifymessage,'');
            }
            
            if($hostnotifications['reservationnotify']==1)
            {
                $notifyhostid = $userdata->id;
                $notifyto = $listdata->userid;
                $listingid = $listid;
                $notifymessage = "There is a reservation made on";
                $logdatas = $this->addlog('reservation',$notifyhostid,$notifyto,$listingid,$notifymessage,'');
            }

            if($hostdata->pushnotification == "1") {
                $userdevicedet = Userdevices::find()->where(['user_id'=>$listdata->userid])->all();
                if(count($userdevicedet) > 0){
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
                }
            }           

            $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
            if($useremails['reservationemail']==1)
            {
                Yii::$app->mailer->compose ( 'reservationrequest', [
                    'name' => $userdata->firstname,
                    'hostname' => $hostdata->firstname,
                    'listid' => $listdata->id,
                    'listingname' => $listdata->listingname,
                    'reserveid' => $reservation->id,
                    ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $userdata->email )->setSubject ( 'You made a reservation' )->send ();              
            }
            if($hostemails['reservationemail']==1)
            {
                Yii::$app->mailer->compose ( 'reservationreceived', [
                    'name' => $hostdata->firstname,
                    'username' => $userdata->firstname,
                    'listid' => $listdata->id,
                    'listingname' => $listdata->listingname                     
                    ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $hostdata->email )->setSubject ( 'Reservation made on your listing' )->send ();
            } 
            $_SESSION['paySuccess'] = "enabled";  
            return $this->redirect(['/user/listing/success']);          
        } else {
            //Yii::$app->getSession ()->setFlash ( 'error', 'Something went wrong.' );
            return $this->redirect(['/']);
        }
      }
   } else {
      Yii::$app->getSession ()->setFlash ( 'success', 'Invalid Request.' );
      return $this->goHome ();
   }
}

/********************************** stripe ends ****************************/  
    
/*
 * Function to display the payment cancel page
 */
public function actionCancelled()
{
    $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    return $this->render('cancelled',[
        'setngs' => $sitesettings]);
}

/*
 * Function to display the payment success page
 */
public function actionSuccess()
{
    if(isset($_SESSION['paySuccess']) && trim($_SESSION['paySuccess']) == "enabled") {
        $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
        return $this->render('success',[
            'setngs' => $sitesettings]);
    } else {
        Yii::$app->getSession ()->setFlash ( 'success', 'Not Found' ); 
        return $this->redirect(['/dashboard']);   
    }
}

/*
 * Function to list all the active listings created by the host
 */
public function actionMylistings()
{
    $model =  new SignupForm();
    $listings = new Listing();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else
    $userid = Yii::$app->user->identity->id;
    $userdata = $model->findIdentity ( $userid );
    
    $query = Listing::find()->where(['userid'=>$userid])
    ->andWhere(['=','liststatus','1'])
    ->orderBy('id desc');
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $listdata = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->all();        
    return $this->render('mylistings',[
        'userdata' => $userdata,
        'listdata' => $listdata,
        'pages' => $pages
        ]);
}

/*
 * Function to list all the pending listings created by the host
 */
public function actionPendinglistings()
{
    $model =  new SignupForm();
    $listings = new Listing();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else
    $userid = Yii::$app->user->identity->id;
    $userdata = $model->findIdentity ( $userid );

    $query = Listing::find()->where(['userid'=>$userid])
    ->andWhere(['!=','liststatus','1'])
    ->orderBy('id desc');
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $listdata = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->all();
    return $this->render('pendinglistings',[
        'userdata' => $userdata,
        'listdata' => $listdata,
        'pages' => $pages
        ]);
}    

/*
 * Function to display the reservation requirements
 */
public function actionRequirements()
{
    $model =  new SignupForm();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else
    $userid = Yii::$app->user->identity->id;
    $userdata = $model->findIdentity ( $userid );       
    return $this->render('requirements',[
        'userdata' => $userdata
        ]);     
}

/*
 * Function to display all the pending reservations that are in the requested status
 */
public function actionFuturereservations()
{
    $model = new Reservations();
    $userform = new SignupForm();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else
    $userid = Yii::$app->user->identity->id;
    $userdata = $userform->findIdentity ( $userid );
    $todaydate = date('m/d/Y');
    $today = strtotime($todaydate);
    $query = Reservations::find()->where(['hostid'=>$userid,'bookstatus'=>'requested']);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $reservations = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->orderby('id desc')
    ->all();        
    return $this->render('futurereservations',[
        'reservations' => $reservations,
        'userdata' => $userdata,
        'pages' => $pages
        ]);
}

/*
 * Function to display the accepeted and declined reservations which are not checked in
 */
public function actionReservations()
{
    $model = new Reservations();
    $userform = new SignupForm();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else
    $userid = Yii::$app->user->identity->id;
    $userdata = $userform->findIdentity ( $userid );
    $todaydate = date('m/d/Y');
    $today = strtotime($todaydate);
    $query = Reservations::find()->where(['hostid'=>$userid])
    ->andWhere(['>=','todate',$today])
    ->andWhere(['!=','bookstatus','requested']);
    $countQuery = clone $query; 
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $reservations = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->orderby('id desc')
    ->all();        
    return $this->render('reservations',[
        'reservations' => $reservations,
        'userdata' => $userdata,
        'pages' => $pages
        ]);
}   

/*
 * Function to change the reservation status as "accepted" or "declined"
 */
public function actionChangereservestatus()
{
    $reservestatus = $_POST['resstatus'];
    $reserveid = $_POST['reserveid'];
    $model = new Reservations();
    $reservation = Reservations::find()->where(['id'=>$reserveid])->one();
    $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
    $loguserid = Yii::$app->user->identity->id;
    $loguserdata = User::find()->where(['id'=>$loguserid])->one(); 

    $checkoutDate = $reservation->checkout; 
    $payoutDue = json_decode($sitesetting->stripe_card_details, true);
    $payoutDue = (trim($payoutDue['stripe_hostpaydays']) > 2) ? trim($payoutDue['stripe_hostpaydays']): 2; 
    $payoutDue = "+".$payoutDue." days";
    $payoutDue = date("m/d/Y H:i:s",strtotime($checkoutDate.$payoutDue)); 

    $currentTimezone = Myclass::getTime($reservation->timezone);
    date_default_timezone_set('UTC'); 
 
    if($reservestatus=="accept" && $reservation->bookstatus=="requested" && ($loguserid==$reservation->hostid) && $loguserdata->hoststatus == "1" && (strtotime($currentTimezone) < strtotime($reservation->checkin)) ) 
    {
        $reservation->bookstatus = "accepted";
        $reservation->save();
        $userid = $reservation->userid;
        $hostid = $reservation->hostid;
        $userform = new SignupForm ();
        $userdata = $userform->findIdentity ( $userid );
        $hostdata = $userform->findIdentity($hostid);
        $usernotifications = json_decode($userdata->notifications,true);
        $useremails = json_decode($userdata->emailsettings,true);
        if($usernotifications['reservationnotify']==1)
        {
            $listingid = $reservation->listid;
            $notifymessage = 'accepted your reservation request';
            $message = '';
            $logdatas = $this->addlog('accept',$hostid,$userid,$listingid,$notifymessage,$message);
        }
        $listingdata = Listing::find()->where(['id'=>$reservation->listid])->one();

        if($userdata->pushnotification == "1") {
            $userdevicedet = Userdevices::find()->where(['user_id'=>$userid])->all();
            if(count($userdevicedet) > 0){
                foreach($userdevicedet as  $userdevice) {
                    $deviceToken = $userdevice->deviceToken;
                    $badge = $userdevice->badge;
                    $badge +=1;
                    $userdevice->badge = $badge;
                    $userdevice->deviceToken = $deviceToken;
                    $userdevice->save(false);
                    if(isset($deviceToken)){
                        $messages = array();
                        $messages['message'] = 'Your reservation request has been accepted by '.$hostdata->firstname.' at '.$listingdata->listingname;
                        $messages['id'] = $reservation->inquiryid;
                        $messages['type'] = 'accept';
                        $messages['senderId'] = $reservation->hostid;
                        $messages['receiverId'] = $reservation->userid;

                        Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                    }
                }
            }
        }
        if($useremails['reservationemail']==1)
        {
            Yii::$app->mailer->compose ( 'reservestatus', [
                'name' => $userdata->firstname,
                'sitesetting' => $sitesetting,
                'listingname' => $listingdata->listingname,
                'status' => 'accepted',
                'hostname' => $hostdata->firstname,
                ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $userdata->email )->setSubject ( 'Your reservation request accepted' )->send ();
        }  
        echo "accepted";  
    }
    else if($reservestatus=="decline" && $reservation->bookstatus=="requested" && $reservation->hostid == $loguserid && $loguserdata->hoststatus == "1" && (strtotime($currentTimezone) < strtotime($reservation->checkin)) ) 
    {
       if(count($reservation) > 0 && empty($reservation->other_transaction)) {     
            $invoice = $reservation->getInvoices()->where(['orderid'=>$reservation->id])->one();
            if(!empty($invoice->stripe_transactionid)) {
                \Stripe\Stripe::setApiKey($sitesetting->stripe_secretkey);

                $refund = \Stripe\Refund::create([
                   'charge' => $invoice->stripe_transactionid
                ]);
                $striperesult = $refund->jsonSerialize();

                if ($striperesult['status'] == 'succeeded' && !empty($striperesult['id']) && !empty($striperesult['balance_transaction'])) {
                    $result['refund_id'] = $striperesult['id'];
                    $result['status'] = $striperesult['status'];
                    $result['amount'] = $striperesult['amount'];
                    $result['type'] = $striperesult['object'];
                    $result['charge'] = $striperesult['charge'];
                    $result['currency'] = $reservation->convertedcurrencycode;
                    $result['cdate'] = time();
                    $reservation->orderstatus = 'paid';
                    $reservation->sdstatus = 'paid';
                    $reservation->other_transaction = json_encode($result);
                    $reservation->bookstatus = "declined";
                    $reservation->cancelby = "Host";
                    $reservation->save();

                    $userid = $reservation->userid;
                    $hostid = $reservation->hostid;
                    $userform = new SignupForm ();
                    $userdata = $userform->findIdentity ( $userid );
                    $hostdata = $userform->findIdentity($hostid);
                    $usernotifications = json_decode($userdata->notifications,true);
                    $useremails = json_decode($userdata->emailsettings,true);

                    if($usernotifications['reservationnotify']==1) {
                        $listingid = $reservation->listid;
                        $notifymessage = 'declined your reservation request';
                        $message = '';
                        $logdatas = $this->addlog('decline',$hostid,$userid,$listingid,$notifymessage,$message);
                    }           

                    $listingdata = Listing::find()->where(['id'=>$reservation->listid])->one();

                    if($userdata->pushnotification == "1") {
                        $userdevicedet = Userdevices::find()->where(['user_id'=>$userid])->all();

                        if(count($userdevicedet) > 0) {
                            foreach($userdevicedet as  $userdevice) {
                                $deviceToken = $userdevice->deviceToken;
                                $badge = $userdevice->badge;
                                $badge +=1;
                                $userdevice->badge = $badge;
                                $userdevice->deviceToken = $deviceToken;
                                $userdevice->save(false);
                                if(isset($deviceToken)){
                                    $messages = array();
                                    $messages['message'] = 'Your reservation request has been declined by '.$hostdata->firstname.' at '.$listingdata->listingname;
                                    $messages['id'] = $reservation->inquiryid;
                                    $messages['type'] = 'decline';
                                    $messages['senderId'] = $reservation->hostid;
                                    $messages['receiverId'] = $reservation->userid;

                                    Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                                } 
                            }
                        }
                    }
                    if($useremails['reservationemail']==1)
                    {
                        Yii::$app->mailer->compose ( 'reservestatus', [
                            'name' => $userdata->firstname,
                            'sitesetting' => $sitesetting,
                            'listingname' => $listingdata->listingname,
                            'status' => 'declined',
                            'hostname' => $hostdata->firstname,
                            ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $userdata->email )->setSubject ( 'Your reservation request declined' )->send ();
                    }
                    echo "declined"; 
                }
            }
        }         
    }
    else if($reservestatus=="cancel" && ($reservation->bookstatus=="requested" || $reservation->bookstatus=="accepted") && $reservation->userid == $loguserid && $loguserdata->userstatus == "1" && (strtotime($currentTimezone) < strtotime($reservation->checkin)) ) 
    {          
        $flag = 0; $cancelpercentage = 0; $policies = NULL; $deduct_amount = 0; $host_fund = 0;
        $host_account_id = "";

        if(count($reservation) > 0 && empty($reservation->other_transaction) && empty($reservation->claim_transaction) && ($loguserid == $reservation->userid)) {

            /*$reservation->bookstatus = "cancelled";
            $reservation->cancelby = "Guest";
            $reservation->canceldate = time();
            $reservation->save();*/    

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
             $hostData = User::find()->where(['id'=>$reservation->hostid])->one(); 
 
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
                   $reservation->cancelby = "Guest";      
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

                    $userid = $reservation->userid;
                    $hostid = $reservation->hostid;
                    $userform = new SignupForm ();
                    $userdata = $userform->findIdentity ( $userid );
                    $hostdata = $userform->findIdentity($hostid);
                    $hostnotifications = json_decode($hostdata->notifications,true);
                    $hostemails = json_decode($hostdata->emailsettings,true);

                    if($hostnotifications['reservationnotify']==1)
                    {
                        $listingid = $reservation->listid;
                        $notifymessage = 'cancelled your reservation';
                        $message = '';
                        $logdatas = $this->addlog('cancel',$userid,$hostid,$listingid,$notifymessage,$message);
                    }

                    $listingdata = Listing::find()->where(['id'=>$reservation->listid])->one();

                    if($hostdata->pushnotification == "1") {
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
                                    $messages['message'] = 'Your reservation has been cancelled by '.$userdata->firstname.' at '.$listingdata->listingname;
                                    $messages['id'] = $reservation->inquiryid;
                                    $messages['type'] = 'cancel';
                                    $messages['senderId'] = $reservation->userid;
                                    $messages['receiverId'] = $reservation->hostid;

                                    Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                                }
                            }
                        }
                    }

                    if($hostemails['reservationemail']==1) 
                    {
                        Yii::$app->mailer->compose ( 'reservestatus', [
                            'name' => $hostdata->firstname,
                            'sitesetting' => $sitesetting,
                            'listingname' => $listingdata->listingname,
                            'status' => 'cancelled',
                            'hostname' => $userdata->firstname,
                            ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $hostdata->email )->setSubject ( 'Your reservation cancelled' )->send (); 
                    }

                   echo "cancelled";   
                }  
            }
        }
        echo $flag;            
    }
    
    return false;
}

/*
 * Function to display all "accepted" and "declined" reservations which are checked in
 */
public function actionPastreservations()
{
    $model = new Reservations();
    $userform = new SignupForm();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else
    $userid = Yii::$app->user->identity->id;
    $userdata = $userform->findIdentity ( $userid );
    $todaydate = date('m/d/Y');
    $today = strtotime($todaydate);
    $query = Reservations::find()->where(['hostid'=>$userid])
    ->andWhere(['<','todate',$today])
    ->andWhere(['!=','bookstatus','requested']);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $reservations = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->orderby('id desc')
    ->all();   
    $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();     
    return $this->render('pastreservations',[
        'reservations' => $reservations,
        'userdata' => $userdata,
        'sitesetting' => $sitesetting,
        'pages' => $pages
        ]);     
}

/*
 * Funtion to display the future trips
 */
public function actionTrips()
{
    $model = new Reservations();
    $userform = new SignupForm();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else
    $userid = Yii::$app->user->identity->id;
    $userdata = $userform->findIdentity ( $userid );
    $todaydate = date('m/d/Y');
    $today = strtotime($todaydate);
    $query = Reservations::find()->where(['>=','todate',$today])
    ->andWhere(['userid'=>$userid]);
    $countQuery = clone $query;

    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $trips = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->orderby('id desc')
    ->all();        
    return $this->render('trips',[
        'trips' => $trips,
        'userdata' => $userdata,
        'pages' => $pages
        ]);
}

/*
 * Function to display the previous trips
 */
public function actionPrevioustrips()
{
    $model = new Reservations();
    $userform = new SignupForm();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else
    $userid = Yii::$app->user->identity->id;
    $userdata = $userform->findIdentity ( $userid );
    $todaydate = date('m/d/Y');
    $today = strtotime($todaydate);
    $query = Reservations::find()->where(['<','todate',$today])
    ->andWhere(['userid'=>$userid]);

    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $trips = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->orderby('id desc')
    ->all();        
    return $this->render('previoustrips',[
        'trips' => $trips,
        'userdata' => $userdata,
        'pages' => $pages
        ]);
}    

/*
 * Display the claim page. Guest and host send message to one another and can claim secrity amount here.
 */
public function actionClaim($details)
{
    return $this->goHome ();

    $userform = new SignupForm();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else
    $userid = Yii::$app->user->identity->id;
    $userdata = $userform->findIdentity ( $userid );        
    $idrand = base64_decode($details);
    $idval = explode("_",$idrand);
    $id = $idval[0];
    $trips = Reservations::find()->where(['id'=>$id])->one();
    $listdata = $trips->getList()->where(['id'=>$trips->listid])->one();
    $model  = new Claim();
    $claimdata = Claim::find()->where(['reservationid'=>$id])
    ->one();
    return $this->render('claim',[
        'trips' => $trips,
        'userdata' => $userdata,
        'listdata' => $listdata,
        'claimdata' => $claimdata,
        'userid' => $userid
        ]);
}

/*
 * Function to initiate the claim
 */
public function actionClaimsecurityfee()
{
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    }       
    $tripid = $_POST['tripid'];
    $claimby = $_POST['claimby'];
    $userid = Yii::$app->user->identity->id;
    $reservation = Reservations::find()->where(['id'=>$tripid])->one();
    $loguserdata = User::find()->where(['id'=>$userid])->one(); 

    $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();

    $checkoutDate = $reservation->checkout; 
    $payoutDue = json_decode($sitesetting->stripe_card_details, true);

    if(trim($payoutDue['stripe_hostpaydays']) > 2)
      $payoutDue = trim($payoutDue['stripe_hostpaydays']); 
    else
      $payoutDue = 2;

    $payoutDue = "+".$payoutDue." days";
    $payoutDue = date("m/d/Y H:i:s",strtotime($checkoutDate.$payoutDue));   

    $currentTimezone = Myclass::getTime($reservation->timezone);
    date_default_timezone_set('UTC');  

    if($reservation->bookstatus=="accepted" && $loguserdata->hoststatus == "1" && $reservation->hostid == $userid && (strtotime($checkoutDate) <= strtotime($currentTimezone)) && (strtotime($currentTimezone) <= strtotime($payoutDue))) { 

      $reservation->bookstatus = "claimed";
      $reservation->claim_status = "pending"; 

      $reservation->save(); 
      echo $reservation->id;  
    } 

    /*$receiverid = $reservation->hostid;

    $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
    $siteName = $sitesetting->sitename;
    $models = new SignupForm();
    $receiverdata = $models->findIdentity ( $receiverid );
    $userdata = $models->findIdentity($userid);
    $email = $receiverdata->email;
    Yii::$app->mailer->compose ( 'claim', [
        'name' => $receiverdata->firstname,
        'siteName' => $siteName,
        'sitesetting' => $sitesetting,
        'claimby' => $claimby,
        ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Claim Initiated' )->send ();    

    $listingdata = Listing::find()->where(['id'=>$reservation->listid])->one();
    $listingid = $reservation->listid;
    $notifymessage = 'has initiated the claim amount';
    $message = '';
    $logdatas = $this->addlog('claim',$userid,$receiverid,$listingid,$notifymessage,$message);

    
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
                $messages = $userdata->firstname.' has initiated the claim amount on '.$listingdata->listingname;
                Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
            }
        }
    }*/ 
    
    return false;
}

/*
 * Function to change the claim status
 */
public function actionChangereceiverstatus()
{
    $reserveid = $_POST['reserveid'];
    $status = $_POST['status'];
    $claimdata = Claim::find()->where(['reservationid'=>$reserveid])->one();
    $claimdata->receiverstatus = $status;
    $claimdata->save();

    $reservationdata = Reservations::find()->where(['id'=>$reserveid])->one();
    if($claimdata->claimby=='Host')
    {
        $receiverid = $reservationdata->hostid;
        $senderid = $reservationdata->userid;
        $claimby = 'Guest';
    }
    else if($claimdata->claimby=='Guest')
    {
        $receiverid = $reservationdata->userid;
        $senderid = $reservationdata->hostid;
        $claimby = 'Host';
    }
    $listingdata = Listing::find()->where(['id'=>$reservationdata->listid])->one();
    $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
    $siteName = $sitesetting->sitename;
    $models = new SignupForm();
    $senderdata = $models->findIdentity ( $senderid );
    $receiverdata = $models->findIdentity ( $receiverid );    
    $email = $receiverdata->email;    
    Yii::$app->mailer->compose ( 'claimstatus', [
        'name' => $receiverdata->firstname,
        'siteName' => $siteName,
        'sitesetting' => $sitesetting,
        'claimby' => $claimby,
        'status' => $status,
        'sendername' => $senderdata->firstname,
        'listingname' => $listingdata->listingname,
        ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Claim '.$status )->send ();    

    
    $listingid = $reservationdata->listid;
    $notifymessage = 'has '.$status.' your claim request';
    $message = '';
    $logdatas = $this->addlog('claim',$senderid,$receiverid,$listingid,$notifymessage,$message);        

    if($receiverdata->pushnotification == "1") {
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
                    $messages = $senderdata->firstname.' has '.$status.' your claim request on '.$listingdata->listingname;
                    Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                }
            }
        }
    }        
}

/*
 * Function to change the claim status
 */
public function actionChangeclaimstatus()
{
    $claimid = $_POST['claimid'];
    $status = $_POST['status'];
    $claimdata = Claim::find()->where(['id'=>$claimid])->one();
    $claimdata->claimstatus = $status;
    $claimdata->save();
}

/*
 * Function to send the claim message to the guest and host
 */
public function actionSendclaimmessage()
{
    $loguserid = Yii::$app->user->identity->id;
    $tripid = $_POST['tripid'];
    $userid = $_POST['userid'];
    $hostid = $_POST['hostid'];
    $message = $_POST['messages'];
    $claimmodel = new Claimmessage();
    $claimmodel->claimid = $tripid;
    $claimmodel->userid = $userid;
    $claimmodel->hostid = $hostid;
    $claimmodel->message = $message;
    if($loguserid==$userid)
        $claimmodel->sentby = 'Guest';
    else if($loguserid==$hostid)
        $claimmodel->sentby = 'Host';
    $claimmodel->cdate = date("Y-m-d h:i:s");
    $claimmodel->save();
}

/*
 * Display all the claim messages sent between guest and host
 */
public function actionGetclaimmessage()
{
    $reserveid = $_POST['reserveid'];
    $loguserid = Yii::$app->user->identity->id;
    $claimmessages = Claimmessage::find()->where(['claimid'=>$reserveid])
    ->orderBy('id desc')
    ->all();
    $claimdata = Claimmessage::find()->where(['claimid'=>$reserveid])->one();
    $userdata = $claimdata->getUser()->where(['id'=>$claimdata->userid])->one();
    $hostdata = $claimdata->getHost()->where(['id'=>$claimdata->hostid])->one();
    return $this->renderPartial('getclaimmessage',[
        'claimmessages'=>$claimmessages,
        'loguserid' => $loguserid,
        'userdata' => $userdata,
        'hostdata' => $hostdata
        ]);
}

/*
 * Function to involve admin for the claim 
 */
public function actionInvolveadmin()
{
    $claimid = $_POST['claimid'];
    $claimdata = Claim::find()->where(['id'=>$claimid])->one();
    $claimdata->involveadmin = '1';
    $claimdata->save();
}

/*
 * Function to send the message between guest and host using contact host option.
 */
public function actionSendcontactmessage()
{
    //$inquirydata = Inquiry::find()->where(['id'=>1])->one();
   //echo date('Y-m-d H:i:s', strtotime("10/28/2018 20:20"));
   if(isset($_POST['senderid']) && isset($_POST['receiverid']) && isset($_POST['messages']) && isset($_POST['listingid']) && isset($_POST['booking']) && isset($_POST['guests']) && isset($_POST['checkindate']) && isset($_POST['checkoutdate']) && count($_POST) >= 8) {
      $senderid = trim($_POST['senderid']);
      $receiverid = trim($_POST['receiverid']);
      $messages = trim($_POST['messages']);
      $listingid = trim($_POST['listingid']);
      $booking = trim($_POST['booking']);
      $guests = trim($_POST['guests']);
      $bookingtime = NULL;
      $checkinDate = trim($_POST['checkindate']);
      $checkoutDate = trim($_POST['checkoutdate']);

      if(isset($_POST['bookingtime']) && trim($_POST['bookingtime'])!="") {
        $bookingtime = trim($_POST['bookingtime']);
      }

      $loguserid = Yii::$app->user->identity->id;
      $listingdata = Listing::find()->where(['id'=>$listingid])->one();

      if($loguserid == $senderid && $listingdata->userid == $receiverid) {
         if($booking == "perhour") {
            $bookingtimeSplit = explode('-', $bookingtime);
            $checkInDateTime = date('Y-m-d H:i:s', strtotime($checkinDate." ".$bookingtimeSplit[0]));
            $checkOutDateTime = date('Y-m-d H:i:s', strtotime($checkoutDate." ".$bookingtimeSplit[1]));
         } else {
            //$bookingtime = str_replace('*|*', '-', $listingdata->pernight_availablity);
            $checkInDateTime = date('Y-m-d H:i:s', strtotime($checkinDate));
            $checkOutDateTime = date('Y-m-d H:i:s', strtotime($checkoutDate));
         }

         $inquiryAll = Inquiry::find()->where(['senderid'=>$senderid, 'receiverid'=>$receiverid, 'listingid'=>$listingid, 'checkin'=> $checkInDateTime, 'checkout'=> $checkOutDateTime])->orderBy('id desc')->all();   

         $reserveCount = new \yii\db\Query;
         $reserveCount->select(['hts_inquiry.*'])
         ->from('hts_inquiry')
         ->leftJoin('hts_reservations', 'hts_reservations.inquiryid = hts_inquiry.id')
         ->where(['hts_inquiry.senderid'=>$senderid, 'hts_inquiry.receiverid'=>$receiverid, 'hts_inquiry.listingid'=>$listingid, 'hts_inquiry.checkin'=> $checkInDateTime, 'hts_inquiry.checkout'=> $checkOutDateTime, 'hts_inquiry.type'=>'booked'])
         ->andWhere(['or', ['=','hts_reservations.bookstatus','refunded'], ['=','hts_reservations.bookstatus','declined'] ]);

         $countQuery = clone $reserveCount; 
         $reserveCount = $countQuery->count();

         if(count($inquiryAll) == 0 || (count($inquiryAll) == $reserveCount)) {   
            $inquiryData = new Inquiry();
            $inquiryData->senderid = $senderid;
            $inquiryData->receiverid = $receiverid;
            $inquiryData->listingid = $listingid;
            $inquiryData->checkin = $checkInDateTime;
            $inquiryData->checkout = $checkOutDateTime;
            $inquiryData->guest = $guests;
            $inquiryData->cdate = time();
            $inquiryData->mdate = time();
            $inquiryData->save(false);

            $messageData = new Messages();
            $messageData->inquiryid = $inquiryData->id;
            $messageData->senderid = $senderid;
            $messageData->receiverid = $receiverid;
            $messageData->listingid = $listingid;
            $messageData->message = $messages;
            $messageData->receiverread = 0;
            $messageData->messagetype = "user";
            $messageData->cdate = date('Y-m-d H:i:s');  
            $messageData->save(false); 

            $inquiryData = Inquiry::find()->where(['id'=>$inquiryData->id])->one();
            $inquiryData->lastmessageid = $messageData->id;
            $inquiryData->save(false);

            $signupmodel = new SignupForm(); 
            
            $senderdata = $signupmodel->findIdentity($senderid);
            $receiverdata = $signupmodel->findIdentity($receiverid); 
            $sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
    
            $notifications = json_decode($receiverdata->notifications,true);
            if($notifications['messagenotify'] == 1) {   
               $userid = $senderid;
               $notifyto = $receiverid;
               $listingid = $listingid;
               $notifymessage = "sent you a message";
               $message = $messages;
               $logdatas = $this->addlog('message',$userid,$notifyto,$listingid,$notifymessage,$message);
            }     

            Yii::$app->mailer->compose ( 'contactmessage', [
               'name' => $receiverdata->firstname,
               'sitesetting' => $sitesetting,
               'messages' => $messages,
               'sendername' => $senderdata->firstname,
               ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $receiverdata->email )->setSubject ( 'You got message' )->send (); 

            if($receiverdata->pushnotification == "1") {
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
                            $messages = array();
                            $messages['message'] = $senderdata->firstname.' sent you a message';
                            $messages['id'] = $inquiryData->id;
                            $messages['type'] = 'inquiry';
                            $messages['senderId'] = $senderid;
                            $messages['receiverId'] = $receiverid;  
                           Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                       }
                   }
                }  
            }    
            echo "1";
         } else {
            // already available
            echo "0";
         }
      } else {
        echo "2";
      }
   } else {
      echo "2";
   } 
}

/*
 * Function to save the notifications for the user
 */
public function actionNotifications()
{
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    }
    $loguserid = Yii::$app->user->identity->id;
    $userform = new SignupForm();
    $userdata = $userform->findIdentity ( $loguserid );
    $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
    if(Yii::$app->request->post())
    { 
        if(isset($_POST['pushnotify']) && trim($_POST['pushnotify'])=="1")
            $userdata->pushnotification = $_POST['pushnotify'];
        else
            $userdata->pushnotification = "0";

        if(isset($_POST['mobilenotify']) && trim($_POST['mobilenotify'])=="1")
            $notifications['mobilenotify'] = $_POST['mobilenotify'];
        else
            $notifications['mobilenotify'] = "0";

        if(isset($_POST['messagenotify']) && trim($_POST['messagenotify'])=="1")
            $notifications['messagenotify'] = $_POST['messagenotify'];
        else
            $notifications['messagenotify'] = "0";

        if(isset($_POST['reservationnotify']) && trim($_POST['reservationnotify'])=="1")
            $notifications['reservationnotify'] = $_POST['reservationnotify'];
        else 
            $notifications['reservationnotify'] = "0";

        if(isset($_POST['accountnotify']) && trim($_POST['accountnotify'])=="1")
            $notifications['accountnotify'] = $_POST['accountnotify'];
        else
            $notifications['accountnotify'] = "0";

        if(isset($_POST['generalemail']) && trim($_POST['generalemail'])=="1")
            $emails['generalemail'] = $_POST['generalemail'];
        else
            $emails['generalemail'] = "0";

        if(isset($_POST['reservationemail']) && trim($_POST['reservationemail'])=="1")
            $emails['reservationemail'] = $_POST['reservationemail'];
        else 
            $emails['reservationemail'] = "0";   

        $notifications_setting = json_encode($notifications);
        $email_setting = json_encode($emails);
        $userdata->notifications = $notifications_setting;
        $userdata->emailsettings = $email_setting;
        if($userdata->save()) {   
            Yii::$app->getSession()->setFlash ( 'success', 'Notification updated successfully.' ); 
        }
    }
    return $this->render('notifications',[
        'userdata' => $userdata,
        'sitesettings' => $sitesettings,
        'userform' => $userform
        ]);
}

/*
 * Function to display the user notificatons for booking, messaging and claim
 */
public function actionUsernotifications()
{
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    }
    $loguserid = Yii::$app->user->identity->id;
    $query = Logs::find()->where(['notifyto'=>$loguserid]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $logmessages = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->orderBy('id desc')
    ->all(); 
    
    $updateNotification = Logs::find()->Where(['notifyto'=>$loguserid, 'messageread'=>'1'])->count();
    if($updateNotification > 0) { 
        Logs::updateAll(['messageread' => '0'], ['and', ['=', 'notifyto', $loguserid], ['=', 'messageread', '1']]); 
    }

    return $this->render('usernotifications',[
        'logmessages' => $logmessages,
        'pages' => $pages
        ]);     
}

/*
 * Function to save the notification log
 */ 
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
    $log->save(false);
}

/*
 * Function to resize the image with the given height and weight
 */
public function actionResized($id1,$id2,$details)
{
    return $this->render('resized',[
        'imgwidth' => $id1,
        'imgheight' => $id2,
        'imagename' => $details
        ]);
}


/**
 * Function to search the places based on
 * the latitude, longitude and other attributes from the get method
 * 
 * @param String $place // Holds the value of the place name for display purpose only
 * @return string
 */

public function actionSearch($place, $countryid=NULL) {

   $this->layout = "search";

   //Default Price Range
   $priceRangeValue = "0;10010";   
   $priceRange = explode(';', $priceRangeValue); 

   //Page Limit
   $pageContent = 10;

   // Flag
   $conditionFlag = 0; 

   //Selected Currency Value
   if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="") {
      $currencyCode = $_SESSION['currency_code'];
      $currencySymbol = $_SESSION['currency_symbol'];

      //user currency
      $currencyRate= Myclass::getcurrencyprice($currencyCode); 
   } else {
      $currencydata = Currency::find()->where(['defaultcurrency'=>1])->one(); 

      //user currency
      $currencyRate= Myclass::getcurrencyprice($currencydata->currencycode); 

      $currencyCode = $currencydata->currencycode;
      $currencySymbol = $currencydata->currencysymbol; 
   }

   //Declaration
   $checkInDate = (isset($_GET['checkin'])) ? trim($_GET['checkin']) : "";
   $checkOutDate = (isset($_GET['checkout'])) ? trim($_GET['checkout']) : "";
   $place = (trim($place)!="") ? trim($place) : ""; 
   $countryDetails = ""; 
   $_SESSION['place'] = "";

   // User Id
   $userid = (! Yii::$app->user->isGuest)? \Yii::$app->user->identity->id:"";

   //Price Condition
   //$priceCondition = ['or', ['between',"Round(((hts_listing.nightlyprice/u.price) * $currencyRate),2)", (int)$priceRange[0],(int)$priceRange[1]], ['between',"Round(((hts_listing.hourlyprice/u.price) * $currencyRate),2)", (int)$priceRange[0],(int)$priceRange[1]], ];  

   $priceCondition = ['or', ['>=',"Round(((hts_listing.nightlyprice/u.price) * $currencyRate),2)",(int)$priceRange[0]], ['>=',"Round(((hts_listing.hourlyprice/u.price) * $currencyRate),2)",(int)$priceRange[0]] ]; 

   //Price Filter Sub Query
   $subQuery = (new Query())->select('*')->from('hts_currency')->where('hts_currency.price > 0');

   //methodType
   $methodType = "all";

   //ZeroResult
   $zeroresult = "";

   // Latitue and Longitude if Present
   $lat = (isset($_GET['lat'])) ? trim($_GET['lat']):"";
   $lng = (isset($_GET['long'])) ? trim($_GET['long']):""; 

   // Table Declaration
    $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();

   if((trim($place)=="type" && trim($countryid)=="featured") || (trim($place)=="featured")) {  

      $query = Listing::find()->where(['featuredlist'=>'1','liststatus'=>'1']);
      
      $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency'); 
      //$query->andwhere($priceCondition)->orderBy('hts_listing.id desc'); 
      $query->andwhere($priceCondition)->orderBy('hts_listing.featuredate desc');  

      $conditionFlag = 1;
      $methodType = "featured";
      $_SESSION['place']= "Featured";

   } elseif ((trim($place)=="type" && trim($countryid)=="traverse") || (trim($place)=="traverse")) {

      $query = Listing::find()->select(['hts_listing.*', 'count(hts_reservations.listid) AS maxapp']);
      $query = $query->join('RIGHT JOIN', 'hts_reservations', 'hts_reservations.listid = hts_listing.id');
      $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency');
      $query = $query->where(['hts_listing.liststatus'=>'1'])->andwhere($priceCondition)->groupBy('hts_reservations.listid')->orderBy('maxapp desc');
      $conditionFlag = 1;
      $methodType = "traverse"; 
      $_SESSION['place']= "Popular"; 

   } else {
      $place = explode('&',trim($place));
      $place = preg_replace("/[^a-zA-Z, ]/", "", trim($place[0]));  
      $placeType = array_values(array_filter(explode(',',$place)));  
        
      //DateTypeValue
      $dateCondition = "";
      $roomCondition = "";
      
      $checkInDate = ($checkInDate != "undefined" && $checkInDate!="")?date('m/d/Y',strtotime($checkInDate)):"";
      $checkOutDate = ($checkOutDate != "undefined" && $checkOutDate!="")?date('m/d/Y',strtotime($checkOutDate)):"";
      if(!empty($checkInDate) && !empty($checkOutDate)) {
         $dateCondition = ['or',[
                              'and',
                              ['bookingavailability'=> "always"],
                              ['startdate'=> NULL],
                              ['enddate' => NULL],
                          ], [
                              'and',
                              ['bookingavailability'=> "onetime"], 
                              ['<=','hts_listing.startdate',strtotime($checkInDate)],
                              ['>=','hts_listing.enddate', strtotime($checkOutDate)],
                          ]
                        ];
      }

      //RoomType Value
      $roomType = (isset($_GET['roomtype'])) ? trim($_GET['roomtype']) : "";
      if($roomType > 0 && !empty($roomType)) {
         $roomCondition = ['=','roomtype', $roomType];
         //$roomTypeText = Roomtype::find()->where(['id'=>$roomType])->one(); 

      } 

      if(trim(strtolower($place))=="anywhere" || (trim($countryid)=="anywhere")) {
         $query = Listing::find()->where(['liststatus'=>'1']);
         $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency'); 
         $query->andwhere($dateCondition)->andwhere($roomCondition)->andwhere($priceCondition)->orderBy('hts_listing.id desc');    
         
         $conditionFlag = 1;         
         $methodType = "anywhere";
         $_SESSION['place'] = "Anywhere";

      } elseif (trim($place)!="" && count($placeType) == 1) { 
         // Country Based Listing Search
         $countryData = Country::find()->where(['countryname'=>ucfirst(strtolower(trim($placeType[0])))])->orWhere(['like','alternative',strtolower(trim($placeType[0]))])->one();  
         if(count($countryData) > 0) {
            $countryDetails = $countryData->id;
            $lat = $countryData->latitude;
            $lng = $countryData->longitude; 
            $query = Listing::find()->where(['country'=>trim($countryDetails),'liststatus'=>'1']);
            $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency');
            $query->andwhere($priceCondition)->andwhere($roomCondition)->andwhere($dateCondition)->orderBy('hts_listing.id desc');
            $conditionFlag = 1;
            $methodType = "country";
            $_SESSION['place'] = trim($place);
         } else {
            $methodType = "location";
         }
      } elseif (count($placeType) > 1) {
        $methodType = "location";
      }

      if($methodType == "location") { 

         if(trim($lat)!="" && trim($lng)!="" && trim($lat)!="undefined" && trim($lng)!="undefined") { 
             if(isset($kilometer)) {
               $kilometer = $kilometer * 0.1 / 11;
             } else {
               $kilometer = 80 * 0.1 / 11;
             }

             // Range in degrees (0.1 degrees is close to 11km)
             $Distance = $kilometer; 
             $LatN = $lat + $Distance;
             $LatS = $lat - $Distance;
             $LonE = $lng + $Distance;
             $LonW = $lng - $Distance;

             $locationCondition = ['and', ['between','hts_listing.latitude',$LatS, $LatN], ['between','hts_listing.longitude', $LonW, $LonE]];

             $query = Listing::find()->where(['liststatus'=>'1']);
             $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency');
             $query->andwhere($priceCondition)->andwhere($dateCondition)->andwhere($roomCondition)->andwhere($locationCondition)->orderBy('hts_listing.id desc');
             //$methodType = "location";
          
             $placename = str_replace(" ", "-", $place);

             $details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$placename."&sensor=false&key=".trim($sitesettings->googleapikey);

             $curl_handle=curl_init();
             curl_setopt($curl_handle, CURLOPT_URL,$details_url);
             curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
             curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
             $response = curl_exec($curl_handle);
             curl_close($curl_handle);
             $resarr = json_decode($response,true);

             //If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
             if ($resarr['status'] == 'OK') {       
                $lat = $resarr['results'][0]['geometry']['location']['lat'];
                $lng = $resarr['results'][0]['geometry']['location']['lng'];
                $conditionFlag = 1;
             }

             $_SESSION['place']= trim($place);
         } else {
            $conditionFlag = 0;
         }
      }
   }

    if($conditionFlag == 1) {
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $totalCount = $countQuery->count();

        $listDetails = $query->limit($pageContent)->all();
   }

   if($conditionFlag == 0 || count($listDetails) == 0) {
        $query = Listing::find()->where(['liststatus'=>'1']);
        $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency');
        $query->andwhere($priceCondition)->orderBy('hts_listing.id desc'); 
        $lat = "";
        $lng = "";   
        $zeroresult = "zeroresult";
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $totalCount = $countQuery->count();

        $listDetails = $query->limit($pageContent)->all();
   }  
   
   /* echo $query->createCommand()->getRawSql();
   echo "<br><BR>".count($listDetails)." // ".$totalCount." // ".$methodType;
   die; */   

   $aminityDetails = Commonamenities::find()->all();
   $listingProperties = Listingproperties::find()->one();  
   $homeTypeDetails = Hometype::find()->all();
   $roomTypeDetails = Roomtype::find()->all();
   $roomData = array();

   foreach($roomTypeDetails as $roomKey => $roomType){
       $roomData[$roomKey]['roomtypeid'] = $roomType->id;
       $roomData[$roomKey]['roomtype'] = $roomType->roomtype;
       $roomData[$roomKey]['description'] = $roomType->description;
   }
   $wishArray = array();
   if($userid!="") {
      $wishlists = Wishlists::find()->where(['userid'=>$userid])->all();
      foreach ($wishlists as $key => $value) {
         array_push($wishArray,$value->listingid); 
      }      
   }

   if($zeroresult == "zeroresult") {
        $methodType = "anywhere";
   } 
    
   return $this->render('search',['listDetails'=>$listDetails, 
        'lat' => $lat, 
        'lng' => $lng,
        'zeroresult' => $zeroresult, 
        'place'=>$place,
        'checkIn'=>$checkInDate,
        'roomData' => $roomData, 
        'checkOut'=>$checkOutDate,
        'totalCount' => $totalCount,
        'pagesContent' => $pageContent,
        'aminityDetails' => $aminityDetails,
        'listingProperties' => $listingProperties, 
        'homeTypeDetails' => $homeTypeDetails,
        'userid' => $userid,
        //'pricerange' => $sitesettings->pricerange,
        'priceRangeValue' => $priceRangeValue,
        'sitesettings'=>$sitesettings,
        'methodType'=>$methodType,
        'countryDetails'=>trim($countryDetails),
        'currencyCode'=>$currencyCode,
        'currencySymbol'=>$currencySymbol, 
        'wishArray'=>$wishArray,  
   ]);
} 

/*
 * Function to search the places based on latitude, longitude, room types, guests, amenities etc
 */
public function actionGetsearchupdate() {
    if (Yii::$app->request->isAjax) {
        $postData = Yii::$app->request->post();

        $methodType = (isset($postData['methodtype']) && $postData['methodtype'] != '') ? trim($postData['methodtype']) : "";
        if($methodType == 'all' || $methodType == 'featured' || $methodType == 'traverse' || $methodType == 'anywhere' || $methodType == 'country' || $methodType == 'location') {

            /**************  Ajax Declaration ***************/

            $dateCondition = "";
            $priceCondition = "";
            $conditionFlag = 0;
            $condition[] = 'and';
            $condition[] = ['=','hts_listing.liststatus', "1"];
            $locationCondition = ""; 

            /************** Ajax Post Value ***************/
            $checkInDate = (isset($postData['checkinDate']) && trim($postData['checkinDate'])!="undefined" && trim($postData['checkinDate'])!="")?date('m/d/Y',strtotime(trim($postData['checkinDate']))):"";
            $checkOutDate = (isset($postData['checkoutDate']) && trim($postData['checkoutDate'])!="undefined" && trim($postData['checkoutDate'])!="")?date('m/d/Y',strtotime(trim($postData['checkoutDate']))):"";

            // priceRange 
            $priceRange = (isset($postData['priceRange']) && trim($postData['priceRange'])!="") ? explode(';',trim($postData['priceRange'])) : "";

            // Co-ordinates
            $lat = (isset($postData['lat']) && trim($postData['lat'])!="") ? trim($postData['lat']) : "";
            $lng = (isset($postData['lng']) && trim($postData['lng'])!="") ? trim($postData['lng']) : "";

            if($lat!="" && $lng!="") {
                if(isset($postData['kilometer']) && trim($postData['kilometer']) > 0) {
                   $kilometer = $postData['kilometer'] * 0.1 / 11;
                } else {
                   $kilometer = 80 * 0.1 / 11;
                }

                // Range in degrees (0.1 degrees is close to 11km)
                $Distance = $kilometer; 
                $LatN = $lat + $Distance;
                $LatS = $lat - $Distance;
                $LonE = $lng + $Distance;
                $LonW = $lng - $Distance;

                $locationCondition = ['and', ['between','hts_listing.latitude',$LatS, $LatN], ['between','hts_listing.longitude', $LonW, $LonE]];
            }

            //Country id
            $countryId = (isset($postData['countryid']) && trim($postData['countryid'])!="" && trim($postData['countryid'])>0) ? trim($postData['countryid']) : "";
            
            // Room Types
            $roomTypes = (isset($postData['roomTypes']) && trim($postData['roomTypes'])!="") ? explode(',',trim($postData['roomTypes'])) : "";

            // Home Types
            $homeTypes = (isset($postData['homeTypes']) && trim($postData['homeTypes'])!="") ? explode(',',trim($postData['homeTypes'])) : "";

            // Amenities 
            $amenities = (isset($postData['amenities']) && trim($postData['amenities'])!="") ? explode(',',trim($postData['amenities'])) : "";

            //Duration
            $durationList = (isset($postData['duration']) && trim($postData['duration'])!="") ? trim($postData['duration']) : "";

            // Map action
            $mapAction = (isset($postData['mapaction']) && trim($postData['mapaction'])!="") ? trim($postData['mapaction']) : ""; 

            //UserId
            if (Yii::$app->user->isGuest) {
                $userid = "";
            } else if (! Yii::$app->user->isGuest) {
                $userid = \Yii::$app->user->identity->id;
            }

            // Essentials

            $condition[] = (isset($postData['beds']) && trim($postData['beds'])!="" && trim($postData['beds'])>0)  ? ['>=','hts_listing.beds', trim($postData['beds'])] : "";
            $condition[] = (isset($postData['bathroom']) && trim($postData['bathroom'])!="" && trim($postData['bathroom'])>0)  ? ['>=','hts_listing.bathrooms', trim($postData['bathroom'])] : "";
            $condition[] = (isset($postData['bedroom']) && trim($postData['bedroom'])!="" && trim($postData['bedroom'])>0)  ? ['>=','hts_listing.bedrooms', trim($postData['bedroom'])] : "";

            // Date Conditions
            if(!empty($checkInDate) && !empty($checkOutDate) && ($checkInDate <= $checkOutDate)) { 
             $dateCondition = ['or',[
                                  'and',
                                  ['hts_listing.bookingavailability'=> "always"],
                                  ['hts_listing.startdate'=> NULL],
                                  ['hts_listing.enddate' => NULL],
                              ], [
                                  'and',
                                  ['hts_listing.bookingavailability'=> "onetime"], 
                                  ['<=','hts_listing.startdate',strtotime($checkInDate)],
                                  ['>=','hts_listing.enddate', strtotime($checkOutDate)],
                              ]
                            ];
            }

            if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="") {
                $currencyCode = $_SESSION['currency_code'];
                $currencySymbol = $_SESSION['currency_symbol'];

                //user currency
                $currencyRate= Myclass::getcurrencyprice($currencyCode); 
            } else {
                $currencydata = Currency::find()->where(['defaultcurrency'=>1])->one(); 

                //user currency
                $currencyRate= Myclass::getcurrencyprice($currencydata->currencycode); 

                $currencyCode = $currencydata->currencycode;
                $currencySymbol = $currencydata->currencysymbol; 
            }  

            if(!empty($priceRange) && count($priceRange) == 2) {
                if(((int)$priceRange[0] <= (int)$priceRange[1]) && ((int)$priceRange[1] <= 10000)) {
                    $priceCondition = ['or', ['between',"Round(((hts_listing.nightlyprice/u.price) * $currencyRate),2)", (int)$priceRange[0],(int)$priceRange[1]], ['between',"Round(((hts_listing.hourlyprice/u.price) * $currencyRate),2)", (int)$priceRange[0],(int)$priceRange[1]], ];  
                } else if((int)$priceRange[0] >= 10000) {
                    $priceCondition = ['or', ['>=',"Round(((hts_listing.nightlyprice/u.price) * $currencyRate),2)",10000], ['>=',"Round(((hts_listing.hourlyprice/u.price) * $currencyRate),2)",10000] ];  
                } else if((int)$priceRange[1] > 10000) {
                    $priceCondition = ['or', ['>=',"Round(((hts_listing.nightlyprice/u.price) * $currencyRate),2)",(int)$priceRange[0]], ['>=',"Round(((hts_listing.hourlyprice/u.price) * $currencyRate),2)",(int)$priceRange[0]] ]; 
                }
            }  

           //Price Filter Sub Query
           $subQuery = (new Query())->select('*')->from('hts_currency')->where('hts_currency.price > 0');

            // Room, Home Condition
            if ($roomTypes != "" && count($roomTypes) > 0) {
                $condition[] = ['IN','hts_listing.roomtype', $roomTypes];
            } 

            if ($homeTypes != "" && count($homeTypes) > 0) {
                $condition[] = ['IN','hts_listing.hometype', $homeTypes];
            }

            // Duration Condition
            if(!empty($durationList) && ($durationList == "perhour" || $durationList == "pernight")){
                 $condition[] = ['=','hts_listing.booking', $durationList];
            }

            // Method Type Condition
            if($methodType == "featured") {

                $query = Listing::find()->where($condition);
                $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency'); 
                $query->andwhere(['hts_listing.featuredlist'=>'1'])->andwhere($priceCondition)->andwhere($dateCondition);
                if($mapAction == "mapped")
                    $query->andwhere($locationCondition); 
                $query->orderBy('hts_listing.featuredate desc');  

                $conditionFlag = 1;

            } elseif ($methodType == "traverse") {
 
              $query = Listing::find()->select(['hts_listing.*', 'count(hts_reservations.listid) AS maxapp']);
              $query->join('RIGHT JOIN', 'hts_reservations', 'hts_reservations.listid = hts_listing.id');
              $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency'); 
              $query->where($condition)->andwhere($priceCondition)->andwhere($dateCondition);
              if($mapAction == "mapped")
                    $query->andwhere($locationCondition);  
               $query->groupBy('hts_reservations.listid')->orderBy('maxapp desc');   
              $conditionFlag = 1;   

            } elseif ($methodType == "country" && !empty($countryId)) {
                $countryData = Country::find()->where(['id'=>$countryId])->one(); 
                if(count($countryData) > 0) {
                    $lat = $countryData->latitude;
                    $lng = $countryData->longitude; 
                    $query = Listing::find()->where($condition);
                    $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency'); 
                    $query->andwhere(['country'=>trim($countryData->id)])->andwhere($priceCondition)->andwhere($dateCondition);
                    if($mapAction == "mapped")
                        $query->andwhere($locationCondition); 

                    $query->orderBy('hts_listing.id desc');
                    $conditionFlag = 1; 
                }
            } elseif($methodType == "location") { 
                $query = Listing::find()->where($condition);
                $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency'); 
                $query->andwhere($priceCondition)->andwhere($dateCondition)->andwhere($locationCondition)->orderBy('hts_listing.id desc');

                $conditionFlag = 1;
            } elseif($methodType == "anywhere" || $methodType == "all") {

                $query = Listing::find()->where($condition);
                $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency');  
                $query->andwhere($priceCondition)->andwhere($dateCondition);
                if($mapAction == "mapped")
                        $query->andwhere($locationCondition);
                $query->orderBy('hts_listing.id desc'); 
                $conditionFlag = 1;   

            }

            if($conditionFlag == 1) {
                if($amenities != "" && count($amenities) > 0) { 
                    $query->joinWith('commonlistings', true, 'LEFT JOIN');
                    $query->andwhere(['IN', 'hts_commonlisting.amenityid', $amenities]); 
                    $query->groupBy('hts_commonlisting.listingid'); 
                }

                
                $countQuery = clone $query;
                $limit = trim($postData['limit']); 
                $offset = trim($postData['offset']); 
                $currentPage = trim($postData['currentPage']); 
                $searchType = trim($postData['searchType']);  
                
                $totalCount = $countQuery->count(); 
                /*echo $query->createCommand()->getRawSql()."<br><BR>".$totalCount;
                die;  */

                $listDetails = $query->offset($offset)->limit($limit)->all();    

                if($searchType == 1 && ($offset + $limit) < $totalCount)
                    $offset = ($currentPage * $limit) - $limit;
                else if($searchType == 1)
                    $offset = ($currentPage * $limit) - $limit;
                else
                    $offset = $limit;

                $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();

                  $wishArray = array();
                  if($userid!="") {
                     $wishlists = Wishlists::find()->where(['userid'=>$userid])->all();
                     foreach ($wishlists as $key => $value) {
                        array_push($wishArray,$value->listingid); 
                     }      
                  }

                return $this->renderPartial('getsearchupdate',['listDetails'=>$listDetails,'sitesettings'=>$sitesettings,
                    'totalCount' => $totalCount, 'currentPage' => $currentPage, 'offset' => $offset,
                    'limit' => $limit,'userid'=>$userid, 'currencyCode'=>$currencyCode,
                    'currencySymbol'=>$currencySymbol, 'wishArray'=>$wishArray,   
                    ]);
            }
        } else {
            // something went wrong 
        }
    }
}

/*
 * Function for cron. If the host did not accept the reservation request with in 48 hours the request will be declined by the host automatically
 */
public function actionBookingresponce(){

    $twodaysbfr = date('Y-m-d H:i:s', strtotime('-48 hours'));

    $reservations = Reservations::find()->where(['<=','cdate',$twodaysbfr])
    ->andWhere(['=','bookstatus','requested'])
    ->all();
            //print_r($reservations);exit;
    if(!empty($reservations)){
        foreach($reservations as $reserve){ 
            $reservation = Reservations::find()->where(['id'=>$reserve->id])->one();
            $reservation->id = $reserve->id;
            $reservation->bookstatus = "declined";
            $reservation->save();
        }
    }
}

/*
 * Function to save the checkin date once the user checked in to the place
 */
public function actionSavecheckin()
{
    $checkindate = $_POST['checkindate'];
    $inhr = $_POST['inhr'];
    $inmin = $_POST['inmin'];
    $insec = $_POST['insec'];
    $checkin = date('Y-m-d',strtotime($checkindate))." ".$inhr.":".$inmin.":".$insec;
    $reserveid = $_POST['reserveid'];
    
    $reservation = Reservations::find()->where(['id'=>$reserveid])->one();
    $reservation->checkin = $checkin;
    if($reservation->save())
    {
        echo "success"."***".$checkin;
    }
    else
    {
        echo "error";
    }
}

/*
 * Function to save the check out date for the user once the user checked out from that place
 */ 
public function actionSavecheckout()
{
    $checkoutdate = $_POST['checkoutdate'];
    $outhr = $_POST['outhr'];
    $outmin = $_POST['outmin'];
    $outsec = $_POST['outsec'];
    $checkout = date('Y-m-d',strtotime($checkoutdate))." ".$outhr.":".$outmin.":".$outsec;
    $reserveid = $_POST['reserveid'];
    
    $reservation = Reservations::find()->where(['id'=>$reserveid])->one();
    $reservation->checkout = $checkout;
    if($reservation->save())
    {
        echo "success"."***".$checkout;
    }
    else
    {
        echo "error";
    }
}

/*
 * Function to save review by the user for the reservation
 */
public function actionSavereview()
{
    $tripid = $_POST['tripid'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $userid = Yii::$app->user->identity->id;
    $reservationdata = Reservations::find()->where(['id'=>$tripid])->one();
    $reviewExist = Reviews::find()->where(['reservationid' => $tripid])->one();  
    if(count($reviewExist) == 0) { 
        $reviewdata = new Reviews();
        $reviewdata->userid = $userid;
        $reviewdata->reservationid = $tripid;
        $reviewdata->rating = $rating;
        $reviewdata->review = $review;
        $reviewdata->listid = $reservationdata->listid;
        if($reviewdata->save())
        {
            echo "success";
            $model = new SignupForm();
            $userdata = $model->findIdentity ( $userid );
            $listingid = $reservationdata->listid;
            $listingdata = Listing::find()->where(['id'=>$listingid])->one();
            $receiverid = $reservationdata->hostid;
            $receiverdata = $model->findIdentity ( $receiverid );
            $notifymessage = 'sent review';
            $message = '';

            $notifications = json_decode($receiverdata->notifications,true);
            if($notifications['messagenotify'] == 1) {
                $logdatas = $this->addlog('review',$userid,$receiverid,$listingid,$notifymessage,$message);
            } 

            if($receiverdata->pushnotification == "1") {
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
                            $messages = array();
                            $messages['message'] = $userdata->firstname.' sent review on your listing '.$listingdata->listingname;
                            $messages['id'] = $reservationdata->inquiryid; 
                            $messages['type'] = 'review';
                            $messages['senderId'] = $reservationdata->userid;
                            $messages['receiverId'] = $reservationdata->hostid; 

                            Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
                        }
                    }  
                } 
            } 
            die;        
        } 
    }
    echo "error";
    
}

/*
 * User can edit their own review
 */
public function actionReviewedit()
{
    $tripid = $_POST['tripid'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $userid = Yii::$app->user->identity->id;
    $reviewdata = Reviews::find()->where(['reservationid'=>$tripid])->one();
    $reviewdata->reservationid = $tripid;
    $reviewdata->review = $review;
    $reviewdata->rating = $rating;
    if($reviewdata->save())
        echo "success";
    else
        echo "error";
}   

/*
 * Displays all the reviews given by you for each reservation
 */
public function actionReviewsbyyou()
{
    $model = new Profile ();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else if (! Yii::$app->user->isGuest) {
        $userid = \Yii::$app->user->identity->id;
        $userdata = $model->findIdentity ( $userid );
    }
    //$reviews = Reviews::find()->where(['userid'=>$userid])->all();
    $query = Reviews::find()->where(['userid'=>$userid]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $reviews = $query->offset($pages->offset)
    ->orderBy('id desc')
    ->limit($pages->limit)
    ->all();        
    return $this->render('reviewsbyyou',[
        'userdata' => $userdata,
        'reviews' => $reviews,
        'pages' => $pages
        ]);
}

/*
 * Displays all the reviews given to you for each reservation
 */
public function actionReviewsaboutyou()
{
    $model = new Profile ();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else if (! Yii::$app->user->isGuest) {
        $userid = \Yii::$app->user->identity->id;
        $userdata = $model->findIdentity ( $userid );
    }
    $listdatas = Listing::find()->where(['userid'=>$userid])->all();
    if(!empty($listdatas))
    {
        foreach($listdatas as $lists)
        {
            $listids[] = $lists['id'];
        }
    }
    else
    {
        $listids[] = "";
    }
    //$reviews = Reviews::find()->where(['listid'=>$listids])->all();
    $query = Reviews::find()->where(['listid'=>$listids]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $reviews = $query->offset($pages->offset)
    ->orderBy('id desc')
    ->limit($pages->limit)
    ->all();    
    return $this->render('reviewsaboutyou',[
        'userdata' => $userdata,
        'reviews' => $reviews,
        'pages' => $pages
        ]);
}

/*
 * Function to get the datas to display the save to wish list popup
 */
public function actionGetlistpopup()
{
    $listid = $_POST['listid'];
    $listdata = Listing::find()->where(['id'=>$listid])->one();
    $photos = Photos::find()->where(['listid'=>$listid])->all();
    if(isset($photos[0]['image_name']))
    {
        $listimage = $photos[0]['image_name'];
    }
    else
    {
        $listimage = "usrimg.jpg";
    }
    if (!(Yii::$app->user->isGuest)) {
        $loguserid = \Yii::$app->user->identity->id;
        $listimg = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$listimage);
        $listresizeurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimg.'&w=465&h=540');
        $listnames = Lists::find()->where(['createdby'=>$loguserid])
        ->orWhere(['user_create'=>0])->all();
        $wishlists = Wishlists::find()->where(['userid'=>$loguserid,'listingid'=>$listdata->id])->all();
        $wishlistid = [];
        if(!empty($wishlists))
        {
          foreach($wishlists as $wishlist)
          {
            $wishlistid[] = $wishlist->listid;
        }
    }
    if(!empty($listnames))
    {
        foreach($listnames as $lists)
        {
            echo '<li class="bg_white padding10 wishli">';
            echo '<p>'.$lists->listname.'</p>';
            echo '<div style="float:right;margin-top: -23px;">';
            if(in_array($lists->id,$wishlistid))
                echo '<i class="fa fa-heart-o whitehrt redhrt" id="'.$lists->id.'"></i>';
            else
                echo '<i class="fa fa-heart-o whitehrt" id="'.$lists->id.'"></i>';
            echo '</div>';
            echo '</li>';
        }
    }
    echo "*****".$listresizeurl;
}

}

/*
 * Function to save the code generated for the user using phone verification
 */
public function actionSaveusercode()
{
    $model = new SignupForm ();
    $code = $_POST['codenumber'];
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else if (! Yii::$app->user->isGuest) {
        $userid = \Yii::$app->user->identity->id;
        $userdata = $model->findIdentity ( $userid );
        $userdata->verifyno = $code;
        $userdata->save();
    }       
}

/*
 * Function to verify the code with the database for phone verification
 */
public function actionVerifyusercode()
{
    $model = new SignupForm ();
    $verifycode = $_POST['verifycode'];
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else if (! Yii::$app->user->isGuest) {
        $userid = \Yii::$app->user->identity->id;
        $userdata = $model->findIdentity ( $userid );
        if($userdata->verifyno==$verifycode)
        {
            $userdata->mobileverify=1;
            $userdata->save();
            echo "success";
        }
        else
        {
            echo "error";
        }
    }           
}

/*
 * Displays all transaction details paid by the user for the reservation 
 */
public function actionCompletedtransaction()
{
    $model = new SignupForm ();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else {
        $userid = Yii::$app->user->identity->id;
        $userdata = $model->findIdentity ( $userid );
    }
                         
    if((isset($_GET['year']) && !empty($_GET['year'])) || (isset($_GET['month']) && !empty($_GET['month']))) 
    {
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? trim($_GET['year']) : "";
        $month = (isset($_GET['month']) && !empty($_GET['month'])) ? trim($_GET['month']) : "";

        if($year == '')
            unset($year);

        if($month == '') 
            unset($month);  

        if(isset($year) && isset($month) && !empty($year) && !empty($month))
        {
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'paid'])
                ->andwhere(['=','bookstatus', 'accepted']) 
                ->andWhere('YEAR(`cdate`)= :year', [':year' => $year])
                ->andWhere('MONTH(`cdate`)= :month', [':month' => $month]);
        } elseif(isset($year) && !isset($month) && !isset($amount) && !empty($year)) {
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'paid'])
                ->andwhere(['=','bookstatus', 'accepted'])
                ->andwhere('YEAR(`cdate`)= :year', [':year' => $year]);
        } elseif(isset($month) && !isset($year) && !isset($amount) && !empty($month)) { 
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'paid'])
                ->andwhere(['=','bookstatus', 'accepted'])
                ->andwhere('MONTH(`cdate`)= :month', [':month' => $month]);
        }  else {
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'paid'])->andwhere(['=','bookstatus', 'accepted']);
        }
        $check = 1;
    } else {
        $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'paid'])->andwhere(['=','bookstatus', 'accepted']);
        $check = 0;
    }

    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $transactions = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->orderBy('id desc')
        ->all();

    return $this->render('completedtransaction',[
        'userdata' => $userdata,
        'transactions' => $transactions,
        'pages' => $pages
        ]);
}

/*
 * Displays all the future transactions paid to the user for the reservations
 */
public function actionFuturetransaction()
{
    $model = new SignupForm ();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else {
        $userid = Yii::$app->user->identity->id;
        $userdata = $model->findIdentity ( $userid );
    }

    if((isset($_GET['year']) && !empty($_GET['year'])) || (isset($_GET['month']) && !empty($_GET['month'])))
    {
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? trim($_GET['year']) : "";
        $month = (isset($_GET['month']) && !empty($_GET['month'])) ? trim($_GET['month']) : "";

        if($year == '')
            unset($year);

        if($month == '') 
            unset($month); 

        if(isset($year) && isset($month) && !empty($year) && !empty($month))
        {
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'pending'])
                ->andwhere(['=','bookstatus', 'accepted'])
                ->andWhere('YEAR(`cdate`)= :year', [':year' => $year])
                ->andWhere('MONTH(`cdate`)= :month', [':month' => $month]);
        } elseif(isset($year) && !isset($month) && !isset($amount) && !empty($year)) {
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'pending'])
                ->andwhere(['=','bookstatus', 'accepted'])
                ->andwhere('YEAR(`cdate`)= :year', [':year' => $year]);
        } elseif(isset($month) && !isset($year) && !isset($amount) && !empty($month)) {
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'pending'])
                ->andwhere(['=','bookstatus', 'accepted'])
                ->andwhere('MONTH(`cdate`)= :month', [':month' => $month]);
        } else {
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'pending'])->andwhere(['=','bookstatus', 'accepted']);
        }
        $check = 1;
    } else {
        $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'pending'])->andwhere(['=','bookstatus', 'accepted']);
        $check = 0;
    }

    $countQuery = clone $query; 
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $transactions = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->orderBy('id desc')
    ->all();  
    return $this->render('futuretransaction',[
        'userdata' => $userdata,
        'transactions' => $transactions,
        'pages' => $pages
        ]);
}


/*
 * Displays all the future transactions paid to the user for the reservations
 */
public function actionOthertransaction() 
{
    $model = new SignupForm ();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else {
        $userid = Yii::$app->user->identity->id;
        $userdata = $model->findIdentity ( $userid );
    }
    $status = array('refunded','claimed');
    if((isset($_GET['year']) && !empty($_GET['year'])) || (isset($_GET['month']) && !empty($_GET['month'])))
    {
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? trim($_GET['year']) : "";
        $month = (isset($_GET['month']) && !empty($_GET['month'])) ? trim($_GET['month']) : "";

        if($year == '')
            unset($year);

        if($month == '') 
            unset($month);
        
        if(isset($year) && isset($month) && !empty($year) && !empty($month))
        {
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'paid'])->andwhere(['IN','bookstatus', $status])->andWhere(['!=','claim_transaction', 'NULL'])
                ->andWhere('YEAR(`cdate`)= :year', [':year' => $year])
                ->andWhere('MONTH(`cdate`)= :month', [':month' => $month]);
        } elseif(isset($year) && !isset($month) && !isset($amount) && !empty($year)) {
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'paid'])->andwhere(['IN','bookstatus', $status])->andWhere(['!=','claim_transaction', 'NULL'])
                ->andwhere('YEAR(`cdate`)= :year', [':year' => $year]);
        } elseif(isset($month) && !isset($year) && !isset($amount) && !empty($month)) { 
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'paid'])->andwhere(['IN','bookstatus', $status])->andWhere(['!=','claim_transaction', 'NULL'])
                ->andwhere('MONTH(`cdate`)= :month', [':month' => $month]);
        } else {
            $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'paid'])->andwhere(['IN','bookstatus', $status])->andWhere(['!=','claim_transaction', 'NULL']); 
        }
        $check = 1;
    } else {
        $query = Reservations::find()->where(['hostid'=>$userid, 'orderstatus'=>'paid'])->andwhere(['IN','bookstatus', $status])->andWhere(['!=','claim_transaction', 'NULL']); 
        $check = 0;
    }  

    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $transactions = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->orderBy('id desc')
    ->all();  
    return $this->render('othertransaction',[
        'userdata' => $userdata,
        'transactions' => $transactions,
        'pages' => $pages
        ]);
} 

/*
 * Diplays all the admin paid transaction details
 */
public function actionGrossearning()
{
    $model = new SignupForm ();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else {
        $userid = Yii::$app->user->identity->id;
        $userdata = $model->findIdentity ( $userid );
    }
    $query = Reservations::find()->where(['hostid'=>$userid,'orderstatus'=>'paid'])
    ->andWhere(['bookstatus'=>'accepted']);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    $transactions = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->orderBy('id desc')
    ->all();    
    return $this->render('grossearning',[
        'userdata' => $userdata,
        'transactions' => $transactions,
        'pages' => $pages
        ]);
}

/*
 * Function to change the currency for the site
 */
public function actionChangecurrency()
{
    if(isset($_POST['currencyid']) && $_POST['currencyid']!="")
    {
        $currencyid = $_POST['currencyid'];
        $currencydatas = Currency::find()->where(['id'=>$currencyid])->one();
        $_SESSION['currency_code'] = $currencydatas->currencycode;
        $_SESSION['currency_symbol'] = $currencydatas->currencysymbol;
    }
    else
    {
        $_SESSION['currency_code'] = "";
        $_SESSION['currency_symbol'] = "";
    }
}

/*
 * Function to view the completed transaction order details
 */
public function actionVieworder($details)
{
    $signupmodel = new SignupForm ();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else {
        $userid = Yii::$app->user->identity->id;
        $userdata = $signupmodel->findIdentity ( $userid );
    } 
    
    $id = explode('*', base64_decode($details)); 
    if(count($id) == 2 && ($id[0]=="other" || $id[0]=="future" || $id[0]=="completed") && $id[1] > 0) {
       $reservation = Reservations::find()->where(['id'=>$id[1]])->one();
       if($userid == $reservation->hostid) {
           $hostdata = $reservation->getHost()->where(['id'=>$reservation->hostid])->one();
           $guestdata = $reservation->getUser0()->where(['id'=>$reservation->userid])->one();
           $listdata = $reservation->getList()->where(['id'=>$reservation->listid])->one();

           if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="") {
               $currency_code = $_SESSION['currency_code'];
               $currency_symbol = $_SESSION['currency_symbol'];

               //listing currency
               $rate1= Myclass::getcurrencyprice($reservation->currencycode);
               //reservation currency
               $rate2= Myclass::getcurrencyprice($reservation->convertedcurrencycode);
               //user currency
               $rate= Myclass::getcurrencyprice($currency_code); 
           } else {
               $currencydata = Currency::find()->where(['defaultcurrency'=>1])->one(); 
               //listing currency
               $rate1= Myclass::getcurrencyprice($reservation->currencycode);
               //reservation currency
               $rate2= Myclass::getcurrencyprice($reservation->convertedcurrencycode);
               //user currency
               $rate= Myclass::getcurrencyprice($currencydata->currencycode); 
               
               $currency_code = $currencydata->currencycode;
               $currency_symbol = $currencydata->currencysymbol;
           }

           $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();

           return $this->render('vieworder', [
                   'model' => $reservation,
                   'hostdata' => $hostdata,
                   'guestdata' => $guestdata,
                   'listdata' => $listdata,
                   'userdata' => $userdata,
                   'currency_code' => $currency_code,
                   'rate' => $rate,
                   'rate2' => $rate2, 
                   'rate1' => $rate1,  
                   'currency_symbol' => $currency_symbol,  
                   'backtag' => $id[0], 
                   ]); 

       } else {
         Yii::$app->getSession ()->setFlash ( 'success', 'Access denied.' );
           return $this->goHome (); 
       }
   } else { 
      Yii::$app->getSession ()->setFlash ( 'success', 'Not Found' ); 
      return $this->goHome ();
   }   
}

/*
 * Function to view the future transaction order details
 */
public function actionViewfutureorder($id)
{
    $signupmodel = new SignupForm ();
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else {
        $userid = Yii::$app->user->identity->id;
        $userdata = $signupmodel->findIdentity ( $userid );
    }
    

    $reservation = Reservations::find()->where(['id'=>$id])->one();
    if($userid == $reservation->hostid) {
        $hostdata = $reservation->getHost()->where(['id'=>$reservation->hostid])->one();
        $guestdata = $reservation->getUser0()->where(['id'=>$reservation->userid])->one();
        $listdata = $reservation->getList()->where(['id'=>$reservation->listid])->one();

        if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="") {
            $currency_code = $_SESSION['currency_code'];
            $currency_symbol = $_SESSION['currency_symbol'];

            //listing currency
            $rate1= Myclass::getcurrencyprice($reservation->currencycode);
            //reservation currency
            $rate2= Myclass::getcurrencyprice($reservation->convertedcurrencycode);
            //user currency
            $rate= Myclass::getcurrencyprice($currency_code); 
        } else {
            $currencydata = Currency::find()->where(['defaultcurrency'=>1])->one(); 
            //listing currency
            $rate1= Myclass::getcurrencyprice($reservation->currencycode);
            //reservation currency
            $rate2= Myclass::getcurrencyprice($reservation->convertedcurrencycode);
            //user currency
            $rate= Myclass::getcurrencyprice($currencydata->currencycode); 
            
            $currency_code = $currencydata->currencycode;
            $currency_symbol = $currencydata->currencysymbol;
        }

        $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();

        return $this->render('viewfutureorder', [
                'model' => $reservation,
                'hostdata' => $hostdata,
                'guestdata' => $guestdata,
                'listdata' => $listdata,
                'userdata' => $userdata,
                'currency_code' => $currency_code,
                'rate' => $rate,
                'rate2' => $rate2, 
                'rate1' => $rate1,  
                'currency_symbol' => $currency_symbol,  
                ]);

    } else {
        return $this->goHome (); 
    }
}   


public function actionCheckdates()
{
    $listid=$_POST['listid'];
    $dateRange=$_POST['dateRange'];
    $listdata = Listing::find()->where(['id'=>$listid])->one();
    $hourly_availablity=explode(',',$listdata->hourly_availablity);
    $hourly_availablity=array_filter($hourly_availablity);  
    $hourly_availablity_count=count($hourly_availablity);
    if($hourly_availablity_count >0)
    {
        $currentdate=time();
        $reservations = Reservations::find()->where(['listid'=>$listid])
        ->andWhere(['!=','bookstatus','cancelled'])
        ->andWhere(['!=','bookstatus','declined'])
        ->andWhere(['>','fromdate',$currentdate])
        ->andWhere(['=','booking','perhour'])
        ->all();
        foreach($reservations as $res)
        {
            $resdate=$res->fromdate;
            $hourly_availablity_array=array();
            $checkreservations = Reservations::find()->where(['fromdate'=>$resdate])->count();
            if($checkreservations >= $hourly_availablity_count){
                array_push($hourly_availablity_array,$resdate);
            }
        }

        $newhourly_availablity_array = array_merge($hourly_availablity_array,$dateRange);
        echo $newhourly_availablity_array;
    }
    
    
}

public function actionChangecanceldesc() {
    $id = trim($_POST['cancellationid']);
    $cancellation = Cancellation::find()->where(['id'=>$id])->one();
    if(!empty($cancellation)) {
        echo $cancellation['canceldesc'];
    } else {
        echo 'empTy';
    }
    die;
}      

public function actionDisableddates()
{
    $booking=$_POST['booking'];
    $list_id=$_POST['list_id'];
    $todaydate = date('m/d/Y');
    $today = strtotime($todaydate);
    $listdata = Listing::find()->where(['id'=>$list_id])->one();
    if($booking=='perhour')
    {
        $connection = Yii::$app->getDb();
        $hourly_availablity=$listdata->hourly_availablity;
        $hourly_availablity=explode(',',$hourly_availablity);
        $hourly_availablity=array_filter($hourly_availablity);
        $hourly_availablity_count=count($hourly_availablity);
        $hourreservations = $connection->createCommand ( "SELECT count(todate),fromdate,todate,listid FROM hts_reservations WHERE listid='".$list_id."' and todate >= $today and bookstatus!='declined' and bookstatus!='cancelled' group by todate HAVING COUNT(todate) >= '".$hourly_availablity_count."'");
        $reservations = $hourreservations->queryAll();
        if(isset($reservations) && !empty($reservations))
        {
            for($h=0;$h<count($reservations);$h++)
            {
                $startdates[] = $reservations[$h]['fromdate'];
                $enddates[] = $reservations[$h]['todate'];
            }
        }
        else
        {
            $startdates = "";
            $enddates = "";
        }

        echo json_encode($startdates).'******'.json_encode($enddates);
    }
    else
    {
        echo '*****';
    }
}

public function actionCalendar()
{
   if (Yii::$app->user->isGuest) {
     return $this->goHome ();
   } else {  
      $defaultcurrency = Currency::find()->where(['defaultcurrency'=>1])->one(); 
      if (Yii::$app->request->isAjax) {
         $listId = (isset($_POST['listid']) && trim($_POST['listid'])!="") ? trim($_POST['listid']): 0;
         $listingFlag = (isset($_POST['listingFlag']) && trim($_POST['listingFlag'])!="") ? trim($_POST['listingFlag']): ""; 

         $loguserid = Yii::$app->user->identity->id;
         $listdata = Listing::find()->where(['userid'=>$loguserid, 'id'=>$listId, 'liststatus'=>1])->one();

         $userHostStatus = Yii::$app->user->identity->hoststatus;

         if(count($listdata) > 0 && $userHostStatus == 1 && ($listingFlag == "fetch" || $listingFlag == "update" || $listingFlag == "check")) { 
            $updateFlag = 0; 

            if($listingFlag == "update") {
               $splDates = array_filter(explode(',',$_POST['listingDateRange'])); // date with comma
               $splListingstatus = trim($_POST['listingStatus']); //available, blocked, default
               $splListingprice = trim($_POST['listingSpecialPrice']); // price if available
               $splNotes = trim($_POST['listingNotes']); // if available or blocked
               $splcheckprice = NULL;
             
               $splcheckprice = ($listdata->booking == "pernight")? $listdata->nightlyprice : $listdata->hourlyprice;   

               if(count($splDates) >=1 && ($splListingstatus == "available" || $splListingstatus == "blocked")) {

                  $availPrice = ($listdata->specialprice!="" && $listdata->specialprice != NULL) ? json_decode($listdata->specialprice) : NULL;
                  $blockPrice = ($listdata->blockedspecialprice!="" && $listdata->blockedspecialprice != NULL) ? json_decode($listdata->blockedspecialprice) : NULL;
                  $normalPrice = ($listdata->normalprice!="" && $listdata->normalprice != NULL) ? json_decode($listdata->normalprice) : NULL; 

                  if($availPrice!=NULL || $blockPrice!=NULL || $normalPrice!=NULL) { 
                     for($i=0; $i < count($splDates) ; $i++) { 
                        $checkDate  = explode('/', $splDates[$i]);

                        if (count($checkDate) == 3) {
                           if (checkdate(trim($checkDate[0]), trim($checkDate[1]), trim($checkDate[2]))) {
                              $calendarDate = strtotime(trim($splDates[$i]));

                              if($normalPrice != NULL) {
                                 $Temp = array();
                                 foreach ($normalPrice as $nkey => $normalVal) {
                                   $a_startdate = strtotime(trim($normalVal->specialstartDate));
                                   $a_enddate = strtotime(trim($normalVal->specialendDate));

                                   // old dates removed and array redefined
                                   if(($a_startdate == $calendarDate && $a_enddate == $calendarDate) ||($a_enddate <= time())) {
                                      unset($normalPrice[$nkey]);
                                   } elseif ($a_startdate == $calendarDate) {
                                      $normalVal->specialstartDate = date("m/d/Y",strtotime($normalVal->specialstartDate.'+1 days'));
                                   } elseif ($a_enddate == $calendarDate) {
                                      $normalVal->specialendDate = date("m/d/Y",strtotime($normalVal->specialendDate.'-1 days'));
                                   } elseif ($a_startdate < $calendarDate && $a_enddate > $calendarDate) {
                                      $end_date = $normalVal->specialendDate;
                                      $normalVal->specialendDate = date("m/d/Y",strtotime(date("m/d/Y",$calendarDate).'-1 days'));

                                      $Temp['specialstartDate'] = date("m/d/Y",strtotime(date("m/d/Y",$calendarDate).'+1 days'));
                                      $Temp['specialendDate'] = $end_date;
                                      $Temp['liststatus'] = $normalVal->liststatus;
                                      $Temp['note'] = $normalVal->note;
                                      
                                   }
                                 }

                                 if(count($Temp) > 0) {
                                    $normalPrice[] = $Temp;
                                 }
                                 $normalPrice = json_decode(json_encode(array_values($normalPrice)));
                              } 

                              if($availPrice != NULL) {
                                 $Temp = array();
                                 foreach ($availPrice as $akey => $availVal) {
                                   $a_startdate = strtotime(trim($availVal->specialstartDate));
                                   $a_enddate = strtotime(trim($availVal->specialendDate));

                                   // old dates removed and array redefined
                                   if(($a_startdate == $calendarDate && $a_enddate == $calendarDate) ||($a_enddate <= time())) {
                                      unset($availPrice[$akey]);
                                   } elseif ($a_startdate == $calendarDate) {
                                      $availVal->specialstartDate = date("m/d/Y",strtotime($availVal->specialstartDate.'+1 days'));
                                   } elseif ($a_enddate == $calendarDate) {
                                      $availVal->specialendDate = date("m/d/Y",strtotime($availVal->specialendDate.'-1 days'));
                                   } elseif ($a_startdate < $calendarDate && $a_enddate > $calendarDate) {
                                      $end_date = $availVal->specialendDate;
                                      $availVal->specialendDate = date("m/d/Y",strtotime(date("m/d/Y",$calendarDate).'-1 days'));

                                      $Temp['specialstartDate'] = date("m/d/Y",strtotime(date("m/d/Y",$calendarDate).'+1 days'));
                                      $Temp['specialendDate'] = $end_date;
                                      $Temp['liststatus'] = $availVal->liststatus;
                                      $Temp['specialprice'] = $availVal->specialprice;
                                      $Temp['note'] = $availVal->note;
                                      
                                   }
                                 }

                                 if(count($Temp) > 0) {
                                    $availPrice[] = $Temp;
                                 }
                                 $availPrice = json_decode(json_encode(array_values($availPrice)));
                              }

                              if($blockPrice != NULL) {
                                 $Temp = array();
                                 foreach ($blockPrice as $bkey => $blockVal) {
                                    $a_startdate = strtotime(trim($blockVal->specialstartDate));
                                    $a_enddate = strtotime(trim($blockVal->specialendDate));

                                    // old dates removed and array redefined
                                    if(($a_startdate == $calendarDate && $a_enddate == $calendarDate) ||($a_enddate <= time())) {
                                       unset($blockPrice[$bkey]);
                                    } elseif ($a_startdate == $calendarDate) {
                                       $blockVal->specialstartDate = date("m/d/Y",strtotime($blockVal->specialstartDate.'+1 days'));
                                    } elseif ($a_enddate == $calendarDate) {
                                       $blockVal->specialendDate = date("m/d/Y",strtotime($blockVal->specialendDate.'-1 days'));
                                    } elseif ($a_startdate < $calendarDate && $a_enddate > $calendarDate) {
                                       $end_date = $blockVal->specialendDate;
                                       $blockVal->specialendDate = date("m/d/Y",strtotime(date("m/d/Y",$calendarDate).'-1 days'));

                                       $Temp['specialstartDate'] = date("m/d/Y",strtotime(date("m/d/Y",$calendarDate).'+1 days'));
                                       $Temp['specialendDate'] = $end_date;
                                       $Temp['liststatus'] = $blockVal->liststatus;
                                       $Temp['specialprice'] = $blockVal->specialprice;
                                       $Temp['note'] = $blockVal->note;
                                      
                                    }
                                 }

                                 if(count($Temp) > 0){
                                    $blockPrice[] = $Temp;
                                 }
                                 $blockPrice = json_decode(json_encode(array_values($blockPrice)));
                              }
                           }
                        }
                     }
                  }

                  if(($splListingstatus == "available" && $splcheckprice != $splListingprice) || $splListingstatus == "blocked") {
                     for ($i=0; $i < count($splDates) ; $i++) {
                        $checkDate  = explode('/', $splDates[$i]);
                        if (count($checkDate) == 3) {
                           if (checkdate($checkDate[0], $checkDate[1], $checkDate[2])) {
                              $calendarDate = strtotime(trim($splDates[$i]));
                              $Temp = array();
                              $Temp['specialstartDate'] = date("m/d/Y",trim($calendarDate));
                              $Temp['specialendDate'] = date("m/d/Y",trim($calendarDate));
                              $Temp['liststatus'] = $splListingstatus;
                              $Temp['specialprice'] = $splListingprice;
                              $Temp['note'] = $splNotes;

                              if($splListingstatus == "available") {
                                $availPrice[count($availPrice)] = $Temp;
                              } elseif ($splListingstatus == "blocked") {
                                $blockPrice[count($blockPrice)] = $Temp;
                              }
                           }
                        } 
                     }
                  } elseif($splListingstatus == "available" && $splcheckprice == $splListingprice && $splNotes!="") { 
                     for ($i=0; $i < count($splDates) ; $i++) {
                        $checkDate  = explode('/', $splDates[$i]);
                        if (count($checkDate) == 3) {
                           if (checkdate($checkDate[0], $checkDate[1], $checkDate[2])) {
                              $calendarDate = strtotime(trim($splDates[$i]));
                              $Temp = array();
                              $Temp['specialstartDate'] = date("m/d/Y",trim($calendarDate));
                              $Temp['specialendDate'] = date("m/d/Y",trim($calendarDate));
                              $Temp['liststatus'] = "normal";
                              $Temp['note'] = $splNotes;

                              $normalPrice[count($normalPrice)] = $Temp;
                           }
                        } 
                     }
                  }

                  if((($availPrice!=NULL) && !empty($availPrice)) || (($blockPrice!=NULL) && !empty($blockPrice))) {
                    $listdata->splpricestatus = 1; 
                  } else if ((($availPrice==NULL) || empty($availPrice)) && (($blockPrice==NULL) || empty($blockPrice))) {
                     $listdata->splpricestatus = 0; 
                  }

                  $listdata->specialprice = (($availPrice!=NULL) && !empty($availPrice)) ? json_encode($availPrice) : NULL;
                  $listdata->blockedspecialprice = (($blockPrice!=NULL) && !empty($blockPrice)) ? json_encode($blockPrice) : NULL; 
                  $listdata->normalprice = (($normalPrice!=NULL) && !empty($normalPrice)) ? json_encode($normalPrice) : NULL; 

                  $listdata->save(false);
                  $updateFlag = 1;
               } 
            }

            if($listingFlag == "check") {
               $splDates = array_filter(explode(',',$_POST['dateRangeValue'])); // date with comma
               $availCount = 0;
               $blockCount = 0;
               $defaultCount = 0;
               $noteData = "";
               $priceData = "";
               $normalCount = count($splDates);

               if(count($splDates) >=1) {
                  $availPrice = ($listdata->specialprice!="" && $listdata->specialprice != NULL) ? json_decode($listdata->specialprice) : NULL;
                  $blockPrice = ($listdata->blockedspecialprice!="" && $listdata->blockedspecialprice != NULL) ? json_decode($listdata->blockedspecialprice) : NULL;
                  $normalPrice = ($listdata->normalprice!="" && $listdata->normalprice != NULL) ? json_decode($listdata->normalprice) : NULL;  
                  $weekDayCnt = 0;

                 // if($availPrice!=NULL || $blockPrice!=NULL || $normalPrice!=NULL) {  
                     for($i=0; $i < count($splDates) ; $i++) {  
                        $checkDate  = explode('/', $splDates[$i]);

                        if (count($checkDate) == 3) {
                           if (checkdate(trim($checkDate[0]), trim($checkDate[1]), trim($checkDate[2]))) {
                              $calendarDate = strtotime(trim($splDates[$i]));

                              $day = strtolower(date('D', $calendarDate));
                              if($day == "fri" || $day=="sat") {
                                 ++$weekDayCnt;
                              } 
                              

                              if($normalPrice != NULL) {
                                 foreach ($normalPrice as $nkey => $normalVal) {
                                   $a_startdate = strtotime(trim($normalVal->specialstartDate));
                                   $a_enddate = strtotime(trim($normalVal->specialendDate));

                                   if ($a_startdate <= $calendarDate && $a_enddate >= $calendarDate) {
                                       if($noteData == "" && trim($normalVal->note)!="") {
                                          $noteData = trim($normalVal->note);
                                       } elseif ($noteData != "" && trim($normalVal->note)!="") {
                                          if(trim($noteData) != trim($normalVal->note)) {
                                             $noteData = "";
                                          }
                                       }
                                       ++$defaultCount;  
                                    }
                                 }
                              }

                              if($availPrice != NULL) {
                                 foreach ($availPrice as $akey => $availVal) {
                                   $a_startdate = strtotime(trim($availVal->specialstartDate));
                                   $a_enddate = strtotime(trim($availVal->specialendDate));

                                   if ($a_startdate <= $calendarDate && $a_enddate >= $calendarDate) {
                                       if($noteData == "" && trim($availVal->note)!="") {
                                          $noteData = trim($availVal->note);
                                       } elseif ($noteData != "" && trim($availVal->note)!="") {
                                          if(trim($noteData) != trim($availVal->note)) {
                                             $noteData = "";
                                          }
                                       }

                                       if($priceData == "" && trim($availVal->specialprice)!="") {
                                          $priceData = trim($availVal->specialprice);
                                       } elseif($priceData!="" && trim($availVal->specialprice)!="") {
                                          if(trim($priceData) != trim($availVal->specialprice)) {
                                             $priceData = "";
                                          }
                                       }
                                       ++$availCount;                                     
                                    }
                                 }
                              }

                              if($blockPrice != NULL) { 
                                 foreach ($blockPrice as $bkey => $blockVal) {
                                    $a_startdate = strtotime(trim($blockVal->specialstartDate));
                                    $a_enddate = strtotime(trim($blockVal->specialendDate));

                                    if ($a_startdate<=$calendarDate && $a_enddate>=$calendarDate) {
                                       if($noteData == "" && trim($blockVal->note)!="") {
                                          $noteData = trim($blockVal->note);
                                       } elseif ($noteData != "" && trim($blockVal->note)!="") {
                                          if(trim($noteData) != trim($blockVal->note)) {
                                             $noteData = "";
                                          }
                                       }

                                       if($priceData == "" && trim($blockVal->specialprice)!="") {
                                          $priceData = trim($blockVal->specialprice);
                                       } elseif($priceData!="" && trim($blockVal->specialprice)!="") {
                                          if(trim($priceData) != trim($blockVal->specialprice)) {
                                             $priceData = "";
                                          }
                                       }  
                                       ++$blockCount;
                                    } 
                                 }
                              }
                           }
                        }
                     }
                 // } 
               }
               $weekendDiscount = $listdata->weekendprice;

               if($weekDayCnt == $normalCount && $availCount == 0 && $weekendDiscount == '1') { 
                    $queryWeekend = Weekendprice::find()->where(['listid'=>$listdata->id])->one();
                    $priceData = $queryWeekend->weekend_price;  
               } else if($priceData == "") { 
                 $priceData = ($listdata->booking == "pernight")? $listdata->nightlyprice : $listdata->hourlyprice;
               }  
               $normalCount = $normalCount - $availCount - $blockCount; 

               $noteData = (($blockCount == 0 && $availCount > 0 && $normalCount == 0) || ($blockCount > 0 && $availCount == 0 && $normalCount == 0) || (($normalCount == $defaultCount) && $availCount == 0 && $blockCount == 0 )) ? $noteData : "";

               $priceData = (($blockCount == 0 && $availCount > 0 && $normalCount == 0) || ($blockCount == 0 && $availCount == 0 && $normalCount > 0)) ? $priceData : "";   

               $dropStatus = ($blockCount > 0 && $availCount == 0 && $normalCount == 0) ? "0" : "1";
               
               echo base64_encode($dropStatus."***~#~***".$noteData."***~#~***".$priceData);  
               die;
            } 
         
            if($listingFlag == "update" || $listingFlag == "fetch") {
               $lastListing = Listing::find()->where(['userid'=>$loguserid, 'id'=>$listId, 'liststatus'=>1])->one();
               // Fetch Process
               $availDates = ""; $blockDates = ""; $availRate = "";
               $todaydate = date('m/d/Y');
               $today = strtotime($todaydate);
               $currency_code = "";
               $currency_symbol = "";

               $weekendDiscount = $lastListing->weekendprice;
               if($weekendDiscount == '1'){
                 $queryWeekend = Weekendprice::find()->where(['listid'=>$lastListing->id])->one();
                 $weekendPrice = $queryWeekend->weekend_price; 
               }else{
                 $weekendPrice = '';
               }

               if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="" && isset($_SESSION['currency_symbol']) && $_SESSION['currency_symbol']!="") { 
                  $currency_code = $_SESSION['currency_code'];
                  $currency_symbol = $_SESSION['currency_symbol'];
               } else {
                  $currency_code = $defaultcurrency->currencycode;
                  $currency_symbol = $defaultcurrency->currencysymbol;
               }

               $listingcurrency = Currency::find()->where(['id'=>$lastListing->currency])->one(); 
               $rate2= Myclass::getcurrencyprice($listingcurrency->currencycode);//listing currency
               $rate= Myclass::getcurrencyprice($currency_code);//user currency

               if(trim($lastListing->splpricestatus) == 1) {

                  if(trim($lastListing->specialprice) !="") {
                     $specialpricedata = json_decode($lastListing->specialprice);

                     if(count($specialpricedata) > 0 ) {
                        foreach ($specialpricedata as $key => $special) {
                           if(strtotime($special->specialendDate) >= $today) {
                              $c_sdate = strtotime(trim($special->specialstartDate));
                              $c_edate = strtotime(trim($special->specialendDate));
                              $c_price = trim($special->specialprice);
                              //$c_price = round(($rate * (trim($special->specialprice)/$rate2)),2);

                              if ($c_edate >= $c_sdate) {
                                 for ($pDates=$c_sdate; $pDates <= $c_edate; $pDates+=86400) {
                                    if($pDates >= $today) {
                                       $pDate = date('j/n/Y', $pDates);
                                       $availDates.= (trim($availDates=="")) ? $pDate : ",".$pDate; 
                                       $availRate.= (trim($availRate=="")) ? $c_price : ",".$c_price;
                                    }
                                 }
                              }
                           }
                        }
                     }
                  }

                  if(trim($lastListing->blockedspecialprice) !="") {
                     $specialpricedata = json_decode($lastListing->blockedspecialprice);

                     if(count($specialpricedata) > 0 ) {
                        foreach ($specialpricedata as $key => $special) {
                           if(strtotime($special->specialendDate) >= $today) {
                              $c_sdate = strtotime(trim($special->specialstartDate));
                              $c_edate = strtotime(trim($special->specialendDate));

                              if ($c_edate >= $c_sdate) {
                                 for ($pDates=$c_sdate; $pDates <= $c_edate; $pDates+=86400) {
                                    if($pDates >= $today) {
                                       $pDate = date('j/n/Y', $pDates);
                                       $blockDates.= (trim($blockDates=="")) ? $pDate : ",".$pDate; 
                                    }                                      
                                 }
                              }
                           }
                        }
                     }
                  } 
               }
               $durationPrice = ($lastListing->booking == "pernight")? $lastListing->nightlyprice : $lastListing->hourlyprice; 
               $durationText = ($lastListing->booking == "pernight")? Yii::t("app","Nightly price") : Yii::t("app","Hourly price");  
               //$listingOrginalPrice = round(($rate * ($durationPrice/$rate2)),2);
               $listingOrginalPrice = $durationPrice;  
               $listingCurrency = $listingcurrency->currencysymbol;

               $htmlData = '<div id="dater"></div><a href="javascript:void(0);" class="clearCalendar float-left">'.Yii::t('app','Clear').'</a><a href="javascript:void(0);" id="showr" class="editCalendar btn float-right"><i class="fa fa-edit"></i> '.Yii::t('app','Edit').'</a>';

               $stripe_USD = Myclass::getcurrencyprice('USD'); 
               $list_CUR = $listingcurrency->price;  

               $stripe_money = ceil(($stripe_USD * 10) * ($list_CUR));

               echo base64_encode($availDates."***~#~***".$blockDates."***~#~***".$availRate."***~#~***".$listingOrginalPrice."***~#~***".$durationPrice."***~#~***".$durationText."***~#~***".$updateFlag."***~#~***".$htmlData)."###~#~###".$listingCurrency."###~#~###".$weekendPrice."###~#~###".$stripe_money;     
               die;
            }
         }

         echo "failed";
         die;  

      } else { 
         $loguserid = Yii::$app->user->identity->id;
         $userHostStatus = Yii::$app->user->identity->hoststatus;
         $userListings = Listing::find()->where(['userid'=>$loguserid, 'liststatus'=>1])->orderBy('id desc')->all();

         if($userHostStatus == 1 && count($userListings) > 0) {
             $lastListing = Listing::find()->where(['userid'=>$loguserid, 'liststatus'=>1])->orderBy('id desc')->one();
             $listingcurrency = Currency::find()->where(['id'=>$lastListing->currency])->one(); 
             return $this->render('calendar', [
                'listings' => $userListings,
                'lastListing' => $lastListing,  
                'loguserid' => $loguserid, 
                'defaultcurrency' => $defaultcurrency,
                'listingcurrency' => $listingcurrency,
             ]);
         } else {
             Yii::$app->getSession ()->setFlash ( 'success', 'Not Found' ); 
             return $this->redirect(['/dashboard']); 
         } 
      } 
   }
}

public function actionViewdetail($details)
{
    if (Yii::$app->user->isGuest) {
        return $this->goHome ();
    } else {            
        $details = base64_decode($details); 
        $details = explode(".",$details); 

        if(count($details) == 3 && is_numeric($details[1])) { 
            $inquiryId = trim(hex2bin($details[1])); 
            $userType = trim($details[2]); 
            $inquiryData = Inquiry::find()->where(['id'=> $inquiryId])->one();
            if(!empty($inquiryData)) { 
                $senderid = trim($inquiryData->senderid);
                $receiverid = trim($inquiryData->receiverid);
                $listingid = trim($inquiryData->listingid);

                $userform = new SignupForm();
                $loguserid = Yii::$app->user->identity->id;
                $userdata = $userform->findIdentity($loguserid);

                $senderdata = User::find()->where(['id'=>$senderid])->one();
                $receiverdata = User::find()->where(['id'=>$receiverid])->one();
                    
                if($loguserid != $receiverid)               
                    $otherUser = $inquiryData->receiverid;
                else 
                    $otherUser = $inquiryData->senderid;

                $models = new SignupForm();
                $otherUserData = User::find()->where(['id'=>$otherUser])->one();
                $shippingaddress = Shippingaddress::find()->where(['userid'=>$otherUserData->id])->one(); 
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

                $roomData = Roomtype::find()->where(['id'=>$reservelistdata->roomtype])->one();
                $homeData = Hometype::find()->where(['id'=>$reservelistdata->hometype])->one();
                $cancelData = Cancellation::find()->where(['id'=>$reservelistdata->cancellation])->one(); 

                $reservedurationType = trim($reservelistdata->booking);
                
                return $this->render('viewdetail',[
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
                        'inquiryId' => $inquiryId, 
                        'roomData' => $roomData,   
                        'homeData' => $homeData,   
                        'cancelData' => $cancelData,    
                        'userType' => $userType,    
                        ]);
            } else {
                Yii::$app->getSession ()->setFlash ( 'success', 'Not Found' );
                return $this->redirect(['/user/messages/inbox/'.$details[2]]); 
            }
        } else {
            if(isset($details[2]) && trim($details[2])=="traveling") {
                Yii::$app->getSession ()->setFlash ( 'success', 'Not Found' );
                return $this->redirect(['/user/messages/inbox/'.$details[2]]);  
            } else {
                Yii::$app->getSession ()->setFlash ( 'success', 'Invalid access' );
                return $this->goHome ();  
            }
        }
    } 


}


public function actionChangetimezone() {
    $id = trim($_POST['countryid']);
    $countryData = Country::find()->where(['id'=>$id])->one();
    if(count($countryData) > 0) {
       $timeZoneData = Timezone::find()->where(['code'=>$countryData->code])->all();
       $timeZoneResult = "<option value=''>Select</option>";
       if(count($timeZoneData) > 0) {
            $timeZoneResult = "";
            foreach ($timeZoneData as $key => $value) {
                $timeZoneResult .="<option value='".$value->id."'>".$value->timezone."</option>";
            }
       }
       echo $timeZoneResult;  
    } else {
        echo 'empTy';
    }
    die;
}















}
 