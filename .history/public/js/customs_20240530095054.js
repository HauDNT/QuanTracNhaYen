const overlay = document.querySelector(".overlay");


if (!!overlay) {
    overlay.addEventListener("click", () => {
        navBar.classList.remove("open");
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const successToast = document.getElementById("successToast");
    if (!!successToast) {
        if (successToast.querySelector(".toast-body").textContent.trim() !== "") {
            var toast = new bootstrap.Toast(successToast);
            toast.show();
        }
    }

});
