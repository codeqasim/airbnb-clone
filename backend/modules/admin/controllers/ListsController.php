<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Lists;
use backend\models\Listssearch;
use backend\models\Users;
use frontend\models\Wishlists;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ListsController implements the CRUD actions for Lists model.
 */
class ListsController extends Controller
{
    public function behaviors()
    {
        /*return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];*/
        return [];
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
        $searchModel = new Listssearch();
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
        $model = new Lists();
        if ($model->load(Yii::$app->request->post())) {
            $listname = $_POST['Lists']['listname'];
            $createdby = $_POST['Lists']['createdby'];
            $listdata = Lists::find()->where(['listname'=>$listname,'createdby'=>$createdby])->one();
            if(count($listdata)==0)
            {
                $model->createdby = $createdby;
                $model->user_create = 0;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'List name already added' );
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
            $listname = $_POST['Lists']['listname'];
            $createdby = $_POST['Lists']['createdby'];
            $listdata = Lists::find()->where(['listname'=>$listname,'createdby'=>$createdby])
                                     ->andWhere(['!=','id',$id])
                                     ->one();
            if(count($listdata)==0)
            {
                $model->createdby = $createdby;
                $model->user_create = 0;
                $model->save();
                //return $this->redirect(['view', 'id' => $model->id]);
                return $this->redirect('index');
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
    	$wishlists = Wishlists::find()->where(['listid'=>$id])->all();  

        if(count($wishlists)==0)
        {
        	Yii::$app->getSession ()->setFlash ( 'success', "Wishlist deleted successfully" ); 
        	$this->findModel($id)->delete(); 
        } else {
        	Yii::$app->getSession ()->setFlash ( 'success', "Can't delete wishlist, listing exist" );
        }

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
        if (($model = Lists::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
