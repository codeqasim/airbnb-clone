<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'My Yii Application';
?>


    
    <div class="banner" style="background-image:url(images/banner.jpg);">

        <div class="container">

            <div class="pos_rel banner_text text_white"> 
                           
                <h1>Discover the best holiday homes</h1>
                <h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </h4>
                
                <div class="airfcfx-home-website-search banner_form margin_top40">  
                          	
                    <div class="banner_form_left">                    	
                        	<input type="text" placeholder="Where do u want to go?" class="form-control form_text1" /> 
                            <input id="check-in" class="form-control cal form_text2" placeholder="Checked in ">
                            <input id="check-out" class="form-control cal form_text2" placeholder="Checked Out ">
                            <select class="form-control form_text2">
                            <option>Guest</option>
                            </select>                                             
                    </div>
                    <div class="banner_form_right">
                    	<button class="btn btn_search width100" type="button" /><i class="fa fa-search"></i> Search</button>
                    </div>
                    
            	</div> <!--banner_form end-->
				
				<div class="airfcfx-home-mobile-cal col-xs-12 no-hor-padding">
					<a class="airfcfx-input-model" data-toggle="modal" data-target="#chat-with-seller-modal">Where to ?</a>
					<a href="" class="airfcfx-mobile-cal-search"><div class="airfcfx-search-icon"></div></a>
				</div>
				
				<!--mobile calendar popup-->
				
			<div class="modal fade" id="chat-with-seller-modal" role="dialog"> 
				<div class="modal-dialog mobile-cal-cnt">
					<div class="mobile-cal-header">
						<a class="modal-close" data-behavior="modal-close" href="#">
							<span class="aria-hidden">×</span>
						</a>
						Search
					</div>
					<div class="mobile-cal-body">
						
					</div>
				</div>
			</div>
                
            </div>  <!--banner_text end-->

        </div>
        <!--container end-->

    </div>
    <!--banner end-->
    
<div class="container"> 
    <div id="carousel-example-generic" class="carousel slide margin_top50" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <div class="slide_one" style="background-image:url(images/slide1.jpg);"></div> 
              <div class="col-xs-12 col-sm-4">
                  <div class="carousel-caption slide_caption1">
                  <h1>Hosting Opens Up a World of Opportunity</h1>
                  <h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h4>
                  <button class="btn btn_search">See What you can earn</button>
                  </div> 
              </div> <!-- col-sm-4 end -->    
            </div>
            <div class="item">
              <div class="slide_one" style="background-image:url(images/slide1.jpg);"></div>
              <div class="col-xs-12 col-sm-4">
                  <div class="carousel-caption slide_caption1">
                   <h1>Hosting Opens Up a World of Opportunity</h1>
                  <h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h4>
                  <button class="btn btn_search">See What you can earn</button>
                  </div> 
              </div>   <!-- col-sm-4 end --> 
            </div>
          </div>
	</div> <!-- slide end -->
        
</div> <!-- container end -->

    
<div class="container">
    
    	<div class="text-center margin_top50 margin_bottom30">
    		<h1 class="text-uppercase">Explore the World</h1>
            <h4>See Where people are Travelling, all around the World</h4>
    	</div>
        
        <div class="col-xs-12 col-sm-4" >
        	<a href="#">
        	<div class="explore_img pos_rel" style="background-image:url(images/world1.jpg);">    
            	<div class="explore_top">From <br/> <span>$89</span> </div>
                <div class="explore_bottom">
                <h4>Paris</h4>
                </div>
            </div>
            </a>
        </div> <!--col-sm-4 end-->
        
        <div class="col-xs-12 col-sm-4" >
        	<a href="#">
        	<div class="explore_img pos_rel" style="background-image:url(images/world2.jpg);">    
            	<div class="explore_top">From <br/> <span>$125</span> </div>
                <div class="explore_bottom">
                <h4>Berlin</h4>
                </div>
            </div>
            </a>
        </div> <!--col-sm-4 end-->
        
        <div class="col-xs-12 col-sm-4" >
        	<a href="#">
        	<div class="explore_img pos_rel" style="background-image:url(images/world3.jpg);">    
            	<div class="explore_top">From <br/> <span>$100</span> </div>
                <div class="explore_bottom">
                <h4>London</h4>
                </div>
            </div>
            </a>
        </div> <!--col-sm-4 end-->
       
            <div class="col-xs-12 col-sm-8 margin_top30" >
            	<a href="#">
                <div class="explore_img pos_rel" style="background-image:url(images/world4.jpg);">    
                    <div class="explore_top">From <br/> <span>$125</span> </div>
                    <div class="explore_bottom">
                    <h4>New York</h4>
                    </div>
                </div>
                </a>
            </div> <!--col-sm-8 end-->
            
            <div class="col-xs-12 col-sm-4 margin_top30" >
            	<a href="#">
                <div class="explore_img pos_rel" style="background-image:url(images/world3.jpg);">    
                    <div class="explore_top">From <br/> <span>$60</span> </div>
                    <div class="explore_bottom">
                    <h4>Dubai</h4>
                    </div>
                </div>
                </a>
        </div> <!--col-sm-4 end-->
        
       <div class="text-center ">
       <button class="btn btn_search margin_top30">View all Places</button>
       </div>
        
    </div> <!--container end-->
    
<div id="carousel-example-generic" class="carousel slide margin_top50" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>    
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <div class="slide_one" style="background-image:url(images/slide1.jpg);"></div>
      
      <div class="carousel-caption slide_caption">
       Lorem Ipsum is simply dummy text of the printing and typesetting industry.
      </div>
    </div>
    <div class="item">
      <div class="slide_one" style="background-image:url(images/slide1.jpg);"></div>
      <div class="carousel-caption slide_caption">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
      </div>
    </div>
    
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div> <!-- slide end -->

 <div class="container">
    
    	<div class="text-center margin_top50 margin_bottom30">
    		<h1 class="text-uppercase">Some Good Reason</h1>
            <h4>Lorem Ipsum is simply dummy</h4>
    	</div>
        
        <div class="col-xs-12 col-sm-4">
        	<div class="reason_one">
            	<div class="text-center">
                	<i class="fa fa-map-marker icon_bg fa-3x margin_bottom20"></i>
                    <h1 class="text_white">+1500 Places</h1>
                    <p class="reason_text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ver since the 1500 when an unknown printer</p>
                </div>
            </div>  <!-- reason_one end -->
        </div> <!-- col-sm-4 end -->
        
        <div class="col-xs-12 col-sm-4">
        	<div class="reason_one">
            	<div class="text-center">
                	<i class="fa fa-users icon_bg fa-3x margin_bottom20"></i>
                    <h1 class="text_white">+25678 Customers</h1>
                    <p class="reason_text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ver since the 1500 when an unknown printer</p>
                </div>
            </div>  <!-- reason_one end -->
        </div> <!-- col-sm-4 end -->
        
        <div class="col-xs-12 col-sm-4">
        	<div class="reason_one">
            	<div class="text-center">
                	<i class="fa fa-phone icon_bg fa-3x margin_bottom20"></i>
                    <h1 class="text_white">24/7 Support</h1>
                    <p class="reason_text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ver since the 1500 when an unknown printer</p>
                </div>
            </div>  <!-- reason_one end -->
        </div> <!-- col-sm-4 end -->
        
 </div> <!-- Container end -->
 
 <div class="container  margin_bottom30">
    	<div class="text-center margin_top50 margin_bottom30">
    		<h1 class="text-uppercase">Our Community</h1>
    	</div>
        <div class="col-xs-12 col-sm-3">
        	<div class="community1 text-center">
            	<a href="#">
            	<h1 class="text_white">Create</h1>
                <img src="images/create.png" alt="create"  />
                <br/>
                <h2 class="text_white">Make airbnb Yours</h2>
                <p class="text_white">Lorem Ipsum is simply dummy text</p>
                </a>
            </div> <!-- community1 end -->
        </div> <!-- col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-3">
        	<a href="#">
        	<div class="community2" style="background-image:url(images/create1.jpg);">
            	<button class="btn btn_travel">Traveling</button>
                <div class="community_text text-center">
                <h2 class="text_white ">Alice & Chris</h2>
                <p class="text_white ">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                </div> <!-- community2_text end -->
            </div> <!-- community2 end -->
            </a>
        </div> <!-- col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-3">
        	<a href="#">
        	<div class="community2" style="background-image:url(images/create2.jpg);">
            	<button class="btn btn_business">Business Travel</button>
                <div class="community_text text-center">
                <h2 class="text_white ">For Business</h2>
                <p class="text_white ">Lorem Ipsum is simply dummy text of the printing </p>
                </div> <!-- community2_text end -->
            </div> <!-- community2 end -->
            </a>
        </div> <!-- col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-3">
        	<a href="#">
        	<div class="community2" style="background-image:url(images/create3.jpg);">
            	<button class="btn btn_host">Hosting</button>
                <div class="community_text text-center">
                <h2 class="text_white ">Lorem Ipsum</h2>
                <p class="text_white ">Lorem Ipsum is simply dummy text of the printing and typesetting industry </p>
                </div> <!-- community2_text end -->
            </div> <!-- community2 end -->
            </a>
        </div> <!-- col-sm-3 end -->
        
 </div> <!-- Container end -->

<div class="footer">
	<div class="container margin_bottom30">
    	<div class="col-xs-12 col-sm-4">
				<h4 class="text_white">Contact Us</h4>
				<ul class="footer_menu list-unstyled">
				<?php
				echo '<li> '.$footercontent['address'].'</li>
				<li> <b>Phone:</b> '.$footercontent['phone'].'</li>
				<li> <b>Email:</b>
						'.$footercontent['email'].'</li>
				';
				 
				?>
				</ul>
				<div class="airfcfx-footer-app-section col-xs-12 col-sm-12 no-hor-padding">
					<div class="airfcfx-app-section-txt">Native Apps Available On</div>
					<div class="airfcfx-footer-app-link">
						<a href="" class="airfcfx-app-link"><img src="images/ios-app-link.png" width="32px" height="32px" alt="ios link"></a>
						<a href="" class="airfcfx-app-link"><img src="images/android-app-link.png" width="32px" height="32px" alt="ios link"></a>
					</div>
				</div>
			</div>
			<!-- col-sm-4 end -->
		
			<div class="col-xs-12 col-sm-8">
                <h4 class="text_white">Informations</h4>
                
                <?php
                $i = 0;
                echo '<ul class="airfcfx-footer-ul footer_menu list-unstyled">';
                foreach($helppages as $helps)
                {
                    echo '<li><a href="'.$baseUrl.'/user/help/view?id='.$helps->id.'">'.$helps->name.'</a></li>';
                    $i++;
                    if($i%5==0)
                    echo '</ul><ul class="airfcfx-footer-ul footer_menu list-unstyled">';
                }
                echo '</ul>';
                ?>
              
            </div>
			<!-- col-sm-4 end -->
        
    </div> <!-- container end -->
    
    <div class="container">
    	<div class="airfcfx-footer-border border_bottom1 margin_top20 margin_bottom20"></div>
        <div class="text-center">
        	<i class="fa fa-facebook social_icon text_white"></i>
            <i class="fa fa-twitter social_icon text_white"></i>
            <i class="fa fa-google-plus social_icon text_white"></i>
            <i class="fa fa-linkedin social_icon text_white"></i>
            <i class="fa fa-youtube-play social_icon text_white"></i>
            <i class="fa fa-pinterest-p social_icon text_white"></i>
            <i class="fa fa-instagram social_icon text_white"></i>
            <p class="text_white margin_top10">Copyright &copy; companyname.com 2015. Privacy Policy</p>
        </div>
    </div> <!-- container end -->
    
</div> <!-- footer end -->



<!-- Modal -->
<!--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog signup_width" role="document">
    <div class="modal-content">
      <div class="modal-header no_border">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body text-center">
        <button class="btn btn_fb width100" type="button"><i class="fa fa-facebook "></i> Signup with Facebook</button>
        <button class="btn btn_google margin_top10 width100" type="button"><i class="fa fa-google google_color"></i> Signup with Facebook</button>
        <div class="margin_top10">or</div>
        <button class="btn btn_email margin_top10 width100" type="button"><i class="fa fa-envelope-o"></i> Signup with Email</button>
        <p class="margin_top20 text-left font_size12 margin_bottom10">By signing up, I agree to Airbnb's <a href="#" class="text-danger">Terms of Service</a>, <a href="#" class="text-danger">Privacy Policy</a>, <a href="#" class="text-danger">Guest Refund Policy</a>, and <a href="#" class="text-danger">Host Guarantee Terms.</a> </p>
      </div>
      <div class="modal-footer">
        <p class="text-left">Already an Airbnb member? <a href="#" class="text-danger"><b>Log in</b></a> </p>
      </div>
    </div>
  </div>
</div>-->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog login_width" role="document">
    <div class="modal-content">
      <div class="modal-header no_border">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body text-center">
      	<p>Signup with <a href="#" class="text-danger">Facebook</a> or <a href="#" class="text-danger">Google</a></p>
        <div class="login_or border_bottom margin_top10"><span>or</span></div>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>        
        <form>
        <input type="text" class="form-control margin_top20 margin_bottom20" placeholder="First Name" name="firstname" />
        <input type="text" class="form-control margin_bottom20" placeholder="Last Name" name="lastname" />
        <input type="text" class="form-control margin_bottom20" placeholder="Email Address" id="signupform-email" name="SignupForm[email]" />
        <input type="text" class="form-control margin_bottom20" placeholder="Password" />
        <div class="pull-left form-control no_border">
        <label>Birthday ?</label>
                
        <select >
        <option value="">Month</option>
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
        </select>
        
        <select >
        <option value="">Day</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
        </select>
        
        <select >
        <option value="">Year</option>
        <option value="2015">2015</option>
        <option value="2014">2014</option>
        <option value="2013">2013</option>
        <option value="2012">2012</option>
        <option value="2011">2011</option>
        <option value="2010">2010</option>
        <option value="2009">2009</option>
        <option value="2008">2008</option>
        <option value="2007">2007</option>
        <option value="2006">2006</option>
        <option value="2005">2005</option>
        <option value="2004">2004</option>
        <option value="2003">2003</option>
        <option value="2002">2002</option>
        <option value="2001">2001</option>
        <option value="2000">2000</option>
        <option value="1999">1999</option>
        <option value="1998">1998</option>
        <option value="1997">1997</option>
        <option value="1996">1996</option>
        <option value="1995">1995</option>
        <option value="1994">1994</option>
        <option value="1993">1993</option>
        <option value="1992">1992</option>
        <option value="1991">1991</option>
        <option value="1990">1990</option>
        <option value="1989">1989</option>
        <option value="1988">1988</option>
        <option value="1987">1987</option>
        <option value="1986">1986</option>
        <option value="1985">1985</option>
        <option value="1984">1984</option>
        <option value="1983">1983</option>
        <option value="1982">1982</option>
        <option value="1981">1981</option>
        <option value="1980">1980</option>
        <option value="1979">1979</option>
        <option value="1978">1978</option>
        <option value="1977">1977</option>
        <option value="1976">1976</option>
        <option value="1975">1975</option>
        <option value="1974">1974</option>
        <option value="1973">1973</option>
        <option value="1972">1972</option>
        <option value="1971">1971</option>
        <option value="1970">1970</option>
        <option value="1969">1969</option>
        <option value="1968">1968</option>
        <option value="1967">1967</option>
        <option value="1966">1966</option>
        <option value="1965">1965</option>
        <option value="1964">1964</option>
        <option value="1963">1963</option>
        <option value="1962">1962</option>
        <option value="1961">1961</option>
        <option value="1960">1960</option>
        <option value="1959">1959</option>
        <option value="1958">1958</option>
        <option value="1957">1957</option>
        <option value="1956">1956</option>
        <option value="1955">1955</option>
        <option value="1954">1954</option>
        <option value="1953">1953</option>
        <option value="1952">1952</option>
        <option value="1951">1951</option>
        <option value="1950">1950</option>
        <option value="1949">1949</option>
        <option value="1948">1948</option>
        <option value="1947">1947</option>
        <option value="1946">1946</option>
        <option value="1945">1945</option>
        <option value="1944">1944</option>
        <option value="1943">1943</option>
        <option value="1942">1942</option>
        <option value="1941">1941</option>
        <option value="1940">1940</option>
        <option value="1939">1939</option>
        <option value="1938">1938</option>
        <option value="1937">1937</option>
        <option value="1936">1936</option>
        <option value="1935">1935</option>
        <option value="1934">1934</option>
        <option value="1933">1933</option>
        <option value="1932">1932</option>
        <option value="1931">1931</option>
        <option value="1930">1930</option>
        <option value="1929">1929</option>
        <option value="1928">1928</option>
        <option value="1927">1927</option>
        <option value="1926">1926</option>
        <option value="1925">1925</option>
        <option value="1924">1924</option>
        <option value="1923">1923</option>
        <option value="1922">1922</option>
        <option value="1921">1921</option>
        <option value="1920">1920</option>
        <option value="1919">1919</option>
        <option value="1918">1918</option>
        <option value="1917">1917</option>
        <option value="1916">1916</option>
        <option value="1915">1915</option>
        <option value="1914">1914</option>
        <option value="1913">1913</option>
        <option value="1912">1912</option>
        <option value="1911">1911</option>
        <option value="1910">1910</option>
        <option value="1909">1909</option>
        <option value="1908">1908</option>
        <option value="1907">1907</option>
        <option value="1906">1906</option>
        <option value="1905">1905</option>
        <option value="1904">1904</option>
        <option value="1903">1903</option>
        <option value="1902">1902</option>
        <option value="1901">1901</option>
        <option value="1900">1900</option>
        <option value="1899">1899</option>
        <option value="1898">1898</option>
        <option value="1897">1897</option>
        <option value="1896">1896</option>
        <option value="1895">1895</option>
        </select>
        </div>
        <div class="form-control no_border pull-left margin_top10 margin_bottom20">
        <div class="checkbox">
        <label>
          <input type="checkbox"> I�d like to receive coupons and inspiration
        </label>
      </div>
        
        </div>
                 
        </form>
        <div class="margin_top10 text-left font_size12 margin_bottom10"><p>By signing up, I agree to Airbnb's <a href="#" class="text-danger">Terms of Service</a>, <a href="#" class="text-danger">Privacy Policy</a>, <a href="#" class="text-danger">Guest Refund Policy</a>, and <a href="#" class="text-danger">Host Guarantee Terms.</a> </p></div>       
        <button class="btn btn_email margin_top10 width100" type="button">Sign up</button>
      </div>  
      <div class="modal-footer">
        <p class="text-left">Already an Airbnb member? <a href="#" class="text-danger"><b>Log in</b></a> </p>        
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog login_width" role="document">
    <div class="modal-content">
      <div class="modal-header no_border">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body text-center">
      	<button class="btn btn_fb width100" type="button"><i class="fa fa-facebook "></i> Signup with Facebook</button>
        <button class="btn btn_google margin_top10 width100" type="button"><i class="fa fa-google google_color"></i> Signup with Facebook</button>
        <div class="login_or border_bottom margin_top10"><span>or</span></div>
        <form>
        <input type="text" class="form-control margin_top30 margin_bottom10" placeholder="Email ID" />
        <input type="text" class="form-control margin_bottom10" placeholder="Password" />
        <div class="pull-left margin_bottom10"><input type="checkbox" class="" /> Remember me</div>
        <p class="text-right text-danger margin_bottom10">Forget Password?</p>
        <button class="btn btn_email margin_top10 width100" type="button"> Login</button>
        </form>
        </div>
      <div class="modal-footer">
        <p class="text-left">Don�t have an account?  <a href="#" class="text-danger"><b>Sign Up</b></a> </p>
      </div>
    </div>
  </div>
</div>


<script>

	$(function () {
$("#check-in").datepicker({
	minDate:new Date(),
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#check-out").datepicker("option", "minDate", dt);
        }
    });
    $("#check-out").datepicker({
		minDate:new Date(),
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#check-in").datepicker("option", "maxDate", dt);
        }
    });

	});
	

</script>


