document.addEventListener('DOMContentLoaded', function() {
    startApp();
});

function startApp() {
    searchByDate();
}

function searchByDate() {
    const date = document.querySelector('#date');
    date.addEventListener('input', function(e) {
        const date_pick = e.target.value;

        window.location = `?date=${date_pick}`;
    });
}

