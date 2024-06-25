<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="core.css">
    <link rel="stylesheet" href="bottomsheet-modal/styles.css">
    <link rel="stylesheet" href="profileBox/profileBox.css">
    <title>dashboard</title>
    
</head>
<body>
<div class="main-window" id="main">
    
<div class="wsBody" id="wsBody">
<!-- Rounded switch -->

<div class="logoholder">
    <div class="lg1"></div>
    <div class="lg2"></div>
    <div class="lg3"></div>
</div>
    <h1 style="color:white">northfast account</h1>
    <div class="wsHeader" id='wsHeader'>
            <div class="accountsettings" id="accountsettings"> 
                
             <div class="profileimageHolder" id="profileimageHolder"><img title="profile" src="./res/user.png" alt="profile" srcset=""></div>
             <div class="accountnameHolder">   
                    <!--consent screen-->
<div class="consentScreen-default" id="consentScreen">
    <div class="consentContent" id="consentContent">
    <p>You are about to delete a connection</p>
    </div>
   <div class="consentControls" id="consentControls">
    <button type="button" class="consentAccept" id="consentAccept">Accept</button>
    <button type="button" class="consentReject" id="consentReject">Reject</button>
</div>
</div>
<!--end of consent screen-->
                <div class="wsContent">
              <h3 class="titleS">Sessions</h3>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo">
                    <h5>gari.co.ke</h5>
                </div>
                <div class="controls" id="controls">
                    <button type="button"  class="delete"  id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo">
                    <h5>premier</h5>
                </div>
                <div class="controls" id="controls">
                    <button type="button" class="delete"  id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">remove access</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
           </div>
        </div>
            </div> 
    </div>
    
 
    <div class="wsFooter" id="wsFooter"></div>
    </div>       

</div>     
<!--end of main window-->          
</div>
    <!--bottom sheet -->
    <div id="bottomSheet" class="bottom-sheet">
        <div class="bar"></div>
        <div class="content" id="content"></div>
    </div>
<!--end of bottomsheet-->  

<script type="module" src="./profileman/index.js"></script>
<script src="webStacks.js" type="module"></script>
<!-- <script src="././sections/accounts/api.js" type="module"></script> -->
<!---->
</body>
</html>