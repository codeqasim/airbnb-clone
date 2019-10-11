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
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use frontend\models\Listing;
$this->title = Yii::t('app','Gross Earnings');
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;
//echo $userdata['firstname'];die;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$id = $userdata['id'];
$username = base64_encode($id."-".rand(0,999));
?>
<div class="profile_head">
	<div class="container">    
    	<ul class="profile_head_menu list-unstyled">
		<?php 
        echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
        <li><a href="'.$baseUrl.'/user/messages/inbox/traveling">'.Yii::t('app','Inbox').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listing').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/trips">'.Yii::t('app','Trips').'</a></li>
        <li><a href="'.$baseUrl.'/editprofile">'.Yii::t('app','Profile').'</a></li>  
        <li class="active"><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Account').'</a></li>';
        if (!Yii::$app->user->isGuest) {
          $loguserid = Yii::$app->user->identity->id;
          $userHostStatus = Yii::$app->user->identity->hoststatus;
          $userListings = Listing::find()->where(['userid'=>$loguserid])->all();

            if($userHostStatus == 1 && count($userListings) > 0) {
              echo '<li><a href="'.$baseUrl.'/user/listing/calendar">'.Yii::t('app','Calender').'</a></li>';
            }
        }
		?>
        </ul>
    </div> <!--container end -->
</div> <!--profile_head end -->


<div class="bg_gray1">
      <div class="container">    
        <div class="col-xs-12 col-sm-3 margin_top20">
        	<ul class="profile_left list-unstyled">
				<?php
             echo '<li><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Notifications').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/usernotifications">'.Yii::t('app','User Notifications').'</a></li>
            <li><a href="'.$baseUrl.'/changepassword">'.Yii::t('app','Security').'</a></li>
			<li class="active"><a href="'.$baseUrl.'/user/listing/completedtransaction">'.Yii::t('app','Transaction History').'</a></li>';
			?>
            </ul>
           
        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 margin_top20">
        	
           
        	
        <div class="airfcfx-panel panel panel-default">
                      <div class="airfcfx-xs-heading-tab-cnt airfcfx-panel aifcfx-hor-padding airfcfx-padd-top-20 panel-heading profile_menu1" style="padding-bottom:0px;">
                        <!-- Nav tabs -->
              <ul class="nav nav-tabs review_tab" role="tablist">
				<?php
				echo '
                <li role="presentation"><a class="airfcfx-tab-padding" href="'.$baseUrl.'/user/listing/completedtransaction">'.Yii::t('app','Completed Transaction').'</a></li>
                <li role="presentation"><a class="airfcfx-tab-padding" href="'.$baseUrl.'/user/listing/futuretransaction">'.Yii::t('app','Future Transaction').'</a></li> 
                <li role="presentation" class="active"><a class="airfcfx-tab-padding" href="'.$baseUrl.'/user/listing/grossearning">'.Yii::t('app','Gross Earnings').'</a></li>';
				?>            
              </ul>
                      </div>
    
              
            
              <!-- Tab panes -->
              <div class="tab-content">

                
                <div role="tabpanel" class="tab-pane active" id="profile">
                
                	
                      
                      <div class="airfcfx-panel-padding panel-body">
                       <div class="row">                
                                <div class="col-xs-12">
                                <table class="airfcfx-xs-table margin_bottom0 table table_no_border">
                                	<thead>
                                      <tr class="review_tab">
                                          <th><?php echo Yii::t('app','Order Date');?></th> 
                                    <th><?php echo Yii::t('app','Booking Date');?></th>
                                     <th><?php echo Yii::t('app','Transaction ID');?></th>               
                                           <th><?php echo Yii::t('app','Gross Earnings');?></th>                                        
                                      </tr>
                                    </thead>
										<?php
										if(!empty($transactions))
										{
											foreach($transactions as $transaction)
											{
												$created = $transaction->cdate;
												$fromdate = $transaction->fromdate;
												$todate = $transaction->todate;
												$reserveid = $transaction->id;
												$listid = $transaction->listid;
												$revenue = $transaction->total - ($transaction->commissionfees+$transaction->servicefees+$transaction->securityfees+$transaction->commissionfees);
												$invoice = $transaction->getInvoices()->where(['orderid'=>$reserveid])->one();
												$listing = $transaction->getList()->where(['id'=>$listid])->one();
												$currency = $transaction->getCurrency()->where(['currencycode'=>$transaction->currencycode])->one();
												if(isset($currency) && $currency->currencysymbol!="")
												$currencysymbol = $currency->currencysymbol;
												else
												$currencysymbol = "";
												echo '<tr><td class="xs-table-heading">Order Date</td><td>'.date('M d,Y',strtotime($created)).'</td>
												<td class="xs-table-heading">Booking Date</td><td>'.date('M d Y',$fromdate).' - '.date('M d Y',$todate).'</td>
												<td class="xs-table-heading">Transaction ID</td><td>'.$invoice['paypaltransactionid'].'</td>
												<td class="xs-table-heading">Gross Earnings</td><td align="center">'.$currencysymbol.$revenue.'</td>
												</tr>
												
												';
											}
										}
										else
										{
											echo '<tr><td colspan="6"><div class="text-center margin_top20"><h4>'. Yii::t('app','No Transaction').'</h4></div></td></tr>';
										}
										?>
                                </table>
                                
                                                            
							<?php
							echo '<div align="center" class="clear">';
							 echo LinkPager::widget([
								 'pagination' => $pages,
							]);
							 echo '</div>'
							?>
                                
                                </div>                           
                             </div> <!--row end --> 
                      </div>
                      
                    
                    
                     
                   
                </div> <!--#profile end -->

                
                 </div> <!-- tab end -->  
                	
                </div> <!--Panel end -->
        
       
       
        
      </div> <!--col-sm-9 end -->
        
    </div> <!--container end -->

</div>
  
<script>
$(document).ready(function(){    
    $(".show_ph").click(function(){
        $(".add_phone").show();
		$(".show_ph").hide();
    });
	$(".add_cont").click(function(){
        $(".add_contact").toggle();		
    });
	$(".add_ship").click(function(){
        $(".add_shipping").toggle();		
    });
});
</script>  