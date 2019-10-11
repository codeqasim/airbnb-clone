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
use Dompdf\Dompdf;
use frontend\models\Currency;
use backend\components\Myclass;

$this->title = Yii::t('app','View Order Details');
?>

<?php
$baseUrl = Yii::$app->request->baseUrl;
//echo $userdata['firstname'];die;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$id = $userdata['id'];
$username = base64_encode($id."-".rand(0,999));
?>
<!--?php

$html =
'<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>hello</body>
  </html>';
  $html = " ";
function pdf_create($html, $filename='', $stream=TRUE) 
{
    $savein = '';
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
  $dompdf->stream("hello_world");
    $canvas = $dompdf->get_canvas();

    /*// the same call as in my previous example
    $canvas->page_text(540, 773, "Page {PAGE_NUM} of {PAGE_COUNT}",
                   $font, 6, array(0,0,0));*/

    $pdf = $dompdf->output();      // gets the PDF as a string

    file_put_contents("/var/www/html/arquivo.pdf",$pdf);  // save the pdf file on server

    unset($html);
    unset($dompdf); 

}

pdf_create($html);
?-->

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
          
           
          
            
        <div class="airfcfx-panel panel panel-default" id="downdiv">
                      <div class="col-sm-9 airfcfx-panel panel-heading profile_menu1 margin_bottom20" style="padding:0px;border:none;">
                        <!-- Nav tabs -->
              <ul class="airfcfx-panel-padding nav nav-tabs review_tab" role="tablist">
        <?php
        echo '
                <li class="airfcfx-view-order-li" role="presentation"><a>'.Yii::t('app','View Order Details').'</a></li>'; 
        ?>
              </ul>
        
                      </div>
            <div class="col-sm-3 airfcfx-panel-padding panel-heading profile_menu1 margin_bottom20" style="text-align: right;">
            <?php
            $transurl = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/'.$backtag.'transaction'); 
            echo '<a href="'.$transurl.'" class="airfcfx-view-order-back">'.Yii::t('app','Back').'</a>';
            ?>
            </div>
    
              
            
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="airfcfx-transaction-print tab-pane active" id="profile">
                
                  
                      
                      <div class="panel-body margin_top20">
                       <div class="row">                
                                <div class="col-xs-12">
      <?php
      echo '<div class="col-sm-12 no-padding"><div class="col-sm-6 airfcfx-print-download-txt no-hor-padding">'.Yii::t('app','Order Date').' - <b>'.date('M d Y',strtotime($model->cdate)).'</b></div>
      <div class="col-sm-6 airfcfx-print-download-cnt no-hor-padding">
        <a href="javascript:void(0);"><div class="airfcfx-printer" onclick="print_doc();"></div></a>
        <a href="javascript:void(0);"><div class="airfcfx-download" id="downbtn"></div></a>
      </div> <br /><br /><hr /></div>
      
      ';
      $invoices = $model->getInvoices()->where(['orderid'=>$model->id])->one();
      if(!empty($invoices) && isset($invoices->stripe_transactionid))
      $transactionid = $invoices->stripe_transactionid;
      else
      $transactionid = "";

      $reserve_duration = ($model->booking == "perhour") ? "Per Hour":"Per Night";
      echo '<p>'.Yii::t('app','Dates').'<br />
      <b>'.date('M d Y',$model->fromdate).' - '.date('M d Y',$model->todate).'</b><br />
      <b>'.date('h:i A',strtotime($model->checkin)).' - '.date('h:i A',strtotime($model->checkout)).'</b><br />

      <p><br />'.Yii::t('app','Transaction ID').': '.$transactionid.'<br />'.Yii::t('app','Duration').': '.$reserve_duration.'<br /><hr />'; 

      $totalduration = ($model->booking=="perhour")?$model->totalhours:$model->totaldays;
      $totaldurationtitle = ($model->booking=="perhour")?Yii::t('app','Number of hours'):Yii::t('app','Number of days');

       $currencycode = $model->currencycode;

      if($model->convertedcurrencycode!="")
      {
        if($model->currencycode!=$model->convertedcurrencycode)           
          $rate =  $model->convertedprice;
        else
          $rate = "1";
      } else {
        $rate = "1";
      } 



      if($model->convertedcurrencycode!="" && $model->currencycode!="" && ($model->convertedcurrencycode!=$model->currencycode)) {
          //user currency
          $rate2= Myclass::getcurrencyprice($model->convertedcurrencycode);
          //listing currency
          $rate1= Myclass::getcurrencyprice($model->currencycode); 

      } else {
          $rate = "1";    $rate2 = "1";
      } 

      if($model->bookstatus == "accepted" && $model->orderstatus == "pending") {
                echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).' '.Yii::t('app','by Host').'</p>';
      } else if($model->bookstatus == "accepted" && $model->orderstatus == "paid") {
                
          /*$other_transaction = json_decode($model->other_transaction, true);
          echo '<br><p><b>'.Yii::t('app','Security Deposit Refund To Guest').'</b></p>';
          echo '<p>'.Yii::t('app','Refund ID').' : '.$other_transaction['refund_id'].'</p>';
          echo '<p>'.Yii::t('app','Refund Status').' : '.ucfirst($other_transaction['status']).'</p>';

          echo '<p>'.Yii::t('app','Refund Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

          echo '<p>'.Yii::t('app','Refund Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>'; */

          $other_transaction = json_decode($model->claim_transaction, true);
          echo '<br><p><b>'.Yii::t('app','Host Amount').'</b></p>';
          echo '<p>'.Yii::t('app','Transaction ID').' : '.$other_transaction['claim_id'].'</p>';
          $hostAmount = $other_transaction['amount']/100;
          $hostAmount = number_format(round(($rate1 * ($hostAmount/ $rate2)),2),2,".","");
          echo '<p>'.Yii::t('app','Transaction Amount').' : '.$hostAmount.' '.$model->currencycode.'</p>';

          echo '<p>'.Yii::t('app','Transaction Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>'; 

      } else if($model->bookstatus == "refunded" && $model->orderstatus == "paid") {
          echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).'</p><br/>';
          /*if($model->other_transaction!="") {
              $other_transaction = json_decode($model->other_transaction, true);
              echo '<br><p><b>'.Yii::t('app','Amount Refund To Guest').'</b></p>';
              echo '<p>'.Yii::t('app','Refund ID').' : '.$other_transaction['refund_id'].'</p>';
              echo '<p>'.Yii::t('app','Refund Status').' : '.ucfirst($other_transaction['status']).'</p>';

              echo '<p>'.Yii::t('app','Refund Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

              echo '<p>'.Yii::t('app','Cancel Percentage').' : '.$other_transaction['percentage'].' % </p>';

              echo '<p>'.Yii::t('app','Refund Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';
          } */ 

          if($model->claim_transaction!="") { 
              $other_transaction = json_decode($model->claim_transaction, true);
              echo '<p><b>'.Yii::t('app','Host Amount').'</b></p>';  
              echo '<p>'.Yii::t('app','Cancel ID').' : '.$other_transaction['deduct_id'].'</p>'; 
              echo '<p>'.Yii::t('app','Cancel Status').' : '.ucfirst($other_transaction['status']).'</p>';
              $hostAmount = $other_transaction['amount']/100;
              $hostAmount = number_format(round(($rate1 * ($hostAmount/ $rate2)),2),2,".","");
              echo '<p>'.Yii::t('app','Cancel Amount').' : '.$hostAmount.' '.$model->currencycode.'</p>';

              echo '<p>'.Yii::t('app','Cancel Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>'; 

          }

      } else if($model->bookstatus == "claimed" && $model->orderstatus == "pending" && $model->claim_status =="pending") {
          echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).' '.Yii::t('app','by Host').'</p>';
      } else if($model->bookstatus == "claimed" && $model->orderstatus == "paid" && $model->claim_status =="declined") {
          echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).' '.Yii::t('app','by Host').'</p>';
          /*$other_transaction = json_decode($model->other_transaction, true);
          echo '<br><p><b>'.Yii::t('app','Security Deposit Refund To Guest').'</b></p>';
          echo '<p>'.Yii::t('app','Refund ID').' : '.$other_transaction['refund_id'].'</p>';
          echo '<p>'.Yii::t('app','Refund Status').' : '.ucfirst($other_transaction['status']).'</p>';

          echo '<p>'.Yii::t('app','Refund Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

          echo '<p>'.Yii::t('app','Refund Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>'; */

          $other_transaction = json_decode($model->claim_transaction, true);
          echo '<br><p><b>'.Yii::t('app','Claim Amount To Host').'</b></p>';
          echo '<p>'.Yii::t('app','Transaction ID').' : '.$other_transaction['claim_id'].'</p>';
          echo '<p>'.Yii::t('app','Claim Status by Admin').' : '.ucfirst($model->claim_status).'</p>';

          $hostAmount = $other_transaction['amount']/100;
          $hostAmount = number_format(round(($model->convertedprice * $hostAmount),2),2,".",""); 
          echo '<p>'.Yii::t('app','Transaction Amount').' : '.$hostAmount.' '.$model->currencycode.'</p>';

          echo '<p>'.Yii::t('app','Transaction Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';
      } else if($model->bookstatus == "claimed" && $model->orderstatus == "paid" && $model->claim_status =="approved") {
          echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).' '.Yii::t('app','by Host').'</p>';
          $other_transaction = json_decode($model->claim_transaction, true);
          echo '<br><p><b>'.Yii::t('app','Claim Amount To Host').'</b></p>';
          echo '<p>'.Yii::t('app','Claim ID').' : '.$other_transaction['claim_id'].'</p>';
          echo '<p>'.Yii::t('app','Claim Status by Admin').' : '.ucfirst($model->claim_status).'</p>'; 

          $hostAmount = $other_transaction['amount']/100;
          $hostAmount = number_format(round(($model->convertedprice * $hostAmount),2),2,".",""); 
          echo '<p>'.Yii::t('app','Claim Amount').' : '.$hostAmount.' '.$model->currencycode.'</p>';
 
          echo '<p>'.Yii::t('app','Claim Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';
      } 

      echo '<hr />';

      
    //  $nightprice = number_format(round($rate * ($model->pricepernight/$rate1),2),2,".","") * $totalduration;
      /*$nightprice = $model->pricepernight * $totalduration;
      $nightprice = number_format(round($rate * ($nightprice/$rate1),2),2,".","");  
      $commissionfees = number_format(round($rate * ($model->commissionfees/$rate1),2),2,".","");
      $servicefees = number_format(round($rate * ($model->servicefees/$rate1),2),2,".","");
      $securityfees = number_format(round($rate * ($model->securityfees/$rate1),2),2,".","");
      $taxfees = number_format(round($rate * ($model->taxfees/$rate1),2),2,".","");
      $cleaningfees = number_format(round($rate * ($model->cleaningfees/$rate1),2),2,".","");
      $sitefees = number_format(round($rate * ($model->sitefees/$rate1),2),2,".",""); */

    //  $totalprice = $nightprice + $commissionfees + $servicefees + $securityfees + $taxfees + $cleaningfees + $sitefees;  

      $nightprice = $model->pricepernight * $totalduration;
      $nightprice = number_format(round($nightprice,2),2,".","");  
      $commissionfees = number_format(round($model->commissionfees,2),2,".","");
      $servicefees = number_format(round($model->servicefees,2),2,".","");
      $securityfees = number_format(round($model->securityfees,2),2,".","");
      $taxfees = number_format(round($model->taxfees,2),2,".","");
      $cleaningfees = number_format(round($model->cleaningfees,2),2,".","");
      $sitefees = number_format(round($model->sitefees,2),2,".","");

      $totalprice = number_format(round(($rate * $model->total),2),2,".",""); 


      echo '<table class="tablesorter table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>'.Yii::t('app','Listing Name').'</th>
                        <th>'.$totaldurationtitle.'</th>';
                        $totaldurationtitle = ($model->booking=="perhour")?Yii::t('app','Price per hour'):Yii::t('app','Price per night'); 
                       echo '<th>'.$totaldurationtitle.'</th>
                        <th>'.Yii::t('app','Total Price').'</th>
                        <th>'.Yii::t('app','Guest Pay').'</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$listdata->listingname.'</td>
                        <td>'.$totalduration.'</td>
                        <td>'.$currencycode." ".$model->pricepernight.'</td>
                        <td>'.$currencycode.' '.$totalprice.'</td>
                        <td>'.$model->convertedcurrencycode.' '.$model->total.'</td>  
                    </tr>
                </tbody>
      </table>';
      
      echo '<div class="detaildiv">
                <div class="clear">
                    <div class="leftdivs">'.$model->pricepernight.' x '.$totalduration.'</div>  
                    <div class="rightdivs">'.$nightprice.' '.$currencycode.'</div>
                </div>
                <div class="clear">
                     <div class="leftdivs">'.Yii::t('app','Commission Fees').'</div>
                    <div class="rightdivs">'.$commissionfees.' '.$currencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Service Fees').'</div>
                    <div class="rightdivs">'.$servicefees.' '.$currencycode.'</div>
                </div>
                <div class="clear">
                   <div class="leftdivs">'.Yii::t('app','Security Deposit').'</div>
                    <div class="rightdivs">'.$securityfees.' '.$currencycode.'</div>
                </div>
                <div class="clear">
                       <div class="leftdivs">'.Yii::t('app','Tax').'</div>
                    <div class="rightdivs">'.$taxfees.' '.$currencycode.'</div>
                </div>
                <div class="clear">
                       <div class="leftdivs">'.Yii::t('app','Cleaning Fees').'</div>
                    <div class="rightdivs">'.$cleaningfees.' '.$currencycode.'</div>
                </div> 
                <div class="clear">
                       <div class="leftdivs">'.Yii::t('app','Site Fees').'</div>
                    <div class="rightdivs">'.$sitefees.' '.$currencycode.'</div>
                </div>
                <div class="clear divline"></div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Total').'</div>
                    <div class="rightdivs">'.$totalprice.' '.$currencycode.'</div>
                </div>
                <div class="clear divline"></div> 
      </div>'; 
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

<script src="<?php echo $baseUrl.'/js/jsPDF/dist/jspdf.min.js';?>"></script>

<script type="text/javascript">
$('#downbtn').click(function () {

/*var pdf = new jsPDF();
 pdf.addHTML($('#downdiv')[0], function () {
     pdf.save('Test.pdf');
 });*/
var pdf = new jsPDF('l', 'pt', 'a4');
 var options = {
    pagesplit: true
};

pdf.addHTML($('#downdiv'), 0, 0, options, function(){
    pdf.save("test.pdf");
});

  /*html2canvas(document.getElementById("downdiv"),{
      onrendered : function(canvas) 
      {
        var img = canvas.toDataURL('image/png');
        var doc = newjsPDF();
        doc.addImage(img,'JPEG',20,20);
        doc.save('sample-file.pdf');
      }
  });*/
});
</script>
