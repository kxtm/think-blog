function toSubmit() {
    $("#password").val(enc($("#password").val(), $(".login-title").attr('data-key'), $(".login-title").attr('data-v')));
}

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
