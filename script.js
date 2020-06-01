document.getElementById('button').onclick = CreatStoreInfoDiv;
var i = 0;
var storeInfoTemplate = document.getElementById('storeInfoTemplate');

function CreatStoreInfoDiv() {
    var clone = storeInfoTemplate.cloneNode(true); // "deep" clone
    clone.style = "";
    clone.id = "storeInfoDiv" + ++i; // there can only be one element with an ID
    storeInfoTemplate.parentNode.appendChild(clone);
}


