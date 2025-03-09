function toSubmit() {
    $("#password").val(enc($("#password").val(), $(".login-title").attr('data-key'), $(".login-title").attr('data-v')));
}
alert(location.href)