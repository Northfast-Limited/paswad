<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="core.css">
    <link rel="stylesheet" href="i.scss">
    <title>auto</title>
    
</head>
<body>

<div class="wsBody" id="wsBody">

       <div class="wsBodyHeader" id='wsBodyHeader'>
            <div class="accountsettings"> 
           
             <div class="profileimageHolder"><img title="profile" src="./res/user.png" alt="profile" srcset=""></div>
             <div class="accountnameHolder"><svg id="spinner" version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
  viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
  <circle fill="#4285F4" stroke="none" cx="6" cy="50" r="6">
    <animate
      attributeName="opacity"
      dur="1s"
      values="0;1;0"
      repeatCount="indefinite"
      begin="0.1"/>    
  </circle>
  <circle fill="#4285F4" stroke="none" cx="26" cy="50" r="6">
    <animate
      attributeName="opacity"
      dur="1s"
      values="0;1;0"
      repeatCount="indefinite" 
      begin="0.2"/>       
  </circle>
  <circle fill="#4285F4" stroke="none" cx="46" cy="50" r="6">
    <animate
      attributeName="opacity"
      dur="1s"
      values="0;1;0"
      repeatCount="indefinite" 
      begin="0.3"/>     
  </circle>
</svg><p id="accountname"  class="accountname"></p><p id="accountnumber"class="accuntnumber"></p></div>
            </div> 
       </div>       
 
            <div class="wsContent">

                </div>
              <div class="cont2">
<!-- 
                 <button  id="stackOpener">Withdraw to mpesa</button>
                 <button  id="registration">Withdraw to bank</button> -->
                 <button id="withdraw"  id="stackOpener">Courses</button>
                 <button id="withdraw"  id="stackOpener">Fees</button>
                 <button id="withdraw"  id="stackOpener">Transcripts</button>
                 <button id="withdraw"  id="stackOpener">Class schedule</button>
                 <button id="withdraw"  id="stackOpener">Assignments</button>
                </div>
                <!--add dynamic html data from js here-->
                
            <div>
            
       
</div>
   



<!--display all data-->
<div class="wsStack" id="wsStack">
    <div class="stackHeader">
        <button onclick="back"><img src = "res/backArrowSvg.svg" alt="back"/></button>
    </div>
<div id="wsBodyStackInnerContent">
   
</div>

</div>
<script src="webStacks.js" type="module"></script>
<script src="././sections/accounts/api.js" type="module"></script>
<script src="././sections/transactions/api.js" type="module"></script>
<!---->

</body>
</html>