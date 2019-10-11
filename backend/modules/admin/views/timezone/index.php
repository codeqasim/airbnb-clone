<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Timezonesearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Timezones');
$this->params['subtitle'] = Yii::t('app', 'Timezones');
$this->params['breadcrumbs'][] = '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2> '. Yii::t('app','Manage Timezones').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="timezone-index">
<br >
    <p>
        <?= Html::a(Yii::t('app', 'Create Timezone'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
<br />
<?php Pjax::begin(['id' => 'amenities']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          /*[
		'attribute' =>   'countryname',
		'label' => Yii::t('app',  'Country name')
	    ],*/
          [
		'attribute' =>  'timezone',
		'label' => Yii::t('app',  'Timezone')
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
