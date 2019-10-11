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
<!-- 				<div class="panel-ctrls" -->
<!-- 					data-actions-container=""  -->
<!-- 					data-action-collapse='{"target": ".panel-body"}' -->
<!-- 					data-action-expand='' -->
<!-- 					data-action-colorpicker='' -->
<!-- 				> -->
<!-- 				</div> -->
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
			'label' => Yii::t('app','Role name'),
			'value' => $model->name,
		],
		[
			'label' => Yii::t('app','Role Description'),
			'value' => $model->description,
		],
[
			'label' =>  Yii::t('app', 'Priviliges'),
			'format'=>'raw',
			'value' => Html::a('Show Priviliges','javascript:void(0);', ['class' => 'btn btn-primary', 'onClick' => 'showuserroles();']),
		],
[
			'label' => Yii::t('app', 'Created Date'),
			'value' => date('Y-m-d', strtotime($model->created_time)),
		],
           
        ],
    ]) ?>

</div>
        </div></div>

        <!-- Popup starts-->
        <?php
            $priviliges = json_decode($model->priviliges);

            $priviligesData = array(
    'rolesmanagement'=>'Roles',
    'moderator'=>'Moderators',
    'usermanagement'=>'User Management',
    'blockedusermanagement' => 'Blocked User Management',
    'activehostmanagement'=> 'Active Host management',
    'blockedhostmanagement'=>'Blocked Host management',
    'reviewsmanagement'=>'Reviews & Ratings',
    'activelisting'=>'Active Listing',
    'blockedlisting'=>'Blocked Listing',
    'wishlists'=>'Wishlists',
    'managereports'=>'Manage Reports',
    'userreports'=>'User Reports',
    'listingreport'=>'Listing Report',
    'emailmanagement'=>'Email Management',
    'sitemanagement'=>'Site Management',
    'stripesettings'=>'Stripe Settings',
    'mobilesmssettings'=>'Mobile SMS Settings',  
    'socialloginsettings'=>'Social Login Settings',
    'footersettings'=>'Footer settings',
    'managecurrency'=>'Manage Currency',
    'managelanguages'=>'Manage Languages',
    'timezone'=>'timezone',
    'googlecodesettings'=>'Google Analaytics',

    'baseproperties'=>'Base Properties',
    'additionalamenities'=>'Additional Amenities',
    'commonamenities'=>'Common Amenties',
    'hometypes'=>'Home Types',
    'roomtypes'=>'Room Types',
    'safetychecklist'=>'Safety Checklists',
    'specialfeatures'=>'Special Features',

    'completereservations'=>'Complete Reservations',
    'incompletereservations'=>'Incomplete Reservations',
    'completeclaim'=>'Complete Claim',
    'incompleteclaim'=>'Incomplete Claim',
        
    'commission'=>'Commission',
    'sitecharges'=>'Site Charges',
    'tax'=>'Tax',
    'invoices'=>'Invoices',
    
    'homepagesettings'=>'Home Page Settings',
    'homepagecountries'=>'Home Page Countries',
    'buttonslider'=>'Button Slider',
    
    'helppages'=>'Help Pages',
    'termsandconditions'=>'Terms and Conditions',
    'cancellation'=>'Cancellation Policies', 
);

        ?>
		 <div class="invoice-popup-overlay">
            <div class="invoice-popup invoicediv">
                <div>
                    <button class="btn btn-danger pop-close" style="float: right;" type="button"><?php echo Yii::t('app','Close');?></button>
                    <div id="userdetails"></div>
                    <div id="rolesdetails">
                        
                        <div class="rightdiv">
                                <h3><?php echo Yii::t('app','Current Roles:');?></h3>
                        		<?php
                        			foreach($priviliges as $privilige)
                        			{
                                        
                        				echo '<input type="checkbox" checked="checked" disabled="disabled"> '.ucfirst($priviligesData[$privilige]).'<br/>';
                        			}
                        		?>
                        </div>
                        <div class="msgerrcls"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End popup -->