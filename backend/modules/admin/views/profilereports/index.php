<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Listssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Manage Reports');
$this->params['subtitle'] = ''. Yii::t('app','Reports').'';
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage All Reports').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="lists-index">

<br />
    <p>
        <?= Html::a(Yii::t('app', 'Create Report'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'amenities']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          /* [
		'attribute' => 'id',
		'label' => Yii::t('app','ID')
	    ],*/
			
            [
		'attribute' => 'report',
		'label' => Yii::t('app','Report Name')
	    ],
			/*[
				'label' => ''. Yii::t('app','Created By').'',
				'value' => function($model)
				{
					$username = $model->getCreatedby0()->where(['id'=>$model->createdby])->one();
					return $username->firstname;
				}
			],*/
			[
				'label'=>''. Yii::t('app','Report Type').'',
				'value'=>'report_type'
			],
            [
				'label'=>''. Yii::t('app','Created Date').'',
				'value'=> function($model)
					{
						return date('M d, Y', strtotime($model->created_time));
					}
			],
            [
			 'class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{update}{delete}',
			 'buttons'=>[
                              'view' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'view'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
							  },
                              'update' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'update'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
							  },
                              'delete' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'delete'.'?'.$urls[1];
								$reportdata = $model->getReports()->where(['reportid'=>$model->id])->all(); 
								if(count($reportdata)==0)
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
?>
