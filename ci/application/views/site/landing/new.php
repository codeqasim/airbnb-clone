               <?php 
                $selectedLangCode = $this->session->userdata('language_code');
                if ($selectedLangCode == ''){
                	$selectedLangCode = $defaultLg[0]['lang_code'];
                }
                if (count($activeLgs)>0){
                	foreach ($activeLgs as $activeLgsRow){
                ?>							
                    <li><a href="lang/<?php echo $activeLgsRow['lang_code'];?>" <?php if ($selectedLangCode == $activeLgsRow['lang_code']){echo 'class="active"';}?>><?php echo $activeLgsRow['name'];?></a></li>
                <?php } } ?>
				
				
				