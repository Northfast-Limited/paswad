//identify sections and identify resources 
//forms generator
//has some connections to wsStack
import apiHandler from "../calls/login.js";
import pwdCheckApi  from "../calls/login.js";
export var renderContent = ()=> {
   const wsContent = document.getElementById("wsContent");
   const wsBody = document.getElementById("wsBody");
   const wsStack = document.getElementById("wsStack");
   const wsBodyStackInnerContent = document.getElementById("wsBodyStackInnerContent");
//dynamically creates login form elements
   //form to input email and then call the api and post to pwd page 
   //the caller can be login page whatsapp or email text
   //create elements

   //other attributes

   //create two seperate forms 
   const output = document.createElement('p');
   const infoForm = document.createElement('form');
   const inputsAndControlsForm = document.createElement('form');
   //bottom controls holder
   const constrolsHolder = document.createElement('div');
   const email = document.createElement('input');
   const nextBtn = document.createElement('button');
   const createAccountBtn = document.createElement('button');
   const title = document.createElement('h1');
   //atrributes
   constrolsHolder.classList = 'constrolsHolder';
   infoForm.classList = 'infoForm';
   inputsAndControlsForm.classList = 'inputsAndControlsForm';
   email.placeholder = 'Email';
   email.id = 'email';
   nextBtn.innerHTML = "Next";
   nextBtn.type = 'button';
   nextBtn.id = 'nextBtn';
   nextBtn.classList= "nextBtn";
   createAccountBtn.classList = "createAccount";
   createAccountBtn.type = 'button';
   createAccountBtn.innerText = 'Create a new account';
   title.id ='mytitle';
   title.innerText = "login";
   wsBodyStackInnerContent.classList = 'wsBodyStackInnerContent';
   // createAccountBtn.addEventListener("click",stack);
   
     
      constrolsHolder.appendChild(createAccountBtn);
      constrolsHolder.appendChild(nextBtn);
      infoForm.appendChild(title);
      inputsAndControlsForm.appendChild(email);
      inputsAndControlsForm.appendChild(constrolsHolder);
      // wsContent.appendChild(notificationLabel);
      wsContent.appendChild(infoForm);
      wsContent.appendChild(inputsAndControlsForm);
   
   //after definitions and creations
   //intelligent point
   document.getElementById('nextBtn').addEventListener('click' , ()=>{
      var accountnumber = email.value;
      apiHandler(accountnumber);
   })
}

//callback from api / closing stack/opening another stack / one function to manage stacks 
//property - open - close - minimize 
//content api feedback /dynamic html / js code/ video
//calling function must request callback or have a callback for the stack to understand the process

//stack manager 
export var  stack = (data,callback) =>{
   // a new stack every time
   wsStack.style.display = 'flex';
   wsStack.style.width = window.innerWidth + 'px';
   wsStack.style.height = window.innerHeight + 'px';
   wsBodyStackInnerContent.innerHTML = data.response.payload.content;
   //render only 
   //contact api 

}
function meana() {
   console.log('dsfdsf');
}