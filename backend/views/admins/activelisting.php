<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Hometype;
use backend\models\Users;
use backend\models\Country;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Additionalamenitiessearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$baseUrl = Yii::$app->request->baseUrl;
$this->title = 'Active Listings';
$this->params['subtitle'] = '';
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Active Listings').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="listings-index">

<?php Pjax::begin(['id' => 'currencyindex']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['id' => 'rowid'.$model['id']];
        },
        'columns' => [ 
            [
    		'attribute' => 'id',
    		'label' => Yii::t('app','ID')
    	    ],
             [
                'attribute' => 'listingname',
                'label' => Yii::t('app','Listing name'),
            ],
            [
                'label' => Yii::t('app',  'Property Type'),  
                'value' => function( $model )
                {

                    $getHomemodel = Hometype::find()->where(['id'=>$model->hometype])->One();
                    return $getHomemodel->hometype;
                }
            ],
            [
                'label' => Yii::t('app',  'Host Name'),
                'value' => function( $model )
                {
                    $Users = Users::find()->where(['id'=>$model->userid])->One();
                    return $Users->firstname;
                }
            ],
            [
                'label' => Yii::t('app',  'Location'),
                'value' => function( $model )
                {
                    $getCountry = Country::find()->select('countryname')->where(['id'=>$model->country])->One();
                    $Location = "";
                    if(isset($model->city) && !empty($model->city)) {
                    	$Location = trim(ucfirst($model->city));
                    }

                    if(isset($model->state) && !empty($model->state)) {
                    	$Location = ($Location!="") ? $Location.', '.trim(ucfirst($model->state)):trim(ucfirst($model->state));   
                    }

                    return ucwords(strtolower(($Location!="") ? $Location.', '.$getCountry->countryname : $getCountry->countryname));      
                }
            ],
            [
                'label' => Yii::t('app','Per night price'),
                'value' => function($model)
                {
                    if(is_null($model->nightlyprice)){
                        return '-';
                    }else{
                        return $model->nightlyprice;
                    }
                }
            ],
            [
                'label' => Yii::t('app','Per hour price'),
                'value' => function($model)
                {
                    if(is_null($model->hourlyprice)){
                        return '-';
                    }else{
                        return $model->hourlyprice;
                    }
                }
            ],
            [
                'label' => Yii::t('app','Featured'),
                'format' => 'raw',
                'value' => function($model)
                {
                        if($model->featuredlist == 0)
                            return '<div id="list'.$model->id.'">
                        <input type="checkbox" name="featurelist" id="featurelist_'.$model->id
                        .'" class="btn btn-success featurelist" value="'.$model->id.'" onclick="javascript:alterfeaturelist('.$model->id.');"></div>';
                        else
                            return '<div id="list'.$model->id.'">
                        <input type="checkbox" name="featurelist" id="featurelist_'.$model->id.'" class="btn btn-success featurelist" value="'.$model->id.'" onclick="javascript:alterfeaturelist('.$model->id.');" checked="checked"></div>';
                }
            ],
            [
                'attribute' => 'liststatus',
                'label' => Yii::t('app','Actions'),
                'format' => 'raw',
                'value' => function($model)
                {
                    $listingurl = base64_encode($model->id.'_'.rand(1,9999));
                        
                    $mainUrl = Url::base(true);
                    $mainUrl = str_replace('/admin', '', $mainUrl."/");  
 
                    $listingurl = $mainUrl.'user/listing/view/' . $listingurl .'/admin';      

                    if($model->liststatus=="1" || $model->liststatus=="0")
                        return '<div id="list'.$model->id.'"><input type="button" class="btn btn-success" value="'.Yii::t('app','Block').'" onclick="alterliststatus(\'block\','.$model->id.')"><a href="'.$listingurl.'" target="_blank" class="btn btn-success" >View</a></div>';
                    else if($model->liststatus=="2")
                        return '<div id="list'.$model->id.'"><input type="button" class="btn btn-success" value="'.Yii::t('app','Unblock').'" onclick="alterliststatus(\'unblock\','.$model->id.')"<a href="'.$listingurl.'" target="_blank" class="btn btn-success" >View</a></div>';
                }
            ]

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