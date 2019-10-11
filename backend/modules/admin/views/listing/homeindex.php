<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Hometypesearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Home Types';
$this->params['subtitle'] = Yii::t('app','Home Types');
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'.Yii::t('app','Manage Home Types').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="hometype-index">

<br />
    <p>
        <?= Html::a( Yii::t('app','Create Hometype'), ['homecreate'], ['class' => 'btn btn-success']) ?>
		<?php //Html::a( Yii::t('app','Set Priority'), ['homepriority'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'home']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             [
		'attribute' => 'hometype',
		'label' => Yii::t('app', 'Home type')
	    ],

            [
			 'class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{update}{delete}',
			 'buttons'=>[
                              'view' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'homeview'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
							  },
                              'update' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'homeupdate'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
							  },
                              'delete' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'homedelete'.'?'.$urls[1];
								$homelistings = $model->getListings()->where(['hometype'=>$model->id])->all();
								if(count($homelistings)==0)
								{
                                return Html::a('', ['homedelete', 'id' => $model->id], [
								'class' => 'glyphicon glyphicon-trash',
								'data' => [
									'confirm' => ''. Yii::t('app','Are you sure you want to delete this item?').'',
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