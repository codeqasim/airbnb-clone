<?php
$this->load->view('site/templates/header');
$this->load->view('site/templates/listing_head_side');
?>

<script type="text/javascript">
function ImageAddClick(){
var idval =$('#prdiii').val();
//alert(idval);
$(".dragndrop1").colorbox({width:"1000px", height:"500px", href:baseURL+"site/product/dragimageuploadinsert/"+idval});
}
</script>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addProperty.js"></script>
<style>

body
{
font-family:arial;
}

#preview
{
color:#cc0000;
font-size:12px
}
.imgList 
{
max-height:150px;
margin-left:5px;
border:1px solid #dedede;
padding:4px;	
float:left;	
}

</style>


<!-- added 23/05/2014 -->
<script>
function EmptyChk() {
	
	if(document.getElementById('rental_image').value=="") {	
	alert("No Images Selected");
	return false;
	}
}

</script>

 <script src="js/site/addProperty.js"></script>

<!-- image uploaded script -->
<!--<script src="js/site/jquery.min.js"></script> -->
<script src="js/site/jquery.wallform.js"></script>
<script>
function uploadImage()
{
			    $("#imageform").ajaxForm({target: '#preview', 
				     beforeSubmit:function(){ 
					
					console.log('ttest');
					$("#imageloadstatus").show();
					 $("#imageloadbutton").hide();
					 }, 
					success:function(){
					alert(response);					
                    //return false;
				    console.log('test');
					
					 $("#imageloadstatus").hide();
					 $("#imageloadbutton").show();
					 
					}, 
					error:function(){ 
					console.log('xtest');
					 $("#imageloadstatus").hide();
					$("#imageloadbutton").show();
					} }).submit();
					
		

		
		
}

</script>






<!-- image uploaded script end -->

 




   
            <div class="right_side nsd">
            
            <div class="dashboard_price_main">
            
            <!--<div class="dragndrop1">Rental Image : <button onclick="ImageAddClick();">Choose Image</button></div>-->
            <div class="lisdt-area" align="center" style="width:590px; border:dashed 2px #0099FF;">
              <img src="images/site/cam.png">
            <h3><?php if($this->lang->line('Addaphoto') != '') { echo stripslashes($this->lang->line('Addaphoto')); } else echo "Add a photo or two!"; ?> </h3>

              <span><?php if($this->lang->line('Orthree') != '') { echo stripslashes($this->lang->line('Orthree')); } else echo "Or three, or more! Guests love photos that highlight the features of your space."; ?></span>
                <form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo base_url(); ?>site/product/ajaxImageUpload' style="clear:both">
				<span class="add-photos"><?php if($this->lang->line('AddPhotos') != '') { echo stripslashes($this->lang->line('AddPhotos')); } else echo "Add Photos"; ?></span>
				<div id='imageloadstatus' style='display:none'><img src="images/site/loader.gif" alt="Uploading...."/></div>
				<div id='imageloadbutton' style="color:red;">
				<input type="file" name="photos[]" id="photoimg" multiple="true" style="background-color:red;" onchange="uploadImage();" />
				<input type="hidden" id="prd_id" name="prd_id" value="<?php echo $this->uri->segment(2); ?>" />
				</div>
				</form>
				
				
				
				
				
				
				
				
				
				
				
            </div>
			<!-- 
				<form id="testupload" name="testupload" method="post" action="<?php echo base_url(); ?>site/product/ImageUploadTest" enctype="multipart/form-data">
				<input type="file" name="photostest[]"  multiple="true" style="background-color:red;" />
				<input type="hidden" id="prd_id" name="prd_id" value="<?php echo $this->uri->segment(2); ?>" />
				<input type="submit" name="submit" id="submit" />
				</form>
			
			-->
			
            
            <?php //echo '<pre>'; print_r($imgDetail->result_array()); ?>
            
                <div class="widget_content">
                      <?php if (!empty($imgDetail)){ ?>
					  <ul>
					  <?php 
						$this->session->set_userdata(array('product_image_'.$imgDetail->row()->id => $imgDetail->row()->image));
						foreach ($imgDetail->result() as $img){ ?>
								<li>
                       <input type="hidden" name="imaged[]" value="<?php echo $img->product_image; ?>"/>
                     <div class="img-holds">  <img src="<?php echo base_url()."server/php/rental/";?><?php echo $img->product_image; ?>"  height="80px" width="80px" /></div>
					  
                         <a class="p_del tipTop" href="javascript:void(0)" onClick="javascript:SiteDeleteProductImage(<?php echo $img->id; ?>,<?php echo $listDetail->row()->id; ?>);" title="Delete this image"></a>
						 <br />
						<!-- <input type="text" id="<?php echo $img->id; ?>" name="<?php echo $img->id; ?>" value="<?php echo $img->caption; ?>" onblur="SavePhotoCaption('<?php echo $img->id; ?>',this.value)" />-->
						  <textarea class="phtdetl" id="<?php echo $img->id; ?>" name="<?php echo $img->id; ?>"  onblur="SavePhotoCaption('<?php echo $img->id; ?>',this.value);" ><?php echo $img->caption; ?></textarea>
						       </li>
                       
							<?php	}  ?>
							</ul>
							<?php } ?>
                  </div>
				  
				 
              
         </div>
		 <span class="onclk-text" style="border-left: 1px solid #dcdada !important;">Want to add Video URL?&nbsp;<span onclick="show_block_cate('1')">You can add.</span></span>
		 <div class="dashboard_price_main" id="monthly" style="display:none;border-left: 1px solid #dcdada !important;" >

			<div class="overview_title">
					
				<label>Video URL</label>
			
				<input type="text" value="<?php echo $listDetail->row()->video_url;?>" placeholder="Meta Title" class="title_overview" 
			   onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'video_url');" name="video_url" style="color:#000 !important;" />
				
				<input type="hidden" id="id" name="id" value="<?php echo $listDetail->row()->id; ?>" />
				
	
			</div>
		 </div>
         </div>
		 <script type="text/javascript">
		 function SavePhotoCaption(id,caption)
		 {//alert();
			 $.ajax({
			 type:'POST',
			 dataType:'json',
			 url:'<?php echo base_url()?>site/product/SavePhotoCaption',
			 data:{id:id,caption:caption},
			 success:function(response)
			 {
			//alert(response);
			 }
			 });
		 }
		 function show_block_cate(columin_id)
		{
		  $(".onclk-text").css("display","none");
		   $("#monthly").css("display","block");  
		}
		 </script>
<?php
$this->load->view('site/templates/footer');
?>