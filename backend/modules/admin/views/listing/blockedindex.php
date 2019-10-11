<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Additionalamenitiessearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$baseUrl = Yii::$app->request->baseUrl;
$this->title = 'Manage Listings';
$this->params['subtitle'] = ''. Yii::t('app','Manage Listings').'';
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Listings').'</h2>
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
        'columns' => [

           [
		'attribute' => 'id',
		'label' => Yii::t('app','ID')
	    ],
            [
                'attribute' => 'listingname',
                'label' => Yii::t('app','Listingname'),
                'value' => function($model)
                        {
                            if(is_null($model->listingname) || trim($model->listingname) == ""){
                                return '-'; 
                            } else { 
                                return $model->listingname; 
                            }
                        }
            ],
            [
                'attribute' =>   'description', 
                'label' => Yii::t('app',  'Description'),
                'value' => function($model)
                        {
                            if(is_null($model->description) || trim($model->description) == ""){
                                return '-'; 
                            } else { 
                                return $model->description;  
                            }
                        }
            ],
            [
            'attribute' => 'nightlyprice',
            'label' => Yii::t('app','Price (per night)'),
            'value' => function($model)
                        {
                            if(is_null($model->nightlyprice) || trim($model->nightlyprice) == ""){
                                return '-'; 
                            } else { 
                                return $model->nightlyprice; 
                            }
                        }
            ],
            [
            'attribute' => 'hourlyprice',
            'label' => Yii::t('app','Price (per hour)'),
            'value' => function($model)
                {
                    if(is_null($model->hourlyprice) || trim($model->hourlyprice) == ""){
                        return '-'; 
                    } else { 
                        return $model->hourlyprice; 
                    }
                } 
            ],  
            /*[
                'attribute' => 'liststatus',
                'label' => Yii::t('app','Actions'),
                'format' => 'raw',
                'value' => function($model)
                {
                    if($model->liststatus=="1" || $model->liststatus=="0")
                        return '<div id="list'.$model->id.'"><input type="button" class="btn btn-success" value="'.Yii::t('app','Block').'" onclick="changeliststatus(\'block\','.$model->id.')"></div>';
                    else if($model->liststatus=="2")
                        return '<div id="list'.$model->id.'"><input type="button" class="btn btn-success" value="'.Yii::t('app','Unblock').'" onclick="changeliststatus(\'unblock\','.$model->id.')"></div>';
                }
            ]*/

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

