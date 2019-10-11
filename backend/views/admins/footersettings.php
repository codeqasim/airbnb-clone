<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$baseUrl = Yii::$app->request->baseUrl;
$this->title = 'Footer Settings';
$this->params['subtitle'] = ''. Yii::t('app','Footer Settings').'';
$this->params['breadcrumbs'][]= '';

/* @var $this yii\web\View */
/* @var $model backend\models\Sitesettings */
/* @var $form ActiveForm */
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?= Yii::t('app',Html::encode($this->title)) ?></h2>
<!-- 				<div class="panel-ctrls" -->
<!-- 					data-actions-container=""  -->
<!-- 					data-action-collapse='{"target": ".panel-body"}' -->
<!-- 					data-action-expand='' -->
<!-- 					data-action-colorpicker='' -->
<!-- 				> -->
<!-- 				</div> -->
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
<div class="admins-footersettings">

    <?php $form = ActiveForm::begin(array(
    		'id'=>'sitesettings-form',
			'action' => '',
    		'enableAjaxValidation'=>false,
    		'options' => array('onsubmit'=>'return footerSettingsValidate()'),
    )); ?>
    
 	<?php /*echo $form->field($model, 'address')->textInput(['class' => 'form-control address', 
    	'name'=>'address'])->label(Yii::t('app','Address')); ?>
 	<?php echo $form->field($model, 'phone')->textInput(['class' => 'form-control phone', 
    	'name'=>'phone','onkeypress' => 'return isNumber(event);'])->label(Yii::t('app','Phone')); ?>
 	<?php echo $form->field($model, 'email')->textInput(['class' => 'form-control email', 
    	'name'=>'email'])->label(Yii::t('app','Email')); */ ?> 
    <?php echo $form->field($model, 'facebookLink')->textInput(['class' => 'form-control facebookLink', 
    	'name'=>'facebookLink'])->label(Yii::t('app','Facebook Link')); ?>
 	<?php echo $form->field($model, 'googleLink')->textInput(['class' => 'form-control googleLink', 
    	'name'=>'googleLink'])->label(Yii::t('app','Google Link')); ?>
 	<?php echo $form->field($model, 'twitterLink')->textInput(['class' => 'form-control twitterLink', 
    	'name'=>'twitterLink'])->label(Yii::t('app','Twitter Link')); ?>
 	<?php echo $form->field($model, 'linkedinLink')->textInput(['class' => 'form-control linkedinLink', 
    	'name'=>'linkedinLink'])->label(Yii::t('app','Linkedin Link')); ?>
 	<?php echo $form->field($model, 'youtubeLink')->textInput(['class' => 'form-control youtubeLink', 
    	'name'=>'youtubeLink'])->label(Yii::t('app','Youtube Link')); ?>
 	<?php echo $form->field($model, 'pinterestLink')->textInput(['class' => 'form-control pinterestLink', 
    	'name'=>'pinterestLink'])->label(Yii::t('app','Pinterest Link')); ?>
 	<?php echo $form->field($model, 'instagramLink')->textInput(['class' => 'form-control instagramLink', 
    	'name'=>'instagramLink'])->label(Yii::t('app','Instagram Link')); ?>

    <h5><?php echo Yii::t('app','Native Apps Link'); ?> </h5>
        <?php 
            $ioslinkstatus = $model->ioslinkstatus;
            $androidlinkstatus = $model->androidlinkstatus;
        ?>
        <div class="form-group col-md-12 col-sm-12 nopadding" style="margin-bottom: 5px !important;"> 
            <?php echo '<label class="col-sm-2 control-label statusLabel">'.Yii::t('app','Ios Link Status').'</label>
            <div class="col-sm-8 iosradiostatus">';
            if(isset($ioslinkstatus) && $ioslinkstatus!="")
            {
                if($ioslinkstatus=="yes")
                {
                    echo '<label class="radio-inline icheck ">
                        <input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="ioslinkstatus" checked> '. Yii::t('app','Enable').'
                    </label>
                    <label class="radio-inline icheck ">
                        <input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="ioslinkstatus" > '. Yii::t('app','Disable').'
                    </label>'; 
                }
                else if($ioslinkstatus=="no")
                {
                    echo '<label class="radio-inline icheck ">
                        <input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="ioslinkstatus"> '. Yii::t('app','Enable').'
                    </label>
                    <label class="radio-inline icheck ">
                        <input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="ioslinkstatus" checked> '. Yii::t('app','Disable').'
                    </label>';                          
                }
            }
            else
            {
                echo '<label class="radio-inline icheck ">
                    <input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="ioslinkstatus" checked> '. Yii::t('app','Enable').'
                </label>
                <label class="radio-inline icheck ">
                    <input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="ioslinkstatus" > '. Yii::t('app','Disable').'
                </label>';                 
            }
            echo '</div>'; ?> 
        </div> 

        <div class="form-group col-md-12 col-sm-12 nopadding" style="margin-bottom: 0px !important;"> 
            <?php echo $form->field($model, 'ioslink')->textInput(['class' => 'form-control instagramLink', 
        'name'=>'ioslink'])->label(Yii::t('app','Ios app Link')); ?>
         <hr />
        </div>

       
        
        <div class="form-group col-md-12 col-sm-12 nopadding" style="margin-bottom: 5px !important;"> 
            <?php echo '<label class="col-sm-2 control-label statusLabel">'.Yii::t('app','Android Link Status').'</label>
            <div class="col-sm-8 androidradiostatus">'; 
            if(isset($androidlinkstatus) && $androidlinkstatus!="")
            {
                if($androidlinkstatus=="yes")
                {
                    echo '<label class="radio-inline icheck ">
                        <input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="androidlinkstatus" checked> '. Yii::t('app','Enable').'
                    </label>
                    <label class="radio-inline icheck ">
                        <input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="androidlinkstatus" > '. Yii::t('app','Disable').'
                    </label>'; 
                }
                else if($androidlinkstatus=="no")
                {
                    echo '<label class="radio-inline icheck ">
                        <input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="androidlinkstatus"> '. Yii::t('app','Enable').'
                    </label>
                    <label class="radio-inline icheck ">
                        <input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="androidlinkstatus" checked> '. Yii::t('app','Disable').'
                    </label>';                          
                }
            }
            else
            {
                echo '<label class="radio-inline icheck ">
                    <input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="androidlinkstatus" checked> '. Yii::t('app','Enable').'
                </label>
                <label class="radio-inline icheck ">
                    <input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="androidlinkstatus" > '. Yii::t('app','Disable').'
                </label>';                 
            }
            echo '</div>'; ?> 
        </div>  

        <div class="form-group col-md-12 col-sm-12 nopadding" style="margin-bottom: 0px !important;"> 
            <?php echo $form->field($model, 'androidlink')->textInput(['class' => 'form-control instagramLink', 'name'=>'androidlink'])->label(Yii::t('app','Android app Link')); ?>
        </div> 
    
        <div class="form-group">
            <?= Html::submitButton(''. Yii::t('app','Submit').'', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admins-socialloginsettings -->
        </div>
    </div>
<style>
.nopadding { 
    padding:0px !important;
}
.statusLabel {
    padding:7px 0px !important;
}
</style>

<script type="text/javascript">

    function footerSettingsValidate() {
        //regular expression for URL
        var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
        var facebooklink = $('#sitesettings-facebooklink').val();
        var googlelink = $('#sitesettings-googlelink').val();
        var twitterlink = $('#sitesettings-twitterlink').val();
        var linkedinlink = $('#sitesettings-linkedinlink').val();
        var youtubelink = $('#sitesettings-youtubelink').val();
        var pinterestlink = $('#sitesettings-pinterestlink').val();
        var instagramlink = $('#sitesettings-instagramlink').val();
        var ioslink = $('#sitesettings-ioslink').val(); 
        var androidlink = $('#sitesettings-androidlink').val(); 
        var rFlag = 0;

        if(!pattern.test(facebooklink)) {
            $(".field-sitesettings-facebooklink").addClass("has-error");
            $("#sitesettings-facebooklink").next(".help-block").html("Enter a valid url").css('color','red'); 
            rFlag = 1;
        } else if(!pattern.test(googlelink)) {
            $(".field-sitesettings-googlelink").addClass("has-error");
            $("#sitesettings-googlelink").next(".help-block").html("Enter a valid url").css('color','red');  
            rFlag = 1;
        } else if(!pattern.test(twitterlink)) {
            $(".field-sitesettings-twitterlink").addClass("has-error");
            $("#sitesettings-twitterlink").next(".help-block").html("Enter a valid url").css('color','red'); 
            rFlag = 1;
        } else if(!pattern.test(linkedinlink)) {
            $(".field-sitesettings-linkedinlink").addClass("has-error");
            $("#sitesettings-linkedinlink").next(".help-block").html("Enter a valid url").css('color','red'); 
            rFlag = 1;
        } else if(!pattern.test(youtubelink)) {
            $(".field-sitesettings-youtubelink").addClass("has-error");
            $("#sitesettings-youtubelink").next(".help-block").html("Enter a valid url").css('color','red'); 
            rFlag = 1;
        } else if(!pattern.test(pinterestlink)) {
            $(".field-sitesettings-pinterestlink").addClass("has-error");
            $("#sitesettings-pinterestlink").next(".help-block").html("Enter a valid url").css('color','red'); 
            rFlag = 1;
        } else if(!pattern.test(instagramlink)) {
            $(".field-sitesettings-instagramlink").addClass("has-error");
            $("#sitesettings-instagramlink").next(".help-block").html("Enter a valid url").css('color','red'); 
            rFlag = 1;
        } else if(!pattern.test(ioslink)) {
            $(".field-sitesettings-ioslink").addClass("has-error");
            $("#sitesettings-ioslink").next(".help-block").html("Enter a valid url").css('color','red'); 
            rFlag = 1;
        } else if(!pattern.test(androidlink)) {
            $(".field-sitesettings-androidlink").addClass("has-error");
            $("#sitesettings-androidlink").next(".help-block").html("Enter a valid url").css('color','red'); 
            rFlag = 1;
        }

        if(rFlag == 1)
            return false;  
    }
</script> 