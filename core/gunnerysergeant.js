/*
 * functions used for the gunnerySergeant.org application
 * est. 140613 tjs
 */
/*
 * GLOBALS
 */
var currentMilitiaMemberLocalStorageRef = null;
var gunnerySergeants = null;
var loginTemplate;
// tjs 140723
var userMode;

/*
 * Data design
 * 
name: {first: <first>, last: <last>}
member: {state: state, city: city, handle: handle, augmentation: {
number: number, spouse: spouse, friends: [name1, name2, ...]}}
credentials: {<member>, password: password }

//types are mobile or landline
phone: {type: <type>, number: <number>}
address: {street1: <street1>, street2: <street2>, city: <city>, state: <state>, zip: <zip>}
snailMail: {name: <name>, address: <address>}
contactInfo: {snailMail: <snailMail>, emails: [email, ...], phones: [phone, ...]}

gunInfo: {dateAcquired: <dateAcquired>, type: <type>, model: <model>, serialNumber:
<serialNumber>, gunName: <gunName>, description: <description>}

contactLog: {member: <member>, date: <date>, log: <notes>}

data: {
backups: [contactInfo, ...], // min one both cases
contactInfo: <contactInfo>, // min one if gunnerySergeantEmail != null
// else one each with type phone mobile assured
guns: [gunInfo, ...], // min one if gunnerySergeantEmail != null
// else must be null
platoonSize: <platoonSize>, // required if gunnerySergeantEmail == null
// else must be null
logs: [contactLog, ...] // optional if gunnerySergeantEmail == null
// else must be null
 }

record: {credentials: <credentials>, gunnerySergeantEmail: gunnerySergeantEmail, data: <data>}

test imported:
{"militia": [
{"credentials": {"state": "MA", "city": "LYNN", "handle": "SteelDrum", "augmentation": {
"number": null, "spouse": "Marsha", "friends": []}},
 "gunnerySergeantEmail": null,
  "data": {
"backups": [{"contactInfo": {"snailMail": null, "emails": ["tsoucy@me.com"], "phones": []}}],
"contactInfo": {"snailMail": {"name": {"first": "Thomas", "last": "Soucy"}, "address": {"street1": "3 Harris Rd", "street2": null, "city": "Lynn", "state": "MA", "zip": "01904"}}, "emails": ["tandmsoucy@verizon.net"], "phones": [{"type": "landline", "number": "781 599-8014"}, {"type": "mobile", "number": "781 608-6840"}]},
"guns": [],
"platoonSize": 10,
"logs": []
 }},
{"credentials": {"state": "ME", "city": "WELLS", "handle": "WoodCarver", "augmentation": {
"number": null, "spouse": null, "friends": ["Bernice"]}},
 "gunnerySergeantEmail": "tandmsoucy@verizon.net",
  "data": {
"backups": [{"contactInfo": {"snailMail": null, "emails": ["bernice@maine.rr.com"], "phones": []}}],
"contactInfo": {"snailMail": null, "emails": [], "phones": [{"type": "landline", "number": "(207) 216-4873"}]},
"guns": [{"dateAcquired": "Jan 1, 2000", "type": "rifle", "model": "model 1", "serialNumber":
"123456", "gunName": "winchester", "description": "hunter rifle"}],
"platoonSize": 0,
"logs": []
 }}]}


 */

function GSSelector(handle, email) {
	this.label = handle;
	this.email = email;
}

// tjs 140626
/*
  {
    "data" : {
      "platoonSize" : 0,
      "backups" : [ {
        "contactInfo" : {
          "emails" : []
        }
      } ],
      "contactInfo" : {
        "emails" : [],
        "snailMail" : {
          "address" : {
            "city" : "",
            "state" : "",
            "zip" : "",
            "street1" : ""
          },
          "name" : {
            "last" : "",
            "first" : ""
          }
        },
        "phones" : [ {
          "type" : "landline",
          "number" : ""
        }, {
          "type" : "mobile",
          "number" : ""
        } ]
      }
    },
    "credentials" : {
      "region" : {
       	"state": "XX",
       	 "locale": {
       	 	"city": "YYYY",
       	 	"id": {
       	 		"handle": "ZZZZZ", "augmentation" : []
       	 	}
       	 }
       	 }
      }
  }
 */
/*
// e.g. usage generator.newMember(0, "MA", "LYNN", "SteelDrum");
var generator = {
		  thruState: ', "backups" : [ {"contactInfo" : {"emails" : []}} ],"contactInfo" : {"emails" : [],"snailMail" : {"address" : {"city" : "","state" : "","zip" : "","street1" : ""},"name" : {"last" : "","first" : ""}},"phones" : [ {"type" : "landline","number" : ""}, {"type" : "mobile","number" : ""} ]}},"credentials" : {"region" : {"state": "',
		  newMember: function(size, state, city, handle) {
		    return ['{"data" : {"platoonSize" : ', size, this.thruState, state, '","locale": {"city": "', city, '","id": {"handle": "', handle, '", "augmentation" : []}}}}}'].join('');
		  }
		};
*/
//e.g. usage generator.newMember(platoonSize, backupContactEmail, backupContactFirstName, backupContactLastName, backupContactStreet1, backupContactStreet2, backupContactCity, backupContactState, backupContactZip, backupContactPhoneType, backupContactPhoneNumber, email, firstName, lastName, street1, street2, city, state, zip, handle, associates);
var generator = {
		upToPlatoonSize: '{"data" : {"platoonSize" : ',
		backupContactInfo: ', "backups" : [ {"contactInfo" : {',
		backupEmail: '"email" : "',
		backupSnailMailCity: '", "snailMail" : {"address" : {"city" : "',
		backupSnailMailState: '","state" : "',
		backupSnailMailZip: '","zip" : "',
		backupSnailMailStreet1: '","street1" : "',
		backupSnailMailStreet2: '","street2" : "',
		backupSnailMailLastName: '"},"name" : {"last" : "',
		backupSnailMailFirstName: '","first" : "',
		backupPhoneLandline: '"}},"phones" : {"landline" : "',
		backupPhoneMobile: '","mobile" : "',
		primaryContactInfo: '"} }}], "contactInfo" : {',
		primaryEmail: '"email" : "',
		primarySnailMailCity: '", "snailMail" : {"address" : {"city" : "',
		primarySnailMailState: '","state" : "',
		primarySnailMailZip: '","zip" : "',
		primarySnailMailStreet1: '","street1" : "',
		primarySnailMailStreet2: '","street2" : "',
		primarySnailMailLastName: '"},"name" : {"last" : "',
		primarySnailMailFirstName: '","first" : "',
		primaryPhoneLandline: '"}},"phones" : {"landline" : "',
		primaryPhoneMobile: '","mobile" : "',
		credentialState: '"} }}, "credentials" : {"region" : {"state": "',
		//endData: '"} ]}}',
		//credentialState: '{"credentials": " : {"region" : {"state": "',
		credentialCity: '","locale": {"city": "',
		credentialHandle: '","id": {"handle": "',
		rest: '", "augmentation" : []}}}}}',
		 // newMember: function(platoonSize, backupContactEmail, backupContactFirstName, backupContactLastName, backupContactStreet1, backupContactStreet2, backupContactCity, backupContactState, backupContactZip, backupContactPhoneType, backupContactPhoneNumber, email, firstName, lastName, street1, street2, city, state, zip, phoneType, phoneNumber, handle, associates) {
		  newMember: function(platoonSize, backupContactEmail, backupContactFirstName, backupContactLastName, backupContactStreet1, backupContactStreet2, backupContactCity, backupContactState, backupContactZip, backupContactLandlinePhone, backupContactMobilePhone, email, firstName, lastName, street1, street2, city, state, zip, landlinePhone, mobilePhone, handle, associates) {
			  var memberInfo = this.upToPlatoonSize + platoonSize + this.backupContactInfo + this.backupEmail + backupContactEmail + this.backupSnailMailCity + backupContactCity + this.backupSnailMailState + backupContactState + this.backupSnailMailZip + backupContactZip + this.backupSnailMailStreet1 + backupContactStreet1 + this.backupSnailMailStreet2 + backupContactStreet2 + this.backupSnailMailLastName + backupContactLastName + this.backupSnailMailFirstName + backupContactFirstName + this.backupPhoneLandline + backupContactLandlinePhone + this.backupPhoneMobile + backupContactMobilePhone + this.primaryContactInfo + this.primaryEmail + email + this.primarySnailMailCity + city + this.primarySnailMailState + state + this.primarySnailMailZip + zip + this.primarySnailMailStreet1 + street1 + this.primarySnailMailStreet2 + street2 + this.primarySnailMailLastName + lastName + this.primarySnailMailFirstName + firstName + this.primaryPhoneLandline + landlinePhone + this.primaryPhoneMobile + mobilePhone + this.credentialState + state + this.credentialCity + city + this.credentialHandle + handle + this.rest;
			  console.log("newMember memberInfo " + memberInfo);
			  //var memberObj = JSON.parse(memberInfo);
		    //return memberObj;
		    return memberInfo;
		  }
		};

//tjs 140721
function MemberAssociate(type, name) {
	this.associateType = type;
	this.associateName = name;
}

//tjs 140722
function appendAssociate(ary, associate) {
	if (associate.spouse != null) {
		var newMemberAssociate = new MemberAssociate("Spouse", associate.spouse);
		ary.push(newMemberAssociate);							
	} else if (associate.Spouse != null) {
		var newMemberAssociate = new MemberAssociate("Spouse", associate.Spouse);
		ary.push(newMemberAssociate);							
	} else if (associate.friend != null) {
		var newMemberAssociate = new MemberAssociate("Friend", associate.friend);
		ary.push(newMemberAssociate);							
	} else if (associate.Friend != null) {
		var newMemberAssociate = new MemberAssociate("Friend", associate.Friend);
		ary.push(newMemberAssociate);							
	} else if (associate.Brother != null) {
		var newMemberAssociate = new MemberAssociate("Brother", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Sister != null) {
		var newMemberAssociate = new MemberAssociate("Sister", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Father != null) {
		var newMemberAssociate = new MemberAssociate("Father", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Mother != null) {
		var newMemberAssociate = new MemberAssociate("Mother", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Son != null) {
		var newMemberAssociate = new MemberAssociate("Son", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Daughter != null) {
		var newMemberAssociate = new MemberAssociate("Daughter", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Uncle != null) {
		var newMemberAssociate = new MemberAssociate("Uncle", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Aunt != null) {
		var newMemberAssociate = new MemberAssociate("Aunt", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Nephew != null) {
		var newMemberAssociate = new MemberAssociate("Nephew", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Niece != null) {
		var newMemberAssociate = new MemberAssociate("Niece", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Acquaintance != null) {
		var newMemberAssociate = new MemberAssociate("Acquaintance", associate.Brother);
		ary.push(newMemberAssociate);							
	} else if (associate.Other != null) {
		var newMemberAssociate = new MemberAssociate("Other", associate.Brother);
		ary.push(newMemberAssociate);							
	} 
}
