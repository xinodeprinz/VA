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

window.onload = () => {
    if (!sessionStorage.getItem('locale')) {
        const data = {
            en: {
                title: '<div style="font-size:22px">Select Language</div>'
            },
            fre: {
                title: '<div style="font-size:25px">Choisir La Langue</div>'
            },
            colors: {
                main: '#356735',
            },
        }
        Swal.fire({
            title: `<div style="color:${data.colors.main}">${data.fre.title}${data.en.title}</div>`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Français<br/>French',
            denyButtonText: `Anglais<br/>English`,
            confirmButtonColor: data.colors.main,
            denyButtonColor: 'black',
            allowOutsideClick: false,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.pathname = '/language/fre';
            } else if (result.isDenied) {
                window.location.pathname = '/language/en';
            }
            sessionStorage.setItem('locale', true);
        });
    }
}