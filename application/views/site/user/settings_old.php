<?php 
$this->load->view('site/templates/header');
?>

<link rel="stylesheet" type="text/css" href="css/colorbox.css" media="all" />
<link href="css/page_inner.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/my-account.css" type="text/css" media="all"/>
<script type="text/javascript" src="js/site/SpryTabbedPanels.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/site/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="js/site/jquery.galleryview-3.0-dev.js"></script>
<!-- script added 14/05/2014 -->

<!-- script end -->

<!---DASHBOARD-->
<div class="dashboard yourlisting bgcolor profile-edit">

<div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('header_dashboard') != '') { echo stripslashes($this->lang->line('header_dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></a></li>
                <li class="active"><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul> </div></div>
	<div class="main">
    	<div id="command_center">
        <div class="dashboard-sidemenu">
             <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></a></li>
                <li class="active"><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li ><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul> 
            <ul class="subnav">
                <li class="active"><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('EditProfile') != '') { echo stripslashes($this->lang->line('EditProfile')); } else echo "Edit Profile";?></a></li>
				<li ><a href="<?php echo base_url();?>photo-video"><?php if($this->lang->line('photos') != '') { echo stripslashes($this->lang->line('photos')); } else echo "Photos";?></a></li>
				<li ><a href="<?php echo base_url();?>verification"><?php if($this->lang->line('TrustandVerification') != '') { echo stripslashes($this->lang->line('TrustandVerification')); } else echo "Trust and Verification";?></a></li>
                <li ><a href="<?php echo base_url();?>display-review"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></a></li>
                
				 <a class="invitefrds" href="users/show/<?php echo $userDetails->row()->id; ?>"><?php if($this->lang->line('ViewProfile') != '') { echo stripslashes($this->lang->line('ViewProfile')); } else echo "View Profile";?></a> 
				 
				 
                          
            </ul>
			</div>
			<div class="listiong-areas">
            	<div id="account">
    <div class="box">
	
	
	<?php //echo "<pre>"; print_r($userDetails);die;   ?>
      <div class="middle">
			

         <!-- <h1>Mobile Notifications / Text Messages</h1>-->
         
  				<h1><?php if($this->lang->line('Required') != '') { echo stripslashes($this->lang->line('Required')); } else echo "Required";?></h1>
               <!-- <form name="email_settings" method="post" action="site/user/update_notifications">-->
                 <div class="section notification_section" style="width:100%;">
					 
  	       <div id="div-form" style="border:1px solid #000;">
  		<form class="myform" id="profile_settings_form" method="post" action="site/user_settings/changePhoto" enctype="multipart/form-data" onSubmit="return profileUpdate();">
          <ul>
            <li>
		  <label for="user"><?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "First Name";?>:</label>
            <input type="text" name="firstname" id="firstname" value="<?php if(!empty($userDetails)) echo $userDetails->row()->firstname; ?>" />
			
           </li> 
		   
		   <li>
            <label for="emailaddress"><?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Last Name:";?>:</label>
            <input type="text" name="lastname" value="<?php if(!empty($userDetails)) echo $userDetails->row()->lastname; ?>" /><br />
            <span class="tips-text"><?php if($this->lang->line('Thisisonlyshared') != '') { echo stripslashes($this->lang->line('Thisisonlyshared')); } else echo "This is only shared once you have a confirmed booking with another user.";?></span>
			</li> 
           
               <li>
            <label for="emailaddress"><?php if($this->lang->line('IAm') != '') { echo stripslashes($this->lang->line('IAm')); } else echo "I Am";?>:<i class="lock"></i></label>
            <select class="gends" id="gender" name="gender"><option value="Male" <?php if(!empty($userDetails)){if($userDetails->row()->gender=='Male'){echo 'selected="selected"';}}?>>Male</option><option value="Female" <?php if(!empty($userDetails)){if($userDetails->row()->gender=='Female'){echo 'selected="selected"';}}?>>Female</option><option value="Unspecified" <?php if(!empty($userDetails)){if($userDetails->row()->gender=='Unspecified'){echo 'selected="selected"';}}?>>Unspecified</option></select><br />
            <span class="tips-text"><?php if($this->lang->line('Weusethisdata') != '') { echo stripslashes($this->lang->line('Weusethisdata')); } else echo "We use this data for analysis and never share it with other users.";?></span>
			</li>              
			 <li>
            <label for="emailaddress"><?php if($this->lang->line('BirthDate') != '') { echo stripslashes($this->lang->line('BirthDate')); } else echo "Birth Date";?>:<i class="lock"></i></label>
            <select class="mnths" name="dob_month" id="user_birthdate_2i" class="valid">
<option value="1" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='1'){echo 'selected="selected"';}}?> >January</option>
<option value="2" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='2'){echo 'selected="selected"';}}?>>February</option>
<option value="3" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='3'){echo 'selected="selected"';}}?>>March</option>
<option value="4" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='4'){echo 'selected="selected"';}}?>>April</option>
<option value="5" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='5'){echo 'selected="selected"';}}?>>May</option>
<option value="6" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='6'){echo 'selected="selected"';}}?>>June</option>
<option value="7" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='7'){echo 'selected="selected"';}}?>>July</option>
<option value="8" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='8'){echo 'selected="selected"';}}?>>August</option>
<option value="9" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='9'){echo 'selected="selected"';}}?>>September</option>
<option value="10" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='10'){echo 'selected="selected"';}}?>>October</option>
<option value="11" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='11'){echo 'selected="selected"';}}?>>November</option>
<option value="12" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='12'){echo 'selected="selected"';}}?>>December</option>
</select>


<select class="mnths2" name="dob_date" id="user_birthdate_3i">
<?php
for($i=1;$i<=31;$i++){

echo '<option value="'.$i.'"'; 
if(!empty($userDetails)){if($userDetails->row()->dob_date==$i){echo 'selected="selected"';}}

echo '>'.$i.'</option>';
}


 ?>
</select>

 

<select class="dob21" name="dob_year" id="user_birthdate_1i" class="valid">
<?php 
$current_year=date('Y')-15;
for($i=$current_year;$i > 1920;$i--){

echo '<option value="'.$i.'"'; 
if(!empty($userDetails)){if($userDetails->row()->dob_year==$i){echo 'selected="selected"';}}

echo '>'.$i.'</option>';
}
?>
</select>
<span class="tips-text"><?php if($this->lang->line('Themagicaldayou') != '') { echo stripslashes($this->lang->line('Themagicaldayou')); } else echo "The magical day you were dropped from the sky by a stork. We use this data for analysis and never share it with other users.";?></span>
     </li>          
            
           <!-- <input type="text" placeholder="mm/dd/yyyy" name="datefrom" id="datefrom" class="checkin ui-datepicker-target">-->
            
            <li>
             <label for="emailaddress"><?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address";?>:<i class="lock"></i></label>
            <input type="text" name="email" value="<?php if(!empty($userDetails)) echo $userDetails->row()->email; ?>" /><br />
           <span class="tips-text"><?php if($this->lang->line('Thisisonlyshared') != '') { echo stripslashes($this->lang->line('Thisisonlyshared')); } else echo "This is only shared once you have a confirmed booking with another user.";?></span>
		   </li> 
			
			
			 <li>
			 <label for="emailaddress"><?php if($this->lang->line('PhoneNumber') != '') { echo stripslashes($this->lang->line('PhoneNumber')); } else echo "Phone Number";?>:<i class="lock"></i></label>
			 <?php if($user_verified_status->row()->ph_verified=='yes'){?>
			 <div class="phone-num">
           <?php if($this->lang->line('PhoneNumberisVerified.') != '') { echo stripslashes($this->lang->line('PhoneNumberisVerified')); } else echo "Phone Number is Verified.";?>
		   </div>
			 <?php } else {?>
            
			<span class="no-numbr"><?php if($this->lang->line('Nophonenumberentered') != '') { echo stripslashes($this->lang->line('Nophonenumberentered')); } else echo "No phone number entered";?></span>
			
			
			<div class="phone-number-verify-widget" style="display: block;">
			<div class="pnaw-step1">
			<div id="phone-number-input-widget-64e0b448" class="phone-number-input-widget">
			<label for="phone_country"><?php if($this->lang->line('Chooseacountry') != '') { echo stripslashes($this->lang->line('Chooseacountry')); } else echo "Choose a country";?>:</label>
			<div class="select">
			<select id="phone_country" name="phone_country" onchange="get_mobile_code(this.value)">
			<option value="" >Select</option>
			<?php foreach($active_countries->result() as $active_country) :?>
			<option value="<?php echo $active_country->id;?>" <?php if($userDetails->row()->s_city == $active_country->id ){ echo "selected";} ?> ><?php echo $active_country->name;?></option>
			<?php endforeach;?>
			</select>
			</div>
			<label for="phone_number"><?php if($this->lang->line('Addaphonenumber') != '') { echo stripslashes($this->lang->line('Addaphonenumber')); } else echo "Add a phone number";?>:</label>
			<div class="pniw-number-container clearfix">
			<div class="pniw-number-prefix">+91</div>
			<input id="phone_number" name="phone_no" class="pniw-number" type="text" value="<?php if(!empty($userDetails)) echo $userDetails->row()->phone_no; ?>">
			</div>
			</div>
			<div class="pnaw-verify-container">
			<a class="btn btn-primary" rel="sms" href="javascript:void(0);" id="verify_sms"><?php if($this->lang->line('VerifyviaSMS') != '') { echo stripslashes($this->lang->line('VerifyviaSMS')); } else echo "Verify via SMS";?></a>
			<a class="btn btn-primary" rel="call" href="#"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?>Verify via Call</a>
			<a class="why-verify" target="_blank" href="pages/why-verify" style="display:none;"><?php if($this->lang->line('WhyVerify') != '') { echo stripslashes($this->lang->line('WhyVerify')); } else echo "Why Verify?";?></a>
			</div>
			</div>
			</div>
			
			<div class="phone-number-verify-widget verification_div" style="display: none;">
    <p class="message message_sent"></p>
    <label for="phone_number_verification"><?php if($this->lang->line('Pleaseenterthe') != '') { echo stripslashes($this->lang->line('Pleaseenterthe')); } else echo "Please enter the 4-digit code";?>:</label>
    <input type="text" id="mobile_verification_code">
     <a href="javascript:void(0);" onclick="check_phpone_verification()" rel="verify">
        <?php if($this->lang->line('Verify') != '') { echo stripslashes($this->lang->line('Verify')); } else echo "Verify";?>
      </a>
      <a href="javascript:void(0);" onclick="cancel_verification();">
       <?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel";?> 
      </a>
    
    <p class="arrive"><?php if($this->lang->line('Ifitdoesnt') != '') { echo stripslashes($this->lang->line('Ifitdoesnt')); } else echo "If it doesn't arrive, click cancel and try call verification instead.";?></p>
  
			</div>
			
			
			
			
			
			
			
			
           
           <span class="tips-text"><?php if($this->lang->line('Thisisonlysharedonce') != '') { echo stripslashes($this->lang->line('Thisisonlysharedonce')); } else echo "This is only shared once you have a confirmed booking with another user. This is how we can all get in touch.";?></span>
		   <?php }?>
		   </li> 
			
			
			
			 <li>
            <label for="emailaddress"><?php if($this->lang->line('WhereYouLive') != '') { echo stripslashes($this->lang->line('WhereYouLive')); } else echo "Where You Live";?>:</label>
            <input type="text" name="s_city" value="<?php if(!empty($userDetails)) echo $userDetails->row()->s_city; ?>" /><br />
            </li> 
			
			
			 <li>
            <label for="comments"><?php if($this->lang->line('DescribeYourself') != '') { echo stripslashes($this->lang->line('DescribeYourself')); } else echo "DescribeYourself";?>:</label>
			<textarea name="description" style="width:500px"><?php if(!empty($userDetails)) echo $userDetails->row()->description; ?></textarea><br />
			<span class="tips-text"><div class="text-muted row-space-top-1">
<?php if($this->lang->line('Weisbuiltonrelationships') != '') { echo stripslashes($this->lang->line('Weisbuiltonrelationships')); } else echo "We is built on relationships. Help other people get to know you.";?>
<br>
<br>
<?php if($this->lang->line('Tellthemabout') != '') { echo stripslashes($this->lang->line('Tellthemabout')); } else echo "Tell them about the things you like: What are 5 things you can’t live without? Share your favorite travel destinations, books, movies, shows, music, food.";?>
<br>
<br>
<?php if($this->lang->line('Tellthemwhat') != '') { echo stripslashes($this->lang->line('Tellthemwhat')); } else echo "Tell them what it’s like to have you as a guest or host: What’s your style of traveling? Of hosting?";?>
<br>
<br>
<?php if($this->lang->line('Dyouhave') != '') { echo stripslashes($this->lang->line('Dyouhave')); } else echo "Tell them about you: Do you have a life motto?";?>
</div></span>
            </li> 
			
			
			
        
        </div> <!-- form befor div closed -->
					
  	       
  			 
          </div>
				   
    <div class="clearfix"></div>
      </div>
    </div>
	
	
	
	
	
	 <div class="box">
	
	
	
      <div class="middle">
			

         <!-- <h1>Mobile Notifications / Text Messages</h1>-->
         
  				<h1><?php if($this->lang->line('Optional') != '') { echo stripslashes($this->lang->line('Optional')); } else echo "Optional";?></h1>
               <!-- <form name="email_settings" method="post" action="site/user/update_notifications">-->
                 <div class="section notification_section" style="width:100%;">
					 
  	       <div id="div-form" style="border:1px solid #000;">
  		
          <ul>
          
			
			
			
			 <li>
            <label for="school"><?php if($this->lang->line('School') != '') { echo stripslashes($this->lang->line('School')); } else echo "School";?>:</label>
			<input type="text" name="school" value="<?php if(!empty($userDetails)) echo $userDetails->row()->school; ?>" /><br />
            
			</li>
			
			
			<li>
            <label for="work"><?php if($this->lang->line('Work') != '') { echo stripslashes($this->lang->line('Work')); } else echo "Work";?>:</label>
			<input type="text" name="work" value="<?php if(!empty($userDetails)) echo $userDetails->row()->work; ?>" /><br />
            </li> 
			
			
			<li>
<label for="timezone" ><?php if($this->lang->line('TimeZone') != '') { echo stripslashes($this->lang->line('TimeZone')); } else echo "Time Zone";?>:</label>
<select name="timezone"  id="user_preference_time_zone">
<option value="">Select</option>
<option value="International Date Line West" <?php if($userDetails->row()->timezone=='International Date Line West'){?>selected="selected"<?php }?>>(GMT-11:00) International Date Line West</option>
<option value="Midway Island" <?php if($userDetails->row()->timezone=='Midway Island'){?>selected="selected"<?php }?>>(GMT-11:00) Midway Island</option>
<option value="Samoa" <?php if($userDetails->row()->timezone=='Samoa'){?>selected="selected"<?php }?>>(GMT-11:00) Samoa</option>
<option value="Hawaii" <?php if($userDetails->row()->timezone=='Hawaii'){?>selected="selected"<?php }?>>(GMT-10:00) Hawaii</option>
<option value="Alaska" <?php if($userDetails->row()->timezone=='Alaska'){?>selected="selected"<?php }?>>(GMT-09:00) Alaska</option>
<option value="America/Los_Angeles" <?php if($userDetails->row()->timezone=='America/Los_Angeles'){?>selected="selected"<?php }?>>(GMT-08:00) America/Los_Angeles</option>
<option value="Pacific Time (US &amp; Canada)" <?php if($userDetails->row()->timezone=='Pacific Time (US &amp; Canada)'){?>selected="selected"<?php }?>>(GMT-08:00) Pacific Time (US &amp; Canada)</option>
<option value="Tijuana" <?php if($userDetails->row()->timezone=='Tijuana'){?>selected="selected"<?php }?>>(GMT-08:00) Tijuana</option>
<option value="Arizona" <?php if($userDetails->row()->timezone=='Arizona'){?>selected="selected"<?php }?>>(GMT-07:00) Arizona</option>
<option value="Chihuahua" <?php if($userDetails->row()->timezone=='Chihuahua'){?>selected="selected"<?php }?>>(GMT-07:00) Chihuahua</option>
<option value="Mazatlan" <?php if($userDetails->row()->timezone=='Mazatlan'){?>selected="selected"<?php }?>>(GMT-07:00) Mazatlan</option>
<option value="Mountain Time (US &amp; Canada)" <?php if($userDetails->row()->timezone=='Mountain Time (US &amp; Canada)'){?>selected="selected"<?php }?>>(GMT-07:00) Mountain Time (US &amp; Canada)</option>
<option value="Central America" <?php if($userDetails->row()->timezone=='Central America'){?>selected="selected"<?php }?>>(GMT-06:00) Central America</option>
<option value="Central Time (US &amp; Canada)" <?php if($userDetails->row()->timezone=='Central Time (US &amp; Canada)'){?>selected="selected"<?php }?>>(GMT-06:00) Central Time (US &amp; Canada)</option>
<option value="Guadalajara" <?php if($userDetails->row()->timezone=='Guadalajara'){?>selected="selected"<?php }?>>(GMT-06:00) Guadalajara</option>
<option value="Mexico City" <?php if($userDetails->row()->timezone=='Mexico City'){?>selected="selected"<?php }?>>(GMT-06:00) Mexico City</option>
<option value="Monterrey" <?php if($userDetails->row()->timezone=='Monterrey'){?>selected="selected"<?php }?>>(GMT-06:00) Monterrey</option>
<option value="Saskatchewan" <?php if($userDetails->row()->timezone=='Saskatchewan'){?>selected="selected"<?php }?>>(GMT-06:00) Saskatchewan</option>
<option value="America/Montreal" <?php if($userDetails->row()->timezone=='America/Montreal'){?>selected="selected"<?php }?>>(GMT-05:00) America/Montreal</option>
<option value="America/New_York" <?php if($userDetails->row()->timezone=='America/New_York'){?>selected="selected"<?php }?>>(GMT-05:00) America/New_York</option>
<option value="America/Toronto" <?php if($userDetails->row()->timezone=='America/Toronto'){?>selected="selected"<?php }?>>(GMT-05:00) America/Toronto</option>
<option value="Bogota" <?php if($userDetails->row()->timezone=='Bogota'){?>selected="selected"<?php }?>>(GMT-05:00) Bogota</option>
<option value="Eastern Time (US &amp; Canada)" <?php if($userDetails->row()->timezone=='Eastern Time (US &amp; Canada)'){?>selected="selected"<?php }?>>(GMT-05:00) Eastern Time (US &amp; Canada)</option>
<option value="Indiana (East)" <?php if($userDetails->row()->timezone=='ndiana (East)'){?>selected="selected"<?php }?>>(GMT-05:00) Indiana (East)</option>
<option value="Lima" <?php if($userDetails->row()->timezone=='Lima'){?>selected="selected"<?php }?>>(GMT-05:00) Lima</option>
<option value="Quito" <?php if($userDetails->row()->timezone=='Quito'){?>selected="selected"<?php }?>>(GMT-05:00) Quito</option>
<option value="Caracas" <?php if($userDetails->row()->timezone=='Caracas'){?>selected="selected"<?php }?>>(GMT-04:30) Caracas</option>
<option value="Atlantic Time (Canada)" <?php if($userDetails->row()->timezone=='Atlantic Time (Canada)'){?>selected="selected"<?php }?>>(GMT-04:00) Atlantic Time (Canada)</option>
<option value="Georgetown" <?php if($userDetails->row()->timezone=='Georgetown'){?>selected="selected"<?php }?>>(GMT-04:00) Georgetown</option>
<option value="La Paz" <?php if($userDetails->row()->timezone=='La Paz'){?>selected="selected"<?php }?>>(GMT-04:00) La Paz</option>
<option value="Santiago" <?php if($userDetails->row()->timezone=='Santiago'){?>selected="selected"<?php }?>>(GMT-04:00) Santiago</option>
<option value="Newfoundland" <?php if($userDetails->row()->timezone=='Newfoundland'){?>selected="selected"<?php }?>>(GMT-03:30) Newfoundland</option>
<option value="Brasilia" <?php if($userDetails->row()->timezone=='Brasilia'){?>selected="selected"<?php }?>>(GMT-03:00) Brasilia</option>
<option value="Buenos Aires" <?php if($userDetails->row()->timezone=='Buenos Aires'){?>selected="selected"<?php }?>>(GMT-03:00) Buenos Aires</option>
<option value="Greenland" <?php if($userDetails->row()->timezone=='Greenland'){?>selected="selected"<?php }?>>(GMT-03:00) Greenland</option>
<option value="Mid-Atlantic" <?php if($userDetails->row()->timezone=='Mid-Atlantic'){?>selected="selected"<?php }?>>(GMT-02:00) Mid-Atlantic</option>
<option value="Azores" <?php if($userDetails->row()->timezone=='Azores'){?>selected="selected"<?php }?>>(GMT-01:00) Azores</option>
<option value="Cape Verde Is." <?php if($userDetails->row()->timezone=='Cape Verde Is.'){?>selected="selected"<?php }?>>(GMT-01:00) Cape Verde Is.</option>
<option value="Casablanca" <?php if($userDetails->row()->timezone=='Casablanca'){?>selected="selected"<?php }?>>(GMT+00:00) Casablanca</option>
<option value="Dublin" <?php if($userDetails->row()->timezone=='Dublin'){?>selected="selected"<?php }?>>(GMT+00:00) Dublin</option>
<option value="Edinburgh" <?php if($userDetails->row()->timezone=='Edinburgh'){?>selected="selected"<?php }?>>(GMT+00:00) Edinburgh</option>
<option value="Lisbon" <?php if($userDetails->row()->timezone=='Lisbon'){?>selected="selected"<?php }?>>(GMT+00:00) Lisbon</option>
<option value="London" <?php if($userDetails->row()->timezone=='London'){?>selected="selected"<?php }?>>(GMT+00:00) London</option>
<option value="Monrovia" <?php if($userDetails->row()->timezone=='Monrovia'){?>selected="selected"<?php }?>>(GMT+00:00) Monrovia</option>
<option value="UTC" <?php if($userDetails->row()->timezone=='UTC'){?>selected="selected"<?php }?>>(GMT+00:00) UTC</option>
<option value="Amsterdam" <?php if($userDetails->row()->timezone=='Amsterdam'){?>selected="selected"<?php }?>>(GMT+01:00) Amsterdam</option>
<option value="Belgrade" <?php if($userDetails->row()->timezone=='Belgrade'){?>selected="selected"<?php }?>>(GMT+01:00) Belgrade</option>
<option value="Berlin" <?php if($userDetails->row()->timezone=='Berlin'){?>selected="selected"<?php }?>>(GMT+01:00) Berlin</option>
<option value="Bern" <?php if($userDetails->row()->timezone=='Bern'){?>selected="selected"<?php }?>>(GMT+01:00) Bern</option>
<option value="Bratislava" <?php if($userDetails->row()->timezone=='Bratislava'){?>selected="selected"<?php }?>>(GMT+01:00) Bratislava</option>
<option value="Brussels" <?php if($userDetails->row()->timezone=='Brussels'){?>selected="selected"<?php }?>>(GMT+01:00) Brussels</option>
<option value="Budapest" <?php if($userDetails->row()->timezone=='Budapest'){?>selected="selected"<?php }?>>(GMT+01:00) Budapest</option>
<option value="Copenhagen" <?php if($userDetails->row()->timezone=='Copenhagen'){?>selected="selected"<?php }?>>(GMT+01:00) Copenhagen</option>
<option value="Europe/Amsterdam" <?php if($userDetails->row()->timezone=='Europe/Amsterdam'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Amsterdam</option>
<option value="Europe/Berlin" <?php if($userDetails->row()->timezone=='Europe/Berlin'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Berlin</option>
<option value="Europe/Copenhagen" <?php if($userDetails->row()->timezone=='Europe/Copenhagen'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Copenhagen</option>
<option value="Europe/Madrid" <?php if($userDetails->row()->timezone=='Europe/Madrid'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Madrid</option>
<option value="Europe/Paris" <?php if($userDetails->row()->timezone=='Europe/Paris'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Paris</option>
<option value="Europe/Rome" <?php if($userDetails->row()->timezone=='Europe/Rome'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Rome</option>
<option value="Europe/Zagreb" <?php if($userDetails->row()->timezone=='Europe/Zagreb'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Zagreb</option>
<option value="Ljubljana" <?php if($userDetails->row()->timezone=='Ljubljana'){?>selected="selected"<?php }?>>(GMT+01:00) Ljubljana</option>
<option value="Madrid" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Madrid</option>
<option value="Paris" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Paris</option>
<option value="Prague" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Prague</option>
<option value="Rome" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Rome</option>
<option value="Sarajevo" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Sarajevo</option>
<option value="Skopje" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Skopje</option>
<option value="Stockholm" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Stockholm</option>
<option value="Vienna" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Vienna</option>
<option value="Warsaw" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Warsaw</option>
<option value="West Central Africa" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) West Central Africa</option>
<option value="Zagreb" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Zagreb</option>
<option value="Asia/Jerusalem" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Asia/Jerusalem</option>
<option value="Athens" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Athens</option>
<option value="Bucharest" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Bucharest</option>
<option value="Cairo" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Cairo</option>
<option value="Harare" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Harare</option>
<option value="Helsinki" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Helsinki</option>
<option value="Istanbul" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Istanbul</option>
<option value="Jerusalem" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Jerusalem</option>
<option value="Kyiv" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Kyiv</option>
<option value="Pretoria" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Pretoria</option>
<option value="Riga" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Riga</option>
<option value="Sofia" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Sofia</option>
<option value="Tallinn" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Tallinn</option>
<option value="Vilnius" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Vilnius</option>
<option value="Baghdad" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:00) Baghdad</option>
<option value="Kuwait" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:00) Kuwait</option>
<option value="Minsk" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:00) Minsk</option>
<option value="Nairobi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:00) Nairobi</option>
<option value="Riyadh" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:00) Riyadh</option>
<option value="Tehran" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:30) Tehran</option>
<option value="Abu Dhabi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Abu Dhabi</option>
<option value="Baku" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Baku</option>
<option value="Moscow" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Moscow</option>
<option value="Muscat" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Muscat</option>
<option value="St. Petersburg" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) St. Petersburg</option>
<option value="Tbilisi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Tbilisi</option>
<option value="Volgograd" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Volgograd</option>
<option value="Yerevan" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Yerevan</option>
<option value="Kabul" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:30) Kabul</option>
<option value="Islamabad" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:00) Islamabad</option>
<option value="Karachi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:00) Karachi</option>
<option value="Tashkent" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:00) Tashkent</option>
<option value="Chennai" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:30) Chennai</option>
<option value="Kolkata" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:30) Kolkata</option>
<option value="Mumbai" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:30) Mumbai</option>
<option value="New Delhi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:30) New Delhi</option>
<option value="Sri Jayawardenepura" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:30) Sri Jayawardenepura</option>
<option value="Kathmandu" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:45) Kathmandu</option>
<option value="Almaty" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+06:00) Almaty</option>
<option value="Astana" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+06:00) Astana</option>
<option value="Dhaka" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+06:00) Dhaka</option>
<option value="Ekaterinburg" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+06:00) Ekaterinburg</option>
<option value="Rangoon" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+06:30) Rangoon</option>
<option value="Bangkok" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+07:00) Bangkok</option>
<option value="Hanoi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+07:00) Hanoi</option>
<option value="Jakarta" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+07:00) Jakarta</option>
<option value="Novosibirsk" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+07:00) Novosibirsk</option>
<option value="Asia/Makassar" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Asia/Makassar</option>
<option value="Beijing" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Beijing</option>
<option value="Chongqing" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Chongqing</option>
<option value="Hong Kong" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Hong Kong</option>
<option value="Krasnoyarsk" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Krasnoyarsk</option>
<option value="Kuala Lumpur" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Kuala Lumpur</option>
<option value="Perth" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Perth</option>
<option value="Singapore" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Singapore</option>
<option value="Taipei" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Taipei</option>
<option value="Ulaan Bataar" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Ulaan Bataar</option>
<option value="Urumqi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Urumqi</option>
<option value="Irkutsk" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:00) Irkutsk</option>
<option value="Osaka" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:00) Osaka</option>
<option value="Sapporo" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:00) Sapporo</option>
<option value="Seoul" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:00) Seoul</option>
<option value="Tokyo" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:00) Tokyo</option>
<option value="Adelaide" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:30) Adelaide</option>
<option value="Darwin" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:30) Darwin</option>
<option value="Brisbane" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Brisbane</option>

<option value="Canberra" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Canberra</option>
<option value="Guam" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Guam</option>
<option value="Hobart" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Hobart</option>
<option value="Melbourne" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Melbourne</option>
<option value="Port Moresby" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Port Moresby</option>
<option value="Sydney" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Sydney</option>
<option value="Yakutsk" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Yakutsk</option>
<option value="New Caledonia" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+11:00) New Caledonia</option>
<option value="Vladivostok" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+11:00) Vladivostok</option>
<option value="Auckland" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Auckland</option>
<option value="Fiji" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Fiji</option>
<option value="Kamchatka" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Kamchatka</option>
<option value="Magadan" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Magadan</option>
<option value="Marshall Is." <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Marshall Is.</option>
<option value="Solomon Is." <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Solomon Is.</option>
<option value="Wellington" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Wellington</option>
<option value="Nuku'alofa" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+13:00) Nuku'alofa</option></select>

<span class="tips-text"><?php if($this->lang->line('Yourhometime') != '') { echo stripslashes($this->lang->line('Yourhometime')); } else echo "Your home time zone.";?></span>

</li>

<li>
<label for="emailaddress"><?php if($this->lang->line('Language') != '') { echo stripslashes($this->lang->line('Language')); } else echo "Language";?></label>
<span class="no-numbr">
<ul>
<li><?php if($this->lang->line('None') != '') { echo stripslashes($this->lang->line('None')); } else echo "None";?> </li>
<li><a  data-toggle="modal" href="#myModal"  class="multiselect-add-more"><i class="icon icon-add"></i><?php if($this->lang->line('AddMore') != '') { echo stripslashes($this->lang->line('AddMore')); } else echo "Add More";?></a></li>
<li><span style="width:100%" class="tips-text"><?php if($this->lang->line('Addlanguages') != '') { echo stripslashes($this->lang->line('Addlanguages')); } else echo "Add languages you speak.";?></span></li>
</ul>

</span>
<?php 
$languages_known_user=explode(',',$userDetails->row()->languages_known);
if(count($languages_known_user)>0)
{ ?>
<ul class="inner_language">
<?php
foreach($languages_known->result() as $language){
if(in_array($language->language_code,$languages_known_user)) {?>
<li id="<?php echo $language->language_code;?>"><?php echo $language->language_name;?><small>
<a class="text-normal" href="javascript:void(0);" onclick="delete_languages(this,'<?php echo $language->language_code;?>')">x</a>
</small></li>
<?php } }?>
</ul>
<?php }?>
</li>


<li>
<label for="emailaddress"><?php if($this->lang->line('Emergencycontact') != '') { echo stripslashes($this->lang->line('Emergencycontact')); } else echo "Emergency contact";?></label>
<span class="no-numbr">
<ul>

<li><span style="width:100%" class="tips-text"><?php if($this->lang->line('GiveourCustomer') != '') { echo stripslashes($this->lang->line('GiveourCustomer')); } else echo "Give our Customer Experience team a trusted contact we can alert in an urgent situation.";?></span></li>



</ul>

</span>
<li>
          
		  
<ul>	  <li><label for="emergency_name"><?php if($this->lang->line('Name') != '') { echo stripslashes($this->lang->line('Name')); } else echo "Name";?></label>
<input id="emergency_name" type="text" value="<?php if(!empty($userDetails)) echo $userDetails->row()->emergency_name; ?>" name="emergency_name">
</li>
 <li><label for="emergency_phone"><?php if($this->lang->line('Phone') != '') { echo stripslashes($this->lang->line('Phone')); } else echo "Phone";?></label>
<input id="emergency_phone" type="text" value="<?php if(!empty($userDetails)) echo $userDetails->row()->emergency_phone; ?>" name="emergency_phone">
</li>
 <li><label for="emergency_email"><?php if($this->lang->line('Email') != '') { echo stripslashes($this->lang->line('Email')); } else echo "Email";?></label>
<input id="emergency_email" type="text" value="<?php if(!empty($userDetails)) echo $userDetails->row()->emergency_email; ?>" name="emergency_email">
</li>
 <li><label for="emergency_relationship"><?php if($this->lang->line('Relationship') != '') { echo stripslashes($this->lang->line('Relationship')); } else echo "Relationship";?></label>
<input id="emergency_relationship" type="text" value="<?php if(!empty($userDetails)) echo $userDetails->row()->emergency_relationship; ?>" name="emergency_relationship">
</ul>
<button class="btn btn-primary blue" type="submit"><?php if($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save";?> </button>
</li>

<!---
            <div class="upload-file">
					<input id="uploadavatar" class="uploadavatar" name="upload-file" type="file">
					<span class="uploading" style="display:none"><?php if($this->lang->line('settings_uploading') != '') { echo stripslashes($this->lang->line('settings_uploading')); } else echo "Uploading..."; ?></span>
					<span class="description"><?php if($this->lang->line('settings_allowedimag') != '') { echo stripslashes($this->lang->line('settings_allowedimag')); } else echo "Allowed file types JPG, GIF or PNG.<br>Maximum width and height is 600px"; ?></span>
					<?php if(!empty($userDetails) && $userDetails->row()->image!=''){ ?>
					<img src="images/users/<?php echo $userDetails->row()->image; ?>" width="100px" />
                    <?php } ?>
				</div>
				
				
	<div class="">
	<?php $languages_knowns=explode(',',$userDetails->row()->languages_known);?>
        <label>Languages Known </label></br>
          
            <input type="checkbox" <?php if(in_array(4096,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="4096">
            Bahasa Indonesia
          </br>
          
            <input type="checkbox" <?php if(in_array(4194304,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="4194304">
            Bahasa Malaysia
          </br>
          
            <input type="checkbox" <?php if(in_array(32768,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="32768">
            Bengali
          </br>
          
            <input type="checkbox" <?php if(in_array(16777216,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="16777216">
            Dansk
          </br>
          
            <input type="checkbox" <?php if(in_array(4,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="4">
            Deutsch
          </br>
          
            <input type="checkbox" <?php if(in_array(1,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="1">
            English
          </br>
          
            <input type="checkbox" <?php if(in_array(64,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="64">
            Español
          </br>
          
            <input type="checkbox" <?php if(in_array(2,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="2">
            Français
          </br>
          
            <input type="checkbox" <?php if(in_array(512,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="512">
            Hindi
          </br>
          
            <input type="checkbox" <?php if(in_array(16,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="16">
            Italiano
          </br>
          
            <input type="checkbox" <?php if(in_array(536870912,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="536870912">
            Magyar
          </br>
          
            <input type="checkbox" <?php if(in_array(8192,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="8192">
            Nederlands
          </br>
          
            <input type="checkbox" <?php if(in_array(67108864,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="67108864">
            Norsk
          </br>
          
            <input type="checkbox" <?php if(in_array(2097152,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="2097152">
            Polski
          </br>
          
            <input type="checkbox" <?php if(in_array(1024,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="1024">
            Português
          </br>
          
            <input type="checkbox" <?php if(in_array(131072,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="131072">
            Punjabi
          </br>
           
          
            <input type="checkbox" <?php if(in_array(524288,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="524288">
            Sign Language
          </br>
          
            <input type="checkbox" <?php if(in_array(134217728,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="134217728">
            Suomi
          </br>
          
            <input type="checkbox" <?php if(in_array(33554432,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="33554432">
            Svenska
          </br>
          
            <input type="checkbox" <?php if(in_array(8388608,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="8388608">
            Tagalog
          </br>
          
            <input type="checkbox" <?php if(in_array(2048,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="2048">
            Türkçe
          </br>
          
            <input type="checkbox" <?php if(in_array(268435456,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="268435456">
            Čeština
          </br>
          
            <input type="checkbox" <?php if(in_array(262144,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="262144">
            Ελληνικά
          </br>
          
            <input type="checkbox" <?php if(in_array(32,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="32">
            Русский
          </br>
          
            <input type="checkbox" <?php if(in_array(1073741824,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="1073741824">
            українська
          </br>
          
            <input type="checkbox" <?php if(in_array(1048576,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="1048576">
            עברית
          </br>
          
            <input type="checkbox" <?php if(in_array(256,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="256">
            العربية
          </br>
          
         <input type="checkbox" <?php if(in_array(65536,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="65536">
                           ภาษาไทย
          </br>
          
            <input type="checkbox" <?php if(in_array(128,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="128">
            中文
          </br>
          
            <input type="checkbox" <?php if(in_array(8,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="8">
            日本語
          </br>
          
            <input type="checkbox" <?php if(in_array(16384,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="16384">
            한국어
          </br>
     
      </div>			
				
				
<div class="section notification_section">
<h2>Emergency Contact</h2>
<label for="emergency_name">Name</label><input type="text" name="emergency_name" value="<?php if(!empty($userDetails)) echo $userDetails->row()->emergency_name; ?>" id="emergency_name">
<label for="emergency_phone">Phone</label><input type="text" name="emergency_phone" value="<?php if(!empty($userDetails)) echo $userDetails->row()->emergency_phone; ?>" id="emergency_phone">
<label for="emergency_email">Email</label><input type="text" name="emergency_email" value="<?php if(!empty($userDetails)) echo $userDetails->row()->emergency_email; ?>" id="emergency_email">
<label for="emergency_relationship">Relationship</label><input type="text" name="emergency_relationship" value="<?php if(!empty($userDetails)) echo $userDetails->row()->emergency_relationship; ?>" id="emergency_relationship">
</div>				
            
			<input type="submit" value="Save Settings" name="commit" class="btn green">	
              
            
        </form>
        
        </div>  -->
					
  	       
  			 
          </div>
				</form>    
    <div class="clearfix"></div>
      </div>
    </div>
	
	
  </div>
         
  </div>
   </div>
    </div>
</div>
<!---DASHBOARD-->
<!---FOOTER-->

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.css" />
<script type="text/javascript">
	/*jQuery(document).ready( function () {
		$(".datepicker").datepicker({ minDate:0, dateFormat: 'yy-mm-dd'});
	});*/
	
	
	

$(function() {
$( "#datefrom" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
minDate:0,
onClose: function( selectedDate ) {
$( "#expiredate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#expiredate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
minDate:0,
onClose: function( selectedDate ) {
$( "#datefrom" ).datepicker( "option", "maxDate", selectedDate );
}
});
});

/* $(function() {
$( "#datepicker" ).datepicker();
});*/
</script>

		<div id="myModal" class="modal fade in profilepage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		      
		<div class="panel-header">
		<a class="close" aria-hidden="true" data-dismiss="modal" type="button">×</a>
		<?php if($this->lang->line('SpokenLanguages') != '') { echo stripslashes($this->lang->line('SpokenLanguages')); } else echo "Spoken Languages";?>
		</div>
		<div class="panel-body">
		<p><?php if($this->lang->line('Whatlanguages') != '') { echo stripslashes($this->lang->line('Whatlanguages')); } else echo "What languages can you speak fluently? We have many international travelers who appreciate hosts who can speak their language.";?></p>
		<div class="row-fluid row">
		<div class="span6 col-6">
		<?php $languages_knowns=explode(',',$userDetails->row()->languages_known);?>
      
          <li>
            <input type="checkbox" <?php if(in_array(4096,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="4096">
           <label> Bahasa Indonesia</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(4194304,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="4194304">
            <label>Bahasa Malaysia</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(32768,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="32768">
           <label> Bengali</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(16777216,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="16777216">
           <label> Dansk</label>
         </li>
            <li>
            <input type="checkbox" <?php if(in_array(4,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="4">
           <label> Deutsch</label>
        </li>
            <li>
            <input type="checkbox" <?php if(in_array(1,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="1">
           <label> English</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(64,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="64">
            <label>Español</label>
         </li>
            <li>
            <input type="checkbox" <?php if(in_array(2,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="2">
            <label>Français</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(512,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="512">
           <label> Hindi</label>
       </li>
            <li>
            <input type="checkbox" <?php if(in_array(16,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="16">
           <label> Italiano</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(536870912,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="536870912">
           <label> Magyar</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(8192,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="8192">
           <label> Nederlands</label>
         </li>
            <li>
            <input type="checkbox" <?php if(in_array(67108864,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="67108864">
           <label> Norsk</label>
          </li>





            <li>
            <input type="checkbox" <?php if(in_array(2097152,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="2097152">
           <label> Polski</label>
         </li>
            <li>
            <input type="checkbox" <?php if(in_array(1024,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="1024">
           <label> Português</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(131072,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="131072">
           <label> Punjabi</label>
        </li>




		</div>
		<div class="span6 col-6">
             <li>
          
            <input type="checkbox" <?php if(in_array(524288,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="524288">
           <label> Sign Language</label>
         </li>
            <li>
            <input type="checkbox" <?php if(in_array(134217728,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="134217728">
           <label> Suomi</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(33554432,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="33554432">
           <label> Svenska</label>
          </li>





            <li>
            <input type="checkbox" <?php if(in_array(8388608,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="8388608">
           <label> Tagalog</label>
         </li>
          
        
			  <li>
		  <input type="checkbox" <?php if(in_array(2048,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="2048">
           <label> Türkçe</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(268435456,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="268435456">
           <label> Čeština</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(262144,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="262144">
           <label> Ελληνικά</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(32,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="32">
            <label>Русский</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(1073741824,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="1073741824">
           <label> українська</label>
         </li>
            <li>
            <input type="checkbox" <?php if(in_array(1048576,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]"   value="1048576">
           <label> עברית</label>
        </li>
            <li>
            <input type="checkbox" <?php if(in_array(256,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="256">
           <label> العربية</label>
      </li>
            <li>
         <input type="checkbox" <?php if(in_array(65536,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="65536">
                         <label>  ภาษาไทย</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(128,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="128">
           <label> 中文</label>
          </li>
            <li>
            <input type="checkbox" <?php if(in_array(8,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="8">
           <label> 日本語</label>
         </li>
            <li>
            <input type="checkbox" <?php if(in_array(16384,$languages_knowns)) {?> checked="checked" <?php }?>  name="languages[]"   value="16384">
          <label>  한국어</label>
          </li>
		</div>
		</div>
		</div>
		<div class="panel-footer">
		
		<button class="btn btn-primary" data-dismiss="modal" type="button" id="language_ajax"> Save </button>
		<a class="btn btn-default pull-left" data-dismiss="modal" type="button">Close</a>
		
		</div>
		
		
</div><!-- /.modal -->
<script type="text/javascript">
function get_mobile_code(country_id)
{

 $.ajax({
type:'POST',
url:'<?php echo base_url();?>site/twilio/get_mobile_code',
data:{country_id:country_id},
dataType:'json',
success:function(response)
{
$('.pniw-number-prefix').text(response['country_mobile_code']);
//alert(response);
}
});
}
$('.toggle').click(function()
{
$('.emergncy-hide').slideToggle('slow');
});

$('#verify_sms').click(function()
{
var mobile_code=$('.pniw-number-prefix').text();
var phone_number=$('#phone_number').val();

if(phone_number =='')
{
alert('Please Enter Phone Number');
}
else if(isNaN(phone_number) || phone_number.length < 9)
{
alert('Phone Number Should be 10 Digit Number');
}
else{
$.ajax({
type:'POST',
url:'<?php echo base_url();?>site/twilio/product_verification',
data:{phone_no:phone_number,mobile_code:mobile_code},
success:function(response)
{
if(response=='success')
{
alert('We Have Sent Verification Code to Your Mobile Please Enter Verification Code');
$('.message_sent').text('We sent a verification code to '+phone_number);
$('.verification_div').css('display','block');
}
}
});
}
});

function cancel_verification()
{
$('.verification_div').css('display','none');
}

function check_phpone_verification()
{
 mobile_verification_code=$('#mobile_verification_code').val();
$.ajax({
type:'POST',
url:'<?php echo base_url()?>site/product/check_phone_verification',
data:{mobile_verification_code:mobile_verification_code},
success:function(response)
{ 
if(response=='success')
{
window.location.reload(true);
}
else{
alert('Verification Code Does not match Please enter Correct Code');
}

}
}); 

}


$(function()
{

$('#language_ajax').click(function()
{

var languages=document.getElementsByName('languages[]');

var languages_known=new Array();
for(var i=0;i<languages.length;i++)
{
if($(languages[i]).is(':checked'))
{
languages_known.push(languages[i].value);
}
}

if(languages_known.length>0)
{

$.ajax({
type:'POST',
url:'<?php echo base_url()?>site/user_settings/update_languages',
data:{languages_known:languages_known},
dataType:'json',
success:function(response)
{
if(response['status_code']==1)
{
// window.location.reload(false);
$('.inner_language').html();
}
}
});

}
})
});

function delete_languages(elem,language_code)
{
$.ajax({
type:'POST',
url:'<?php echo base_url()?>site/user_settings/delete_languages',
data:{language_code:language_code},
dataType:'json',
success:function(response)
{
if(response['status_code']==1)
{
$(elem).closest('li').remove();
//window.location.reload(true);
}
}
});
}
</script>   
<?php 
$this->load->view('site/templates/footer');
?>