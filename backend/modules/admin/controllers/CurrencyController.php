<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Currency;
use backend\models\Sitesettings;
use backend\models\CurrencySearch;
use backend\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Country;
use yii\helpers\ArrayHelper;
use backend\components\Myclass;

/**
 * CurrencyController implements the CRUD actions for Currency model.
 */
class CurrencyController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
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
     * Lists all Currency models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CurrencySearch();
        $settingModel =new Sitesettings();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $siteSettingData = Sitesettings::find()->where(['id'=>1])->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'siteSettingData' => $siteSettingData
        ]);
    }
 
    /**
     * Displays a single Currency model.
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
     * Creates a new Currency model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Currency();

        if ($model->load(Yii::$app->request->post())) {
            $currencycode = $_POST['Currency']['currencycode'];
            $countryname = $_POST['Currency']['countryname'];
            $currency = Currency::find()->where(['currencycode'=>$currencycode,'countryname'=>$countryname])->one();
            if(count($currency)==0)
            {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'Currency already added' );
                return $this->redirect('index');                
            }            
        } else {
        	return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionDefaultcurrency()
    {
        $model = Currency::find()->all();

        if (Yii::$app->request->post()) {
		$currencyid = $_POST['currencycode'];
		$defaultcurrency = Currency::find()->where(['defaultcurrency'=>'1'])->one();
		if(!empty($defaultcurrency))
		{
			$defaultcurrency->defaultcurrency = "0";		
			$defaultcurrency->save(false);
		}
		$currencydata = Currency::find()->where(['id'=>$currencyid])->one();
		$currencydata->defaultcurrency = "1";	
		$currencydata->save(false);
        /* new changes for currency updation */
            Myclass::currencyUpdateCron();
        /* new changes for currency updation */
            return $this->redirect(['index']);
        } else {
        	return $this->render('defaultcurrency', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Currency model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $siteSettingData = Sitesettings::find()->where(['id'=>1])->one();

        if ($model->load(Yii::$app->request->post())) {

            if(trim($_POST['Currency']['price']) == "" || trim($_POST['Currency']['price']) <= 0 || trim($_POST['Currency']['price']) > 500){
                Yii::$app->getSession ()->setFlash ( 'success', 'Currency price should be between 0 - 500' ); 
                return $this->redirect('index');  
            } else {
                $currencycode = $_POST['Currency']['currencycode'];
                $countryname = $_POST['Currency']['countryname'];
                $currency = Currency::find()->where(['currencycode'=>$currencycode,'countryname'=>$countryname])
                                            ->andWhere(['!=','id',$id])
                                            ->one();
                if(count($currency)==0)
                {
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else
                {
                    Yii::$app->getSession ()->setFlash ( 'success', 'Currency already added' );
                    return $this->redirect('index');                
                }
            }   
        } else {
        	return $this->render('update', [
                'model' => $model,
                'siteSetting'=>$siteSettingData,
            ]);
        }
    }

    /**
     * Deletes an existing Currency model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $updateReceiver = Users::find()->Where(['currency_mobile'=>$id])->count();

        if($updateReceiver > 0) {
          Users::updateAll(['currency_mobile' => 1], ['and',['=', 'currency_mobile', $id], ['>', 'id', 0]]); 
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Currency model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Currency the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Currency::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Find the country code based on the country
     * selected in the currency adding form
     * @param interger $id
     * @return appropriate country code
     */
    public function actionGetCountryCode($id){
    	$countryDetails = Country::findOne($id);
    	$countryCode = $countryDetails->code;
    	
    	return $countryCode;
    }

   
}
