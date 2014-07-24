/**
 * @module ui/login.reel
 * @requires montage/ui/component
 */
var Component = require("montage/ui/component").Component;
var RangeController = require('montage/core/range-controller').RangeController;
//var MemberService = require('core/member-service').MemberService;
var sharedGunnerySergeantCrudService = require('core/gunnerysergeant-crud-service').shared;
var Serializer = require('montage/core/serialization').Serializer;
var Deserializer = require('montage/core/serialization').Deserializer;
var LOCAL_STORAGE_KEY = 'credentials-montage';
// tjs 140716
var selfie;

/**
 * @class Login
 * @extends Component
 */
exports.Login = Component.specialize(/** @lends Login# */ {
    gunnerysergeantListController: {
        value: null
    },
    gunnerysergeantGSListController: {
        value: null
    },
    gunnerysergeantMMListController: {
        value: null
    },
    constructor: {
        value: function Login() {
            this.super();
            this.gunnerysergeantListController = new RangeController();
            this.gunnerysergeantGSListController = new RangeController();
            this.gunnerysergeantMMListController = new RangeController();
            this.defineBindings({
                'militia': {'<-': 'gunnerysergeantListController.organizedContent'},
                'militiaGunnerySergeants': {'<-': 'gunnerysergeantListGSController.organizedContent'},
                'militiaPrivates': {'<-': 'gunnerysergeantListMMController.organizedContent'}
              });
            var self = this;
            selfie = this;
        }
    },
    militia: {
        value: null
    },
    militiaGunnerySergeants: {
        value: null
    },
    militiaPrivates: {
        value: null
    },
    templateDidLoad: {
        value: function() {
            console.log("templateDidLoad");
            sharedGunnerySergeantCrudService.load(this.gunnerysergeantListController);
            console.log("load done...");
            var pageName = this.templateObjects.pageName;
            pageName.value = "Home";
            
            // tjs 140721
            var associateTypes = this.templateObjects.associateTypes;
            
            associateTypes.content = [
                {"label": "Spouse"},
                {"label": "Brother"},
                {"label": "Sister"},
                {"label": "Father"},
                {"label": "Mother"},
                {"label": "Son"},
                {"label": "Daughter"},
                {"label": "Uncle"},
                {"label": "Aunt"},
                {"label": "Nephew"},
                {"label": "Niece"},
                {"label": "Friend"},
                {"label": "Acquaintance"},
                {"label": "Other"}
            ];

            // tjs 140719
            loginTemplate = this;
        }
    },
    createMember: { // enlist
        value: function (record) {
            var member = new MemberService().initWithMember(record);
            this.gunnerysergeantListController.add(member);
            return member;
        }
    },
    destroyMember: {
        value: function (member) {
            this.gunnerysergeantListController.delete(member);
            return member;
        }
    },
    processNewMemberFormSubmit: {
        value: function () {
        }
    },
    handleCredentials2HomeButtonAction: {
        value: function() {
            console.log("handleCredentials2HomeButtonAction action!");
            var pageName = this.templateObjects.pageName;            
            pageName.value = "Home";
        }
    },
    handleAssociates2HomeButtonAction: {
        value: function() {
            console.log("handleAssociates2HomeButtonAction action!");
            this.handleCredentials2HomeButtonAction();
        }
    },
    handleGunnerySergeant2HomeButtonAction: {
        value: function() {
            console.log("handleGunnerySergeant2HomeButtonAction action!");
            this.handleCredentials2HomeButtonAction();
         }
    },
    handleContact2HomeButtonAction: {
        value: function() {
            console.log("handleContact2HomeButtonAction action!");
            this.handleCredentials2HomeButtonAction();
        }
    },
    handleBackupContact2HomeButtonAction: {
        value: function() {
            console.log("handleBackupContact2HomeButtonAction action!");
            this.handleCredentials2HomeButtonAction();
        }
    },
    handleAbout2HomeButtonAction: {
        value: function() {
            console.log("handleAbout2HomeButtonAction action!");
            this.handleCredentials2HomeButtonAction();
        }
    },
    handleReport2HomeButtonAction: {
        value: function() {
            console.log("handleReport2HomeButtonAction action!");
            this.handleCredentials2HomeButtonAction();
        }
    },
    handleAboutButtonAction: {
        value: function() {
            console.log("about action!");
            var pageName = this.templateObjects.pageName;            
            pageName.value = "About";
        }
    },
    handleSignupAction: {
        value: function() {
            console.log("handleSignupAction");
            //var targetRangeController = this.templateObjects.targetRangeController;
            userMode = "signup";
            this.templateObjects.signupImage.src = "../../assets/images/targetedDuck30x32.jpg";
            this.templateObjects.alreadySignedUpImage.src = "../../assets/images/untargetedDuck30x32.jpg";
            this.templateObjects.volunteerImage.src = "../../assets/images/untargetedDuck30x32.jpg";
            this.templateObjects.logImage.src = "../../assets/images/untargetedDuck30x32.jpg";
            this.templateObjects.cityField.value = "";            
            this.templateObjects.stateField.value = "";            
            this.templateObjects.handleField.value = "";
            this.templateObjects.associatesList.content = new Array();
        }
    },
    handleAlreadySignedUpAction: {
        value: function() {
            console.log("handleAlreadySignedUpAction");
            //var targetRangeController = this.templateObjects.targetRangeController;
            userMode = "alreadySignedUp";
            this.templateObjects.signupImage.src = "../../assets/images/untargetedDuck30x32.jpg";
            this.templateObjects.alreadySignedUpImage.src = "../../assets/images/targetedDuck30x32.jpg";
            this.templateObjects.volunteerImage.src = "../../assets/images/untargetedDuck30x32.jpg";
            this.templateObjects.logImage.src = "../../assets/images/untargetedDuck30x32.jpg";
        }
    },
    handleVolunteerAction: {
        value: function() {
            console.log("handleVolunteerAction");
            //var targetRangeController = this.templateObjects.targetRangeController;
            userMode = "volunteer";
           this.templateObjects.signupImage.src = "../../assets/images/untargetedDuck30x32.jpg";
            this.templateObjects.alreadySignedUpImage.src = "../../assets/images/untargetedDuck30x32.jpg";
            this.templateObjects.volunteerImage.src = "../../assets/images/targetedDuck30x32.jpg";
            this.templateObjects.logImage.src = "../../assets/images/untargetedDuck30x32.jpg";
        }
    },
    handleLogAction: {
        value: function() {
            console.log("handleLogAction");
            //var targetRangeController = this.templateObjects.targetRangeController;
            userMode = "log";
            this.templateObjects.signupImage.src = "../../assets/images/untargetedDuck30x32.jpg";
            this.templateObjects.alreadySignedUpImage.src = "../../assets/images/untargetedDuck30x32.jpg";
            this.templateObjects.volunteerImage.src = "../../assets/images/untargetedDuck30x32.jpg";
            this.templateObjects.logImage.src = "../../assets/images/targetedDuck30x32.jpg";
        }
    },
    handleLoginButtonAction: {
        value: function() {
            console.log("login action!");
            var pageName = this.templateObjects.pageName;            
            pageName.value = "Credentials";
            var associates = this.templateObjects.associates;            
            associates.value = "None";
            // tjs 140721 temp for debug
            var associatesList = this.templateObjects.associatesList;
            
            //this.templateObjects.signupImage.src = "../../assets/images/targetedDuck30x32.jpg";
            selfie.handleSignupAction();
        	console.log("handleLoginButtonAction userMode " + userMode);

            if (localStorage) {
                var credentialsSerialization = localStorage.getItem(LOCAL_STORAGE_KEY);
                if (credentialsSerialization) {
                    var deserializer = new Deserializer(),
                        self = this;

                    // tjs 140711
                    loginTemplate = this;
                    
                    deserializer.init(credentialsSerialization, require)
                    .deserializeObject()
                    .then(function (credentialsRefIndex) {
                       	var index = credentialsRefIndex;
                       	// tjs 140630
                       	currentMilitiaMemberLocalStorageRef = index;
                    	console.log("restore using local storage credentials from index " + index);
                         sharedGunnerySergeantCrudService.findCredentialsByIndex(index, self);
                         // tjs 140721 temp hack
                         loginTemplate.templateObjects.alreadySignedUp.checked = true;
                         selfie.handleAlreadySignedUpAction();
                     	console.log("handleLoginButtonAction userMode (localStorage) " + userMode);
                         /*
                          loginTemplate.templateObjects.signupImage.src = "../../assets/images/untargetedDuck30x32.jpg";
                         loginTemplate.templateObjects.alreadySignedUp.checked = true;
                         var targetRangeController = loginTemplate.templateObjects.targetRangeController;
                         userMode = targetRangeController.value;
                         loginTemplate.templateObjects.alreadySignedUpImage.src = "../../assets/images/targetedDuck30x32.jpg";
                         */
                    }).fail(function (error) {
                        console.error('Could not load credentials ref.');
                        console.debug('Could not deserialize', credentialsSerialization);
                        console.log(error.stack);
                    });
                }
            }
        }
    },
    handleCredentialsButtonAction: {
        value: function() {
            console.log("credentials login action!");
            var cityField = this.templateObjects.cityField.value;            
            var stateField = this.templateObjects.stateField.value;            
            var handleField = this.templateObjects.handleField.value;
            var associatesList = this.templateObjects.associatesList.content;
            var associateTypeSelection = this.templateObjects.associateTypeSelection.value;
            var associateNameField = this.templateObjects.associateNameField.value;
            
            // tjs 140723
			if (associatesList.length > 0) {
				console.log("handleCredentialsButtonAction associatesList "
						+ JSON.stringify(associatesList));
			}
			if (associateNameField != null && associateNameField.length > 0) {
				var newMemberAssociate = MemberAssociate(associateTypeSelection, associateNameField);
				associatesList.push(newMemberAssociate);
			}
            
            console.log("credentials cityField " + cityField + " stateField " + stateField + " handleField " + handleField);
            // tjs 140723
         	console.log("handleCredentialsButtonAction userMode " + userMode);
            var targetRangeController = this.templateObjects.targetRangeController;
            //var userMode = targetRangeController.value;
            userMode = targetRangeController.value;
            console.log("credentials userMode (controller reset) " + userMode);
        	this.templateObjects.city.value = cityField;
        	this.templateObjects.state.value = stateField;
        	this.templateObjects.handle.value = handleField;
            //var toggleField = this.templateObjects.toggleField.checked;
        	var toggleField = userMode == "volunteer" || userMode == "log";
            console.log("credentials toggle " + toggleField);
            //var foundMember = sharedGunnerySergeantCrudService.validateCredentials(stateField, cityField, handleField, associatesList);
            //console.log("handleCredentialsButtonAction foundMember " + foundMember);
            //var pageName = this.templateObjects.pageName;
            var template = this.templateObjects;
       	if (toggleField) {
            	this.templateObjects.gsHandle.value = handleField;
        	    pageName.value = "GunnerySergeant";
        	} else {
                sharedGunnerySergeantCrudService.validateCredentials(stateField, cityField, handleField, associatesList, template, this.validateCredentialsDone, this.storeCredentialsRef);
 /*
                if (!foundMember) {
        			if (userMode == "signup") {
                    	this.templateObjects.mmContactHandle.value = handleField;
                    	this.templateObjects.mmBackupHandle.value = handleField;
                    	this.templateObjects.mmSelectHandle.value = handleField;
                    	this.templateObjects.mmHandle.value = handleField;
                    	// tjs 140721
                        //sharedGunnerySergeantCrudService.saveCredentials(stateField, cityField, handleField, null, this.storeCredentialsRef);
                        sharedGunnerySergeantCrudService.saveCredentials(stateField, cityField, handleField, associatesList, associateTypeSelection, associateNameField, this.storeCredentialsRef);
                 	    pageName.value = "PrivateContact";
        			}
        		} else {
        			if (userMode == "signup") {
        	       	    pageName.value = "Associates";
        			} else {
        				pageName.value = "PrivateContact";
        			}
        		} */
        	}

            
            /*
             var result = Math.floor((Math.random()*10)+1);
            console.log("credentials lookup result " + result + " result%2 " + result%2);
            var pageName = this.templateObjects.pageName;
            // tjs 140701
            var template = this.templateObjects;
             if (result%2 == 0) {
             	this.templateObjects.toggle.checked = toggleField;
        	    pageName.value = "Associates";
            } else {
            	if (toggleField) {
                	this.templateObjects.gsHandle.value = handleField;
            	    pageName.value = "GunnerySergeant";
            	} else {
                	this.templateObjects.mmContactHandle.value = handleField;
                	this.templateObjects.mmBackupHandle.value = handleField;
                	this.templateObjects.mmSelectHandle.value = handleField;
                	this.templateObjects.mmHandle.value = handleField;
                	// tjs 140721
                    //sharedGunnerySergeantCrudService.saveCredentials(stateField, cityField, handleField, null, this.storeCredentialsRef);
                    sharedGunnerySergeantCrudService.saveCredentials(stateField, cityField, handleField, associatesList, associateTypeSelection, associateNameField, this.storeCredentialsRef);
             	    pageName.value = "PrivateContact";
            	}
            }
            var associates = this.templateObjects.associates;            
            associates.value = "None";*/
        }
    },
    handleAssociatesButtonAction: {
        value: function() {
            console.log("associates login action!");
            var city = this.templateObjects.city.value;            
            var state = this.templateObjects.state.value;            
            var handle = this.templateObjects.handle.value;            
            var handleField = this.templateObjects.handleField.value;            
            console.log("associates city " + city + " state " + state + " handle " + handle);
            // tjs 140721
            var associatesList = this.templateObjects.associatesList.content;
            var associateTypeSelection = this.templateObjects.associateTypeSelection.value;
            var associateNameField = this.templateObjects.associateNameField.value;

            // tjs 140723
			if (associatesList.length > 0) {
				console.log("handleAssociatesButtonAction associatesList "
						+ JSON.stringify(associatesList));
			}
			if (associateNameField != null && associateNameField.length > 0) {
				var newMemberAssociate = MemberAssociate(associateTypeSelection, associateNameField);
				associatesList.push(newMemberAssociate);
			}

            // tjs 140723
         	console.log("associates userMode " + userMode);
            var targetRangeController = this.templateObjects.targetRangeController;
            //var userMode = targetRangeController.value;
            userMode = targetRangeController.value;
            console.log("associates userMode (controller reset) " + userMode);

            //var toggle = this.templateObjects.toggle.checked;
        	var toggleField = userMode == "volunteer" || userMode == "log";
            console.log("credentials toggle " + toggleField);
            //var pageName = this.templateObjects.pageName;
            var template = this.templateObjects;

           // var foundMember = sharedGunnerySergeantCrudService.validateCredentials(state, city, handle, associatesList);
           // console.log("handleAssociatesButtonAction foundMember " + foundMember);
        	if (toggleField) {
            	this.templateObjects.gsHandle.value = handleField;
        	    pageName.value = "GunnerySergeant";
        	} else {
                sharedGunnerySergeantCrudService.validateCredentials(state, city, handle, associatesList, template, this.validateCredentialsDone, this.storeCredentialsRef);
        		/*if (!foundMember) {
        			if (userMode == "signup") {
                    	this.templateObjects.mmContactHandle.value = handleField;
                    	this.templateObjects.mmBackupHandle.value = handleField;
                    	this.templateObjects.mmSelectHandle.value = handleField;
                    	this.templateObjects.mmHandle.value = handleField;
                    	// tjs 140721
                        //sharedGunnerySergeantCrudService.saveCredentials(stateField, cityField, handleField, null, this.storeCredentialsRef);
                        sharedGunnerySergeantCrudService.saveCredentials(state, city, handle, associatesList, associateTypeSelection, associateNameField, this.storeCredentialsRef);
                 	    pageName.value = "PrivateContact";
        			}
        		} else {
        			if (userMode == "signup") {
        	       	    pageName.value = "Associates";
        			} else {
        				pageName.value = "PrivateContact";
        			}
        		}*/
        	}           
            /*
            var result = Math.floor((Math.random()*10)+1);
            console.log("credentials lookup result " + result + " result%2 " + result%2);
            var pageName = this.templateObjects.pageName;            
            // tjs 140701
            var template = this.templateObjects;
            if (result%2 == 0) {
            	this.templateObjects.city.value = city;
            	this.templateObjects.state.value = state;
            	this.templateObjects.handle.value = handle;
            	this.templateObjects.toggle.checked = toggle;
        	    pageName.value = "Associates";
            } else {
            	if (toggle) {
            		this.templateObjects.gsHandle.value = handle;
            	    pageName.value = "GunnerySergeant";
            	} else {
                	this.templateObjects.mmContactHandle.value = handleField;
                	this.templateObjects.mmBackupHandle.value = handleField;
                	this.templateObjects.mmSelectHandle.value = handleField;
                	this.templateObjects.mmHandle.value = handleField;
                     //sharedGunnerySergeantCrudService.saveCredentials(state, city, handle, null, this.storeCredentialsRef);
                     sharedGunnerySergeantCrudService.saveCredentials(state, city, handle, associatesList, associateTypeSelection, associateNameField, this.storeCredentialsRef);
             	    pageName.value = "PrivateContact";
            	}
            }*/
        }
    },
    handleGunnerySergeantButtonAction: {
        value: function() {
            console.log("gunnerySergeants login action!");
            var pageName = this.templateObjects.pageName;            
            // pageName.value = "Credentials";
            var associates = this.templateObjects.associates;            
            // associates.value = "None";
        }
    },
    handlePrivateContactButtonAction: {
        value: function() {
            console.log("handlePrivateContactButtonAction contact action!");
             var pageName = this.templateObjects.pageName;            
             console.log("handlePrivateContactButtonAction pageName value " + pageName.value);
            console.log("handlePrivateContactButtonAction mmEmail <" + this.templateObjects.mmEmailField.value + ">");
            console.log("handlePrivateContactButtonAction mmFirstName <" + this.templateObjects.mmFirstNameField.value + ">");
          sharedGunnerySergeantCrudService.savePrivateContactInfo(currentMilitiaMemberLocalStorageRef, this.templateObjects.mmMobilePhoneField.value, this.templateObjects.mmPhoneField.value, this.templateObjects.mmEmailField.value, this.templateObjects.mmFirstNameField.value, this.templateObjects.mmLastNameField.value, this.templateObjects.mmStreet1Field.value, this.templateObjects.mmStreet2Field.value, this.templateObjects, this.validateContactInfo);                    
         }
    },
    handlePrivateBackupContactButtonAction: {
        value: function() {
            console.log("private login backup contact action!");
            var pageName = this.templateObjects.pageName;  
            console.log("handlePrivateContactButtonAction pageName value " + pageName.value);
            console.log("handlePrivateContactButtonAction mmEmail <" + this.templateObjects.mmBackupEmailField.value + ">");
            console.log("handlePrivateContactButtonAction mmFirstName <" + this.templateObjects.mmBackupFirstNameField.value + ">");
          sharedGunnerySergeantCrudService.savePrivateBackupContactInfo(currentMilitiaMemberLocalStorageRef, this.templateObjects.mmBackupMobilePhoneField.value, this.templateObjects.mmBackupPhoneField.value, this.templateObjects.mmBackupEmailField.value, this.templateObjects.mmBackupFirstNameField.value, this.templateObjects.mmBackupLastNameField.value, this.templateObjects.mmBackupStreet1Field.value, this.templateObjects.mmBackupStreet2Field.value, this.templateObjects, this.validateContactInfo);                    
        }
    },
    backupContactDone: {
        value: function() {
            console.log("login backupContactDone");
        }
    },
    gsLoadDone: {
    	value: function(gsList, pageName, gunnerySergeants) {
             var gunnerySergeantGSList = new Array();
            console.log("private gsLoadDone gsList length " + gsList.length);
			var gsSelector = new GSSelector("Select One", "unknown");
			gunnerySergeantGSList.push(gsSelector);
            for	(index = 0; index < gsList.length; ++index) {
                 var childData = gsList[index];
                console.log("private gsLoadDone childData " + JSON.stringify(childData));
        	    var handle = childData.credentials.region.locale.id.handle;
    	    	//var email = deepClone(childData.data.contactInfo.emails[0]);
    	    	var email = deepClone(childData.data.contactInfo.email);
                console.log("private gsLoadDone handle " + handle + " email " + email);
                // e.g. private gsLoadDone handle SteelDrum email
				// tandmsoucy@verizon.net login.js:252
    			var gsSelector = new GSSelector(handle, email);
                console.log("private gsLoadDone gsSelector " + JSON.stringify(gsSelector));
                // e.g. private gsLoadDone gsSelector
				// {"label":"SteelDrum","email":"tandmsoucy@verizon.net"}
				// login.js:26
    			gunnerySergeantGSList.push(gsSelector);
            }
            console.log("private gsLoadDone gunnerySergeantGSList " + JSON.stringify(gunnerySergeantGSList));
            // e.g. private gsLoadDone gunnerySergeantGSList
			// [{"label":"SteelDrum","email":"tandmsoucy@verizon.net"}]
			// login.js:270
			gunnerySergeants.content = gunnerySergeantGSList;
    	    pageName.value = "PrivateGunnerySergeantSelection";    		
    	}
    },
    validateCredentialsDone: {
        	value: function(foundMember, template, postprocess) {
                var cityField = template.cityField.value;            
                var stateField = template.stateField.value;            
                var handleField = template.handleField.value;
                var associatesList = template.associatesList.content;
                var associateTypeSelection = template.associateTypeSelection.value;
                var associateNameField = template.associateNameField.value;
                console.log("validateCredentialsDone handleField " + handleField + " foundMember " + foundMember + " userMode " + userMode);

        		var pageName = template.pageName;											        	
                if (!foundMember) {
        			if (userMode == "signup") {
        				template.mmContactHandle.value = handleField;
        				template.mmBackupHandle.value = handleField;
        				template.mmSelectHandle.value = handleField;
        				template.mmHandle.value = handleField;
                    	// tjs 140721
                        //sharedGunnerySergeantCrudService.saveCredentials(stateField, cityField, handleField, null, this.storeCredentialsRef);
                        sharedGunnerySergeantCrudService.saveCredentials(stateField, cityField, handleField, associatesList, associateTypeSelection, associateNameField, postprocess);
                 	    pageName.value = "PrivateContact";
        			}
        		} else {
                    sharedGunnerySergeantCrudService.saveCredentials(stateField, cityField, handleField, associatesList, associateTypeSelection, associateNameField, postprocess);
        			if (userMode == "signup") {
         	       	    pageName.value = "Associates";
        			} else {
        				pageName.value = "PrivateContact";
        			}
        		}
    	}
    },
    storeCredentialsRef: {
    	value: function(ref) {
        if (localStorage) {
	    	console.log("login storeCredentialsRef ref " + ref);
	    	var refString = ref.toString();
   	    	var pos = refString.lastIndexOf("/");
	    	var index = refString.substr(++pos);
	    	var self = this;
	    	currentMilitiaMemberLocalStorageRef = index;
                serializer = new Serializer().initWithRequire(require);
                localStorage.setItem(LOCAL_STORAGE_KEY, serializer.serializeObject(index));
                sharedGunnerySergeantCrudService.findCredentialsByIndex(index, loginTemplate);
          }    		
	}
},
    validateContactInfo: {
   	value: function(template, email, phones, snailMail, backupTorf) {
     	    	console.log("login validateContactInfo...");
        	    	console.log("login validateContactInfo email " + JSON.stringify(email));
           	    	console.log("login validateContactInfo phones " + JSON.stringify(phones));
           	    	console.log("login validateContactInfo address " + JSON.stringify(snailMail));
           	    	/*
           	    	 * e.g.
           	    	 * login validateContactInfo emails { "emails" : [""] } login.js:266
login validateContactInfo phones { "phones" : [{"type" : "", "number" : ""}] } login.js:267
login validateContactInfo address { "snailMail" : { "address" : { "street1" : "", "street2" : "", "city" : "", "state" : "", "zip" : ""}, "name" : { "first" : "", "last" : ""}}} login.js:268
           	    	 */
         	    	console.log("login validateContactInfo backupTorf " + backupTorf);
           	    	var landline = null;
           	    	var mobile = null;
           	    	if (phones != null) {
               	    	landline = phones.landline;
               	    	mobile = phones.mobile;
           	    	}
           	    	var first = snailMail.name.first;
           	    	var last = snailMail.name.last;
           	    	var street1 = snailMail.address.street1;
           	    	var street2 = snailMail.address.street2;
           	    	var self = this;
          	    	if (!backupTorf) {
               	    	var contactExists = true;
if ((email == null || email.length == 0) &&
		(landline == null || landline.length == 0) &&
		(mobile == null || mobile.length == 0) &&
		((first == null || first.length == 0) && (last == null || last.length == 0) && (street1 == null || street1.length == 0))) {
	contactExists = false;
}
               	    	console.log("login validateContactInfo contactExists " + contactExists);
                        if (!contactExists) {
                  	    	console.log("login validateContactInfo reroute to PrivateContact...");
                             template.pageName.value = "PrivateContact";
                        } else {
                  	    	console.log("login validateContactInfo review and validate backup contact...");
                   	    	template.pageName.value = "PrivateBackupContact";
                        }
           	    	} else {
               	    	var backupContactExists = true;
               	    	if ((email == null || email.length == 0) &&
               	    			(landline == null || landline.length == 0) &&
               	    			(mobile == null || mobile.length == 0) &&
               	    			((first == null || first.length == 0) && (last == null || last.length == 0) && (street1 == null || street1.length == 0))) {
               	    		backupContactExists = false;
               	    	} 
                        if (!backupContactExists) {
                        	template.pageName.value = "PrivateBackupContact";
                        } else {
                            var city = template.city.value;            
                            var state = template.state.value;
                            console.log("private login validateContactInfo contact city " + city + " state " + state);
                            sharedGunnerySergeantCrudService.loadGS(state, city, selfie.gunnerysergeantGSListController, selfie.gsLoadDone, template.pageName, template.gunnerySergeants);
                        }
           	    	}
    	}
    },
    handlePrivateGunnerySergeantSelectionButtonAction: {
        value: function() {
            console.log("private gunnery sergeant selection action!");
             var pageName = this.templateObjects.pageName;
            var gunnerySergeantEmail = this.templateObjects.gunnerySergeant.value;
            console.log("private gunnery sergeant selection " + gunnerySergeantEmail);
            sharedGunnerySergeantCrudService.postPrivateGSEmail(gunnerySergeantEmail);
            
            var date = new Date(),
            month = date.getMonth() + 1, day = date.getDate(), year = date.getFullYear();
             var today = month + "/" + day + "/" + year;
            console.log("private gunnery sergeant today " + today);
            this.templateObjects.mmDateEntryField.value = today;        
    	    pageName.value = "PrivateReportToGS";
        }
    },
    handlePrivateReportButtonAction: {
        value: function() {
            console.log("private report action!");
            var dateField = this.templateObjects.mmDateField.value;
            console.log("private report date " + dateField);
            var d = Date.parse(dateField);
            console.log("private report d " + d);
            var date = new Date(d),year = date.getFullYear();
            console.log("private report year " + year);           
            var pageName = this.templateObjects.pageName;
            if (year < 1970) {
                var date = new Date(),
                month = date.getMonth() + 1, day = date.getDate(), year = date.getFullYear();
                var today = month + "/" + day + "/" + year;
                console.log("private gunnery sergeant today " + today);
                this.templateObjects.mmDateEntryField.value = today;
            	pageName.value = "PrivateReportToGS";
            } else {
                var type = this.templateObjects.mmTypeField.value;
                var model = this.templateObjects.mmModelField.value;
                var serialNumber = this.templateObjects.mmSerialNumberField.value;
                var name = this.templateObjects.mmNameField.value;
                var description = this.templateObjects.mmDescriptionField.value;
                sharedGunnerySergeantCrudService.postPrivateGun(dateField, type, model, serialNumber, name, description);            	
            	pageName.value = "Credentials";
            }
            //var associates = this.templateObjects.associates;            
        }
    },
    handleButtonAction: {
        value: function() {
            console.log("login action!");
        }
    },
    captureBeforeunload: {
        value: function () {
        	console.log("login captureBeforeunload...");
        }
    }
});
