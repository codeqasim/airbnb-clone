<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Reservationssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Approved Orders';
$this->params['subtitle'] = 'Room Types';
$this->params['breadcrumbs'][]= '';
?>
<div class="reservations-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Reservations', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userid',
            'hostid',
            'listid',
            'fromdate',
            // 'todate',
            // 'guests',
            // 'pricepernight',
            // 'totaldays',
            // 'commissionfees',
            // 'servicefees',
            // 'taxfees',
            // 'securityfees',
            // 'total',
            // 'booktype',
            // 'bookstatus',
            // 'cancelby',
            // 'orderstatus',
            // 'cdate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
