 <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\Myclass;

/* @var $this yii\web\View */
/* @var $model backend\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="currency-form">

    <?php $form = ActiveForm::begin();
    $currencies = Myclass::getCurrencyList();
    $countries = Myclass::getCountryList();
       $siteSetting = Myclass::getLogo();

    

    ?>
    
    <?= $form->field($model, 'currencyDetails')->dropDownList($currencies, 
    		['onchange'=>'updateCurrencyCode();'])->label(Yii::t('app','Currency Details')); ?>

    <?= $form->field($model, 'currencycode')->textInput(['maxlength' => true, 
    		'readonly'=>'readonly'])->label(Yii::t('app','Currency code')) ?>

    <?= $form->field($model, 'currencysymbol')->textInput(['maxlength' => true, 
    		'readonly'=>'readonly'])->label(Yii::t('app','Currency symbol')) ?>

    <?= $form->field($model, 'currencyname')->textInput(['maxlength' => true, 
    		'readonly'=>'readonly'])->label(Yii::t('app','Currency name')) ?>

    <?= $form->field($model, 'countryDetails')->dropDownList($countries, 
    		['onchange'=>'updateCountryCode();'])->label(Yii::t('app','Country Details')); ?>
    
    <?= $form->field($model, 'countrycode')->textInput(['maxlength' => true, 
    		'readonly'=>'readonly'])->label(Yii::t('app','Country code')) ?>

    <?= $form->field($model, 'countryname')->textInput(['maxlength' => true, 
    		'readonly'=>'readonly'])->label(Yii::t('app','Country name')) ?>

           

            <div class="form-group field-currency-price <?php if($siteSetting->autoupdate_currency==0) { echo "has-success"; } ?>">
<label for="currency-price" class="control-label">price</label>
<input type="text" maxlength="6" <?php if($siteSetting->autoupdate_currency==1) { echo "readonly"; } ?> value="<?php echo $model->price;?>" name="Currency[price]" class="form-control" id="currency-price">  
<input type="hidden" name="autoUdt" id="autoUdt" value="<?php echo $siteSetting->autoupdate_currency;?>">
<div class="help-block"></div>
</div>

   

    <?php //$form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'cdate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick' => $model->isNewRecord ? 'return manageCurrencyValidate();' : 'return manageCurrencyPriceValidate();']) ?>  
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(document).ready(function(){ 
    $('#currency-price').keypress(function(event) {
        var $this = $(this);
        if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
           ((event.which < 48 || event.which > 57) &&
           (event.which != 0 && event.which != 8))) {
               event.preventDefault();
        }

        var text = $(this).val();
        if ((event.which == 46) && (text.indexOf('.') == -1)) {
            setTimeout(function() {
                if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                    $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                }
            }, 1);
        }

        if ((text.indexOf('.') != -1) &&
            (text.substring(text.indexOf('.')).length > 2) &&
            (event.which != 0 && event.which != 8) &&
            ($(this)[0].selectionStart >= text.length - 2)) {
                event.preventDefault();
        }

        var number = text.split('.');
        if(number[0].length > 2) { 
            if(number.length == 1 && number[0].length == 3 && event.which != 46 && event.which != 8) {
                event.preventDefault();
            } else if (number.length == 2) {
                if((event.which < 48 || event.which > 57) && event.which != 8)
                    event.preventDefault();
            }
        } 
    })

});
</script>

