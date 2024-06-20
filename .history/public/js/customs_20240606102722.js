$(document).ready(function () {
    const successToast = document.getElementById("successToast");
    if (!!successToast) {
        if (successToast.querySelector(".toast-body").textContent.trim() !== "") {
            var toast = new bootstrap.Toast(successToast);
            toast.show();
        }
    }

    var mainPage = $('.main-page');

    mainPage.on('click', '.search-btn', function() {
        var searchQuery = $(this).prev('input').val();
        alert(searchQuery);
    });
});