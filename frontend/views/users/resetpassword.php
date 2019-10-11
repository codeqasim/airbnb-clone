<?php
/*
 * This is for the user to reset the password. User can set the new password here.
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Reset Password';
?>


<?php
?>
<div class="container passwordcontent">
	<div class="modal-dialog login_width" role="document">
    <div class="modal-content passwordform">
	<div class="modal-body text-center">
            <?php $form = ActiveForm::begin(['id' => 'resetpassword-form'
            ]); ?>
				<?= $form->field($model, 'id')->hiddenInput(['value'=> $id])->label(false); ?>
                <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control margin_top30','placeholder' => 'New Password','id'=>'newpassword'])->label(false) ?>
				<?= $form->field($model, 'password')->passwordInput(['class' => 'form-control margin_top30','placeholder' => 'Confirm Password','id'=>'confirmpassword'])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Save & Continue', ['class' => 'btn btn_email margin_top10 width100', 'name' => 'reset-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
	</div>
	</div>
	</div>

</div> <!-- container end -->
