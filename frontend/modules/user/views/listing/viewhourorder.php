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
use Dompdf\Dompdf;
use yii\CurrencyConverter\CurrencyConverter;
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
    <?php
    $converter = new CurrencyConverter();
	if($model->convertedcurrencycode!="")
	{
		if($model->currencycode!=$model->convertedcurrencycode)
		{
		$currency_code = $model->convertedcurrencycode;
		$rate =  $model->convertedprice;
		}
		else
		{
			$currency_code = $model->currencycode;
			$rate = "1";
		}
	}
	else
	{
		$rate = "1";
		$currency_code = $model->currencycode;
	}

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
        	
           
        	
            
        <div class="panel panel-default margin_top20" id="downdiv">
                      <div class="no-print col-sm-9 panel-heading profile_menu1 margin_bottom20" style="padding:0px;border:none;">
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
						$transurl = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/completedtransaction');
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
			echo '<p class="airfcfx-print-download-txt">'.Yii::t('app','Order Date').'<br />
			<div class="airfcfx-print-download-cnt">
				<a href="javascript:void(0);"><div class="airfcfx-printer" onclick="print_doc();"></div></a>
				<a href="javascript:void(0);"><div class="airfcfx-download" id="downbtn"></div></a>
			</div>
			<b>'.date('M d Y',strtotime($model->cdate)).'</b>
			<br />
			<hr />
			';
			$invoices = $model->getInvoices()->where(['orderid'=>$model->id])->one();
			if(!empty($invoices) && isset($invoices->paypaltransactionid))
			$transactionid = $invoices->paypaltransactionid;
			else
			$transactionid = "";
      $hours=explode('*|*',$model->hourly_booked);
      $bookedhours=date("h:i A", strtotime($hours[0])).'-'.date("h:i A", strtotime($hours[1]));
			echo '<p>'.Yii::t('app','Dates').'<br />
			<b>'.date('M d Y',$model->fromdate).' - '.date('M d Y',$model->todate).'</b>
      <p><b>'.$bookedhours.'</b></p>
      <p>'.Yii::t('app','Transaction ID').': '.$transactionid.'<br />
      <b></b>			
			<br />
			<hr />
			';
			echo '<table class="tablesorter table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>'.Yii::t('app','SI No').'</th>
                        <th>'.Yii::t('app','Listing Name').'</th>
                        <th>'.Yii::t('app','Duration').'</th>
                        <th>'.Yii::t('app','Number of hours').'</th>
                        <th>'.Yii::t('app','Price per Hour').'</th>
                        <th>'.Yii::t('app','Total Price').'</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>'.$listdata->listingname.'</td>
                        <td>Hourly based</td>
                        <td>'.$model->totalhours.'</td>
                        <td>'.round(($rate * $model->pricepernight),2).'</td>
                        <td>'.round(($rate * $model->total),2).'</td>
                    </tr>
                </tbody>
			</table>';
			$nightprice = $model->pricepernight * $model->totalhours;
			$totalprice = $nightprice + $model->commissionfees + $model->servicefees + $model->securityfees + $model->taxfees;
			echo '<div class="detaildiv">
                <div class="clear">
                    <div class="leftdivs">'.round(($rate * $model->pricepernight),2).' x '.$model->totalhours.'</div>
                    <div class="rightdivs">'.round(($rate * $nightprice),2).' '.$currency_code.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Commission Fees').'</div>
                    <div class="rightdivs">'.round(($rate * $model->commissionfees),2).' '.$currency_code.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Service Fees').'</div>
                    <div class="rightdivs">'.round(($rate * $model->servicefees),2).' '.$currency_code.'</div>
                </div>
                <div class="clear">
                  <div class="leftdivs">'.Yii::t('app','Security Deposit').'</div>
                    <div class="rightdivs">'.round(($rate * $model->securityfees),2).' '.$currency_code.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Tax').'</div>
                    <div class="rightdivs">'.round(($rate * $model->taxfees),2).' '.$currency_code.'</div>
                </div>
                <div class="clear divline"></div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Total').'</div>
                    <div class="rightdivs">'.round(($rate * $totalprice),2).' '.$currency_code.'</div>
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
<script src="<?php echo $baseUrl.'/js/html2canvas.js';?>"></script>

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
