<?php
use frontend\components\MyClass;
$sitesetting = Yii::$app->mycomponent->getLogo();
?>
<?php require_once 'emailheader.php';//$this->renderPartial('emailheader',array('siteSettings'=>$siteSettings)); ?>  
				<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="font-family: Georgia, serif; background: #fff;" bgcolor="#ffffff">
			      <tr>
			        <td width="14" style="font-size: 0px;" bgcolor="#ffffff">&nbsp;</td>
					<td width="100%" valign="top" align="left" bgcolor="#ffffff"style="font-family: Georgia, serif; background: #fff;">
						<table cellpadding="0" cellspacing="0" border="0"  style="color: #333333; font: normal 13px Arial; margin: 0; padding: 0;" width="100%" class="content">
						<!-- <tr>
							<td style="padding: 25px 0 5px; border-bottom: 2px solid #d2b49b;font-family: Georgia, serif; "  valign="top" align="center">
								<h3 style="color:#767676; font-weight: normal; margin: 0; padding: 0; font-style: italic; line-height: 13px; font-size: 13px;">~ <currentmonthname> <currentday>, <currentyear> ~</h3>
							</td>
						</tr> -->
						<tr>
							<td style="padding: 18px 0 0;" align="left">			
								<h2 style=" font-weight: normal; margin: 0; padding: 0 0 12px; font-style: inherit; line-height: 30px; font-size: 25px; font-family: Trebuchet MS; border-bottom: 1px solid #333333; "> Hello <?php echo $name; ?>, Welcome to <?php echo $sitesetting->sitename; ?></h2>
							</td>
						</tr>
						
							<tr>
								<td style="padding: 15px 0;"  valign="top">
									<p style='margin-bottom: 10px'>
										Greetings! Thanks for registering with <?php echo $sitesetting->sitename; ?>.
									</p>
									<p style='margin-bottom: 10px'>
										You have received an invitation from 
										<?php echo $loguser->first_name; ?> to join 
										<?php echo SITE_NAME; ?>. Please click the link below to accept 
										the invitation and to create your new account with 
										<?php echo $siteName; ?>.
									</p>
									  <?php
									  $username = base64_encode($loguser->id."-".rand(0,999));
									  ?>									
									<p style='margin-bottom: 10px'>
										Invitation link: <?php echo "<a href='".SITE_URL."signup?referrer=".$username."'>Join with me</a>"; ?>
									</p>
									<p style='margin-bottom: 10px'>
										To view <?php echo $loguser->first_name; ?>'s  profile, please click the link below.
									</p>
									<p style='margin-bottom: 10px'>

										Link:  <?php echo "<a href='".SITE_URL."people/".$username."'>"; ?><?php echo ucwords(strtolower($loguser->firstname)); ?></a>
									</p>

									<p style='margin-bottom: 10px'>
										Joining to <?php echo $siteName; ?> & referring your friends is not only sharing the fun, but you will get some additional benefits too. Go to our help section to read more about the referral program. 
									</p>
									
								</td>
							</tr>
							<tr>
							  <td style="padding: 15px 0;"  valign="top">
									<p style='margin-bottom: 10px'>
										<a href="<?php echo $link; ?>" style="color: #d18648; text-decoration: none;">
											Click Here
										</a>,  to confirm your registration.
									</p>
							  </td>
							</tr>
							
							<tr>
								<td style="padding: 15px 0"  valign="top">
									<p style="color: #333333; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 14px;font-family: Arial; ">
										Regards,
										<br />
										<b><?php echo $siteName.' Team'; ?>.</b>
									</p>
									<br>
								</td>
							</tr>
						</table>	
					</td>
					<td width="16" bgcolor="#ffffff" style="font-size: 0px;font-family: Georgia, serif; background: #fff;">&nbsp;</td>
			      </tr>
				</table><!-- body -->
				  <?php require_once 'emailfooter.php';//$this->renderPartial('emailfooter',array('siteSettings'=>$siteSettings)); ?> 
		  	</td>
		</tr>
    </table>
  </body>
</html>
<?php //die; ?>