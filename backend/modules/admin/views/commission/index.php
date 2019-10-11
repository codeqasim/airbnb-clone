<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Commissionsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Commissions');
$this->params['subtitle'] = Yii::t('app','Commissions');
$this->params['breadcrumbs'][] = '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'.Yii::t('app','Manage Commissions').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="commission-index">

<br />
    <p>
        <?= Html::a(Yii::t('app','Create Commission'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'commission']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           [
		'attribute' =>   'min_value',
		'label' => Yii::t('app',  'Min Value')
	    ], 
           [
		'attribute' => 'max_value',
		'label' => Yii::t('app',  'Max Value')
	    ], 
          [
		'attribute' =>    'percentage',
		'label' => Yii::t('app',  'Percentage')
	    ], 

            [
                'class' => 'yii\grid\ActionColumn'
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
