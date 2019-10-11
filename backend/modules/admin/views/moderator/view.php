<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = $model->username;
$this->params['subtitle'] = 'View';
$this->params['breadcrumbs'][]= '<ol class="breadcrumb">
<li class="active"><a href="/admin/dashboard">Dashboard</a></li>
<li class="active"><a href="javascript:history.back(1);">back</a></li>
</ol>';
?>
<?php
    echo '<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Moderator Details</h2>
                    <div class="panel-ctrls">
                    </div>
                </div>
                <div class="panel-body panel-no-padding">';
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this moderator?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
        $attributes = [
    [
        'attribute'=>'firstname', 
        'format'=>'raw', 
        'value'=>'<kbd>'.$model->firstname.'</kbd>', 
        'displayOnly'=>true
    ],
    [
        'attribute'=>'lastname', 
        'format'=>'raw', 
        'value'=>$model->lastname,
        'inputWidth'=>'40%'
    ],
    [
        'attribute'=>'email', 
        'format' => 'raw',
        'value' => $model->email,
        'inputWidth'=>'40%'
    ],
    [
        'attribute'=>'user_level', 
        'format' => 'raw',
        'value' => $model->user_level,
        'inputWidth'=>'40%'
    ]
];

echo DetailView::widget([
    'model'=>$model,
    'attributes'=>$attributes
]);
    ?>

</div>
<?php
    echo '</div>
        </div>
        </div>
        </div>';
?>