<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = $model->username;
$this->params['subtitle'] = 'View';
$this->params['breadcrumbs'][]= '<ol class="breadcrumb">
<li class=""><a href="index.html">Home</a></li>
<li class="active"><a href="index.html">Dashboard</a></li>
</ol>';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Data Tables</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'firstname',
            'lastname',
            'username',
            'email:email',
            'password',
            'birthday',
            'userstatus',
            'hoststatus',
            'verify_pass',
            'verify_passcode',
            'profile_image',
            'address1',
            'address2',
            'city',
            'state',
            'country',
            'created_at',
            'modified_at',
            'last_login',
            'login_type',
            'facebookid',
            'googleid',
            'referrer_id',
            'credit_total',
            'gender',
            'activation',
            'user_level',
            'phoneno',
            'about',
            'school',
            'work',
            'timezone',
            'language',
            'emergencyno',
            'emergencyname',
            'emergencyemail:email',
            'emergencyrelation',
            'shippingid',
            'workemail:email',
            'pushnotification',
            'notifications:ntext',
            'emailsettings:ntext',
            'socialconnections',
            'findability',
            'loginnotify',
            'mobileverify',
            'verifyno',
            'emailverify:email',
            'verifycode',
            'reservationrequirement',
        ],
    ]) ?>

</div>
<?php
	echo '</div>
		</div>
		</div>
        </div>';
?>