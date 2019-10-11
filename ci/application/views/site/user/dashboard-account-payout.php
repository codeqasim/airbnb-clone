<?php 
$this->load->view('site/templates/header');
?>
<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-1.5.1.min"></script>
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery.colorbox.js"></script>
<script type="text/javascript">
$(document).ready(function(){
			$(".paypal-popup").colorbox({width:"365px", height:"500px", inline:true, href:"#dddddinline_paypal"}); $("#accno").keydown(function (event) {        if (!(event.keyCode == 8                                           || event.keyCode == 9                                          || event.keyCode == 17                                          || event.keyCode == 46                                          || (event.keyCode >= 35 && event.keyCode <= 40)                 || (event.keyCode >= 48 && event.keyCode <= 57)                 || (event.keyCode >= 96 && event.keyCode <= 105)                || (event.keyCode == 65 && prevKey == 17 && prevControl == event.currentTarget.id))             ) {            event.preventDefault();            }           });
});
</script>
<div style='display:none'>

<div id='dddddinline_paypal' style='background:#fff;'>
  
  		<div class="popup_page" >
        <img src="<?php echo base_url().'images/site/paypal.png' ?>"  style="margin-top:20px;">
        
       
       <table>
        <tr><td><label> Full Name</label></td></tr>
        <tr><td><input type="text" name="bank_name" id="bank_name" value="<?php echo $userpay->row()->bank_name; ?>" /></td></tr> 
        <tr><td><label> Account Number</label></td></tr>
        <tr><td><input type="text" name="bank_no" id="bank_no" value="<?php echo $userpay->row()->bank_no; ?>" /></td></tr> 
        <tr><td><label> Bank Code</label></td></tr>
        <tr><td><input type="text" name="bank_code" id="bank_code" value="<?php echo $userpay->row()->bank_code; ?>" /></td></tr>
        <tr><td><label> Paypal Email</label></td></tr>
        <tr><td><input type="text" name="paypal_email" id="paypal_email" value="<?php echo $userpay->row()->paypal_email; ?>" /></td></tr>
        <tr><td>
        <button class="btn btn-block btn-primary large btn-large padded-btn-block" type="submit" onclick="javascript:paypaldetail();" >Submit</button>
        
        </td></tr>
       </table>
       
       
        </div>
        
  </div>
  
</div>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor account acc-payout">

  <div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></li>
                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li class="active"><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul> </div></div>
  <div class="main">
      <div id="command_center">
    
              <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></li>
                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li class="active"><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul>  
           <ul class="subnav">
                <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Notifications') != '') { echo stripslashes($this->lang->line('Notifications')); } else echo "Notifications";?></a></li>
                 <li  class="active"><a href="<?php echo base_url();?>account-payout"><?php if($this->lang->line('PayoutPreferences') != '') { echo stripslashes($this->lang->line('PayoutPreferences')); } else echo "Payout Preferences";?></a></li>
                <li><a href="<?php echo base_url();?>account-trans"><?php if($this->lang->line('TransactionHistory') != '') { echo stripslashes($this->lang->line('TransactionHistory')); } else echo "Transaction History";?></a></li>
                <!-- <li><a href="<?php echo base_url();?>referrals">Referrals</a></li>-->
                <li><a href="<?php echo base_url();?>account-privacy"><?php if($this->lang->line('Privacy') != '') { echo stripslashes($this->lang->line('Privacy')); } else echo "Privacy";?></a></li>
                <li><a href="<?php echo base_url();?>account-security"><?php if($this->lang->line('Security') != '') { echo stripslashes($this->lang->line('Security')); } else echo "Security";?></a></li>
                <li><a href="<?php echo base_url();?>account-setting"><?php if($this->lang->line('Settings') != '') { echo stripslashes($this->lang->line('Settings')); } else echo "Settings";?></a></li>            
            

            <a class="invitefrds" href="#" style="display:none"><?php if($this->lang->line('InviteFriendspage') != '') { echo stripslashes($this->lang->line('InviteFriendspage')); } else echo "Invite Friends page";?></a>

            
          </ul>
            	<div id="account">
    <div class="box">
      <div class="middle">

        <div id="payout_setup">
          
            <h2><?php if($this->lang->line('PayoutMethods') != '') { echo stripslashes($this->lang->line('PayoutMethods')); } else echo "Payout Methods";?></h2>
            
              <a data-toggle="modal" href="#myModal" class="btn btn paypal-popup2 cboxElement2" href="#">
			  <?php if($userpay->row()->accname == ''){ ?>
			  <?php if($this->lang->line('add_payout_method') != '') { echo stripslashes($this->lang->line('add_payout_method')); } else echo "Add Payout Method";?>
			  <?php }else{ ?> 
			   <?php if($this->lang->line('view_payout_method') != '') { echo stripslashes($this->lang->line('view_payout_method')); } else echo "View Payout Method";?>
			  <?php } ?></a>
          
        </div>
        <div id="taxes"></div>
        </div>
      </div> 
    </div>
         
  </div>
    </div>
</div>











<div id="myModal" class="modal fade in payoutprefer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
 
                <div class="modal-header">
                    <a class="" data-dismiss="modal"><span class="">X</span></a>
                    <h4 class="modal-title" id="myModalLabel"><?php if($this->lang->line('AddPayoutDetails') != '') { echo stripslashes($this->lang->line('AddPayoutDetails')); } else echo "Add Payout Details";?></h4>
                </div>
				<form action="<?php echo base_url(); ?>site/user/account_update" method="post">
				
				<input type="hidden" name="hid" id="hid" value="<?php echo $userpay->row()->id;?>" />
                <div class="modal-body">
                   <table>
                  <tbody>
                  <tr>
                  <td>
                  <label><?php if($this->lang->line('AccountName') != '') { echo stripslashes($this->lang->line('AccountName')); } else echo "Account Name";?>*</label>
                  </td>
                  </tr>
                  <tr>
                  <td>
                  <input id="accname" type="text" value="<?php echo $userpay->row()->accname;?>" name="accname">
                  </td>
                  </tr>
                  <tr>
                  <td>
                  <label><?php if($this->lang->line('AccountNumber') != '') { echo stripslashes($this->lang->line('AccountNumber')); } else echo "Account Number";?>*</label>
                  </td>
                  </tr>
                  <tr>
                  <td>
                  <input id="accno" type="text" value="<?php echo $userpay->row()->accno;?>" name="accno">
                  </td>
                  </tr>
                  <tr>
                  <td>
                  <label><?php if($this->lang->line('BankName') != '') { echo stripslashes($this->lang->line('BankName')); } else echo "Bank Name";?>*</label>
                  </td>
                  </tr>
                  <tr>
                  <td>
                  <input id="bankname" type="text" name="bankname" value="<?php echo $userpay->row()->bankname;?>" style="width: 40%;">
                  </td>
                  </tr>
				  
				  
				  
				  
				   <tr>
                  <td>
                  <button style=" margin: 10px 0 0;"  class="btn btn-block btn-primary large btn-large padded-btn-block"  type="submit"><?php if($this->lang->line('Submit') != '') { echo stripslashes($this->lang->line('Submit')); } else echo "Submit";?></button>
                  </td>
                  </tr>
                  </tbody>
                  </table>
                </div>
                </form>
                </div>
 
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dalog -->
</div><!-- /.modal -->
    

<!---DASHBOARD-->
<!---FOOTER-->
<?php 
$this->load->view('site/templates/footer');
?>