<?php
/*
 * This page is for the user to change their password
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->params['breadcrumbs'][] = "";
$this->params['subtitle'] = "";
$this->title = Yii::t('app','cancelled');
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;

?>



<div class="bg_gray1">
      <div class="">    
	<div class="row">
    	
        <div class="col-xs-12 margin_top20 margin_bottom20">
        	<div class="col-sm-12">
                <div class="panel panel-default margin_top30">

                  <div class="panel-body padding10">



          		<?php echo "<center class='payment-success'><p>	Something went worng!</p>";
					echo "<p><span style='color:#B53A4A;'>Your payment was Cancelled, please try again.</span>.</p>";
					//echo "<p style='font-size:13px;'>You will receive a Email shortly from ".$setngs->noreplyname."</p>";	
					echo "</center>"
          
        				?>
     				   </div>  <!--Panel end -->       
       
    
        
      </div> <!--col-sm-9 end -->
        
    </div> <!--container end -->
</div>
</div>
</div>
</div>