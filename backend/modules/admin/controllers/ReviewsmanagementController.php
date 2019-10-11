<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */
use Yii;
use backend\models\Reviews;
use backend\models\Reviewssearch;
use backend\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * ListsController implements the CRUD actions for Lists model.
 */
class ReviewsmanagementController extends Controller
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
        $searchModel = new Reviewssearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        
        $model = new Reviews();
        if ($model->load(Yii::$app->request->post())) {

            //Post Values
            $rolename = $_POST['Roleandprivilige']['name'];
            $rolecomment = $_POST['Roleandprivilige']['comment'];
            $priviliges = json_encode($_POST['roles']);

            $reportData = Roleandprivilige::find()->where(['name'=>$rolename])->one();
            if(count($reportData)==0)
            {
                $model->name = $rolename;
                $model->comment = $rolecomment;
                $model->priviliges = $priviliges;
                $model->created_time = date('Y-m-d h:i:s');
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'Role Name already exist' );
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
            $rating = $_POST['Reviews']['rating'];
            $reviews = $_POST['Reviews']['review'];
           
                $model->rating = $rating;
                $model->review = $reviews;
                $model->cdate = $_POST['Reviews']['cdate'];
                $model->save();
                return $this->redirect( ['view', 'id' => $model->id] );
            
        }else{
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
        if (($model = Reviews::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}