<?php 
//echo '<pre>';print_r($receiverDetails->row());die;
$this->load->view('site/templates/header');
$count = 0;
?>

<script>
<?php if($unread_count != 0 ){ ?>
var unread = "<?php echo $unread_count; ?>";
$(".unread-icon").text(unread);

<?php } ?>
function sendMessage()
{   

   document.body.style.cursor='wait'; 
	var sender_id = $('#sender_id').val();
	var receiver_id = $('#receiver_id').val();
	var booking_id = $('#bookingno').val();
	var pageURL = $('#pageURL').val();
	var product_id = $('#product_id').val();
	var message_content = $('#message_content').val();
	if(message_content == '')
	{
		alert('Message is required!');
		return false;
	}
	var subject = $('#subject').val();
	$.ajax(
		{
			type: 'POST',
			url: "<?php echo base_url();?>site/user/send_message",
			data: {'sender_id':sender_id, 'receiver_id':receiver_id, 'booking_id':booking_id, 'product_id':product_id, 'message':message_content,'subject':subject},
			success: function(data) 
			{	
				window.location.reload();
			}
		});
}

function confirmation(id, status)
{   document.body.style.cursor='wait';

   
	var pageURL = $('#pageURL').val();
	var booking_id = $('#bookingno').val();
	var sender_id = $('#sender_id').val();
	var receiver_id = $('#receiver_id').val();
	var booking_id = $('#bookingno').val();
	var product_id = $('#product_id').val();
	var subject = $('#subject').val();

	if(status == 'Accept' )
	{
		var message = $('#approve-message').val();
	}
	else if(status == 'Decline')
	{
		var message = $('#decline-message').val();
	}

	if(message == '')
	{
		alert('Message is required!');
		return false;
	}

	if(status != 'Accept' && status != 'Decline'){ alert('Select approval!'); return false;}
	if(status == 'Accept' )
	{
		$.ajax(
		{
			type: 'POST',
			url: "<?php echo base_url();?>site/cms/confirm_booking",
			data: {'sender_id':sender_id, 'receiver_id':receiver_id, 'booking_id':booking_id, 'product_id':product_id, 'message':message,'subject':subject, 'status':status},
			success: function(data) 
			{	
			    window.location.reload();
			}
		});
	}
	else if(status == 'Decline')
	{
		$.ajax(
		{
			type: 'POST',
			url: "<?php echo base_url();?>site/cms/confirm_booking",
			data: {'sender_id':sender_id, 'receiver_id':receiver_id, 'booking_id':booking_id, 'product_id':product_id, 'message':message,'subject':subject, 'status':status},
			success: function(data) 
			{		
				window.location.reload();
			}
		});
	}
}
</script>
<div class="dashboard yourlisting yourlistinghome">
	<div class="top-listing-head">
		<div class="main">   
            <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard">Dashboard</a></li>
                <li class="active"><a href="<?php echo base_url();?>inbox">Inbox</a></li>
                <li><a href="<?php echo base_url();?>listing/all">Your Listing</a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming">Your Trips</a></li>
                <li><a href="<?php echo base_url();?>settings">Profile</a></li>
                <li><a href="<?php echo base_url();?>account">Account</a></li>
                <li><a href="<?php echo base_url();?>plan">Plan</a></li>
            </ul> 
		</div>
	</div>
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
	<div class="conversation-box">
		<div class="main">
			<h2 class="convrs">Conversation with <?php echo $receiverDetails->row()->user_name?></h2>
			<?php if($bookingDetails->row()->renter_id != $userId && $conversationDetails->row()->status == 'Decline'){ ?>
			<div class="top-section">
            <p class="rd-color">Declined </p>
            <p>Don't give up — keep contacting other listings.</p>
            <p>Contacting several places considerably improves your odds of a booking.</p>
            <a class="rd-color" href="#">View Similar Listings</a>

			</div>
			<?php } else if($bookingDetails->row()->renter_id == $userId && $conversationDetails->row()->status == 'Decline'){ ?>
			<div class="top-section">
            <p class="rd-color">Declined </p>
            <p>You was declined the guest for this booking.</p>
            <p>Kindly reply to guest to get more number of guests.</p>
            </div>
			<?php }else if($bookingDetails->row()->renter_id != $userId && $conversationDetails->row()->status == 'Accept'){ ?>
			<div class="top-section">
            <p class="rd-color">Accepted </p>
            <p>Your request for this property was accepted by Host.</p>
            <p>Kindly make a payment and contact Host through this conversation.</p>
            <a class="rd-color" href="#">View Similar Listings</a>

			</div>
			<?php } else if($bookingDetails->row()->renter_id == $userId && $conversationDetails->row()->status == 'Accept'){ ?>
			<div class="top-section">
            <p class="rd-color">Accepted </p>
            <p>You was Accepted the guest for this booking.</p>
            <p>Kindly respond to guest to give a guidance.</p>
            </div>
			<?php }?>

			<div class="col-md-8">
				<div class="top-area-convers">
					<div class="dic-area">
						<textarea id="message_content" class="fstlin-txt" placeholder="Add a Personal message here..." ></textarea>
		
						<div class="botom-botm">
							<input type="hidden" id="sender_id" value="<?php echo $sender_id;?>" />
							<input type="hidden" id="receiver_id" value="<?php echo $receiver_id;?>" />
							<input type="hidden" id="bookingno" value="<?php echo $bookingNo;?>" />
							<input type="hidden" id="product_id" value="<?php echo $productId;?>" />
							<input type="hidden" id="subject" value="<?php echo $conversationDetails->row()->subject;?>" />
							<input type="hidden" id="pageURL" value="<?php echo $pageURL;?>" />
							<input type="hidden" id="baseURL" value="<?php echo base_url();?>" />
							
							<button class="Send-message" onClick="sendMessage();">Send Message</button>
							<?php if($bookingDetails->row()->renter_id == $userId && $conversationDetails->row()->status == 'Pending'){ ?><button  onclick="slidings()" class="Send-decline" >Pre-approve / Decline</button> <?php } 
							if($conversationDetails->row()->status != 'Pending'){$status = ($conversationDetails->row()->status == 'Accept')?'Accepted':'Declined';}?>
						</div>
						<!--<ul class="botm-radio">
						<li><input class = "approval" value="Accept" name="trues" type="radio"><label>Accept</label></li>
						<li><input class = "approval" value="Decline" name="trues" type="radio"><label>Decline</label></li>
						<li>
						<button class="Send-message" onClick="confirmation('<?php echo $bookingDetails->row()->id?>')">Confirm</button></li>
						
						</ul>-->

						<div class="full-hat-app">
								<div class="full-hat-app-header">
                                   <div class="full-hat-app-left">
                                   	<span class="red-ares"><?php echo $bookingDetails->row()->product_title;?></span>
                                   	<span class="date-plac"><?php echo date('M d', strtotime($bookingDetails->row()->checkin));?> - <?php echo date('d, Y', strtotime($bookingDetails->row()->checkout));?>. <?php echo $bookingDetails->row()->NoofGuest;echo ($bookingDetails->row()->NoofGuest > 1)?'Guests':'Guest';?></span>


								</div>


								<div class="full-hat-app-right">
                                     <span class="cls-dolar"><?php echo $this->session->userdata('currency_s').' '.stripslashes($bookingDetails->row()->totalAmt * $this->session->userdata('currency_r')); ?></span>

								</div>

								</div>

								<div class="aloe-div">
                               <span onclick="alowdsliding()" class="alow-thebook">Allow the guest to book</span>
                               <div class="aloe-div-opens">
                               <label>Pre-approve Booking</label>
                               <p>Accept the booking for the specified listing</p>
                               <textarea class="incd-text" id="approve-message" required placeholder="Enter message.."></textarea>
                               

                               <button class="Send-message" onClick="confirmation('<?php echo $bookingDetails->row()->id?>', 'Accept')">Pre-Approve</button>

								</div>
								</div>

						
                                    
								<div class="aloe-div">
                               <span onclick="alowdsliding2()"  class="alow-thebook">Tell the Guest your listing is Unavailable</span>
                                    <div class="aloe-div-opens2">
                               <label>Decline Booking</label>
                               <p>Sorry, the list was unavailable right moment</p>
                               <textarea class="incd-text" id="decline-message" required placeholder="Enter message.."></textarea>

                               <button class="Send-message" onClick="confirmation('<?php echo $bookingDetails->row()->id?>','Decline')">Decline</button>

								</div></div>



						</div>
					</div> 
				</div>
				<ul>
				
				<?php 
				$total = $conversationDetails->num_rows();
				foreach($conversationDetails->result() as  $coversation) {
				$count++;
				if($coversation->point == '1') { ?>
				<li class="booking_msg">
				<label class="line-mesg">	Property <p> <?php echo $bookingDetails->row()->product_title;?></p> was <?php echo ($coversation->status == 'Accept')?'Accepted':'Declined';?><p> on <?php echo date('d/m/Y', strtotime($coversation->dateAdded));?></p></label>
				<span class="line-let">
					<?php  if(date('Y', strtotime($bookingDetails->row()->checkout)) == date('Y', strtotime($bookingDetails->row()->checkin))){ echo date('M d', strtotime($bookingDetails->row()->checkin));} else {echo date('M d, Y', strtotime($bookingDetails->row()->checkin));}?> - <?php if(date('M', strtotime($bookingDetails->row()->checkout)) != date('M', strtotime($bookingDetails->row()->checkin))) { echo date('M d, Y', strtotime($bookingDetails->row()->checkout)); } else { echo date('d, Y', strtotime($bookingDetails->row()->checkout)); } ?>. <?php echo $bookingDetails->row()->NoofGuest;echo ($bookingDetails->row()->NoofGuest > 1)?'Guests':'Guest';?>
					</span></li>
				<?php }else if($sender_id == $coversation->senderId){ ?>
					<li>
						<div class="col-xs-1"><a class="aurtors" href="<?php echo base_url();?>users/show/<?php echo $senderDetails->row()->id?>">
						<img style="border-radius: 50%; width: 32px; height: 33px;" src="<?php if($senderDetails->row()->loginUserType == 'google'){ echo $senderDetails->row()->image;} elseif($senderDetails->row()->image == '' ){ echo base_url();?>images/site/profile.png<?php } else { echo base_url().'images/users/'.$senderDetails->row()->image;}?>"></a></div>
						<div class="col-xs-11">

						
						<div class="conversation">
						<span class="ardsleft"></span>
						<span><?php echo $coversation->message;?></span>

						</div>

						<span class="span-left-area"><?php echo date('d/m/Y', strtotime($coversation->dateAdded));?> via the <label>web</label>


						</span>

						</div>
      
					</li>
					<?php } else { 
					
					if($total == $count) { ?>
					<li class="booking_msg">
				<label class="line-mesg">	Inquiry about<p> <?php echo $bookingDetails->row()->product_title;?></p></label>
				<span class="line-let">
					<?php  if(date('Y', strtotime($bookingDetails->row()->checkout)) == date('Y', strtotime($bookingDetails->row()->checkin))){ echo date('M d', strtotime($bookingDetails->row()->checkin));} else {echo date('M d, Y', strtotime($bookingDetails->row()->checkin));}?> - <?php if(date('M', strtotime($bookingDetails->row()->checkout)) != date('M', strtotime($bookingDetails->row()->checkin))) { echo date('M d, Y', strtotime($bookingDetails->row()->checkout)); } else { echo date('d, Y', strtotime($bookingDetails->row()->checkout)); } ?>. <?php echo $bookingDetails->row()->NoofGuest;echo ($bookingDetails->row()->NoofGuest > 1)?'Guests':'Guest';?>
					</span></li>
					<?php $first = 1; } ?>

					<li class="evenli">
     
						<div class="col-xs-11">

						<div class="conversation">
						<span class="ardsleft"></span>
						<span><?php echo $coversation->message;?></span>

						</div>

						<span class="span-left-area"><?php echo date('d/m/Y', strtotime($coversation->dateAdded));?> via the <label>web</label>


						</span>

						</div>
      
						<div class="col-xs-1"><a class="aurtors" href="<?php echo base_url();?>users/show/<?php echo $receiverDetails->row()->id?>">
						<img style="border-radius: 50%; width: 32px; height: 33px;" src="<?php if($receiverDetails->row()->loginUserType == 'google'){ echo $receiverDetails->row()->image;} elseif($receiverDetails->row()->image == '' ){ echo base_url();?>images/site/profile.png<?php } else { echo base_url().'images/users/'.$receiverDetails->row()->image;}?>"></a></div>
   
					</li>
					<?php } }?>
				</ul>
			</div>


    <div class="col-md-4">
    	<div class="right-artrs">
          <div class="profile-topd">
          <div class="profile-topd-left">
        <img src="<?php if($receiverDetails->row()->loginUserType == 'google'){ echo $receiverDetails->row()->image;} elseif($receiverDetails->row()->image == '' ){ echo base_url();?>images/site/profile.png<?php } else { echo base_url().'images/users/'.$receiverDetails->row()->image;}?>">
           </div>

           <div class="profile-topd-right">

           	<span><?php echo $receiverDetails->row()->user_name;?></span>
           	
           	<address><?php echo $receiverDetails->row()->address?></br> Member since <?php echo date('Y', strtotime($receiverDetails->row()->created));?></address>

           </div>

           <div class="profile-topd-middle">
           	<span>Verifications<?php echo$receiverDetails->row()->is_verified;?></span>
           	 <ul class="verid">
			 
				
				<?php if($receiverDetails->row()->id_verified == 'Yes') {?>
           	 	<li class="verified">
					  <p>Email Address</p>
					  <label>Verified</label>
           	 	</li>
				<?php } else { ?>
           	 	<li class="not-verified">
					  <p>Email Address</p>
					  <label>Not Verified</label>
           	 	</li>
				<?php } ?>
				
				<?php if($receiverDetails->row()->ph_verified == 'Yes') {?>
           	 	<li class="verified">
					  <p>Phone number</p>
					  <label>Verified</label>
           	 	</li>
				<?php } else { ?>
           	 	<li class="not-verified">
					  <p>Phone number</p>
					  <label>Not Verified</label>
           	 	</li>
				<?php } ?>
				
				<?php if($receiverDetails->row()->is_verified == 'Yes') {?>
           	 	<li class="verified">
					  <p>Verified ID</p>
					  <label>Yes</label>
           	 	</li>
				<?php } else { ?>
           	 	<li class="not-verified">
					  <p>Verified ID</p>
					  <label>No</label>
           	 	</li>
				<?php } ?>
				
				<?php if($reviewCount > 0) {?>
           	 	<li class="verified">
				<?php } else { ?>
				<li class="not-verified">
				<?php } ?>
					  <p>Review</p>
					  <label><?php echo $reviewCount;?> review</label>
           	 	</li>


           	</ul>
           </div>

          </div>
</div>
         

  <!--<div class="help-block">

  	<span>Help</span>

  	<ul>
    <li>How do i get paid?</li> 	
    <li>How do i received contact info?</li> 
    <li>Can i Call the other person?</li> 	
    <li>How do i pay?</li> 	
    <li>How do i Contact holidan?</li> 	



  	</ul>

  	<a class="faqs" href="#">See FAQ for more help</a>

  </div>

  <div class="help-block">

  	<span>Safety</span>
  	<a class="faqs" href="#">Educte yourself about safety</a>

  </div>


  <div class="help-block">

  	<img src="images/icon.png">
  	<a class="faqs" href="#">See FAQ for more help</a>

  </div>

  <div class="help-block">

  	<span>Email Address</span>

  	<ul>
    <li>Your phone number listing address and an version of your email address</li> 	
  


  	</ul>

  	<a class="faqs" href="#">Learn more about Emails</a>

  </div>


  <div class="help-block">

  	<span>How do i pay?</span>

  	<ul>
    <li>Your phone number listing address and an version of your email address</li> 	
  


  	</ul>

  	

  </div>
    	



    </div> -->


	</div>

</div>

</div>

<style>

.conversation-box ul li.booking_msg{
    background: none repeat scroll 0 0 #edefed;
    border: 1px solid #ccc;
    font-size: 14px;
    padding: 12px 10px;
}

.conversation-box ul li.booking_msg span span{
    color: #acacac;
    float: left;
    width: 100%;
}
.line-mesg {
    color: #9c9c9c;
    float: left;
    font-size: 15px;
    font-weight: bold;
    margin: 0 0 9px;
    width: 100%;
}

.fstlin-txt{border:none; box-shadow:none;}

.fstlin-txt:focus{border:none; box-shadow:none;}


.line-mesg p{
    color: #ff5a5f;
    display: inline-block;
    margin: 0 0 0 8px;
}

.Send-decline {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 1px solid #bcbcbc;
    float: right;
    font-size: 14px;
    margin: 21px 10px 0 10px;
    padding: 8px;
}

.botm-radio{
    border-top: 1px solid #eeeeee;
    float: left;
    padding: 20px 0 0;
    width: 100%;
}

.botm-radio{display:none;}

.conversation-box ul.botm-radio li{float:left; width:100%; padding:0; margin:0;}

.conversation-box ul.botm-radio li input[type="radio"]{
    display: inline-block;
    margin: 0 4px;
}

.conversation-box ul.botm-radio li button{margin:0}
.conversation-box ul.botm-radio li label{display: inline-block;}

.full-hat-app{display:none;}

.loading-bar{
padding: 20px;
border: 1px solid green;


}

</style>

<script>

$(function(){
$(".aloe-div-opens3").hide();
});
function slidings(){

$(".botom-botm").hide();
$(".fstlin-txt").hide();
$(".dic-area").css('padding','0');
$(".full-hat-app").slideDown();
};

function alowdsliding(){
$(".aloe-div-opens2").hide();
$(".aloe-div-opens").slideToggle();
$(".aloe-div-opens3").hide();

}


function alowdsliding2(){
$(".aloe-div-opens").hide();
$(".aloe-div-opens2").slideToggle();
$(".aloe-div-opens3").hide();

}

function alowdsliding3(){
$(".aloe-div-opens").hide();
$(".aloe-div-opens2").hide();
$(".aloe-div-opens3").slideToggle();

}
</script>

<?php
$this->load->view('site/templates/footer');
?>

