<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Specialfeatures */
/* @var $form yii\widgets\ActiveForm */
$baseUrl = Yii::$app->request->baseUrl;
$frontendurl = str_replace('/admin','',$baseUrl);
?>

<div class="specialfeatures-form">

    <?php $form = ActiveForm::begin([
    		'enableAjaxValidation'=>false,
    		'options' => array('onsubmit'=>'return specialvalidate()'),
            ]); ?>
    <?php
    if(isset($model->specialimage))
    {
        $imagename = $model->specialimage;
    }
    else
    {
        $imagename = "";
    }
    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'onkeypress'=>'return isAlpha(event);'])->label(Yii::t('app','Name')) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label(Yii::t('app','Description')) ?>
<?php
				echo '<div class="form-group">
					
					<label class="col-sm-12 control-label">'.Yii::t('app','Special Features Icon').'</label>
					<div class="col-sm-12">
						
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
                            if($imagename!="")
                            {
							echo '<img src="'.$frontendurl.'/albums/images/special/'.$imagename.'">';
                            }
							echo '</div>
							<span class="fileinput-filename" name="logoblack"></span>
							<input class="btn btn-default btn-file" type="file" id="specialimg" name="" accept=".png, .jpg, .jpeg">
							<input type="hidden" id="specialimgfile" name="Specialfeatures[specialimgfile]" value="'.$imagename.'">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">'.Yii::t('app','Remove').'</a>
								<button type="button" class="btn btn-primary" onclick="start_specialfile_upload(\'specialimg\')">'.Yii::t('app','Start Upload').'</button>
								<div id="specialimgupload" class="succcls"></div>
								<div class="logoimgerrcls errcls"></div>
							</div>
						</div>
					</div>
				</div>';
                ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick' => $model->isNewRecord ? '' : 'return specialformValidate();']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
