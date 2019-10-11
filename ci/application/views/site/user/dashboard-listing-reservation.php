<?php 
$this->load->view('site/templates/header');
?>

<!---DASHBOARD-->
<div class="dashboard yourlisting resrev bgcolor">

<div class="top-listing-head">
 <div class="main">   
            <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li class="active"><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></li>
                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul> </div></div>
    <div class="main">
        <div class="dashboard-sidemenu" id="command_center">
       
        <div class="dashboard-sidemenu">
            <ul class="subnav">
                <li class="active"><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('ManageListings') != '') { echo stripslashes($this->lang->line('ManageListings')); } else echo "Manage Listings";?></a></li>
                <li><a href="<?php echo base_url();?>listing-reservation"><?php if($this->lang->line('YourReservations') != '') { echo stripslashes($this->lang->line('YourReservations')); } else echo "Your Reservations";?>  </a></li>
                <li><a href="<?php echo base_url();?>listing-requirement"><?php if($this->lang->line('ReservationRequirements') != '') { echo stripslashes($this->lang->line('ReservationRequirements')); } else echo "Reservation Requirements";?></a></li>
                <!--<li><a href="<?php echo base_url();?>listing-booking">Booking</a></li>
                <li><a href="<?php echo base_url();?>listing_enquiry">Enquiry</a></li>-->
                
            </ul>

            </div>


            <div class="dashboard-rightmenu">
            <div class="box" id="my_listings">
                <div class="middle">
                <?php if($bookedRental->num_rows() >0)
                                { ?>
                       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
                            <thead>
                             <tr height="40px">
                             
                             <td style="width:100px"><strong><?php if($this->lang->line('UserName') != '') { echo stripslashes($this->lang->line('UserName')); } else echo "User Name";?></strong></td>
                             <td style="width:150px"><strong><?php if($this->lang->line('DatesandLocation') != '') { echo stripslashes($this->lang->line('DatesandLocation')); } else echo "Dates and Location";?></strong></td>
                             <td style="width:100px"><strong><?php if($this->lang->line('Details') != '') { echo stripslashes($this->lang->line('Details')); } else echo "Details";?></strong></td>
                             <td style="width:100px"><strong><?php if($this->lang->line('PaymentStatus') != '') { echo stripslashes($this->lang->line('PaymentStatus')); } else echo "Payment Status";?></strong></td>
							  <td style="width:100px"><strong><?php if($this->lang->line('Approval') != '') { echo stripslashes($this->lang->line('Approval')); } else echo "Approval";?></strong></td>
                             <!--<td width="15%" style="background:#f5f5f5;" ><strong>Action</strong></td>-->
                             </tr>
                            </thead>
                         
                                   <?php 
                                 // echo '<pre>';print_r($bookedRental->result());die;
                                   
                                   
                                   
                                   
                                   foreach($bookedRental->result() as $row)
                                            { ?>
                                    
                                        <tr>
                                        <td><img src="<?php if($row->loginUserType == 'google'){ echo $row->image;} elseif($row->image == '' ){ echo base_url();?>images/site/profile.png<?php } else { echo base_url().'images/users/'.$row->image;}?>" width="100" height="100" alt="image"/> &nbsp;&nbsp;<br /><a target="_blank" href="users/show/<?php echo $row->GestId; ?>" style="float:left;  "><?php echo $row->firstname;?></a></td>
                                        <td class="nw-lite"> <?php if($row->checkin!='0000-00-00 00:00:00' && $row->checkout!='0000-00-00 00:00:00'){ echo "<br>".date('M d',strtotime($row->checkin))." - ".date('M d, Y',strtotime($row->checkout))."<br>";
                                                   echo "<a href='".base_url()."rental/".$row->product_id."'>".$row->product_title."</a><br>";
                                                   echo $row->address."<br>";
                                                   echo $row->city_name.",".$row->state_name." ".$row->post_code."<br>";
                                                   echo $row->country_name."<br>";
												   echo "Boooking No :".$row->Bookingno;}
                                                   ?>
                                        </td>                                        
                                        <td>
										
										<?php
										if($row->is_coupon_used == 'Yes'){
					
					  echo '<li style="color: green;">Coupon: '. $row->coupon_code  .'</li>';
					  echo '<li style="text-decoration: ;">'.strtoupper($currencySymbol)." ".number_format($row->discount*$this->session->userdata('currency_r'),2).'</li>';
					  echo '<li style="text-decoration: line-through;">'.strtoupper($currencySymbol)." ".number_format($row->total_amt*$this->session->userdata('currency_r'),2).'</li>';
					
					}else {
						echo strtoupper($currencySymbol)." ".number_format($row->totalAmt*$this->session->userdata('currency_r'),2);
					}
										?> </td>
                                        <td>
										<?php 
$paymentstatus = $this->cms_model->get_all_details(PAYMENT,array('Enquiryid'=>$row->EnqId));
 $chkval = $paymentstatus->num_rows();

										if($chkval==1) { 
										?>
										 <p><a href="javascript:void(0);" title="Edit Enquiry"><?php echo "Paid"//$row->booking_status; ?></a></p>
										 <p><a href="site/user/invoice/<?php echo $row->Bookingno;?>" target="_blank"><?php if($this->lang->line('Confirmation') != '') { echo stripslashes($this->lang->line('Confirmation')); } else echo "Confirmation";?></a></p>
                                        
                                        <?php } else { echo "Pending"; } ?> 
                                        
                                        </td>
<td>
<?php   if($row->approval=='Pending') { echo 'Approval Pending'; } else { ?>
<?php echo ($row->approval == 'Accept')?'Accepted':'Declined';  ?>
<?php } ?>
</td>

                                        </tr>
                                            <?php   } ?>
                                        </table>
                                       <?php } 
                                    else
                                        { ?>
                            
                            <p class="no_listings">
                                <?php if($this->lang->line('Youhavenoreservations') != '') { echo stripslashes($this->lang->line('Youhavenoreservations.')); } else echo "You have no reservations.";?><br>
                                <?php if($this->uri->segment(2)=="") {?>
                                <a href="<?php echo base_url()."listing-reservation"; ?>"><?php if($this->lang->line('ViewPastReserv') != '') { echo stripslashes($this->lang->line('ViewPastReserv')); } else echo "View Past Reservation History.";?></a>
                                <?php } else {?>
                                <a href="<?php echo base_url()."list_space"; ?>"><?php if($this->lang->line('Createanewisting') != '') { echo stripslashes($this->lang->line('Createanewisting')); } else echo "Create a new listing.";?></a>
                                <?php }?>
                                
                             </p>
                            <?php 
                            }
                            ?>
                   
                </div>

           </div>     
    </div>
           
  </div>
    </div>
</div>
<!---DASHBOARD-->
<!---FOOTER-->
<?php 

$this->load->view('site/templates/footer');
?>