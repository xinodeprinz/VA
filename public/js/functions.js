window.onsubmit = () => {
    const submitBtn = document.querySelector('[type="submit"]');
    loadSpinner(submitBtn);
};

function copy() {
    const textMan = document.getElementById("copy");
    navigator.clipboard.writeText(textMan.innerText);
    return alert(`Link copied successfully`);
}

function disableWithBtn() {
    const btn = document.getElementById('withBtn');
    loadSpinner(btn);
}

function loadSpinner(btn) {
    btn.setAttribute('disabled', true);
    btn.innerHTML = `
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
}

function togglePasword(toggler) {
    const passInput = document.getElementById('password');
    const icon = toggler.children[0];
    if (passInput.type === 'password') {
        passInput.type = 'text';
        icon.setAttribute('data-icon', 'eye-slash');
    } else {
        passInput.type = 'password';
        icon.setAttribute('data-icon', 'eye');
    }
}

function sweetAlert({ icon, title }) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    return Toast.fire({ icon, title })
}

function countryCode(countryEl) {
    const cCodeEl = document.getElementById('c-code');
    if (countryEl.value === 'Uganda')
        cCodeEl.innerText = '+256'
    else if (countryEl.value === 'Nigeria')
        cCodeEl.innerText = '+234'
    else if (countryEl.value === 'Ghana')
        cCodeEl.innerText = '+233'
    else if (countryEl.value === 'Cameroon')
        cCodeEl.innerText = '+237'
    else if (countryEl.value === 'Central African Republic')
        cCodeEl.innerText = '+236'
    else if (countryEl.value === 'Equatorial Guinea')
        cCodeEl.innerText = '+240'
    else if (countryEl.value === 'Chad')
        cCodeEl.innerText = '+245'
    else if (countryEl.value === 'Congo Republic')
        cCodeEl.innerText = '+242'
    else
        cCodeEl.innerText = '+243'
}

async function details(amountEl, token) {
    const response = await fetch('/investment/details', {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token,
        },
        method: "POST",
        body: JSON.stringify({ amount: amountEl.value }),
    });

    const result = await response.json();

    if (response.status != 200) {
        // An error occured
        getAndSetDetails(null);
        return console.log("An error occured!");
    } else {
        return getAndSetDetails(result);
    }
}

function getAndSetDetails(details) {
    // Getting elements
    const amountField = document.getElementById('amount');
    const videoField = document.getElementById('video-cost');
    const durationField = document.getElementById('duration');
    const totalField = document.getElementById('total-earn');
    const minWithField = document.getElementById('min-with');
    // Setting values
    amountField.innerText = details ? details.amount + ' FCFA' : '-';
    videoField.innerText = details ? details.video_cost + ' FCFA' : '-';
    durationField.innerText = details ? details.duration + ' days' : '-';
    totalField.innerText = details ? details.total_earn + ' FCFA' : '-';
    minWithField.innerText = details ? details.min_withdrawal + ' FCFA' : '-';
}