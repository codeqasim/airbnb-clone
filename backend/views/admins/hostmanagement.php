<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<?php
use backend\models\Users;
use backend\models\Listing;
use backend\models\Reviews;
$this->title = 'Host Management';
$this->params['subtitle'] = ''. Yii::t('app','Host Management').'';
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Hosts').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<?php Pjax::begin(['id' => 'amenities']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showOnEmpty' => true,
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
		'label' => Yii::t('app','Email')
	    ],
			
            [
		'attribute' => 'state',
		'label' => Yii::t('app','State'),
			'value' => function($model)
	                {
	                    if(is_null($model->state)){
	                        return '-';
	                    }else{
	                        return $model->state; 
	                    }
	                }
	    ],
	    
	    [
			'label' => ''. Yii::t('app','Listing Count').'',
			'value' => function ($model)
			{
				/*
				$data = $model->listids;
				$listData = str_replace( array( '\'', '[', ']' , '"', '<', '>' ), ' ', $data);
				$returnCount = count(explode(',',$listData));
				*/
				$listCount = Listing::find()->where(['userid'=>$model->id,'liststatus'=>'1'])->count(); 
				return $listCount; 
			}
		],
		[
			'label' => ''. Yii::t('app','Review Count').'',
			'value' => function ($model)
			{
				$data = $model->listids;
				$listData = str_replace( array( '\'', '[', ']' , '"', '<', '>' ), ' ', $data);
				$getReviews = Reviews::find()->select('listid')->all();

				$rviewArray = array();
				foreach($getReviews as $review)
				{
					$rviewArray[] = $review->listid;
				} 
				$listbysplitChar = explode(',',$listData);
				$getCommonvalues = array_intersect($listbysplitChar, $rviewArray);
				return count($getCommonvalues);
			}
		],
		[
		'attribute' => 'verifyno',
		'label' => Yii::t('app','Phone Number'),
			'value' => function($model)
	                {
	                    if(is_null($model->verifyno) || trim($model->verifyno) == ""){
	                        return '-'; 
	                    } else { 
	                        return $model->verifyno; 
	                    }
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
					$baseUrl = Yii::$app->request->baseUrl;
							return '<input type="button" class="btn btn-success" value="'. Yii::t('app','Block').'" onclick="changehoststatus(\'block\','.$model->id.')">
							<a href="'.$baseUrl.'/admin/listing/'.$model->id.'">
							<input type="button" class="btn btn-info" value="'. Yii::t('app','Listings').'">
							</a>';
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
	<div class="invoice-popup">
		<div>
			<button class="btn btn-danger pop-close" style="float: right;"><?php echo Yii::t('app','Close');?></button>
			<div id="userdetails" class="popupdiv"></div>
			<div id="messagedetails" class="popupdiv">
				<div class="leftdiv"><?php echo Yii::t('app','Message:');?> </div>
				<div class="rightdiv"><textarea rows="5" cols="20" id="messagecont"></textarea></div>
				<input type="hidden" id="cuserid">
				<input type="button" value="<?php echo Yii::t('app','Send');?>" class="btn btn-primary" onclick="sendmessage()">
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


