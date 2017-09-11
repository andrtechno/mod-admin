$(function() {
    $.mask.definitions['~'] = "[+-]";
    $(".maskDate").mask("99/99/9999",{
        completed:function(){
            alert("Callback when completed");
        }
    });

$(".maskPhoneExt").mask("(999) 999-9999? x99999");
    $(".maskWidthHeight").mask("999x999");
    $(".maskSsn").mask("999-99-9999");
    $(".maskProd").mask("a*-999-a999", {
        placeholder: " "
    });
    $(".maskEye").mask("~9.99 ~9.99 999");
    $(".maskPo").mask("PO: aaa-999-***");
    $(".maskPct").mask("99%");
    $(".maskPerPage").mask("99,99,99");
    $(".maskAddress").mask("*,99,99");
    //Одесса, ул. Армейская 18A
    //phones
    $(".maskPhone1").mask("+3 (999) 999-99-99");
    $(".maskPhone2").mask("(999) 999 99 99");
    $(".maskPhone3").mask("+3 (999) 999 99 99");


});