<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\Commonamenitiessearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Common Amenities';
$this->params['subtitle'] = ''. Yii::t('app','Common amenities').'';
$this->params['breadcrumbs'][]= '';
$baseUrl = Yii::$app->request->baseUrl;
$frontendurl = str_replace('/admin','',$baseUrl);
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Common Amenities').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="commonamenities-index">

<br />
    <p>
        <?= Html::a(Yii::t('app','Create Common amenities'), ['commoncreate'], ['class' => 'btn btn-success']) ?>
    </p>
<br />
<?php Pjax::begin(['id' => 'amenities']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showOnEmpty' => true,
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
                'attribute' => 'commonimage',
               'label' => Yii::t('app',  'Common image'),
                'format' => 'html',
                'value' => function ($model) {
					$baseUrl = Yii::$app->request->baseUrl;
					$frontendurl = str_replace('/admin','',$baseUrl);
                            return Html::img($frontendurl.'/albums/images/common/'. $model['commonimage'],
                                ['width' => '64px']);
                        },                
            ],
            [
			 'class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{update}{delete}',
			 'contentOptions' => ['style' => 'width:10%;'],
			 'buttons'=>[
                              'view' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'commonview'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
							  },
                              'update' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'commonupdate'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
							  },
                              'delete' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'commondelete'.'?'.$urls[1];
								$commonlistings = $model->getCommonlistings()->where(['amenityid'=>$model->id])->all();
								if(count($commonlistings)==0)
								{
									return Html::a('', ['commondelete', 'id' => $model->id], [
									'class' => 'glyphicon glyphicon-trash',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
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
