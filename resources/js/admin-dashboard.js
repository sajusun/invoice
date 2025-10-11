import './bootstrap.js';

// window.Echo.channel('new-signup')
//     .listen('UserRegistered', (e) => {
//         console.log("📢 new user registered", e.id);
//     });
// console.log(window.Echo);

const adminId = document.querySelector('meta[name="user-id"]').content;
const notif_count = document.getElementById('notif_count');
const notif_list = document.getElementById('notif_list');
console.log(notif_count.textContent);
// window.Echo.private(`App.Models.Admin.${adminId}`)
//     .listen('UserRegistered', (e) => {
//         console.log("hello", );
//     });
// window.Echo.private(`admin.notifications`)
//     .listen('UserRegistered', (e) => {
//         console.log("hello", e.name);
//         notif_count.textContent = parseInt(notif_count.textContent) + 1;
//
//         notif_list.elements=`<li class='p-2 hover:bg-gray-50 rounded'>👤 New client registered ${e.name}</li>`;
//     });
import './admin-notifcations.js'
