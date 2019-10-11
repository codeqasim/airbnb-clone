<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Homecountries;
use backend\models\Homecountriessearch;
use backend\models\Users;
use backend\models\Sitesettings; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HomecountriesController implements the CRUD actions for Homecountries model.
 */
class HomecountriesController extends Controller
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
     * Lists all Homecountries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Homecountriessearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Homecountries model.
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
     * Creates a new Homecountries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Homecountries();

        if ($model->load(Yii::$app->request->post())) {

            $homecountries = Homecountries::find()->where(['countryid'=>$_POST['Homecountries']['countryid']])->one();
            if(count($homecountries)==0)
            {

                $countryidname = $_POST['Homecountries']['countryid'];
                $countryvals = explode("-",$countryidname);
                $countryid = $countryvals[0];
                $countryname = $countryvals[1];
                $countryname = str_replace(" ","-",$countryname);
                $placename = str_replace(" ", "-", $countryname);
                //$details_url = "http://maps.googleapis.com/maps/api/geocode/json?address='".$placename."'&sensor=false";

                $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
                $details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$placename."&sensor=false&key=".trim($sitesettings->googleapikey);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $details_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = json_decode(curl_exec($ch),true);
                // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
                if ($response['status'] != 'OK') {
                    return null;
                }
                
                //print_r($response);
                //print_r($response['results'][0]['geometry']['location']);
                
                $latLng = $response['results'][0]['geometry']['location'];
                
                $lat = $latLng['lat'];
                $lng = $latLng['lng'];
                // $lat = "";
                // $lng = "";
                $model->countryid = $countryid;
                $model->imagename = $_POST['countryimgfile'];
                $model->latitude = $lat;
                $model->longitude = $lng;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'Country already added' );
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Homecountries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         if ($model->load(Yii::$app->request->post())) {
            $homecountries = Homecountries::find()->where(['countryid'=>$_POST['Homecountries']['countryid']])
                                                  ->andWhere(['!=','id',$id])
                                                  ->one();
                if(count($homecountries)==0)
                {
                    $countryidname = $_POST['Homecountries']['countryid'];
                    $countryvals = explode("-",$countryidname);
                    $countryid = $countryvals[0];
                    $countryname = $countryvals[1];
                    $placename = str_replace(" ", "-", $countryname);

                     $sitesettings = Sitesettings::find()->where(['id'=>'1'])->one();
                     $details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$placename."&sensor=false&key=".trim($sitesettings->googleapikey);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $details_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $response = json_decode(curl_exec($ch), true);
                    //print_r($response);
                    // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
                    if ($response['status'] != 'OK') {
                        return null;
                    }
                    
                    //print_r($response);
                    //print_r($response['results'][0]['geometry']['location']);
                    
                    $latLng = $response['results'][0]['geometry']['location'];
                    
                    $lat = $latLng['lat'];
                    $lng = $latLng['lng'];
                    // $lat = "";
                    // $lng = "";
                    $model->countryid = $countryid;
                    $model->imagename = $_POST['countryimgfile'];
                    $model->latitude = $lat;
                    $model->longitude = $lng;
                    $model->save(false);
                    return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'Country already added' );
                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Homecountries model.
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
     * Finds the Homecountries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Homecountries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Homecountries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
