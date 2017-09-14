$(function () {

    setInterval(function () {
        reloadCounters();
    }, 10000); //10000

    function reloadCounters() {
        var notifaction_list = [];
        console.log(notifaction_list.length);
        //   if (notifaction_list.length === 0) {
        $.getJSON('/admin/default/ajax-counters?' + Math.random(), function (data) {
            $.each(data.count, function (i, c) {

                if (c > 0) {
                    $('.counter-cart').html(c).show();
                } else {
                    $('.circle-orders .label').hide();
                }
            });
            //console.log(Object.keys(data.notify));
            $.each(data.notify, function (id, notifaction) {

                notifaction_list[id] = $.notify({message: notifaction.text}, {
                    type: notifaction.type,
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
                        $.playSound('http://' + window.location.hostname + '/uploads/notifaction.mp3');
                    },
                    onClose: function (s) {
                        console.log(s);
                        $.getJSON('/admin/default/ajax-read-notifaction', {id: id}, function (data) {

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