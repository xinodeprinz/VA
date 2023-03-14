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
    try {
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value;
        const token = document.querySelector('meta[name="csrf-token"]').content;
        loadSpinner(btn);
        // Sending ajax request
        const res = await fetch('/admin/users/email', {
            method: 'POST',
            body: JSON.stringify({ subject, message }),
            headers: {
                "X-CSRF-Token": token,
                'Content-Type': 'Application/json',
                'Accept': 'Application/json',
            },
        });
        const { success, failed } = await res.json();
        alert(`Emailing done!! Sucess: ${success}, Failed: ${failed}`);
        return window.location.reload();
    } catch (error) {
        alert('An error occured');
        console.log(error);
    }
}