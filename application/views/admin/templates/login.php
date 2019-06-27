<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/><meta name="viewport" content="width=device-width"/><base href="<?php echo base_url(); ?>">
<title><?php echo $title;?></title>
<link href="css/reset.css" rel="stylesheet" type="text/css">
<link href="css/typography.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="css/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css">
<link href="css/gradient.css" rel="stylesheet" type="text/css">
<link href="css/developer.css" rel="stylesheet" type="text/css"><link rel="stylesheet" type="text/css" media="all" href="css/admin-responsive.css" />
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="css/ie/ie7.css" />
<![endif]-->
<!--[if IE 8]>
<link rel="stylesheet" type="text/css" href="css/ie/ie8.css" />
<![endif]-->
<!--[if IE 9]>
<link rel="stylesheet" type="text/css" href="css/ie/ie9.css" />
<![endif]-->
<!-- Jquery -->
<script src="js/jquery-1.7.1.min.js"></script>
<script src="js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="js/chosen.jquery.js"></script>
<script src="js/uniform.jquery.js"></script>
<script src="js/jquery.tagsinput.js"></script>
<script src="js/jquery.cleditor.js"></script>
<script src="js/jquery.jBreadCrumb.1.1.js"></script>
<script src="js/accordion.jquery.js"></script>
<script src="js/autogrow.jquery.js"></script>
<script src="js/duallist.jquery.js"></script>
<script src="js/input-limiter.jquery.js"></script>
<script src="js/inputmask.jquery.js"></script>
<script src="js/iphone-style-checkbox.jquery.js"></script>
<script src="js/raty.jquery.js"></script>
<script src="js/stepy.jquery.js"></script>
<script src="js/vaidation.jquery.js"></script>
<script src="js/jquery.collapse.js"></script>

<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-colorpicker.js"></script>
<script src="js/jquery.tipsy.js"></script>
<script src="js/custom-scripts.js"></script>
<script type="text/javascript">

function hideErrDiv(arg) {
    document.getElementById(arg).style.display = 'none';
}
</script>
</head>
<!-- <?php $query = $this->db->query('SELECT logo_image, background_image FROM '.ADMIN_SETTINGS.' WHERE id = 1');foreach ($query->result() as $row){    $logoImage = $row->logo_image;    $backgroundImage = $row->background_image;} ?> -->
<body id="theme-default" class="full_block">
<div id="login_page" style='background:url("images/logo/<?php echo $this->config->item('background_image');?>") repeat scroll 0 0 / cover rgba(0, 0, 0, 0)'>
	<div class="login_container">
		<div class="login_header blue_lgel">
			<ul class="login_branding">
				<li>
				<div class="logo_small">
					<img src="images/logo/<?php echo $this->config->item('logo_image');?>">
				</div>
				<span></span>
				</li>
				<li class="right go_to"><a href="<?php echo base_url();?>" title="Go to Main Site" class="home">Go To Main Site</a></li>
			</ul>
		</div>
		<?php if (validation_errors() != ''){?>
		<div id="validationErr">
			<script>setTimeout("hideErrDiv('validationErr')", 3000);</script>
			<p><?php echo validation_errors();?></p>
		</div>
		<?php }?>
		<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
		<?php echo form_open('admin/adminlogin/admin_login'); /*if (strpos(base_url(),'pleasureriver.com') === false){*/ if (!$this->data['demoserverChk']){ ?>
			<div class="login_form">
				<!--  <h3 class="blue_d">Admin Login</h3>-->
				<ul>
					<li class="login_user tipBot" title="Please enter your username">
					<label>Username:</label>
					<input class="login-scroll" name="admin_name" value="" type="text" >
					</li>
					<li class="login_pass tipTop" title="Please enter your password">
					<label>Password:</label>
					<input class="login-scroll" name="admin_password" type="password" value="">
					</li>
				</ul>
			</div>
			<ul class="login_opt_link">
				
				<li class="remember_me tipBot" title="Select to remember your password upto one day">
				<input name="remember" class="rem_me" type="checkbox" value="checked">
				Remember Me</li>
				<li class="right"><a href="admin/adminlogin/admin_forgot_password_form" class="tipLeft" title="Click to reset a new password">Forgot Password?</a></li>
			</ul>
			<input class="login_btn blue_lgel left" name="" value="Login" type="submit">
			
            <?php } else { ?>
            <div class="login_form">
				<h3 class="blue_d">Admin Login</h3>
				<ul>
					<li class="login_user tipBot" title="Please enter your username">
					<input name="admin_name" value="" type="text" >
					</li>
					<li class="login_pass tipTop" title="Please enter your password">
					<input name="admin_password" type="password" value="">
					</li>
				</ul>
			</div>
			<input class="login_btn blue_lgel" name="" value="Login" type="submit">
			<ul class="login_opt_link">
				<!--<li><a href="admin/adminlogin/admin_forgot_password_form" class="tipLeft" title="Click to reset a new password">Forgot Password?</a></li>-->
				<li class="remember_me right tipBot" title="Select to remember your password upto one day">
				<input name="remember" class="rem_me" type="checkbox" value="checked">
				Remember Me</li>
			</ul>
				<span style="background-color: rgb(255, 255, 255); float: left; text-align: center;">Due to security reasons site main configuration like payment settings, configuration settings is disabled in demo login</span>
                <?php } ?>
		</form>
        
	</div>
</div>
</body>
</html>