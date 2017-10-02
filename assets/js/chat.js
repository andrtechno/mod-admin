function reloadchat(message, clearChat) {
    var url = $(".btn-send-comment").data("url");
    var model = $(".btn-send-comment").data("model");
    var userfield = $(".btn-send-comment").data("userfield");
    $.ajax({
        url: url,
        type: "POST",
        data: {message: message, model: model, userfield: userfield},
        success: function (html) {
            if (clearChat == true) {
                $("#chat_message").val("");
                $('.emoji-wysiwyg-editor .emoji-inner').remove(); //emojipicker
                $('.emoji-wysiwyg-editor').html(''); //emojipicker
            }
            $("#chat-box").html(html);
            

        }
    });
}
setInterval(function () {
   // reloadchat('', false);
}, 5000);
$(".btn-send-comment").on("click", function () {
    var message = $("#chat_message").val();
    reloadchat(message, true);
});
