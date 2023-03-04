function decrementingTimer(offset) {
    const d = new Date();
    const utc = d.getTime() + d.getTimezoneOffset() * 60000;
    const nd = new Date(utc + 3600000 * offset);
    // return nd.toLocaleString();
    // return nd.toLocaleTimeString();
    return {
        hours: 24 - nd.getHours(),
        minutes: 60 - nd.getMinutes(),
        seconds: 60 - nd.getSeconds(),
    };
}


const showTime = document.getElementById("show-time");
const interval = setInterval(() => {
    let { hours, minutes, seconds } = decrementingTimer(1)
    hours = hours > 9 ? hours : String(hours).padStart(2, 0);
    minutes = minutes > 9 ? minutes : String(minutes).padStart(2, 0);
    seconds = seconds > 9 ? seconds : String(seconds).padStart(2, 0);
    showTime.innerText = `${hours}h : ${minutes}m : ${seconds}s`;
}, 1000);

if (!showTime) {
    clearInterval(interval);
}