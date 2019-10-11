<?php

$this->beginPage();

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
 
use frontend\components\MyClass;

AppAsset::register($this);

   $sitesetting = Yii::$app->mycomponent->getLogo();
	if(isset($sitesetting->metakey))
		$metakey = $sitesetting->metakey;
	else
		$metakey = "";

	if(isset($sitesetting->metadesc))
		$metadesc = $sitesetting->metadesc;
	else
		$metadesc = "";
            
	$baseUrl = Yii::$app->request->baseUrl;
	$adminUrl = Yii::$app->request->baseUrl.'/admin';

?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
   <meta charset="<?= Yii::$app->charset ?>">
	<meta name="description" content="<?php echo $metakey; ?>">
	<meta name="keywords" content="<?php echo $metadesc; ?>">        
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	  
   <title><?= $sitesetting->sitetitle; ?></title>
   <link href="<?php echo $adminUrl."/images/".$sitesetting->defaultfavicon; ?>" type="image/x-icon" rel="icon"> 
   <script src="https://js.stripe.com/v3/"></script>
   <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl.'/css/stripebase.css'; ?>">
   <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl.'/css/stripepay.css'; ?>">
</head>
<body>
<?php $this->beginBody() ?>

        <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
