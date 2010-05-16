// JavaScript Document
function createAjax() {
	var xmlHttp;
	try {
		xmlHttp = new document.XMLHttpRequest();
	} catch(e) {
		try {
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try	{
         		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
         	} catch (e) {
				 alert("doesnt support AJAX!");
				 return false;
         	}
      	}
	}
	return xmlHttp;
}

function ajaxpost(url,formid) {
	var result = new Object();
	var xmlHttp = createAjax();
	result = getParameter(formid);
	result = JSON.stringify(result);
	xmlHttp.onreadystatechange = function() {
		if(xmlHttp.readyState==4) {
			document.getElementById("ress").innerHTML = xmlHttp.responseText;
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.send(result);
}
function getParameter(formid) {
	var result = new Object();
	form = document.getElementById(formid);
	inputs = form.getElementsByTagName("INPUT");
	selects = form.getElementsByTagName("SELECT");
	textareas = form.getElementsByTagName("TEXTAREA");
	for (var i = 0; i < inputs.length; i++) {
		var name = inputs[i].name;
		var value = inputs[i].value;
		var type = inputs[i].type;
		var checked = inputs[i].checked;
		switch (type) {
			case "text":
				result[name] = value;
				break;
			case "password":
				result[name] = value;
				break;
			case "radio":
				if (checked) {
					result[name] = value;
				}
				break;
			case "checkbox":
				if (checked) {
					result[name] = value;
				}
				break;
			default:
				break;
		}
	}
	for (var i = 0; i < selects.length; i++) {
		var name = selects[i].name;
		var value = selects[i].value;
		result[name] = value;
	}
	for (var i = 0; i < textareas.length; i++) {
		var name = textareas[i].name;
		var value = textareas[i].value;
		result[name] = value;
	}
	return result;
}
function argumentsToArray(arguments,del) {
	var idArray = new Array();
	if (del == null || del == 'undefined') {del = 0;}
	for (var i = del; i < arguments.length; i++) {
		idArray.push(arguments[i]);
	}
	return idArray;
}