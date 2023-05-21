var chrt = document.getElementById("chartId").getContext("2d");
var chartId = new Chart(chrt, {
    type: 'line',
    data: {
        labels: getDates(),
        datasets: [{
            label: "Weekly Profit (FCFA)",
            data: randomAmounts(),
            backgroundColor: ['#233344', '#233344', '#233344', '#233344', '#233344', '#233344'],
            borderColor: ['#233344'],
            borderWidth: 2,
            pointRadius: 5,
        }],
    },
    options: {
        responsive: false,
    },
});


function getDates() {
    const dates = [];
    const date = new Date();
    let day = date.getDate();
    let month = date.getMonth();
    const year = date.getFullYear();
    for (let i = 0; i < 7; i++) {
        const requiredDate = `${String(day).padStart(2, 0)}/${String(month).padStart(2, 0)}/${year}`;
        dates.push(requiredDate);
        ++day;
        ++month;
    }
    return dates;
}

function randomAmounts() {
    const amounts = [];
    for (let i = 0; i < 7; i++) {
        const amount = Math.round(Math.random() * 2000000);
        amounts.push(amount);
    }
    return amounts;
}