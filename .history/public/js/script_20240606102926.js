var mainPage = $('.main-page');

mainPage.on('')

mainPage.on('click', '.search-btn', function() {
    var searchQuery = $(this).prev('input').val();
    alert(searchQuery);
});