<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Lists */
$this->title = $model->name;
$this->params['subtitle'] = ''. Yii::t('app','View Role').'';
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php Yii::t('app',Html::encode($this->title)) ?></h2>	
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
<div class="lists-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		[
			'label' => 'ID',
			'value' => $model->id,
		],
		[
			'label' => Yii::t('app','User name'),
			'value' => $model->userid,
		],
		[
			'label' => Yii::t('app','Rating'),
			'value' => $model->rating,
		],
        [
			'label' => Yii::t('app', 'Created Time'),
			'value' => $model->cdate,
		],
           
        ],
    ]) ?>

</div>
        </div></div>

        <!-- Popup starts-->
		 <div class="invoice-popup-overlay">
            <div class="invoice-popup invoicediv">
                <div>
                    <button class="btn btn-danger pop-close" style="float: right;" type="button"><?php echo Yii::t('app','Close');?></button>
                    <div id="userdetails"></div>
                    <div id="rolesdetails">
                        <div class="leftdiv"><?php echo Yii::t('app','Current Roles:');?> </div>
                        <div class="rightdiv">
                        		<?php
                        		$priviliges = json_decode($model->priviliges);
                        			foreach($priviliges as $privilige)
                        			{
                        				echo '<input type="checkbox" checked="checked" disabled="disabled"> '.ucfirst($privilige).'<br/>';
                        			}
                        		?>
                        </div>
                        <div class="msgerrcls"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End popup -->