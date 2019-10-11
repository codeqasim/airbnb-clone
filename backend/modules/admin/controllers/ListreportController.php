<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Userreports;
use backend\models\Userreportsearch;
use backend\models\Listreportsearch;
use backend\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ListsController implements the CRUD actions for Lists model.
 */
class ListreportController extends Controller
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
     * Lists all Lists models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Listreportsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //echo '<pre>'; print_r($dataProvider); exit;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lists model.
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
     * Creates a new Lists model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profilereports();
        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>'; print_r($_POST['Profilereports']); exit;
            $reportname = $_POST['Profilereports']['report'];
            $shortdesc = $_POST['Profilereports']['shortdesc'];
            $report_type = $_POST['Profilereports']['reporttype'];

            $reportData = Userreport::find()->where(['report'=>$reportname,'shortdesc'=>$shortdesc])->one();
            if(count($reportData)==0)
            {
                $model->report = $reportname;
                $model->shortdesc = $shortdesc;
                $model->report_type = $report_type;
                $model->created_time = date('Y-m-d h:i:s');
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'ReportName already added' );
                return $this->redirect('index');                
            }              
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Lists model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $reportname = $_POST['Profilereports']['report'];
            $shortdesc = $_POST['Profilereports']['shortdesc'];
            $report_type = $_POST['Profilereports']['reporttype'];
            $listdata = Userreport::find()->where(['report'=>$reportname,'shortdesc'=>$shortdesc])
                                     ->andWhere(['!=','id',$id])
                                     ->one();
            if(count($listdata)==0)
            {
                $model->report = $reportname;
                $model->shortdesc = $shortdesc;
                $model->report_type = $report_type;
                $model->created_time = date('Y-m-d h:i:s');
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'List name already added' );
                return $this->redirect('index');                
            } 
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Lists model.
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
     * Finds the Lists model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lists the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userreports::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
