//receives content and target node
export function nota(content){
    const wss = document.getElementById("WsNota");
    const WsNewInfo = document.createElement('p');
    const wsTopControlsHolder = document.getElementById("wsTopControlsHolder");
    const wsNotificationIconHolder = document.getElementById("wsNotificationIconHolder");
    const WsNota = document.createElement('div');

    if(wsTopControlsHolder.contains(wss)){
        //update message
WsNewInfo.innerText = content;
    }else {
    //append message
            //notification element properties
            WsNota.classList = "WsNota";
            //properties
            WsNewInfo.style.color = "green";
    WsNewInfo.innerText = content;
    WsNota.appendChild(WsNewInfo);
    wsTopControlsHolder.insertBefore(WsNota,wsNotificationIconHolder);
    }


}