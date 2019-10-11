<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Help;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\Helpsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Helps';
$baseUrl = Yii::$app->request->baseUrl;
?>
<div class="profile_head">
    <div class="container">    
        <ul class="profile_head_menu list-unstyled">
        <?php 
        echo '<li class="active"><a href="'.$baseUrl.'/user/help/index">'.Yii::t('app','Help Center').'</a></li>';
        ?>
        </ul>
    </div> <!--container end -->
</div> <!--profile_head end -->
<div>
      <div class="container margin_bottom30">    

        
        <div class=" help-text-page col-xs-12 col-sm-12 margin_top20">
            <h3 class="help-title-txt"><?php echo Yii::t('app','Suggested for you');?></h3>


            <div class="col-md-12 col-sm-12 col-xs-12 no-hor-padding">

                <div class="help-type">
                    <?php
                        foreach($topicModel as $topics)
                        {
                            $getQuestions = Help::find()->where(['topicid'=> $topics->id])->all();
                            if(count($getQuestions) > 0)
                            {
                    ?>
                    <div class="col-md-4 col-sm-6 col-xs-12 no-hor-padding">
                        <ul>
                            <h3><?= Yii::t('app',$topics->topic); ?></h3>
                            <?php
                                foreach($getQuestions as $questions)
                                {
                                    echo '<li><a href="'.$baseUrl.'/user/help/view/'.$questions->id.'">'.Yii::t('app',$questions->name).'</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                    <?php } } ?>
                </div>

            </div>



            
      </div> <!--col-sm-9 end -->
        
    </div> <!--container end -->
</div>
