<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\Myclass;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Tax */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tax-form">

    <?php $form = ActiveForm::begin();
    $countries = Myclass::getCountries();
    $country_name = $model->countryname;
    $model->countryname = $model->countryid."-".$model->countryname;
    ?>

    <?= $form->field($model, 'countryid')->hiddenInput()->label(false); ?>
    <?php
    if(isset($country_name))
    {
    echo '<input type="hidden" value="'.$country_name.'" name="countryname" id="countryname">';
    }
    else {
    	echo '<input type="hidden" value="" name="countryname" id="countryname">';
    }
    ?>

    <?= $form->field($model, 'countryname')->dropDownList($countries,['onchange'=>'updatecountryid(this.val);'])->label(Yii::t('app','Countryname')) ; ?>

    <?= $form->field($model, 'taxname')->textInput(['maxlength' => true])->label(Yii::t('app','Taxname')) ?>

    <?= $form->field($model, 'percentage')->textInput(['maxlength' => true, 'onkeypress' => 'return isNumber(event);'])->label(Yii::t('app','Percentage'))  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick' => 'return taxValidate();']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
