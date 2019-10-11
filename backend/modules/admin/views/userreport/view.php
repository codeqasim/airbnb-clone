<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Listing;

/* @var $this yii\web\View */
/* @var $model backend\models\Lists */

$this->title = 'User Reports';
$this->params['subtitle'] = ''. Yii::t('app','View Report').'';
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
        <?php echo Html::a(Yii::t('app', 'Back'), ['/admin/userreport/index'], ['class' => 'btn btn-primary']) ?>
		
    </p>

    <?php
    	$listmodel = new Listing();
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		[
			'label' => 'ID',
			'value' => $model->id,
		],
		[
			'label' => Yii::t('app','Report'),
			'value' => $model->getReportname($model->reportid),
		],
		[
			'label' => Yii::t('app','Report Person'),
			'value' => $model->getUsername($model->userid),
		],
		[
			'label' =>  ($model->reporterid != 0) ? Yii::t('app', 'Reported Person') : Yii::t('app', 'Listing Name') ,
			'value' => ($model->reporterid != 0) ? $model->getUsername($model->reporterid) : $listmodel->getListingname($model->listid),
		],
		[
			'label' => Yii::t('app', 'Created Time'),
			'value' => $model->createdtime,
		],

           
        ],
    ]) ?>

</div>
        </div></div>
