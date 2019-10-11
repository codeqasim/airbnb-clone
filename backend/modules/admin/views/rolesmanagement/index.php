<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Listssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Manage Roles and Priviliges');
$this->params['subtitle'] = '';
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage All Roles').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="lists-index">

<br />
    <p>
        <?= Html::a(Yii::t('app', 'Create Role'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'amenities']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
	        'class' => 'news-v2 margin-bottom-50',
	        'id' => false
	    ],
        'columns' => [
            

           [
		'attribute' => 'id',
		'label' => Yii::t('app','ID')
	    ],
			
            [
		'attribute' => 'name',
		'label' => Yii::t('app','Role Name')
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
				'label'=>''. Yii::t('app','Role Description').'',
				'value'=>function($model){ return substr($model->description, 0, 35).'..'; }
			],
            [
				'label'=>''. Yii::t('app','Created Date').'',
				'value'=>function($model){ return date('M d-Y', strtotime($model->created_time)); }
			],
            [
			 'class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{update}{delete}',
			 'buttons'=>[
                              'view' => function ($url, $model) {
								$urls = explode("?",$url);
								
								$url2 = Yii::$app->urlManager->createAbsoluteUrl ('admin/rolesmanagement/view'.'?'.$urls[1] );
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url2, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
							  },
                              'update' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = Yii::$app->urlManager->createAbsoluteUrl ('admin/rolesmanagement/update'.'?'.$urls[1] );
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
							  },
                              'delete' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = Yii::$app->urlManager->createAbsoluteUrl ('admin/rolesmanagement/delete'.'?'.$urls[1] );
                                return Html::a('', ['delete', 'id' => $model->id], [
								'class' => 'glyphicon glyphicon-trash',
								'data' => [
									'confirm' => ''. Yii::t('app','Are you sure you want to delete this item?').'',
									'method' => 'post',
								],
								]);
								
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