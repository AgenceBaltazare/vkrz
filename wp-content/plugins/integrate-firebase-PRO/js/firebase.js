!function(e,i){if("object"==typeof exports&&"object"==typeof module)module.exports=i();else if("function"==typeof define&&define.amd)define([],i);else{var t,n=i();for(t in n)("object"==typeof exports?exports:e)[t]=n[t]}}(this,function(){return(()=>{"use strict";var c={1095:(e,i,t)=>{t.d(i,{Z:()=>n});i=t(4325),t=t.n(i)()(function(e){return e[1]});t.push([e.id,"#firebase-loader{display:none;position:fixed;left:0px;top:0px;width:100%;height:100%;z-index:9999;background:url(https://cdn.techcater.com/images/loading-icon.jpg) center no-repeat rgba(255,255,255,0.5)}#firebase-error,.firebase-error{color:red}.firebase-show-with-claims{display:none}#firebase-signout,#firebaseui-auth-container{display:none}#firebase-login__submit,#firebase-login-form__submit{margin-top:20px}#firebase-login__forgot-password,#firebase-login-form__forgot-password{margin-left:20px}#firebase-login__error,#firebase-login-form__error{font-style:italic;color:red}#firebase-register-form #firebase-register-form__submit{margin-top:20px}#firebase-register-form__error{font-style:italic;color:red}firebase-auth,firebase-login,firebase-register,firebase-forgot-password{max-width:500px;margin:0 auto;display:block}firebase-auth input,firebase-login input,firebase-register input,firebase-forgot-password input{width:100%}firebase-forgot-password button,#firebase-forgot-password button{margin:20px 0}firebase-auth .firebaseui-idp-list{display:flex;justify-content:center;gap:2rem}firebase-auth .firebaseui-idp-list .firebaseui-idp-text.firebaseui-idp-text-long{display:none}firebase-auth .firebaseui-idp-list .firebaseui-idp-icon-wrapper{display:block;text-align:center}#if-realime-collection-table th,#if-firestore-collection-table th{text-transform:capitalize}.text-center{text-align:center}\n",""]);const n=t},2302:(e,i,t)=>{t.d(i,{Z:()=>n});i=t(4325),t=t.n(i)()(function(e){return e[1]});t.push([e.id,"form.woocommerce-EditAccountForm fieldset{display:none !important}\n",""]);const n=t},4325:e=>{e.exports=function(t){var d=[];return d.toString=function(){return this.map(function(e){var i=t(e);return e[2]?"@media ".concat(e[2]," {").concat(i,"}"):i}).join("")},d.i=function(e,i,t){"string"==typeof e&&(e=[[null,e,""]]);var n={};if(t)for(var o=0;o<this.length;o++){var r=this[o][0];null!=r&&(n[r]=!0)}for(var s=0;s<e.length;s++){var a=[].concat(e[s]);t&&n[a[0]]||(i&&(a[2]?a[2]="".concat(i," and ").concat(a[2]):a[2]=i),d.push(a))}},d}},9790:(e,o,r)=>{var i,t,d=function(){return i=void 0===i?Boolean(window&&document&&document.all&&!window.atob):i},s=(t={},function(e){if(void 0===t[e]){var i=document.querySelector(e);if(window.HTMLIFrameElement&&i instanceof window.HTMLIFrameElement)try{i=i.contentDocument.head}catch(e){i=null}t[e]=i}return t[e]}),l=[];function c(e){for(var i=-1,t=0;t<l.length;t++)if(l[t].identifier===e){i=t;break}return i}function a(e,i){for(var t={},n=[],o=0;o<e.length;o++){var r=e[o],s=i.base?r[0]+i.base:r[0],a=t[s]||0,d="".concat(s," ").concat(a),s=(t[s]=a+1,c(d)),a={css:r[1],media:r[2],sourceMap:r[3]};-1!==s?(l[s].references++,l[s].updater(a)):l.push({identifier:d,updater:function(i,e){var t,n,o;{var r;o=e.singleton?(r=v++,t=p=p||u(e),n=f.bind(null,t,r,!1),f.bind(null,t,r,!0)):(t=u(e),n=function(e,i,t){var n=t.css,o=t.media,t=t.sourceMap;o?e.setAttribute("media",o):e.removeAttribute("media");t&&"undefined"!=typeof btoa&&(n+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(t))))," */"));if(e.styleSheet)e.styleSheet.cssText=n;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(n))}}.bind(null,t,e),function(){var e=t;null!==e.parentNode&&e.parentNode.removeChild(e)})}return n(i),function(e){e?e.css===i.css&&e.media===i.media&&e.sourceMap===i.sourceMap||n(i=e):o()}}(a,i),references:1}),n.push(d)}return n}function u(e){var i=document.createElement("style"),t=e.attributes||{};if(void 0!==t.nonce||(n=r.nc)&&(t.nonce=n),Object.keys(t).forEach(function(e){i.setAttribute(e,t[e])}),"function"==typeof e.insert)e.insert(i);else{var n=s(e.insert||"head");if(!n)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");n.appendChild(i)}return i}n=[];var n,b=function(e,i){return n[e]=i,n.filter(Boolean).join("\n")};function f(e,i,t,n){var t=t?"":n.media?"@media ".concat(n.media," {").concat(n.css,"}"):n.css;e.styleSheet?e.styleSheet.cssText=b(i,t):(n=document.createTextNode(t),(t=e.childNodes)[i]&&e.removeChild(t[i]),t.length?e.insertBefore(n,t[i]):e.appendChild(n))}var p=null,v=0;e.exports=function(e,r){(r=r||{}).singleton||"boolean"==typeof r.singleton||(r.singleton=d());var s=a(e=e||[],r);return function(e){if(e=e||[],"[object Array]"===Object.prototype.toString.call(e)){for(var i=0;i<s.length;i++){var t=c(s[i]);l[t].references--}for(var e=a(e,r),n=0;n<s.length;n++){var o=c(s[n]);0===l[o].references&&(l[o].updater(),l.splice(o,1))}s=e}}}}},t={};function n(e){var i=t[e];if(void 0!==i)return i.exports;i=t[e]={id:e,exports:{}};return c[e](i,i.exports,n),i.exports}n.n=e=>{var i=e&&e.__esModule?()=>e.default:()=>e;return n.d(i,{a:i}),i},n.d=(e,i)=>{for(var t in i)n.o(i,t)&&!n.o(e,t)&&Object.defineProperty(e,t,{enumerable:!0,get:i[t]})},n.o=(e,i)=>Object.prototype.hasOwnProperty.call(e,i),n.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})};var u={};{n.r(u);const r={firebaseOptions:{apiKey:null===(e=window.firebaseOptions)||void 0===e?void 0:e.apiKey,authDomain:null===(e=window.firebaseOptions)||void 0===e?void 0:e.authDomain,databaseURL:null===(e=window.firebaseOptions)||void 0===e?void 0:e.databaseURL,storageBucket:null===(e=window.firebaseOptions)||void 0===e?void 0:e.storageBucket,appId:null===(e=window.firebaseOptions)||void 0===e?void 0:e.appId,measurementId:null===(e=window.firebaseOptions)||void 0===e?void 0:e.measurementId,projectId:null===(e=window.firebaseOptions)||void 0===e?void 0:e.projectId,services:null===(e=window.firebaseOptions)||void 0===e?void 0:e.services,language:null===(e=window.firebaseOptions)||void 0===e?void 0:e.language,messagingSenderId:null===(e=window.firebaseOptions)||void 0===e?void 0:e.messagingSenderId,reCaptchaSiteKey:null===(e=window.firebaseOptions)||void 0===e?void 0:e.reCaptchaSiteKey,proScript:null===(e=window.firebaseOptions)||void 0===e?void 0:e.proScript},firebaseSettings:{apiToken:null===(e=window.firebaseSettings)||void 0===e?void 0:e.frontendApiToken,baseDomain:null===(e=window.firebaseSettings)||void 0===e?void 0:e.baseDomain,proVersion:null===(e=window.firebaseSettings)||void 0===e?void 0:e.proVersion},authSettings:{loginWithFirebase:null===(e=window.authSettings)||void 0===e?void 0:e.loginWithFirebase,loginUrl:null===(e=window.authSettings)||void 0===e?void 0:e.loginUrl,signinWithEmailLink:null===(e=window.authSettings)||void 0===e?void 0:e.signinWithEmailLink,googleClientId:null===(e=window.authSettings)||void 0===e?void 0:e.googleClientId,signInSuccessUrl:null===(e=window.authSettings)||void 0===e?void 0:e.signInSuccessUrl,signInOptions:null===(e=window.authSettings)||void 0===e?void 0:e.signInOptions,tosUrl:null===(e=window.authSettings)||void 0===e?void 0:e.tosUrl,privacyPolicyUrl:null===(e=window.authSettings)||void 0===e?void 0:e.privacyPolicyUrl,isWordfenceActive:null===(e=window.authSettings)||void 0===e?void 0:e.isWordfenceActive},firebaseWordPress:{siteUrl:null===(e=window.firebaseWordpress)||void 0===e?void 0:e.siteUrl,firebaseLoginKey:null===(e=window.firebaseWordpress)||void 0===e?void 0:e.firebaseLoginKey,userCollectionName:null===(e=window.firebaseWordpress)||void 0===e?void 0:e.userCollectionName,firebaseDatabaseType:null===(e=window.firebaseWordpress)||void 0===e?void 0:e.firebaseDatabaseType,isUserLoggedIn:null===(e=window.firebaseWordpress)||void 0===e?void 0:e.isUserLoggedIn,wpLogoutLink:null===(e=window.firebaseWordpress)||void 0===e?void 0:e.wpLogoutLink},firebaseMessages:{publicKey:null===(e=window.firebaseMessages)||void 0===e?void 0:e.publicKey},firebaseExperiments:{allowUpdatingEmail:null===(e=window.firebaseExperiments)||void 0===e?void 0:e.allowUpdatingEmail},firebaseWoocommerce:{createNewUserAtCheckout:null===(e=window.firebaseWoocommerce)||void 0===e?void 0:e.createNewUserAtCheckout}};null===(e=window.firebaseSettings)||void 0===e||e.dashboardApiToken,null===(e=window.firebaseSettings)||void 0===e||e.baseDomain,null===(e=window.firebaseSettings)||void 0===e||e.proVersion,window.firebaseTranslations;var f=function(e,s,a,d){return new(a=a||Promise)(function(t,i){function n(e){try{r(d.next(e))}catch(e){i(e)}}function o(e){try{r(d.throw(e))}catch(e){i(e)}}function r(e){var i;e.done?t(e.value):((i=e.value)instanceof a?i:new a(function(e){e(i)})).then(n,o)}r((d=d.apply(e,s||[])).next())})};const d=(()=>{const t=[];return(e,i)=>f(void 0,void 0,void 0,function*(){return t.includes(e)||(t.push(e),n=e,o=i,yield new Promise((e,i)=>{if(!document.getElementById(o)&&null!=n){const t=document.createElement("script");t.src=n,t.id=o,t.async=!0,t.onload=e,t.onerror=i,document.head.appendChild(t)}})),!0;var n,o})})(),l=(()=>{let i=[];return e=>f(void 0,void 0,void 0,function*(){return i.includes(e)||(i=[e],n=e,yield new Promise((e,i)=>{const t=document.createElement("link");t.rel="stylesheet",t.href=n,t.onload=e,t.onerror=i,document.head.appendChild(t)})),!0;var n})})();var e=n(9790),e=n.n(e),i=n(1095),o={insert:"head",singleton:!1},p=(e()(i.Z,o),i.Z.locals,function(e,s,a,d){return new(a=a||Promise)(function(t,i){function n(e){try{r(d.next(e))}catch(e){i(e)}}function o(e){try{r(d.throw(e))}catch(e){i(e)}}function r(e){var i;e.done?t(e.value):((i=e.value)instanceof a?i:new a(function(e){e(i)})).then(n,o)}r((d=d.apply(e,s||[])).next())})}),o=n(2302),i={insert:"head",singleton:!1},b=(e()(o.Z,i),o.Z.locals,void 0),v=void 0,s=void 0,a=function*(){yield d("https://www.gstatic.com/firebasejs/9.6.6/firebase-app-compat.js","firebase-app-script"),yield d("https://www.gstatic.com/firebasejs/9.6.6/firebase-auth-compat.js","firebase-auth-script");const e=r.firebaseOptions.services;for(const i of e)"realtime"===i?yield d("https://www.gstatic.com/firebasejs/9.6.6/firebase-database-compat.js","realtime-script"):yield d(`https://www.gstatic.com/firebasejs/9.6.6/firebase-${i}-compat.js`,i+"-script");(e.includes("firestore")||e.includes("realtime"))&&(yield l("//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"),yield d("//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js","datatables-script")),yield p(void 0,void 0,void 0,function*(){var e=r.firebaseOptions["language"],i=r.authSettings["signInOptions"];0<(null==i?void 0:i.length)&&(["ar","fa","iw"].includes(e)?yield l("https://www.gstatic.com/firebasejs/ui/6.0.0/firebase-ui-auth-rtl.css"):yield l("https://www.gstatic.com/firebasejs/ui/6.0.0/firebase-ui-auth.css"),yield d(`https://www.gstatic.com/firebasejs/ui/6.0.0/firebase-ui-auth__${e}.js`,"firebase-ui-auth-script"))});try{"techcater-plugins.local"===location.host?(console.warn("DEV --- PRO script is served from local"),yield d("https://techcater-plugins.local/wp-content/plugins/integrate-firebase-PRO/js/firebase-pro.js?ver=3.17.0","firebase-pro-script")):yield d(r.firebaseOptions.proScript,"firebase-pro-script")}catch(e){console.error(e)}};new(s=s||Promise)(function(t,i){function n(e){try{r(a.next(e))}catch(e){i(e)}}function o(e){try{r(a.throw(e))}catch(e){i(e)}}function r(e){var i;e.done?t(e.value):((i=e.value)instanceof s?i:new s(function(e){e(i)})).then(n,o)}r((a=a.apply(b,v||[])).next())})}return u})()});