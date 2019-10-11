<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Users;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Additionalamenitiessearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$baseUrl = Yii::$app->request->baseUrl;
$this->title = 'Blocked Listings';
$this->params['subtitle'] = ''. Yii::t('app','Blocked Listings').'';
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Blocked Listings').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="listings-index">

<?php Pjax::begin(['id' => 'currencyindex']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['id' => 'rowid'.$model['id']];
        },
        'columns' => [

           [
		'attribute' => 'id',
		'label' => Yii::t('app','ID')
	    ],
             [
                'attribute' => 'listingname',
                'label' => Yii::t('app','Listingname'),
            ],
          [
                'attribute' =>   'description', 
                'label' => Yii::t('app',  'Description'),
            ],
            [
                'label' => Yii::t('app','Per night price'), 
                'value' => function($model)
                {
                    if(is_null($model->nightlyprice)){
                        return '-';
                    }else{
                        return $model->nightlyprice;
                    }
                }
            ],
            [
                'label' => Yii::t('app','Per hour price'), 
                'value' => function($model)
                {
                    if(is_null($model->hourlyprice)){
                        return '-';
                    }else{
                        return $model->hourlyprice;
                    }
                }
            ],
            [
                //'attribute' => 'hourlyprice',
                'label' => Yii::t('app','Hostname'),
                'value' => function($model)
                {
                    $usernme = Users::find()->where(['id'=>$model->userid])->one();
                    return $usernme->firstname;
                }
            ],
            [
                'attribute' => 'liststatus',
                'label' => Yii::t('app','Actions'),
                'format' => 'raw',
                'value' => function($model)
                {
                    $userData = Users::find()->where(['id'=>$model->userid])->one();

                    if($userData->hoststatus == '0')
                    {
                        return '<div id="list'.$model->id.'"><input type="button" class="btn btn-success" value="'.Yii::t('app','Unblock').'" onclick="alert(\'Unblock the host account to move the listing to active.\');"></div>';
                    }else{


                    if($model->liststatus=="1" || $model->liststatus=="0")
                        return '<div id="list'.$model->id.'"><input type="button" class="btn btn-success" value="'.Yii::t('app','Block').'" onclick="alterliststatus(\'block\','.$model->id.')"></div>';
                    else if($model->liststatus=="2")
                        return '<div id="list'.$model->id.'"><input type="button" class="btn btn-success" value="'.Yii::t('app','Unblock').'" onclick="alterliststatus(\'unblock\','.$model->id.')"></div>';
                    }
                }
            ]

        ],
    ]); ?>

<?php Pjax::end() ?>
</div>
<?php
	echo '</div>
		</div>
		</div>
        </div>';
?>