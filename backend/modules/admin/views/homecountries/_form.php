<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\Myclass;

/* @var $this yii\web\View */
/* @var $model backend\models\Homecountries */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php 
    $currencies = Myclass::getCurrencyList();
    $countries = Myclass::getCountries();
$baseUrl = Yii::$app->request->baseUrl;
$frontendurl = str_replace('/admin','',$baseUrl);	
    ?>
<div class="homecountries-form">

    <?php $form = ActiveForm::begin([
            'enableAjaxValidation'=>false,
            'options' => array('onsubmit'=>'return homecountriesvalidate();'),
            ]); ?>
    <?php
    if(isset($model->countryid))
    {
        $countrydata = $model->getCountry()->where(['id'=>$model->countryid])->one();
        $model->countryid = $model->countryid."-".$countrydata->countryname;
        $imagename = $model->imagename;
    }
    else
    {
        $imagename = "";
    }
    ?>
    
    <?= $form->field($model, 'countryid')->dropDownList($countries,['onchange'=>'updatelatlon();'])->label(Yii::t('app','Country')) ?>

<?php
				echo '<div class="form-group">
					
					<label class="col-sm-12 control-label">'.Yii::t('app','Home Country Image').'</label>
					<div class="col-sm-12">
						
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
                            if($imagename!="")
                            {
							echo '<img src="'.$frontendurl.'/albums/images/country/'.$imagename.'">';
                            }
							echo '</div>
							<span class="fileinput-filename" name="logoblack"></span>
							<input class="btn btn-default btn-file" type="file" id="countryimg" name="" >
							<input type="hidden" id="countryimgfile" name="countryimgfile" value="'.$imagename.'">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">'.Yii::t('app','Remove').'</a>
								<button type="button" class="btn btn-primary" onclick="start_countryfile_upload(\'countryimg\')">'.Yii::t('app','Start Upload').'</button>
								<div id="countryimgupload" class="succcls"></div>
								<div class="logoimgerrcls errcls"></div>
							</div>
						</div>
					</div>
				</div>';
                ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

