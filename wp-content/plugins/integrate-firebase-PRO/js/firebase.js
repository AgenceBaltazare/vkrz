!function (e, i) { if ("object" == typeof exports && "object" == typeof module) module.exports = i(); else if ("function" == typeof define && define.amd) define([], i); else { var t, r = i(); for (t in r) ("object" == typeof exports ? exports : e)[t] = r[t] } }(this, function () { return (() => { "use strict"; var t = { 1095: (e, i, t) => { t.d(i, { Z: () => r }); i = t(4325), t = t.n(i)()(function (e) { return e[1] }); t.push([e.id, "#firebase-loader{display:none;position:fixed;left:0px;top:0px;width:100%;height:100%;z-index:9999;background:url(https://cdn.techcater.com/images/loading-icon.jpg) center no-repeat rgba(255,255,255,0.5)}#firebase-error,.firebase-error{color:red}.firebase-show-with-claims{display:none}#firebase-signout,#firebaseui-auth-container{display:none}#firebase-login__submit,#firebase-login-form__submit{margin-top:20px}#firebase-login__forgot-password,#firebase-login-form__forgot-password{margin-left:20px}#firebase-login__error,#firebase-login-form__error{font-style:italic;color:red}#firebase-register-form #firebase-register-form__submit{margin-top:20px}#firebase-register-form__error{font-style:italic;color:red}firebase-auth,firebase-login,firebase-register,firebase-forgot-password{max-width:500px;margin:0 auto;display:block}firebase-auth input,firebase-login input,firebase-register input,firebase-forgot-password input{width:100%}firebase-forgot-password button,#firebase-forgot-password button{margin:20px 0}firebase-auth .firebaseui-idp-list{display:flex;justify-content:center;gap:2rem}firebase-auth .firebaseui-idp-list .firebaseui-idp-text.firebaseui-idp-text-long{display:none}firebase-auth .firebaseui-idp-list .firebaseui-idp-icon-wrapper{display:block;text-align:center}#if-realime-collection-table th,#if-firestore-collection-table th{text-transform:capitalize}.text-center{text-align:center}\n", ""]); const r = t }, 4325: e => { e.exports = function (t) { var d = []; return d.toString = function () { return this.map(function (e) { var i = t(e); return e[2] ? "@media ".concat(e[2], " {").concat(i, "}") : i }).join("") }, d.i = function (e, i, t) { "string" == typeof e && (e = [[null, e, ""]]); var r = {}; if (t) for (var n = 0; n < this.length; n++) { var o = this[n][0]; null != o && (r[o] = !0) } for (var s = 0; s < e.length; s++) { var a = [].concat(e[s]); t && r[a[0]] || (i && (a[2] ? a[2] = "".concat(i, " and ").concat(a[2]) : a[2] = i), d.push(a)) } }, d } }, 5871: (e, i, t) => { t.r(i), t.d(i, { default: () => n }); var i = t(9790), i = t.n(i), t = t(1095), r = { insert: "head", singleton: !1 }; i()(t.Z, r); const n = t.Z.locals || {} }, 9790: (e, n, o) => { var i, t, d = function () { return i = void 0 === i ? Boolean(window && document && document.all && !window.atob) : i }, s = (t = {}, function (e) { if (void 0 === t[e]) { var i = document.querySelector(e); if (window.HTMLIFrameElement && i instanceof window.HTMLIFrameElement) try { i = i.contentDocument.head } catch (e) { i = null } t[e] = i } return t[e] }), l = []; function c(e) { for (var i = -1, t = 0; t < l.length; t++)if (l[t].identifier === e) { i = t; break } return i } function a(e, i) { for (var t = {}, r = [], n = 0; n < e.length; n++) { var o = e[n], s = i.base ? o[0] + i.base : o[0], a = t[s] || 0, d = "".concat(s, " ").concat(a), s = (t[s] = a + 1, c(d)), a = { css: o[1], media: o[2], sourceMap: o[3] }; -1 !== s ? (l[s].references++, l[s].updater(a)) : l.push({ identifier: d, updater: function (i, e) { var t, r, n; { var o; n = e.singleton ? (o = b++, t = p = p || u(e), r = f.bind(null, t, o, !1), f.bind(null, t, o, !0)) : (t = u(e), r = function (e, i, t) { var r = t.css, n = t.media, t = t.sourceMap; n ? e.setAttribute("media", n) : e.removeAttribute("media"); t && "undefined" != typeof btoa && (r += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(t)))), " */")); if (e.styleSheet) e.styleSheet.cssText = r; else { for (; e.firstChild;)e.removeChild(e.firstChild); e.appendChild(document.createTextNode(r)) } }.bind(null, t, e), function () { var e = t; null !== e.parentNode && e.parentNode.removeChild(e) }) } return r(i), function (e) { e ? e.css === i.css && e.media === i.media && e.sourceMap === i.sourceMap || r(i = e) : n() } }(a, i), references: 1 }), r.push(d) } return r } function u(e) { var i = document.createElement("style"), t = e.attributes || {}; if (void 0 !== t.nonce || (r = o.nc) && (t.nonce = r), Object.keys(t).forEach(function (e) { i.setAttribute(e, t[e]) }), "function" == typeof e.insert) e.insert(i); else { var r = s(e.insert || "head"); if (!r) throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid."); r.appendChild(i) } return i } r = []; var r, g = function (e, i) { return r[e] = i, r.filter(Boolean).join("\n") }; function f(e, i, t, r) { var t = t ? "" : r.media ? "@media ".concat(r.media, " {").concat(r.css, "}") : r.css; e.styleSheet ? e.styleSheet.cssText = g(i, t) : (r = document.createTextNode(t), (t = e.childNodes)[i] && e.removeChild(t[i]), t.length ? e.insertBefore(r, t[i]) : e.appendChild(r)) } var p = null, b = 0; e.exports = function (e, o) { (o = o || {}).singleton || "boolean" == typeof o.singleton || (o.singleton = d()); var s = a(e = e || [], o); return function (e) { if (e = e || [], "[object Array]" === Object.prototype.toString.call(e)) { for (var i = 0; i < s.length; i++) { var t = c(s[i]); l[t].references-- } for (var e = a(e, o), r = 0; r < s.length; r++) { var n = c(s[r]); 0 === l[n].references && (l[n].updater(), l.splice(n, 1)) } s = e } } } }, 2680: function (e, i, t) { var r = this && this.__awaiter || function (e, s, a, d) { return new (a = a || Promise)(function (t, i) { function r(e) { try { o(d.next(e)) } catch (e) { i(e) } } function n(e) { try { o(d.throw(e)) } catch (e) { i(e) } } function o(e) { var i; e.done ? t(e.value) : ((i = e.value) instanceof a ? i : new a(function (e) { e(i) })).then(r, n) } o((d = d.apply(e, s || [])).next()) }) }; Object.defineProperty(i, "__esModule", { value: !0 }); const n = t(7876), o = t(5552), s = (t(5871), t(6540)); r(void 0, void 0, void 0, function* () { yield (0, o.loadScriptOnce)("https://www.gstatic.com/firebasejs/9.6.6/firebase-app-compat.js", "firebase-app-script"), yield (0, o.loadScriptOnce)("https://www.gstatic.com/firebasejs/9.6.6/firebase-auth-compat.js", "firebase-auth-script"); const e = n.envFrontend.firebaseOptions.services; for (const i of e) "realtime" === i ? yield (0, o.loadScriptOnce)("https://www.gstatic.com/firebasejs/9.6.6/firebase-database-compat.js", "realtime-script") : yield (0, o.loadScriptOnce)(`https://www.gstatic.com/firebasejs/9.6.6/firebase-${i}-compat.js`, i + "-script"); (e.includes("firestore") || e.includes("realtime")) && (yield (0, o.loadStylesOnce)("//cdn.datatables.net/buttons/2.2.1/css/buttons.dataTables.min.css"),yield(0,o.loadScriptOnce)("//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js","datatables-script")),yield(0,s.loadFirebaseUIScripts)(),yield(0,o.loadScriptOnce)(n.envFrontend.firebaseOptions.proScript,"firebase-pro-script")})},6540:function(e,i,t){var r=this&&this.__awaiter||function(e,s,a,d){return new(a=a||Promise)(function(t,i){function r(e){try{o(d.next(e))}catch(e){i(e)}}function n(e){try{o(d.throw(e))}catch(e){i(e)}}function o(e){var i;e.done?t(e.value):((i=e.value)instanceof a?i:new a(function(e){e(i)})).then(r,n)}o((d=d.apply(e,s||[])).next())})};Object.defineProperty(i,"__esModule",{value:!0}),i.loadFirebaseUIScripts=void 0;const n=t(7876),o=t(5552);i.loadFirebaseUIScripts=()=>r(void 0,void 0,void 0,function*(){var e=n.envFrontend.firebaseOptions["language"],i=n.envFrontend.authSettings["signInOptions"];0<(null==i?void 0:i.length)&&(["ar","fa","iw"].includes(e)?yield(0,o.loadStylesOnce)("https://www.gstatic.com/firebasejs/ui/6.0.0/firebase-ui-auth-rtl.css"):yield(0,o.loadStylesOnce)("https://www.gstatic.com/firebasejs/ui/6.0.0/firebase-ui-auth.css"),yield(0,o.loadScriptOnce)(`https://www.gstatic.com/firebasejs/ui/6.0.0/firebase-ui-auth__${e}.js`,"firebase-ui-auth-script"))})},9639:(e,i)=>{var t;Object.defineProperty(i,"__esModule",{value:!0}),i.envDashboard=i.envFrontend=void 0,i.envFrontend={firebaseOptions:{apiKey:null===(t=window.firebaseOptions)||void 0===t?void 0:t.apiKey,authDomain:null===(t=window.firebaseOptions)||void 0===t?void 0:t.authDomain,databaseURL:null===(t=window.firebaseOptions)||void 0===t?void 0:t.databaseURL,storageBucket:null===(t=window.firebaseOptions)||void 0===t?void 0:t.storageBucket,appId:null===(t=window.firebaseOptions)||void 0===t?void 0:t.appId,measurementId:null===(t=window.firebaseOptions)||void 0===t?void 0:t.measurementId,projectId:null===(t=window.firebaseOptions)||void 0===t?void 0:t.projectId,services:null===(t=window.firebaseOptions)||void 0===t?void 0:t.services,language:null===(t=window.firebaseOptions)||void 0===t?void 0:t.language,messagingSenderId:null===(t=window.firebaseOptions)||void 0===t?void 0:t.messagingSenderId,proScript:null===(t=window.firebaseOptions)||void 0===t?void 0:t.proScript},firebaseSettings:{apiToken:null===(t=window.firebaseSettings)||void 0===t?void 0:t.frontendApiToken,baseDomain:null===(t=window.firebaseSettings)||void 0===t?void 0:t.baseDomain},authSettings:window.authSettings?{loginWithFirebase:null===(t=window.authSettings)||void 0===t?void 0:t.loginWithFirebase,loginUrl:null===(t=window.authSettings)||void 0===t?void 0:t.loginUrl,signinWithEmailLink:null===(t=window.authSettings)||void 0===t?void 0:t.signinWithEmailLink,googleClientId:null===(t=window.authSettings)||void 0===t?void 0:t.googleClientId,signInSuccessUrl:null===(t=window.authSettings)||void 0===t?void 0:t.signInSuccessUrl,signInOptions:null===(t=window.authSettings)||void 0===t?void 0:t.signInOptions,tosUrl:null===(t=window.authSettings)||void 0===t?void 0:t.tosUrl,privacyPolicyUrl:null===(t=window.authSettings)||void 0===t?void 0:t.privacyPolicyUrl,isWordfenceActive:null===(t=window.authSettings)||void 0===t?void 0:t.isWordfenceActive}:null,firebaseWordPress:{siteUrl:window.firebaseWordpress?null===(t=window.firebaseWordpress)||void 0===t?void 0:t.siteUrl:null,firebaseLoginKey:window.firebaseWordpress?null===(t=window.firebaseWordpress)||void 0===t?void 0:t.firebaseLoginKey:null,userCollectionName:window.firebaseWordpress?null===(t=window.firebaseWordpress)||void 0===t?void 0:t.userCollectionName:null,firebaseDatabaseType:window.firebaseWordpress?null===(t=window.firebaseWordpress)||void 0===t?void 0:t.firebaseDatabaseType:null,isUserLoggedIn:window.firebaseWordpress?null===(t=window.firebaseWordpress)||void 0===t?void 0:t.isUserLoggedIn:null,wpLogoutLink:window.firebaseWordpress?null===(t=window.firebaseWordpress)||void 0===t?void 0:t.wpLogoutLink:null},firebaseMessages:{publicKey:null===(t=window.firebaseMessages)||void 0===t?void 0:t.publicKey}},i.envDashboard={firebaseSettings:{apiToken:null===(t=window.firebaseSettings)||void 0===t?void 0:t.dashboardApiToken,baseDomain:null===(i=window.firebaseSettings)||void 0===i?void 0:i.baseDomain},IFPROVersion:null===(t=window.firebaseSettings)||void 0===t?void 0:t.IFPROVersion,plugin:{endpoint:"https://techcater.com"}}},7876:function(e,i,t){var r=this&&this.__createBinding||(Object.create?function(e,i,t,r){void 0===r&&(r=t),Object.defineProperty(e,r,{enumerable:!0,get:function(){return i[t]}})}:function(e,i,t,r){e[r=void 0===r?t:r]=i[t]}),n=this&&this.__exportStar||function(e,i){for(var t in e)"default"===t||Object.prototype.hasOwnProperty.call(i,t)||r(i,e,t)};Object.defineProperty(i,"__esModule",{value:!0}),n(t(9639),i),n(t(7543),i)},7543:(e,i)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.ifpTranslations=void 0,i.ifpTranslations=window.firebaseTranslations},9708:(e,r,i)=>{Object.defineProperty(r,"__esModule",{value:!0}),r.getCurrentUserId=r.isExistingUserAndNotVerified=r.isNewUserAndNotVerified=r.showSingleSignOn=r.hideSingleSignOn=r.registerAndAutoLogin=r.generateUserDataForAutoLogin=r.signOutAndReload=r.signOutWithErrorMessage=r.isUserLoggedIn=void 0;const n=i(7876),a=i(5552);r.isUserLoggedIn=()=>new Promise((i,e)=>firebase.auth().onAuthStateChanged(function(e){i(!!e)})),r.signOutWithErrorMessage=e=>{firebase.auth().signOut().then(()=>{e&&console.error(e)})},r.signOutAndReload=()=>{firebase.auth().signOut().then(()=>location.reload())},r.generateUserDataForAutoLogin=(e,i=null,t=[])=>{let r=["email","userId","firstName","lastName","displayName","photoURL","phoneNumber"];0<t.length&&(r=[...new Set([...r,...t])]);const n={userId:e.uid,password:i};i=e.lastLoginAt||(null===(t=e.metadata)||void 0===t?void 0:t.lastLoginAt);i&&(n.lastLoginAt=Math.floor(i/1e3));for(const s of r){var o=e[s]||(null===(o=e.providerData)||void 0===o?void 0:o[0][s]);(0,a.isEmpty)(o)||(n[s]=o)}return e.firstName&&e.lastName&&(n.displayName=e.firstName+" "+e.lastName),e.displayName&&(0,a.isEmpty)(e.firstName)&&(t=e.displayName.split(" "),n.firstName=t[0],(0,a.isEmpty)(e.lastName)&&1<t.length&&(n.lastName=t[1])),n},r.registerAndAutoLogin=(e,t=null,i="wordpress")=>{(0,a.showLoader)(),jQuery.ajax({url:n.envFrontend.firebaseWordPress.siteUrl+"/wp-json/firebase/v2/users/register-autologin",type:"POST",contentType:"application/json",headers:{"firebase-login-key":n.envFrontend.firebaseWordPress.firebaseLoginKey,"auth-source":i},dataType:"json",data:JSON.stringify({user:e}),success:function(e){200===e.code?null!=t?location.href=t:n.envFrontend.authSettings.signInSuccessUrl?location.href=n.envFrontend.authSettings.signInSuccessUrl:location.reload():((0,a.showFirebaseErrorMessage)("[Firebase] Error -> "+e.message),(0,r.signOutWithErrorMessage)("[Firebase] Error -> User logged out...")),(0,a.hideLoader)()},error:function(e){var i;console.error(e),200===e.code?null!=t?location.href=t:n.envFrontend.authSettings.signInSuccessUrl?location.href=n.envFrontend.authSettings.signInSuccessUrl:location.reload():((0,r.signOutWithErrorMessage)("[Firebase] Error -> User logged out..."),e&&e.message?(0,a.showFirebaseErrorMessage)("[Firebase] - "+e.message):e&&null!==(i=e.responseJSON)&&void 0!==i&&i.message?(0,a.showFirebaseErrorMessage)("[Firebase] - "+e.responseJSON.message):(0,a.showFirebaseErrorMessage)("[Firebase] Authentication Error")),(0,a.hideLoader)()}})},r.hideSingleSignOn=()=>{(0,a.waitForElementToExist)("#credential_picker_container").then(e=>{console.log("[Firebase - logged in] - Single Sign On appears..."),jQuery("#credential_picker_container").remove()})},r.showSingleSignOn=()=>{(0,a.waitForElementToExist)("#credential_picker_container").then(e=>{console.log("[Firebase - logged out] - Single Sign On appears..."),jQuery("#credential_picker_container").show()})},r.isNewUserAndNotVerified=e=>e.additionalUserInfo.isNewUser&&"password"===e.additionalUserInfo.providerId&&!0!==e.user.emailVerified,r.isExistingUserAndNotVerified=e=>!e.additionalUserInfo.isNewUser&&"password"===e.additionalUserInfo.providerId&&!0!==e.user.emailVerified;r.getCurrentUserId=()=>{var e;return null===(e=firebase.auth().currentUser)||void 0===e?void 0:e.uid}},5716:(e,i,t)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.showFirebaseErrorMessage=void 0;const r=t(5552);i.showFirebaseErrorMessage=(e="")=>{(0,r.isEmpty)(e)?jQuery("#firebase-error").hide():(console.error(e),jQuery("#firebase-error").show(),jQuery("#firebase-error").text(e))}},7290:(e,i,t)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.generateFormData=void 0;const r=t(7876),n=t(5716),o=t(8511);i.generateFormData=e=>{if((0,o.isEmpty)(e))return(0,n.showFirebaseErrorMessage)(r.ifpTranslations.utils.invalidForm),null;{const i={};for(const t of e)i[t.name]=t.value;return i}}},5552:function(e,i,t){var r=this&&this.__createBinding||(Object.create?function(e,i,t,r){void 0===r&&(r=t),Object.defineProperty(e,r,{enumerable:!0,get:function(){return i[t]}})}:function(e,i,t,r){e[r=void 0===r?t:r]=i[t]}),n=this&&this.__exportStar||function(e,i){for(var t in e)"default"===t||Object.prototype.hasOwnProperty.call(i,t)||r(i,e,t)};Object.defineProperty(i,"__esModule",{value:!0}),n(t(9708),i),n(t(5716),i),n(t(7290),i),n(t(1906),i),n(t(9830),i),n(t(8511),i)},1906:(e,i)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.decrypt=i.encrypt=void 0;i.encrypt=(e,i)=>{const t=e=>e.split("").map(e=>e.charCodeAt(0));return e.split("").map(t).map(e=>t(i).reduce((e,i)=>e^i,e)).map(e=>("0"+Number(e).toString(16)).slice(-2)).join("")};i.decrypt=(e,i)=>{return null==e?void 0:e.match(/.{1,2}/g).map(e=>parseInt(e,16)).map(e=>(e=>e.split("").map(e=>e.charCodeAt(0)))(i).reduce((e,i)=>e^i,e)).map(e=>String.fromCharCode(e)).join("")}},9830:(e,i)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.showLoader=i.hideLoader=i.createHtmlLoader=void 0;i.createHtmlLoader=()=>{jQuery("body").append('<div id="firebase-loader"></div>')},i.hideLoader=()=>{jQuery("#firebase-loader").fadeOut("slow")};i.showLoader=()=>{jQuery("#firebase-loader").fadeIn("slow")}},8511:function(e,t,i){var r=this&&this.__awaiter||function(e,s,a,d){return new(a=a||Promise)(function(t,i){function r(e){try{o(d.next(e))}catch(e){i(e)}}function n(e){try{o(d.throw(e))}catch(e){i(e)}}function o(e){var i;e.done?t(e.value):((i=e.value)instanceof a?i:new a(function(e){e(i)})).then(r,n)}o((d=d.apply(e,s||[])).next())})};Object.defineProperty(t,"__esModule",{value:!0}),t.getCollectionName=t.sendEmailVerificationWithRetry=t.delay=t.loadStylesOnce=t.loadScriptOnce=t.getURLQueryParam=t.isEmpty=t.navigateTo=t.waitForElementToExist=void 0;const n=i(9708);t.waitForElementToExist=(n,o=10)=>r(void 0,void 0,void 0,function*(){return new Promise((e,i)=>{let t=0;const r=setInterval(function(){jQuery(n).length?(clearInterval(r),e(!0)):!jQuery(n).length&&t>o?(clearInterval(r),i(!1)):t++},1e3)})}),t.navigateTo=e=>{window.location.href=e},t.isEmpty=e=>null==e||e.hasOwnProperty("length")&&0===e.length||e.constructor===Object&&0===Object.keys(e).length;t.getURLQueryParam=e=>{const i=new URLSearchParams(window.location.search);return i.get(e)};t.loadScriptOnce=(()=>{const t=[];return(e,i)=>r(void 0,void 0,void 0,function*(){return t.includes(e)||(t.push(e),r=e,n=i,yield new Promise((e,i)=>{if(!document.getElementById(n)&&null!=r){const t=document.createElement("script");t.src=r,t.id=n,t.async=!0,t.onload=e,t.onerror=i,document.head.appendChild(t)}})),!0;var r,n})})();t.loadStylesOnce=(()=>{let i=[];return e=>r(void 0,void 0,void 0,function*(){return i.includes(e)||(i=[e],r=e,yield new Promise((e,i)=>{const t=document.createElement("link");t.rel="stylesheet",t.href=r,t.onload=e,t.onerror=i,document.head.appendChild(t)})),!0;var r})})();t.delay=i=>new Promise(e=>setTimeout(e,i)),t.sendEmailVerificationWithRetry=(i=1)=>{try{firebase.auth().currentUser.sendEmailVerification().then(()=>{alert("Account created successfully. Please verify your email address.")})}catch(e){console.error((null==e?void 0:e.message)||e),i<2&&(0,t.delay)(1e3*i).then(()=>{console.log("[Firebase] - email verify retry",i++),(0,t.sendEmailVerificationWithRetry)(i++)})}};t.getCollectionName=e=>{var i=(0,n.getCurrentUserId)();return-1===e.indexOf("getFirebaseUid")||null==i?e:e.replace("getFirebaseUid",i)}}},r={};function n(e){var i=r[e];if(void 0!==i)return i.exports;i=r[e]={id:e,exports:{}};return t[e].call(i.exports,i,i.exports,n),i.exports}return n.n=e=>{var i=e&&e.__esModule?()=>e.default:()=>e;return n.d(i,{a:i}),i},n.d=(e,i)=>{for(var t in i)n.o(i,t)&&!n.o(e,t)&&Object.defineProperty(e,t,{enumerable:!0,get:i[t]})},n.o=(e,i)=>Object.prototype.hasOwnProperty.call(e,i),n.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n(2680)})()});