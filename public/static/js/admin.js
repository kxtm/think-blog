$("#logn-btn").click(function () {
    $("#password").val(enc($("#password").val(), $(".login-title").attr('data-key'), $(".login-title").attr('data-v')));
    $("#login-form").submit();
});
$("#verifyImg").click(function () {
    $(this).attr("src", $(this).attr("data-url") + "?" + Math.random());
});
$(".nav-item").click(function () {
    $(this).toggleClass('open')
});
const path = window.location.pathname;
$(".sider .nav-item").each(function () {
    //直接设置焦点
    $(this).removeClass("active")
    if ($(this).children(".nav-link").attr("href") == path) {
        $(this).addClass("active");
        if ($(this).parent().children(".sub-item").length > 0) {
            $(this).parent().parent().addClass("open");
        }
    }
});
