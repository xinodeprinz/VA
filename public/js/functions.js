window.onsubmit = () => {
    const submitBtn = document.querySelector('[type="submit"]');
    submitBtn.innerHTML = `
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
    submitBtn.setAttribute('disabled', true);
};

function copy() {
    const textMan = document.getElementById("copy");
    navigator.clipboard.writeText(textMan.innerText);
    return alert(`Link copied successfully`);
}