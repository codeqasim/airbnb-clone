<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Currency */

$this->title = 'Set Default Currency';
$this->params['breadcrumbs'][]= '';
$baseUrl = Yii::$app->request->baseUrl;
$this->params['subtitle'] = ''. Yii::t('app','Set Default Currency').'';
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
<div class="currency-create">
<?php $form = ActiveForm::begin();

echo '<div class="form-group"><select name="currencycode" class="form-control">';
foreach($model as $currency)
{
	if($currency->defaultcurrency==1)
	echo '<option value="'.$currency->id.'" selected>'.$currency->currencycode.'</option>';
	else
	echo '<option value="'.$currency->id.'">'.$currency->currencycode.'</option>';
}
echo '</select></div>';
?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Set'), ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>
<span style="color:red">Note * : If auto currency update option is enable,while change default currency , all currency price will be update.</span>
</div>
        </div>
    </div>
