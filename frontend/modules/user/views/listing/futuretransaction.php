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
use yii\CurrencyConverter\CurrencyConverter;
use frontend\models\Listing;
$this->title = Yii::t('app','Completed Transactions');
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;
//echo $userdata['firstname'];die;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$createyear = date('Y',$userdata['created_at']);
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
                      <div class="airfcfx-xs-heading-tab-cnt aifcfx-hor-padding airfcfx-panel panel-heading profile_menu1" style="padding-bottom:0px;">
                        <!-- Nav tabs -->
              <ul class="nav nav-tabs review_tab" role="tablist">
        <?php
        echo '
                <li role="presentation"><a class="airfcfx-tab-padding" href="'.$baseUrl.'/user/listing/completedtransaction">'.Yii::t('app','Completed Transaction').'</a></li>
                <li role="presentation" class="active"><a class="airfcfx-tab-padding" href="'.$baseUrl.'/user/listing/futuretransaction">'.Yii::t('app','Future Transaction').'</a></li> 
                <li role="presentation"><a class="airfcfx-tab-padding" href="'.$baseUrl.'/user/listing/othertransaction">'.Yii::t('app','Other Transaction').'</a></li>';
                //<li role="presentation"><a class="airfcfx-tab-padding" href="'.$baseUrl.'/user/listing/grossearning">'.Yii::t('app','Gross Earnings').'</a></li>';
        ?>
              </ul>
                      </div>
    
               
            
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="profile">
        
                      <div class="airfcfx-panel-padding panel-body">
                       <div class="row">                


                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                            <!--<div class="selcet-listing">
                              <select class="payout-method">
                                  <option value="">All payout methods</option>
                              </select>
                            </div>-->

                            <!--
                             <div class="selcet-listing">
                              <select class="payout-list">
                                  <option value="">All listings</option>
                                  <option value="madurai">madurai</option>
                              </select>
                            </div>
                            -->

                             <?php
                              $formattedMonthArray = array(
                    "1" => "January", "2" => "February", "3" => "March", "4" => "April",
                    "5" => "May", "6" => "June", "7" => "July", "8" => "August",
                    "9" => "September", "10" => "October", "11" => "November", "12" => "December",
                );
                            ?>
                             <div class="selcet-listing">
                              <select class="payout-start-month" onchange="javascript:filterbytransaction('future');">
                                  <option value="" selected=""><?= Yii::t('app','Order Month'); ?></option>
                                  <?php
                                    foreach($formattedMonthArray as $key=>$month)
                                    {
                                      $selected = (isset($_GET['month']) && $key == $_GET['month']) ? 'selected="selected"' : '';
                                      echo '<option value="'.$key.'" '.$selected.'>'.$month.'</option>';    
                                    }
                                  ?>
                              </select>
                            </div>
                            
                            <?php 
                              $years = range($createyear, date('Y'));


                            ?>
                             <div class="selcet-listing">
                              <select class="payout-start-year" onchange="javascript:filterbytransaction('future');">
                                  <option value=""><?= Yii::t('app','Year'); ?></option>
                                  <?php
                                    foreach($years as $year)
                                    {
                                      $selected = (isset($_GET['year']) && $_GET['year'] == $year) ? 'selected="selected"' : '';
                                      echo '<option value="'.$year.'" '.$selected.'>'.$year.'</option>';
                                    }
                                  ?>
                              </select>
                            </div>
                           
                            <?php
                                //$prices = array('0-100', '1000-2000', '2000-4000', '4000-8000', '8000-16000', '10000+');
                            ?>
                            <!-- div class="selcet-listing">
                              <select class="payout-list" onchange="javascript:filterbytransaction('price');">
                                  <option value=""><?= Yii::t('app','Amount'); ?></option>
                                  <?php /*
                                    foreach($prices as $price)
                                    {
                                       
                                      $selected = (isset($_GET['price']) && $_GET['price'] == $price) ? 'selected="selected"' : '';
                                      echo '<option value="'.$price.'" '.$selected.'>'.$price.'</option>';
                                    }*/
                                  ?>
                              </select>
                            </div -->
                          </div>


                                <div class="col-xs-12">
                                <table class="airfcfx-xs-table margin_bottom0 table table_no_border">
                                  <thead>
                                      <tr class="review_tab">
                                        <th><?php echo Yii::t('app','Order Date');?></th>
                                        <th><?php echo Yii::t('app','Booking Date');?></th>                                        
                                        <th><?php echo Yii::t('app','Listings');?></th>                                        
                                        <th><?php echo Yii::t('app','Amount');?></th>
                    <th><?php echo Yii::t('app','View');?></th>
                                      </tr>
                                    </thead>
                    <?php
                    if(!empty($transactions))
                    {
                      //$datas = (object) $transactions;

                      foreach($transactions as $transaction)
                      {
                        $created = $transaction->cdate;
                        $fromdate = $transaction->fromdate;
                        $todate = $transaction->todate;
                        $reserveid = $transaction->id;
                        $listid = $transaction->listid;
                        $invoice = $transaction->getInvoices()->where(['orderid'=>$reserveid])->one();
                        $listing = $transaction->getList()->where(['id'=>$listid])->one();
                        //$currency = $transaction->getCurrency()->where(['currencycode'=>$transaction->currencycode])->one(); 

                        $currency_code = $transaction->currencycode;
                      if($transaction->convertedcurrencycode!="")
                      {
                        if($transaction->currencycode!=$transaction->convertedcurrencycode)                       
                          $rate =  $transaction->convertedprice;
                        else
                          $rate = "1";
                      } else {
                        $rate = "1";
                      }

                      $currency = $transaction->getCurrencydetail($currency_code);

                      if(!empty($currency))
                        $currency_symbol = $currency->currencysymbol;
                      else
                        $currency_symbol = "";

                        $viewId = 'future*'.$transaction->id;
                        echo '<tr><td class="xs-table-heading">'.Yii::t('app','Order Date').'</td><td>'.date('M d,Y',strtotime($created)).'</td>
                        <td class="xs-table-heading">'.Yii::t('app','Booking Date').'</td><td>'.date('M d Y',$fromdate).' - '.date('M d Y',$todate).'</td>
                        <td class="xs-table-heading">'.Yii::t('app','Listings').'</td><td class="airfcfx-td-transc">'.$listing->listingname.'</td>
                        <td class="xs-table-heading">'.Yii::t('app','Amount').'</td><td>'.$currency_symbol.round(($rate * $transaction->total),2).'</td>
                        <td class="xs-table-heading">'.Yii::t('app','View').'</td><td align="center"><a href="'.$baseUrl.'/user/listing/vieworder/'.base64_encode($viewId).'"><i class="airfcfx-red-icon fa fa-search"></i></a></td>
                        </tr>
                        
                        ';
                      }
                    }
                    else
                    {
                      echo '<tr><td colspan="6"><div class="text-center margin_top20"><h3>'. Yii::t('app','No Transaction').'</h3></div></td></tr>';
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
       
       
      <!--div class="panel panel-default">
          <div class="panel-heading profile_menu1">
            <h3 class="panel-title">Login Notifications  </h3>
          </div>
          
          <div class="panel-body">
              <div class="row margin_top10">
                    <div class="col-xs-12">                        
                        <div class="checkbox margin_bottom20">
                                <label>
                                  <input type="checkbox">   Turn on login notifications  
                                </label>
                              </div>
                        
                        <p>Login notifications are an extra security feature. When you turn them on, we’ll let you know when anyone logs into your Airbnb account from a new browser. This helps keep your account safe. </p>
                        </div>
                    </div> 
          </div>
          <div class="panel-footer">
            <div class="text-right"><button class="btn btn_email  ">Save</button></div>
          </div>
          
      </div-->  <!--Panel end -->  
        
       
       
        
      </div> <!--col-sm-9 end -->
        
    </div> <!--container end -->


  
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
