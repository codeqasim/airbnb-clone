<?php 

//echo '<pre>';print_r($PendingbookedRental->result());die;
$this->load->view('site/templates/header');
?>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor account accountid1">

  <div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard">Dashboard</a></li>
                <li><a href="<?php echo base_url();?>inbox">Inbox</a></li>
                <li><a href="<?php echo base_url();?>listing/all">Your Listing</a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming">Your Trips</a></li>
                <li><a href="<?php echo base_url();?>settings">Profile</a></li>
                <li class="active"><a href="<?php echo base_url();?>account">Account</a></li>
                <li><a href="<?php echo base_url();?>plan">Plan</a></li>
            </ul> </div></div>
  <div class="main">
      <div id="command_center">
    
             <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard">Dashboard</a></li>
                <li><a href="<?php echo base_url();?>inbox">Inbox</a></li>
                <li><a href="<?php echo base_url();?>listing/all">Your Listing</a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming">Your Trips</a></li>
                <li><a href="<?php echo base_url();?>settings">Profile</a></li>
                <li class="active"><a href="<?php echo base_url();?>account">Account</a></li>
                <li><a href="<?php echo base_url();?>plan">Plan</a></li>
            </ul>  
            <ul class="subnav">
               <li><a href="<?php echo base_url();?>account">Notifications</a></li>
                 
                <li><a href="<?php echo base_url();?>account-payout">Payout Preferences</a></li>
                <li class="active"><a href="<?php echo base_url();?>account-trans">Transaction History</a></li>
                <!-- <li><a href="<?php echo base_url();?>referrals">Referrals</a></li>-->
                <!--<li><a href="<?php echo base_url();?>account-privacy">Privacy</a></li>-->
                <li><a href="<?php echo base_url();?>account-security">Security</a></li>
                <li><a href="<?php echo base_url();?>account-setting">Settings</a></li>  
              
            </ul>

              <div id="transaction_history">

           
             <div class="box" id="my_listings">
                <div class="middle">
                  
      <div class="tabbable-panel">
        <div class="tabbable-line">
          <ul class="nav nav-tabs ">
            <li <?php if(($this->uri->segment(4)=="" || $this->uri->segment(4)=="Booked")&&$this->uri->segment(1) !='gross-earning'){?>class="active" <?php }?> onclick="redirect()">
              <a href="#tab_default_1" data-toggle="tab">Completed Transactions</a>
            </li>
			<!--<li <?php if($this->uri->segment(1)=="gross-earning"){?>class="active" <?php }?> onclick="redirect()">
              <a href="#tab_default_3" data-toggle="tab">Gross Earnings</a>
            </li>-->
            <li <?php if($this->uri->segment(4)=="Pending"){?>class="active" <?php }?> onclick="redirect()">
              <a href="#tab_default_2" data-toggle="tab">Future Transactions</a>
            </li>
            
          </ul>



            <div class="tab-content">
            <div class="tab-pane <?php if(($this->uri->segment(4)=="" || $this->uri->segment(4)=="Booked")&&$this->uri->segment(1) !='gross-earning'){?>active<?php }?>" id="tab_default_1">

            <!--<div class="filter-sectiong">
             <div class="select">
              <select class="pay-method" name="year" id="year" onchange="gross_earning(this)">
              <option value="">Year</option>
			  <?php $from_year=date('Y', strtotime('-20 year'));
			        $end_year=date('Y');
				for($i=$end_year;$i>=$from_year;$i--){?>
				<option value="<?php echo $i;?>" <?php if($this->uri->segment(2)=='year'){?>
				<?php if($this->uri->segment(3)==$i){?>selected="selected"<?php }?>
				<?php }?>><?php echo $i;?></option>
				<?php }?>
			  
              </select>
              </div>
              <div class="select">
              <select class="pay-month" name="created" id="created" onchange="gross_earning(this)">
              <option value="">All months</option>
             <?php for($i = 1 ; $i <= 12; $i++) { ?>
			<option value="<?php echo $i;?>" <?php if($this->uri->segment(2)=='created'){?>
				<?php if($this->uri->segment(3)==$i){?>selected="selected"<?php }?>
				<?php }?>><?php echo  date("F",mktime(0,0,0,$i,1,date("Y")));?></option>  
             <?php }?>

              </select>
              </div>
            </div>-->
			
			<?php
             if($gross_earning_rental)
			 {
			if(count($gross_earning_rental->result()) >0 )
                    { ?>
                       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
                        <thead>
               <tr height="40px">          
               <td width="10%" style="" ><strong>Date</strong></td>
               <td width="17%" style=""><strong>Booking Number</strong></td>
               <td width="20%" style=""><strong>Transaction Method</strong></td>

               <td width="15%" style=""><strong>Transaction Id</strong></td>
               <td width="15%" style=""><strong>Gross Earnings</strong></td>
                            
                 </tr>
              </thead>
                         
                           <?php 
                    foreach($gross_earn->result() as $row)
                        { 
						
						?>
                                    
                                        <tbody>
                                        <td>
										<?php echo $row->txt_date;?>
										</td>
										<td>
										<?php echo $row->bookingId;?>
										</td>
										<td>
										<?php echo $row->txn_type;?>
										</td>
                                        
					<td>
					<?php echo $row->txn_id;?></td>
                    <td><?php echo $row->amount;?></td>
                        </tbody>
                                          <?php } ?>
                                        </table>
                                       <?php } }
									   
									   
                    else{ ?>
                            
              <h3 class="status-text">No Transactions</h3>
              <?php 
              }
              ?>


 </div>
            
            <div class="tab-pane <?php if($this->uri->segment(1)=="gross-earning"){?>active<?php }?>" id="tab_default_3">
              
									   
            </div>
			
			
			
			
			
			
			<div class="tab-pane <?php if($this->uri->segment(4)=="Pending"){?>active<?php }?>" id="tab_default_2">
             <!--<div class="filter-sectiong">
             <div class="select">
              <select class="pay-method" name="payment_type" id="payment_type" onchange="transaction_change(this,'Booked')">
              <option value="">All</option>
			  <option value="Credit Cart" <?php if($this->uri->segment(3)=='Credit-Cart'){?> selected="selected" <?php }?>>Credit Cart</option>
			  <option value="paypal" <?php if($this->uri->segment(3)=='paypal'){?> selected="selected" <?php }?>>paypal</option>
              </select>
              </div>
              <div class="select">
              <select class="pay-listing" name="product_id" id="product_id" onchange="transaction_change(this,'Booked')">
			  <option value="">All Listing</option>
			  <?php foreach($RentalList->result() as $rental) :?>
			  <option value="<?php echo $rental->id;?>" <?php if($this->uri->segment(3)==$rental->id){?> selected="selected" <?php }?>><?php echo $rental->product_title;?></option>
			  <?php endforeach;?>
              </select>
              </div>
             
              <div class="select">
              <select class="pay-month" name="created" id="created" onchange="transaction_change(this,'Booked')">
              <option value="">All months</option>
             <?php for($i = 1 ; $i <= 12; $i++) { ?>
			<option value="<?php echo $i;?>" <?php if($this->uri->segment(2)=='created'){?>
				<?php if($this->uri->segment(3)==$i){?>selected="selected"<?php }?>
				<?php }?>><?php echo  date("F",mktime(0,0,0,$i,1,date("Y")));?></option>  
             <?php }?>

              </select>
              </div>
            </div>-->









             <?php if(count($PendingbookedRental->result()) >0)
                    { ?>
                       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
                        <thead>
               <tr height="40px">          
                              <td width="15%" style="" ><strong>Date</strong></td>
                 <td width="15%" style=""><strong>Type</strong></td>
                
                 <td width="35%" style=""><strong>Details</strong></td>
                             <td width="30%" style=""><strong>Amount</strong></td>
                             
                             <!--<td width="15%" style="background:#f5f5f5;" ><strong>Action</strong></td>-->
                 </tr>
              </thead>
                         
                           <?php 
                    foreach($PendingbookedRental->result() as $row)
                        { 
						//var_dump($row);die;
						
						?>
                                    
                                        <tbody>
                                        <td>
										<?php if($row->checkin!='0000-00-00 00:00:00' && $row->checkout!='0000-00-00 00:00:00'){ echo "<br>".date('M d',strtotime($row->checkin))." - ".date('M d, Y',strtotime($row->checkout)); ?>
										</td>
										<td>
										<?php echo $row->home_type;?>
										</td>
                                        <td class="paddgns">
								<a target="_blank" href="users/show/<?php echo $row->GestId; ?>" style="float:left; "><?php echo $row->firstname;?></a><br>
                                  										
								<br />
						  <?php
                           echo "<a href='".base_url()."rental/".$row->product_id."'>".$row->product_title."</a><br>";
                           /* echo $row->address."<br>";
                           echo $row->city_name.",".$row->state_name." ".$row->post_code."<br>";
                           echo $row->country_name; */}
                           ?>
                    <?php echo strtoupper($currencySymbol)."".round($row->price * $this->session->userdata('currency_r'),2)." / Night";?><br>
					<?php echo "<label style='font-weight:bold;'>Booking No :</label>".$row->Bookingno;?>
                    </td>
					<?php
							//$totalAmount = ($row->numofdates*$row->price);
							$totalAmount = $row->totalAmt - $row->serviceFee;;
							
							if($service_tax[1]['promotion_type'] == 'flat') 
							$gCommision = $service_tax[1]['commission_percentage'];
							else
							$gCommision = number_format(($totalAmount*$service_tax[1]['commission_percentage'])/100,2);
							
							if($service_tax[0]['promotion_type'] == 'flat') 
							$hCommision = $service_tax[0]['commission_percentage'];
							else
							$hCommision = number_format(($totalAmount*$service_tax[0]['commission_percentage'])/100,2);
							
							$netAmount = ($row->totalAmt-($gCommision+$hCommision));
							
					?>
							
                    <td><table><tr><td style="text-align:right;"><span style="color:red;">Total </span></td><td style="text-align:right;"><?php echo strtoupper($currencySymbol)."".round($row->totalAmt,2)."";?> </td></tr>
					<tr><td style="text-align:right;"><span style="color:red;">Service Fee </span></td><td style="text-align:right;"><?php echo strtoupper($currencySymbol)."".round($gCommision,2)."";?> </td></tr>
					<tr><td style="text-align:right;"><span style="color:red;">Host Fee </span></td><td style="text-align:right;"><?php echo strtoupper($currencySymbol)."".round($hCommision,2)."";?> </td></tr>
					<tr><td style="text-align:right;"><span style="color:red;">Net Amount </span></td><td style="text-align:right;"><?php echo strtoupper($currencySymbol)."".round($row->totalAmt-($gCommision+$hCommision))."";?> </td></tr></table>
					</td>
                                       <!-- <td>
                                        <?php if($row->booking_status=='Enquiry'){?>
                                        <a href="edit_inquiry_details/<?php echo $row->EnqId; ?>" title="Edit Enquiry"><?php echo $row->PaymentStatus; ?></a>
                                        <?php }else{?>
                                        <p ><?php echo $row->PaymentStatus; ?></p>
                                         <?php }?>
                                        
                                        </td><!--<td><a href="#">View</a></td>-->
                                        </tbody>
                                          <?php } ?>
                                        </table>
                                       <?php } 
                  else
                    { ?>
                            
                       <p class="no_listings">
                         Once you have reservations, the money that you have earned will be displayed here.
                         </p>
						 <h3 class="status-text">No Transactions</h3>
              <?php 
              }
              ?>



           <!-- <div class="pagination">
            
            <ul>
            <li class="disabled">
            <a class="previous_page" href="#">«</a>
            </li>
            <li class="disabled">
            <a class="next_page" href="#">»</a>
            </li>
            </ul>
            </div>-->
            </div>
          </div>
        </div>
      </div>









                
                        <div class="show_all_reservations">
                           <!-- <a href="#=1">View past reservation history</a>-->
                        </div>
                </div>
    </div>

    </div>
         
  </div>
    </div>
</div>
<!---DASHBOARD-->
<!---FOOTER-->
<script type="text/javascript">
function redirect()
{
if('<?php echo $this->uri->segment(2)?>' !="")
{
//window.location='<?php echo base_url();?>account-trans';
}
}
function transaction_change(elem,booking_status)
{
var cur_field=$(elem).attr('id');
var cur_value=$(elem).val();
cur_value= cur_value.replace(' ', '-');
if(cur_field !="" && cur_value !="")
{
window.location='<?php echo base_url()?>account-trans/'+cur_field+'/'+cur_value+'/'+booking_status;
}
else{
window.location='<?php echo base_url();?>account-trans/'+booking_status;
}

}

function gross_earning(elem)
{
var cur_field=$(elem).attr('id');
var cur_value=$(elem).val();
cur_value= cur_value.replace(' ', '-');
if(cur_field !="" && cur_value !="")
{
window.location='<?php echo base_url()?>gross-earning/'+cur_field+'/'+cur_value;
}
else{
window.location='<?php echo base_url()?>gross-earning/';
}
}
</script>
<?php 
$this->load->view('site/templates/footer');
?>