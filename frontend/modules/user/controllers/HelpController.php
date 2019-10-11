<?php

namespace frontend\modules\user\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use backend\models\Homepagesettings;

use Yii;
use frontend\models\Help;
use frontend\models\Helpsearch;
use frontend\models\Helptopic;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Users; 

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

    public function beforeAction($action)
    {
        
        if (!(Yii::$app->user->isGuest)) {
            $loguserid = \Yii::$app->user->identity->id;
            $logUserDetails = Users::find()->where(['id' => $loguserid])->One();
            if(isset($logUserDetails->userstatus)) {
                if($logUserDetails->userstatus == "0") {
                     return $this->redirect(['/']);
                }
            } else {
                return $this->redirect(['/']);
            }  
        }  
        return true;
    }   

    /**
     * Lists all Help models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Helpsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Help::find('all')->all();

        $topicModel = Helptopic::find()
        ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'model' => $model,
            'topicModel' => $topicModel
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
    
    public function actionTerms()
    {
    	$model = Homepagesettings::find()->where(['id'=>'1'])->one();
    	return $this->render('terms', [
    			'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
