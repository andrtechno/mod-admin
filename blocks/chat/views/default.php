<?php
$bundle = \panix\engine\emoji\EmojiPickerAsset::register($this);
$this->registerJs("
    $(function () {

        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '".$bundle->baseUrl."/images',
            popupButtonClasses: 'icon-smile'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();

    });
");

?>

<div class="chat-panel">

        <div class="chat" id="chat-box">
            <?= $data; ?>
        </div>


</div>
<div class="card-footer">
    <div class="emoji-picker-container">
        <textarea name="Chat[message]" id="chat_message" data-emojiable="true" placeholder="Сообщение..." class="form-control" rows="1" style="width:100%;resize:none;"></textarea>
        <div class="text-right" style="margin-top: 10px;">
            <button class="btn btn-sm btn-success btn-send-comment" data-url="<?= $url; ?>" data-model="<?= $userModel; ?>" data-userfield="<?= $userField; ?>" data-loading="<?= $loading; ?>"><i class="icon-send"></i> <?= Yii::t('app/default', 'SEND') ?></button>
        </div>
    </div>
</div>