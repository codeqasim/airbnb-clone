<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Help;
use backend\models\HelpSearch;
use backend\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HelpController implements the CRUD actions for Help model.
 */
class HelpController extends Controller
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
     * Lists all Help models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HelpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Help model.
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
     * Creates a new Help model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Help();
        if ($model->load(Yii::$app->request->post())) {

            $name = $_POST['Help']['name'];
            $topicid = $_POST['Help']['topicid']; 
            $subcontent = $_POST['Help']['subcontent'];
            $maincontent = $_POST['Help']['maincontent'];

            $helpData = Help::find()->where(['name'=>$name])->one();
            if(count($helpData)==0)
            {
                $model->name = $name;
                $model->topicid = ($topicid != NULL && $topicid > 0) ? $topicid : 0;  
                $model->subcontent = $subcontent;
                $model->maincontent = $maincontent;

                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'Help Name already exist' );
                return $this->redirect('index');                
            }              
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }  
    }

    /**
     * Updates an existing Help model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $name = $_POST['Help']['name'];
            $topicid = $_POST['Help']['topicid'];
            $subcontent = $_POST['Help']['subcontent'];
            $maincontent = $_POST['Help']['maincontent'];

            $model->name = $name;
            $model->topicid = ($topicid != NULL && $topicid > 0) ? $topicid : 0;
            $model->subcontent = $subcontent;
            $model->maincontent = $maincontent;
            $model->save();   
            return $this->redirect(['view', 'id' => $model->id]); 
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        } 
 
    }

    /**
     * Deletes an existing Help model.
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
     * Finds the Help model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Help the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Help::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
