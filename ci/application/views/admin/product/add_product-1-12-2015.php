<?php
$this->load->view('admin/templates/header.php');
?>
<?php
	$bedrooms="";
	$beds="";
	$bedtype="";
	$bathrooms="";
	$noofbathrooms="";
	$min_stay="";
	$accommodates="";
	$can_policy="";
if($listValues->num_rows()==1){
	$roombedVal=json_decode($listValues->row()->rooms_bed);
	$bedrooms=$roombedVal->bedrooms;
	$beds=$roombedVal->beds;
	$bedtype=$roombedVal->bedtype;
	$bathrooms=$roombedVal->bathrooms;
	$noofbathrooms=$roombedVal->noofbathrooms;
	$min_stay=$roombedVal->min_stay;
	$accommodates=$roombedVal->accommodates;
	$can_policy=$roombedVal->can_policy;
}
//echo  $product_details->row()->id; die;

									  // if($accommodates!=""){ 
										// $accommodatesArr=@explode(',',$accommodates);
										// foreach($accommodatesArr as $r){

									  // echo $r; 
									  // }
									  // }
									  
?>
<!-- <script type="text/javascript" src="js/map_google_load.js"></script> -->  
<script src='http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->config->item('google_map_api');?>'></script>    
<script type="text/javascript" src="js/map_find.js"></script>      
      
<script type="text/javascript">


function list_amenities(evt)
{
if($(evt).is(":checked")){
	var am = $(evt).val();
	//alert(am);
	//$(".dashboard_price_right ul li").append('<li><a>Message Center</a></li>');
	$.ajax({
        type: 'POST',
        url: baseURL+'admin/product/get_sublist_values',
        data: {"list_value_id":am},
        dataType:'json',
        success: function(response)
		{
       	 	//alert("cccccc");
       		$(evt).parents('li').append(response.amenities);
		}
        });
}
else 
{
//	alert("UNchecked");
	$(evt).parents('li').find('ul').remove();
}
}


function ImageAddClick(){
var idval =$('#prdiii').val();
//alert(idval);
$(".dragndrop1").colorbox({width:"1000px", height:"500px", href:baseURL+"admin/product/dragimageuploadinsert/?id="+idval});
}
</script>



<script type="text/javascript">
		function delimage(val){
		$('#row'+val).remove();
		}
		
		 $(function() {
			
		
		/* product Add images dynamically */
	var i = 1;
	
	
	$('#add').click(function() {
	
			$('<div id="row'+i+'" class="control-group field"><input type="text" class="small tipTop" name="imgtitle[]"  maxlength="25"  placeholder="Caption" /> <input class="small tipTop"  placeholder="Priority" name="imgPriority[]" type="text"><div class="uploader" id="uniform-productImage" style=""><input type="file" class="large tipTop" name="product_image[]" id="product_image" onchange="Test.UpdatePreview(this,'+i+')" style="opacity: 0;"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div><img style="display: inline-block; margin: 0 10px; position: relative;top: 13px;" class="img'+i+'" width="150" height="150" alt="" src="images/noimage.jpg"><a href="javascript:void(0);" onclick="return delimage('+i+');"><div class="rmv_btn">Remove</div></a></div></div><br />').fadeIn('slow').appendTo('.imageAdd');
			i++;
		});
	
			Test = {
        UpdatePreview: function(obj,ival){
          // if IE < 10 doesn't support FileReader
          if(!window.FileReader){
             // don't know how to proceed to assign src to image tag
          } else {
             var reader = new FileReader();
             var target = null;
             
             reader.onload = function(e) {
              target =  e.target || e.srcElement;
			 
               $(".img"+ival).prop("src", target.result);
             };
              reader.readAsDataURL(obj.files[0]);
          }
        }
    };					 
		
		$('#remove').click(function() {
									
		if(i > 0) {
			$('.field:last').remove();
			i--; 
		}
		});
		
		$('#reset').click(function() {
		
			$('.field').remove();
			$('.field').remove();
			$('#add').show();
			i=0;
		
		
		});
		
		$('#add').click(function() {
		if(i > 15) {
			$('#add').hide();
		
		}
		});
		});
	/* end */

		
		
	</script>
	<script type="text/javascript">
		function updateDatabase(newLat, newLng)
		{//alert(newLat+'-----'+newLng);
		
		$('#latitude').val(newLat);
		$('#longitude').val(newLng);
			// make an ajax request to a PHP file
			// on our site that will update the database
			// pass in our lat/lng as parameters
			
		}
	</script>
    
    
    
    
    
    
	<?php  //echo $map['js']; ?>
</head>


<style>
.form_container ul li {
    position: static;
}
#map_canvas{

width:50% !important;}
</style>
<script>
$(document).ready(function(){
	$('.nxtTab').click(function(){
		var cur = $(this).parent().parent().parent().parent().parent();
		cur.hide();
		cur.next().show();
		var tab = cur.parent().parent().prev();
		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
	});
	$('.prvTab').click(function(){
		var cur = $(this).parent().parent().parent().parent().parent();
		cur.hide();
		cur.prev().show();
		var tab = cur.parent().parent().prev();
		tab.find('a.active_tab').removeClass('active_tab').parent().prev().find('a').addClass('active_tab');
	});
	$('#tab2 input[type="checkbox"]').click(function(){
		var cat = $(this).parent().attr('class');
		var curCat = cat;
		var catPos = '';
		var added = '';
		var curPos = curCat.substring(3);
		var newspan = $(this).parent().prev();
		if($(this).is(':checked')){
			while(cat != 'cat1'){
				cat = newspan.attr('class');
				catPos = cat.substring(3);
				if(cat != curCat && catPos<curPos){
					if (jQuery.inArray(catPos, added.replace(/,\s+/g, ',').split(',')) >= 0) {
					    //Found it!
					}else{
						newspan.find('input[type="checkbox"]').attr('checked','checked');
						added += catPos+',';
					}
				}
				newspan = newspan.prev(); 
			}
		}else{
			var newspan = $(this).parent().next();
			if(newspan.get(0)){
				var cat = newspan.attr('class');
				var catPos = cat.substring(3);
			}
			while(newspan.get(0) && cat != curCat && catPos>curPos){
				newspan.find('input[type="checkbox"]').attr('checked',this.checked);	
				newspan = newspan.next(); 	
				cat = newspan.attr('class');
				catPos = cat.substring(3);
			}
		}
	});
		
});
</script>
<script language="javascript">
function viewAttributes(Val){

	if(Val == 'show'){
		document.getElementById('AttributeView').style.display = 'block';
	}else{
		document.getElementById('AttributeView').style.display = 'none';
	}

}
</script>
<script>
$(document).ready(function(){

	//loadMap();
	var i = 1;
	
	
	$('#add').click(function() { 
//<!--		$('<div style="float: left; margin: 12px 10px 10px; width:85%;" class="field"><div class="image_text" style="float: left;margin: 5px;margin-right:50px;"><span>Attribute:</span><select name="attribute_name[]" style="width:200px;color:gray;width:206px;" class="chzn-select"><?php //foreach ($atrributeValue->result() as $attrRow){ ?><option value="<?php //echo $attrRow->attribute_name;; ?>"><?php //echo $attrRow->attribute_name; ?></option> <?php //} ?></select></div><div class="attribute_box attrInput" style="float: left;margin: 5px;width: 20%;" ><span>Value :</span><input type="text" style="width:100px;"  name="attribute_val[]" ></div><div class="image_price attrInput" style="float: left;margin: 5px;width: 20%;"><span>Weight :</span><input type="text" style="width:100px;" name="attribute_weight[]" ></div><div class="image_price attrInput" style="float: left;margin: 5px;width: 20%;"><span>Price :</span><input type="text" style="width:100px;" name="attribute_price[]" ></div></div>').fadeIn('slow').appendTo('.inputs');-->
		$('<div style="float: left; margin: 12px 10px 10px; width:85%;" class="field">'+
				'<div class="image_text" style="float: left;margin: 5px;margin-right:50px;">'+
					'<span>List Name:</span>&nbsp;'+
					'<select name="attribute_name[]" onchange="javascript:loadListValues(this)" style="width:200px;color:gray;width:206px;" class="chzn-select">'+
						'<option value="">--Select--</option>'+
						<?php foreach ($atrributeValue->result() as $attrRow){ 
							if (strtolower($attrRow->attribute_name) != 'price'){
						?>
						'<option value="<?php echo $attrRow->id; ?>"><?php echo $attrRow->attribute_name; ?></option>'+
						<?php }} ?>
					 '</select>'+
				'</div>'+
				'<div class="attribute_box attrInput" style="float: left;margin: 5px;" >'+
					 '<span>List Value :</span>&nbsp;'+
					 '<select name="attribute_val[]" style="width:200px;color:gray;width:206px;" class="chzn-select">'+
					 '<option value="">--Select--</option>'+
					 '</select>'+
				'</div>'+
		'</div>').fadeIn('slow').appendTo('.inputs');
		i++;
	});
	
	$('#remove').click(function() {
		$('.field:last').remove();
	});
	
	$('#reset').click(function() {
		$('.field').remove();
		$('#add').show();
		i=0;
	
	
	});
	
	
	var j = 1;
	$('#addAttr').click(function() { 
		$('<div style="float: left; margin: 12px 10px 10px; width:85%;" class="field">'+
				'<div class="image_text" style="float: left;margin: 5px;margin-right:50px;">'+
					'<span>Attribute Name:</span>&nbsp;'+
					'<select name="product_attribute_name[]" style="width:200px;color:gray;width:206px;" class="chzn-select">'+
						'<option value="">--Select--</option>'+
						<?php foreach ($PrdattrVal->result() as $prdattrRow){ ?>
						'<option value="<?php echo $prdattrRow->id; ?>"><?php echo $prdattrRow->attr_name; ?></option>'+
						<?php } ?>
					 '</select>'+
				'</div>'+
				'<div class="attribute_box attrInput" style="float: left;margin: 5px;" >'+
					 '<span>Attribute Price :</span>&nbsp;'+
					 '<input type="text" name="product_attribute_val[]" style="width:75px;color:gray;" class="chzn-select" />'+
				'</div>'+
		'</div>').fadeIn('slow').appendTo('.inputss');
		j++;
	});
	
	$('#removeAttr').click(function() {
		$('.field:last').remove();
	});
	
	
	

});
</script>

<script>

function runScript(e) {
    if (e.keyCode == 13) {
        var tb = document.getElementById("product_title");
        eval(tb.value);
        return false;
    }
}




</script>






<script src="js/site/addProperty.js"></script>

<div id="content">
  <div class="grid_container">
    <div class="grid_12">
      <div class="widget_wrap">
        <div class="widget_top"> <span class="h_icon list"></span>
          <h6>Add New Property</h6>
          <!--<a class="inline cboxElement" href="#inline_content">Inline HTML</a>-->
          <div id="widget_tab">
            <ul>
              <li><a href="#tab1" class="active_tab">Property General Information</a></li>
              <li><a href="#tab2">Images</a></li>
              <li><a href="#tab3">Amenities</a></li>
              <li><a href="#tab4">Address & Availability Information</a></li>
              <li><a href="#tab5">Listing</a></li>
              <li><a href="#tab6">Detailed description</a></li>
              <li><a href="#tab7">SEO</a></li>
            </ul>
          </div>
        </div>
        <div class="widget_content">        
          <?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addproduct_form1111', 'enctype' => 'multipart/form-data');
						echo form_open_multipart('admin/product/UpdateProduct',$attributes)
						
					?>
                    <input type="hidden" name="latitude" id="latitude" value="37.4419" />
                    <input type="hidden" name="longitude" id="longitude" value="-122.1419" />
                   <!-- <input type="text" name="prdiii" id="prdiii" value="<?php //echo $id=$this->uri->segment(4,0); ?>" />-->
                    <input type="hidden" name="prdiii" id="prdiii" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->id)); } else { echo "0";}?>" />
          <div id="tab1">
            <ul class="tab-areas1">
            	<li>
                <div class="form_grid_12">
                  <label class="field_title" for="user_id">Property Owner Name <span class="req">*</span></label>
                  <div class="form_input">
                  <?php 
				  if(!empty($userdetails)){ echo '<select name="user_id" >';
				  	foreach($userdetails->result() as $user_details){
				  
				  
				  ?>
                 
                  <option value="<?php echo $user_details->id;?>" <?php if(!empty($product_details)){ if($user_details->id==$product_details->row()->OwnerId){echo 'selected="selected"';} } ?>><?php echo ucfirst($user_details->firstname).' '.ucfirst($user_details->lastname);?></option>
                  
                 <?php  
				 	} echo '</select>';
				 } ?>
                    
                    
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="product_title">Title <span class="req">*</span></label>
                  <div class="form_input">
                  <?php if(!empty($product_details)){  $Valid = trim(stripslashes($product_details->row()->id)); } else {  $Valid=0;}?>
                    <input name="product_title" id="product_title" type="text" tabindex="1" class="required large tipTop" title="Please enter the product name" onchange="javascript:AdminDetailview(this,document.getElementById('prdiii').value,'price');"  onkeypress="return runScript(event);"  onkeydown = "return (event.keyCode!=13);"
                    value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->product_title)); }?>"/>
                    
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="description">Summary</label>
                  <div class="form_input">
                    <textarea name="description" id="description" tabindex="2" style="width:370px;" class="tipTop mceEditor" title="Please enter the product description"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->description)); }?></textarea>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="price">Price per night<span class="req">*</span></label>
                  <div class="form_input">
                    <input type="text" name="price" id="price" tabindex="9" class="required large tipTop" title="Please enter the product price" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->price)); }?>"  onchange="javascript:PriceInsert(this.value,document.getElementById('prdiii').value,'price');"/>
                      
                        
                  </div>
                </div>
              </li>
              
              
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="price_perweek">Long-Term Prices </label>
                  <div class="form_input">
                    
                    <input name="price_perweek" id="price_perweek" type="text" tabindex="10" class="large tipTop" title="Please enter the product Price Per Week" placeholder="Per Week" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->price_perweek)); }?>" onchange="javascript:PriceInsert(this.value,document.getElementById('prdiii').value,'price_perweek');"/>
                    <input name="price_permonth" id="price_permonth" type="text" tabindex="11" class="large tipTop" title="Please enter the product Price Per Month" placeholder="Per Month" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->price_permonth)); }?>" onchange="javascript:PriceInsert(this.value,document.getElementById('prdiii').value,'price_permonth');"/>
                  </div>
                </div>
              </li>
              
               <li style="display:none">
                <div class="form_grid_12">
                  <label class="field_title" for="description">Deal Amount</label>
                  <div class="form_input">
                    <input type="text" name="deal_amount" id="deal_amount" tabindex="9" class="required large tipTop" title="Please enter deal amount" value="<?php if(!empty($ProductDealPrice)){ echo trim(stripslashes($ProductDealPrice->row()->deal_amount)); }?>"  
		onchange="DealPriceInsert(this.value,'deal_amount');"/>
                  </div>
                </div>
              </li>
			  
			   <li style="display:none">
                <div class="form_grid_12">
                  <label class="field_title" for="description">Deal Start Date</label>
                  <div class="form_input">
                    <input type="text" name="deal_start_date" id="deal_start_date" tabindex="9" class="required large tipTop datepicker" title="Please select deal start date" value="<?php if(!empty($ProductDealPrice)){ echo trim(stripslashes($ProductDealPrice->row()->deal_start_date)); }?>"  
					onchange="DealPriceInsert(this.value,'deal_start_date');"/>
                  </div>
                </div>
              </li>
			  
			   <li style="display:none">
                <div class="form_grid_12">
                  <label class="field_title" for="description">Deal End Date</label>
                  <div class="form_input">
                    <input type="text" name="deal_end_date" id="deal_end_date" tabindex="9" class="required large tipTop datepicker" title="Please select deal end date" value="<?php if(!empty($ProductDealPrice)){ echo trim(stripslashes($ProductDealPrice->row()->deal_end_date)); }?>"  onchange="DealPriceInsert(this.value,'deal_end_date');"/>
                  </div>
                </div>
              </li>
			  
			  <!-- <li>
                <div class="form_grid_12">
                  <label class="field_title" for="admin_name">Deal Status <span class="req">*</span></label>
                  <div class="form_input">
                    <div class="active_inactive">
                      <input type="checkbox" tabindex="11" name="deal_status" checked="checked" id="publish_unpublish_publish" class="publish_unpublish"/>
                    </div>
                  </div>
                </div>
              </li>-->
			  
              
              
              
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="admin_name">Status <span class="req">*</span></label>
                  <div class="form_input">
                    <div class="publish_unpublish">
                      <input type="checkbox" tabindex="11" name="status" checked="checked" id="publish_unpublish_publish" class="publish_unpublish"/>
                    </div>
                  </div>
                </div>
              </li>
              
            
              
              <li>
                <div class="form_grid_12">
                  <div class="form_input">
                    <input type="button" class="btn_small btn_blue nxtTab" tabindex="9" value="Next"/>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div id="tab2">
            <ul class="tab-areas2">
              <li>
               
               
               <?php //include('img_upload.php'); ?>
               
                 <div class="form_grid_12">
                  <label class="field_title" for="product_image">Rental Image <span class="req">*</span></label>
              
                    
                    <div class="dragndrop1"><button onclick="ImageAddClick();">Choose Image</button></div>
                </div>
              </li>
              <li>
                <div class="widget_content">
                  <table class="display display_tbl" id="image_tbl">
                    <thead>
                      <tr align="center">
                        <th > Sno </th>
                        <th> Image </th>
                        <!--<th> Position </th>-->
                        <th> Action </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
					      // echo "<pre>";print_r($imgDetail->result_array());
							if (!empty($imgDetail) && !empty($product_details)){
								$i=0;$j=1;
								$this->session->set_userdata(array('product_image_'.$product_details->row()->id => $product_details->row()->image));
								foreach ($imgDetail->result() as $img){
									if ($img != ''){
							?>
                      <tr id="img_<?php echo $img->id ?>">
                        <td class="center tr_select "><input type="hidden" name="imaged[]" value="<?php echo $img->product_image; ?>"/>
                          <?php echo $j;?> </td>
                        <td class="center "><img src="<?php echo base_url();?>server/php/rental/<?php echo $img->product_image; ?>"  height="80px" width="80px" /> </td>
<!--                        <td class="center"><span>
                          <input type="text" style="width: 15%;" name="changeorder[]" value="<?php echo $i; ?>" size="3" />
                          </span> </td>
-->                        <td class="center tr_select"><ul class="action_list" style="background:none;border-top:none;">
                            <li style="width:100%;"><a class="p_del tipTop" href="javascript:void(0)" onClick="javascript:DeleteProductImage(<?php echo $img->id; ?>,<?php echo $product_details->row()->id; ?>);" title="Delete this image">Remove</a></li>
                          </ul></td>
                      </tr>
                      <?php 
							$j++;
									}
									$i++;
								}
							}
							?>
                    </tbody>
                    <tfoot>
                      <tr align="center">
                        <th> Sno </th>
                        <th> Image </th>
                        <!--<th> Position </th>-->
                        <th> Action </th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <div class="form_input">
                    <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Prev"/>
                    <input type="button" class="btn_small btn_blue nxtTab" tabindex="9" value="Next"/>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          
			<div id="tab3">
				<?php  
					if(!empty($product_details)) {
                         $list_name = $product_details->row()->list_name;						  
						 $facility = (explode(",", $list_name));  
					}    
				?> 
				<?php if($listNameCnt->num_rows()>0){ ?>
				<ul  class="tab-areas3">
					<?php 
					foreach($listNameCnt->result() as $listVals){
					$listValues = $this->product_model->get_all_details(LIST_VALUES,array('list_id'=>$listVals->id));
					?>
					<h3><?php echo $listVals->attribute_name; ?></h3>
					<p><?php echo $listVals->attribute_title; ?> </p>
					<?php  
					if($listValues->num_rows()>0){	
						foreach($listValues->result() as $details){
					?>
                    <li>
						<input type="checkbox" class="checkbox_check" name="list_name[]" id="mostcommon<?php echo $details->id; ?>"  <?php if(in_array($details->id,$facility)) { ?> checked="checked" <?php } ?> value="<?php echo $details->id; ?>"/>
						<span><?php echo $details->list_value; ?></span>
                    </li>
                    <?php 
							}
						}
					}					
                    ?>      
					<li class="btnsa">
						<div class="form_grid_12">
							<div class="form_input" style="margin:0px;width:100%;">
								<input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Prev"/>
								<input type="button" class="btn_small btn_blue nxtTab" tabindex="9" value="Next"/>
							</div>
						</div>
					</li>
				</ul>
			<?php } ?>
			</div>
         
       
          
         <div id="tab4">
            <ul id="AttributeView">
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="country">Country<span class="req">*</span></label>
                  <div class="form_input">
                     <select class="chzn-select required" onchange="javascript:loadCountryListValues(this);update_Country();" name="country" tabindex="-1" style="width: 375px; display: none;" data-placeholder="Please select the country name">
                      <option value=""></option>
                      <?php foreach ($RentalCountry->result() as $row){ ?>
                      
                      <option value="<?php echo $row->id;?>" <?php if(!empty($product_details)) { if($row->id==$product_details->row()->country){ echo 'selected="selected"'; } }?>><?php echo $row->name;?></option>
                      <?php }?>
                    </select>
					<input type="hidden" id="load_lat" value = "<?php echo $product_details->row()->latitude;?>"/>
					<input type="hidden" id="load_lan" value = "<?php echo $product_details->row()->longitude;?>"/>
                  </div>
                </div>
              </li>
<?php if(!empty($product_details) && $product_details->row()->state!=''){?>
<script type="text/javascript">
			  setTimeout(function update_Country(){
			  	$('.state_sel').val('<?php echo $product_details->row()->state; ?>');
			  },2000);
			  function update_Country(){
			  //alert("sss");
			  	$('.state_sel').val('<?php echo $product_details->row()->state; ?>');
			  }
			  
			  setTimeout(function update_State(){
			  	$('.city_sel').val('<?php echo $product_details->row()->city; ?>');
			  },4000);
			  function update_State(){
			 // alert("sss");
			  	$('.city_sel').val('<?php echo $product_details->row()->city; ?>');
			  }
			
</script>
<?php }else{?> 
<script type="text/javascript">

			setTimeout(function update_Country(){
			  	//$('.state_sel').val('1');
			  },2000);
			  function update_Country(){
			  //alert("sss");
			  	//$('.state_sel').val('1');
			  }
			  
			  setTimeout(function update_State(){
			  	//$('.city_sel').val('1');
			  },4000);
			  function update_State(){
			  //alert("sss");
			  	//$('.state_sel').val('1');
			  }

</script>
<?php } ?>  

    




           
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="state">State<span class="req">*</span></label>
                  <div class="form_input" id="listCountryCnt">
                    <select class="chzn-select required state_sel" name="state" onchange="javascript:loadStateListValues(this);update_State();" tabindex="-1" style="width: 375px; display: none;" data-placeholder="Please select the state name">
                      <option value=""></option>
                     
                      <?php foreach ($RentalState->result() as $row){ ?>
					 
                      
                      <option value="<?php echo $row->id;?>" ><?php echo $row->name;?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </li>
              
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="city">City<span class="req">*</span></label>
                  <div class="form_input" id="listStateCnt">
                    <select class="chzn-select required city_sel" name="city" tabindex="-1" style="width: 375px; display: none;" data-placeholder="Please select the city name">
                       <option value="">Select City</option>
                      <?php foreach ($RentalCity->result() as $row){
											
											
											?>
                      <option value="<?php echo $row->id;?>"><?php echo $row->name;?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </li>
               <li>
                <div class="form_grid_12">
                  <label class="field_title" for="address">Street Address</label>
                  <div class="form_input">
                    <textarea onblur="load(); return false" name="address" id="address" tabindex="3" style="width:370px;" class="large tipTop" title="Enter address"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->address)); }?></textarea>
                  </div>
                  <div style="margin-left:30%;margin-top:10px;">
					 <table  bgcolor="#FFFFCC" width="300">
					  <tr>
					    <td><b>Latitude</b></td>
					    <td><b>Longitude</b></td>
					  </tr>
					  <tr>
					    <td id="lat"></td>
					    <td id="lng"></td>
					  </tr>
					</table>
					  <div align="center" id="map" style="width: 600px; height: 300px"><p style="margin-top:150px;">Map will be displayed here</p></div>
                  </div>
                </div>
              </li>
               <li>
                <div class="form_grid_12">
                  <label class="field_title" for="address">Apt, Suite, Bldg.(optional)</label>
                  <div class="form_input">
                    <input type="text" name="apt" id="apt" tabindex="3" style="width:370px;" class="large tipTop" title="Enter the Apt, Suite, Bldg" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->apt)); }?>"/>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="post_code">Zip Code<span class="req">*</span></label>
                  <div class="form_input">
                    <input type="text" name="post_code" id="post_code" tabindex="8" class="large tipTop" title="Please enter the post code" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->post_code)); }?>" />
                  </div>
                </div>
              </li>
              
              <li style="display:none;">
                <div class="form_grid_12">
                  <label class="field_title" for="neighborhood">Neighborhoods</label>
                  <div class="form_input">
<select class="chzn-select " name="neighborhood[]" multiple="multiple" tabindex="1" style="width: 375px;" data-placeholder="Please select the neighborhood ">
                                                <?php 
                                                $NeiborArr=array();
                                                if(!empty($product_details)){
                                                	$NeiborArr=@explode(',',$product_details->row()->neighborhood); 
                                                }
                                                if($NeiborCity->num_rows() > 0){
                                                	foreach ($NeiborCity->result() as $row){
                                                ?>
                                                    <option value="<?php echo trim(stripslashes($row->seourl));?>" <?php if(in_array($row->seourl,$NeiborArr)){echo 'selected="selected"';} ?>> <?php echo $row->name;?></option>
                                                <?php }}?>
                                        </select>                  </div>
                </div>
              </li>
             
             
             
             <li>
              <!-- <h4>Available Information </h4></li>-->
			  </ul>
              <!--<li>
                <div class="form_grid_12">
                  <label class="field_title" for="datefrom">Availabe From: <span class="req">*</span></label>
                  <div class="form_input">
                    <input name="datefrom" id="datefrom" type="text" tabindex="5" class="required small tipTop datepicker" title="Please select the date" 
                    value="<?php if(!empty($product_details)){ echo $product_details->row()->DATEFROM; }?>"/>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="dateto">Available To: <span class="req">*</span></label>
                  <div class="form_input">
                    <input name="dateto" id="dateto" type="text" tabindex="6" class="required small tipTop datepicker" title="Please select the date" 
                    value="<?php if(!empty($product_details)){ echo $product_details->row()->DateTo; }?>"/>
                  </div>
                </div>
              </li>
             </ul>-->
			 <!--<a style="padding:4px 0 !important; height:auto !important; width:150px; margin:0 auto;  " class="btn_small btn_green btn_blue" onclick="popup()">Calculate</a>-->
            <ul>
              <li>
                <div class="form_grid_12">
                  <div class="form_input" style="margin:0px;width:100%;">
                    <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Prev"/>
                    <input type="button" class="btn_small btn_blue nxtTab" tabindex="9" value="Next"/>
                  </div>
                </div>
              </li>
            </ul>
          </div>
     
          <div id="tab5">
            <ul>
            
              <h4>Listing Info:</h4>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Home Type</label>
                  <div class="form_input">
                    
					<select name="home_type" id="home_type">
                    <option value="Apartment" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'Apartment') echo 'selected="selected"'; }?>>Apartment</option>
                    	  <option value="house" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'house') echo 'selected="selected"'; }?>>House</option>
                          <option value="bed breakfast"<?php if(!empty($product_details)) { if($product_details->row()->home_type == 'bed breakfast') echo 'selected="selected"'; }?>>Bed &amp; Breakfast</option>
                          <option value="loft"<?php if(!empty($product_details)) { if($product_details->row()->home_type == 'loft') echo 'selected="selected"'; } ?>>Loft</option>
                          <option value="cabin"<?php if(!empty($product_details)) { if($product_details->row()->home_type == 'cabin') echo 'selected="selected"'; }?>>Cabin</option>
                                      
                                      <option value="villa" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'villa') echo 'selected="selected"'; } ?>>Villa</option>
                                      
                                      <option value="castle" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'castle') echo 'selected="selected"'; } ?>>Castle</option>
                                      
                                      <option value="dorm" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'dorm') echo 'selected="selected"'; } ?>>Dorm</option>
                                      
                                      <option value="treehouse" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'treehouse') echo 'selected="selected"'; } ?>>Treehouse</option>
                                      
                                      <option value="boat" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'boat') echo 'selected="selected"'; }?>>Boat</option>
                                      
                                      <option value="plane" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'plane') echo 'selected="selected"'; }?>>Plane</option>
                                      
                                      <option value="parking space" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'parking space') echo 'selected="selected"'; } ?>>Parking Space</option>
                                      
                                      <option value="car" <?php if(!empty($product_details)) {  if($product_details->row()->home_type == 'car') echo 'selected="selected"'; }?>>Car</option>
                                      
                                      <option value="van" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'van') echo 'selected="selected"'; } ?>>Van</option>
                                      
                                      <option value="camper/rv" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'camper/rv') echo 'selected="selected"'; } ?>>Camper/RV</option>
                                      
                                      <option value="igloo" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'igloo') echo 'selected="selected"'; }?>>Igloo</option>
                                      
                                      <option value="lighthouse" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'lighthouse') echo 'selected="selected"'; } ?>>Lighthouse</option>
                                      
                                      <option value="yurt" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'yurt') echo 'selected="selected"'; } ?>>Yurt</option>
                                      
                                      <option value="tipi" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'tipi') echo 'selected="selected"'; }?>>Tipi</option>
                                      
                                      <option value="cave" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'cave') echo 'selected="selected"'; } ?>>Cave</option>
                                      
                                      <option value="island" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'island') echo 'selected="selected"'; } ?>>Island</option>
                                      
                                      <option value="chalet" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'chalet') echo 'selected="selected"'; }?>>Chalet</option>
                                      
                                      <option value="earth house" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'earth house') echo 'selected="selected"'; } ?>>Earth House</option>
                                      
                                      <option value="hut" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'hut') echo 'selected="selected"'; }?>>Hut</option>
                                      
                                      <option value="train" <?php if(!empty($product_details)) {  if($product_details->row()->home_type == 'train') echo 'selected="selected"'; }?>>Train</option>
                                      
                                      <option value="tent" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'tent') echo 'selected="selected"'; }?>>Tent</option>
                                      
                                      <option value="other" <?php if(!empty($product_details)) { if($product_details->row()->home_type == 'other') echo 'selected="selected"'; } ?>>Other</option>
                           
                         
                     </select>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Room Type</label>
                  <div class="form_input">
                    
					<?php 
					 if(!empty($product_details)) {
					 $type = $product_details->row()->room_type; 
					 }
					?>
					<select name="room_type" id="room_type">
                    	<option <?php  if (!empty($product_details)) { if($type == 'entire home/apt') echo 'selected="selected"'; } ?> value="entire home/apt">Entire home/apt</option>
                        <option <?php if (!empty($product_details)) { if($type == 'private room') echo 'selected="selected"'; } ?> value="private room">Private room</option>
                        <option <?php if (!empty($product_details)) { if($type == 'shared room') echo 'selected="selected"'; } ?> value="shared room">Shared room</option>
                    </select>
                   
                  </div>
                </div>
              </li>
               <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Accommodates</label>
                  <div class="form_input">
                    
					<select name="accommodates" id="accommodates">
					
							<?php 
									  if($accommodates!=""){ 
										$accommodatesArr=@explode(',',$accommodates);
										foreach($accommodatesArr as $rows){
									  ?>
									 <option value="<?php echo $rows; ?>"<?php if($listDetail->row()->accommodates == $row) echo 'selected="selected"'; ?>>
											<?php echo $rows; ?>
										</option>
									  <?php 
										}
									  } 
									?>
					
                    	 
                    </select>
                   
                   
                  </div>
                </div>
              </li>
			   <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Cancellation Policy</label>
                  <div class="form_input">
                    
					<select name="cancellation_policy" id="cancellation_policy">
					
							<?php 
									  if($can_policy!=""){ 
										$can_policyArr=@explode(',',$can_policy);
										foreach($can_policyArr as $rows){
									  ?>
									 <option value="<?php echo $rows; ?>"<?php if($listDetail->row()->cancellation_policy == $row) echo 'selected="selected"'; ?>>
											<?php echo $rows; ?>
										</option>
									  <?php 
										}
									  } 
									?>
					
                    	 
                    </select>
                   
                   
                  </div>
                </div>
              </li>
             <!-- <li>
                <div class="form_grid_12">
                  <label class="field_title" for="order_email"> </label>
                  <div class="form_input">
                    
                  </div>
                </div>
              </li>-->
              <h4>Rooms and beds:</h4>
               <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Bedrooms </label>
                  <div class="form_input">
                    
					<select name="bedrooms" id="bedrooms">
									<?php 
									$bedroomsArr = array();
									  if($bedrooms!=""){ 
										$bedroomsArr=@explode(',',$bedrooms);
										foreach($bedroomsArr as $row){
									  ?>
										<option value="<?php echo $row; ?>" <?php if($listDetail->row()->bedrooms == $row) echo 'selected="selected"'; ?>>
											<?php echo $row; ?>
										</option>
									  <?php 
										}
									  } 
									?>
					<?php
/* 
					for($i = 1; $i <= 10; $i++) {
					if(!empty($product_details)) {
					
						 $selected = ($product_details->row()->bedrooms == $i) ? 'selected="selected"'  : "";
					}
					
					echo "<option value=".$i." ".$selected.">".$i."</option>";
					} */
					?> 
                         
                     </select>
                    
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Beds</label>
                  <div class="form_input">
                    
					<select name="beds" id="beds">
									<?php 
									  if($beds!=""){ 
										$bedsArr=@explode(',',$beds);
										foreach($bedsArr as $row){
									  ?>
										<option value="<?php echo $row; ?>" <?php if($listDetail->row()->beds == $row) echo 'selected="selected"'; ?>>
											<?php echo $row; ?>
										</option>
									  <?php 
										}
									  } 
									?>
                    <?php
/* 
					for($i = 1; $i <= 15; $i++) {
					if(!empty($product_details)) {
					
						 $selected = ($product_details->row()->beds == $i) ? 'selected="selected"'  : "";
					}
					
					echo "<option value=".$i." ".$selected.">".$i."</option>";
					}<option value="16">16+</option> */
					?> 
                    

                    	 
                                       
                    </select>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Bed type</label>
                  <div class="form_input">
                    
					<select name="bed_type" id="bed_type">
									<?php 
									  if($bedtype!=""){ 
										$bedtypeArr=@explode(',',$bedtype);
										foreach($bedtypeArr as $row){
									  ?>
										<option value="<?php echo $row; ?>" <?php if($listDetail->row()->bed_type == $row) echo 'selected="selected"'; ?>>
											<?php echo $row; ?>
										</option>
									  <?php 
										}
									  } 
									?>
                    	<?php /* <option value="airbed" <?php if(!empty($product_details)) { if($product_details->row()->bed_type == "airbed") echo 'selected="selected"'; }?>>Airbed</option>
                     	<option value="futon" <?php if(!empty($product_details)) { if($product_details->row()->bed_type == "futon") echo 'selected="selected"'; }?>>Futon</option>
                        <option value="pull-out sofa" <?php if(!empty($product_details)) { if($product_details->row()->bed_type == "pull-out sofa") echo 'selected="selected"'; } ?>>Pull-out sofa</option>
                       	<option value="couch" <?php if(!empty($product_details)) { if($product_details->row()->bed_type == "couch") echo 'selected="selected"'; } ?>>Couch</option>
                       	<option value="real bed" <?php if(!empty($product_details)) { if($product_details->row()->bed_type == "real bed") echo 'selected="selected"'; } ?>>Real bed</option> */ ?>
                     </select>
                    
                  </div>
                </div>
              </li>
               <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Bathrooms</label>
                  <div class="form_input">
                    
					<select name="bathrooms" id="bathrroms">
					<option value="">Select</option>
									<?php 
									  if($bathrooms!=""){ 
										$bathroomsArr=@explode(',',$bathrooms);
										foreach($bathroomsArr as $row){
									  ?>
										<option value="<?php echo $row; ?>" <?php if(!empty($product_details)) { if($product_details->row()->bathrooms == $row) echo 'selected="selected"'; } ?>>
											<?php echo $row; ?>
										</option>
									  <?php 
										}
									  } 
									?>	
					
					<?php /* <option value="Private" <?php if(!empty($product_details)) { if($product_details->row()->bathrooms == "Private") echo 'selected="selected"'; }?>>Private</option>
                    <option value="Both" <?php if(!empty($product_details)) { if($product_details->row()->bathrooms == "Both") echo 'selected="selected"'; }?>>Both</option>
                    <option value="Shared" <?php if(!empty($product_details)) { if($product_details->row()->bathrooms == "Shared") echo 'selected="selected"'; } ?>>Shared</option> */ ?>
					
					
					
                    
                  <!--  <?php

					/* for($i = 0; $i <= 8; $i+=0.5) {
					if(!empty($product_details)) {
					
						 $selected = ($product_details->row()->bathrooms == $i) ? 'selected="selected"'  : "";
					}
					
					echo "<option value=".$i." ".$selected.">".$i."</option>";
					} */
					?> -->
                    
                    	 
                    </select>
                   
                  </div>
                </div>
              </li>
			  
			  
               <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Number of Bathrooms</label>
                  <div class="form_input">
                    
					<select name="noofbathrooms" id="noofbathrooms">
						<option value="">Select</option>
						<?php 
						  if($noofbathrooms!=""){ 
							$noofbathroomsArr=@explode(',',$noofbathrooms);
							foreach($noofbathroomsArr as $row){
						?>
						<option value="<?php echo $row; ?>" <?php if(!empty($product_details)) { if($product_details->row()->noofbathrooms == $row) echo 'selected="selected"'; } ?>>
							<?php echo $row; ?>
						</option>
						<?php 
							}
						} 
						?>	
                    </select>
                  </div>
                </div>
              </li>
			  
			  <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Minimum Stay</label>
                  <div class="form_input">
                    
					<select name="minimum_stay" id="minimum_stay">
									<?php 
									  if($min_stay!=""){ 
										$min_stayArr=@explode(',',$min_stay);
										foreach($min_stayArr as $row){
									  ?>
										<option value="<?php echo $row; ?>" <?php if($listDetail->row()->minimum_stay==$row){?>selected="selected"<?php }?>>
											<?php echo $row; ?>
										</option>
									  <?php 
										}
									  } 
									?>
					<?php

					/* for($i = 1; $i <= 10; $i++) {
					if(!empty($product_details)) {
					
						 $selected = ($product_details->row()->minimum_stay == $i) ? 'selected="selected"'  : "";
					}
					
					echo "<option value=".$i." ".$selected.">".$i."</option>";
					} */
					?> 
                         
                     </select>
                    
                  </div>
                </div>
              </li>
              
              <li>
                <div class="form_grid_12">
                  <div class="form_input" style="margin:0px;width:100%;">
                    <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Prev"/>
                    <input type="button" class="btn_small btn_blue nxtTab" tabindex="9" value="Next"/>
                  </div>
                </div>
              </li>
            </ul>
          </div>
         
          <div id="tab6">
            <ul>
            <h3>Details</h3><p>A description of your space displayed on your public listing page. </p>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="space">The Space</label>
                  <div class="form_input">
                                 <textarea name="space" id="space" tabindex="13" style="width:370px;height:100px;" class="large tipTop" title="what makes  your listing unique ?"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->space)); }?></textarea>
                    </div>  

                  </div>
                
              </li>
             
              
              
              <h3>Extra Details</h3><p>Other information you wish to share on your public listing page. </p>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="other_thingnote">Other Things to Note</label>
                  <div class="form_input">
                                 <textarea name="other_thingnote" id="other_thingnote" tabindex="13" style="width:370px;height:100px;" class="large tipTop" title="Are there any other details you’d like to share ?"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->other_thingnote)); }?></textarea>
                    </div>  
                  </div>
               
              </li>
              
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="house_rules">House Rules</label>
                  <div class="form_input">
                                 <textarea name="house_rules" id="house_rules" tabindex="13" style="width:370px;height:100px;" class="large tipTop" title="How do you expect your guests to behave ?"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->house_rules)); }?></textarea>
                    </div>  
                  </div>
               
              </li>
              
              
            </ul>
            <ul>
              <li>
                <div class="form_grid_12">
                  <div class="form_input" style="margin:0px;width:100%;">
                    <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Prev"/>
                    <input type="button" class="btn_small btn_blue nxtTab" tabindex="9" value="Next"/>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          
          <div id="tab7">
            <ul>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="meta_title">Meta Title</label>
                  <div class="form_input">
                    <input name="meta_title" id="meta_title" type="text" tabindex="1" class="large tipTop" title="Please enter the page meta title" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->meta_title)); }?>"/>
                  </div>
                </div>
              </li>
              
                                  <li>
								<div class="form_grid_12">
								<label class="field_title" for="description">Keywords</label>
								<div class="form_input">
								   
                                <textarea name="meta_keyword" id="meta_keywords" tabindex="13" style="width:370px;height:150px;" class="required large tipTop" title="Please enter the Address"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->meta_keyword)); }?></textarea>
								</div>
								</div>
							</li>
                            <li>
								<div class="form_grid_12">
								<label class="field_title" for="description">Meta Description</label>
								<div class="form_input">
								<textarea name="meta_description" id="meta_description" tabindex="13" style="width:370px;height:150px;" class="required large tipTop" title="Please enter the Address"> <?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->meta_description)); }?></textarea>
								</div>
								</div>
							</li>

              
              
            </ul>
            <ul>
              <li>
                <div class="form_grid_12">
                  <div class="form_input">
                    <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Prev"/>
                    <button type="submit" class="btn_small btn_blue" tabindex="4"><span>Submit</span></button>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <input type="hidden" name="userID" value="<?php if ($loginID != ''){echo $loginID;}else {echo '0';}?>"/>
           
          </form>
        </div>
      </div>
    </div>
  </div>
  <span class="clear"></span> </div>
</div>

<script type="text/javascript">
function DealPriceInsert(value,title)
{
var pid=document.getElementById('prdiii').value;
alert(pid);
 $.ajax({
type:'POST',
url:'<?php echo base_url()?>admin/product/DealPriceInsert',
data:{val:value,product_id:pid,title:title},
success:function(msg)
{
}
});
}
</script>
<script>
function ImageAddClick1(){
	$(".dragndrop1").colorbox({width:"1000px", height:"500px",iframe:true, href:""});
}
</script>
<!-----------popup for listing------
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>

function popup()
{
$( "#dialog-message" ).dialog({
modal: true,
buttons: {
click: function() {
$( this ).dialog( "close" );
}
}
});
};

$(function()
{
$('#dialog-message').css('display','none');
});
</script>
<style>
.ui-draggable-handle
{
display:none !important;
}
</style>
<div id="dialog-message">
<div style="display:none;">
<div id='inline_example11' style='background:#fff;'>
  		<div class="popup_page" style="min-height: 500px;overflow:auto;"></div>
</div>
</div>

</div>
-----------End popup for listing------>
<?php 
$this->load->view('admin/templates/footer.php');
?>
