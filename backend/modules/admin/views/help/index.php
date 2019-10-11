 <?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HelpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Helps';
$this->params['breadcrumbs'][] = '';
$this->params['subtitle'] = ''. Yii::t('app','Help Pages').'';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Help Pages').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="help-index">

<br />
    <p>
        <?= Html::a(''. Yii::t('app','Create Help').'', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'help']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
         [
		'attribute' => 'name',
		'label' => Yii::t('app','Name')
	    ], 

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}{delete}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                    $urls = explode("?",$url);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'View'),
                    ]);
                  },
                  'update' => function ($url, $model) {
                    $urls = explode("?",$url);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'Update'),
                    ]);
                  },
                  'delete' => function ($url, $model) {
                    $urls = explode("?",$url);
                    
                    if($model->id>1) 
                    {
                        return Html::a('', ['delete', 'id' => $model->id], [
                            'class' => 'glyphicon glyphicon-trash',
                            'data' => [
                                'confirm' => ''. Yii::t('app','Are you sure, want to delete this report?').'',
                                'method' => 'post', 
                            ],
                        ]); 
                    }
                  }
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end() ?>
</div>
<?php
	echo '</div>
		</div>
		</div>
        </div>';

