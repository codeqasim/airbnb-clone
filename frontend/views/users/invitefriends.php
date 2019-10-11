<?php
/*
 * This is for the users to invite their friends through the email
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Invite Friends';
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;
//echo $userdata['firstname'];die;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];

/* Invite Friends To Your Profile */
$profile = base64_encode($userdata->id."-".rand(0,999));
$profileurl = Yii::$app->urlManager->createAbsoluteUrl ( '/profile/' . $profile );  
$profileurl = Yii::$app->urlManager->createAbsoluteUrl ( '/');   
?>
<div class="bg_gray1 positn-relatv">
    <div class="invite-banner text-center">

        <div class="container">

        	<div class="profile-image-invite-page">
        		<?php
			if(isset($userdata->profile_image) && $userdata->profile_image!="")
			{
				$profile_image = $userdata->profile_image;
				$profile_image = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$profile_image);
				$resized_profile_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$profile_image.'&w=110&h=110');	
				echo '<div class="profile_img" style="background-image:url('.$resized_profile_image.');" ></div>';
			}
			else
			{
				$profile_image = "usrimg.jpg";
				$profile_image = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$profile_image);
				$resized_profile_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$profile_image.'&w=110&h=110');	
				echo '<div class="profile_img" style="background-image:url('.$resized_profile_image.');" ></div>';
			}
			?>
        	</div>

        	<h2><span>Share your love of travel</span></h2>

        	<?php /*<div class="hero-subtext-md-lg"><span>Introduce a friend to <?php echo $sitesettings->sitename;?>. They’ll get ₹1,200 in travel credit when they sign up, and you’ll get ₹600 in travel credit once they complete a trip. Only for new <?php echo $sitesettings->sitename;?> guests!<a href="<?php echo $baseUrl.'/user/help/terms' ?>"> Read the terms</a></span></div>
        </div> */ ?> 
        <!--container end-->

    </div>
    <!--banner end-->
    

<div class="invite-frnds-tab" style="top:auto !important; "> 
	<div class="container">
		<div class="row">

			<div class="invit-section col-xs-12 text-center margin_bottom20">
				<div class="invite-new text-center">
					<div style="margin: 0 auto;" class="text-center">
						<div class="email-frm emaildiv">
							<div class="addmail-lis">
								<span class="add inputspan" id="invitetext" tabindex="0"><?php echo  Yii::t('app','Enter your friends email address');?></span>
								<input type="text" id="invitetextval" class="text" style="display: none;width:100%;" onkeyup="emailEnd(event.keyCode)">
							</div>
							<button class="airfcfx-invite-send-btn airfcfx-panel btn btn_email invite" type="button" onclick="send_mail();">Send</button>
						</div>
						<div class="clear"></div>
						
						<div id="emailerr" class="errcls hiddencls"><?php echo Yii::t('app','Please enter email');?></div>

					</div>

				</div>
				<?php
					echo '<div class="loadingimg-invite"> <img id="loadingimg" src="'.$baseUrl.'/images/load.gif" class="loading"></div>';
				?>		
						
				<div id="mailsuccess" class="errcls hiddencls"><?php echo Yii::t('app','Invite Sent Successfully');?></div>
				<!--input type="text" placeholder="Enter email address, separated by commas" class="form-control" style="width:50%;" onkeyup="emailEnd(event.keyCode)"-->

				<!--
				<div class="social-inviter">
					<span class="impot-span">Import contacts:</span>
					<span class="contact-importer">
						<span class="loading-trigger">
							<a href="#" class="gmail-icon"><span>Gmail</span></a>
						</span>
						<span class="loading-trigger">
							<a href="#" class="yahoo-icon"><span>Yahoo! Mail</span></a>
						</span>
						<span class="loading-trigger">
							<a href="#" class="windowslive-icon"><span>Outlook</span></a>
						</span>
					</span>
				</div>
				-->

				<div class="or-separator"><span class="h6 or-separator--text"><span>or</span></span><hr></div>

				<div class="invit-other-sender row">

					<div class="col-sm-12 col-md-6 col-lg-6">
						<label class="float-item input-type-large" for="share-link"><span>Share Your Link:</span></label>
						<div class="flexble-span">
							<div class="input-addon">
								<input class="input-type-large input-copy-btn" id="copyurlText" value="<?= $profileurl; ?>" readonly="" name="personal-link" type="text">
								<a href="javascript:void(0);" class="input-suffix btn icon btn-copy-btn" onclick="javascript:myFunction();">
									<span class="copy-btn-text"><span>Copy</span></span>
								</a>
							</div>
						</div>
					</div>

					<!--
					<div class="col-sm-6 col-md-3 col-lg-3">
						<a href="#" class="btn btn-large social-share-btn facebook-messenger">
							<span>Messenger</span>
						</a>
					</div>
					-->
					<?php 
					 $shareImg = Yii::$app->urlManager->createAbsoluteUrl ("/images/".$sitesettings->sitelogoblack); 
						$shareTitle = 'Joining to '.$sitesettings->sitename.' & referring your friends is not only sharing the fun, but you will get some additional benefits too. Go to our help section to read more about the referral program.';
						$shareHeader  = 'Invitation to join '.$sitesettings->sitename;
					?>
					<div class="col-sm-6 col-md-3 col-lg-3">
						<a href="javascript:void(0);" onclick="javascript:fbShare('<?= $profileurl; ?>', '<?php echo $shareHeader; ?>', '<?php echo $shareTitle; ?>', '<?php echo $shareImg; ?>', 520, 350);" class="btn btn-large social-share-btn facebook">
							<span>Facebook</span>    
						</a>
					</div>

				</div>


			</div><!--col-sm-9 end-->
			<?php /* 
			<div class="col-xs-12 invite-share-option">

				<h2 class="text-center"><span>It’s easy to get started</span></h2>
				<div class="invit-divite">
					
					<div class=" col-xs-12 col-sm-4 col-md-4">
						<div class="how-it-weork clearfix">
							<div class="how-it-works-icon">
								<!--<i class="fa fa-sign-out rotate"></i>-->
								<?php echo '<img class="icon-invite" src="'.$baseUrl.'/images/spreed-mail.png" alt="Icon-img">';?>

							</div>
							<div class="how-it-works-text">
								<span>Spread the word with your link or over email.</span>
							</div>	
						</div>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="how-it-weork clearfix">
							<div class="how-it-works-icon">
								<!--<i class="fa fa-suitcase"></i>-->
								<?php echo '<img class="icon-invite" src="'.$baseUrl.'/images/trip.png" alt="Icon-img">';?>
							</div>
							<div class="how-it-works-text">
								<span>Get ₹600 when they take their first trip of ₹3,300 or more.</span>
							</div>	
						</div>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="how-it-weork clearfix">
							<div class="how-it-works-icon">
								<!--<i class="fa fa-handshake-o"></i>-->
								<?php echo '<img class="icon-invite" src="'.$baseUrl.'/images/guest-shak.png" alt="Icon-img">';?>
							</div>
							<div class="how-it-works-text">
								<span>Get ₹3,000 when they welcome their first guest.</span>
							</div>	
						</div>
					</div>

				</div>
			</div> */ ?>



		</div><!--row end-->
	</div><!--container end-->

</div>

</div>
<style type="text/css">
	.invite
	{
		border-radius: 0;
		box-shadow: none;
		/*height: 38px;*/
		display: block;
		top: 0;
		position: absolute;
		right: -65px;
	}
	.emaildiv
	{
		text-align: left;
		display: inline-block;
		height: auto;
	}
	.inputspan
	{
		display: inline-block;
		width:100%;
	}
</style>
<script type="text/javascript">
    var email_addrs = [];
    function add_email(addr){
	if(/[\w\-\.\+]+@[\w\-\.]+[a-z]+/.test(addr)){
            if($.inArray(addr,email_addrs) === -1) email_addrs.push(addr);
	}
    }
    function remove_mail(addr){
	var index = email_addrs.indexOf(addr);
	email_addrs.splice(index,1);
    }	
	$('.email-frm .add').click(function(){
	$(this).hide().parents('.email-frm').addClass('focus').find('input').show().focus();
    });
    $('.email-frm input[type="text"]').blur(function(){
	var email_a = $(this).val().replace(",","");
	var email = email_a.replace(" ","");
	$(this).parents('.email-frm').removeClass('focus');
	if(email==''){$(this).hide().parents('.email-frm').find('.add').show();}
	else{
	    
		var email_a = $('.email-frm input').val().replace(",","");
		var email = email_a.replace(" ","");
		if(email.indexOf(".") == -1 || email.indexOf("@") == -1) {
			$('.email-frm input').val(email);
		}else{
			
			var email_a = $('.email-frm input').val().replace(",","");
			var email = email_a.replace(" ","");
			if(email.indexOf(".") == -1 || email.indexOf("@") == -1) {
				$('.email-frm input').val(email);
			}else{
				$('<b class="name">'+email+'<button type="button" style="padding:0 3px;background-color:#fe5571;color:#ffffff;border:1px solid #fe5571;margin:1px 5px;" class="fa fa-remove removebtncls" onclick="$(this).parents('+"'.name'"+').remove();if ($('+"'.email-frm .name'"+').length<1) {$('+"'.email-frm .add').text('Enter your friends email address')"+'}"></button></b>').insertBefore('.email-frm .add');
				$('.email-frm input').val('');
			}
		}
		add_email(email);
	}
    });
	
function send_mail()
{
$(".removebtncls").css("display","none");
	var emails=[],valid_emails=[], param = {};
	$('.email-frm b.name').each(function(){
            var em = $(this).text();
            if(/[\w\-\.\+]+@[\w\-\.]+[a-z]+/.test(em)){
		if($.inArray(em, valid_emails) === -1) valid_emails.push(em);
            }
	});
    console.log("Email Count "+email_addrs.length);
    if(email_addrs.length<=0)
	{
    $("#emailerr").show();
				setTimeout(function() {
					$("#emailerr").hide();
				}, 5000);	
	}
    else
	{
    $("#emailerr").hide();
	}
	if(!email_addrs.length) return false;

	param['use_credit_email'] = true;
	param['emails'] = email_addrs.join(',');

	if($('.email-frm .name').length < 1)
	{
		$('.email-frm .add').text('Please enter your friends email address').css('color','red');
		return false;
	}


		    $.ajax({
			url: baseurl+"/sendmail",
			type: "post",
			data : { 'emails': param},
			dataType: "html",
			beforeSend: function(){
				$("#loadingimg").show();
				$(".removebtncls").css("display","none");
			},
			success: function(responce){
				$("#loadingimg").hide();
				$("#mailsuccess").show();
				$('.email-send-load').hide();
				$('dl.via input,dl.via textarea').val('');
			   	$('.email-frm .name').remove();
			   	$('.email-frm .add').text('Enter your friends email address');
				$("#invitetext").css("display","inline-block");
				$("#invitetextval").css("display","none");
				email_addrs = [];
				setTimeout(function() {
					$("#mailsuccess").hide();
				}, 5000);
			}
			});
}	
	
</script>
 <script>
        //Fb Share listing.
         function fbShare(url, title, descr, image, winWidth, winHeight) {
            var winTop = (screen.height / 2) - (winHeight / 2);
            var winLeft = (screen.width / 2) - (winWidth / 2);
            window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&picture=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
        }


        function myFunction() {
  /*var copyText = $("#listurl").val();*/
  var copyText = document.getElementById('copyurlText');
  copyText.select();
  document.execCommand("Copy");
  alert("Copied the text: " + copyText.value);
}
    </script>