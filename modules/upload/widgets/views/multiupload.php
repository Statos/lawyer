<?php
use yii\helpers\Html;
?>


    <script>
        function remove_attachment(id) {
            $.ajax({
                type : 'POST',
                url : '<?=$options['delete_url']?>',
                dataType: 'json',
                data : { id : id },
                success : function(data){
                    if(data['success'] != undefined){
                        $('#upload-img-' + id).hide(400, function(){
                            $(this).remove();
                        });
                        var value = $('#<?=$options['id']?>').val();
                        if(value)
                            value = value.split(',');
                        else
                            value = [];
                        var result = [];
                        for(var i=0; i< value.length; i++){
                            if(value[i] != id)
                                result.push(value[i]);
                        }
                        $('#<?=$options['id']?>').val(result.join(','));
                    }
                }
            })
        }
        function set_hidden_input(id){
            var input = document.getElementById('<?=$options['id'];?>');
            var value = input.value;
            if(value)
                value = value.split(',');
            else
                value = [];
            value.push(id);
            input.value = value.join(',');
        }
    </script>



<?php
$self->loadFileInput();
?>

<?php echo Html::beginTag('div', $options['progress_bar']); ?>
    <div class="progress-bar progress-bar-success"></div>
<?php echo Html::endTag('div'); ?>

<?php
echo Html::hiddenInput($options['name'], "", [
    'id' => $options['id'],
]);
?>

<?php
echo Html::beginTag('div', [
    'id' => $options['img_id'],
    'class' => $options['div_class'],
]);
?>

<?php foreach ($attachment as $attach): ?>
    <div id="upload-img-<?=$attach->id?>" class="upload-img">
        <div class="delete-button" onclick="remove_attachment(<?=$attach->id?>);">&times</div>
        <img src="<?=$attach->titleUrl?>" width="200px">
        <script>set_hidden_input(<?=$attach->id?>)</script>
    </div>
<?php endforeach; ?>

<?php
echo Html::endTag('div');
?>