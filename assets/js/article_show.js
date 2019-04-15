$(document).ready(function () {
    $('.fulltext').hide();
    $('.readmore').click(function (event) {
        event.preventDefault();
        $(this).parent().find('.fulltext').slideToggle('slow');
        $(this).text($(this).text() === 'Read less...' ? 'Read more...' : 'Read less...');
    });
});