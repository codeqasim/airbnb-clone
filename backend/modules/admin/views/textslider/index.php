<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Textsliderssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Text sliders');
$this->params['subtitle'] = Yii::t('app', 'Text sliders');
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'.Yii::t('app', 'Manage Sliders').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="textsliders-index">

<br />
    <p>
        <?= Html::a(Yii::t('app', 'Create Text sliders'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(['id' => 'textslider']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           /* [
		'attribute' => 'id',
		'label' => 'ID'
	    ], */
           [
		'attribute' =>  'slidertext',
		'label' => Yii::t('app', 'Slider text'),
		'value' => function ($data)
		{
			return strip_tags(str_replace("&nbsp;", " ", $data->slidertext));
		},
	    ], 
            [
                'attribute' => 'sliderimage',
               'label' => Yii::t('app','Slider Image'),
               'format' => 'raw',
                'value' => function ($data) {
                            return Html::img(Yii::getAlias('@web').'/images/textsliders/'. $data['sliderimage'],
                                ['width' => '100px']);
                        },                
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
