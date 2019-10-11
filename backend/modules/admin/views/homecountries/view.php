<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Homecountries */

$this->title = $model->id;
$this->params['subtitle'] =Yii::t('app', 'View Home countries');
$this->params['breadcrumbs'][]= '';
$baseUrl = Yii::$app->request->baseUrl;
$frontendurl = str_replace('/admin','',$baseUrl);
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
<div class="homecountries-view">


    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' =>  Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

<?php
$countrydata = $model->getCountry()->where(['id'=>$model->countryid])->one();
$countryname = $countrydata->countryname;
?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
             [
			'label' => 'ID',
			'value' => $model->id,
		],
             [
		'label' => Yii::t('app','Countryid'),
			'value' => $model->countryid,
		],
           [
                'label' => Yii::t('app','Country Name'),
                'value' => $countryname,
           ],           
            [
                'attribute' => 'imagename',
                'label' => Yii::t('app','Imagename'),
                'format' => 'raw',
                'value'=>$frontendurl.'/albums/images/country/'.$model->imagename,
                'format' => ['image',['width'=>'64','height'=>'64']],
            ],
          /*[
		'label' => Yii::t('app', 'Latitude'),
			'value' => $model-> latitude,
		],
           [
		'label' => Yii::t('app', 'Longitude'),
			'value' => $model->longitude,
		],*/
        ],
    ]) ?>

</div>
        </div></div>
