<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use frontend\models\Users;
use frontend\models\Listing;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Additionalamenitiessearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$baseUrl = Yii::$app->request->baseUrl;
$this->title = 'Reviews';
$this->params['subtitle'] = ''. Yii::t('app','Reviews').'';
$this->params['breadcrumbs'][]= '';
?>
<?php
    echo '<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>'. Yii::t('app','Reviews').'</h2>
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
                'label' => Yii::t('app','User Name'),
                'value' => function($model)
                {
                    $getUsername = Users::find()->select('firstname')->where(['id'=>$model->userid])->one();
                    return $getUsername->firstname;
                }
            ],
            [
                'attribute' =>   'rating', 
                'label' => Yii::t('app',  'Rating'),
                'value' => function($model)
                {
                    return $model->rating;
                }
            ],
            [
                'label' => Yii::t('app',  'Listing Name'),
                'value' => function($model)
                {
                    $getListingname = Listing::find()->select('listingname')->where(['id'=>$model->listid])->one();
                    return $getListingname->listingname;
                }
            ],
            [
                'label'=>''. Yii::t('app','Created Date').'',
                'value'=>'cdate'
            ],
            [
             'class' => 'yii\grid\ActionColumn',
             'template'=>'{view}{update}{delete}',
             'buttons'=>[
                              'view' => function ($url, $model) {
                                $urls = explode("?",$url);
                                $url = 'reviewandratings/viewreviews'.'?'.$model->id;
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
                              },
                              'update' => function ($url, $model) {
                                $urls = explode("?",$url);
                                $url = 'reviewandratings/updatereviews'.'?'.$model->id;
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
                              },
                              'delete' => function ($url, $model) {
                                $urls = explode("?",$url);
                                $url = 'reviewandratings/delete'.'?'.$model->id;
                                return Html::a('', ['delete', 'id' => $model->id], [
                                'class' => 'glyphicon glyphicon-trash',
                                'data' => [
                                    'confirm' => ''. Yii::t('app','Are you sure you want to delete this item?').'',
                                    'method' => 'post',
                                ],
                                ]); 
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