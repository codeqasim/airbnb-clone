<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Users;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Languagessearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Languages';
$this->params['subtitle'] = ''. Yii::t('app','Languages').'';
$this->params['breadcrumbs'][] = "";
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app','Manage Languages').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="languages-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<br />
    <p>
        <?= Html::a(''. Yii::t('app','Create Languages').'', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'home']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             [
		'attribute' => 'languagename',
		'label' => Yii::t('app','Language name')
	    ], 

            ['class' => 'yii\grid\ActionColumn',
			 'template'=>'{view}{update}{delete}',
			 'buttons'=>[
                       'delete' => function ($url, $model) {
									$urls = explode("?",$url);
									//$url = 'delete'.'?'.$urls[1];

									$userData = Users::find()->where(['LIKE','language',$model->languagename])->all();    
									if(count($userData)==0)
									{
	                           return Html::a('', ['delete', 'id' => $model->id], [
											'class' => 'glyphicon glyphicon-trash',
											'data' => [
												'confirm' => ''. Yii::t('app','Are you sure, want to delete this report?').'',
												'method' => 'post', 
											],
										]); 
									}
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

