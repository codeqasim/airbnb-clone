 <?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Help */

$this->title = Yii::t('app','Update Help:') . ' ' . $model->name;
$this->params['breadcrumbs'][] = '';
$this->params['subtitle'] = ''. Yii::t('app','Update Help Page').'';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?= Yii::t('app',Html::encode($this->title)) ?></h2>
<!-- 				<div class="panel-ctrls"
					data-actions-container="" 
					data-action-collapse='{"target": ".panel-body"}'
					data-action-expand=''
					data-action-colorpicker=''
				>
				</div> -->
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
<div class="help-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
        </div></div>

