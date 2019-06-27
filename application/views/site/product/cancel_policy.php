<?php 

$this->load->view('site/templates/header');

$this->load->view('site/templates/listing_head_side');



	$can_policy="";

	$roombedVal=json_decode($listValues->row()->rooms_bed);

	$can_policy=$roombedVal->can_policy;

?>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addProperty.js"></script>

         

            <div class="right_side cancelation">

            

            <div class="dashboard_price_main">

			<?php if($this->lang->line('Pleaseselectyour') != '') { echo stripslashes($this->lang->line('Pleaseselectyour')); } else echo "Please select your cancellation policy. You can read more about the cancellation policy"; ?> <a target="_blank" href="<?php echo 'pages/'.$cancellation_policy->row()->seourl;?>"><?php if($this->lang->line('here') != '') { echo stripslashes($this->lang->line('here')); } else echo "here"; ?> </a>.

           <?php //echo stripslashes($cancellation_policy->row()->description);?>

            </div>

			<div class="cancelation-text dashboard_price_main">

			<label><?php if($this->lang->line('CancellationPolicy') != '') { echo stripslashes($this->lang->line('CancellationPolicy')); } else echo "Cancellation Policy"; ?></label>

			<?php  //echo $listDetail->row()->cancellation_policy;?>

			<select name="cancellation_policy" onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'cancellation_policy');">

			<option value = ""><?php if($this->lang->line('Select') != '') { echo stripslashes($this->lang->line('Select')); } else echo "Select"; ?></option>

			

			<?php

									  if($can_policy!=""){ 

										$can_policyArr=@explode(',',$can_policy);

										foreach($can_policyArr as $rows){

									  ?>

									

									 <option value="<?php echo $rows; ?>"<?php if($listDetail->row()->cancellation_policy == $rows) {echo 'selected="selected"';} ?>>

											<?php echo $rows; ?>

										</option>

									  <?php 

										}

									  } 

									?>

			</select><br>

			<label><?php if($this->lang->line('SecurityDeposit') != '') { echo stripslashes($this->lang->line('SecurityDeposit')); } else echo "Security Deposit"; ?></label>

			<?php if($listDetail->row()->currency != ''){

						$currency_type=$listDetail->row()->currency;

						$currency_symbol_query='SELECT * FROM '.CURRENCY.' WHERE currency_type="'.$currency_type.'"';

						$currency_symbol=$this->product_model->ExecuteQuery($currency_symbol_query);

	

						if($currency_symbol->num_rows() > 0)

						{

							$currency_sym = $currency_symbol->row()->currency_symbols;

						}

						else{

							$currency_sym = '$';

						}

						?>

						

							<span class="WebRupee"><?php echo $currency_sym; ?></span>

						<?php } else { ?>

							<span class="WebRupee">$</span>

						<?php } ?>

			<input type="text" value="<?php echo $listDetail->row()->security_deposit;?>" class="per_amount_scroll"  name="security_deposit" onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'security_deposit');" />

			</div>
			<span class="onclk-text">Want to add SEO tags?&nbsp;<span onclick="show_block_cate('1')">You can add.</span></span>
			<div class="dashboard_price_main" id="monthly" style="display:none" >

				<div class="overview_title">
                        
                        	<label><?php if($this->lang->line('MetaTitle') != '') { echo stripslashes($this->lang->line('MetaTitle')); } else echo "Meta Title";?></label>
                        
                        	<input type="text" value="<?php echo $listDetail->row()->meta_title;?>" placeholder="Meta Title" class="title_overview" 
                           onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'meta_title');" name="meta_title" style="color:#000 !important;" />
                            
                            <input type="hidden" id="id" name="id" value="<?php echo $listDetail->row()->id; ?>" />
                            
                            <!--<span>35 characters left</span>-->
                        
                        </div>
                        
                        
                        <div class="overview_title">
                        
                        	<label><?php if($this->lang->line('Keywords') != '') { echo stripslashes($this->lang->line('Keywords')); } else echo "Keywords";?></label>
                            
                            <textarea class="title_overview" placeholder="<?php if($this->lang->line('Maximum150words') != '') { echo stripslashes($this->lang->line('Maximum150words')); } else echo "Maximum 150 words";?>" rows="8"  onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'meta_keyword');"  name="meta_keyword" id="meta_keyword" style="color:#000 !important;"><?php echo strip_tags($listDetail->row()->meta_keyword);?></textarea>
                        </div>
						
						<div class="overview_title">
                        
                        	<label><?php if($this->lang->line('MetaDescription') != '') { echo stripslashes($this->lang->line('MetaDescription')); } else echo "Meta Description";?></label>
                            
                            <textarea class="title_overview" placeholder="<?php if($this->lang->line('Maximum150words') != '') { echo stripslashes($this->lang->line('Maximum150words')); } else echo "Maximum 150 words";?>" rows="8"  onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'meta_description');"  name="meta_description" id="meta_description" style="color:#000 !important;"><?php echo strip_tags($listDetail->row()->meta_description);?></textarea>
                        </div>

			</div>
			<input type="submit" onclick="window.location.reload(true);" value="Save" class="newline-btn" />

          </div>

            

        </div>

        

    </div>

<script type="text/javascript">

function DeleteListYoutProperty(val){

	//$('#delete_profile_image').disable();

	var res = window.confirm('Are you sure?');

	if(res){

		window.location.href = 'site/product/delete_property_details/'+val;

	}else{

		//$('#delete_profile_image').removeAttr('disabled');

		return false;

	}

}
function show_block_cate(columin_id)

{

  $(".onclk-text").css("display","none");

   $("#monthly").css("display","block");  

}

</script>   

<!---DASHBOARD--> 

<?php

$this->load->view('site/templates/footer');

?>