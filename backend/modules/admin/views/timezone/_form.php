<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Timezone */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timezone-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--?= $form->field($model, 'countryname')->textInput(['maxlength' => true])->label(Yii::t('app','Countryname'))  ?-->

<?php
$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
echo '<div class="form-group">';
echo '<select name="Timezone[timezone]">';
        $timezones = [];
        $offsets = [];
        $now = new DateTime('now', new DateTimeZone('UTC'));
       foreach (DateTimeZone::listIdentifiers() as $timezone) {
            $now->setTimezone(new DateTimeZone($timezone));
            $offsets[] = $offset = $now->getOffset();
            $timezones[$timezone] = '(' . format_GMT_offset($offset) . ') ' . format_timezone_name($timezone);
            if(isset($model->timezone) && $model->timezone!="" && $model->timezone==$timezones[$timezone])
            	echo '<option value="'.$timezones[$timezone].'" selected>'.$timezones[$timezone].'</option>';
        	else
        		echo '<option value="'.$timezones[$timezone].'">'.$timezones[$timezone].'</option>';
        }
echo '</select>';        
function format_GMT_offset($offset) {
    $hours = intval($offset / 3600);
    $minutes = abs(intval($offset % 3600 / 60));
    return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
}

function format_timezone_name($name) {
    $name = str_replace('/', ', ', $name);
    $name = str_replace('_', ' ', $name);
    $name = str_replace('St ', 'St. ', $name);
    return $name;
}
echo '</div>';        
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
