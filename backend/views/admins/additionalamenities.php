
<?php
use backend\models\Admin;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use backend\models\Additionalamenities;
$this->title = 'Manage Additional Amenities';
$this->params['subtitle'] = 'Manage Additional Amenities';
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
<?php Pjax::begin(['id' => 'amenities']) ?>
				<?php
				
echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'showFooter' => false,
			'filterRowOptions'=>['class'=>'input-sm'],
    'columns' => [
		['class'=>'yii\grid\SerialColumn'],
		[
			'attribute'=>'name',
		],
        'description',
		['class'=>'yii\grid\ActionColumn'],
    ],
        ]);				
				?>
			<?php
				echo '</div>
			</div>
		</div>
	</div>';
	?>
	<?php Pjax::end() ?>
<div class="invoice-popup-overlay">
	<div class="invoice-popup">
		<div>
			<button class="btn btn-danger pop-close" style="float: right;">Close</button>
			<div id="userdetails" class="popupdiv"></div>
			<div id="messagedetails" class="popupdiv">
				<div class="leftdiv">Message: </div>
				<div class="rightdiv"><textarea rows="5" cols="20" id="messagecont"></textarea></div>
				<input type="hidden" id="cuserid">
				<input type="button" value="Send" class="btn btn-primary" onclick="sendmessage()">
				<div class="has-success" id="succmsg" style="display: none;">
					<p class="help-block">
						<i class="fa fa-check"></i>
						Message sent successfully
					</p>
				</div>
			</div>
		</div>
	</div>
</div>


