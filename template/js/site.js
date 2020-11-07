$(document).ready(function() {
    $('.js-select').select2({
        placeholder: "Выберите актёров",
        tags: true
    });
    $('.js-select-format').select2({
        placeholder: "Выберите формат",
    });

    $('.js_import_btn').on( "click", function() {
        $(this).attr("style", "display: none");
        $('.import_form').attr("style", "display: block");
    });
});