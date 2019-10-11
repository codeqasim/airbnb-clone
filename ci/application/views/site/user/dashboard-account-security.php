<?php 
$this->load->view('site/templates/header');
?>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor account acc-security">

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
                 <li><a href="<?php echo base_url();?>account-payout"><?php if($this->lang->line('PayoutPreferences') != '') { echo stripslashes($this->lang->line('PayoutPreferences')); } else echo "Payout Preferences";?></a></li>
                <li><a href="<?php echo base_url();?>account-trans"><?php if($this->lang->line('TransactionHistory') != '') { echo stripslashes($this->lang->line('TransactionHistory')); } else echo "Transaction History";?></a></li>
                <!-- <li><a href="<?php echo base_url();?>referrals">Referrals</a></li>-->
                <li><a href="<?php echo base_url();?>account-privacy"><?php if($this->lang->line('Privacy') != '') { echo stripslashes($this->lang->line('Privacy')); } else echo "Privacy";?></a></li>
                <li class="active"><a href="<?php echo base_url();?>account-security"><?php if($this->lang->line('Security') != '') { echo stripslashes($this->lang->line('Security')); } else echo "Security";?></a></li>
                <li><a href="<?php echo base_url();?>account-setting"><?php if($this->lang->line('Settings') != '') { echo stripslashes($this->lang->line('Settings')); } else echo "Settings";?></a></li>            
            

            <a class="invitefrds" href="#" style="display:none"><?php if($this->lang->line('InviteFriendspage') != '') { echo stripslashes($this->lang->line('InviteFriendspage')); } else echo "Invite Friends page";?></a>

            
          </ul>
            	<div id="account">
    <div class="box">
      <div class="middle">
        <form method="post" action="site/user/change_password1" accept-charset="UTF-8" id="changePassword1"><div style="margin:0;padding:0;display:inline"></div>
          <h2><?php if($this->lang->line('ChangeYourPassword') != '') { echo stripslashes($this->lang->line('ChangeYourPassword')); } else echo "Change Your Password";?></h2>
          <div class="section notification_section">
            <div class="notification_area">
            
              <div class="notification_action">


                <input type="hidden" value="<?php echo $userDetails->row()->email;?>" name="id" id="id">
               
                <table class="password-fields">
                    <tbody><tr><td width=200><?php if($this->lang->line('OldPassword') != '') { echo stripslashes($this->lang->line('OldPassword')); } else echo "Old Password";?>:<span style="color:#FF0000">*</span></td><td><input type="password" style="width:150px;margin:3px;" name="old_password" id="old_password">
                    <div id="old_password_warn"  style="float:right;margin-left:5px; color:#FF0000;"></div></td></tr>
                  <tr><td><?php if($this->lang->line('NewPassword') != '') { echo stripslashes($this->lang->line('NewPassword')); } else echo "New Password";?>:<span style="color:#FF0000">*</span></td><td><input type="password" style="width:150px;margin:3px;" size="30" name="new_password" id="new_password">
                   <div id="new_password_warn"  style="float:right;margin-left:5px; color:#FF0000;"></div></td></tr>
                  <tr><td><?php if($this->lang->line('change_conf_pwd') != '') { echo stripslashes($this->lang->line('change_conf_pwd')); } else echo "Confirm Password";?>:<span style="color:#FF0000">*</span></td><td><input type="password" style="width:150px;margin:3px;" size="30" name="confirm_password" id="confirm_password">
                   <div id="confirm_password_warn"  style="float:right;margin-left:5px; color:#FF0000;"></div></td></tr>
                </tbody></table>
              </div>
            </div>
            <div class="buttons">
              <input type="submit" value="<?php if($this->lang->line('UpdatePassword') != '') { echo stripslashes($this->lang->line('UpdatePassword')); } else echo "Update Password";?>" onclick="return ChangePassword();" name="commit" class="updatepaswd">
            </div>
          </div>
</form>
        <!--<h2>Cancel Account</h2>
        <div id="cancel_account" class="section notification_section">
          <div class="notification_area">
            <div style="clear: both;"></div>
            <p class="cancel_link"><a onclick="jQuery('#account_canceler').show(); jQuery('.cancel_link').hide(); return false;" href="#">Cancel my account</a></p>
            <div style="clear: both;"></div>
            <div style="display: none;" id="account_canceler">
              <form method="post" action="site/user/cancel_account" accept-charset="UTF-8"><div style="margin:0;padding:0;display:inline"></div>
              <div id="canceling_explanation" class="fanged_panel">
                <div class="header">
                  <h3>Tell us why you're leaving</h3>
                </div>
                <div class="body">
                  <ul class="no-disc">
                    <li class="clearfix"><input type="radio" value="safety_concerns" name="reason" id="reason_safety_concerns"> <label for="reason_safety_concerns">I have safety concerns.</label> </li>
                    <li class="clearfix"><input type="radio" value="privacy_concerns" name="reason" id="reason_privacy_concerns"> <label for="reason_privacy_concerns">I have privacy concerns.</label> </li>
                    <li class="clearfix"><input type="radio" value="not_useful" name="reason" id="reason_not_useful"> <label for="reason_not_useful">I don't find it useful.</label> </li>
                    <li class="clearfix"><input type="radio" value="dont_understand_how_to_use" name="reason" id="reason_dont_understand_how_to_use"> <label for="reason_dont_understand_how_to_use">I don't understand how to use it.</label> </li>
                    <li class="clearfix"><input type="radio" value="temporary" name="reason" id="reason_temporary"> <label for="reason_temporary">It's temporary; I'll be back.</label> </li>
                    <li class="clearfix"><input type="radio" value="other" name="reason" id="reason_other"> <label for="reason_other">Other</label> </li>
                  </ul>

                  <p class="tell_more">Care to tell us more?</p>
                  <textarea name="details" id="details"></textarea>

                  <h6>Can we contact you for more details?</h6>
                  <input type="radio" value="yes" name="contact_ok" id="contact_ok_yes"> <label for="reason_yes">Yes</label>
                  <input type="radio" value="no" name="contact_ok" id="contact_ok_no"> <label for="reason_no">No</label>

                  <h6>What's going to happen</h6>
                  <ul>
                    <li>Your profile and any listings will disappear.</li>
                    <li>We'll remove you from any groups you're in.</li>
                    <li><strong>We'll miss you terribly.</strong></li>
                  </ul>
				  <input type="hidden" value="<?php echo $userDetails->row()->email; ?>" name="email" />
                  <input type="hidden" value="<?php echo $userDetails->row()->id; ?>" name="id" />
                  <input type="submit" value="Cancel my account" id="make_the_call" class="btn red"> or <a onclick="jQuery('#account_canceler').hide(); jQuery('.cancel_link').show(); return false;" href="#">Don't cancel account</a>
                </div>
              </div>
</form>
              <div id="canceling_alternatives" class="fanged_panel">
                <div class="header">
                  <h3>Alternatives to canceling</h3>
                </div>
                <div class="body">
                  <h5>
                    <a href="<?php echo base_url().'account-privacy';?>">Adjust my privacy settings</a>
                  </h5>
                  <p class="alternative_explanation">
                    Turn off search indexing on your listing, preventing search engines such as Google and Bing from displaying your listing in their search results.
                  </p>
                  <h5>
                    <a href="<?php echo base_url().'account';?>">Change notification preferences</a>
                  </h5>
                  <p class="alternative_explanation">
                    Are we sending you too much email? Change your notification preferences.
                  </p>
                  <h5>
                    <a href="<?php echo base_url().'listing/all';?>">Hide my listings</a>
                  </h5>
                  <p class="alternative_explanation">
                    Remove your listings from being viewed or found in search to stop hosting on .
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>-->

        <div class="clearfix"></div>
      </div>
    </div>
  </div>
         
  </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
			$("#changePassword").submit(function(){
				// var email = $('#vendor_email').val();
				//alert('');
			
				 $("#old_password_warn").html('');
				 $("#new_password_warn").html('');
				 $("#confirm_password_warn").html('');
				
				
					
					if(jQuery.trim($("#old_password").val()) == ''){
					  
						$("#old_password_warn").html('Please enter your old password');
						$("#old_password").focus();
						return false;
						
					}else if(jQuery.trim($("#new_password").val()) == ''){
						
						$("#new_password_warn").html('Please enter your new passowrd');
						$("#new_password").focus();
						return false;
						
					}else if(jQuery.trim($("#confirm_password").val()) == ''){
					  
						$("#confirm_password_warn").html('Re-enter the new password');
						$("#confirm_password").focus();
						return false;
					}else if(jQuery.trim($("#confirm_password").val()) != (jQuery.trim($("#new_password").val()))){
					  
						$("#confirm_password_warn").html('Passwords do not match');
						$("#confirm_password").focus();
						return false;
						
					}else
					{	
					      	$("#changePassword").submit();
					}
					
					return false;	
				});
		});
		
	 
function removeError(idval){
	$("#"+idval+"_warn").html('');}
</script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<script>
// just for the demos, avoids form submit
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
$( "#changePassword" ).validate({
  rules: {
    old_password: {
      required: true,
      minlength: 6
    },
	new_password: {
      required: true,
      minlength: 6
    },
	confirm_password: {
      required: true,
      minlength: 6
    },
  }
});
</script>
<!---DASHBOARD-->
<!---FOOTER-->
<?php 

$this->load->view('site/templates/footer');
?>