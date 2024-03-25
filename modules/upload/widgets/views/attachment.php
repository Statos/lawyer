<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $self \app\modules\upload\widgets\AttachmentWidget */
/* @var $attachments \app\modules\upload\models\Attachments[] */

?>

<?php
echo Html::beginTag('div');
?>

<?php foreach ($attachments as $attach): ?>
    <div id="attach-img-<?=$attach->id?>" class="upload-img">
        <img src="<?=$attach->titleUrl?>" width="200px">
        <script>set_hidden_input(<?=$attach->id?>)</script>
    </div>
<?php endforeach; ?>

<?php
echo Html::endTag('div');
?>