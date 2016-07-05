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
	window.location.href = 'enlist.html';
		//window.location.href = 'enlist.php';
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
	
	//function displayEnlistmentForm(arole, aoption) {
	function displayEnlistmentForm() {
		//role = arole;
		//option = aoption;
		role = getCookie('role');
		option = getCookie('option');
		console.log("displayEnlistmentForm role is " + role + " options is " + option);
		var html;
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
			//html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table"><tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" name="firstName" /></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" name="lastname" /></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><input type="text" name="username" /></td></tr><tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" /></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" /></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" /></td></tr><tr><td style="text-align: right;">State:</td><td cstyle="text-align: left;"><input type="text"  name="statename" /></td></tr><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Phone:</td><td cstyle="text-align: left;"><input type="text"  name="phone" /></td></tr><tr><td style="text-align: right;">Email:</td><td cstyle="text-align: left;"><input type="text"  name="emailaddress" /></td></tr><tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
			html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table"><tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" name="firstName" /></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" name="lastName" /></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><input type="text" name="username" /></td></tr><tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" /></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" /></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" /></td></tr><tr><td style="text-align: right;">State:</td><td cstyle="text-align: left;"><input type="text"  name="stateName" /></td></tr><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Phone:</td><td cstyle="text-align: left;"><input type="text"  name="phone" /></td></tr><tr><td style="text-align: right;">Email:</td><td cstyle="text-align: left;"><input type="text"  name="emailAddress" /></td></tr><tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
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
				html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="username" value="unknown" /><input type="hidden" name="street1" value="unknown" /><input type="hidden" name="street2" value="unknown" /><input type="hidden" name="city" value="unknown" /><input type="hidden" name="stateName" value="XX" /><input type="hidden" name="phone" value="unknown" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="visit sponsor to reset" /><input type="hidden" name="passwordMnemonicAnswer" value="sponsorhelp" /><input type="hidden" name="firstName" value="unknown" /><input type="hidden" name="lastName" value="unknown" /><input type="hidden" name="emailAddress" value="' + uniqueEmailAddress + '" /><input type="hidden" name="shortname" value="shortname" /><input type="hidden" name="isforsale" value="0" /><input type="hidden" name="createddate" value="' + date + '" /><table class="w3-table"><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Handle:</td><td style="text-align: left;"><input type="text" name="handle"></td></tr><tr><td style="text-align: right;">Sponsor Username:</td><td style="text-align: left;"><input type="text" name="sponsor"></td></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Gun Name:</td><td style="text-align: left;"><input type="text" name="gunname"></td></tr><tr><td style="text-align: right;">Make:</td><td style="text-align: left;"><input type="text" name="make"></td></tr><tr><td style="text-align: right;">Model:</td><td style="text-align: left;"><input type="text" name="model"></td></tr><tr><td style="text-align: right;">Serial Number:</td><td style="text-align: left;"><input type="text" name="serialnumber"></td></tr><tr><td style="text-align: right;">Description:</td><td style="text-align: left;"><input type="text" name="description"></td></tr><tr><td style="text-align: right;">Caliber:</td><td style="text-align: left;"><input type="text" name="caliber"></td></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
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
				html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table"><tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" name="firstName" /></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" name="lastName" /></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><input type="text" name="username" /></td></tr><tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" /></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" /></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" /></td></tr><tr><td style="text-align: right;">State:</td><td cstyle="text-align: left;"><input type="text"  name="stateName" /></td></tr><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Phone:</td><td cstyle="text-align: left;"><input type="text"  name="phone" /></td></tr><tr><td style="text-align: right;">Email:</td><td cstyle="text-align: left;"><input type="text"  name="emailAddress" /></td></tr><tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Skills You Have:</td><td style="text-align: left;"><input type="text" name="otherSkills"></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
				break;
			default:
				// donor
				html='<form action="enlist.php" method="post"><input type="hidden" name="action" value="register" /><input type="hidden" name="primarySkillArea" value="other" /><input type="hidden" name="passwordMnemonicQuestion" value="update profile" /><input type="hidden" name="passwordMnemonicAnswer" value="memberhelp" /><table class="w3-table"><tr><td style="text-align: right;">First Name:</td><td cstyle="text-align: left;"><input type="text" name="firstName" /></td></tr><tr><td style="text-align: right;">Last Name:</td><td cstyle="text-align: left;"><input type="text" name="lastName" /></td></tr><tr><td style="text-align: right;">Username:</td><td cstyle="text-align: left;"><input type="text" name="username" /></td></tr><tr><td style="text-align: right;">Street1:</td><td cstyle="text-align: left;"><input type="text"  name="street1" /></td></tr><tr><td style="text-align: right;">Street2:</td><td cstyle="text-align: left;"><input type="text"  name="street2" /></td></tr><tr><td style="text-align: right;">City:</td><td cstyle="text-align: left;"><input type="text"  name="city" /></td></tr><tr><td style="text-align: right;">State:</td><td cstyle="text-align: left;"><input type="text"  name="stateName" /></td></tr><tr><td style="text-align: right;">Zip Code:</td><td style="text-align: left;"><input type="text" name="zip5" /></tr><tr><td style="text-align: right;">Phone:</td><td cstyle="text-align: left;"><input type="text"  name="phone" /></td></tr><tr><td style="text-align: right;">Email:</td><td cstyle="text-align: left;"><input type="text"  name="emailAddress" /></td></tr><tr><td style="text-align: right;">Password:</td><td cstyle="text-align: left;"><input type="text" name="password1"></tr><tr><td style="text-align: right;">Password Again:</td><td style="text-align: left;"><input type="text" name="password2"></tr><tr><td style="text-align: right;">Gender:</td><td style="text-align: left;"><input type="radio" name="gender" value="m" checked> Male</input>&nbsp;<input type="radio" name="gender" value="f"> Female</input></tr><tr><td style="text-align: right;">Maintain Confidentiality:</td><td style="text-align: left;"><input type="radio" name="confidential" value="1" checked> Yes</input>&nbsp;<input type="radio" name="confidential" value="0"> No</input></tr><tr><td style="text-align: right;">Reminder Solicitations (in months):</td><td style="text-align: left;"><input type="text" name="reminderGap"></tr><tr><td style="text-align: right;">Intentional Donor Status:</td><td style="text-align: left;"><input type="radio" name="intentionalDonor" value="1"> Yes</input>&nbsp;<input type="radio" name="intentionalDonor" value="0" checked> No</input></tr><tr><td style="text-align: right;">Subscribe to Postings:</td><td style="text-align: left;"><input type="radio" name="subscriber" value="1"> Yes</input>&nbsp;<input type="radio" name="subscriber" value="0" checked> No</input></tr><tr><td/><td style="text-align: left;"><input type="submit" value="Submit"></td></tr></table></form>';
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