<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Cancellationsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Manage Cancellation Policies');
$this->params['subtitle'] = Yii::t('app', 'Manage Cancellation Policies');
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'.Yii::t('app','Manage Cancellation Policies').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="cancellation-index">
<br />

    <p>
        <?= Html::a(Yii::t('app', 'Create Cancellation'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'amenities']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
		'attribute' =>  'id',
		'label' => 'ID',
	    ], 
	    [
	    	'attribute' => 'policyname',
	    	'label'=>Yii::t('app',  'Policy Name')
	    ],
	    /*[
		//'attribute' =>     'cancelfrom',
		'label' => Yii::t('app',  'Cancelfrom'),
		'value' => function ($model)
                {
                    return $model->cancelfrom;
                }
	    ], */
            [
		'attribute' =>   'cancelto',
		'label' => Yii::t('app',  'Days before cancel')
	    ], 
          [
		'attribute' =>      'cancelpercentage', 
		'label' => Yii::t('app',  'CancelPercentage')
	    ], 

            ['class' => 'yii\grid\ActionColumn',

            'template'=>'{view}{update}{delete}',
			 	'buttons'=>[
                              'view' => function ($url, $model) {
								$urls = explode("?",$url);
								//$url = 'view'.'?'.$urls[1]; 
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
							  },
                              'update' => function ($url, $model) {
								$urls = explode("?",$url);
								//$url = 'update'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
							  },
                              'delete' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'delete'.'?'.$urls[1];
								$listingdata = $model->getListingCancellation()->where(['cancellation'=>$model->id])->all(); 
								if(count($listingdata)==0)
								{
                                return Html::a('', ['delete', 'id' => $model->id], [
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
	/*echo '</div>
	<div class="notecls">
	<b>'.Yii::t('app',  'Note:').' </b><br />'.Yii::t('app',  '1. If the cancel percentage is 0 service fees will be paid to the admin. Except service fees the remaining paid amount will be refunded to the guest.').'<br/>
	'.Yii::t('app',  '2. If the cancel percentage is not equal to 0 commission and service fees will be paid to the admin. For example, if the cancel percentage is 50% means 50% of room rent will be paid to the host and the remaining amont will be refunded to the guest.').'
	<br />
	</div>
		</div>
		</div>';*/
		
?>

<style>
td {
	width:20px;
}

.panel-heading + .panel-body.panel-no-padding table > thead > tr > th:last-child {
		width:50px !important;
	}
</style>
