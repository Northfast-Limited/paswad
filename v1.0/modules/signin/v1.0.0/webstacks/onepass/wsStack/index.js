//wsStack //names may change in the future
const wsStack = document.createElement('div');
const wsStackHeader = document.createElement('div');
const wsStackBody = document.createElement('div');
const wsStackContent = document.createElement('div'); 
const wsStackTopControls = document.createElement('div');
const wsStackBottomControls = document.createElement('div');
const wsStackFooter = document.createElement('div');

const wsHeaderLeftContainer = document.createElement('div');
const wsHeaderBackArrowHolder = document.createElement('div');
const wsHeaderBackArrowImage = document.createElement('img');
const wsHeaderPreviousTitle = document.createElement('h2');
//wsstack sample wr element
const wsStackLoginQrHolder = document.createElement('div');
const wsStackLoginQrImg = document.createElement('img');
//classes
wsStackContent.classList = "wsStackContent";
wsStackLoginQrHolder.classList = "wsStackLoginQrHolder";
wsStackLoginQrImg.classList = "wsStackLoginQrImg";
wsStackLoginQrImg.src = "wsStack/res/sample.jpg";
wsStackLoginQrHolder.appendChild(wsStackLoginQrImg);

//footer elements
const wsStackFooterControls = document.createElement('div');
const learnHowToUseThisQr = document.createElement('a');
learnHowToUseThisQr.classList = "learnHowToUseThisQr";
learnHowToUseThisQr.innerText = "Learn more about qr login";
wsStackFooterControls.classList = "wsStackFooterControls";
wsStackFooterControls.appendChild(learnHowToUseThisQr);
//element properties
wsHeaderPreviousTitle.innerText = "Login";
wsHeaderLeftContainer.classList = "wsHeaderLeftContainer";
wsHeaderLeftContainer.id = "wsHeaderLeftContainer";
wsHeaderBackArrowHolder.classList = "wsHeaderBackArrowHolder";
wsHeaderBackArrowHolder.id = "wsHeaderBackArrowHolder";
wsHeaderBackArrowImage.classList = "wsHeaderBackArrowImage";
wsHeaderBackArrowImage.id = "wsHeaderBackArrowImage";
wsHeaderBackArrowImage.src = "./wsStack/res/arrow.png";
wsHeaderBackArrowHolder.appendChild(wsHeaderBackArrowImage);
wsHeaderLeftContainer.appendChild(wsHeaderBackArrowHolder);
wsHeaderLeftContainer.appendChild(wsHeaderPreviousTitle);

wsStack.classList = "wsStack";
wsStack.id = "wsStack";
wsStackHeader.classList = "wsStackHeader";
wsStackHeader.id = "wsStackHeader";
wsStackBody.classList = "wsStackBody";
wsStackBody.id = "wsStackBody";
wsStackTopControls.classList = "wsStackTopControls";
wsStackTopControls.id = "wsStackTopControls";
wsStackBottomControls.classList = "wsStackBottomControls";
wsStackBottomControls.id = "wsStackBottomControls";
wsStackFooter.classList = "wsStackFooter";


//appends
wsStackContent.appendChild(wsStackLoginQrHolder);

wsStackFooter.appendChild(wsStackFooterControls);
wsStack.appendChild(wsStackHeader);
wsStackHeader.appendChild(wsHeaderLeftContainer);
wsStack.appendChild(wsStackBody);
wsStackBody.appendChild(wsStackTopControls);
wsStackBody.appendChild(wsStackContent);
wsStackBody.appendChild(wsStackBottomControls);
wsStack.appendChild(wsStackFooter);
//get wscontent
const wsContent = document.getElementById('wsContent');
//receives props
//name change in the future
//receives controls and target element
export function wsStackFunction(){
//create a new stack
//test with wsContent
wsContent.appendChild(wsStack);

}

//back button functionality 
wsHeaderBackArrowHolder.addEventListener('click',()=>{
backBtn();
});
export function backBtn(){
    wsContent.removeChild(wsStack);
}