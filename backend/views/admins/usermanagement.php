<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<?php
use backend\models\Users;
$this->title = 'User Management';
$this->params['subtitle'] = ''. Yii::t('app','User Management').'';
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Users').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<?php Pjax::begin(['id' => 'usermanage']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'rowOptions' => function ($model) {
                return ['id' => $model['id']];
        },			
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

         [
		'attribute' => 'firstname',
		'label' => Yii::t('app','First name')
	    ],
	    [
		'attribute' => 'email',
		'label' => Yii::t('app','Email Address')
	    ],
	    [
			'attribute' => 'verifyno',
			'label' => Yii::t('app','Phone Number'),
			'value' => function($model)
                {
                    if(is_null($model->verifyno)){
                        return '-';
                    }else{
                        return $model->verifyno;
                    }
                }
	    ],	
	    [
		
			'label' => Yii::t('app','Created At'),
			'value' => function ($model)
						{
							return date('Y-m-d',$model->created_at);
						}
	    ],	
		[
			'label' => ''. Yii::t('app','Referred').'',
			'value' => function ($model)
			{
				$data = $model->getUserinvite($model->id);
				return $data;
			}
		],
		[
			'label' => ''. Yii::t('app','Actions').'',
			'format' => 'raw',
			'value' =>function ($model) {
						return '<input type="button" class="btn btn-success" value="'. Yii::t('app','Block').'" onclick="changeuserstatus(\'block\','.$model->id.')">
							<input type="button" class="btn btn-info" value="'. Yii::t('app','View').'" onclick="view_user('.$model->id.')">';
						},
		],
        ],
    ]); ?>
<?php Pjax::end() ?>
<?php
	echo '</div>
		</div>
		</div>
        </div>';
?>
<!--?php

	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Data Tables</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">
					<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Username</th>
								<th>Location</th>
								<th>Referred</th>
								<th>Credit</th>
								<th>Block</th>
								<th>View</th>
							</tr>
						</thead>
						<tbody>';
						$models = new Users();
						foreach($userdatas as $users)
						{
							$datas = $models->getUserinvites($users->id);
							$userid = $users->id;
							echo '<tr class="odd gradeX" id="usr_'.$userid.'">
								<td>'.$users->firstname.'</td>
								<td>'.$users->state.'</td>
								<td>'.count($datas).'</td>
								<td>'.$users->credit_total.'</td>
								<td><input type="button" class="btn btn-success" value="Block" onclick="changeuserstatus(\'block\','.$userid.')"></td>
								<td><input type="button" class="btn btn-info" value="View" onclick="view_user('.$userid.')"></td>
							</tr>';
						}
						echo '</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>';
	?-->
<div class="invoice-popup-overlay">
	<div class="invoice-popup invoicediv">
		<div class="col-sm-12"> 
			<button class="btn btn-danger pop-close" style="float: right;"><?php echo Yii::t('app','Close');?></button>
			<div id="userdetails" class="popupdiv"></div>
			<div id="messagedetails" class="popupdiv">
				<div class="leftdiv"><?php echo Yii::t('app','Message:');?> </div>
				<div class="rightdiv"><textarea rows="5" cols="20" id="messagecont"></textarea></div>
				<input type="hidden" id="cuserid">
				<input type="button" value="Send" class="btn btn-primary" onclick="sendmessage()">
				<div class="msgerrcls"></div>
				<div class="has-success" id="succmsg" style="display: none;">
					<p class="help-block">
						<i class="fa fa-check"></i>
						<?php echo Yii::t('app','Message sent successfully');?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>


