<!DOCTYPE html>
<html lang="en">
  <!--northfast webstacks-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="onepass.css">
    <link rel="stylesheet" href="notfiy.css">
    <title>onepass</title>
</head>
<body>
  <!--uses northfast webstacks-->
  <!--notification sound--->
  <audio id="notification-sound" src="res/dg.mp3" preload="auto"></audio>


<div class="wsBody" id="wsBody">


  <div class="wsBodyHeader" id='wsBodyHeader'>
    
  </div>       
  <div class="wsContent" id="wsContent">
  <div id="notifications-container"></div>
  </div>  
  <!--display all data-->
<div class="wsStack" id="wsStack">
    <div class="stackHeader">
        <button  id='backArrow' class='backArrow' type='button'><img src = "../stack/res/backArrow.png" alt="back"/></button>
    </div>
<div id="wsBodyStackInnerContent"> 
</div>

                 
</div>
<!---login caller-->
<script src="resize.js" type="module"></script>
<script src="./webstacks.js" type="module"></script>
<!-- <script src="./../calls/login.js" type="module"></script> -->
<!---->
<!--script 

look for a way to make it better and secure 
9-->
<script>
  function pwdCheckApi() {
    const remover = document.getElementById("stackNotification");

const wsBodyStackInnerContent = document.getElementById("wsBodyStackInnerContent");

if (wsBodyStackInnerContent.contains(remover)) {
  // If remover exists and is a child of wsStack
  wsBodyStackInnerContent.removeChild(remover);
}
//notification label 
     const notificationLabel = document.createElement('p')
     notificationLabel.classList = 'notificationLabel';
     notificationLabel.id = 'stackNotification';
   
  const mytitle = document.getElementById("mytitle");
  wsBodyStackInnerContent.appendChild(notificationLabel);
const pwdCheckApiUrl = 'https://local.muslih.tech/api/v1.0/modules/signin/v1.0.0/confirmpassword/index.php';
const accountnumber = document.getElementById('email');
const pwdField = document.getElementById('password');
    const data = {
      //js form validation 
        email: String(accountnumber.value),
        password: String(pwdField.value),
        timestamp: String(pwdField.dataset.timestamp)
      };
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    };
  //in the future to become general fetch for the whole system
        fetch(pwdCheckApiUrl, requestOptions)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          //response code is important for js ui side
          if(data.response.responseCode == 1){
            notificationLabel.style.color = 'green';
             notificationLabel.innerHTML = data.response.payload.message;
            //stack element
  
   wsBodyStackInnerContent.innerHTML = data.response.payload.content;
   //render only 
   //contact api 
          }else{
            notificationLabel.style.color = 'red';
             notificationLabel.innerHTML = data.response.payload.message;
          }
         
        })
        .catch(error => {
  
          notificationLabel.style.color = 'red';
          notificationLabel.innerHTML = error;
      
      ('Error:', error);
        });
}
</script>
</body>
</html>