<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Hometype */

$this->title = 'Create Home Type';
$this->params['subtitle'] =Yii::t('app','Create Hometype');
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?= Html::encode($this->title) ?></h2>
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
<div class="hometype-create">


    <?php $form = ActiveForm::begin(); ?>
<?php
$priority= ['1' => '1', '2' => '2','3' => '3'];
$listData=ArrayHelper::map($hometypes,'id','hometype');

echo $form->field($model, 'hometype')->dropDownList(
                                $listData,
                                ['prompt'=>'Select...',
								 'name'=>'hometype'])->label(Yii::t('app','Hometype'));
echo $form->field($model, 'priority')->dropDownList(
                                $priority,
                                ['prompt'=>'Select...',
								 'name'=>'priority'])->label(Yii::t('app','Priority'));

		?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Set'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick'=>'return homePriorityValidate();']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
        </div>
    </div>
