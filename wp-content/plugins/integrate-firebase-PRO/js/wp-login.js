!function(e,i){if("object"==typeof exports&&"object"==typeof module)module.exports=i();else if("function"==typeof define&&define.amd)define([],i);else{var o,r=i();for(o in r)("object"==typeof exports?exports:e)[o]=r[o]}}(this,function(){return(()=>{"use strict";var o={9639:(e,i)=>{var o;Object.defineProperty(i,"__esModule",{value:!0}),i.envDashboard=i.envFrontend=void 0,i.envFrontend={firebaseOptions:{apiKey:null===(o=window.firebaseOptions)||void 0===o?void 0:o.apiKey,authDomain:null===(o=window.firebaseOptions)||void 0===o?void 0:o.authDomain,databaseURL:null===(o=window.firebaseOptions)||void 0===o?void 0:o.databaseURL,storageBucket:null===(o=window.firebaseOptions)||void 0===o?void 0:o.storageBucket,appId:null===(o=window.firebaseOptions)||void 0===o?void 0:o.appId,measurementId:null===(o=window.firebaseOptions)||void 0===o?void 0:o.measurementId,projectId:null===(o=window.firebaseOptions)||void 0===o?void 0:o.projectId,services:null===(o=window.firebaseOptions)||void 0===o?void 0:o.services,language:null===(o=window.firebaseOptions)||void 0===o?void 0:o.language,messagingSenderId:null===(o=window.firebaseOptions)||void 0===o?void 0:o.messagingSenderId,proScript:null===(o=window.firebaseOptions)||void 0===o?void 0:o.proScript},firebaseSettings:{apiToken:null===(o=window.firebaseSettings)||void 0===o?void 0:o.frontendApiToken,baseDomain:null===(o=window.firebaseSettings)||void 0===o?void 0:o.baseDomain},authSettings:window.authSettings?{loginWithFirebase:null===(o=window.authSettings)||void 0===o?void 0:o.loginWithFirebase,loginUrl:null===(o=window.authSettings)||void 0===o?void 0:o.loginUrl,signinWithEmailLink:null===(o=window.authSettings)||void 0===o?void 0:o.signinWithEmailLink,googleClientId:null===(o=window.authSettings)||void 0===o?void 0:o.googleClientId,signInSuccessUrl:null===(o=window.authSettings)||void 0===o?void 0:o.signInSuccessUrl,signInOptions:null===(o=window.authSettings)||void 0===o?void 0:o.signInOptions,tosUrl:null===(o=window.authSettings)||void 0===o?void 0:o.tosUrl,privacyPolicyUrl:null===(o=window.authSettings)||void 0===o?void 0:o.privacyPolicyUrl,isWordfenceActive:null===(o=window.authSettings)||void 0===o?void 0:o.isWordfenceActive}:null,firebaseWordPress:{siteUrl:window.firebaseWordpress?null===(o=window.firebaseWordpress)||void 0===o?void 0:o.siteUrl:null,firebaseLoginKey:window.firebaseWordpress?null===(o=window.firebaseWordpress)||void 0===o?void 0:o.firebaseLoginKey:null,userCollectionName:window.firebaseWordpress?null===(o=window.firebaseWordpress)||void 0===o?void 0:o.userCollectionName:null,firebaseDatabaseType:window.firebaseWordpress?null===(o=window.firebaseWordpress)||void 0===o?void 0:o.firebaseDatabaseType:null,isUserLoggedIn:window.firebaseWordpress?null===(o=window.firebaseWordpress)||void 0===o?void 0:o.isUserLoggedIn:null,wpLogoutLink:window.firebaseWordpress?null===(o=window.firebaseWordpress)||void 0===o?void 0:o.wpLogoutLink:null},firebaseMessages:{publicKey:null===(o=window.firebaseMessages)||void 0===o?void 0:o.publicKey}},i.envDashboard={firebaseSettings:{apiToken:null===(o=window.firebaseSettings)||void 0===o?void 0:o.dashboardApiToken,baseDomain:null===(i=window.firebaseSettings)||void 0===i?void 0:i.baseDomain},IFPROVersion:null===(o=window.firebaseSettings)||void 0===o?void 0:o.IFPROVersion,plugin:{endpoint:"https://techcater.com"}}},7876:function(e,i,o){var r=this&&this.__createBinding||(Object.create?function(e,i,o,r){void 0===r&&(r=o),Object.defineProperty(e,r,{enumerable:!0,get:function(){return i[o]}})}:function(e,i,o,r){e[r=void 0===r?o:r]=i[o]}),n=this&&this.__exportStar||function(e,i){for(var o in e)"default"===o||Object.prototype.hasOwnProperty.call(i,o)||r(i,e,o)};Object.defineProperty(i,"__esModule",{value:!0}),n(o(9639),i),n(o(7543),i)},7543:(e,i)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.ifpTranslations=void 0,i.ifpTranslations=window.firebaseTranslations},9708:(e,r,i)=>{Object.defineProperty(r,"__esModule",{value:!0}),r.isExistingUserAndNotVerified=r.isNewUserAndNotVerified=r.showSingleSignOn=r.hideSingleSignOn=r.registerAndAutoLogin=r.generateUserDataForAutoLogin=r.signOutAndReload=r.signOutWithErrorMessage=r.isUserLoggedIn=void 0;const n=i(7876),a=i(5552);r.isUserLoggedIn=()=>new Promise((i,e)=>firebase.auth().onAuthStateChanged(function(e){i(!!e)})),r.signOutWithErrorMessage=e=>{firebase.auth().signOut().then(()=>{e&&console.error(e)})},r.signOutAndReload=()=>{firebase.auth().signOut().then(()=>location.reload())},r.generateUserDataForAutoLogin=(e,i=null,o=[])=>{let r=["email","userId","firstName","lastName","displayName","photoURL","phoneNumber"];0<o.length&&(r=[...new Set([...r,...o])]);const n={userId:e.uid,password:i};i=e.lastLoginAt||(null===(o=e.metadata)||void 0===o?void 0:o.lastLoginAt);i&&(n.lastLoginAt=Math.floor(i/1e3));for(const s of r){var t=e[s]||(null===(t=e.providerData)||void 0===t?void 0:t[0][s]);(0,a.isEmpty)(t)||(n[s]=t)}return e.firstName&&e.lastName&&(n.displayName=e.firstName+" "+e.lastName),e.displayName&&(0,a.isEmpty)(e.firstName)&&(o=e.displayName.split(" "),n.firstName=o[0],(0,a.isEmpty)(e.lastName)&&1<o.length&&(n.lastName=o[1])),n},r.registerAndAutoLogin=(e,o=null,i="wordpress")=>{(0,a.showLoader)(),jQuery.ajax({url:n.envFrontend.firebaseWordPress.siteUrl+"/wp-json/firebase/v2/users/register-autologin",type:"POST",contentType:"application/json",headers:{"firebase-login-key":n.envFrontend.firebaseWordPress.firebaseLoginKey,"auth-source":i},dataType:"json",data:JSON.stringify({user:e}),success:function(e){200===e.code?null!=o?location.href=o:n.envFrontend.authSettings.signInSuccessUrl?location.href=n.envFrontend.authSettings.signInSuccessUrl:location.reload():((0,a.showFirebaseErrorMessage)("[Firebase] Error -> "+e.message),(0,r.signOutWithErrorMessage)("[Firebase] Error -> User logged out...")),(0,a.hideLoader)()},error:function(e){var i;console.error(e),200===e.code?null!=o?location.href=o:n.envFrontend.authSettings.signInSuccessUrl?location.href=n.envFrontend.authSettings.signInSuccessUrl:location.reload():((0,r.signOutWithErrorMessage)("[Firebase] Error -> User logged out..."),e&&e.message?(0,a.showFirebaseErrorMessage)("[Firebase] - "+e.message):e&&null!==(i=e.responseJSON)&&void 0!==i&&i.message?(0,a.showFirebaseErrorMessage)("[Firebase] - "+e.responseJSON.message):(0,a.showFirebaseErrorMessage)("[Firebase] Authentication Error")),(0,a.hideLoader)()}})},r.hideSingleSignOn=()=>{(0,a.waitForElementToExist)("#credential_picker_container").then(e=>{console.log("[Firebase - logged in] - Single Sign On appears..."),jQuery("#credential_picker_container").remove()})},r.showSingleSignOn=()=>{(0,a.waitForElementToExist)("#credential_picker_container").then(e=>{console.log("[Firebase - logged out] - Single Sign On appears..."),jQuery("#credential_picker_container").show()})},r.isNewUserAndNotVerified=e=>e.additionalUserInfo.isNewUser&&"password"===e.additionalUserInfo.providerId&&!0!==e.user.emailVerified;r.isExistingUserAndNotVerified=e=>!e.additionalUserInfo.isNewUser&&"password"===e.additionalUserInfo.providerId&&!0!==e.user.emailVerified},5716:(e,i,o)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.showFirebaseErrorMessage=void 0;const r=o(5552);i.showFirebaseErrorMessage=(e="")=>{(0,r.isEmpty)(e)?jQuery("#firebase-error").hide():(console.error(e),jQuery("#firebase-error").show(),jQuery("#firebase-error").text(e))}},7290:(e,i,o)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.generateFormData=void 0;const r=o(7876),n=o(5716),t=o(8511);i.generateFormData=e=>{if((0,t.isEmpty)(e))return(0,n.showFirebaseErrorMessage)(r.ifpTranslations.utils.invalidForm),null;{const i={};for(const o of e)i[o.name]=o.value;return i}}},5552:function(e,i,o){var r=this&&this.__createBinding||(Object.create?function(e,i,o,r){void 0===r&&(r=o),Object.defineProperty(e,r,{enumerable:!0,get:function(){return i[o]}})}:function(e,i,o,r){e[r=void 0===r?o:r]=i[o]}),n=this&&this.__exportStar||function(e,i){for(var o in e)"default"===o||Object.prototype.hasOwnProperty.call(i,o)||r(i,e,o)};Object.defineProperty(i,"__esModule",{value:!0}),n(o(9708),i),n(o(5716),i),n(o(7290),i),n(o(1906),i),n(o(9830),i),n(o(8511),i)},1906:(e,i)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.decrypt=i.encrypt=void 0;i.encrypt=(e,i)=>{const o=e=>e.split("").map(e=>e.charCodeAt(0));return e.split("").map(o).map(e=>o(i).reduce((e,i)=>e^i,e)).map(e=>("0"+Number(e).toString(16)).slice(-2)).join("")};i.decrypt=(e,i)=>{return null==e?void 0:e.match(/.{1,2}/g).map(e=>parseInt(e,16)).map(e=>(e=>e.split("").map(e=>e.charCodeAt(0)))(i).reduce((e,i)=>e^i,e)).map(e=>String.fromCharCode(e)).join("")}},9830:(e,i)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.showLoader=i.hideLoader=i.createHtmlLoader=void 0;i.createHtmlLoader=()=>{jQuery("body").append('<div id="firebase-loader"></div>')},i.hideLoader=()=>{jQuery("#firebase-loader").fadeOut("slow")};i.showLoader=()=>{jQuery("#firebase-loader").fadeIn("slow")}},8511:function(e,i){var r=this&&this.__awaiter||function(e,s,a,d){return new(a=a||Promise)(function(o,i){function r(e){try{t(d.next(e))}catch(e){i(e)}}function n(e){try{t(d.throw(e))}catch(e){i(e)}}function t(e){var i;e.done?o(e.value):((i=e.value)instanceof a?i:new a(function(e){e(i)})).then(r,n)}t((d=d.apply(e,s||[])).next())})};Object.defineProperty(i,"__esModule",{value:!0}),i.loadStylesOnce=i.loadScriptOnce=i.getURLQueryParam=i.isEmpty=i.navigateTo=i.waitForElementToExist=void 0,i.waitForElementToExist=(n,t=10)=>r(void 0,void 0,void 0,function*(){return new Promise((e,i)=>{let o=0;const r=setInterval(function(){jQuery(n).length?(clearInterval(r),e(!0)):!jQuery(n).length&&o>t?(clearInterval(r),i(!1)):o++},1e3)})}),i.navigateTo=e=>{window.location.href=e},i.isEmpty=e=>null==e||e.hasOwnProperty("length")&&0===e.length||e.constructor===Object&&0===Object.keys(e).length;i.getURLQueryParam=e=>{const i=new URLSearchParams(window.location.search);return i.get(e)};i.loadScriptOnce=(()=>{const o=[];return(e,i)=>r(void 0,void 0,void 0,function*(){return o.includes(e)||(o.push(e),r=e,n=i,yield new Promise((e,i)=>{if(!document.getElementById(n)&&null!=r){const o=document.createElement("script");o.src=r,o.id=n,o.async=!0,o.onload=e,o.onerror=i,document.head.appendChild(o)}})),!0;var r,n})})();i.loadStylesOnce=(()=>{let i=[];return e=>r(void 0,void 0,void 0,function*(){return i.includes(e)||(i=[e],r=e,yield new Promise((e,i)=>{const o=document.createElement("link");o.rel="stylesheet",o.href=r,o.onload=e,o.onerror=i,document.head.appendChild(o)})),!0;var r})})()},439:function(e,i,o){var r=this&&this.__createBinding||(Object.create?function(e,i,o,r){void 0===r&&(r=o),Object.defineProperty(e,r,{enumerable:!0,get:function(){return i[o]}})}:function(e,i,o,r){e[r=void 0===r?o:r]=i[o]}),n=this&&this.__exportStar||function(e,i){for(var o in e)"default"===o||Object.prototype.hasOwnProperty.call(i,o)||r(i,e,o)};Object.defineProperty(i,"__esModule",{value:!0}),n(o(4723),i),n(o(5410),i),n(o(1893),i)},4723:(e,i)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.FirebaseStorage=void 0,(i=i.FirebaseStorage||(i.FirebaseStorage={})).Firebase2FASecret="FIREBASE_2FA_SECRET",i.FirebaseUID="FIREBASE_UID"},5410:(e,i)=>{Object.defineProperty(i,"__esModule",{value:!0})},1893:(e,i)=>{Object.defineProperty(i,"__esModule",{value:!0})}},r={};function n(e){var i=r[e];if(void 0!==i)return i.exports;i=r[e]={exports:{}};return o[e].call(i.exports,i,i.exports,n),i.exports}var e={};{Object.defineProperty(e,"__esModule",{value:!0});const a=n(5552),d=n(439);document.addEventListener("DOMContentLoaded",()=>{const e=document.getElementById("loginform");if(e){const n=e.getAttribute("action");-1<n.indexOf("?")?e.setAttribute("action",n+"&debug=true"):e.setAttribute("action",n+"?debug=true");var i,o=(0,a.getURLQueryParam)("secret"),r=window.localStorage.getItem(d.FirebaseStorage.Firebase2FASecret),r=o&&(0,a.decrypt)(r,o),{email:o,password:r}=JSON.parse(r||"{}");if(o&&r){window.localStorage.removeItem(d.FirebaseStorage.Firebase2FASecret);const t=document.getElementById("user_login"),s=document.getElementById("user_pass");t&&s&&(t.value=o,s.value=r,i="https://"+location.hostname,fetch(i+"/wp-admin/admin-ajax.php",{headers:{accept:"application/json, text/javascript, */*; q=0.01","accept-language":"en-US,en;q=0.9","cache-control":"no-cache","content-type":"application/x-www-form-urlencoded; charset=UTF-8",pragma:"no-cache","sec-ch-ua":'" Not A;Brand";v="99", "Chromium";v="100", "Google Chrome";v="100"',"sec-ch-ua-mobile":"?0","sec-fetch-dest":"empty","sec-fetch-mode":"cors","sec-fetch-site":"same-origin","x-requested-with":"XMLHttpRequest"},referrerPolicy:"strict-origin-when-cross-origin",body:`log=${o}&wfls-email-verification=&pwd=${r}&redirect_to=${i}/wp-admin&testcookie=1&action=wordfence_ls_authenticate`,method:"POST",mode:"cors",credentials:"include"}).then(e=>{document.getElementById("wp-submit").click()}).catch(e=>console.error(e)))}}})}return e})()});