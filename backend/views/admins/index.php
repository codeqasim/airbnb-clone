<?php
/*
 * Admin Login Page
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$baseUrl = Yii::$app->request->baseUrl;
?>
<html>
<title>Admin</title>
<script>
var baseurl="<?php print Yii::$app->request->baseUrl;?>";
</script> 
    <script type="text/javascript" src="<?php echo $baseUrl.'/js/jquery-1.10.2.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $baseUrl.'/js/admin.js';?>"></script>
    <body class="bg_gray1" style="background:#f8f8f8;">
        <div class="logincontain" style="">
			<div class="headercont">Sign In</div>
			<div class="bodycont">
            <?php $form = ActiveForm::begin(['id' => 'login-form','action' => ''.$baseUrl.'/login']); ?>

                <?= $form->field($model, 'email')->textInput(['id'=>'login-email', 'class' => 'txtbox','placeholder' => 'Email', 'value'=>''])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['id'=>'login-password','class' => 'txtbox','placeholder' => 'Password', 'value'=>''])->label(false) ?>  



                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn-login', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
			</div>
        </div>
    </body>
</html>

<style type="text/css">
	.logincontain
	{
		border-radius:4px;
		width: 33%;
		margin: 100px auto;
		border: 1px solid #ddd;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
	}
	.headercont
	{
		background: #f3f3f3;
		padding: 15px;
		font-size:18px;
	}
	.bodycont
	{
		background: #ffffff;
		padding: 15px;
	}
	.txtbox
	{
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
		color: #555;
		display: block;
		font-size: 14px;
		height: 34px;
		line-height: 1.42857;
		padding: 6px 12px;
		transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
		width: 100%;
	}
	.btn-login
	{
		background-color: #ff5a5f;
		border-radius: 3px;
		color: #fff;
		font-size: 14px !important;
		font-weight: bold !important;
		-moz-user-select: none;
		border: 1px solid transparent;
		cursor: pointer;
		display: inline-block;
		font-size: 14px;
		font-weight: normal;
		line-height: 1.42857;
		margin-bottom: 0;
		padding: 6px 12px;
		text-align: center;
		vertical-align: middle;
		white-space: nowrap;
		width: 100%;
	}
	
</style>