<?php

namespace frontend\controllers;

/*
 * This controller controls all the user related actions like signup, login, profile, social logins, forget password
 * and delete account. Any user account related funcitons should be carried outin this controller.
 *
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */
use frontend\models\Listingproperties;

use Yii;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Country;
use frontend\models\Currency; 
use frontend\models\Profile;
use frontend\models\Userinvites;
use frontend\models\Shippingaddress;
use frontend\models\Reservations;
use frontend\models\Sitesettings;
use frontend\models\Homepagesettings;
use frontend\models\Homecountries;
use frontend\models\Buttonsliders;
use frontend\models\Textsliders;
use frontend\models\Timezone;
use frontend\models\Listing;
use frontend\models\Languages;
use frontend\models\Reviews;
use frontend\models\Users;
use frontend\models\Logs; 
use frontend\models\Photos; 
use frontend\models\Userdevices; 
use frontend\models\Roomtype;
use backend\models\Profilereports;
use backend\models\Userreports;
use frontend\components\MyClass;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\Cookie;
use common\models\User;
use yii\data\Pagination;
use yii\authclient\OpenId;
use  yii\web\Session;

//use yii\translatemanager\helpers\Language;

/**
 * User controller
 * - User relates functions
 * Database Tables used in this controller:
 * _user, _lists, _userinvites, _userinvitecredits,_countr
 */
class UsersController extends Controller {
	public $successUrl = 'index';
	/**
	 * @inheritdoc
	 * Yii Frame work default functions
	 */
	public function behaviors() {
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
				]/* ,
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'logout' => [ 
										'post' 
								] 
						] 
				]  */
		];
	}


	
	public function beforeAction($action) {
		$this->enableCsrfValidation = false; 
		if(isset($_COOKIE['email']))
		{
			$model = new SignupForm ();
			$email = base64_decode($_COOKIE['email']); 
			$userdata = $model->findByEmail ( $email );	 		
			Yii::$app->user->login ( $userdata );
		}
		if (!(Yii::$app->user->isGuest)) {
         $loguserid = \Yii::$app->user->identity->id;
         $logUserDetails = User::find()->where(['id' => $loguserid])->One();
         if(isset($logUserDetails->userstatus)) {
             if($logUserDetails->userstatus == "0") {
                 Yii::$app->user->logout(); 
                 setcookie ("email", '');
                 setcookie ("user_id", '');
                 Yii::$app->session->setFlash ( 'success', 'Your account was blocked. Please contact admin' );
                 return $this->redirect(['/']);  
             }
         } else {
             return $this->redirect(['/']); 
         }  
     	}   
		return parent::beforeAction($action);
	}	
	
	/**
	 * @inheritdoc
	 * Yii Frame work default functions
	 */
	public function actions() {
		return [ 
				'error' => [ 
						'class' => 'yii\web\ErrorAction' 
				],
				'captcha' => [ 
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null 
				],
				'auth' => [ 
						'class' => 'yii\authclient\AuthAction',
						'successCallback' => [ 
								$this,
								'successCallback' 
						] 
				],
				'upload' => [ 
						'class' => 'yii\xupload\actions\php\XUploadAction',
						'path' => \Yii::$app->getBasePath () . DIRECTORY_SEPARATOR . 'albums' . DIRECTORY_SEPARATOR . 'images',
						'publicPath' => \Yii::$app->getHomeUrl () . DIRECTORY_SEPARATOR . 'albums' . DIRECTORY_SEPARATOR . 'images',
						'subfolderVar' => "parent_id" 
				] 
		];
	}
	public function actionCreate() {
		$model = new SignupForm ();
		$model = new \yii\xupload\models\XUploadForm ();
		$model->profile_id = '000'; // vk todo testing
		return $this->render ( 'create', [ 
				'model' => $model 
		] );
	}
	
	/**
	 * CallBack Functions for Social Logins
	 *
	 * @param unknown $client        	
	 */
	public function successCallback($client) {
		$model = new SignupForm ();
		$attributes = $client->getUserAttributes ();
		// user login or signup comes here
	//die(print_r($attributes));
	if(isset($attributes['email']) && $attributes['email']!="")
	{
		$email = $attributes['email'];
	}
	else if(isset($attributes['emails'][0]['value']))
	{
		$email = $attributes['emails'][0]['value'];
	}
	else
	{
		Yii::$app->getSession ()->setFlash ( 'success', 'Can not get email address' );
		//return $this->goHome ();
		$email = "";
	}
	if($email!="")
	{
			
			$user = \common\models\User::find ()->where ( [ 
					'email' => $email
			] )->one ();
			if (! empty ( $user )) {
				Yii::$app->user->login ( $user );
			} else {
				// Save session attribute user from FB
				$session = Yii::$app->session;
				$session ['attributes'] = $attributes;
				if(isset($attributes['name']) && !is_array($attributes['name']) && !empty($attributes['name']))
				$model->firstname = $attributes['name'];
				else
				$model->firstname = $attributes ['displayName'];
				$model->email = $email;
				$model->facebookid = $attributes ['id'];
				$model->signup ();
				$link = Yii::$app->urlManager->createAbsoluteUrl ( '/verify/' . base64_encode ( $email ) );

				$models = $model->findByEmail ( $email );
				$imagelink = "https://graph.facebook.com/" . $attributes ['id'] . "/picture?width=150&height=150";
				$header_response = get_headers($imagelink, 1);
				if ( strpos( $header_response[0], "404" ) !== false )
				{

				} 
				else 
				{
					$filename = time().rand(0, 9);
					$newname = $models->id.'_'.$filename.'.'."jpg";
					$path = realpath ( Yii::$app->basePath . "/web/albums/images/users/" ) . "/";
					$contents=file_get_contents($imagelink);
					if($contents==false)
					{
						$ch = curl_init($imagelink);
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
					$models->profile_image = $newname;
					$models->save(false);
				}

				// redirect to form signup, variabel global set to successUrl
				// $this->successUrl = \yii\helpers\Url::to(['signup']);
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
				Yii::$app->user->login ( $models );
			}
		}
	}
	


	public function actionSocial($details) { 
		if($details == "error") {  
				Yii::$app->getSession ()->setFlash ( 'success', 'Error Occur, Try again later');
				return $this->goHome (); 
		} else if($details!="") { 
			$details = json_decode(base64_decode($details),true);

			if(count($details) >= 7 && isset($details['type']) && isset($details['id'])) {  

				$email = (isset($details['email']) && $details['email']!="") ? $details['email']:"";

				if($details['type'] == "google" && $email!="") { 
					$user = \common\models\User::find()->where(['email' => $email])->one();

					if (count($user) > 0) { 
						Yii::$app->user->login($user);
						return $this->goHome(); 
					} else {
						$model = new SignupForm ();

						if(isset($details['first_name']) && !empty($details['first_name']))
							$model->firstname =  str_replace(' ', '', $details['first_name']); 
						else
							$model->firstname = str_replace(' ', '', $details['name']['givenName']);

						$model->email = trim($email);
						$model->googleid = $details['id'];
						$model->signup ();
						$link = Yii::$app->urlManager->createAbsoluteUrl('/verify/'.base64_encode($email));

						$models = $model->findByEmail($email);
						$imagelink = $details['image']['url'];
						$header_response = get_headers($imagelink, 1);
						if(strpos( $header_response[0], "404" ) !== false )
						{	}  
						else 
						{
							$filename = time().rand(0, 9);
							$newname = $models->id.'_'.$filename.'.'."jpg";
							$path = realpath ( Yii::$app->basePath . "/web/albums/images/users/" ) . "/";
							$contents=file_get_contents($imagelink);
							if($contents==false)
							{
								$ch = curl_init($imagelink);
								$fp = fopen($path.$newname, 'wb');
								curl_setopt($ch, CURLOPT_FILE, $fp);
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_exec($ch);
								curl_close($ch);
								fclose($fp);						
							} else { 
								file_put_contents($path.$newname,$contents);
							}
							$models->profile_image = $newname;
							$models->save(false);
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
						Yii::$app->user->login($models); 	
						return $this->goHome(); 
					} 
				} else {
					Yii::$app->getSession ()->setFlash ( 'success', 'Page not found');
					return $this->goHome ();
				}
			} else { 
				Yii::$app->getSession ()->setFlash ( 'success', 'Page not found');
				return $this->goHome ();
			}
		} else {
			Yii::$app->getSession ()->setFlash ( 'success', 'Page not found');
			return $this->goHome ();
		}
	}
	/**
	 * This function Display the Home Page & Used for User Registration
	 * On successful registration sends email and redirects to home page
	 */
	public function actionIndex() {

		if (!(Yii::$app->user->isGuest)) { 
	    	$loguserid = \Yii::$app->user->identity->id;
	    	$logUserDetails = User::find()->where(['id' => $loguserid])->One(); 
	    	if($logUserDetails->userstatus != '1') {  
        		Yii::$app->getSession ()->setFlash ( 'success', 'Sorry user access blocked by admin.' );
        		Yii::$app->user->logout ();
        		return $this->goHome ();     
      	}
    	}

		$homesettings = Homepagesettings::find()->where(['id'=>'1'])->one();
		$buttonsliders = Buttonsliders::find('all')->all();
		$textsliders = Textsliders::find('all')->all();
		$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();

		//Get Most reservation listings.
		$traverselist = Reservations::getMaxreservations();
		$featuredlist = Listing::getListing(); 
		
		$this->layout = "home";
		$model = new SignupForm ( [ 
				'scenario' => 'register' 
		] );
		
		$models = new PasswordResetRequestForm ();
		
		$listings = Listing::find()->where(['liststatus'=>1])
		->andWhere([
					'or', 
				   ['>','nightlyprice','0'],
				   ['>','hourlyprice','0']  
				]) ->orderBy('id desc')->all();  
		
		//$homecountries = Homecountries::find()->limit('7')->all();
		$homecountries = Homecountries::getHomecountries();
		$getRoomtype = Roomtype::findallidentity();

		//To add rating..
		$c=0;
		foreach($traverselist as $getrating)
		{			
			$getreviews = Reviews::getRatingbylisting($getrating['listid']);
			$traverselist[$c]['ratings'] = $getreviews['rating'];
			$traverselist[$c]['n_rating'] =  $getreviews['n_rating'];
			$getReservePhotos = Photos::find()->where(['listid'=>$getrating['listid']])->orderBy('id asc')->one();
			if(count($getReservePhotos) > 0)
				$traverselist[$c]['image_name'] = $getReservePhotos['image_name'];
			$c++;
		}
		
		$listingproperties = Listingproperties::find()->where(['id'=>'1'])->one();
		
		if (Yii::$app->user->isGuest) {
			$userid = "";
			$recentview = "";
		}
		else if (! Yii::$app->user->isGuest) {
			$userid = \Yii::$app->user->identity->id;
			$userdata = User::find()->where(['id'=>$userid])->one();
			if(!empty($userdata->listids) && $userdata->listids != ""){
				$listids = $userdata->listids;
				$list_ids = json_decode($listids, true);
				foreach($list_ids as $list){
					$listid[] = $list;
				}	
				for($i=0;$i<4;$i++)
				{
					if(isset($listid[$i]))
					$recentlistid[] = $listid[$i];
				}
				
				foreach($recentlistid as $key => $list_id){
					$recentview[] = Listing::find()->where(['id'=>$list_id, 'liststatus'=>1])->one(); 
				}

				if(empty($recentview))
				{
					$recentview = "";
				}
			}
			else
			{
				$recentview = "";
			}
		}

		//echo '<pre>'; print_r($recentview); exit;
		
		if(isset($_SESSION['currency_code']) && isset($_SESSION['currency_symbol'])) {
			$_SESSION['currency_code'] = trim($_SESSION['currency_code']);
			$_SESSION['currency_symbol'] = trim($_SESSION['currency_symbol']);
		} else {
			$currencydata = Currency::find()->where(['defaultcurrency'=>1])->one();
			if(count($currencydata)) {
				$_SESSION['currency_code'] = $currencydata->currencycode; 
				$_SESSION['currency_symbol'] = $currencydata->currencysymbol; 				
			}
			else {
				$currencydata = Currency::find()->where(['price'>0])->one();
				$_SESSION['currency_code'] = $currencydata->currencycode; 
				$_SESSION['currency_symbol'] = $currencydata->currencysymbol;  
			}
		}

		return $this->render ( 'index', [ 
				'model' => $model,
				'models' => $models,
				'homesettings' => $homesettings,
				'buttonsliders' => $buttonsliders,
				'textsliders' => $textsliders,
				'sitesettings' => $sitesettings,
				'roomtypes' => $getRoomtype,
				'featuredlist' => $featuredlist,
				'traverselistings'=>$traverselist,
				'listings' => $listings,
				'listingproperties' => $listingproperties,
				'recentview' => $recentview,
				'homecountries' => $homecountries
		] );
	}
	
	/**
	 * Function for Login including validations
	 *
	 * @return mixed
	 */
	public function actionLogin() {
		Yii::$app->controller->enableCsrfValidation = false;
		if (! Yii::$app->user->isGuest) {
			//return $this->goHome ();
		}
		Yii::$app->controller->enableCsrfValidation = false;
		
		$model = new SignupForm ([ 
				'scenario' => 'register' 
		]);
		
		if (!(Yii::$app->user->isGuest)) {
	    	$loguserid = \Yii::$app->user->identity->id;
	    	$logUserDetails = User::find()->where([
            		'id' => $loguserid
            ])->One();
    	}
    	$userEmail = Yii::$app->request->post();
    	$data = "";
    	if(count($userEmail) > 0) {
	    	$userEmail = $userEmail['SignupForm']['email'];
	    	$data = $model->findByEmail ( $userEmail );
	   }

		if ($model->load ( Yii::$app->request->post () ) && $model->login ()) {
			
			if(isset($_SESSION['RedirectCategory']) && isset($_SESSION['RedirectUrl'])) {
	        if(trim($_SESSION['RedirectCategory']) == "Listing") {
	        		$randno = $_SESSION['RedirectUrl'];
	        		$_SESSION['RedirectCategory'] = "";
	        		$_SESSION['RedirectUrl'] = "";  
	            return $this->redirect(['/user/listing/view/'.$randno]);
	        }
	      }
			return $this->goHome (); 		
		}  else if(!empty($data)) { 
			if($data->userstatus == '0'){
				Yii::$app->getSession ()->setFlash ( 'success', 'Your account was blocked. Please contact admin' );
				return $this->goHome (); 

			} else if($data->userstatus == '2'){
				Yii::$app->getSession ()->setFlash ( 'success', 'Moderator cannot use this login' );
				return $this->goHome ();
			}
		} elseif(empty($data)) {
			$this->redirect ('signin');  
		} else {  
			return $this->goHome ();
		}
		
	}
	
	/*
	Displays login page
	*/
	public function actionSignin()
	{
		Yii::$app->controller->enableCsrfValidation = false;

		if (!(Yii::$app->user->isGuest)) {
	    	$loguserid = \Yii::$app->user->identity->id;
	    	$logUserDetails = User::find()->where([
            		'id' => $loguserid
            ])->One();
			return $this->goHome (); 
    	}


		$model = new SignupForm ( [
				'scenario' => 'register'
				] );
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		$models = new PasswordResetRequestForm ();		
		return $this->render('login',[
				'model' => $model,
				'models' => $models,
				'sitesetting' => $sitesetting
				]);		
	}
	
	/**
	 * Logout the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout() {
		
		$lang = $_SESSION['language'];
		Yii::$app->user->logout ();
		setcookie ("email", '');
		setcookie ("user_id", '');
		//setcookie ("password", ''); 

		Yii::$app->session->setFlash ( 'success', Yii::t('app','Thanks, Welcome Back.') );
		$_SESSION['language'] = $lang;
		return $this->goHome ();
	}
	/**
	 * Displays contact page.
	 *
	 * @return mixed
	 */
	public function actionContact() {
		$model = new ContactForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->validate ()) {
			if ($model->sendEmail ( Yii::$app->params ['adminEmail'] )) {
				Yii::$app->session->setFlash ( 'success', 'Thank you for contacting us. We will respond to you as soon as possible.' );
			} else {
				Yii::$app->session->setFlash ( 'error', 'There was an error sending email.' );
			}
			
			return $this->refresh ();
		} else {
			return $this->render ( 'contact', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Displays about page.
	 *
	 * @return mixed
	 */
	public function actionAbout() {
		return $this->render ( 'about' );
	}
	
	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup() {
		Yii::$app->controller->enableCsrfValidation = false;
		if (!Yii::$app->user->isGuest) {
			Yii::$app->getSession ()->setFlash ( 'success', 'Already Logged in. Logout to Signup' );
			return $this->goHome();  		
		}

		$model = new SignupForm([ 
				'scenario' => 'register' 
		]);

		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		
		if(isset($_GET['referrer']) && $_GET['referrer']!="") {
			$referrer = $_GET ['referrer'];
			$referrer = base64_decode($referrer);
			$referrer_id = explode("-",$referrer);
			$referrerid = $referrer_id [0];
			
			if($referrerid  > 0) {
				$model->referrer_id = $referrerid;
				return $this->render ( 'signup', [ 
						'model' => $model,
						'reff_id' => $referrerid,
						'sitesetting' => $sitesetting
				]);
			} else {
				$this->redirect ('register'); 
			}
		} else if (count(Yii::$app->request->post()) > 0) {
			if($model->load(Yii::$app->request->post())) {

				if($user = $model->signup()) {
					$email = $model->email;
					$referrermodel = $model->findByEmail ( $email );
					$link = Yii::$app->urlManager->createAbsoluteUrl ( '/verify/' . base64_encode ( $email ) );
					$userreferrer = $referrermodel->referrer_id;
					$userreferrer = json_decode ($userreferrer, true); 
					
					if(!empty($userreferrer))
						$referid = $userreferrer['reffid']; 

					if (isset($referid)) {
						$userinvitemodel = Userinvites::find ()->where ( [ 
								'userid' => $referid,
								'invitedemail' => $email 
						])->One();
						if(count($userinvitemodel) > 0) {
							$userinvitemodel->id = $userinvitemodel->id;
							$userinvitemodel->status = "Joined";
							$userinvitemodel->save(); 
						}  
					}

					$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
					$siteName = $sitesetting->sitename;
					if($sitesetting->welcomeemail=="yes") {
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

					if (Yii::$app->user->login($user)) {
						$session = Yii::$app->session;
						$session->open ();
						$session ['welcomepop'] = "1";
						$_SESSION['welcomepop'] = "1";
						$redirecturl = Yii::$app->urlManager->createAbsoluteUrl ( '/');
						return $this->goHome();
					}
				}  
			}
		} else {
			$this->redirect ('register');
		}
		
		
	}
	
	/*
	Displays sign up page
	*/
	public function actionRegister()
	{
		if (!(Yii::$app->user->isGuest)) {
			return $this->goHome (); 
    	} else {
			$model = new SignupForm ( [
					'scenario' => 'register'
					] );
				$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
			return $this->render ( 'signup', [
			'model' => $model,
			'sitesetting' => $sitesetting
			]);	 
		}
	}
	
	/**
	 * Function to let the user to reset his/her passsword.
	 *
	 * It will send the link to reset the password through email.
	 * If you click on the link you can create a new password for your account.
	 */
	public function actionForgotpassword() {
		$model = new SignupForm ();
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		$models = new PasswordResetRequestForm ( [ 
				'scenario' => 'passwordrequest' 
		] );
		if ($models->load ( Yii::$app->request->post () ) && $models->validate ()) {
			$email = $models->email;
			$createdDate = time ();
			$userdata = $model->findByEmail ( $email );
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
			Yii::$app->getSession ()->setFlash ( 'success', 'Mail sent to your mail id' );
			return $this->goHome ();			
		}
		Yii::$app->response->redirect ( array (
				'' 
		) );
	}
	
	/**
	 * Resets password.
	 *
	 * @param string $token        	
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetpassword() {
		Yii::$app->user->logout ();
		$model = new ResetPasswordForm ( [ 
				'scenario' => 'resetpass' 
		] );
		$signupmodel = new SignupForm ();
		if (isset ( $_GET ['resetLink'] ) && ! isset ( $_POST ['ResetPasswordForm'] ['password'] )) {
			$resetData = base64_decode ( $_GET ['resetLink'] );
			$resetData = explode ( '-', $resetData );
			$userId = $resetData [0];
			$createddate = $resetData [1];
			$resetPasswordModel = $signupmodel->findIdentity ( $userId ); // print_r($resetPasswordModel);
			if (! empty ( $resetPasswordModel ) && $resetPasswordModel->verify_pass != "1" && $resetPasswordModel->verify_passcode == $createddate) {
				return $this->render ( 'resetpassword', array (
						'model' => $model,
						'id' => $userId 
				) );
			} else {
				Yii::$app->session->setFlash ( 'success', 'Access denied!' ); 
				$this->redirect ( 'signin' );
			}
			// Yii::$app->session->setFlash ( 'success', 'New password was saved.' );
		} elseif (isset ( $_POST ['ResetPasswordForm'] ['password'] )) {
			$userId = $_POST ['ResetPasswordForm'] ['id'];
			$password = base64_encode ( $_POST ['ResetPasswordForm'] ['password'] );
			$resetPasswordModel = $signupmodel->findIdentity ( $userId );
			$verify_pass = $resetPasswordModel->verify_pass;
			$resetPasswordModel->password = $password;
			$resetPasswordModel->verify_pass = "1";
			if ($verify_pass != "1") {
				if ($resetPasswordModel->save ()) {
					Yii::$app->session->setFlash ( 'success', 'Password Reset Successfully' );
					$this->redirect ( 'signin' ); 
				} else {
					Yii::$app->session->setFlash ( 'success', 'Something went wrong' );
					$this->redirect ( 'signin' ); 
				}
			}
		} else {
			Yii::$app->session->setFlash ( 'success', 'Access denied!..' );
			return $this->goHome ();
		}

	}
	
	/**
	 * Function for displaying profile information
	 */
	public function actionDashboard() {
		$model = new SignupForm ();
		if (Yii::$app->user->isGuest) {
			return $this->goHome ();
		} else if (! Yii::$app->user->isGuest) {
			$userid = \Yii::$app->user->identity->id;
			$userdata = $model->findIdentity ( $userid );
	    	if($userdata->userstatus != '1') {   
        		Yii::$app->getSession ()->setFlash ( 'success', 'Sorry user access blocked by admin.' );
        		Yii::$app->user->logout ();
        		return $this->goHome ();     
      	}
		}
		$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
		$uploadmodel = new \yii\xupload\models\XUploadForm ();
		if (Yii::$app->request->post ()) {
			$path = realpath ( Yii::$app->basePath . "/web/albums/images/users/" ) . "/";
			// echo $path;die;
			$model = new \yii\xupload\models\XUploadForm ();
			$model->file = UploadedFile::getInstance ( $model, 'file' );
			
			if ($model->file !== null) {
				// Grab some data
				/*
				 * $model->mime_type = $model->file->getType( );
				 * $model->size = $model->file->getSize( );
				 */
				$model->name = $model->file->getBaseName ();
				$userid = \Yii::$app->user->identity->id;
				$imgname = Yii::$app->mycomponent->productSlug ( $model->name );
				$filename = $userid . "_" . $imgname;
				$filename .= "." . $model->file->getExtension ();
				// echo $path.$filename;die;
				if ($model->validate ()) {
					// Move our file to our temporary dir
					$model->file->saveAs ( $path . $filename );
					chmod ( $path . $filename, 0777 );
					$userdata->id = $userid;
					$userdata->profile_image = $filename;
					$userdata->save ();
				}
			}
			return $this->redirect ( 'dashboard', [
					'model' => $model,
					'userdata' => $userdata,
					'uploadmodel' => $uploadmodel
			] );			
		}
		return $this->render ( 'dashboard', [ 
				'model' => $model,
				'userdata' => $userdata,
				'uploadmodel' => $uploadmodel,
				'sitesettings' => $sitesettings
		] );
	}
	
	/**
	 * Validates if the email is already exists or not while signup
	 */
	public function actionValidatedata() {
		$model = new SignupForm ();
		$email = $_POST ['email'];
		$models = $model->findByEmail ( $email );
		if ($email == "") {
			echo "empty";
		} else if (count ( $models ['email'] ) > 0) {
			echo "exists";
		} else {
			echo "success";
		}
	}
	
	/**
	 * Validate the login form.
	 * Validate the email and password
	 */
	public function actionLoginvalidate() {
		$model = new SignupForm ();
		$email = $_POST ['email'];
		$password = $_POST ['password'];
		$models = $model->findByEmail ( $email );
		if ($email == "") {
			echo "empty";
		} else if (count ( $models ['email'] ) > 0) {
			if($models['id'] == "1" ){
				echo "error";
			} else {
				$userpassword = base64_decode ( $models->password );
				if ($password != $userpassword) {
					echo "passerr";
				} else if ($password == $userpassword)
					echo "success";
			}
		} else {
			echo "error";
		}
	}
	
	/**
	 * Validate email on forgot password
	 */
	public function actionValidateforgot() {
		$model = new PasswordResetRequestForm ();
		$signupmodel = new SignupForm ();
		$email = $_POST ['email'];
		$models = $signupmodel->findByEmail ( $email );
		if ($email == "") {
			echo "empty";
		} else if (count ( $models ['email'] ) > 0) {
			echo "success";
		} else {
			echo "error";
		}
	}
	
	/**
	 * Function to let the user to verify their email address for booking
	 *
	 * @param verifylink $details        	
	 */
	public function actionVerify($details) {
		$model = new SignupForm ();
		$email = base64_decode ( $details );
		$models = $model->findByEmail ( $email );
		$table = $model->tableName ();
		if ($details != "" && $models->emailverify != "1") {
			
			Yii::$app->db->createCommand ( 'UPDATE ' . $table . ' set emailverify="1" WHERE email="' . $email . '"' )->execute ();
			Yii::$app->getSession ()->setFlash ( 'success', 'Email verified' );
		} else if ($models->emailverify == "1") {
			Yii::$app->getSession ()->setFlash ( 'success', 'Email already verified' );
		}
		
		Yii::$app->response->redirect ( array (
				'/dashboard' 
		) );
	}
	
	/**
	 * Function to let the user to edit their profile and to save their profile information.
	 */
	public function actionEditprofile() {
		$model = new Profile ();

		$country = new Country ();
		$shippingmodel = new Shippingaddress ();
		$this->layout = "main";
		if (Yii::$app->user->isGuest) {
			return $this->goHome ();
		} else if (! Yii::$app->user->isGuest) {
			$userid = \Yii::$app->user->identity->id;
			$userdata = $model->findIdentity ( $userid );
			$shipping = Shippingaddress::find ()->where ( [ 
					'userid' => $userid 
			] )->One ();

	    	if($userdata->userstatus != '1') {   
        		Yii::$app->getSession ()->setFlash ( 'success', 'Sorry user access blocked by admin.' );
        		Yii::$app->user->logout ();
        		return $this->goHome ();     
      	}
		}

		$timezones = Timezone::find()->all();
		$countries = Country::find ()->all ();
		$languages = Languages::find()->all();
		$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();

		if (Yii::$app->request->post ()) {
			$model->load ( $_POST );
			$userid = \Yii::$app->user->identity->id;
			$profilemodel = $model->findIdentity ( $userid );
			$profilemodel->id = $userid;
			$profilemodel->firstname = $_POST ['SignupForm'] ['firstname'];
			$profilemodel->lastname = $_POST ['SignupForm'] ['lastname'];
			$profilemodel->gender = $_POST ['SignupForm'] ['gender'];
			$profilemodel->firstname = $_POST ['SignupForm'] ['firstname'];
			$profilemodel->birthday = $_POST ['SignupForm'] ['month'] . "-" . $_POST ['SignupForm'] ['day'] . "-" . $_POST ['SignupForm'] ['year'];
			//$profilemodel->phoneno = $_POST ['SignupForm'] ['phoneno'];
			$profilemodel->state = $_POST ['SignupForm'] ['state'];
			$profilemodel->about = $_POST ['SignupForm'] ['about'];
			//$profilemodel->paypalid = $_POST ['SignupForm'] ['paypalid'];
			
			if(isset($_POST ['SignupForm'] ['school'])){
			$profilemodel->school = $_POST ['SignupForm'] ['school'];
			}
			if(isset($_POST ['SignupForm'] ['work'])){
			$profilemodel->work = $_POST ['SignupForm'] ['work'];
			}
			if(isset($_POST ['SignupForm'] ['timezone'])){
			$profilemodel->timezone = $_POST ['SignupForm'] ['timezone'];
			}
			if(isset($_POST ['SignupForm'] ['emergencyno'])){
			$profilemodel->emergencyno = $_POST ['SignupForm'] ['emergencyno'];
			}
			if(isset($_POST ['SignupForm'] ['emergencyname'])){
			$profilemodel->emergencyname = $_POST ['SignupForm'] ['emergencyname'];
			}
			if(isset($_POST ['SignupForm'] ['emergencyemail'])){
			$profilemodel->emergencyemail = $_POST ['SignupForm'] ['emergencyemail'];
			}
			if(isset($_POST ['SignupForm'] ['emergencyrelation'])){
			$profilemodel->emergencyrelation = $_POST ['SignupForm'] ['emergencyrelation'];
			}
			$profilemodel->firstname = $_POST ['SignupForm'] ['firstname'];


			if(isset($_POST['SignupForm']['userlanguages']) && !empty($_POST['SignupForm']['userlanguages']))
			{
				$langaugearr = $_POST['SignupForm']['userlanguages'];
				for($i=0;$i<count($langaugearr);$i++)
				{
					$userlanguages[$i]['name'] = $langaugearr[$i];
				}
				$profilemodel->language = json_encode($userlanguages);
			}else{
				$profilemodel->language = '';
			}

			$profilemodel->save ();
			// print_r($profilemodel);die;
			if (isset($shipping) && !empty ( $shipping )) {
				$shipping->id = $shipping->id;
			}
			else 
				$shipping = new Shippingaddress();
				$shipping->userid = $userid;
				$shipping->country = $_POST ['Shippingaddress'] ['country'];
				$shipping->address1 = $_POST ['Shippingaddress'] ['address1'];
				$shipping->address2 = $_POST ['Shippingaddress'] ['address2'];
				$shipping->city = $_POST ['Shippingaddress'] ['city'];
				$shipping->state = $_POST ['Shippingaddress'] ['state'];
				$shipping->zipcode = $_POST ['Shippingaddress'] ['zipcode'];
				$shipping->save ();
				Yii::$app->getSession ()->setFlash ( 'success', 'Profile Updated' );
				$username = base64_encode($userid."-".rand(0,999));
				return $this->redirect ( 'profile/'.$username, [ 
						'model' => $model,
						'userdata' => $userdata,
						'countries' => $countries,
						'shipping' => $shipping,
						'timezones' => $timezones,
						'languages' => $languages
				] );
		}
		if(empty($shipping))
		{
			$shipping = new Shippingaddress();
		}
		return $this->render ( 'editprofile', [ 
				'model' => $model,
				'userdata' => $userdata,
				'countries' => $countries,
				'shipping' => $shipping,
				'timezones' => $timezones,
				'languages' => $languages,
				'site_settings' => $sitesettings
		] );
	}
	
	/**
	 * Function to view the user profile
	 *
	 * @param string $id        	
	 */
	public function actionProfile($details) {
		$model = new SignupForm ();
		$this->layout = "main";
		if (! empty ( $details )) {
			$userdata = base64_decode ( $details );
			$userids = explode ( "-", $userdata );
			$userid = $userids [0];
		}
		/*if (Yii::$app->user->isGuest) {
			return $this->goHome ();
		} else*/
		if (!Yii::$app->user->isGuest) {
	    	$loguserid = \Yii::$app->user->identity->id;
	    	$logUserDetails = User::find()->where(['id' => $loguserid])->One(); 
	    	if($logUserDetails->userstatus != '1') {  
        		Yii::$app->getSession ()->setFlash ( 'success', 'Sorry user access blocked by admin.' );
        		Yii::$app->user->logout ();
        		return $this->goHome ();     
      	} 
		}
		else
			$loguserid = "";
		$userdata = $model->findIdentity ( $userid );
		$listdatas = Listing::find()->where(['userid'=>$userid, 'liststatus'=>'1'])->all();


		$getReports = Profilereports::find()->where(['report_type'=>'profile'])->all();

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
		 

		$reportcount = Userreports::find()->where(['userid'=>$loguserid, 'reporterid'=>$userid])->one();


		$query = Reviews::find()->where(['listid'=>$listids]);
    	$countQuery = clone $query;
    	$pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>20]);
    	$reviews = $query->orderBy('id desc')->all(); 
		if(!empty($userdata))
		{	
			if($userdata->userstatus=="1")
			{
				return $this->render ( 'profile', [ 
						'userdata' => $userdata,
						'loguserid' => $loguserid,
						'listdatas' => $listdatas,
						'reportcount'=>$reportcount,
						'getReports' => $getReports,
						'reviews' => $reviews,
						'pages' => $pages
				] );
			}
			else
			{
				Yii::$app->getSession ()->setFlash ( 'success', 'User blocked' );
				Yii::$app->response->redirect ( array (
						'' 
				) );
			}
		}
		else
		{
			Yii::$app->getSession ()->setFlash ( 'success', 'User not found' );
			Yii::$app->response->redirect ( array (
					'' 
			) );
		}
	}

	public function actionAddreport()
	{
		$model = new Userreports();
		if (Yii::$app->user->isGuest) {
		
			$key = 'false';
			return $key;
		}else{
			$model->reportid = $_POST['reportid'];
			$model->userid = Yii::$app->user->identity->id;
			$model->reporterid = $_POST['reporterid'];
			$model->createdtime = date('Y-m-d h:i:s');
			$model->report_type = 'profile';
			$model->report_status = 1;
			$model->status = 1;
			$model->save(false);
			$key = 'true';
			return $key;
		}
		
	}

	public function actionAddlistingreport()
	{
		$model = new Userreports();
		if (Yii::$app->user->isGuest) {
		
			$key = 'false';
			return $key;
		}else{
			$model->reportid = $_POST['reportid'];
			$model->userid = Yii::$app->user->identity->id;
			$model->listid = $_POST['listid'];
			$model->createdtime = date('Y-m-d h:i:s');
			$model->report_status = 1;
			$model->report_type = 'list';
			$model->status = 1;
			$model->save(false);
			$key = 'true';
			return $key;
		}
		
	}

	/*
		Delete Reports
	*/
	public function actionDeletereport()
	{
		$id = trim($_POST['profilereportid']);
		$model = Userreports::find()->where(['id'=>$id])->one();
      $model = $model->delete();
		return 'true';
	}
	
	/**
	 * Page to display the veritication information for the user
	 */
	public function actionTrust() {
		$model = new SignupForm ();
		$country = new Country ();
		if (Yii::$app->user->isGuest) {
			return $this->goHome ();
		} else{
			$userid = Yii::$app->user->identity->id;
			$userdata = $model->findIdentity ( $userid );
			$countries = Country::find ()->all ();
			return $this->render ( 'trust', [ 
					'userdata' => $userdata,
					'countries' => $countries 
			] );
			}
	}
	
	/**
	 * Function to the let the user to change their password
	 */
	public function actionChangepassword() {
		$model = new ResetPasswordForm ();
		$model->scenario = 'changepass';
		$signupmodel = new SignupForm ();
		if (Yii::$app->user->isGuest) {
			return $this->goHome ();
		} else {
			$userid = Yii::$app->user->identity->id;
			$userdata = $signupmodel->findIdentity ( $userid );
			if (Yii::$app->request->post ()) {
				$userdata->id = $userid;
				$userdata->password = base64_encode ( $_POST ['newpassword'] );
				$userdata->save ();
				Yii::$app->getSession ()->setFlash ( 'success', 'Password changed successfully' );
			}
			return $this->render ( 'changepassword', [ 
					'userdata' => $userdata,
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Display the invite friends page
	 */
	public function actionInvitefriends() {
		$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
		$model = new SignupForm ();
		if (Yii::$app->user->isGuest) {
			return $this->goHome ();
		} else {
			$userid = Yii::$app->user->identity->id;
			$userdata = $model->findIdentity ( $userid );
			return $this->render ( 'invitefriends', [ 
					'userdata' => $userdata,
					'sitesettings' => $sitesettings
			] );
		}
	}
	
	/**
	 * Function to invite the friends by sending the email to the friends
	 */
	public function actionSendmail() {
		$user_id = Yii::$app->user->identity->id;
		$model = new SignupForm ();
		$invitemodel = new Userinvites ();
		$tablename = $invitemodel->tableName ();
		$emailids = $_POST ['emails'];
		$email = explode ( ',', $emailids ['emails'] );
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		
		$loguser = $model->findIdentity ( $user_id );
		
		$userinvitearray = array ();
		foreach ( $email as $key => $toemail ) {
			$userinviteModel = Userinvites::find ()->where ( [ 
					'userid' => $user_id,
					'invitedemail' => $toemail 
			])->one();
			if(count($userinviteModel) == 0) {
				$userinvitearray [] = [ 
					'userid' => $user_id,
					'invitedemail' => $toemail,
					'status' => 'Invited',
					'inviteddate' => time (),
					'cdate' => time () 
				];
			} 
			$emailarray[] = [
				'invitedemail' => $toemail
			];
		} 

		if (count ( $userinvitearray ) > 0) {
			$columnNameArray = [ 
					'userid',
					'invitedemail',
					'status',
					'inviteddate',
					'cdate' 
			];
			// below line insert all your record and return number of rows inserted
			$insertCount = Yii::$app->db->createCommand ()->batchInsert ( $tablename, $columnNameArray, $userinvitearray )->execute ();

			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
			$siteName = $sitesetting->sitename;
			foreach ( $emailarray as $invites ) { 
				echo $email = $invites ['invitedemail'];
				Yii::$app->mailer->compose ( 'invitemail', [ 
						'loguser' => $loguser,
						'siteName' => $siteName,
				] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Invite mail' )->send ();
			}
		}   
	}
	public function afterSave() {
		$path = realpath ( Yii::app ()->getBasePath () . "/../media/item/" . $photosModel->productId . "/" ) . "/";
		$model = new XUploadForm ();
		$model->file = UploadedFile::getInstance ( $model, 'file' );
		echo "dsfD";
		die ();
		// We check that the file was successfully uploaded
		if ($model->file !== null) {
			// Grab some data
			$model->mime_type = $model->file->getType ();
			$model->size = $model->file->getSize ();
			$model->name = $model->file->getName ();
			// (optional) Generate a random name for our file
			$filename = md5 ( Yii::app ()->user->id . microtime () . $model->name );
			$filename .= "." . $model->file->getExtensionName ();
			if ($model->validate ()) {
				// Move our file to our temporary dir
				$model->file->saveAs ( $path . $filename );
				chmod ( $path . $filename, 0777 );
				// here you can also generate the image versions you need
				// using something like PHPThumb
				
				// Now we need to save this path to the user's session
				if (Yii::app ()->user->hasState ( 'images' )) {
					$userImages = Yii::app ()->user->getState ( 'images' );
				} else {
					$userImages = array ();
				}
				$userImages [] = array (
						"path" => $path . $filename,
						// the same file or a thumb version that you generated
						"thumb" => $path . $filename,
						"filename" => $filename,
						'size' => $model->size,
						'mime' => $model->mime_type,
						'name' => $model->name 
				);
				Yii::app ()->user->setState ( 'images', $userImages );
				
				// Now we need to tell our widget that the upload was succesfull
				// We do so, using the json structure defined in
				// https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
				echo json_encode ( array (
						array (
								"name" => $model->name,
								"type" => $model->mime_type,
								"size" => $model->size,
								"url" => $publicPath . $filename,
								"thumbnail_url" => $publicPath . "/$filename",
								"delete_url" => $this->createUrl ( "upload", array (
										"_method" => "delete",
										"file" => $filename 
								) ),
								"delete_type" => "POST" 
						) 
				) );
			} else {
				// If the upload failed for some reason we log some data and let the widget know
				echo json_encode ( array (
						array (
								"error" => $model->getErrors ( 'file' ) 
						) 
				) );
				Yii::log ( "XUploadAction: " . CVarDumper::dumpAsString ( $model->getErrors () ), CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction" );
			}
		} else {
			throw new CHttpException ( 500, "Could not upload file" );
		}
	}
	
	/*
	Function to set the language and to change the language
	*/
	public function actionLanguage()
	{
		$language = $_POST['language'];
		Yii::$app->language = $language;
		$session = Yii::$app->session;
		Yii::$app->session->set('language', $language);
		$session['language'] = $language;
		$_SESSION['language'] = $language;
		$languageCookie = new Cookie([
			'name' => 'language',
			'value' => $language,
			'expire' => time() + 60 * 60 * 24 * 30, // 30 days
		]);
		Yii::$app->response->cookies->add($languageCookie);
		//echo Yii::$app->request->getReferrer(); die;
	}

	/*
	Function to send verification mail to the user for booking
	*/
	public function actionSendtrustmail()
	{
			$email = $_POST['email'];
			$model = new SignupForm ();
			//$email = 'lakshmipriya@hitasoft.com';
			$link = Yii::$app->urlManager->createAbsoluteUrl ( '/verify/' . base64_encode ( $email ) );
			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
			$models = $model->findByEmail ( $email );
			Yii::$app->mailer->compose ( 'verifyemail', [
						'name' => $models->firstname,
						'link' => $link,
					    'sitesetting' => $sitesetting
						] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $email )->setSubject ( 'Verify Email' )->send ();
			
					echo "success";
									
	}	

	public function actionMobileverificationstatus() {
		$_SESSION["code"] = $_POST["code"];
		$_SESSION["csrf_nonce"] = $_POST["csrf_nonce"];
		//echo "code ".$_POST["code"]; echo "nonce ".$_POST["csrf_nonce"];
		$ch = curl_init();

		$sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
		$sms_settings = json_decode($sitesettings->smssettings, true);
		$fb_appid = $sms_settings['facebook']['appid'];
		$fb_secret = $sms_settings['facebook']['secret'];
		
		// Set url elements
		$fb_app_id = $fb_appid;
		$ak_secret = $fb_secret;
		$token = 'AA|'.$fb_app_id.'|'.$ak_secret;
		// Get access token
		$url = 'https://graph.accountkit.com/v1.0/access_token?grant_type=authorization_code&code='.$_POST["code"].'&access_token='.$token;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		$info = json_decode($result);
		// print_r($info);
		// Get account information
		$url = 'https://graph.accountkit.com/v1.0/me/?access_token='.$info->access_token;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		curl_close($ch);
		$final = json_decode($result);
		//print_r($final);
		if(!empty($final->id)) {
			$id = Yii::$app->user->identity->id;
			$loguserdetails = Users::find()->where(['id'=>$id])->one();
			$loguserdetails->verifycountrycode = $final->phone->country_prefix;
			$loguserdetails->verifyno = $final->phone->national_number;
			$loguserdetails->mobileverify = '1';
			$loguserdetails->save(false);
			echo '1'; die;
		} else {
			echo '0'; die;
		}

	}

	public function actionPaysettings($details) {
		if (Yii::$app->user->isGuest) {
			return $this->goHome ();
		} else {
			$model = new SignupForm ();
			$userid = Yii::$app->user->identity->id;
			$userdata = $model->findIdentity($userid);
			
			// Site Settings
			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();

			if($userdata['stripe_account_id'] != "") {
				$hostData = json_decode(trim($userdata['stripe_account_id']), true);
				$details = trim($hostData['base']);
				// Stripe Key
				\Stripe\Stripe::setApiKey($sitesetting['stripe_secretkey']);

				try {
			      $account = \Stripe\Account::retrieve(trim($hostData['accountid']));
			   }

			   catch(\Stripe\Error\InvalidRequest $e) {
			      Yii::$app->getSession()->setFlash('success','Invalid request error - '.$e->getMessage());
			      return Yii::$app->response->redirect(array('dashboard'));
			   } catch (\Stripe\Error\Authentication $e) {
			      Yii::$app->getSession()->setFlash('success','Authentication error - '.$e->getMessage());
			      return Yii::$app->response->redirect(array('dashboard'));
			   } catch (\Stripe\Error\ApiConnection $e) {
			      Yii::$app->getSession()->setFlash('success','Network error - '.$e->getMessage());
			      return Yii::$app->response->redirect(array('dashboard'));
			   } catch (\Stripe\Error\Base $e) {
			      Yii::$app->getSession()->setFlash('success','Error - '.$e->getMessage());
			      return Yii::$app->response->redirect(array('dashboard'));
			   } catch(Exception $e) {
			      Yii::$app->getSession()->setFlash('success','Error - '.$e->getMessage());
			      return Yii::$app->response->redirect(array('dashboard'));
			   }

			} else {
				if($details == "default") {
					$details = "US~USD~United States";
				} else {
					$details = $this->airUrlConvert($details);
					$details = Myclass::getDcode(base64_decode($details)); 
				}
				$_SESSION['Stripe']['hostcountry'] = $details; 
			}
			
			// Stripe connect custom account creation supported countries, please don't change until confirmed in STRIPE.
			$stripeHostCountry = json_decode($sitesetting->stripe_host_support_country, true);

			//Stripe European Currencies
			$europeanCurrencies = array("EUR", "CHF", "DKK", "NOK", "SEK");

			//Stripe Address Basis
			$excludeLineBasis = array("AT");
			$excludeCityBasis = array("AT", "SG");
			$excludeCodeBasis = array("AT", "IE", "HK");
			$includeStateBasis = array("AU", "US", "IE", "CA");
			$includePersonalIdBasis = array("CA", "US", "HK", "SG"); 

			//Canada Province Code
			$canadaStateCode = array('AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT');

			if(in_array($details,$stripeHostCountry)) {
				return $this->render('paysettings', [ 
					'userdata' => $userdata,
					'sitesetting' => $sitesetting,
					'hostCountryOnLoad' => $details,
					'model' => $model,
					'canadaStateCode' => $canadaStateCode,
					'europeanCurrencies' => $europeanCurrencies,
					'excludeLineBasis' =>$excludeLineBasis,
					'excludeCityBasis' =>$excludeCityBasis,
					'excludeCodeBasis' =>$excludeCodeBasis,
					'includeStateBasis' =>$includeStateBasis,
					'includePersonalIdBasis' =>$includePersonalIdBasis 
				]); 
        	} else {
        		return Yii::$app->response->redirect(array('dashboard'));
        	}
		}
	}
	 
	public function actionPaysave() {
		if (Yii::$app->user->isGuest) {
			return $this->goHome ();
		} else {
			//User Identity
			$userid = Yii::$app->user->identity->id;
			$userdata = User::find()->where(['id'=>$userid])->one();

			$hostCountry = ""; $entryFlag = 0; 

			// Site Settings
			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
			
			// Stripe Key
			\Stripe\Stripe::setApiKey($sitesetting['stripe_secretkey']);

			if($userdata['stripe_account_id'] == "") {
				if(isset($_POST['Stripe']['hostCountry']) && trim($_POST['Stripe']['hostCountry'])!="")
					$hostCountry = trim(Myclass::getDcode(trim($_POST['Stripe']['hostCountry']))); 
					$_SESSION['Stripe']['hostcountry'] = $hostCountry;  
					$hostCountryRedirect = base64_encode(trim($_POST['Stripe']['hostCountry'])); 
			} else {
				$hostCountry = json_decode(trim($userdata['stripe_account_id']), true);
				$account = \Stripe\Account::retrieve(trim($hostCountry['accountid']));
				$account = $account->jsonSerialize();

				if($account['payouts_enabled'] == 1 && count($account['verification']['fields_needed']) == 0 && $account['charges_enabled'] == 1 && $account['legal_entity']['verification']['status'] == "verified") {
					$entryFlag = 1;
				}
				$hostCountry = $hostCountry['base'];
				$hostCountryRedirect = trim(Myclass::getEcode(trim($hostCountry))); 
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

				$hostData = json_decode(trim($userdata['stripe_account_id']), true); 

				//Validation on Post Values
				if(!isset($_POST['Stripe']['accountnumber']) || trim($_POST['Stripe']['accountnumber'])=="") {
					$exitFlag = 1;
				} else {
					if($userdata['stripe_account_id'] == "")
						$accountnumber = $_SESSION['Stripe']['accountnumber'] = trim($_POST['Stripe']['accountnumber']);
					//else
						//$accountnumber = trim($hostData['accountnumber']);
				}

				// European Countries doesn't contain routing numbers
				if(!in_array($cntry[1],$europeanCurrencies)) {
					if(!isset($_POST['Stripe']['routingnumber']) || trim($_POST['Stripe']['routingnumber'])=="") {
						$exitFlag = 1;
					} else {
						if($userdata['stripe_account_id'] == "")
							$routingnumber = $_SESSION['Stripe']['routingnumber'] = trim($_POST['Stripe']['routingnumber']); 
						//else
							//$routingnumber = trim($hostData['routingnumber']);
					}
				}

				if(in_array($cntry[0],$includePersonalIdBasis)) {
					if(!isset($_POST['Stripe']['personalidnumber']) || trim($_POST['Stripe']['personalidnumber'])=="") {
						$exitFlag = 1;
					} else {
						$_SESSION['Stripe']['personalidnumber'] = trim($_POST['Stripe']['personalidnumber']);
					}
				}

				if($cntry[0] == "US") {
					if(!isset($_POST['Stripe']['ssn']) || trim($_POST['Stripe']['ssn'])=="" || strlen(trim($_POST['Stripe']['ssn'])) != 4 ) {
						$exitFlag = 1;
					} else {
						$_SESSION['Stripe']['ssn'] = trim($_POST['Stripe']['ssn']);
					}
				}

				if(!isset($_POST['Stripe']['firstname']) || trim($_POST['Stripe']['firstname'])=="" || strlen(trim($_POST['Stripe']['firstname'])) < 3 ) {
					$exitFlag = 1;
				}

				if(!isset($_POST['Stripe']['lastname']) || trim($_POST['Stripe']['lastname'])=="" || strlen(trim($_POST['Stripe']['lastname'])) < 3) {
					$exitFlag = 1;
				}

				if(trim($_POST['Stripe']['year']) > 1900) {
					if(((int) checkdate(trim($_POST['Stripe']['month']), trim($_POST['Stripe']['day']), trim($_POST['Stripe']['year']))) != 1) {
						$exitFlag = 1;
					}
					$checkdob = trim($_POST['Stripe']['year'])."-".trim($_POST['Stripe']['month'])."-".trim($_POST['Stripe']['day']);

					if(date_diff(date_create($checkdob), date_create('today'))->y <= 13 ) {
						$exitFlag = 1;
					} 
				} else {
					$exitFlag = 1;
				}



				if(!isset($_POST['Stripe']['phonenumber']) || trim($_POST['Stripe']['phonenumber'])=="") {
					$exitFlag = 1;
				} else {
					$_SESSION['Stripe']['phonenumber'] = trim($_POST['Stripe']['phonenumber']);
				} 

				if($cntry[0] != "AT") {
					if(!in_array($cntry[0],$excludeLineBasis)) {
						if(!isset($_POST['Stripe']['line']) || trim($_POST['Stripe']['line'])=="") {
							$exitFlag = 1;
						} else {
							$_SESSION['Stripe']['line'] = trim($_POST['Stripe']['line']);
						} 
					}

					if(isset($_POST['Stripe']['lineoptional']) || trim($_POST['Stripe']['lineoptional'])!="") {
						$_SESSION['Stripe']['lineoptional'] = trim($_POST['Stripe']['lineoptional']);
					}  

					if(!in_array($cntry[0],$excludeCityBasis)) {
						if(!isset($_POST['Stripe']['city']) || trim($_POST['Stripe']['city'])=="") {
							$exitFlag = 1;
						} else {
							$_SESSION['Stripe']['city'] = trim($_POST['Stripe']['city']);
						} 
					}

					if(in_array($cntry[0],$includeStateBasis)) {
						if(!isset($_POST['Stripe']['state']) ||trim($_POST['Stripe']['state'])==""){
							$exitFlag = 1;
						} else {
							$_SESSION['Stripe']['state'] = trim($_POST['Stripe']['state']);
						} 
					}

					if(!in_array($cntry[0],$excludeCodeBasis)) {
						if(!isset($_POST['Stripe']['postalcode']) ||trim($_POST['Stripe']['postalcode'])=="") {
							$exitFlag = 1;
						} else {
							$_SESSION['Stripe']['postalcode'] = trim($_POST['Stripe']['postalcode']);
						} 
					} 
				}

				if($exitFlag == 1) {
					Yii::$app->getSession()->setFlash ( 'success', 'Sorry! Insufficient Data Error.' );
					return Yii::$app->response->redirect(array('paysettings/'.$hostCountryRedirect)); 
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
								Yii::$app->getSession()->setFlash ( 'success', "Account - ". $details[0]." ".$details[1].": ".$details[2]);
								return Yii::$app->response->redirect(array('paysettings/'.$hostCountryRedirect));
							}
						} else {
							Yii::$app->getSession()->setFlash ( 'success', "Error - ".$details[0]." ".$details[1].": ".$details[2]); 
							return Yii::$app->response->redirect(array('paysettings/'.$hostCountryRedirect));   
						}
					} else {
						$accountId = $hostData['accountid'];
						$accountToken = "";
					}

					if($accountId != "") {
						//Stripe Account Update
						$account = \Stripe\Account::retrieve($accountId);
						$account->legal_entity->first_name = $_SESSION['Stripe']['firstname'] = trim($_POST['Stripe']['firstname']);
			      	$account->legal_entity->last_name = $_SESSION['Stripe']['lastname'] = trim($_POST['Stripe']['lastname']);
						$account->legal_entity->dob->day = $_SESSION['Stripe']['day'] = trim($_POST['Stripe']['day']);
						$account->legal_entity->dob->month = $_SESSION['Stripe']['month'] = trim($_POST['Stripe']['month']);
						$account->legal_entity->dob->year = $_SESSION['Stripe']['year'] = trim($_POST['Stripe']['year']);
						$account->legal_entity->type= "individual";
						$account->legal_entity->phone_number = $_SESSION['Stripe']['phonenumber'] = trim($_POST['Stripe']['phonenumber']);

						$account->tos_acceptance->date = time();
						$account->tos_acceptance->ip = $_SERVER['REMOTE_ADDR'];	

						if(in_array($cntry[0],$includePersonalIdBasis)) {
							$account->legal_entity->personal_id_number = $_SESSION['Stripe']['personalidnumber'] = trim($_POST['Stripe']['personalidnumber']);
						}

						if($cntry[0] == "US") {
							$account->legal_entity->ssn_last_4 = $_SESSION['Stripe']['ssn'] = trim($_POST['Stripe']['ssn']);
						}

						// Stripe Address Update
						if($cntry[0] != "AT") {
							if(!in_array($cntry[0],$excludeLineBasis)) {
								$account->legal_entity->address->line1 = $_SESSION['Stripe']['line'] = trim($_POST['Stripe']['line']);
							}

							if(isset($_POST['Stripe']['lineoptional']) && trim($_POST['Stripe']['lineoptional']) != "") {
								$account->legal_entity->address->line2 = $_SESSION['Stripe']['lineoptional'] = trim($_POST['Stripe']['lineoptional']);
							} else {
								$account->legal_entity->address->line2 = NULL;
							}
														
							if(!in_array($cntry[0],$excludeCityBasis)) {
								$account->legal_entity->address->city = $_SESSION['Stripe']['city'] = trim($_POST['Stripe']['city']);
							}

							if(in_array($cntry[0],$includeStateBasis)) {
								$account->legal_entity->address->state = $_SESSION['Stripe']['state'] = trim($_POST['Stripe']['state']);
							}

							if(!in_array($cntry[0],$excludeCodeBasis)) {
								$account->legal_entity->address->postal_code = $_SESSION['Stripe']['postalcode'] = trim($_POST['Stripe']['postalcode']);
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
						       		$result['personalidnumber'] = trim($_POST['Stripe']['personalidnumber']);
						       		$result['personalidnumber_status'] = trim($details['legal_entity']['personal_id_number_provided']);
						       	}
						      }
						      // Retrieve SSN
						      if(strpos(json_encode($details['legal_entity']), 'ssn_last_4_provided') !== false && $hostCountryCode == "US") {
						    		if(trim($details['legal_entity']['ssn_last_4_provided']) == 1 ){
						       		$result['ssn_last_four'] = trim($_POST['Stripe']['ssn']);
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
								$userdata->save ();

								$_SESSION['Stripe'] = ""; 

								Yii::$app->getSession()->setFlash ( 'success', "Host Account Created.");
								return Yii::$app->response->redirect(array('paysettings/'.$hostCountryRedirect));
    						} else {
    							Yii::$app->getSession()->setFlash ( 'success', "Account Creation Failed ");
								return Yii::$app->response->redirect(array('paysettings/'.$hostCountryRedirect));
    						}
    					} else {
    						Yii::$app->getSession()->setFlash ( 'success', "Account Update - ". $details[0]." ".$details[1].": ".$details[2]);
							return Yii::$app->response->redirect(array('paysettings/'.$hostCountryRedirect));
    					}
					} else {
						Yii::$app->getSession()->setFlash ( 'success', 'Sorry! Something Went wrong.' );
						return Yii::$app->response->redirect(array('paysettings/'.$hostCountryRedirect));     
					}
				}
			} else {
				if($entryFlag == 1)
					Yii::$app->getSession()->setFlash('success','Host account already verified.');
				else
					Yii::$app->getSession()->setFlash('success','Sorry! Something Went wrong.');

				return Yii::$app->response->redirect(array('dashboard')); 
			}	
		}
	}

	public function airUrlConvert($string) {
		$entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
		$replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
		return str_replace($entities, $replacements, urlencode($string));
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

	public function dataReturn($key, $flag) {
		$userid = Yii::$app->user->identity->id;
		$userdata = User::find()->where(['id'=>$userid])->one();
		
		if($userdata->stripe_account_id != "" && $flag == "AC") {
			$data = json_decode($userdata->stripe_account_id, true);
			return base64_encode($data[$key]);
		} elseif ($userdata->stripe_account_info != "" && $flag == "IN") {
			$data = json_decode($userdata->stripe_account_info, true);
			return base64_encode($data[$key]);
		} else {
			return;
		}
	}


	// Stripe Auto Payment for host and guest. if, not cliamed by host.
	// CRON Job, please don't delete. 
	public function actionPayupdate() {
		
		$todaydate = date('m/d/Y');
    	$today = strtotime($todaydate);

		$reservations = Reservations::find()->where(['orderstatus'=>'pending'])
		->andWhere([
					'or', 
				   ['bookstatus'=>'accepted'],
				   ['bookstatus'=>'requested']
				]) 
		->andWhere(['other_transaction'=>NULL])
		->andWhere(['claim_transaction'=>NULL]) 
		->andWhere(['!=','checkin','0000-00-00 00:00:00'])
		->andWhere(['!=','checkout','0000-00-00 00:00:00'])
		->andWhere(['<','todate', $today])  
		->all();

		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();  
		$cardDetails = json_decode($sitesetting->stripe_card_details, true);

		if(count($reservations) > 0 && count($cardDetails) > 0) { 
			
			foreach ($reservations as $key => $reservation) {
				$currentTimezone = strtotime(Myclass::getTime($reservation->timezone)); 
                date_default_timezone_set('UTC');

				if($reservation->bookstatus == "requested" && (strtotime($reservation->checkout) < $currentTimezone) && empty($reservation->other_transaction)) {   
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
		                    $reservation->bookstatus = "refunded";
		                    $reservation->cancelby = "Admin";
		                    $reservation->canceldate = time();
		                    $reservation->save();

		                    $userid = $reservation->userid;
		                    $hostid = $reservation->hostid;
		                    $userform = new SignupForm ();
		                    $userdata = $userform->findIdentity($userid);
		                    $hostdata = $userform->findIdentity($hostid);
		                    $usernotifications = json_decode($userdata->notifications,true);

		                    if($usernotifications['reservationnotify']==1) {
		                        $listingid = $reservation->listid;
		                        $notifymessage = 'refunded on your trip request';
		                        $message = '';
		                        $logdatas = $this->addlog('refund',$hostid,$userid,$listingid,$notifymessage,$message);  
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
			                                $messages = 'Your trip request has been refunded by Admin at '.$listingdata->listingname;
			                                Yii::$app->mycomponent->pushnot($deviceToken,$messages,$badge);
			                            }
			                        }
			                    }
			                 } 

		                    Yii::$app->mailer->compose ( 'reservestatus', [
		                        'name' => $userdata->firstname,
		                        'sitesetting' => $sitesetting,
		                        'listingname' => $listingdata->listingname,
		                        'status' => 'refunded',
		                        'hostname' => $hostdata->firstname,
		                        ] )->setFrom ( $sitesetting->noreplyemail )->setTo ( $userdata->email )->setSubject ( 'Your trip request has refunded' )->send (); 
		                }
		            }
				} else if($reservation->bookstatus == "accepted" &&  (strtotime($reservation->checkout) < $currentTimezone)) {
					$hostData = User::find()->where(['id'=>$reservation->hostid])->one();
					$checkoutDate = date("m/d/Y",$reservation->todate);
					$todayDate = date('m/d/Y');

			    	$payoutDue = json_decode($sitesetting->stripe_card_details, true);
					$payoutDue = (trim($payoutDue['stripe_hostpaydays']) > 2)?trim($payoutDue['stripe_hostpaydays']):'2';
					$payoutDue = "+".$payoutDue." days";

					if($hostData['stripe_status'] == "verified" && $hostData['stripe_account_id'] != NULL && $hostData['stripe_account_id'] != "" && $hostData['stripe_account_info'] != NULL && $hostData['stripe_account_info'] != "") {

						$dueDate = date("m/d/Y",strtotime($checkoutDate.$payoutDue));

						if((strtotime($checkoutDate) < $currentTimezone) && ($currentTimezone > strtotime($dueDate))) { 
							$host_amount = 0; $guest_amount = 0; $guest_pay=0;

			            if($reservation->booking == 'perhour') {
			               $total_listingprice = $reservation->pricepernight * $reservation->totalhours;
			            } else if($reservation->booking == 'pernight') {
			               $total_listingprice = $reservation->pricepernight * $reservation->totaldays;
			            } else {
			               $total_listingprice = $reservation->pricepernight;
			            }

				         $other_amount = $reservation->taxfees + $reservation->cleaningfees + $reservation->servicefees;
		              	$total_amount = $total_listingprice + $other_amount;

	               	$guest_amount = $reservation->securityfees;

	               	$rate = $reservation->convertedprice;   

	            		if($reservation->convertedcurrencycode == "JPY" || $reservation->convertedcurrencycode == "jpy") {
		                  $host_amount = round(($total_amount/$rate),2);
		                  $guest_pay = round(($guest_amount/$rate),2);
		               } else {
		                  $host_amount = round(($total_amount/$rate),2) * 100;
		                  $guest_pay = round(($guest_amount/$rate),2) * 100; 
		               } 

		               $inv_reservation = Reservations::find()->where(['id'=>$reservation->id])->one();
		               $invoice = $inv_reservation->getInvoices()->where(['orderid'=>$reservation->id])->one();

		               $host_account_id = json_decode($hostData['stripe_account_id'], true); 

		               \Stripe\Stripe::setApiKey($sitesetting->stripe_secretkey); 
		               
	               	if(!empty($invoice->stripe_transactionid) && $host_account_id['accountid']!="") { 

		               	if(!empty($guest_pay) && $guest_pay > 0 && $inv_reservation->other_transaction == NULL) { 
			               	// Refund to security deposit to Guest
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
			                     $inv_reservation->sdstatus = 'paid';
			                     $inv_reservation->other_transaction = json_encode($result);
			                     $inv_reservation->save();
			                  }
			               } 

				            if(!empty($host_amount) && $host_amount > 0 && $inv_reservation->claim_transaction == NULL)   
				            {  
			                  $cardDetails = json_decode($sitesetting->stripe_card_details, true);
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
				                  $inv_reservation->orderstatus = 'paid';
				                  $inv_reservation->sdstatus = 'paid';
				                  $inv_reservation->claim_transaction = json_encode($result);
				                  $inv_reservation->save();
				               }
				            }
		               }
						} 
					}
				}

			}
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

	// Stripe Auto Payment for host and guest. if, not cliamed by host.
	// CRON Job, please don't delete. 
	public function actionCurrencyupdate() { 
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

					$url = 'https://www.x-rates.com/calculator/?from='.strtoupper($defaultcurrency).'&to='.strtoupper($staticCurrency).'&amount=1';
          		$rawdata = file_get_contents($url); 
           		$data = explode('ccOutputRslt">', $rawdata);
           		$data1 = explode('ccOutputTrail">', $rawdata);
           		$data = explode('<span', $data[1]);   
           		$data1 = explode('</span', $data1[1]);   
           		$amtConverted =  trim($data[0]).trim($data1[0]);

					$currencyTbl = Currency::find()->where(['id'=>$curId])->one();
					$currencyTbl->price=$amtConverted;
					$currencyTbl->save(false); 
				} 
				return "updated";	 
			}
		} 
		die;

	}


}
