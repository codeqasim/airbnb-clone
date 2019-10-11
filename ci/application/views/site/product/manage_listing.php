<?php $this->load->view('site/templates/header'); 
$this->load->view('site/templates/listing_head_side');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dop.BackendBookingCalendarPRO.css" />
<script type="text/JavaScript" src="<?php echo base_url();?>js/jquery-latest.js"></script>
<script type="text/JavaScript" src="<?php echo base_url();?>js/jquery.dop.BackendBookingCalendarPRO.js"></script>
<style>



</style>

<script type="text/JavaScript">
	$(document).ready(function(){
		localStorage.setItem("room_type",'null');
		localStorage.setItem("home_type",'null');
		localStorage.setItem("accommodates",'null');

		localStorage.setItem("location",'');
		$("#backend").DOPBackendBookingCalendarPRO({
		"ID": '<?php echo $this->uri->segment(2);?>',
		"DataURL": "<?php echo base_url();?>dopbcp/php-database/load.php",
		"SaveURL": "<?php echo base_url();?>dopbcp/php-database/save.php"
		});


		$("#backend").DOPBackendBookingCalendarPRO({"DataURL": "dopbcp/php-database/load.php",
		"SaveURL": "dopbcp/php-database/save.php"});

		$("#backend-refresh").click(function(){
		$("#backend").DOPBackendBookingCalendarPRO({"Reinitialize": true});

		$("#backend").DOPBackendBookingCalendarPRO({"Reinitialize": true,
		"DataURL": "dopbcp/php-database/load.php",
		"SaveURL": "dopbcp/php-database/save.php"});
		});
	});
	
	
</script>

<div class="right_side manage_listing-right">
	<div class="calender_box_main">
		<div class="calender_box">
			<div class="calender_bottom center">
			<?php if($listDetail->row()->calendar_checked!='' && $listDetail->row()->status !='UnPublish') {?>
				<!--<img src="<?php echo base_url();?>images/calender.png">-->
				<input type="hidden" value="<?php echo $listDetail->row()->price; ?>" name="comprice" id="comprice">
				<input type="hidden" value="<?php echo $listDetail->row()->currency; ?>" name="currency" id="currency">
				
				
				<div class="calender-top">
					<div class="col-xs-12 calender-top-left">
						<div class="calender-left-arrow"></div>
						
						<div class="calender-month" id="selected_month_year">
						
						
						<?php echo date('F Y');?>
						
						</div>
						
						<div class="calender-right-arrow" style="cursor:pointer;"></div>
					</div>
					
					<div class="col-xs-12 calender-top-right">
						<ul>
							<li><span class="green-circle"></span>Available</li>
							<li><span class="white-circle"></span>Booked</li>
							<li><span class="gray-circle"></span>UnAvailable</li>
						</ul>
					</div>
					
				</div>
				
				
				
				<div id="wrapper">
					<div id="backend-container">
						<div id="backend"></div>
					</div>
				</div>
			<?php }else {?>
                    <div class="calender_hide center" id="calenderlist1">
                    
                        <div class="calender_small_icon small-1"></div>
                        
                        <h2 class="calender_bottom_header"><?php if($this->lang->line('Always_Available') != '') { echo stripslashes($this->lang->line('Always_Available')); } else echo "Always Available";?></h2>
                    
                        <p><?php if($this->lang->line('Thisisyourcalendar') != '') { echo stripslashes($this->lang->line('Thisisyourcalendar')); } else echo "This is your calendar! After listing your space, return here to update your availability.";?></p>
                        
                        <a class="choose_links" href="javascript:calenderView('1')"><?php if($this->lang->line('Choose_Again') != '') { echo stripslashes($this->lang->line('Choose_Again')); } else echo "Choose Again";?></a>
                    
                    </div>
                    
                          
                    <div class="calender_bottom_block">
                    
                        <h2 class="calender_bottom_header"><?php if($this->lang->line('Whenisyourlisting') != '') { echo stripslashes($this->lang->line('Whenisyourlisting')); } else echo "When is your listing available?";?></h2>
                        
                        <ul class="calender_detail" style="padding: 0px !important;">
                        
                            <li class="availability_option" style="margin: 0 auto !important; padding: 0 !important; width: auto !important; float: none;">
                            
                            <a href="javascript:calenderView('1'),Detailview('<?php echo $listDetail->row()->id;?>','always','calendar_checked');">
                            
                                <div class="calendar-image available-always" <?php if($listDetail->row()->calendar_checked=='always'){?>style="background-position: 2px -290px;"<?php }?>></div>
                                
                                <h3><?php if($this->lang->line('Always') != '') { echo stripslashes($this->lang->line('Always')); } else echo "Always";?></h3>
                                
                                <p><?php if($this->lang->line('Listalldates') != '') { echo stripslashes($this->lang->line('Listalldates')); } else echo "List all dates as available";?></p>
                            </a>
                            
                            </li>
                      
                        </ul>
                        
                        </div>
                        
                        
                    <?php }?>
                    </div>
                    
                    
                    
                
                
                </div>

                <span class="calen-text"><?php if($this->lang->line('CalenderLast') != '') { echo stripslashes($this->lang->line('CalenderLast')); } else echo "Calender Last Update";?> <a class="today-text" href="#">today</a></span>
                
                </div>
            
            </div>
            
            <div class="calender_comments map-right">
            
                <div class="calender_comment_content">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
					<h1><?php if($this->lang->line('Usethecalendarto') != '') { echo stripslashes($this->lang->line('Usethecalendarto')); } else echo "Use the calendar to";?><h1>
					<li class="calender_comment_text"><?php if($this->lang->line('Setcustom') != '') { echo stripslashes($this->lang->line('Setcustom')); } else echo "Set custom Prices for specific dates";?></li>
					<li class="calender_comment_text"><?php if($this->lang->line('Markdates') != '') { echo stripslashes($this->lang->line('Markdates')); } else echo "Mark dates as unavailable";?></li>
					<li class="calender_comment_text"><?php if($this->lang->line('ViewYourupcoming') != '') { echo stripslashes($this->lang->line('ViewYourupcoming')); } else echo "View Your upcoming reservations";?></li>
                    
                   <!-- <p class="calender_comment_text">
					Choose the option that best fits your listing's availability. Don't worry, you can change this any time.
					</p>-->
                
                </div>
            
            </div>
<script>
$(function(){
	$('.calender-left-arrow').css('opacity',0.1);
	setTimeout(function() {
       available_status();
    }, 2000);
	
})
	
function available_status()
	{
		
       /** available status **/
	  
		
		$('.avail-middle').each(function(){
		var available_status=$(this).parent().next().attr('class');
		available_status1=available_status.split(' ');
		if(available_status1[2]!='available')
		{
		
		$(this).parent().next().addClass('avail-last');
		$('.avail-first').css('background','url("<?php echo base_url().'images/available-1st.png';?>")');
		$('.avail-first').css('background-position','right');
		$('.avail-middle').css('background-color','#1b8ebf');
		
		$('.avail-last').css('background','url("<?php echo base_url().'images/available-last.png';?>") no-repeat');
		$('.avail-last').css('height','72px');
		} 
		})
		/** available status **/
		
		/** booked status **/
		
		
		$('.booked-middle').each(function(){
		var available_status=$(this).parent().next().attr('class');
		available_status1=available_status.split(' ');
		if(available_status1[2]!='booked')
		{
		
		$(this).parent().next().addClass('booked-last');
		$('.booked-first').css('background','url("<?php echo base_url().'images/booked-1st.png';?>")');
		$('.booked-first').css('background-position','right');
		$('.booked-middle').css('background-color','#fac97a');
		
		$('.booked-last').css('background','url("<?php echo base_url().'images/booked-last.png';?>") no-repeat');
		$('.booked-last').css('height','72px');
		} 
		})
		/** booked status **/
		
		
		/** unavailable status **/
		
		$('.unavail-middle').each(function(){
		var available_status=$(this).parent().next().attr('class');
		available_status1=available_status.split(' ');
		if(available_status1[2]!='unavailable')
		{
		
		$(this).parent().next().addClass('unavail-last');
		$('.unavail-first').css('background','url("<?php echo base_url().'images/unavailable-1st.png';?>")');
		$('.unavail-first').css('background-position','right');
		$('.unavail-middle').css('background-color','#666666');
		
		$('.unavail-last').css('background','url("<?php echo base_url().'images/unavailable-last.png';?>") no-repeat');
		$('.unavail-last').css('height','72px');
		} 
		})
		/** unavailable status **/
   
	}
function Detailview(catID,title,chk)
{
	$.ajax({
	type:'POST',
	url:'<?php echo base_url()?>site/product/saveDetailPage',
	data:{catID:catID,title:title,chk:chk},
	success:function(response)
	{
	window.location.reload(true);
	}
	})
}
</script>	
<style>
.content{
height:44px !important;
}
</style>

<div id="myModal-rating-publish" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<a class="btn btn-default close-btn" data-dismiss="modal"><span class="">x</span></a>
				
				<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png"></a>
			</div>
			
			<div class="modal-body">
				<span class="publish-head"><?php if($this->lang->line('product_page_active_instruction_publish') != '') { echo stripslashes($this->lang->line('product_page_active_instruction_publish')); } else echo "To publish your listing ";?></span>
				<span id="pending_steps_new" class="number-circle"></span> 
				<span class="publish-footer"><?php if($this->lang->line('product_page_active_instruction_more') != '') { echo stripslashes($this->lang->line('product_page_active_instruction_more')); } else echo "more Steps to be Completed";?></span>
				
				<hr style="clear:both;">
				<a class="request-trip" id="finish_my_listing"href="" style="margin-right:36%;"><?php if($this->lang->line('product_page_active_instruction_finish') != '') { echo stripslashes($this->lang->line('product_page_active_instruction_finish')); } else echo "Finish my listing";?></a>
				
			</div>
			
			
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dalog -->
</div>
<style>
/*-------------Calender-page------------*/
#wrapper
{
	float:left;
}
.calender-top
{
	width:100%;
	float:left;
	clear:both;
	margin-bottom: 15px;
}
.calender-top-left, .calender-top-right
{
	padding:0;
}
.calender-left-arrow
{
	width:35px;
	height:35px;
	background:url(images/calender-left-arrow.png) no-repeat scroll 54% 67% #fff;
	border:1px solid #ccc;
	padding:10px;
	float:left;
}
.calender-right-arrow
{
	width:35px;
	height:35px;
	background:url(images/calender-right-arrow.png) no-repeat scroll 54% 67% #fff;
	border:1px solid #ccc;
	padding:10px;
	float:left;
}
.calender-month
{
	width:180px;
	float:left;
	background:#fff;
	height:35px;
	padding:2px;
	font-family: "Conv_DaxLight";
	color:#333;
	border:1px solid #ccc;
	margin:0 10px;
}
.calender-top-right ul
{
	float:right;
}
.calender-top-right ul li
{
	font-family: "Conv_DaxLight";
	color:#333;
	font-size:14px;
	float:left;
	margin-right:30px;
}
.calender-top-right ul li:last-child
{
	margin-right:0;
}
.green-circle
{
	width:10px;
	height:10px;
	float:left;
	background:#1b8ebf;
	display:block;
	border-radius:100%;
	margin-top:5px;
	margin-right:10px;
	border:1px solid #1b8ebf;
}
.white-circle
{
	width:10px;
	height:10px;
	float:left;
	background:#FAC97A;
	display:block;
	border-radius:100%;
	margin-top:5px;
	margin-right:10px;
	border:1px solid #FAC97A;
}
.gray-circle
{
	width:10px;
	height:10px;
	float:left;
	background:#666666;
	display:block;
	border-radius:100%;
	margin-top:5px;
	margin-right:10px;
	border:1px solid #ccc;
}

.DOPBackendBookingCalendarPRO_Day .bind-content .header, .DOPBackendBookingCalendarPRO_Day .bind-content .content
{
	border:0 !important;
}
.DOPBackendBookingCalendarPRO_Day.curr_month, .DOPBackendBookingCalendarPRO_Day.past_day, .DOPBackendBookingCalendarPRO_Day.next_month
{
	border: 1px solid #cccccc !important;
	/*width:74.9px !important;*/
	width:65px !important;
	width:calc(100% / 7 ) !important;
/*	width: -webkit-calc(100% / 7 ) !important;
	width: -moz-calc(100% / 7 ) !important;*/
}

.DOPBackendBookingCalendarPRO_Day .bind-content .header .day
{
	font-family: "Conv_DaxBold" !important;
	color:#000 !important;
	font-size:14px !important;
	float:none !important;
}
.DOPBackendBookingCalendarPRO_Month
{
	width:100%; !important;
}
.DOPBackendBookingCalendarPRO_Day .bind-content .header
{
	/*text-align:right;*/
}
/*.DOPBackendBookingCalendarPRO_Day.selected .header
{
	background:none !important;
	border:0 !important;
}*/

.DOPBackendBookingCalendarPRO_Day .bind-content .content .price
{
	  display: inline-block;
	  float:none !important;
}
.DOPBackendBookingCalendarPRO_Day.available .content
{
text-align:center !important;
font-size: 24px !important;
line-height: 20px !important;
}


.DOPBackendBookingCalendarPRO_Day.available .avail-first
{
	/* background:url(images/available-1st.png); */
	float:right;
	width:67px;
	height:72px;
	background-repeat: no-repeat !important;
	background-position: right !important;
	z-index: 9999;
	position: absolute;
}

.booked-first,.booked-last,.unavail-first,.unavail-last
{
	background-repeat: no-repeat !important;
}
.booked-first,.unavail-first
{
	background-position: right !important;
}

.DOPBackendBookingCalendarPRO_Day.available .avail-first .day, .DOPBackendBookingCalendarPRO_Day .bind-content .content .price, .DOPBackendBookingCalendarPRO_Day .bind-content .content .available, .DOPBackendBookingCalendarPRO_Day .avail-middle .header .day
{
	color:#000 !important;
	font-size: 14px !important;
}
.DOPBackendBookingCalendarPRO_Day
{
	/* min-height:73px; */
	height:73px !important;
	overflow:hidden;
}
.DOPBackendBookingCalendarPRO_Day
{
	border:1px solid #CCC;
}
.DOPBackendBookingCalendarPRO_Day .bind-content
{
	position:absolute;
}
.DOPBackendBookingCalendarPRO_Day
{
	/*width:74.9px !important;*/
	width:65px !important;
}


.DOPBackendBookingCalendarPRO_Day.available .avail-middle
{
	/* background-color:#37a86c; */
	height:72px;
	float:left;
	position: absolute;
	color:#000;
}
.DOPBackendBookingCalendarPRO_Day:last-child .avail-middle ~ div.DOPBackendBookingCalendarPRO_Day
{
	background:url(images/available-1st.png);
	float:right;
	width:67px;
	height:72px;
	background-repeat: no-repeat;
	background-position: right;
	z-index: 9999;
	position: absolute;
	transform:rotate(180deg);
}


#get_calendar
{
	float: left;
	border:0;
    width: 100%;
}


.DOPBackendBookingCalendarPRO_Day.curr_month.available +.DOPBackendBookingCalendarPRO_Day.curr_month.available
{
/* background:url(images/available-last.png); */
background-repeat: no-repeat; 
}


.DOPBackendBookingCalendarPRO_Month .DOPBackendBookingCalendarPRO_Day.available:last-child  .avail-middle
{
	background-color:none !important;
}
.DOPBackendBookingCalendarPRO_Day .bind-content .header
{
	background:none !important;
}
.DOPBackendBookingCalendarPRO_Day.last_month {
    opacity: 1 !important;
}
.DOPBackendBookingCalendarPRO_Day.past_day,.DOPBackendBookingCalendarPRO_Day.next_month
{
    opacity: 0.4 !important;
}
input#selected_month_year
{
	border:0;
	width: 100%;
	height: 30px;
	text-align:center;
	box-shadow:none;
}
.month_year,.add_btn, .remove_btn, .previous_btn, .next_btn,.DOPBackendBookingCalendarPRO_Navigation .previous_btn
{
	display:none !important;
}
.DOPBackendBookingCalendarPRO_Month 
{
    padding: 0px 0 !important;
    background: none repeat scroll 0% 0% #FFF;
    float: left;
    width: 99.5% !important;
}
.calender-month
{
	text-align:center !important;
	padding-top:7px !important;
	background:url("images/small-arrow.png") no-repeat scroll 95% 57% #FFF;
	top: -14px;
	position: relative;
}

.DOPBackendBookingCalendarPRO_Day.selected .header,.DOPBackendBookingCalendarPRO_Day.selected .header,.DOPBackendBookingCalendarPRO_Day.selected .header,.DOPBackendBookingCalendarPRO_Day.special .header,.DOPBackendBookingCalendarPRO_Day.booked .header
{
background-color: none !important;
border-color: 0 !important;
}
.publish-btn {
    background: none repeat scroll 0px 0px #38A86A;
    border-radius: 5px;
    color: #FFF !important;
    font-family: "Conv_DaxLight";
    font-size: 16px;
    font-weight: normal;
    margin: 3px 0 0 24px;
    padding: 0px 20px;
	float:right;
	cursor: pointer;
}
.publish-btn:hover{
	color: #FFF !important;
}

.DOPBackendBookingCalendarPRO_FormContainer
{
	background:#FFF !important;
	border-radius:5px !important;
	border:1px solid #999;
}
.section-item lable.left
{
	font-family: "Conv_DaxLight";
	font-size:14px;
}
input#DOPBCP_submit
{
	background: none repeat scroll 0px 0px #38A86A !important;
	border-radius: 5px !Important;
	color: #FFF !important;
	font-family: "Conv_DaxLight";
	font-size: 15px;
	font-weight: normal;
	margin: 3px 15px 0px 0 !important;
	padding: 3px 15px !important;
	float: left !important;
}

input#DOPBCP_reset{
  background: #7d7d7d !important;
  padding: 3px 15px !important;
  font-family: "Conv_DaxLight";
  margin: 3px 15px 0px 0 !important;
  border-radius: 5px !Important;
  font-size: 15px;
}

input#DOPBCP_close
{
	background: #000 !important;
	padding: 3px 15px !important;
	font-family: "Conv_DaxLight";
	margin: 3px 0 0px 0 !important;
	border-radius: 5px !Important;
	font-size: 15px;
}

.DOPBackendBookingCalendarPRO_Form .section-item select
{
	line-height:20px !important;
}

.DOPBackendBookingCalendarPRO_Form .section-item .date
{
	color: #37a86c !important;
}

.register_popup_main 
{
    background: none repeat scroll 0px 0px rgba(0, 0, 0, 0.4);
    height: 1770px;
    position: absolute;
    width: 100%;
    z-index: 9999;
}
.DOPBackendBookingCalendarPRO_Day .bind-content .header
{
	padding:0 !important;
}

.DOPBackendBookingCalendarPRO_Day.booked .content
{
	text-align:center !important;
}
.table-condensed .prev
{
	-webkit-transform: -webkit-rotateY(180deg);
}




.DOPBackendBookingCalendarPRO_Navigation, .DOPBackendBookingCalendarPRO_Form .container, .DOPBackendBookingCalendarPRO_Form .section input[type="button"] , .DOPBackendBookingCalendarPRO_Day.selected .header,.DOPBackendBookingCalendarPRO_Container
{
	background:none !important;
}
.DOPBackendBookingCalendarPRO_Navigation .month_year
{
	color:#FFF !important;
	font-family: "Conv_DaxBold";
}
.DOPBackendBookingCalendarPRO_Navigation .week .day
{
	color:#333 !important;
	font-family: "Conv_DaxLight" !important;
	font-size:12px !important;
}
.DOPBackendBookingCalendarPRO_Day .bind-content .header
{
	background:none !important;
}
/*.DOPBackendBookingCalendarPRO_Day.booked .header
{
	background:#fbd597 !important;
}*/
.DOPBackendBookingCalendarPRO_Day .bind-content .content .price
{
	font-family: "Conv_DaxLight" !important;
	font-weight: normal !important;
	font-size: 17px !important;
	padding-top: 12px !important;
}
#wrapper 
{
    width: 100%;
    z-index: -999 !important;
}
input#DOPBCP_close
{
	background:#7d7d7d  !important;
}
input#DOPBCP_close:hover
{
	background:#333 !important;
}

.DOPBackendBookingCalendarPRO_FormWrapper {
    position: absolute;
}
.DOPBackendBookingCalendarPRO_Navigation, .DOPBackendBookingCalendarPRO_Calendar
{
	z-index:0 !important;
	position:inherit !important;
}
.calender-month
{
	top: 0px !important;
}
</style>
<?php $this->load->view('site/templates/footer'); ?>