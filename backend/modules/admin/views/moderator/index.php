<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\Userssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Moderators';
$this->params['subtitle'] = '';


$this->params['breadcrumbs'][]= '';


?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Moderator Management</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="users-index">
    <p>
        <br/>
        <?= Html::a(Yii::t('app', 'Create Moderator'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?php Pjax::begin(['id' => 'users']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
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

            //['class' => 'yii\grid\ActionColumn'],
            [
             'class' => 'yii\grid\ActionColumn',
             'template'=>'{view}{update}{delete}',
             'contentOptions' => ['style' => 'width:10%;'],
             'buttons'=>[
                              'view' => function ($url, $model) {
                                $urls = explode("?",$url);
                                $url = 'moderator/view'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
                              },
                              'update' => function ($url, $model) {
                                $urls = explode("?",$url);
                                $url = 'moderator/update'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
                              },
                              'delete' => function ($url, $model) {
                                $urls = explode("?",$url);
                                $url = 'moderator/delete'.'?'.$urls[1];
                                return Html::a('', ['delete', 'id' => $model->id], [
                                    'class' => 'glyphicon glyphicon-trash',
                                    'data' => [
                                        'confirm' => Yii::t('app','Are you sure, want to delete the Moderator?'), 
                                        'method' => 'post',
                                    ],
                                ]);
                                
                              }                           
                        ]
            ],
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
