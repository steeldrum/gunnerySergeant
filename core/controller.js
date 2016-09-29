function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}

function processEnlistment() {
	var value = 'booster';
	var x = document.getElementsByClassName("membertype");
	var i;
	for (i = 0; i < x.length; i++) {
	    //x[i].style.backgroundColor = "red";
		if (x[i].checked) {
			value = x[i].value;
			break;
		}	   
	}
	console.log("processEnlistment value is " + value);
	switch(value) {
	case 'sponsor':
		console.log("processEnlistment sponsor case...");
		window.location.href = 'sponsor.html';
		break;
	case 'private':
		console.log("processEnlistment owner case...");
		window.location.href = 'private.html';
		break;
	case 'sergeant':
		console.log("processEnlistment sergeant case...");
		window.location.href = 'sergeant.html';
		break;
	default:
		console.log("processEnlistment default case...");
	  window.location.href = 'booster.html';
		break;
	}
}

var role;
var option;
function enlist(arole, aoption) {
	role = arole;
	option = aoption;
	console.log("enlist role is " + role + " options is " + option);
	//window.role = role;
	//window.option = option;
	setCookie('role', role, 1);
	setCookie('option', option, 1);
	// tjs 160709
	//setCookie('errors', 'none', 1);
	setCookie('errornumber', 0, 1);
	//window.location.href = 'enlist.html';
	//window.location.href = 'enlist.php';
		window.location.href = 'enlist.php?role=' + role + '&option=' + option;
		/*
		var html;
		switch(role) {
		case 'sponsor':
			console.log("enlist sponsor case...");
			//window.location.href = 'sponsor.html';
			break;
		case 'private':
			console.log("enlist owner case...");
			//window.location.href = 'private.html';
			switch(option) {
			case 2:
				break;
			case 3:
				break;
			default:
				html='<div id="gender">{{gender}}</div><div id="zip5">{{zip5}}</div><div id="handle">{{handle}}</div><div id="sponsor">{{sponsor}}</div><div id="commPreference">{{commPreference}}</div>';
				break;
			}
			break;
		case 'sergeant':
			console.log("enlist sergeant case...");
			//window.location.href = 'sergeant.html';
			break;
		default:
			console.log("enlist default case...");
		  //window.location.href = 'booster.html';
			break;
		}
		window.location.href = 'enlist.html';
		console.log("enlist html " + html);
		$('#enlistmentForm').empty();
	
		$('#enlistmentForm').append($(html));
		console.log("enlist form appended...");
		
		var handle = "BillyTheKid";
		console.log("enlist handle " + handle);
		w3DisplayData("handle", {"handle" : handle});
		console.log("enlist handle displayed...");
		//window.location.href = 'enlist.html';*/
		
	}

// tjs 160825
//function memberServices(arole, aoption) {
function memberServices(arole, aoption, atoken) {
	role = arole;
	option = aoption;
	console.log("memberServices role is " + role + " options is " + option);
	//window.role = role;
	//window.option = option;
	setCookie('role', role, 1);
	setCookie('option', option, 1);
	// tjs 160709
	//setCookie('errors', 'none', 1);
	setCookie('errornumber', 0, 1);
	//window.location.href = 'enlist.html';
	//window.location.href = 'enlist.php';
	
	// tjs 160805
	if (option == 0) {
		window.location.href = 'memberProfileManager.php?role=' + role + '&option=' + option + '&token=-1';
	} else if (option == 22) {
		window.location.href = 'view_role_members.php?start=0&order=role';	
	} else if (option == 10) {
		//window.location.href = 'view_platoon_logs.php?start=0&order=startaccess';	
		token = atoken;
		console.log("memberServices token is " + token);
		window.location.href = 'view_platoon_logs.php?start=0&order=startaccess&sergeantid=' + atoken;	
	} else if (option == 12) {
		//window.location.href = 'view_platoon_logs.php?start=0&order=startaccess';	
		token = atoken;
		console.log("memberServices token is " + token);
		window.location.href = 'add_edit_platoon_member_log.php?sergeantid=' + atoken;	
	}
		/*
		var html;
		switch(role) {
		case 'sponsor':
			console.log("enlist sponsor case...");
			//window.location.href = 'sponsor.html';
			break;
		case 'private':
			console.log("enlist owner case...");
			//window.location.href = 'private.html';
			switch(option) {
			case 2:
				break;
			case 3:
				break;
			default:
				html='<div id="gender">{{gender}}</div><div id="zip5">{{zip5}}</div><div id="handle">{{handle}}</div><div id="sponsor">{{sponsor}}</div><div id="commPreference">{{commPreference}}</div>';
				break;
			}
			break;
		case 'sergeant':
			console.log("enlist sergeant case...");
			//window.location.href = 'sergeant.html';
			break;
		default:
			console.log("enlist default case...");
		  //window.location.href = 'booster.html';
			break;
		}
		window.location.href = 'enlist.html';
		console.log("enlist html " + html);
		$('#enlistmentForm').empty();
	
		$('#enlistmentForm').append($(html));
		console.log("enlist form appended...");
		
		var handle = "BillyTheKid";
		console.log("enlist handle " + handle);
		w3DisplayData("handle", {"handle" : handle});
		console.log("enlist handle displayed...");
		//window.location.href = 'enlist.html';*/
		
	}
function displayErrors() {
	errorNumber = getCookie('errornumber');
	//console.log("displayEnlistmentForm errors are " + errors);
	console.log("displayErrors error number " + errorNumber);

	var errorhtml = "";
	
		if (errorNumber == 0) {
			errorhtml = errorhtml + '<p>Checked Items Are Validated...</p>';
		} else {
			if (errorNumber >= 32) {
				errorhtml = errorhtml + '<p class="error">The entries for "username", "password", "emailAddress", "firstName", "lastName", "zip5", and "gender" are all required fields.</p>';
				errorNumber -= 32;
			}
			if (errorNumber >= 16) {
				errorhtml = errorhtml + '<p class="error">A member with that handle already exists for the same zip code in the database. Please choose another handle.</p>';
				errorNumber -= 16;
			}
			if (errorNumber >= 8) {
				hterrorhtmlml = errorhtml + '<p class="error">A member with that email address already exists in the database. Please choose another email address, or contact the webmaster to retrieve your password.</p>';
				errorNumber -= 8;
			}
			if (errorNumber >= 4) {
				errorhtml = errorhtml + '<p class="error">A member with that username already exists in the database. Please choose another username.</p>';
				errorNumber -= 4;
			}
			if (errorNumber >= 2) {
				errorhtml = errorhtml + '<p class="error">A member in you zip code area with that haandle already exists in the database. Please choose another handle.</p>';
				errorNumber -= 2;
			}
			if (errorNumber >= 1) {
				errorhtml = errorhtml + '<p class="error">Please make sure you enter your password correctly in both password fields.</p>';
			}
		}
		console.log("displayErrors errorhtml " + errorhtml);
		$('#errorList').empty();
		$('#errorList').append($(errorhtml));

}
	//function displayEnlistmentForm(arole, aoption) {
	function displayEnlistmentForm() {
		//role = arole;
		//option = aoption;
		role = getCookie('role');
		option = getCookie('option');
		console.log("displayEnlistmentForm role is " + role + " options is " + option);
		// tjs 160709
		//errors = getCookie('errors');
		//errorNumber = getCookie('errornumber');
		//console.log("displayEnlistmentForm errors are " + errors);
		//console.log("displayEnlistmentForm error number " + errorNumber);
		//var html;
		//var html = errors;
		var html = "";
		
		//var handleTableRow = '<tr><td style="text-align: right;">Handle:</td><td><p><input type="text" size="32" id="handle" name="handle" onchange="callAjax(\'checkHandle\', this.value, this.id);">&nbsp;<input id="valid_handle" type="checkbox" disabled name="valid_handle"></p><div id="rsp_handle"><!-- --></div></td></tr>';
		var handleTableRow = '<tr><td style="text-align: right;">Handle:</td><td cstyle="text-align: left;"><p><input type="text" size="32" id="handle" name="handle" onchange="callAjax(\'checkHandle\', this.value, this.id);">&nbsp;<input id="valid_handle" type="checkbox" disabled name="valid_handle"></p><div id="rsp_handle"><!-- --></div></td></tr>';
		//var sponsorUsernameTableRow = '<tr><td style="text-align: right;">Sponsor Username:</td><td cstyle="text-align: left;"><p><input type="text" size="32" id="sponsorusername" name="sponsorusername" onchange="callAjax(\'checkSponsorUsername\', this.value, this.id);">&nbsp;<input id="valid_sponsorusername" type="checkbox" disabled name="valid_sponsorusername"></p><div id="rsp_sponsorusername"><!-- --></div></td></tr>';
		var sponsorUsernameTableRow = '<tr><td style="text-align: right;">Sponsor Username:</td><td cstyle="text-align: left;"><p><input type="text" size="32" id="sponsorusername" name="sponsor" onchange="callAjax(\'checkSponsorUsername\', this.value, this.id);">&nbsp;<input id="valid_sponsorusername" type="checkbox" disabled name="valid_sponsorusername"></p><div id="rsp_sponsorusername"><!-- --></div></td></tr>';
		//var namingTableRows = '<tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" size="32" name="firstname" onchange="this.value = this.value.replace(/^\s+|\s+$/g, \'\'); valid_firstname.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_firstname"></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" size="32" name="lastname" onchange="this.value = this.value.replace(/^\s+|\s+$/g, \'\'); valid_lastname.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_lastname"></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><p><input type="text" size="32" id="username" name="username" onchange="callAjax(\'checkUsername\', this.value, this.id);">&nbsp;<input id="valid_username" type="checkbox" disabled name="valid_username"></p><div id="rsp_username"><!-- --></div></td></tr>';
		// nok var namingTableRows = '<tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" size="32" name="firstname" onchange="this.value = this.value.replace(/^/\s+|/\s+$/g, \'\'); valid_firstname.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_firstname"></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" size="32" name="lastname" onchange="this.value = this.value.replace(/^\s+|\s+$/g, \'\'); valid_lastname.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_lastname"></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><p><input type="text" size="32" id="username" name="username" onchange="callAjax(\'checkUsername\', this.value, this.id);">&nbsp;<input id="valid_username" type="checkbox" disabled name="valid_username"></p><div id="rsp_username"><!-- --></div></td></tr>';
		//var namingTableRows = '<tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" size="32" name="firstname" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_firstname.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_firstname"></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" size="32" name="lastname" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_lastname.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_lastname"></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><p><input type="text" size="32" id="username" name="username" onchange="callAjax(\'checkUsername\', this.value, this.id);">&nbsp;<input id="valid_username" type="checkbox" disabled name="valid_username"></p><div id="rsp_username"><!-- --></div></td></tr>';
		var namingTableRows = '<tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" size="32" name="firstName" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_firstname.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_firstname"></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" size="32" name="lastName" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_lastname.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_lastname"></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><p><input type="text" size="32" id="username" name="username" onchange="callAjax(\'checkUsername\', this.value, this.id);">&nbsp;<input id="valid_username" type="checkbox" disabled name="valid_username"></p><div id="rsp_username"><!-- --></div></td></tr>';
		//var addressTableRows='<tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" onchange="this.value = this.value.replace(/^\s+|\s+$/g, \'\'); valid_street1.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_street1"></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" onchange="this.value = this.value.replace(/^\s+|\s+$/g, \'\'); valid_street2.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_street2"></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" onchange="this.value = this.value.replace(/^\s+|\s+$/g, \'\'); valid_city.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_city"></td></tr><tr><td style="text-align: right;">State:</td><td cstyle="text-align: left;"><input type="text"  name="stateName" onchange="this.value = this.value.replace(/^\s+|\s+$/g, \'\'); valid_statename.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_statename"></td></tr><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5"  onchange="this.value = this.value.replace(/^\s+|\s+$/g, \'\'); valid_zip5.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_zip5"></tr>';
		var addressStateTableRow='<tr><td style="text-align: right;">State Code:</td><td style="text-align: left;"><input type="text" name="stateName"  onchange="this.value = /^([a-z]{2})$/.test(this.value)? this.value : \'\'; valid_statename.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_statename"></tr>';
		var addressZipCodeTableRow='<tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5"  onchange="this.value = /^([0-9]{5})$/.test(this.value)? this.value : \'\'; valid_zip5.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_zip5"></tr>';
		//var addressTableRows='<tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_street1.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_street1"></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_street2.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_street2"></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_city.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_city"></td></tr><tr><td style="text-align: right;">State:</td><td cstyle="text-align: left;"><input type="text"  name="stateName" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_statename.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_statename"></td></tr><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5"  onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_zip5.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_zip5"></tr>';
		var addressTableRows='<tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_street1.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_street1"></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_street2.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_street2"></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" onchange="this.value = this.value.replace(/^\\s+|\\s+$/g, \'\'); valid_city.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_city"></td></tr>' + addressStateTableRow + addressZipCodeTableRow;
		//var addressZipCodeTableRow='<tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5"  onchange="this.value = /^([0-9]{5})$/.exec(this.value); valid_zip5.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_zip5"></tr>';
//		var addressZipCodeTableRow='<tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5"  onchange="this.value = /^([0-9]{5})$/.test(this.value)? this.value : \'\'; valid_zip5.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_zip5"></tr>';
		var phoneTableRow ='<tr><td style="text-align: right;">Phone:</td><td cstyle="text-align: left;"><input type="text"  name="phone" onchange="this.value = this.value.replace(/^\s+|\s+$/g, \'\'); valid_phone.checked = this.value;">&nbsp;<input type="checkbox" disabled name="valid_phone"></td></tr>';
		var emailTableRow ='<tr><td style="text-align: right;">Email:</td><td cstyle="text-align: left;"><input type="text" id="email" name="emailAddress" onchange="callAjax(\'checkEmail\', this.value, this.id);">&nbsp;<input id="valid_email" type="checkbox" disabled name="valid_email"></p><div id="rsp_email"><!-- --></div></td></tr>';

		switch(role) {
		case 'sponsor':
			console.log("displayEnlistmentForm sponsor case...");
			/*
			 * about this case:
			 * A sponsor is a friend/acquantance or relative of a gun owner.
			 * A sponsor must be enlisted prior to a private of any form.
			 * (The enlistment can directly preceed the private enlistment).
			 * New private enlistments trigger an event that verifies the sponsor
			 * information and requests a response from the sponsor.
			 * The verification informs the sponsor that he or she now has
			 * a private that referenced them as a sponsor.  The sponsor
			 * should not be surprized and should simply acknowledge that this is OK.
			 * Part of the sponsor response is to state that the sponsor does NOT posses any guns!
			 * On occasion staff could contact the sponsor if questions arise.
			 * The system ensures, as best it can, that the sponsor doesn't have a gun.
			 * The system ensures that the same sponsor is NOT sponsering another enlisted member
			 * (other than the private that tries to reference the sponsor the first time).
			 * We solicit minimal information from the prospective sponsor
			 * reducing data entry fatique.  The sponsor can (later on) sign in
			 * and update his or her proffile with more details.
			 *  */
			//TODO use ajax check to ensure the username for the sponsor.
			//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table"><tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" name="firstName" /></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" name="lastName" /></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><input type="text" name="username" /></td></tr><tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" /></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" /></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" /></td></tr><tr><td style="text-align: right;">State:</td><td cstyle="text-align: left;"><input type="text"  name="stateName" /></td></tr><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Phone:</td><td cstyle="text-align: left;"><input type="text"  name="phone" /></td></tr><tr><td style="text-align: right;">Email:</td><td cstyle="text-align: left;"><input type="text"  name="emailAddress" /></td></tr><tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
			//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table">' + namingTableRows + '<tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" /></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" /></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" /></td></tr><tr><td style="text-align: right;">State:</td><td cstyle="text-align: left;"><input type="text"  name="stateName" /></td></tr><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Phone:</td><td cstyle="text-align: left;"><input type="text"  name="phone" /></td></tr><tr><td style="text-align: right;">Email:</td><td cstyle="text-align: left;"><input type="text"  name="emailAddress" /></td></tr><tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
			//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table">' + namingTableRows + addressTableRows + '<tr><td style="text-align: right;">Phone:</td><td cstyle="text-align: left;"><input type="text"  name="phone" /></td></tr><tr><td style="text-align: right;">Email:</td><td cstyle="text-align: left;"><input type="text"  name="emailAddress" /></td></tr><tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
			////html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table">' + namingTableRows + addressTableRows + phoneTableRow + emailTableRow + '<tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
			//html = html + '<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table">' + namingTableRows + addressTableRows + phoneTableRow + emailTableRow + '<tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
			html = html + '<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table">' + namingTableRows + addressTableRows + phoneTableRow + emailTableRow + '<tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
			 break;
		case 'private':
			/*
			 * effect of private registration is:
  derive sponsor id given sponsor username
  derive kaba member id given kaba member username
  use temp sergeantid = 1
  
  insert into kaba (gun owner desiring KABA rights)
			 */
			console.log("displayEnlistmentForm owner case...");
			//window.location.href = 'private.html';
			switch(option) {
			case '2':
				break;
			case '3':
				break;
			default:
				var d = new Date();
				var n = d.getTime();
				var uniqueEmailAddress = n + '@collogistics.com';
				/*
				 * about this case:
				 * Non PFC, non-certified private implies:
				 * The enlister knows the sponsor's username
				 * Enlistment is handled by sorrogate sponsor in this way:
				 * the sponsor's password is used temporarily.  After
				 * enlistment the private is expected to meet with
				 * sponsor who log's into the newly created private's account.
				 * The private can then adjust (reset) the password
				 * as well as password mnemonic related fields.
				 * The default username for the newbie private is based on
				 * his or handle but forced to become unique.  The private
				 * can alter the username once the account transfer is
				 * effected (i.e. meet with sponsor and reset password).
				 * 
				 *  */
//TODO use ajax check to ensure the handle is unique within the zip code.  Use ajax to try handle as username until unique by appending numbers starting with 1.
				//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="username" value="unknown" /><input type="hidden" name="street1" value="unknown" /><input type="hidden" name="street2" value="unknown" /><input type="hidden" name="city" value="unknown" /><input type="hidden" name="stateName" value="XX" /><input type="hidden" name="phone" value="unknown" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="visit sponsor to reset" /><input type="hidden" name="passwordMnemonicAnswer" value="sponsorhelp" /><input type="hidden" name="firstName" value="unknown" /><input type="hidden" name="lastName" value="unknown" /><input type="hidden" name="emailAddress" value="' + uniqueEmailAddress + '" /><table class="w3-table"><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Handle:</td><td style="text-align: left;"><input type="text" name="handle"></td></tr><tr><td style="text-align: right;">Sponsor Username:</td><td style="text-align: left;"><input type="text" name="sponsor"></td></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				var d = new Date();
				var month = d.getUTCMonth() + 1; //months from 1-12
				if (month < 10) {
					month = "0" + new String(month)
				}
				var day = d.getUTCDate();
				if (day < 10) {
					day = "0" + new String(day)
				}
				var year = d.getUTCFullYear();
				var date = year + '-' + month + '-' + day;

				//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="username" value="unknown" /><input type="hidden" name="street1" value="unknown" /><input type="hidden" name="street2" value="unknown" /><input type="hidden" name="city" value="unknown" /><input type="hidden" name="stateName" value="XX" /><input type="hidden" name="phone" value="unknown" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="visit sponsor to reset" /><input type="hidden" name="passwordMnemonicAnswer" value="sponsorhelp" /><input type="hidden" name="firstName" value="unknown" /><input type="hidden" name="lastName" value="unknown" /><input type="hidden" name="emailAddress" value="' + uniqueEmailAddress + '" /><input type="hidden" name="shortname" value="shortname" /><input type="hidden" name="isforsale" value="0" /><table class="w3-table"><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Handle:</td><td style="text-align: left;"><input type="text" name="handle"></td></tr><tr><td style="text-align: right;">Sponsor Username:</td><td style="text-align: left;"><input type="text" name="sponsor"></td></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Gun Name:</td><td style="text-align: left;"><input type="text" name="gunname"></td></tr><tr><td style="text-align: right;">Make:</td><td style="text-align: left;"><input type="text" name="make"></td></tr><tr><td style="text-align: right;">Model:</td><td style="text-align: left;"><input type="text" name="model"></td></tr><tr><td style="text-align: right;">Serial Number:</td><td style="text-align: left;"><input type="text" name="serialnumber"></td></tr><tr><td style="text-align: right;">Description:</td><td style="text-align: left;"><input type="text" name="description"></td></tr><tr><td style="text-align: right;">Caliber:</td><td style="text-align: left;"><input type="text" name="caliber"></td></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="username" value="unknown" /><input type="hidden" name="street1" value="unknown" /><input type="hidden" name="street2" value="unknown" /><input type="hidden" name="city" value="unknown" /><input type="hidden" name="stateName" value="XX" /><input type="hidden" name="phone" value="unknown" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="visit sponsor to reset" /><input type="hidden" name="passwordMnemonicAnswer" value="sponsorhelp" /><input type="hidden" name="firstName" value="unknown" /><input type="hidden" name="lastName" value="unknown" /><input type="hidden" name="emailAddress" value="' + uniqueEmailAddress + '" /><input type="hidden" name="shortname" value="shortname" /><input type="hidden" name="isforsale" value="0" /><input type="hidden" name="createddate" value="' + date + '" /><table class="w3-table">' + addressZipCodeTableRow + '<tr><td style="text-align: right;">Handle:</td><td style="text-align: left;"><input type="text" name="handle"></td></tr><tr><td style="text-align: right;">Sponsor Username:</td><td style="text-align: left;"><input type="text" name="sponsor"></td></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Gun Name:</td><td style="text-align: left;"><input type="text" name="gunname"></td></tr><tr><td style="text-align: right;">Make:</td><td style="text-align: left;"><input type="text" name="make"></td></tr><tr><td style="text-align: right;">Model:</td><td style="text-align: left;"><input type="text" name="model"></td></tr><tr><td style="text-align: right;">Serial Number:</td><td style="text-align: left;"><input type="text" name="serialnumber"></td></tr><tr><td style="text-align: right;">Description:</td><td style="text-align: left;"><input type="text" name="description"></td></tr><tr><td style="text-align: right;">Caliber:</td><td style="text-align: left;"><input type="text" name="caliber"></td></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="username" value="unknown" /><input type="hidden" name="street1" value="unknown" /><input type="hidden" name="street2" value="unknown" /><input type="hidden" name="city" value="unknown" /><input type="hidden" name="stateName" value="XX" /><input type="hidden" name="phone" value="unknown" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="visit sponsor to reset" /><input type="hidden" name="passwordMnemonicAnswer" value="sponsorhelp" /><input type="hidden" name="firstName" value="unknown" /><input type="hidden" name="lastName" value="unknown" /><input type="hidden" name="emailAddress" value="' + uniqueEmailAddress + '" /><input type="hidden" name="shortname" value="shortname" /><input type="hidden" name="isforsale" value="0" /><input type="hidden" name="createddate" value="' + date + '" /><table class="w3-table">' + addressZipCodeTableRow + '<tr><td style="text-align: right;">Handle:</td><td style="text-align: left;"><input type="text" name="handle"></td></tr>' + sponsorUsernameTableRow + '<tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Gun Name:</td><td style="text-align: left;"><input type="text" name="gunname"></td></tr><tr><td style="text-align: right;">Make:</td><td style="text-align: left;"><input type="text" name="make"></td></tr><tr><td style="text-align: right;">Model:</td><td style="text-align: left;"><input type="text" name="model"></td></tr><tr><td style="text-align: right;">Serial Number:</td><td style="text-align: left;"><input type="text" name="serialnumber"></td></tr><tr><td style="text-align: right;">Description:</td><td style="text-align: left;"><input type="text" name="description"></td></tr><tr><td style="text-align: right;">Caliber:</td><td style="text-align: left;"><input type="text" name="caliber"></td></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				//html = html + '<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="username" value="unknown" /><input type="hidden" name="street1" value="unknown" /><input type="hidden" name="street2" value="unknown" /><input type="hidden" name="city" value="unknown" /><input type="hidden" name="stateName" value="XX" /><input type="hidden" name="phone" value="unknown" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="visit sponsor to reset" /><input type="hidden" name="passwordMnemonicAnswer" value="sponsorhelp" /><input type="hidden" name="firstName" value="unknown" /><input type="hidden" name="lastName" value="unknown" /><input type="hidden" name="emailAddress" value="' + uniqueEmailAddress + '" /><input type="hidden" name="shortname" value="shortname" /><input type="hidden" name="isforsale" value="0" /><input type="hidden" name="createddate" value="' + date + '" /><table class="w3-table">' + addressZipCodeTableRow + handleTableRow + sponsorUsernameTableRow + '<tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Gun Name:</td><td style="text-align: left;"><input type="text" name="gunname"></td></tr><tr><td style="text-align: right;">Make:</td><td style="text-align: left;"><input type="text" name="make"></td></tr><tr><td style="text-align: right;">Model:</td><td style="text-align: left;"><input type="text" name="model"></td></tr><tr><td style="text-align: right;">Serial Number:</td><td style="text-align: left;"><input type="text" name="serialnumber"></td></tr><tr><td style="text-align: right;">Description:</td><td style="text-align: left;"><input type="text" name="description"></td></tr><tr><td style="text-align: right;">Caliber:</td><td style="text-align: left;"><input type="text" name="caliber"></td></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				//html = '<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="username" value="unknown" /><input type="hidden" name="street1" value="unknown" /><input type="hidden" name="street2" value="unknown" /><input type="hidden" name="city" value="unknown" /><input type="hidden" name="stateName" value="XX" /><input type="hidden" name="phone" value="unknown" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="visit sponsor to reset" /><input type="hidden" name="passwordMnemonicAnswer" value="sponsorhelp" /><input type="hidden" name="firstName" value="unknown" /><input type="hidden" name="lastName" value="unknown" /><input type="hidden" name="emailAddress" value="' + uniqueEmailAddress + '" /><input type="hidden" name="shortname" value="shortname" /><input type="hidden" name="isforsale" value="0" /><input type="hidden" name="createddate" value="' + date + '" /><table class="w3-table">' + addressZipCodeTableRow + handleTableRow + sponsorUsernameTableRow + '<tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Gun Name:</td><td style="text-align: left;"><input type="text" name="gunname"></td></tr><tr><td style="text-align: right;">Make:</td><td style="text-align: left;"><input type="text" name="make"></td></tr><tr><td style="text-align: right;">Model:</td><td style="text-align: left;"><input type="text" name="model"></td></tr><tr><td style="text-align: right;">Serial Number:</td><td style="text-align: left;"><input type="text" name="serialnumber"></td></tr><tr><td style="text-align: right;">Description:</td><td style="text-align: left;"><input type="text" name="description"></td></tr><tr><td style="text-align: right;">Caliber:</td><td style="text-align: left;"><input type="text" name="caliber"></td></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				html = html + '<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="username" value="unknown" /><input type="hidden" name="street1" value="unknown" /><input type="hidden" name="street2" value="unknown" /><input type="hidden" name="city" value="unknown" /><input type="hidden" name="stateName" value="XX" /><input type="hidden" name="phone" value="unknown" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="visit sponsor to reset" /><input type="hidden" name="passwordMnemonicAnswer" value="sponsorhelp" /><input type="hidden" name="firstName" value="unknown" /><input type="hidden" name="lastName" value="unknown" /><input type="hidden" name="emailAddress" value="' + uniqueEmailAddress + '" /><input type="hidden" name="shortname" value="shortname" /><input type="hidden" name="isforsale" value="0" /><input type="hidden" name="createddate" value="' + date + '" /><table class="w3-table">' + addressZipCodeTableRow + handleTableRow + sponsorUsernameTableRow + '<tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Gun Name:</td><td style="text-align: left;"><input type="text" name="gunname"></td></tr><tr><td style="text-align: right;">Make:</td><td style="text-align: left;"><input type="text" name="make"></td></tr><tr><td style="text-align: right;">Model:</td><td style="text-align: left;"><input type="text" name="model"></td></tr><tr><td style="text-align: right;">Serial Number:</td><td style="text-align: left;"><input type="text" name="serialnumber"></td></tr><tr><td style="text-align: right;">Description:</td><td style="text-align: left;"><input type="text" name="description"></td></tr><tr><td style="text-align: right;">Caliber:</td><td style="text-align: left;"><input type="text" name="caliber"></td></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
			break;
		}
		break;
	case 'sergeant':
		console.log("displayEnlistmentForm sergeant case...");
		//window.location.href = 'sergeant.html';
		break;
	default:
		console.log("displayEnlistmentForm default case...");
	  //window.location.href = 'booster.html';
		switch(option) {
			case '2':
				// collaborator
				//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table"><tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" name="firstName" /></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" name="lastName" /></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><input type="text" name="username" /></td></tr><tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" /></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" /></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" /></td></tr><tr><td style="text-align: right;">State:</td><td cstyle="text-align: left;"><input type="text"  name="stateName" /></td></tr><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Phone:</td><td cstyle="text-align: left;"><input type="text"  name="phone" /></td></tr><tr><td style="text-align: right;">Email:</td><td cstyle="text-align: left;"><input type="text"  name="emailAddress" /></td></tr><tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Skills You Have:</td><td style="text-align: left;"><input type="text" name="otherSkills"></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table">' + namingTableRows + addressTableRows + phoneTableRow + emailTableRow + '<tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Skills You Have:</td><td style="text-align: left;"><input type="text" name="otherSkills"></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				html = html + '<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table">' + namingTableRows + addressTableRows + phoneTableRow + emailTableRow + '<tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Skills You Have:</td><td style="text-align: left;"><input type="text" name="otherSkills"></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				break;
			default:
				// donor
				//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table"><tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" name="firstName" /></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" name="lastName" /></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><input type="text" name="username" /></td></tr><tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" /></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" /></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" /></td></tr><tr><td style="text-align: right;">State:</td><td cstyle="text-align: left;"><input type="text"  name="stateName" /></td></tr><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Phone:</td><td cstyle="text-align: left;"><input type="text"  name="phone" /></td></tr><tr><td style="text-align: right;">Email:</td><td cstyle="text-align: left;"><input type="text"  name="emailAddress" /></td></tr><tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Maintain Confidentiality:</td><td style="text-align: left;"><input type="radio" name="confidential" value="1" checked> Yes</input>&nbsp;<input type="radio" name="confidential" value="0"> No</input></tr><tr><td style="text-align: right;">Reminder Solicitations (in months):</td><td style="text-align: left;"><input type="text" name="reminderGap"></tr><tr><td style="text-align: right;">Intentional Donor Status:</td><td style="text-align: left;"><input type="radio" name="intentionalDonor" value="1"> Yes</input>&nbsp;<input type="radio" name="intentionalDonor" value="0" checked> No</input></tr><tr><td style="text-align: right;">Subscribe to Postings:</td><td style="text-align: left;"><input type="radio" name="subscriber" value="1"> Yes</input>&nbsp;<input type="radio" name="subscriber" value="0" checked> No</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table">' + namingTableRows + addressTableRows + phoneTableRow + emailTableRow + '<tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Maintain Confidentiality:</td><td style="text-align: left;"><input type="radio" name="confidential" value="1" checked> Yes</input>&nbsp;<input type="radio" name="confidential" value="0"> No</input></tr><tr><td style="text-align: right;">Reminder Solicitations (in months):</td><td style="text-align: left;"><input type="text" name="reminderGap"></tr><tr><td style="text-align: right;">Intentional Donor Status:</td><td style="text-align: left;"><input type="radio" name="intentionalDonor" value="1"> Yes</input>&nbsp;<input type="radio" name="intentionalDonor" value="0" checked> No</input></tr><tr><td style="text-align: right;">Subscribe to Postings:</td><td style="text-align: left;"><input type="radio" name="subscriber" value="1"> Yes</input>&nbsp;<input type="radio" name="subscriber" value="0" checked> No</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				html = html + '<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table">' + namingTableRows + addressTableRows + phoneTableRow + emailTableRow + '<tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Maintain Confidentiality:</td><td style="text-align: left;"><input type="radio" name="confidential" value="1" checked> Yes</input>&nbsp;<input type="radio" name="confidential" value="0"> No</input></tr><tr><td style="text-align: right;">Reminder Solicitations (in months):</td><td style="text-align: left;"><input type="text" name="reminderGap"></tr><tr><td style="text-align: right;">Intentional Donor Status:</td><td style="text-align: left;"><input type="radio" name="intentionalDonor" value="1"> Yes</input>&nbsp;<input type="radio" name="intentionalDonor" value="0" checked> No</input></tr><tr><td style="text-align: right;">Subscribe to Postings:</td><td style="text-align: left;"><input type="radio" name="subscriber" value="1"> Yes</input>&nbsp;<input type="radio" name="subscriber" value="0" checked> No</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				break;
		}
		break;
	}

		
	//window.location.href = 'enlist.html';
	console.log("displayEnlistmentForm html " + html);
	$('#enlistmentForm').empty();

	$('#enlistmentForm').append($(html));
	console.log("displayEnlistmentForm form appended...");
	/*
	var handle = "BillyTheKid";
	console.log("displayEnlistmentForm handle " + handle);
	w3DisplayData("handle", {"handle" : handle});
	console.log("displayEnlistmentForm handle displayed...");
	//window.location.href = 'enlist.html';	
	*/
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}


