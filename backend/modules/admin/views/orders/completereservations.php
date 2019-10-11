<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Reservationssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reservations'; 
$this->params['subtitle'] = Yii::t('app','Complete Payment History');
$this->params['breadcrumbs'][]= '';
$baseUrl = Yii::$app->request->baseUrl;
?>
<?php
  echo '<div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h2>'. Yii::t('app', 'Complete Payment History').'</h2>
          <div class="panel-ctrls">
          </div>
        </div>
        <div class="panel-body panel-no-padding">'; 
?>
<div class="reservations-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(['id' => 'approvedpayment']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            /*[
              'attribute' => 'id',
             'label' => Yii::t('app','Transaction Id'),
              'value' => 'invoices.stripe_transactionid'
            ],*/
            [
              'attribute' => 'userid',
              'label' =>  Yii::t('app','Guest Name'),
              'value' => 'user.firstname'
            ],
            [
              'attribute' => 'hostid',
                 'label' => Yii::t('app', 'Host Name'),
              'value' => 'host.firstname',
            ],
            [
                //'attribute' => 'total',
                'label' =>  Yii::t('app','Guest Paid Amount'),
                'value' => function ($model)
                {
                    return $model->convertedcurrencycode." ".$model->total;
                }
            ],
            [
              'label' =>  Yii::t('app','Total Revenue'),
                'value' => function ($model)
                {
                    return $model->currencycode." ".($model->commissionfees + $model->sitefees);
                }
            ],
            [
                 'label' =>  Yii::t('app','Host Amount'),
                'value' => function ($model)
                {
                  if($model->booking == "perhour") {
                    return $model->currencycode." ".(($model->pricepernight * $model->totalhours) + $model->taxfees + $model->servicefees + $model->cleaningfees);
                  } elseif ($model->booking == "pernight") {
                    return $model->currencycode." ".(($model->pricepernight * $model->totaldays) + $model->taxfees + $model->servicefees + $model->cleaningfees);
                  } 
                }
            ],      
            [
                'label' =>  Yii::t('app','Security Deposit'),  
                'value' => function ($model)
                {
                    if($model->securityfees == "")
                      return "-";
                    else
                      return $model->currencycode." ".$model->securityfees; 
                }
            ],
            [
                'attribute' => 'bookstatus',
                'label' =>  Yii::t('app','Status'),
                'value' => function ($model)
                {
                    return $model->bookstatus;
                }
            ],
                        
      [
        'label' =>  Yii::t('app','Actions'),
        'format' => 'raw',
        'value' =>function ($model) {
              $enddate = $model->fromdate;
              $baseUrl = Yii::$app->request->baseUrl;
              
              return '<a href="'.$baseUrl.'/admin/orders/vieworder/'.$model->id.'">
              <input type="button" value="'.Yii::t('app','View').'" class="btn btn-primary"></a>';
            },      
  
      ],
        ],
    ]); ?>
<div id="paypalfom"></div>
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
  /*width:30%;*/
}

.empty {
  text-align: center;
}
</style>