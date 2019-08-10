// Hide submenus
$('#admin-body-row .collapse').collapse('hide');

// Collapse/Expand icon
$('#collapse-icon').addClass('fa-angle-double-left');

// Collapse click
$('[data-toggle=sidebar-colapse]').click(function() {
    SidebarCollapse();
});

window.SidebarCollapse = function SidebarCollapse () {
    $('.menu-collapsed').toggleClass('d-none');
    $('.admin-sidebar-submenu').toggleClass('d-none');
    $('.submenu-icon').toggleClass('d-none');
    $('#admin-sidebar-container').toggleClass('admin-sidebar-expanded admin-sidebar-collapsed');

    // Treating d-flex/d-none on separators with title
    var SeparatorTitle = $('.admin-sidebar-separator-title');
    if ( SeparatorTitle.hasClass('d-flex') ) {
        SeparatorTitle.removeClass('d-flex');
    } else {
        SeparatorTitle.addClass('d-flex');
    }

    // Collapse/Expand icon
    $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
};