var mainPage = $('.main-page');

mainPage.on('keypress', '.search', function(e)) {
    // var keycode = e.keyCode || e.which;
    if(e.keyCode == 13) {

    }
}


$(document).keypress(function(event) {
    var keycode = event.keyCode || event.which;
    if (keycode == 13) { // Enter key's keycode
        alert('Enter key pressed');
    } else if (keycode == 27) { // Escape key's keycode
        alert('Escape key pressed');
    }
});
mainPage.on('click', '.search-btn', function() {
    var searchQuery = $(this).prev('input').val();
    alert(searchQuery);
});