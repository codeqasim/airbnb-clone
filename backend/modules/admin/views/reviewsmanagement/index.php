<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use backend\models\Users;
use backend\models\Listing;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\Listssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Manage Ratings and Reviews');
$this->params['subtitle'] = ''. Yii::t('app','Ratings and Reviews').'';
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage All Review').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="lists-index">

<br />
    <p>
        <?php //Html::a(Yii::t('app', 'Create Role'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'amenities']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            /*['class' => 'yii\grid\SerialColumn'],*/
            [
				'attribute' => 'id',
				    'value' => function ($model, $key, $index, $column) {
				          return $column->grid->dataProvider->totalCount - $index + 1;
				    }
		    ],
           
			[
				'label'=>''. Yii::t('app','User Name').'',
				'value'=>function($model)
				{
					$getUsername = Users::find()->select('firstname')->where(['id'=>$model->userid])->one();
					return $getUsername->firstname;
				}
			],
			[
				'label'=>''. Yii::t('app','Rating').'',
				'value'=>'rating'
			],
			[
				'label'=>''. Yii::t('app','Review').'',
				'value'=>function($model){
					return (strlen($model->review) > 50) ? substr($model->review, 0, 50).'..' : $model->review;
				}
			],
            [
				'label'=>''. Yii::t('app','Listing Name').'',
				'format' => 'raw',
				'value'=>function($model)
				{
					 $listingurl = base64_encode($model->listid.'_'.rand(1,9999));
					 $mainUrl = Url::base(true);
                 $mainUrl = str_replace('/admin', '', $mainUrl."/");  

                 $listingurl = $mainUrl.'user/listing/view/' . $listingurl .'/admin';

					$getListname = Listing::find()->select('listingname')->where(['id'=>$model->listid])->one();
					return Html::a($getListname->listingname, $listingurl, [
                                        'title' => Yii::t('app', 'view'),
                                ]);
				}
			],
			[
				'label'=>''. Yii::t('app','Created Time').'',
				'value'=>function($model)
				{
					return date('M d-Y', strtotime($model->cdate));
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
	echo '</div></div></div></div>';
?>