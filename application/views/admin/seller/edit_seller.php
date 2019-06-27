<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Host</h6>
						<div id="widget_tab">
			              <ul>
			                <li><a href="#tab1" class="active_tab">Host Details</a></li>
			                <li><a href="#tab2">Bank Details</a></li>
							<li><a href="#tab3">Change Password</a></li>
			              </ul>
			            </div>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form');
						echo form_open('admin/seller/insertEditSeller',$attributes);
						
					?>
	 						<div id="tab1">
	 						<ul>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="full_name">First Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="firstname" style=" width:295px" id="full_name" value="<?php echo $seller_details->row()->firstname;?>" type="text" tabindex="1" class="required tipTop" title="Please enter the user fullname"/>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="full_name">Last Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="lastname" style=" width:295px" id="full_name" value="<?php echo $seller_details->row()->lastname;?>" type="text" tabindex="1" class="required tipTop" title="Please enter the user fullname"/>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="gender">I Am</label>
									<div class="form_input">
                                    <select name="gender" id="gender" class=" large tipTop"  title="Please select the gender">
                                    <option value="Male" <?php if($seller_details->row()->gender=='Male'){echo 'selected="selected"';}?>>Male</option>
                                    <option value="Female" <?php if($seller_details->row()->gender=='Female'){echo 'selected="selected"';}?>>Female</option>
                                    <option value="Unspecified" <?php if($seller_details->row()->gender=='Unspecified'){echo 'selected="selected"';}?>>Unspecified</option>
                                    </select>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="gender">Date of birth</label>
									<div class="form_input">
                                    <select name="dob_month" id="user_birthdate_2i" class="valid">
                                        <option value="1" <?php if($seller_details->row()->dob_month=='1'){echo 'selected="selected"';}?> >January</option>
                                        <option value="2" <?php if($seller_details->row()->dob_month=='2'){echo 'selected="selected"';}?>>February</option>
                                        <option value="3" <?php if($seller_details->row()->dob_month=='3'){echo 'selected="selected"';}?>>March</option>
                                        <option value="4" <?php if($seller_details->row()->dob_month=='4'){echo 'selected="selected"';}?>>April</option>
                                        <option value="5" <?php if($seller_details->row()->dob_month=='5'){echo 'selected="selected"';}?>>May</option>
                                        <option value="6" <?php if($seller_details->row()->dob_month=='6'){echo 'selected="selected"';}?>>June</option>
                                        <option value="7" <?php if($seller_details->row()->dob_month=='7'){echo 'selected="selected"';}?>>July</option>
                                        <option value="8" <?php if($seller_details->row()->dob_month=='8'){echo 'selected="selected"';}?>>August</option>
                                        <option value="9" <?php if($seller_details->row()->dob_month=='9'){echo 'selected="selected"';}?>>September</option>
                                        <option value="10" <?php if($seller_details->row()->dob_month=='10'){echo 'selected="selected"';}?>>October</option>
                                        <option value="11" <?php if($seller_details->row()->dob_month=='11'){echo 'selected="selected"';}?>>November</option>
                                        <option value="12" <?php if($seller_details->row()->dob_month=='12'){echo 'selected="selected"';}?>>December</option>
                                        </select>
                                        
                                        
                                        <select name="dob_date" id="user_birthdate_3i">
                                        <?php
                                        for($i=1;$i<=31;$i++){
                                        
                                        echo '<option value="'.$i.'"'; 
                                        if($seller_details->row()->dob_date==$i){echo 'selected="selected"';}
                                        
                                        echo '>'.$i.'</option>';
                                        }
                                        
                                        
                                         ?>
                                        </select>
                                        
                                        <select name="dob_year" id="user_birthdate_1i" class="valid">
                                        <?php 
                                        for($i=2005;$i > 1920;$i--){
                                        
                                        echo '<option value="'.$i.'"'; 
                                        if($seller_details->row()->dob_year==$i){echo 'selected="selected"';}
                                        
                                        echo '>'.$i.'</option>';
                                        }
                                        ?>
                                        </select>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="phone_no">Phone no </label>
									<div class="form_input">
										<input type="text" style=" width:295px" name="phone_no" value="<?php  echo $seller_details->row()->phone_no; ?>" />
									</div>
								</div>
								</li> 
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="s_city">Where You Live</label>
									<div class="form_input">
										<input type="text" style=" width:295px" name="s_city" value="<?php  echo $seller_details->row()->s_city; ?>" />
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Describe Yourself</label>
									<div class="form_input">
										<textarea name="description" style="width:295px;"><?php  echo $seller_details->row()->description; ?></textarea>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="s_city">School</label>
									<div class="form_input">
										<input type="text" style=" width:295px" name="school" value="<?php  echo $seller_details->row()->school; ?>" />
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="work">Work</label>
									<div class="form_input">
										<input type="text" style=" width:295px" name="work" value="<?php  echo $seller_details->row()->work; ?>" />
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="email">Email Address </label>
									<div class="form_input">
										<?php echo $seller_details->row()->email;?>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="image">User Image (Image Size 272px X 272px)</label>
									<div class="form_input">
										<input name="image" id="image" type="file" tabindex="7" class="large tipTop" title="Please select user image" accept="image/*"/>
									</div>
									<div class="form_input"><img src="<?php if($seller_details->row()->image==''){ echo base_url().'images/site/profile.png';}else{ echo base_url();?>images/users/<?php echo $seller_details->row()->image;}?>" width="100px"/></div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="web_url">Website</label>
									<div class="form_input">
										<input type="text" name="web_url" value="<?php echo $seller_details->row()->web_url;?>" class="tipTop large" title="Enter the website url" />
									</div>
								</div>
								</li>
                               <li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>
									</div>
								</div>
								</li>
							</ul>
						</div>
						<div id="tab2">
							<ul>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="accname">Account Name</label>
									<div class="form_input">
										<input type="text" name="accname" value="<?php echo $seller_details->row()->accname;?>" class="tipTop large" title="Enter the bank account Name" />
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="accno">Account Number</label>
									<div class="form_input">
										<input type="text" name="accno" value="<?php echo $seller_details->row()->accno;?>" class="tipTop large" title="Enter the bank account number" />
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Bank Name</label>
									<div class="form_input">
										<input type="text" name="bankname" value="<?php echo $seller_details->row()->bankname;?>" class="tipTop large" title="Enter the bank name" />
									</div>
								</div>
								</li>
								<!----<li>
								<div class="form_grid_12">
									<label class="field_title" for="Acccountry">Account Country</label>
									<div class="form_input">
										 <select id="Acccountry" name="Acccountry">
											<option value="">Select</option>
											<option  value="<?php echo $seller_details->row()->Acccountry;?>" <?php if($seller_details->row()->Acccountry != ''){echo 'selected';}else{ echo 'style="display:none"';} ?>><?php echo $seller_details->row()->Acccountry;?></option>
											
											<?php foreach($active_countries->result() as $active_country) :?>
											<option value="<?php echo $active_country->name;?>"><?php echo $active_country->name;?></option>
											<?php endforeach;?>
											</select>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="swiftcode">Swift Code</label>
									<div class="form_input">
										<input type="text" name="swiftcode" value="<?php echo $seller_details->row()->swiftcode;?>" class="tipTop large" title="Enter the Swiftcode" />
										
										
									</div>
								</div>
								</li>---->
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>
									</div>
								</div>
								</li>
							</ul>
						</div>
						<div id="tab3">
							<ul>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="password">Password</label>
									<div class="form_input">
										<input type="password" name="password" value="" class="tipTop large" id="admin-pass" title="Enter the Password" />
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="confirm-password">Confirm Password</label>
									<div class="form_input">
										<input type="password" name="confirm-password" value="" class="tipTop large" id="admin-cnfm-pass" title="Enter the Confirm Password" />
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" onclick="return checkPassword();" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>
									</div>
								</div>
								</li>
							</ul>
						</div>
						
						<input type="hidden" name="seller_id" value="<?php echo $seller_details->row()->id;?>"/>
						<input type="hidden" name="email" value="<?php echo $seller_details->row()->email;?>"/>
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<script type="text/javascript">
function checkPassword()
{
	if($('#admin-pass').val().length < 6 || $('#admin-pass').val() != $('#admin-cnfm-pass').val())
	{
		alert('Password should be 6 charecter and both same!');
		return false;
	}
	else return true;
}
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>