<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Roomtypesearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Room Types';
$this->params['subtitle'] = Yii::t('app','Room Types');
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'.Yii::t('app','Manage Room Types').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="roomtype-index">

<br />
<?php if(count($model) < 3){?>
    <p>
        <?= Html::a( Yii::t('app','Create Roomtype'), ['roomcreate'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php } ?>
<?php Pjax::begin(['id' => 'room']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

         [
		'attribute' =>   'roomtype',
		'label' => Yii::t('app', 'Room type')
	    ],

            [
			 'class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{update}{delete}',
			 'buttons'=>[
                              'view' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'roomview'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
							  },
                              'update' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'roomupdate'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
							  },
                              'delete' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'roomdelete'.'?'.$urls[1];
								$roomlistings = $model->getListings()->where(['roomtype'=>$model->id])->all();
								if(count($roomlistings)==0)
								{
									return Html::a('', ['roomdelete', 'id' => $model->id], [
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
