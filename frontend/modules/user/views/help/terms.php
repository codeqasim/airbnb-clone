<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Help */

$this->title = "Terms and Conditions";
$baseUrl = Yii::$app->request->baseUrl;
?>
<div class="help-view">

      <div class="container margin_bottom30">    

        
        <div class="col-xs-12 col-sm-12 margin_top20">
            <div class="col-xs-8 helpdiv">
                
            <?php
            echo '<h2 class="text-center">Terms and Conditions</h2>';
            echo '<div class="col-xs-12" style="margin-top:4px;">'.$model->main_termsandconditions.'</div>';
            echo '<div class="clear"></div><br />';
            echo '<div class="col-xs-12">'.$model->sub_termsandconditions.'</div>';
            ?>
            </div>
      </div> <!--col-sm-9 end -->
        
    </div> <!--container end -->

</div>
