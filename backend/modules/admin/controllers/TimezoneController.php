<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Timezone;
use backend\models\Timezonesearch;
use backend\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TimezoneController implements the CRUD actions for Timezone model.
 */
class TimezoneController extends Controller
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
        Yii::$app->getSession ()->setFlash ( 'success', 'Page not found' );
        return $this->goHome ();

        
        $this->enableCsrfValidation = false;
        if (Yii::$app->user->isGuest) {
          return $this->goHome ();
        } 

        return parent::beforeAction($action);
    }  

    /**
     * Lists all Timezone models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Timezonesearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Timezone model.
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
     * Creates a new Timezone model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Timezone();

        if ($model->load(Yii::$app->request->post())) {
            $timezonename = $_POST['Timezone']['timezone'];
            $timezone = Timezone::find()->where(['timezone'=>$timezonename])->one();
            if(count($timezone)==0)
            {
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'Timezone already added' );
                return $this->redirect('index');                
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Timezone model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $timezonename = $_POST['Timezone']['timezone'];
            $timezone = Timezone::find()->where(['timezone'=>$timezonename])
                                        ->andWhere(['!=','id',$id])
                                        ->one();
            if(count($timezone)==0)
            {
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'Timezone already added' );
                return $this->redirect('index');                
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Timezone model.
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
     * Finds the Timezone model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Timezone the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Timezone::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
