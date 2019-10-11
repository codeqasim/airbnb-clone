<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Reservations */

$this->title = 'Create Reservations';
$this->params['breadcrumbs'][] = ['label' => 'Reservations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
