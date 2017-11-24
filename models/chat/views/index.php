<?php
$bundle = \panix\engine\emoji\EmojiPickerAsset::register($this);
?>
<script>
    $(function () {

        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '<?= $bundle->baseUrl ?>/images/',
            popupButtonClasses: 'icon-emoji'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();

    });

</script>
<div class="chat-panel panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="icon-comments"></i> Чат
            <div class="btn-group pull-right hidden2">
                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-arrow-down"></i>
                </button>
                <ul class="dropdown-menu slidedown">
                    <li>
                        <a href="#">
                            <i class="icon-refresh"></i> Refresh
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-check-circle fa-fw"></i> Available
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-times fa-fw"></i> Busy
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-clock-o fa-fw"></i> Away
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <ul class="chat" id="chat-box">
            <?= $data; ?>
        </ul>
    </div>  
    <div class="panel-footer">
        <div class="emoji-picker-container">
            <textarea name="Chat[message]" id="chat_message" data-emojiable="true" placeholder="Сообщение..." class="form-control" rows="1" style="width:100%;resize:none;"></textarea>



            <div class="text-right" style="margin-top: 10px;">
                <button class="btn btn-sm btn-success btn-send-comment" data-url="<?= $url; ?>" data-model="<?= $userModel; ?>" data-userfield="<?= $userField; ?>" data-loading="<?= $loading; ?>"><i class="icon-send"> <?= Yii::t('app', 'SEND') ?></button>
            </div>
        </div>
    </div>

</div>