<?php

/*
 * This page displays the user verification information. User can verify their phone number and email here.
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\components\MyClass;
use frontend\models\Listing;
$this->title = 'Stripe Host Account';

$baseUrl = Yii::$app->request->baseUrl;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$id = $userdata['id'];
$username = base64_encode($id."-".rand(0,999));

// Stripe Key
\Stripe\Stripe::setApiKey($sitesetting['stripe_secretkey']);

if($userdata->stripe_account_id != "") {
   $stripeAccountId= json_decode(trim($userdata->stripe_account_id));

   $account = \Stripe\Account::retrieve(trim($stripeAccountId->accountid));
   $details = $account->jsonSerialize();

   if($details['payouts_enabled'] == 1 && count($details['verification']['fields_needed']) == 0 && $details['charges_enabled'] == 1 && $details['legal_entity']['verification']['status'] == "verified") {
      $formEntry = 1;
   } else {
      $formEntry = 0;
   }
} else {
   $formEntry = 0;
}  

//echo $this->context->dataReturn('as','asd'); 
?>
<div class="profile_head">
	<div class="container">    
      <ul class="profile_head_menu list-unstyled">
         <?php 
            echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
            <li><a href="'.$baseUrl.'/user/messages/inbox/traveling">'.Yii::t('app','Inbox').'</a></li>
            <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listing').'</a></li>
            <li><a href="'.$baseUrl.'/user/listing/trips">'.Yii::t('app','Trips').'</a></li>
            <li class="active"><a href="'.$baseUrl.'/editprofile">'.Yii::t('app','Profile').'</a></li>
            <li><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Account').'</a></li>'; 
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
               echo '<li><a href="'.$baseUrl.'/editprofile" >'.Yii::t('app','Edit Profile').'</a></li>  
               <li class="active"><a href="'.$baseUrl.'/paysettings/default" >'.Yii::t('app','Stripe Host Account').'</a></li>           
               <li><a href="'.$baseUrl.'/trust" >'.Yii::t('app','Trust and Verification').'</a></li>
               <li><a href="'.$baseUrl.'/user/listing/reviewsbyyou" >'.Yii::t('app','Reviews').'</a></li>';
            ?>         
         </ul>
         <a href="<?php echo $baseUrl.'/profile/'.$username;?>">
            <button class="airfcfx-panel btn-border full-width btn btn_google margin_top20">       <?php echo Yii::t('app','View Profile');?>
            </button>
         </a>
      </div> <!--col-sm-3 end -->

      <div class="col-xs-12 col-sm-9 no-padding">
         <?php
            if($formEntry == 0) {
               $form = ActiveForm::begin(['id' => 'form-stripe','action'=>''.$baseUrl.'/paysave',
               //'enableAjaxValidation' => true,
               //'enableClientValidation'=>true,
               //'validateOnSubmit'=>true,
               ]);
            } else {
               $form = ActiveForm::begin();
            }
         ?>
            <div class="col-xs-12 col-sm-12 margin_top20">      
               <div class="airfcfx-panel panel panel-default">
                  <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
                     <h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','Host Country');?></h3>
                  </div>

                  <div class="airfcfx-panel-padding panel-body">
                     <div class="row">                
                        <div class="col-xs-12 col-sm-12">
                           <p class="margin_top_5 text_red margin_bottom20">
                              <?php echo Yii::t('app','We never share this data with others.')." ".Yii::t('app','These details are mandatory for account creation in Stripe Payment.');?>
                           </p>
                        </div>
                        <div class="col-xs-12 col-sm-12">
                           <div class="col-xs-12 col-sm-3 ">
                              <label class="profile_label">
                                 <?php echo Yii::t('app','Host Country');?>
                              </label>
                           </div>
                           <div class="col-xs-12 col-sm-9">
                              <select class="form-control stripeHostCountry" style="width:auto;" id="stripeHostCountry" name="Stripe[hostCountry]">
                                 <?php
                                 if($userdata->stripe_account_id != "") {
                                    $stripeHostCountry = json_decode($sitesetting->stripe_host_support_country, true);
                                    $stripeHostAccount = json_decode($userdata->stripe_account_id, true);

                                    if(in_array( trim($stripeHostAccount['base']), $stripeHostCountry)) {
                                       $valueSplit = explode('~', trim($stripeHostAccount['base']));
                                       echo '<option value="'.Myclass::getEcode(trim($stripeHostAccount['base'])).'" selected>'.$valueSplit[2].' - '.$valueSplit[1].'</option>';
                                       $hostFlag = 1;
                                    } else {
                                       $hostFlag = 0;
                                    }
                                 } else {
                                    $hostFlag = 0;
                                 }

                                 if($hostFlag == 0) {
                                    $stripeHostCountry = json_decode($sitesetting->stripe_host_support_country, true);
                                    foreach ($stripeHostCountry as $key => $value) {
                                       $valueSplit = explode('~', $value);
                                       if($hostCountryOnLoad == $value) {
                                          echo '<option value="'.Myclass::getEcode($value).'" selected>'.$valueSplit[2].' - '.$valueSplit[1].'</option>';
                                       } else {
                                          echo '<option value="'.Myclass::getEcode($value).'">'.$valueSplit[2].' - '.$valueSplit[1].'</option>';
                                       }
                                    }
                                 }

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div> <!--row end -->
                  </div>
               </div> <!--Panel end -->
            </div>
          
            <?php 
            $stripe_accountnumber = "";
            if(isset($_SESSION['Stripe']['accountnumber']))
               $stripe_accountnumber = $_SESSION['Stripe']['accountnumber'];

            $stripe_routingnumber = "";
            if(isset($_SESSION['Stripe']['routingnumber']))
               $stripe_routingnumber = $_SESSION['Stripe']['routingnumber'];

            $stripe_personalidnumber = "";
            if(isset($_SESSION['Stripe']['personalidnumber']))
               $stripe_personalidnumber = $_SESSION['Stripe']['personalidnumber'];

            $stripe_ssn = "";
            if(isset($_SESSION['Stripe']['ssn']))
               $stripe_ssn = $_SESSION['Stripe']['ssn'];

            $stripe_firstname = "";
            if(isset($_SESSION['Stripe']['firstname']))
               $stripe_firstname = $_SESSION['Stripe']['firstname'];

            $stripe_lastname = "";
            if(isset($_SESSION['Stripe']['lastname']))
               $stripe_lastname = $_SESSION['Stripe']['lastname'];

            $stripe_day = "";
            if(isset($_SESSION['Stripe']['day']))
               $stripe_day = $_SESSION['Stripe']['day'];

            $stripe_month = "";
            if(isset($_SESSION['Stripe']['month']))
               $stripe_month = $_SESSION['Stripe']['month'];

            $stripe_year = "";
            if(isset($_SESSION['Stripe']['year']))
               $stripe_year = $_SESSION['Stripe']['year'];

            $stripe_phonenumber = "";
            if(isset($_SESSION['Stripe']['phonenumber']))
               $stripe_phonenumber = $_SESSION['Stripe']['phonenumber'];

            $stripe_line = "";
            if(isset($_SESSION['Stripe']['line']))
               $stripe_line = $_SESSION['Stripe']['line'];

            $stripe_lineoptional = "";
            if(isset($_SESSION['Stripe']['lineoptional']))
               $stripe_lineoptional = $_SESSION['Stripe']['lineoptional'];

            $stripe_city = "";
            if(isset($_SESSION['Stripe']['city']))
               $stripe_city = $_SESSION['Stripe']['city'];

            $stripe_state = "";
            if(isset($_SESSION['Stripe']['state']))
               $stripe_state = $_SESSION['Stripe']['state'];

            $stripe_postalcode = "";
            if(isset($_SESSION['Stripe']['postalcode']))
               $stripe_postalcode = $_SESSION['Stripe']['postalcode'];

            $cntry = explode("~",$hostCountryOnLoad);

            if($cntry[0] != "JP") {
            ?>
               <div class="col-xs-12 col-sm-12">        
                  <div class="airfcfx-panel panel panel-default">
                     <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
                        <h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','Host Account');?></h3>
                     </div>

                     <div class="airfcfx-panel-padding panel-body">
                        <div class="row">
                           <?php 
                           if(!in_array($cntry[1],$europeanCurrencies)) {
                           ?>
                              <div class="col-xs-12 col-sm-12 margin_top10">
                                 <div class="col-xs-12 col-sm-3 ">
                                    <label class="profile_label">
                                       <?php echo Yii::t('app','Account Number');?>
                                    </label> 
                                 </div>
                                 <div class="col-xs-12 col-sm-9">
                                    <?php if($userdata->stripe_account_id == "") { ?>
                                       <?= $form->field($model, 'accountnumber')->textInput(['class' => 'form-control','name'=>'Stripe[accountnumber]','placeholder'=>'','maxlength'=>'50','value'=>''.$stripe_accountnumber.''])->label(false) ?>
                                    <?php } else { ?>
                                       <label class="profile_label label_account_type">
                                          <?php echo base64_decode($this->context->dataReturn('accountnumber','AC'));?>
                                       </label>
                                       <?= $form->field($model, 'accountnumber')->hiddenInput(['class' => 'form-control','name'=>'Stripe[accountnumber]','placeholder'=>'','maxlength'=>'50','value'=>''.base64_decode($this->context->dataReturn('accountnumber','AC')).''])->label(false) ?>
                                     <?php } ?>
                                 </div>
                              </div>

                              <div class="col-xs-12 col-sm-12 margin_top10">
                                 <div class="col-xs-12 col-sm-3 ">
                                    <label class="profile_label">
                                       <?php echo Yii::t('app','Routing Number');?>
                                    </label> 
                                 </div>
                                 <div class="col-xs-12 col-sm-9">
                                    <?php if($userdata->stripe_account_id == "") { ?>
                                       <?= $form->field($model, 'routingnumber')->textInput(['class' => 'form-control','name'=>'Stripe[routingnumber]','placeholder'=>'','maxlength'=>'50','value'=>''.$stripe_routingnumber.''])->label(false) ?> 
                                    <?php } else { ?>
                                       <label class="profile_label label_account_type">
                                          <?php echo base64_decode($this->context->dataReturn('routingnumber','AC'));?>
                                       </label>
                                       <?= $form->field($model, 'routingnumber')->hiddenInput(['class' => 'form-control','name'=>'Stripe[routingnumber]','placeholder'=>'','maxlength'=>'50','value'=>''.base64_decode($this->context->dataReturn('routingnumber','AC')).''])->label(false) ?>
                                    <?php } ?>
                                 </div>
                              </div>
                           <?php } else { ?>
                              <div class="col-xs-12 col-sm-12 margin_top10">
                                 <div class="col-xs-12 col-sm-3 ">
                                    <label class="profile_label">
                                       <?php echo Yii::t('app','IBAN (Europe)');?>
                                    </label> 
                                 </div>
                                 <div class="col-xs-12 col-sm-9">
                                    <?php if($userdata->stripe_account_id == "") { ?>
                                       <?= $form->field($model, 'accountnumber')->textInput(['class' => 'form-control','name'=>'Stripe[accountnumber]','placeholder'=>''.$cntry[0].'89370400440532013000','maxlength'=>'50','value'=>''.$stripe_accountnumber.''])->label(false) ?>   
                                    <?php } else { ?>
                                       <label class="profile_label label_account_type">
                                          <?php echo base64_decode($this->context->dataReturn('accountnumber','AC'));?>
                                       </label>
                                       <?= $form->field($model, 'accountnumber')->hiddenInput(['class' => 'form-control','name'=>'Stripe[accountnumber]','placeholder'=>''.$cntry[0].'89370400440532013000','maxlength'=>'50','value'=>''.base64_decode($this->context->dataReturn('accountnumber','AC')).''])->label(false) ?>
                                     <?php } ?>
                                 </div>
                              </div>
                           <?php } ?>

                           <?php 
                           if(in_array($cntry[0],$includePersonalIdBasis)) {
                           ?> 
                              <div class="col-xs-12 col-sm-12 margin_top10">
                                 <div class="col-xs-12 col-sm-3 ">
                                    <label class="profile_label">
                                       <?php echo Yii::t('app','Personal ID Number');?>
                                    </label> 
                                 </div>
                                 <div class="col-xs-12 col-sm-9">
                                    <?php if($userdata->stripe_account_info == "") { ?>
                                       <?= $form->field($model, 'personalidnumber')->textInput(['class' => 'form-control','name'=>'Stripe[personalidnumber]','placeholder'=>'','maxlength'=>'50','value'=>''.$stripe_personalidnumber.''])->label(false) ?>
                                    <?php } else { ?>
                                       <?= $form->field($model, 'personalidnumber')->textInput(['class' => 'form-control','name'=>'Stripe[personalidnumber]','placeholder'=>'','maxlength'=>'50','value'=>''.base64_decode($this->context->dataReturn('personalidnumber','IN')).''])->label(false) ?>
                                    <?php } ?>
                                 </div>
                              </div>
                           <?php } ?>

                           <?php 
                           if($cntry[0] == "US") {
                           ?> 
                              <div class="col-xs-12 col-sm-12 margin_top10">
                                 <div class="col-xs-12 col-sm-3 ">
                                    <label class="profile_label no-ver-padding"> 
                                       <?php echo Yii::t('app','SSN Number')."<br>".Yii::t('app','(Last Four Digit)');?>
                                    </label> 
                                 </div>
                                 <div class="col-xs-12 col-sm-9">
                                    <?php if($userdata->stripe_account_info == "") { ?>
                                       <?= $form->field($model, 'ssn')->textInput(['class' => 'form-control','name'=>'Stripe[ssn]','placeholder'=>'','maxlength'=>'4','value'=>''.$stripe_ssn.''])->label(false) ?>
                                    <?php } else { ?>
                                       <?= $form->field($model, 'ssn')->textInput(['class' => 'form-control','name'=>'Stripe[ssn]','placeholder'=>'','maxlength'=>'4','value'=>''.base64_decode($this->context->dataReturn('ssn_last_four','IN')).''])->label(false) ?>
                                    <?php } ?>
                                 </div>
                              </div>
                           <?php } ?>

                           <?php if($userdata['stripe_account_id'] != "" && $userdata['stripe_status'] !="") { ?>
                              <div class="col-xs-12 col-sm-12 margin_top10">
                                 <div class="col-xs-12 col-sm-3 ">
                                    <label class="profile_label">
                                       <?php echo Yii::t('app','Account Status');?>
                                    </label> 
                                 </div>
                                 <div class="col-xs-12 col-sm-9">
                                    <label class="profile_label label_account_type">
                                       <?php echo strtoupper(Yii::t('app',$userdata['stripe_status'])); ?> 
                                    </label> 
                                 </div>
                              </div>
                           <?php } ?>

                           <?php if($userdata['stripe_account_id'] != "" && $userdata['stripe_status'] !="" && $userdata['stripe_account_info'] != "") { ?>
                              <?php $accountData = json_decode($userdata['stripe_account_info'], true); ?>

                              <div class="col-xs-12 col-sm-12 margin_top10">
                                 <div class="col-xs-12 col-sm-3 ">
                                    <label class="profile_label">
                                       <?php echo Yii::t('app','Payout Status');?>
                                    </label> 
                                 </div>
                                 <div class="col-xs-12 col-sm-9">
                                    <label class="profile_label label_account_type">
                                       <?php if($accountData['payouts_enabled'] == 1)
                                          echo Yii::t('app',"Enabled"); 
                                       else
                                          echo "<span class='text_redonly'>".Yii::t('app',"Disabled")."</span>";
                                       ?> 
                                    </label> 
                                 </div> 
                              </div>

                              <?php if($accountData['payouts_enabled'] == 1) { ?>
                                 <div class="col-xs-12 col-sm-12 margin_top10">
                                    <div class="col-xs-12 col-sm-3 ">
                                       <label class="profile_label">
                                          <?php echo Yii::t('app','Payout Schedule');?>
                                       </label> 
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                       <label class="profile_label label_account_type">
                                          <?php echo ucfirst($accountData['payouts_interval'])." - ".$accountData['payouts_day']." ".Yii::t('app','day rolling basis');?> 
                                       </label> 
                                    </div>
                                 </div> 
                              <?php } ?>
                           <?php } ?>

                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-xs-12 col-sm-12">        
                  <div class="airfcfx-panel panel panel-default">
                     <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
                        <h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','Host Information');?></h3>
                     </div>

                     <div class="airfcfx-panel-padding panel-body">
                        <div class="row"> 
                           <div class="col-xs-12 col-sm-12 margin_top10">
                              <div class="col-xs-12 col-sm-3 ">
                                 <label class="profile_label">
                                    <?php echo Yii::t('app','First Name');?>
                                 </label> 
                              </div>
                              <div class="col-xs-12 col-sm-9">
                                 <?php if($userdata->stripe_account_info == "") { ?>
                                    <?= $form->field($model, 'firstname')->textInput(['class' => 'form-control','name'=>'Stripe[firstname]','placeholder'=>'First Name','maxlength'=>'30','value'=>''.$firstname.'','onkeypress'=>'return isAlpha(event)'])->label(false) ?>
                                 <?php } else { ?>
                                     <?= $form->field($model, 'firstname')->textInput(['class' => 'form-control','name'=>'Stripe[firstname]','placeholder'=>'First Name','maxlength'=>'30','value'=>''.base64_decode($this->context->dataReturn('firstname','IN')).'','onkeypress'=>'return isAlpha(event)'])->label(false) ?>
                                 <?php } ?>
                              </div>
                           </div> <!--col-xs-12 end -->
                       
                           <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                              <div class="col-xs-12 col-sm-3 ">
                                 <label class="profile_label">
                                    <?php echo Yii::t('app','Last Name');?>
                                 </label> 
                              </div>
                              <div class="col-xs-12 col-sm-9">
                                 <?php if($userdata->stripe_account_info == "") { ?>
                                    <?= $form->field($model, 'lastname')->textInput(['class' => 'form-control','name'=>'Stripe[lastname]','placeholder'=>'Last Name','maxlength'=>'30','value'=>''.$lastname.'','onkeypress'=>'return isAlpha(event)'])->label(false) ?>
                                 <?php } else { ?>
                                    <?= $form->field($model, 'lastname')->textInput(['class' => 'form-control','name'=>'Stripe[lastname]','placeholder'=>'Last Name','maxlength'=>'30','value'=>''.base64_decode($this->context->dataReturn('lastname','IN')).'','onkeypress'=>'return isAlpha(event)'])->label(false) ?>
                                 <?php } ?>
                              </div>
                           </div> <!--col-xs-12 end -->  

                           <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                              <div class="col-xs-12 col-sm-3 ">
                                 <label class="profile_label">
                                    <?php echo Yii::t('app','Birth Date');?> 
                                    <i class="fa fa-lock profile_icon" data-toggle="tooltip" data-placement="top" title="Private"></i> 
                                 </label> 
                              </div>
                              <div class="airfcfx-profile-bd field-signupform-dob col-xs-12 col-sm-9">
                                 <?php if($userdata->stripe_account_info == "") { ?>
                                    <?php
                                       $birthdate = $userdata['birthday'];
                                       if(isset($birthdate) && $birthdate!="") {
                                          $birthdate = explode("-",$birthdate);
                                       } else {
                                          $birthdate[0] = '0';
                                          $birthdate[1] = '0';
                                          $birthdate[2] = '0';
                                       }
                                    ?>
                                    <select id="signupform-month" class="form-control col-sm-4" style="width:70px; text-align: center; padding: 0px !important;" name="Stripe[month]">
                                       <?php
                                          if($birthdate[0] == "0")
                                          {
                                             echo '<option value="">Month</option>';
                                             for($m=1; $m<=12; $m++) {
                                                echo '<option value="'.$m.'">'.$m.'</option>';
                                             }                    
                                          } else {
                                             for($m=1; $m<=12; $m++) {  
                                                if($birthdate[0] == $m) {
                                                   echo '<option value="'.$m.'" selected>'.$m.'</option>';
                                                } else {
                                                   echo '<option value="'.$m.'">'.$m.'</option>';
                                                }
                                             }
                                          }
                                       ?>
                                    </select>
                                    
                                    <select id="signupform-day" class="form-control col-sm-4 margin_left10" style="width:60px; text-align: center; padding: 0px !important;" name="Stripe[day]">
                                       <?php
                                          if($birthdate[1] == "0") {
                                             echo '<option value="">Day</option>';
                                             for($d=1;$d<=31;$d++) {
                                                echo '<option value="'.$d.'">'.$d.'</option>';
                                             }
                                          } else {
                                             for($d=1; $d<=31; $d++) {
                                                if($birthdate[1] == $d) {
                                                   echo '<option value="'.$d.'" selected>'.$d.'</option>';
                                                } else {
                                                   echo '<option value="'.$d.'">'.$d.'</option>';
                                                }
                                             }
                                          }
                                       ?>
                                    </select>
                                    <select id="signupform-year" class="form-control col-sm-4 margin_left10" style="width:70px; text-align: center; padding: 0px !important;" name="Stripe[year]">
                                       <?php
                                          if($birthdate[2] == "0") {
                                             echo '<option value="">Year</option>';
                                             for($i=2013; $i>1900; $i--) {
                                                echo '<option value="'.$i.'"  >'.$i.'</option>';
                                             }
                                          } else {
                                             for($i=date('Y'); $i>=1900; $i--) {
                                                if($birthdate[2] == $i) { 
                                                   echo '<option value="'.$i.'"  selected>'.$i.'</option>';
                                                } else {                 
                                                   echo '<option value="'.$i.'"  >'.$i.'</option>';
                                                }
                                             }
                                          }
                                       ?>
                                    </select>
                                 <?php } else { ?>
                                    <select id="signupform-month" class="form-control col-sm-4" style="width:70px; text-align: center; padding: 0px !important;" name="Stripe[month]">
                                       <?php echo '<option value="'.base64_decode($this->context->dataReturn('birth_month','IN')).'" selected>'.base64_decode($this->context->dataReturn('birth_month','IN')).'</option>';?>
                                    </select>
                                    <select id="signupform-day" class="form-control col-sm-4 margin_left10" style="width:60px; text-align: center; padding: 0px !important;" name="Stripe[day]">
                                       <?php echo '<option value="'.base64_decode($this->context->dataReturn('birth_day','IN')).'" selected>'.base64_decode($this->context->dataReturn('birth_day','IN')).'</option>';?>
                                    </select>
                                    <select id="signupform-year" class="form-control col-sm-4 margin_left10" style="width:70px; text-align: center; padding: 0px !important;" name="Stripe[year]">
                                       <?php echo '<option value="'.base64_decode($this->context->dataReturn('birth_year','IN')).'" selected>'.base64_decode($this->context->dataReturn('birth_year','IN')).'</option>';?>
                                    </select>
                                 <?php } ?>
                                 <p class="help-block help-block-error"></p>
                              </div>
                           </div> <!--col-xs-12 end -->

                           <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                              <div class="col-xs-12 col-sm-3 ">
                                 <label class="profile_label">
                                    <?php echo Yii::t('app','Account Type');?>
                                 </label> 
                              </div>
                              <div class="col-xs-12 col-sm-9">
                                 <label class="profile_label label_account_type">
                                    <?php echo Yii::t('app','Individual');?>
                                 </label> 
                              </div>
                           </div>

                           <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                              <div class="col-xs-12 col-sm-3 ">
                                 <label class="profile_label">
                                    <?php echo Yii::t('app','Email');?>
                                 </label> 
                              </div>
                              <div class="col-xs-12 col-sm-9">
                                 <label class="profile_label label_account_type">
                                    <?php echo $userdata['email'];?>
                                 </label> 
                              </div>
                           </div>

                           <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                              <div class="col-xs-12 col-sm-3 ">
                                 <label class="profile_label">
                                    <?php echo Yii::t('app','Phone Number');?>
                                 </label> 
                              </div>
                              <div class="col-xs-12 col-sm-9">
                                 <?php if($userdata->stripe_account_info == "") { ?>
                                    <?= $form->field($model, 'phonenumber')->textInput(['class' => 'form-control','name'=>'Stripe[phonenumber]','placeholder'=>'','maxlength'=>'15','value'=>''.$stripe_phonenumber.''])->label(false) ?>
                                 <?php } else { ?>
                                    <?= $form->field($model, 'phonenumber')->textInput(['class' => 'form-control','name'=>'Stripe[phonenumber]','placeholder'=>'','maxlength'=>'15','value'=>''.base64_decode($this->context->dataReturn('phonenumber','IN')).''])->label(false) ?>
                                 <?php } ?>
                                  <p class="margin_top_5 text_green">
                                    <?php echo Yii::t('app','Please mention the contact number according to Host Country')." - ".$cntry[2].", ".Yii::t('app','Without country code.');?>
                                 </p>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               </div>

               <?php 
               if($cntry[0] != "AT") {
               ?>
                  <div class="col-xs-12 col-sm-12">        
                     <div class="airfcfx-panel panel panel-default">
                        <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
                           <h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','Host Address');?></h3>
                        </div>

                        <div class="airfcfx-panel-padding panel-body">
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                                 <p class="margin_top_5 text_red">
                                    <?php echo Yii::t('app','Please mention the address according to Host Country')." - ".$cntry[2].". ".Yii::t('app','If not Stripe Address Verification may Fail.');?>
                                 </p>
                              </div>

                              <?php 
                              if(!in_array($cntry[0],$excludeLineBasis)) {
                              ?>
                                 <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                                    <div class="col-xs-12 col-sm-3 ">
                                       <label class="profile_label">
                                          <?php echo Yii::t('app','Street / Line 1');?>
                                       </label> 
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                       <?php if($userdata->stripe_account_info == "") { ?>
                                          <?= $form->field($model, 'line')->textInput(['class' => 'form-control','name'=>'Stripe[line]','placeholder'=>'','maxlength'=>'100','value'=>''.$stripe_line.''])->label(false) ?>
                                       <?php } else { ?>
                                          <?= $form->field($model, 'line')->textInput(['class' => 'form-control','name'=>'Stripe[line]','placeholder'=>'','maxlength'=>'100','value'=>''.base64_decode($this->context->dataReturn('line1','IN')).''])->label(false) ?>
                                       <?php } ?>
                                    </div>
                                 </div>

                                 <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                                    <div class="col-xs-12 col-sm-3 ">
                                       <label class="profile_label">
                                          <?php echo Yii::t('app','Line 2');?>
                                       </label> 
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                       <?php if($userdata->stripe_account_info == "") { ?>
                                          <?= $form->field($model, 'lineoptional')->textInput(['class' => 'form-control','name'=>'Stripe[lineoptional]','placeholder'=>'(Optional)','maxlength'=>'50','value'=>''.$stripe_lineoptional.''])->label(false) ?>
                                       <?php } else { ?>
                                          <?= $form->field($model, 'lineoptional')->textInput(['class' => 'form-control','name'=>'Stripe[lineoptional]','placeholder'=>'(Optional)','maxlength'=>'50','value'=>''.base64_decode($this->context->dataReturn('line2','IN')).''])->label(false) ?>
                                       <?php } ?>
                                    </div>
                                 </div>
                              <?php } ?>

                              <?php 
                              if(!in_array($cntry[0],$excludeCityBasis)) {
                              ?>
                                 <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                                    <div class="col-xs-12 col-sm-3 ">
                                       <label class="profile_label">
                                          <?php echo Yii::t('app','City');?>
                                       </label> 
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                       <?php if($userdata->stripe_account_info == "") { ?>
                                          <?= $form->field($model, 'city')->textInput(['class' => 'form-control','name'=>'Stripe[city]','placeholder'=>'','maxlength'=>'50','value'=>''.$stripe_city.''])->label(false) ?>
                                       <?php } else { ?>
                                          <?= $form->field($model, 'city')->textInput(['class' => 'form-control','name'=>'Stripe[city]','placeholder'=>'','maxlength'=>'50','value'=>''.base64_decode($this->context->dataReturn('city','IN')).''])->label(false) ?>
                                       <?php } ?>
                                    </div>
                                 </div>
                              <?php } ?>

                              <?php 
                              if(in_array($cntry[0],$includeStateBasis)) { 
                              ?>
                                 <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                                    <div class="col-xs-12 col-sm-3 ">
                                       <label class="profile_label">
                                          <?php echo Yii::t('app','State');?>
                                       </label> 
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                       <?php 
                                          $maxlength = 50;
                                          if($cntry[0] == "CA") {
                                             $maxlength = 2;
                                          }
                                       ?>
                                       <?php if($userdata->stripe_account_info == "") { ?>
                                          <?= $form->field($model, 'state')->textInput(['class' => 'form-control','name'=>'Stripe[state]','placeholder'=>'','maxlength'=>''.$maxlength.'','value'=>''.$stripe_state.''])->label(false) ?>
                                       <?php } else { ?>
                                          <?= $form->field($model, 'state')->textInput(['class' => 'form-control','name'=>'Stripe[state]','placeholder'=>'','maxlength'=>''.$maxlength.'','value'=>''.base64_decode($this->context->dataReturn('state','IN')).''])->label(false) ?>
                                       <?php } ?>
                                       <label class="profile_label label_account_type">
                                          <?php if($cntry[0] == "CA") { ?>
                                            Note : Please use Province / State code (Capital) for Canada Country. <br><br>
                                            'AB' - Alberta, 'BC' - British Columbia, 'MB' - Manitoba, 'NB' - New Brunswick, 'NL' - Newfoundland and Labrador, 'NS' - Nova Scotia, 'NT' - Northwest Territories, 'NU' - Nunavut, 'ON' - Ontario, 'PE' - Prince Edward Island, 'QC' - Quebec, 'SK' - Saskatchewan, 'YT' - Yukon.
                                          <?php } ?>
                                       </label>
                                    </div>

                                 </div>
                              <?php } ?>

                              <?php 
                              if(!in_array($cntry[0],$excludeCodeBasis)) {
                              ?>
                                 <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                                    <div class="col-xs-12 col-sm-3 ">
                                       <label class="profile_label">
                                          <?php echo Yii::t('app','Postal Code');?>
                                       </label> 
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                       <?php if($userdata->stripe_account_info == "") { ?>
                                          <?= $form->field($model, 'postalcode')->textInput(['class' => 'form-control','name'=>'Stripe[postalcode]','placeholder'=>'','maxlength'=>'15','value'=>''.$stripe_postalcode.''])->label(false) ?>
                                       <?php } else { ?>
                                          <?= $form->field($model, 'postalcode')->textInput(['class' => 'form-control','name'=>'Stripe[postalcode]','placeholder'=>'','maxlength'=>'15','value'=>''.base64_decode($this->context->dataReturn('postalcode','IN')).''])->label(false) ?>  
                                       <?php } ?> 
                                    </div>
                                 </div>
                              <?php } ?>

                              <div class="col-xs-12 col-sm-12 margin_top10 margin_bottom10">
                                 <div class="col-xs-12 col-sm-3 ">
                                    <label class="profile_label">
                                       <?php echo Yii::t('app','Country');?>
                                    </label> 
                                 </div>
                                 <div class="col-xs-12 col-sm-9">
                                    <label class="profile_label label_account_type">
                                       <?php echo  $cntry[2]; ?>
                                    </label>
                                 </div>
                              </div>

                           </div> <!--row end -->
                        </div>
                     </div> <!--Panel end -->
                  </div>
               <?php } ?>
            <?php } else { ?>
               <!-- japan code -->
            <?php } ?>

            <?php 
               if($formEntry == 0) { 
            ?>
               <div class="col-xs-12 col-sm-12">
                  <div class="form-group">
                     <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'pull-right airfcfx-panel btn btn_email margin_bottom20','onclick' => 'return actionStripe();']) ?>
                  </div>
               </div>
            <?php } ?>
            

         <?php ActiveForm::end(); ?>
      </div>

   </div> <!--container end -->
</div>

<script type="text/javascript">
   function actionStripe() {
      var cCode = '<?php echo $cntry[0]; ?>';
      var accountnumber = $.trim($('#signupform-accountnumber').val());
      var routingnumber = $.trim($('#signupform-routingnumber').val());
      var personalidnumber = $.trim($('#signupform-personalidnumber').val());
      var ssn = $.trim($('#signupform-ssn').val());
      var firstname = $.trim($('#signupform-firstname').val());
      var lastname = $.trim($('#signupform-lastname').val());
      var month = $.trim($('#signupform-month').val());
      var day = $.trim($('#signupform-day').val());
      var year = $.trim($('#signupform-year').val());
      var phonenumber = $.trim($('#signupform-phonenumber').val());
      var line = $.trim($('#signupform-line').val());
      var city = $.trim($('#signupform-city').val());
      var state = $.trim($('#signupform-state').val());
      var postalcode = $.trim($('#signupform-postalcode').val()); 
      var cFlag = 0;
      var dob = new Date(year+'-'+month+'-'+day);
      var today = new Date();
      var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
      
      <?php
         if(!in_array($cntry[1],$europeanCurrencies)) {
      ?>
         if(accountnumber=="") {
            $(".field-signupform-accountnumber").addClass("has-error");
            $("#signupform-accountnumber").next(".help-block-error").html("Account Number cannot be blank.");
            $("#signupform-accountnumber").keydown(function(){
               $(".field-signupform-accountnumber").removeClass("has-error");
               $("#signupform-accountnumber").next(".help-block-error").html("");
            });
            cFlag = 1;
         } else if(routingnumber=="") {
            $(".field-signupform-routingnumber").addClass("has-error");
            $("#signupform-routingnumber").next(".help-block-error").html("Routing Number cannot be blank.");
            $("#signupform-routingnumber").keydown(function(){
               $(".field-signupform-routingnumber").removeClass("has-error");
               $("#signupform-routingnumber").next(".help-block-error").html("");
            });
            cFlag = 1;
         }
      <?php } else { ?>
         if(accountnumber=="") {
            $(".field-signupform-accountnumber").addClass("has-error");
            $("#signupform-accountnumber").next(".help-block-error").html("IBAN Number cannot be blank.");
            $("#signupform-accountnumber").keydown(function(){
               $(".field-signupform-accountnumber").removeClass("has-error");
               $("#signupform-accountnumber").next(".help-block-error").html("");
            });
            cFlag = 1;
         }
      <?php }?>

      <?php 
         if(in_array($cntry[0],$includePersonalIdBasis)) {
      ?>
         if(personalidnumber=="" && cFlag == 0) {
            $(".field-signupform-personalidnumber").addClass("has-error");
            $("#signupform-personalidnumber").next(".help-block-error").html("Personal ID Number cannot be blank.");
            $("#signupform-personalidnumber").keydown(function(){
               $(".field-signupform-personalidnumber").removeClass("has-error");
               $("#signupform-personalidnumber").next(".help-block-error").html("");
            });
            cFlag = 1;
         }
      <?php } ?>

       <?php 
         if($cntry[0] == "US") {
      ?>
         if(ssn=="" && cFlag == 0) {
            $(".field-signupform-ssn").addClass("has-error");
            $("#signupform-ssn").next(".help-block-error").html("SSN Number cannot be blank.");
            $("#signupform-ssn").keydown(function(){
               $(".field-signupform-ssn").removeClass("has-error");
               $("#signupform-ssn").next(".help-block-error").html("");
            });
            cFlag = 1;
         }

         if(ssn.length!=4 && cFlag == 0) {
            $(".field-signupform-ssn").addClass("has-error");
            $("#signupform-ssn").next(".help-block-error").html("SSN Number should be the last four digit only.");
            $("#signupform-ssn").keydown(function(){
               $(".field-signupform-ssn").removeClass("has-error");
               $("#signupform-ssn").next(".help-block-error").html("");
            });
            cFlag = 1;
         }
      <?php } ?>

      if(firstname=="" && cFlag == 0) {
         $(".field-signupform-firstname").addClass("has-error");
         $("#signupform-firstname").next(".help-block-error").html("First name cannot be blank.");
         $("#signupform-firstname").keydown(function(){
            $(".field-signupform-firstname").removeClass("has-error");
            $("#signupform-firstname").next(".help-block-error").html("");
         });
         cFlag = 1;
      } else if(firstname.length < 3) {
         $(".field-signupform-firstname").addClass("has-error");
         $("#signupform-firstname").next(".help-block-error").html("First name should have minimum 3 characters.");
         $("#signupform-firstname").keydown(function(){
            $(".field-signupform-firstname").removeClass("has-error");
            $("#signupform-firstname").next(".help-block-error").html("");
         });
         cFlag = 1;
      }

      if(lastname=="" && cFlag == 0) {
         $(".field-signupform-lastname").addClass("has-error");
         $("#signupform-lastname").next(".help-block-error").html("Last name cannot be blank.");
         $("#signupform-lastname").keydown(function(){
            $(".field-signupform-lastname").removeClass("has-error");
            $("#signupform-lastname").next(".help-block-error").html("");
         });
         cFlag = 1;
      } else if(lastname.length < 3) {
         $(".field-signupform-lastname").addClass("has-error");
         $("#signupform-lastname").next(".help-block-error").html("Last name should have minimum 3 characters.");
         $("#signupform-lastname").keydown(function(){
            $(".field-signupform-lastname").removeClass("has-error");
            $("#signupform-lastname").next(".help-block-error").html("");
         });
         cFlag = 1;
      }
      

      if((month=="" || month==0) && cFlag == 0) {
         $(".field-signupform-dob").addClass("has-error");
         $(".field-signupform-dob > .help-block-error").html("Select the month of your birth.");
         $("#signupform-month").click(function(){
            $(".field-signupform-dob").removeClass("has-error");
            $(".field-signupform-dob > .help-block-error").html("");
         });
         cFlag = 1;
      }

      if((day=="" || day==0) && cFlag == 0) {
         $(".field-signupform-dob").addClass("has-error");
         $(".field-signupform-dob > .help-block-error").html("Select the day of your birth.");
         $("#signupform-day").click(function(){
            $(".field-signupform-dob").removeClass("has-error");
            $(".field-signupform-dob > .help-block-error").html("");
         });
         cFlag = 1;
      }
       
      if((year=="" || year<1900) && cFlag == 0) {
         $(".field-signupform-dob").addClass("has-error");
         $(".field-signupform-dob > .help-block-error").html("Select the year of your birth.");
         $("#signupform-year").click(function(){
            $(".field-signupform-dob").removeClass("has-error");
            $(".field-signupform-dob > .help-block-error").html("");
         });
         cFlag = 1;
      }

      if(age<=13) {
         $(".field-signupform-dob").addClass("has-error");
         $(".field-signupform-dob > .help-block-error").html("Stripe allows only age after 13");
         $("#signupform-year, #signupform-month, #signupform-day").click(function(){
            $(".field-signupform-dob").removeClass("has-error");
            $(".field-signupform-dob > .help-block-error").html("");
         });
         cFlag = 1;
      }

      if(phonenumber=="" && cFlag == 0) {
         $(".field-signupform-phonenumber").addClass("has-error");
         $("#signupform-phonenumber").next(".help-block-error").html("Phone number cannot be blank.");
         $("#signupform-phonenumber").keydown(function(){
            $(".field-signupform-phonenumber").removeClass("has-error");
            $("#signupform-phonenumber").next(".help-block-error").html("");
         });
         cFlag = 1;
      }

      <?php 
         if(!in_array($cntry[0],$excludeLineBasis)) {
      ?>
         if(line=="" && cFlag == 0) {
            $(".field-signupform-line").addClass("has-error");
            $("#signupform-line").next(".help-block-error").html("Line cannot be blank.");
            $("#signupform-line").keydown(function(){
               $(".field-signupform-line").removeClass("has-error");
               $("#signupform-line").next(".help-block-error").html("");
            });
            cFlag = 1;
         }
      <?php } ?>

      <?php 
         if(!in_array($cntry[0],$excludeCityBasis)) {
      ?>
         if(city=="" && cFlag == 0) {
            $(".field-signupform-city").addClass("has-error");
            $("#signupform-city").next(".help-block-error").html("City cannot be blank.");
            $("#signupform-city").keydown(function(){
               $(".field-signupform-city").removeClass("has-error");
               $("#signupform-city").next(".help-block-error").html("");
            });
            cFlag = 1;
         }
      <?php } ?>

      <?php 
         if(in_array($cntry[0],$includeStateBasis)) {
      ?>
         if(state=="" && cFlag == 0) {
            $(".field-signupform-state").addClass("has-error");
            $("#signupform-state").next(".help-block-error").html("State cannot be blank.");
            $("#signupform-state").keydown(function(){
               $(".field-signupform-state").removeClass("has-error");
               $("#signupform-state").next(".help-block-error").html("");
            });
            cFlag = 1;
         }

         <?php if($cntry[0] == "CA") { ?>
            var canadaCode = ['AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT'];
            var k = canadaCode.includes(state);
            if(k == false) {
               $(".field-signupform-state").addClass("has-error");
               $("#signupform-state").next(".help-block-error").html("Province Code is inCorrect");
               $("#signupform-state").keydown(function(){
                  $(".field-signupform-state").removeClass("has-error");
                  $("#signupform-state").next(".help-block-error").html("");
               });
               cFlag = 1;
            }
         <?php } ?>
      <?php } ?>

      <?php 
         if(!in_array($cntry[0],$excludeCodeBasis)) {
      ?>
         if(postalcode=="" && cFlag == 0) {
            $(".field-signupform-postalcode").addClass("has-error");
            $("#signupform-postalcode").next(".help-block-error").html("Postal code cannot be blank.");
            $("#signupform-postalcode").keydown(function(){
               $(".field-signupform-postalcode").removeClass("has-error");
               $("#signupform-postalcode").next(".help-block-error").html("");
            });
            cFlag = 1;
         }
      <?php } ?>

      if(cFlag == 1)
         return false;
   }
</script>

<script>
   $(document).on('change', '#stripeHostCountry', function(e) {
      stripeHostCountry = $("#stripeHostCountry").val();
      window.location = baseurl+"/paysettings/"+btoa(stripeHostCountry);
   });

   /*$(document).ready(function(){    

   });*/
</script>  

<style type="text/css">
   .stripeHostCountry {
      padding: 0px 30px 0px 10px !important;
   }

   .label_account_type {
      color: green !important;
      font-weight: 500 !important;
   }

   .text_red {
      color: red !important;
      font-size: 13px;
      text-align: center;
   }

   .text_redonly {
      color: red !important;
   }

   .text_green {
      color: green !important;
      font-size: 13px;
   }

   .form-control::placeholder, .form-control::-moz-placeholder {
      color: #cccccc !important;
   }
   
   .no-ver-padding {
      padding-top: 0px !important;
      padding-bottom: 0px !important; 
   }


   /*.label_color_fade {
      color:#ccc !important;
   }*/

</style>

