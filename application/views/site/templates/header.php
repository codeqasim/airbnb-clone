<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php if($this->config->item('google_verification')){ echo stripslashes($this->config->item('google_verification')); }if ($heading == ''){?>
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
    <?php 	$by_creating_accnt = str_replace("{SITENAME}",$siteTitle);	$this->load->view('site/templates/css_files',$this->data); ?>
    <script type="text/javascript" src="js/site/1.10.min.js"></script>
    <script type="text/javascript" src="js/site/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/site/bootstrap.js"></script>
    <script type="text/javascript" src="js/site/jquery.colorbox.js"></script>
    <script type="text/javascript" src="js/site/jquery-ui.js"></script>
    <?php	$this->load->view('site/templates/script_files',$this->data);?>
    <link rel="stylesheet" type="text/css" href="css/site/bs.css">
    <link rel="stylesheet" media="all" href="css/main.css" type="text/css" />
    <link rel="stylesheet" media="all" href="css/style.css" type="text/css" />
    <link rel="stylesheet" media="all" href="css/font-awesome.css" type="text/css" />
    <link rel="stylesheet" href="css/style_common.css">
    <link rel="stylesheet" href="css/style7.css">
    <link rel="stylesheet" media="all" href="css/help-style.css" type="text/css" />
    <!--[if lt IE 8]>
    <script type="text/javascript" src="js/html5shiv/dist/html5shiv.js"></script>
    <![endif]-->
    <style type="text/css">
     .showlist3 li:hover a {
      text-decoration: none;
      }
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
      .pac-container:after{
    content:none !important;
      }
      .right-arel label input {
    float: left;
}
.right-arel label span {
    color: #4c4c4c;
    float: left;
    font-family: opensansregular;
    padding: 0 0 0 7px;
}
    </style>
    <link rel="stylesheet" media="all" href="css/bug-fixed.css" type="text/css" />
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
  <body <?php if($this->uri->segment(1) == 'property' ){echo 'onload="initialize();"'; } else {echo 'onload="initializeMap()"';} ?>>
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
    <!--<link rel="stylesheet" type="text/css" media="all" href="css/new-customization.css" />-->
    <!-- Popup_signin_start -->
    <div style='display:none'>
      <div id='inline_login' style='background:#fff;'>
        <div id="login_error" style="background:grey; display:none;"></div>
        <div class="popup_page">
          <div class="popup_header"><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "Log in"; ?></div>
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
              <?php
                $facebook_id = $this->config->item('facebook_app_id');
                $facebook_secert = $this->config->item('facebook_app_secret');
                $linkedin_id = $this->config->item('linkedin_app_id');
                $linkedin_secert = $this->config->item('linkedin_app_key');
                $google_id = $this->config->item('google_client_id');
                $google_secert = $this->config->item('google_client_secret'); ?>
              <?php if ($facebook_id !='' && $facebook_secert !='') { ?>
              <a href="javascript:void(0);" onclick="fbLogon();" class="popup_facebook"><?php if($this->lang->line('login_facebook') != '') { echo stripslashes($this->lang->line('login_facebook')); } else echo "Login with Facebook"; ?></a>
              <?php } if($linkedin_id !='' && $linkedin_secert !='') { ?>
              <a href="<?php echo base_url();?>site/invitefriend/login" class="popup_linkedin" ><?php if($this->lang->line('login_linkedin') != '') { echo stripslashes($this->lang->line('login_linkedin')); } else echo "Login with Linkedin"; ?></a>
              <?php } if($google_id !='' && $google_secert !='') { ?>
              <a href="javascript:void(0);" class="popup_google" onclick="gglLogon();"><?php if($this->lang->line('login_google') != '') { echo stripslashes($this->lang->line('login_google')); } else echo "Login with Google"; ?></a>
              <?php } ?>
              <span class="popup_signup_or">OR</span>
              <input type="text" name="email" id="signin_email_address" value="" class="decorative-input" placeholder="<?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address"; ?>" onblur="if(this.value=='')this.value=this.defaultValue;"  />
              <input type="password" id="signin_password"  placeholder="<?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?>" value="" class="decorative-input1" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
              <input type="hidden" name="bpath" id="bpath" value="<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>" />
              <span class="popup_stay"><input class="check" id="remember" type="checkbox" /><?php if($this->lang->line('remember_me') != '') { echo stripslashes($this->lang->line('remember_me')); } else echo "Remember Me";?></span>
              <a href="javascript:void(0);" class="all-link1 forgot-popup"><?php if($this->lang->line('forgot_passsword') != '') { echo stripslashes($this->lang->line('forgot_passsword')); } else echo "Forgot Password"; ?>?</a>
              <button class="btn btn-block btn-primary large btn-large padded-btn-block" type="submit" onclick="javascript:signin();" id="signin_click" ><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "Log in"; ?></button>
              <span style="margin-bottom:15px" class="popup_stay"><?php if($this->lang->line('dont_account') != '') { echo stripslashes($this->lang->line('dont_account')); } else echo "Don't have an account?"; ?><a href="javascript:void(0);" style="font-size:13px; margin:0 0 0 3px" class="all-link reg-popup"><?php if($this->lang->line('login_signup') != '') { echo stripslashes($this->lang->line('login_signup')); } else echo "Create Account"; ?></a></span>

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
              <?php if ($facebook_id !='' && $facebook_secert !='') { ?>
              <a class="popup_facebook" onclick="window.location.href='<?php echo base_url().'facebook/user.php'; ?>'"><?php if($this->lang->line('facebook_signup') != '') { echo stripslashes($this->lang->line('facebook_signup')); } else echo "Sign Up with Facebook"; ?></a>							<?php }							if($linkedin_id !='' && $linkedin_secert !='') { ?>																<a href="<?php echo base_url();?>site/invitefriend/login" class="popup_linkedin" ><?php if($this->lang->line('signup_linkedin') != '') { echo stripslashes($this->lang->line('signup_linkedin')); } else echo "Sign Up with Linkedin"; ?></a>								<?php }							if($google_id !='' && $google_secert !='') { ?>
              <a class="popup_google" onclick="window.location.href='<?php echo $authUrl; ?>'"><?php if($this->lang->line('signup_google') != '') { echo stripslashes($this->lang->line('signup_google')); } else echo "Sign Up with Google"; ?></a>								<?php } ?>
              <span class="popup_signup_or">OR</span>
              <button class="btn btn-block btn-primary large btn-large padded-btn-block mail-btn register-popup" type="submit"><?php if($this->lang->line('signup_email') != '') { echo stripslashes($this->lang->line('signup_email')); } else echo "Sign up with Email"; ?></button>
              <p style="font-size:11px; margin:10px 0"><?php if($this->lang->line('signup_cont1') != '') { echo stripslashes($this->lang->line('signup_cont1')); } else echo 'By Signing up, you confirm that you accept the';?> <a target="_blank" data-popup="true" href="pages/terms-of-service"><?php if($this->lang->line('header_terms_service') != '') { echo stripslashes($this->lang->line('header_terms_service')); } else echo "Terms of Service";?></a> <?php if($this->lang->line('header_and') != '') { echo stripslashes($this->lang->line('header_and')); } else echo "and"; ?> <a target="_blank" data-popup="true" href="pages/privacy-policy"><?php if($this->lang->line('header_privacy_policy') != '') { echo stripslashes($this->lang->line('header_privacy_policy')); } else echo "Privacy Policy";?></a>.</p>
            </div>
          </div>
          <span style="margin-bottom:10px;margin-top:10px" class="popup_stay"><?php if($this->lang->line('already_member') != '') { echo stripslashes($this->lang->line('already_member')); } else echo "Already a member?";?><a href="javascript:void(0);" style="font-size:13px; margin:0 0 0 3px" class="all-link login-popup"><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "Log in"; ?></a></span>
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
              <?php if ($facebook_id !='' && $facebook_api !='') { ?>
              <a class="popup_facebook" onclick="window.location.href='<?php echo base_url().'facebook/user.php'; ?>'"><?php if($this->lang->line('facebook_signup') != '') { echo stripslashes($this->lang->line('facebook_signup')); } else echo "Sign up with Facebook"; ?></a>								<?php }							if($google_id !='' && $google_secert !='') { ?>
              <a class="popup_google" onclick="window.location.href='<?php echo $authUrl; ?>'"><?php if($this->lang->line('signup_google') != '') { echo stripslashes($this->lang->line('signup_google')); } else echo "Sign up with Google"; ?></a>									<?php } ?>
              <span class="popup_signup_or">(OR)</span>
              <input type="text" id="first_name" value="<?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "First name"; ?>" class="decorative-input2" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
              <input type="text" id="last_name" value="<?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Last name"; ?>" class="decorative-input2" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
              <input type="text" id="email" value="<?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address"; ?>" class="decorative-input" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
              <input type="password" id="password" value=""  placeholder="<?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?>" class="decorative-input1" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
              <input type="password" id="cnf_password"  placeholder="<?php if($this->lang->line('change_conf_pwd') != '') { echo stripslashes($this->lang->line('change_conf_pwd')); } else echo "Confirm Password"; ?>" value="" class="decorative-input1" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
              <div class="test" style="float:left; width:100%; margin:5px 0"> <input type="checkbox" checked="checked" id="checkbox" style="float:left; width:auto; margin:0 5px 0 0px" /><label class="news-stay" style="float:left"><?php if($this->lang->line('staynest_news') != '') { echo stripslashes($this->lang->line('staynest_news')); } else echo "Tell me about latest news";?> </label></div>
              <p style="font-size:11px; text-align:left; margin:10px 0"><?php if($this->lang->line('simplesignup_cont1') != '') { echo stripslashes($this->lang->line('simplesignup_cont1')); } else echo 'By clicking "Sign up" you confirm that you accept the';?> <a data-popup="true" href="pages/privacy-policy"><?php if($this->lang->line('header_terms_service') != '') { echo stripslashes($this->lang->line('header_terms_service')); } else echo "Terms of Service";?></a> <?php if($this->lang->line('header_and') != '') { echo stripslashes($this->lang->line('header_and')); } else echo "and"; ?> <a data-popup="true" href="pages/policy"><?php if($this->lang->line('header_privacy_policy') != '') { echo stripslashes($this->lang->line('header_privacy_policy')); } else echo "Privacy Policy";?></a>.</p>
              <br />
              <div style="font-weight: 700; color: rgb(0, 0, 0); font-style: oblique; line-height: 65px; float: left; width: 50%; font-size: 22px; height: 36px; margin: -15px 0px 5px 0px; border-radius: 6px;"><input type="text" placeholder="captcha" id="register_captcha" style="height:37px; width:75%; float:left;"/><a href="javascript:reload_captcha();"><img src="images/refresh.png" style="width:12px;height:12px;margin:15px 10px;" title="Refresh" /></a></div>
              <div style="font-weight: 700; color: rgb(0, 0, 0); font-style: oblique; line-height: 65px; float: right; width: 50%; font-size: 22px; border: 1px solid rgb(223, 223, 195); height: 36px; margin: -15px 0px 5px 0px; border-radius: 6px; background: none repeat scroll 0% 0% rgb(242, 252, 227);"><span class="captcha-cls" id="captacha1" style="float: left; width: 48%; text-decoration: line-through; transform: rotate(-10deg); text-align: right; margin: -15px 0px 0px;"><?php $Capta1 = substr(str_shuffle("0123456789"), 0, 4); echo $Capta1; ?></span><span class="captcha-cls" id="captacha2" style="float: left; width: 48%; text-decoration: line-through; margin: -12px 0px 0px; text-align: left; transform: rotate(12deg);"><?php $Capta2 = substr(str_shuffle("0123456789"), 0, 4); echo $Capta2; ?></span><input type="hidden" id="captacha" value="<?php echo $Capta1.$Capta2; ?>" style="width:46%" /></div>
              <div style="display:none;" id="loading_signup_image" ><img  src="images/ajax-loader/ajax-loader(4).gif" id="loading_signup_image" ></div>
              <button type="submit" id="loading_signup" class="btn btn-block btn-primary large btn-large padded-btn-block register-popup cboxElement" onclick="javascript:register_user();" ><?php if($this->lang->line('login_signup') != '') { echo stripslashes($this->lang->line('login_signup')); } else echo "Create Account"; ?></button>
              <div class="remembr" style="display:none;">
                <input class="new-chek" type="checkbox"><span class="remember-me"><?php if($this->lang->line('remember_me') != '') { echo stripslashes($this->lang->line('remember_me')); } else echo "Remember Me";?></span>
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
    <nav class="navbar navbar-static-top navbar-default" style="border-bottom: 1px solid #dedede">
      <div class="container">
        <div class="navbar-header go-right">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
          <?php if($this->uri->segment(1) != '') { ?>
          <a href="<?php echo base_url();?>"><img class="img-responsive logo" src="images/logo/<?php echo $this->config->item('logo_image');?>" alt=""></a>
          <?php }else { ?>
          <a href="<?php echo base_url();?>"><img class="img-responsive logo" src="images/logo/<?php echo $this->config->item('home_logo_image');?>" alt=""></a>
          <?php } ?>
        </div>
        <div class="collapse navbar-collapse" id="header">


        <div class="navbar-form navbar-left">
		<input style="margin-top:5px" class="form-control" class="auto-tet" name="city" id="autocompleteNew" placeholder="<?php if($this->lang->line('search_where') != '') { echo stripslashes($this->lang->line('search_where')); } else echo "Where do you want to go?"; ?>" onFocus="geolocate()" type="text" onkeyup="findLocation(event);" value="<?php echo $gogole_address;?>">
		<div  id="autoCompImg" style="float: right; margin: 15px; display:none;"><img src="images/ajax-loader/ajax-loader.gif" alt="Loading..."></div>
        </div>

       <!-- <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input style="margin-top:5px"type="text" class="form-control" placeholder="Where are you going?">
            </div>
          </form>-->

              <ul class="nav navbar-nav navbar-left main-nav">
            <li class=""><a href="<?php echo base_url();?>popular"><?php if($this->lang->line('popular') != '') { echo stripslashes($this->lang->line('popular')); } else echo "Popular"; ?></a></li>
          </ul>

         <ul class="navbar-form navbar-right" role="search">
            <a href="<?php echo base_url();?>list_space" class="btn btn-primary"><?php if($this->lang->line('list_your') != '') { echo stripslashes($this->lang->line('list_your')); } else echo "List Your Space";?></a>



          </ul>

          <ul class="nav navbar-nav navbar-right main-nav">

            <?php if ($loginCheck == ''){?>

            <li ><a href="javascript:void(0);" class="reg-popup"><?php if($this->lang->line('signup') != '') { echo stripslashes($this->lang->line('signup')); } else echo "sign up"; ?></a></li>

            <li ><a href="javascript:void(0);" class="login-popup"><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "login"; ?></a></li>
            <?php }else {?>
          </ul>


          <ul class="nav navbar-nav navbar-right" id="broswe_box1">
            <li><a href="javascript: void();" class="dropdown-toggle" data-toggle="dropdown"><img width="20" src="<?php if($userDetails->row()->loginUserType == 'google'){ echo $userDetails->row()->image;} elseif($userDetails->row()->image == '' ){ echo base_url();?>images/site/profile.png<?php } else { echo base_url().'images/users/'.$userDetails->row()->image;}?>" style="float:left; margin:5px 5px;" id="showlist_test" alt=""/> <label class="user-name"><?php if($this->lang->line('login_hi') != '') { echo stripslashes($this->lang->line('login_hi')); } else echo "Hi"; ?><?php echo " ".ucfirst($userDetails->row()->firstname);?></label></a></li>
            <ul class="showlist3" >
              <span class="ard"></span>
              <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('header_dashboard') != '') { echo stripslashes($this->lang->line('header_dashboard')); } else echo "Dashboard"; ?></a></li>
              <li><a href="<?php echo base_url();?>inbox"> Inbox <?php if($unread_messages_count != '' || $unread_messages_count != 0) {?><span class="badge badge-warning pull-right"><?php echo $unread_messages_count;?></span><?php }?> </a></li>
              <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('header_listing') != '') { echo stripslashes($this->lang->line('header_listing')); } else echo "Your Listings"; ?></a></li>
              <li><a href="<?php echo base_url();?>listing-reservation"><?php if($this->lang->line('YourReservations') != '') { echo stripslashes($this->lang->line('YourReservations')); } else echo "Your Reservations"; ?></a></li>
              <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('your_trips') != '') { echo stripslashes($this->lang->line('your_trips')); } else echo "Your Trips"; ?></a></li>
              <li><a href="users/<?php echo $loginCheck;?>/wishlists"><?php if($this->lang->line('wish_list') != '') { echo stripslashes($this->lang->line('wish_list')); } else echo "Wish List"; ?></a></li>
              <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('settings_edit_prof') != '') { echo stripslashes($this->lang->line('settings_edit_prof')); } else echo "Edit Profile"; ?></a></li>
              <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('referrals_account') != '') { echo stripslashes($this->lang->line('referrals_account')); } else echo "Account"; ?></a></li>
              <li><a href="logout"><?php if($this->lang->line('header_signout') != '') { echo stripslashes($this->lang->line('header_signout')); } else echo "Log Out"; ?></a></li>
            </ul>
          </ul>
          <?php }?>


        </div>
      </div>
    </nav>
    <!-- Popup_signin_ends -->
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
      	initializeMap();
      	if($('#address_location').length)initializeMapAddress();
      	if($('#autocompleteNewList').length)initializeMapList();
        $("body").scroll(function(){
          $(".header").addClass("important blue");
        });
      });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&signed_in=true"></script>
    <!--<script type="text/javascript" src="js/markerwithlabel.js"></script>
      <script type="text/javascript" src="js/markerwithlabel_packed.js"></script>-->
    <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initializeMap() {
        // Create the autocomplete object, restricting the search
        // to geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById('autocompleteNew')),
            { types: ['geocode'] });
        // When the user selects an address from the dropdown,
        // populate the address fields in the form.
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
          var data = $("#autocompleteNew").serialize();
      	findLocationAuto(data);
      	return false;
        });
      }

      function initializeMapList() {
        // Create the autocomplete object, restricting the search
        // to geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById('autocompleteNewList')),
            { types: ['(cities)'] });
        // When the user selects an address from the dropdown,
        // populate the address fields in the form.
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
          //fillInAddress();
      	var uri_segment='<?php echo $this->uri->segment(1)?>';

      		if( uri_segment =='list_space' )
      		{

      	 localStorage.setItem("location",$('#autocompleteNewList').val());
      		}
        });
      }

      function initializeMapAddress() {
        // Create the autocomplete object, restricting the search
        // to geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById('address_location')),
            { types: ['geocode'] });
        // When the user selects an address from the dropdown,
        // populate the address fields in the form.
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
          fillInAddress();
        });
      }

      // [START region_fillform]
      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }
      // [END region_fillform]

      // [START region_geolocation]
      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
      }

      function findLocation(event)
      {
      	var x = event.which || event.keyCode;
          if(x == 13)window.location='<?php echo base_url()?>property?city='+$('#autocompleteNew').val();
      }

      function findLocationAuto(loc)
      {
      	window.location='<?php echo base_url()?>property?'+loc;
      }
      // [END region_geolocation]
    </script>