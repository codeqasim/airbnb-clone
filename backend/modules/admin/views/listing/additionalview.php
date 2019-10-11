<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Additionalamenities */

$this->title = $model->name;
$this->params['subtitle'] = Yii::t('app','View Additional Amenity');
$this->params['breadcrumbs'][]= '';
$baseUrl = Yii::$app->request->baseUrl;
$frontendurl = str_replace('/admin','',$baseUrl);
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?= Yii::t('app',Html::encode($this->title)) ?></h2>
<!-- 				<div class="panel-ctrls"
					data-actions-container="" 
					data-action-collapse='{"target": ".panel-body"}'
					data-action-expand=''
					data-action-colorpicker=''
				>
				</div> -->
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
<div class="additionalamenities-view">


    <p>
        <?= Html::a(Yii::t('app','Update'), ['additionalupdate', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php
		$additionallistings = $model->getAdditionallistings()->where(['amenityid'=>$model->id])->all();
		if(count($additionallistings)==0)
		{
		?>
        <?= Html::a(Yii::t('app','Delete'), ['additionaldelete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' =>''. Yii::t('app','Are you sure you want to delete this item?').'',
                'method' => 'post',
            ],
        ]) ?>
		<?php
		}
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
			'label' => Yii::t('app','Name'),
			'value' => $model->name,
		],
       [
			'label' => Yii::t('app','Description'),
			'value' => $model-> description,
		],
            [
                'attribute' => 'additionalimage',
                 'label' => Yii::t('app','Additionalimage'),
                'format' => 'raw',
                'value'=>$frontendurl.'/albums/images/additional/'.$model->additionalimage,
                'format' => ['image',['width'=>'64','height'=>'64']],
            ]
        ],
    ]) ?>

</div>
        </div></div>
