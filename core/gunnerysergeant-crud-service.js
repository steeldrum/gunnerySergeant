var Montage = require('montage').Montage;
var RangeController = require('montage/core/range-controller').RangeController;
var Serializer = require('montage/core/serialization').Serializer;
var Deserializer = require('montage/core/serialization').Deserializer;
var LOCAL_STORAGE_KEY = 'gunnerysergeant-montage';

exports.GunnerySergeantCrudService = Montage
		.specialize({

			constructor : {
				value : function GunnerySergeantService() {
					this.super();
				}
			},

			gunnerySergeantListController : {
				value : null
			},

			gunnerySergeantGSListController : {
				value : null
			},

			gunnerySergeantMMListController : {
				value : null
			},

			load : {
				value : function(gunnerySergeantListController) {
					this.gunnerySergeantListController = gunnerySergeantListController;
					// define( "AGGREGATE_DSN", "firebaseIO.com" );
					// ensure all but one of the following options remain
					// uncommented out!
					var aggregateDSN = "firebaseIO.com";
					var aggregateDB = "gunnerysergeant";
					var militia = "militia";
					// Create our Firebase reference
					var gunnerySergeantListReferenceURL = "https://"
							+ aggregateDB + "." + aggregateDSN + "//" + militia;
					console
							.log("gunnerysergeant-crud-service load gunnerySergeantListReferenceURL "
									+ gunnerySergeantListReferenceURL);
					var gunnerySergeantListRef = new Firebase(
							gunnerySergeantListReferenceURL);
					var self = this;
					gunnerySergeantList = new Array();

					// Basic usage of .once() to read the data located at
					// firebaseRef.
					// firebaseRef.once('value', function(dataSnapshot) { /*
					// handle read data. */ });
					// var messageListRef = new
					// Firebase('https://SampleChat.firebaseIO-demo.com/message_list');
					// lastMessagesQuery = messageListRef.endAt().limit(500);
					// lastMessagesQuery.on('child_added',
					// function(childSnapshot) { /* handle child add */ });
					gunnerySergeantListRef
							.once(
									'value',
									function(dataSnapshot) { /*
																 * handle read
																 * data.
																 */
										// Given a DataSnapshot containing a
										// child 'fred' and a child 'wilma':
										dataSnapshot
												.forEach(function(childSnapshot) {
													// This code will be called
													// twice.
													var childData = childSnapshot
															.val();
													var handle = childData.credentials.region.locale.id.handle;
													console
															.log("gunnerysergeant-crud-service load handle "
																	+ handle);
													// e.g.
													// gunnerysergeant-crud-service
													// load handle SteelDrum
													// gunnerysergeant-crud-service.js:59
													// gunnerysergeant-crud-service
													// load handle WoodCarver
													// gunnerysergeant-crud-service.js:59
													gunnerySergeantList
															.push(childData);
													// childData will be the
													// actual contents of the
													// child.
												});
										console
												.log("gunnerysergeant-crud-service load gunnerySergeantList length "
														+ gunnerySergeantList.length);
										// e.g. gunnerysergeant-crud-service
										// load gunnerySergeantList length 2
										// gunnerysergeant-crud-service.js:64
										self.gunnerySergeantListController.content = gunnerySergeantList;
									});
				}
			},

			loadGS : {
				value : function(state, city, gunnerySergeantListController,
						done, pageName, gunnerySergeants) {
					this.gunnerySergeantGSListController = gunnerySergeantListController;
					var aggregateDSN = "firebaseIO.com";
					var aggregateDB = "gunnerysergeant";
					var militia = "militia";
					// Create our Firebase reference
					var gunnerySergeantGSListReferenceURL = "https://"
							+ aggregateDB + "." + aggregateDSN + "//" + militia;
					console.log("gunnerysergeant-crud-service loadGS gunnerySergeantGSListReferenceURL "
									+ gunnerySergeantGSListReferenceURL);
					var gunnerySergeantGSListRef = new Firebase(
							gunnerySergeantGSListReferenceURL);
					var self = this;
					gunnerySergeantGSList = new Array();
					var query = gunnerySergeantGSListRef.limit(100);
					// Basic usage of .once() to read the data located at
					// firebaseRef.
					console.log("gunnerysergeant-crud-service loadGS state "
							+ state + " city " + city);
					query.once('value',
									function(dataSnapshot) { /*
																 * handle read
																 * data.
																 */
										dataSnapshot.forEach(function(childSnapshot) { /*
																					 * handle
																					 * read
																					 * data.
																					 */
													var childData = childSnapshot.val();
													var platoonSize = childData.data.platoonSize;
													console.log("gunnerysergeant-crud-service loadGS platoonSize "
																	+ platoonSize);
													if (platoonSize > 0) {
														var handle = childData.credentials.region.locale.id.handle;
														console.log("gunnerysergeant-crud-service loadGS handle "
																		+ handle);
														var gsState = childData.credentials.region.state;
														if (gsState == state) {
															var gsCity = childData.credentials.region.locale.city;
															if (gsCity == city) {
																gunnerySergeantGSList.push(childData);
															}
														}
													}
													// e.g.
													// gunnerysergeant-crud-service
													// load handle SteelDrum
													// gunnerysergeant-crud-service.js:59
													// gunnerysergeant-crud-service
													// load handle WoodCarver
													// gunnerysergeant-crud-service.js:59
												});
										console.log("gunnerysergeant-crud-service loadGS gunnerySergeantGSList length "
														+ gunnerySergeantGSList.length);
										if (gunnerySergeantGSList.length == 0) {
											var defaultGSHandle = city
													+ "GunnerySergeant";
											// tjs 140630
											var defaultEmail = defaultGSHandle
												+ '@gunnerySergeant.org';
											//		  newMember: function(platoonSize, backupContactEmail, backupContactFirstName, backupContactLastName, backupContactStreet1, backupContactStreet2, backupContactCity, backupContactState, backupContactZip, backupContactPhoneType, backupContactPhoneNumber, email, firstName, lastName, street1, street2, city, state, zip, phoneType, phoneNumber, handle, associates) {
											var newMember = generator.newMember(100, '', '', '',
															'', '', '', '', '',
															'', '', defaultEmail, '', '',
															'', '', city,
															state, '', '', '',
															defaultGSHandle);
											var gunnerySergeantGSDefaultRef = gunnerySergeantGSListRef
													.push(JSON.parse(newMember));
											console.log("gunnerysergeant-crud-service loadGS gunnerySergeantGSDefaultRef "
															+ gunnerySergeantGSDefaultRef);
									
											// e.g. gunnerysergeant-crud-service
											// loadGS
											// gunnerySergeantGSDefaultRef
											// https://gunnerysergeant.firebaseio.com/militia/-JQZe9dlNxyGtdEjWFn6

											gunnerySergeantGSDefaultRef.once(
															'value',
															function(
																	dataSnapshot) { 
																var childData = dataSnapshot.val();
																var platoonSize = childData.data.platoonSize;
																console.log("gunnerysergeant-crud-service loadGS default platoonSize "
																				+ platoonSize);
																if (platoonSize > 0) {
																	gunnerySergeantGSList.push(childData);
																}
																console.log("gunnerysergeant-crud-service loadGS default gunnerySergeantGSList length "
																				+ gunnerySergeantGSList.length);
																self.gunnerySergeantGSListController.content = gunnerySergeantGSList;
																done(
																		gunnerySergeantGSList,
																		pageName,
																		gunnerySergeants);
															});
										} else {
											// e.g. gunnerysergeant-crud-service
											// load gunnerySergeantList length 2
											// gunnerysergeant-crud-service.js:64
											self.gunnerySergeantGSListController.content = gunnerySergeantGSList;
											// done();
											done(gunnerySergeantGSList,
													pageName, gunnerySergeants);
										}
									});
				}
			},

			/*
			 * "credentials" : { "city" : "LYNN", "augmentation" : { "spouse" :
			 * "Marsha" }, "state" : "MA", "handle" : "SteelDrum" } ,
			 * "credentials" : { "region" : { "state": "MA", "locale": { "city":
			 * "LYNN", "id": { "handle": "SteelDrum", "augmentation" :
			 * [{"spouse" : "Marsha" }] } } } }
			 */
			saveCredentials : {
				value : function(memberState, memberCity, memberHandle, memberAugmentation, done) {
					var aggregateDSN = "firebaseIO.com";
					var aggregateDB = "gunnerysergeant";
					var militia = "militia";
					var foundMember = false;
					var ref = null;
					// Create our Firebase reference
					var gunnerySergeantReferenceURL = "http://" + aggregateDB
					+ "." + aggregateDSN + "//" + militia;
					console.log("gunnerysergeant-crud-service save/update gunnerySergeantReferenceURL "
									+ gunnerySergeantReferenceURL);
					var gunnerySergeantListRef = new Firebase(
							gunnerySergeantReferenceURL);
					gunnerySergeantListRef.once(
									'value',
									function(dataSnapshot) {
										//console.log("gunnerysergeant-crud-service save/update dataSnapshot " + JSON.stringify(dataSnapshot));
										dataSnapshot.forEach(function(childSnapshot) { /*
																					 * handle
																					 * read
																					 * data.
																					 */
											//console.log("gunnerysergeant-crud-service save/update childSnapshot ref " + childSnapshot.ref());
											// e.g. gunnerysergeant-crud-service save/update childSnapshot ref https://gunnerysergeant.firebaseio.com/militia/militia 
											console.log("gunnerysergeant-crud-service save/update childSnapshot ref " + childSnapshot.ref());
													var childData = childSnapshot.val();
													//console.log("gunnerysergeant-crud-service save/update childData " + JSON.stringify(childData));
													var state = childData.credentials.region.state;
													console.log("gunnerysergeant-crud-service save/update state " + state);
													if (state == memberState) {
														var city = childData.credentials.region.locale.city;
														console.log("gunnerysergeant-crud-service save/update city " + city);
														if (city == memberCity) {
															var handle = childData.credentials.region.locale.id.handle;
															console.log("gunnerysergeant-crud-service save/update handle " + handle);
															if (handle == memberHandle) {
																foundMember = true;
																console.log("gunnerysergeant-crud-service save/update foundMember " + foundMember);
																ref = childSnapshot.ref();
															}
														}
													}
												});
										if (foundMember) {
											console.log("gunnerysergeant-crud-service save/update ref " + ref);
											// e.g. gunnerysergeant-crud-service
											// save/update ref
											// https://gunnerysergeant.firebaseio.com/militia/0
											// gunnerysergeant-crud-service.js:227
											//done(ref);
											// tjs 140709
											//done(ref, template, contactValidator);
											done(ref);
										} else {
											console.log("gunnerysergeant-crud-service save/update foundMember "
															+ foundMember);
											var newMember = generator
													.newMember(0, '', '', '',
															'', '', '', '', '',
															'', '', '', '', '',
															'', '', memberCity,
															memberState, '',
															'', '',
															memberHandle);
											ref = gunnerySergeantListRef.push(JSON.parse(newMember));
											done(ref);
										}
									});
				}
			},

			/*
			 * "credentials" : { "city" : "LYNN", "augmentation" : { "spouse" :
			 * "Marsha" }, "state" : "MA", "handle" : "SteelDrum" } ,
			 * "credentials" : { "region" : { "state": "MA", "locale": { "city":
			 * "LYNN", "id": { "handle": "SteelDrum", "augmentation" :
			 * [{"spouse" : "Marsha" }] } } } }
			 */
			findCredentialsByIndex : {
				value : function(index, self) {
					var aggregateDSN = "firebaseIO.com";
					var aggregateDB = "gunnerysergeant";
					var militia = "militia";
					var foundMember = false;
					var city, state, handle;
					// tjs 140715
					var self2 = this;
					
					var gunnerySergeantReferenceURL = "http://" + aggregateDB
							+ "." + aggregateDSN + "//" + militia + "//"
							+ index;
					console.log("gunnerysergeant-crud-service findCredentialsByIndex gunnerySergeantReferenceURL "
									+ gunnerySergeantReferenceURL);
					var gunnerySergeantRef = new Firebase(
							gunnerySergeantReferenceURL);
					gunnerySergeantRef.once(
									'value',
									function(dataSnapshot) {
										var childData = dataSnapshot.val();
										state = childData.credentials.region.state;
										console.log("gunnerysergeant-crud-service findCredentialsByIndex state "
														+ state);
										city = childData.credentials.region.locale.city;
										console.log("gunnerysergeant-crud-service findCredentialsByIndex city "
														+ city);
										handle = childData.credentials.region.locale.id.handle;
										console.log("gunnerysergeant-crud-service findCredentialsByIndex handle "
														+ handle);
										foundMember = true;
										console.log("gunnerysergeant-crud-service save/findCredentialsByIndex foundMember "
														+ foundMember);
										if (foundMember) {
											self.templateObjects.cityField.value = city;
											self.templateObjects.stateField.value = state;
											self.templateObjects.handleField.value = handle;
											
											// tjs 140709
											var contactInfo = childData.data.contactInfo;
											var email = contactInfo.email;
											var mmEmailInForm = self.templateObjects.mmEmailField.value;
											console.log("gunnerysergeant-crud-service save/findCredentialsByIndex mmEmailInForm " + mmEmailInForm);
											if (mmEmailInForm != null) {
												if (mmEmailInForm.length == 0) {
													console.log("gunnerysergeant-crud-service save/findCredentialsByIndex reset mmEmailInForm...");
													self.templateObjects.mmEmailField.value = email;
												} else {
													console.log("gunnerysergeant-crud-service save/findCredentialsByIndex using mmEmailInForm...");
												}
											} else {
												console.log("gunnerysergeant-crud-service save/findCredentialsByIndex set mmEmailInForm...");
												self.templateObjects.mmEmailField.value = email;
											}
											var phones = contactInfo.phones;
											//self.templateObjects.mmPhoneField.value = phones[0].number;
											var snailMail = contactInfo.snailMail;
											var name = snailMail.name;
											self.templateObjects.mmFirstNameField.value = name.first;
											self.templateObjects.mmLastNameField.value = name.last;
											var address = snailMail.address;
											self.templateObjects.mmStreet1Field.value = address.street1;
											self.templateObjects.mmStreet2Field.value = address.street2;
										
											// tjs 140715
											self2.findFirstBackupContactInfoByIndex(index, self.templateObjects);
										}										
									});
					}
			},
			savePrivateContactInfo : {
					value : function(index, mmMobilePhoneField, mmPhoneField, mmEmailField, mmFirstNameField, mmLastNameField, mmStreet1Field, mmStreet2Field, template, contactValidator) {
						console.log("gunnerysergeant-crud-service savePrivateContactInfo mmPhoneField "
								+ mmPhoneField + " mmEmailField " + mmEmailField + " mmFirstNameField " + mmFirstNameField + " mmLastNameField " + mmLastNameField + " mmStreet1Field " + mmStreet1Field + " mmStreet2Field " + mmStreet2Field);
						var aggregateDSN = "firebaseIO.com";
						var aggregateDB = "gunnerysergeant";
						var militia = "militia";
						var foundMember = false;
						var firstItem;
						var emails;
						var phones;
						var snailMail;
						var address;
						var name;
						var newEmail = mmEmailField;
						var self = this;

						var gunnerySergeantReferenceURL = "http://" + aggregateDB
								+ "." + aggregateDSN + "//" + militia + "//"
								+ index + "//data//contactInfo//";
						console.log("gunnerysergeant-crud-service savePrivateContactInfo gunnerySergeantReferenceURL "
										+ gunnerySergeantReferenceURL);
						var gunnerySergeantContactInfoRef = new Firebase(
								gunnerySergeantReferenceURL);
						gunnerySergeantContactInfoRef.child('email').set(mmEmailField);
						gunnerySergeantContactInfoRef.child('phones').child('mobile').set(mmMobilePhoneField);
						gunnerySergeantContactInfoRef.child('phones').child('landline').set(mmPhoneField);
						gunnerySergeantContactInfoRef.child('snailMail').child('name').child('first').set(mmFirstNameField);
						gunnerySergeantContactInfoRef.child('snailMail').child('name').child('last').set(mmLastNameField);
						gunnerySergeantContactInfoRef.child('snailMail').child('address').child('street1').set(mmStreet1Field);
						gunnerySergeantContactInfoRef.child('snailMail').child('address').child('street2').set(mmStreet2Field);
						self.findContactInfoByIndex(index, template, contactValidator);

				}
			},
			findContactInfoByIndex : {
				value : function(index, template, done) {
					var aggregateDSN = "firebaseIO.com";
					var aggregateDB = "gunnerysergeant";
					var militia = "militia";
					var foundMember = false;
					var firstItem;
					var email;
					var phones;
					var snailMail;
					var gunnerySergeantReferenceURL = "http://" + aggregateDB
							+ "." + aggregateDSN + "//" + militia + "//"
							+ index + "//data//contactInfo//";
					console.log("gunnerysergeant-crud-service findContactInfoByIndex gunnerySergeantReferenceURL "
									+ gunnerySergeantReferenceURL);
					var gunnerySergeantRef = new Firebase(
							gunnerySergeantReferenceURL);
					gunnerySergeantRef.once(
									'value',
									function(dataSnapshot) {
										var contactInfo = dataSnapshot.val();
										email = contactInfo.email;
										phones = contactInfo.phones;
										snailMail = contactInfo.snailMail;
										console.log("gunnerysergeant-crud-service findContactInfoByIndex validating...");
										done(template, email, phones, snailMail, false);
									});
				}
			},
			savePrivateBackupContactInfo : {
					value : function(index, buMobilePhoneField, buPhoneField, buEmailField, buFirstNameField, buLastNameField, buStreet1Field, buStreet2Field, template, contactValidator) {
						console.log("gunnerysergeant-crud-service savePrivateBackupContactInfo buPhoneField "
								+ buPhoneField + " buEmailField " + buEmailField + " buFirstNameField " + buFirstNameField + " buLastNameField " + buLastNameField + " buStreet1Field " + buStreet1Field + " buStreet2Field " + buStreet2Field);
						var aggregateDSN = "firebaseIO.com";
						var aggregateDB = "gunnerysergeant";
						var militia = "militia";
						var foundMember = false;
						var firstItem;
						var emails;
						var phones;
						var snailMail;
						var address;
						var name;
						var newEmail = buEmailField;
						var self = this;

						var gunnerySergeantReferenceURL = "http://" + aggregateDB
								+ "." + aggregateDSN + "//" + militia + "//"
													+ index + "//data//backups";
						console.log("gunnerysergeant-crud-service savePrivateBackupContactInfo gunnerySergeantReferenceURL "
										+ gunnerySergeantReferenceURL);
						var gunnerySergeantBackupsRef = new Firebase(
								gunnerySergeantReferenceURL);
						gunnerySergeantBackupsRef.once(
								'value',
								function(dataSnapshot) {
									//console.log("gunnerysergeant-crud-service savePrivateContactInfo backupIndex "
									//		+ backupIndex);
									dataSnapshot.forEach(function(childSnapshot) {
										//var gunnerySergeantIndexedBackupReferenceURL = childSnapshot.ref();
										var gunnerySergeantIndexedBackupReferenceURL = childSnapshot.ref().toString();
										console.log("gunnerysergeant-crud-service savePrivateBackupContactInfo gunnerySergeantIndexedBackupReferenceURL "
												+ gunnerySergeantIndexedBackupReferenceURL);
										var n = gunnerySergeantIndexedBackupReferenceURL.lastIndexOf("/");
										var backupIndex = gunnerySergeantIndexedBackupReferenceURL.substr(++n);
										console.log("gunnerysergeant-crud-service savePrivateBackupContactInfo backupIndex "
												+ backupIndex);
										// e.g. gunnerysergeant-crud-service savePrivateBackupContactInfo ref https://gunnerysergeant.firebaseio.com/militia/-JRuBF6TJScJTIcngM4E/data/backups/0 gunnerysergeant-crud-service.js:473
										// e.g. https://gunnerysergeant.firebaseio.com/militia/-JRuBF6TJScJTIcngM4E/data/backups/0
										var gunnerySergeantIndexedBackupRef = new Firebase(
												gunnerySergeantIndexedBackupReferenceURL);
										gunnerySergeantIndexedBackupRef.child('contactInfo').child('email').set(buEmailField);
										gunnerySergeantIndexedBackupRef.child('contactInfo').child('phones').child('mobile').set(buMobilePhoneField);
										gunnerySergeantIndexedBackupRef.child('contactInfo').child('phones').child('landline').set(buPhoneField);
										gunnerySergeantIndexedBackupRef.child('contactInfo').child('snailMail').child('name').child('first').set(buFirstNameField);
										gunnerySergeantIndexedBackupRef.child('contactInfo').child('snailMail').child('name').child('last').set(buLastNameField);
										gunnerySergeantIndexedBackupRef.child('contactInfo').child('snailMail').child('address').child('street1').set(buStreet1Field);
										gunnerySergeantIndexedBackupRef.child('contactInfo').child('snailMail').child('address').child('street2').set(buStreet2Field);
										self.findBackupContactInfoByIndex(index, backupIndex, template, contactValidator);
										return true; // stop loop
									});
								});
				}
			},
			findBackupContactInfoByIndex : {
				value : function(index, backupIndex, template, done) {
					var aggregateDSN = "firebaseIO.com";
					var aggregateDB = "gunnerysergeant";
					var militia = "militia";
					var foundMember = false;
					var firstItem;
					var email;
					var phones;
					var snailMail;
					var gunnerySergeantReferenceURL = "http://" + aggregateDB
							+ "." + aggregateDSN + "//" + militia + "//"
							+ index + "//data//backups//" + backupIndex;
					console.log("gunnerysergeant-crud-service findBackupContactInfoByIndex gunnerySergeantReferenceURL "
									+ gunnerySergeantReferenceURL);
					var gunnerySergeantRef = new Firebase(
							gunnerySergeantReferenceURL);
					gunnerySergeantRef.once(
									'value',
									function(dataSnapshot) {
										var obj = dataSnapshot.val();
										console.log("gunnerysergeant-crud-service findBackupContactInfoByIndex contactInfo "
												+ JSON.stringify(obj));
										email = obj.contactInfo.email;
										console.log("gunnerysergeant-crud-service findBackupContactInfoByIndex email "
												+ email);
										phones = obj.contactInfo.phones;
										snailMail = obj.contactInfo.snailMail;
										console.log("gunnerysergeant-crud-service findBackupContactInfoByIndex validating...");
										done(template, email, phones, snailMail, true);									
									});
				}
			},
			findFirstBackupContactInfoByIndex : {
				value : function(index, template) {
					var aggregateDSN = "firebaseIO.com";
					var aggregateDB = "gunnerysergeant";
					var militia = "militia";

					var gunnerySergeantReferenceURL = "http://" + aggregateDB
							+ "." + aggregateDSN + "//" + militia + "//"
												+ index + "//data//backups";
					console.log("gunnerysergeant-crud-service findFirstBackupContactInfoByIndex gunnerySergeantReferenceURL "
									+ gunnerySergeantReferenceURL);
					var gunnerySergeantBackupsRef = new Firebase(
							gunnerySergeantReferenceURL);
					gunnerySergeantBackupsRef.once(
							'value',
							function(dataSnapshot) {
								dataSnapshot.forEach(function(childSnapshot) {
									var gunnerySergeantIndexedBackupReferenceURL = childSnapshot.ref().toString();
									console.log("gunnerysergeant-crud-service findFirstBackupContactInfoByIndex gunnerySergeantIndexedBackupReferenceURL "
											+ gunnerySergeantIndexedBackupReferenceURL);
									// e.g. gunnerysergeant-crud-service savePrivateBackupContactInfo ref https://gunnerysergeant.firebaseio.com/militia/-JRuBF6TJScJTIcngM4E/data/backups/0 gunnerysergeant-crud-service.js:473
									// e.g. https://gunnerysergeant.firebaseio.com/militia/-JRuBF6TJScJTIcngM4E/data/backups/0
									var gunnerySergeantIndexedBackupRef = new Firebase(
											gunnerySergeantIndexedBackupReferenceURL);
									gunnerySergeantIndexedBackupRef.child('contactInfo').child('email').once(
											'value',
												function(dataSnapshot2) {
													var email = dataSnapshot2.val();
													console.log("gunnerysergeant-crud-service findFirstBackupContactInfoByIndex email "
															+ email);
													template.mmBackupEmailField.value = email;
												});
									gunnerySergeantIndexedBackupRef.child('contactInfo').child('phones').child('mobile').once(
											'value',
												function(dataSnapshot2) {
													var mobile = dataSnapshot2.val();
													console.log("gunnerysergeant-crud-service findFirstBackupContactInfoByIndex mobile "
															+ mobile);
													template.mmBackupMobilePhoneField.value = mobile;
												});
									gunnerySergeantIndexedBackupRef.child('contactInfo').child('phones').child('landline').once(
											'value',
												function(dataSnapshot2) {
													var landline = dataSnapshot2.val();
													console.log("gunnerysergeant-crud-service findFirstBackupContactInfoByIndex landline "
															+ landline);
													template.mmBackupPhoneField.value = landline;
												});
									gunnerySergeantIndexedBackupRef.child('contactInfo').child('snailMail').child('name').child('first').once(
											'value',
												function(dataSnapshot2) {
													var first = dataSnapshot2.val();
													console.log("gunnerysergeant-crud-service findFirstBackupContactInfoByIndex first "
															+ first);
													template.mmBackupFirstNameField.value = first;
												});
									gunnerySergeantIndexedBackupRef.child('contactInfo').child('snailMail').child('name').child('last').once(
											'value',
												function(dataSnapshot2) {
													var last = dataSnapshot2.val();
													console.log("gunnerysergeant-crud-service findFirstBackupContactInfoByIndex last "
															+ last);
													template.mmBackupLastNameField.value = last;
												});
									gunnerySergeantIndexedBackupRef.child('contactInfo').child('snailMail').child('address').child('street1').once(
											'value',
												function(dataSnapshot2) {
													var street1 = dataSnapshot2.val();
													console.log("gunnerysergeant-crud-service findFirstBackupContactInfoByIndex street1 "
															+ street1);
													template.mmBackupStreet1Field.value = street1;
												});
									gunnerySergeantIndexedBackupRef.child('contactInfo').child('snailMail').child('address').child('street2').once(
											'value',
												function(dataSnapshot2) {
													var street2 = dataSnapshot2.val();
													console.log("gunnerysergeant-crud-service findFirstBackupContactInfoByIndex street2 "
															+ street2);
													template.mmBackupStreet2Field.value = street2;
												});
									return true; // stop loop
								});
							});
				}
			},

			postPrivateGSEmail : {
				value : function(gunnerySergeantEmail) {
					var aggregateDSN = "firebaseIO.com";
					var aggregateDB = "gunnerysergeant";
					var militia = "militia";
					// Create our Firebase reference
					var gunnerySergeantPrivateReferenceURL = "http://"
							+ aggregateDB + "." + aggregateDSN + "//" + militia + "//" + currentMilitiaMemberLocalStorageRef + "//data";
					console
							.log("gunnerysergeant-crud-service postPrivateGSEmail "
									+ gunnerySergeantPrivateReferenceURL);
					var gunnerySergeantPrivateRef = new Firebase(
							gunnerySergeantPrivateReferenceURL);
					
					gunnerySergeantPrivateRef.child('gunnerySergeantEmail').set(gunnerySergeantEmail);
				}
			},

			postPrivateGun : {
				value : function(dateField, type, model, serialNumber, name, description) {
					var aggregateDSN = "firebaseIO.com";
					var aggregateDB = "gunnerysergeant";
					var militia = "militia";
					// Create our Firebase reference
					var gunnerySergeantPrivateReferenceURL = "http://"
							+ aggregateDB + "." + aggregateDSN + "//" + militia + "//" + currentMilitiaMemberLocalStorageRef + "//data//guns//";
					console.log("gunnerysergeant-crud-service postPrivateGun "
									+ gunnerySergeantPrivateReferenceURL);
					var gunnerySergeantPrivateRef = new Firebase(
							gunnerySergeantPrivateReferenceURL);
					
					var gun = '{"dateAcquired": "' + dateField + '"'
						+ ', "type": "' + type + '"'
						+ ', "model": "' + model + '"'
						+ ', "serialNumber": "' + serialNumber + '"'
						+ ', "name": "' + name + '"'
						+ ', "description": "' + description + '"}';
				console.log("gunnerysergeant-crud-service postPrivateGun gun "
								+ gun);
				var gunObj = JSON
						.parse(gun);
				gunnerySergeantPrivateRef
						.push(gunObj);

					//gunnerySergeantPrivateRef.child('gunnerySergeantEmail').set(gunnerySergeantEmail);
				}
			},

			save : {
				value : function() {
					var aggregateDSN = "firebaseIO.com";
					var aggregateDB = "gunnerysergeant";
					var militia = "militia";
					// Create our Firebase reference
					var gunnerySergeantListReferenceURL = "http://"
							+ aggregateDB + "." + aggregateDSN + "//" + militia;
					console.log("gunnerysergeant-crud-service save gunnerySergeantList "
									+ gunnerySergeantListReferenceURL);
					var gunnerySergeantListRef = new Firebase(
							gunnerySergeantListReferenceURL);
					var members = this.gunnerySergeantListController.content;

					for ( var i = 0, len = members.length; i < len; i++) {
						var member = members[i];
						console.log("gunnerysergeant-crud-service save handle "
								+ member.credentials.handle);
						var gunnerySergeantListRef = gunnerySergeantList
								.child(member.credentials.handle);

						// Use setWithPriority to put the name / score in
						// Firebase, and set the priority to be the score.
						// gunnerySergeantListRef.setWithPriority({
						// title:todo.title, completed:todo.completed,
						// priority:todo.priority }, todo.priority);
					}
				}
			}

		});

exports.shared = new exports.GunnerySergeantCrudService();