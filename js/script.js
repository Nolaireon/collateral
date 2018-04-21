var permissionLogin = false;
var regInputs = {username:false, password:false, mail:false, permissionRegister:false};
var rightUsername = false;
var rightPassword = false;
var user = [];

$(document).ready(function(){
    checkLogged();
	
	function hideAllDialogs(){
		$('.dialog-overlay').fadeOut();
	}

	$('.dialog-confirm-button').on('click', function () {
		hideAllDialogs();
	});

	$('.dialog-overlay').on('click', function (e) {
		if(e.target == this){
			hideAllDialogs();
		}
	});

	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			hideAllDialogs();
		}
	});
	
	//var toShow = $(this).data('show-dialog');
	//showDialog('my-success-dialog', 'Content here ...');
	/*$('.dialog-show-button').on('click', function () {
		var toShow = $(this).data('show-dialog');
		showDialog(toShow);
	});*/
})

function showDialog(id, content){
	var dialog = $('#' + id), card = dialog.find('.dialog-card'), info = card.find('p');
	info.text(content);
	dialog.fadeIn();
	card.css({'margin-top' : -card.outerHeight()/2});
}

function slideToggleFunc(buttonID){
	switch(buttonID){
		case "toggle-register":
			$("#authSection").slideToggle("slow", function(){
				$("#authSection").empty();
				$("#authSection").load("./upload.html #regForm", function(){
					$("#authSection").slideToggle("slow");
				});
			});
			break;
		case "toggle-login":
			$("#authSection").slideToggle("slow", function(){
				$("#authSection").empty();
				$("#authSection").load("./upload.html #loginForm", function(){
					$("#authSection").slideToggle("slow");
				});
			});
			break;
		case "toggle-logout":
			$("#authSection").slideToggle("slow", function(){
				$("#authNav").empty();
				$("#authNav").load("./upload.html #toggle-login, #toggle-register");
				$("#authSection").empty();
				$("#authSection").load("./upload.html #loginForm", function(){
					$("#authSection").slideToggle("slow");
				});
			});
			break;
		case "submit":
			$("#authSection").slideToggle("slow", function(){
				onAuthSectionRefresh();
				$("#authSection").slideToggle("slow");
			});
			break;
	}
}

function onAuthSectionRefresh(){
	$("#authNav").empty();
	$("#authNav").load("./upload.html #toggle-logout");
	$("#authSection").empty();
	$("#authSection").html('<div id="avatar"><img src="'+user["avatar"]+'">'+'<h3>You are welcome<br>'+user["name"]+'!</h3></div><p id="messageP">5 messages</p><p id="settingsP">setup your profile</p>');
}

function validateLoginForm(inputField){
	if (inputField == "username"){
		var x = document.forms["loginForm"]["username"];
		var z = document.getElementsByClassName("validateIco")[0];
		if (x.value == null || x.value == "" || x.value.length < 4 || x.value.length > 16){
			rightUsername = false;
			z.style.backgroundImage = "url('./images/button_cancel.png')";
		} else {
			rightUsername = true;
			z.style.backgroundImage = "url('./images/button_ok.png')";
		}
	} else if (inputField == "password"){
		var x = document.forms["loginForm"]["password"];
		var z = document.getElementsByClassName("validateIco")[1];
		if (x.value == null || x.value == "" || x.value.length < 4 || x.value.length > 16){
			rightPassword = false;
			z.style.backgroundImage = "url('./images/button_cancel.png')";
		} else {
			rightPassword = true;
			z.style.backgroundImage = "url('./images/button_ok.png')";
		}
	}
	
	if (rightUsername && rightPassword){
		permissionLogin = true;
	} else {
		permissionLogin = false;
	}
}

function validateRegForm(inputField){
	switch(inputField){
		case "username":
			var x = document.forms["regForm"]["username"];
			var z = document.getElementsByClassName("validateIco")[0];
			if (x.value == null || x.value == "" || x.value.length < 4 || x.value.length > 16){
				regInputs["username"] = false;
				z.style.backgroundImage = "url('./images/button_cancel.png')";
			} else {
				regInputs["username"] = true;
				z.style.backgroundImage = "url('./images/button_ok.png')";
			}
			break;
		case "rPassword":
			var x = document.forms["regForm"]["rPassword"];
			var z = document.getElementsByClassName("validateIco")[1];
			if (x.value == null || x.value == "" || x.value.length < 4 || x.value.length > 16){
				regInputs["password"] = false;
				z.style.backgroundImage = "url('./images/button_cancel.png')";
			} else {
				regInputs["password"] = true;
				z.style.backgroundImage = "url('./images/button_ok.png')";
			}
			break;
		case "mail":
			var x = document.forms["regForm"]["mail"];
			var z = document.getElementsByClassName("validateIco")[2];
			if (x.value == null || x.value == "" || x.value.length < 4 || x.value.length > 24){
				regInputs["mail"] = false;
				z.style.backgroundImage = "url('./images/button_cancel.png')";
			} else {
				regInputs["mail"] = true;
				z.style.backgroundImage = "url('./images/button_ok.png')";
			}
			break;
	}
	
	if (regInputs["username"] && regInputs["password"] && regInputs["mail"]){
		regInputs["permissionRegister"] = true;
	} else {
		regInputs["permissionRegister"] = false;
	}
}

function submitLoginForm(){
	if (permissionLogin){
		permissionLogin = false;
		var sData = $("#loginForm").serialize();
		$.myPOST("login", sData, function(rData){
			if (rData["status"] == 1){
				user["name"] = rData["name"];
				user["avatar"] = rData["avatar"];
				slideToggleFunc("submit");
			}else if(rData["status"] == 0){
				//alert("Error: "+rData["error"]);
				showDialog('my-error-dialog', rData["error"]);
			}
		});
	}else{
		//alert("Incorrect login/password");
		showDialog('my-error-dialog', 'Incorrect login/password');
	}
	return false;
}

function submitRegForm(){
	if (regInputs["permissionRegister"]){
		regInputs["permissionRegister"] = false;
		var sData = $("#regForm").serialize();
		$.myPOST("register", sData, function(rData){
			if (rData["status"] == 3){
				slideToggleFunc("toggle-login");
				//alert("Message: "+rData["message"]);
				showDialog('my-success-dialog', rData["message"]);
			}else if(rData["status"] == 0){
				//alert("Error: "+rData["error"]);
				showDialog('my-error-dialog', rData["error"]);
			}
		});
	}else{
		//alert("Incorrect inputs");
		showDialog('my-error-dialog', 'Incorrect inputs');
	}
	return false;
}

function submitLogout(){
	if (user["name"] != undefined){
		var sData = "logout";
		$.myPOST("logout", sData, function(rData){
			if (rData["status"] == 1){
				slideToggleFunc("toggle-logout");
			}
		});
	}
}

function checkLogged(){
	$.myPOST("checkLogged", function(rData){
		if (rData["status"] == 1){
			user["name"] = rData["name"];
			user["avatar"] = rData["avatar"];
			onAuthSectionRefresh();
		}
	});
}

$.myPOST = function(action,data,callback){
	$.post('./php/main.php?action='+action,data,callback,'json');
}