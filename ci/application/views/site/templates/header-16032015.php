<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if($this->config->item('google_verification')){ echo stripslashes($this->config->item('google_verification')); }
if ($heading == ''){?>
<title><?php echo $title;?></title>
	<?php }else {?>
	<title><?php echo $heading;?></title>
	<?php }?>
	
<meta property="og:image" content="<?php echo base_url(); ?>images/logo/<?php echo $this->config->item('logo_image');?>"/>
<meta name="title" content="<?php echo $meta_title;?>" />
<meta name="keywords" content="<?php echo $meta_keyword; ?>" />
<meta name="description" content="<?php echo $meta_description; ?>" />
<meta name="viewport" content="width=device-width, user-scalable=no">
<link rel="shortcut icon" type="image/x-icon" href="images/logo/<?php echo $this->config->item('fevicon_image'); ?>">	
<base href="<?php echo base_url(); ?>" />
<?php 
	$by_creating_accnt = str_replace("{SITENAME}",$siteTitle);
	$this->load->view('site/templates/css_files',$this->data); 
?>
<script type="text/javascript" src="js/site/1.10.min.js"></script>
<script type="text/javascript" src="js/site/bootstrap.min.js"></script>
<script type="text/javascript" src="js/site/bootstrap.js"></script>
<script type="text/javascript" src="js/site/jquery.colorbox.js"></script>
<script type="text/javascript" src="js/site/jquery-ui.js"></script>
<?php
	$this->load->view('site/templates/script_files',$this->data);
?>
<link rel="stylesheet" type="text/css" href="css/site/twitter-bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/site/bootstrap-min.css">
<link rel="stylesheet" href="css/site/jquery-ui.css">
<link rel="stylesheet" media="all" href="css/main.css" type="text/css" />
<link rel="stylesheet" media="all" href="css/style.css" type="text/css" />
<link rel="stylesheet" media="all" href="css/ie8-css.css" type="text/css" />
<link rel="stylesheet" media="all" href="css/site/1.css" type="text/css" />


<link rel="stylesheet" href="css/site/style-responsive-only.css">
<link rel="stylesheet" href="css/site/style-responsive.css">


<!--[if lt IE 8]>
<script type="text/javascript" src="js/html5shiv/dist/html5shiv.js"></script>
<![endif]-->




<style type="text/css">
	 
.popup_header {
    background-color: #EFEFEF;
    border-bottom: 1px solid #DBDBDB;
    font-size: 15px;
    font-weight: bold;
	font-family:Arial, Helvetica, sans-serif;
	color:#393C3D;
    padding: 10px 15px;
}
.popup_sub_header {
    font-size: 13px;
    font-weight: normal;
	font-family:Arial, Helvetica, sans-serif;
	color:#393C3D;
    padding: 8px 0px;
}
.banner_signup {
    text-align:center;
	margin:20px;
}
.popup_facebook {
    background: url("images/facebook.png") no-repeat;
    color: #FFFFFF;
    cursor: pointer;
    display: inline-block;
    font-family:Arial, Helvetica, sans-serif;
    font-size: 14px;
    font-weight: bold !important;
    line-height: 37px;
    margin: 0;
    padding:0 35px 0 80px;
    text-indent: initial;
}

.popup_facebook:hover{
	 background: url("images/facebook.png") no-repeat;
	text-decoration:none;
}

.popup_signup_or {
    display: inline-block;
    margin: 10px 0;
    text-align: center;
    width: 100%;
}
.popup_page {
    background: none repeat scroll 0 0 #ffffff;
    overflow: hidden;
}
.popup_signup_or {
    display: inline-block;
    margin: 10px 0;
    text-align: center;
    width: 100%;
}

.btn.large {
    font-size: 16px;
}
.mail-btn {
    background: url("images/mail-bg.png") repeat-x scroll 0 0 rgba(0, 0, 0, 0) !important;
    border: 1px solid #1689c7 !important;
    border-radius: 2px !important;
    color: #fff;
    font-size: 14px !important;
    line-height: 17px !important;
    padding: 8px 0 !important;
    text-shadow: none !important;
    text-transform: capitalize;
    width: 275px;
}
.btn {
    -moz-user-select: none;
    border-radius: 2px;
    cursor: pointer;
    display: inline-block;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-weight: normal;
    line-height: 1.6;
    margin-bottom: 0;
    text-align: center;
    text-transform: none;
    vertical-align: middle;
    white-space: nowrap;
}
.btn {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #018fe1;
    background-image: -moz-linear-gradient(center top , #018fe1, #00aeff);
    background-repeat: repeat-x;
    border-color: #0195eb #0083c7 #0175b8;
    border-image: none;
    border-radius: 5px !important;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 0 0.2em rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.2), 0 0 0 #000;
    box-sizing: border-box;
    color: #ffffff;
    display: inline-block;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 12px;
    font-weight: bold;
    line-height: 16px;
    margin-bottom: 0;
    padding: 0.4em 1.8em;
    text-align: center;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.2);
    text-transform: uppercase;
    vertical-align: middle;
}
.btn-primary {
    background-color: #2badf3;
    background-image: -moz-linear-gradient(center top , #2badf3, #2492db);
    background-repeat: repeat-x;
    border: 1px solid #106fa9;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.18), 0 0 1px 1px rgba(255, 255, 255, 0.09) inset;
    color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.2);
}
.btn-large {
    font-size: 15px;
    padding: 9px 18px;
}
.btn-block {
    display: block;
    white-space: normal;
    width: 100%;
}
button, input[type="button"], input[type="reset"], input[type="submit"] {
    cursor: pointer;
}
button, input, select, textarea {
    font-size: 100%;
    margin: 0;
    vertical-align: middle;
}
button, input {
    line-height: normal;
}
label, input, button, select, textarea {
    font-size: 13px;
    font-weight: normal;
    line-height: 18px;
}
input, button, select, textarea {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}
.popup_page p {
    text-align: left !important;
}

.popup_stay {
    border-top: 1px solid #dbdbdb;
    color: #393c3d;
    display: inline-block;
    float: left;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 13px;
    margin: 0;
    padding: 10px 0 12px 20px !important;
    width: 100%;
}
.all-link {
    color: #00b0ff;
    font-size: 15px;
}
p {
    margin: 0;
    padding: 0;
}
a {
    outline: medium none;
}

.decorative-input {
    background-image: url("images/site/EMAIL.png");
    background-position: right 5px;
    background-repeat: no-repeat;
    box-sizing: border-box;
    display: block;
    font-size: 15px;
    height: 40px;
    line-height: 30px;
    padding: 0 10px;
    width: 95% !important;
}
input, textarea, select, .uneditable-input {
    background-color: #fff;
    border: 1px solid #cdcdcd;
    border-radius: 3px;
    box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.08) inset, 0 1px 0 0 #fff;
    color: #959595;
    display: inline-block;
    font-size: 13px;
    margin-bottom: 9px;
    padding: 6px 9px;
    width: 210px;
}
input, select, textarea {
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
}
button, input, select, textarea {
    font-size: 100%;
    margin: 0;
    vertical-align: middle;
}
button, input {
    line-height: normal;
}
label, input, button, select, textarea {
    font-size: 13px;
    font-weight: normal;
    line-height: 18px;
}
input, button, select, textarea {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}
input, textarea, select, .uneditable-input {
    border: 1px solid #f29b39;
    border-radius: 3px;
    color: #5a5a5a;
    display: inline-block;
    font-size: 13px;
    line-height: 18px;
    margin-bottom: 9px;
    padding: 4px;
    width: 210px;
}
.decorative-input1 {
    background-image: url("images/site/lock.png");
    background-position: right 5px;
    background-repeat: no-repeat;
    box-sizing: border-box;
    display: block;
    font-size: 15px;
    height: 40px;
    line-height: 30px;
    padding: 0 10px;
    width: 95% !important;
}
.all-link1 {
    color: #00b0ff;
    float: right;
    font-size: 13px;
    margin: 10px 0;
}
button, input {
    line-height: normal;
}

input, textarea, select, .uneditable-input {
    background-color: #fff;
    border: 1px solid #cdcdcd;
    border-radius: 3px;
    box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.08) inset, 0 1px 0 0 #fff;
    color: #959595;
    display: inline-block;
    font-size: 13px;
    margin-bottom: 9px;
    padding: 6px 9px;
    width: 210px;
}


#cboxClose {
  right: -4px;
     top: 3px;}
</style>
	 
<script>
jQuery.fn.extend({
 propAttr: $.fn.prop || $.fn.attr
});
$(function() {

$("#autocomplete,#city_landing").autocomplete({
source: function( request, response ) {
		$( "#autoCompImg" ).show();
        $.ajax({
            url: "<?php echo base_url();?>site/landing/home_search_auto",
            dataType: "json",
            data: {
			term : request.term,
            tableName : "city"
			},
            success: function(data) {
                    response(data);
					$( "#autoCompImg" ).hide();
            }
        });
    },
	change: function (event, ui) {
            if (!ui.item) {
                this.value = '';
            }
        },
		select: function(event,ui){
		
		var city=ui.item.value;
		city=city.replace(" ", "+");
		if($(this).attr('id')=='autocomplete')
		{
		window.location='<?php echo base_url()?>property?city='+city+'';
		}
		
        
    },
	min_length: 10,
    delay: 1

});
});
</script>
<!-- Autosuggestion Script End-->
    
</head>

<body <?php if($this->uri->segment(1) == 'property' ){echo 'onload="initialize()"'; } ?>>
<?php if (is_file('google-login-mats/index.php'))
{
	require_once 'google-login-mats/index.php';
}
$newAuthUrl = $authUrl;
$userdata = array('newAuthUrl'=>$newAuthUrl);
$this->session->set_userdata($userdata);

//echo $this->session->userdata('rUrl');

if($this->session->userdata('rUrl') != '')
{
$reUrl = $this->session->userdata('rUrl');
$this->session->unset_userdata('rUrl');
redirect ($reUrl);
}
		
?>
<!-- Popup_signin_start -->
<div style='display:none'>

  <div id='inline_login' style='background:#fff;'>
		<div id="login_error" style="background:grey; display:none;"></div>
  		<div class="popup_page">
 
  			<div class="popup_header"><?php if($this->lang->line('login') != '') { echo stripslashes($this->lang->line('login')); } else echo "Log in"; ?></div>
            
			<script>
			function fbLogon()
			{
				<?php 
				$pageURL = 'http';
				if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
				$pageURL .= "://";
				if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				}
				?>
				$.ajax(
				{
				type: 'POST',
				url: "<?php echo base_url();?>site/landing/fbLogin",
				data: { rUrl : "<?php echo $pageURL;?>" },
				success: function(data) 
				{		
					window.location.href='<?php echo base_url()."facebook/user.php"; ?>';
				}
				});
			}
			function gglLogon()
			{
				<?php 
				$pageURL = 'http';
				if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
				$pageURL .= "://";
				if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				}
				?>
				$.ajax(
				{
				type: 'POST',
				url: "<?php echo base_url();?>site/landing/fbLogin",
				data: { rUrl : "<?php echo $pageURL;?>" },
				success: function(data) 
				{		
					window.location.href='<?php echo $authUrl; ?>';
				}
				});
			}
			</script>
			
            <div class="popup_detail">
            
            	<div class="banner_signup">
                            	
                                <a href="javascript:void(0);" onclick="fbLogon();" class="popup_facebook"><?php if($this->lang->line('login_facebook') != '') { echo stripslashes($this->lang->line('login_facebook')); } else echo "Login with Facebook"; ?></a>
                                	
                                 <a href="javascript:void(0);" class="popup_google" onclick="gglLogon();"><?php if($this->lang->line('login_google') != '') { echo stripslashes($this->lang->line('login_google')); } else echo "Login with Google"; ?></a>
								 <span class="popup_signup_or"><?php if($this->lang->line('header_or') != '') { echo stripslashes($this->lang->line('header_or')); } else echo "OR"; ?></span>
                                 
                                 <input type="text" name="email" id="signin_email_address" value="" class="decorative-input" placeholder="<?php if($this->lang->line('header_enter_email') != '') { echo stripslashes($this->lang->line('header_enter_email')); } else echo "Email Address"; ?>" onblur="if(this.value=='')this.value=this.defaultValue;"  />
                                 
                                 <input type="password" id="signin_password"  placeholder="<?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?>" value="" class="decorative-input1" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                 
								 <input type="hidden" name="bpath" id="bpath" value="<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>" />
								 
                                <span class="popup_stay"><input class="check" id="remember" type="checkbox" /><?php if($this->lang->line('Remember_Me') != '') { echo stripslashes($this->lang->line('Remember_Me')); } else echo "Remember Me";?></span>
                                 <a href="javascript:void(0);" class="all-link1 forgot-popup"><?php if($this->lang->line('forgot_passsword') != '') { echo stripslashes($this->lang->line('forgot_passsword')); } else echo "Forgot Password"; ?>?</a>
                                 <button class="btn btn-block btn-primary large btn-large padded-btn-block" type="submit" onclick="javascript:signin();" id="signin_click" ><?php if($this->lang->line('log in') != '') { echo stripslashes($this->lang->line('log in')); } else echo "Log in"; ?></button>
                                 <span class="popup_stay"><?php if($this->lang->line('dont_account') != '') { echo stripslashes($this->lang->line('dont_account')); } else echo "Don't have an account?"; ?><a href="javascript:void(0);" style="font-size:13px; margin:0 0 0 3px" class="all-link reg-popup"><?php if($this->lang->line('login_signup') != '') { echo stripslashes($this->lang->line('login_signup')); } else echo "Create  Account"; ?></a></span>
                            </div>
                    
                    	
            </div>
     
        </div>
        
  </div>
  
</div>

<div style='display:none'>

  <div id='inline_reg' style='background:#fff;'>
  
  		<div class="popup_page">
  
  			<div class="popup_header"><?php if($this->lang->line('login_signup') != '') { echo stripslashes($this->lang->line('login_signup')); } else echo "Create  Account"; ?></div>
            
            <div class="popup_detail">
            
            	<div class="banner_signup">
                            	
                                           	
                                <a class="popup_facebook" onclick="window.location.href='<?php echo base_url().'facebook/user.php'; ?>'"><?php if($this->lang->line('facebook_signup') != '') { echo stripslashes($this->lang->line('facebook_signup')); } else echo "Sign Up with Facebook"; ?></a>
                                <a class="popup_google" onclick="window.location.href='<?php echo $authUrl; ?>'"><?php if($this->lang->line('signup_google') != '') { echo stripslashes($this->lang->line('signup_google')); } else echo "Sign Up with Google"; ?></a>
                                	
                                 <span class="popup_signup_or"><?php if($this->lang->line('header_or') != '') { echo stripslashes($this->lang->line('header_or')); } else echo "OR"; ?></span>
                                 <button class="btn btn-block btn-primary large btn-large padded-btn-block mail-btn register-popup" type="submit"><?php if($this->lang->line('signup_email') != '') { echo stripslashes($this->lang->line('signup_email')); } else echo "Sign up with Email"; ?></button>
                                 <p style="font-size:11px; margin:10px 0"><?php if($this->lang->line('signup_cont1') != '') { echo stripslashes($this->lang->line('signup_cont1')); } else echo 'By Signing up, you confirm that you accept the';?> <a target="_blank" data-popup="true" href="pages/privacy-policy"><?php if($this->lang->line('header_terms_service') != '') { echo stripslashes($this->lang->line('header_terms_service')); } else echo "Terms of Service";?></a> <?php if($this->lang->line('header_and') != '') { echo stripslashes($this->lang->line('header_and')); } else echo "and"; ?> <a target="_blank" data-popup="true" href="pages/policy"><?php if($this->lang->line('header_privacy_policy') != '') { echo stripslashes($this->lang->line('header_privacy_policy')); } else echo "Privacy Policy";?></a>.</p>
                    </div>
                    </div>
        		<span class="popup_stay"><?php if($this->lang->line('already_member') != '') { echo stripslashes($this->lang->line('already_member')); } else echo "Already a member?";?><a href="javascript:void(0);" style="font-size:13px; margin:0 0 0 3px" class="all-link login-popup"><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "Log in"; ?></a></span>
        </div>
        
  </div>
  
</div>

<!-- contact me popupwindow -->
<!-- contact me popupwindow -->


<div style='display:none'>

  <div id='inline_register' style='background:#fff;'>
  
  		<div class="popup_page">
  
  			<div class="popup_header"><?php if($this->lang->line('login_signup') != '') { echo stripslashes($this->lang->line('login_signup')); } else echo "Create Account"; ?></div>
            
            <div class="popup_detail">
            
            	<div class="banner_signup">
                                           	
                                <a class="popup_facebook" onclick="window.location.href='<?php echo base_url().'facebook/user.php'; ?>'"><?php if($this->lang->line('facebook_signup') != '') { echo stripslashes($this->lang->line('facebook_signup')); } else echo "Sign up with Facebook"; ?></a>
                               	
								<a class="popup_google" onclick="window.location.href='<?php echo $authUrl; ?>'"><?php if($this->lang->line('signup_google') != '') { echo stripslashes($this->lang->line('signup_google')); } else echo "Sign up with Google"; ?></a>
                                 <span class="popup_signup_or">(<?php if($this->lang->line('header_or') != '') { echo stripslashes($this->lang->line('header_or')); } else echo "OR"; ?>)</span>
                                 
                                 <input type="text" id="first_name" value="<?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "First name"; ?>" class="decorative-input2" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                 <input type="text" id="last_name" value="<?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Last name"; ?>" class="decorative-input2" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                 
                                 <input type="text" id="email" value="<?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address"; ?>" class="decorative-input" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                 
                                 <input type="password" id="password" value=""  placeholder="<?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?>" class="decorative-input1" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                  <input type="password" id="cnf_password"  placeholder="<?php if($this->lang->line('change_conf_pwd') != '') { echo stripslashes($this->lang->line('change_conf_pwd')); } else echo "Confirm Password"; ?>" value="" class="decorative-input1" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                  
                                 <div class="test" style="float:left; width:100%; margin:5px 0"> <input type="checkbox" checked="checked" id="checkbox" style="float:left; width:auto; margin:0 5px 0 0px" /><label class="news-stay" style="float:left"><?php if($this->lang->line('staynest_news') != '') { echo stripslashes($this->lang->line('staynest_news')); } else echo "Tell me about Holidan news";?> </label></div>
                                 
                                

<p style="font-size:11px; text-align:left; margin:10px 0"><?php if($this->lang->line('simplesignup_cont1') != '') { echo stripslashes($this->lang->line('simplesignup_cont1')); } else echo 'By clicking "Sign up" you confirm that you accept the';?> <a data-popup="true" href="pages/privacy-policy"><?php if($this->lang->line('header_terms_service') != '') { echo stripslashes($this->lang->line('header_terms_service')); } else echo "Terms of Service";?></a> <?php if($this->lang->line('header_and') != '') { echo stripslashes($this->lang->line('header_and')); } else echo "and"; ?> <a data-popup="true" href="pages/policy"><?php if($this->lang->line('header_privacy_policy') != '') { echo stripslashes($this->lang->line('header_privacy_policy')); } else echo "Privacy Policy";?></a>.</p>
<br />




                                 
                                 <button type="submit" class="btn btn-block btn-primary large btn-large padded-btn-block register-popup cboxElement" onclick="javascript:register_user();" ><?php if($this->lang->line('login_signup') != '') { echo stripslashes($this->lang->line('login_signup')); } else echo "Create Account"; ?></button>
								 
								 <div class="remembr">
								 <input class="new-chek" type="checkbox"><span class="remember-me"><?php if($this->lang->line('Remember_Me') != '') { echo stripslashes($this->lang->line('Remember_Me')); } else echo "Remember Me";?></span>
								 </div>
                                 <span class="popup_stay"><?php if($this->lang->line('already_member') != '') { echo stripslashes($this->lang->line('already_member')); } else echo "Already member?";?><a href="javascript:void(0);" style="font-size:13px; margin:0 0 0 3px" class="all-link login-popup"><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "log in"; ?></a></span>
                            </div>
                    
                    	
            </div>
        
        </div>
        
  </div>
  
</div>

<div style='display:none'>

  <div id='inline_forgot' style='background:#fff;'>
  
  		<div class="popup_page">
  
  			<div class="popup_header"> <?php if($this->lang->line('forgot_reset_pwd') != '') { echo stripslashes($this->lang->line('forgot_reset_pwd')); } else echo "Reset Password";?> </div>
            
            <div class="popup_detail">
            
            	<div class="banner_signup">
                            	<p style="font-size:12px; text-align:left; margin:10px 0"><?php if($this->lang->line('contant_reset_pwd') != '') { echo stripslashes($this->lang->line('contant_reset_pwd')); } else echo "Enter the email address associated with your account, and we'll email you a link to reset your password.";?></p>
                                
                                 <input type="text" id="forgot_email" value="" placeholder="<?php if($this->lang->line('header_enter_email') != '') { echo stripslashes($this->lang->line('header_enter_email')); } else echo "Email Address"; ?>" class="decorative-input" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                 
                              <button class="btn btn-primary" style="height:25px;" type="submit" onclick="javascript:forgot_password();" >
							  <span id="load-img-forgot" style="display:none;">
							  <img src="images/ajax-loader/ajax-loader(2).gif" alt="Loading..." />
							  </span>
							  <?php if($this->lang->line('send_reset_pwd') != '') { echo stripslashes($this->lang->line('send_reset_pwd')); } else echo "Send Reset Link";?></button>
                               
                            </div>
                    
                    	
            </div>
        
        </div>
        
  </div>
  
</div>


<!-- Popup_signin_ends -->

<header>
<input type="hidden" value="" name="login_checked_status" id="login_checked_status">
	<div class="header" style="height:98px !impoertant;">
	<div class="container2">
		<div class="col-md-7">
			<div class="logo-container">
        <h1 class="logo"><a href="<?php echo base_url();?>"><img src="images/logo/<?php echo $this->config->item('logo_image');?>" alt=""></a></h1>
        <div class="inpt-head-place"><input type="text" style="width: 85%;" class="auto-tet" placeholder="<?php if($this->lang->line('search_where') != '') { echo stripslashes($this->lang->line('search_where')); } else echo "Where do you want to go?"; ?>" id="autocomplete">
			<div id="autoCompImg" style="float: right; margin: 15px; display:none;"><img src="images/ajax-loader/ajax-loader.gif" alt="Loading..."></div>
         </div>
       <div class="brows-loop"> <label class="browse"><?php if($this->lang->line('shop_browse') != '') { echo stripslashes($this->lang->line('shop_browse')); } else echo "Browse"; ?><i class="caret"></i>
<ul class="showlist2 useclas">
<span class="ard"></span>
<li><a href="popular"><?php if($this->lang->line('popular') != '') { echo stripslashes($this->lang->line('popular')); } else echo "Popular"; ?></a></li>
<?php if($loginCheck!='') { ?>
 <li><a href="browsefriends"><?php if($this->lang->line('header_Friends') != '') { echo stripslashes($this->lang->line('header_Friends')); } else echo "Friends"; ?></a></li> 
 <li><a href="users/<?php echo $userDetails->row()->id; ?>/wishlists"><?php if($this->lang->line('header_wishlist') != '') { echo stripslashes($this->lang->line('header_wishlist')); } else echo "My Wish Lists"; ?></a></li>
<?php } ?> 
</ul></label>
</div>

			</div></div>


		<div class="col-md-5">
      <div style="margin:0" class="navbar">
        <div class="navbar-inner">
            
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span><?php if($this->lang->line('header_Menu') != '') { echo stripslashes($this->lang->line('header_Menu')); } else echo "Menu"; ?></span>
			<span class="icon-bar"></span>
			
            </a>
            <div class="nav-collapse navbar-collapse my-nav">
			
                <ul class="nav">
				<?php if ($loginCheck == ''){?> 
                   <!-- <li ><a href="javascript:void(0);" class="reg-popup">sign up</a></li> -->
				   
				   <li ><a href="javascript:void(0);" class="reg-popup"><?php if($this->lang->line('signup') != '') { echo stripslashes($this->lang->line('signup')); } else echo "sign up"; ?></a></li>
                    
					<!-- <li><a href="javascript:void(0);" class="login-popup">login</a></li> -->
					<li ><a href="javascript:void(0);" class="login-popup"><?php if($this->lang->line('login') != '') { echo stripslashes($this->lang->line('login')); } else echo "login"; ?></a></li>
					
                    <li><a href="pages/help" ><?php if($this->lang->line('footer_follow_help') != '') { echo stripslashes($this->lang->line('footer_follow_help')); } else echo "Help"; ?></a>
				 <ul class="showlist2" >
                	<?php $cmsList = unserialize($cmsList_serial); 
						if ($cmsList->num_rows() > 0){
							foreach ($cmsList->result() as $row){
								if($row->hidden_page == 'No' && $row->category == 'Sub' && $row->parent == '71') {
						?>
        	   <li><a href="pages/<?php echo $row->seourl; ?>"><?php echo $row->page_name;?></a></li> <?php } } } ?>
                </ul>
					</li>
					<?php }else {?>
					
               <div class="browse_div2" id="broswe_box1">
            	 <a href="javascript:void(0);"><img width="20" src="<?php if($userDetails->row()->loginUserType == 'google'){ echo $userDetails->row()->image;} elseif($userDetails->row()->image == '' ){ echo base_url();?>images/site/profile.png<?php } else { echo base_url().'images/users/'.$userDetails->row()->image;}?>" style="float:left; margin:0 5px;" id="showlist_test" alt=""/><label class="user-name"><?php if($this->lang->line('login_hi') != '') { echo stripslashes($this->lang->line('login_hi')); } else echo "Hi"; ?><?php echo " ".$userDetails->row()->firstname.$userDetails->row()->lastname;?></label><i class="caret"></i></a>              
                <ul class="showlist3" >
                    <span class="ard"></span>
                    <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('header_dashboard') != '') { echo stripslashes($this->lang->line('header_dashboard')); } else echo "Dashboard"; ?></a></li>
                    <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('header_listing') != '') { echo stripslashes($this->lang->line('header_listing')); } else echo "Your Listings"; ?></a></li>
					<li><a href="<?php echo base_url();?>listing-reservation"><?php if($this->lang->line('your_reservations') != '') { echo stripslashes($this->lang->line('your_reservations')); } else echo "Your Reservations"; ?></a></li>
                    <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('your_trips') != '') { echo stripslashes($this->lang->line('your_trips')); } else echo "Your Trips"; ?></a></li>
					<li><a href="users/<?php echo $loginCheck;?>/wishlists"><?php if($this->lang->line('wish_list') != '') { echo stripslashes($this->lang->line('wish_list')); } else echo "Wish List"; ?></a></li>
                    <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('settings_edit_prof') != '') { echo stripslashes($this->lang->line('settings_edit_prof')); } else echo "Edit Profile"; ?></a></li>
                    <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('referrals_account') != '') { echo stripslashes($this->lang->line('referrals_account')); } else echo "Account"; ?></a></li>
                    <li><a href="logout"><?php if($this->lang->line('header_signout') != '') { echo stripslashes($this->lang->line('header_signout')); } else echo "Log Out"; ?></a></li>
                </ul>
               
          </div>
		  
		   <div class="browse_di">
                 <?php 
				 $result = 0;
				 if($userDetails->row()->id != '') {
				 $this->db->select('*');
				 $this->db->from(DISCUSSION);
				 $this->db->where('receiver_id',$userDetails->row()->id);
				 $this->db->where('msg_read','no');
				 $result = $this->db->get()->num_rows();
				 //$this->db->last_query();die;
				 }
				 
				 if($result == 0){?>
                <a href="<?php echo base_url();?>inbox"><img src="images/site/mail.png" alt="" /></a>
				<?php } else {?>
				<a href="<?php echo base_url();?>inbox"><img src="images/site/mail-unread.png" alt="" /></a>
				<?php }?>
				
           </div> 
                    
					<?php }?>
					<li><a class="request-trip" href="list_space"><?php if($this->lang->line('list_your') != '') { echo stripslashes($this->lang->line('list_your')); } else echo "List Your Space";?></a></li>
                </ul>
				
            </div>
        </div>
    </div>

	</div>



</div>
</div>
</header>
                   <?php if($flash_data != '') {?>
                    <div class="errorContainer" id="<?php echo $flash_data_type;?>">
                        <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 4000);</script>
                        <p style="color:#000000; font-size:16px;"><span><?php echo $flash_data;?></span></p>
                    </div>
                    <?php } ?>
<!---HEADER-->
                 
					<script type="text/javascript">
					function showView()
					{
					//alert($(this).attr('class'));
                    if($('.showlist3').css('display')=='none')
					{
					$('.showlist3').css('display','block')
					}
					}
					
      $('body').click(function(){    
				   if($(this).attr('id')!= "showlist_test")
				   {
				   //alert();
				   $('.showlist3').css('display','none')
				   }
				  
          
            });
			
$('#signin_email_address,#signin_password').keypress(function(e)
{
if(e.keyCode == 13)$( "#signin_click" ).click();
});			
</script>
<!--<script src="https://code.jquery.com/jquery-migrate-1.0.0.js"></script>-->

<script>

$(document).ready(function(){
  $("body").scroll(function(){
    $(".header").addClass("important blue");
  });
});
</script>

<?php if(($this->uri->segment(1)=='pages' && $this->uri->segment(2)=='about-us') || $this->uri->segment(1)=='contact-us' || $this->uri->segment(1)=='business-travel'){?>
<div class="dashboard yourlisting dash-home bgcolor">

<div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li <?php if ($this->uri->segment(1)=='pages'){?>class="active"<?php }?>><a href="pages/about-us">About Us</a></li>
                <li <?php if ($this->uri->segment(1)=='contact-us'){?>class="active"<?php }?>><a href="contact-us">Contact Us</a></li>
                <li <?php if ($this->uri->segment(1)=='business-travel'){?>class="active"<?php }?>><a href="business-travel">Business Travel</a></li>
				<li></li>
    </ul> </div></div>
</div>
<?php }?>
<?php if($this->uri->segment(1)=='pages' && ($this->uri->segment(2)=='live-like-locals' || $this->uri->segment(2)=='learn-more-about-hosting' || $this->uri->segment(2)=='how-it-works')){?>
<div class="dashboard yourlisting dash-home bgcolor">

<div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li <?php if ($this->uri->segment(2)=='live-like-locals'){?>class="active"<?php }?>><a href="pages/live-like-locals"><?php if($this->lang->line('Live_Like') != '') { echo stripslashes($this->lang->line('Live_Like')); } else echo "Live Like Locals";?></a></li>
                <li <?php if ($this->uri->segment(3)=='learnmore'){?>class="active"<?php }?>><a href="site/cms/learnmore">Learn more about hosting</a></li>
                <li <?php if ($this->uri->segment(3)=='howitwork'){?>class="active"<?php }?>><a href="site/cms/howitwork">How it works</a></li>
				<li></li>
    </ul> </div></div>
</div>
<?php }?>
<?php if($this->uri->segment(1)=='pages' && ($this->uri->segment(2)=='faq' || $this->uri->segment(2)=='policy' || $this->uri->segment(2)=='privacy-policy' )){?>
<div class="dashboard yourlisting dash-home bgcolor">

<div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li <?php if ($this->uri->segment(2)=='faq'){?>class="active"<?php }?>><a href="pages/faq">Frequently Asked Question</a></li>
                <li <?php if ($this->uri->segment(2)=='policy'){?>class="active"<?php }?>><a href="pages/policy">Policy</a></li>
                <li <?php if ($this->uri->segment(2)=='privacy-policy'){?>class="active"<?php }?>><a href="pages/privacy-policy">Terms & Privacy</a></li>
				<li></li>
    </ul> </div></div>
</div>
<?php }?>


<?php if($this->uri->segment(3)=='learnmore' || $this->uri->segment(3)=='howitwork'){?>
<div class="dashboard yourlisting dash-home bgcolor">

<div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li <?php if ($this->uri->segment(2)=='live-like-locals'){?>class="active"<?php }?>><a href="pages/live-like-locals">Live like locals</a></li>
                <li <?php if ($this->uri->segment(3)=='learnmore'){?>class="active"<?php }?>><a href="site/cms/learnmore">Learn More about Hosting</a></li>
                <li <?php if ($this->uri->segment(3)=='howitwork'){?>class="active"<?php }?>><a href="site/cms/howitwork">How it works</a></li>
				<li></li>
    </ul> </div></div>
</div>
<?php }?>




