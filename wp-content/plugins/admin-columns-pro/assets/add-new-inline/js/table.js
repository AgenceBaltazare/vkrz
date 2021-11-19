!function(e){var t={};function n(i){if(t[i])return t[i].exports;var s=t[i]={i:i,l:!1,exports:{}};return e[i].call(s.exports,s,s.exports,n),s.l=!0,s.exports}n.m=e,n.c=t,n.d=function(e,t,i){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:i})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var s in e)n.d(i,s,function(t){return e[t]}.bind(null,s));return i},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=10)}([function(e,t,n){var i=n(4),s=n(5),o=n(1);function r(e){if(!(this instanceof r))return new r(e);this._name=e||"nanobus",this._starListeners=[],this._listeners={}}e.exports=r,r.prototype.emit=function(e){o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.emit: eventName should be type string or symbol");for(var t=[],n=1,i=arguments.length;n<i;n++)t.push(arguments[n]);var r=s(this._name+"('"+e.toString()+"')"),u=this._listeners[e];return u&&u.length>0&&this._emit(this._listeners[e],t),this._starListeners.length>0&&this._emit(this._starListeners,e,t,r.uuid),r(),this},r.prototype.on=r.prototype.addListener=function(e,t){return o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.on: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.on: listener should be type function"),"*"===e?this._starListeners.push(t):(this._listeners[e]||(this._listeners[e]=[]),this._listeners[e].push(t)),this},r.prototype.prependListener=function(e,t){return o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.prependListener: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.prependListener: listener should be type function"),"*"===e?this._starListeners.unshift(t):(this._listeners[e]||(this._listeners[e]=[]),this._listeners[e].unshift(t)),this},r.prototype.once=function(e,t){o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.once: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.once: listener should be type function");var n=this;return this.on(e,(function i(){t.apply(n,arguments),n.removeListener(e,i)})),this},r.prototype.prependOnceListener=function(e,t){o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.prependOnceListener: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.prependOnceListener: listener should be type function");var n=this;return this.prependListener(e,(function i(){t.apply(n,arguments),n.removeListener(e,i)})),this},r.prototype.removeListener=function(e,t){return o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.removeListener: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.removeListener: listener should be type function"),"*"===e?(this._starListeners=this._starListeners.slice(),n(this._starListeners,t)):(void 0!==this._listeners[e]&&(this._listeners[e]=this._listeners[e].slice()),n(this._listeners[e],t));function n(e,t){if(e){var n=e.indexOf(t);return-1!==n?(i(e,n,1),!0):void 0}}},r.prototype.removeAllListeners=function(e){return e?"*"===e?this._starListeners=[]:this._listeners[e]=[]:(this._starListeners=[],this._listeners={}),this},r.prototype.listeners=function(e){var t="*"!==e?this._listeners[e]:this._starListeners,n=[];if(t)for(var i=t.length,s=0;s<i;s++)n.push(t[s]);return n},r.prototype._emit=function(e,t,n,i){if(void 0!==e&&0!==e.length){void 0===n&&(n=t,t=null),t&&(n=void 0!==i?[t].concat(n,i):[t].concat(n));for(var s=e.length,o=0;o<s;o++){var r=e[o];r.apply(r,n)}}}},function(e,t){function n(e,t){if(!e)throw new Error(t||"AssertionError")}n.notEqual=function(e,t,i){n(e!=t,i)},n.notOk=function(e,t){n(!e,t)},n.equal=function(e,t,i){n(e==t,i)},n.ok=n,e.exports=n},function(e,t){function n(e,t){if(!e)throw new Error(t||"AssertionError")}n.notEqual=function(e,t,i){n(e!=t,i)},n.notOk=function(e,t){n(!e,t)},n.equal=function(e,t,i){n(e==t,i)},n.ok=n,e.exports=n},function(e,t,n){var i=n(7),s=n(8),o=n(2);function r(e){if(!(this instanceof r))return new r(e);this._name=e||"nanobus",this._starListeners=[],this._listeners={}}e.exports=r,r.prototype.emit=function(e){o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.emit: eventName should be type string or symbol");for(var t=[],n=1,i=arguments.length;n<i;n++)t.push(arguments[n]);var r=s(this._name+"('"+e.toString()+"')"),u=this._listeners[e];return u&&u.length>0&&this._emit(this._listeners[e],t),this._starListeners.length>0&&this._emit(this._starListeners,e,t,r.uuid),r(),this},r.prototype.on=r.prototype.addListener=function(e,t){return o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.on: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.on: listener should be type function"),"*"===e?this._starListeners.push(t):(this._listeners[e]||(this._listeners[e]=[]),this._listeners[e].push(t)),this},r.prototype.prependListener=function(e,t){return o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.prependListener: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.prependListener: listener should be type function"),"*"===e?this._starListeners.unshift(t):(this._listeners[e]||(this._listeners[e]=[]),this._listeners[e].unshift(t)),this},r.prototype.once=function(e,t){o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.once: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.once: listener should be type function");var n=this;return this.on(e,(function i(){t.apply(n,arguments),n.removeListener(e,i)})),this},r.prototype.prependOnceListener=function(e,t){o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.prependOnceListener: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.prependOnceListener: listener should be type function");var n=this;return this.prependListener(e,(function i(){t.apply(n,arguments),n.removeListener(e,i)})),this},r.prototype.removeListener=function(e,t){return o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.removeListener: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.removeListener: listener should be type function"),"*"===e?(this._starListeners=this._starListeners.slice(),n(this._starListeners,t)):(void 0!==this._listeners[e]&&(this._listeners[e]=this._listeners[e].slice()),n(this._listeners[e],t));function n(e,t){if(e){var n=e.indexOf(t);return-1!==n?(i(e,n,1),!0):void 0}}},r.prototype.removeAllListeners=function(e){return e?"*"===e?this._starListeners=[]:this._listeners[e]=[]:(this._starListeners=[],this._listeners={}),this},r.prototype.listeners=function(e){var t="*"!==e?this._listeners[e]:this._starListeners,n=[];if(t)for(var i=t.length,s=0;s<i;s++)n.push(t[s]);return n},r.prototype._emit=function(e,t,n,i){if(void 0!==e&&0!==e.length){void 0===n&&(n=t,t=null),t&&(n=void 0!==i?[t].concat(n,i):[t].concat(n));for(var s=e.length,o=0;o<s;o++){var r=e[o];r.apply(r,n)}}}},function(e,t,n){"use strict";e.exports=function(e,t,n){var i,s=e.length;if(!(t>=s||0===n)){var o=s-(n=t+n>s?s-t:n);for(i=t;i<o;++i)e[i]=e[i+n];e.length=o}}},function(e,t,n){var i,s=n(6)(),o=n(1);r.disabled=!0;try{i=window.performance,r.disabled="true"===window.localStorage.DISABLE_NANOTIMING||!i.mark}catch(e){}function r(e){if(o.equal(typeof e,"string","nanotiming: name should be type string"),r.disabled)return u;var t=(1e4*i.now()).toFixed()%Number.MAX_SAFE_INTEGER,n="start-"+t+"-"+e;function a(o){var r="end-"+t+"-"+e;i.mark(r),s.push((function(){var s=null;try{var u=e+" ["+t+"]";i.measure(u,n,r),i.clearMarks(n),i.clearMarks(r)}catch(e){s=e}o&&o(s,e)}))}return i.mark(n),a.uuid=t,a}function u(e){e&&s.push((function(){e(new Error("nanotiming: performance API unavailable"))}))}e.exports=r},function(e,t,n){var i=n(1),s="undefined"!=typeof window;function o(e){this.hasWindow=e,this.hasIdle=this.hasWindow&&window.requestIdleCallback,this.method=this.hasIdle?window.requestIdleCallback.bind(window):this.setTimeout,this.scheduled=!1,this.queue=[]}o.prototype.push=function(e){i.equal(typeof e,"function","nanoscheduler.push: cb should be type function"),this.queue.push(e),this.schedule()},o.prototype.schedule=function(){if(!this.scheduled){this.scheduled=!0;var e=this;this.method((function(t){for(;e.queue.length&&t.timeRemaining()>0;)e.queue.shift()(t);e.scheduled=!1,e.queue.length&&e.schedule()}))}},o.prototype.setTimeout=function(e){setTimeout(e,0,{timeRemaining:function(){return 1}})},e.exports=function(){var e;return s?(window._nanoScheduler||(window._nanoScheduler=new o(!0)),e=window._nanoScheduler):e=new o,e}},function(e,t,n){"use strict";e.exports=function(e,t,n){var i,s=e.length;if(!(t>=s||0===n)){var o=s-(n=t+n>s?s-t:n);for(i=t;i<o;++i)e[i]=e[i+n];e.length=o}}},function(e,t,n){var i,s=n(9)(),o=n(2);r.disabled=!0;try{i=window.performance,r.disabled="true"===window.localStorage.DISABLE_NANOTIMING||!i.mark}catch(e){}function r(e){if(o.equal(typeof e,"string","nanotiming: name should be type string"),r.disabled)return u;var t=(1e4*i.now()).toFixed()%Number.MAX_SAFE_INTEGER,n="start-"+t+"-"+e;function a(o){var r="end-"+t+"-"+e;i.mark(r),s.push((function(){var s=null;try{var u=e+" ["+t+"]";i.measure(u,n,r),i.clearMarks(n),i.clearMarks(r)}catch(e){s=e}o&&o(s,e)}))}return i.mark(n),a.uuid=t,a}function u(e){e&&s.push((function(){e(new Error("nanotiming: performance API unavailable"))}))}e.exports=r},function(e,t,n){var i=n(2),s="undefined"!=typeof window;function o(e){this.hasWindow=e,this.hasIdle=this.hasWindow&&window.requestIdleCallback,this.method=this.hasIdle?window.requestIdleCallback.bind(window):this.setTimeout,this.scheduled=!1,this.queue=[]}o.prototype.push=function(e){i.equal(typeof e,"function","nanoscheduler.push: cb should be type function"),this.queue.push(e),this.schedule()},o.prototype.schedule=function(){if(!this.scheduled){this.scheduled=!0;var e=this;this.method((function(t){for(;e.queue.length&&t.timeRemaining()>0;)e.queue.shift()(t);e.scheduled=!1,e.queue.length&&e.schedule()}))}},o.prototype.setTimeout=function(e){setTimeout(e,0,{timeRemaining:function(){return 1}})},e.exports=function(){var e;return s?(window._nanoScheduler||(window._nanoScheduler=new o(!0)),e=window._nanoScheduler):e=new o,e}},function(e,t,n){"use strict";n.r(t);var i=n(0),s=n.n(i),o=function(){function e(e){this.element=e,this.state=!1,this.events=new s.a,this.init()}return e.prototype.init=function(){var e=this;this.determinScreenOptionState(),this.element.addEventListener("click",(function(){e.determinScreenOptionState(),e.persist()}))},e.prototype.isEnabled=function(){return this.element.checked},e.prototype.determinScreenOptionState=function(){this.isEnabled()?this.enable():this.disable()},e.prototype.enable=function(){this.state=!0,this.events.emit("changeState",!0)},e.prototype.disable=function(){this.state=!1,this.events.emit("changeState",!1)},e.prototype.persist=function(){jQuery.post(ajaxurl,{action:"acp_new_inline_show_button",value:this.state,layout:AC.layout,list_screen:AC.list_screen,_ajax_nonce:AC.ajax_nonce})},e}(),r=function(){function e(){this.element=this.createElement(),this.state=!0,this.events=new s.a,this.placeElement(),this.initEvents()}return e.prototype.placeElement=function(){var e=this,t=document.querySelector(".page-title-action");t&&setTimeout((function(){t.insertAdjacentElement("afterend",e.element)}),200)},e.prototype.initEvents=function(){var e=this;this.element.addEventListener("click",(function(t){t.preventDefault(),e.state&&e.events.emit("click")}))},e.prototype.getElement=function(){return this.element},e.prototype.hide=function(){this.getElement().style.display="none"},e.prototype.show=function(){this.getElement().style.display="inline-block"},e.prototype.enable=function(){this.show(),this.state=!0},e.prototype.disable=function(){this.hide(),this.state=!1},e.prototype.createElement=function(){var e=document.createElement("a");return e.classList.add("ac-button"),e.classList.add("ac-add-new-inline"),e.classList.add("add-new-h2"),e.id="ac-button-add-new-inline",e.innerText=ACP_ADD_NEW_INLINE.i18n.add_new,e},e}(),u=n(3),a=n.n(u),l=function(){function e(){this.services={},this.events=new a.a}return e.prototype.registerService=function(e,t){return this.services[e]=t,this},e.prototype.getService=function(e){return this.hasService(e)?this.services[e]:null},e.prototype.hasService=function(e){return this.services.hasOwnProperty(e)},e.prototype.addListener=function(e,t){this.events.addListener(e,t)},e.prototype.emitEvent=function(e,t){this.events.emit(e,t)},e}(),c=function(){return window.AC_SERVICES||(window.AC_SERVICES=new l),window.AC_SERVICES},h=c(),p=function(){function e(){this.loading=!1,this.createButton=new r,this.screenOption=null;var e=document.getElementById("acp_new_inline_show_button-1");e&&(this.screenOption=new o(e)),this.initEvents()}return e.prototype.initEvents=function(){var e=this;this.screenOption&&!this.screenOption.isEnabled()&&this.createButton.disable(),this.screenOption&&this.screenOption.events.addListener("changeState",(function(t){t?e.createButton.enable():e.createButton.disable()})),this.createButton.events.addListener("click",(function(){e.addNew()}))},e.prototype.addNew=function(){var e=this;this.loading||(this.loading=!0,jQuery.post(window.location.href,{ac_action:"acp_add_new_inline",_ajax_nonce:AC.ajax_nonce,list_screen:AC.list_screen,layout:AC.layout}).done((function(e){if(e&&e.success&&e.data.hasOwnProperty("row")){var t=jQuery(e.data.row);jQuery("table.wp-list-table tbody").prepend(t),t.hide(),t.fadeIn(),h.getService("Table").updateRow(t[0]),h.hasService("Editing")&&h.getService("Editing").hasService("InlineEdit")&&h.getService("Editing").getService("InlineEdit").initRow(e.data.id)}})).always((function(){e.loading=!1})))},e}(),d=c();document.addEventListener("DOMContentLoaded",(function(){d.registerService("AddNewInline",new p)}))}]);