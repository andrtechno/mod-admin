var chatBox = $("#chat-box");
function reloadchat(message, clearChat) {
    var selector = $(".btn-send-comment");
    var url = selector.data("url");
    var model = selector.data("model");
    var userfield = selector.data("userfield");
    $.ajax({
        url: url,
        type: "POST",
        data: {message: message, model: model, userfield: userfield},
        success: function (html) {
            if (clearChat === true) {
                $("#chat_message").val("");
                $('.emoji-wysiwyg-editor .emoji-inner').remove(); //emojipicker
                $('.emoji-wysiwyg-editor').html(''); //emojipicker
            }
            console.log('reloadchat');
            chatBox.html(html);
            chatBox.animate({
                scrollTop: chatBox.prop("scrollHeight")
            }, 0);
        }
    });
}

chatBox.animate({
    scrollTop: chatBox.prop("scrollHeight")
}, 0);

setInterval(function () {
    // reloadchat('', false);
}, 5000);

$(".btn-send-comment").on("click", function () {
    var message = $("#chat_message").val();
    reloadchat(message, true);
});
