var xhr_notify;
$(function () {

    setInterval(function () {
        if(xhr_notify === undefined)
            reloadCounters();
    }, 10000); //10000

    function reloadCounters() {
        var notifaction_list = [];
        console.log(notifaction_list.length);

        if(xhr_notify !== undefined)
            xhr_notify.abort();
        //   if (notifaction_list.length === 0) {
        xhr_notify = $.getJSON('/admin/app/default/ajax-counters', function (data) { //'/admin/default/ajax-counters?' + Math.random()
            $.each(data.count, function (i, c) {

                if (c > 0) {
                    $('.counter-cart').html(c).show();
                } else {
                    $('.circle-orders .label').hide();
                }
            });
            //console.log(Object.keys(data.notify));
            $.each(data.notify, function (id, notification) {

                notifaction_list[id] = $.notify({message: notification.text}, {
                    type: notification.type,
                    showProgressbar: true,
                    allow_duplicates: false,
                    timer: 1000,
                    //allow_dismiss: false,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    placement: {
                        from: "bottom",
                        align: "left"
                    },
                    onShow: function () {
                        $.playSound('http://' + window.location.hostname + '/uploads/notification.mp3');
                    },
                    onClose: function (s) {
                        console.log(s);
                            $.getJSON('/admin/app/default/ajax-read-notification', {id: id}, function (data) {

                        });
                        $.stopSound();
                        // delete notifaction_list[notifaction.id];
                        //notifaction_list.splice(notifaction, []);
                    }
                });

            });
        });
        //}
    }

});