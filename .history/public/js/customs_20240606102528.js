document.addEventListener("DOMContentLoaded", function () {
    

});

$(document).ready(function () {
    const successToast = document.getElementById("successToast");
    if (!!successToast) {
        if (successToast.querySelector(".toast-body").textContent.trim() !== "") {
            var toast = new bootstrap.Toast(successToast);
            toast.show();
        }
    }
});