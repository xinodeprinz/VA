window.onsubmit = () => {
    const allSubmitBtns = document.querySelectorAll('[type="submit"]');
    allSubmitBtns.forEach((btn) => btn.setAttribute("disabled", true));
};

function momo(type) {
    window.location.pathname = `/mobile-money/${type}`;
}

function paypal(type) {
    window.location.pathname = `/paypal/${type}`;
}

// To hide alerts after 5 seconds.
$(document).ready(function() {
    setTimeout(function() {
        $(".alert-yoo").hide("fade");
    }, 10000);
});

function copy() {
    const textMan = document.getElementById("copy");
    navigator.clipboard.writeText(textMan.innerText);
    return alert(`Link copied successfully`);
}

function changeCurrency() {
    const currencyForm = document.getElementById('currency-form');
    currencyForm.submit();
}