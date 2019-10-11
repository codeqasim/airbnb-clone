<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Cancellation;
use backend\models\Cancellationsearch;
use backend\models\Userdevices;
use backend\models\Users;
use backend\models\Listing;
use frontend\models\Logs;
use yii\web\Controller;
use backend\components\Myclass;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CancellationController implements the CRUD actions for Cancellation model.
 */
class CancellationController extends Controller
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
     * Lists all Cancellation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Cancellationsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cancellation model.
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
     * Creates a new Cancellation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cancellation();
        if ($model->load(Yii::$app->request->post())) {
            $model->policyname = trim($_POST['Cancellation']['policyname']);
            $model->cancelfrom = 0;
            $model->cancelto = trim($_POST['Cancellation']['cancelto']);
            $model->cancelpercentage = trim($_POST['Cancellation']['cancelpercentage']);
            $model->save(false);

            $userdata = Users::find()->where(['hoststatus'=>'1'])->all();
            foreach ($userdata as $key => $value) {
                $receiverid = $value->id;
                $userid = Yii::$app->user->identity->id;
                $notifyto = $receiverid;
                $notifymessage = "created the cancellation policy";
                $message = "";
                $logdatas = $this->addlog('admin',$userid,$notifyto,'',$notifymessage,$message);
            }

            $query = new \yii\db\Query;
            $query->select(['hts_userdevices.user_id'])->from('hts_userdevices')
                ->leftJoin('hts_users', 'hts_users.id = hts_userdevices.user_id')
                ->where(['=', 'hts_users.hoststatus', '1'])
                ->groupBy('hts_userdevices.user_id');
            $command = $query->createCommand();
            $traverselist = $command->queryAll();
            foreach ($traverselist as $key => $value) {
                $userdevicedet = Userdevices::find()->where(['user_id'=>$value['user_id']])->all();
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
                           $messages['message'] = 'Admin created the cancellation policy';
                           $messages['type'] = 'notification';
                           
                           Myclass::pushnot($deviceToken,$messages,$badge);
                       }
                   }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cancellation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post())) {            
            $model->policyname = trim($_POST['Cancellation']['policyname']);
            $model->cancelfrom = 0;
            $model->cancelto = trim($_POST['Cancellation']['cancelto']);
            $model->cancelpercentage = trim($_POST['Cancellation']['cancelpercentage']); 
            $model->save(false);
            $userdata = Users::find()->where(['hoststatus'=>'1'])->all();
            foreach ($userdata as $key => $value) {
                $receiverid = $value->id;
                $userid = Yii::$app->user->identity->id;
                $notifyto = $receiverid;
                $notifymessage = "Updated the cancellation policy";
                $message = "";
                $logdatas = $this->addlog('admin',$userid,$notifyto,'',$notifymessage,$message);
            }             

            $query = new \yii\db\Query;
            $query->select(['hts_userdevices.user_id'])->from('hts_userdevices')
                ->leftJoin('hts_users', 'hts_users.id = hts_userdevices.user_id')
                ->where(['=', 'hts_users.hoststatus', '1'])
                ->groupBy('hts_userdevices.user_id');
            $command = $query->createCommand();
            $traverselist = $command->queryAll();
            foreach ($traverselist as $key => $value) {
                $userdevicedet = Userdevices::find()->where(['user_id'=>$value['user_id']])->all();
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
                           $messages['message'] = 'Admin updated the cancellation policy';
                           $messages['type'] = 'notification';
                           
                           Myclass::pushnot($deviceToken,$messages,$badge);
                       }
                   }
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cancellation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $listing = Listing::find()->where(['cancellation'=>$id])->all();  

        if(count($listing)==0)
        {
            Yii::$app->getSession ()->setFlash ( 'success', "Cancellation policy deleted successfully" ); 
            $this->findModel($id)->delete(); 
        } else {
            Yii::$app->getSession ()->setFlash ( 'success', "Can't delete cancellation, exist in listing" );
        }
 
        return $this->redirect(['index']);  
    }

    /**
     * Finds the Cancellation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cancellation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cancellation::findOne($id)) !== null) {
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
