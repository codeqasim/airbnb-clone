<?php
use yii\helpers\Html;
use backend\models\Profilereports;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Users;
use backend\models\Userreports;
use backend\models\Listing;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\Listssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Manage List Reports');
$this->params['subtitle'] = ''. Yii::t('app','List Reports').'';
$this->params['breadcrumbs'][]= '';

?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Listing Reports').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="lists-index">

<br />
    <p>
        <?php //echo Html::a(Yii::t('app', 'Create Report'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'amenities']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],           	
	    	[
				'label' => ''. Yii::t('app','Report Name').'',
				'value' => function($model)
				{
					$reports = Profilereports::find()->where(['id'=>$model->reportid])->one();
					if(count($reports) > 0)
						return ucfirst($reports->report); 
					else
						return "-"; 
				}
			],
			[
				'label' => ''. Yii::t('app','Listing Name').'',
				'value' => function($model)
				{
					$reports = Listing::find()->select('listingname')->where(['id'=>$model->listid])->one();
					//$d=mktime(11, 14, 54, 8, 12, 2014);
					//echo "Created date is " . date("Y-m-d h:i:sa", $d); exit;
					//echo date('y-m-d h:i:s'); exit;
					return $reports->listingname;
				}
			],
			[
				'label' => ''. Yii::t('app','Reported count').'',
				'value' => function($model)
				{
					$getReportcount = Userreports::find()->where(['reportid'=>$model->reportid, 'listid'=>$model->listid, 'report_type'=>'list'])->count();
					return $getReportcount;
				}
			],
			[
				'label' => ''. Yii::t('app','Created By').'',
				'value' => function($model)
				{
					$hostid = Listing::find()->select('userid')->where(['id'=>$model->listid])->one();
					if(isset($hostid->userid) && $hostid->userid != '')
					{
						$userdata = Users::find()->select('firstname')->where(['id'=>$hostid->userid])->one();
						        //echo '<pre>'; print_r($getlists); exit;
						return (isset($userdata->firstname) && $userdata->firstname != '') ? $userdata->firstname : '';
					}else{
						//return '-';
						return $model->userid." // ";
					}
				}
			],
			[
				'label'=>''. Yii::t('app','Created Date').'',
				'value'=>function($model)
				{
					return date('m-d-Y', strtotime($model->createdtime));
				}
			],
            [
			 'class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{delete}',
			 'buttons'=>[
                              'view' => function ($url, $model) {

                              	$listingurl = base64_encode($model->listid.'_'.rand(1,9999));
                              	$mainUrl = Url::base(true);
                    					$mainUrl = str_replace('/admin', '', $mainUrl."/");
                    					$listingurl = $mainUrl.'user/listing/view/'.$listingurl.'/admin';   

                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $listingurl, [
                                        'title' => Yii::t('app', 'View'),
                                ]); 
							  },
							  /*
                              'update' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'update'.'?'.$urls[1];
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                ]);
							  },
							  */
                              'delete' => function ($url, $model) {
								$urls = explode("?",$url);
								$url = 'delete'.'?'.$urls[1];
								
                                return Html::a('', ['delete', 'id' => $model->id], [
								'class' => 'glyphicon glyphicon-trash',
								'data' => [
									'confirm' => ''. Yii::t('app','Are you sure, want to delete this report?').'', 
									'method' => 'post', 
								],
								]);
								
							  }							  
						]
			],
			[
				'label' => ''. Yii::t('app','Actions').'',
				'format' => 'raw',
				'value' =>function ($model) {

						$list_status = Listing::find()->select('liststatus')->where(['id'=>$model->listid])->one();

						if($list_status->liststatus != 2)
							return '<input type="button" class="btn btn-success" value="'. Yii::t('app','Block List').'" onclick="alterliststatus(\'block\','.$model->listid.')">';
						else
							return '<input type="button" class="btn btn-success" value="'. Yii::t('app','UnBlock List').'" onclick="alterliststatus(\'unblock\','.$model->listid.')">';
				}
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