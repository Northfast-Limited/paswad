// import loginCaller from "./pages/login.js";
// import registrationCaller from "./pages/registration.js";
import axios from 'axios';
function fetchuserinfo(){
// Create an axios instance with credentials option
const instance = axios.create({
  withCredentials: true
});

// Make the POST request
instance.post('http://172.31.105.163/auth/onepass/v1.0/modules/dashboard/api/internal/getaccountinfo/', {
  token: 'value1',
})
.then(response => {
  console.log('Data:', response.data);
  console.log("api called");
})
.catch(error => {
  console.error('Error:', error);
});

}
const stackOpener = document.getElementById("stackOpener");
const   registration = document.getElementById("registration");

window.addEventListener("load", (event) => {
        wsBody.style.width = window.innerWidth + 'px';
        wsBody.style.height = window.innerHeight + 'px';
     //call dashboard apis
fetchuserinfo();
  });

//   stackOpener.addEventListener("click", loginCaller);
//   registration.addEventListener("click", registrationCaller);

