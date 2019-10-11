<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use backend\assets\AppAsset;
use yii\helpers\Html;

$this->title = $name;

$baseUrl = Yii::$app->request->baseUrl;

?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl.'/css/bootstrap.css';?>"> 

</head>
<body>
<?php
echo '<div class="oop-bg"><img src="'.$baseUrl.'/images/404-error.jpg" class="img-responsive">
    <div class="panel-body text-center" ><div class="oops-contnt">
    '.Yii::t('app','Oops...! Page not Found.').'</div><br />
   <a href="'.$baseUrl.'/"><input type="button" class="btn btn-danger" value="'.Yii::t('app','Back to dashboard').'"></a> 
    </div>
</div>';
?>
</body>
</html>
<?php /*
<!-- div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above 3 error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div -->
*/ ?>