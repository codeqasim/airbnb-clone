<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Safetychecksearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Safety Checklists';
$this->params['subtitle'] = Yii::t('app','Safety Checklists');
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Safety Checklists').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="safetycheck-index">

<br />
    <p>
        <?= Html::a(Yii::t('app', 'Create Safetycheck'), ['safetycreate'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'safety']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            [
		'attribute' => 'name',
		'label' => Yii::t('app','Name')
	    ], 
           [
		'attribute' =>   'description',
		'label' => Yii::t('app',  'Description')
	    ],

            [
			 'class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{update}{delete}',
			 'contentOptions' => ['style' => 'width:10%;'],
			 'buttons'=>[
                              'view' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'safetyview'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
							  },
                              'update' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'safetyupdate'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
							  },
                              'delete' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'safetydelete'.'?'.$urls[1];
								$safetylistings = $model->getSafetylistings()->where(['safetyid'=>$model->id])->all();
								if(count($safetylistings)==0)
								{
									return Html::a('', ['safetydelete', 'id' => $model->id], [
									'class' => 'glyphicon glyphicon-trash',
									'data' => [
										'confirm' =>Yii::t('app', 'Are you sure you want to delete this item?'),
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
