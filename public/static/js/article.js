$(function () {
    const editor = new window.wangEditor("#div1")
    editor.config.height = window.innerHeight - 300
    editor.create();
})