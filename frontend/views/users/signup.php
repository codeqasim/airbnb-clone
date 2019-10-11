<?php
/*
 * This is for the user to register their account with referral
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Signup';
$baseUrl = Yii::$app->request->baseUrl;
$socialSettings = $sitesetting->socialid;
$socialSettingsDetails = json_decode($socialSettings, true);
$_SESSION['welcomepop'] = '0';

$googleId = isset($socialSettingsDetails['google']['appid'])?$socialSettingsDetails['google']['appid']:'';
?>

  <script src="https://apis.google.com/js/api:client.js"></script>
  <script>
  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '<?php echo trim($googleId); ?>',   
        cookiepolicy: 'single_host_origin', 
      });
      attachSignin(document.getElementById('customBtn'));
    });
  };

  function attachSignin(element) {
    console.log(element.id);
    auth2.attachClickHandler(element, {},
        function(googleUser) {
              var profile = googleUser.getBasicProfile();

              var id = profile.getId();
              var full_name=[];
              full_name.push({
                givenName:profile.getName()
              })
              var last_name = profile.getFamilyName();
              var first_name = profile.getGivenName();
              var image = [];
              image.push({
                url:profile.getImageUrl()
              })
              var email = profile.getEmail();

              var attributes = [];
              attributes.push({
                id:id,
                name:full_name[0],
                last_name:last_name,
                image:image[0],
                email:email,
                first_name:first_name,
                type:'google'
              });

              window.location = baseurl+'/social/'+btoa(JSON.stringify(attributes[0]));

        }, function(error) {
            var error = error.error;
            if(error != "popup_closed_by_user"){
                window.location = baseurl+'/social/error';  
            }    
        });
  }
  </script>
  <style type="text/css">
    #customBtn {
      display: inline-block;
      background: white;
      color: #444;
      width: 100%; 
      border-radius: 3px; 
      border: thin solid #888;
      white-space: nowrap;
      padding: 3px;
    }
    #customBtn:hover {
      cursor: pointer;
    }
    span.label {
      font-family: serif;
      font-weight: normal;
    }
    span.icon {
      background: url('https://google-developers.appspot.com/identity/sign-in/g-normal.png') transparent 5px 50% no-repeat;
      display: inline-block;  
      vertical-align: middle;
      width: 42px;
      height: 42px;
    }
    span.buttonText {
      display: inline-block;
      vertical-align: middle;
      padding-left: 0;
      padding-right: 0; 
      font-size: 18px;  
      font-weight: bold;
      /* Use the Roboto font that is loaded in the <head> */
      /*font-family: 'Roboto', sans-serif;*/
    }
  </style>

  
<div class="pos_rel bg_gray1">
	<div class="container">
  <div class="modal-dialog login_width" role="document">
    <div class="modal-content" style="box-shadow: none;">
      <div class="modal-body text-center">

         <?= yii\authclient\widgets\AuthChoice::widget([
                     'baseAuthUrl' => ['auth']
                ]); ?>



          <div id="gSignInWrapper"> 
            <div id="customBtn" class="customGPlusSignIn">
              <span class="icon"></span>
              <span class="buttonText">Log In with Google</span>
            </div>
          </div> 

          <script>startApp();</script> 


         <div class="login_or border_bottom margin_top10"><span><?php echo Yii::t('app','or');?></span></div>

       <?php 
      if(isset($socialSettingsDetails['socialstatus']) && $socialSettingsDetails['socialstatus'] == "1") { ?>
       <!--<h2 class="login-popup-title">join in to continue</h2>
      	<p><?php echo Yii::t('app','Signup with');?> </p>--><a href="#" class="text-danger margin_top10">
      	      	
      	</a>

        <?php  } else {
        echo Yii::t('app','Sign Up');
        }  ?>
            <?php $form = ActiveForm::begin(['id' => 'form-signup','action'=>'signup',
            		//'onSubmit'=>'return validatedata();'
            		//'enableAjaxValidation' => true,
            		//'enableClientValidation'=>true,
            		//'validateOnSubmit'=>true,
            ]); ?>
				<?php
				if(isset($reff_id) && $reff_id!="")
				{
					?>
                <?= $form->field($model, 'referrer_id')->hiddenInput(['id'=>'referrer_id','value'=> $reff_id])->label(false); ?>
				<?php
				}
				?>
                <?= $form->field($model, 'firstname')->textInput(['id'=>'firstname','class' => 'form-control margin_top30 margin_bottom10','placeholder' => ''.Yii::t('app','First Name').'','onkeypress'=>'return isAlpha(event)','maxlength'=>'30'])->label(false); ?>
                <?= $form->field($model, 'lastname')->textInput(['id'=>'lastname','class' => 'form-control margin_bottom10','placeholder' => ''.Yii::t('app','Last Name').'','onkeypress'=>'return isAlpha(event)','maxlength'=>'30'])->label(false); ?>

                <?= $form->field($model, 'email')->textInput(['id' => 'email', 'class' => 'form-control margin_bottom10','placeholder' => ''.Yii::t('app','Email Address').''])->label(false); ?>
                <!--?= $form->errorSummary($model); ?-->
                <?= $form->field($model, 'password')->passwordInput(['id'=>'password','class' => 'form-control margin_bottom10','placeholder' => ''.Yii::t('app','Password').''])->label(false); ?>
                 <p class="text-right text-danger margin_bottom10 show-paswrd">
                    <a href="javascript:void(0);" onclick="javascript:ToggleSignup();"><?php echo Yii::t('app','Show password'); ?></a>  
                </p>

                <div class="bdaycls"> <label><?php echo Yii::t('app','Birthday ?');?></label>
                     <p><?php echo Yii::t('app','To sign up, you must be 18 or older. Other people won’t see your birthday.'); ?></p>  
                    <br />
        <select name="SignupForm[year]" class="bdayselcls" id="byear">
        <option value="0000"><?php echo Yii::t('app','Year');?></option>
        <?php
          $Year = date('Y') - 18; 
          for($i=$Year;$i>=1900;$i--)
          {
              echo '<option value="'.$i.'">'.$i.'</option>';
          }
        ?>
        </select>

        <select name="SignupForm[month]" class="bdayselcls" id="bmonth">
        <option value="0"><?php echo Yii::t('app','Month');?></option>
        <option value="1"><?php echo Yii::t('app','January');?></option>
        <option value="2"><?php echo Yii::t('app','February');?></option>
        <option value="3"><?php echo Yii::t('app','March');?></option>
        <option value="4"><?php echo Yii::t('app','April');?></option>
        <option value="5"><?php echo Yii::t('app','May');?></option>
        <option value="6"><?php echo Yii::t('app','June');?></option>
        <option value="7"><?php echo Yii::t('app','July');?></option>
        <option value="8"><?php echo Yii::t('app','August');?></option>
        <option value="9"><?php echo Yii::t('app','September');?></option>
        <option value="10"><?php echo Yii::t('app','October');?></option>
        <option value="11"><?php echo Yii::t('app','November');?></option>
        <option value="12"><?php echo Yii::t('app','December');?></option>
        </select>

        <select name="SignupForm[day]" class="bdayselcls" id="bday">
          <option value="0"><?php echo Yii::t('app','Day');?></option>
        
        </select>
        
      </div>
<?php
$termsurl = Yii::$app->urlManager->createAbsoluteUrl("/user/help/terms");;
?>				
<div class="has-error"><p id="bdayerr" class="help-block help-block-error"></p></div>
        <div class="margin_top10 text-left font_size12 margin_bottom10"><p><?php echo Yii::t('app','By signing up, I agree to ');?> <?php echo $sitesetting->sitename;?>'s
		<a href="<?php echo $termsurl;?>" target="_blank" class="text-danger"><?php echo Yii::t('app','Terms and Conditions.');?></a> </p></div>  
                <div class="form-group">
                    <?= Html::submitButton(''.Yii::t('app','Sign up').'', ['id'=>'signup_btn', 'class' => 'btn btn_email margin_top10 width100', 'name' => 'signup-button']) ?> 
                </div> 
				<?php
				$loadimgurl = Yii::$app->urlManager->createAbsoluteUrl ('/images/load.gif');
echo '<img id="signuploadimg" src="'.$loadimgurl.'" class="loading" style="margin-top:-1px;">';
?>
            <?php ActiveForm::end(); ?>  

             <p class="text-center"><?php echo Yii::t('app','Already an');?> <?php echo $sitesetting->sitename;?> <?php echo Yii::t('app','member? ');?><a href="<?php echo $baseUrl.'/signin';?>" class="text-danger"><b><?php echo Yii::t('app','Log in');?></b></a> </p>    
             <!--<p class="changeover">Already have an Airbnb account? <a data-dismiss="modal" data-toggle="modal" href="#loginModal">Log in</a></p>-->
   
      </div>  

    </div>
  </div>
    </div> <!-- container end -->
</div> <!-- list_bg end -->

<script>

function ToggleSignup() { 
    var temp = document.getElementById("password"); 
    if (temp.type === "password") { 
        temp.type = "text"; 
    } else {  
        temp.type = "password"; 
    } 
}  


</script>        

<script>
  $(document).on('change', '#bmonth, #byear', function(e){
      var year = $('#byear').val();
      var month = $('#bmonth').val(); 
      if(month>0 && month<=12 && year > 0) {
        var getDaysInMonth = function(month,year) {
         return new Date(year, month, 0).getDate(); 
        };
        var totalDays = getDaysInMonth(month, year); 
        var count;
        var totalText = "";  
        for(count = 1; count<=totalDays; count++) {
          totalText+="<option value='"+count+"'>"+count+"</option>"; 
        }
        $('#bday').html(totalText);
      }
  });
</script> 