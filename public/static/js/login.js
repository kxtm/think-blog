$("#logn-btn").click(function () {
    $("#password").val(enc($("#password").val(), $(".login-title").attr('data-key'), $(".login-title").attr('data-v')));
    $("#login-form").submit();
});
$("#verifyImg").click(function () {
    $(this).attr("src", $(this).attr("data-url") + "?" + Math.random());
});
