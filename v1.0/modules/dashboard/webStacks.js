import axios from 'axios';
console.log('newcalled');
function fetchUserInfo() {
  // Create an axios instance with credentials option
  const instance = axios.create({
    withCredentials: true // Ensures cookies are sent with the request
  });

  // Axios interceptor for handling responses
  instance.interceptors.response.use(
    response => {
      // If the response is successful, return the response data
      return response;
    },
    error => {
      // Handle error responses
      if (error.response && error.response.status === 401) {
        // If the status code is 401 (Unauthorized), redirect to login page
        window.location.href = 'http://172.31.105.163/auth/onepass/v1.0/modules/signin/v1.0.0/webstacks/onepass/';
      } else {
        // For other errors, you can log or handle them as needed
        console.error('Error:', error.response ? error.response.data : error.message);
      }
      // Optionally, return a rejected promise to propagate the error
      return Promise.reject(error);
    }
  );

  // Make the POST request without including the token in the body
  instance.post('http://172.31.105.163/auth/onepass/v1.0/modules/dashboard/api/internal/getaccountinfo/', {}, {
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => {
    console.log('Data:', response.data);
    console.log('API called');
  })
  .catch(error => {
    // Error handling is already managed by the interceptor
  });
}

// DOM Elements
const stackOpener = document.getElementById("stackOpener");
const registration = document.getElementById("registration");
const wsBody = document.getElementById("wsBody");

window.addEventListener("load", (event) => {
  console.log("msl");
  if (wsBody) {
    wsBody.style.width = window.innerWidth + 'px';
    wsBody.style.height = window.innerHeight + 'px';
  }
  
  // Call dashboard APIs
  fetchUserInfo();
});

// Uncomment if needed
// stackOpener.addEventListener("click", loginCaller);
// registration.addEventListener("click", registrationCaller");
