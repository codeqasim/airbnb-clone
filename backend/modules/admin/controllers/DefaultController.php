<?php

namespace backend\modules\admin\controllers;

/*
 * @Company: Hitasoft Technology Solutions Private Limited
 * @Framework : Yii
 * @Version: 2.0
 */

use yii\web\Controller;

class DefaultController extends Controller
{
	 public function beforeAction($action) {
        return $this->goHome ();
        $this->enableCsrfValidation = false;
        if (Yii::$app->user->isGuest) {
          return $this->goHome (); 
        } 

        return parent::beforeAction($action);
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
}
