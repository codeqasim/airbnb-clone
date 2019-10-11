                       <?php
					   use backend\models\Users;
					   use backend\models\Roleandprivilige;
                       $fronturl = str_replace('/admin','',$baseUrl); 
                       $userid = Yii::$app->user->id;
                       
                       $user_data = Users::findIdentity($userid);
                       $userlevel = $user_data->user_level;

                       
                       if($userlevel != 'god')
                       {
							$privilige_data = Roleandprivilige::find()->select('priviliges')->where(['id'=>$user_data->privilige_id])->one();
                       		$priviliges = json_decode($privilige_data->priviliges);
                       }else{
                       		$priviliges = array();
                       }

						?>
                        <div class="sidebar">
    <div class="widget stay-on-collapse" id="widget-welcomebox">
        <div class="widget-body welcome-box tabular">
            <div class="tabular-row">
                <div class="tabular-cell welcome-avatar">
                    <a href="<?php echo $baseUrl.'/dashboard';?>"><img src="<?php echo $fronturl.'/albums/images/users/usrimg.jpg'?>" class="avatar"></a>
                </div>
                <div class="tabular-cell welcome-options">
                    <span class="welcome-text"><?php echo Yii::t('app','Welcome');?>,</span>
                    <a href="<?php echo $baseUrl.'/dashboard';?>" class="name"><?php echo Yii::$app->user->identity->firstname; ?></a>
                </div>
            </div>
        </div>
    </div>
	<div class="widget stay-on-collapse" id="widget-sidebar">
        <nav role="navigation" class="widget-body">
	<ul class="acc-menu">
		<li class="nav-separator"><?php echo Yii::t('app','Explore');?></li>
		<li><a href="<?php echo $baseUrl.'/dashboard';?>"><i class="fa fa-dashboard"></i><span><?php echo Yii::t('app','Dashboard');?></span></a></li>
		<?php
		if($userlevel == 'god' || in_array('rolesmanagement', $priviliges) || in_array('moderator', $priviliges))
		{
		?>
			<li><a href="javascript:void(0);"><i class="fa fa-users" aria-hidden="true"></i><span><?php echo Yii::t('app','Roles & Privileges');?></span></a>
				<ul class="acc-menu">
					<?php
					if( in_array('rolesmanagement', $priviliges) || $userlevel == 'god' )
					{
					?>
						<li><a href="<?php echo $baseUrl.'/admin/rolesmanagement';?>"></i><span><?php echo Yii::t('app','Roles');?></span></a></li>
					<?php } 

					if( in_array('moderator', $priviliges) || $userlevel == 'god' )
					{
					?>
						<li><a href="<?php echo $baseUrl.'/admin/moderator';?>"></i><span><?php echo Yii::t('app','Moderators');?></span></a></li>
					<?php } ?>
				</ul>
			</li>

		<?php
		}

		if($userlevel == 'god' || in_array('usermanagement', $priviliges) || in_array('blockedusermanagement', $priviliges))
		{
		?>
			<li><a href="javascript:void(0);"><i class="fa fa-user"></i><span><?php echo Yii::t('app','User Management');?></span></a>
			
				<ul class="acc-menu">
					<?php
					if( in_array('usermanagement', $priviliges) || $userlevel == 'god' )
					{
					?>
						<li><a href="<?php echo $baseUrl.'/usermanagement';?>"></i><span><?php echo Yii::t('app','Active User Management');?></span></a></li>
					<?php } 

					if( in_array('blockedusermanagement', $priviliges) || $userlevel == 'god' )
					{
					?>
						<li><a href="<?php echo $baseUrl.'/blockedusermanagement';?>"></i><span><?php echo Yii::t('app','Blocked User Management');?></span></a></li>
					<?php } ?>
				</ul>
			</li>
		<?php } ?>

		<?php
			if($userlevel == 'god' || in_array('activehostmanagement', $priviliges) || in_array('blockedhostmanagement', $priviliges))
			{
		?>
		<li><a href="javascript:void(0);"><i class="fa fa-bank"></i><span><?php echo Yii::t('app','Host Management');?></span></a>
		<ul class="acc-menu">
		<?php
				if( in_array('activehostmanagement', $priviliges) || $userlevel == 'god' )
				{
		?>
			<li><a href="<?php echo $baseUrl.'/hostmanagement';?>"><span><?php echo Yii::t('app','Active Host Management');?></span></a></li>
			<?php } 

				if( in_array('blockedhostmanagement', $priviliges) || $userlevel == 'god' )
				{
			?>
			<li><a href="<?php echo $baseUrl.'/blockedhostmanagement';?>"><span><?php echo Yii::t('app','Blocked Host Management');?></span></a></li>
			<?php } ?>
		</ul>
		</li>
		<?php } ?>


		<?php
			if($userlevel == 'god' || in_array('activelisting', $priviliges) || in_array('blockedlisting', $priviliges))
			{
		?>
		<li><a href="javascript:void(0);"><i class="fa fa-building"></i><span><?php echo Yii::t('app','List Management');?></span></a>
		<ul class="acc-menu">
			<?php
			if( in_array('activelisting', $priviliges) || $userlevel == 'god' )
				{
			?>
				<li><a href="<?php echo $baseUrl.'/activelisting';?>"><span><?php echo Yii::t('app','Active Listing');?></span></a></li>
			<?php 
				}
				if( in_array('blockedlisting', $priviliges) || $userlevel == 'god' )
				{
			?>
				<li><a href="<?php echo $baseUrl.'/blockedlisting';?>"><span><?php echo Yii::t('app','Blocked Listing');?></span></a></li>
			<?php } ?>
		</ul>
		</li>

		<?php } ?>

		<?php
			if($userlevel == 'god' || in_array('reviewsmanagement', $priviliges))
			{
		?>

		<li><a href="<?php echo $baseUrl.'/admin/reviewsmanagement/';?>"><i class="fa fa-building"></i><span><?php echo Yii::t('app','Rating & Reviews');?></span></a></li>
		<?php } ?>

		<?php
			if(in_array('wishlists', $priviliges) || $userlevel == 'god' )
			{
		?>
		<li><a href="<?php echo $baseUrl.'/admin/lists/index';?>"><i class="fa fa-asterisk"></i><span><?php echo Yii::t('app','Manage Wish Lists');?></span></a></li>
		<?php } ?>

		<?php
			if( $userlevel == 'god' || 
				in_array('managereports', $priviliges) || 
				in_array('userreports', $priviliges) || 
				in_array('listingreport', $priviliges))
			{
		?>
		<li><a href="javascript:void(0);"><i class="fa fa-asterisk"></i><span><?php echo Yii::t('app','Reports');?></span></a>
			<ul class="acc-menu">
				<?php
				if( in_array('managereports', $priviliges) || $userlevel == 'god' )
				{
				?>
				<li><a href="<?php echo $baseUrl.'/admin/profilereports/index';?>"><?php echo Yii::t('app','Manage Reports');?></a></li>
				<?php 
				}
				if( in_array('userreports', $priviliges) || $userlevel == 'god' )
				{
				?>
				<li><a href="<?php echo $baseUrl.'/admin/userreport/index';?>"><?php echo Yii::t('app','User Reports');?></a></li>
				<?php 
				} 
				if( in_array('listingreport', $priviliges) || $userlevel == 'god' )
				{
				?>
				<li><a href="<?php echo $baseUrl.'/admin/listreport/index';?>"><?php echo Yii::t('app','Listing Reports');?></a></li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>

		<?php
			if( $userlevel == 'god' || 
				in_array('emailmanagement', $priviliges) || 
				in_array('sitemanagement', $priviliges) || 
				in_array('stripesettings', $priviliges) ||
				in_array('socialloginsettings', $priviliges) ||
				in_array('footersettings', $priviliges) ||
				in_array('managecurrency', $priviliges) ||
				in_array('managelanguages', $priviliges) ||
				in_array('timezone', $priviliges) ||
				in_array('googlecodesettings', $priviliges) ||
				in_array('mobilesmssettings', $priviliges))
			{
		?>
		<li><a href="javascript:void(0);"><i class="fa fa-sitemap"></i><span><?php echo Yii::t('app','Site Settings');?></span></a>
			<ul class="acc-menu">
			<?php
			if( in_array('emailmanagement', $priviliges) || $userlevel == 'god' )
			{
			?>
				<li><a href="<?php echo $baseUrl.'/emailmanagement';?>"><?php echo Yii::t('app','Email Management');?></a></li>
			<?php } 
				if( in_array('sitemanagement', $priviliges) || $userlevel == 'god' )
				{
			?>
				<li><a href="<?php echo $baseUrl.'/sitemanagement';?>"><?php echo Yii::t('app','Site Management');?></a></li>
			<?php } 

			if( in_array('stripesettings', $priviliges) || $userlevel == 'god' )
				{
			?>
				<li><a href="<?php echo $baseUrl.'/stripesettings';?>"><?php echo Yii::t('app','Stripe Settings');?></a></li>
			<?php }

				if( in_array('socialloginsettings', $priviliges) || $userlevel == 'god' )
				{
			?>
				<li><a href="<?php echo $baseUrl.'/socialloginsettings';?>"><?php echo Yii::t('app','Social Login Settings');?></a></li>
			<?php }
				if( in_array('mobilesmssettings', $priviliges) || $userlevel == 'god' )
				{
			?>
				<li><a href="<?php echo $baseUrl.'/mobilesmssettings';?>"><?php echo Yii::t('app','Mobile SMS Settings');?></a></li>
			<?php }
				if( in_array('footersettings', $priviliges) || $userlevel == 'god' )
				{
			 ?>
				<li><a href="<?php echo $baseUrl.'/footersettings';?>"><?php echo Yii::t('app','Footer Settings');?></a></li>
			<?php } 
				if( in_array('managecurrency', $priviliges) || $userlevel == 'god' )
				{
			?>
				<li><a href="<?php echo $baseUrl.'/admin/currency/index';?>"><?php echo Yii::t('app','Manage Currency');?></a></li>
			<?php } 
				if( in_array('managelanguages', $priviliges) || $userlevel == 'god' )
				{
			?>
				<li><a href="<?php echo $baseUrl.'/admin/languages/index';?>"><?php echo Yii::t('app','Manage Languages');?></a></li>
				<?php }  
					/*if( in_array('timezone', $priviliges) || $userlevel == 'god' )
					{		
				?>
				<li><a href="<?php echo $baseUrl.'/admin/timezone/index';?>"><span><?php echo Yii::t('app','Timezone');?></span></a></li>
				<?php } */
					if( in_array('googlecodesettings', $priviliges) || $userlevel == 'god' )
					{
				?>
				<li><a href="<?php echo $baseUrl.'/googlecodesettings';?>"><span><?php echo Yii::t('app','Google Analaytics');?></span></a></li>
				<?php } ?>

			</ul>
		</li>
		<?php } ?>

		<?php
			if( $userlevel == 'god' || 
				in_array('baseproperties', $priviliges) || 
				in_array('additionalamenities', $priviliges) || 
				in_array('commonamenities', $priviliges) ||
				in_array('hometypes', $priviliges) ||
				in_array('roomtypes', $priviliges) ||
				in_array('safetychecklist', $priviliges) ||
				in_array('specialfeatures', $priviliges))
			{
		?>
		<li><a href="javascript:void(0);"><i class="fa fa-reorder"></i><span><?php echo Yii::t('app','Listing Properties');?></span></a>
			<ul class="acc-menu">
			<?php
				if(in_array('baseproperties', $priviliges) || $userlevel == 'god')
				{
			?>
				<li><a href="<?php echo $baseUrl.'/listingproperties';?>"><?php echo Yii::t('app','Base Properties');?></a></li>
			<?php } 
				if(in_array('additionalamenities', $priviliges) || $userlevel == 'god')
				{
			?>
				<li>
					<a href="<?php echo $baseUrl.'/admin/listing/additionalindex';?>"><?php echo Yii::t('app','Additional amenities');?></a>
					<a href="<?php echo $baseUrl.'/admin/listing/additionalcreate';?>" style="display: none;"><?php echo Yii::t('app','Additional Amenities');?></a>
				</li>
				<?php } if(in_array('commonamenities', $priviliges) || $userlevel == 'god') 
						{
					?>

				<li>
					<a href="<?php echo $baseUrl.'/admin/listing/commonindex';?>"><?php echo Yii::t('app','Common amenities');?></a>
					<a href="<?php echo $baseUrl.'/admin/listing/commoncreate';?>" style="display: none;"><?php echo Yii::t('app','Common amenities');?></a>
				</li>
				<?php } 
					if(in_array('hometypes', $priviliges) || $userlevel == 'god')
					{
				?>
				<li>
					<a href="<?php echo $baseUrl.'/admin/listing/homeindex';?>"><?php echo Yii::t('app','Home Types');?></a>
					<a href="<?php echo $baseUrl.'/admin/listing/homecreate';?>" style="display: none;"><?php echo Yii::t('app','Home Types');?></a>
				</li>
				<?php 
				}
				if(in_array('roomtypes', $priviliges) || $userlevel == 'god')
					{
				?>

				<li>
					<a href="<?php echo $baseUrl.'/admin/listing/roomindex';?>"><?php echo Yii::t('app','Room Types');?></a>
					<a href="<?php echo $baseUrl.'/admin/listing/roomcreate';?>" style="display: none;"><?php echo Yii::t('app','Room Types');?></a>
				</li>
				<?php 
				}
				if(in_array('safetychecklist', $priviliges) || $userlevel == 'god')
				{
				?>
				<li>
					<a href="<?php echo $baseUrl.'/admin/listing/safetyindex';?>"><?php echo Yii::t('app','Safety Checklists');?></a>
					<a href="<?php echo $baseUrl.'/admin/listing/safettcreate';?>" style="display: none;"><?php echo Yii::t('app','Safety Checklists');?></a>
				</li>
				<?php } 
					if(in_array('specialfeatures', $priviliges) || $userlevel == 'god')
					{
				?>
				<li>
					<a href="<?php echo $baseUrl.'/admin/listing/specialindex';?>"><?php echo Yii::t('app','Special Features');?></a>
					<a href="<?php echo $baseUrl.'/admin/listing/specialcreate';?>" style="display: none;"><?php echo Yii::t('app','Special Features');?></a>
				</li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>

		<?php
			if( $userlevel == 'god' || 
				in_array('completereservations', $priviliges) || 
				in_array('incompletereservations', $priviliges))
			{
		?>
		<li><a href="javascript:void(0);"><i class="fa fa-money"></i><span><?php echo Yii::t('app','Reservations');?></span></a>
			<ul class="acc-menu">
				<?php	if(in_array('completereservations', $priviliges) || $userlevel == 'god') { ?>
					<li>
						<a href="<?php echo $baseUrl.'/admin/orders/completereservations';?>"><?php echo Yii::t('app','Complete Reservations');?></a>
					</li>
				<?php } ?>

				<?php	if(in_array('incompletereservations', $priviliges) || $userlevel == 'god') { ?>
					<li>
						<a href="<?php echo $baseUrl.'/admin/orders/incompletereservations';?>"><?php echo Yii::t('app','Incomplete Reservations');?></a>
					</li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>


		<?php
			if( $userlevel == 'god' || 
				in_array('completeclaim', $priviliges) || 
				in_array('incompleteclaim', $priviliges))
			{
		?>
		<li><a href="javascript:void(0);"><i class="fa fa-money"></i><span><?php echo Yii::t('app','Security Deposit');?></span></a>
			<ul class="acc-menu">
				<?php	if(in_array('completeclaim', $priviliges) || $userlevel == 'god') { ?>
					<li>
						<a href="<?php echo $baseUrl.'/admin/orders/completeclaim';?>"><?php echo Yii::t('app','Complete Claim');?></a>
					</li>
				<?php } ?>

				<?php	if(in_array('incompleteclaim', $priviliges) || $userlevel == 'god') { ?>
					<li>
						<a href="<?php echo $baseUrl.'/admin/orders/incompleteclaim';?>"><?php echo Yii::t('app','Incomplete Claim');?></a>
					</li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>

		<?php
			if( $userlevel == 'god' || 
				in_array('commission', $priviliges) || 
				in_array('sitecharges', $priviliges) || 
				in_array('tax', $priviliges) ||
				in_array('invoices', $priviliges))
			{
		?>
		<li><a href="javascript:void(0);"><i class="fa fa-money"></i><span><?php echo Yii::t('app','Payment');?></span></a>
			<ul class="acc-menu">
				<?php
					if(in_array('commission', $priviliges) || $userlevel == 'god')
					{
				?>
				<li>
					<a href="<?php echo $baseUrl.'/admin/commission/index';?>"><?php echo Yii::t('app','Commission');?></a>
					<a href="<?php echo $baseUrl.'/admin/commission/create';?>" style="display: none;"><?php echo Yii::t('app','Commission');?></a>
				</li>
				<?php 
					}
					if(in_array('sitecharges', $priviliges) || $userlevel == 'god')
					{
				?>
				<li>
					<a href="<?php echo $baseUrl.'/admin/sitecharge/index';?>"><?php echo Yii::t('app','Site Charges');?></a>
					<a href="<?php echo $baseUrl.'/admin/sitecharge/create';?>" style="display: none;"><?php echo Yii::t('app','Site Charges');?></a>
				</li>
				<?php }
					if(in_array('tax', $priviliges) || $userlevel == 'god')
					{	
				?>
				<li>
					<a href="<?php echo $baseUrl.'/admin/tax/index';?>"><?php echo Yii::t('app','Tax');?></a>
					<a href="<?php echo $baseUrl.'/admin/tax/create';?>" style="display: none;"><?php echo Yii::t('app','Tax');?></a>
				</li>
				<?php }
					if(in_array('invoices', $priviliges) || $userlevel == 'god')
					{	
				?>
				<li><a href="<?php echo $baseUrl.'/admin/orders/invoicemanagement';?>"><?php echo Yii::t('app','Invoices');?></a></li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>

		<?php 
			if( $userlevel == 'god' || 
				in_array('homepagesettings', $priviliges) || 
				in_array('homepagecountries', $priviliges) || 
				in_array('buttonslider', $priviliges))
			{
		?>
		<li><a href="javascript:void(0);"><i class="fa fa-support"></i><span><?php echo Yii::t('app','Landing Page');?></span></a>
		<ul class="acc-menu">
				<?php
					if(in_array('homepagesettings', $priviliges) || $userlevel == 'god')
					{
				?>
			<li><a href="<?php echo $baseUrl.'/homepagesettings';?>"><span><?php echo Yii::t('app','Home Page Settings');?></span></a></li>
				<?php }
					if(in_array('homepagecountries', $priviliges) || $userlevel == 'god')
					{	 
				?>
			<li><a href="<?php echo $baseUrl.'/admin/homecountries/index';?>"><span><?php echo Yii::t('app','Home Page Countries');?></span></a></li>
			<?php }
					if(in_array('buttonslider', $priviliges) || $userlevel == 'god')
					{	
				?>
			<li><a href="<?php echo $baseUrl.'/admin/buttonslider/index';?>"><span><?php echo Yii::t('app','Button Slide');?>r</span></a></li>
			<?php } ?>
		</ul>
		</li>
		<?php } ?>

		<?php
			if( $userlevel == 'god' || 
				in_array('helppages', $priviliges) || 
				in_array('termsandconditions', $priviliges))
			{
		?>
		<li><a href="javascript:void(0);"><i class="fa fa-home"></i><span><?php echo Yii::t('app','Help Pages');?></span></a>
			<ul class="acc-menu">
				<?php
					if(in_array('helppages', $priviliges) || $userlevel == 'god')
					{
				?>
				<li><a href="<?php echo $baseUrl.'/admin/help/index';?>"><?php echo Yii::t('app','Help Pages');?></a></li>
				<?php }
					if(in_array('termsandconditions', $priviliges) || $userlevel == 'god')
					{
				?>
				<li><a href="<?php echo $baseUrl.'/termsandconditions';?>"><?php echo Yii::t('app','Terms and Conditions');?></a></li>
				<?php } ?>
			</ul>		
		</li>
		<?php } ?>

		<?php		  
			if(in_array('cancellation', $priviliges) || $userlevel == 'god')
					{
		?>
		<li><a href="<?php echo $baseUrl.'/admin/cancellation';?>"><i class="fa fa-building"></i><span><?php echo Yii::t('app','Cancellation Policies');?></span></a></li>
		<?php } ?>
	</ul>
</nav>
    </div>
</div>
