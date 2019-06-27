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
<style type="text/css">



#submitbutton{
margin-left: 320px;
margin-top: 5px;
width: 90px;

}


</style>
<!-- script end -->

<!---DASHBOARD-->
<div class="dashboard yourlisting photos bgcolor">

<div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></li>
                <li class="active"><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul> </div></div>
	<div class="main">
    	<div id="command_center">
    
             <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></li>
                <li class="active"><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li ><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul> 
            <div class="dashboard-sidemenu">    <ul class="subnav">
                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('EditProfile') != '') { echo stripslashes($this->lang->line('EditProfile')); } else echo "Edit Profile";?></a></li>
				<li class="active" ><a href="<?php echo base_url();?>display-review"><?php if($this->lang->line('photos') != '') { echo stripslashes($this->lang->line('photos')); } else echo "Photos";?></a></li>
				<li ><a href="<?php echo base_url();?>verification"><?php if($this->lang->line('TrustandVerification') != '') { echo stripslashes($this->lang->line('TrustandVerification')); } else echo "Trust and Verification";?></a></li>
                <li ><a href="<?php echo base_url();?>display-review"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></a></li>

				 <a class="invitefrds" href="users/show/<?php echo $userDetails->row()->id;?>"><?php if($this->lang->line('ViewProfile') != '') { echo stripslashes($this->lang->line('ViewProfile')); } else echo "View Profile";?></a>
				</div>
                          
            </ul>
			
			<div class="listiong-areas">
            	<div id="account">
    <div class="box">
      <div class="middle">
			


         
  				<h1><?php echo $heading;?></h1>
               
                 <div class="section notification_section" style="width:100%;">
				 
				 
				 <div class="img-left-section">
				 <div class="left-img-container">
				 <?php if(!empty($userDetails) && $userDetails->row()->image!=''){ ?>
					<img src="images/users/<?php echo $userDetails->row()->image; ?>" />
                    <?php } ?>
					
				 </div><!--<span style="color: red; float: left; font-weight: normal; font-size: 11px; padding: 9px 0px 0px;">Please Upload the Image Size 247 X 240(w X h)</span>-->
				 </div>
				  <div class="img-right-section">
				  <p><?php if($this->lang->line('Clearfrontal') != '') { echo stripslashes($this->lang->line('Clearfrontal')); } else echo "Clear frontal face photos are an important way for hosts and guests to learn about each other. It's not much fun to host a landscape! Please upload a photo that clearly shows your face.";?></p>
					<div class="button-grops">
					
					<button style="display:none" class="take-photo-btn"><?php if($this->lang->line('TakeaPhoto') != '') { echo stripslashes($this->lang->line('TakeaPhoto')); } else echo "Take a Photo With Your Webcam";?></button>
				
					<center><button class="take-photo-btn"><?php if($this->lang->line('Uploadafile') != '') { echo stripslashes($this->lang->line('Uploadafile')); } else echo "Upload a file from your computer";?> </button></center>
					<form class="myform" id="profile_settings_form" method="post" action="photo-video" enctype="multipart/form-data" onSubmit="return profileUpdate();">
					<div class="upload-file">
					<input id="uploadavatar" required class="hidden-file" name="upload-file" type="file">
					
				  </div>
				 <input style="margin-left:155px;" type="submit" value="<?php if($this->lang->line('SaveSetting') != '') { echo stripslashes($this->lang->line('SaveSetting')); } else echo "Save Settings";?>"  name="commit" class="blu-btn">
				 </form>
				 
					</div> 
  	       <div id="div-form" style="border:1px solid #000;">
  		
        
            
        
        
        </div> <!-- form befor div closed -->
					
  	       
  			 
          </div>
		  </div>
			  
    <div class="clearfix"></div>
      </div>
    </div>
  </div>
  </div>
         
  </div>
    </div>
</div>
<!---DASHBOARD-->
<?php 
$this->load->view('site/templates/footer');
?>