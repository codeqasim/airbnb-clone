<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Commission;
use backend\models\Commissionsearch;
use backend\models\Userdevices;
use backend\models\Users;
use frontend\models\Logs;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommissionController implements the CRUD actions for Commission model.
 */
class CommissionController extends Controller
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
     * Lists all Commission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Commissionsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Commission model.
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
     * Creates a new Commission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Commission();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $userdata = Users::find()->where(['hoststatus'=>'1'])->all();
            foreach ($userdata as $key => $value) {
                $receiverid = $value->id;
                $userid = Yii::$app->user->identity->id;
                $notifyto = $receiverid;
                $notifymessage = "created the commission";
                $message = "";
                $logdatas = $this->addlog('admin',$userid,$notifyto,'',$notifymessage,$message);                   
            }            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Commission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $userdata = Users::find()->where(['hoststatus'=>'1'])->all();
            foreach ($userdata as $key => $value) {
                $receiverid = $value->id;
                $userid = Yii::$app->user->identity->id;
                $notifyto = $receiverid;
                $notifymessage = "updated the commission";
                $message = "";
                $logdatas = $this->addlog('admin',$userid,$notifyto,'',$notifymessage,$message);                       
            }
            

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Commission model.
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
     * Finds the Commission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Commission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Commission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
}
