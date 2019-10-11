<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Homecountriessearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Home countries');
$this->params['subtitle'] = Yii::t('app', 'Home countries');
$this->params['breadcrumbs'][] = "";
$baseUrl = Yii::$app->request->baseUrl;
$frontendurl = str_replace('/admin','',$baseUrl);
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'.Yii::t('app', 'Manage Home countries').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="homecountries-index">

<br />
    <p>
        <?= Html::a(Yii::t('app', 'Create Home countries'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'home']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            /* [
		'attribute' => 'id',
		'label' => 'ID',
	    ],*/
           [
		'attribute' =>  'countryid',
		'label' => Yii::t('app','Country id'),
		'filter'=>false,
	    ],
           [
				'attribute' =>  'countryid',
				'filter' => false,
				'label' => Yii::t('app','Country Name'),
				'value' => function ($model)
				{
					$countrydata = $model->getCountry()->where(['id'=>$model->countryid])->one();
					return $countrydata->countryname;
				},
		   ],	    
            [
                'attribute' => 'imagename',
                'filter' => false,
'label' => Yii::t('app','Image name'),
                'format' => 'html',
                'value' => function ($model) {
					$baseUrl = Yii::$app->request->baseUrl;
					$frontendurl = str_replace('/admin','',$baseUrl);
                            return Html::img($frontendurl.'/albums/images/country/'. $model['imagename'],
                                ['width' => '32px']);
                        },                
            ],
           /*[
		'attribute' =>  'latitude',
		'label' => Yii::t('app', 'Latitude')
	    ],
            [
		'attribute' => 'longitude',
		'label' => Yii::t('app','Longitude')
	    ],*/

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
<style>
td {
	width:10px;
}
</style>