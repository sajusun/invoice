// all month in array
const monthsInArray = ['January', "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

// page link var
const host = 'http://localhost:8000';
const appName = "invozen";

// all kind of app global methods here
methods = {
    // onclick this method route data view page dynamically
    go2singlePage: function (pageLink) {
        $("#t_body").on('click', '.clickable', function () {
            window.location.href = `${window.location.href}/${this.parentElement.id}/view`;
        });
    },
    // button effects object
    buttonEffect: {
        delete() {
            return new Button_effect('c_delete', 'Deleting', 'Deleted')
        },
        update() {
            return new Button_effect('c_update', 'Updating')
        },
        login() {
            return new Button_effect('login_btn', 'Logging')
        },
        signup() {
            return new Button_effect('resister_btn', 'Processing', 'Go To Next')
        },
    },

    getMonth: function (monthNumber) {
        return monthsInArray[monthNumber];
    },
    // return N length number from to range
    get_N_length_number: function (number, startPoint, range) {
        const numberStr = number.toString(); // Convert the number to a string
        if (range < 1 || range > numberStr.length) {
            return null; // Return null if length is out of bounds
        }
        return numberStr.slice(startPoint, range); // Get the first 'length' digits
    }
}

// return current year js
function getCurrentYear() {
    const d = new Date();
    return d.getFullYear();
}


//custom redirect function
function redirect(url) {
    window.location.href = url;
}


// app token object that set anf get api token
const token = {
    set: function (key) {
        sessionStorage.setItem(`${host}key`, key);
    },
    get: function () {
        return sessionStorage.getItem(`${host}key`);
    },
}





