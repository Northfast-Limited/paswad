//identify sections and identify resources 
//forms generator
//has some connections to wsStack
import apiHandler from "../calls/login.js";
import pwdCheckApi  from "../calls/login.js";
import { bottomsheetCreateAccount } from "./bottomsheetCreateAccount/index.js";
import { wsStackFunction } from "./wsStack/index.js";

export var renderContent = ()=> {
   //ws elements
   const wsContent = document.getElementById("wsContent");
   const wsContentMaincontainer = document.createElement("div");
   const wsContentInputsHolder = document.createElement("div");
   const wsBodyFooter = document.createElement("div");
   const wsBody = document.getElementById("wsBody");
   const wsFooterControls = document.createElement('div');
   const wsLeftControls = document.createElement('div');
   const wsRightontrols = document.createElement('div');
   const wsQrHolder = document.createElement('div');
   const wsQrHolderIcon = document.createElement('img');
   const wsTopControlsHolder = document.createElement('div');
   const wsNotificationIconHolder = document.createElement('div');
   const wsNotificationIcon = document.createElement('img');

   // wsStackmaker
//    const WsNota = document.createElement('div');
//    //notification element properties
// WsNota.classList = "WsNota";
   //ws body qr holder 
   wsTopControlsHolder.classList = "wsTopControlsHolder";
   wsTopControlsHolder.id = "wsTopControlsHolder";
wsQrHolder.classList = "wsQrHolder";
wsQrHolder.id = "wsQrHolder";
wsQrHolderIcon.src = "res/qr.png";
wsQrHolderIcon.classList = "wsQrHolderIcon";


wsNotificationIcon.src= "res/notification.png";
wsNotificationIcon.classList = "wsNotificationIcon";
wsNotificationIconHolder.classList = "wsNotificationIconHolder";
wsNotificationIconHolder.id = "wsNotificationIconHolder";
//appender
wsQrHolder.appendChild(wsQrHolderIcon);
wsNotificationIconHolder.appendChild(wsNotificationIcon);
wsTopControlsHolder.appendChild(wsNotificationIconHolder);

   //ws footer controls
   wsLeftControls.classList = "wsLeftControls";
   wsRightontrols.classList = "wsRightontrols";
   wsFooterControls.classList = "wsFooterControls";

   //ws footer controls

   const language = document.createElement('a');
   const help = document.createElement('a');
   const privacy = document.createElement('a');
   const terms = document.createElement('a');
   //ws footer controls properties
   language.innerText = "Language";
   help.innerText = "Help";
   privacy.innerText = "Privacy";
   terms.innerText = "Terms";
   language.href = "#language";
   help.href = "#help";
   privacy.href = "#privacy";
   terms.href = "#terms";
   language.classList = "wsFooterControl-Language";
   help.classList = "wsFooterControl-help";
   privacy.classList = "wsFooterControl-privacy";
   terms.classList = "wsFooterControl-terms";
   // ws elements

   //ws footer elements
   wsLeftControls.appendChild(language);
   wsRightontrols.appendChild(help);
   wsRightontrols.appendChild(privacy);
   wsRightontrols.appendChild(terms);
   wsFooterControls.appendChild(wsLeftControls);
   wsFooterControls.appendChild(wsRightontrols);
 wsBodyFooter.appendChild(wsFooterControls);
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
   email.classList = "wsCustomInput-email";
   nextBtn.innerHTML = "Next";
   nextBtn.type = 'button';
   nextBtn.id = 'nextBtn';
   nextBtn.classList= "nextBtn";
   createAccountBtn.classList = "createAccount";
   createAccountBtn.id = "createAccount";
   createAccountBtn.type = 'button';
   createAccountBtn.innerText = 'Create a new account';
   title.id ='mytitle';
   title.innerText = "onepass";
   cmpLogoortitle.id - 'cmptitle';
   cmpLogoortitle.innerText = 'signin';
   topbarLogo.appendChild(logoHolder);
   topbar.classList = 'topBar';
   topBarText.innerText = "onepass";
   // createAccountBtn.addEventListener("click",stack);
     topbar.appendChild(topbarLogo);
     topbar.appendChild(topBarText);
      wsBody.appendChild(topbar);
      wsBody.appendChild(wsContent);
      wsBody.appendChild(wsBodyFooter);
      // wsContent.appendChild(WsNota);
      wsContent.appendChild(wsTopControlsHolder);
      wsContent.appendChild(wsContentMaincontainer);
      infoForm.appendChild(cmpLogoortitle)
      wsContentControlsHolder.appendChild(createAccountBtn);
      wsContentControlsHolder.appendChild(nextBtn);
      // infoForm.appendChild(title);
      wsInputsForm.appendChild(email);
      wsInputsForm.appendChild(wsQrHolder);
      // wsContent.appendChild(notificationLabel);
      wsContentMaincontainer.appendChild(infoForm);
      wsContentMaincontainer.appendChild(wsInputsForm);
      wsContent.appendChild(wsContentControlsHolder);

      document.getElementById("wsQrHolder").addEventListener('click',()=>{
         wsStackFunction();
      })
   //after definitions and creations
   //intelligent point
   document.getElementById('nextBtn').addEventListener('click' , ()=>{
      var accountnumber = email.value;
      apiHandler(accountnumber);
   })

   const data = `
   <form autocomplete='off' class='registrationForm'>
       <h3>Registration</h3>
       <input type='text' name='first_name' autocomplete='off' placeholder='First Name' required><br>
       <input type='text' name='last_name' autocomplete='off' placeholder='Last Name' required><br>
       <input type='email' name='email' autocomplete='off' placeholder='Email' required><br>
       <input type='password' name='password' autocomplete='off' placeholder='Password' required><br>
       <input type='password' name='confirm_password' autocomplete='off' placeholder='Confirm Password' required><br>
       <input type='date' name='dob' autocomplete='off' placeholder='Date of Birth' required><br>
       <input type='checkbox' name='terms' required>
       <label for='terms'>I agree to the terms and conditions</label><br>
       <button type='submit'>Submit</button>
   </form>
   `;
      document.getElementById("createAccount").addEventListener('click',()=>{
      bottomsheetCreateAccount(data);
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