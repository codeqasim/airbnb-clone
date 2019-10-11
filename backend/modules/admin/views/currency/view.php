<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Currency */

$this->title = $model->currencyname;
$this->params['breadcrumbs'][] = '';
$this->params['subtitle'] = ''. Yii::t('app','View Currency').'';
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
<div class="currency-view">


    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php
		$listdata = $model->getListings()->where(['currency'=> $model->id])->all();
		if(count($listdata)==0)
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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
			'label' => 'ID',
			'value' => $model->id,
		],
            [
			'label' => Yii::t('app','Country code'),
			'value' => $model->countrycode,
		],
            [
			'label' => Yii::t('app','Currency code'),
			'value' => $model->currencycode,
		],
          [
			'label' => Yii::t('app','Currency symbol'),
			'value' => $model->currencysymbol,
		],
            [
			'label' => Yii::t('app','Country name'),
			'value' => $model->countryname,
		],
        [
			'label' => Yii::t('app','Currency name'),
			'value' => $model->currencyname,
		],
		  [
			'label' => Yii::t('app','Price'),
			'value' => $model->price,
		],
        ],
    ]) ?>
    </div>
        </div></div>

