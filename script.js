// document.getElementById('button').onclick = CreatStoreInfoDiv;
document.getElementsByName('memberLogin').onclick = UserLogin('memberLogin');
document.getElementsByName('farmerLogin').onclick = UserLogin('farmerLogin');
var i = 0;
var storeInfoTemplate = document.getElementById('storeInfoTemplate');

function CreatStoreInfoDiv() {
    var clone = storeInfoTemplate.cloneNode(true); // "deep" clone
    clone.style = "";
    clone.id = "storeInfoDiv" + ++i; // there can only be one element with an ID
    storeInfoTemplate.parentNode.appendChild(clone);
}

function UserLogin(identity) {
    var userName = document.getElementsByName('user');
    var password = document.getElementsByName('password');
    var index = 0;
    if (identity == 'memberLogin') {
        //會員登入
        index = 1;

    }
    else if (identity == 'farmerLogin') {
        //小農登入
        index = 2;
    }
    else if (identity == 'rootLogin') {
        //管理者登入
        index = 3;
    }

}