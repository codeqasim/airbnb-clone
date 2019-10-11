<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use Yii;
use backend\models\Buttonsliders;
use backend\models\Buttonsliderssearch;
use backend\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ButtonsliderController implements the CRUD actions for Buttonsliders model.
 */
class ButtonsliderController extends Controller
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
     * Lists all Buttonsliders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Buttonsliderssearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Buttonsliders model.
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
     * Creates a new Buttonsliders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$model = new Buttonsliders();
		if (Yii::$app->request->post () ) {
			$path = realpath ( Yii::$app->basePath . "/web/images/buttonsliders/" ) . "/";
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
			$model->title = $_POST['Buttonsliders']['title'];
			$model->description = $_POST['Buttonsliders']['description'];
			$model->buttonname = $_POST['Buttonsliders']['buttonname'];
			$model->buttonlink = $_POST['Buttonsliders']['buttonlink'];
			$model->save();
			Yii::$app->getSession ()->setFlash ( 'success', 'Slider added successfully' );
			return $this->redirect(['index']);
		}
		return $this->render('create',[
				'model' => $model
				]);	
    }

    /**
     * Updates an existing Buttonsliders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$path = realpath ( Yii::$app->basePath . "/web/images/buttonsliders/" ) . "/";
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
     * Deletes an existing Buttonsliders model.
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
     * Finds the Buttonsliders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Buttonsliders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Buttonsliders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
