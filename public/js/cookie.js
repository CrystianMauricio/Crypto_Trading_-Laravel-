"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[824],{7050:(t,o,n)=>{var i=n(4145);iziToast.show({theme:"dark",message:(0,i.__)("app.cookie_consent"),class:"cookie-consent",close:!1,timeout:!1,position:"bottomCenter",buttons:[["<button><b>"+(0,i.__)("app.accept")+"</b></button>",function(t,o){axios.post("/cookie/accept").then((function(n){void 0!==n.data.success&&n.data.success&&t.hide({transitionOut:"fadeOut"},o,"button")}))}],["<button>"+(0,i.__)("app.privacy_policy")+"</button>",function(t,o){window.location.href="/page/privacy-policy"}]]})},4145:(t,o,n)=>{function i(t){return void 0!==window.i18n?c(window.i18n,t,t):t}function e(t){return void 0!==window.cfg?c(window.cfg,t):t}function c(t,o){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;return function(o){for(var i=0,e=(o=o.split(".")).length;i<e;i++){if(void 0===t[o[i]])return n||void 0;t=t[o[i]]}return t}(o)}n.d(o,{__:()=>i,vc:()=>e})}},t=>{var o;o=7050,t(t.s=o)}]);