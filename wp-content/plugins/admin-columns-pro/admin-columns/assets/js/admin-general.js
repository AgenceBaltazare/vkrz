/*! For license information please see admin-general.js.LICENSE.txt */
(()=>{var e={808:(e,t,n)=>{var i,s,r;r=function(){function e(){for(var e=0,t={};e<arguments.length;e++){var n=arguments[e];for(var i in n)t[i]=n[i]}return t}function t(e){return e.replace(/(%[0-9A-Z]{2})+/g,decodeURIComponent)}return function n(i){function s(){}function r(t,n,r){if("undefined"!=typeof document){"number"==typeof(r=e({path:"/"},s.defaults,r)).expires&&(r.expires=new Date(1*new Date+864e5*r.expires)),r.expires=r.expires?r.expires.toUTCString():"";try{var o=JSON.stringify(n);/^[\{\[]/.test(o)&&(n=o)}catch(e){}n=i.write?i.write(n,t):encodeURIComponent(String(n)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),t=encodeURIComponent(String(t)).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent).replace(/[\(\)]/g,escape);var l="";for(var a in r)r[a]&&(l+="; "+a,!0!==r[a]&&(l+="="+r[a].split(";")[0]));return document.cookie=t+"="+n+l}}function o(e,n){if("undefined"!=typeof document){for(var s={},r=document.cookie?document.cookie.split("; "):[],o=0;o<r.length;o++){var l=r[o].split("="),a=l.slice(1).join("=");n||'"'!==a.charAt(0)||(a=a.slice(1,-1));try{var h=t(l[0]);if(a=(i.read||i)(a,h)||t(a),n)try{a=JSON.parse(a)}catch(e){}if(s[h]=a,e===h)break}catch(e){}}return e?s[e]:s}}return s.set=r,s.get=function(e){return o(e,!1)},s.getJSON=function(e){return o(e,!0)},s.remove=function(t,n){r(t,"",e(n,{expires:-1}))},s.defaults={},s.withConverter=n,s}((function(){}))},void 0===(s="function"==typeof(i=r)?i.call(t,n,t,e):i)||(e.exports=s),e.exports=r()},204:e=>{function t(e,t){if(!e)throw new Error(t||"AssertionError")}t.notEqual=function(e,n,i){t(e!=n,i)},t.notOk=function(e,n){t(!e,n)},t.equal=function(e,n,i){t(e==n,i)},t.ok=t,e.exports=t},559:(e,t,n)=>{var i=n(69),s=n(999),r=n(204);function o(e){if(!(this instanceof o))return new o(e);this._name=e||"nanobus",this._starListeners=[],this._listeners={}}e.exports=o,o.prototype.emit=function(e){r.ok("string"==typeof e||"symbol"==typeof e,"nanobus.emit: eventName should be type string or symbol");for(var t=[],n=1,i=arguments.length;n<i;n++)t.push(arguments[n]);var o=s(this._name+"('"+e.toString()+"')"),l=this._listeners[e];return l&&l.length>0&&this._emit(this._listeners[e],t),this._starListeners.length>0&&this._emit(this._starListeners,e,t,o.uuid),o(),this},o.prototype.on=o.prototype.addListener=function(e,t){return r.ok("string"==typeof e||"symbol"==typeof e,"nanobus.on: eventName should be type string or symbol"),r.equal(typeof t,"function","nanobus.on: listener should be type function"),"*"===e?this._starListeners.push(t):(this._listeners[e]||(this._listeners[e]=[]),this._listeners[e].push(t)),this},o.prototype.prependListener=function(e,t){return r.ok("string"==typeof e||"symbol"==typeof e,"nanobus.prependListener: eventName should be type string or symbol"),r.equal(typeof t,"function","nanobus.prependListener: listener should be type function"),"*"===e?this._starListeners.unshift(t):(this._listeners[e]||(this._listeners[e]=[]),this._listeners[e].unshift(t)),this},o.prototype.once=function(e,t){r.ok("string"==typeof e||"symbol"==typeof e,"nanobus.once: eventName should be type string or symbol"),r.equal(typeof t,"function","nanobus.once: listener should be type function");var n=this;return this.on(e,(function i(){t.apply(n,arguments),n.removeListener(e,i)})),this},o.prototype.prependOnceListener=function(e,t){r.ok("string"==typeof e||"symbol"==typeof e,"nanobus.prependOnceListener: eventName should be type string or symbol"),r.equal(typeof t,"function","nanobus.prependOnceListener: listener should be type function");var n=this;return this.prependListener(e,(function i(){t.apply(n,arguments),n.removeListener(e,i)})),this},o.prototype.removeListener=function(e,t){return r.ok("string"==typeof e||"symbol"==typeof e,"nanobus.removeListener: eventName should be type string or symbol"),r.equal(typeof t,"function","nanobus.removeListener: listener should be type function"),"*"===e?(this._starListeners=this._starListeners.slice(),n(this._starListeners,t)):(void 0!==this._listeners[e]&&(this._listeners[e]=this._listeners[e].slice()),n(this._listeners[e],t));function n(e,t){if(e){var n=e.indexOf(t);return-1!==n?(i(e,n,1),!0):void 0}}},o.prototype.removeAllListeners=function(e){return e?"*"===e?this._starListeners=[]:this._listeners[e]=[]:(this._starListeners=[],this._listeners={}),this},o.prototype.listeners=function(e){var t="*"!==e?this._listeners[e]:this._starListeners,n=[];if(t)for(var i=t.length,s=0;s<i;s++)n.push(t[s]);return n},o.prototype._emit=function(e,t,n,i){if(void 0!==e&&0!==e.length){void 0===n&&(n=t,t=null),t&&(n=void 0!==i?[t].concat(n,i):[t].concat(n));for(var s=e.length,r=0;r<s;r++){var o=e[r];o.apply(o,n)}}}},61:(e,t,n)=>{var i=n(204),s="undefined"!=typeof window;function r(e){this.hasWindow=e,this.hasIdle=this.hasWindow&&window.requestIdleCallback,this.method=this.hasIdle?window.requestIdleCallback.bind(window):this.setTimeout,this.scheduled=!1,this.queue=[]}r.prototype.push=function(e){i.equal(typeof e,"function","nanoscheduler.push: cb should be type function"),this.queue.push(e),this.schedule()},r.prototype.schedule=function(){if(!this.scheduled){this.scheduled=!0;var e=this;this.method((function(t){for(;e.queue.length&&t.timeRemaining()>0;)e.queue.shift()(t);e.scheduled=!1,e.queue.length&&e.schedule()}))}},r.prototype.setTimeout=function(e){setTimeout(e,0,{timeRemaining:function(){return 1}})},e.exports=function(){var e;return s?(window._nanoScheduler||(window._nanoScheduler=new r(!0)),e=window._nanoScheduler):e=new r,e}},999:(e,t,n)=>{var i,s=n(61)(),r=n(204);o.disabled=!0;try{i=window.performance,o.disabled="true"===window.localStorage.DISABLE_NANOTIMING||!i.mark}catch(e){}function o(e){if(r.equal(typeof e,"string","nanotiming: name should be type string"),o.disabled)return l;var t=(1e4*i.now()).toFixed()%Number.MAX_SAFE_INTEGER,n="start-"+t+"-"+e;function a(r){var o="end-"+t+"-"+e;i.mark(o),s.push((function(){var s=null;try{var l=e+" ["+t+"]";i.measure(l,n,o),i.clearMarks(n),i.clearMarks(o)}catch(e){s=e}r&&r(s,e)}))}return i.mark(n),a.uuid=t,a}function l(e){e&&s.push((function(){e(new Error("nanotiming: performance API unavailable"))}))}e.exports=o},69:e=>{"use strict";e.exports=function(e,t,n){var i,s=e.length;if(!(t>=s||0===n)){var r=s-(n=t+n>s?s-t:n);for(i=t;i<r;++i)e[i]=e[i+n];e.length=r}}},311:e=>{"use strict";e.exports=jQuery}},t={};function n(i){var s=t[i];if(void 0!==s)return s.exports;var r=t[i]={exports:{}};return e[i](r,r.exports,n),r.exports}n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},n.d=(e,t)=>{for(var i in t)n.o(t,i)&&!n.o(e,i)&&Object.defineProperty(e,i,{enumerable:!0,get:t[i]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{"use strict";let e=n(808);class t{constructor(e){this.element=e,this.init()}init(){if(this.element.classList.contains("-closable")){const t=this.element.querySelector(".ac-section__header");if(t&&t.addEventListener("click",(()=>{this.toggle()})),this.isStorable()){let t=e.get(this.getCookieKey());void 0!==t&&(1===parseInt(t)?this.open:this.close())}}}getCookieKey(){return`ac-section_${this.getSectionId()}`}getSectionId(){return this.element.dataset.section}isStorable(){return void 0!==this.element.dataset.section}toggle(){this.isOpen()?this.close():this.open()}isOpen(){return!this.element.classList.contains("-closed")}open(){this.element.classList.remove("-closed"),this.isStorable()&&e.set(this.getCookieKey(),1)}close(){this.element.classList.add("-closed"),this.isStorable()&&e.set(this.getCookieKey(),0)}}class i{constructor(e,t=""){this.element=e,this.content=t||e.dataset.acTip,this.tip=s(this.content),this.initEvents()}initEvents(){"1"!==this.element.dataset.acTooltipInit&&(this.element.dataset.acTooltipInit="1",this.element.addEventListener("mouseenter",(()=>{const e=document.body.getBoundingClientRect(),t=this.element.getBoundingClientRect();document.body.appendChild(this.tip),this.tip.style.left=t.left-e.left+this.element.offsetWidth/2+"px",this.tip.style.top=t.top-e.top+this.element.offsetHeight+"px",this.tip.classList.add("hover")})),this.element.addEventListener("mouseleave",(()=>{this.tip.classList.remove("hover"),document.body.removeChild(this.tip)})))}}const s=e=>{let t=document.createElement("div");return t.classList.add("ac-tooltip"),t.innerHTML=e,t},r=n(311);class o{constructor(e){this.element=e,this.settings=this.getDefaults(),this.init(),this.setInitialized()}setInitialized(){l.add(this.element)}getDefaults(){return{width:this.element.getAttribute("data-width")?this.element.getAttribute("data-width"):250,noclick:!!this.element.getAttribute("data-noclick")&&this.element.getAttribute("data-noclick"),position:this.getPosition()}}isInitialized(){return l.isInitialized(this.element)}init(){this.isInitialized()||(r(this.element).mouseenter((()=>{r(this.element).pointer({content:this.getRelatedHTML(),position:this.settings.position,pointerWidth:this.settings.width,pointerClass:this.getPointerClass()})})),this.initEvents())}getPosition(){let e={at:"left top",my:"right top",edge:"right"},t=this.element.getAttribute("data-pos"),n=this.element.getAttribute("data-pos_edge");return"right"===t&&(e={at:"right middle",my:"left middle",edge:"left"}),"right_bottom"===t&&(e={at:"right middle",my:"left bottom",edge:"none"}),"left"===t&&(e={at:"left middle",my:"right middle",edge:"right"}),n&&(e.edge=n),e}getPointerClass(){let e=["ac-wp-pointer","wp-pointer","wp-pointer-"+this.settings.position.edge];return this.settings.noclick&&e.push("noclick"),e.join(" ")}getRelatedHTML(){let e=document.getElementById(this.element.getAttribute("rel"));return e?e.innerHTML:""}initEvents(){let e=r(this.element);this.settings.noclick||e.click((function(){e.hasClass("open")?e.removeClass("open"):e.addClass("open")})),e.click((function(){e.pointer("open")})),e.mouseenter((function(){e.pointer("open"),setTimeout((()=>{e.pointer("open")}),2)})),e.mouseleave((function(){setTimeout((()=>{e.hasClass("open")||0!==r(".ac-wp-pointer.hover").length||e.pointer("close")}),1)})),e.on("close",(()=>{setTimeout((()=>{e.hasClass("open")||e.pointer("close")}))}))}}class l{static isInitialized(e){return this.initElements.filter((t=>t===e)).length>0}static add(e){this.initElements.push(e)}}l.initElements=[];const a=(e=null)=>{e||(e=document.querySelectorAll(".ac-pointer")),e.forEach((e=>{new o(e)})),r(".ac-wp-pointer").hover((function(){r(this).addClass("hover")}),(function(){r(this).removeClass("hover"),r(".ac-pointer").trigger("close")})).on("click",".close",(function(){r(".ac-pointer").removeClass("open")})),new class{constructor(){this.init()}init(){document.querySelectorAll("[data-ac-tip]").forEach((e=>{new i(e)}))}}};var h=n(559),c=n.n(h);const u=e=>d.create(e);class d{constructor(e){this.element=e instanceof HTMLElement?e:document.createElement(e)}static create(e){return new d(e)}addId(e){return this.element.id=e,this}addClass(e){return this.element.classList.add(e),this}addClasses(...e){return e.forEach((e=>this.addClass(e))),this}setAttribute(e,t){return this.element.setAttribute(e,t),this}setAttributes(e){return Object.keys(e).forEach((t=>this.setAttribute(t,e[t]))),this}addHtml(e){return this.element.innerHTML=e,this}append(e){return this.element.appendChild(e),this}appendSelfTo(e){return e.append(this.element),this}css(e,t){return this.element.style[e]=t,this}insertAfter(e){try{this.element.parentElement.insertBefore(e,this.element.nextElementSibling)}catch(e){console.error("Not able to insert element after current node",this.element)}}insertSelfBefore(e){try{e.parentElement.insertBefore(this.element,e)}catch(e){console.error("Not able to insert element before current node",this.element)}return this}insertBefore(e){try{this.element.parentElement.insertBefore(e,this.element)}catch(e){console.error("Not able to insert element before current node",this.element)}return this}addEventListener(e,t){return this.element.addEventListener(e,t),this}addEventListeners(e,t){return e.forEach((e=>this.addEventListener(e,t))),this}}class p{constructor(){this.filters={}}addFilter(e,t,n=10){this.filters.hasOwnProperty(e)||(this.filters[e]={}),this.filters[e].hasOwnProperty(n)||(this.filters[e][n]=[]),this.filters[e][n].push(t)}applyFilters(e,t,n={}){return this.filters.hasOwnProperty(e)?(Object.keys(this.filters[e]).forEach((i=>{this.filters[e][parseInt(i)].forEach((e=>{t=e(t,n)}))})),t):t}}const f=n(311);window.AC_SERVICES||(window.AC_SERVICES=new class{constructor(){this.services={},this.events=new(c()),this.filters=new p,this.$=u}registerService(e,t){return this.services[e]=t,this}getService(e){return this.hasService(e)?this.services[e]:null}hasService(e){return this.services.hasOwnProperty(e)}addListener(e,t){this.events.addListener(e,t)}emitEvent(e,t){this.events.emit(e,t)}}),window.AC_SERVICES,f(document).ready((()=>{a(),document.querySelectorAll(".ac-section").forEach((e=>{new t(e)})),f(document).on("select2:open",(()=>{let e=document.querySelector(".select2-container--open .select2-search__field");e&&e.focus()}))}))})()})();