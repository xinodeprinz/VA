const progress = document.getElementById("ad-progress");
const claimRewardBtn = document.getElementById("claim-reward");

// document.addEventListener('contextmenu', event => event.preventDefault());

let percentage = 0;

const randomNumber = 10; //Math.floor(Math.random() * 10);

const res = setInterval(() => {
    percentage += randomNumber;

    if (percentage >= 100) {
        claimRewardBtn.removeAttribute("hidden");
        percentage = 100;
    }

    progress.setAttribute("style", `width:${percentage}%`);
    progress.setAttribute("aria-valuemin", percentage);
    progress.innerText = `${percentage}%`;
}, 1000);

if (!progress) {
    clearInterval(res);
}