<?php
namespace backend\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\AdminLoginForm;
use yii\filters\VerbFilter;
use backend\components\Myclass;
use backend\models\Users;
use backend\models\Userssearch;
use backend\models\Messages;
use backend\models\Sitesettings;
use backend\models\Listingproperties;
use backend\models\Additionalamenities;
use backend\models\Commonamenities; 
use backend\models\Safetycheck;
use backend\models\Specialfeatures;
use backend\models\Listing;
use backend\models\Listingsearch;
use backend\models\Reviews;
use backend\models\Reviewssearch;
use frontend\models\Logs;
use backend\models\Buttonsliders;
use backend\models\Homepagesettings;
use yii\web\UploadedFile;
use yii\web\Cookie;
use yii\data\ActiveDataProvider;
use backend\models\Currency;
use backend\models\Hometype;


/**
 * User controller
 */
class AdminsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return []; 
    }

    public function beforeAction($action) {
		$this->enableCsrfValidation = false;
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
            'upload' => [
            'class' => 'yii\xupload\actions\php\XUploadAction',
            'path' => \Yii::$app->getBasePath () . DIRECTORY_SEPARATOR . 'albums' . DIRECTORY_SEPARATOR . 'images',
            'publicPath' => \Yii::$app->getHomeUrl () . DIRECTORY_SEPARATOR . 'albums' . DIRECTORY_SEPARATOR . 'images',
            'subfolderVar' => "parent_id"
            ]          
        ];
    }

    /**
     * Admin home page before login
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = false;
        $model = new Users();
        if (!\Yii::$app->user->isGuest) {
			Yii::$app->response->redirect ( array (
					'/dashboard' 
			) );
        }
        return $this->render('index',[
            'model' => $model
                ]);
    }
    
    /**
     * Admin home page after login
     */
    public function actionDashboard()
    {
    	
    	if (Yii::$app->user->isGuest) {
    		return $this->goHome();
    	}
    	$model = new Users();
    	$usermodel = Users::find('all')->where(['!=','user_level','god'])->all();
    	$activeuser = Users::find('all')->where(['!=','user_level','god'])->andWhere(['!=','userstatus','0'])->all();
    	$blockuser = Users::find('all')->where(['!=','user_level','god'])->andWhere(['=','userstatus','0'])->all();
    	$activelist = Listing::find('all')->where(['=','liststatus','1'])->all();

    	return $this->render('dashboard',[
    			'model' => $model,
    			'usermodel' => $usermodel,
    			'activeuser' => $activeuser,
    			'blockuser' => $blockuser,
    			'activelist' => $activelist
    	]);
    }    

    /**
     * Allows the admin to login
     * @return \yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            //return $this->goHome();
        }

        $model = new Users();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
        	//Yii::$app->getSession ()->setFlash ( 'success', 'Successful Login' );
			Yii::$app->response->redirect ( array (
					'/dashboard' 
			) );
        } else {
        	Yii::$app->session->setFlash ( 'success', 'Login failed' );
        	$baseUrl = Yii::$app->request->baseUrl.'/';
			return $this->redirect(''.$baseUrl.'');
        }
    }
	
    public function actionProfile()
    {
    	if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   } 
        $model = new Users();
        $userid = \Yii::$app->user->identity->id;
        $user = $model->findIdentity($userid);
        if (Yii::$app->request->post()) {
        	$adminemail = $_POST['adminemail'];
        	$adminpassword = $_POST['adminpassword'];
        	$user->email = $adminemail;
        	$user->password = base64_encode($adminpassword);
        	$user->save(false);
			//Yii::$app->getSession ()->setFlash ( 'success', 'Successful Login' );
			Yii::$app->response->redirect ( array (
					'/dashboard' 
			) );
        }
        return $this->render('profile',[
        	'user' => $user
        	]); 	
    }	

    /**
     * Function to logout the admin
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
		$baseUrl = Yii::$app->request->baseUrl; 

        return $this->redirect(''.$baseUrl.'/');
    }
    
	/**
	 * Validate the login form.
	 * Validate the email and password
	 */
	public function actionLoginvalidate() {
		$model = new Users ();
		$email = $_POST['email'];
		$password = $_POST['password'];
		$models = $model->findByEmail ( $email );
		
		if ($email == "") {
			echo "empty";
		} else if (count ( $models ['email'] ) > 0) {
			$userpassword = base64_decode ( $models->password );
			if ($password != $userpassword) {
				echo "passerr";
			} else if ($password == $userpassword)
				echo "success";
		} else {
			echo "error";
		}
	}

	/*
	 * Allows the admin to manage the user. It lists all the unblocked/active users
	 */
	public function actionUsermanagement()
	{
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
        $searchModel = new Userssearch();
        $dataProvider = $searchModel->searchblockusers(Yii::$app->request->queryParams);

        return $this->render('usermanagement', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}
	
	/*
	 * Allows the admin to manage host. It lists all the unblocked/active hosts
	 */
	public function actionHostmanagement()
	{
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$searchModel = new Userssearch();
		$dataProvider = $searchModel->searchactivehosts(Yii::$app->request->queryParams);
	
		return $this->render('hostmanagement', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				]);
	}	
	
	/*
	 * Allows the admin to manage host. It lists all the blocked/inactive hosts
	*/
	public function actionBlockedhostmanagement()
	{
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$searchModel = new Userssearch();
		$dataProvider = $searchModel->searchinactivehosts(Yii::$app->request->queryParams);
	
		return $this->render('blockedhostmanagement', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				]);
	}	
	/*
	 * Allows the admin to enable and disable the user 
	 */
	public function actionChangeuserstatus()
	{
		Yii::$app->controller->enableCsrfValidation = false;
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new Users();
		$status = $_POST['status'];
		$userid = $_POST['userid'];		
		
		$user = $model->findIdentity($userid);
		$email = $user->email;
		if(!empty($user))
		{
			$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
			$siteName = $sitesetting->sitename;
			if($status=="block")
			{
				$user->userstatus = "0";
				$user->hoststatus = "0";
				$user->save();

				$hostid = $user->id;
				$listdata = Listing::find()->where(['userid'=>$hostid])->all();
				foreach($listdata as $list)
				{
				  $list->liststatus = "2";
				  $list->save(false);
				} 

				Yii::$app->mailer->compose ( 'userblock', [
						'name' => $user->firstname,
						'siteName' => $siteName,
						'sitesetting' => $sitesetting,
						] )->setFrom ( $sitesetting->noreplyemail )
						->setTo ( $email )
						->setSubject ( 'Your account blocked' )->send ();				
				echo "success";
			}
			else if($status=="unblock")
			{
				$user->userstatus = "1";
				$user->save();

				$hostid = $user->id;
				$listdata = Listing::find()->where(['userid'=>$hostid])->all();
				if(count($listdata) > 0) {
					$user->hoststatus = "1";
               $user->save();

					foreach($listdata as $list)
					{
					  if(isset($list->bookingstyle) && $list->bookingstyle!="")
					  	$list->liststatus = "1";
					  else
					  	$list->liststatus = "0";
					  $list->save(false);    
					} 
				} 
 
				Yii::$app->mailer->compose ( 'userunblock', [
						'name' => $user->firstname,
						'siteName' => $siteName,
						'sitesetting' => $sitesetting,
						] )->setFrom ( $sitesetting->noreplyemail )
						->setTo ( $email )
						->setSubject ( 'Your account unblocked' )->send ();				
				echo "success";
			}
		}
		else
		{
			echo "error";
		}
	}
	
	/*
	 * Allows the admin to enable and disable the host
	*/
	public function actionChangehoststatus()
	{
		Yii::$app->controller->enableCsrfValidation = false;
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new Users();
		$status = $_POST['status'];
		$userid = $_POST['userid'];
	
		$user = $model->findIdentity($userid);
		$email = $user->email;
		if(!empty($user))
		{
			if($status=="block")
			{
				$user->hoststatus = "0";
				$user->save();
				$hostid = $user->id;
				$listdata = Listing::find()->where(['userid'=>$hostid])->all();
				foreach($listdata as $list)
				{
					$list->liststatus = "2";
					$list->save(false);
				}
				Yii::$app->mailer->compose ( 'hostblock', [
						'name' => $user->firstname,
						'sitesetting' => $sitesetting,
						] )->setFrom ( $sitesetting->noreplyemail )
						->setTo ( $email )
						->setSubject ( 'Your host account has been blocked' )->send ();
				echo "success";
			}
			else if($status=="unblock")
			{
				$user->hoststatus = "1";
				$user->save();
				$hostid = $user->id;
				$listdata = Listing::find()->where(['userid'=>$hostid])->all();
				foreach($listdata as $list)
				{
					if((isset($list->bookingstyle) && $list->bookingstyle!="") && (isset($list->bookingavailability) && $list->bookingavailability!=""))
					$list->liststatus = "1";
					else
					$list->liststatus = "0";  
					$list->save(false);
				}				
				Yii::$app->mailer->compose ( 'hostunblock', [
						'name' => $user->firstname,
						'sitesetting' => $sitesetting,
						] )->setFrom ( $sitesetting->noreplyemail )
						->setTo ( $email )
						->setSubject ( 'Your host account has been unblocked' )->send ();
				echo "success";
			}
		}
		else
		{
			echo "error";
		}
	}	
	
	/*
	 * Allows the admin to enable and disable the list
	*/	
	public function actionChangeliststatus()
	{
		Yii::$app->controller->enableCsrfValidation = false;
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new Users();
		$status = $_POST['status'];
		$listid = $_POST['listid'];
		
		$listdata = Listing::find()->where(['id'=>$listid])->one();
		$userid = $listdata->userid;
	
		$user = $model->findIdentity($userid);
		$email = $user->email;
		if(!empty($user))
		{
			if($status=="block")
			{
				$listdata->liststatus = "2";
				$listdata->save(false);
				/*Yii::$app->mailer->compose ( 'listblock', [
						'name' => $user->firstname,
						'sitesetting' => $sitesetting,
						] )->setFrom ( $sitesetting->noreplyemail )
						->setTo ( $email )
						->setSubject ( 'Your list has been blocked' )->send ();*/
				echo "success";
			}
			else if($status=="unblock")
			{
				$listdata->liststatus = "1";
				$listdata->save(false);
				/*Yii::$app->mailer->compose ( 'listunblock', [
						'name' => $user->firstname,
						'sitesetting' => $sitesetting,
						] )->setFrom ( $sitesetting->noreplyemail )
						->setTo ( $email )
						->setSubject ( 'Your list has been unblocked' )->send ();*/
				echo "success";
			}
		}
		else
		{
			echo "error";
		}
	}
	public function actionActivelisting()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }
		 $blockeduserids = array();
		 $blockedusers = Users::find()->where(['hoststatus' => '0'])
						->andWhere(['!=', 'user_level', 'god'])
		 				->all();

		 if($blockedusers){
		 	foreach ($blockedusers as $value) {
		 		$blockeduserids[] = $value->id;
		 	}
		 	 
		 }
		  $searchModel = new Listingsearch();
		 if($blockeduserids){
		 	$dataProvider = $searchModel->activesearch(Yii::$app->request->queryParams,$blockeduserids);
		 }else{
		 	$dataProvider = $searchModel->activesearch(Yii::$app->request->queryParams);
		 }
		return $this->render('activelisting', [
		   'searchModel' => $searchModel,
		   'dataProvider' => $dataProvider,
		 ]);
	}	
	public function actionBlockedlisting()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }
		 $blockeduserids = array();
		 $blockedusers = Users::find()->where(['hoststatus' => '0'])
						->andWhere(['!=', 'user_level', 'god'])
		 				->all();

		 if($blockedusers){
		 	foreach ($blockedusers as $value) {
		 		$blockeduserids[] = $value->id;
		 	}
		 	 
		 }


		 $searchModel = new Listingsearch();
		 if($blockeduserids){
		 	$dataProvider = $searchModel->blocksearch(Yii::$app->request->queryParams,$blockeduserids);
		 }else{
		 	$dataProvider = $searchModel->blocksearch(Yii::$app->request->queryParams);
		 }
		 //print_r($blockeduserids);die;
		return $this->render('blockedlisting', [
		   'searchModel' => $searchModel,
		   'dataProvider' => $dataProvider,
		 ]);
	}	
	public function actionAlterliststatus()
	{
		Yii::$app->controller->enableCsrfValidation = false;
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$status = $_POST['status'];
		$listid = $_POST['listid'];
		$listdata = Listing::find()->where(['id'=>$listid])->one();
		
		if(!empty($listdata))
		{
			if($status=="block")
			{
				$listdata->liststatus = "2";
				$listdata->save(false);
				echo "success";
			}
			else if($status=="unblock")
			{
				$listdata->liststatus = "1";
				$listdata->save(false);
				echo "success";
			}else if($status =="hostblock")
			{
				echo "error";
			}
		}
		else
		{
			echo "error";
		}
	}
	/*
	 * Allows the admin to change listing features.
	*/
	public function actionAlterfeaturelist()
	{
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		Yii::$app->controller->enableCsrfValidation = false;

		$listid = $_POST['listid'];
		$featured = $_POST['featured'];
		$listdata = Listing::find()->where(['id'=>$listid])->one();

		if( !empty($listdata) )
		{
			$listdata->featuredlist = $featured;
			$listdata->featuredate = time();  
			$listdata->save(false);
			echo 'true';
		}
		else
		{
			echo "false";
		}
	}
	/*
	 * Allows the admin to manage the user. It lists all the blocked users
	*/	
	public function actionBlockedusermanagement()
	{
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
        $searchModel = new Userssearch();
        $dataProvider = $searchModel->searchunblockusers(Yii::$app->request->queryParams);

        return $this->render('blockedusermanagement', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}	

	/**
	 * Function to get the user detail
	 */
	public function actionGetuserdetails()
	{
		$this->layout = false;
		$model = new Users();
		$userid = $_POST['userid'];
		$userdata = $model->findIdentity($userid);
		$referred = $model->getUserinvites($userid);
		return $this->render('getuserdetails',[
				'model' => $model,
				'userdata' => $userdata,
				'referred' => $referred
				]);
	}
	
	/**
	 * Function to send the message to the user
	 */
	public function actionSendmessage()
	{
		$this->layout = false;
		$model = new Messages();
		$userid = $_POST['userid'];	
		$message = $_POST['message'];
		$model->senderid = Yii::$app->user->identity->id;
		$model->receiverid = $userid;
		$model->message = $message;
		$model->receiverread = "0";
		$model->messagetype="admin";
		$model->save();
		
			$receiverid = $userid;
	    	$userid = Yii::$app->user->identity->id;
	    	$notifyto = $receiverid;
	    	$notifymessage = "sent you a message";
	    	$message = $message;
	    	$logdatas = $this->addlog('admin',$userid,$notifyto,'',$notifymessage,$message);		
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
	 * Function to save site related details like site name, title, logo image etc...
	 */
	public function actionSitemanagement()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$models = new Sitesettings();
	
		$uploadmodel = new \yii\xupload\models\XUploadForm ();
		if (Yii::$app->request->post () ) {
			$basepath = Yii::$app->basePath;
			$frontendurl = str_replace('backend','frontend',$basepath);
			$path = realpath ( Yii::$app->basePath . "/web/images/" ) . "/";
			$usrimgpth = realpath ( $frontendurl . "/web/albums/images/users/" ) . "/";
			/*$model = new \yii\xupload\models\XUploadForm ();
			$model->file = UploadedFile::getInstances ( $model, 'file' );
			if(!empty($model->file))
			{
				if ($model->file[0] !== null) {
					$filename0 = "logoblack." . $model->file[0]->getExtension ();
						$model->file[0]->saveAs ( $path . $filename0 );
						chmod ( $path . $filename0, 0777 );
				}
				if ($model->file[1] !== null) {
					$filename1 = "logowhite." . $model->file[1]->getExtension ();
						$model->file[1]->saveAs ( $path . $filename1 );
						chmod ( $path . $filename1, 0777 );
				}
				if ($model->file[2] !== null) {
					$filename2 = "usrimg.jpg";
					$model->file[2]->saveAs ( $usrimgpth . $filename2 );
					chmod ( $usrimgpth . $filename2, 0777 );
				}				
			}*/
			$sitesetting = $models->findIdentity();
			if(empty($sitesetting))
			{
				$sitesetting = new Sitesettings();
				$sitesetting->id = "1";
			}
			$filename0 = $_POST['logoblackfile'];
			$filename1 = $_POST['logowhitefile'];
			$filename2 = $_POST['defaultuserimagefile'];
			$filename3 = $_POST['faviconfile'];
			
			$sitesetting->sitelogoblack = $filename0;
			$sitesetting->sitelogowhite = $filename1;
			$sitesetting->defaultuserimage = $filename2;
			$sitesetting->defaultfavicon = $filename3; 
			$sitesetting->sitename = $_POST['sitename'];
			$sitesetting->sitetitle = $_POST['sitetitle'];
			$sitesetting->metakey = $_POST['metakey'];
			$sitesetting->metadesc = $_POST['metadesc'];
			$sitesetting->googleapikey = $_POST['googleapikey'];
			$sitesetting->welcomeemail = $_POST['welcomeemail'];
			$sitesetting->hour_booking = $_POST['hour_booking'];
			$sitesetting->fcmKey = $_POST['fcmKey'];
			//$sitesetting->pricerange = $_POST['pricerange'];
			$sitesetting->save();
			Yii::$app->response->redirect ( array (
					'sitemanagement'
			) );			
		}
		$sitesetting = $models->findIdentity();
		$socialLinks = json_decode($sitesetting->footercontent);

		return $this->render('sitemanagement',[
				'sitesetting' => $sitesetting,
				'socialLinks' => $socialLinks,
				]);	
	}
	
	public function actionStartfileupload()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }
		$id = $_POST['id'];
		if ( 0 < $_FILES['file']['error'] ) {
			//echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		$ftmp = $_FILES['file']['tmp_name'];
		$oname = $_FILES['file']['name'];
		$fname = $_FILES['file']['name'];
		$fsize = $_FILES['file']['size'];
		$ftype = $_FILES['file']['type'];   

		$imageSize = ($fsize / 1024) / 1024;
		if(trim($ftype) == "image/jpeg" || trim($ftype) == "image/jpg" || trim($ftype) == "image/png" || trim($ftype) == "image/x-icon") { 
			$ext = strrchr($oname, '.');
			$basepath = Yii::$app->basePath; 
			if($id=="defaultuserimage")
			{
				$frontendurl = str_replace('backend','frontend',$basepath);			
				$usrimgpth = realpath ( $frontendurl . "/web/albums/images/users/" ) . "/";
				$usrimg = "usrimg.jpg";
			}
			else if($id=="logoblack" || $id=="logowhite")
			{
				$usrimgpth = realpath ( Yii::$app->basePath . "/web/images/" ) . "/";
				$usrimg = $id.$ext;
			}
			else if($id=="bannerforapp" || $id=="bannerimg")
			{
				$frontendurl = str_replace('backend','frontend',$basepath);			
				$usrimgpth = realpath ( $frontendurl . "/web/albums/images/homepage/" ) . "/";
				$usrimg = $id.$ext;
			}
			else if($id=="favicon")
			{
				$usrimgpth = realpath ( Yii::$app->basePath . "/web/images/" ) . "/";
				$usrimg = $id.$ext;   
			}
			$result = move_uploaded_file($ftmp,$usrimgpth.$usrimg); 
		} elseif ($imageSize >= 2 || $imageSize == 0) {
			$usrimg = "size_error";  
		} else {
			$usrimg = "type_error";
		} 
		echo $usrimg;  
	} 
	
	public function actionStartcountryfileupload()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }
		if ( 0 < $_FILES['file']['error'] ) {
			//echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		$ftmp = $_FILES['file']['tmp_name'];
		$oname = $_FILES['file']['name'];
		$fname = $_FILES['file']['name'];
		$fsize = $_FILES['file']['size'];
		$ftype = $_FILES['file']['type'];
		$imageSize = ($fsize / 1024) / 1024;
		if(trim($ftype) == "image/jpeg" || trim($ftype) == "image/jpg" || trim($ftype) == "image/png") {
			$ext = strrchr($oname, '.');
			$basepath = Yii::$app->basePath;
			$frontendurl = str_replace('backend','frontend',$basepath);
			$usrimgpth = realpath ( $frontendurl . "/web/albums/images/country/" ) . "/";
			$usrimg = "country_".time().$ext;
			$result = move_uploaded_file($ftmp,$usrimgpth.$usrimg);
		} elseif ($imageSize >= 2 || $imageSize == 0) {
			$usrimg = "size_error";  
		} else {
			$usrimg = "type_error";
		}  
		echo $usrimg;
	}
	
	public function actionStartadditionalfileupload()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }
		if ( 0 < $_FILES['file']['error'] ) {
			//echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		$ftmp = $_FILES['file']['tmp_name'];
		$oname = $_FILES['file']['name'];
		$fname = $_FILES['file']['name'];
		$fsize = $_FILES['file']['size'];
		$ftype = $_FILES['file']['type'];
		$imageSize = ($fsize / 1024) / 1024;
		if(trim($ftype) == "image/jpeg" || trim($ftype) == "image/jpg" || trim($ftype) == "image/png") {
			$ext = strrchr($oname, '.');
			$basepath = Yii::$app->basePath;
			$frontendurl = str_replace('backend','frontend',$basepath);
			$usrimgpth = realpath ( $frontendurl . "/web/albums/images/additional/" ) . "/";
			$usrimg = "additional_".time().$ext;
			$result = move_uploaded_file($ftmp,$usrimgpth.$usrimg);
		} elseif ($imageSize >= 2 || $imageSize == 0) {
			$usrimg = "size_error";  
		} else {
			$usrimg = "type_error";
		} 
		echo $usrimg;
	}
	
	public function actionStartcommonfileupload()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }
		if ( 0 < $_FILES['file']['error'] ) {
			//echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		$ftmp = $_FILES['file']['tmp_name'];
		$oname = $_FILES['file']['name'];
		$fname = $_FILES['file']['name'];
		$fsize = $_FILES['file']['size'];
		$ftype = $_FILES['file']['type'];
		$imageSize = ($fsize / 1024) / 1024;
		if(trim($ftype) == "image/jpeg" || trim($ftype) == "image/jpg" || trim($ftype) == "image/png") {
			$ext = strrchr($oname, '.');
			$basepath = Yii::$app->basePath;
			$frontendurl = str_replace('backend','frontend',$basepath);
			$usrimgpth = realpath ( $frontendurl . "/web/albums/images/common/" ) . "/";
			$usrimg = "additional_".time().$ext;
			$result = move_uploaded_file($ftmp,$usrimgpth.$usrimg);
		} elseif ($imageSize >= 2 || $imageSize == 0) {
			$usrimg = "size_error";  
		} else {
			$usrimg = "type_error";
		}  
		echo $usrimg;
	}
	
	public function actionStartspecialfileupload()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }
		if ( 0 < $_FILES['file']['error'] ) {
			//echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		$ftmp = $_FILES['file']['tmp_name'];
		$oname = $_FILES['file']['name'];
		$fname = $_FILES['file']['name'];
		$fsize = $_FILES['file']['size'];
		$ftype = $_FILES['file']['type'];
		$imageSize = ($fsize / 1024) / 1024;
		if(trim($ftype) == "image/jpeg" || trim($ftype) == "image/jpg" || trim($ftype) == "image/png") {
			$ext = strrchr($oname, '.');
			$basepath = Yii::$app->basePath;
				$frontendurl = str_replace('backend','frontend',$basepath);
				$usrimgpth = realpath ( $frontendurl . "/web/albums/images/special/" ) . "/";
				$usrimg = "additional_".time().$ext;
			$result = move_uploaded_file($ftmp,$usrimgpth.$usrimg);
		} elseif ($imageSize >= 2 || $imageSize == 0) {
			$usrimg = "size_error";  
		} else {
			$usrimg = "type_error";
		}
		echo $usrimg;
	}	
	
	/**
	 * Function to handle the social login configuration in 
	 * the admin panel for the facebook and google.
	 */
	public function actionMobilesmssettings(){
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }
		$models = new Sitesettings();
		$sitesetting = $models->findIdentity();
		$smsSettings = $sitesetting->smssettings;
		$smsSettingsDetails = json_decode($smsSettings, true);
		if (Yii::$app->request->post ()) {
			$smsSettingsDetails['facebook']['secret'] = $_POST['facebooksecret'];
			$smsSettingsDetails['facebook']['appid'] = $_POST['facebookappid'];
			$encodeSmsSettings = json_encode($smsSettingsDetails);
			$sitesetting->smssettings = $encodeSmsSettings;
			$sitesetting->save(false);
		}
		if(!empty($smsSettings)){
			if(isset($smsSettingsDetails['facebook']['appid'])){
				$models->facebooksecret = $smsSettingsDetails['facebook']['secret'];
				$models->facebookappid = $smsSettingsDetails['facebook']['appid'];
			}
		}
		//$models->setScenario('sociallogin');
		return $this->render('mobilesmssettings',[
				'model' => $models
		]);

	}
	
	/**
	 * Function to handle the social login configuration in 
	 * the admin panel for the facebook and google.
	 */
	public function actionSocialloginsettings(){
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }
		$models = new Sitesettings();
		$sitesetting = $models->findIdentity();
		$socialSettings = $sitesetting->socialid;
		$socialSettingsDetails = json_decode($socialSettings, true);
		if (Yii::$app->request->post ()) {
			$socialSettingsDetails['socialstatus'] = $_POST['socialstatus'];
			$socialSettingsDetails['facebook']['status'] = $_POST['facebookstatus'];
			$socialSettingsDetails['facebook']['secret'] = $_POST['facebooksecret'];
			$socialSettingsDetails['facebook']['appid'] = $_POST['facebookappid'];
			$socialSettingsDetails['google']['status'] = $_POST['googlestatus'];
			$socialSettingsDetails['google']['secret'] = $_POST['googlesecret'];
			$socialSettingsDetails['google']['appid'] = $_POST['googleappid'];
			
			$encodeSocialSettings = json_encode($socialSettingsDetails);
			$sitesetting->socialid = $encodeSocialSettings;
			$sitesetting->save(false);
		}
		if(!empty($socialSettings)){
			if(isset($socialSettingsDetails['socialstatus']))
			$models->socialstatus = $socialSettingsDetails['socialstatus'];
			if(isset($socialSettingsDetails['facebook']['status'])){
				$models->facebookstatus = $socialSettingsDetails['facebook']['status'];
				$models->facebooksecret = $socialSettingsDetails['facebook']['secret'];
				$models->facebookappid = $socialSettingsDetails['facebook']['appid'];
			}
			if(isset($socialSettingsDetails['google']['status'])){
				$models->googlestatus = $socialSettingsDetails['google']['status'];
				$models->googlesecret = $socialSettingsDetails['google']['secret'];
				$models->googleappid = $socialSettingsDetails['google']['appid'];	
			}
		}
		//$models->setScenario('sociallogin');
		return $this->render('socialloginsettings',[
				'model' => $models
		]);
	}
	
	/**
	 * Function to handle the footer
	 * social icon url and contact us 
	 * information.
	 * 
	 */
	Public function actionFootersettings(){
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }
		$models = new Sitesettings();
		$sitesetting = $models->findIdentity();
		$footerSettings = $sitesetting->footercontent;
		$footerSettingsDetails = json_decode($footerSettings, true);

		if (Yii::$app->request->post ()) {
			$footerSettingsDetails['facebookLink'] = $_POST['facebookLink'];
			$footerSettingsDetails['googleLink'] = $_POST['googleLink'];
			$footerSettingsDetails['twitterLink'] = $_POST['twitterLink'];
			$footerSettingsDetails['linkedinLink'] = $_POST['linkedinLink'];
			$footerSettingsDetails['youtubeLink'] = $_POST['youtubeLink'];
			$footerSettingsDetails['pinterestLink'] = $_POST['pinterestLink'];
			$footerSettingsDetails['instagramLink'] = $_POST['instagramLink'];

			$footerSettingsDetails['ioslinkstatus'] = $_POST['ioslinkstatus'];
			$footerSettingsDetails['ioslink'] = $_POST['ioslink'];
			$footerSettingsDetails['androidlinkstatus'] = $_POST['androidlinkstatus'];
			$footerSettingsDetails['androidlink'] = $_POST['androidlink'];

			//$footerSettingsDetails['address'] = $_POST['address'];
			//$footerSettingsDetails['phone'] = $_POST['phone'];
			//$footerSettingsDetails['email'] = $_POST['email']; 
				
			$encodeFooterSettings = json_encode($footerSettingsDetails);
			$sitesetting->footercontent = $encodeFooterSettings;
			$sitesetting->save(false);
		}
		if(!empty($footerSettings)){
			//echo $footerSettingsDetails['androidlink']; exit;
			$models->facebookLink = $footerSettingsDetails['facebookLink'];
			$models->googleLink = $footerSettingsDetails['googleLink'];
			$models->twitterLink = $footerSettingsDetails['twitterLink'];
			$models->linkedinLink = $footerSettingsDetails['linkedinLink'];
			$models->youtubeLink = $footerSettingsDetails['youtubeLink'];
			$models->pinterestLink = $footerSettingsDetails['pinterestLink'];
			$models->instagramLink = $footerSettingsDetails['instagramLink'];
			$models->address = $footerSettingsDetails['address'];
			$models->ioslink = $footerSettingsDetails['ioslink'];
			$models->androidlink = $footerSettingsDetails['androidlink'];
			$models->phone = $footerSettingsDetails['phone'];
			$models->email = $footerSettingsDetails['email'];	

			$models->androidlinkstatus = $footerSettingsDetails['androidlinkstatus'];			
			$models->ioslinkstatus = $footerSettingsDetails['ioslinkstatus'];	 		
		}
		//$models->setScenario('sociallogin');
		return $this->render('footersettings',[
				'model' => $models
		]);
	}
	
	/**
	 * Function to save site noreply email, smtp name, email and password
	 */
	public function actionEmailmanagement()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   } 
		$models = new Sitesettings([
				]);
		$uploadmodel = new \yii\xupload\models\XUploadForm ();
		
		if (Yii::$app->request->post () && $models->validate()) {
			if($models->validate())
			{
				$sitesetting = $models->findIdentity();
				if(empty($sitesetting))
				{
					$sitesetting = new Sitesettings();
					$sitesetting->id = "1";
				}
				$sitesetting->supportemail = $_POST['supportemail'];
				$sitesetting->noreplyname = $_POST['noreplyname'];
				$sitesetting->noreplyemail = $_POST['noreplyemail'];
				$sitesetting->noreplypassword = $_POST['noreplypassword'];
				$sitesetting->gmail_smtp = $_POST['smtpenable'];
				if(isset($_POST['smtpport']))
				$sitesetting->smtp_port = $_POST['smtpport'];
				else
				$sitesetting->smtp_port = "";
				$sitesetting->save();
			Yii::$app->getSession ()->setFlash ( 'success', 'Successfully saved' );
			return $this->redirect(['/emailmanagement']);	
			}	
			else
			{
				return Yii::error($models);
			}		
		}
		else
		{
		//	return $models->errors();
		}
		$sitesetting = $models->findIdentity();
		return $this->render('emailmanagement',[
				'sitesetting' => $sitesetting,
				'models' => $models
				]);	
	}
	
	/**
	 * Function to save the listing properties like bed count, bedrooms count, bathroom count and accommodates count
	 */
	public function actionListingproperties()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Listingproperties();
		if (Yii::$app->request->post () ) {
			$listing = $model->findIdentity();
			if(empty($listing))
			{
				$listing = new Listingproperties();
				$listing->id = "1";
			}
			$listing->bedrooms = $_POST['bedrooms'];
			$listing->beds = $_POST['beds'];
			$listing->bathrooms = $_POST['bathrooms'];
			$listing->accommodates = $_POST['accommodates'];
			$listing->save();
			Yii::$app->response->redirect ( array (
					'listingproperties'
			) );			
		}
		$listing = $model->findIdentity();
		return $this->render('listingproperties',[
				'listing' => $listing
				]);		
	}
	
	/**
	 * Function to manage the additional amenities
	 */
	public function actionAdditionalamenities()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Additionalamenities();
		$amenities = $model->findallidentity();
		//$amenities = $model->search();
		$searchModel = new Additionalamenities();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('additionalamenities',[
				'amenities' => $amenities,
				'model' => $model,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider
				]);	
	}
	
	/**
	 * Function to add additional amenities
	 */
	public function actionAddadditionalamenity()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Additionalamenities();
		
		if (Yii::$app->request->post () ) {
			$model->name = $_POST['amenityname'];
			$model->description = $_POST['amenitydesc'];
			$model->save();
			$amenities = $model->findallidentity();
			Yii::$app->getSession ()->setFlash ( 'success', 'Additional amenity saved' );
			Yii::$app->response->redirect ( array (
					'additionalamenities'
			) );			
		}
		return $this->render('addadditionalamenity');
	}
	
	/**
	 * Function to manage the common amenities
	 */
	public function actionCommonamenities()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Commonamenities();
		$amenities = $model->findallidentity();
		return $this->render('commonamenities',[
				'amenities' => $amenities,
				]);
	
	}
	
	public function actionHomepagesettings()
	{

		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Homepagesettings();
		$homesettings = Homepagesettings::find()->where(['id'=>'1'])->one();
		if (Yii::$app->request->post () ) {
			//$path = realpath ( Yii::$app->basePath . "/web/images/homepage/" ) . "/";
			/*$model = new \yii\xupload\models\XUploadForm ();
			$model->file = UploadedFile::getInstances ( $model, 'file' );
			if(!empty($model->file))
			{
				if ($model->file[0] !== null) {
					$filename0 = "banner." . $model->file[0]->getExtension ();
					$model->file[0]->saveAs ( $path . $filename0 );
					chmod ( $path . $filename0, 0777 );
				}
				if ($model->file[1] !== null) {
					$filename1 = "bannerapp." . $model->file[1]->getExtension ();
					$model->file[1]->saveAs ( $path . $filename1 );
					chmod ( $path . $filename1, 0777 );
				}
			
			}*/
			
			//$filename0 = $_POST['bannerimgfile'];
			//$filename1 = $_POST['bannerforappfile'];
				
			/*if(isset($homesettings) && !empty($homesettings))
			{
				$homesettings->id = $homesettings->id;	
				$bannerimage = $homesettings->banner;
				$bannerimageforapp = $homesettings->bannerforapp;
			}
			else	
			{
				$homesettings = new Homepagesettings();
				$bannerimage = "";
			}
			/*if(!empty($filename0))
			{
				$homesettings->banner = $filename0;
			}
			else
			{
				$homesettings->banner = $bannerimage;
			}*/
			
			/*if(!empty($filename1))
			{
				$homesettings->bannerforapp = $filename1;
			}
			else
			{
				$homesettings->bannerforapp = $bannerimageforapp;
			}*/
			 
			$homesettings->bannertitle = $_POST['bannertitle'];
			$homesettings->bannerdesc = $_POST['bannerdesc'];
			$homesettings->placescount = $_POST['placescount'];
			$homesettings->placesdesc = $_POST['placesdesc'];
			$homesettings->bannertextcolor = "";  
			$homesettings->customerscount = $_POST['customerscount'];
			$homesettings->customersdesc = $_POST['customersdesc'];
			$homesettings->supporttime = $_POST['supporttime'];
			$homesettings->supportdesc = $_POST['supportdesc'];//print_r($homesettings);die; 
			$homesettings->save(false);

			Yii::$app->getSession ()->setFlash ( 'success', 'Successfully updated' );
			return $this->redirect('homepagesettings');
		}
		return $this->render('homepagesettings',[
				'homesettings' => $homesettings
				]);
	}
	
	/**
	 * Function to add common amenities
	 */
	public function actionAddcommonamenity()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Commonamenities();
	
		if (Yii::$app->request->post () ) {
			$model->name = $_POST['amenityname'];
			$model->description = $_POST['amenitydesc'];
			$model->save();
			$amenities = $model->findallidentity();
			Yii::$app->getSession ()->setFlash ( 'success', 'Common amenity saved' );
			/*Yii::$app->response->redirect ( array (
					'commonamenities'
			) );*/
		}
		return $this->render('addcommonamenity');
	}	
	
	public function actionEmailmanage()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Sitesettings();
		if($model->validate())
		{
			echo "dfg";
		}
		else
		{
			echo "dsfsd";
		}
	}
	
	/*
	 * Function to add slider images
	 */
	public function actionAddbuttonslider()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Buttonsliders();
		if (Yii::$app->request->post () ) {
			$path = realpath ( Yii::$app->basePath . "/web/images/buttonsliders/" ) . "/";
			$models = new \yii\xupload\models\XUploadForm ();
			$models->file = UploadedFile::getInstances ( $models, 'file' );
			if(!empty($models->file))
			{
				if ($models->file[0] !== null) {
					$filename0 = time().".". $models->file[0]->getExtension ();
					$models->file[0]->saveAs ( $path . $filename0 );
					chmod ( $path . $filename0, 0777 );
				}
			}
			$model->sliderimage = $filename0;
			$model->title = $_POST['Buttonsliders']['title'];
			$model->description = $_POST['Buttonsliders']['description'];
			$model->buttonname = $_POST['Buttonsliders']['buttonname'];
			$model->buttonlink = $_POST['Buttonsliders']['buttonlink'];
			$model->save();
		}
		return $this->render('addbuttonslider',[
				'model' => $model
				]);		
	}
	
	public function actionPaypalsettings()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Sitesettings();
		if (Yii::$app->request->post () ) {
			$sitesetting = $model->findIdentity();
			$sitesetting->paypalid = $_POST['paypalemailid'];
			$sitesetting->paymenttype = $_POST['paymenttype'];
			$paypaladaptive = array();
			$paypaladaptive['paymentMode'] = 'adaptive';
			$paypaladaptive['apiUserId'] = $_POST['apiuserid'];
			$paypaladaptive['apiPassword'] = $_POST['apipassword'];
			$paypaladaptive['apiSignature'] = $_POST['apisignature'];
			$paypaladaptive['apiApplicationId'] = $_POST['appid'];
			$paypal = json_encode($paypaladaptive);
			$sitesetting->paypaladaptive = $paypal;
			$sitesetting->braintreepaymenttype = $_POST['braintreepaymenttype'];
			$sitesetting->braintreemerchantid = $_POST['braintreemerchantid'];
			$sitesetting->braintreepublickey = $_POST['braintreepublickey'];
			$sitesetting->braintreeprivatekey = $_POST['braintreeprivatekey'];
			//print_r($sitesetting);die;
			$sitesetting->save();
		}
		$sitesetting = $model->findIdentity();
		return $this->render('paypalsettings',[
				'model' => $sitesetting
				]);
	}
	
	public function actionLanguage()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$language = $_GET['language'];
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
		return $this->redirect(\Yii::$app->request->getReferrer());
	}
	
	public function actionTermsandconditions()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Homepagesettings();
		$homesettings = Homepagesettings::find()->where(['id'=>'1'])->one();
		if (Yii::$app->request->post () ) {
			//print_r($_POST);die;
			$homesettings->sub_termsandconditions = $_POST['Homepagesettings']['sub_termsandconditions'];
			$homesettings->main_termsandconditions = $_POST['Homepagesettings']['main_termsandconditions'];
			$homesettings->save(false);
		}
		return $this->render('termsandconditions',[
				'model' => $model,
				'homesettings' => $homesettings
				]);		
	
	}

	public function actionGooglecodesettings()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Sitesettings();
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		if (Yii::$app->request->post () ) {
			//print_r($_POST);die;
			$sitesetting->googleanalyticsactive = $_POST['googleanalyticsactive'];
			$sitesetting->googleanalyticscode = $_POST['googleanalyticscode'];
			$sitesetting->google_webmaster_link = $_POST['google_webmaster_link'];
			$sitesetting->save(false);
		}
		return $this->render('googlecodesettings',[
				'model' => $model,
				'sitesetting' => $sitesetting
				]);			
	}

	public function actionSeomanagement()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Sitesettings();
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		if (Yii::$app->request->post () ) {


			$footerSettings = $sitesetting->footercontent;
			$footerSettingsDetails = json_decode($footerSettings, true);

			/*
			$footerSettingsDetails['facebookLink'] = $_POST['facebooklink'];
			$footerSettingsDetails['googleLink'] = $_POST['googlelink'];
			$footerSettingsDetails['twitterLink'] = $_POST['twitterlink'];
			$footerSettingsDetails['linkedinLink'] = $_POST['linkedinlink'];
			$footerSettingsDetails['youtubeLink'] = $_POST['youtubelink'];
			$footerSettingsDetails['pinterestLink'] = $_POST['pinterestlink'];
			$footerSettingsDetails['instagramLink'] = $_POST['instagramlink'];
			$footerSettingsDetails['address'] = (isset($_POST['address']) && $_POST['address'] != '') ? $_POST['address']:$footerSettingsDetails['address'];
			$footerSettingsDetails['phone'] = (isset($_POST['phone']) && $_POST['phone'] != '') ? $_POST['phone']:$footerSettingsDetails['phone'];
			*/
			$footerSettingsDetails['email'] = (isset($_POST['email']) && $_POST['email'] != '') ? $_POST['email']:$footerSettingsDetails['email'];
			$encodeFooterSettings = json_encode($footerSettingsDetails);

			$sitesetting->sitetitle = $_POST['sitetitle'];
			$sitesetting->metakey = $_POST['metakey'];
			$sitesetting->metadesc = $_POST['metadesc'];
			//$sitesetting->footercontent = $encodeFooterSettings;
			$sitesetting->googleanalyticscode = $_POST['googleanalyticscode'];
			$sitesetting->google_webmaster_link = $_POST['google_webmaster_link'];
			$sitesetting->save(false);
		}
		return $this->render('seomanagement',[
				'model' => $model,
				'sitesetting' => $sitesetting
				]);
	}



    public function actionAutoupdatecurrency()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$status=$_POST['status'];
		$model = new Sitesettings();
		$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
		$value = "empty";
		if ($status==0 || $status==1) {
			$sitesetting->autoupdate_currency = $status;
			$sitesetting->save(false); 
			$value = Myclass::currencyUpdateCron();	
		}
		echo $value;
		die; 
	}

	public function actionUpdatecurrencyprice()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		Myclass::currencyUpdateCron();
	}
	public function actionGetcurrencyvalue()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$Sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
		if($Sitesettings->autoupdate_currency==1)
        {
				$dynamic=$_POST['currency'];
				$defaultCur = Currency::find()->where(['defaultcurrency'=>'1'])->one();
				if(!empty($defaultCur))
				{	
					$default=$defaultCur->currencycode;
					echo $amt=Myclass::currencyConverter($default,$dynamic,1);
				}
		}
	}

	//STRIPE UPDATION
	public function actionStripesettings()
	{
		if (Yii::$app->user->isGuest) {
	      return $this->goHome ();
	   }

		$model = new Sitesettings();
		$sitesetting = $model->findIdentity();
		if (Yii::$app->request->post () ) {	
			$stripeCard = array();
			$stripeCard['stripe_card'] = trim($_POST['stripe_card']);
			$stripeCard['stripe_month'] = trim($_POST['stripe_month']);
			$stripeCard['stripe_year'] = trim($_POST['stripe_year']);
			$stripeCard['stripe_cvc'] = trim($_POST['stripe_cvc']);
			
			if(isset($_POST['stripe_hostpaydays']) && trim($_POST['stripe_hostpaydays'])>2) {
				$payout_days = trim($_POST['stripe_hostpaydays']);
			} else {
				$payout_days = 2;
			}

			$stripeCard['stripe_hostpaydays'] = $payout_days;
			$sitesetting->stripe_publishkey = $_POST['stripe_publishkey'];
			$sitesetting->stripe_secretkey  = $_POST['stripe_secretkey'];
			$sitesetting->stripe_card_details  = json_encode($stripeCard); 
			$sitesetting->save();
		}
		return $this->render('stripesettings',[
				'model' => $sitesetting
				]);
	}
}
