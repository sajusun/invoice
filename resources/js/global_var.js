
const global= {
     host : document.querySelector('meta[name="base-url"]')?.content || '',
     appName : "invozen",
// all month in array
     month_Names : ['January', "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
}
window.host = global.host;
export default global;



