<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = 'Update Moderator: ' . ' ' . $model->username;
$this->params['subtitle'] = 'Update Moderator';
$this->params['breadcrumbs'][]= '<ol class="breadcrumb">
<li class="active"><a href="/admin/dashboard">Dashboard</a></li>
<li class="active"><a href="javascript:history.back(1);">back</a></li>
</ol>';
?>
<div class="users-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
