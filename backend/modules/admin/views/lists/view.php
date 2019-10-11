<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Users;

/* @var $this yii\web\View */
/* @var $model backend\models\Lists */

$this->title = $model->listname;
$this->params['subtitle'] = ''. Yii::t('app','View List').'';
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?= Yii::t('app',Html::encode($this->title)) ?></h2>	
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
		<?php
		$wishlistdata = $model->getWishlists()->where(['listid'=>$model->id])->all();
		if(count($wishlistdata)==0)
		{
		?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
		<?php
		}
		?>


		<?php 
		$usermodel = Users::find()->where(['id' => $model->createdby])->One();

		?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		[
			'label' => 'ID',
			'value' => $model->id,
		],
		[
			'label' => Yii::t('app','Listname'),
			'value' => $model->listname,
		],
[
			'label' =>  Yii::t('app', 'Created by'),
			//'value' => $model->createdby,
			'value' => $usermodel->firstname,
		],
[
			'label' => Yii::t('app', 'Created date'),
			'value' => date('M - d - Y',strtotime($model->cdate)),
		],
           
        ],
    ]) ?>

</div>
        </div></div>
