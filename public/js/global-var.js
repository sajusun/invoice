// all month in array
const monthsInArray = ['January', "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

// page link var
const host = 'http://localhost:8000';
const appName = "expenses-app";
const home_Page = `${host + appName}/user`;
const login_Page = `${host + appName}/login`;
const signup_Page = `${host + appName}/register`;
const in_add_Page = `${host + appName}/in/add`;
const in_list_Page = `${host + appName}/in/list`;
const in_view_Page = `${host + appName}/in/view`;

// app url Links
// let urlLink = {
//     home_Page: `${host + appName}/user`,
//     login_Page: `${host + appName}/login`,
//     signup_Page: `${host + appName}/register`,
//     reset_Page: `${host + appName}/reset`,
//     in_add_Page: `${host + appName}/in/add`,
//     in_list_Page: `${host + appName}/in/list`,
//     in_view_Page: `${host + appName}/in/view`,
// }


//app api links
let apiLink = {
    isValid: `${host}api/user/isValid`,
    login: `${host}api/user/login`,
    register: `${host}api/user/register`,
    reset: `${host}api/user/reset`,
    in_add: `${host}api/expenses_app/in/add`,
    out_add: `${host}api/expenses_app/out/add`,
    incomeList_url: `${host}api/expenses_app/in/list/`,
    expensesList_url: `${host}api/expenses_app/out/list/`
}
// all kind of app global methods here
methods = {
    // onclick this method route data view page dynamically
    go2singlePage: function (pageLink) {
        $("#t_body").on('click', '.clickable', function () {
            window.location.href = `${window.location.href}/${this.parentElement.id}/view`;
            console.log(this.parentElement.id)
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

// redirect home page
function to_home() {
    window.location.href = home_Page;
}

//custom redirect function
function redirect(url) {
    window.location.href = url;
}

// redirect to profile page
function to_profile() {
    window.location.href = `${home_Page}/profile`;
}

// redirect to setting page
function to_settings() {
    window.location.href = home_Page + "/settings";
}

// redirect to contact page
function to_contact() {
    window.location.href = home_Page + "/contact";
}

// call to user logout process
function logout() {
    new User().logout();
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





