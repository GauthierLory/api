
$(document).ready(function () {
    $lang = ($("#language_sess").val());
    switch($lang){
        case 'en':
            $("#nav_lang").attr("src", $("#flag_en").attr("src"));
            break;
        case 'fr':
            $("#nav_lang").attr("src", $("#flag_fr").attr("src"));
            break;
    }
});
