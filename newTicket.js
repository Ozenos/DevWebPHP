console.log("newTicket.js initiated");

function check_title() {
    // Verify title selection
    const title = document.querySelector('#title');
    // .value get input value
    console.log("title : ", title.value);
    
    const title_error = document.querySelector('#title_error');

    if (title.value == "") {
        title_error.classList.remove('invisible');
        return 1;
    } else {
        title_error.classList.add('invisible');
        return 0;
    }
}

function check_time() {
    // Verify time selection
    const time = document.querySelector('#time');
    // .value get input value
    console.log("time H : ", time.value);
    const Hval = Number.isInteger(Number(time.value)) && Number(time.value) > 0;

    const time_error = document.querySelector('#time_error');
    if (time.value == "") {
        time_error.classList.remove('invisible');
        time_error.textContent = 'Veuillez entrer une estimation de temps en heures';
        return 1;
    }
    if (Hval == false) {
        time_error.classList.remove('invisible');
        time_error.textContent = 'Veuillez entrer une valeur entière';
        return 2;
    } else {
        time_error.classList.add('invisible');
        return 0;
    }
}

const titleInput = document.getElementById("title");
const timeInput = document.getElementById("time");

titleInput.addEventListener('blur', check_title);
timeInput.addEventListener('blur', check_time);

// form selection #submitform
const fdata = document.querySelector('#submitform');

fdata.addEventListener("submit", function (event) {
    event.preventDefault();

    let nb_errors = check_title() + check_time();
    console.log("nb_errors : ", nb_errors);

    if (nb_errors == 0) {
        console.log(titleInput.value, timeInput.value);

        titleInput.value = "";
        timeInput.value = "";

        const toast = document.getElementById("success");
        console.log(toast);
        toast.classList.remove('invisible');
        // Wait 3 seconds then remove
        setTimeout(() => {
            toast.classList.add('invisible');
        }, 5000);
    }
});