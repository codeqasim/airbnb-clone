<?php

use backend\components\Myclass;

$this->title = 'Dashboard';
$this->params['subtitle'] = Yii::t('app','Dashboard Sub Title');
$this->params['breadcrumbs'][]= '';
?>
	<div data-widget-group="group1">

		<div class="row">
			<div class="col-md-3">
				<div class="amazo-tile tile-success">
					<div class="tile-heading">
						<div class="title"><?php echo Yii::t('app','Total Users');?></div>
						<div class="secondary"></div>
					</div>
					<div class="tile-body">
						<div class="content"><?php echo count($usermodel);?></div>
					</div>
					<div class="tile-footer">
						<span class="info-text text-right"><!--<i class="fa fa-level-up"></i>--></span>
						<div id="sparkline-revenue" class="sparkline-line"></div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="amazo-tile tile-info" href="#"> 
					<div class="tile-heading">
				        <div class="title"><?php echo Yii::t('app','Active Users');?></div>
				        <div class="secondary"></div>
				    </div>
				    <div class="tile-body">
				        <div class="content"><?php echo count($activeuser);?></div>
				    </div>
				    <div class="tile-footer">
				    	<span class="info-text text-right"></span>
				    	<div class="progress">
					    	<div class="progress-bar" style="width: 82%"></div>
					    </div>
				    </div>
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="amazo-tile tile-white">
					<div class="tile-heading">
						<div class="title"><?php echo Yii::t('app','Blocked Users');?></div>
						<div class="secondary"></div>
					</div>
					<div class="tile-body">
						<span class="content"><?php echo count($blockuser); ?></span>
					</div>
					<div class="tile-footer text-center">
						<span class="info-text text-right" style="color: #f04743"><!--<i class="fa fa-level-down"></i>--></span>
						<div id="sparkline-item" class="sparkline-bar"></div>
					</div>
				</div>
			</div>
			

			
			<div class="col-md-3">
				<div class="amazo-tile tile-white">
					<div class="tile-heading">
						<span class="title"><?php echo Yii::t('app','Active Listings');?></span>
						<span class="secondary"></span>
					</div>
					<div class="tile-body">
						<span class="content"><?php echo count($activelist);?></span>
					</div>
					<div class="tile-footer">
						<span class="info-text text-right" style="color: #94c355"><!-- <i class="fa fa-level-up"></i>--></span>
						<div id="sparkline-commission" class="sparkline"></div>
					</div>
				</div>
			</div>
		</div>


	</div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default demo-dashboard-graph" data-widget=''>
                    <div class="panel-heading">
                        <h2>
                            <ul class="nav nav-tabs" id="chartist-tab">
                                <li><a href="#tab-revenues" data-toggle="tab"><i class="fa fa-bar-chart-o visible-xs"></i>
                                    <span class="hidden-xs">Bookings</span></a></li>
                            </ul>
                        </h2>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="tab-revenues" class="tab-pane active">
                                <div class="demo-chartist-sales" id="chart2"></div>
                                <div class="requested"></div><div class="txtcls">Requested</div>
                                <div class="accepted"></div><div class="txtcls">Accepted</div>
                                <div class="declined"></div><div class="txtcls">Declined</div>
                                <div class="cancelled"></div><div class="txtcls">Cancelled</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default demo-dashboard-graph" data-widget=''>
                    <div class="panel-heading">
                        <h2>
                            <ul class="nav nav-tabs" id="chartist-tab">
                                <li><a href="#tab-revenues" data-toggle="tab"><i class="fa fa-bar-chart-o visible-xs"></i>
                                    <span class="hidden-xs">Monthly Turnover</span></a></li>
                            </ul>
                        </h2>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="tab-revenues" class="tab-pane active">
                                <div class="demo-chartist-sales" id="chart3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        


    <!-- Switcher -->
    <div class="demo-options">
        <!--div class="demo-options-icon"><i class="fa fa-spin fa-fw fa-smile-o"></i></div-->
        <div class="demo-heading"><?php echo Yii::t('app','Demo Settings');?></div>

        <div class="demo-body">
            <div class="tabular">
                <div class="tabular-row">
                    <div class="tabular-cell"><?php echo Yii::t('app','Fixed Header');?></div>
                    <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" checked data-size="mini" data-on-color="success" data-off-color="default" name="demo-fixedheader" data-on-text="I" data-off-text="O"></div>
                </div>
                <div class="tabular-row">
                    <div class="tabular-cell"><?php echo Yii::t('app','Boxed Layout');?></div>
                    <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" data-size="mini" data-on-color="success" data-off-color="default" name="demo-boxedlayout" data-on-text="I" data-off-text="O"></div>
                </div>
                <div class="tabular-row">
                    <div class="tabular-cell"><?php echo Yii::t('app','Collapse Leftbar');?></div>
                    <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" data-size="mini" data-on-color="success" data-off-color="default" name="demo-collapseleftbar" data-on-text="I" data-off-text="O"></div>
                </div>
                <div class="tabular-row">
                    <div class="tabular-cell"><?php echo Yii::t('app','Collapse Rightbar');?></div>
                    <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" checked data-size="mini" data-on-color="success" data-off-color="default" name="demo-collapserightbar" data-on-text="I" data-off-text="O"></div>
                </div>
                <div class="tabular-row hide" id="demo-horizicon">
                    <div class="tabular-cell"><?php echo Yii::t('app','Horizontal Icons');?></div>
                    <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" checked data-size="mini" data-on-color="primary" data-off-color="warning" data-on-text="S" data-off-text="L" name="demo-horizicons" ></div>
                </div>
            </div>

        </div>

        <div class="demo-body">
            <div class="option-title"><?php echo Yii::t('app','Header Colors');?></div>
            <ul id="demo-header-color" class="demo-color-list">
                <li><span class="demo-white"></span></li>
                <li><span class="demo-black"></span></li>
                <li><span class="demo-midnightblue"></span></li>
                <li><span class="demo-primary"></span></li>
                <li><span class="demo-info"></span></li>
                <li><span class="demo-alizarin"></span></li>
                <li><span class="demo-green"></span></li>
                <li><span class="demo-violet"></span></li>                
                <li><span class="demo-indigo"></span></li> 
            </ul>
        </div>

        <div class="demo-body">
            <div class="option-title"><?php echo Yii::t('app','Sidebar Colors');?></div>
            <ul id="demo-sidebar-color" class="demo-color-list">
                <li><span class="demo-white"></span></li>
                <li><span class="demo-black"></span></li>
                <li><span class="demo-midnightblue"></span></li>
                <li><span class="demo-primary"></span></li>
                <li><span class="demo-info"></span></li>
                <li><span class="demo-alizarin"></span></li>
                <li><span class="demo-green"></span></li>
                <li><span class="demo-violet"></span></li>                
                <li><span class="demo-indigo"></span></li> 
            </ul>
        </div>

        <div class="demo-body hide" id="demo-boxes">
            <div class="option-title"><?php echo Yii::t('app','Boxed Layout Options');?></div>
            <ul id="demo-boxed-bg" class="demo-color-list">
                <li><span class="pattern-brickwall"></span></li>
                <li><span class="pattern-dark-stripes"></span></li>
                <li><span class="pattern-rockywall"></span></li>
                <li><span class="pattern-subtle-carbon"></span></li>
                <li><span class="pattern-tweed"></span></li>
                <li><span class="pattern-vertical-cloth"></span></li>
                <li><span class="pattern-grey_wash_wall"></span></li>
                <li><span class="pattern-pw_maze_black"></span></li>
                <li><span class="patther-wild_oliva"></span></li>
                <li><span class="pattern-stressed_linen"></span></li>
                <li><span class="pattern-sos"></span></li>
            </ul>
        </div>

    </div>
<!-- /Switcher -->
<?php
$baseUrl = Yii::$app->request->baseUrl;

$first  = strtotime('first day this month');
$months = array();

for ($i = 6; $i >= 1; $i--) {
  array_push($months, date('M', strtotime("-$i month", $first)));
}
$months = json_encode($months);
$start = mktime(0,0,0,date('m'), date('d'), date('Y'));;

$requestedbookings = array();
$acceptedbookings = array();
$declinedbookings = array();
$cancelledbookings = array();
$turnover = array();
// loop through the current and last four month
for ($i = 0; $i <=5; $i++) {
    // calculate the first day of the month
    $first = mktime(0,0,0,date('m',$start) - $i,1,date('Y',$start));

    // calculate the last day of the month
    $last = mktime(0, 0, 0, date('m') -$i + 1, 0, date('Y',$start));

    // now some output...
    $startdate = date('Y-m-d',$first);
    $enddate = date('Y-m-d',$last);

    $requested = Myclass::getRequsted($startdate,$enddate);
    $accepted = Myclass::getAccepted($startdate,$enddate);
    $declined = Myclass::getDeclined($startdate,$enddate);
    $cancelled = Myclass::getCancelled($startdate,$enddate);
    $monthlyturnover = Myclass::getTurnover($startdate,$enddate);
    array_push($requestedbookings, $requested);
    array_push($acceptedbookings, $accepted);
    array_push($declinedbookings, $declined);
    array_push($cancelledbookings, $cancelled);
    array_push($turnover,$monthlyturnover);
}
$requestedbookings = json_encode($requestedbookings);
$acceptedbookings = json_encode($acceptedbookings);
$declinedbookings = json_encode($declinedbookings);
$cancelledbookings = json_encode($cancelledbookings);
$turnover = json_encode($turnover);
?>
<script type="text/javascript" src="<?php echo $baseUrl;?>/plugins/charts-chartistjs/chartist.min.js"></script>  
<script type="text/javascript" src="<?php echo $baseUrl;?>/plugins/charts-chartistjs/chartist-plugin-tooltip.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl;?>/demo/demo-index.js"></script>
<script type="text/javascript">
        var chartistData2 = {
          labels: 
          <?php
          print_r($months);
          ?>
          ,
            series: [
            <?php
            print_r($requestedbookings);
            ?>,
            <?php
            print_r($acceptedbookings);
            ?>,
            <?php
            print_r($declinedbookings);
            ?>,
            <?php
            print_r($cancelledbookings);
            ?>
            ]
        };

        var chartistOptions2 = {
          height: 300,
          seriesBarDistance: 15,
          axisX: {
            offset: 20
          },
          axisY: {
            offset: 20,
            /*labelInterpolationFnc: function(value) {
              return '$' + value + 'K'
            },*/
            scaleMinSpace: 0
          },
          plugins: [
            Chartist.plugins.tooltip({})
          ]
        };

        var chartistData3 = {
          labels: 
          <?php
          print_r($months);
          ?>
          ,
            series: [
            <?php
            print_r($turnover);
            ?>,

            ]
        };

        var chartistOptions3 = {
          height: 300,
          seriesBarDistance: 15,
          axisX: {
            offset: 20
          },
          axisY: {
            offset: 20,
            /*labelInterpolationFnc: function(value) {
              return '$' + value + 'K'
            },*/
            scaleMinSpace: 0
          },
          plugins: [
            Chartist.plugins.tooltip({})
          ]
        };        

        var Chartist2 = new Chartist.Bar('#chart2', chartistData2, chartistOptions2);
        var Chartist1 = new Chartist.Bar('#chart3', chartistData3, chartistOptions3);
</script>