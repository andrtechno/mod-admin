$(function(){
    setInterval(function(){
        reloadCounters();
    }, 10000);

    function reloadCounters() {
        $.getJSON('/admin/app/ajax/counters?' + Math.random(), function(data){
            if(data.orders > 0){                        
                $('.circle-orders .label').html(data.orders).show();
            }else{
                $('.circle-orders .label').hide();
            }
        });
    }
});