 <?php
use backend\components\Myclass;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$baseUrl = Yii::$app->request->baseUrl;
$this->title = 'Currencies';
$this->params['breadcrumbs'][] = '';
$this->params['subtitle'] = ''. Yii::t('app','Currencies').'';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Currencies').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="currency-index">

<br />
    <p>
        <?= Html::a(''. Yii::t('app','Create Currency').'', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(''. Yii::t('app','Set Default Currency').'', ['defaultcurrency'], ['class' => 'btn btn-success']) ?>
        &nbsp;&nbsp;
     
        <label class="switch" >
        <input type="checkbox" <?php if($siteSettingData->autoupdate_currency==1){echo "checked";}?> id="autoUptcurrency">
        <span class="slider round"></span>
        <span style="margin-left: 45px !important;"> 
          <img id="loadingimg" src="<?= $baseUrl;?>/images/load.gif" class="msgLoader">  
        </span> 

      </label>  

      

    </p>
    
<?php Pjax::begin(['id' => 'currencyindex']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
 /*[
		'attribute' =>   'countrycode',
		'label' => Yii::t('app', 'Country code')
	    ],
	    [
		'attribute' =>  'countryname',
		'label' => Yii::t('app', 'Country name')
	    ],*/
           [
		'attribute' => 'currencycode',
		'label' => Yii::t('app','Currency code')
	    ],
           [
		'attribute' =>    'currencysymbol',
		'label' => Yii::t('app',  'Currency symbol')
	    ],
             
	     [
		'attribute' =>  'price',
		'label' => Yii::t('app', 'Price')
	    ],
            
     
     
            // 'currencyname',
            // 'price',
            // 'status',
            // 'cdate',

            [
			 'class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{update}{delete}',
			 'buttons'=>[
                              'view' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'view'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
							  },
                              'update' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'update'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
							  },
                              'delete' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'delete'.'?'.$urls[1];
								$listingdata = $model->getListings()->where(['currency'=>$model->id])->all();
								if(count($listingdata)==0 && $model->id > 1) 
								{
                                return Html::a('', ['delete', 'id' => $model->id], [
								'class' => 'glyphicon glyphicon-trash',
								'data' => [
									'confirm' =>  ''. Yii::t('app','Are you sure you want to delete this item?').'',
									'method' => 'post',
								],
								]);
								}
							  }							  
						]
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

<style>
td {
width:20px;
}
/* new style for slider */
.switch {
  position: absolute;
  display: inline-block;
  width: 60px;
  height: 34px;
  padding-left: 25px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #8bc34a;
}

input:focus + .slider {
  box-shadow: 0 0 1px #8bc34a;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.msgLoader {
  display: none;
}


/* new slider */
</style>

