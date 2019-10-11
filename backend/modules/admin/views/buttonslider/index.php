<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Buttonsliderssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Button sliders');
$this->params['subtitle'] = Yii::t('app', 'Button sliders');
$this->params['breadcrumbs'][] = '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Sliders').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="buttonsliders-index">
<br />

    <p>
        <?= Html::a(Yii::t('app', 'Create Button sliders'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'buttonslider']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
  /*[
		'attribute' => 'id',
		'label' => 'ID',
	    ],*/
            
  [
		'attribute' => 'title',
		'label' => Yii::t('app','Title')
	    ],
            [
		'attribute' => 'description', 
		'label' => Yii::t('app', 'Description')
	    ],
            [
		'attribute' =>  'buttonname',
		'label' => Yii::t('app',  'Button name')
	    ],
            [
		'attribute' =>  'buttonlink',
		'label' => Yii::t('app',  'Button link')
	    ], 
		
		

		
	    
            [
                'attribute' => 'sliderimage',
                 'label' => Yii::t('app','Slider Image'),
                'format' => 'html',
                'value' => function ($data) {
                            return Html::img(Yii::getAlias('@web').'/images/buttonsliders/'. $data['sliderimage'],
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
