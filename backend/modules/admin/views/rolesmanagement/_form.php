<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Lists */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lists-form">
    <?php $form = ActiveForm::begin([
    		'enableAjaxValidation'=>false,
    		'options' => array('onsubmit'=>'return createRoleValidate()'),
            ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => '150'])->label(Yii::t('app','Role Name')); ?>
    <?= $form->field($model, 'description')->textarea(['maxlength' => '350'])->label(Yii::t('app','Role Descriptions')); ?>
    <div class="form-group field-roleandprivilige-roles required has-success">
        <a href="javascript:void(0);" onclick="view_roles()">Assign roles</a>
        <div class="help-block"></div>
    </div>

    <?php
    $userid = Yii::$app->user->identity->id;
    ?>
    <?= $form->field($model, 'created_time')->hiddenInput(['value'=>''.date('Y-m-d h:i:s').''])->label(false); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['id'=>'listcreatebtn','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'onclick'=>"if(!this.form.checkbox.checked){alert('You must agree to the terms first.');return false}"]) ?>
    </div>


<?php
    if(isset($model->priviliges))
    {
        $priviliges = json_decode($model->priviliges);
    }else{
        $priviliges = array();
    }
?>
    <!-- Popup starts-->
        <div class="invoice-popup-overlay">
            <div class="invoice-popup invoicediv">
                <div>
                    <button class="btn btn-danger pop-close pop-corner" style="float: right;" type="button"><?php echo Yii::t('app','Close');?></button>
                    <div id="userdetails"></div>
                    <div id="rolesdetails">
                        <div class="leftdiv"><?php echo Yii::t('app','Roles:');?> </div>
                        <div class="select-all"><input type="checkbox" name="select_all" id="select_all" />Select All</div>
                        <div class="rightdiv">
                            <div class="leftcolumn" style="float: left;width: 60%;">
                                <div class="roleHeader">Role & Privileges</div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="rolesmanagement" value="rolesmanagement" <?php if(in_array('rolesmanagement',$priviliges)) echo 'checked="checked"'; ?> > 
                                    <span>Roles</span>
                                </div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="moderator" <?php if(in_array('moderator',$priviliges)) echo 'checked="checked"'; ?> value="moderator">
                                    <span>Moderator Management</span>
                                </div> 

                                <div class="roleHeader">Users</div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="usermanagement" value="usermanagement" <?php if(in_array('usermanagement',$priviliges)) echo 'checked="checked"'; ?> >
                                    <span>Active User Management</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="blockedusermanagement" <?php if(in_array('blockedusermanagement',$priviliges)) echo 'checked="checked"'; ?> value="blockedusermanagement" >
                                    <span>Blocked User Management</span>
                                </div>

                                <div class="roleHeader">Host Management</div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="activehostmanagement" <?php if(in_array('activehostmanagement',$priviliges)) echo 'checked="checked"'; ?> value="activehostmanagement" >
                                    <span>Active Host Management</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="blockedhostmanagement" <?php if(in_array('blockedhostmanagement',$priviliges)) echo 'checked="checked"'; ?> value="blockedhostmanagement" >
                                    <span>Blocked Host Management</span>
                                </div>

                                <div class="roleHeader">List Management</div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="activelisting" <?php if(in_array('activelisting',$priviliges)) echo 'checked="checked"'; ?> value="activelisting" >
                                    <span>Active Listing</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" <?php if(in_array('blockedlisting',$priviliges)) echo 'checked="checked"'; ?> id="blockedlisting" value="blockedlisting" >
                                    <span>Blocked Listing</span>
                                </div> 

                                <div class="roleHeader">Reviews & Ratings</div>
                                <div class="roleinput"> 
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="reviewsmanagement" <?php if(in_array('reviewsmanagement',$priviliges)) echo 'checked="checked"'; ?> value="reviewsmanagement" >
                                    <span>Reviews Management</span>
                                </div>
                                
                                <div class="roleHeader">Wishlists</div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="wishlists" <?php if(in_array('wishlists',$priviliges)) echo 'checked="checked"'; ?> value="wishlists" >
                                    <span>Manage Wishlists</span>
                                </div>
                                
                                <div class="roleHeader">Reports</div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="managereports" <?php if(in_array('managereports',$priviliges)) echo 'checked="checked"'; ?> value="managereports" >
                                    <span>Manage Reports</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="userreports" <?php if(in_array('userreports',$priviliges)) echo 'checked="checked"'; ?> value="userreports" >
                                    <span>User Reports</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="listingreport" <?php if(in_array('listingreport',$priviliges)) echo 'checked="checked"'; ?> value="listingreport" >
                                    <span>Listing Reports</span>
                                </div> 

                                <div class="roleHeader">Site Settings</div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="emailmanagement" <?php if(in_array('emailmanagement',$priviliges)) echo 'checked="checked"'; ?> value="emailmanagement" >
                                    <span>Email Management</span>
                                </div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="sitemanagement" value="sitemanagement" <?php if(in_array('sitemanagement',$priviliges)) echo 'checked="checked"'; ?> >
                                    <span>Sitemanagement</span>
                                </div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="stripesettings" value="stripesettings" <?php if(in_array('stripesettings',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Stripe Settings</span>
                                </div> 

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="socialloginsettings" value="socialloginsettings" <?php if(in_array('socialloginsettings',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Social Login Settings</span>
                                </div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="mobilesmssettings" value="mobilesmssettings" <?php if(in_array('mobilesmssettings',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Mobile SMS Settings</span> 
                                </div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="footersettings" value="footersettings" <?php if(in_array('footersettings',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Footer Settings</span>
                                </div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="managecurrency" value="managecurrency" <?php if(in_array('managecurrency',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Manage Currency</span>
                                </div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="managelanguages" value="managelanguages" <?php if(in_array('managelanguages',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Manage Languages</span>
                                </div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="timezone" value="timezone" <?php if(in_array('timezone',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Timezone</span>
                                </div> 

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="googlecodesettings" value="googlecodesettings" <?php if(in_array('googlecodesettings',$priviliges)) echo 'checked="checked"'; ?>><span>Google Analaytics</span>
                                </div>
                                
                            </div>

                            <div class="rightcolumn">
                                
                                <div class="roleHeader">Listing Properties</div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="baseproperties" value="baseproperties" <?php if(in_array('baseproperties',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Base Properties</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="additionalamenities" value="additionalamenities" <?php if(in_array('additionalamenities',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Additional Amenities</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="commonamenities" value="commonamenities" <?php if(in_array('commonamenities',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Common Amenities</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="hometypes" value="hometypes" <?php if(in_array('hometypes',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Home Types</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="roomtypes" value="roomtypes" <?php if(in_array('roomtypes',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Room Types</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="safetychecklist" value="safetychecklist" <?php if(in_array('safetychecklist',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Safety Checklists</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="specialfeatures" value="specialfeatures" <?php if(in_array('specialfeatures',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Special Features</span>
                                </div>

                                <div style="font-weight: bold;padding: 10px 0;">Reservations</div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="completereservations" value="completereservations" <?php if(in_array('completereservations',$priviliges)) echo 'checked="checked"'; ?> > 
                                    <span>Complete Reservations</span>
                                </div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="incompletereservations" value="incompletereservations" <?php if(in_array('incompletereservations',$priviliges)) echo 'checked="checked"'; ?> > 
                                    <span>Incomplete Reservations</span>
                                </div>

                                <div style="font-weight: bold;padding: 10px 0;">Security Deposit</div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="completeclaim" value="completeclaim" <?php if(in_array('completeclaim',$priviliges)) echo 'checked="checked"'; ?> > 
                                    <span>Complete claim</span>
                                </div>

                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="incompleteclaim" <?php if(in_array('incompleteclaim',$priviliges)) echo 'checked="checked"'; ?> value="incompleteclaim" >
                                    <span>Incomplete claim</span>
                                </div>

                                <div style="font-weight: bold;padding: 10px 0;">Payment</div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="commission" <?php if(in_array('commission',$priviliges)) echo 'checked="checked"'; ?> value="commission" >
                                    <span>Commission</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="sitecharges" <?php if(in_array('sitecharges',$priviliges)) echo 'checked="checked"'; ?> value="sitecharges" >
                                    <span>Site Charges</span>
                                </div> 
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="tax" <?php if(in_array('tax',$priviliges)) echo 'checked="checked"'; ?> value="tax" >
                                    <span>Tax</span>
                                </div>
                        
                                <div class="roleinput">
                                    <input type="checkbox" class="checkBoxClass" name="roles[]" id="invoices" value="invoices" <?php if(in_array('invoices',$priviliges)) echo 'checked="checked"'; ?> >
                                    <span>Invoices</span>
                                </div>
                                
                                <div class="roleHeader">Landing Page</div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="homepagesettings" value="homepagesettings" <?php if(in_array('homepagesettings',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Home Page Settings</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="homepagecountries" value="homepagecountries" <?php if(in_array('homepagecountries',$priviliges)) echo 'checked="checked"'; ?>> 
                                    <span>Home Page Countries</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="buttonslider" value="buttonslider" <?php if(in_array('buttonslider',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Button Slider</span>
                                </div>

                                <div class="roleHeader">Help Pages</div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="helppages" value="helppages" <?php if(in_array('helppages',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Help Pages</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="termsandconditions" value="termsandconditions" <?php if(in_array('termsandconditions',$priviliges)) echo 'checked="checked"'; ?>><span>Terms & Conditions</span>
                                </div>
                                <div class="roleinput">
                                    <input type="checkbox" name="roles[]" class="checkBoxClass" id="cancellation" value="cancellation" <?php if(in_array('cancellation',$priviliges)) echo 'checked="checked"'; ?>>
                                    <span>Cancellation Policies</span>
                                </div> 
                            </div>
                        </div>

                        <div class="saveroleserror has-error">
                            <div class="help-block"></div>
                        </div>
                        <input type="button" onclick="saveroless();" value="Save" class="btn btn-primary">

                        <div class="msgerrcls"></div>
                        <div class="has-success" id="succmsg" style="display: none;">
                            <p class="help-block">
                                <i class="fa fa-check"></i>
                                <?php echo Yii::t('app','Roles assigned successfully');?>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    <!-- End popup -->


    <?php ActiveForm::end(); ?>
</div>

<style type="text/css">
    .roleHeader {
       font-weight: bold;
       padding: 10px 0 !important; 
       font-size: 14px;
    }
    div.roleinput, input{
        margin-right: 5px !important;
        margin-top: 1px !important;
        padding: 10px 10px;

    }
     div.roleinput, span{
        display: inline-block !important;
     }

     #rolesdetails .roleinput {
        width: 100%;
        margin: 0 !important;
        padding: 10px 10px;
    }
    input.checkBoxClass, input#select_all{
        position: relative;
        top:4px; 
    }

    .rightcolumn {
        float: left;
        width: 40%;
    }
</style>
<script type="text/javascript">
    $("#select_all").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });

    $(".checkBoxClass").click(function () {
                
        var rolesCountChecked = $(".rightdiv input.checkBoxClass:checkbox:checked").length;
        if(rolesCountChecked > 0){
            var rolesCountall = $(".rightdiv input.checkBoxClass:checkbox").length;
            if(rolesCountChecked < rolesCountall) {
                $('.select-all > input').prop('checked',false);   
            } else if(rolesCountChecked == rolesCountall) {
                $('.select-all > input').prop('checked',true); 
            }
        } else {
            $('.select-all > input').prop('checked',false);  
        }
        
    });

    function saveroless()
    {
        var rolesCount = $("input:checkbox:checked").length;
        if( rolesCount <= 0){
            $(".saveroleserror .help-block").show();
            $(".saveroleserror .help-block").html("Please select any roles");
            setTimeout(function() {
                $('.saveroleserror .help-block').fadeOut('slow');
                $(".saveroleserror .help-block").html("");
            }, 4000);     
            return false;
        } else {
            $('.invoice-popup-overlay').hide();
            $('.invoice-popup-overlay').css("opacity", "0");
        }     
           
    }

    $(document).ready(function(){
        var rolesCountChecked = $("input:checkbox:checked").length;
        if(rolesCountChecked > 0){
            var rolesCountall = $("input:checkbox").length;
            var roles = rolesCountall - 1;

            if(roles == rolesCountChecked) {
                $('.select-all > input').attr('checked','checked'); 
            } 
        }
    });

</script>