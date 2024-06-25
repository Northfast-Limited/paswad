//one loader ,one caller
//next button event tracker 
//check account first
//btn temporary data
import {bottomsheet}  from "../onepass/bottomsheet/index.js";
const message = document.getElementById("message");
const apiUrl = 'http://172.31.105.163/auth/onepass/v1.0/modules/signin/v1.0.0/';
//data for api

// api for account check 
//end of notification implimentation

 function apiHandler(accountnumber){

  const mytitle = document.getElementById("mytitle");
    
    var accountnumber = accountnumber;

    const data = {
        accountnumber: String(accountnumber)
      };
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    };
  //in the future to become general fetch for the whole system
        fetch(apiUrl, requestOptions)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {

            if(data.response.responseCode == 1){
              //the payload includes a link with generated token to retrieve password field
              //long bottomsheet instead of stack for quick developement
              bottomsheet(data);
              notificationLabel.style.color = 'green';
              notificationLabel.innerHTML = data['response'];
            }else if(data.response.responseCode == 0){
              showNotification(data.response.payload);
            }else {
              showNotification('unexpected error occurred, Please refresh the page');
            }
         
        })
        .catch(error => {
          showNotification(error);
      ('Error:', error);
        });

     };

//notification handler
    //in the future should ,properties such as color
     function showNotification(message) {
      //adds message , notification icon and close button
      const container = document.getElementById('notifications-container');
      const sound = document.getElementById('notification-sound');
      const notification = document.createElement('div');
      notification.classList.add('notification');
      
      const icon = document.createElement('span');
      icon.classList.add('notification-icon');
      icon.innerHTML = '🔔'; // Use any icon you prefer
      
      const text = document.createElement('span');
      text.classList.add('notification-text');
      text.innerText = message;
      text.style.color ='red';
      sound.currentTime = 0; // Reset the sound to the start
      sound.play();
      const closeButton = document.createElement('button');
      closeButton.classList.add('notification-close');
      closeButton.innerText = '✖';
     closeButton.style.color = 'red';
      closeButton.classList.add('notification-close');
      closeButton.innerHTML = '✖'; // Use HTML entity for close icon
      closeButton.addEventListener('click', () => {
          notification.classList.remove('show');
          setTimeout(() => {
              container.removeChild(notification);
              adjustNotificationPositions(); // Adjust positions after removing notification
          }, 300);
      });
      
      notification.appendChild(icon);
      notification.appendChild(text);
      notification.appendChild(closeButton);
      container.appendChild(notification);
      
      // Show notification
      setTimeout(() => {
          notification.classList.add('show');
          adjustNotificationPositions(); // Adjust positions after adding notification
      }, 10);
    }
    
function adjustNotificationPositions() {
  const notifications = document.querySelectorAll('.notification.show');
  
  // Start position from bottom for the first notification
  let bottomPosition = 5; // Initial bottom position

  notifications.forEach((notification, index) => {
      notification.style.top = `${bottomPosition}px`;
      bottomPosition += 7; // Adjust stack position with space
  });
}
//store temp data in api 
     export default apiHandler;