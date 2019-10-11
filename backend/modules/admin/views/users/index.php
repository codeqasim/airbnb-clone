<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\Userssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['subtitle'] = 'Create Users';
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
					<h2>User Management</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="users-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?php Pjax::begin(['id' => 'users']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'firstname',
            'lastname',
            'email:email',
            // 'password',
            // 'birthday',
            // 'userstatus',
            // 'hoststatus',
            // 'verify_pass',
            // 'verify_passcode',
            // 'profile_image',
            // 'address1',
            // 'address2',
            // 'city',
            // 'state',
            // 'country',
            // 'created_at',
            // 'modified_at',
            // 'last_login',
            // 'login_type',
            // 'facebookid',
            // 'googleid',
            // 'referrer_id',
            // 'credit_total',
            // 'gender',
            // 'activation',
            // 'user_level',
            // 'phoneno',
            // 'about',
            // 'school',
            // 'work',
            // 'timezone',
            // 'language',
            // 'emergencyno',
            // 'emergencyname',
            // 'emergencyemail:email',
            // 'emergencyrelation',
            // 'shippingid',
            // 'workemail:email',
            // 'pushnotification',
            // 'notifications:ntext',
            // 'emailsettings:ntext',
            // 'socialconnections',
            // 'findability',
            // 'loginnotify',
            // 'mobileverify',
            // 'verifyno',
            // 'emailverify:email',
            // 'verifycode',
            // 'reservationrequirement',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>
<?php
	echo '</div>
		</div>
		</div>
        </div>';
?>
