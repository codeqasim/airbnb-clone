<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
$this->title = 'Google Analytics';
$this->params['subtitle'] = ''. Yii::t('app','Google Analytics').'';
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php echo Yii::t('app','Google Analytics');?></h2>
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
			<div class="help-create">

<?php
if(!empty($sitesetting))
{
    $googleanalyticsactive = $sitesetting->googleanalyticsactive;
    $googleanalyticscode = $sitesetting->googleanalyticscode;
    $google_webmaster_link = $sitesetting->google_webmaster_link;
}
else
{
    $googleanalyticsactive = "";
    $googleanalyticscode = "";
    $google_webmaster_link = "";
}
 $form = ActiveForm::begin(array(
    		'id'=>'google-form',
			'action' => '',
    		'enableAjaxValidation'=>false,
    )); ?>
                <?php
                echo '<div class="form-group">
                        <label class="col-sm-3 control-label">'. Yii::t('app','Google Webmaster Link').'</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" rows="15" id="google_webmaster_link" name="google_webmaster_link" value="'.$google_webmaster_link.'" />
                        </div>
                    </div>';
                echo '<br/><br/>';
                echo '<div class="form-group">
                    <label class="col-sm-3 control-label">'. Yii::t('app','Google Analytics Code').'</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="15" id="googleanalyticscode" name="googleanalyticscode">'.$googleanalyticscode.'</textarea>
                    </div>
                        <div class="googleanalyticscodeerrcls errorcls"></div>
                </div>';

                    echo '<div class="form-group">
                    <label class="col-sm-3 control-label">'. Yii::t('app','Active').'</label>
                    <div class="col-sm-8">';
                    if(isset($googleanalyticsactive) && $googleanalyticsactive!="")
                    {
                        if($googleanalyticsactive=="yes")
                        {
                            echo '<label class="radio-inline icheck">
                                <input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="googleanalyticsactive" checked> '. Yii::t('app','Yes').'
                            </label>
                            <label class="radio-inline icheck">
                                <input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="googleanalyticsactive" > '. Yii::t('app','No').'
                            </label>';
                        }
                        else if($googleanalyticsactive=="no")
                        {
                            echo '<label class="radio-inline icheck">
                                <input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="googleanalyticsactive"> '. Yii::t('app','Yes').'
                            </label>
                            <label class="radio-inline icheck">
                                <input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="googleanalyticsactive" checked> '. Yii::t('app','No').'
                            </label>';                          
                        }
                    }
                    else
                    {
                        echo '<label class="radio-inline icheck">
                            <input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="googleanalyticsactive" checked> '. Yii::t('app','Yes').'
                        </label>
                        <label class="radio-inline icheck">
                            <input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="googleanalyticsactive" > '. Yii::t('app','No').'
                        </label>';                      
                    }
                    echo '</div>
                </div>';
                ?>
<div class="clear"></div>
    <div class="form-group">
         <?= Html::submitButton(''. Yii::t('app','Submit').'', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
				</div>
        </div>
    </div>