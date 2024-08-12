import axios from 'axios';

function fetchUserInfo() {
  // Create an axios instance with credentials option
  const instance = axios.create({
    withCredentials: true
  });

  // Make the POST request
  instance.post('http://172.31.105.163/auth/onepass/v1.0/modules/dashboard/api/internal/getaccountinfo/', {
    token: 'eyJ0eXAiOiJpbnRlcm5hbC1hdXRoJ1wvZGFzaGJvYXJkIiwiYWxnIjoiSFMyNTYiLCJwYXRoIjoib25seURhc2hib2FyZCIsInN0YXR1cyI6ImFjdGl2ZSIsInVzZXJJZCI6Im11c2xpaGFiZGlrZXJAZ21haWwuY29tIiwiZXhwIjoxNzIzNDgxNDkzLCJ0aW1lc3RhbXAiOjE3MjM0Nzc4OTN9.eyJjbGllbnQtaWQiOiIwMDAwIiwiY2xpZW50LW5hbWUiOiJzeXN0ZW0iLCJ0b2tlbi1yb2xlIjoiYWRtaW4ifQ.DpXmQqULOEEzZPQU_tlDsiRMAioqBLvxJR17OOhXTqY'
  }, {
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => {
    console.log('Data:', response.data);
    console.log('API called successfully');
  })
  .catch(error => {
    console.error('Error:', error.response ? error.response.data : error.message);
  });
}

const stackOpener = document.getElementById("stackOpener");
const registration = document.getElementById("registration");
const wsBody = document.getElementById("wsBody"); // Ensure this element exists

window.addEventListener("load", (event) => {
  console.log("Webpage loaded");
  wsBody.style.width = window.innerWidth + 'px';
  wsBody.style.height = window.innerHeight + 'px';
  // Call dashboard APIs
  fetchUserInfo();
});

// Uncomment if needed
// stackOpener.addEventListener("click", loginCaller);
// registration.addEventListener("click", registrationCaller");
