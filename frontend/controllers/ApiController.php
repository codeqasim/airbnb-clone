<?php
namespace frontend\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use common\models\LoginForm;
use common\models\User;
use backend\components\Myclass; 
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Country;
use frontend\models\Photos;
use frontend\models\Profile;
use frontend\models\Userinvites;
use frontend\models\Shippingaddress;
use frontend\models\Sitesettings;
use frontend\models\Homepagesettings;
use frontend\models\Buttonsliders;
use frontend\models\Textsliders;
use frontend\models\Timezone;
use frontend\models\Listing;
use frontend\models\Wishlists;
use frontend\models\Hometype;
use frontend\models\Roomtype;
use frontend\models\Reservations;
use frontend\models\Invoices;
use frontend\models\Commonlisting;
use frontend\models\Homecountries;
use frontend\models\Additionallisting;
use frontend\models\Speciallisting;
use frontend\models\Safetylisting;
use frontend\models\Commission;
use frontend\models\Claim;
use frontend\models\Claimmessage;
use frontend\models\Sitecharge;
use frontend\models\Tax;
use frontend\models\Messages;
use frontend\models\Logs;
use frontend\models\Lists;
use frontend\models\Languages;
use frontend\models\Users;
use frontend\models\Listingproperties;
use frontend\models\Userdevices;
use frontend\models\Currency;
use frontend\models\Commonamenities;
use frontend\models\Additionalamenities;
use frontend\models\Specialfeatures;
use frontend\models\Safetycheck;
use frontend\models\Reportlisting;
use frontend\models\Userreports;
use frontend\models\Profilereports;
use frontend\models\Inquiry;
use backend\models\Cancellation;
use backend\models\Help;
use frontend\models\Reviews;
use frontend\models\Weekendprice;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\Cookie;
use yii\data\SqlDataProvider;
use \yii\data\Pagination;
use yii\db\Query; 
use yii\helpers\ArrayHelper;


/**
 * Site controller
 */
class ApiController extends Controller
{
	public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
		return [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'only' => [ 
								'logout',
						],
						'rules' => [ 
								[ 
										'actions' => [ 
												'signup' 
										],
										'allow' => true,
										'roles' => [ 
												'?' 
										] 
								],
								[ 
										'actions' => [ 
												'auth' 
										],
										'allow' => true,
										'roles' => [ 
												'@' 
										] 
								],
								[ 
										'actions' => [ 
												'logout' 
										],
										'allow' => true,
										'roles' => [ 
												'@' 
										] 
								] 
						] 
				]
		];
    }
	
	public function beforeAction($action) {
		$model = new SignupForm ();
		if(isset($_POST['user_id']) && $_POST['user_id']!="")
		{
			$userid = $_POST['user_id'];
			$userdata = $model->findIdentity ( $userid );
			if(count($userdata) == 0 || $userdata->userstatus == 0) {
				echo '{"status":"error","message":"Your account is blocked, please contact Admin to unblock"}';
				die;	
			}
		}
		return parent::beforeAction($action);
	}

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
				'auth' => [ 
						'class' => 'yii\authclient\AuthAction',
						'successCallback' => [ 
								$this,
								'successCallback' 
						] 
				] 			
        ];
    }
	public function successCallback($client) {
		$attributes = $client->getUserAttributes ();
		// user login or signup comes here
		die(print_r($attributes));
	}	

    /**
     * Displays homepage.
     *
     * @return mixed
     */
   public function actionIndex()
   {
   	/*$datetime1 = new DateTime(trim(booking_timing[0]));
   	$datetime2 = new DateTime(trim(booking_timing[1]));

		$interval = $datetime1->diff($datetime2);
		echo $interval->format('%hh');*/

		//date_default_timezone_set('Asia/Calcutta');
		//$date = date('m/d/Y h:i:s a', time()); 
		//echo $date;

		//https://api.transferwise.com/v1/rates?source=USD&target=INR
		
		//$url = 'http://www.xe.com/currencyconverter/convert/?Amount='.$amount.'&From='.$from_Currency.'&To='.$to_Currency;
		/*$url = 'https://www.x-rates.com/calculator/?from=USD&to=INR&amount=1';
             $rawdata = file_get_contents($url); 
              $data = explode('ccOutputRslt">', $rawdata);
             $data = explode('</span>', $data[1]);
             //$amount = preg_replace('/[^0-9,.]/', '', $data[0]);
           // echo round($amount, 2); 
             //echo $amount. " // ".$data[1];    
             echo trim($data[0]);  */
		die;

   }
     
	public function actionLogin()
	{
		$model = new SignupForm();
		$email = $_POST['email'];
		$password = base64_encode($_POST['password']);
		
		$userdata = User::find()->where(['email'=>$email,'password'=>$password])->one();
		$model->email = $email;
		$model->password = $password;
		if(!empty($userdata))
		{
			if($userdata->userstatus=="0")
			{
				echo '{"status":"error","message":"Your account is blocked, please contact Admin to unblock"}';
				die;				
			} else if($userdata->userstatus=="2") {
				echo '{"status":"error","message":"Moderator cannot use this login"}'; 
				die;				
			} else if($userdata->id =="1") { 
				echo '{"status":"error","message":"Email not found"}';    
				die;				
			} else {
				if ($model->login()) {
					$username = base64_encode($userdata->id."-".rand(0,999));

					if(empty($userdata->currency_mobile) || $userdata->currency_mobile = 0) {
						$defaultcurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one();
						$firstcurrency = Currency::find()->where(['defaultcurrency'=>'0'])->one();
						$userdata->currency_mobile = (count($defaultcurrency) > 0) ? $defaultcurrency->id : $firstcurrency->id; 
						$userdata->save();   
					}
					$resultarray = array();
					$resultarray['user_id'] = $userdata->id;
					$resultarray['first_name'] = $userdata->firstname;
					$resultarray['last_name'] = $userdata->lastname;
					$userimage = $userdata->profile_image;
					if($userimage=="")
					$userimage="usrimg.jpg";
					$userimageurl = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$userimage);
					$resultarray['user_image'] = $userimageurl;
					$resultarray['email'] = $userdata->email;
					$resultarray['date_of_birth'] = $userdata->birthday;
					$resultarray['password'] = base64_decode($userdata->password);
					$resultarray['referal_url'] = Yii::$app->urlManager->createAbsoluteUrl("/signup?referrer=".$username);
					$resultarray['message'] = "Successfully Login";
					$result = json_encode($resultarray);
					echo '{"status":"true","result":'.$result.'}';
				}
			}
		}
		else
		{
			echo '{"status":"false","message":"Please enter correct email and password"}';
		}
	}
	
	public function actionSociallogin()
	{
		$model = new SignupForm ();
		if(isset($_POST['image_url']) && $_POST['image_url']!="")
		{
		$image_url = $_POST['image_url'];
		$filenames = pathinfo($image_url);
		}
		//$filename = $filenames['filename'];
		//$extension = $filenames['extension'];
		$filename = time().rand(0, 9);
		$extension = "jpg";
		if(isset($_POST['email']))
		{
			$email = $_POST['email'];
			$userdata = User::find()->where(['email'=>$email])->one();
			if(!empty($userdata))
			{
				if($userdata->userstatus=="0")
				{
					echo '{"status":"error","message":"Your account is blocked, please contact Admin to unblock"}';
					die;				
				}
			}
		}

		if(isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['type']) && isset($_POST['id']))
		{
			$email = $_POST['email'];
			$userdata = $model->findByEmail ( $email );
			if(empty($userdata))
			{
				$user = new User();
				$user->email = $_POST['email'];
				$user->firstname = $_POST['first_name'];
				$user->lastname = $_POST['last_name'];
				$user->userstatus = "1";
				$user->user_level = "normal";
				$user->hoststatus = "2";				
				if($_POST['type']=='facebook')
				{
					$user->facebookid = $_POST['id'];
				}
				else if($_POST['type']=='google')
				{
					$user->googleid = $_POST['id'];
				}
				$user->save();
				if(isset($_POST['image_url']) && $_POST['image_url']!="")
				{
					$newname = $user->id.'_'.$filename.'.'.$extension;
					$path = realpath ( Yii::$app->basePath . "/web/albums/images/users/" ) . "/";
					$contents=file_get_contents($_POST['image_url']);
					if($contents==false)
					{
						$ch = curl_init($image_url);
						$fp = fopen($path.$newname, 'wb');
						curl_setopt($ch, CURLOPT_FILE, $fp);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_exec($ch);
						curl_close($ch);
						fclose($fp);						
					}
					else
					{
						file_put_contents($path.$newname,$contents);
					}				
					$user->id = $user->id;
					$user->profile_image = $newname;
					$user->save();
					$path = realpath ( Yii::$app->basePath . "/web/albums/images/users/" ) . "/";
					//move_uploaded_file( $image_url, $path .$newname);
				}
				$resultarray = array();
				$resultarray['user_id'] = $user->id;
				$resultarray['first_name'] = $user->firstname;
				$resultarray['last_name'] = $user->lastname;
				$userimage = $user->profile_image;
				if($userimage=="")
				$userimage="usrimg.jpg";
				$userimageurl = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$userimage);
				$resultarray['user_image'] = $userimageurl;
				$resultarray['email'] = $user->email;
				$resultarray['date_of_birth'] = $user->birthday;
				$resultarray['password'] = base64_decode($user->password);
				$username = base64_encode($user->id."-".rand(0,999));
				$referalurl = Yii::$app->urlManager->createAbsoluteUrl("/signup?referrer=".$username);
				$resultarray['referal_url'] = $referalurl;
				$resultarray['message'] = "Successfully Login";
				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';
				$email = $user->email;
			$link = Yii::$app->urlManager->createAbsoluteUrl ( '/verify/' . base64_encode ( $email ) );
			// redirect to form signup, variabel global set to successUrl
			// $this->successUrl = \yii\helpers\Url::to(['signup']);
			
			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
			$siteName = $sitesetting->sitename;
			if($sitesetting->welcomeemail=="yes")
			{
				Yii::$app->mailer->compose ( 'welcome', [
						'name' => $user->firstname,
						'link' => $link,
						'siteName' => $siteName,
						'sitesetting' => $sitesetting,						
						] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Welcome mail' )->send ();
			}
			Yii::$app->mailer->compose ( 'verifyemail', [
					'name' => $user->firstname,
					'link' => $link,
					'siteName' => $siteName,
					'sitesetting' => $sitesetting,					
					] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Verify Email' )->send ();						
				
				
			}
			else
			{
				$user = $model->findByEmail ( $email );
				/*if(isset($_POST['image_url']))
				{
					$newname = $user->id.'_'.$filename.'.'.$extension;
					$path = realpath ( Yii::$app->basePath . "/web/albums/images/users/" ) . "/";
					$contents=file_get_contents($_POST['image_url']);
					if($contents==false)
					{
						$ch = curl_init($image_url);
						$fp = fopen($path.$newname, 'wb');
						curl_setopt($ch, CURLOPT_FILE, $fp);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_exec($ch);
						curl_close($ch);
						fclose($fp);						
					}
					else
					{
						file_put_contents($path.$newname,$contents);
					}
				
					$user->id = $user->id;
					$user->profile_image = $newname;
					$user->save();
					$path = realpath ( Yii::$app->basePath . "/web/albums/images/users/" ) . "/";
					//move_uploaded_file( $image_url, $path .$newname);
				}*/
				$resultarray = array();
				$resultarray['user_id'] = $user->id;
				$resultarray['first_name'] = $user->firstname;
				$resultarray['last_name'] = $user->lastname;
				$userimage = $user->profile_image;
				if($userimage=="")
				$userimage="usrimg.jpg";
				$userimageurl = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$userimage);
				$resultarray['user_image'] = $userimageurl;
				$resultarray['email'] = $user->email;
				$resultarray['date_of_birth'] = $user->birthday;
				$resultarray['password'] = base64_decode($user->password);
				$username = base64_encode($user->id."-".rand(0,999));
				$referalurl = Yii::$app->urlManager->createAbsoluteUrl("/signup?referrer=".$username);
				$resultarray['referal_url'] = $referalurl;
				$resultarray['message'] = "Successfully Login";
				$result = json_encode($resultarray);				
				//echo '{"status":"false","message":"Email already exists"}';
				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';
			}
		}
		else
		{
			echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
		}
	}
	
	public function actionForgotpassword()
	{
		
		$model = new SignupForm ();
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		$models = new PasswordResetRequestForm ( [ 
				'scenario' => 'passwordrequest' 
		] );
		if (isset($_POST['email'])) {
			$email = $_POST['email'];
			$createdDate = time ();
			$userdata = $model->findByEmail ( $email );
			if(!empty($userdata) && $userdata->userstatus =="1")
			{
				$userid = $userdata->id;
				$userdata->id = $userid;
				$userdata->verify_pass = '0';
				$userdata->verify_passcode = $createdDate;
				$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
				$siteName = $sitesetting->sitename;
				$userdata->save ();
				
				$randomValue = rand ( 10000, 100000 );
				$resetPasswordData = base64_encode ( $userid . "-" . $createdDate . "-" . $randomValue );
				$link = Yii::$app->urlManager->createAbsoluteUrl ( '/resetpassword?resetLink=' . $resetPasswordData );
				Yii::$app->mailer->compose ( 'forgotpassword', [ 
						'name' => $models->firstname,
						'link' => $link,
						'siteName' => $siteName
				] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Password reset mail' )->send ();
					echo '{"status":"true","message":"Your password details has been mailed to you."}';
			} else if(!empty($userdata) && $userdata->userstatus =="2") {
				echo '{"status":"false","message":"Moderator access denied"}'; 
			} else {
				echo '{"status":"false","message":"Enter valid email"}';
			}
		}		
	}
	
	public function actionHome() 
	{

		if(!isset($_POST['user_id']))
		{
			echo '{"status":"false","message":"Need user id"}';
		}

		$models = new SignupForm();

		$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 4;

 		$getUsercurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one();
 		$user_currency_id = $getUsercurrency->id;
 		$user_currency_code = $getUsercurrency->currencycode;
 		$user_currency_sym = $getUsercurrency->currencysymbol;
		

		$bannersettings = Homepagesettings::find()->where(['id'=>1])->one();
		$resultarray = array();
		$resultarray2 = array();

		if(isset($bannersettings->bannerforapp)){
			$bannerimg = $bannersettings->bannerforapp;
		}else{
			$bannerimg = $bannersettings->banner;
		}

		if($bannerimg=="")
			$bannerimage = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/users/usrimg.jpg');
		else
			$bannerimage = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/homepage/'.$bannerimg);

		$bannername = $bannersettings->bannertitle;
		$bannerdesc = $bannersettings->bannerdesc;
		$resultarray['banner'][0]['banner_image'] = $bannerimage;
		$resultarray['banner'][0]['banner_name'] = $bannername;
		$resultarray['banner'][0]['banner_des'] = $bannerdesc;
			
		$query = new \yii\db\Query;
		$query->select(['hts_homecountries.*'])->from('hts_homecountries')
			->leftJoin('hts_country', 'hts_country.id = hts_homecountries.countryid')
			->where(['>', 'hts_homecountries.countryid', '0'])
			->orderBy('hts_homecountries.id desc');
		$command = $query->createCommand();
		$homecountries = $command->queryAll();  


		foreach($homecountries as $key => $homecountry) {
			$countrydata = Homecountries::findcountry(trim($homecountry['countryid']));  
			if(trim($homecountry['imagename'])=="")
				$imagename = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/usrimg.jpg');
			else
				$imagename = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/country/'.trim($homecountry['imagename']));  

		 	$resultarray['popular_destination'][$key]['country_id'] = $countrydata->id;
			$resultarray['popular_destination'][$key]['country_name'] = $countrydata->countryname;
			$resultarray['popular_destination'][$key]['image'] = $imagename;
		}

		if(isset($_POST['user_id']))
		{
			$userid = $_POST['user_id'];
			$userdata = User::find()->where(['id'=>$userid])->one();
			if(count($userdata) > 0 && $userdata->currency_mobile != 0) {
				$user_currency_id = $userdata->currency_mobile;
				$getUsercurrency = Currency::find()->where(['id'=>$user_currency_id])->one();
				$user_currency_code = $getUsercurrency->currencycode;
				$user_currency_sym = $getUsercurrency->currencysymbol;
			}

			$resultarray['host_block'] = ($userdata->hoststatus == "0")?"true":"false"; 

			if($userdata->searchkeys != ""){
				$searchkeys = $userdata->searchkeys;
				$search_keys = json_decode($searchkeys, true);
				foreach($search_keys as $keys => $search){
					$resultarray['recent_search'][0][$keys] = $search;
				}
			}

			if($userdata->listids != "") {
				$list_ids = array_values(array_slice(json_decode($userdata->listids, true), 0, 4, true));
				 
				$keyval = 0;
				foreach($list_ids as $key=>$list_id)
				{
					$type = 'recent_view';
					$recent = Listing::find()->where(['liststatus'=>1,'id'=>$list_id])->one();
					$models = new SignupForm();

					if(count($recent) > 0)
					{
						$listid = $recent->id;
						$hostdata = $models->findIdentity ( $recent->userid );
						$currency = $recent->getCurrency0()->where(['id'=>$recent->currency])->one();
						$hometype = $recent->getHometype0()->where(['id'=>$recent->hometype])->one();
						$roomtype = $recent->getRoomtype0()->where(['id'=>$recent->roomtype])->one();

						$photos = Photos::find()->where(['listid'=>$listid])->all();
						$getaverageRating = $this->getaveragerating($listid, 'list'); 

						$resultarray2[$type][$keyval]['list_id'] = $recent->id;
						$resultarray2[$type][$keyval]['list_name'] = $recent->listingname;
						$resultarray2[$type][$keyval]['description'] = $recent->description;
						$resultarray2[$type][$keyval]['duration_type'] = $recent->booking;

						$resultarray2[$type][$keyval]['total_reviews'] = $getaverageRating['totalreview'];
						$resultarray2[$type][$keyval]['average_rating'] = $getaverageRating['average_rating'];
						
						if ($recent->booking == 'perhour') {
							$price = ($recent->hourlyprice=="" || $recent->hourlyprice==null || $recent->hourlyprice==0) ? 0 : $recent->hourlyprice;
						} else {
							$price = ($recent->nightlyprice =="" || $recent->nightlyprice == null || $recent->nightlyprice==0) ? 0 : $recent->nightlyprice;
						}

						$userCurrencyrate = Myclass::getcurrencyprice($user_currency_code);
						$listCurrencyrate = Myclass::getcurrencyprice($currency->currencycode);

						$resultarray2[$type][$keyval]['price'] = round(($userCurrencyrate * ($price/$listCurrencyrate)),2);
						$resultarray2[$type][$keyval]['currency'] = $user_currency_sym;
						
						if(!empty($currency))
							$resultarray2[$type][$keyval]['list_currency'] = $currency->currencysymbol;

						foreach($photos as $keyphoto => $photo)
						{
							$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photo->image_name);

							$resultarray2[$type][$keyval]['list_photos'][$keyphoto]['image_url'] = $image_url;
							
						}
						if(isset($_POST['user_id']))
						{
							$userid = $_POST['user_id'];
							$wishlists = Wishlists::find()->where(['userid'=>$userid,'listingid'=>$listid])->all();
							if(!empty($wishlists))
								$resultarray2[$type][$keyval]['liked'] = 'yes';
							else
								$resultarray2[$type][$keyval]['liked'] = 'no';
						}
						else
							$resultarray2[$type][$keyval]['liked'] = 'no';

						$resultarray2[$type][$keyval]['host_id'] = $hostdata->id;
						$resultarray2[$type][$keyval]['host_name'] = $hostdata->firstname;
						$hostprofileimage = $hostdata->profile_image;

						if($hostprofileimage=="")
							$hostprofileimage = "usrimg.jpg";

						$hostimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$hostprofileimage);

						$resultarray2[$type][$keyval]['host_image'] = $hostimage;
						$resultarray2[$type][$keyval]['property_type'] = (isset($hometype->hometype)) ? $hometype->hometype : '';
						$resultarray2[$type][$keyval]['room_type'] = $roomtype->roomtype;
						$resultarray2[$type][$keyval]['accommodates'] = $recent->accommodates;
						$resultarray2[$type][$keyval]['bedrooms'] = $recent->bedrooms;
						$resultarray2[$type][$keyval]['beds'] = $recent->beds;
						$resultarray2[$type][$keyval]['lat'] = $recent->latitude;
						$resultarray2[$type][$keyval]['lon'] = $recent->longitude;
						if(count($recent)>0)
						{
							$keyval++; 
						}	
					}				
				}
			}
		}

		$resultarray3['default_currency'] = $user_currency_sym; 
		$resultarray3['email_verified'] = ($userdata->emailverify == '1') ? 'true' : 'false'; 
		$resultarray3['default_currency_code'] = $user_currency_code; 
		
		$recentadded = Listing::find()->where(['liststatus'=>1])
							->limit($limit)->orderBy('id desc')->all();
		$resultarray1= $this->listarray($recentadded,'recently_added');

		$Listingcount = Listing::find()->where(['liststatus'=>1])->orderBy('id desc')->all();
		$resultarray3['recent_listing_count'] = count($Listingcount);

		$Listingcount = Listing::find()->where(['featuredlist' => '1', 'liststatus'=>'1'])->all();		
		$resultarray3['featured_listing_count'] = count($Listingcount);

		$query = new \yii\db\Query;
		$query->select(['count(hts_reservations.listid) as maxapp', 'hts_reservations.listid as listid', 'hts_listing.*'])->from('hts_reservations')
			->leftJoin('hts_listing', 'hts_listing.id = hts_reservations.listid')
			->where(['>', 'hts_reservations.listid', '0'])
			->andWhere(['=', 'hts_listing.liststatus', '1'])  
			->groupBy('hts_reservations.listid')
			->orderBy('maxapp desc');

		$countQuery = clone $query;
		$resultarray3['popular_listing_count'] = $countQuery->count();

		$command = $query->limit($limit)->createCommand();
		$traverselist = $command->queryAll();  

		$Listingcount =  Reservations::TotalReservationCount();	 
		 
		$featuredlist = Listing::getFeatureListing();

		$popularArray= $this->popularlistarray($traverselist,'popular_listing');
		$featuredArray= $this->popularlistarray($featuredlist,'featured_listing');

		$newresult = array_merge($resultarray,$resultarray1,$resultarray2,$popularArray,$featuredArray,$resultarray3);
		
		$result = json_encode($newresult);
		echo '{"status":"true","result":'.$result.'}'; 
	}

	public function getaveragerating($id, $type)
	{	

		$listdata = Listing::find()->where(['id'=>$id])->one();
		if($type = 'list') {
			$getReviews = $listdata->getReviews0()->where(['listid'=>$id])->all();
		} else {
			$getReviews = $listdata->getReviews0()->where(['userid'=>$id])->all();
		}
			
		$sum = 0;
		foreach($getReviews as $review)
		{
			$sum+=$review->rating; 
		}

		if($sum != 0 && count($getReviews) != 0)
		{
			$getaverageRating = $sum/count($getReviews);
		}else{
			$getaverageRating = 0;
		}

			$result = array('totalreview'=>count($getReviews), 'average_rating'=>$getaverageRating);
			return $result;
	}

	public function popularlistarray($traverselist,$type)
	{
		$popularArray=array(); 
 		$userid = 0;
 		$getUsercurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one();
 		$user_currency_id = $getUsercurrency->id;
 		$user_currency_code = $getUsercurrency->currencycode;
 		$user_currency_sym = $getUsercurrency->currencysymbol;

		if(isset($_POST['user_id'])) {
			$userid = trim($_POST['user_id']);
		}

		if($userid > 0 && !empty($userid)) {
			$userdata = User::find()->where(['id'=>$userid])->one();
			if(count($userdata) > 0 && $userdata->currency_mobile != 0) {
				$user_currency_id = $userdata->currency_mobile;
				$getUsercurrency = Currency::find()->where(['id'=>$user_currency_id])->one();
				$user_currency_code = $getUsercurrency->currencycode;
				$user_currency_sym = $getUsercurrency->currencysymbol;
			}
		}

		foreach($traverselist as $keys => $traverse) {			
			$models = new SignupForm();
			$keyval=$keys;
			if($type == "popular_listing")
				$listid = $traverse['listid'];
			else
				$listid = $traverse['id'];
			$listdata = Listing::find()->where(['id'=>$listid])->one();

			if(count($listdata) > 0) {
				$hostid = $traverse['userid'];
				$hostdata = $models->findIdentity ($hostid);
				$currency = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();
				$hometype = $listdata->getHometype0()->where(['id'=>$listdata->hometype])->one();
				$roomtype = $listdata->getRoomtype0()->where(['id'=>$listdata->roomtype])->one();
				$photos = Photos::find()->where(['listid'=>$listid])->all(); 
				$getaverageRating = $this->getaveragerating($listid, 'list'); 

				if($type == "popular_listing")
					$popularArray[$type][$keyval]['list_id'] = $traverse['listid'];
				else
					$popularArray[$type][$keyval]['list_id'] = $traverse['id'];

				$popularArray[$type][$keyval]['list_name'] = $traverse['listingname'];
				$popularArray[$type][$keyval]['description'] = $traverse['description'];
				$popularArray[$type][$keyval]['duration_type'] = $traverse['booking'];
				$popularArray[$type][$keyval]['total_reviews'] = $getaverageRating['totalreview'];
				$popularArray[$type][$keyval]['average_rating'] = $getaverageRating['average_rating'];
				
				if ($traverse['booking']=='perhour') {
					if($traverse['hourlyprice']=="" || $traverse['hourlyprice']==null ||$traverse['hourlyprice']==0)
						$price = 0;
					else
						$price = $traverse['hourlyprice'];
				} else {
					if($traverse['nightlyprice']=="" || $traverse['nightlyprice']==null ||$traverse['nightlyprice']==0)
						$price = 0;
					else 
						$price = $traverse['nightlyprice'];
				}

				$userCurrencyrate = Myclass::getcurrencyprice($user_currency_code);
				$listCurrencyrate = Myclass::getcurrencyprice($currency->currencycode);

				$popularArray[$type][$keyval]['price'] = round(($userCurrencyrate * ($price/$listCurrencyrate)),2);
				$popularArray[$type][$keyval]['currency'] = $user_currency_sym;
				
				
				if(!empty($currency))
					$popularArray[$type][$keyval]['list_currency'] = $currency->currencysymbol; 

				foreach($photos as $keyphoto => $photo)
				{
					$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photo->image_name);
					
					$popularArray[$type][$keyval]['list_photos'][$keyphoto]['image_url'] = $image_url;
				} 
				if(isset($_POST['user_id']))
				{
					$userid = $_POST['user_id'];
					$wishlists = Wishlists::find()->where(['userid'=>$userid,'listingid'=>$listid])->all();
					if(!empty($wishlists))
						$popularArray[$type][$keyval]['liked'] = 'yes';
					else
						$popularArray[$type][$keyval]['liked'] = 'no';
				}
				else
					$popularArray[$type][$keyval]['liked'] = 'no';

				$popularArray[$type][$keyval]['host_id'] = $hostdata->id;
				$popularArray[$type][$keyval]['host_name'] = $hostdata->firstname;
				$hostprofileimage = $hostdata->profile_image;

				if($hostprofileimage=="")
				$hostprofileimage = "usrimg.jpg";
				$hostimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$hostprofileimage);
				$popularArray[$type][$keyval]['host_image'] = $hostimage;
				$popularArray[$type][$keyval]['property_type'] = (isset($hometype->hometype)) ? $hometype->hometype : '';
				$popularArray[$type][$keyval]['room_type'] = $roomtype->roomtype; /**/
				$popularArray[$type][$keyval]['accommodates'] = $traverse['accommodates'];
				$popularArray[$type][$keyval]['bedrooms'] = $traverse['bedrooms'];
				$popularArray[$type][$keyval]['beds'] = $traverse['beds'];
				$popularArray[$type][$keyval]['lat'] = $traverse['latitude'];
				$popularArray[$type][$keyval]['lon'] = $traverse['longitude'];
			}
		
		}
		return $popularArray;

	}
	
	public function listarray($listarray,$type)
	{
		$models = new SignupForm();
		$userid = 0;
 		$getUsercurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one();
 		$user_currency_id = $getUsercurrency->id;
 		$user_currency_code = $getUsercurrency->currencycode;
 		$user_currency_sym = $getUsercurrency->currencysymbol;

		if(isset($_POST['user_id'])) {
			$userid = trim($_POST['user_id']);
		}

		if($userid > 0 && !empty($userid)) {
			$userdata = User::find()->where(['id'=>$userid])->one();
			if(count($userdata) > 0 && $userdata->currency_mobile != 0) {
				$user_currency_id = $userdata->currency_mobile;
				$getUsercurrency = Currency::find()->where(['id'=>$user_currency_id])->one();
				$user_currency_code = $getUsercurrency->currencycode;
				$user_currency_sym = $getUsercurrency->currencysymbol;
			}
		}

		foreach($listarray as $key => $recent)
		{
			$listid = $recent->id;
			$hostid = $recent->userid;
			$hostdata = $models->findIdentity ( $hostid );
			$listdata = Listing::find()->where(['id'=>$listid])->one();

			$currency = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();
			$hometype = $listdata->getHometype0()->where(['id'=>$listdata->hometype])->one();
			$roomtype = $listdata->getRoomtype0()->where(['id'=>$listdata->roomtype])->one();

			$getaverageRating = $this->getaveragerating($listid, 'list');

			$photos = Photos::find()->where(['listid'=>$listid])->all();
			$resultarray[$type][$key]['list_id'] = $recent->id;
			$resultarray[$type][$key]['list_name'] = $recent->listingname;
			$resultarray[$type][$key]['description'] = $recent->description;
			$resultarray[$type][$key]['duration_type'] = $recent->booking;
			$resultarray[$type][$key]['total_reviews'] = $getaverageRating['totalreview'];
			$resultarray[$type][$key]['average_rating'] = $getaverageRating['average_rating'];

			if ($recent->booking == 'perhour') {
				if($recent->hourlyprice == "" || $recent->hourlyprice == null || $recent->hourlyprice == 0)
					$price = 0;
				else
					$price = $recent->hourlyprice;
			} else {
				if($recent->nightlyprice == "" || $recent->nightlyprice==null || $recent->nightlyprice==0)
					$price = 0;
				else 
					$price = $recent->nightlyprice;
			}

			$userCurrencyrate = Myclass::getcurrencyprice($user_currency_code);

			$listCurrencyrate = Myclass::getcurrencyprice($currency->currencycode);

			$resultarray[$type][$key]['price'] = round(($userCurrencyrate * ($price/$listCurrencyrate)),2);
			$resultarray[$type][$key]['currency']= $user_currency_sym;
			 
			if(!empty($currency))
				$resultarray[$type][$key]['list_currency'] = $currency->currencysymbol;

			foreach($photos as $keyphoto => $photo)
			{
				$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photo->image_name);
				
				$resultarray[$type][$key]['list_photos'][$keyphoto]['image_url'] = $image_url;		
			}
			if(isset($_POST['user_id']))
			{
				$userid = $_POST['user_id'];
				$wishlists = Wishlists::find()->where(['userid'=>$userid,'listingid'=>$listid])->all();
				if(!empty($wishlists))
				$resultarray[$type][$key]['liked'] = 'yes';
				else
				$resultarray[$type][$key]['liked'] = 'no';
			}
			else
				$resultarray[$type][$key]['liked'] = 'no';
			$resultarray[$type][$key]['host_id'] = $hostdata->id;
			$resultarray[$type][$key]['host_name'] = $hostdata->firstname;
			$hostprofileimage = $hostdata->profile_image;
			if($hostprofileimage=="")
			$hostprofileimage = "usrimg.jpg";
			$hostimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$hostprofileimage);
			$resultarray[$type][$key]['host_image'] = $hostimage;
			$resultarray[$type][$key]['property_type'] = (isset($hometype->hometype)) ? $hometype->hometype : '';
			$resultarray[$type][$key]['room_type'] = $roomtype->roomtype;
			$resultarray[$type][$key]['accommodates'] = $recent->accommodates;
			$resultarray[$type][$key]['bedrooms'] = $recent->bedrooms;
			$resultarray[$type][$key]['beds'] = $recent->beds;
			$resultarray[$type][$key]['lat'] = $recent->latitude;
			$resultarray[$type][$key]['lon'] = $recent->longitude;
		}
		return $resultarray;
	}
	
	public function listarray2($listarrays,$type)
	{
		$models = new SignupForm();
		foreach($listarrays as $listarray)
		{
		foreach($listarray as $key => $recent)
		{
			$listid = $recent->id;
			$hostid = $recent->userid;
			$hostdata = $models->findIdentity ( $hostid );
			$listdata = Listing::find()->where(['id'=>$listid])->one();
			$currency = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();
			$hometype = $listdata->getHometype0()->where(['id'=>$listdata->hometype])->one();
			$roomtype = $listdata->getRoomtype0()->where(['id'=>$listdata->roomtype])->one();
			$photos = Photos::find()->where(['listid'=>$listid])->all();
			$resultarray[$type][$key]['list_id'] = $recent->id;
			$resultarray[$type][$key]['list_name'] = $recent->listingname;
			$resultarray[$type][$key]['description'] = $recent->description;
			$resultarray[$type][$key]['price'] = $recent->nightlyprice;
			if(!empty($currency))
			$resultarray[$type][$key]['currency'] = $currency->currencysymbol;
			foreach($photos as $keyphoto => $photo)
			{
				$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photo->image_name);
				$resultarray[$type][$key]['list_photos'][$keyphoto]['image_url'] = $image_url;	 	
			}
			if(isset($_POST['user_id']))
			{
				$userid = $_POST['user_id'];
				$wishlists = Wishlists::find()->where(['userid'=>$userid,'listingid'=>$listid])->all();
				if(!empty($wishlists))
				$resultarray[$type][$key]['liked'] = 'yes';
				else
				$resultarray[$type][$key]['liked'] = 'no';
			}
			else
				$resultarray[$type][$key]['liked'] = 'no';
			$resultarray[$type][$key]['host_id'] = $hostdata->id;
			$resultarray[$type][$key]['host_name'] = $hostdata->firstname;
			$hostprofileimage = $hostdata->profile_image;
			if($hostprofileimage=="")
			$hostprofileimage = "usrimg.jpg";
			$hostimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$hostprofileimage);
			$resultarray[$type][$key]['host_image'] = $hostimage;
			$resultarray[$type][$key]['property_type'] = (isset($hometype->hometype)) ? $hometype->hometype : '';
			$resultarray[$type][$key]['room_type'] = $roomtype->roomtype;
			$resultarray[$type][$key]['accommodates'] = $recent->accommodates;
			$resultarray[$type][$key]['bedrooms'] = $recent->bedrooms;
			$resultarray[$type][$key]['beds'] = $recent->beds;
			$resultarray[$type][$key]['lat'] = $recent->latitude;
			$resultarray[$type][$key]['lon'] = $recent->longitude;
		}
		return $resultarray;
		}
		
	}	
	
	public function listarray1($listarray)
	{
		$models = new SignupForm();
		$userid = 0;
 		$getUsercurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one();
 		$user_currency_id = $getUsercurrency->id;
 		$user_currency_code = $getUsercurrency->currencycode;
 		$user_currency_sym = $getUsercurrency->currencysymbol;

 		if(isset($_POST['user_id'])) {
			$userid = trim($_POST['user_id']);
		}

		if($userid > 0 && !empty($userid)) {
			$userdata = User::find()->where(['id'=>$userid])->one();
			if(count($userdata) > 0 && $userdata->currency_mobile != 0) {
				$user_currency_id = $userdata->currency_mobile;
				$getUsercurrency = Currency::find()->where(['id'=>$user_currency_id])->one();
				$user_currency_code = $getUsercurrency->currencycode;
				$user_currency_sym = $getUsercurrency->currencysymbol;
			}
		} 
		$resultarray = array(); 
		foreach($listarray as $key => $recent)
		{
			$listid = $recent->id;
			$hostid = $recent->userid;
			$hostdata = $models->findIdentity ( $hostid );
			$listdata = Listing::find()->where(['id'=>$listid, 'liststatus'=>'1'])->one();   
			if(count($listdata) > 0) {
				$currency = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();
				$hometype = $listdata->getHometype0()->where(['id'=>$listdata->hometype])->one();
				$roomtype = $listdata->getRoomtype0()->where(['id'=>$listdata->roomtype])->one();

				$getaverageRating = $this->getaveragerating($listid, 'list');
				$photos = Photos::find()->where(['listid'=>$listid])->all();

				$resultarray[$key]['list_id'] = $recent->id;
				$resultarray[$key]['list_name'] = $recent->listingname;
				$resultarray[$key]['description'] = $recent->description;
				$resultarray[$key]['duration_type'] = $recent->booking;
				$resultarray[$key]['total_reviews'] = $getaverageRating['totalreview'];
				$resultarray[$key]['average_rating'] = $getaverageRating['average_rating'];

				if ($recent->booking == 'perhour') {
					if($recent->hourlyprice == "" || $recent->hourlyprice == null || $recent->hourlyprice == 0)
						$price = 0;
					else
						$price = $recent->hourlyprice;
				} else {
					if($recent->nightlyprice == "" || $recent->nightlyprice==null || $recent->nightlyprice==0)
						$price = 0;
					else 
						$price = $recent->nightlyprice;
				}

				$userCurrencyrate = Myclass::getcurrencyprice($user_currency_code);
				$listCurrencyrate = Myclass::getcurrencyprice($currency->currencycode);
				$resultarray[$key]['price'] = round(($userCurrencyrate * ($price/$listCurrencyrate)),2);
				$resultarray[$key]['currency']= $user_currency_sym;
	 
				if(!empty($currency))
					$resultarray[$key]['list_currency'] = $currency->currencysymbol;
	 
				foreach($photos as $keyphoto => $photo)
				{
					$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photo->image_name);
					
					$resultarray[$key]['list_photos'][$keyphoto]['image_url'] = $image_url;				
				}
				if(isset($_POST['user_id']))
				{
					$userid = $_POST['user_id'];
					$wishlists = Wishlists::find()->where(['userid'=>$userid,'listingid'=>$listid])->all();
					if(!empty($wishlists))
					$resultarray[$key]['liked'] = 'yes';
					else
					$resultarray[$key]['liked'] = 'no';
				}
				else
					$resultarray[$key]['liked'] = 'no';
				$resultarray[$key]['host_id'] = $hostdata->id;
				$resultarray[$key]['host_name'] = $hostdata->firstname;
				$hostprofileimage = $hostdata->profile_image;
				if($hostprofileimage=="")
				$hostprofileimage = "usrimg.jpg";			
				$hostimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$hostprofileimage);
				$resultarray[$key]['host_image'] = $hostimage;
				$resultarray[$key]['property_type'] = (isset($hometype->hometype)) ? $hometype->hometype : '';
				$resultarray[$key]['room_type'] = $roomtype->roomtype;
				$resultarray[$key]['accommodates'] = $recent->accommodates;
				$resultarray[$key]['bedrooms'] = $recent->bedrooms;
				$resultarray[$key]['beds'] = $recent->beds;
				$resultarray[$key]['lat'] = $recent->latitude;
				$resultarray[$key]['lon'] = $recent->longitude;
			} 
		}
		return $resultarray;
	}	

	public function actionSignup()
	{
		$model = new SignupForm ( [ 
				'scenario' => 'register' 
		] );
		$invitemodel = new Userinvites ();

		
		if(isset($_POST ['referrer']))
		{
			$referrer = $_POST ['referrer'];
			$referrer = base64_decode ( $referrer );
			$referrer_id = explode ( "-", $referrer );
			$referrerid = $referrer_id [0];			
			$reff_id['reffid'] = $referrerid;
			$reff_id['first'] = 'first';
			$user->referrer_id = json_encode($reff_id);
		}
		
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		$siteName = $sitesetting->sitename;		


		if (isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['password']) && isset($_POST['date_of_birth'])) {
			$user = new User();
			$user->email = $email = $_POST['email'];
			$user->firstname = $firstname = $_POST['first_name'];
			$user->lastname = $lastname = $_POST['last_name'];
			$user->password = $password = base64_encode($_POST['password']);
			$user->birthday = $birthday = $_POST['date_of_birth'];
			$user->userstatus = "1";
			$user->user_level = "normal";
			$user->hoststatus = "2";

			$defaultcurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one();
			$firstcurrency = Currency::find()->where(['defaultcurrency'=>'0'])->one();
			$user->currency_mobile = (count($defaultcurrency) > 0) ? $defaultcurrency->id : $firstcurrency->id;   
			
			$userdata = $model->findByEmail ( $email );
			if(!empty($userdata))
			{
				echo '{"status":"false","message":"An Account with this email address already exist. Unable to create account."}';
			}
			else if($user->save()){

				$referrermodel = $model->findByEmail ( $email );
				$link = Yii::$app->urlManager->createAbsoluteUrl ( '/verify/' . base64_encode ( $email ) );
				$userreferrer = $referrermodel->referrer_id;
				$userreferrer = ( array ) json_decode ( $userreferrer );
				if(!empty($userreferrer))
				$referid = $userreferrer ['reffid'];
				if (isset ( $referid )) {
					$userinvitemodel = Userinvites::find ()->where ( [ 
							'userid' => $referid,
							'invitedemail' => $email 
					] )->One ();
					$userinvitemodel->id = $userinvitemodel->id;
					$userinvitemodel->status = "Joined";
					$userinvitemodel->save ();
				}
				$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
				$siteName = $sitesetting->sitename;
				if($sitesetting->welcomeemail=="yes")
				{
					Yii::$app->mailer->compose ( 'welcome', [ 
						'name' => $model->firstname,
						'link' => $link,
						'siteName' => $siteName,
						'sitesetting' => $sitesetting,
					] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Welcome mail' )->send ();
				}
				Yii::$app->mailer->compose ( 'verifyemail', [
						'name' => $model->firstname,
						'link' => $link,
						'siteName' => $siteName,
						'sitesetting' => $sitesetting,
						] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Verify Email' )->send ();			
				/*if (Yii::$app->getUser ()->login ( $user )) {
					$session = Yii::$app->session;
					$session->open ();
					$session ['welcomepop'] = "1";
					return $this->redirect ( '/', [ 
							'welcomepop' => '1' 
					] );
				}*/
				echo '{"status":"true","message":"Thank you for registering on '.$siteName.'. We\'ve sent you the activation link on your registered email ID."}';
				die;
			}
			
		}
		else
		{
			echo '{"status":"false","message":"Sorry, Something went wrong"}';
		}
	}
	
	public function actionListdetail() 
	{
		if(isset($_POST['user_id']))
		{
			$userid = $_POST['user_id'];
		}
		if(isset($_POST['list_id']))
		{
			$listid = $_POST['list_id'];

			$getUsercurrency=Currency::find()->where(['defaultcurrency'=>'1'])->one();
			$listdata = Listing::find()->where(['id'=>$listid])->one();

			if(isset($_POST['user_id']))
			{
				$userid = $_POST['user_id'];
				$userdata = User::find()->where(['id'=>$userid])->one();

				if($userdata->currency_mobile != "" && $userdata->currency_mobile > 0)
					$getUsercurrency = Currency::find()->where(['id'=>$userdata->currency_mobile])->one();
				else
					$getUsercurrency=Currency::find()->where(['defaultcurrency'=>'1'])->one(); 	

				if($userid != $listdata->userid && $userid > 0) {  
					if($userdata->listids=="")
					{
						$listidss = array($listid);
						$listids = json_encode($listidss);
						$userdata->id = $userdata->id;
						$userdata->listids = $listids;
						$userdata->save();					
					}else{
						$listidss1 = array($listid);
						$listidss = $userdata->listids;
						$listids = json_decode($listidss, true);
						$listcount = sizeof($listids); 
						
						if($listcount >= 10){
						array_unshift($listids,$listid);
						array_pop($listids);
						$arrlistids = array_map('trim', array_merge($listidss1,$listids));
						$uniqlistids = array_values(array_unique($arrlistids)); 
						$listids2 = json_encode($uniqlistids);
						}else{
						$arrlistids = array_map('trim', array_merge($listidss1,$listids)); 
						$uniqlistids = array_values(array_unique($arrlistids)); //print_r($uniqlistids);exit;
						$listids2 = json_encode($uniqlistids);
						}
						//print_r($listids2);
						$userdata->id = $userdata->id;
						$userdata->listids = $listids2;
						$userdata->save();
					}
				}
			}
			
			
			$getlatestreview = $listdata->getReviews0()->where(['listid'=>$listid])->orderBy('id desc')->all();  
			$getcancellationData = $listdata->getCancellation0()->one();

			if($listdata->liststatus=="2") 
			{
				echo '{"status":"false","block":"yes","message":"Sorry, Something went to be wrong"}';
				die; 
			} else {
				$models = new SignupForm();
				$listid = $listdata->id;
				$hostid = $listdata->userid;
				$hostdata = $models->findIdentity ( $hostid );
				$listdata = Listing::find()->where(['id'=>$listid])->one();
				$currency = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();
				$hometype = $listdata->getHometype0()->where(['id'=>$listdata->hometype])->one();
				$roomtype = $listdata->getRoomtype0()->where(['id'=>$listdata->roomtype])->one();
				$photos = Photos::find()->where(['listid'=>$listid])->all();
				$resultarray['list_id'] = $listdata->id;
				$resultarray['list_name'] = $listdata->listingname;
				$resultarray['description'] = $listdata->description;

				if(isset($listdata->startdate) && isset($listdata->enddate))
				{
					$resultarray['start_date'] = $listdata->startdate;
					$resultarray['end_date'] = $listdata->enddate;
				}

				$resultarray['currency'] = $getUsercurrency->currencysymbol;
				$resultarray['currency_code'] = $getUsercurrency->currencycode;

				if(isset($getcancellationData) && !empty($getcancellationData))
				{
					$resultarray['cancellation_id'] = $getcancellationData->id; 
					$resultarray['cancellation_type'] = $getcancellationData->policyname;
					$resultarray['cancellation_policy'] = $getcancellationData->canceldesc;
				}
 
				if(!empty($currency))
				{
					$resultarray['list_currency'] = $currency->currencysymbol;
					$resultarray['list_currency_code'] = $currency->currencycode;
				}

				$resultarray['duration_type'] = $listdata->booking;

				if($listdata->booking == 'pernight' || $listdata->booking == 'perday') {
					if($listdata->nightlyprice=="" || $listdata->nightlyprice==null || $listdata->nightlyprice==0) {
							$resultarray['price'] = "";
					} else {
						 $resultarray['price'] = $listdata->nightlyprice;
					}
				} elseif($listdata->booking == 'perhour') {
					if( $listdata->hourlyprice=="" || $listdata->hourlyprice==null || $listdata->hourlyprice==0 ) {
							$resultarray['price'] = "";
					} else {
						 $resultarray['price'] = $listdata->hourlyprice;
					}
				}

				//echo '<pre>'; print_r($listdata); exit;
				if($resultarray['price'] != "") {  
					$convertionprice = $this->currencyConvertion($userid, $listid, $resultarray['price']);
					$resultarray['price'] = $convertionprice;
				}

				$hourlyavailabilityTime = explode(',', $listdata->hourly_availablity);
				$nightavailabilityTime = explode('*|*', $listdata->pernight_availablity);

				if(isset($nightavailabilityTime[0]) && $nightavailabilityTime[0] != '')
				{
					$startNighthours = trim($nightavailabilityTime[0]).":00";
					$startNighthours = date("g:i A", strtotime($startNighthours)); 
					$endNighthours = trim($nightavailabilityTime[1]).":00"; 
					$endNighthours = date("g:i A", strtotime($endNighthours));   
				}else{
					$startNighthours = '';
					$endNighthours = '';
				}
				
				if($startNighthours != '' && $endNighthours != '')
				{
					$resultarray['night_availabletime'] = $startNighthours.'-'.$endNighthours; 
				}else{
					$resultarray['night_availabletime'] = "";
				}

				if(count($hourlyavailabilityTime) > 0) {
					foreach ($hourlyavailabilityTime as $key => $hat) {
						if(trim($hat) != "") { 
							$hat=explode('*|*',$hat);
							$starthours = date("g:i A", strtotime(trim($hat[0]).":00"));
							$endhours = date("g:i A", strtotime(trim($hat[1]).":00")); 
							$resultarray['hours_availabletime'][$key]['time'] = $starthours.'-'.$endhours; 
						}
					}
				} else {
					$resultarray['hours_availabletime'] = "";
				}

				$listurl = base64_encode($listdata->id.'_'.rand(1,9999));
				$listingurl = Yii::$app->urlManager->createAbsoluteUrl("/user/listing/view/".$listurl);
				if($listdata->bookingstyle == "instant"){
				$resultarray['instant_book'] = "true";
				}else{
				$resultarray['instant_book'] = "false";
				}
			
				$resultarray['product_url'] = $listingurl;
				foreach($photos as $keyphoto => $photo)
				{
					$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photo->image_name);
					
					$resultarray['list_photos'][$keyphoto]['image_url'] = $image_url;				
				}
				if(isset($_POST['user_id']))
				{
					$userid = $_POST['user_id'];
					$wishlists = Wishlists::find()->where(['userid'=>$userid,'listingid'=>$listid])->all();
					if(!empty($wishlists))
					$resultarray['liked'] = 'yes';
					else
					$resultarray['liked'] = 'no';

					$reportdata = Userreports::find()->where(['userid'=>$userid,'listid'=>$listid,'report_type'=>'list'])->one();   
					if(count($reportdata)==0)
					{
						$resultarray['report'] = 'true';
						$resultarray['report_id'] = ''; 
					}
					else if(count($reportdata)>0)
					{
						$resultarray['report'] = 'false';
						$resultarray['report_id'] = $reportdata->reportid; 
					}
				}
				else
					$resultarray['liked'] = 'no';
				$resultarray['host_id'] = $hostdata->id;
				$resultarray['host_name'] = $hostdata->firstname;
				$hostprofileimage = $hostdata->profile_image;
				if($hostprofileimage=="")
				$hostprofileimage = "usrimg.jpg";
				$hostimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$hostprofileimage);
				$resultarray['host_image'] = $hostimage;
				$resultarray['property_type'] = (isset($hometype->hometype)) ? $hometype->hometype : '';
				$resultarray['room_type'] = $roomtype->roomtype;
				$resultarray['accommodates'] = $listdata->accommodates;
				$resultarray['bedrooms'] = $listdata->bedrooms;
				$resultarray['beds'] = $listdata->beds;
				$resultarray['bathrooms'] = $listdata->bathrooms;
				$countrydata = Country::find()->where(['id'=>$listdata->country])->one();
				$resultarray['address'] = $listdata->streetaddress.','.$listdata->city.','.$listdata->state.','.$countrydata->countryname;
				$resultarray['lat'] = $listdata->latitude;
				$resultarray['lon'] = $listdata->longitude;
				$resultarray['video_url'] = $listdata->youtubeurl;
				$resultarray['cleaningfees'] = $listdata->cleaningfees;
				$resultarray['servicefees'] = $listdata->servicefees;
				$resultarray['security_deposit'] = $listdata->securitydeposit;
				$resultarray['weekend_fee_status'] = $listdata->weekendprice;

				if($listdata->weekendprice == 1) {
					$weekendData = Weekendprice::find()->where(['listid'=>$listid])->one();
					if(count($weekendData) > 0){
						$resultarray['weekend_fee'] = $weekendData->weekend_price;
					} else {
						$resultarray['weekend_fee'] = 0;
					}
				}	

				if(isset($listdata->houserules) && $listdata->houserules!="")
				{
					$resultarray['home_rules'] = $listdata->houserules;
				}			
				 
				$resultarray['minimum_stay'] = $listdata->minstay;
				$resultarray['maximum_stay'] = $listdata->maxstay;
				$created = $hostdata->created_at;
				$month = date('F',$created);
				$year = date('Y',$created);
				$resultarray['member_from'] = $month." ".$year;
				$shipping = Shippingaddress::find ()->where ( [ 
						'userid' => $hostdata->id 
				] )->One ();
				if(!empty($shipping))
				{
					$country = Country::find()->where(['id'=>$shipping->country])->one();
					$resultarray['host_address'] = $shipping->address1;
					$resultarray['host_city'] = $shipping->city;
					$resultarray['host_state'] = $shipping->state;
					//$resultarray['host_country'] = $country->countryname;
				}
				else 
				{
					$resultarray['host_address'] = "";
					$resultarray['host_city'] = "";
					$resultarray['host_state'] = "";
					$resultarray['host_country'] = "";
				}
				if(isset($hosthdata->about) && $hostdata->about!="")
				$resultarray['host_description'] = $hostdata->about;
				else
				$resultarray['host_description'] = "";
				if($listdata->bookingavailability=="always")
				$resultarray['availability'] = "all";
				else if($listdata->bookingavailability=="onetime")
				{
					$resultarray['availability'][0]['startdate'] = $listdata->startdate;
					$resultarray['availability'][0]['enddate'] = $listdata->enddate;
				}
				
				if($listdata->booking=='perhour')
				{
					$todaydate = date('m/d/Y');
    				$today = strtotime($todaydate);
					$connection = Yii::$app->getDb();
					
					$reservations = $connection->createCommand ( "SELECT t.fromdate, t.todate, GROUP_CONCAT(hourly_booked ORDER BY LENGTH(`hourly_booked`), `hourly_booked` SEPARATOR ',') AS hourly_booked FROM (SELECT *  FROM `hts_reservations` WHERE `listid` = '".$listid."' AND `todate` >= $today AND `bookstatus` NOT IN ('cancelled','declined','refunded')) AS t GROUP BY t.todate"); 

					$hourreservations = $reservations->queryAll(); 

					if(!empty($hourreservations))
					{
						//echo count($hourreservations); 
						//exit;
						for($h=0;$h<count($hourreservations);$h++)
						{
							$resultarray['booked_dates'][$h]['startdate'] = $hourreservations[$h]['fromdate'];
							$resultarray['booked_dates'][$h]['enddate'] = $hourreservations[$h]['todate'];
							$book_time = array_filter(explode(',',$hourreservations[$h]['hourly_booked']));

							$listdata_hourly_availablity = array_filter(explode(',',$listdata->hourly_availablity));

							$book_time = array_values(array_diff($listdata_hourly_availablity,$book_time)); 
			 											  
							if(count($book_time) > 0) {  		
								foreach ($book_time as $key => $hat) {
									if(trim($hat)!="") { 
										$hat=explode('*|*',$hat);
										$starthours = date("g:i A", strtotime(trim($hat[0]).":00"));
										$endhours = date("g:i A", strtotime(trim($hat[1]).":00"));
										$resultarray['booked_dates'][$h]['hours_availabletime'][$key]['time'] = $starthours.'-'.$endhours;
									}
								}
							}
						}
					}
				}

				if($listdata->booking=='pernight')
				{
					$reservations = Reservations::find()->where(['listid'=>$listid])
												->andWhere(['!=','bookstatus','cancelled'])
												->andWhere(['!=','bookstatus','declined'])
												->andWhere(['!=','bookstatus','refunded'])
												->all();
					if(!empty($reservations))
					{
						foreach($reservations as $key => $reservation)
						{
							$resultarray['booked_dates'][$key]['startdate'] = $reservation->fromdate;
							$resultarray['booked_dates'][$key]['enddate'] = $reservation->todate;
						}
					}

				}
				
				$commondata = Commonlisting::find()->where(['listingid'=>$listid])->all();
				$additionaldata = Additionallisting::find()->where(['listingid'=>$listid])->all();
				$specialdata = Speciallisting::find()->where(['listingid'=>$listid])->all();
				$safetydata = Safetylisting::find()->where(['listingid'=>$listid])->all();
				$commonamenities = array();
				$commonamenitiesid = array();
				$key = 0;
				foreach($commondata as $common)
				{    	
					$commonamenity = $common->getAmenity()->where(['id'=>$common->amenityid])->one();
					$commonamenities[$key]['name'] = $commonamenity->name;
					$commonamenities[$key]['cimage'] = $commonamenity->commonimage;
					$commonamenitiesid[] = $commonamenity->id;
					$key++;
				}
				
				$additionalamenities = array();
				$additionalamenitiesid = array();
				$addkey = 0;
				foreach($additionaldata as $additional)
				{
					$additionalamenity = $additional->getAmenity()->where(['id'=>$additional->amenityid])->one();
					$additionalamenities[$addkey]['name'] = $additionalamenity->name;
					$additionalamenities[$addkey]['cimage'] = $additionalamenity->additionalimage;
					$additionalamenitiesid[] = $additionalamenity->id;
					$addkey++;
				}
				$specialfeatures = array();
				$specialfeaturesid = array();
				$specialkey=0;
				foreach($specialdata as $special)
				{
					$specialfeature = $special->getSpecial()->where(['id'=>$special->specialid])->one();
					$specialfeatures[$specialkey]['name'] = $specialfeature->name;
					$specialfeatures[$specialkey]['cimage'] = $specialfeature->specialimage;
					$specialfeaturesid[] = $specialfeature->id;
					$specialkey++;
				}
				$safetychecklist = array();
				foreach($safetydata as $safety)
				{
					$safetycheck = $safety->getSafety()->where(['id'=>$safety->safetyid])->one();
					$safetychecklist[$safetycheck->id] = $safetycheck->name;
					 
				}			
				
				$array = array_merge($commonamenities,$additionalamenities,$specialfeatures);
				$arrayid = array_merge($commonamenitiesid,$additionalamenitiesid,$specialfeaturesid);
				
				
				foreach($array as $key => $amenity)
				{
					$resultarray['amenities'][$key]['type_id'] = $arrayid[$key];
					$resultarray['amenities'][$key]['type_name'] = $amenity['name'];
					$resultarray['amenities'][$key]['amenities_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/common/'.$amenity['cimage']);
				}
				$skey = 0;
				foreach($safetychecklist as $safetykey => $safetyval)
				{
					$resultarray['safety_features'][$skey]['type_id'] = $safetykey;
					$resultarray['safety_features'][$skey]['type_name'] = $safetyval;
					$skey++;
				}
				
				if($listdata->liststatus=="1")
				{
					$similarlisting = Listing::find()->where(['roomtype'=>$listdata->roomtype,'city'=>$listdata->city,'liststatus'=>'1'])
										 ->andWhere(['!=','id',$listdata->id])
										 ->limit('3')
										 ->all();
					if(!empty($similarlisting))
					{
					$resultarray2 = $this->listarray($similarlisting,'similar_listing');
					$newarray = array_merge($resultarray,$resultarray2);
					}
					else
					{
						$newarray =  $resultarray;
					}
				}
				else
				{
					$newarray =  $resultarray;
				}
	
				$getreviews = $this->getaveragerating($listdata->id,'list');

				$totlreviews = $getreviews['totalreview'];
				$average_ratings = $getreviews['average_rating'];
				$newarray['total_reviews'] = "$totlreviews";
				$newarray['average_rating'] = "$average_ratings";

				
				//get variable datas
				if($listdata->splpricestatus == 1) {
						$rarray = array();
						$rkey = 0;
						if(!empty($listdata->specialprice)) {
							$specialpricedata = json_decode($listdata->specialprice);
							//$specialpricedata = array_filter($specialpricedata);

							if(count($specialpricedata) > 0 ) {
								foreach ($specialpricedata as $rkeys => $special) {
									if(strtotime($special->specialendDate) >= strtotime(date('m/d/y'))) {
										$rarray[$rkey ]['start_date'] = strtotime(trim($special->specialstartDate));
										$rarray[$rkey ]['end_date'] = strtotime(trim($special->specialendDate));
										$rarray[$rkey ]['list_status'] = trim($special->liststatus);
										$rarray[$rkey ]['price'] = trim($special->specialprice);
										$rarray[$rkey ]['notes'] = $special->note;
										++$rkey;
									}
								}
							}
						} 

						if(!empty($listdata->blockedspecialprice)) {
							$specialpricedata = json_decode($listdata->blockedspecialprice);

							if(count($specialpricedata) > 0) {
								
								foreach ($specialpricedata as $rkeys=>$special) {
									if(strtotime($special->specialendDate) >= strtotime(date('m/d/y'))) {
										$rarray[$rkey]['start_date'] = strtotime(trim($special->specialstartDate)); 
										$rarray[$rkey]['end_date'] = strtotime(trim($special->specialendDate));
										$rarray[$rkey ]['list_status'] = trim($special->liststatus);
										$rarray[$rkey ]['price'] = "";  
										$rarray[$rkey ]['notes'] = $special->note;
										++$rkey; 
									}   
								}
							}
						} 
						if(count($rarray) > 0) 
							$newarray['calendar'] = $rarray;
					}

				if($newarray['total_reviews'] != 0)
				{

					$getuserdata = Users::find()->where(['id'=>$getlatestreview[0]->userid])->one();

					$newarray['review']['reviewer_name'] = $getuserdata->firstname;
					$newarray['review']['reviewer_id'] = $getlatestreview[0]->userid;
					$newarray['review']['reviewer_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$getuserdata->profile_image);
					$newarray['review']['review_date'] = strtotime($getlatestreview[0]->cdate);
					$newarray['review']['user_review'] = $getlatestreview[0]->review;
				}else{
					$newarray['review'] = '';
				}

				$result = json_encode($newarray);
				echo '{"status":"true","result":'.$result.'}';
			}
		}
		
		else
		{
			//echo 'param wrong'; exit;
			echo '{"status":"false","message":"Sorry, Something went to be wrong"}';	
		}
	}
	
	public function actionSearch() {
      $userid = (isset($_POST['user_id'])) ? trim($_POST['user_id']):"";
      $methodType = (isset($_POST['searchtype'])) ? trim($_POST['searchtype']):"";
      $userdata = User::find()->where(['id'=>$userid])->one();
    	if((count($userdata) > 0 && !empty($userdata)) && ($methodType == "search" || $methodType == "traverse" || $methodType == "recent" || $methodType == "featured")) { 

    		if($userdata->currency_mobile > 0) {
    			//user currency
		      $currencyRate= Myclass::getcurrencyidprice($userdata->currency_mobile);
		   } else {
		      $currencydata = Currency::find()->where(['defaultcurrency'=>1])->one(); 
		      //user currency
		      $currencyRate= Myclass::getcurrencyprice($currencydata->currencycode); 
		   }

		   //Initialization
		   $searchdata = array();
		   $checkin = ""; $checkout = ""; $place = ""; $placeType = "";
		   $lat = ""; $lon = ""; $amenityTypeSelected ="";
		   $dateCondition = "";
         $priceCondition = "";
         $conditionFlag = 0;
         $locationCondition = ""; 

		   /***** Declaration ******/
		   //Offset
		   if(isset($_POST['offset'])) {
		      $offset = $searchdata['offset'] = trim($_POST['offset']);
		   } else {
		      $offset = 0;
		   }

		   //Limit
		   if(isset($_POST['limit'])) {
		      $limit = $searchdata['limit'] = trim($_POST['limit']);
		   } else {
		      $limit = 10;
		   }

		   // Search Key
		   if(isset($_POST['search_key'])) {
		      $searchdata['search_key'] = $place = trim($_POST['search_key']);
		      $place = preg_replace("/[^a-zA-Z, ]/", "", trim($place));  
      		$placeType = array_values(array_filter(explode(',',$place)));  
		   } 

		   // Check In and Check Out
			if(isset($_POST['check_in']) && $_POST['check_in']!="") {
				$searchdata['check_in'] = $checkin = trim($_POST['check_in']);
			}

			if(isset($_POST['check_out']) && $_POST['check_out']!="") {
				$searchdata['check_out'] = $checkout = trim($_POST['check_out']);
			}
			
			if(!empty($checkin) && !empty($checkout) && ($checkin < $checkout)) { 
            $dateCondition = [
         							'or',[
                                  'and',
                                  ['hts_listing.bookingavailability'=> "always"],
                                  ['hts_listing.startdate'=> NULL],
                                  ['hts_listing.enddate' => NULL],
                              ], [
                                  'and',
                                  ['hts_listing.bookingavailability'=> "onetime"], 
                                  ['<=','hts_listing.startdate',$checkin],
                                  ['>=','hts_listing.enddate', $checkout],
                              ]
                             ];
         } 

			// Lat & Lon
			if(isset($_POST['lat']) && $_POST['lat']!="") {
				$searchdata['lat'] = $lat = trim($_POST['lat']);
			}

			if(isset($_POST['lon']) && $_POST['lon']!="") {
				$searchdata['lon'] = $lon = trim($_POST['lon']);
			} 

			if($lat!="" && $lon!="") {
				if(isset($_POST['kilometer']) && trim($_POST['kilometer']) > 0) {
					$kilometer = $_POST['kilometer'] * 0.1 / 11;
				} else {
					$kilometer = 80 * 0.1 / 11;
				}

				// Range in degrees (0.1 degrees is close to 11km)
				$Distance = $kilometer; 
				$LatN = $lat + $Distance;
				$LatS = $lat - $Distance;
				$LonE = $lon + $Distance;
				$LonW = $lon - $Distance;

				$locationCondition = ['and', ['between','hts_listing.latitude',$LatS, $LatN], ['between','hts_listing.longitude', $LonW, $LonE]];
			}

			// priceRange 
         $priceRange = (isset($_POST['price_range']) && trim($_POST['price_range'])!="") ? explode('-',trim($_POST['price_range'])) : ""; 

         if(!empty($priceRange) && count($priceRange) == 2) {
				if(((int)$priceRange[0] <= (int)$priceRange[1]) && ((int)$priceRange[1] < 10000)) {
					$priceCondition = ['or', ['between',"Round(((hts_listing.nightlyprice/u.price) * $currencyRate),2)", (int)$priceRange[0],(int)$priceRange[1]], ['between',"Round(((hts_listing.hourlyprice/u.price) * $currencyRate),2)", (int)$priceRange[0],(int)$priceRange[1]], ];  
				} else if((int)$priceRange[0] >= 10000) {
					$priceCondition = ['or', ['>=',"Round(((hts_listing.nightlyprice/u.price) * $currencyRate),2)",10000], ['>=',"Round(((hts_listing.hourlyprice/u.price) * $currencyRate),2)",10000] ];  
				} else if((int)$priceRange[1] >= 10000) {   
					$priceCondition = ['or', ['>=',"Round(((hts_listing.nightlyprice/u.price) * $currencyRate),2)",(int)$priceRange[0]], ['>=',"Round(((hts_listing.hourlyprice/u.price) * $currencyRate),2)",(int)$priceRange[0]] ]; 
				} 
			}  

			//Price Filter Sub Query
         $subQuery = (new Query())->select('*')->from('hts_currency')->where('hts_currency.price > 0');

         // Condition Array
         $condition[] = 'and';
         $condition[] = ['=','hts_listing.liststatus', "1"];

         //Filters Essentials
         if(isset($_POST['bedrooms']) && $_POST['bedrooms'] != "" && trim($_POST['bedrooms']) > 0) {
				$bedroom = $_POST['bedrooms'];
				$condition[] = ['>=','hts_listing.bedrooms', $bedroom]; 
				$searchdata['bedrooms'] = $bedroom;
			}
			if(isset($_POST['bathrooms']) && $_POST['bathrooms'] != "" && trim($_POST['bathrooms']) > 0) {
				$bathroom = $_POST['bathrooms'];
				$condition[] = ['>=','hts_listing.bathrooms', $bathroom];
				$searchdata['bathrooms'] = $bathroom;
			}
			if(isset($_POST['beds']) && $_POST['beds'] != "" && trim($_POST['beds']) > 0) {
				$beds = $_POST['beds'];
				$condition[] = ['>=','hts_listing.beds', $beds];
				$searchdata['beds'] = $beds;
			}
			if(isset($_POST['accommodates']) && $_POST['accommodates'] != "" && trim($_POST['accommodates']) > 0) {
				$beds = $_POST['accommodates'];
				$condition[] = ['>=','hts_listing.accommodates', $beds]; 
				$searchdata['accommodates'] = $beds;
			}
			if (isset($_POST['property_type']) && $_POST['property_type'] != "") {
				$homeTypes = $_POST['property_type'];
				$homeTypeSelected = explode(',', $homeTypes);
				$condition[] = ['IN','hts_listing.hometype', $homeTypeSelected];
				$searchdata['property_type'] = $homeTypes;
			}
			if (isset($_POST['room_type']) && $_POST['room_type'] != "" ) {
				$roomTypes = $_POST['room_type'];
				$roomTypeSelected = explode(',', $roomTypes);
				$condition[] = ['IN','hts_listing.roomtype', $roomTypeSelected];
				$searchdata['room_type'] = $roomTypes;
			}

			if (isset($_POST['amenities']) && $_POST['amenities'] != "" ) {
				$amenityTypes = $_POST['amenities'];
				$amenityTypeSelected = explode(',', $amenityTypes);
				$searchdata['amenities_type'] = $amenityTypes;
			} else {
				$amenityTypes = "";  
			}

			// Durations
			$durationList = (isset($_POST['duration_type']) && trim($_POST['duration_type'])!="") ? trim($_POST['duration_type']) : ""; 

			if(!empty($durationList) && ($durationList == "perhour" || $durationList == "pernight")) {
			  	$searchdata['duration_type'] = $durationList;
			  	$condition[] = ['=','hts_listing.booking', $durationList];
			}


			// Method Type Condition
			if($methodType == "featured") {

				$query = Listing::find()->where($condition);
				$query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency'); 
				$query->andwhere(['hts_listing.featuredlist'=>'1'])->andwhere($priceCondition)->andwhere($dateCondition)->andwhere($locationCondition)->orderBy('hts_listing.id desc'); 
				$conditionFlag = 1;

			} elseif ($methodType == "traverse") {  
				$query = Listing::find()->select(['count(hts_reservations.listid) as maxapp','hts_listing.*']);
				$query->join('RIGHT JOIN', 'hts_reservations', 'hts_reservations.listid = hts_listing.id');
				$query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency'); 
				$query->where($condition)->andwhere($priceCondition)->andwhere($dateCondition)->andwhere($locationCondition)->groupBy('hts_reservations.listid')->orderBy('maxapp desc');
				$conditionFlag = 1;   
			} elseif($methodType == "recent") {

				$query = Listing::find()->where($condition);
				$query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency'); 
				$query->andwhere($priceCondition)->andwhere($dateCondition)->andwhere($locationCondition)->orderBy('hts_listing.id desc'); 
				$conditionFlag = 1;

			} elseif($methodType == "search") { 
				if(trim($place)!="" && count($placeType) == 1) { 
		         // Country Based Listing Search
		         $countryData = Country::find()->where(['countryname'=>ucfirst(strtolower(trim($placeType[0])))])->orWhere(['like','alternative',strtolower(trim($placeType[0]))])->one(); 
		         if(count($countryData) > 0) { 
		            $countryDetails = $countryData->id; 
		            $query = Listing::find()->where($condition);
		            $query->andwhere(['country'=>trim($countryDetails)]);
		            $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency');
		            $query->andwhere($priceCondition)->andwhere($dateCondition)->orderBy('hts_listing.id desc');
		            $conditionFlag = 1;
		         } else {
		            $methodType = "location";
		         }
		      } else {  
		      	$methodType = "location";
		      }
			}

			if($methodType == "location" && $conditionFlag == 0) { 
             $query = Listing::find()->where($condition);
             $query->leftJoin(['u' => $subQuery], 'u.id=hts_listing.currency'); 
             $query->andwhere($priceCondition)->andwhere($dateCondition)->andwhere($locationCondition)->orderBy('hts_listing.id desc');

             $conditionFlag = 1;
         }

         if($conditionFlag == 1) {
         	if($amenityTypeSelected != "" && count($amenityTypeSelected) > 0 && $amenityTypes !="") { 
					$query->joinWith('commonlistings', true, 'RIGHT JOIN');
					$query->andwhere(['IN', 'hts_commonlisting.amenityid', $amenityTypeSelected]); 
				}
  
		      $listDetails = $query->all();
		      $resultcount = count($listDetails); 
		      $listDetails = $query->offset($offset)->limit($limit)->all();
		      $resultarray = array(); 

		      if(!empty($listDetails)) {
		        $resultarray = $this->listarray1($listDetails);
		        $result = json_encode($resultarray);
		        
		        echo '{"status":"true","result_count":'.$resultcount.',"result":'.$result.'}';
		      } else { 
		        echo '{"status":"false","message":"No result found"}';
		      } 
         } else { 
	        	echo '{"status":"false","message":"No result found"}';
	      }  
    	} else {
    		echo '{"status":"false","message":"No result found"}';
    	}
	}
	
	public function actionContacthost()
	{

		if(isset($_POST['user_id']) && isset($_POST['host_id']) && isset($_POST['message']) && isset($_POST['list_id']))
		{
				$_POST['senderid'] = $_POST['user_id'];
				$_POST['receiverid']= $_POST['host_id'];
				$_POST['listingid']= $_POST['list_id'];
				$_POST['messages']= $_POST['message'];

			  $senderid = trim($_POST['senderid']);
		      $receiverid = trim($_POST['receiverid']);
		      $messages = trim($_POST['messages']);
		      $listingid = trim($_POST['listingid']);
		      $booking = trim($_POST['duration_type']);
		      $guests = trim($_POST['guest_count']);
		      $bookingtime = NULL;
		      $checkinDate = trim($_POST['start_date']);
		      $checkoutDate = trim($_POST['end_date']);

		      if(isset($_POST['bookingtime']) && trim($_POST['bookingtime'])!="") {
		        $bookingtime = trim($_POST['bookingtime']);
		      }

		      $loguserid = $_POST['senderid'];
		      $listingdata = Listing::find()->where(['id'=>$listingid])->one();
		      
		      if($loguserid == $senderid && $listingdata->userid == $receiverid) 
		      {
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
		            $userdevicedet = Userdevices::find()->where(['user_id'=>$receiverid])->all();
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
		            echo '{"status":"true","message":"Message sent successfully"}';
		            exit;
		         } else {
		            // already available
		            echo '{"status":"false","message":"You have already contacted host to this duration"}'; 
		            exit;
		         }
		         
		      } else {
		      	
		        echo "2";
		      }
			echo '{"status":"true","message":"Message sent successfully"}';
			exit;
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionGetmessages()
	{
		if(isset($_POST['user_id']) && isset($_POST['type']))
		{
			$userid = $_POST['user_id'];
			$msgtype = $_POST['type'];

			$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
    		$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;

			//All messages
			if($_POST['type'] == 'host')
			{
				$allmessages = new \yii\db\Query;
                    $allmessages->select('*')
                    ->from('hts_messages')
                    ->leftJoin('hts_inquiry', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.receiverid', $userid])
                    ->orderBy('hts_messages.cdate desc');
                    //->limit(0)->offset(20);

	            $countQuery = clone $allmessages;
	            $messages = $countQuery->createCommand()->queryAll();	

	            //echo '<pre>'; print_r($messages); exit;
			} elseif($_POST['type']=='guest') {
				$allmessages = new \yii\db\Query;
                    $allmessages->select('*')
                    ->from('hts_messages')
                    ->leftJoin('hts_inquiry', 'hts_inquiry.lastmessageid = hts_messages.id')
                    ->where(['=', 'hts_inquiry.senderid', $userid])
                    ->orderBy('hts_messages.cdate desc');  
                    //->limit(0)->offset(20);
                $countQuery = clone $allmessages;
	            $messages = $countQuery->createCommand()->queryAll();	
			}

			//echo '<pre>'; print_r($messages); exit;

			$messages = array_slice( $messages, $offset, $limit );

			if(!empty($messages) && $msgtype!='admin')
			{
				$time = time();
				foreach($messages as $key => $message)
				{
					$message = (object) $message;
					
					$resultarray[$key]['type'] = $msgtype;
					$resultarray[$key]['message_id'] = $message->inquiryid;   
					$senderid = $message->senderid;
					$receiverid = $message->receiverid;
					$listingid = $message->listingid;
					$senderdata = Users::find()->where(['id'=>$senderid])->one();
					$receiverdata = Users::find()->where(['id'=>$receiverid])->one();
					$listingdata = Listing::find()->where(['id'=>$listingid])->one();
					$photos = Photos::find()->where(['listid'=>$listingdata->id])->all();
					$senderimage = $senderdata->profile_image;
					$receiverimage = $receiverdata->profile_image;
					if($senderimage=="")
					$senderimage="usrimg.jpg";
					if($receiverimage=="")
					$receiverimage = "usrimg.jpg";
					$senderimageurl = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$senderimage);
					$receiverimageurl = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$receiverimage);

					if($userid==$senderid)
					{
						$resultarray[$key]['user_id'] = $receiverdata->id;
						$resultarray[$key]['user_image'] = $receiverimageurl;
						$resultarray[$key]['user_name'] = $receiverdata->firstname;
					}
					else
					{
						$resultarray[$key]['user_id'] = $senderdata->id;
						$resultarray[$key]['user_image'] = $senderimageurl;
						$resultarray[$key]['user_name'] = $senderdata->firstname;
					}

					/**
					*Check reservation with inquiry table.
					*
					*/

           		$reservedurationType = trim($listingdata->booking);
               if($reservedurationType == "pernight") {
                   $s_datetime = strtotime(date('m/d/Y', strtotime($message->checkin)));
                   $e_datetime = strtotime(date('m/d/Y', strtotime($message->checkout)));
                   $reservationStatus = Reservations::find()->where(['listid'=>$listingdata->id])
                   ->andWhere(['=','fromdate',$s_datetime])
                   ->andWhere(['=','todate',$e_datetime])
                   ->andWhere(['=','inquiryid',$message->inquiryid])
                   ->one();
               } else {
                   $s_datetime = strtotime($message->checkin);
                   $e_datetime = strtotime($message->checkout);

                   $reservationStatus = Reservations::find()->where(['listid'=>$listingdata->id])
                   ->andWhere(['=','checkin',$message->checkin])
                   ->andWhere(['=','checkout',$message->checkout])
                   ->andWhere(['=','inquiryid',$message->inquiryid]) 
                   ->one();
               } 


              if(!empty($reservationStatus)) {
              		if($reservationStatus->userid == $message->senderid) {
              			$resultarray[$key]['status'] = ucfirst($reservationStatus->bookstatus);
              		} else {
              			$resultarray[$key]['status'] = ucfirst('Not available');
              		}
              } else {
                  if($listingdata->booking == 'pernight')
                   {
                   	$checkinDate = date('Y-m-d', $s_datetime);
              			$checkoutDate = date('Y-m-d', $e_datetime);
                   	$getInquiry = Inquiry::find()->where(['listingid'=>$listingdata->id])
                    		->andWhere(['=','checkin',$checkinDate.' 00:00:00'])
                         ->andWhere(['=','checkout',$checkoutDate.' 00:00:00'])
                         ->andWhere(['=','id',$message->inquiryid])
                         ->one();	
                   }else{
                   	$checkinDate = date('Y-m-d H:i:s', $s_datetime);
              			$checkoutDate = date('Y-m-d H:i:s', $e_datetime);
                   	$getInquiry = Inquiry::find()->where(['listingid'=>$listingdata->id])
                    		->andWhere(['=','checkin',$checkinDate])
                         ->andWhere(['=','checkout',$checkoutDate])
                         ->andWhere(['=','id',$message->inquiryid])  
                         ->one();	
                   }	

                   if(!empty($getInquiry))
                   	$resultarray[$key]['status'] = ucfirst($getInquiry->type);
                  
              }

                    /**
					*End reservations.
					*
					*/

					//Get recent message at first.
					$getlastMessage = Messages::find()->where(['id'=>$message->lastmessageid])->one();
					
					$resultarray[$key]['date'] = ''.strtotime($getlastMessage->cdate).''; 
					$resultarray[$key]['last_message'] = $message->message;
					$resultarray[$key]['time'] = ''.$time.'';  


					if($message->receiverread==0 && $userid == $getlastMessage->receiverid)
						$resultarray[$key]['read'] = "false";
					else
						$resultarray[$key]['read'] = "true";

					$resultarray[$key]['list_id'] = $message->listingid;

					$resultarray[$key]['start_date'] = strtotime($message->checkin);
					$resultarray[$key]['end_date'] = strtotime($message->checkout);
					//$resultarray[$key]['other_reservation_status'] = (count($otherguestreservations) > 0) ? 'true' : 'false';

					if((time()-(60*60*24)) < strtotime($message->checkout))
					{	
						$resultarray[$key]['expiry_status'] = "false";
					}else{
						$resultarray[$key]['expiry_status'] = "true";
					}
					
					
					if(!empty($photos)){
						foreach( $photos as $keyphoto => $photo )
						{
							$listimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photo->image_name);
						}
					}else{
							$userimage = "usrimg.jpg";
							$listimage = Yii::$app->urlManager->createAbsoluteUrl('albums/images/users/'.$userimage);
					}
					
					$resultarray[$key]['list_image'] = $listimage;
					$resultarray[$key]['list_name'] = $listingdata->listingname;
					$resultarray[$key]['duration_type'] = $listingdata->booking;  
				}

				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';
			}
			else
			{
				echo '{"status":"false","message":"No result found"}';
			}
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionGetconversation()
	{
		//id - inquiry.

		if(isset($_POST['user_id']) && isset($_POST['id'])) {
			$inquiryid = trim($_POST['id']);
			$userid = trim($_POST['user_id']);

			$set = new \yii\db\Query;
						$set->select(['hts_inquiry.senderid', 
							'hts_users.firstname',
							'hts_inquiry.receiverid',
							'hts_inquiry.type',
							'hts_inquiry.id',
							'hts_inquiry.checkin',
							'hts_listing.booking',
							'hts_listing.blockedspecialprice',
							'hts_inquiry.checkout',
							'hts_inquiry.listingid'])  
					        ->from('hts_inquiry')
					        ->leftJoin('hts_users', 'hts_users.id = hts_inquiry.senderid')
					        ->leftJoin('hts_listing', 'hts_listing.id = hts_inquiry.listingid')
					        ->where(['hts_inquiry.id'=>$inquiryid])
					        ->andwhere(['or',['receiverid'=>$userid],['senderid'=>$userid]])
					        ->limit(1); 

			$command = $set->createCommand();
			$getInquiry = $command->queryOne();

			if(empty($getInquiry))
			{
				echo '{"status":"false","message":"No result found"}';	
			}

			if($getInquiry['type']=='inquiry')
			{

				if($getInquiry['booking']=='pernight'){

					//$getReservation = Reservations::find()->where(['fromdate'=>strtotime($getInquiry['checkin']),'todate'=>strtotime($getInquiry['checkout'])])
					$s_datetime = strtotime(date('m/d/Y', strtotime($getInquiry['checkin'])));
               $e_datetime = strtotime(date('m/d/Y', strtotime($getInquiry['checkout'].'-1 days'))); 

					$getReservation = Reservations::find()->where(['or', ['between','fromdate',$s_datetime,  $e_datetime], ['between','todate', $s_datetime,  $e_datetime]])   
						->andWhere(['=','listid',$getInquiry['listingid']]) 
						->andWhere(['!=','bookstatus','refunded'])
                	->andWhere(['!=','bookstatus','declined']) 
                	->one();
					$start_date = date('m/d/Y',strtotime($getInquiry['checkin']));
					$to_date = date('m/d/Y',strtotime($getInquiry['checkout']));
				} else {   
					$getReservation = Reservations::find()->where(['checkin'=>$getInquiry['checkin'],
						'checkout'=>$getInquiry['checkout']])
						->andWhere(['=','listid',$getInquiry['listingid']])  
						->andWhere(['!=','bookstatus','refunded'])
                	->andWhere(['!=','bookstatus','declined'])
                	->one(); 
					$start_date = date('m/d/Y',strtotime($getInquiry['checkin']));
					$to_date = date('m/d/Y',strtotime($getInquiry['checkout']));
				} 

				$blockedCount = 0;
				$blockPrice = ($getInquiry['blockedspecialprice']!="" && $getInquiry['blockedspecialprice'] != NULL) ? json_decode($getInquiry['blockedspecialprice']) : NULL;

				if(count($blockPrice) > 0) {
				   $count=count($blockPrice);
				   for($i=0; $i<$count; $i++) {
				       $cell = $blockPrice[$i];

				       if($cell->liststatus == 'blocked') {
				           for ($pDate=strtotime($start_date); $pDate <= strtotime($to_date); $pDate+=86400) {
				               if($pDate >= strtotime($cell->specialstartDate) && $pDate <= strtotime($cell->specialendDate)) {
				                   ++$blockedCount;
				               }
				           }
				       }
				   }
				}

				if(!empty($getReservation))
				{
					$status = 'Not Available';	 
				} elseif(strtotime($start_date) < time()) {
					$status = 'Expired'; 
				} elseif($blockedCount > 0) {
					$status = 'Blocked';
				} else {
					$status = 'Available';
				}
			} else {
				$getReservation = Reservations::find()->where(['inquiryid'=>$getInquiry['id']])->one();
				$status = ucfirst($getReservation["bookstatus"]);
			} 


			$inquiryData = Inquiry::find()->where(['id'=> $inquiryid])->one();
         if(count($inquiryData) > 0 && (($userid == $inquiryData->senderid) || ($userid == $inquiryData->receiverid))) {
				$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
    			$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;

				$senderid = trim($inquiryData->senderid);
	            $receiverid = trim($inquiryData->receiverid);
	            $listingid = trim($inquiryData->listingid);
				$resultarray = array();

	    		$updateReceiver = Messages::find()->Where(['inquiryid'=>$inquiryid, 'receiverid'=>$userid, 'receiverread'=>0])->count();
	    		if($updateReceiver > 0) {
	    			Messages::updateAll(['receiverread' => 1], ['and',['=', 'receiverid', $userid], ['=', 'inquiryid', $inquiryid], ['=', 'receiverread', 0]]);
	    		}

	    		$messages = Messages::find()->Where(['listingid'=>$listingid, 'inquiryid'=>$inquiryid])->orderBy('cdate desc')->offset($offset)->limit($limit)->all();  

	    		$time = time();

				if(count($messages) > 0) 
				{
					foreach($messages as $key => $message)
					{
						$senderdata = $message->getSender()->where(['id'=>$message->senderid])->one();
						$senderimg = $senderdata->profile_image;
						if($senderimg=="")
							$senderimg = "usrimg.jpg";
						$senderimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$senderimg);
						$resultarray[$key]['chat_id'] = $message->id;
						$resultarray[$key]['user_id'] = $message->senderid;
						$resultarray[$key]['user_image'] = $senderimage;
						$resultarray[$key]['user_name'] = $senderdata->firstname;
						$resultarray[$key]['date'] = ''.strtotime($message->cdate).'';
						$resultarray[$key]['time'] = ''.$time.''; 
						$resultarray[$key]['message'] = $message->message;
						
					} 
					$result = json_encode($resultarray);

					$inq_userid = ($getInquiry["senderid"] == $userid) ? $getInquiry['receiverid'] : $getInquiry['senderid'] ;
					$getUsername = User::find()->select('firstname')->where(['id'=>$inq_userid])->one();

					if(count($getReservation) > 0) 
						$res_id = $getReservation["id"];
					else
						$res_id = 0;  

					echo '{"status":"true",
					"user_id":'.$inq_userid.',
					"user_name":"'.$getUsername["firstname"].'",
					"list_id":'.$getInquiry["listingid"].',
					"type":"'.$getInquiry["type"].'",  
					"order_status":"'.$status.'",
					"order_id":'.$res_id.', 
					"result":'.$result.'}';
				}
				else
				{
					echo '{"status":"false","message":"No result found"}';
				}
			} else {
				echo '{"status":"false","message":"Sorry, something went to be wrong"}';
			}
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionSendconversation() 
	{
		if(isset($_POST['user_id']) && isset($_POST['id']) && isset($_POST['message']) && isset($_POST['receiverId']) && isset($_POST['listingId']) && count($_POST) == 5) {
			$userid = trim($_POST['user_id']);

			$inquiryid = trim($_POST['id']);
			$messages = trim($_POST['message']);
			$senderid = trim($userid);
         $receiverid = trim($_POST['receiverId']);
         $listingid = trim($_POST['listingId']);

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
				$userdevicedet = Userdevices::find()->where(['user_id'=>$receiverid])->all();
				$senderdata = Users::find()->where(['id'=>$senderid])->one();

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

				
				$senderimg = $senderdata->profile_image;
				if($senderimg=="")
					$senderimg = "usrimg.jpg";

				$newmessage = Messages::find()->where(['id'=>$contactmessage->id])->one();
				$senderimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$senderimg);

				$resultarray['id'] = $inquiryid;  
				$resultarray['chat_id'] = $contactmessage->id;
				$resultarray['user_id'] = $senderid;
				$resultarray['user_image'] = $senderimage;
				$resultarray['user_name'] = $senderdata->firstname;
				$resultarray['date'] = strtotime($newmessage->cdate);
				$resultarray['message'] = $messages;			
				
				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';	
         } else {
         	echo '{"status":"false","message":"Sorry, something went to be wrong"}';
         }                      	
		} else {
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionGetadminmessages()
	{
		//$_POST['user_id'] = 2;
		if(isset($_POST['user_id']))
		{
			$userid = $_POST['user_id'];

			$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
    		$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;

    		$query = Messages::find()->where(['receiverid'=>$userid])
    		->andWhere(['messagetype'=>'admin'])->orderBy('id desc');
    		$messages = $query->offset($offset)
    		->limit($limit)
    		->all();
			if(!empty($messages))
			{
				foreach($messages as $key => $message)
				{
					$resultarray[$key]['admin_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');
					$resultarray[$key]['date'] = strtotime($message->cdate);
					$resultarray[$key]['message'] = $message->message;
				}
				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';
			}
			else
			{
				echo '{"status":"false","message":"No result found"}';
			}
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionGetnotifications()
	{
		if(isset($_POST['user_id']))
		{
			$userid = $_POST['user_id'];
			
			$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
    		$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;

			$query = Logs::find()->where(['notifyto'=>$userid])->orderBy('id desc');
			$logmessages = $query->offset($offset)
			->limit($limit)
			->all();
			if(!empty($logmessages))
			{
				foreach($logmessages as $key => $log)
				{
					$userdata = $log->getUser()->where(['id'=>$log->userid])->one();
					$userimage = $userdata->profile_image;
					$username = $userdata->firstname;
					if($userimage=="")
					$userimage="usrimg.jpg";
					$userimageurl = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$userimage);
					if($log->type=="message")
					{
						$resultarray[$key]['type'] = 'message';
						$resultarray[$key]['notification_id'] = $log->id;
						$resultarray[$key]['user_id'] = $userdata->id;
						$resultarray[$key]['user_image'] = $userimageurl;
						$resultarray[$key]['user_name'] = $username;
						$resultarray[$key]['date'] = $log->cdate;
						$resultarray[$key]['time'] = time();
						$resultarray[$key]['message'] = $log->message;
					}
					else if($log->type=="request" || $log->type=="reservation" || $log->type=="accept" || $log->type=="cancel" || $log->type=="decline" || $log->type == "claim" || $log->type == "review")
					{
						$listid = $log->listingid;
						$listingdata = $log->getListing()->where(['id'=>$listid])->one();
						$listingname = $listingdata->listingname;
						$photos = Photos::find()->where(['listid'=>$listid])->all();
						$resultarray[$key]['type'] = $log->type;
						$resultarray[$key]['notification_id'] = $log->id;
						$resultarray[$key]['user_id'] = $userdata->id;
						$resultarray[$key]['user_image'] = $userimageurl;
						$resultarray[$key]['user_name'] = $username;
						$resultarray[$key]['date'] = $log->cdate;
						$resultarray[$key]['time'] = time();
						$resultarray[$key]['block'] = ($listingdata->liststatus == "2") ? "yes" : "no";  

						$resultarray[$key]['list_id'] = $listid;
						$resultarray[$key]['list_name'] = $listingname;
						$resultarray[$key]['list_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photos[0]->image_name);
						$resultarray[$key]['notifymessage'] = $log->notifymessage;
					}
					else if($log->type=="admin")
					{
						if($log->message=="")
							$resultarray[$key]['type'] = 'adminlog';
						else
							$resultarray[$key]['type'] = 'adminmessage';
						$resultarray[$key]['notification_id'] = $log->id;
						$resultarray[$key]['user_id'] = $userdata->id;
						$resultarray[$key]['user_image'] = $userimageurl;
						$resultarray[$key]['user_name'] = $username;
						$resultarray[$key]['date'] = $log->cdate;
						$resultarray[$key]['time'] = time();
						if($log->message=="")
							$resultarray[$key]['message'] = $log->notifymessage;
						else
							$resultarray[$key]['message'] = $log->message;						
					}
					else if($log->type=="adminpayment")
					{
						$resultarray[$key]['type'] = 'adminpayment';
						$resultarray[$key]['notification_id'] = $log->id;
						$resultarray[$key]['user_id'] = $userdata->id;
						$resultarray[$key]['user_image'] = $userimageurl;
						$resultarray[$key]['user_name'] = $username;
						$resultarray[$key]['date'] = $log->cdate;
						$resultarray[$key]['time'] = time();
						$resultarray[$key]['message'] = $log->notifymessage;						
					}  
				}
				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';
			}
			else
			{
				echo '{"status":"false","message":"No result found"}';
			}   
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionGetwishlists()  
	{
		if(isset($_POST['user_id'])) 
		{
			$userid = $_POST['user_id'];
			$listid = $_POST['list_id'];
			$listnames = Lists::find()->where(['createdby'=>$userid])
    								->orWhere(['user_create'=>0])->all();
			if(!empty($listnames))
			{
				foreach($listnames as $key => $listname)
				{
					$query = Wishlists::find()->where(['hts_wishlists.listid'=>$listname->id,'hts_wishlists.userid'=>$userid]);
					$query->leftJoin('hts_listing', 'hts_listing.id = hts_wishlists.listingid');
					$query->andWhere(['=', 'hts_listing.liststatus', '1']);
					$query->orderBy('hts_wishlists.id desc'); 
					$wishlists = $query->all();
					
					//$wishlists = Wishlists::find()->where(['listid'=>$listname->id,'userid'=>$userid])->orderBy('id desc')->all(); 
					$listcount = count($wishlists);
					if($listid != "" && $listid != "0" && $listid > 0){
						$userwishlist = Wishlists::find()->where(['listid'=>$listname->id,'userid'=>$userid,'listingid'=>$listid])->one();
					} else {  
						$userwishlist = Wishlists::find()->where(['listid'=>$listname->id,'userid'=>$userid])->one();
					}
					$resultarray[$key]['wish_id'] = $listname->id;
					$resultarray[$key]['wish_name'] = $listname->listname;
					if($listname->user_create==0)
					{
						$resultarray[$key]['default'] = 'admin';
					}
					else
					{
						$resultarray[$key]['default'] = 'user';
					}

					if(!empty($wishlists)) {
						$listingid = $wishlists[0]->listingid;
						$photos = Photos::find()->where(['listid'=>$listingid])->orderBy('id asc')->one();
						if(!empty($photos)){
							$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photos->image_name); 
							$resultarray[$key]['image'] = $image_url;
						} else {
								$userimage = "usrimg.jpg";
								$usrimg = Yii::$app->urlManager->createAbsoluteUrl('albums/images/users/'.$userimage);
								$resultarray[$key]['image'] = $usrimg;
						}
						
					} else {
						$userimage = "usrimg.jpg";
						$usrimg = Yii::$app->urlManager->createAbsoluteUrl('albums/images/users/'.$userimage);
						$resultarray[$key]['image'] = $usrimg;
					}
					$resultarray[$key]['listing_count'] = $listcount;
					if(!empty($userwishlist))
					$resultarray[$key]['already_added'] = "true";
					else
					$resultarray[$key]['already_added'] = "false";
				}
				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';
			}
			else
			{
				echo '{"status":"false","message":"No result found"}';
			}
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionGetwishlistlisting() 
	{
		if(isset($_POST['user_id']) && isset($_POST['wish_id']))
		{
			$userid = $_POST['user_id'];
			$wishid = $_POST['wish_id'];

			$query = Wishlists::find()->where(['hts_wishlists.listid'=>$wishid,'hts_wishlists.userid'=>$userid]);
					$query->leftJoin('hts_listing', 'hts_listing.id = hts_wishlists.listingid');
					$query->andWhere(['=', 'hts_listing.liststatus', '1']);
					$wishlists = $query->all();
					 
			$listingids = array();
			if(!empty($wishlists))
			{
				foreach($wishlists as $key => $wishlist)
				{
					$listingids[] = $wishlist->listingid;				
				}
				$listdata = Listing::find()->where(['id'=>$listingids])->all();
				if(!empty($listdata))
				{
					$resultarray = $this->listarray1($listdata);
					$result = json_encode($resultarray);
					echo '{"status":"true","result":'.$result.'}';
				}
				else
				{
					echo '{"status":"false","message":"No result found"}';
				}
			}
			else
			{
				echo '{"status":"false","message":"No result found"}';
			}			
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}		
	}
	
	public function actionCreatewishlist()
	{
		if(isset($_POST['user_id']) && isset($_POST['wish_name']))
		{
			if(isset($_POST['wish_id']))
			{
				$lists = Lists::find()->where(['id'=>$_POST['wish_id']])->one();
				if(!empty($lists))
				{
					$lists->listname = $_POST['wish_name'];
				}
				else
				{
					$lists = new Lists();
					$lists->listname = $_POST['wish_name'];
					$lists->createdby = $_POST['user_id'];
					$lists->user_create = 1;					
				}
			}
			else
			{
				$lists = new Lists();
				$lists->listname = $_POST['wish_name'];
				$lists->createdby = $_POST['user_id'];
				$lists->user_create = 1;
			}
			$lists->save();
			$listdatas = Lists::find()->where(['id'=>$lists->id])->one();
			
			$resultarray['wish_id'] = $listdatas->id;
			$resultarray['wish_name'] = $listdatas->listname;
			
			$wishlists = Wishlists::find()->where(['listid'=>$listdatas->id,'userid'=>$_POST['user_id']])->all();
			if(!empty($wishlists)){
						$listingid = $wishlists[0]->listingid;
						$photos = Photos::find()->where(['listid'=>$listingid])->all();
						if(!empty($photos)){
							foreach($photos as $keyphoto => $photo)
							{
								$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photo->image_name);
								$resultarray['image'] = $image_url;
							} 
						}else{
								$userimage = "usrimg.jpg";
								$usrimg = Yii::$app->urlManager->createAbsoluteUrl('albums/images/users/'.$userimage);
								$resultarray['image'] = $usrimg;
						}
						
					} else {
						$userimage = "usrimg.jpg";
						$usrimg = Yii::$app->urlManager->createAbsoluteUrl('albums/images/users/'.$userimage);
						$resultarray['image'] = $usrimg;
					}
			$resultarray['listing_count'] = count($wishlists); 
			$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';		
    		} else {
    			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
    		} 
	}
		
	public function actionDashboard()
	{
		if( isset($_POST['user_id']) )
		{
			$userid = $_POST['user_id'];
			$model = new SignupForm ();
			$userdata = $model->findIdentity ( $userid );

			$resultarray['email_verified'] = ($userdata->emailverify==1) ? 'true' : 'false';
			$resultarray['phone_verified'] = ($userdata->mobileverify==1) ? 'true' : 'false';
			//$resultarray['paypalid'] = (isset($userdata->paypalid)) ? $userdata->paypalid : '';
						
			$listdata = Listing::find()->where(['liststatus'=>1,'userid'=>$userid])->all();
			if(!empty($listdata))
			{
				foreach($listdata as $listkey => $listval)
				{
					$listid = $listval->id;
					$photos = Photos::find()->where(['listid'=>$listid])->all();
					if(isset($photos[0]->image_name) && $photos[0]->image_name!="")
					$listimage = $photos[0]->image_name;
					else
					$listimage = "usrimg.jpg";
					$resultarray['listings'][$listkey]['list_id'] = $listval->id;
					$resultarray['listings'][$listkey]['list_name'] = $listval->listingname;
					$resultarray['listings'][$listkey]['list_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$listimage);
					$requests = Reservations::find()->where(['listid'=>$listid,'bookstatus'=>'requested'])
											->all();
					$reservations = Reservations::find()->where(['listid'=>$listid,'bookstatus'=>'accepted'])
											->all();
					$resultarray['listings'][$listkey]['requests'] = count($requests);
					$resultarray['listings'][$listkey]['reservations'] = count($reservations);
					if($listval->bookingstyle=="instant")
					$resultarray['listings'][$listkey]['instant_book'] = "true";
					else
					$resultarray['listings'][$listkey]['instant_book'] = "false";
				}
			}
			else
			{
				$resultarray['listings'] = "";
			}
			$adminmessages = Messages::find()->where(['receiverid'=>$userid])
    		->andWhere(['messagetype'=>'admin'])->all();
			foreach($adminmessages as $key => $admin)
			{
				$baseUrl = Yii::$app->urlManager->createAbsoluteUrl("");   
				$resultarray['admin_notifications'][$key]['admin_image'] = $baseUrl.'albums/images/users/usrimg.jpg';
				$resultarray['admin_notifications'][$key]['date'] = strtotime($admin->cdate);
				$resultarray['admin_notifications'][$key]['message'] = $admin->message;
			}
				$currentMonth = date('m');
				/* Code Start hts */
				$resultarray['total_booking'] = Reservations::find()->where(['hostid'=>$userid])
					->andWhere('MONTH(cdate)='.$currentMonth)
					->count();  

				if($resultarray['total_booking'] == 0)
				{
					$resultarray['total_earning'] = 0;
				}else{
					$bookingsEarnedPrice = 0;
					$bookingsEarned = Reservations::find()->where(['hostid'=>$userid, 'MONTH(cdate)'=>$currentMonth])
					->andWhere(['or', 

									['and',
										['=','bookstatus', 'accepted'],
	                           ['=','orderstatus', 'paid'],
	                           ['!=','claim_transaction', 'NULL'],
	                        ],
	                        ['and',
	                           ['=','bookstatus', 'refunded'],
	                           ['=','orderstatus', 'paid'],
	                           ['!=','claim_transaction', 'NULL'],
	                        ],
									['and',
	                           ['=','bookstatus', 'claimed'], 
	                           ['=','orderstatus', 'paid'],
	                           ['!=','claim_transaction', 'NULL'], 
	                        ]
	                      ])->all();  

					$bePrice = array();
					foreach($bookingsEarned as $beKey => $value) {
						//Paid currency
	               $rate2 = Myclass::getcurrencyprice($value->convertedcurrencycode);  
	               //user currency
	               $paycurrency = Currency::find()->where(['id'=>$userdata->currency_mobile])->one();
	               $rate = Myclass::getcurrencyprice($paycurrency->currencycode);

	               if($value->claim_transaction != NULL) {
							$host_amount = json_decode($value->claim_transaction, true);
				    		$host_amount = $host_amount['amount']/100;
				    		$bePrice[count($bePrice)] = round($rate * ($host_amount/$rate2),2);
				    	} 
					} 
					$values_earn = round(array_sum($bePrice),2);
					$resultarray['total_earning'] = "$values_earn";       
					$resultarray['total_earning_count'] = count($bePrice);     
				} 

				$query = new \yii\db\Query;
					 $query	->select(['hts_reviews.id as reviewid', 
					 				  'hts_reviews.rating as rating', 
					 				  'hts_listing.id as listid', 
					 				  'hts_reviews.review as reviews', 
					 				  'hts_reviews.userid as userid',
					 				  'hts_reviews.cdate as reviewdate'])  
					        ->from('hts_reviews')
					        ->leftJoin('hts_listing', 'hts_listing.id = hts_reviews.listid')
					        ->where(['=', 'hts_listing.userid', $userid])
					       // ->andWhere('MONTH(hts_reviews.cdate) = '.$currentMonth)
					        ->orderBy('hts_reviews.cdate desc');
					
					$command = $query->createCommand();
					$reviewData = $command->queryAll();
					$sum = 0;
					foreach($reviewData as $rdata)
					{
						$sum+= $rdata['rating'];  
					}
					if($sum != 0 && count($reviewData) != 0)
					{
						$resultarray['average_rating'] = round($sum/count($reviewData));
					}else{
						$resultarray['average_rating'] = 0;  
					}
			/* Code end*/
			$result = json_encode($resultarray);
			echo '{"status":"true","result":'.$result.'}';
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionProfile()
	{
		if(isset($_POST['user_id']))  
		{
			$models = new SignupForm();
			$userid = $_POST['user_id'];
			$hostid = (isset($_POST['host_id']) && trim($_POST['host_id'])!="") ? trim($_POST['host_id']): "";  
			$getReportdata = "";
			$resultarray['report_id'] = "";

			if($hostid!="") {
				$getReportdata = Userreports::find()->where(['reporterid'=>$hostid, 'userid'=>$userid, 'report_type'=>'profile'])->one();    
				if(count($getReportdata) > 0) {
					$resultarray['report_id'] = $getReportdata->reportid;  
				}
				$userid = $hostid; 
			}

			$userdata = $models->findIdentity ( $userid );
			$getListingdata = Listing::find()->where(['userid'=>$userid])->All();   
			$reportstatus = (isset($getReportdata) && count($getReportdata) > 0) ? 'true' : 'false';

			if(!empty($userid))
			{
				$resultarray['user_id'] = $userid;
				$resultarray['full_name'] = $userdata->firstname;
				$resultarray['last_name'] = $userdata->lastname;
				$userimage = $userdata->profile_image;
				if($userimage=="")
				$userimage = "usrimg.jpg";
				$usrimg = Yii::$app->urlManager->createAbsoluteUrl('albums/images/users/'.$userimage);
				$resultarray['user_image'] = $usrimg;
				$resultarray['email'] = $userdata->email;
				$resultarray['phone'] = $userdata->verifycountrycode.$userdata->verifyno;
				$resultarray['report'] = $reportstatus;
				$resultarray['total_listing'] = count($getListingdata); 

				if($userdata->emailverify==1)
				$resultarray['email_verified'] = 'true';
				else
				$resultarray['email_verified'] = 'false';
				if($userdata->mobileverify==1)
				$resultarray['phone_verified'] = 'true';
				else
				$resultarray['phone_verified'] = 'false';
				$created = $userdata['created_at'];
				$month = date('F',$created);
				$year = date('Y',$created);			
				$resultarray['member_from'] = $month.' '.$year;
				$resultarray['gender'] = $userdata->gender;
				$resultarray['date_of_birth'] = $userdata->birthday;
				$resultarray['about_me'] = $userdata->about;
				$resultarray['school'] = $userdata->school;
				$resultarray['work'] = $userdata->work;
				$resultarray['live_address'] = $userdata->state;
				$resultarray['paypal_id'] = $userdata->paypalid;
				$resultarray['account_status'] = $userdata->stripe_status;  

				//$languages = Languages::find()->all();
				$languages = $userdata->language;
				if(!empty($languages))
				{
					$languages = json_decode($languages,true);//print_r($languages);die;
					if(!empty($languages))
					{
					foreach($languages as $lkey => $language)
					{
						$resultarray['languages'][$lkey]['name'] = $language['name'];
					}
					}
					else
					{
						$resultarray['languages'] = "";
					}
				}
				$timezones = Timezone::find()->where(['timezone'=>$userdata->timezone])->one();
				if(!empty($timezones))
				{
					$resultarray['timezone']['id'] = $timezones->id;
					$resultarray['timezone']['country_name'] = $timezones->countryname;
					$resultarray['timezone']['time_zone'] = $timezones->timezone;
				}
				
				$resultarray['emergency_contact']['name'] = $userdata->emergencyname;
				$resultarray['emergency_contact']['phone'] = $userdata->emergencyno;
				$resultarray['emergency_contact']['email'] = $userdata->emergencyemail;
				$resultarray['emergency_contact']['relationship'] = $userdata->emergencyrelation;
				$shipping = Shippingaddress::find ()->where ( [ 
						'userid' => $userid 
				] )->One ();
				if(!empty($shipping))
				{
					$resultarray['shipping_address']['country_id'] = $shipping->country;
					$countrydata = Country::find()->where(['id'=>$shipping->country])->one();
					if(!empty($countrydata))
					{
						$resultarray['shipping_address']['country_name'] = $countrydata->countryname;
					}
					else
						$resultarray['shipping_address']['country_name'] = "";
					$resultarray['shipping_address']['address_one'] = $shipping->address1;
					$resultarray['shipping_address']['address_two'] = $shipping->address2;
					$resultarray['shipping_address']['city'] = $shipping->city;
					$resultarray['shipping_address']['state'] = $shipping->state;
					$resultarray['shipping_address']['zipcode'] = $shipping->zipcode;
				}
				else
				{
					$resultarray['shipping_address']['country_id'] = "";
					$resultarray['shipping_address']['country_name'] = "";
					$resultarray['shipping_address']['address_one'] = "";
					$resultarray['shipping_address']['address_two'] = "";
					$resultarray['shipping_address']['city'] = "";
					$resultarray['shipping_address']['state'] = "";
					$resultarray['shipping_address']['zipcode'] = "";					
				}

				/* Code for below
					Total Reviews
					Average rating
					Review
				 */
					 $query = new \yii\db\Query;
					
					 $query->select(['hts_reviews.id as reviewid', 
					 				  'hts_reviews.rating as rating', 
					 				  'hts_listing.id as listid', 
					 				  'hts_reviews.review as reviews', 
					 				  'hts_reviews.userid as userid',
					 				  'hts_reviews.cdate as reviewdate'])  
					        ->from('hts_reviews')
					        ->leftJoin('hts_listing', 'hts_listing.id = hts_reviews.listid')
					        ->where(['=', 'hts_listing.userid', $userid])
					        ->orderBy('hts_reviews.cdate desc'); 
							
					$command = $query->createCommand();
					//echo $command->getRawSql(); exit;
					$reviewData = $command->queryAll();
					$sum = 0;
					foreach($reviewData as $rdata)
					{
						$sum+= $rdata['rating'];
					}
					if($sum != 0 && count($reviewData) != 0)
					{
						$resultarray['average_rating'] = ($sum/count($reviewData));
					}else{
						$resultarray['average_rating'] = 0;
					}
					$resultarray['total_reviews'] = count($reviewData);
					$getAllratings = array();

				 	if(count($reviewData) > 0)
				 	{
				 		$userform = new SignupForm ();
			    		$userdata = $userform->findIdentity ( $reviewData[0]['userid'] );

						$resultarray['review']['reviewer_name'] = $userdata->firstname;
						$resultarray['review']['reviewer_id'] = $reviewData[0]['userid'];
						$resultarray['review']['reviewer_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$userdata->profile_image);
						$resultarray['review']['user_review'] = $reviewData[0]['reviews'];
						$resultarray['review']['review_date'] = strtotime($reviewData[0]['reviewdate']);
				 	} 
				 	$similarlisting = Listing::find()->where(['userid'=>$userid, 'liststatus'=>'1'])->all();
					if(count($similarlisting) > 0)
					{
						$resultarray2 = $this->listarray($similarlisting,'host_listing');
						$resultarray = array_merge($resultarray,$resultarray2);
					}
		
				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';
			}
			else
			{
				echo '{"status":"false","message":"No result found"}';
			}
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionEditprofile()
	{
		if(isset($_POST['user_id']))
		{
			$userid = $_POST['user_id'];
			$userdata = User::find()->where(['id'=>$userid])->one();
			if(isset($_POST['full_name']))
			{
				$userdata->firstname = $_POST['full_name'];
			}
			if(isset($_POST['last_name']))
			{
				$userdata->lastname = $_POST['last_name'];
			}
			if(isset($_POST['phone']))
			{
				$userdata->verifyno = $_POST['phone'];  
			}
			if(isset($_POST['countrycode']))
			{
				$userdata->verifycountrycode = trim($_POST['countrycode']);
			}
			if(isset($_POST['paypal_id']))
			{
				$userdata->paypalid = $_POST['paypal_id'];
			}
			if(isset($_POST['gender']))
			{
				$userdata->gender = $_POST['gender'];
			}
			if(isset($_POST['live_address']))
			{
				$userdata->state = $_POST['live_address'];
			}
			if(isset($_POST['about_me']))
			{
				$userdata->about = $_POST['about_me'];
			}
			if(isset($_POST['school']))
			{
				$userdata->school = $_POST['school'];
			}
			if(isset($_POST['work']))
			{
				$userdata->work = $_POST['work'];
			}
			if(isset($_POST['date_of_birth']))
			{
				$userdata->birthday = $_POST['date_of_birth'];
			}
			if(isset($_POST['timezone_id']))
			{
				$timezone = Timezone::find()->where(['id'=>$_POST['timezone_id']])->one();
				$userdata->timezone = $timezone->timezone;
			}
			if(isset($_POST['languages']))
			{
				$languages = $_POST['languages'];
				$userdata->language = $languages;
			}
			if(isset($_POST['emergency_name']))
			{
				$userdata->emergencyname = $_POST['emergency_name'];
			}
			if(isset($_POST['emergency_phone']))
			{
				$userdata->emergencyno = $_POST['emergency_phone'];
			}
			if(isset($_POST['emergency_email']))
			{
				$userdata->emergencyemail = $_POST['emergency_email'];
			}
			if(isset($_POST['emergency_relationship']))
			{
				$userdata->emergencyrelation = $_POST['emergency_relationship'];
			}

			if(isset($_POST['phone_verified']))
			{
				$userdata->mobileverify = $_POST['phone_verified'];
			}

			$shipping = Shippingaddress::find ()->where ( [ 
						'userid' => $userid 
				] )->One();

			//echo '<pre>'; print_r($shipping); exit;
			if (isset($shipping) && !empty ( $shipping )) {
				$shipping->id = $shipping->id;
			}
			else {
				$shipping = new Shippingaddress();
				//echo $userid; exit;
				$shipping->userid = $userid;
			}
			
			if(isset($_POST['country_id']))
			{
				$shipping->country = $_POST['country_id'];
			}
			if(isset($_POST['address_one']))
			{
				$shipping->address1 = $_POST['address_one'];
			}
			if(isset($_POST['address_two']))
			{
				$shipping->address2 = $_POST['address_two'];
			}
			if(isset($_POST['city']))
			{
				$shipping->city = $_POST['city'];
			}
			if(isset($_POST['state']))
			{
				$shipping->state = $_POST['state'];
			}
			if(isset($_POST['zipcode']))
			{
				$shipping->zipcode = $_POST['zipcode'];
			}
			$userdata->save();
			if(isset($shipping)){
			$shipping->save(false);
			}
			echo '{"status":"true","message":"Successfully changed"}';
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionGetsettings()
	{
		if(isset($_POST['user_id']))
		{
			$userid = $_POST['user_id'];
			$userdata = User::find()->where(['id'=>$userid])->one();
			$pushnotifications = $userdata->pushnotification;
			$notifications = json_decode($userdata->notifications,true);
			$emailsettings = json_decode($userdata->emailsettings,true);
			if($pushnotifications==1)
				$resultarray['push_notification'] = 'enable';
			else
				$resultarray['push_notification'] = 'disable';
			if($notifications['mobilenotify']==1)
				$resultarray['text_notification'] = 'enable';
			else
				$resultarray['text_notification'] = 'disable';
			if($notifications['messagenotify']==1)
				$resultarray['notification_messages'] = 'enable';
			else
				$resultarray['notification_messages'] = 'disable';
			if($notifications['reservationnotify']==1)
				$resultarray['notification_reservation'] = 'enable';
			else
				$resultarray['notification_reservation'] = 'disable';
			if($emailsettings['reservationemail']==1)
				$resultarray['email_reservation'] = 'enable';
			else
				$resultarray['email_reservation'] = 'disable';
			$result = json_encode($resultarray);
			echo '{"status":"true","result":'.$result.'}';
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionSetsettings()
	{
		if(isset($_POST['user_id']))
		{
			$userid = $_POST['user_id'];
			$userdata = User::find()->where(['id'=>$userid])->one();
			$notification = json_decode($userdata->notifications,true);
			$emailsetting = json_decode($userdata->emailsettings,true);			
    		if(isset($_POST['push_notification']))
    			$userdata->pushnotification = $_POST['push_notification'];
    		if(isset($_POST['text_notification']))
    			$notifications['mobilenotify'] = $_POST['text_notification'];
    		else
    			$notifications['mobilenotify'] = $notification['mobilenotify'];
    		if(isset($_POST['notification_messages']))
    			$notifications['messagenotify'] = $_POST['notification_messages'];
    		else
    			$notifications['messagenotify'] = $notification['messagenotify'];
    		if(isset($_POST['notification_reservation']))
    			$notifications['reservationnotify'] = $_POST['notification_reservation'];
    		else 
    			$notifications['reservationnotify'] = $notification['reservationnotify'];
    		if(isset($_POST['accountnotify']))
    			$notifications['accountnotify'] = $_POST['accountnotify'];
    		else
    			$notifications['accountnotify'] = $notification['accountnotify'];
    		if(isset($_POST['generalemail']))
    			$emails['generalemail'] = $_POST['generalemail'];
    		else
    			$emails['generalemail'] = $emailsetting['generalemail'];
    		if(isset($_POST['email_reservation']))
	    		$emails['reservationemail'] = $_POST['email_reservation'];
    		else 
    			$emails['reservationemail'] = $emailsetting['reservationemail'];
    		$notifications_setting = json_encode($notifications);
    		$email_setting = json_encode($emails);
    		$userdata->notifications = $notifications_setting;
    		$userdata->emailsettings = $email_setting;				
			$userdata->save();
			echo '{"status":"true","message":"Successfully changed"}';
		}
		else
		{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
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
		$log->save(false);
	}	
    
  public function actionCreatelisting(){
    	
  if(isset($_POST['user_id']) && $_POST['user_id']!="" ) {
		$model = new SignupForm ();
		$userid = $_POST['user_id'];
		$userdata = $model->findIdentity ( $userid );
		
		if($userdata->emailverify!=1 && ($userdata->stripe_status!="verified" || $userdata->stripe_account_id=="")) { 
				echo '{"status":"false", "account_status": "0", "message":"please add stripe account information and verify your email id"}';
				die;
		} elseif($userdata->emailverify!=1) {
				echo '{"status":"false", "account_status": "1", "message":"You need to verify your email id to add listing"}';
				die;
		} elseif($userdata->stripe_status!="verified" || $userdata->stripe_account_id == "") {
				echo '{"status":"false", "account_status": "2", "message":"You need to add stripe account information to add listing"}';
				die;
		} else if($userdata->stripe_status == "verified" && $userdata->stripe_account_id != "" && $userdata->emailverify == 1)	{    

    		if(!isset($_POST['list_id'])) {
    			//new listing
    			if(isset($_POST['home_type']) && ($_POST['home_type'] != "") 
    			&& isset($_POST['room_type']) && ($_POST['room_type'] != "") 
    			&& isset($_POST['accomodates']) && ($_POST['accomodates'] != "") 
    			&& isset($_POST['bedrooms']) && ($_POST['bedrooms'] != "") 
    			&& isset($_POST['beds']) && ($_POST['beds'] != "") 
    			&& isset($_POST['bathrooms']) && ($_POST['bathrooms'] != "") 
    			&& isset($_POST['city']) && ($_POST['city'] != "") 
    			&& isset($_POST['state']) && ($_POST['state'] != "") 
    			&& isset($_POST['country_id']) && ($_POST['country_id'] != "") && isset($_POST['duration_type']) && ($_POST['duration_type'] != "")) 
    			{
    			
		    		$hometype = $_POST['home_type'];
		    		$roomtype = $_POST['room_type'];
		    		$accommodate = $_POST['accomodates'];
		    		$bedrooms = $_POST['bedrooms'];
						$beds = $_POST['beds'];
						$bathrooms = $_POST['bathrooms'];
		    		$city = $_POST['city'];
		    		$state = $_POST['state'];
		    		$country = $_POST['country_id'];
		    		$duration_type = $_POST['duration_type'];	
		   			$listdata = new Listing();
		    		$resultarray = array();
		    		$userid = $_POST['user_id'];
    		 
						$userdata = $model->findIdentity ( $userid );
						$userdata->hoststatus = 1;
						$userdata->save();			 
			 
		    		$listdata->userid = $userid;
		    		$listdata->hometype = $hometype;
		    		$listdata->roomtype = $roomtype;
		    		$listdata->accommodates = $accommodate;
		    		$listdata->beds = $beds;
		    		$listdata->bathrooms = $bathrooms;
		    		$listdata->bedrooms = $bedrooms;
		    		$listdata->city = $city;
						$listdata->state = $state;
						$listdata->booking = $duration_type;
		    		$countrydata = Country::find()->where(['id'=>$country])->one();
		    		$listdata->country = $countrydata->id;
		    		$currencydata = Currency::find()->where(['defaultcurrency'=>'1'])->one();
		    		$listdata->currency = $currencydata->id;
		    		$listdata->cdate = time();  
						$listdata->save(false);
						$listid = $listdata->id;
				} 
			} elseif(isset($_POST['list_id'])) {
				$listid = $_POST['list_id'];
			}
			//existing & update listing
			$changeLog = 0; 
			if(isset($_POST['duration_type']) && $_POST['duration_type'] != "") {
				$listingUpdate = Listing::find()->where(['id'=>$listid])->one();
    			$duration_type = trim($_POST['duration_type']);
    			$listing_duration = trim($listingUpdate->booking); 

    			if($duration_type != $listing_duration) {
    				$listingUpdate->booking = $duration_type;
    				$listingUpdate->nightlyprice = NULL;
    				$listingUpdate->hourlyprice = NULL;  
    				$listingUpdate->hourly_availablity = NULL;
    				$listingUpdate->pernight_availablity = NULL;  
    				$listingUpdate->minstay = NULL;  
    				$listingUpdate->maxstay = NULL;  
    				$listingUpdate->startdate = NULL;  
    				$listingUpdate->enddate = NULL;   
    				$listingUpdate->bookingavailability = NULL;   
    				$listingUpdate->liststatus = 0; 
    				$listingUpdate->save(false);  
    				$changeLog = 1;  
    			}  
    		}

			$listdata = Listing::find()->where(['id'=>$listid])->one();
			$listdata->id = $listid;
			if(isset($_POST['home_type']) && $_POST['home_type']!="")
			{
				$hometype = $_POST['home_type'];
				$listdata->hometype = $hometype;
			}
			if(isset($_POST['room_type']) && $_POST['room_type']!="")
			{
				$roomtype = $_POST['room_type'];
				$listdata->roomtype = $roomtype;
			}			
			if(isset($_POST['bedrooms']) && $_POST['bedrooms']!="")
			{
				$bedrooms = $_POST['bedrooms'];
				$listdata->bedrooms = $bedrooms;
			}
			if(isset($_POST['beds']) && $_POST['beds']!="")
			{
				$beds = $_POST['beds'];
				$listdata->beds = $beds;
			}
			if(isset($_POST['bathrooms']) && $_POST['bathrooms']!="")
			{
				$bathrooms = $_POST['bathrooms'];
				$listdata->bathrooms = $bathrooms;
			}
			if(isset($_POST['accomodates']) && $_POST['accomodates']!="")
			{
				$accommodates = $_POST['accomodates'];
				$listdata->accommodates = $accommodates;
			}			
			if(isset($_POST['list_name']) && $_POST['list_name'] != ""){
				$listname = $_POST['list_name'];
				$listdata->listingname = $listname;
			}
			if(isset($_POST['list_des']) && $_POST['list_des'] != ""){
				$listdesc = $_POST['list_des'];
				$listdata->description = $listdesc;
			}
			if(isset($_POST['street_address']) && $_POST['street_address'] != ""){
				$streetaddress = $_POST['street_address'];
				$listdata->streetaddress = $streetaddress;
			}
			if(isset($_POST['zipcode']) && $_POST['zipcode'] != ""){
				$zipcode = $_POST['zipcode'];
				$listdata->zipcode = $zipcode;
			}
    		if(isset($_POST['apt_address']) && $_POST['apt_address'] != ""){
    			$accesscode = $_POST['apt_address'];
					$listdata->accesscode = $accesscode;
			}
    		if(isset($_POST['city']) && $_POST['city'] != ""){
    			$city = $_POST['city'];
					$listdata->city = $city;
			}
    		if(isset($_POST['state']) && $_POST['state'] != ""){
    			$state = $_POST['state'];
					$listdata->state = $state;
			}
    		if(isset($_POST['country_id']) && $_POST['country_id'] != ""){
    			$country_id = $_POST['country_id'];
				$listdata->country = $country_id;
			}
			if(isset($_POST['timezone_id']) && $_POST['timezone_id'] != ""){
    			$timezone_id = $_POST['timezone_id'];
				$listdata->timezone = $timezone_id;  
			}			
			if(isset($_POST['latitude']) && $_POST['latitude'] != ""){
				$latitude = $_POST['latitude'];
				$listdata->latitude = $latitude;
			}
			if(isset($_POST['longitude']) && $_POST['longitude'] != ""){
				$longitude = $_POST['longitude'];
				$listdata->longitude = $longitude;
			}	

			/*if(isset($_POST['fire_extinguisher']) && $_POST['fire_extinguisher'] != ""){
    			$fire_extinguisher = $_POST['fire_extinguisher'];
    		  $listdata->fireextinguisher = $fire_extinguisher;
    		}*/
    		
    		if(isset($_POST['hour_price'])){
    		  $listdata->hourlyprice = (trim($_POST['hour_price']) > 0 && trim($_POST['hour_price'])!="") ? trim($_POST['hour_price']) : NULL;
    		}


    		if(isset($_POST['cancellation_policy'])){
    			$cancellation = $_POST['cancellation_policy'];
    		  $listdata->cancellation = $cancellation;
    		}


    		if(isset($_POST['night_availabletime']) && $_POST['night_availabletime'] != "") {
    			$night_availabletime = $_POST['night_availabletime'];
    		  $listdata->pernight_availablity = str_replace('-', '*|*',$night_availabletime);
    		}
    		if(isset($_POST['hours_availabletime']) && $_POST['hours_availabletime'] != "") {
    			  $hourly_availablity = $_POST['hours_availabletime'];
    		    $listdata->hourly_availablity = str_replace('-', '*|*',$hourly_availablity);
    		}

    		/*if(isset($_POST['fire_alarm']) && $_POST['fire_alarm'] != "")
   	 			$listdata->firealarm = $_POST['fire_alarm'];
   	 	if(isset($_POST['gas_shutoff']) && $_POST['gas_shutoff'] != "")
	   	 		$listdata->gasshutoffvalve = $_POST['gas_shutoff'];
	   	if(isset($_POST['emergency_exit']) && $_POST['emergency_exit'] != "")
    			$listdata->emergencyexitinstruction = $_POST['emergency_exit'];
    		if(isset($_POST['emergency_medical']) && $_POST['emergency_medical'] != "")	
    			$listdata->medicalno = $_POST['emergency_medical'];
    		if(isset($_POST['emergency_fire']) && $_POST['emergency_fire'] != "")	
    			$listdata->fireno = $_POST['emergency_fire'];
    		if(isset($_POST['emergency_police']) && $_POST['emergency_police'] != "")	
    			$listdata->policeno = $_POST['emergency_police']; 
			*/

    		if(isset($_POST['price'])) { 
    			$listdata->nightlyprice = (trim($_POST['price']) > 0 && trim($_POST['price'])!="") ? trim($_POST['price']) : NULL;
    		}
    		if(isset($_POST['security_deposit']) && $_POST['security_deposit'] != "")
    			$listdata->securitydeposit = $_POST['security_deposit'];
    		if(isset($_POST['currency_id']) && $_POST['currency_id'] != "")		
    			$listdata->currency = $_POST['currency_id'];
    		if(isset($_POST['maximum_stay']) && $_POST['maximum_stay'] != "")		
    			$listdata->maxstay = $_POST['maximum_stay'];
    		if(isset($_POST['minimum_stay']) && $_POST['minimum_stay'] != "")			
    			$listdata->minstay = $_POST['minimum_stay'];
    		if(isset($_POST['available_booking']) && $_POST['available_booking'] != "") {
    			$listdata->bookingavailability = $_POST['available_booking'];
    			if($_POST['available_booking'] == "onetime") {
    				if(!isset($_POST['start_date']) || $_POST['start_date'] == "" && !isset($_POST['end_date']) || $_POST['end_date'] == "") {
    					echo '{"status":"false","message":"Please give start date and end date"}';die;
    				} else {
    					if(isset($_POST['start_date']) && $_POST['start_date'] != "")
				   			$listdata->startdate = $_POST['start_date'];
							if(isset($_POST['end_date']) && $_POST['end_date'] != "")
    						$listdata->enddate = $_POST['end_date']; 
    				}
    			} else {
    				$listdata->startdate = "";
    				$listdata->enddate = ""; 
    			}
    		}	
    			
    		if(isset($_POST['instant_book']) && $_POST['instant_book'] == "true")
    			$listdata->bookingstyle = "instant";
    		elseif(isset($_POST['instant_book']) && $_POST['instant_book'] == "false") 
    			$listdata->bookingstyle = "request";
    			
    		if(isset($_POST['home_rules']) && $_POST['home_rules'] != "")	
    			$listdata->houserules = $_POST['home_rules'];

    		$listdata->cleaningfees = (isset($_POST['cleaning_fee']) && $_POST['cleaning_fee'] != '') ? $_POST['cleaning_fee'] : '';
		    
			$listdata->servicefees = (isset($_POST['service_fee']) && $_POST['service_fee'] != '') ? $_POST['service_fee'] : '';

			$listdata->youtubeurl = (isset($_POST['video_url']) && $_POST['video_url'] != '') ? $_POST['video_url'] : '';

			$listdata->weekendprice = (isset($_POST['weekend_fee']) && $_POST['weekend_fee'] > 0) ? '1' : '0';
			$listdata->cdate = time(); 
			$listdata->save(false);

			if(isset($_POST['weekend_fee']) && $_POST['weekend_fee'] > 0)	{
				$WeekendpriceCount = Weekendprice::find()->where(['listid'=>$listid])->one();
				if(count($WeekendpriceCount) == 0)
				{
				  $weekendprice = new Weekendprice();
				  $weekendprice->listid = $listid;
				  $weekendprice->weekend_price = $_POST['weekend_fee'];
				  $weekendprice->save(false);
				} else {
				  $WeekendpriceCount->listid = $listid;
				  $WeekendpriceCount->weekend_price = $_POST['weekend_fee'];
				  $WeekendpriceCount->save(false);
				}
			}
			
			if(isset($_POST['common_amenities']) && $_POST['common_amenities'] != "") {
				$commonamenities = explode(',',$_POST['common_amenities']);
				$commonlisting = new Commonlisting();
				$common_listing = $commonlisting->find()->where(['listingid'=>$listid])->all();
				foreach($common_listing as $clisting)
				{
					if(!in_array($clisting->amenityid,$commonamenities))
					{
						$deletecommon = $commonlisting->find()->where(['listingid'=>$listid,'amenityid'=>$clisting->amenityid])->one();
						$deletecommon->delete();
					}
				}
					
				for($j=0;$j<count($commonamenities);$j++) {
  					$commonlisting = new Commonlisting();
  					$commondata = $commonlisting->find()->where(['listingid'=>$listid,'amenityid'=>$commonamenities[$j]])->one();
  					if(count($commondata)==0)
  					{
    					$commonlisting->listingid = $listid;
    					$commonlisting->amenityid = $commonamenities[$j];
    					$commonlisting->save();
  					}
  				}
    		}
    		
    		if(isset($_POST['additional_amenities']) && $_POST['additional_amenities'] != "") {
    			$additionalamenities = explode(',',$_POST['additional_amenities']);
					
				$additionallisting = new Additionallisting();
				$additional_listing = $additionallisting->find()->where(['listingid'=>$listid])->all();
				foreach($additional_listing as $alisting) {

					if(!in_array($alisting->amenityid,$additionalamenities))
					{
						$deleteadditional = $additionallisting->find()->where(['listingid'=>$listid,'amenityid'=>$alisting->amenityid])->one();
						$deleteadditional->delete();
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
  			}
    		
    		if(isset($_POST['special_features']) && $_POST['special_features'] != "") {
 				$specialfeatures = explode(',',$_POST['special_features']);
				
				$speciallisting = new Speciallisting();
				$special_listing = $speciallisting->find()->where(['listingid'=>$listid])->all();
				foreach($special_listing as $slisting)
				{
					if(!in_array($slisting->specialid,$specialfeatures))
					{
						$deletespecial = $speciallisting->find()->where(['listingid'=>$listid,'specialid'=>$slisting->specialid])->one();
						$deletespecial->delete();
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
    		
    		if(isset($_POST['safety_checklist']) && $_POST['safety_checklist'] != "") {
    			$safetychecklist = explode(',',$_POST['safety_checklist']);
					
					$safetylisting = new Safetylisting();
					$safety_listing = $safetylisting->find()->where(['listingid'=>$listid])->all();
					foreach($safety_listing as $salisting)
					{
						if(!in_array($salisting->safetyid,$safetychecklist))
						{
							$deletesafety = $safetylisting->find()->where(['listingid'=>$listid,'safetyid'=>$salisting->safetyid])->one();
							$deletesafety->delete();
						}
					}						
					
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
    		
    		if(isset($_POST['photo']) && $_POST['photo'] != "") {
    			$filenames = json_decode($_POST['photo'],true);
    			$photodata = Photos::find()->where(['listid'=>$listid])->all();
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
    		}
    		    		
    		$listdatas = Listing::find()->where(['id'=>$listid])->one();
			$commondata = Commonlisting::find()->where(['listingid'=>$listid])->all();
			$additionaldata = Additionallisting::find()->where(['listingid'=>$listid])->all();
			$specialdata = Speciallisting::find()->where(['listingid'=>$listid])->all();
			$safetydata = Safetylisting::find()->where(['listingid'=>$listid])->all();    		
    		$photos = Photos::find()->where(['listid'=>$listid])->all();
    		
			if(($listdatas->listingname != "") && ($listdatas->description != "") && ($listdatas->streetaddress != "") && ($listdatas->zipcode != "") && ($listdatas->latitude != "") && ($listdatas->longitude != "") && ($listdatas->currency != "")	&& ($listdatas->bookingavailability != "") && ($listdatas->bookingstyle != "") && (!empty($safetydata)) && (!empty($commondata)) && (!empty($additionaldata)) && (!empty($specialdata)) && (!empty($photos)) && $changeLog == 0) {
				
					if($listdatas->bookingavailability == "onetime") {		
	    				if(($listdatas->startdate != "") && ($listdatas->enddate != "")) {
			    				$listdatas->id = $listid;
								if(isset($listdata->liststatus) && $listdata->liststatus=="0")
									$listdata->liststatus = "1";
								else if($listdata->liststatus=="2")
									$listdata->liststatus = "2";
								else if(!isset($listdata->liststatus))
									$listdata->liststatus = "1";
								else
									$listdata->liststatus = "1";
			    				$listdata->save(false);
			    		}
	    			} else {
	    				$listdatas->id = $listid;
							if(isset($listdata->liststatus) && $listdata->liststatus=="0")
								$listdata->liststatus = "1";
							else if($listdata->liststatus=="2")
								$listdata->liststatus = "2";
							else if(!isset($listdata->liststatus))
								$listdata->liststatus = "1";
							else
								$listdata->liststatus = "1";						
		    				$listdata->save(false);
	    			}
    		} else {
	 				$listdatas->id = $listid;
					if(isset($listdata->liststatus) && $listdata->liststatus=="0")
						$listdata->liststatus = "0";
					else if($listdata->liststatus=="2")
						$listdata->liststatus = "2";
					else if(!isset($listdata->liststatus))
						$listdata->liststatus = "0";
					else
						$listdata->liststatus = "0";					
    			$listdata->save(false);
 			}
 			
    		$listModel = Listing::find()->where(['id'=>$listid])->one();
    			
			$resultarray['list_id'] = $listid;
			$resultarray['list_name'] = $listModel->listingname;
		
			if($listModel->liststatus == "1")
			$resultarray['status'] = "Completed";
			else 
			$resultarray['status'] = "Incomplete";
		
			$resultarray['description'] = $listModel->description;
			$currency = $listModel->getCurrency0()->where(['id'=>$listModel->currency])->one();
			if(!empty($currency)){ 
				$resultarray['currency_symbol'] =  $currency->currencysymbol;	
				$resultarray['currency_code'] =  $currency->currencycode;	
			}
			$resultarray['currency_id'] = $listModel->currency;
			$resultarray['security_deposit'] = $listModel->securitydeposit;
			if($listModel->bookingstyle == "instant")
				$resultarray['instant_book'] = "true"; 
			else 
				$resultarray['instant_book'] = "false";
			
			$photos = Photos::find()->where(['listid'=>$listid])->all();
		
			foreach($photos as $keyphoto => $photo)
			{
				$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photo->image_name);
				
				$resultarray['photos'][$keyphoto]['image_org'] = $image_url;
			}
		
			$hometype = $listModel->getHometype0()->where(['id'=>$listModel->hometype])->one();
			$resultarray['property_id'] = $listModel->hometype;
			$resultarray['property_name'] = (isset($hometype->hometype)) ? $hometype->hometype : '';
			
			$roomtype = $listModel->getRoomtype0()->where(['id'=>$listModel->roomtype])->one();
			$resultarray['room_id'] = $listModel->roomtype;
			$resultarray['room_name'] = $roomtype->roomtype;
			
			$resultarray['accommodates'] = $listModel->accommodates;
			$resultarray['bedrooms'] = $listModel->bedrooms;
			$resultarray['beds'] = $listModel->beds;
			$resultarray['bathrooms'] = $listModel->bathrooms;
			$countrydata = Country::find()->where(['id'=>$listModel->country])->one();
			$resultarray['address'] = $listModel->streetaddress.','.$listModel->city.','.$listModel->state.','.$countrydata->countryname;
			$resultarray['lat'] = $listModel->latitude;
			$resultarray['lon'] = $listModel->longitude;
			$resultarray['minimum_stay'] = $listModel->minstay;
			$resultarray['maximum_stay'] = $listModel->maxstay;
			$resultarray['street_address'] = $listModel->streetaddress;
			$resultarray['apt_address'] = $listModel->accesscode;
			$resultarray['city'] = $listModel->city;
			$resultarray['state'] = $listModel->state;
			$resultarray['country_name'] = $countrydata->countryname;
			$resultarray['country_id'] = $listModel->country;
			$resultarray['zipcode'] = $listModel->zipcode;

			$resultarray['country_code'] = ($listModel->country > 0) ? $countrydata->code : ""; 
			$resultarray['timezone_id'] = "";
			$resultarray['time_zone'] = "";

			if(isset($listModel->timezone) && trim($listModel->timezone) > 0) {
				$resultarray['timezone_id'] = $listModel->timezone;
				$timezoneData = Timezone::find()->where(['id'=>$listModel->timezone])->one();
				$resultarray['time_zone'] = (count($timezoneData) > 0) ? $timezoneData->timezone : "";
			} 
			
			/*$resultarray['fire_extinguisher'] = $listModel->fireextinguisher;
			$resultarray['fire_alarm'] = $listModel->firealarm;
			$resultarray['gas_shutoff'] = $listModel->gasshutoffvalve;	
			$resultarray['emergency_instruction'] = $listModel->emergencyexitinstruction;
			$resultarray['emergency_medical'] = $listModel->medicalno;
			$resultarray['emergency_fire'] = $listModel->fireno;
			$resultarray['emergency_police'] = $listModel->policeno; */
			$resultarray['availability'] = $listModel->bookingavailability;
			$resultarray['duration_type'] = $listModel->booking;
			$resultarray['video_url'] = $listModel->youtubeurl;
			$resultarray['cleaning_fee'] = (trim($listModel->cleaningfees) > 0) ? trim($listModel->cleaningfees) : NULL;
			$resultarray['cancellation_policy'] = $listModel->cancellation;
			$resultarray['service_fee'] = (trim($listModel->servicefees) > 0) ? trim($listModel->servicefees) : NULL;  
			$resultarray['weekend_fee_status'] = $listModel->weekendprice;

			if($listModel->weekendprice == 1) {
				$weekendData = Weekendprice::find()->where(['listid'=>$listid])->one();
				if(count($weekendData) > 0){
					$resultarray['weekend_fee'] = $weekendData->weekend_price;
				} else {
					$resultarray['weekend_fee'] = 0;
				}
			}	
			 		
			if($listModel->booking=='perday' || $listModel->booking=='pernight'){
				$resultarray['price'] =  $listModel->nightlyprice;
				$resultarray['night_availabletime'] = str_replace('*|*', ' - ', $listModel->pernight_availablity);
			}
			if($listModel->booking=='perday' || $listModel->booking=='perhour') {
				$resultarray['hour_price'] = $listModel->hourlyprice;
				$hourly_availablity=str_replace('*|*', ' - ', $listModel->hourly_availablity);
				$hourly_availablity=explode(',',$hourly_availablity);
				$hourly_availablity=array_values(array_filter($hourly_availablity)); 
				$hourly_availablity_count=count($hourly_availablity);
				$hours = "";
				if(!empty($hourly_availablity) &&  $hourly_availablity_count >0)
				{
					for($i=0;$i<$hourly_availablity_count;$i++)
					{
						if($i == 0)
							$hours = $hourly_availablity[$i];  
						else
							$hours = $hours.", ".$hourly_availablity[$i]; 
	 
					}
					$resultarray['hours_availabletime'] = $hours; 
				}
				else
				{
				$resultarray['hours_availabletime'] = "";
				}
			}
			if(isset($listModel->houserules) && $listModel->houserules!="")
			{
				$resultarray['home_rules'] = $listModel->houserules;
			}
		
			if($listModel->bookingavailability=="onetime")
			{
				$resultarray['start_date'] = $listModel->startdate;
				$resultarray['end_date'] = $listModel->enddate;
			}
		
			$commondata = Commonlisting::find()->where(['listingid'=>$listid])->all();
			$additionaldata = Additionallisting::find()->where(['listingid'=>$listid])->all();
			$specialdata = Speciallisting::find()->where(['listingid'=>$listid])->all();
			$safetydata = Safetylisting::find()->where(['listingid'=>$listid])->all();
			$skey = 0;	
			foreach($commondata as $common)
			{    	
				$commonamenity = $common->getAmenity()->where(['id'=>$common->amenityid])->one();
				$resultarray['common_amenities'][$skey]['type_id'] = $commonamenity->id;
				$resultarray['common_amenities'][$skey]['type_name'] = $commonamenity->name;
				$skey++;
			}
			$akey = 0;	
			foreach($additionaldata as $additional)
			{
				$additionalamenity = $additional->getAmenity()->where(['id'=>$additional->amenityid])->one();
				$resultarray['additional_amenities'][$akey]['type_id'] = $additionalamenity->id;
				$resultarray['additional_amenities'][$akey]['type_name'] = $additionalamenity->name;
				$akey++;
			}
			$sfkey = 0;
			foreach($specialdata as $special)
			{
				$specialfeature = $special->getSpecial()->where(['id'=>$special->specialid])->one();
				$specialfeatures[$specialfeature->id] = $specialfeature->name;
				$resultarray['safety_features'][$sfkey]['type_id'] = $specialfeature->id;
				$resultarray['safety_features'][$sfkey]['type_name'] = $specialfeature->name;
				$sfkey++;
			}
			$sckey = 0;
			foreach($safetydata as $safety)
			{
				$safetycheck = $safety->getSafety()->where(['id'=>$safety->safetyid])->one();
				$resultarray['safety_checklist'][$sckey]['type_id'] = $safetycheck->id;
				$resultarray['safety_checklist'][$sckey]['type_name'] =  $safetycheck->name;
				$sckey++;
			}			
					
    		$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';		
			
		}
		/*else
		{
			echo '{"status":"false","message":"You need to add paypal id and to verify your email id to add listing"}';
		}*/
	}	else {
		echo '{"status":"false","message":"Sorry, something went to be wrong"}';
	}	
    
  }
  
  public function actionGettrips(){
    	
		if(isset($_POST['user_id']) && isset($_POST['recent'])) {
			$model = new Reservations();
			$userform = new SignupForm();		
			
			$resultarray = array();

			$userid = trim($_POST['user_id']);
			$recent = trim($_POST['recent']);
			
			$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
    		$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;
			
			$userdata = $userform->findIdentity ($userid);

			$todaydate = date('m/d/Y');
			$today = strtotime($todaydate);
			
			if($recent == 1) {
				$query = Reservations::find()->where(['>','todate',$today])
						->andWhere(['userid'=>$userid])->orderBy('id desc');
			} elseif($recent == 2) {
				$query = Reservations::find()->where(['<=','todate',$today])
			->andWhere(['userid'=>$userid])->orderBy('id desc');
			} elseif($recent == 0) {
				$query = Reservations::find()->where(['userid'=>$userid])->orderBy('id desc');
			}
			
			$trips = $query->offset($offset)->limit($limit)->all();   
			
			if(!empty($trips)) {
				foreach($trips as $key => $trip) {
					$resultarray[$key]['id'] = $trip->inquiryid;
					$resultarray[$key]['order_id'] = $trip->id;  		
					$resultarray[$key]['status'] = ucfirst($trip->bookstatus);
					$resultarray[$key]['price'] = $trip->pricepernight;
					$resultarray[$key]['duration_type'] = $trip->booking;
					$resultarray[$key]['security_deposit'] = $trip->securityfees;
					$resultarray[$key]['service_fee'] = $trip->servicefees;
					$resultarray[$key]['host_id'] = $trip->hostid;

			     
			      	$rate = $trip->convertedprice;

			      	if($userid == $trip->userid) {   
						$resultarray[$key]['grand_total'] = $trip->total;
						$currencyData = Currency::find()->where(['currencycode'=>$trip->convertedcurrencycode])->one(); 
					}	else {
						$resultarray[$key]['grand_total'] = round(($trip->total/$rate),2); 
						$currencyData = Currency::find()->where(['currencycode'=>$trip->currencycode])->one(); 
					}	      										

					$resultarray[$key]['currency'] = $currencyData->currencysymbol;
					$resultarray[$key]['currencycode'] = $currencyData->currencycode; 

					$hostdata = $trip->getHost()->where(['id'=>$trip->hostid])->one();
					$resultarray[$key]['host_name'] = $hostdata->firstname.' '.$hostdata->lastname;
					$usrimg = $hostdata->profile_image;
					if(trim($usrimg) == "")
						$usrimg = "usrimg.jpg";
					$userimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$usrimg);
					$resultarray[$key]['host_image'] = $userimage;

					$listid = $trip->listid;
					$resultarray[$key]['list_id'] = $listid;
					
					$currentTimezone = Myclass::getTime($trip->timezone);
					date_default_timezone_set('UTC');  
					
					$listdata = Listing::find()->where(['id'=>$listid])->one();
					$resultarray[$key]['list_name'] = $listdata->listingname;
					
					$resultarray[$key]['block'] = ($listdata->liststatus == 2) ? "yes":"no";  

					$photos = Photos::find()->where(['listid'=>$listid])->all();
					$reviewData = Reviews::find()->where(['reservationid'=>$trip->id])->one();
					$reserve_status = array('accepted','claimed');

					if(count($reviewData) == 0 && (strtotime($trip->checkout) < strtotime($currentTimezone)) && (in_array($trip->bookstatus,$reserve_status) || ($trip->bookstatus == "refunded" && strtolower($trip->cancelby) == "admin"))) {
						$resultarray[$key]['rating'] = "";
						$resultarray[$key]['review'] = "";
						$resultarray[$key]['review_status'] = 'true'; 
					} else if(count($reviewData) > 0 && (strtotime($trip->checkout) < strtotime($currentTimezone)) && (in_array($trip->bookstatus,$reserve_status) || ($trip->bookstatus == "refunded" && strtolower($trip->cancelby) == "admin"))) { 
						$resultarray[$key]['rating'] = $reviewData->rating;
						$resultarray[$key]['review'] = $reviewData->review;
						$resultarray[$key]['review_status'] = 'true';    
					} else {
						$resultarray[$key]['rating'] = "";
						$resultarray[$key]['review'] = "";
						$resultarray[$key]['review_status'] = 'false';   
					}

					$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photos[0]->image_name);
					
					$resultarray[$key]['list_image'] = $image_url;
					
					$resultarray[$key]['check_in'] = strtotime($trip->checkin);
					$resultarray[$key]['check_out'] = strtotime($trip->checkout);  
							
					$countrydata = Country::find()->where(['id'=>$listdata->country])->one();
					$resultarray[$key]['address'] = $listdata->streetaddress.', '.$listdata->city.', '.$listdata->state.', '.$countrydata->countryname;


					if(($trip->bookstatus == "requested" || $trip->bookstatus == "accepted") && (strtotime($currentTimezone) < strtotime($trip->checkin))) {
	               		$resultarray[$key]['cancel_status'] = 'true';
	               } else {
	               		$resultarray[$key]['cancel_status'] = 'false';	 
	               }	  		
					
				}
				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';		
			
			} else {
				echo '{"status":"false","message":"No result found"}';
			}
    				
		} else {
				echo '{"status":"false","message":"No result found"}';
		} 
   }
    
        public function actionSendinvitefriends(){
       		
       	if(isset($_POST['user_id']) && isset($_POST['email_id'])){	
       		$userid = $_POST['user_id'];
       		$emailids = $_POST['email_id'];
 
       		$model = new SignupForm ();
				$invitemodel = new Userinvites ();
				$tablename = $invitemodel->tableName ();
				
				$email = explode (',', $emailids);
				
				$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
				
				$loguser = $model->findIdentity ($userid);
				$userinvitearray = array ();
			
				foreach ( $email as $key => $toemail ) {
						$userinviteModel = Userinvites::find ()->where ( [ 
									'userid' => $userid,
									'invitedemail' => $toemail 
				] )->all ();
			
				//if (count ( $userinviteModel ) == 0) {
				$userinvitearray [] = [ 
						'userid' => $userid,
						'invitedemail' => $toemail,
						'status' => 'Invited',
						'inviteddate' => time (),
						'cdate' => time () 
				];
				//}
			}
			if (count ( $userinvitearray ) > 0) {
				$columnNameArray = [ 
					'userid',
					'invitedemail',
					'status',
					'inviteddate',
					'cdate' 
				];
			
			$insertCount = Yii::$app->db->createCommand ()->batchInsert ( $tablename, $columnNameArray, $userinvitearray )->execute ();
			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
			$siteName = $sitesetting->sitename;
			
			foreach ( $userinvitearray as $invites ) {
				//echo $email = $invites ['invitedemail'];
				Yii::$app->mailer->compose ( 'invitemail', [ 
						'loguser' => $loguser,
						'siteName' => $siteName,
				] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Invite mail' )->send ();
			}
		 }
       		echo '{"status":"true","message":"Email send successfully"}';
   	 } else {
   	 	   echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
		 }
				
     }
     
     public function actionAddandremovewishlist()
	  {
			if(isset($_POST['user_id']) && isset($_POST['list_id']) && isset($_POST['wish_id']))
			{
				
				$wishlists = Wishlists::find()->where(['userid'=>$_POST['user_id'],'listid'=>$_POST['wish_id'],'listingid'=>$_POST['list_id']])->one();
				
				if(!empty($wishlists))
				{
    				$wishlist = Wishlists::find()->where(['userid'=>$_POST['user_id'],'listid'=>$_POST['wish_id'],'listingid'=>$_POST['list_id']])->one();
    				$wishlist->delete();
					echo '{"status":"true","message":"Successfully removed"}';	
				}
				else
				{
					$wlists = new Wishlists();
					$wlists->userid = $_POST['user_id'];
					$wlists->listid = $_POST['wish_id'];
					$wlists->listingid = $_POST['list_id'];
					$wlists->save();					
					echo '{"status":"true","message":"Successfully added"}';
				}
		
			} else {
    			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
    		}
	  }
	  
	public function actionMylistings(){
	  	
		$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
		$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;

	  	if(isset($_POST['user_id'])) {
  			$userid = $_POST['user_id'];
  			$resultarray = array();
	  			
	  		$listdetails = Listing::find()->where(['userid'=>$userid])->offset($offset)->limit($limit)->orderBy('id desc')->all();
	  		
	  		if(!empty($listdetails)) {
    		
	    		foreach($listdetails as $key=>$listdata) {
	    			$listid = $listdata->id;
					$resultarray[$key]['list_id'] = $listdata->id;
					$resultarray[$key]['list_name'] = $listdata->listingname;
				
					$resultarray[$key]['status'] = ($listdata->liststatus == "1") ? "Completed" : "Incomplete";
		
					$resultarray[$key]['description'] = $listdata->description;
					$resultarray[$key]['price'] =  $listdata->nightlyprice;
					$resultarray[$key]['duration_type'] = $listdata->booking;

					if(($listdata->nightlyprice=="" || $listdata->nightlyprice==null || $listdata->nightlyprice==0) && ( $listdata->booking=='perhour')) {
							$resultarray[$key]['price'] = "";
					} else {
						 $resultarray[$key]['price'] = $listdata->nightlyprice;
						 $resultarray[$key]['night_availabletime'] = str_replace('*|*', ' - ', $listdata->pernight_availablity);
					}

					if(($listdata->hourlyprice=="" || $listdata->hourlyprice==null || $listdata->hourlyprice==0) && ($listdata->booking=='pernight')) {
							$resultarray[$key]['hour_price'] = "";
					} else {
					 	$resultarray[$key]['hour_price'] = $listdata->hourlyprice;

						$hourly_availablity = str_replace('*|*', ' - ', implode(",",array_values(array_filter(explode(',',$listdata->hourly_availablity)))));     

						if(!empty($hourly_availablity))  
						{
							$resultarray[$key]['hours_availabletime'] = $hourly_availablity;
						} else {
							$resultarray[$key]['hours_availabletime'] = ""; 
						}
					}

					$currencydata = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();
					if(!empty($currencydata)){
					$resultarray[$key]['currency_symbol'] =  $currencydata->currencysymbol;	
					$resultarray[$key]['currency_code'] =  $currencydata->currencycode;
					}	
					$resultarray[$key]['currency_id'] = $listdata->currency;
					$resultarray[$key]['security_deposit'] = $listdata->securitydeposit;
					if($listdata->bookingstyle == "instant")
						$resultarray[$key]['instant_book'] = "true"; 
					elseif($listdata->bookingstyle == "request")
						$resultarray[$key]['instant_book'] = "false"; 
				
					$photos = Photos::find()->where(['listid'=>$listid])->all();
				
					foreach($photos as $keyphoto => $photo)
					{
						$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photo->image_name);
						$resultarray[$key]['photos'][$keyphoto]['image_org'] = $image_url;				
					}
					
					$hometype = $listdata->getHometype0()->where(['id'=>$listdata->hometype])->one();
					$resultarray[$key]['property_id'] = $listdata->hometype;
					$resultarray[$key]['property_name'] = (isset($hometype->hometype)) ? $hometype->hometype : '';
					
					$roomtype = $listdata->getRoomtype0()->where(['id'=>$listdata->roomtype])->one();
					$resultarray[$key]['room_id'] = $listdata->roomtype;
					$resultarray[$key]['room_name'] = $roomtype->roomtype;
					
					$resultarray[$key]['accommodates'] = $listdata->accommodates;
					$resultarray[$key]['bedrooms'] = $listdata->bedrooms;
					$resultarray[$key]['beds'] = $listdata->beds;
					$resultarray[$key]['bathrooms'] = $listdata->bathrooms;
					$countrydata = Country::find()->where(['id'=>$listdata->country])->one();
					$resultarray[$key]['address'] = $listdata->streetaddress.','.$listdata->city.','.$listdata->state.','.$countrydata->countryname;
					$resultarray[$key]['lat'] = $listdata->latitude;
					$resultarray[$key]['lon'] = $listdata->longitude;
					$resultarray[$key]['minimum_stay'] = $listdata->minstay;
					$resultarray[$key]['maximum_stay'] = $listdata->maxstay;
					$resultarray[$key]['street_address'] = $listdata->streetaddress;
					$resultarray[$key]['city'] = $listdata->city;
					$resultarray[$key]['state'] = $listdata->state;
					$resultarray[$key]['country_name'] = $countrydata->countryname;
					$resultarray[$key]['country_id'] = $listdata->country;


					$resultarray[$key]['country_code'] = ($listdata->country > 0) ? $countrydata->code : ""; 
					$resultarray[$key]['timezone_id'] = "";
					$resultarray[$key]['time_zone'] = "";

					if(isset($listdata->timezone) && trim($listdata->timezone) > 0) {
						$resultarray[$key]['timezone_id'] = $listdata->timezone;
						$timezoneData = Timezone::find()->where(['id'=>$listdata->timezone])->one();
						$resultarray[$key]['time_zone'] = (count($timezoneData) > 0) ? $timezoneData->timezone : "";
					} 

					$resultarray[$key]['video_url'] = $listdata->youtubeurl;
					$resultarray[$key]['cleaning_fee'] = $listdata->cleaningfees;
					$resultarray[$key]['service_fee'] = $listdata->servicefees;
					$resultarray[$key]['zipcode'] = $listdata->zipcode;
					/*$resultarray[$key]['fire_extinguisher'] = $listdata->fireextinguisher;
					$resultarray[$key]['fire_alarm'] = $listdata->firealarm;
					$resultarray[$key]['gas_shutoff'] = $listdata->gasshutoffvalve;	
					$resultarray[$key]['emergency_instruction'] = $listdata->emergencyexitinstruction;
					$resultarray[$key]['emergency_medical'] = $listdata->medicalno;
					$resultarray[$key]['emergency_fire'] = $listdata->fireno;
					$resultarray[$key]['emergency_police'] = $listdata->policeno;*/ 
					$resultarray[$key]['availability'] = $listdata->bookingavailability;
					$resultarray[$key]['security_deposit'] = $listdata->securitydeposit;
					$resultarray[$key]['weekend_fee_status'] = $listdata->weekendprice;
					$resultarray[$key]['cancellation_policy'] = $listdata->cancellation;

					if($listdata->weekendprice == 1) {
						$weekendData = Weekendprice::find()->where(['listid'=>$listid])->one();
						if(count($weekendData) > 0){
							$resultarray[$key]['weekend_fee'] = $weekendData->weekend_price;
						} else {
							$resultarray[$key]['weekend_fee'] = 0;
						}
					}	 

					if(isset($listdata->houserules) && $listdata->houserules!="")
					{
						$resultarray[$key]['home_rules'] = $listdata->houserules;
					}

					if($listdata->bookingavailability=="onetime")
					{
						$resultarray[$key]['start_date'] = $listdata->startdate;
						$resultarray[$key]['end_date'] = $listdata->enddate;
					}
					
					$commondata = Commonlisting::find()->where(['listingid'=>$listid])->all();
					$additionaldata = Additionallisting::find()->where(['listingid'=>$listid])->all();
					$specialdata = Speciallisting::find()->where(['listingid'=>$listid])->all();
					$safetydata = Safetylisting::find()->where(['listingid'=>$listid])->all();
					$skey = 0;	
					foreach($commondata as $common)
					{    	
						$commonamenity = $common->getAmenity()->where(['id'=>$common->amenityid])->one();
						$resultarray[$key]['common_amenities'][$skey]['type_id'] = $commonamenity->id;
						$resultarray[$key]['common_amenities'][$skey]['type_name'] = $commonamenity->name;
						$skey++;
					}

					$akey = 0;	
					foreach($additionaldata as $additional)
					{
						$additionalamenity = $additional->getAmenity()->where(['id'=>$additional->amenityid])->one();
						$resultarray[$key]['additional_amenities'][$akey]['type_id'] = $additionalamenity->id;
						$resultarray[$key]['additional_amenities'][$akey]['type_name'] = $additionalamenity->name;
						$akey++;
					}

					$sfkey = 0;
					foreach($specialdata as $special)
					{
						$specialfeature = $special->getSpecial()->where(['id'=>$special->specialid])->one();
						if(isset($specialfeature->name) && isset($specialfeature->specialimage)) {
							$specialfeatures[$specialfeature->id] = $specialfeature->name;
							$resultarray[$key]['safety_features'][$sfkey]['type_id'] = $specialfeature->id;
							$resultarray[$key]['safety_features'][$sfkey]['type_name'] = $specialfeature->name;
							$sfkey++;
						}  
					}

					$sckey = 0;
					foreach($safetydata as $safety)
					{
						$safetycheck = $safety->getSafety()->where(['id'=>$safety->safetyid])->one();
						if(count($safetycheck) > 0) {
							$resultarray[$key]['safety_checklist'][$sckey]['type_id'] = $safetycheck->id;
							$resultarray[$key]['safety_checklist'][$sckey]['type_name'] =  $safetycheck->name;
							$sckey++;
						} 
					}			
			 	}

				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';	
				
			} else {
				echo '{"status":"false","message":"No result found"}';
			}	  	
		} else {
    			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
    	} 
  
   }
	  
	  public function actionAdminlistingproperties(){
	  
	  	$listingproperties = Listingproperties::find()->one();
	 
	  		if(!empty($listingproperties)){
	  			$resultarray['bedrooms'] = $listingproperties->bedrooms;
	  			$resultarray['beds'] = $listingproperties->beds;
	  			$resultarray['bathrooms'] = $listingproperties->bathrooms;
	  			$resultarray['accommodates'] = $listingproperties->accommodates;
	  			
	  			$countrydetails = Country::find()->all();	
	  			if(!empty($countrydetails)){
	  			foreach($countrydetails as $cnkey=>$country){
	  				$resultarray['country'][$cnkey]['id'] = $country->id;
					$resultarray['country'][$cnkey]['name'] = $country->countryname;
				}
				}
	  			
	  			$languages = Languages::find()->all();
				if(!empty($languages))
				{
				foreach($languages as $lkey => $language)
				{
					$resultarray['languages'][$lkey]['id'] = $language->id;
					$resultarray['languages'][$lkey]['name'] = $language->languagename;
				}
				}
				
	  			$timezonedetails = Timezone::find()->all();	
	  			if(!empty($timezonedetails)){
	  			foreach($timezonedetails as $tkey=>$timezone){
	  				$resultarray['time_zone'][$tkey]['id'] = $timezone->id;
					$resultarray['time_zone'][$tkey]['country'] = $timezone->countryname;
					$resultarray['time_zone'][$tkey]['zone'] = $timezone->timezone;
				}
				}
	  			
	  			$currencydetails = Currency::find()->all();	
	  			if(!empty($currencydetails)){
	  			foreach($currencydetails as $curkey=>$currency){
		  			$resultarray['currency'][$curkey]['id'] = $currency->id;
					$resultarray['currency'][$curkey]['code'] = $currency->currencycode;
					$resultarray['currency'][$curkey]['symbol'] = $currency->currencysymbol;
				}
				}
	  			
	  			$hometype = Hometype::find()->all();
	  			if(!empty($hometype)){
	  			foreach($hometype as $hkey=>$htype){
	  			$resultarray['home_type'][$hkey]['id'] = $htype->id;
				$resultarray['home_type'][$hkey]['name'] = $htype->hometype;
				if($htype->priority == NULL)
					$resultarray['home_type'][$hkey]['priority'] = "0";
				else
					$resultarray['home_type'][$hkey]['priority'] = $htype->priority;
				}
				}

				$roomtype = Roomtype::find()->all();
	  			if(!empty($roomtype)){
	  			foreach($roomtype as $rkey=>$rtype){
		  			$resultarray['room_type'][$rkey]['id'] = $rtype->id;
					$resultarray['room_type'][$rkey]['name'] = $rtype->roomtype;
				}
				}
	  			
	  			$model = new Commonamenities();
				$commonamenities = $model->findallidentity();
				if(!empty($commonamenities)){
				foreach($commonamenities as $comkey=>$common){
					$resultarray['common_amenities'][$comkey]['id'] = $common->id;
					$resultarray['common_amenities'][$comkey]['name'] = $common->name;
					$resultarray['common_amenities'][$comkey]['image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/common/'.$common->commonimage);
				}
				}
				
				$model = new Additionalamenities();
				$amenities = $model->findallidentity();
				if(!empty($amenities)){
				foreach($amenities as $adkey=>$additional){
					$resultarray['additional_amenities'][$adkey]['id'] = $additional->id;
					$resultarray['additional_amenities'][$adkey]['name'] = $additional->name;
					$resultarray['additional_amenities'][$adkey]['image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/additional/'.$additional->additionalimage);
				}
				}
				
		 		$safetyfeatures = Specialfeatures::find()->all();
		 		if(!empty($safetyfeatures)){
				foreach($safetyfeatures as $sfkey=>$safety){
					$resultarray['safety_features'][$sfkey]['id'] = $safety->id;
					$resultarray['safety_features'][$sfkey]['name'] = $safety->name;
				}
				}
				
				$safetycheck = Safetycheck::find()->all();
		 		if(!empty($safetycheck)){
				foreach($safetycheck as $skey=>$safety){
					$resultarray['safety_checklist'][$skey]['id'] = $safety->id;
					$resultarray['safety_checklist'][$skey]['name'] = $safety->name;
				}
				}

				$cancellationPolicy = Cancellation::find()->all();
		 		if(!empty($cancellationPolicy)){
					foreach($cancellationPolicy as $skey=>$policy){
						$resultarray['cancellation_policy'][$skey]['id'] = $policy->id;
						$resultarray['cancellation_policy'][$skey]['name'] = $policy->policyname;
						$resultarray['cancellation_policy'][$skey]['cancelfrom'] = $policy->cancelfrom;
						$resultarray['cancellation_policy'][$skey]['cancelto'] = $policy->cancelto;
						$resultarray['cancellation_policy'][$skey]['description'] = $policy->canceldesc;
					}
				}
	  		$result = json_encode($resultarray);
			echo '{"status":"true","result":'.$result.'}';		
    	
			} else {
    			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
    		}
	  
	  }
	  
	public function actionGetreservation(){
    	$Flag = 0;

   		if(isset($_POST['user_id']) && isset($_POST['recent']) && trim($_POST['user_id']) > 0 && trim($_POST['recent']) >= 0 && trim($_POST['recent']) <=2) {
			$userid = trim($_POST['user_id']);
			$recent = trim($_POST['recent']);
			$userform = new SignupForm();
			$userdata = $userform->findIdentity($userid);

			if(count($userdata) > 0 && $userdata->hoststatus == "1") {
 				$model = new Reservations();   				
 				$resultarray = array();
 				
 				$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
 				$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;
 				
 				$todaydate = date('m/d/Y');
 				$today = strtotime($todaydate);
    				
 				if($recent == 1) {
 					$query = Reservations::find()->where(['>=','todate',$today])
 							->andWhere(['hostid'=>$userid])
 							->andWhere(['=','bookstatus','requested'])->orderBy('id desc');
 				} elseif($recent == 2) {
 					$query = Reservations::find()->where(['<','todate',$today])
 						->andWhere(['hostid'=>$userid])
 						->andWhere(['!=','bookstatus','requested'])->orderBy('id desc');
 				} elseif($recent == 0) {
 					$query = Reservations::find()->where(['hostid'=>$userid])->orderBy('id desc');
 				}
    			$reservations = $query->offset($offset)->limit($limit)->all();

				if(!empty($reservations)) {
					foreach($reservations as $key => $reserve) {					
						$resultarray[$key]['id'] = $reserve->inquiryid; 
						$resultarray[$key]['order_id'] = $reserve->id;
						$resultarray[$key]['status'] = ucfirst($reserve->bookstatus);    
						$resultarray[$key]['duration_type'] = $reserve->booking;
						$resultarray[$key]['price'] = $reserve->pricepernight;
						$resultarray[$key]['guest_count'] = $reserve->guests;
						$resultarray[$key]['security_deposit'] = $reserve->securityfees;
						$resultarray[$key]['service_fee'] = $reserve->servicefees;
						$resultarray[$key]['grand_total'] = $reserve->total;
						$resultarray[$key]['host_id'] = $reserve->hostid;

						$hostdata = $reserve->getHost()->where(['id'=>$reserve->hostid])->one();
						$resultarray[$key]['host_name'] = $hostdata->firstname.' '.$hostdata->lastname;

						$usrimg = $hostdata->profile_image;
						if($usrimg=="")
							$usrimg = "usrimg.jpg";
						$userimage =Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$usrimg);
						$resultarray[$key]['host_image'] = $userimage;

						$resultarray[$key]['guest_id'] =  $reserve->userid;
						$guestdata = $reserve->getUser()->where(['id'=>$reserve->userid])->one();
						$resultarray[$key]['guest_name'] = $guestdata->firstname.' '.$guestdata->lastname;
						$usrimg = $guestdata->profile_image;
						if($usrimg=="")
							$usrimg = "usrimg.jpg";
						$userimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$usrimg);
						$resultarray[$key]['guest_image'] = $userimage;					
						
						$listid = $reserve->listid;
						$resultarray[$key]['list_id'] = $listid;
							
						$listdata = Listing::find()->where(['id'=>$listid])->one();
						$resultarray[$key]['list_name'] = $listdata->listingname;
						
						$resultarray[$key]['block'] = ($listdata->liststatus == 2) ?"yes":"no"; 

						$photos = Photos::find()->where(['listid'=>$listid])->all(); 
						$image_url = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/listings/'.$photos[0]->image_name);
						
						$resultarray[$key]['list_image'] = $image_url;

						if($reserve->booking=='perhour') {
							$resultarray[$key]['booked_time'] = str_replace('*|*', ' - ', $reserve->hourly_booked);
						} else {
							$resultarray[$key]['night_availabletime'] = str_replace('*|*', ' - ', $reserve->hourly_booked); 
						}
	    				$resultarray[$key]['check_in'] = strtotime($reserve->checkin); 
	    				$resultarray[$key]['check_out'] = strtotime($reserve->checkout);
		    					
	    				$countrydata = Country::find()->where(['id'=>$listdata->country])->one();
						$resultarray[$key]['address'] = $listdata->streetaddress.','.$listdata->city.','.$listdata->state.','.$countrydata->countryname;
						
						if($reserve->bookstatus == "accepted" && $reserve->todate <= $today)
							$resultarray[$key]['instant_book'] = "true";
						else 
							$resultarray[$key]['instant_book'] = "false";
							
						$hostid = $reserve->hostid;
						$reserveid = $reserve->id;
						$todate = $reserve->checkout;
						$resultarray[$key]['enable_claim'] = "false";

						$currentTimezone = Myclass::getTime($reserve->timezone); 
						date_default_timezone_set('UTC');  
						
						if(strtotime($todate) < strtotime($currentTimezone) && $reserve->bookstatus=="accepted" && isset($reserve->securityfees) && $reserve->securityfees!="" && $reserve->securityfees > 0 && $reserve->claim_status==NULL)
						{
							$checkoutDate = $reserve->checkout;
							$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
							$payoutDue = json_decode($sitesetting->stripe_card_details, true);
							if(trim($payoutDue['stripe_hostpaydays']) > 2)
								$payoutDue = trim($payoutDue['stripe_hostpaydays']); 
							else
								$payoutDue = 2;
							$payoutDue = "+".$payoutDue." days";
							$payoutDue = date("m/d/Y H:i:s",strtotime($checkoutDate.$payoutDue));

							if((strtotime($checkoutDate) <= strtotime($currentTimezone)) && (strtotime($currentTimezone) <= strtotime($payoutDue))) {
								$resultarray[$key]['enable_claim'] = "true"; 
							}
						}						
					}
					$Flag = 1;
					$result = json_encode($resultarray);
					echo '{"status":"true","result":'.$result.'}'; 
				} 
			} 
    	} 
    	if($Flag == 0)
    		echo '{"status":"false","message":"No result found"}'; 
   }
       	   		
   public function actionAdddeviceid() {
		$deviceId = $_POST['device_id'];
		$userid = $_POST['user_id'];
		$deviceToken = $_POST['device_token'];
		$devicetype = $_POST['device_type'];
		$devicemode = $_POST['device_mode'];

		$userdevicedatas = Userdevices::find()->where(['deviceId'=>$deviceId])->one();
         
      if(isset($deviceId) && trim($deviceId)!=''){
			if (isset($devicetype)){        
				if(!empty($userdevicedatas)){
				  	if (isset($devicetype)) {
						$userdevicedatas->deviceId = $deviceId;
						$userdevicedatas->user_id = $userid;
						$userdevicedatas->type =  $devicetype;
						$userdevicedatas->mode = $devicemode;
						$userdevicedatas->save(false);
					}
               if (isset($deviceToken)){
						$userdevicedatas->deviceId = $deviceId;
						$userdevicedatas->user_id = $userid;
						$userdevicedatas->deviceToken =  $deviceToken;
						$userdevicedatas->mode = $devicemode;
						$userdevicedatas->save(false);
               }
					                 
				} else {
					$newdevice = new Userdevices();
					$newdevice->deviceId = $deviceId;
					$newdevice->user_id = $userid;
					$newdevice->deviceToken = $deviceToken;
					$newdevice->type =  $devicetype;
					$newdevice->mode = $devicemode;
					$newdevice->cdate = time();
					$newdevice->save(false);
				}
				echo '{"status":"true","result":"Registered successfully"}';
			}
		} else {
			echo '{"status":"false","result":"Something went wrong, please try again later"}';
		}

	} 
                
   public function actionPushsignout() {
       	
		$deviceId = $_POST['device_id'];
	              
		if(isset($deviceId) && trim($deviceId)!=''){
			$userdevice = Userdevices::find()->where(['deviceId'=>$deviceId])->one();
			$userdevice->delete();
			echo '{"status":"true","result":"Unregistered successfully"}';
		} else {
		 	echo '{"status":"false","result":"Something went wrong, please try again later"}';
		}
   }	
       
   public function actionHelp() {
		$help_pages = Help::find()->all(); 
		
		if(!empty($help_pages)){
			foreach($help_pages as $key=>$help){
				$resultarray[$key]['help_id'] = $help->id;
			 	$resultarray[$key]['title'] = $help->name;
			 	
			 	//echo $help->maincontent; exit;
				$maincontent = $help->maincontent;
				//$maincontent = strip_tags(str_replace("\r\n","",$maincontent));
				$subcontent = $help->subcontent;
				//$subcontent = strip_tags(str_replace("\r\n","",$subcontent));
			 	$resultarray[$key]['main_content'] = str_replace("\r\n","",$maincontent);
			 	$resultarray[$key]['sub_content'] = str_replace("\r\n","",$subcontent);
			}
			$result = json_encode($resultarray);
			echo '{"status":"true","result":'.$result.'}';		
		} else {
			echo '{"status":"false","message":"No result found"}';
		}
	}
		
	public function actionChangepassword() {
		$userid = $_POST['user_id'];
		$oldpwd = $_POST['old_password'];
		$newpwd = $_POST['new_password'];

		$signupmodel = new SignupForm ();
		$userdata = $signupmodel->findIdentity ( $userid );
				
		if($userdata->password == base64_encode($oldpwd)){
			$userdata->id = $userid;
			$userdata->password = base64_encode ( $newpwd );
			$userdata->save ();
			echo '{"status":"true","result":"Password changed successfully"}';
		}else{
			echo '{"status":"false","message":"Old password incorrect"}';
		}
	}
		  	
	public function actionChangeuserimage(){
		  		
  		if(isset($_POST['user_id']) && isset($_POST['user_image']) && !empty($_POST['user_image']) && !empty($_POST['user_id'])) {
  				$userid = $_POST['user_id'];
  				$userimg = $_POST['user_image'];
  				
  			$signupmodel = new SignupForm ();
			$userdata = $signupmodel->findIdentity ( $userid );
			$userdata->id = $userid;
			$userdata->profile_image = $userimg;
			$userdata->save ();
		
  			echo '{"status":"true","result":"User image updated successfully"}';
  		} else {
  			echo '{"status":"false","result":"Sorry, Something went to be wrong"}';
  		}
  	}
		  	
	public function actionAdmindata(){
		$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
		$homesettings = Homepagesettings::find()->where(['id'=>'1'])->one();
		$helppages = Help::find()->all(); 
		if(!empty($sitesettings)){
			$footercontent = json_decode($sitesettings->footercontent,true);
			foreach($helppages as $helps){
				$resultarray[$helps->name] = Yii::$app->urlManager->createAbsoluteUrl('/user/help/view?id='.$helps->id);
			}
			$defaultCurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one(); 
			$resultarray['country_code']=$defaultCurrency->countrycode;
			$resultarray['hourly_book']=$sitesettings->hour_booking;
			$resultarray['contact_details']['address'] = $footercontent['address'];
			$resultarray['contact_details']['phone'] = $footercontent['phone'];
			$resultarray['contact_details']['email'] = $footercontent['email'];
			$maincontent = strip_tags($homesettings['main_termsandconditions']);
			$maincontent = str_replace("\r\n","",$maincontent);
			$subcontent = strip_tags($homesettings['sub_termsandconditions']);
			$subcontent = str_replace("\r\n","",$subcontent);						
			$resultarray['terms_conditions']['main_content'] = str_replace("\r\n","",$homesettings['main_termsandconditions']);
			$resultarray['terms_conditions']['sub_content'] = str_replace("\r\n","",$homesettings['sub_termsandconditions']);
				$sitecharges = Sitecharge::find('all')->all();
			foreach($sitecharges as $key => $sitecharge)
			{
				$resultarray['service_fee'][$key]['min_value'] = $sitecharge->min_value;
				$resultarray['service_fee'][$key]['max_value'] = $sitecharge->max_value;
				$resultarray['service_fee'][$key]['percentage'] = $sitecharge->percentage;	
			}
			$result = json_encode($resultarray);
			echo '{"status":"true","result":'.$result.'}';		
		}else{
			echo '{"status":"false","result":"Sorry, Something went to be wrong"}';
		}

	}
		  	       
	public function actionReservationipnprocess() {
		if(isset($_POST['user_id']) && isset($_POST['type']) && (trim($_POST['type'])=="reservation" || trim($_POST['type'])=="inquiry")) {
	      $callType = trim($_POST['type']);
	      $loguserid = trim($_POST['user_id']);

	      $userdata = User::find()->where(['id'=>$loguserid])->one(); 
	      $paycurrency = "";
	      if($userdata->currency_mobile > 0) {
	      	$currencydata = Currency::find()->where(['id'=>$userdata->currency_mobile])->one();
	      	$paycurrency = $currencydata->currencycode;
	      }

	      if((count($_POST) < 7 && $callType == "reservation") || (count($_POST) < 4 && $callType == "inquiry") || !isset($_POST['paytoken']) || count($userdata) == 0 || empty($paycurrency)) {  
	         echo '{"status":"false","message":"Sorry, Something went to be wrong 1"}';
	      } else {
	         $total_period = 0;
	         $booking_timing = "";
	         $inquiryId = "";

	         if($callType == "inquiry") {
	            $inquiryId = trim($_POST['id']);
	            $inquiryData = Inquiry::find()->where(['id'=> $inquiryId])->one();

	            if(count($inquiryData) > 0 && $loguserid == $inquiryData->senderid && $inquiryData->type=="inquiry") {
	               $listdata = Listing::find()->where(['id'=>$inquiryData->listingid])->one();

	               if(count($listdata) > 0 && $listdata->userid == $inquiryData->receiverid) {
	                  $guests = trim($inquiryData->guest);
	                  $listid = trim($inquiryData->listingid);
	               
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
	                  echo '{"status":"false","message":"Sorry, Something went to be wrong 2"}';
	                  die;
	               }
	            } else {
	              	echo '{"status":"false","message":"Sorry, Something went to be wrong 3"}';
	              	die;
	            }
	         } else {
	         	$listid = trim($_POST['list_id']);
	            $listdata = Listing::find()->where(['id'=>$listid])->one();
	            $guests = trim($_POST['guest_count']);
	            $start_date = trim($_POST['start_date']);
	            $end_date = trim($_POST['end_date']);

	            if($listdata->booking == "perhour") {
	               $booking_timing = (isset($_POST['booking_timing'])) ? trim($_POST['booking_timing']):"";
	               $bookingTiming = explode('-',$booking_timing);
	               // if need please check booking time to list hourly time
	               if(count($bookingTiming) == 2) {
	                  $fromtime = strtotime($start_date." ".$bookingTiming[0]);
	                  $totime = strtotime($end_date." ".$bookingTiming[1]);
	                  $total_period = round(($totime - $fromtime)/3600, 1);
	                  $booking_timing = date("H:i",$fromtime)."-".date("H:i",$totime); 
	               }             
	            } else {
	               $fromtime = date('m/d/Y', strtotime($start_date));
	               $totime = date('m/d/Y', strtotime($end_date));
	               $total_period = strtotime($totime) - strtotime($fromtime);
	               $total_period =  round($total_period / (60 * 60 * 24));
	            }
	         }

	         if($total_period <= 0 || $guests <= 0) {
	            echo '{"status":"false","message":"Sorry, Something went to be wrong 4"}';
	            die;
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
				   echo '{"status":"false","message":"Sorry, Booked dates are not available"}'; 
				   die; 
				} 

				for ($pDate=strtotime($start_date); $pDate <= strtotime($weDate); $pDate+=86400) {
				    $a_day = (strtolower(date('l', $pDate))); 
				    if($a_day == "friday" || $a_day == "saturday") {
				        ++$weekend_count;
				    }
				}

	         $specialPriceVal = json_decode($listdata->specialprice);
	         if($listdata->splpricestatus == 1 && !empty($listdata->specialprice) && count($specialPriceVal) > 0) 
	         {
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

	         $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one(); 
	         $currencydata = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();

            if($paycurrency == $currencydata->currencycode) {
               $rate = "1";    $rate2 = "1";    $convert_rate = "1";
            } else {
               //listing currency
               $rate2= Myclass::getcurrencyprice($currencydata->currencycode);
               //user currency
               $rate= Myclass::getcurrencyprice($paycurrency);
               // Convert Rate
               $convert_rate = $rate2 / $rate;
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

	         //$totalamount = $taxamount + $siteamount + $commissionamount + $listtotalprice + $securitydeposit + $servicefees + $cleaningfees;

	         $tax_amount = round($rate * ($taxamount/$rate2),2);
	         $site_amount = round($rate * ($siteamount/$rate2),2);
	         $commission_amount = round($rate * ($commissionamount/$rate2),2);
	         $security_deposit = round($rate * ($securitydeposit/$rate2),2);
	         $service_fees = round($rate * ($servicefees/$rate2),2);
	         $cleaning_fees = round($rate * ($cleaningfees/$rate2),2);

	         $list_totalprice = round($rate * ($listtotalprice/$rate2),2);

	         $totalamount = $tax_amount + $site_amount + $commission_amount + $list_totalprice + $security_deposit + $service_fees + $cleaning_fees;

	         if($paycurrency == "JPY" || $paycurrency == "jpy"){
	         	// JPY - If added in Stripe, Calculate amount as mentioned.
	            $payamout = ceil($totalamount);
	            $totalamount = ceil($totalamount);
	         } else {
	            $payamout = $totalamount * 100;
	            $totalamount = $totalamount;
	         }

	         $paytoken = trim($_POST['paytoken']);  

		      //Stripe api key
		      $stripe = array(
		       "secret_key"      => $sitesettings->stripe_secretkey,
		       "publishable_key" => $sitesettings->stripe_publishkey
		      );

		      \Stripe\Stripe::setApiKey($stripe['secret_key']);

		      if($userdata->stripe_customer_id == NULL || empty($userdata->stripe_customer_id)) {
		        //add customer to stripe
		        $customer = \Stripe\Customer::create(array(
		           'email' => $userdata->email,
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
		         'description' => 'charge from '.$userdata->email
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

	            if(count($inquiryAll) == 0 || ($callType == "reservation" && (count($inquiryAll) == $reserveCount))) {
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
	            $reservation->fromdate = strtotime(trim($start_date));
	            $reservation->todate = strtotime(trim($end_date)); 
	            $reservation->checkin = $checkInDateTime;
	            $reservation->checkout = $checkOutDateTime;
	            $reservation->guests = $guests;
	            $reservation->booking = $listdata->booking;
	            $reservation->timezone = $listdata->timezone;   

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

	            $reservation->convertedcurrencycode = $paycurrency; 
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

            	$hostdata = User::find()->where(['id'=>$listdata->userid])->one();
	            $hostnotifications = json_decode( $hostdata->notifications,true );
	            $hostemails = json_decode( $hostdata->emailsettings,true );
	            
	            $usernotifications = json_decode( $userdata->notifications,true );
	            $useremails = json_decode( $userdata->emailsettings,true );

	            if($usernotifications['reservationnotify'] == 1)
	            {
	                $notifyuserid = $listdata->userid;
	                $notifyto = $userdata->id;
	                $notifymessage = "You made a reservation on";
	                $logdatas = $this->addlog('request',$notifyuserid,$notifyto,$listid,$notifymessage,'');
	            }
	            
	            if( $hostnotifications['reservationnotify']==1 )
	            {
	                $notifyhostid = $userdata->id;
	                $notifyto = $listdata->userid;
	                $notifymessage = "There is a reservation made on";
	                $logdatas = $this->addlog('reservation',$notifyhostid,$notifyto,$listid,$notifymessage,'');
	            }

	            $userdevicedet = Userdevices::find()->where(['user_id'=>$listdata->userid])->all();

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
	            }            

	            if($useremails['reservationemail']==1)
	            {
	                Yii::$app->mailer->compose ( 'reservationrequest', [
	                    'name' => $userdata->firstname,
	                    'hostname' => $hostdata->firstname,
	                    'listid' => $listid,
	                    'listingname' => $listdata->listingname,
	                    'reserveid' => $reservation->id,
	                    ] )->setFrom ( $sitesettings->noreplyemail )->setTo ( $userdata->email )->setSubject ( 'You made a reservation' )->send ();              
	            }  
	            if($hostemails['reservationemail']==1)
	            {
	                Yii::$app->mailer->compose ( 'reservationreceived', [
	                    'name' => $hostdata->firstname,
	                    'username' => $userdata->firstname,
	                    'listid' => $listid,  
	                    'listingname' => $listdata->listingname                     
	                    ] )->setFrom ( $sitesettings->noreplyemail )->setTo ( $hostdata->email )->setSubject ( 'Reservation made on your listing' )->send ();
	            } 
	            echo '{"status":"true","message":"Order placed successfully."}';
		      } else {
		      	echo '{"status":"false","message":"Sorry, Something went to be wrong 6"}';
		      }
	      }
	   } else {
	   	echo '{"status":"false","message":"Sorry, Something went to be wrong 7"}';
	   }	 
	}
	   
	public function actionRemove_image()
	{
			$listid = $_POST['list_id'];
			$imageurl = $_POST['image_url'];
			$deletephoto = Photos::find()->where(['listid'=>$listid,'image_name'=>$imageurl])->one();
    		if($deletephoto->delete())
			{
				echo '{"status":"true","message":"Image deleted successfully"}';
			}
			else
			{
				echo '{"status":"false","message":"Sorry, Something went wrong. Please try again later"}';
			}
	}

	public function actionGetreportlist()
	{
	   		$getReports = Profilereports::find()->all();
	   		$resultArray = array();

	   		if(count($getReports) > 0)
	   		{	
	   			foreach($getReports as $key=>$val)
	   			{
					$resultArray[$key]['report_id'] = $val->id;
					$resultArray[$key]['report_name'] =  $val->report;
					$resultArray[$key]['report_des'] = $val->shortdesc;
					$resultArray[$key]['type'] =  $val->report_type;
	   			}	
	   			$result = json_encode($resultArray);
	   			echo '{"status":"true","result":'.$result.'}';	
	   		}else{
	   			echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
	   		}
	   		exit;
	}

	public function actionReportlisting()
	{
		/*
			//Sample post values.
			$_POST['list_id'] = 7;   
			$_POST['user_id'] = 2;
			$_POST['report_id'] = 12;
		*/
		if( isset($_POST['list_id']) && isset($_POST['user_id']) && isset($_POST['report_id']) )
		{
   		$listid = $_POST['list_id'];
   		$userid = $_POST['user_id'];
   		$report_id = $_POST['report_id'];	   			
   		$reportdata = Userreports::find()->where(['userid'=>$userid,'listid'=>$listid, 'reportid'=>$report_id])->one();
   		if(empty($reportdata))
   		{
   			$reportdata = new Userreports();
   			$reportdata->userid = $userid;
   			$reportdata->listid = $listid;
   			$reportdata->reportid = $report_id;
   			$reportdata->report_type = 'list';
   			$reportdata->report_status = '1';
   			$reportdata->status = '1';
   			$reportdata->save();
   			echo '{"status":"true","message":"Listing reported successfully"}';
   		}
   		else
   		{
   			$reportdata->delete();
   			echo '{"status":"true","message":"Listing unreported successfully"}';	   			
   		}
		} 
		else
		{
			echo '{"status":"false","message":"Sorry, Something went wrong. Please try again later"}';
		}
	}



	public function actionReportuser()
	{
		/*
			//Sample post values.
			$_POST['user_id'] = 2;
			$_POST['reportuser_id'] = 60;
			$_POST['report_id'] = 1;
		*/
	   		
		if( isset($_POST['reportuser_id']) && isset($_POST['user_id']) && isset($_POST['report_id']) )
		{
   		$reportuser_id = $_POST['reportuser_id'];
   		$userid = $_POST['user_id'];
   		$report_id = $_POST['report_id'];

   		$reportdata = Userreports::find()->where(['userid'=>$userid,'reporterid'=>$reportuser_id, 'reportid'=>$report_id, 'report_type'=>'profile'])->one(); 

   		if(count($reportdata) == 0) 
   		{
   			$reportdata = new Userreports();
   			$reportdata->userid = $userid;
   			$reportdata->reporterid = $reportuser_id;
   			$reportdata->reportid = $report_id;
   			$reportdata->report_type = 'profile';
   			$reportdata->report_status = '1';
   			$reportdata->status = '1';
   			$reportdata->save();
   			echo '{"status":"true","message":"Successfully Reported"}'; 
   		} else { 
   			$reportdata->delete(); 
   			echo '{"status":"true","message":"Successfully Undo Reported"}';	 
   		}
		}
		else
		{
			echo '{"status":"false","message":"Sorry, Something went wrong. Please try again later"}';
		}
	}

	public function actionCheckavailability()
	{
		$listid=$_POST['list_id'];
		$todaydate = date('m/d/Y');
    	$today = strtotime($todaydate);
		$reservations = Reservations::find()->where(['listid'=>$listid])
				            ->andWhere(['!=','bookstatus','refunded'])
				            ->andWhere(['!=','bookstatus','declined'])
				            ->andWhere(['>','todate',$today])
				            ->all();
		$reservation_count=count($reservations);
		if($reservation_count>0)
		{
			$result='no';
			echo '{"status":"false","canedit":"'.$result.'"}';
		}
		else
		{	$result='yes';
			echo '{"status":"true","canedit":"'.$result.'"}';
		}
	}

	public function actionGetbookingdetails() { 

		$type = (isset($_POST['type'])) ? trim($_POST['type']) : "";
		$user_id = (isset($_POST['user_id'])) ? trim($_POST['user_id']) : "";
		$userdata = User::find()->where(['id'=>$user_id])->one(); 

		if($userdata->currency_mobile > 0)
			$userCurrencyData = Currency::find()->where(['id'=>$userdata->currency_mobile])->one();
		else
			$userCurrencyData = Currency::find()->where(['defaultcurrency'=>1])->one();

		$userCurrency = $userCurrencyData->currencycode;

		if(($type=="reservation" || $type=="inquiry") && (count($userdata) > 0)) {
			$calculateFlag = 0;
			$blockStatus = "disabled";
			$booking_timing = "";

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
			$createdTime = "";

			if($type=="inquiry") {
				$inquiryId = (isset($_POST['id'])) ? trim($_POST['id']) : "";
				$inquiryData = Inquiry::find()->where(['id'=> $inquiryId])->one();
				if(!empty($inquiryData)) {
					$senderid = trim($inquiryData->senderid);
					$hostid = trim($inquiryData->receiverid);
					$listingid = trim($inquiryData->listingid);

					$inquiryType = trim($inquiryData->type);
					$guest_count = trim($inquiryData->guest);

					$reservations = Reservations::find()->where(['inquiryid'=>$inquiryData->id])
                    ->andWhere(['=','userid',$inquiryData->senderid])
                    ->andWhere(['=','hostid',$inquiryData->receiverid])
                    ->andWhere(['=','listid',$inquiryData->listingid])
                    ->one();

               //Any guest Done reservation on requested day
					$listdata = Listing::find()->where(['id'=>$listingid])->one();
					$resultarray['block'] = ($listdata->liststatus == 2) ?"yes":"no"; 

					$durationType = trim($listdata->booking);
					$status = array('accepted','claimed'); 

					if($durationType == "pernight") {
					   $s_datetime = strtotime(date('m/d/Y', strtotime($inquiryData->checkin)));
					   $e_datetime = strtotime(date('m/d/Y', strtotime($inquiryData->checkout.'-1 days')));

					   $otherguestreservations = Reservations::find()->where(['listid'=>$inquiryData->listingid]) 
					   ->andWhere(['or', ['between','fromdate',$s_datetime, $e_datetime], ['between','todate', $s_datetime, $e_datetime]])
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

					if(count($reservations) == 0 && $inquiryType == "inquiry") { 
                  if($listdata->booking == "perhour") {
                      $start_date = date('m/d/Y', strtotime($inquiryData->checkin));
                      $end_date = date('m/d/Y', strtotime($inquiryData->checkout));
                      $fromtime = strtotime($inquiryData->checkin);
                      $totime = strtotime($inquiryData->checkout);
                      $total_period = round(($totime - $fromtime)/3600, 1);
                      $booking_timing = date("H:i",$fromtime)."-".date("H:i",$totime);

                      $createdTime = $inquiryData->cdate;
                  } else {
                      $start_date = date('m/d/Y', strtotime($inquiryData->checkin));
                      $end_date = date('m/d/Y', strtotime($inquiryData->checkout)); 

                      $nightavailabilityTime = explode('*|*', $listdata->pernight_availablity); 
				
							 $startNighthours = $start_date.' '.trim($nightavailabilityTime[0]).":00";
							 $endNighthours = $end_date.' '.trim($nightavailabilityTime[1]).":00";  
				
                      $fromtime = strtotime($startNighthours);
                      $totime = strtotime($endNighthours);  
                      $total_period = strtotime($end_date) - strtotime($start_date);
                      $total_period =  round($total_period / (60 * 60 * 24));

                      $createdTime = $inquiryData->cdate;
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

                  if($user_id == $senderid || $user_id == $hostid) {  
	                  if(count($otherguestreservations) > 0) {
	                  	$resultarray['status'] = ucfirst("not available");
	                  } elseif (strtotime($inquiryData->checkout) < time()) {
	                  	$resultarray['status'] = ucfirst("expired");
	                  } elseif ($blockStatus == "enabled") {
	                  	$resultarray['status'] = ucfirst("blocked");
	                  } else {
	                  	$resultarray['status'] = ucfirst("inquiry"); 
	                  }
	               }

                  $currencyData = Currency::find()->where(['id'=>$listdata->currency])->one();
						$listCurrency = $currencyData->currencycode;

                  $calculateFlag = 1;
					} elseif (count($reservations) > 0 && $inquiryType == "booked") {
						$start_date = date('m/d/Y', $reservations->fromdate);
                  $end_date = date('m/d/Y', $reservations->todate);
                  $fromtime = strtotime($reservations->checkin);
                  $totime = strtotime($reservations->checkout); 
                  $createdTime = strtotime($reservations->cdate);

                  $durationType = $reservations->booking; 
                  $total_period = ($durationType == "pernight") ? $reservations->totaldays : $reservations->totalhours;

                  $booking_timing = ($durationType == "perhour") ? str_replace('-', '*|*', $reservations->hourly_booked):"";
                  
                  $unitprice = $reservations->pricepernight;

                  if($durationType == "perhour") 
                  	$listtotalprice = $reservations->pricepernight * $reservations->totalhours;
                  else
                  	$listtotalprice = $reservations->pricepernight * $reservations->totaldays;

                  $currentTimezone = Myclass::getTime($reservations->timezone);
						date_default_timezone_set('UTC');
                  
                  if($user_id == $senderid) {
	                  if(($reservations->bookstatus == "requested" || $reservations->bookstatus == "accepted") && strtotime($reservations->checkin) > strtotime($currentTimezone)) { 
	                  	$resultarray['cancel_status'] = 'true';
	                  } else {
	                  	$resultarray['cancel_status'] = 'false';	 
	                  }
                 	}

                 	$resultarray['order_id'] = $reservations->id; 

                 	if($user_id == $hostid) {
	                  if($reservations->bookstatus == "requested" && strtotime($reservations->checkin) > strtotime($currentTimezone)) {  
	                  	$resultarray['accept_status'] = 'true';
	                  } else {
	                  	$resultarray['accept_status'] = 'false';	
	                  }
                 	}

                  if($reservations->pricedetails !="" && $reservations->pricedetails !=NULL) {
                      $r_check = json_decode($reservations->pricedetails, true);

                      $pricearray['normal_price'] = $r_check['normal']['price'];  
                      $pricearray['normal_count'] = $r_check['normal']['days']; 
                      $pricearray['special_price'] = $r_check['special_price'];
                      $pricearray['special_count'] = $r_check['special_count'];
                      $pricearray['weekend_price'] = $r_check['week']['price'];
                      $pricearray['weekend_count'] = $r_check['week']['days']; 
                  }

                  $commissionamount = $reservations->commissionfees;
                  $siteamount = $reservations->sitefees; 
                  $taxamount = ($reservations->taxfees >= 0) ? $reservations->taxfees : 0;  
                  $securitydeposit = ($reservations->securityfees >= 0) ? $reservations->securityfees : 0;  
                  $cleaningfees = ($reservations->cleaningfees >= 0) ? $reservations->cleaningfees : 0; 
                  $servicefees = ($reservations->servicefees >= 0) ? $reservations->servicefees : 0; 

                  $currencyData = Currency::find()->where(['currencycode'=>$reservations->currencycode])->one();
						$listCurrency = $currencyData->currencycode;

                  $resultarray['status'] = ucfirst($reservations->bookstatus); 
                  $resultarray['return_amount'] = "";

                  if(($reservations->bookstatus == "refunded" || $reservations->bookstatus == "claimed") && $reservations->orderstatus == "paid") 
                  {
                  	if($user_id == $reservations->userid) {
                  		if(!empty($reservations->other_transaction)) {
                  			$transaction = json_decode($reservations->other_transaction, true);  
                  			$resultarray['return_amount'] = $transaction['amount'] / 100; 
                  		}                  		
                  	} else if($user_id == $reservations->hostid) {
                  		if(!empty($reservations->claim_transaction)) { 
                  			$rate = $reservations->convertedprice;

                  			$transaction = json_decode($reservations->claim_transaction, true); 
                  			$resultarray['return_amount'] = round((($transaction['amount'] / 100)*$rate),2);     
                  		}
                  	}  

                  }

                  if($user_id == $reservations->userid) {
							$rate = $reservations->convertedprice;
							$userCurrencyData = Currency::find()->where(['currencycode'=>$reservations->convertedcurrencycode])->one();

							$taxamount = round(($taxamount/$rate),2);
							$siteamount = round(($siteamount/$rate),2);
							$commissionamount = round(($commissionamount/$rate),2);
							$securitydeposit = round(($securitydeposit/$rate),2);
							$servicefees = round(($servicefees/$rate),2);
							$cleaningfees = round(($cleaningfees/$rate),2);

							$listtotalprice = round(($listtotalprice/$rate),2); 
							$unitprice = round(($unitprice/$rate),2);    
                  } else {
                  	$userCurrencyData = Currency::find()->where(['currencycode'=>$reservations->currencycode])->one(); 

                  } 
                   
					}
					$resultarray['list_name'] = $listdata->listingname;
				} else {
					echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
					die;
				}
			} elseif ($type == "reservation") {
				$listingid = trim($_POST['list_id']);
				$start_date = trim($_POST['start_date']);
				$end_date = trim($_POST['end_date']);
				$booking_timing = trim($_POST['booking_timing']);
				$guest_count = trim($_POST['guest_count']);

				$listdata = Listing::find()->where(['id'=>$listingid])->one();
				$resultarray['block'] = ($listdata->liststatus == 2) ?"yes":"no";  

				$hostid = trim($listdata->userid); 
				$senderid = $user_id;
				$durationType = trim($listdata->booking);

				if($durationType == "perhour") {
					$todaydate = trim(date('m/d/Y')); 
					$bookingtiming = explode('-',$booking_timing);

					$fromtime = $start_date." ".trim($bookingtiming[0]);
					$totime = $end_date." ".trim($bookingtiming[1]); 

					$fromtime = strtotime($fromtime);   
					$totime = strtotime($totime);

					$total_period = round(($totime - $fromtime)/3600, 1);
				} else {
					$start_date = date('m/d/Y', strtotime($start_date));
					$end_date = date('m/d/Y', strtotime($end_date));
					$total_period = strtotime($end_date) - strtotime($start_date);
					$total_period =  round($total_period / (60 * 60 * 24));

					$nightavailabilityTime = explode('*|*', $listdata->pernight_availablity); 

					$startNighthours = $start_date.' '.trim($nightavailabilityTime[0]).":00";
					$endNighthours = $end_date.' '.trim($nightavailabilityTime[1]).":00";  

					$fromtime = strtotime($startNighthours); 
					$totime = strtotime($endNighthours); 
				}
				$currencyData = Currency::find()->where(['id'=>$listdata->currency])->one();
				$listCurrency = $currencyData->currencycode;
				$resultarray['list_name'] = $listdata->listingname;

				$calculateFlag = 1;
			}

			if($calculateFlag == 1) {   
				$total_days = $total_period;
            $weDate = ($durationType== "pernight") ? date("m/d/Y",strtotime($end_date.'-1 days')) : $end_date;

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
                $unitprice = ($listdata->booking == "perhour")?$listdata->hourlyprice:$listdata->nightlyprice; 
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

            $resultarray['stripe_publishkey'] = $sitesetting['stripe_publishkey'];

            if(!empty($listCurrency) && !empty($userCurrency) && $listCurrency != $userCurrency) { 
					//listing currency
					$rate2= Myclass::getcurrencyprice($listCurrency);
					//user currency
					$rate= Myclass::getcurrencyprice($userCurrency);
				} else {
					$rate = "1";    $rate2 = "1";
				}

				$taxamount = round($rate * ($taxamount/$rate2),2);
				$siteamount = round($rate * ($siteamount/$rate2),2);
				$commissionamount = round($rate * ($commissionamount/$rate2),2);
				$securitydeposit = round($rate * ($securitydeposit/$rate2),2);
				$servicefees = round($rate * ($servicefees/$rate2),2);
				$cleaningfees = round($rate * ($cleaningfees/$rate2),2);

				$listtotalprice = round($rate * ($listtotalprice/$rate2),2);
				$unitprice = round($rate * ($unitprice/$rate2),2); 
			}

			$cancellationPolicy = Cancellation::find()->where(['id'=>$listdata->cancellation])->one();
			if(count($cancellationPolicy) > 0) {
				$resultarray['cancellation_type'] = $cancellationPolicy->policyname;
				$resultarray['cancellation_policy'] = $cancellationPolicy->canceldesc;
			}

			$hostdata = User::find()->where(['id'=>$hostid])->one(); 
			if(count($hostdata) > 0) {
				$resultarray['host_name'] = $hostdata->firstname;
				$profileimage = $hostdata->profile_image;
				if($profileimage=="")
					$profileimage = "usrimg.jpg";

				$resultarray['host_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$profileimage); 
				$resultarray['host_id'] = $hostid;
			}

			$guestdata = User::find()->where(['id'=>$senderid])->one(); 
			if(count($guestdata) > 0) {
				$resultarray['guest_name'] = $guestdata->firstname;
				$profileimage = $guestdata->profile_image;
				if($profileimage=="")
					$profileimage = "usrimg.jpg";

				$resultarray['guest_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$profileimage); 
				$resultarray['guest_id'] = $senderid;   
			}

			$grandTotal = $taxamount + $siteamount + $commissionamount + $listtotalprice + $securitydeposit + $servicefees + $cleaningfees; 

			$resultarray['total_days'] = $total_period;  
			$resultarray['start_date'] = $fromtime;
			$resultarray['end_date'] = $totime;   
			$resultarray['duration_type'] = $durationType;
			$resultarray['list_id'] = $listingid;
			$resultarray['booking_time'] = $booking_timing; 
			$resultarray['stay_fee'] = $listtotalprice;
			$resultarray['guest_count'] = $guest_count;    

			$resultarray['average_price'] = $unitprice; 
			$resultarray['commission_fee'] = $commissionamount;
			$resultarray['occupancy_tax'] = $taxamount;
			$resultarray['site_fee'] = $siteamount;
			$resultarray['security_deposit'] = $securitydeposit;
			$resultarray['cleaning_fee'] = $cleaningfees;
			$resultarray['service_fee'] = $servicefees;
			$resultarray['grand_total'] = Myclass::getdecimal($grandTotal);  

			$resultarray['currency'] = $userCurrencyData->currencysymbol;
			$resultarray['list_currency'] = $currencyData->currencysymbol;
			$resultarray['date'] = $createdTime;  

			/*$resultarray['userCurrencyPrice'] = $rate;
			$resultarray['listCurrencyPrice'] = $rate2; 
			$resultarray['userCurrency'] = $userCurrency;
			$resultarray['listCurrency'] = $listCurrency;*/
			
			$result = json_encode($resultarray);  
			echo '{"status":"true","result":'.$result.'}';

		} else {
			echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
		} 
	}

	public function actionReadreview()
	{
		$userid = $_POST['user_id'];
		$listid = $_POST['list_id'];
		//$userid = 2;
		//$listid= 10;

		$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
    	$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;
		
		$resultArray = array();

		$getAllratings = Reviews::find()->where(['listid'=>$listid]);
		$resultcount = count($getAllratings->all());//echo $resultcount;
		//$reviewDetails = $getAllratings->offset($offset)->limit($limit)->all();
		$reviewDetails = $getAllratings->all();   

		//echo '<pre>'; print_r($reviewDetails); exit;

		if(count($reviewDetails) > 0) 
		{

			$averageRatings = Reviews::getRatingbylisting($listid);
			foreach($reviewDetails as $key=>$ratings)
			{
				$userform = new SignupForm ();
	    		$userdata = $userform->findIdentity ( $ratings->userid );   
				
				$resultArray[$key]['reviewer_name'] = $userdata->firstname;
				$resultArray[$key]['reviewer_id'] = "$ratings->userid";
				$resultArray[$key]['reviewer_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$userdata->profile_image);
				$resultArray[$key]['user_review'] = $ratings->review;
				$resultArray[$key]['review_rating'] = $ratings->rating;  
				$resultArray[$key]['review_date'] = strtotime($ratings->cdate);
			} 
			$result = json_encode($resultArray);
			echo '{"status":"true","average_rating":"'.$averageRatings['rating'].'","total_reviews":"'.$averageRatings['n_rating'].'","review":'.$result.'}';
		}else{
			echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
		}
	}


	public function actionReadhostreview()
	{

		$userid = $_POST['user_id'];
		//$userid = 4;


		$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
    	$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;

		//$page = Yii::$app->request->get('page', 1);
    	//$limit = Yii::$app->request->get('per-page', 10);
    	//$from = ($page-1)*$limit; 


    	/* Get overall counts */
		$countquery = new \yii\db\Query;
		$countquery->select(['hts_reviews.id as reviewid', 
					 				  'hts_reviews.rating as rating', 
					 				  'hts_listing.id as listid', 
					 				  'hts_listing.listingname as listname', 
					 				  'hts_reviews.review as reviews', 
					 				  'hts_reviews.userid as userid',
					 				  'hts_reviews.cdate as reviewdate'])  
					        ->from('hts_reviews')
					        ->leftJoin('hts_listing', 'hts_listing.id = hts_reviews.listid')
					        ->where(['=', 'hts_listing.userid', $userid]);
					        $scommand = $countquery->createCommand();
					        $overallcount = $scommand->queryAll(); 

		/* End overall counts */

		$query = new \yii\db\Query;
		$query->select(['hts_reviews.id as reviewid', 
					 				  'hts_reviews.rating as rating', 
					 				  'hts_listing.id as listid', 
					 				  'hts_listing.listingname as listname', 
					 				  'hts_reviews.review as reviews', 
					 				  'hts_reviews.userid as userid',
					 				  'hts_reviews.cdate as reviewdate'])  
					        ->from('hts_reviews')
					        ->leftJoin('hts_listing', 'hts_listing.id = hts_reviews.listid')
					        ->where(['=', 'hts_listing.userid', $userid]);

					       // $query->limit($limit)->offset($offset);
					        $command = $query->createCommand();
				$reviewDetails = $command->queryAll();

		if(!empty($reviewDetails))
		{
			$sum = 0;
			foreach($reviewDetails as $rdata)
			{
				$sum+= $rdata['rating'];
			}
			$resultarray['total_reviews'] = str_replace("'", '', "'".count($overallcount)."'");
			$resultarray['average_rating'] = str_replace("'", '', "'".($sum/count($reviewDetails))."'");
					$getAllratings = array();
				 	foreach($reviewDetails as $key => $reviews)
				 	{
				 		$userform = new SignupForm ();
			    		$userdata = $userform->findIdentity ( $reviews['userid'] );

			    		$reviewertype = (isset($userdata->hoststatus) && $userdata->hoststatus == 1) ? 'host' : 'guest';
			    		
						$resultarray['review'][$key]['reviewer_name'] = $userdata->firstname;
						$resultarray['review'][$key]['reviewer_id'] = $reviews['userid'];
						$resultarray['review'][$key]['reviewer_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$userdata->profile_image);
						$resultarray['review'][$key]['user_review'] = $reviews['reviews'];
						$resultarray['review'][$key]['review_rating'] = $reviews['rating'];
						$resultarray['review'][$key]['review_date'] = strtotime($reviews['reviewdate']);
						$resultarray['review'][$key]['reviewer_type'] = $reviewertype;
						$resultarray['review'][$key]['list_id'] = $reviews['listid'];
						$resultarray['review'][$key]['list_name'] = $reviews['listname'];
				 	}


				 	/*if($limit > count($reviewDetails))
				 	{
				 		$balanceval = $limit-count($reviewDetails);
				 		$reviewbyhost = Reviews::find()->where(['userid'=>$userid])->limit($balanceval)->all();
						$nkey = count($resultarray['review']); 
						foreach($reviewbyhost as $key => $reviews)
						{
								$userform = new SignupForm ();
					    		$userdata = $userform->findIdentity ( $reviews['userid'] );

					    		$listname = Listing::find()->select('listingname')->where(['id'=>$reviews['listid']])->one();
								$resultarray['review'][$nkey]['reviewer_name'] = $userdata->firstname;
								$resultarray['review'][$nkey]['reviewer_id'] = $userid;
								$resultarray['review'][$nkey]['reviewer_image'] = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$userdata->profile_image);
								$resultarray['review'][$key]['review_rating'] = $reviews['rating'];
								$resultarray['review'][$nkey]['user_review'] = $reviews['review'];
								$resultarray['review'][$nkey]['review_date'] = strtotime($reviews['cdate']);
								$resultarray['review'][$nkey]['reviewer_type'] = 'guest';
								$resultarray['review'][$nkey]['list_id'] = $reviews['listid'];
								$resultarray['review'][$nkey]['list_name'] = $listname->listingname;
								$nkey++;
						}
				 	}*/

					$result = json_encode($resultarray);	
					echo '{"status":"true","result":'.$result.'}';
		}else{
			echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
		}
	}

	/*
		Get currency lists.
	*/

	public function actionGetcurrencylist()
	{
		if(!isset($_POST['user_id']))
		{
			echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
			exit;
		}
		$userid = $_POST['user_id'];
		$getCurrencies = Currency::find()->all();
		$getUsers = Users::find()->select('currency_mobile')->where(['id'=>$userid])->one();

		if(trim($getUsers->currency_mobile) == 0 || trim($getUsers->currency_mobile) == '' || trim($getUsers->currency_mobile) == NULL) {
			$defaultcurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one();
			$defaultcurrency = $defaultcurrency->id; 
		} else {
			$defaultcurrency = $getUsers->currency_mobile;
		}

		$resultArray = array();
		if(count($getCurrencies) > 0)
		{	
			foreach($getCurrencies as $key=>$val)
			{
			$resultArray[$key]['currency_id'] = "$val->id";
			$resultArray[$key]['currency_name'] =  $val->currencyname;
			$resultArray[$key]['currency_symbol'] =  $val->currencysymbol;
			$resultArray[$key]['currency_code'] =  $val->currencycode;
			$resultArray[$key]['country_name'] =  $val->countryname;
			$resultArray[$key]['country_code'] =  $val->countrycode;
			}	
			$result = json_encode($resultArray);
			echo '{"status":"true","default_currency":"'.$defaultcurrency.'", "currencylist":'.$result.'}';	
		} else {
			echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
		}
		exit;
	}


	/*
		Change currency
	*/
	public function actionChangecurrency()
	{
		if(!isset($_POST['user_id']) || !isset($_POST['currency_id']))
		{
			echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
			exit;
		}else{

		$userid = $_POST['user_id']; 
		$currencyid = $_POST['currency_id'];
		
		$model = Users::find()->where(['id'=>$userid])->one();
		$model->currency_mobile = $currencyid;
		$model->save(false);
		echo '{"status":"true","message":"Successfully Changed"}';	
		exit;
		}
	}

	public function currencyConvertion($userid, $listid, $listPrice)
	{
		$usersdata = Users::find()->where(['id'=>$userid])->one();
		$getUsercurrency =  $usersdata->getCurrency0()->where(['id'=>$usersdata->currency_mobile])->one();
		if(empty($getUsercurrency))
		{

			$getUsercurrency=Currency::find()->where(['defaultcurrency'=>'1'])->one();
			
			/*$getCountries = $usersdata->getCountry0()->where(['id'=>$usersdata->currency_mobile])->one();
			$getUsercurrency =  $usersdata->getCurrency0()->where(['id'=>$getCountries->code])->one();*/
		}
		$listdata = Listing::find()->where(['id'=>$listid])->one();
		$currency = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();
		$userCurrencycode = $getUsercurrency->currencycode;
		$listCurrencycode = $currency->currencycode;
		$userCurrencyrate = Myclass::getcurrencyprice($userCurrencycode);//user currency
		$listCurrencyrate = Myclass::getcurrencyprice($listCurrencycode);//listing currency
		return $getConvertionprice = round(($userCurrencyrate * ($listPrice/$listCurrencyrate)),2);
	}	

	public function actionCalendar()
	{
		$userid = 0;

		if(isset($_POST['user_id'])) {
			$userid = trim($_POST['user_id']);
		}

		if($userid > 0 && !empty($userid)) {
			$getUsercurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one();
	 		$user_currency_id = $getUsercurrency->id;
	 		$user_currency_code = $getUsercurrency->currencycode;
	 		$user_currency_sym = $getUsercurrency->currencysymbol;
	 		$resultarray = array();

			$userdata = User::find()->where(['id'=>$userid])->one();
			if(count($userdata) > 0 && $userdata->currency_mobile != 0) {
				$user_currency_id = $userdata->currency_mobile;

				if($user_currency_id > 0)
					$getUsercurrency = Currency::find()->where(['id'=>$user_currency_id])->one();
				else
					$getUsercurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one();
				$user_currency_code = $getUsercurrency->currencycode;
				$user_currency_sym = $getUsercurrency->currencysymbol;
			} 

			$userListings = Listing::find()->where(['userid'=>$userid,'liststatus'=>1])->all();
			if(count($userListings) > 0){
				foreach ($userListings as $key => $listing) {
					$resultarray[$key]['list_id'] = $listing->id;
					$resultarray[$key]['list_name'] = $listing->listingname;
					$resultarray[$key]['duration_type'] = $listing->booking;
					$resultarray[$key]['availability'] = $listing->bookingavailability;

					if($listing->booking == "perhour"){
						$resultarray[$key]['price'] = $listing->hourlyprice;
					} else {
						$resultarray[$key]['price'] = $listing->nightlyprice;
					}
			
					if($listing->weekendprice == 1){
						$weekendData = Weekendprice::find()->where(['listid'=>$listing->id])->one();
						if(count($weekendData) > 0) {
							$resultarray[$key]['weekend_fee']=$weekendData->weekend_price;
						}
					} else {
						$resultarray[$key]['weekend_fee'] = 0;
					}

					$reservation = Reservations::find()->where(['listid'=>$listing->id])->andWhere(['>=','fromdate',time()])->all();
					if(count($reservation) > 0) {
						foreach ($reservation as $rkey => $booking) {
								$rarray['booked_dates'][$rkey ]['start_date'] = $booking->fromdate;
								$rarray['booked_dates'][$rkey ]['end_date'] = $booking->todate;
						}
						$resultarray[$key] = array_merge($resultarray[$key], $rarray);
					}

					if($listing->splpricestatus == 1) {
						$rarray = array();
						$rkey = 0;
						if(!empty($listing->specialprice)) {
							$specialpricedata = json_decode($listing->specialprice);
							//$specialpricedata = array_filter($specialpricedata);

							if(count($specialpricedata) > 0 ) {
								foreach ($specialpricedata as $rkeys => $special) {
									if(strtotime($special->specialendDate) >= strtotime(date('m/d/y'))) { 
										$rarray['calendar'][$rkey]['start_date'] = strtotime(trim($special->specialstartDate));
										$rarray['calendar'][$rkey]['end_date'] = strtotime(trim($special->specialendDate));
										$rarray['calendar'][$rkey]['list_status'] = trim($special->liststatus);
										$rarray['calendar'][$rkey]['price'] = trim($special->specialprice);
										$rarray['calendar'][$rkey]['notes'] = $special->note;
										++$rkey;
									}
								}
							}
						} 

						if(!empty($listing->blockedspecialprice)) {
							$specialpricedata = json_decode($listing->blockedspecialprice);

							if(count($specialpricedata) > 0) {
								
								foreach ($specialpricedata as $rkeys=>$special) {
									if(strtotime($special->specialendDate) >= strtotime(date('m/d/y'))) { 
										$rarray['calendar'][$rkey]['start_date'] = strtotime(trim($special->specialstartDate));
										$rarray['calendar'][$rkey]['end_date'] = strtotime(trim($special->specialendDate));
										$rarray['calendar'][$rkey ]['list_status'] = trim($special->liststatus);
										$rarray['calendar'][$rkey ]['price'] = trim($special->specialprice);
										$rarray['calendar'][$rkey ]['notes'] = $special->note;
										++$rkey;
									} 
								}
							}
						}
						$resultarray[$key] = array_merge($resultarray[$key], $rarray); 
					}

				} // End of User Listing Loop 
			}

			$result = json_encode($resultarray);
	   	echo '{"status":"true", "currency":"'.$user_currency_sym.'", "currency_code":"'.$user_currency_code.'", "result":'.$result.'}';	
		}
	}	

	public function actionChangecalendarstatus()
	{
		$userid = 0;
		if(isset($_POST['user_id'])) {
			$userid = trim($_POST['user_id']);
		}

		if(!empty($userid) && $userid!="") {
			$listid = trim($_POST['list_id']);
			$listData = Listing::find()->where(['liststatus'=>1,'id'=>$listid, 'userid'=>$userid])->one();
			
			if(count($listData) > 0) {
				$calendarData = "";
				if(isset($_POST['calendar'])) {
					$calendarData = trim($_POST['calendar']);
				}
				if(!empty($calendarData)) {
					$calendarData = json_decode($calendarData, true);
					
					if(count($calendarData) > 0) {
						$changeNotes = NULL;
						if(isset($_POST['status'])) {
							$changeStatus = trim($_POST['status']);
						}

						if(isset($_POST['price'])) {
							$changePrice = trim($_POST['price']);
						} 

						if(isset($_POST['notes'])) {
							$changeNotes = trim($_POST['notes']);
						}

						$availPrice = json_decode($listData->specialprice);
						$blockPrice = json_decode($listData->blockedspecialprice);


						foreach ($calendarData as $key => $value) {
							//echo '<pre>'; print_r($value); exit;
							$calendarDate = trim($value['date']);
							$calendarDateStatus = trim($value['date_status']);

							if($calendarDateStatus == "available" && count($availPrice) > 0) {
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
								if(count($Temp) > 0){
									$availPrice[] = $Temp;
								}
								$availPrice = array_values($availPrice);
							}

							if($calendarDateStatus == "blocked" && count($blockPrice) > 0) {
								$Temp = array(); 
								foreach ($blockPrice as $akey => $blockVal) {
									$a_startdate = strtotime(trim($blockVal->specialstartDate));
									$a_enddate = strtotime(trim($blockVal->specialendDate));

									// old dates removed and array redefined
									if(($a_startdate == $calendarDate && $a_enddate == $calendarDate) ||($a_enddate <= time())) {
										unset($blockPrice[$akey]);
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
								$blockPrice = array_values($blockPrice);
							}
						}

						foreach ($calendarData as $key => $value) {
							if($changeStatus == "available" || $changeStatus == "blocked") {		
								$Temp = array();
								$Temp['specialstartDate'] = date("m/d/Y",trim($value['date']));
								$Temp['specialendDate'] = date("m/d/Y",trim($value['date']));
								$Temp['liststatus'] = $changeStatus;
								$Temp['specialprice'] = $changePrice;
								$Temp['note'] = $changeNotes;

								if($changeStatus == "available") {
									$availPrice[count($availPrice)] = $Temp;
								} elseif ($changeStatus == "blocked") {
									$blockPrice[count($blockPrice)] = $Temp;
								}
							}
						}

						$availPrice = (isset($availPrice) && !empty($availPrice)) ? json_encode(array_values($availPrice)) : '';
						$blockPrice = (isset($blockPrice) && !empty($blockPrice)) ? json_encode(array_values($blockPrice)) : '';

						$listData->specialprice = $availPrice;
						$listData->blockedspecialprice = $blockPrice;
						$listData->splpricestatus = 1;
						$listData->save(false);

						echo '{"status":"true","message":"Successfully changed"}'; 
					
					} else {
						echo '{"status":"false","message":"Sorry, something went to be wrong"}';
					}
				} else {
					echo '{"status":"false","message":"Sorry, something went to be wrong"}';
				}
			} else {
				echo '{"status":"false","message":"Sorry, something went to be wrong"}';
			}
		} else {
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}

	public function actionWritereview()
	{
		if(isset($_POST['user_id'])) {
			$userid = trim($_POST['user_id']);
		}

		if(isset($_POST['list_id'])) {
			$listid = trim($_POST['list_id']);
		}

		if($userid >= 0 && $listid >= 0) {
			if(isset($_POST['rating'])) {
				$rating = trim($_POST['rating']);
			}

			if(isset($_POST['review'])) {
				$review = trim($_POST['review']);
			}

			if(isset($_POST['reservation_id'])) {
				$reservation_id = trim($_POST['reservation_id']);
			}

			$getReviews = Reviews::find()->where(['reservationid'=>$reservation_id])->one(); 
			if($rating > 0 && $review != "" && $reservation_id > 0) {

				if(count($getReviews) > 0)
				{
					$reviewData = Reviews::find()->where(['id'=>$getReviews->id])->one();	 
				} else {
					$reviewData = new Reviews();
				}
				
				$reviewData->userid = $userid;
				$reviewData->reservationid = $reservation_id;
				$reviewData->rating = $rating;
				$reviewData->review = $review;
				$reviewData->listid = $listid;
				$reviewData->status = 0;
				$reviewData->cdate = date('Y-m-d H:i:s');     
				$reviewData->save( false );
				echo '{"status":"true","message":"Saved successfully"}';
			} else {
				echo '{"status":"false","message":"Sorry, something went to be wrong"}';	
			}
		} else {
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}

	public function actionTypesearch() {
		$userid = 0;
		if(isset($_POST['user_id'])) {
			$userid = trim($_POST['user_id']);
		}

		if(isset($_POST['type'])) {
			$type = trim($_POST['type']);
		}

		$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
    	$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;


		if($userid > 0) {
			if($type == "traverse" || $type == "featured" || $type == "recent") {

				if($type == "traverse") {
					$query = new \yii\db\Query;
					$query->select(['count(hts_reservations.listid) as maxapp', 'hts_reservations.listid as listid', 'hts_listing.*'])->from('hts_reservations')
						->leftJoin('hts_listing', 'hts_listing.id = hts_reservations.listid')
						->where(['>', 'hts_reservations.listid', '0'])
						->andwhere(['=', 'hts_listing.liststatus', '1'])
						->groupBy('hts_reservations.listid')
						->orderBy('maxapp desc');
					$command = $query->createCommand();
					$totalCount = count($command->queryAll());
					$query->limit($limit)->offset($offset);
					$command = $query->createCommand();
					$list = $command->queryAll();   
					$type = "popular_listing";
				}

				if($type == "featured") {
					$query = Listing::find()->where(['featuredlist' => '1', 'liststatus'=>'1']);
					$type = "featured_listing";
					$totalCount = $query->count(); 
					$list = $query->offset($offset)->limit($limit)->all();
				}

				if($type == "recent") {
					$query = Listing::find()->where(['liststatus'=>1])->orderBy('id desc');
					$type = "recently_added";
					$totalCount = $query->count();
					$list = $query->offset($offset)->limit($limit)->all();
				}
				$result= $this->popularlistarray($list, $type);

				$resultData = json_encode($result);
				echo '{"status":"true","result_count":'.$totalCount.',"result":'.$resultData.'}';

			} else {
				echo '{"status":"false","message":"Sorry, something went to be wrong"}';
			}
		} else {
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}


	public function actionTransactionhistory()
	{
		if( (isset($_POST['user_id']) && $_POST['user_id'] != '') && (isset($_POST['option']) && $_POST['option'] != '')) {
			$userId = $_POST['user_id'];
			$limit = (isset($_POST['limit']) && trim($_POST['limit'])!="") ? trim($_POST['limit']) : 10;
    		$offset = (isset($_POST['offset']) && trim($_POST['offset'])!="") ? trim($_POST['offset']) : 0;   
			
			$userdata = Users::find()->where(['id'=>$userId])->one();

			if($userdata->hoststatus == 1 && count($userdata) > 0) { 
				if($_POST['option'] == 0) { //Completed Transaction
					$transactionHistory = Reservations::find()->where(['hostid'=>$userId, 'orderstatus'=>'paid'])->andwhere(['=','bookstatus', 'accepted'])->offset($offset)->limit($limit)->all();	

				} elseif($_POST['option'] == 1) { //Future Transaction
					$status = array('accepted');
					$transactionHistory = Reservations::find()->where(['hostid'=>$userId, 'orderstatus'=>'pending'])->andwhere(['=','bookstatus', 'accepted'])->offset($offset)->limit($limit)->all();	  
				} elseif($_POST['option'] == 2) { //other Transaction
					$status = array('refunded','claimed');
					$transactionHistory = Reservations::find()->where(['hostid'=>$userId, 'orderstatus'=>'paid'])->andwhere(['IN','bookstatus', $status])->andWhere(['!=','claim_transaction', 'NULL'])->offset($offset)->limit($limit)->all();	   
				} else {
					//$status = array('accepted','claimed','refunded','cancelled','declined');
					echo '{"status":"false","message":"No result found"}';
					die;
				}
				
				$resultData = array();
	    		foreach($transactionHistory as $key=>$completedlist)
	    		{
	    			$getInvoicedetails = Reservations::getInvoicedetails($completedlist->id);
	    			$getListdetails = Reservations::getListbyid($completedlist->listid);
	    			$currencydata = Reservations::getCurrencydetail($completedlist->currencycode);
	    			$paycurrency = $completedlist->currencycode;

	    			$userdata = Users::find()->where(['id'=>$completedlist->hostid])->one();

	    			//Paid currency
               $rate2= Myclass::getcurrencyprice($completedlist->convertedcurrencycode);  
               //listing currency
               $rate= Myclass::getcurrencyprice($paycurrency);

			    	$resultData[$key]['orderid'] = $completedlist->id;
			    	$resultData[$key]['grand_total'] = round($rate * ($completedlist->total/$rate2),2);
			    	$resultData[$key]['ordered_date'] = strtotime($completedlist->cdate);
			    	$resultData[$key]['transaction_id'] = $getInvoicedetails->stripe_transactionid;
			    	$resultData[$key]['currency_code'] = $currencydata->currencycode;
			    	$resultData[$key]['currency'] = $currencydata->currencysymbol;
			    	$resultData[$key]['duration_type'] = $completedlist->booking;
			    	if($completedlist->booking == "perhour")
			    		$resultData[$key]['no_of_nights'] = $completedlist->totalhours;
			    	else
			    		$resultData[$key]['no_of_nights'] = $completedlist->totaldays;
			    	$resultData[$key]['no_of_guests'] = $completedlist->guests;
			    	$resultData[$key]['grand_total'] = $completedlist->total;
			    	$resultData[$key]['list_id'] = $completedlist->listid;
			    	$resultData[$key]['list_name'] = $getListdetails->listingname;  
			    	$resultData[$key]['status'] = $completedlist->bookstatus;  

		    		$resultData[$key]['check_in'] = ($completedlist->fromdate < 0 || empty($completedlist->fromdate)) ? NULL : strtotime($completedlist->checkin);

		    		$resultData[$key]['check_out'] = ($completedlist->todate < 0 || empty($completedlist->todate)) ? NULL : strtotime($completedlist->checkout);  
		    		
			    	$userdata = Users::find()->where(['id'=>$completedlist->userid])->one();
			    	$resultData[$key]['guest_name'] = trim($userdata->firstname.' '.$userdata->lastname);

			    	if($completedlist->bookstatus=="accepted" && $completedlist->orderstatus=="paid") {
			    		if($completedlist->claim_transaction != NULL) {
			    			$host_amount = json_decode($completedlist->claim_transaction, true);
			    			$host_amount = $host_amount['amount']/100;
			    			$resultData[$key]['price'] = round($rate * ($host_amount/$rate2),2);
			    		} else {
			    			$resultData[$key]['price'] = 0;
			    		}	
			    	} else if(($completedlist->bookstatus=="accepted"  || $completedlist->bookstatus=="claimed") && $completedlist->orderstatus=="pending") {
			    		 if($completedlist->booking == 'perhour') {
			               $total_listingprice = $completedlist->pricepernight * $completedlist->totalhours;
			            } else if($completedlist->booking == 'pernight') { 
			               $total_listingprice = $completedlist->pricepernight * $completedlist->totaldays;
			            } else {
			               $total_listingprice = $completedlist->pricepernight;
			            }

			            $host_amount = $completedlist->taxfees + $completedlist->cleaningfees + $completedlist->servicefees + $total_listingprice;

			    			//$resultData[$key]['price'] = round($rate * ($host_amount/$rate2),2);
			    			$resultData[$key]['price'] = $host_amount;  
			    	} else if((($completedlist->bookstatus=="refunded") || ($completedlist->bookstatus=="claimed" && ($completedlist->claim_status=="declined" || $completedlist->claim_status=="approved"))) && $completedlist->orderstatus=="paid" && $completedlist->claim_transaction!=NULL)  {
			    		$host_amount = json_decode($completedlist->claim_transaction, true);
			    		$host_amount = $host_amount['amount']/100;
			    		$resultData[$key]['price'] = round($rate * ($host_amount/$rate2),2);
			    	}
			    	
	    		}    
	    		$resultData = json_encode($resultData);
				echo '{"status":"true","result":'.$resultData.'}';
			} else {
				echo '{"status":"false","message":"Sorry, something went to be wrong"}';
			}
		}else{
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		}
	}
	
	public function actionGethostcountry() {
		$userid = ((isset($_POST['user_id']) && $_POST['user_id'] != '')) ? trim($_POST['user_id']) : "";
		if (empty($userid) || $userid < 0) {
			echo '{"status":"false 1","message":"Sorry, something went to be wrong"}';
		} else {
			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
			$stripeHostCountry = json_decode($sitesetting->stripe_host_support_country, true);
			if(!empty($stripeHostCountry) && count($stripeHostCountry) > 0) {
				$userdata = User::find()->where(['id'=>$userid])->one();

				$result = array();
				$result['email'] = $userdata['email'];

				foreach ($stripeHostCountry as $key => $value) {
					$cntry = explode('~', $value);
					$result['country'][$key]['country_code'] = trim($cntry[0]);
					$result['country'][$key]['country_name'] = trim($cntry[2]);
					$result['country'][$key]['currency_code'] = trim($cntry[1]);
				}

				if(($userdata['stripe_account_id']!=NULL && $userdata['stripe_account_id']!="") && ($userdata['stripe_status']!=NULL && $userdata['stripe_status']!="") && ($userdata['stripe_account_info'] !=NULL && $userdata['stripe_account_info'] !="")) {
					$result['account_status'] = ucfirst(trim($userdata['stripe_status'])); 

					$europeanCurrencies = array("EUR", "CHF", "DKK", "NOK", "SEK");
					//Stripe Address Basis
					$excludeLineBasis = array("AT");
					$excludeCityBasis = array("AT", "SG");
					$excludeCodeBasis = array("AT", "IE", "HK");
					$includeStateBasis = array("AU", "US", "IE", "CA");
					$includePersonalIdBasis = array("CA", "US", "HK", "SG");

					$hostAccountId = json_decode($userdata['stripe_account_id'], true);

					if(count($hostAccountId) > 0) {
						$result['account_no'] = $hostAccountId['accountnumber'];
						if(!in_array($cntry[1],$europeanCurrencies)) {
							$result['routing_no'] = $hostAccountId['routingnumber'];
						}
						$result['account_id'] = $hostAccountId['accountid'];

						if($hostAccountId['base']!=""){
							$cntry = explode('~', $hostAccountId['base']);
							$result['country_code'] = $cntry[0];
							$result['currency_code'] = $cntry[1];
							$result['country_name'] = $cntry[2];
						}
					}

					$hostAccountInfo = json_decode($userdata['stripe_account_info'],true);
					if(count($hostAccountInfo) > 0) {
						$result['first_name'] = trim($hostAccountInfo['firstname']);
						$result['last_name'] = trim($hostAccountInfo['lastname']);
						$result['phone'] = trim($hostAccountInfo['phonenumber']);
						$result['date_of_birth'] = trim($hostAccountInfo['birth_month'])."/".trim($hostAccountInfo['birth_day'])."/".trim($hostAccountInfo['birth_year']);
						$result['type'] = trim($hostAccountInfo['type']);

						if(in_array($cntry[0],$includePersonalIdBasis)) {
							$result['personal_id_no'] = trim($hostAccountInfo['personalidnumber']);
						}

						if($cntry[0] == "US") {
							$result['ssn_no'] = trim($hostAccountInfo['ssn_last_four']);
						}

						if($cntry[0] != "AT") {
							if(!in_array($cntry[0],$excludeLineBasis)) {
								$result['address_line_one'] = trim($hostAccountInfo['line1']);
							} else {
								$result['address_line_one'] = "";
							}

							$result['address_line_two'] = ($hostAccountInfo['line2']!="") ? trim($hostAccountInfo['line2']) :"";

							if(!in_array($cntry[0],$excludeCityBasis)) {
								$result['city'] = trim($hostAccountInfo['city']);
							} else {
								$result['city'] = "";
							}

							if(in_array($cntry[0],$includeStateBasis)) {
								$result['state'] = trim($hostAccountInfo['state']);
							} else {
								$result['state'] = "";
							}

							if(!in_array($cntry[0],$excludeCodeBasis)) {
								$result['zipcode'] = trim($hostAccountInfo['postalcode']);
							} else {
								$result['zipcode'] = "";
							}
						}
						if($hostAccountInfo['payouts_enabled'] == 1) {
							$result['payout_status'] = ucfirst("enable");
							$result['payout_schedule'] = ucfirst(trim($hostAccountInfo['payouts_interval'])).' - '.trim($hostAccountInfo['payouts_day'])." day rolling basis"; 
						} else {
							$result['payout_status'] = ucfirst("disable");
						}
						$result['charges_enabled'] = trim($hostAccountInfo['charges_enabled']);	
					}

				}
				
				echo '{"status":"true","result":'.json_encode($result).'}'; 
			} else {
				echo '{"status":"false","result":"Sorry, something went to be wrong"}';
			}
		}
	}

	public function actionCreatehostaccount() {
		
		$userid = ((isset($_POST['user_id']) && $_POST['user_id'] != '')) ? trim($_POST['user_id']) : "";

		// Host Country & Currency Info
		$country_code = ((isset($_POST['country_code']) && $_POST['country_code'] != '')) ? trim($_POST['country_code']) : "";
		$country_name = ((isset($_POST['country_name']) && $_POST['country_name'] != '')) ? trim($_POST['country_name']) : "";
		$currency_code = ((isset($_POST['currency_code']) && $_POST['currency_code'] != '')) ? trim($_POST['currency_code']) : "";	

		if (empty($userid) || $userid < 0) {
			echo '{"status":"false","message":"Sorry, Guest not found"}';
		} elseif (empty($country_code) || empty($country_name) || empty($currency_code)) {
			echo '{"status":"false","message":"Sorry, Country not found"}';
		} else {	
			//Userdata
			$userdata = User::find()->where(['id'=>$userid])->one();
			$hostCountry = ""; $entryFlag = 0; 

			// Site Settings
			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
			
			// Stripe Key
			\Stripe\Stripe::setApiKey($sitesetting['stripe_secretkey']);

			if($userdata['stripe_account_id'] == "") {
				$hostCountry = $country_code."~".$currency_code."~".$country_name;
			} else {
				$hostCountry = json_decode(trim($userdata['stripe_account_id']), true);
				$account = \Stripe\Account::retrieve(trim($hostCountry['accountid']));
				$account = $account->jsonSerialize();

				if($account['payouts_enabled'] == 1 && count($account['verification']['fields_needed']) == 0 && $account['charges_enabled'] == 1 && $account['legal_entity']['verification']['status'] == "verified") {
					$entryFlag = 1;
				}
				$hostCountry = $hostCountry['base'];
			}

			// Stripe supported countries in DB, please don't change until confirmed in STRIPE.
			$stripeHostCountry = json_decode($sitesetting->stripe_host_support_country, true);

			if(in_array($hostCountry,$stripeHostCountry) && $hostCountry != "" && $entryFlag == 0) {
				$cntry = explode('~', $hostCountry);
				$hostCountryName = $cntry[2];
				$hostCountryCode = $cntry[0];
				$hostCurrency = $cntry[1];

				//Declaration
				$exitFlag = 0; $accountnumber =""; $routingnumber ="";

				//Stripe European Currencies
				$europeanCurrencies = array("EUR", "CHF", "DKK", "NOK", "SEK");

				//Stripe Address Basis
				$excludeLineBasis = array("AT");
				$excludeCityBasis = array("AT", "SG");
				$excludeCodeBasis = array("AT", "IE", "HK");
				$includeStateBasis = array("AU", "US", "IE", "CA");
				$includePersonalIdBasis = array("CA", "US", "HK", "SG");

				$hostData = json_decode(trim($userdata['stripe_account_id']));

				//Validation on Post Values
				if(!isset($_POST['account_no']) || trim($_POST['account_no'])=="") {
					$exitFlag = 1;
				} else {
					if($userdata['stripe_account_id'] == "")
						$accountnumber = trim($_POST['account_no']);
				}

				// European Countries doesn't contain routing numbers
				if(!in_array($cntry[1],$europeanCurrencies)) {
					if(!isset($_POST['routing_no']) || trim($_POST['routing_no'])=="") {
						$exitFlag = 1;
					} else {
						if($userdata['stripe_account_id'] == "")
							$routingnumber = trim($_POST['routing_no']);
					}
				}

				if(in_array($cntry[0],$includePersonalIdBasis)) {
					if(!isset($_POST['personal_id_no']) || trim($_POST['personal_id_no'])=="") {
						$exitFlag = 1;
					}
				}

				if($cntry[0] == "US") {
					if(!isset($_POST['ssn_no']) || trim($_POST['ssn_no'])=="" || strlen(trim($_POST['ssn_no'])) != 4 ) {
						$exitFlag = 1;
					}
				}

				if(!isset($_POST['first_name']) || trim($_POST['first_name'])=="" || strlen(trim($_POST['first_name'])) < 3 ) {
					$exitFlag = 1;
				}

				if(!isset($_POST['last_name']) || trim($_POST['last_name'])=="" || strlen(trim($_POST['last_name'])) < 3) {
					$exitFlag = 1;
				}

				if(trim($_POST['birth_year']) > 1900) {
					if(((int) checkdate(trim($_POST['birth_month']), trim($_POST['birth_day']), trim($_POST['birth_year']))) != 1) {
						$exitFlag = 1;
					}
					$checkdob = trim($_POST['birth_year'])."-".trim($_POST['birth_month'])."-".trim($_POST['birth_day']);

					if(date_diff(date_create($checkdob), date_create('today'))->y <= 13 ) {
						$exitFlag = 1;
					} 
				} else {
					$exitFlag = 1;
				}



				if(!isset($_POST['phone']) || trim($_POST['phone'])=="") {
					$exitFlag = 1;
				}

				if($cntry[0] != "AT") {
					if(!in_array($cntry[0],$excludeLineBasis)) {
						if(!isset($_POST['address_line_one']) || trim($_POST['address_line_one'])=="") {
							$exitFlag = 1;
						}
					}

					if(!in_array($cntry[0],$excludeCityBasis)) {
						if(!isset($_POST['city']) || trim($_POST['city'])=="") {
							$exitFlag = 1;
						}
					}

					if(in_array($cntry[0],$includeStateBasis)) {
						if(!isset($_POST['state']) ||trim($_POST['state'])==""){
							$exitFlag = 1;
						}
					}

					if(!in_array($cntry[0],$excludeCodeBasis)) {
						if(!isset($_POST['zipcode']) ||trim($_POST['zipcode'])=="") {
							$exitFlag = 1;
						}
					}
				}

				if($exitFlag == 1) {
					echo '{"status":"false","message":"Sorry! Please check the details"}';
				} else {

					if($userdata['stripe_account_id'] == "") {

						//Bank Token Creation
						$newAccount = array();

						if(!in_array($cntry[1],$europeanCurrencies)) {
							$key = array(
							  	"bank_account" => array(
									"country" => $hostCountryCode,
									"currency" => strtolower($hostCurrency),
									"account_holder_type" => "individual",
									"routing_number" => $routingnumber,
									"account_number" => $accountnumber
							  	)
							);
							if($userdata['stripe_account_id'] == "") {
								$newAccount['accountnumber'] = $accountnumber;
								$newAccount['routingnumber'] = $routingnumber;
							}
						} else {
							$key = array(
							  	"bank_account" => array(
									"country" => $hostCountryCode,
									"currency" => strtolower($hostCurrency),
									"account_holder_type" => "individual",
									"account_number" => $accountnumber
							  	)
							);
							if($userdata['stripe_account_id'] == "") 
								$newAccount['accountnumber'] = $accountnumber;
						}

						$details = $this->stripeException($key, 'token');
						$details = explode('~HTS~', $details);

						if($details[1] == "success") {
							$accountToken = trim($details[0]);
								// Stripe Account Creation
		    				$key =  array(
						      "type" => "custom",
						      "country" => $hostCountryCode,
						      "email" => $userdata['email']
						   );
					  		$details = $this->stripeException($key, 'account');
					  		$details = explode('~HTS~', $details);

					  		if($details[1] == "success") {
						  		$accountId = trim($details[0]);
						  		$newAccount['accountid'] = $accountId;
								$newAccount['base'] = $hostCountry;
								$userdata->stripe_account_id = json_encode($newAccount);
								$userdata->stripe_status = "initialised";
								$userdata->save ();
							} else {
								if(!empty(trim($details[2])))
									echo '{"status":"false","message":"'.$details[2].'"}';
								else
									echo '{"status":"false","message":"'.$details[0].' '.$details[1].'"}';
							}
						} else {
							if(!empty(trim($details[2])))
									echo '{"status":"false","message":"'.$details[2].'"}';
							else
								echo '{"status":"false","message":"'.$details[0].' '.$details[1].'"}';							
						}
					} else {
						$accountId = $hostData['accountid'];
						$accountToken = "";
					}

					if($accountId != "") {
						//Stripe Account Update
						$account = \Stripe\Account::retrieve($accountId);
						$account->legal_entity->first_name = trim($_POST['first_name']);
			      	$account->legal_entity->last_name = trim($_POST['last_name']);
						$account->legal_entity->dob->day = trim($_POST['birth_day']);
						$account->legal_entity->dob->month = trim($_POST['birth_month']);
						$account->legal_entity->dob->year = trim($_POST['birth_year']);
						$account->legal_entity->type= "individual";
						$account->legal_entity->phone_number = trim($_POST['phone']);

						$account->tos_acceptance->date = time();
						$account->tos_acceptance->ip = $_SERVER['REMOTE_ADDR'];	

						if(in_array($cntry[0],$includePersonalIdBasis)) {
							$account->legal_entity->personal_id_number= trim($_POST['personal_id_no']);
						}

						if($cntry[0] == "US") {
							$account->legal_entity->ssn_last_4= trim($_POST['ssn_no']);
						}

						// Stripe Address Update
						if($cntry[0] != "AT") {
							if(!in_array($cntry[0],$excludeLineBasis)) {
								$account->legal_entity->address->line1 = trim($_POST['address_line_one']);
							}

							if(isset($_POST['address_line_two']) && trim($_POST['address_line_two']) != "") {
								$account->legal_entity->address->line2 = trim($_POST['address_line_two']);
							} else {
								$account->legal_entity->address->line2 = NULL;
							}
														
							if(!in_array($cntry[0],$excludeCityBasis)) {
								$account->legal_entity->address->city = trim($_POST['city']);
							}

							if(in_array($cntry[0],$includeStateBasis)) {
								$account->legal_entity->address->state = trim($_POST['state']);
							}

							if(!in_array($cntry[0],$excludeCodeBasis)) {
								$account->legal_entity->address->postal_code = trim($_POST['zipcode']);
							}
							$account->legal_entity->address->country = trim($cntry[0]);
						}

						//Stripe Document Update
						$account->legal_entity->verification->document =  $this->stripeUpload($accountId);
						$account->legal_entity->verification->document_back =  $this->stripeUpload($accountId);

						if($userdata['stripe_status'] == "initialised" && $accountToken!="") { 
							//Custom Account Creation With Token
							$account->external_accounts->create(array("external_account" => $accountToken));
							$userdata->stripe_status = "pending"; 
							$userdata->save ();
						}

						// Account Save Process
						$details = $this->stripeException($account, 'update');
						$details = explode('~HTS~', $details); 

						if($details[1] == "success") {
							// Retrieval
							$account = \Stripe\Account::retrieve($accountId);
    						$details = $account->jsonSerialize();

    						if($details['payouts_enabled'] == 1 && count($details['verification']['fields_needed']) == 0 && $details['charges_enabled'] == 1 && $userdata['stripe_status'] == "pending") 
    						{
	    						$result = array();
	    						
	    						// Retrieve Personal Id Niumber
	    						if(strpos(json_encode($details['legal_entity']), 'personal_id_number_provided') !== false) {
						       	if(trim($details['legal_entity']['personal_id_number_provided']) == 1 ) {
						       		$result['personalidnumber'] = trim($_POST['personal_id_no']);
						       		$result['personalidnumber_status'] = trim($details['legal_entity']['personal_id_number_provided']);
						       	}
						      }
						      // Retrieve SSN
						      if(strpos(json_encode($details['legal_entity']), 'ssn_last_4_provided') !== false && $hostCountryCode == "US") {
						    		if(trim($details['legal_entity']['ssn_last_4_provided']) == 1 ){
						       		$result['ssn_last_four'] = trim($_POST['ssn_no']);
						       		$result['ssn_status'] = trim($details['legal_entity']['ssn_last_4_provided']);
						       	}
						      } 
						      // Retrieve First Name
						      if(strpos(json_encode($details['legal_entity']), 'first_name') !== false) {
						        $result['firstname'] = trim($details['legal_entity']['first_name']);
						      }
						      // Retrieve Last Name
						      if(strpos(json_encode($details['legal_entity']), 'last_name') !== false) {
						        $result['lastname'] = trim($details['legal_entity']['last_name']);
						      }
						      // Retrieve Day
						      if(strpos(json_encode($details['legal_entity']['dob']), 'day') !== false) {
						        $result['birth_day'] = trim($details['legal_entity']['dob']['day']);
						      }
						      // Retrieve Month
						      if(strpos(json_encode($details['legal_entity']['dob']), 'month') !== false) {
						        $result['birth_month'] = trim($details['legal_entity']['dob']['month']);
						      }
								// Retrieve Year
						      if(strpos(json_encode($details['legal_entity']['dob']), 'year') !== false) {
						        $result['birth_year'] = trim($details['legal_entity']['dob']['year']);
						      }
						      // Retrieve Type
						      if(strpos(json_encode($details['legal_entity']), 'type') !== false) {
						        $result['type'] = trim($details['legal_entity']['type']);
						      }
						      // Retrieve Phone Number
						      if(strpos(json_encode($details['legal_entity']), 'phone_number') !== false) {
						        $result['phonenumber'] = trim($details['legal_entity']['phone_number']);
						      }
						      // Retrieve Line
						      if(strpos(json_encode($details['legal_entity']['address']), 'line1') !== false) {
						        $result['line1'] = trim($details['legal_entity']['address']['line1']);
						      }
						      // Retrieve Line optional
						      if(strpos(json_encode($details['legal_entity']['address']), 'line2') !== false) {
						        $result['line2'] = trim($details['legal_entity']['address']['line2']);
						      }
						      // Retrieve City
						      if(strpos(json_encode($details['legal_entity']['address']), 'city') !== false) {
						        $result['city'] = trim($details['legal_entity']['address']['city']);
						      }
						      // Retrieve State
						      if(strpos(json_encode($details['legal_entity']['address']), 'state') !== false) {
						        $result['state'] = trim($details['legal_entity']['address']['state']);
						      }
						      // Retrieve Postal Code
						      if(strpos(json_encode($details['legal_entity']['address']), 'postal_code') !== false) {
						        $result['postalcode'] = trim($details['legal_entity']['address']['postal_code']);
						      }
						      // Retrieve Postal Country
						      if(strpos(json_encode($details['legal_entity']['address']), 'country') !== false) {
						        $result['country'] = trim($details['legal_entity']['address']['country']);
						      }
						      // Retrieve Document Verification Status
						      if(strpos(json_encode($details['legal_entity']['verification']), 'document') !="" && strpos(json_encode($details['legal_entity']['verification']), 'document_back') != "") {
						        $result['documentstatus'] = "verified";
						      } 

	    						$result['charges_enabled'] = $details['charges_enabled'];
	    						$result['created'] = $details['created'];
	    						$result['default_currency'] = $details['default_currency'];
	    						$result['payouts_enabled'] = $details['payouts_enabled'];
	    						$result['payouts_day'] = $details['payout_schedule']['delay_days'];
	    						$result['payouts_interval'] = $details['payout_schedule']['interval'];
	    						$result['account_id'] = $details['id'];

    							$userdata = User::find()->where(['id'=>$userid])->one();
    							$userdata->stripe_status = "verified";
    							$userdata->stripe_account_info = json_encode($result);
								$userdata->save( false );
								echo '{"status":"true","message":"Host Account Created."}';
    						} else {
    							echo '{"status":"false","message":"Account Creation Failed."}'; 
    						}    
    					} else {
    						if(!empty(trim($details[2])))
								echo '{"status":"false","message":"'.$details[2].'"}';
							else
								echo '{"status":"false","message":"'.$details[0].' '.$details[1].'"}';
    					}
					} else {
						echo '{"status":"false","message":"Error occured in account creation"}';   
					}
				}
			} else {
				if($entryFlag == 1)
					echo '{"status":"true","message":"Host account already verified."}';
				else
					echo '{"status":"false","message":"Sorry, try again later"}'; 
			}	
		}
	}

	public function stripeException($data, $key) {
		$account = "";
		try {
			if($key == "token") {
				$account = \Stripe\Token::create($data);
			} elseif ($key == "account") {
				$account =  \Stripe\Account::create($data);
			} elseif ($key == "update") {
				$account = $data->save();
			}
		}
		catch(\Stripe\Error\InvalidRequest $e) {
			return "Invalid request~HTS~error~HTS~".$e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			return "Authentication~HTS~error~HTS~".$e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
		  	return "Network Connection~HTS~error~HTS~".$e->getMessage();
		} catch (\Stripe\Error\Base $e) {
		  	return "Stripe~HTS~error~HTS~".$e->getMessage();
		} catch(Exception $e) {
			return "Stripe~HTS~error~HTS~".$e->getMessage();
		} 

		if(!empty($account)) {
			if($key == "update") {
				return "Update~HTS~success~HTS~ ";
			} else {
				$account = $account->jsonSerialize();
				$token  = $account['id'];
				return $token."~HTS~success~HTS~ ";
			}
		} else {
			return "Account~HTS~error~HTS~ ";
		}
	}

	public function stripeUpload($acctId) {
		$filePath = Yii::$app->basePath."/web/images/success.png";

		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		
		// Stripe Key
		\Stripe\Stripe::setApiKey($sitesetting['stripe_secretkey']);

		$fp = fopen($filePath, 'r');
		$file_obj = \Stripe\FileUpload::create(
			array(
			  "purpose" => "identity_document",
			  "file" => $fp
			),
			array(
			  "stripe_account" => $acctId
			)
		);
		return $file_obj->id;
	}


	public function actionPushraw() { 
		$deviceToken = "fczKkZIj-6k:APA91bEtL4G4u9Sr7nQlTXiRxklCH4wOsWTqvFcMU16JqzE4dpeQD3GOeP-lzNgGF8XS8WWpeGeq6shZ0iyP9KoPAdg_LKEgLzxxrNtlE98LL0mgaSvOgRwA-DzzMmHyFG7XpW_xnlxC"; 
			     
     	if($deviceToken!=""){
         $messages = array();
         $messages['message'] = 'pongal';
			$messages['id'] = "1";
			$messages['type'] = 'accept';
			$messages['senderId'] = "2";
			$messages['receiverId'] = "3"; 

         $fcm_url = 'https://fcm.googleapis.com/fcm/send';
			$setting = Sitesettings::find()->where(['id'=> '1'])->one();
			$message = json_encode($messages);
			$notifytype = "notification";
			$registatoin_ids = array($deviceToken);
			
			$messageToBeSent = array();
			$messageToBeSent['data']['message'] = json_decode($message, true);
			$messageToBeSent['data']['type'] = $notifytype;

			$fcmFields = array(
	             'registration_ids' => $registatoin_ids,
	             'data' => $messageToBeSent
		        ); 

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
			print_r(json_encode($result)."<br><BR>");
			if($result->success == 1) {

			}
         
		}
	}

	public function actionPush() 
	{
		$userdevicedet = Userdevices::find()->all();
		if(count($userdevicedet) > 0 ) {
			foreach($userdevicedet as  $userdevice){
				$userData = User::find()->where(['id'=>$userdevice->user_id])->one(); 
				if(count($userdevicedet) > 0 && $userData->pushnotification == '1'){
			     $deviceToken = $userdevice->deviceToken; 
			     $badge = $userdevice->badge;
			     $badge +=1;
			     $userdevice->badge = $badge;
			     $userdevice->deviceToken = $deviceToken;
			     $userdevice->save(false);
			     	if(isset($deviceToken)){
			         $messages['message'] = 'pongal';
						$messages['id'] = "1";
						$messages['type'] = 'accept';
						$messages['senderId'] = "2";
						$messages['receiverId'] = "3";  
			         Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
			         echo "success <br>";
			     	}
			 	} else {
			 		echo "fail <br>";
			 	}
			}
		} else {
			echo "fail out <br>";
		}	    
	}

	/*
	* Service: Change Reservation Status
	* @inheritdoc
	*/
	public function actionChangereservestatus()
	{
		$userid = (isset($_POST['user_id'])) ? trim($_POST['user_id']) : ""; 
		$loguserdata = User::find()->where(['id'=>$userid])->one(); 

		if(count($loguserdata) > 0) {
			$reservestatus = trim($_POST['status']);
			$reserveid = trim($_POST['id']); 

			$model = new Reservations();
			$reservation = Reservations::find()->where(['id'=>$reserveid])->one();
			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();

			$checkoutDate = $reservation->checkout; 
			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
			$payoutDue = json_decode($sitesetting->stripe_card_details, true);
			if(trim($payoutDue['stripe_hostpaydays']) > 2)
				$payoutDue = trim($payoutDue['stripe_hostpaydays']); 
			else
				$payoutDue = 2;
			$payoutDue = "+".$payoutDue." days";
			$payoutDue = date("m/d/Y H:i:s",strtotime($checkoutDate.$payoutDue)); 


			$currentTimezone = Myclass::getTime($reservation->timezone);
			date_default_timezone_set('UTC');  

			if($reservestatus=="accept" && $reservation->bookstatus=="requested" && $reservation->hostid == $userid && $loguserdata->hoststatus == "1" && (strtotime($currentTimezone) < strtotime($reservation->checkin)) )
			{
			  $reservation->bookstatus = "accepted";
			  $reservation->save();
			  $userid = $reservation->userid;
			  $hostid = $reservation->hostid;
			  $userform = new SignupForm ();
			  $userdata = $userform->findIdentity ( $userid );
			  $hostdata = $userform->findIdentity($hostid);
			  $usernotifications = json_decode($userdata->notifications,true);
			  if($usernotifications['reservationnotify']==1)
			  {
			      $listingid = $reservation->listid;
			      $notifymessage = 'accpted your reservation request';
			      $message = '';
			      $logdatas = $this->addlog('accept',$hostid,$userid,$listingid,$notifymessage,$message);
			  }
			  $listingdata = Listing::find()->where(['id'=>$reservation->listid])->one();
			  $userdevicedet = Userdevices::find()->where(['user_id'=>$userid])->all();
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
							$messages['message'] = 'Your reservation request has been accepted by '.$hostdata->firstname.' at '.$listingdata->listingname;
							$messages['id'] = $reservation->inquiryid;
							$messages['type'] = 'accept';
							$messages['senderId'] = $reservation->hostid;
							$messages['receiverId'] = $reservation->userid; 

			            Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
			          }
			      }
			  }

			  Yii::$app->mailer->compose ( 'reservestatus', [
			      'name' => $userdata->firstname,
			      'sitesetting' => $sitesetting,
			      'listingname' => $listingdata->listingname,
			      'status' => 'accepted',
			      'hostname' => $hostdata->firstname,
			      ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $userdata->email )->setSubject ( 'Your reservation request accepted' )->send ();

			  	echo '{"status":"true","message":"Accepted Successfully."}';
			}
			elseif($reservestatus=="decline" && $reservation->bookstatus=="requested" && $reservation->hostid == $userid && $loguserdata->hoststatus == "1" && (strtotime($currentTimezone) < strtotime($reservation->checkin)) )
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

			              if($usernotifications['reservationnotify']==1) {
			                  $listingid = $reservation->listid;
			                  $notifymessage = 'declined your reservation request';
			                  $message = '';
			                  $logdatas = $this->addlog('decline',$hostid,$userid,$listingid,$notifymessage,$message);
			              }           

			              $listingdata = Listing::find()->where(['id'=>$reservation->listid])->one();
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
			                          Yii::$app->mycomponent->pushnot( $deviceToken,$messages,$badge );
			                      }
			                  }
			              }

			              Yii::$app->mailer->compose ( 'reservestatus', [
			                  'name' => $userdata->firstname,
			                  'sitesetting' => $sitesetting,
			                  'listingname' => $listingdata->listingname,
			                  'status' => 'declined',
			                  'hostname' => $hostdata->firstname,
			                  ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $userdata->email )->setSubject ( 'Your reservation request declined' )->send ();
			              
			              echo '{"status":"true","message":"Declined Successfully."}';
			          } else {
			          	echo '{"status":"false","message":"Sorry, something went to be wrong"}';
			          }
			      } else {
			      	echo '{"status":"false","message":"Sorry, something went to be wrong"}';
			      }
			  	} else {
			  		echo '{"status":"false","message":"Sorry, something went to be wrong"}';
			  	}        
			} elseif($reservestatus=="cancel" && ($reservation->bookstatus=="requested" || $reservation->bookstatus=="accepted") && $reservation->userid == $userid && $loguserdata->userstatus == "1" && (strtotime($currentTimezone) < strtotime($reservation->checkin)) ) {
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
							$reservation->orderstatus = 'paid';
							$reservation->sdstatus = 'paid';
							$reservation->cancelby = "Guest";
				   		$reservation->canceldate = time();
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
							if($hostnotifications['reservationnotify']==1)
							{
							   $listingid = $reservation->listid;
							   $notifymessage = 'cancelled your reservation';
							   $message = '';
							   $logdatas = $this->addlog('cancel',$userid,$hostid,$listingid,$notifymessage,$message);
							}

							$listingdata = Listing::find()->where(['id'=>$reservation->listid])->one();
							$userdevicedet = Userdevices::find()->where(['user_id'=>$hostid])->all();
							if(count($userdevicedet) > 0){
							   foreach($userdevicedet as  $userdevice){
							       $deviceToken = $userdevice->deviceToken;
							       $badge = $userdevice->badge;
							       $badge +=1;
							       $userdevice->badge = $badge;
							       $userdevice->deviceToken = $deviceToken;
							       $userdevice->save(false);
							       if(isset($deviceToken)) {
							       	$messages = array();
							            $messages['message'] = 'Your reservation has been cancelled by '.$userdata->firstname.' at '.$listingdata->listingname;
							            $messages['id'] = $reservation->inquiryid;
											$messages['type'] = 'cancel';
											$messages['senderId'] = $reservation->userid;
											$messages['receiverId'] = $reservation->hostid;  

							           Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
							       }
							   }
							}

							Yii::$app->mailer->compose ( 'reservestatus', [
							   'name' => $hostdata->firstname,
							   'sitesetting' => $sitesetting,
							   'listingname' => $listingdata->listingname,
							   'status' => 'cancelled',
							   'hostname' => $userdata->firstname,
							   ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $hostdata->email )->setSubject ( 'Your reservation cancelled' )->send ();

						   echo '{"status":"true","message":"Cancelled Successfully."}';
						} else {
							echo '{"status":"false","message":"Sorry, something went to be wrong"}'; 
						}
					} else {
						echo '{"status":"false","message":"Sorry, something went to be wrong"}';
					}
				} else {
					echo '{"status":"false","message":"Sorry, something went to be wrong"}';
				}
			} elseif($reservestatus=="claim" && $reservation->bookstatus=="accepted" && $loguserdata->hoststatus == "1" && $reservation->hostid == $userid && (strtotime($checkoutDate) <= strtotime($currentTimezone)) && (strtotime($currentTimezone) <= strtotime($payoutDue))) {    
				$reservation = Reservations::find()->where(['id'=>$reserveid])->one();

				$reservation->bookstatus = "claimed";
				$reservation->claim_status = "pending";   

				$reservation->save(false);
				echo '{"status":"true","message":"Claimed Successfully."}';  
			} else { 
				echo '{"status":"false","message":"Sorry, something went to be wrong"}';
			}
		} else { 
			echo '{"status":"false","message":"Sorry, something went to be wrong"}';
		} 
	}

	public function actionHostaccess() {
		if (isset($_POST['user_id'])) {
			$userId = $_POST['user_id'];
			$model = new SignupForm (); 
			$userdata = $model->findIdentity ( $userId );
			if(!empty($userdata) && $userdata->hoststatus =="0") {
				echo '{"status":"false","message":"Your host access is blocked by admin"}';
			} else {
				echo '{"status":"true","message":"Please add listing"}';  
			}
		}
	}

	public function actionTimezone() {
		$userId = (isset($_POST['user_id']) && trim($_POST['user_id']) > 0) ? trim($_POST['user_id']) : "";
		$countryCode = (isset($_POST['country_code']) && trim($_POST['country_code']) != "") ? trim($_POST['country_code']) : ""; 

		if($userId!="" && $countryCode!="") {
			$timezoneData = Timezone::find()->where(['code' => $countryCode])->all(); 
			$resultarray = array();
			foreach ($timezoneData as $key => $value) {
				$rkey = count($resultarray);
				$resultarray[$rkey]['id'] = $value->id;
				$resultarray[$rkey]['zone'] = $value->timezone; 
			}

			if(count($resultarray) > 0) {
				$result = json_encode($resultarray);
				echo '{"status":"true","result":'.$result.'}';
			} else {
				echo '{"status":"false","message":"Sorry, Something went to be wrong"}';	
			}
		}
	}

	public function actionEmailverification() 
	{
		
		$model = new SignupForm ();
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();

		if (isset($_POST['user_id'])) {
			$userId = $_POST['user_id'];
			$userdata = $model->findIdentity ( $userId );
			if(!empty($userdata) && $userdata->userstatus =="1" && $userdata->emailverify!="1") 
			{ 
				$email = $userdata->email;
				$link = Yii::$app->urlManager->createAbsoluteUrl ( '/verify/' . base64_encode ( $email ) );
				$siteName = $sitesetting->sitename;

				Yii::$app->mailer->compose ( 'verifyemail', [
						'name' => $userdata->firstname,
						'link' => $link,
						'siteName' => $siteName,
						'sitesetting' => $sitesetting,
						] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Verify Email' )->send ();		

					echo '{"status":"true","message":"We\'ve sent you the activation link on your registered email"}';

			} else {
				echo '{"status":"false","message":"Enter valid email"}';
			}
		}		
	}

	public function actionBaseprice() { 
		if (isset($_POST['currency_code'])) {
			$stripe_USD = Myclass::getcurrencyprice('USD'); 
			$list_CUR = Myclass::getcurrencyprice(trim($_POST['currency_code'])); 
			$stripe_money = ceil(($stripe_USD * 10) * ($list_CUR));

			echo '{"status":"true","price":"'.$stripe_money.'"}';  
		} else {
			echo '{"status":"false","message":"Currency Incorrect"}';
		}
	} 

	public function actionCheck() {
	
		$listingdata = Listing::find()->where(['id'=>'62'])->one();
		$userdevicedet = Userdevices::find()->where(['user_id'=>'4'])->all();
		$userform = new SignupForm ();
		$userid = 3;
		$reserveid = 8;
		$reservation = Reservations::find()->where(['id'=>$reserveid])->one();
		$userdata = $userform->findIdentity ( $userid );

		if(count($userdevicedet) > 0){
		   foreach($userdevicedet as  $userdevice){
		       $deviceToken = $userdevice->deviceToken;
		       $badge = $userdevice->badge;
		       $badge +=1;
		       $userdevice->badge = $badge;
		       $userdevice->deviceToken = $deviceToken;
		       $userdevice->save(false);
		       if(isset($deviceToken)) {
		       		$messages = array();
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
 	

}
