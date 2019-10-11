<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Users;
use backend\models\Roleandprivilige;
use backend\models\Usersearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ListsController implements the CRUD actions for Lists model.
 */
class ModeratorController extends Controller
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
        $searchModel = new Usersearch();
        $dataProvider = $searchModel->moderatorsearch(Yii::$app->request->queryParams);

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
        $model = new Users();

        $model->password = password_hash(Yii::$app->request->post('password'), PASSWORD_DEFAULT);

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $model->password = Users::hashPassword($model->password); // Hash the password before you save it.
        if($model->save())
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     ** Updates an existing Lists model.
     ** If update is successful, the browser will be redirected to the 'view' page.
     ** @param integer $id
     ** @return mixed
    */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
    		$moderatorid = \Yii::$app->user->identity->id;
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash( 'success', 'Moderator deleted successfully.' );  
    	   if(trim($moderatorid) == trim($id)) {
    	  		$baseUrl = Yii::$app->request->baseUrl; 
	         return $this->redirect(''.$baseUrl.'/');
    	   } else { 
        		return $this->redirect(['index']);
         }
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
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
