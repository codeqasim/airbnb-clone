<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Users */
$this->title = "Create Moderator's";
$this->params['subtitle'] = 'Create moderator';
$this->params['breadcrumbs'][]= '<ol class="breadcrumb">
<li class="active"><a href="/dev/admin/dashboard">Dashboard</a></li>
<li class="active"><a href="javascript:history.back(1);">Go back</a></li>
</ol>';
?>
<div class="panel panel-default" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
		<div class="panel-heading">
		<h2>Create Moderator</h2>
		</div>
<div class="panel-body">
<div class="users-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
<script type="text/javascript">
	$('#users-password').val('');
</script>