<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Help */

$this->title = 'Create Help';
$this->params['breadcrumbs'][] = ['label' => 'Helps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
