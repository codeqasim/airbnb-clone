<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */
use Yii;
use backend\models\Roleandprivilige;
use backend\models\Roleandpriviligesearch;
use backend\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * ListsController implements the CRUD actions for Lists model.
 */
class RolesmanagementController extends Controller
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
        $searchModel = new Roleandpriviligesearch();
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
        
        $model = new Roleandprivilige();
        if ($model->load(Yii::$app->request->post())) {

            if(!isset($_POST['roles']))
            {
                Yii::$app->getSession()->setFlash('warning','Please assign roles');
                return $this->render('create', [
                            'model' => $model,
                        ]);
            }

            //Post Values
            $rolename = $_POST['Roleandprivilige']['name'];
            $rolecomment = $_POST['Roleandprivilige']['description'];
            $priviliges = json_encode($_POST['roles']);

            $reportData = Roleandprivilige::find()->where(['name'=>$rolename])->one();
            if(count($reportData)==0)
            {

                //echo '<pre>'; print_r($model); exit;
                $model->name = $rolename;
                $model->description = $rolecomment;
                $model->priviliges = $priviliges;
                $model->created_time = date('Y-m-d h:i:s');
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->getSession()->setFlash('warning','Rolename already exists.');
                return $this->render('create', [
                            'model' => $model,
                        ]); 
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
            $rolename = $_POST['Roleandprivilige']['name'];
            $rolecomment = $_POST['Roleandprivilige']['description'];
            $roles = json_encode($_POST['roles']);
            $listdata = Roleandprivilige::find()->where(['name'=>$rolename])
                                     ->andWhere(['!=','id',$id])
                                     ->one();
            if(count($listdata)==0)
            {
                $model->name = $rolename;
                $model->description = $rolecomment;
                $model->priviliges = $roles;
                $model->created_time = date('Y-m-d h:i:s');
                $model->save(false);
                return $this->redirect( ['view', 'id' => $model->id] );
            }
            else
            {
                Yii::$app->getSession ()->setFlash ( 'success', 'Role name already exist' );
                return $this->redirect('index');                
            } 
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
       $userdata = Users::find()->where(['userstatus'=>'2', 'privilige_id'=>$id])->all(); 
       if(count($userdata) == 0 && $id > 0) {
            $this->findModel($id)->delete();  
            Yii::$app->getSession()->setFlash( 'success', 'Role deleted successfully.' );
            return $this->redirect(['index']);
       } else {
            Yii::$app->getSession()->setFlash( 'success', "You have moderator access to this role, can't delete." ); 
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
        if (($model = Roleandprivilige::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}