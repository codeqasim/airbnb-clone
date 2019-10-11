<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Commonamenities */

$this->title = $model->name;
$this->params['subtitle'] = Yii::t('app','View Common Amenity');
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
<div class="commonamenities-view">


    <p>
        <?= Html::a('Update', ['commonupdate', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php
		$commonlistings = $model->getCommonlistings()->where(['amenityid'=>$model->id])->all();
		if(count($commonlistings)==0)
		{
			?>
        <?= Html::a('Delete', ['commondelete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete thsis item?',
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
                'attribute' => 'commonimage',
'label' => Yii::t('app','Commonimage'),
                'format' => 'raw',
                'value'=>$frontendurl.'/albums/images/common/'.$model->commonimage,
                'format' => ['image',['width'=>'64','height'=>'64']],
            ]			
        ],
    ]) ?>

</div>
        </div></div>
