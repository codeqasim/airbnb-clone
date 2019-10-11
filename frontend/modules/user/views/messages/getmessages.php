<?php
use yii\widgets\LinkPager;
?>
                    <?php
					
					$baseUrl = Yii::$app->request->baseUrl;
					if(!empty($messages) && $msgtype!='admin')
					{
						foreach($messages as $message)
						{
							$senderid = $message->senderid;
							$receiverid = $message->receiverid;
							$listingid = $message->listingid;
							$senderdata = $message->getSender()->where(['id'=>$senderid])->one();
							$receiverdata = $message->getReceiver()->where(['id'=>$receiverid])->one();
							$listingdata = $message->getListing()->where(['id'=>$listingid])->one();
							$senderimage = $senderdata->profile_image;
							$receiverimage = $receiverdata->profile_image;
							/*if($senderimage=="")
							$senderimage="usrimg.jpg";
							if($receiverimage=="")
							$receiverimage = "usrimg.jpg";*/

							if($senderimage!="")
							{
								$senderheader_response = get_headers(Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$senderimage, 1));
								if ( strpos( $senderheader_response[0], "404" ) !== false )
								{
									$senderimage = "usrimg.jpg";
								}
								else
								{
									$senderimage = $senderdata->profile_image;	
								}
							}
							else if($senderimage=="")
							{
								$senderimage = "usrimg.jpg";
							}
							
							if($receiverimage!="")
							{
								$receiverheader_response = get_headers(Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$receiverimage, 1));
								if ( strpos( $receiverheader_response[0], "404" ) !== false )
								{
									$receiverimage = "usrimg.jpg";
								}
								else
								{
									$receiverimage = $receiverdata->profile_image;	
								}
							}
							else if($receiverimage=="")
							{
								$receiverimage = "usrimg.jpg";
							}

							$senderimageurl = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$senderimage);
							$resized_sender_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$senderimageurl.'&w=60&h=60');							
							$receiverimageurl = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$receiverimage);
							$resized_receiver_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$receiverimageurl.'&w=60&h=60');
							echo '<div class="airfcfx-message-row col-sm-12 no-hor-padding">';
							if($loguserid==$senderid)
								echo '<div class="airfcfx-imgwdth col-xs-2 imgwdth"><span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('.$resized_receiver_image.');"></span></div>';
							else
								echo '<div class="airfcfx-imgwdth col-xs-2 imgwdth"><span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('.$resized_sender_image.');"></span></div>';
							if($loguserid==$senderid)
								echo '<div class="airfcfx-namewdth col-xs-3 namewdth wrdwrp">'.$receiverdata->firstname.'<br /><span class="airfcfx-message-date">';
							else
								echo '<div class="airfcfx-namewdth col-xs-3 namewdth wrdwrp">'.$senderdata->firstname.'<br /><span class="airfcfx-message-date">';
							echo date('m/d/Y',strtotime($message->cdate)).'</span></div>';
							if(!empty($listingdata))
							$messageid = base64_encode($listingdata->id.'_'.$senderid.'_'.$receiverid);
							else
							$messageid = base64_encode($senderid.'_'.$receiverid);
							echo '<div class="airfcfx-msgwdth col-xs-4 msgwdth wrdwrp">';
							if(!empty($listingdata))
							{
								echo '<a href="'.$baseUrl.'/user/messages/viewmessage/'.$messageid.'" class="airfcfx-msg" style="text-decoration:none;">
								'.$message->message.'
								</a>';
							}
							else
							{
								echo '<a href="'.$baseUrl.'/user/messages/adminviewmessage/'.$messageid.'" class="airfcfx-msg" style="text-decoration:none;">
								'.$message->message.'
								</a>';								
							}
							if(!empty($listingdata))
							echo '<div class="airfcfx-listingwdth col-xs-12 no-hor-padding msgwdth wrdwrp">'.$listingdata->listingname.'</div>';
							echo '</div>';
							if(!empty($listingdata))
							{
								$listuserid = $listingdata->userid;
								if($listuserid==$senderid)
									$reserveuserid = $receiverid;
								else if($listuserid==$receiverid)
									$reserveuserid = $senderid;
								$reservationdata = $listingdata->getReservationdata($reserveuserid,$listingid);
								if(!empty($reservationdata))
								$bookstatus = $reservationdata->bookstatus;
								else
								$bookstatus = Yii::t('app',"Not possible");							
								echo '<div class="airfcfx-statuswdth col-xs-3 msgwdth wrdwrp">'.Yii::t('app',ucfirst($bookstatus)).'</div>';
							}
							else
							{
								echo '<div class="airfcfx-listingwdth col-xs-4 msgwdth wrdwrp">'.Yii::t('app','Admin message').'</div>';
							}
							echo '</div>';
							echo '<div class="clear"></div>';
							echo '<hr class="airfcfx-horizontal-line">';
						}
					}
					else if(!empty($messages) && $msgtype=="admin")
					{
						foreach($messages as $message)
						{						
							$senderid = $message->senderid;
							$receiverid = $message->receiverid;
							$listingid = $message->listingid;
							$senderdata = $message->getSender()->where(['id'=>$senderid])->one();
							$receiverdata = $message->getReceiver()->where(['id'=>$receiverid])->one();
							$listingdata = $message->getListing()->where(['id'=>$listingid])->one();
							$senderimage = $senderdata->profile_image;
							$receiverimage = $receiverdata->profile_image;
							/*if($senderimage=="")
								$senderimage="usrimg.jpg";
							if($receiverimage=="")
								$receiverimage = "usrimg.jpg";*/
							if($senderimage!="")
							{
								$senderheader_response = get_headers(Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$senderimage, 1));
								if ( strpos( $senderheader_response[0], "404" ) !== false )
								{
									$senderimage = "usrimg.jpg";
								}
								else
								{
									$senderimage = $senderdata->profile_image;	
								}
							}
							else if($senderimage=="")
							{
								$senderimage = "usrimg.jpg";
							}
							
							if($receiverimage!="")
							{
								$receiverheader_response = get_headers(Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$receiverimage, 1));
								if ( strpos( $receiverheader_response[0], "404" ) !== false )
								{
									$receiverimage = "usrimg.jpg";
								}
								else
								{
									$receiverimage = $receiverdata->profile_image;	
								}
							}
							else if($receiverimage=="")
							{
								$receiverimage = "usrimg.jpg";
							}
							$senderimageurl = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$senderimage);
							$resized_sender_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$senderimageurl.'&w=60&h=60');							
							$receiverimageurl = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$receiverimage);
							$resized_receiver_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$receiverimageurl.'&w=60&h=60');
							echo '<div class="airfcfx-message-row col-sm-12 no-hor-padding">';
							echo '<div class="airfcfx-imgwdth col-xs-2 imgwdth"><span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('.$resized_sender_image.');"></span></div>';
							echo '<div class="airfcfx-namewdth col-xs-3 namewdth wrdwrp">'.$senderdata->firstname.'<br /><span class="airfcfx-message-date">
							'.date('m/d/Y',strtotime($message->cdate)).'</span></div>';
							$messageid = base64_encode($senderid.'_'.$receiverid);
							echo '<div class="airfcfx-msgwdth col-xs-3 msgwdth wrdwrp">
							<a href="'.$baseUrl.'/user/messages/adminviewmessage/'.$messageid.'" style="text-decoration:none;">
							'.$message->message.'
							</a>
							</div>';
							echo '<div class="airfcfx-listingwdth col-xs-4 msgwdth wrdwrp">'.Yii::t('app','Admin message').'</div>';
							echo '</div>';
							echo '<div class="clear"></div>';
							echo '<hr class="airfcfx-horizontal-line">';
						}						
					}
					else
					{
						//echo '<div class="col-xs-12 text-center"><h3>'.Yii::t('app','No messages yet.').'</h3></div>'; ?>

						<div class="airfcfx-panel-body panel panel-default panel-body padding10">
                  	<div class="msg-tablink tab-content">
    					<div id="Hosting" class="tab-pane fade in active">
    						<p class="no-msg text-center">No messages yet.</p>
    						<!-- p class="no-msg-ptag">When guests contact you or send you reservation requests, you’ll see their messages here.</p -->
    					</div>
    				</div>
                  </div>


					<?php }
					?>


