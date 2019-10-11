<?php 
$this->load->view('site/templates/header');
?>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor account acc-setting">

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
                <li><a href="<?php echo base_url();?>account-security"><?php if($this->lang->line('Security') != '') { echo stripslashes($this->lang->line('Security')); } else echo "Security";?></a></li>
                <li class="active"><a href="<?php echo base_url();?>account-setting"><?php if($this->lang->line('Settings') != '') { echo stripslashes($this->lang->line('Settings')); } else echo "Settings";?></a></li>            
            

            <a class="invitefrds" href="#" style="display:none"><?php if($this->lang->line('InviteFriendspage') != '') { echo stripslashes($this->lang->line('InviteFriendspage')); } else echo "Invite Friends page";?></a>

            
          </ul>
            	<div id="account">
    <div class="box">
      <div class="middle">
        <form method="post" action="account-setting" accept-charset="UTF-8" id="dashboard_account_setting"><div style="margin:0;padding:0;display:inline"></div>
          <h2><?php echo $heading;?></h2>
          <div class="section notification_section">
            <div class="notification_area">
              
              <div class="notification_action">


              
               
                <table class="password-fields">
                    <tbody><tr>
					<td><?php if($this->lang->line('CountryofResidence') != '') { echo stripslashes($this->lang->line('CountryofResidence')); } else echo "Country of Residence";?>:<!--<i class="questn">
              <span class="verifi">
              Verifications help build trust between guests and hosts and can make booking easier.
              <i class="arsd-ico rot"></i>
              <a href="#">Learn more »</a>
              </span>
              </i>--></td><td>
					<select id="country" name="country" onchange="javascript:changebotton();" style="width: 270px; height: 41px; margin: 3px 3px 3px 21px;">
					<option value="" >Select</option>
					<?php foreach ($countries->result() as $country):?>
					<option  value="<?php echo $country->id;?>" <?php if($userDetails->row()->country==$country->id){?>selected="selected"<?php }?>><?php echo $country->name;?></option>
					<?php endforeach;?>
					</select>

					
                    <div id="old_password_warn"  style="float:right; color:#FF0000;"></div></td>
					<span style="float:right;" class="error" id="country_warn"></span>
					</tr>
                  </tbody></table>

                       <p class="confirms"><?php if($this->lang->line('Clicksave') != '') { echo stripslashes($this->lang->line('Clicksave')); } else echo "Click save Country of Residence to confirm";?></p>
              </div>
            </div>
            <div class="buttons">
              <input id="change_button" type="button" disabled="true" value="<?php if($this->lang->line('ResidenceClicksave') != '') { echo stripslashes($this->lang->line('ResidenceClicksave')); } else echo "Save Country of Residence";?>"  onclick="return dashboard_account_setting();" name="commit" class="invitefrds">
            </div>
          </div>
</form>
      

        <div class="clearfix"></div>
      </div>
    </div>















    <div class="box cancel-account">
      <div class="middle">
       
          <h2><?php if($this->lang->line('CancelAccount') != '') { echo stripslashes($this->lang->line('CancelAccount')); } else echo "Cancel Account";?></h2>
          <div class="section notification_section">
            <div class="notification_area">
              
              <div class="notification_action">


              <a href="site/cms/cancelmyaccount/<?php echo $userDetails->row()->id; ?>"> <input type="button" value="<?php if($this->lang->line('CancelAccount') != '') { echo stripslashes($this->lang->line('CancelAccount')); } else echo "Cancel Account";?>"  class="invitefrds"></a>
              </div>
            </div>
            
          </div>

      

        <div class="clearfix"></div>
      </div>
    </div>


  </div>
         
  </div>
    </div>
</div>
<script type="text/javascript">
function dashboard_account_setting()
{
$('#country_warn').text('');
var country=$('#country').val();
if(country=='')
{
$('#country_warn').text('Please Select Country');
return false;
}
else
{
$('#dashboard_account_setting').submit();
}
}
		
	 
function removeError(idval){
	$("#"+idval+"_warn").html('');}
	
function changebotton(){
	$("#change_button").removeAttr('disabled');
	}
</script>
<!---DASHBOARD-->
<!---FOOTER-->
<?php 
$this->load->view('site/templates/footer');
?>