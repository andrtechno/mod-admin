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
            $("#chat-box").html(html);
            $("#chat-box").animate({
                scrollTop: $('#chat-box').prop("scrollHeight")
            }, 0);
        }
    });
}
$("#chat-box").animate({
    scrollTop: $('#chat-box').prop("scrollHeight")
}, 0);
setInterval(function () {
   // reloadchat('', false);
}, 5000);
$(".btn-send-comment").on("click", function () {
    var message = $("#chat_message").val();
    reloadchat(message, true);
});
