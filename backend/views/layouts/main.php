<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\web\Session;
use common\widgets\Alert;
use backend\components\Myclass;
use backend\models\Sitesettings; 

AppAsset::register($this);

$sitesetting = Sitesettings::find()->where(['id'=>'1'])->one();
?>
<?php
$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="description" content="Avenger Admin Theme">
<meta name="author" content="KaijuThemes">
<link href="<?php echo Yii::$app->urlManager->createAbsoluteUrl ('/images/'.$sitesetting->defaultfavicon); ?>" type="image/x-icon" rel="icon">  
<!--<script	src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&sensor=false"></script>-->
<?= Html::csrfMetaTags() ?>
<?php
$baseUrl = Yii::$app->request->baseUrl;
$this->registerCssFile($baseUrl.'/css/bootstrap.css');
$this->registerCssFile($baseUrl.'/css/css.css');
$this->registerCssFile($baseUrl.'/css/css1.css');
$this->registerCssFile($baseUrl.'/fonts/font-awesome/css/font-awesome.min.css');
$this->registerCssFile($baseUrl.'/css/styles.css');
$this->registerCssFile($baseUrl.'/plugins/jstree/dist/themes/avenger/style.min.css');
$this->registerCssFile($baseUrl.'/plugins/codeprettifier/prettify.css');
$this->registerCssFile($baseUrl.'/plugins/iCheck/skins/minimal/blue.css');
$this->registerCssFile($baseUrl.'/plugins/form-daterangepicker/daterangepicker-bs3.css');
$this->registerCssFile($baseUrl.'/plugins/fullcalendar/fullcalendar.css');
$this->registerCssFile($baseUrl.'/plugins/charts-chartistjs/chartist.min.css');
$this->registerCssFile($baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
$this->registerCssFile($baseUrl.'/plugins/datatables/dataTables.fontAwesome.css');
//$this->registerCssFile($baseUrl.'/plugins/nanoScroller/css/jquery.nanoscroller.css');

$this->registerJsFile($baseUrl.'/js/jquery-1.10.2.min.js', array('position' => $this::POS_HEAD), 'jquery');
/*$this->registerJsFile($baseUrl.'/js/jqueryui-1.9.2.min.js', array('position' => $this::POS_HEAD), 'jqueryui');
 $this->registerJsFile($baseUrl.'/js/bootstrap.min.js', array('position' => $this::POS_HEAD), 'bootstrap');
$this->registerJsFile($baseUrl.'/plugins/easypiechart/jquery.easypiechart.js', array('position' => $this::POS_HEAD), 'jquery.easypiechart');
$this->registerJsFile($baseUrl.'/plugins/sparklines/jquery.sparklines.min.js', array('position' => $this::POS_HEAD), 'jquery.sparklines');
$this->registerJsFile($baseUrl.'/plugins/jstree/dist/jstree.min.js', array('position' => $this::POS_HEAD), 'jstree');
$this->registerJsFile($baseUrl.'/plugins/codeprettifier/prettify.js', array('position' => $this::POS_HEAD), 'prettify');
$this->registerJsFile($baseUrl.'/plugins/bootstrap-switch/bootstrap-switch.js', array('position' => $this::POS_HEAD), 'bootstrap-switch');
$this->registerJsFile($baseUrl.'/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js', array('position' => $this::POS_HEAD), 'bootstrap-tabdrop');
$this->registerJsFile($baseUrl.'/plugins/iCheck/icheck.min.js', array('position' => $this::POS_HEAD), 'icheck');
$this->registerJsFile($baseUrl.'/js/enquire.min.js', array('position' => $this::POS_HEAD), 'enquire');
$this->registerJsFile($baseUrl.'/plugins/bootbox/bootbox.js', array('position' => $this::POS_HEAD), 'bootbox');
$this->registerJsFile($baseUrl.'/plugins/simpleWeather/jquery.simpleWeather.min.js', array('position' => $this::POS_HEAD), 'jquery.simpleWeather');
$this->registerJsFile($baseUrl.'/plugins/nanoScroller/js/jquery.nanoscroller.min.js', array('position' => $this::POS_HEAD), 'jquery.nanoscroller');
$this->registerJsFile($baseUrl.'/plugins/jquery-mousewheel/jquery.mousewheel.min.js', array('position' => $this::POS_HEAD), 'jquery.mousewheel');
$this->registerJsFile($baseUrl.'/js/application.js', array('position' => $this::POS_HEAD), 'application');
$this->registerJsFile($baseUrl.'/demo/demo.js', array('position' => $this::POS_HEAD), 'demo');
$this->registerJsFile($baseUrl.'/demo/demo-switcher.js', array('position' => $this::POS_HEAD), 'demo-switcher');
$this->registerJsFile($baseUrl.'/plugins/fullcalendar/fullcalendar.min.js', array('position' => $this::POS_HEAD), 'fullcalendar');
$this->registerJsFile($baseUrl.'/plugins/wijets/wijets.js', array('position' => $this::POS_HEAD), 'wijets');
$this->registerJsFile($baseUrl.'/plugins/charts-chartistjs/chartist.min.js', array('position' => $this::POS_HEAD), 'chartist');
$this->registerJsFile($baseUrl.'/plugins/charts-chartistjs/chartist-plugin-tooltip.js', array('position' => $this::POS_HEAD), 'chartist-plugin-tooltip');
$this->registerJsFile($baseUrl.'/plugins/form-daterangepicker/moment.min.js', array('position' => $this::POS_HEAD), 'moment');
$this->registerJsFile($baseUrl.'/plugins/form-daterangepicker/daterangepicker.js', array('position' => $this::POS_HEAD), 'daterangepicker');
$this->registerJsFile($baseUrl.'/demo/demo-index.js', array('position' => $this::POS_HEAD), 'demo-index');
$this->registerJsFile($baseUrl.'/plugins/datatables/jquery.dataTables.js', array('position' => $this::POS_HEAD), 'jquery.dataTables');
$this->registerJsFile($baseUrl.'/plugins/datatables/dataTables.bootstrap.js', array('position' => $this::POS_HEAD), 'dataTables.bootstrap');
$this->registerJsFile($baseUrl.'/demo/demo-datatables.js', array('position' => $this::POS_HEAD), 'demo-datatables');*/

//$this->registerJsFile($baseUrl.'/js/media.match.min.js', array('position' => $this::POS_HEAD), 'media.match');
//$this->registerJsFile($baseUrl.'/js/placeholder.min.js', array('position' => $this::POS_HEAD), 'placeholder');
//$this->registerJsFile($baseUrl.'/js/respond.min.js', array('position' => $this::POS_HEAD), 'respond');
//$this->registerJsFile($baseUrl.'/plugins/charts-flot/excanvas.min.js', array('position' => $this::POS_HEAD), 'excanvas');
//$this->registerJsFile($baseUrl.'/js/html5.js', array('position' => $this::POS_HEAD), 'html5');
//$this->registerCssFile($baseUrl.'/css/ie8.css');
?>

<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
<script>
var baseurl="<?php print Yii::$app->request->baseUrl;?>";
</script>
</head>
<body>
	<?php $this->beginBody() ?>

	<header id="topnav"
		class="navbar navbar-midnightblue navbar-fixed-top clearfix"
		role="banner">

		<span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg"> <a
			data-toggle="tooltips" data-placement="right" title="Toggle Sidebar"><span
				class="icon-bg"><i class="fa fa-fw fa-bars"></i> </span> </a>
		</span>
		<?php
		$settings = Myclass::getLogo();
		echo '<a href="" style="font-size:18px;color:#ffffff;float: left;height:50px;padding:15px;line-height:20px;">'.$settings->sitename.'</a>';
		?>

		<ul class="nav navbar-nav toolbar pull-right">
			<!--li class="dropdown toolbar-icon-bg"><a href="#"
				id="navbar-links-toggle" data-toggle="collapse"
				data-target="header>.navbar-collapse"> <span class="icon-bg"> <i
						class="fa fa-fw fa-ellipsis-h"></i>
				</span>
			</a>
			</li-->

			<li class="dropdown toolbar-icon-bgs">
				<form id="languagechange" action="<?php echo $baseUrl.'/language';?>" method="GET">
					<?= Html::dropDownList('language', Yii::$app->language, ['en' => 'English','fr' => 'French', 'zh' => 'Chinese'],array('onchange'=>'onchangelang()','style'=>'margin-top:8px; padding:5px 6px;','class'=>'form-control')) ?>

				</form>
			</li>
			<?php
			echo '
			<li class="dropdown toolbar-icon-bg">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-bg"><i class="fa fa-fw fa-user"></i></span></a>
			<ul class="dropdown-menu userinfo arrow">
			<!--li><a href="#"><span class="pull-left">Profile</span> <span class="badge badge-info">80%</span></a></li>
			<li><a href="#"><span class="pull-left">Account</span> <i class="pull-right fa fa-user"></i></a></li>
			<li><a href="#"><span class="pull-left">Settings</span> <i class="pull-right fa fa-cog"></i></a></li>
			<li class="divider"></li>
			<li><a href="#"><span class="pull-left">Earnings</span> <i class="pull-right fa fa-line-chart"></i></a></li>
			<li><a href="#"><span class="pull-left">Statement</span> <i class="pull-right fa fa-list-alt"></i></a></li>
			<li><a href="#"><span class="pull-left">Withdrawals</span> <i class="pull-right fa fa-dollar"></i></a></li>
			<li class="divider"></li-->
			<li><a href="'.$baseUrl.'/profile"><span class="pull-left">Profile</span> <i class="pull-right fa fa-user"></i></a></li>
			<li><a href="'.$baseUrl.'/logout"><span class="pull-left">Sign Out</span> <i class="pull-right fa fa-sign-out"></i></a></li>
			</ul>
			</li>';
			?>

		</ul>

	</header>

	<div id="wrapper">
		<div id="layout-static">
			<div class="static-sidebar-wrapper sidebar-midnightblue">
				<div class="static-sidebar">
					<?php include("sidebar.php"); ?>
				</div>
			</div>
			
			<div class="static-content-wrapper">
				<div class="static-content">
					<div class="page-content">

						<?php echo $this->params['breadcrumbs'][0]; ?>
						<div class="page-heading">
							<h1>
								<?php echo $this->params['subtitle']; ?>
							</h1>
							<!--div class="options">
								<div class="btn-toolbar">
									<a href="#" class="btn btn-default"><i
										class="fa fa-fw fa-wrench"></i> </a>
								</div>
							</div-->
						</div>
						<div class="container-fluid">
						<?= Alert::widget() ?>
							<?= $content ?>
						</div>
						<!-- .container-fluid -->
					</div>
					<!-- #page-content -->
				</div>
				<footer role="contentinfo">
					<div class="clearfix">
						<ul class="list-unstyled list-inline pull-left">
							<li><h6 style="margin: 0;">&copy; <?php
							$settings = Myclass::getLogo();
							echo date('Y'); echo ' '.$settings->sitename;?></h6></li>
						</ul>
						<button class="pull-right btn btn-link btn-xs hidden-print"
							id="back-to-top">
							<i class="fa fa-arrow-up"></i>
						</button>
					</div>
				</footer>
			</div>
		</div>
	</div>
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php
echo '
<!--script type="text/javascript" src="'.$baseUrl.'/js/jquery-1.10.2.min.js"></script-->
<script type="text/javascript" src="'.$baseUrl.'/js/jqueryui-1.9.2.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/js/admin.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/js/bootstrap.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/easypiechart/jquery.easypiechart.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/sparklines/jquery.sparklines.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/jstree/dist/jstree.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/codeprettifier/prettify.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/bootstrap-switch/bootstrap-switch.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/js/enquire.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/bootbox/bootbox.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/simpleWeather/jquery.simpleWeather.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/js/application.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/demo/demo.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/demo/demo-switcher.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/wijets/wijets.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/charts-chartistjs/chartist.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/charts-chartistjs/chartist-plugin-tooltip.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/form-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/form-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/demo/demo-datatables.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/form-jasnyupload/fileinput.min.js"></script>
<script type="text/javascript" src="'.$baseUrl.'/plugins/form-ckeditor/ckeditor.js"></script>
';
?>
<style type="text/css">
.alert-success {
	/*position: absolute;*/
	right: -50%;
	width: 100%;
	transition: all 0.5s !important;
	overflow: hidden !important;
}

.flashcss {
	right: 0%;
}
</style>
<script type="text/javascript">
	$(document).ready(function(){

	        setTimeout(function() {
$(".alert-success").css("display","none");
						}, 3000);
		$("#closebutton").click(function(){
			$(".alert-success").css("display","none");
		});
	});
</script>
			<script type="text/javascript">
				function onchangelang(){
					 $( "#languagechange" ).submit();
				}
			</script>
