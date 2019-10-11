<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\Taxsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Taxes';
$this->params['subtitle'] = Yii::t('app', 'Taxes');
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'.Yii::t('app', 'Manage Taxes').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="tax-index">

<br />
    <p>
        <?= Html::a(Yii::t('app', 'Create Tax'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'amenities']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
         [
		'attribute' =>       'countryname',
		'label' => Yii::t('app','Countryname')
	    ],
         [
		'attribute' =>    'taxname',
		'label' => Yii::t('app','Taxname')
	    ],
          [
		'attribute' =>    'percentage',
		'label' => Yii::t('app',  'Percentage')
	    ],

            ['class' => 'yii\grid\ActionColumn'],
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
