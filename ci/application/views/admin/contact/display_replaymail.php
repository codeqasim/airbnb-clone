<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<form action="admin/contact_us/replaymail1" method="post" class="replaymail-con">
	<ul>				
<li>
 <div><label>Email:</label></div>
  <div> 
						<input class="cnt-bx" type="text" name="replayemail"
         
		  value= " <?php echo $admin_replay->row()->email;?>"> 
		 
	
         
         </div>
		 
		 </li>
		 </ul>
		 <ul>
		 <li>
		 <div>
		<label>REPLY MESSAGE:</label>
		</div>
		 <div><textarea name="your-message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required" aria-required="true" aria-invalid="false"></textarea>
		 </div>
		 </li>
		 <span class="replaymsg-btn"><input type="submit"></span>
		 </ul>
		 

</form>
<?php 
$this->load->view('admin/templates/footer.php');
?>