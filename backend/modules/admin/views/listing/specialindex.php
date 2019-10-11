<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Specialfeaturessearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Special Features';
$this->params['subtitle'] = Yii::t('app','Special Features');
$this->params['breadcrumbs'][]= '';
$baseUrl = Yii::$app->request->baseUrl;
$frontendurl = str_replace('/admin','',$baseUrl);
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Special Features').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="specialfeatures-index">

<br />
    <p>
        <?= Html::a(Yii::t('app','Create Special features'), ['specialcreate'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'special']) ?>
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
                'attribute' => 'specialimage',
'label' => Yii::t('app',  'Special image'),
                'format' => 'html',
                'value' => function ($model) {
					$baseUrl = Yii::$app->request->baseUrl;
					$frontendurl = str_replace('/admin','',$baseUrl);
                            return Html::img($frontendurl.'/albums/images/special/'. $model['specialimage'],
                                ['width' => '32px']);
                        },                
            ],
            [
			 'class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{update}{delete}',
			 'contentOptions' => ['style' => 'width:10%;'],
			 'buttons'=>[
                              'view' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'specialview'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
							  },
                              'update' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'specialupdate'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
							  },
                              'delete' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'specialdelete'.'?'.$urls[1];
								$speciallisting = $model->getSpeciallistings()->where(['specialid'=>$model->id])->all();
								if(count($speciallisting)==0)
								{
									return Html::a('', ['specialdelete', 'id' => $model->id], [
									'class' => 'glyphicon glyphicon-trash',
									'data' => [
										'confirm' => Yii::t('app','Are you sure you want to delete this item?'),
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
