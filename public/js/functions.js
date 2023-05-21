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

// window.onload = () => {
//     if (!sessionStorage.getItem('locale')) {
//         const data = {
//             en: {
//                 title: '<div style="font-size:22px">Select Language</div>'
//             },
//             fre: {
//                 title: '<div style="font-size:25px">Choisir La Langue</div>'
//             },
//             colors: {
//                 main: '#356735',
//             },
//         }
//         Swal.fire({
//             title: `<div style="color:${data.colors.main}">${data.fre.title}${data.en.title}</div>`,
//             showDenyButton: true,
//             showCancelButton: false,
//             confirmButtonText: 'Français<br/>French',
//             denyButtonText: `Anglais<br/>English`,
//             confirmButtonColor: data.colors.main,
//             denyButtonColor: 'black',
//             allowOutsideClick: false,
//         }).then((result) => {
//             /* Read more about isConfirmed, isDenied below */
//             if (result.isConfirmed) {
//                 window.location.pathname = '/language/fre';
//             } else if (result.isDenied) {
//                 window.location.pathname = '/language/en';
//             }
//             sessionStorage.setItem('locale', true);
//         });
//     }
// }

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

async function emailUsers(btn) {
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;
    const type = document.getElementById('type').value;
    const data = { subject, message, type };
    loadSpinner(btn);
    try {
        const res = await axios.post('/admin/users/email', data);
        const { success, failed } = res.data;
        const title = `Success: ${success}, Failed: ${failed}`;
        sweetAlert({ icon: 'success', title });
        return setTimeout(() => {
            window.location.reload();
        }, 6000);

    } catch (err) {
        btn.innerText = 'Email Now';
        btn.removeAttribute('disabled');
        const title = err.response.data.message;
        sweetAlert({ icon: 'error', title })
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

    // An error occured
    if (response.status != 200) {
        getAndSetDetails(null);
        return sweetAlert({ icon: 'info', title: result.message });
    }

    getAndSetDetails(result);
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