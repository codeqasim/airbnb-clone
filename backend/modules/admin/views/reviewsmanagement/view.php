<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Reviews;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\Lists */
$this->title = 'Review';
$this->params['subtitle'] = ''. Yii::t('app','View Role').'';
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php Yii::t('app',Html::encode($this->title)) ?></h2>	
<!-- 				<div class="panel-ctrls" -->
<!-- 					data-actions-container=""  -->
<!-- 					data-action-collapse='{"target": ".panel-body"}' -->
<!-- 					data-action-expand='' -->
<!-- 					data-action-colorpicker='' -->
<!-- 				> -->
<!-- 				</div> -->
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
<div class="lists-view">

  

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		[
			'label' => 'ID',
			'value' => $model->id,
		],
		[
			'label' => Yii::t('app','Listing Name'),
			'format' => 'raw',
			'value' => Reviews::getListbyreview($model->listid),
		],
        [
            'label' => Yii::t('app','Rating'),
            'value' => $model->rating,
        ],
        [
            'label' => Yii::t('app','Reviews'),
            'value' => $model->review,
        ],
		[
			'label' => Yii::t('app','User name'),
			'value' => Reviews::getUserbyreview($model->userid),
		],
        [
			'label' => Yii::t('app', 'Created Time'),
			'value' => date('M d, Y',strtotime($model->cdate)),
		],
           
        ],
    ]) ?>

</div>
        </div></div>
