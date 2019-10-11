<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Textsliders;
use backend\models\Textsliderssearch;
use backend\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TextsliderController implements the CRUD actions for Textsliders model.
 */
class TextsliderController extends Controller
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
     * Lists all Textsliders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Textsliderssearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Textsliders model.
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
     * Creates a new Textsliders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$model = new Textsliders();
		if (Yii::$app->request->post () ) {
			$path = realpath ( Yii::$app->basePath . "/web/images/textsliders/" ) . "/";
			$models = new \yii\xupload\models\XUploadForm ();
			$models->file = UploadedFile::getInstances ( $models, 'file' );
			if(!empty($models->file))
			{
				if ($models->file[0] !== null) {
					$filename0 = time().".". $models->file[0]->getExtension ();
					$models->file[0]->saveAs ( $path . $filename0 );
					chmod ( $path . $filename0, 0777 );
				}
			}
			$model->sliderimage = $filename0;
			$model->slidertext = $_POST['Textsliders']['slidertext'];
			$model->save();
			Yii::$app->getSession ()->setFlash ( 'success', 'Slider added successfully' );
			return $this->redirect(['index']);
		}
		return $this->render('create',[
				'model' => $model
				]);	
    }

    /**
     * Updates an existing Textsliders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$path = realpath ( Yii::$app->basePath . "/web/images/textsliders/" ) . "/";
			$models = new \yii\xupload\models\XUploadForm ();
			$models->file = UploadedFile::getInstances ( $models, 'file' );
			if(!empty($models->file))
			{
				if ($models->file[0] !== null) {
					$filename0 = time().".". $models->file[0]->getExtension ();
					$models->file[0]->saveAs ( $path . $filename0 );
					chmod ( $path . $filename0, 0777 );
				}
			}
			if(isset($filename0) && $filename0!="")
			{
			$model->sliderimage = $filename0;
			}
			$model->save();
			return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Textsliders model.
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
     * Finds the Textsliders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Textsliders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Textsliders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
