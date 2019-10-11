<?php

namespace backend\modules\admin\controllers;
/*
 * This controller file used to add, edit and delete listing properties
*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
*/
use Yii;
use backend\models\Additionalamenities;
use backend\models\Additionallisting;
use backend\models\Additionalamenitiessearch;
use backend\models\Commonamenities;
use backend\models\Commonlisting;
use backend\models\Commonamenitiessearch;
use backend\models\Safetycheck;
use backend\models\Safetylisting; 
use backend\models\Safetychecksearch;
use backend\models\Speciallisting;
use backend\models\Specialfeatures;
use backend\models\Specialfeaturessearch;
use backend\models\Hometype;
use backend\models\Hometypesearch;
use backend\models\Roomtype;
use backend\models\Listing;
use backend\models\Users;
use backend\models\Listingsearch;
use backend\models\Roomtypesearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ListingController implements the CRUD actions for Additionalamenities model.
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
	public function beforeAction($action) {
		$this->enableCsrfValidation = false;
        if (Yii::$app->user->isGuest) {
          return $this->goHome ();
        }
		return parent::beforeAction($action);
	}
	
	public function actionIndex($id)
	   {
            //Yii::$app->getSession ()->setFlash ( 'error', 'Invalid access' ); 
            //return $this->redirect(['/']);
		   $searchModel = new Listingsearch();
		   $dataProvider = $searchModel->activelisting(Yii::$app->request->queryParams,$id);  
	
		   return $this->render('index', [ 
			   'searchModel' => $searchModel,
			   'dataProvider' => $dataProvider,
		   ]); 
	   }


    public function actionBlockedindex($id)
       {
           $searchModel = new Listingsearch();
           $dataProvider = $searchModel->blockerlisting(Yii::$app->request->queryParams,$id);
            
           return $this->render('blockedindex', [ 
               'searchModel' => $searchModel,
               'dataProvider' => $dataProvider,
           ]);
       }	

    /**
     * Lists all Additionalamenities models.
     * @return mixed
     */
    public function actionAdditionalindex()
    {
        $searchModel = new Additionalamenitiessearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('additionalindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Additionalamenities model.
     * @param integer $id
     * @return mixed
     */
    public function actionAdditionalview($id)
    {
        return $this->render('additionalview', [
            'model' => $this->findadditionalModel($id),
        ]);
    }

    /**
     * Creates a new Additionalamenities model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdditionalcreate()
    {
        $model = new Additionalamenities(
        		['scenario'=>'additional']
        		);
        $model->cdate = time();

        if ($model->load(Yii::$app->request->post())) {
			$model->cdate = time();
			$model->name = $_POST['Additionalamenities']['name'];
			$model->description = $_POST['Additionalamenities']['description'];
			$model->additionalimage = $_POST['Additionalamenities']['additionalimgfile'];
			$model->save(false);
            return $this->redirect(['additionalview', 'id' => $model->id]);
        } else {
            return $this->render('additionalcreate', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Additionalamenities model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAdditionalupdate($id)
    {
        $model = $this->findadditionalModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->cdate = time();
			$model->name = $_POST['Additionalamenities']['name'];
			$model->description = $_POST['Additionalamenities']['description'];
			$model->additionalimage = $_POST['Additionalamenities']['additionalimgfile'];
			$model->save(false);			
            return $this->redirect(['additionalview', 'id' => $model->id]);
        } else {
            return $this->render('additionalupdate', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Additionalamenities model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAdditionaldelete($id)
    {   
        $additionalListing = Additionallisting::find()->where(['amenityid'=>$id])->all();  

        if(count($additionalListing)==0)
        {
            Yii::$app->getSession ()->setFlash ( 'success', "Amenity deleted successfully" ); 
            $this->findadditionalModel($id)->delete();
        } else {
            Yii::$app->getSession ()->setFlash ( 'success', "Can't delete amenity, exist in listing" );
        }

        return $this->redirect(['additionalindex']); 
    }

    /**
     * Finds the Additionalamenities model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Additionalamenities the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findadditionalModel($id)
    {
        if (($model = Additionalamenities::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Lists all Commonamenities models.
     * @return mixed
     */
    public function actionCommonindex()
    {
    	$searchModel = new Commonamenitiessearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	return $this->render('commonindex', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			]);
    }
    
    /**
     * Displays a single Commonamenities model.
     * @param integer $id
     * @return mixed
     */
    public function actionCommonview($id)
    {
    	return $this->render('commonview', [
    			'model' => $this->findcommonModel($id),
    			]);
    }
    
    /**
     * Creates a new Commonamenities model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCommoncreate()
    {
    	$model = new Commonamenities(
    			['scenario'=>'common']
    			);
    	$model->cdate = time();
    	if ($model->load(Yii::$app->request->post())) {
			$model->cdate = time();
			$model->name = $_POST['Commonamenities']['name'];
			$model->description = $_POST['Commonamenities']['description'];
			$model->commonimage = $_POST['Commonamenities']['commonimgfile'];
			$model->save(false);			
    		return $this->redirect(['commonview', 'id' => $model->id]);
    	} else {
    		return $this->render('commoncreate', [
    				'model' => $model,
    				]);
    	}
    }
    
    /**
     * Updates an existing Commonamenities model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCommonupdate($id)
    {
    	$model = $this->findcommonModel($id);
    
    	if ($model->load(Yii::$app->request->post())) {
			$model->cdate = time();
			$model->name = $_POST['Commonamenities']['name'];
			$model->description = $_POST['Commonamenities']['description'];
			$model->commonimage = $_POST['Commonamenities']['commonimgfile'];
			$model->save(false);				
    		return $this->redirect(['commonview', 'id' => $model->id]);
    	} else {
    		return $this->render('commonupdate', [
    				'model' => $model,
    				]);
    	}
    }
    
    /**
     * Deletes an existing Commonamenities model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCommondelete($id)
    {

        $commonListing = Commonlisting::find()->where(['amenityid'=>$id])->all();  

        if(count($commonListing)==0)
        {
            Yii::$app->getSession ()->setFlash ( 'success', "Amenity deleted successfully" ); 
            $this->findcommonModel($id)->delete();
        } else {
            Yii::$app->getSession ()->setFlash ( 'success', "Can't delete amenity, exist in listing" );
        }
  
        return $this->redirect(['commonindex']);   
    }
    
    /**
     * Finds the Commonamenities model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Commonamenities the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findcommonModel($id)
    {
    	if (($model = Commonamenities::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }    
    
    /**
     * Lists all Safetycheck models.
     * @return mixed
     */
    public function actionSafetyindex()
    {
    	$searchModel = new Safetychecksearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	return $this->render('safetyindex', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			]);
    }
    
    /**
     * Displays a single Safetycheck model.
     * @param integer $id
     * @return mixed
     */
    public function actionSafetyview($id)
    {
    	return $this->render('safetyview', [
    			'model' => $this->findsafetyModel($id),
    			]);
    }
    
    /**
     * Creates a new Safetycheck model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSafetycreate()
    {
    	$model = new Safetycheck([
    			'scenario'=>'safetycheck'
    			]);
    	$model->cdate = time();
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['safetyview', 'id' => $model->id]);
    	} else {
    		return $this->render('safetycreate', [
    				'model' => $model,
    				]);
    	}
    }
    
    /**
     * Updates an existing Safetycheck model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSafetyupdate($id)
    {
    	$model = $this->findsafetyModel($id);
    
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['safetyview', 'id' => $model->id]);
    	} else {
    		return $this->render('safetyupdate', [
    				'model' => $model,
    				]);
    	}
    }
    
    /**
     * Deletes an existing Safetycheck model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSafetydelete($id)
    {
        $safetyListing = Safetylisting::find()->where(['safetyid'=>$id])->all();  

        if(count($safetyListing)==0)
        {
            Yii::$app->getSession ()->setFlash ('success',"Safety check deleted successfully");
            $this->findsafetyModel($id)->delete();
        } else {
            Yii::$app->getSession ()->setFlash ( 'success', "Can't delete safety checklist, exist in listing" );
        } 
    
    	return $this->redirect(['safetyindex']);
    }
    
    /**
     * Finds the Safetycheck model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Safetycheck the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findsafetyModel($id)
    {
    	if (($model = Safetycheck::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    } 

    /**
     * Lists all Specialfeatures models.
     * @return mixed
     */
    public function actionSpecialindex()
    {
    	$searchModel = new Specialfeaturessearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	return $this->render('specialindex', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			]);
    }
    
    /**
     * Displays a single Specialfeatures model.
     * @param integer $id
     * @return mixed
     */
    public function actionSpecialview($id)
    {
    	return $this->render('specialview', [
    			'model' => $this->findspecialModel($id),
    			]);
    }
    
    /**
     * Creates a new Specialfeatures model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSpecialcreate()
    {
    	$model = new Specialfeatures([
    			'scenario'=>'specialfeatures'
    			]);
    	$model->cdate = time();
    	if ($model->load(Yii::$app->request->post())) {
			$model->cdate = time();
			$model->name = $_POST['Specialfeatures']['name'];
			$model->description = $_POST['Specialfeatures']['description'];
			$model->specialimage = $_POST['Specialfeatures']['specialimgfile'];
			$model->save(false);			
    		return $this->redirect(['specialview', 'id' => $model->id]);
    	} else {
    		return $this->render('specialcreate', [
    				'model' => $model,
    				]);
    	}
    }
    
    /**
     * Updates an existing Specialfeatures model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSpecialupdate($id)
    {
    	$model = $this->findspecialModel($id);
    
    	if ($model->load(Yii::$app->request->post())) {
			$model->cdate = time();
			$model->name = $_POST['Specialfeatures']['name'];
			$model->description = $_POST['Specialfeatures']['description'];
			$model->specialimage = $_POST['Specialfeatures']['specialimgfile'];
			$model->save(false);			
    		return $this->redirect(['specialview', 'id' => $model->id]);
    	} else {
    		return $this->render('specialupdate', [
    				'model' => $model,
    				]);
    	}
    }
    
    /**
     * Deletes an existing Specialfeatures model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSpecialdelete($id) 
    {
        $specialListing = Speciallisting::find()->where(['specialid'=>$id])->all();  

        if(count($specialListing)==0)
        {
            Yii::$app->getSession()->setFlash('success',"Special features deleted successfully");
            $this->findspecialModel($id)->delete();
        } else {
            Yii::$app->getSession ()->setFlash ( 'success', "Can't delete special features, exist in listing" );
        } 

    	return $this->redirect(['specialindex']);
    } 
    
    /**
     * Finds the Specialfeatures model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Specialfeatures the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findspecialModel($id)
    {
    	if (($model = Specialfeatures::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }    
    
    /**
     * Lists all Hometype models.
     * @return mixed
     */
    public function actionHomeindex()
    {
    	$searchModel = new Hometypesearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	return $this->render('homeindex', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			]);
    }
    
    /**
     * Sets the priority for home types
     */
    public function actionHomepriority()
    {
    	$model = new Hometype();
    	$hometypes = Hometype::find('all')->all();
    	if (Yii::$app->request->post())
    	{
    		$home = Hometype::find()->where(['id'=>$_POST['hometype']])->one();
    		$existpriority = Hometype::find()->where(['priority'=>$_POST['priority']])->one();
    		//echo count($existpriority);die;
    		if(count($existpriority)>0)
    		{
    			$existpriority->id = $existpriority->id;
    			$existpriority->priority = $home->priority;
    			$existpriority->save();
    		}
    		$home->id = $_POST['hometype'];
    		$home->priority = $_POST['priority'];			
    		$home->save();
			Yii::$app->getSession ()->setFlash ( 'success', 'Successfully set priority' );
			return $this->redirect(['homeindex']);			
    	}
    	return $this->render('homepriority',[
    			'model'=>$model,
    			'hometypes'=>$hometypes
    			]);
    }
    
    /**
     * Displays a single Hometype model.
     * @param integer $id
     * @return mixed
     */
    public function actionHomeview($id)
    {
    	return $this->render('homeview', [
    			'model' => $this->findhomeModel($id),
    			]);
    }
    
    /**
     * Creates a new Hometype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionHomecreate()
    {
    	$model = new Hometype([
    			'scenario'=>'home'
    			]);
    
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['homeview', 'id' => $model->id]);
    	} else {
    		return $this->render('homecreate', [
    				'model' => $model,
    				]);
    	}
    }
    
    /**
     * Updates an existing Hometype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionHomeupdate($id)
    {
    	$model = $this->findhomeModel($id);
    
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['homeview', 'id' => $model->id]);
    	} else {
    		return $this->render('homeupdate', [
    				'model' => $model,
    				]);
    	}
    }
    
    /**
     * Deletes an existing Hometype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionHomedelete($id)
    {   
        $Listing = Listing::find()->where(['hometype'=>$id])->all();  

        if(count($Listing)==0)
        {
            Yii::$app->getSession()->setFlash('success',"Home type deleted successfully");
            $this->findhomeModel($id)->delete();
        } else {
            Yii::$app->getSession ()->setFlash ( 'success', "Can't delete home type, exist in listing" );
        }   

    	return $this->redirect(['homeindex']);
    }
    
    /**
     * Finds the Hometype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hometype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findhomeModel($id)
    {
    	if (($model = Hometype::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    } 

    /**
     * Lists all Roomtype models.
     * @return mixed
     */
    public function actionRoomindex()
    {
    	$searchModel = new Roomtypesearch();
    	$model = Roomtype::find('all')->all();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	return $this->render('roomindex', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'model' => $model
    			]);
    }
    
    /**
     * Displays a single Roomtype model.
     * @param integer $id
     * @return mixed
     */
    public function actionRoomview($id)
    {
    	return $this->render('roomview', [
    			'model' => $this->findroomModel($id),
    			]);
    }
    
    /**
     * Creates a new Roomtype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionRoomcreate()
    {
    	$model = new Roomtype([
    			'scenario'=>'room'
    			]);
    			$Roommodel = Roomtype::find('all')->all();
      if(count($Roommodel) < 3){
    
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['roomview', 'id' => $model->id]);
    	} else {
    		return $this->render('roomcreate', [
    				'model' => $model,
    				]);
    	}
    	}else{
    		 Yii::$app->session->setFlash ( 'success', 'Cannot create more than three roomtype' );
   		 $this->redirect(['roomindex']);
    	}
    }
    
    /**
     * Updates an existing Roomtype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRoomupdate($id)
    {
    	$model = $this->findroomModel($id);
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['roomview', 'id' => $model->id]);
    	} else {
    		return $this->render('roomupdate', [
    				'model' => $model,
    				]);
    	}
    
    }
    
    /**
     * Deletes an existing Roomtype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRoomdelete($id)
    {
        $Listing = Listing::find()->where(['roomtype'=>$id])->all();  

        if(count($Listing)==0)
        {
            Yii::$app->getSession()->setFlash('success',"Room type deleted successfully");
            $this->findroomModel($id)->delete();
        } else {
            Yii::$app->getSession ()->setFlash ( 'success', "Can't delete room type, exist in listing" );
        }  	
    
    	return $this->redirect(['roomindex']);
    }
    
    /**
     * Finds the Roomtype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Roomtype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findroomModel($id)
    {
    	if (($model = Roomtype::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }    

}
