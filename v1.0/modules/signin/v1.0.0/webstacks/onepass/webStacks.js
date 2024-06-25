//identify sections and identify resources 
//forms generator
//has some connections to wsStack
import apiHandler from "../calls/login.js";
import pwdCheckApi  from "../calls/login.js";
import {bottomsheet} from "./bottomsheet/index.js";
export var renderContent = ()=> {
   const wsContent = document.getElementById("wsContent");
   const wsContentMaincontainer = document.createElement("div");
   const wsContentInputsHolder = document.createElement("div");
   const wsBodyFooter = document.createElement("div");
   const wsBody = document.getElementById("wsBody");
   const wsStack = document.getElementById("wsStack");
   const wsBodyStackInnerContent = document.getElementById("wsBodyStackInnerContent");
//dynamically creates login form elements
   //form to input email and then call the api and post to pwd page 
   //the caller can be login page whatsapp or email text
   //create elements

   //other attributes
   const logoHolder = document.createElement("div");
   const lg1 = document.createElement("div");
   const lg2 = document.createElement("div");
   const lg3 = document.createElement("div");
   logoHolder.classList = "logoHolder";
   lg1.classList = "lg1";
   lg2.classList = "lg2";
   lg3.classList = "lg3";
   logoHolder.appendChild(lg1);
   logoHolder.appendChild(lg2);
   logoHolder.appendChild(lg3);
   //create two seperate forms 
   const output = document.createElement('p');
   const infoForm = document.createElement('form');
   const wsInputsForm = document.createElement('form');
   //bottom controls holder
   const wsContentControlsHolder = document.createElement('div');
   const email = document.createElement('input');
   const nextBtn = document.createElement('button');
   const createAccountBtn = document.createElement('button');
   const title = document.createElement('h1');
   const cmpLogoortitle = document.createElement('h1'); 
   const topbar = document.createElement('div');
   const topbarLogo =  document.createElement('div');
   const topBarText = document.createElement('p');
   //atrributes
   wsBodyFooter.classList = "wsBodyFooter";
   wsContentMaincontainer.classList = "wsContentMaincontainer";
   wsContentControlsHolder.classList = 'wsContentControlsHolder';
   infoForm.classList = 'infoForm';
   wsInputsForm.classList = 'wsInputsForm';
   email.placeholder = 'Email';
   email.autocomplete = "off";
   email.id = 'email';
   nextBtn.innerHTML = "Next";
   nextBtn.type = 'button';
   nextBtn.id = 'nextBtn';
   nextBtn.classList= "nextBtn";
   createAccountBtn.classList = "createAccount";
   createAccountBtn.id = "openModalButton";
   createAccountBtn.type = 'button';
   createAccountBtn.innerText = 'Create a new account';
   title.id ='mytitle';
   title.innerText = "onepass";
   cmpLogoortitle.id - 'cmptitle';
   cmpLogoortitle.innerText = 'signin';
   topbarLogo.appendChild(logoHolder);
   topbar.classList = 'topBar';
   topBarText.innerText = "onepass";
   wsBodyStackInnerContent.classList = 'wsBodyStackInnerContent';
   // createAccountBtn.addEventListener("click",stack);
     topbar.appendChild(topbarLogo);
     topbar.appendChild(topBarText);
      wsBody.appendChild(topbar);
      wsBody.appendChild(wsContent);
      wsContent.appendChild(wsContentMaincontainer);
      infoForm.appendChild(cmpLogoortitle)
      wsContentControlsHolder.appendChild(createAccountBtn);
      wsContentControlsHolder.appendChild(nextBtn);
      // infoForm.appendChild(title);
      wsInputsForm.appendChild(email);
      // wsContent.appendChild(notificationLabel);
      wsContentMaincontainer.appendChild(infoForm);
      wsContentMaincontainer.appendChild(wsInputsForm);
      wsContent.appendChild(wsContentControlsHolder);
   //after definitions and creations
   //intelligent point
   document.getElementById('nextBtn').addEventListener('click' , ()=>{
      var accountnumber = email.value;
      apiHandler(accountnumber);
   })
   document.getElementById("openModalButton").addEventListener('click',()=>{
      bottomsheet();
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
   // wsStack.style.width = window.innerWidth + 'px';
   // wsStack.style.height = window.innerHeight + 'px';
   wsBodyStackInnerContent.innerHTML = data.response.payload.content;
   //render only 
   //contact api 

}
function meana() {
   console.log('dsfdsf');
}