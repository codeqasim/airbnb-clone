<?php
use yii\helpers\Html;
use backend\models\Profilereports;
use backend\models\Userreports;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Users;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Listssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Manage User Reports');
$this->params['subtitle'] = ''. Yii::t('app','User Reports').'';
$this->params['breadcrumbs'][]= '';

	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage User Reports').'</h2>
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

          /* [
		'attribute' => 'id',
		'label' => Yii::t('app','ID')
	    ],*/
			
           	
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
				'label' => ''. Yii::t('app','Report Person').'',
				'value' => function($model)
				{
					$username = Users::find()->where(['id'=>$model->reporterid])->one();

					return (isset($username->firstname) && $username->firstname != '') ? $username->firstname : '';
				}
			],
			[
				'label' => ''. Yii::t('app','Report Count').'',
				'value' => function($model)
				{
					$getReportcount = Userreports::find()->where(['reportid'=>$model->reportid, 'reporterid'=>$model->reporterid, 'report_type'=>'profile'])->count();
					return $getReportcount;
				}
			],
			[
				'label'=>''. Yii::t('app','Created Date').'',
				'value' => function($model)
				{
					return date('m-d-Y', strtotime($model->createdtime));
				}
			],
            [
			 'class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{delete}',
			 'buttons'=>[
                              'view' => function ($url, $model) {
											$username = base64_encode($model->reporterid."-".rand(0,999));
											$mainUrl = Url::base(true);
				                    	$mainUrl = str_replace('/admin', '', $mainUrl."/"); 
                    					
                    					$profileUrl = $mainUrl.'profile/' . $username;

                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $profileUrl, [
                                        'title' => Yii::t('app', 'View'),
                                ]);
							  },
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

						$get_host_status = Users::find()->select('hoststatus')->where(['id'=>$model->reporterid])->one();
						if(isset($get_host_status->hoststatus) && $get_host_status->hoststatus != 0)
							return '<input type="button" class="btn btn-success" value="'. Yii::t('app','Block Host').'" onclick="changehoststatus(\'block\','.$model->reporterid.')">';
						else
							return '<input type="button" class="btn btn-success" value="'. Yii::t('app','Unblock Host').'" onclick="changehoststatus(\'unblock\','.$model->reporterid.')">';
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