<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Help */

$this->title = $model->name;
$baseUrl = Yii::$app->request->baseUrl;
?>
<div class="help-view">

      <div class="container margin_bottom30">    

        
        <div class="col-xs-12 col-sm-12 margin_top20">
            <div class="col-xs-8 helpdiv no-hor-padding">
                
            <?php
            echo '<h2 class="text-center">'.Yii::t('app',$model->name).'</h2>';
            echo '<div class="col-xs-12" style="margin-top:4px;">'.Yii::t('app',$model->maincontent).'</div>';
            echo '<div class="clear"></div><br />';
            echo '<div class="col-xs-12">'.Yii::t('app',$model->subcontent).'</div>';
            ?>
            </div>
      </div> <!--col-sm-9 end -->
        
    </div> <!--container end -->

</div>
