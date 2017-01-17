window.google = window["google"] || {};google.friendconnect = google.friendconnect_ || {};if (!window['__ps_loaded__']) {/*http://www-a-fc-opensocial.googleusercontent.com/gadgets/js/rpc.js?c=1*/
window['___jsl']={'u':'http:\/\/www-a-fc-opensocial.googleusercontent.com\/gadgets\/js\/rpc.js?c=1','f':['rpc']};
var gadgets=window.gadgets||{},shindig=window.shindig||{},osapi=window.osapi||{};
;
if(!gadgets.config){gadgets.config=function(){var ___jsl;
var components={};
var configuration;
function foldConfig(origConfig,updConfig){for(var key in updConfig){if(!updConfig.hasOwnProperty(key)){continue
}if(typeof origConfig[key]==="object"&&typeof updConfig[key]==="object"){foldConfig(origConfig[key],updConfig[key])
}else{origConfig[key]=updConfig[key]
}}}function getLoadingScript(){var scripts=document.scripts||document.getElementsByTagName("script");
if(!scripts||scripts.length==0){return null
}var scriptTag;
if(___jsl.u){for(var i=0;
!scriptTag&&i<scripts.length;
++i){var candidate=scripts[i];
if(candidate.src&&candidate.src.indexOf(___jsl.u)==0){scriptTag=candidate
}}}if(!scriptTag){scriptTag=scripts[scripts.length-1]
}if(!scriptTag.src){return null
}return scriptTag
}function getInnerText(scriptNode){var scriptText="";
if(scriptNode.nodeType==3||scriptNode.nodeType==4){scriptText=scriptNode.nodeValue
}else{if(scriptNode.innerText){scriptText=scriptNode.innerText
}else{if(scriptNode.firstChild){var content=[];
for(var child=scriptNode.firstChild;
child;
child=child.nextSibling){content.push(getInnerText(child))
}scriptText=content.join("")
}}}return scriptText
}function parseConfig(configText){var config;
try{eval("config=("+configText+"\n)")
}catch(e){}if(typeof config==="object"){return config
}try{eval("config=({"+configText+"\n})")
}catch(e){}return typeof config==="object"?config:{}
}function augmentConfig(baseConfig){var loadScript=getLoadingScript();
if(!loadScript){return
}var scriptText=getInnerText(loadScript);
var configAugment=parseConfig(scriptText);
if(___jsl.f&&___jsl.f.length==1){var feature=___jsl.f[0];
if(!configAugment[feature]){var newConfig={};
newConfig[___jsl.f[0]]=configAugment;
configAugment=newConfig
}}foldConfig(baseConfig,configAugment)
}return{register:function(component,opt_validators,opt_callback){var registered=components[component];
if(!registered){registered=[];
components[component]=registered
}registered.push({validators:opt_validators||{},callback:opt_callback})
},get:function(opt_component){if(opt_component){return configuration[opt_component]||{}
}return configuration
},init:function(config,opt_noValidation){___jsl=window.___jsl||{};
if(configuration){foldConfig(configuration,config)
}else{configuration=config
}augmentConfig(configuration);
var inlineOverride=window.___config||{};
foldConfig(configuration,inlineOverride);
for(var name in components){if(components.hasOwnProperty(name)){var componentList=components[name],conf=configuration[name];
for(var i=0,j=componentList.length;
i<j;
++i){var component=componentList[i];
if(conf&&!opt_noValidation){var validators=component.validators;
for(var v in validators){if(validators.hasOwnProperty(v)){if(!validators[v](conf[v])){throw new Error('Invalid config value "'+conf[v]+'" for parameter "'+v+'" in component "'+name+'"')
}}}}if(component.callback){component.callback(configuration)
}}}}},update:function(updateConfig,opt_replace){configuration=opt_replace?{}:configuration||{};
foldConfig(configuration,updateConfig)
}}
}()
};;
gadgets.config.isGadget=false;
gadgets.config.isContainer=true;;
(function(){gadgets.config.EnumValidator=function(d){var c=[];
if(arguments.length>1){for(var b=0,a;
(a=arguments[b]);
++b){c.push(a)
}}else{c=d
}return function(f){for(var e=0,g;
(g=c[e]);
++e){if(f===c[e]){return true
}}return false
}
};
gadgets.config.RegExValidator=function(a){return function(b){return a.test(b)
}
};
gadgets.config.ExistsValidator=function(a){return typeof a!=="undefined"
};
gadgets.config.NonEmptyStringValidator=function(a){return typeof a==="string"&&a.length>0
};
gadgets.config.BooleanValidator=function(a){return typeof a==="boolean"
};
gadgets.config.LikeValidator=function(a){return function(c){for(var d in a){if(a.hasOwnProperty(d)){var b=a[d];
if(!b(c[d])){return false
}}}return true
}
}
})();;
gadgets.util=function(){var a=null;
function b(e){var f;
var c=e.indexOf("?");
var d=e.indexOf("#");
if(d===-1){f=e.substr(c+1)
}else{f=[e.substr(c+1,d-c-1),"&",e.substr(d+1)].join("")
}return f.split("&")
}return{getUrlParameters:function(p){var d=typeof p==="undefined";
if(a!==null&&d){return a
}var l={};
var f=b(p||document.location.href);
var n=window.decodeURIComponent?decodeURIComponent:unescape;
for(var h=0,g=f.length;
h<g;
++h){var m=f[h].indexOf("=");
if(m===-1){continue
}var c=f[h].substring(0,m);
var o=f[h].substring(m+1);
o=o.replace(/\+/g," ");
try{l[c]=n(o)
}catch(k){}}if(d){a=l
}return l
}}
}();
gadgets.util.getUrlParameters();;
gadgets.log=(function(){var e=1;
var a=2;
var f=3;
var c=4;
var d=function(i){b(e,i)
};
gadgets.warn=function(i){b(a,i)
};
gadgets.error=function(i){b(f,i)
};
gadgets.setLogLevel=function(i){h=i
};
function b(j,i){if(j<h||!g){return
}if(j===a&&g.warn){g.warn(i)
}else{if(j===f&&g.error){g.error(i)
}else{if(g.log){g.log(i)
}}}}d.INFO=e;
d.WARNING=a;
d.NONE=c;
var h=e;
var g=window.console?window.console:window.opera?window.opera.postError:undefined;
return d
})();;
var tamings___=tamings___||[];
tamings___.push(function(a){___.grantRead(gadgets.log,"INFO");
___.grantRead(gadgets.log,"WARNING");
___.grantRead(gadgets.log,"ERROR");
___.grantRead(gadgets.log,"NONE");
caja___.whitelistFuncs([[gadgets,"log"],[gadgets,"warn"],[gadgets,"error"],[gadgets,"setLogLevel"]])
});;
if(window.JSON&&window.JSON.parse&&window.JSON.stringify){gadgets.json=(function(){var a=/___$/;
return{parse:function(c){try{return window.JSON.parse(c)
}catch(b){return false
}},stringify:function(c){try{return window.JSON.stringify(c,function(e,d){return !a.test(e)?d:null
})
}catch(b){return null
}}}
})()
};;
if(!(window.JSON&&window.JSON.parse&&window.JSON.stringify)){gadgets.json=function(){function f(n){return n<10?"0"+n:n
}Date.prototype.toJSON=function(){return[this.getUTCFullYear(),"-",f(this.getUTCMonth()+1),"-",f(this.getUTCDate()),"T",f(this.getUTCHours()),":",f(this.getUTCMinutes()),":",f(this.getUTCSeconds()),"Z"].join("")
};
var m={"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"};
function stringify(value){var a,i,k,l,r=/["\\\x00-\x1f\x7f-\x9f]/g,v;
switch(typeof value){case"string":return r.test(value)?'"'+value.replace(r,function(a){var c=m[a];
if(c){return c
}c=a.charCodeAt();
return"\\u00"+Math.floor(c/16).toString(16)+(c%16).toString(16)
})+'"':'"'+value+'"';
case"number":return isFinite(value)?String(value):"null";
case"boolean":case"null":return String(value);
case"object":if(!value){return"null"
}a=[];
if(typeof value.length==="number"&&!value.propertyIsEnumerable("length")){l=value.length;
for(i=0;
i<l;
i+=1){a.push(stringify(value[i])||"null")
}return"["+a.join(",")+"]"
}for(k in value){if(k.match("___$")){continue
}if(value.hasOwnProperty(k)){if(typeof k==="string"){v=stringify(value[k]);
if(v){a.push(stringify(k)+":"+v)
}}}}return"{"+a.join(",")+"}"
}return""
}return{stringify:stringify,parse:function(text){if(/^[\],:{}\s]*$/.test(text.replace(/\\["\\\/b-u]/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,""))){return eval("("+text+")")
}return false
}}
}()
};;
gadgets.json.flatten=function(c){var d={};
if(c===null||c===undefined){return d
}for(var a in c){if(c.hasOwnProperty(a)){var b=c[a];
if(null===b||undefined===b){continue
}d[a]=(typeof b==="string")?b:gadgets.json.stringify(b)
}}return d
};;
var tamings___=tamings___||[];
tamings___.push(function(a){___.tamesTo(gadgets.json.stringify,safeJSON.stringify);
___.tamesTo(gadgets.json.parse,safeJSON.parse)
});;
var __getUrlParameters=gadgets.util.getUrlParameters;
gadgets.util=function(){var d={};
var c={};
var e=[];
var a={0:false,10:true,13:true,34:true,39:true,60:true,62:true,92:true,8232:true,8233:true};
function b(g,h){return String.fromCharCode(h)
}function f(g){d=g["core.util"]||{}
}if(gadgets.config){gadgets.config.register("core.util",null,f)
}return{getUrlParameters:__getUrlParameters,makeClosure:function(l,n,m){var k=[];
for(var h=2,g=arguments.length;
h<g;
++h){k.push(arguments[h])
}return function(){var o=k.slice();
for(var q=0,p=arguments.length;
q<p;
++q){o.push(arguments[q])
}return n.apply(l,o)
}
},makeEnum:function(h){var j,g,k={};
for(j=0;
(g=h[j]);
++j){k[g]=g
}return k
},getFeatureParameters:function(g){return typeof d[g]==="undefined"?null:d[g]
},hasFeature:function(g){return typeof d[g]!=="undefined"
},getServices:function(){return c
},registerOnLoadHandler:function(g){e.push(g)
},runOnLoadHandlers:function(){for(var h=0,g=e.length;
h<g;
++h){e[h]()
}},escape:function(g,m){if(!g){return g
}else{if(typeof g==="string"){return gadgets.util.escapeString(g)
}else{if(typeof g==="array"){for(var l=0,h=g.length;
l<h;
++l){g[l]=gadgets.util.escape(g[l])
}}else{if(typeof g==="object"&&m){var k={};
for(var n in g){if(g.hasOwnProperty(n)){k[gadgets.util.escapeString(n)]=gadgets.util.escape(g[n],true)
}}return k
}}}}return g
},escapeString:function(m){if(!m){return m
}var h=[],l,n;
for(var k=0,g=m.length;
k<g;
++k){l=m.charCodeAt(k);
n=a[l];
if(n===true){h.push("&#",l,";")
}else{if(n!==false){h.push(m.charAt(k))
}}}return h.join("")
},unescapeString:function(g){if(!g){return g
}return g.replace(/&#([0-9]+);/g,b)
},attachBrowserEvent:function(i,h,j,g){if(typeof i.addEventListener!="undefined"){i.addEventListener(h,j,g)
}else{if(typeof i.attachEvent!="undefined"){i.attachEvent("on"+h,j)
}else{gadgets.warn("cannot attachBrowserEvent: "+h)
}}},removeBrowserEvent:function(i,h,j,g){if(i.removeEventListener){i.removeEventListener(h,j,g)
}else{if(i.detachEvent){i.detachEvent("on"+h,j)
}else{gadgets.warn("cannot removeBrowserEvent: "+h)
}}}}
}();;
var tamings___=tamings___||[];
tamings___.push(function(a){caja___.whitelistFuncs([[gadgets.util,"escapeString"],[gadgets.util,"getFeatureParameters"],[gadgets.util,"getUrlParameters"],[gadgets.util,"hasFeature"],[gadgets.util,"registerOnLoadHandler"],[gadgets.util,"unescapeString"]])
});;
gadgets.rpctx=gadgets.rpctx||{};
if(!gadgets.rpctx.wpm){gadgets.rpctx.wpm=function(){var d,c;
var e=false;
function b(h,i,g){if(typeof window.addEventListener!="undefined"){window.addEventListener(h,i,g)
}else{if(typeof window.attachEvent!="undefined"){window.attachEvent("on"+h,i)
}}}function a(h,i,g){if(window.removeEventListener){window.removeEventListener(h,i,g)
}else{if(window.detachEvent){window.detachEvent("on"+h,i)
}}}function f(i){var j=gadgets.json.parse(i.data);
if(e){if(!j||!j.f){return
}var h=gadgets.rpc.getRelayUrl(j.f)||gadgets.util.getUrlParameters()["parent"];
var g=gadgets.rpc.getOrigin(h);
if(typeof i.origin!=="undefined"?i.origin!==g:i.domain!==/^.+:\/\/([^:]+).*/.exec(g)[1]){return
}}d(j,i.origin)
}return{getCode:function(){return"wpm"
},isParentVerifiable:function(){return true
},init:function(g,h){d=g;
c=h;
b("message",f,false);
c("..",true);
return true
},setup:function(i,h,g){e=g;
if(i===".."){if(e){gadgets.rpc._createRelayIframe(h)
}else{gadgets.rpc.call(i,gadgets.rpc.ACK)
}}return true
},call:function(h,k,j){var g=gadgets.rpc.getTargetOrigin(h);
var i=gadgets.rpc._getTargetWin(h);
if(g){window.setTimeout(function(){i.postMessage(gadgets.json.stringify(j),g)
},0)
}else{gadgets.error("No relay set (used as window.postMessage targetOrigin), cannot send cross-domain message")
}return true
},relayOnload:function(h,g){c(h,true)
}}
}()
};;
;
gadgets.rpctx=gadgets.rpctx||{};
if(!gadgets.rpctx.frameElement){gadgets.rpctx.frameElement=function(){var e="__g2c_rpc";
var b="__c2g_rpc";
var d;
var c;
function a(g,k,j){try{if(k!==".."){var f=window.frameElement;
if(typeof f[e]==="function"){if(typeof f[e][b]!=="function"){f[e][b]=function(l){d(gadgets.json.parse(l))
}
}f[e](gadgets.json.stringify(j));
return true
}}else{var i=document.getElementById(g);
if(typeof i[e]==="function"&&typeof i[e][b]==="function"){i[e][b](gadgets.json.stringify(j));
return true
}}}catch(h){}return false
}return{getCode:function(){return"fe"
},isParentVerifiable:function(){return false
},init:function(f,g){d=f;
c=g;
return true
},setup:function(j,f){if(j!==".."){try{var i=document.getElementById(j);
i[e]=function(k){d(gadgets.json.parse(k))
}
}catch(h){return false
}}if(j===".."){c("..",true);
var g=function(){window.setTimeout(function(){gadgets.rpc.call(j,gadgets.rpc.ACK)
},500)
};
gadgets.util.registerOnLoadHandler(g)
}return true
},call:function(f,h,g){return a(f,h,g)
}}
}()
};;
;
;
;
gadgets.rpctx=gadgets.rpctx||{};
if(!gadgets.rpctx.nix){gadgets.rpctx.nix=function(){var c="GRPC____NIXVBS_wrapper";
var d="GRPC____NIXVBS_get_wrapper";
var f="GRPC____NIXVBS_handle_message";
var b="GRPC____NIXVBS_create_channel";
var a=10;
var j=500;
var i={};
var h;
var g=0;
function e(){var l=i[".."];
if(l){return
}if(++g>a){gadgets.warn("Nix transport setup failed, falling back...");
h("..",false);
return
}if(!l&&window.opener&&"GetAuthToken" in window.opener){l=window.opener;
if(l.GetAuthToken()==gadgets.rpc.getAuthToken("..")){var k=gadgets.rpc.getAuthToken("..");
l.CreateChannel(window[d]("..",k),k);
i[".."]=l;
window.opener=null;
h("..",true);
return
}}window.setTimeout(function(){e()
},j)
}return{getCode:function(){return"nix"
},isParentVerifiable:function(){return false
},init:function(l,m){h=m;
if(typeof window[d]!=="unknown"){window[f]=function(o){window.setTimeout(function(){l(gadgets.json.parse(o))
},0)
};
window[b]=function(o,q,p){if(gadgets.rpc.getAuthToken(o)===p){i[o]=q;
h(o,true)
}};
var k="Class "+c+"\n Private m_Intended\nPrivate m_Auth\nPublic Sub SetIntendedName(name)\n If isEmpty(m_Intended) Then\nm_Intended = name\nEnd If\nEnd Sub\nPublic Sub SetAuth(auth)\n If isEmpty(m_Auth) Then\nm_Auth = auth\nEnd If\nEnd Sub\nPublic Sub SendMessage(data)\n "+f+"(data)\nEnd Sub\nPublic Function GetAuthToken()\n GetAuthToken = m_Auth\nEnd Function\nPublic Sub CreateChannel(channel, auth)\n Call "+b+"(m_Intended, channel, auth)\nEnd Sub\nEnd Class\nFunction "+d+"(name, auth)\nDim wrap\nSet wrap = New "+c+"\nwrap.SetIntendedName name\nwrap.SetAuth auth\nSet "+d+" = wrap\nEnd Function";
try{window.execScript(k,"vbscript")
}catch(n){return false
}}return true
},setup:function(o,k){if(o===".."){e();
return true
}try{var m=document.getElementById(o);
var n=window[d](o,k);
m.contentWindow.opener=n
}catch(l){return false
}return true
},call:function(k,n,m){try{if(i[k]){i[k].SendMessage(gadgets.json.stringify(m))
}}catch(l){return false
}return true
}}
}()
};;
;
gadgets.rpctx=gadgets.rpctx||{};
if(!gadgets.rpctx.rmr){gadgets.rpctx.rmr=function(){var g=500;
var e=10;
var h={};
var b;
var i;
function k(p,n,o,m){var q=function(){document.body.appendChild(p);
p.src="about:blank";
if(m){p.onload=function(){l(m)
}
}p.src=n+"#"+o
};
if(document.body){q()
}else{gadgets.util.registerOnLoadHandler(function(){q()
})
}}function c(o){if(typeof h[o]==="object"){return
}var p=document.createElement("iframe");
var m=p.style;
m.position="absolute";
m.top="0px";
m.border="0";
m.opacity="0";
m.width="10px";
m.height="1px";
p.id="rmrtransport-"+o;
p.name=p.id;
var n=gadgets.rpc.getRelayUrl(o);
if(!n){n=gadgets.rpc.getOrigin(gadgets.util.getUrlParameters()["parent"])+"/robots.txt"
}h[o]={frame:p,receiveWindow:null,relayUri:n,searchCounter:0,width:10,waiting:true,queue:[],sendId:0,recvId:0};
if(o!==".."){k(p,n,a(o))
}d(o)
}function d(o){var q=null;
h[o].searchCounter++;
try{var n=gadgets.rpc._getTargetWin(o);
if(o===".."){q=n.frames["rmrtransport-"+gadgets.rpc.RPC_ID]
}else{q=n.frames["rmrtransport-.."]
}}catch(p){}var m=false;
if(q){m=f(o,q)
}if(!m){if(h[o].searchCounter>e){return
}window.setTimeout(function(){d(o)
},g)
}}function j(n,p,t,s){var o=null;
if(t!==".."){o=h[".."]
}else{o=h[n]
}if(o){if(p!==gadgets.rpc.ACK){o.queue.push(s)
}if(o.waiting||(o.queue.length===0&&!(p===gadgets.rpc.ACK&&s&&s.ackAlone===true))){return true
}if(o.queue.length>0){o.waiting=true
}var m=o.relayUri+"#"+a(n);
try{o.frame.contentWindow.location=m;
var q=o.width==10?20:10;
o.frame.style.width=q+"px";
o.width=q
}catch(r){return false
}}return true
}function a(n){var o=h[n];
var m={id:o.sendId};
if(o){m.d=Array.prototype.slice.call(o.queue,0);
m.d.push({s:gadgets.rpc.ACK,id:o.recvId})
}return gadgets.json.stringify(m)
}function l(x){var u=h[x];
var q=u.receiveWindow.location.hash.substring(1);
var y=gadgets.json.parse(decodeURIComponent(q))||{};
var n=y.d||[];
var o=false;
var t=false;
var v=0;
var m=(u.recvId-y.id);
for(var p=0;
p<n.length;
++p){var s=n[p];
if(s.s===gadgets.rpc.ACK){i(x,true);
if(u.waiting){t=true
}u.waiting=false;
var r=Math.max(0,s.id-u.sendId);
u.queue.splice(0,r);
u.sendId=Math.max(u.sendId,s.id||0);
continue
}o=true;
if(++v<=m){continue
}++u.recvId;
b(s)
}if(o||(t&&u.queue.length>0)){var w=(x==="..")?gadgets.rpc.RPC_ID:"..";
j(x,gadgets.rpc.ACK,w,{ackAlone:o})
}}function f(p,s){var o=h[p];
try{var n=false;
n="document" in s;
if(!n){return false
}n=typeof s.document=="object";
if(!n){return false
}var r=s.location.href;
if(r==="about:blank"){return false
}}catch(m){return false
}o.receiveWindow=s;
function q(){l(p)
}if(typeof s.attachEvent==="undefined"){s.onresize=q
}else{s.attachEvent("onresize",q)
}if(p===".."){k(o.frame,o.relayUri,a(p),p)
}else{l(p)
}return true
}return{getCode:function(){return"rmr"
},isParentVerifiable:function(){return true
},init:function(m,n){b=m;
i=n;
return true
},setup:function(o,m){try{c(o)
}catch(n){gadgets.warn("Caught exception setting up RMR: "+n);
return false
}return true
},call:function(m,o,n){return j(m,n.s,o,n)
}}
}()
};;
;
gadgets.rpctx=gadgets.rpctx||{};
if(!gadgets.rpctx.ifpc){gadgets.rpctx.ifpc=function(){var e=[];
var d=0;
var c;
function b(h){var f=[];
for(var k=0,g=h.length;
k<g;
++k){f.push(encodeURIComponent(gadgets.json.stringify(h[k])))
}return f.join("&")
}function a(j){var g;
for(var f=e.length-1;
f>=0;
--f){var k=e[f];
try{if(k&&(k.recyclable||k.readyState==="complete")){k.parentNode.removeChild(k);
if(window.ActiveXObject){e[f]=k=null;
e.splice(f,1)
}else{k.recyclable=false;
g=k;
break
}}}catch(h){}}if(!g){g=document.createElement("iframe");
g.style.border=g.style.width=g.style.height="0px";
g.style.visibility="hidden";
g.style.position="absolute";
g.onload=function(){this.recyclable=true
};
e.push(g)
}g.src=j;
window.setTimeout(function(){document.body.appendChild(g)
},0)
}return{getCode:function(){return"ifpc"
},isParentVerifiable:function(){return true
},init:function(f,g){c=g;
c("..",true);
return true
},setup:function(g,f){c(g,true);
return true
},call:function(f,k,i){var j=gadgets.rpc.getRelayUrl(f);
++d;
if(!j){gadgets.warn("No relay file assigned for IFPC");
return false
}var h=null;
if(i.l){var g=i.a;
h=[j,"#",b([k,d,1,0,b([k,i.s,"","",k].concat(g))])].join("")
}else{h=[j,"#",f,"&",k,"@",d,"&1&0&",encodeURIComponent(gadgets.json.stringify(i))].join("")
}a(h);
return true
}}
}()
};;
if(!gadgets.rpc){gadgets.rpc=function(){var I="__cb";
var P="";
var Q="__ack";
var f=500;
var C=10;
var c="|";
var r="callback";
var g="origin";
var p="referer";
var o={};
var T={};
var z={};
var x={};
var v=0;
var k={};
var l={};
var N={};
var e={};
var m={};
var A={};
var w=(window.top!==window.self);
var s=window.name;
var F=function(){};
var M=0;
var W=1;
var a=2;
var t=window.console;
var S=t&&t.log?t.log:function(){};
var O=(function(){function aa(ab){return function(){S(ab+": call ignored")
}
}return{getCode:function(){return"noop"
},isParentVerifiable:function(){return true
},init:aa("init"),setup:aa("setup"),call:aa("call")}
})();
if(gadgets.util){e=gadgets.util.getUrlParameters()
}function G(){if(e.flash=="1"){return gadgets.rpctx.flash
}return typeof window.postMessage==="function"?gadgets.rpctx.wpm:typeof window.postMessage==="object"?gadgets.rpctx.wpm:window.ActiveXObject?(gadgets.rpctx.flash?gadgets.rpctx.flash:gadgets.rpctx.nix):navigator.userAgent.indexOf("WebKit")>0?gadgets.rpctx.rmr:navigator.product==="Gecko"?gadgets.rpctx.frameElement:gadgets.rpctx.ifpc
}function j(af,ad){if(m[af]){return
}var ab=D;
if(!ad){ab=O
}m[af]=ab;
var aa=A[af]||[];
for(var ac=0;
ac<aa.length;
++ac){var ae=aa[ac];
ae.t=B(af);
ab.call(af,ae.f,ae)
}A[af]=[]
}var E=false,R=false;
function K(){if(R){return
}function aa(){E=true
}gadgets.util.attachBrowserEvent(window,"unload",aa,false);
R=true
}function i(aa,ae,ab,ad,ac){if(!x[ae]||x[ae]!==ab){gadgets.error("Invalid auth token. "+x[ae]+" vs "+ab);
F(ae,a)
}ac.onunload=function(){if(l[ae]&&!E){F(ae,W);
gadgets.rpc.removeReceiver(ae)
}};
K();
ad=gadgets.json.parse(decodeURIComponent(ad));
D.relayOnload(ae,ad)
}function X(ae,ab){if(ae&&typeof ae.s==="string"&&typeof ae.f==="string"&&ae.a instanceof Array){if(x[ae.f]){if(x[ae.f]!==ae.t){gadgets.error("Invalid auth token. "+x[ae.f]+" vs "+ae.t);
F(ae.f,a)
}}if(ae.s===Q){window.setTimeout(function(){j(ae.f,true)
},0);
return
}if(ae.c){ae[r]=function(af){gadgets.rpc.call(ae.f,I,null,ae.c,af)
}
}if(ab){var ac=q(ab);
ae[g]=ab;
var ad=document.referrer;
if(!ad||q(ad)!=ac){ad=ab
}ae[p]=ad
}var aa=(o[ae.s]||o[P]).apply(ae,ae.a);
if(ae.c&&typeof aa!=="undefined"){gadgets.rpc.call(ae.f,I,null,ae.c,aa)
}}}function q(ac){if(!ac){return""
}ac=ac.toLowerCase();
if(ac.indexOf("//")==0){ac=window.location.protocol+ac
}if(ac.indexOf("://")==-1){ac=window.location.protocol+"//"+ac
}var ad=ac.substring(ac.indexOf("://")+3);
var aa=ad.indexOf("/");
if(aa!=-1){ad=ad.substring(0,aa)
}var af=ac.substring(0,ac.indexOf("://"));
var ae="";
var ag=ad.indexOf(":");
if(ag!=-1){var ab=ad.substring(ag+1);
ad=ad.substring(0,ag);
if((af==="http"&&ab!=="80")||(af==="https"&&ab!=="443")){ae=":"+ab
}}return af+"://"+ad+ae
}function y(ab,aa){return"/"+ab+(aa?c+aa:"")
}function u(ad){if(ad.charAt(0)=="/"){var ab=ad.indexOf(c);
var ac=ab>0?ad.substring(1,ab):ad.substring(1);
var aa=ab>0?ad.substring(ab+1):null;
return{id:ac,origin:aa}
}else{return null
}}function Z(ac){if(typeof ac==="undefined"||ac===".."){return window.parent
}var ab=u(ac);
if(ab){return window.top.frames[ab.id]
}ac=String(ac);
var aa=window.frames[ac];
if(aa){return aa
}aa=document.getElementById(ac);
if(aa&&aa.contentWindow){return aa.contentWindow
}return null
}function H(ad){var ac=null;
var aa=L(ad);
if(aa){ac=aa
}else{var ab=u(ad);
if(ab){ac=ab.origin
}else{if(ad==".."){ac=e.parent
}else{ac=document.getElementById(ad).src
}}}return q(ac)
}var D=G();
o[P]=function(){S("Unknown RPC service: "+this.s)
};
o[I]=function(ab,aa){var ac=k[ab];
if(ac){delete k[ab];
ac.call(this,aa)
}};
function V(ad,ab,aa){if(l[ad]===true){return
}if(typeof l[ad]==="undefined"){l[ad]=0
}var ac=Z(ad);
if(ad===".."||ac!=null){if(D.setup(ad,ab,aa)===true){l[ad]=true;
return
}}if(l[ad]!==true&&l[ad]++<C){window.setTimeout(function(){V(ad,ab,aa)
},f)
}else{m[ad]=O;
l[ad]=true
}}function J(ab,ae){if(typeof N[ab]==="undefined"){N[ab]=false;
var ad=L(ab);
if(q(ad)!==q(window.location.href)){return false
}var ac=Z(ab);
try{var af=ac.gadgets;
N[ab]=af.rpc.receiveSameDomain
}catch(aa){gadgets.error("Same domain call failed: parent= incorrectly set.")
}}if(typeof N[ab]==="function"){N[ab](ae);
return true
}return false
}function L(ab){var aa=T[ab];
if(aa&&aa.substring(0,1)==="/"){if(aa.substring(1,2)==="/"){aa=document.location.protocol+aa
}else{aa=document.location.protocol+"//"+document.location.host+aa
}}return aa
}function Y(ab,aa,ac){if(!/http(s)?:\/\/.+/.test(aa)){if(aa.indexOf("//")==0){aa=window.location.protocol+aa
}else{if(aa.charAt(0)=="/"){aa=window.location.protocol+"//"+window.location.host+aa
}else{if(aa.indexOf("://")==-1){aa=window.location.protocol+"//"+aa
}}}}T[ab]=aa;
z[ab]=!!ac
}function B(aa){return x[aa]
}function d(aa,ac,ab){ac=ac||"";
x[aa]=String(ac);
V(aa,ac,ab)
}function b(aa,ab){function ac(ag){var af=ag?ag.rpc:{};
var ae=af.useLegacyProtocol;
if(typeof ae==="string"){ae=ae==="true"
}var ad=af.parentRelayUrl||"";
ad=q(e.parent)+ad;
var ah=!!ae;
Y("..",ad,ah);
if(ah){D=gadgets.rpctx.ifpc;
D.init(X,j)
}d("..",aa,ab||e.forcesecure)
}gadgets.config.register("rpc",null,ac)
}function U(ad,aa,ae){var ab=ae||e.forcesecure||false;
var ac=aa||e.parent;
if(ac){Y("..",ac);
d("..",ad,ab)
}}function n(ac,ae,aa,ad){if(ac.charAt(0)!="/"){if(!gadgets.util){return
}var ai=document.getElementById(ac);
if(!ai){throw new Error("Cannot set up gadgets.rpc receiver with ID: "+ac+", element not found.")
}}var ag=ae||ai.src;
Y(ac,ag);
var ah=gadgets.util.getUrlParameters(ag);
var ab=aa||ah.rpctoken;
var af=ad||ah.forcesecure;
d(ac,ab,af)
}function h(aa,ac,ae,ad){if(aa===".."){var ab=ae||e.rpctoken||e.ifpctok||"";
if(window.__isgadget===true){b(ab,ad)
}else{U(ab,ac,ad)
}}else{n(aa,ac,ae,ad)
}}return{config:function(aa){if(typeof aa.securityCallback==="function"){F=aa.securityCallback
}},register:function(ab,aa){if(ab===I||ab===Q){throw new Error("Cannot overwrite callback/ack service")
}if(ab===P){throw new Error("Cannot overwrite default service: use registerDefault")
}o[ab]=aa
},unregister:function(aa){if(aa===I||aa===Q){throw new Error("Cannot delete callback/ack service")
}if(aa===P){throw new Error("Cannot delete default service: use unregisterDefault")
}delete o[aa]
},registerDefault:function(aa){o[P]=aa
},unregisterDefault:function(){delete o[P]
},forceParentVerifiable:function(){if(!D.isParentVerifiable()){D=gadgets.rpctx.ifpc
}},call:function(aa,ab,ag,ae){aa=aa||"..";
var af="..";
if(aa===".."){af=s
}else{if(aa.charAt(0)=="/"){af=y(s,gadgets.rpc.getOrigin(window.location.href))
}}++v;
if(ag){k[v]=ag
}var ad={s:ab,f:af,c:ag?v:0,a:Array.prototype.slice.call(arguments,3),t:x[aa],l:z[aa]};
if(aa!==".."&&u(aa)==null&&!document.getElementById(aa)){return
}if(J(aa,ad)){return
}var ac=m[aa];
if(!ac&&u(aa)!==null){ac=D
}if(!ac){if(!A[aa]){A[aa]=[ad]
}else{A[aa].push(ad)
}return
}if(z[aa]){ac=gadgets.rpctx.ifpc
}if(ac.call(aa,af,ad)===false){m[aa]=O;
D.call(aa,af,ad)
}},getRelayUrl:L,setRelayUrl:Y,setAuthToken:d,setupReceiver:h,getAuthToken:B,removeReceiver:function(aa){delete T[aa];
delete z[aa];
delete x[aa];
delete l[aa];
delete N[aa];
delete m[aa]
},getRelayChannel:function(){return D.getCode()
},receive:function(ab,aa){if(ab.length>4){X(gadgets.json.parse(decodeURIComponent(ab[ab.length-1])))
}else{i.apply(null,ab.concat(aa))
}},receiveSameDomain:function(aa){aa.a=Array.prototype.slice.call(aa.a);
window.setTimeout(function(){X(aa)
},0)
},getOrigin:q,getTargetOrigin:H,init:function(){if(D.init(X,j)===false){D=O
}if(w){h("..")
}},_getTargetWin:Z,_parseSiblingId:u,_createRelayIframe:function(aa,ac){var af=L("..");
if(!af){return null
}var ae=af+"#..&"+s+"&"+aa+"&"+encodeURIComponent(gadgets.json.stringify(ac));
var ab=document.createElement("iframe");
ab.style.border=ab.style.width=ab.style.height="0px";
ab.style.visibility="hidden";
ab.style.position="absolute";
function ad(){document.body.appendChild(ab);
ab.src='javascript:"<html></html>"';
ab.src=ae
}if(document.body){ad()
}else{gadgets.util.registerOnLoadHandler(function(){ad()
})
}return ab
},ACK:Q,RPC_ID:s||"..",SEC_ERROR_LOAD_TIMEOUT:M,SEC_ERROR_FRAME_PHISH:W,SEC_ERROR_FORGED_MSG:a}
}();
gadgets.rpc.init()
};;
gadgets.config.init({"rpc":{"commSwf":"//xpc.googleusercontent.com/gadgets","parentRelayUrl":"/rpc_relay.html"}});
var friendconnect_serverBase = "http://www.google.com";var friendconnect_loginUrl = "https://www.google.com/accounts";var friendconnect_gadgetPrefix = "http://www-a-fc-opensocial.googleusercontent.com/gadgets";
var friendconnect_serverVersion = "0.558.7";
var friendconnect_imageUrl = "http://www.google.com/friendconnect/scs/images";
var friendconnect_lightbox = true;
function fca(a){throw a;}var fcb=void 0,fcc=null,fcd=gadgets,fce=Error,fcf=friendconnect_serverBase,fcg=encodeURIComponent,fcaa=parseInt,fch=String,fci=window,fcba=setTimeout,fcca=Object,fcj=document,fck=Array,fcl=Math;function fcda(a,b){return a.length=b}function fcea(a,b){return a.className=b}function fcm(a,b){return a.width=b}function fcn(a,b){return a.innerHTML=b}function fco(a,b){return a.height=b}
var fcp="appendChild",fcq="push",fcfa="toString",fcr="length",fcga="propertyIsEnumerable",fcha="stringify",fc="prototype",fcia="test",fcs="width",fct="round",fcu="slice",fcv="replace",fcw="document",fcja="data",fcx="split",fcy="getElementById",fcz="charAt",fcA="location",fcB="getUrlParameters",fcC="indexOf",fcka="Dialog",fcD="style",fcla="body",fcE="call",fcF="match",fcG="options",fcma="random",fcH="createElement",fcI="json",fcna="addEventListener",fcJ="setAttribute",fcoa="href",fcpa="substring",
fcK="util",fcqa="maxHeight",fcra="type",fcL="apply",fcsa="auth",fcta="reset",fcua="getSecurityToken",fcva="bind",fcM="name",fcwa="display",fcN="height",fcO="register",fcP="join",fcxa="unshift",fcya="toLowerCase",fcza="right",goog=goog||{},fcQ=this,fcBa=function(a,b,c){a=a[fcx](".");c=c||fcQ;!(a[0]in c)&&c.execScript&&c.execScript("var "+a[0]);for(var d;a[fcr]&&(d=a.shift());)!a[fcr]&&fcAa(b)?c[d]=b:c=c[d]?c[d]:c[d]={}},fcCa=function(a){var b=typeof a;if(b=="object")if(a){if(a instanceof fck)return"array";
else if(a instanceof fcca)return b;var c=fcca[fc][fcfa][fcE](a);if(c=="[object Window]")return"object";if(c=="[object Array]"||typeof a[fcr]=="number"&&typeof a.splice!="undefined"&&typeof a[fcga]!="undefined"&&!a[fcga]("splice"))return"array";if(c=="[object Function]"||typeof a[fcE]!="undefined"&&typeof a[fcga]!="undefined"&&!a[fcga]("call"))return"function"}else return"null";else if(b=="function"&&typeof a[fcE]=="undefined")return"object";return b},fcAa=function(a){return a!==fcb},fcDa=function(a){var b=
fcCa(a);return b=="array"||b=="object"&&typeof a[fcr]=="number"},fcR=function(a){return typeof a=="string"},fcEa=function(a){a=fcCa(a);return a=="object"||a=="array"||a=="function"};fcl.floor(fcl[fcma]()*2147483648)[fcfa](36);
var fcS=function(a){var b=fcCa(a);if(b=="object"||b=="array"){if(a.clone)return a.clone();var b=b=="array"?[]:{},c;for(c in a)b[c]=fcS(a[c]);return b}return a},fcFa=function(a){return a[fcE][fcL](a[fcva],arguments)},fcGa=function(a,b){var c=b||fcQ;if(arguments[fcr]>2){var d=fck[fc][fcu][fcE](arguments,2);return function(){var b=fck[fc][fcu][fcE](arguments);fck[fc][fcxa][fcL](b,d);return a[fcL](c,b)}}else return function(){return a[fcL](c,arguments)}},fcT=function(){fcT=Function[fc][fcva]&&Function[fc][fcva][fcfa]()[fcC]("native code")!=
-1?fcFa:fcGa;return fcT[fcL](fcc,arguments)},fcHa=function(a){var b=fck[fc][fcu][fcE](arguments,1);return function(){var c=fck[fc][fcu][fcE](arguments);c[fcxa][fcL](c,b);return a[fcL](this,c)}},fcIa=function(a,b){for(var c in b)a[c]=b[c]},fcJa=Date.now||function(){return+new Date},fcU=function(a,b,c){fcBa(a,b,c)},fcV=function(a,b){function c(){}c.prototype=b[fc];a.Qc=b[fc];a.prototype=new c;a[fc].constructor=a};
Function[fc].bind=Function[fc][fcva]||function(a){if(arguments[fcr]>1){var b=fck[fc][fcu][fcE](arguments,1);b[fcxa](this,a);return fcT[fcL](fcc,b)}else return fcT(this,a)};SHA1=function(){this.c=fck(5);this.ca=fck(64);this.Hc=fck(80);this.ta=fck(64);this.ta[0]=128;for(var a=1;a<64;++a)this.ta[a]=0;this[fcta]()};SHA1[fc].reset=function(){this.c[0]=1732584193;this.c[1]=4023233417;this.c[2]=2562383102;this.c[3]=271733878;this.c[4]=3285377520;this.Aa=this.A=0};SHA1[fc].ya=function(a,b){return(a<<b|a>>>32-b)&4294967295};
SHA1[fc].L=function(a){for(var b=this.Hc,c=0;c<64;c+=4){var d=a[c]<<24|a[c+1]<<16|a[c+2]<<8|a[c+3];b[c/4]=d}for(c=16;c<80;++c)b[c]=this.ya(b[c-3]^b[c-8]^b[c-14]^b[c-16],1);for(var a=this.c[0],d=this.c[1],e=this.c[2],f=this.c[3],j=this.c[4],i,k,c=0;c<80;++c)c<40?c<20?(i=f^d&(e^f),k=1518500249):(i=d^e^f,k=1859775393):c<60?(i=d&e|f&(d|e),k=2400959708):(i=d^e^f,k=3395469782),i=this.ya(a,5)+i+j+k+b[c]&4294967295,j=f,f=e,e=this.ya(d,30),d=a,a=i;this.c[0]=this.c[0]+a&4294967295;this.c[1]=this.c[1]+d&4294967295;
this.c[2]=this.c[2]+e&4294967295;this.c[3]=this.c[3]+f&4294967295;this.c[4]=this.c[4]+j&4294967295};SHA1[fc].update=function(a,b){b||(b=a[fcr]);var c=0;if(this.A==0)for(;c+64<b;)this.L(a[fcu](c,c+64)),c+=64,this.Aa+=64;for(;c<b;)if(this.ca[this.A++]=a[c++],++this.Aa,this.A==64){this.A=0;for(this.L(this.ca);c+64<b;)this.L(a[fcu](c,c+64)),c+=64,this.Aa+=64}};
SHA1[fc].digest=function(){var a=fck(20),b=this.Aa*8;this.A<56?this.update(this.ta,56-this.A):this.update(this.ta,64-(this.A-56));for(var c=63;c>=56;--c)this.ca[c]=b&255,b>>>=8;this.L(this.ca);for(c=b=0;c<5;++c)for(var d=24;d>=0;d-=8)a[b++]=this.c[c]>>d&255;return a};G_HMAC=function(a,b,c){(!a||typeof a!="object"||!a[fcta]||!a.update||!a.digest)&&fca(fce("Invalid hasher object. Hasher unspecified or does not implement expected interface."));b.constructor!=fck&&fca(fce("Invalid key."));c&&typeof c!="number"&&fca(fce("Invalid block size."));this.k=a;this.ba=c||16;this.Wb=fck(this.ba);this.Vb=fck(this.ba);b[fcr]>this.ba&&(this.k.update(b),b=this.k.digest());for(c=0;c<this.ba;c++)a=c<b[fcr]?b[c]:0,this.Wb[c]=a^G_HMAC.OPAD,this.Vb[c]=a^G_HMAC.IPAD};G_HMAC.OPAD=92;
G_HMAC.IPAD=54;G_HMAC[fc].reset=function(){this.k[fcta]();this.k.update(this.Vb)};G_HMAC[fc].update=function(a){a.constructor!=fck&&fca(fce("Invalid data. Data must be an array."));this.k.update(a)};G_HMAC[fc].digest=function(){var a=this.k.digest();this.k[fcta]();this.k.update(this.Wb);this.k.update(a);return this.k.digest()};G_HMAC[fc].Ib=function(a){this[fcta]();this.update(a);return this.digest()};var fcKa=function(a){for(var b=1;b<arguments[fcr];b++)var c=fch(arguments[b])[fcv](/\$/g,"$$$$"),a=a[fcv](/\%s/,c);return a},fcLa=function(a,b){var c=fch(a)[fcya](),d=fch(b)[fcya]();return c<d?-1:c==d?0:1},fcRa=function(a,b){if(b)return a[fcv](fcMa,"&amp;")[fcv](fcNa,"&lt;")[fcv](fcOa,"&gt;")[fcv](fcPa,"&quot;");else{if(!fcQa[fcia](a))return a;a[fcC]("&")!=-1&&(a=a[fcv](fcMa,"&amp;"));a[fcC]("<")!=-1&&(a=a[fcv](fcNa,"&lt;"));a[fcC](">")!=-1&&(a=a[fcv](fcOa,"&gt;"));a[fcC]('"')!=-1&&(a=a[fcv](fcPa,
"&quot;"));return a}},fcMa=/&/g,fcNa=/</g,fcOa=/>/g,fcPa=/\"/g,fcQa=/[&<>\"]/,fcTa=function(a,b){for(var c=0,d=fch(a)[fcv](/^[\s\xa0]+|[\s\xa0]+$/g,"")[fcx]("."),e=fch(b)[fcv](/^[\s\xa0]+|[\s\xa0]+$/g,"")[fcx]("."),f=fcl.max(d[fcr],e[fcr]),j=0;c==0&&j<f;j++){var i=d[j]||"",k=e[j]||"",l=RegExp("(\\d*)(\\D*)","g"),h=RegExp("(\\d*)(\\D*)","g");do{var g=l.exec(i)||["","",""],m=h.exec(k)||["","",""];if(g[0][fcr]==0&&m[0][fcr]==0)break;var c=g[1][fcr]==0?0:fcaa(g[1],10),p=m[1][fcr]==0?0:fcaa(m[1],10),c=
fcSa(c,p)||fcSa(g[2][fcr]==0,m[2][fcr]==0)||fcSa(g[2],m[2])}while(c==0)}return c},fcSa=function(a,b){if(a<b)return-1;else if(a>b)return 1;return 0},fcUa={},fcVa=function(a){return fcUa[a]||(fcUa[a]=fch(a)[fcv](/\-([a-z])/g,function(a,c){return c.toUpperCase()}))};var fcWa,fcXa,fcYa,fcZa,fc_a,fc0a=function(){return fcQ.navigator?fcQ.navigator.userAgent:fcc},fc1a=function(){return fcQ.navigator},fc2a=function(){fc_a=fcZa=fcYa=fcXa=fcWa=!1;var a;if(a=fc0a()){var b=fc1a();fcWa=a[fcC]("Opera")==0;fcXa=!fcWa&&a[fcC]("MSIE")!=-1;fcZa=(fcYa=!fcWa&&a[fcC]("WebKit")!=-1)&&a[fcC]("Mobile")!=-1;fc_a=!fcWa&&!fcYa&&b.product=="Gecko"}};fc2a();
var fc3a=fcWa,fcW=fcXa,fc4a=fc_a,fc5a=fcYa,fc6a=fcZa,fc7a=function(){var a=fc1a();return a&&a.platform||""},fc8a=fc7a(),fc9a=function(){fc8a[fcC]("Mac");fc8a[fcC]("Win");fc8a[fcC]("Linux");fc1a()&&(fc1a().appVersion||"")[fcC]("X11")};fc9a();
var fcab=function(){var a="",b;fc3a&&fcQ.opera?(a=fcQ.opera.version,a=typeof a=="function"?a():a):(fc4a?b=/rv\:([^\);]+)(\)|;)/:fcW?b=/MSIE\s+([^\);]+)(\)|;)/:fc5a&&(b=/WebKit\/(\S+)/),b&&(a=(a=b.exec(fc0a()))?a[1]:""));if(fcW&&(b=fc$a(),b>parseFloat(a)))return fch(b);return a},fc$a=function(){var a=fcQ[fcw];return a?a.documentMode:fcb},fcbb=fcab(),fccb={},fcX=function(a){return fccb[a]||(fccb[a]=fcTa(fcbb,a)>=0)};var fcdb=function(a){for(var b=[],c=0,d=0;d<a[fcr];d++){for(var e=a.charCodeAt(d);e>255;)b[c++]=e&255,e>>=8;b[c++]=e}return b};var fceb=fcc,fcfb=fcc,fcgb=fcc,fchb=fcc,fcjb=function(a,b){fcDa(a)||fca(fce("encodeByteArray takes an array as a parameter"));fcib();for(var c=b?fcgb:fceb,d=[],e=0;e<a[fcr];e+=3){var f=a[e],j=e+1<a[fcr],i=j?a[e+1]:0,k=e+2<a[fcr],l=k?a[e+2]:0,h=f>>2,f=(f&3)<<4|i>>4,i=(i&15)<<2|l>>6;l&=63;k||(l=64,j||(i=64));d[fcq](c[h],c[f],c[i],c[l])}return d[fcP]("")},fckb=function(a,b){fcib();for(var c=b?fchb:fcfb,d=[],e=0;e<a[fcr];){var f=c[a[fcz](e++)],j=e<a[fcr],j=j?c[a[fcz](e)]:0;++e;var i=e<a[fcr],i=i?c[a[fcz](e)]:
0;++e;var k=e<a[fcr],k=k?c[a[fcz](e)]:0;++e;(f==fcc||j==fcc||i==fcc||k==fcc)&&fca(fce());f=f<<2|j>>4;d[fcq](f);i!=64&&(f=j<<4&240|i>>2,d[fcq](f),k!=64&&(f=i<<6&192|k,d[fcq](f)))}return d},fcib=function(){if(!fceb){fceb={};fcfb={};fcgb={};fchb={};for(var a=0;a<65;a++)fceb[a]="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/="[fcz](a),fcfb[fceb[a]]=a,fcgb[a]="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_."[fcz](a),fchb[fcgb[a]]=a}};var fcY=function(a){this.wb=a},fclb=/\s*;\s*/;fcY[fc].Tb=function(a){return!/[;=\s]/[fcia](a)};fcY[fc].Ub=function(a){return!/[;\r\n]/[fcia](a)};fcY[fc].set=function(a,b,c,d,e,f){this.Tb(a)||fca(fce('Invalid cookie name "'+a+'"'));this.Ub(b)||fca(fce('Invalid cookie value "'+b+'"'));fcAa(c)||(c=-1);e=e?";domain="+e:"";d=d?";path="+d:"";f=f?";secure":"";c<0?c="":(c=c==0?new Date(1970,1,1):new Date(fcJa()+c*1E3),c=";expires="+c.toUTCString());this.vc(a+"="+b+e+d+c+f)};
fcY[fc].get=function(a,b){for(var c=a+"=",d=this.ka(),e=0,f;f=d[e];e++)if(f[fcC](c)==0)return f.substr(c[fcr]);return b};fcY[fc].remove=function(a,b,c){var d=this.M(a);this.set(a,"",0,b,c);return d};fcY[fc].z=function(){return this.ia().keys};fcY[fc].F=function(){return this.ia().values};fcY[fc].P=function(){var a=this.Oa();if(!a)return 0;return this.ka()[fcr]};fcY[fc].M=function(a){return fcAa(this.get(a))};fcY[fc].clear=function(){for(var a=this.ia().keys,b=a[fcr]-1;b>=0;b--)this.remove(a[b])};
fcY[fc].vc=function(a){this.wb.cookie=a};fcY[fc].Oa=function(){return this.wb.cookie};fcY[fc].ka=function(){return(this.Oa()||"")[fcx](fclb)};fcY[fc].ia=function(){for(var a=this.ka(),b=[],c=[],d,e,f=0;e=a[f];f++)d=e[fcC]("="),d==-1?(b[fcq](""),c[fcq](e)):(b[fcq](e[fcpa](0,d)),c[fcq](e[fcpa](d+1)));return{keys:b,values:c}};var fcmb=new fcY(fcj);fcmb.MAX_COOKIE_LENGTH=3950;var fcnb=function(a){this.stack=fce().stack||"";if(a)this.message=fch(a)};fcV(fcnb,fce);fcnb[fc].name="CustomError";var fcob=function(a,b){b[fcxa](a);fcnb[fcE](this,fcKa[fcL](fcc,b));b.shift();this.messagePattern=a};fcV(fcob,fcnb);fcob[fc].name="AssertionError";var fcpb=function(a,b,c,d){var e="Assertion failed";if(c){e+=": "+c;var f=d}else a&&(e+=": "+a,f=b);fca(new fcob(""+e,f||[]))},fcqb=function(a,b){a||fcpb("",fcc,b,fck[fc][fcu][fcE](arguments,2));return a};var fcZ=fck[fc],fcrb=fcZ[fcC]?function(a,b,c){fcqb(a[fcr]!=fcc);return fcZ[fcC][fcE](a,b,c)}:function(a,b,c){c=c==fcc?0:c<0?fcl.max(0,a[fcr]+c):c;if(fcR(a)){if(!fcR(b)||b[fcr]!=1)return-1;return a[fcC](b,c)}for(;c<a[fcr];c++)if(c in a&&a[c]===b)return c;return-1},fcsb=fcZ.forEach?function(a,b,c){fcqb(a[fcr]!=fcc);fcZ.forEach[fcE](a,b,c)}:function(a,b,c){for(var d=a[fcr],e=fcR(a)?a[fcx](""):a,f=0;f<d;f++)f in e&&b[fcE](c,e[f],f,a)},fctb=function(a,b){return fcrb(a,b)>=0},fcub=function(){return fcZ.concat[fcL](fcZ,
arguments)},fcvb=function(a){if(fcCa(a)=="array")return fcub(a);else{for(var b=[],c=0,d=a[fcr];c<d;c++)b[c]=a[c];return b}},fcwb=function(a,b,c){fcqb(a[fcr]!=fcc);return arguments[fcr]<=2?fcZ[fcu][fcE](a,b):fcZ[fcu][fcE](a,b,c)};var fc_=function(a,b){fcm(this,a);fco(this,b)};fc_[fc].clone=function(){return new fc_(this[fcs],this[fcN])};fc_[fc].toString=function(){return"("+this[fcs]+" x "+this[fcN]+")"};fc_[fc].ceil=function(){fcm(this,fcl.ceil(this[fcs]));fco(this,fcl.ceil(this[fcN]));return this};fc_[fc].floor=function(){fcm(this,fcl.floor(this[fcs]));fco(this,fcl.floor(this[fcN]));return this};fc_[fc].round=function(){fcm(this,fcl[fct](this[fcs]));fco(this,fcl[fct](this[fcN]));return this};
fc_[fc].scale=function(a){this.width*=a;this.height*=a;return this};var fcxb=function(a,b,c){for(var d in a)b[fcE](c,a[d],d,a)},fcyb=function(a){var b=[],c=0,d;for(d in a)b[c++]=a[d];return b},fczb=function(a){var b=[],c=0,d;for(d in a)b[c++]=d;return b},fcAb=["constructor","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","toLocaleString","toString","valueOf"],fcBb=function(a){for(var b,c,d=1;d<arguments[fcr];d++){c=arguments[d];for(b in c)a[b]=c[b];for(var e=0;e<fcAb[fcr];e++)b=fcAb[e],fcca[fc].hasOwnProperty[fcE](c,b)&&(a[b]=c[b])}};var fcCb=!fcW||fcX("9");!fc4a&&!fcW||fcW&&fcX("9")||fc4a&&fcX("1.9.1");fcW&&fcX("9");var fcDb=function(a){return(a=a.className)&&typeof a[fcx]=="function"?a[fcx](/\s+/):[]},fcFb=function(a){var b=fcDb(a),c=fcwb(arguments,1),c=fcEb(b,c);fcea(a,b[fcP](" "));return c},fcEb=function(a,b){for(var c=0,d=0;d<b[fcr];d++)fctb(a,b[d])||(a[fcq](b[d]),c++);return c==b[fcr]};var fcGb=function(a){return fcR(a)?fcj[fcy](a):a},fcHb=fcGb,fcIb=function(a,b,c,d){a=d||a;b=b&&b!="*"?b.toUpperCase():"";if(a.querySelectorAll&&a.querySelector&&(!fc5a||fcj.compatMode=="CSS1Compat"||fcX("528"))&&(b||c))return c=b+(c?"."+c:""),a.querySelectorAll(c);if(c&&a.getElementsByClassName)if(a=a.getElementsByClassName(c),b){for(var d={},e=0,f=0,j;j=a[f];f++)b==j.nodeName&&(d[e++]=j);fcda(d,e);return d}else return a;a=a.getElementsByTagName(b||"*");if(c){d={};for(f=e=0;j=a[f];f++)b=j.className,
typeof b[fcx]=="function"&&fctb(b[fcx](/\s+/),c)&&(d[e++]=j);fcda(d,e);return d}else return a},fcKb=function(a,b){fcxb(b,function(b,d){d=="style"?a[fcD].cssText=b:d=="class"?fcea(a,b):d=="for"?a.htmlFor=b:d in fcJb?a[fcJ](fcJb[d],b):a[d]=b})},fcJb={cellpadding:"cellPadding",cellspacing:"cellSpacing",colspan:"colSpan",rowspan:"rowSpan",valign:"vAlign",height:"height",width:"width",usemap:"useMap",frameborder:"frameBorder",maxlength:"maxLength",type:"type"},fcLb=function(a){var b=a[fcw];if(fc5a&&!fcX("500")&&
!fc6a){typeof a.innerHeight=="undefined"&&(a=fci);var b=a.innerHeight,c=a[fcw].documentElement.scrollHeight;a==a.top&&c<b&&(b-=15);return new fc_(a.innerWidth,b)}a=b.compatMode=="CSS1Compat"?b.documentElement:b[fcla];return new fc_(a.clientWidth,a.clientHeight)},fc0=function(){return fcMb(fcj,arguments)},fcMb=function(a,b){var c=b[0],d=b[1];if(!fcCb&&d&&(d[fcM]||d[fcra])){c=["<",c];d[fcM]&&c[fcq](' name="',fcRa(d[fcM]),'"');if(d[fcra]){c[fcq](' type="',fcRa(d[fcra]),'"');var e={};fcBb(e,d);d=e;delete d[fcra]}c[fcq](">");
c=c[fcP]("")}c=a[fcH](c);d&&(fcR(d)?fcea(c,d):fcCa(d)=="array"?fcFb[fcL](fcc,[c].concat(d)):fcKb(c,d));b[fcr]>2&&fcNb(a,c,b,2);return c},fcNb=function(a,b,c,d){function e(c){c&&b[fcp](fcR(c)?a.createTextNode(c):c)}for(;d<c[fcr];d++){var f=c[d];fcDa(f)&&!(fcEa(f)&&f.nodeType>0)?fcsb(fcOb(f)?fcvb(f):f,e):e(f)}},fcOb=function(a){if(a&&typeof a[fcr]=="number")if(fcEa(a))return typeof a.item=="function"||typeof a.item=="string";else if(fcCa(a)=="function")return typeof a.item=="function";return!1};var fcPb="StopIteration"in fcQ?fcQ.StopIteration:fce("StopIteration"),fcQb=function(){};fcQb[fc].next=function(){fca(fcPb)};fcQb[fc].__iterator__=function(){return this};var fc1=function(a){this.i={};this.e=[];var b=arguments[fcr];if(b>1){b%2&&fca(fce("Uneven number of arguments"));for(var c=0;c<b;c+=2)this.set(arguments[c],arguments[c+1])}else a&&this.nb(a)};fc1[fc].q=0;fc1[fc].J=0;fc1[fc].P=function(){return this.q};fc1[fc].F=function(){this.K();for(var a=[],b=0;b<this.e[fcr];b++){var c=this.e[b];a[fcq](this.i[c])}return a};fc1[fc].z=function(){this.K();return this.e.concat()};fc1[fc].M=function(a){return fcRb(this.i,a)};
fc1[fc].clear=function(){this.i={};fcda(this.e,0);this.J=this.q=0};fc1[fc].remove=function(a){if(fcRb(this.i,a))return delete this.i[a],this.q--,this.J++,this.e[fcr]>2*this.q&&this.K(),!0;return!1};fc1[fc].K=function(){if(this.q!=this.e[fcr]){for(var a=0,b=0;a<this.e[fcr];){var c=this.e[a];fcRb(this.i,c)&&(this.e[b++]=c);a++}fcda(this.e,b)}if(this.q!=this.e[fcr]){for(var d={},b=a=0;a<this.e[fcr];)c=this.e[a],fcRb(d,c)||(this.e[b++]=c,d[c]=1),a++;fcda(this.e,b)}};
fc1[fc].get=function(a,b){if(fcRb(this.i,a))return this.i[a];return b};fc1[fc].set=function(a,b){fcRb(this.i,a)||(this.q++,this.e[fcq](a),this.J++);this.i[a]=b};fc1[fc].nb=function(a){var b;a instanceof fc1?(b=a.z(),a=a.F()):(b=fczb(a),a=fcyb(a));for(var c=0;c<b[fcr];c++)this.set(b[c],a[c])};fc1[fc].clone=function(){return new fc1(this)};
fc1[fc].__iterator__=function(a){this.K();var b=0,c=this.e,d=this.i,e=this.J,f=this,j=new fcQb;j.next=function(){for(;;){e!=f.J&&fca(fce("The map has changed since the iterator was created"));b>=c[fcr]&&fca(fcPb);var j=c[b++];return a?j:d[j]}};return j};var fcRb=function(a,b){return fcca[fc].hasOwnProperty[fcE](a,b)};var fcTb=function(a,b,c){fcR(b)?fcSb(a,c,b):fcxb(b,fcHa(fcSb,a))},fcSb=function(a,b,c){a[fcD][fcVa(c)]=b},fcUb=function(a,b){var c=a.nodeType==9?a:a.ownerDocument||a[fcw];if(c.defaultView&&c.defaultView.getComputedStyle&&(c=c.defaultView.getComputedStyle(a,fcc)))return c[b]||c.getPropertyValue(b);return""},fcXb=function(a,b,c){b instanceof fc_?(c=b[fcN],b=b[fcs]):c==fcb&&fca(fce("missing height argument"));fcVb(a,b);fcWb(a,c)},fcYb=function(a,b){typeof a=="number"&&(a=(b?fcl[fct](a):a)+"px");return a},
fcWb=function(a,b){fco(a[fcD],fcYb(b,!0))},fcVb=function(a,b){fcm(a[fcD],fcYb(b,!0))},fcZb=function(a){if((fcUb(a,"display")||(a.currentStyle?a.currentStyle[fcwa]:fcc)||a[fcD][fcwa])!="none")return new fc_(a.offsetWidth,a.offsetHeight);var b=a[fcD],c=b[fcwa],d=b.visibility,e=b.position;b.visibility="hidden";b.position="absolute";b.display="inline";var f=a.offsetWidth,a=a.offsetHeight;b.display=c;b.position=e;b.visibility=d;return new fc_(f,a)},fc_b=function(a,b){a[fcD].display=b?"":"none"};var fc0b={},fc1b={};var fc2b=function(a,b,c,d){b=b||"800";c=c||"550";d=d||"friendconnect";a=fci.open(a,d,"menubar=no,toolbar=no,dialog=yes,location=yes,alwaysRaised=yes,width="+b+",height="+c+",resizable=yes,scrollbars=1,status=1");fci.focus&&a&&a.focus()},fc3b=function(a,b){var c=fcd[fcK][fcB]().communityId;fcd.rpc[fcE](fcc,"signin",fcc,c,a,b)};fcU("goog.peoplesense.util.openPopup",fc2b);fcU("goog.peoplesense.util.finishSignIn",fc3b);var fc6b=function(a,b){var c=fc4b()+"/friendconnect/invite/friends",d=fcg(shindig[fcsa][fcua]());fc5b(c,d,a,b)},fc5b=function(a,b,c,d){a+="?st="+b;c&&(a+="&customMessage="+fcg(c));d&&(a+="&customInviteUrl="+fcg(d));b=760;fcW&&(b+=25);fc2b(a,fch(b),"515","friendconnect_invite")};fcU("goog.peoplesense.util.invite",fc6b);fcU("goog.peoplesense.util.inviteFriends",fc5b);var fc7b=function(a){this.url=a};fc7b[fc].l=function(a,b){(this.url[fcC]("?"+a+"=")>=0||this.url[fcC]("&"+a+"=")>=0)&&fca(fce("duplicate: "+a));if(b===fcc||b===fcb)return this;var c=this.url[fcC]("?")>=0?"&":"?";this.url+=c+a+"="+fcg(b);return this};fc7b[fc].toString=function(){return this.url};var fc4b=function(){return fci.friendconnect_serverBase},fc8b=function(a,b,c,d,e,f,j){b=b||"800";c=c||"550";d=d||"friendconnect";f=f||!1;fcd.rpc[fcE](fcc,"openLightboxIframe",j,a,shindig[fcsa][fcua](),b,c,d,e,fcc,fcc,fcc,f)},fc9b=function(a,b){var c=fcd[fcK][fcB]().psinvite||"",d=new fc7b(fc4b()+"/friendconnect/signin/home");d.l("st",fci.shindig[fcsa][fcua]());d.l("psinvite",c);d.l("iframeId",a);d.l("loginProvider",b);d.l("subscribeOnSignin","1");fc2b(d[fcfa]());return!1},fc$b=function(){var a=fcd[fcK][fcB]().communityId;
fcd.rpc[fcE](fcc,"signout",fcc,a)},fcbc=function(a,b){var c=fc4b()+"/friendconnect/settings/edit?st="+fcg(shindig[fcsa][fcua]())+(a?"&iframeId="+fcg(a):"");b&&(c=c+"&"+b);fcac(c)},fccc=function(a){a=fc4b()+"/friendconnect/settings/siteProfile?st="+fcg(a);fcac(a)},fcac=function(a){var b=800,c=510;fcW&&(b+=25);fc2b(a,fch(b),fch(c))},fcdc=function(a,b,c,d){var d=d||2,e=fcc;if(b=="text")e=fc0("div",{"class":"gfc-button-text"},fc0("div",{"class":"gfc-icon"},fc0("a",{href:"javascript:void(0);"},c))),a[fcp](e);
else if(b=="long"||b=="standard")e=d==1?fc0("div",{"class":"gfc-inline-block gfc-primaryactionbutton gfc-button-base"},fc0("div",{"class":"gfc-inline-block gfc-button-base-outer-box"},fc0("div",{"class":"gfc-inline-block gfc-button-base-inner-box"},fc0("div",{"class":"gfc-button-base-pos"},fc0("div",{"class":"gfc-button-base-top-shadow",innerHTML:"&nbsp;"}),fc0("div",{"class":"gfc-button-base-content"},fc0("div",{"class":"gfc-icon"},c)))))):fc0("table",{"class":"gfc-button-base-v2 gfc-button",cellpadding:"0",
cellspacing:"0"},fc0("tbody",{"class":""},fc0("tr",{"class":""},fc0("td",{"class":"gfc-button-base-v2 gfc-button-1"}),fc0("td",{"class":"gfc-button-base-v2 gfc-button-2"},c),fc0("td",{"class":"gfc-button-base-v2 gfc-button-3"})))),a[fcp](e),b=="standard"&&(b=fc0("div",{"class":"gfc-footer-msg"},"with Google Friend Connect"),d==1&&a[fcp](fc0("br")),a[fcp](b));return e},fcec=function(a,b){a||fca("google.friendconnect.renderSignInButton: missing options");var c=a[fcD]||"standard",d=a.text,e=a.version;
if(c=="standard")d=a.text||"Sign in";else if(c=="text"||c=="long")d=a.text||"Sign in with Friend Connect";var f=a.element;if(!f)(f=a.id)||fca("google.friendconnect.renderSignInButton: options[id] and options[element] == null"),(f=fcHb(f))||fca("google.friendconnect.renderSignInButton: element "+a.id+" not found");fcn(f,"");c=fcdc(f,c,d,e);fci[fcna]?c[fcna]("click",b,!1):c.attachEvent("onclick",b)},fcfc=function(a,b){b=b||fcT(fc9b,fcc,fcc,fcc,fcc);fcec(a,b)},fcgc=function(a,b){fcd.rpc[fcE](fcc,"putReloadViewParam",
fcc,a,b);var c=fcd.views.getParams();c[a]=b},fchc=function(a,b){var c=new fc7b("/friendconnect/gadgetshare/friends");c.l("customMessage",a);c.l("customInviteUrl",b);c.l("container","glb");var d=310;fcW&&(d+=25);fc8b(c[fcfa](),fch(d),"370")};fcU("goog.peoplesense.util.getBaseUrl",fc4b);fcU("goog.peoplesense.util.finishSignIn",fc3b);fcU("goog.peoplesense.util.signout",fc$b);fcU("goog.peoplesense.util.signin",fc9b);fcU("goog.peoplesense.util.editSettings",fcbc);
fcU("goog.peoplesense.util.editSSProfile",fccc);fcU("goog.peoplesense.util.setStickyViewParamToken",fcgc);fcU("google.friendconnect.renderSignInButton",fcfc);fcU("goog.peoplesense.util.share",fchc);fcU("goog.peoplesense.util.userAgent.IE",fcW);var fcic={},fcjc={},fc2=function(a){this.h=new fc1;this.snippetId=a.id;this.site=a.site;var a=a["view-params"],b=a.skin;this.gc=(b?b.POSITION:"top")||"top";this.Ic={allowAnonymousPost:a.allowAnonymousPost||!1,scope:a.scope||"SITE",docId:a.docId||"",features:a.features||"video,comment",startMaximized:"true",disableMinMax:"true",skin:b};this.absoluteBottom=fcW&&!fcX("7");this.fixedIeSizes=fcW;fci[fcna]?fci[fcna]("resize",fcT(this.db,this),!1):fci.attachEvent("onresize",fcT(this.db,this));this.sb()};
fc2[fc].sb=function(){this.site||fca(fce("Must supply site ID."));this.snippetId||fca(fce("Must supply a snippet ID."))};fc2[fc].b=10;fc2[fc].Da=1;fc2[fc].p="fc-friendbar-";fc2[fc].t=fc2[fc].p+"outer";fc2[fc].gb=fc2[fc].t+"-shadow";fc2[fc].render=function(){fcj.write(this.Ab());var a=fcGb(this.snippetId);fcn(a,this.O())};fc2[fc].Bb=function(){var a=fcGb(this.t);return a=fcZb(a)[fcs]};fc2[fc].db=function(){for(var a=this.h.z(),b=0;b<a[fcr];b++)this.sc(a[b]);goog&&fc0b&&fc1b&&fckc&&fclc("resize")};
fc2[fc].n=function(){return this.gc};fc2[fc].d=function(a){return this.p+"shadow-"+a};fc2[fc].ja=function(a){return this.p+"menus-"+a};fc2[fc].R=function(a){return this.p+a+"Target"};fc2[fc].ga=function(a){return this.p+a+"Drawer"};fc2[fc].Ta=function(){return this.R("")};fc2[fc].Ua=function(){return this.p+"wallpaper"};fc2[fc].Pa=function(){return this.ga("")};
fc2[fc].Ab=function(){var a=fci.friendconnect_imageUrl+"/",b=a+"shadow_tc.png",c=a+"shadow_bc.png",d=a+"shadow_bl.png",e=a+"shadow_tl.png",f=a+"shadow_tr.png",j=a+"shadow_br.png";a+="shadow_cr.png";var i=function(a,b){return fcW?'filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'+a+'", sizingMethod="scale");':"background-image: url("+a+");background-repeat: "+b+"; "},k="position:absolute; top:";this.n()!="top"&&(k="position:fixed; bottom:",this.absoluteBottom&&(k="position:absolute; bottom:"));
var l=c;this.n()!="top"&&(l=b);var h=0,g=[];g[h++]='<style type="text/css">';this.n()!="top"&&this.absoluteBottom&&(g[h++]="html, body {height: 100%; overflow: auto; };");g[h++]="#"+this.t+" {";g[h++]="background:#E0ECFF;";g[h++]="left:0;";g[h++]="height: "+(fcW?"35px;":"36px;");this.n()!="top"&&this.absoluteBottom&&(g[h++]="margin-right: 20px;");g[h++]="padding:0;";g[h++]=k+" 0;";g[h++]="width:100%;";g[h++]="z-index:5000;";g[h++]="}";g[h++]="#"+this.gb+" {";g[h++]=i(l,"repeat-x");g[h++]="left:0;";
g[h++]="height:"+this.b+"px;";this.n()!="top"&&this.absoluteBottom&&(g[h++]="margin-right: 20px;");g[h++]="padding:0;";g[h++]=k+(fcW?"35px;":"36px;");g[h++]="width:100%;";g[h++]="z-index:4998;";g[h++]="}";g[h++]="."+this.Pa()+" {";g[h++]="display: block;";g[h++]="padding:0;";g[h++]=k+(fcW?"34px;":"35px;");g[h++]="z-index:4999;";g[h++]="}";g[h++]="."+this.Ua()+" {";g[h++]="background: white;";g[h++]="height: 100%;";g[h++]="margin-right: "+this.b+"px;";g[h++]="}";g[h++]="."+this.Ta()+" {";g[h++]="border: "+
this.Da+"px solid #ccc;";g[h++]="height: 100%;";g[h++]="left: 0;";g[h++]="background-image: url("+fci.friendconnect_imageUrl+"/loading.gif);";g[h++]="background-position: center;";g[h++]="background-repeat: no-repeat;";g[h++]="}";g[h++]="."+this.d("cr")+" {";g[h++]=i(a,"repeat-y");g[h++]="height: 100%;";g[h++]="position:absolute;";g[h++]="right: 0;";g[h++]="top: 0;";g[h++]="width:"+this.b+"px;";g[h++]="}";g[h++]="."+this.d("bl")+" {";g[h++]=i(d,"no-repeat");g[h++]="height: "+this.b+"px;";g[h++]="position:absolute;";
g[h++]="width:"+this.b+"px;";g[h++]="}";g[h++]="."+this.d("tl")+" {";g[h++]=i(e,"no-repeat");g[h++]="height: "+this.b+"px;";g[h++]="position:absolute;";g[h++]="left:0px;";g[h++]="width:"+this.b+"px;";g[h++]="}";g[h++]="."+this.d("bc")+" {";g[h++]=i(c,"repeat-x");g[h++]="height: "+this.b+"px;";g[h++]="left: "+this.b+"px;";g[h++]="position:absolute;";g[h++]="right: "+this.b+"px;";g[h++]="}";g[h++]="."+this.d("tc")+" {";g[h++]=i(b,"repeat-x");g[h++]="height: "+this.b+"px;";g[h++]="left: "+this.b+"px;";
g[h++]="margin-left: "+this.b+"px;";g[h++]="margin-right: "+this.b+"px;";g[h++]="right: "+this.b+"px;";g[h++]="}";g[h++]="."+this.d("br")+" {";g[h++]=i(j,"no-repeat");g[h++]="height: "+this.b+"px;";g[h++]="position:absolute;";g[h++]="right: 0;";g[h++]="width: "+this.b+"px;";g[h++]="}";g[h++]="."+this.d("tr")+" {";g[h++]=i(f,"no-repeat");g[h++]="height: "+this.b+"px;";g[h++]="position:absolute;";g[h++]="right: 0;";g[h++]="top: 0;";g[h++]="width: "+this.b+"px;";g[h++]="}";g[h++]="</style>";return g[fcP]("")};
fc2[fc].O=function(){var a=['<div id="'+this.t+'"></div>','<div id="'+this.gb+'"></div>','<div id="'+this.ja(this.h.P())+'"></div>'];return a[fcP]("")};fc2[fc].ub=function(a,b,c,d){this.h.M(a)||(b=new fc3(this,a,b,c,d),c=this.h.P(),d=fcGb(this.ja(c)),fcn(d,b.O()+'<div id="'+this.ja(c+1)+'"></div>'),this.h.set(a,b))};fc2[fc].na=function(a){(a=this.h.get(a))&&a.drawer&&fc_b(a.drawer,!1)};fc2[fc].ic=function(a){if(a=this.h.get(a))a.rendered=!1};
fc2[fc].refresh=function(){for(var a=this.h.z(),b=0;b<a[fcr];b++){var c=a[b];this.na(c);this.ic(c)}};fc2[fc].cc=function(a){for(var b=this.h.F(),c=0;c<b[fcr];c++){var d=b[c];if(d.id==a){d.Fc();break}}};fc2[fc].bc=function(a){for(var b=this.h.F(),c=0;c<b[fcr];c++){var d=b[c];if(d.id==a){d.Zb();break}}};fc2[fc].sc=function(a){if((a=this.h.get(a))&&a.drawer&&a.pa())a.ea(),a.La(),a.Ca()};
fc2[fc].Ec=function(a,b){var c=this.h.get(a);if(c){if(!c.drawer)c.drawer=fcGb(this.ga(c[fcM])),c.target=fcGb(this.R(c[fcM])),c.sha_bc=fcIb(fcj,"div",this.n()=="top"?this.d("bc"):this.d("tc"),c.drawer)[0],c.sha_cr=fcIb(fcj,"div",this.d("cr"),c.drawer)[0];for(var d=this.h.z(),e=0;e<d[fcr];e++){var f=d[e];a!==f&&this.na(f)}c.ea(b);fc_b(c.drawer,!0);fci.setTimeout(function(){c.Ca();c.La();c.render()},0)}};
var fc3=function(a,b,c,d,e){this.id=-1;this.bar=a;this.name=b;this.constraints=d;this.skin=e||{};fco(this,this.skin.HEIGHT||"0");this.url=fci.friendconnect_serverBase+c;this.sha_bc=this.target=this.drawer=fcc;this.loaded=this.rendered=!1;this.ea()};
fc3[fc].ea=function(a){fcBb(this.constraints,a||{});fcBb(this.skin,this.constraints);if(this.bar.fixedIeSizes&&this.constraints.left&&this.constraints[fcza]){var a=this.bar.Bb(),b=this.constraints.left,c=this.constraints[fcza];a-=b+c;a%2&&(a-=1,this.skin.right+=1);fcm(this.skin,a);delete this.skin.left}};
fc3[fc].Ca=function(){if(this.drawer){if(this.skin[fcs]){var a=this.bar.Da,b=this.bar.b,c=fcW?2:0;fcXb(this.target,this.skin[fcs],"");fcXb(this.sha_bc,this.skin[fcs]-b+2*a-c,"");this.skin.rightShadow?fcXb(this.drawer,this.skin[fcs]+b+2*a-c,""):fcXb(this.drawer,this.skin[fcs]+2*a-c,"")}if(this.skin[fcza])this.drawer[fcD].right=this.skin[fcza]+0+"px"}};
fc3[fc].La=function(){if(fcW&&this.drawer){var a=fcZb(this.target),b=a[fcs]-this.bar.b,a=a[fcN];b<0&&(b=0);this.sha_bc&&this.sha_bc[fcD]&&fcXb(this.sha_bc,b,"");this.sha_cr&&this.sha_cr[fcD]&&fcXb(this.sha_cr,"",a)}};
fc3[fc].O=function(){var a="display:none;",b="position: relative; ",c="",d="",e="",f="",j=!!this.skin.rightShadow;j||(c+="display: none; ",e+="display: none; ",d+="right: 0px; ",f+="margin-right: 0px; ");for(var i in this.skin){var k=Number(this.skin[i]);j&&fcLa(i,"width")==0&&(k+=this.bar.b);fcLa(i,"height")==0&&(b+=i+": "+k+"px; ");i!="rightShadow"&&(fcLa(i,"height")==0&&(k+=this.bar.b),fcLa(i,"width")==0&&(k+=2),a+=i+": "+k+"px; ");fcW&&fcLa(i,"width")==0&&(k-=j?2*this.bar.b:this.bar.b,d+=i+": "+
k+"px; ")}fcW&&(this[fcN]|0)>0&&(j=(this[fcN]|0)+2,c+="height: "+j+"px; ");j=0;i=[];i[j++]='<div id="'+this.bar.ga(this[fcM])+'"class="'+this.bar.Pa()+'"style="'+a+'"> ';this.bar.n()=="bottom"&&(i[j++]='<div class="'+this.bar.d("tl")+'"></div> <div class="'+this.bar.d("tc")+'"style="'+d+'"></div> <div class="'+this.bar.d("tr")+'"style="'+e+'"></div> ');i[j++]='<div style="'+b+'"> <div class="'+this.bar.Ua()+'"style="'+f+'"><div id="'+this.bar.R(this[fcM])+'"class="'+this.bar.Ta()+'"></div> <div class="'+
this.bar.d("cr")+'"style="'+c+'"></div> </div> </div> ';this.bar.n()=="top"&&(i[j++]='<div class="'+this.bar.d("bl")+'"></div> <div class="'+this.bar.d("bc")+'"style="'+d+'"></div> <div class="'+this.bar.d("br")+'"style="'+e+'"></div> ');i[j++]="</div> ";return i[fcP]("")};fc3[fc].Fc=function(){this.rendered=this.pa()};fc3[fc].Zb=function(){this.loaded=this.pa()};fc3[fc].pa=function(){return!!this.drawer&&this.drawer[fcD][fcwa]!="none"};
fc3[fc].render=function(){if(this.rendered==!1){var a={};a.url=this.url;a.id=this.bar.R(this[fcM]);a.site=this.bar.site;a["view-params"]=fcS(this.bar.Ic);this[fcM]=="profile"&&(a["view-params"].profileId="VIEWER");this.skin&&fcBb(a["view-params"].skin,this.skin);a["view-params"].menuName=this[fcM];a["view-params"].opaque="true";a["view-params"].menuPosition=this.bar.gc;fco(a,"1px");if(fcic&&fcjc&&fc4)this.id=fc4.render(a)}};fcU("google.friendconnect.FriendBar",fc2);var fcmc="0123456789abcdefghijklmnopqrstuv",fcoc=function(a){a=new fcnc(a);a.ra()%5&&fca(fce());for(var b=[],c=0;a.ra()>0;c++)b[c]=fcmc[fcz](a.ec(5));return b[fcP]("")},fcnc=function(a){this.G=this.r=0;this.da=a};fcnc[fc].ra=function(){return 8*(this.da[fcr]-this.G)-this.r};
fcnc[fc].ec=function(a){var b=0;a>this.ra()&&fca(fce());if(this.r>0){var b=255>>this.r&this.da[this.G],c=8-this.r,d=fcl.min(a%8,c);c-=d;b>>=c;a-=d;this.r+=d;if(this.r==8)this.r=0,this.G++}for(;a>=8;)b<<=8,b|=this.da[this.G],this.G++,a-=8;if(a>0)b<<=a,b|=this.da[this.G]>>8-a,this.r=a;return b};var fcpc=(new Date).getTime(),fc5=function(){},fcqc=function(){},fcrc=function(){},fcsc=function(){};fcV(fcsc,fcrc);var fctc=function(a){if(a)for(var b in a)a.hasOwnProperty(b)&&(this[b]=a[b]);if(this.viewParams)for(var c in this.viewParams)/^FC_RELOAD_.*$/[fcia](c)&&(this.viewParams[c]=fcc)};fctc[fc].render=function(a){var b=this;a&&(b.Gc(),this.Db(function(c){fcTb(a,"visibility","hidden");fcn(a,c);b.refresh(a,c);c=function(a){fcTb(a,"visibility","visible")};c=fcHa(c,a);fcba(c,500);b.chrome=a}))};
fctc[fc].Db=function(a){return this.Jb(a)};var fc6=function(a){fctc[fcE](this,a);this.V="../../";this.rpcToken=fch(fcl[fct](2147483647*fcl[fcma]()))};fcV(fc6,fctc);fc6[fc].lb="gfc_iframe_";fc6[fc].mb="friendconnect";fc6[fc].Ma="";fc6[fc].tc="rpc_relay.html";fc6[fc].Y=function(a){this.V=a};fc6[fc].Gc=function(){return this.Ma=fch(fcl[fct](2147483647*fcl[fcma]()))};fc6[fc].ha=function(){return this.lb+this.Ma+"_"+this.id};
fc6[fc].refresh=function(a,b){var c=fc4.Lc,d,e={},f=fc4.Na(this.communityId),j=f[fcx]("~"),i=fc4.vb;if(i&&j[fcr]>1){var d=j[2],j=j[1],k=[this.specUrl,this.communityId,j,i][fcP](":");e.sig=fc4.hash(d,k);e.userId=j;e.dateStamp=i}e.container=this.mb;e.mid=this.id;e.nocache=fc4.fc;e.view=this.$;e.parent=fc4.T;this.debug&&(e.debug="1");this.specUrl&&(e.url=this.specUrl);if(this.communityId)i=fcd[fcK][fcB]().profileId,e.communityId=this.communityId,(d=fcd[fcK][fcB]().psinvite)&&(e.psinvite=d),i&&(e.profileId=
i);e.caller=fcuc();e.rpctoken=this.rpcToken;i=!1;d="";j=/Version\/3\..*Safari/;if((j=fc5a&&fc0a()[fcF](j))||!fc4.S[this.specUrl]&&this.viewParams)e["view-params"]=fcd[fcI][fcha](this.viewParams),d="?viewParams="+fcg(e["view-params"]),i=!0;this.prefs&&(e.prefs=fcd[fcI][fcha](this.prefs));this.viewParams&&this.sendViewParamsToServer&&(e["view-params"]=fcd[fcI][fcha](this.viewParams));if(this.locale)e.locale=this.locale;if(this.secureToken)e.st=this.secureToken;j=fc4.Sa(this.specUrl);d=j+"ifr"+d+(this.hashData?
"&"+this.hashData:"");fc4.Kc!=1||i||f||this.secureToken?f&&!e.sig&&(e.fcauth=f):e.sig||(c="get");f=this.ha();fcvc(f,d,c,e,a,b,this.rpcToken)};var fc7=function(){this.j={};this.T="http://"+fcj[fcA].host;this.$="default";this.fc=1;this.Pc=0;this.Mc="US";this.Nc="en";this.Oc=2147483647};fcV(fc7,fcqc);fc7[fc].v=fctc;fc7[fc].B=new fcsc;fc7[fc].fb=function(a){this.fc=a};fc7[fc].Ka=function(a){this.Kc=a};fc7[fc].Ra=function(a){return"gadget_"+a};fc7[fc].w=function(a){return this.j[this.Ra(a)]};
fc7[fc].N=function(a){return new this.v(a)};fc7[fc].ob=function(a){a.id=this.Kb();this.j[this.Ra(a.id)]=a};fc7[fc].dc=0;fc7[fc].Kb=function(){return this.dc++};var fcxc=function(){fc7[fcE](this);this.B=new fcwc};fcV(fcxc,fc7);fcxc[fc].v=fc6;fcxc[fc].X=function(a){a[fcF](/^http[s]?:\/\//)||(a=fcj[fcA][fcoa][fcF](/^[^?#]+\//)[0]+a);this.T=a};fcxc[fc].I=function(a){var b=this.B.Qa(a);a.render(b)};var fcwc=function(){this.zb={}};fcV(fcwc,fcrc);
fcwc[fc].pb=function(a,b){this.zb[a]=b;var c=fcj[fcy](b).className;!c&&c[fcr]==0&&fcea(fcj[fcy](b),"gadgets-gadget-container")};fcwc[fc].Qa=function(a){return(a=this.zb[a.id])?fcj[fcy](a):fcc};var fc8=function(a){fc6[fcE](this,a);a=a||{};this.$=a.view||"profile"};fcV(fc8,fc6);fc8[fc].rb="canvas.html";fc8[fc].xb="/friendconnect/embed/";
var fcuc=function(){var a=fcd[fcK][fcB]().canvas=="1"||fcd[fcK][fcB]().embed=="1",b=fcc;a&&(b=fcd[fcK][fcB]().caller);b||(a=fcj[fcA],b=a.search[fcv](/([&?]?)psinvite=[^&]*(&?)/,function(a,b,e){return e?b:""}),b=a.protocol+"//"+a.hostname+(a.port?":"+a.port:"")+a.pathname+b);return b};fc8[fc].Cc=function(a){this.$=a};fc8[fc].ma=function(){return this.$};fc8[fc].getBodyId=function(){return this.ha()+"_body"};
fc8[fc].Jb=function(a){var b=this.specUrl;b===fcb&&(b="");var b=(fc4.Sa(b)||this.V)+this.tc,c=this.ha();fcd.rpc.setRelayUrl(c,b);b='<div id="'+this.getBodyId()+'"><iframe id="'+c+'" name="'+c;b+=this[fcN]==0?'" style="width:1px; height:1px;':'" style="width:100%;';this.viewParams.opaque&&(b+="background-color:white;");b+='"';b+=' frameborder="0" scrolling="no"';this.viewParams.opaque||(b+=' allowtransparency="true"');b+=this[fcN]?' height="'+this[fcN]+'"':"";b+=this[fcs]?' width="'+this[fcs]+'"':
"";b+="></iframe>";this.showEmbedThis&&(b+='<a href="javascript:void(0);" onclick="google.friendconnect.container.showEmbedDialog(\''+this.divId+"'); return false;\">Embed this</a>");b+="</div>";a(b)};
fc8[fc].Cb=function(){var a=fcuc(),a="canvas=1&caller="+fcg(a),b=fcd[fcK][fcB]().psinvite;b&&(a+="&psinvite="+fcg(b));a+="&site="+fcg(this.communityId);b=fcS(this.viewParams);if(b.skin!=fcc)for(var c=["BG_IMAGE","BG_COLOR","FONT_COLOR","BG_POSITION","BG_REPEAT","ANCHOR_COLOR","FONT_FACE","BORDER_COLOR","CONTENT_BG_COLOR","CONTENT_HEADLINE_COLOR","CONTENT_LINK_COLOR","CONTENT_SECONDARY_TEXT_COLOR","CONTENT_SECONDARY_LINK_COLOR","CONTENT_TEXT_COLOR","ENDCAP_BG_COLOR","ENDCAP_LINK_COLOR","ENDCAP_TEXT_COLOR",
"CONTENT_VISITED_LINK_COLOR","ALTERNATE_BG_COLOR"],d=0;d<c[fcr];d++)delete b.skin[c[d]];b=fcg(fcd[fcI][fcha](b));b=b[fcv]("\\","%5C");return fc4.T+this.rb+"?url="+fcg(this.specUrl)+(a?"&"+a:"")+"&view-params="+b};fc8[fc].D=function(a){a=a||fcf+this.xb+this.communityId;return this.Eb(a,"embed=1")};fc8[fc].C=function(a){return'<iframe src="'+this.D(a)+'" style="height:500px" scrolling="no" allowtransparency="true" border="0" frameborder="0" ></iframe>'};
fc8[fc].Eb=function(a,b){var c=fcg(fcd[fcI][fcha](this.viewParams)),c=c[fcv]("\\","%5C");return a+"?url="+fcg(this.specUrl)+(b?"&"+b:"")+"&view-params="+c};fc8[fc].Nb=function(){var a=fcd[fcK][fcB]().canvas=="1"||fcd[fcK][fcB]().embed=="1",b=fcc;if(a)(b=fcd[fcK][fcB]().caller)||(b="javascript:history.go(-1)");return b};fc8[fc].Ob=function(a){var b=fcc;a=="canvas"?b=this.Cb():a=="profile"&&(b=this.Nb());return b};
var fc9=function(){fcxc[fcE](this);fcd.rpc[fcO]("signin",fc5[fc].signin);fcd.rpc[fcO]("signout",fc5[fc].signout);fcd.rpc[fcO]("resize_iframe",fc5[fc].eb);fcd.rpc[fcO]("set_title",fc5[fc].setTitle);fcd.rpc[fcO]("requestNavigateTo",fc5[fc].cb);fcd.rpc[fcO]("api_loaded",fc5[fc].Ba);fcd.rpc[fcO]("createFriendBarMenu",fc5[fc].Ga);fcd.rpc[fcO]("showFriendBarMenu",fc5[fc].hb);fcd.rpc[fcO]("hideFriendBarMenu",fc5[fc].Va);fcd.rpc[fcO]("putReloadViewParam",fc5[fc].Za);fcd.rpc[fcO]("getViewParams",fc5[fc].Ja);
fcd.rpc[fcO]("getContainerBaseTime",fc5[fc].Ia);fcd.rpc[fcO]("openLightboxIframe",fc5[fc].Ya);fcd.rpc[fcO]("showMemberProfile",fc5[fc].jb);fcd.rpc[fcO]("closeLightboxIframe",fcT(this.u,this));fcd.rpc[fcO]("setLightboxIframeTitle",fcT(this.yc,this));fcd.rpc[fcO]("refreshAndCloseIframeLightbox",fcT(this.hc,this));var a=fcyc;a[fcO]();a.kb(this,"load",this.Qb);a.kb(this,"start",this.Rb);this.V="../../";this.X("");this.fb(0);this.Ka(1);this.qa=fcc;this.apiVersion="0.8";this.openSocialSecurityToken=fcc;
this.W="";this.Ha={};this.Yb=fcc;this.Xb=!1;this.vb=this.ac=this.lastIframeLightboxOpenArguments=this.lastLightboxCallback=this.lastLightboxDialog=fcc;this.Lc="post"};fcV(fc9,fcxc);fc9[fc].wc=function(a){this.vb=a};fc9[fc].v=fc8;fc9[fc].S={};fc9[fc].Ac=function(a){this.qa=a};fc9[fc].Sa=function(a){var b=fc9[fc].S[a];if(!b)this.qa[fcC]("http://")!==0?(a=this.tb(a),b=["http://",a,this.qa][fcP]("")):b=this.qa;return b};
fc9[fc].tb=function(a){var b=new SHA1,a=fcdb(a);b.update(a);b=b.digest();return b=fcoc(b)};
var fczc=function(a,b){var c=b?b:fci.top,d=c.frames;try{if(c.frameElement.id==a)return c}catch(e){}for(c=0;c<d[fcr];++c){var f=fczc(a,d[c]);if(f)return f}return fcc},fcvc=function(a,b,c,d,e,f,j){var i="gfc_load_"+a,b='<html><head><style type="text/css">body {background:transparent;}</style>'+(fcW?'<script type="text/javascript">window.goback=function(){history.go(-1);};setTimeout("goback();", 0);<\/script>':"")+"</head><body><form onsubmit='window.goback=function(){};return false;' style='margin:0;padding:0;' id='"+
i+"' method='"+c+"' ' action='"+fcd[fcK].escapeString(b)+"'>",k;for(k in d)b+="<input type='hidden' name='"+k+"' value='' >";b+="</form></body></html>";var c=fczc(a),l;try{l=c[fcw]||c.contentWindow[fcw]}catch(h){e&&f&&(fcn(e,""),fcn(e,f),c=fczc(a),l=c[fcw]||c.contentWindow[fcw])}j&&fcd.rpc.setAuthToken(a,j);l.open();l.write(b);l.close();a=l[fcy](i);for(k in d)a[k].value=d[k];if(fcW)a.onsubmit();a.submit()};
fc9[fc].yb=function(){var a=fcd[fcK][fcB]().fcsite,b=fcd[fcK][fcB]().fcprofile;a&&b&&fc4.za(b,a)};fc9[fc].xc=function(a,b){this.S[a]=b};fc9[fc].U=function(){var a=/Version\/3\..*Safari/;if(a=fc5a&&fc0a()[fcF](a))fcj[fcA].reload();else{fc4.g!=fcc&&fc4.g.refresh();for(var b in fc4.j)a=fc4.j[b],this.I(a);if(this.lastIframeLightboxOpenArguments!=fcc)b=this.lastIframeLightboxOpenArguments,this.u(),this.sa[fcL](this,b)}};
fc9[fc].X=function(a){a[fcF](/^http[s]?:\/\//)||(a=a&&a[fcr]>0&&a[fcpa](0,1)=="/"?fcj[fcA][fcoa][fcF](/^http[s]?:\/\/[^\/]+\//)[0]+a[fcpa](1):fcj[fcA][fcoa][fcF](/^[^?#]+\//)[0]+a);this.T=a};fc9[fc].fa=function(a){return"fcauth"+a};fc9[fc].la=function(a){return"fcauth"+a+"-s"};fc9[fc].hash=function(a,b){var c=new SHA1,d=fckb(a,!0),c=new G_HMAC(c,d,64),d=fcdb(b),c=c.Ib(d);(new Date).getTime();return fcjb(c,!0)};
fc9[fc].Na=function(a){return a=fcmb.get(this.fa(a))||fcmb.get(this.la(a))||this.Ha[a]||""};fc9[fc].Y=function(a){this.V=a};fc9[fc].Bc=function(a){this.W=a};fc9[fc].N=function(a){a=new this.v(a);a.Y(this.V);return a};fc9[fc].ma=function(){return this.$};fc9[fc].zc=function(a){this.ac=a};var fc$=function(a){return(a=a[fcF](/_([0-9]+)$/))?fcaa(a[1],10):fcc};
fc9[fc].Z=function(a,b,c,d,e,f){if(!this.Jc)this.aa(fci.friendconnect_serverBase+"/friendconnect/styles/container.css?d="+this.W),this.Jc=!0;var j=fcAc(d);if(this.Yb!=(j?"rtl":"ltr"))this.aa(fci.friendconnect_serverBase+"/friendconnect/styles/lightbox"+(j?"-rtl":"")+".css?d="+this.W),this.Yb=j?"rtl":"ltr";if(!this.Xb)this.qb(fci.friendconnect_serverBase+"/friendconnect/script/lightbox.js?d="+this.W),this.Xb=!0;b=b||0;if(goog.ui&&goog.ui[fcka]){this.u();var b=new goog.ui[fcka]("lightbox-dialog",!0),
i=this;goog.events.listen(b,goog.ui[fcka].EventType.AFTER_HIDE,function(){i.lastLightboxCallback&&i.lastLightboxCallback();i.Fa()});b.setDraggable(!0);b.setDisposeOnHide(!0);b.setBackgroundElementOpacity(0.5);b.setButtonSet(new goog.ui[fcka].ButtonSet);this.lastLightboxDialog=b;this.lastLightboxCallback=c||fcc;c=b.getDialogElement();e=e||702;fcTb(c,"width",fch(e)+"px");f&&fcTb(c,"height",fch(f)+"px");a(b);b.getDialogElement()[fcD].direction=j?"rtl":"ltr"}else b<5?(b++,a=fcT(this.Z,this,a,b,c,d,e,
f),fcba(a,1E3)):(this.Fa(),fca(fce("lightbox.js failed to load")))};fc9[fc].u=function(a){var b=this.lastLightboxDialog,c=this.lastLightboxCallback;this.lastLightboxCallback=fcc;b!=fcc&&(this.lastLightboxDialog.dispatchEvent(goog.ui[fcka].EventType.AFTER_HIDE),b.dispose(),c!=fcc&&c(a))};fc9[fc].Fa=function(){this.lastIframeLightboxOpenArguments=this.lastLightboxCallback=this.lastLightboxDialog=fcc};fc9[fc].yc=function(a){this.lastLightboxDialog&&this.lastLightboxDialog.setTitle(a)};
fc9[fc].hc=function(){this.u();this.U()};fc5[fc].cb=function(a,b){var c=fc$(this.f),c=fc4.w(c),d=fcS(c.originalParams);b&&(d["view-params"]=d["view-params"]||{},d["view-params"]=b);d.locale=c.locale;if(c.useLightBoxForCanvas)d.presentation=a,fc4.lastLightboxDialog!=fcc?fc4.u():fc4.ib(d);else if((c=c.Ob(a))&&fcj[fcA][fcoa]!=c)if(fcd[fcK][fcB]().embed=="1")try{fci.parent.location=c}catch(e){fci.top.location=c}else fcj[fcA].href=c};
fc9[fc].ib=function(a,b){var a=a||{},c=a.locale,d=fcAc(c),e=this;this.u();this.Z(function(b){var c=fc0("div",{},fc0("div",{id:"gadget-signin",style:"background-color:#ffffff;height:32px;"}),fc0("div",{id:"gadget-lb-canvas",style:"background-color:#ffffff;"}));b.getTitleTextElement()[fcp](fc0("div",{id:"gfc-canvas-title",style:"color:#000000;"}));b.getContentElement()[fcp](c);b.setVisible(!0);var c=fcS(a),i=fcLb(fci),k=fcl[fct](i[fcN]*0.7),i={BORDER_COLOR:"#cccccc",ENDCAP_BG_COLOR:"#e0ecff",ENDCAP_TEXT_COLOR:"#333333",
ENDCAP_LINK_COLOR:"#0000cc",ALTERNATE_BG_COLOR:"#ffffff",CONTENT_BG_COLOR:"#ffffff",CONTENT_LINK_COLOR:"#0000cc",CONTENT_TEXT_COLOR:"#333333",CONTENT_SECONDARY_LINK_COLOR:"#7777cc",CONTENT_SECONDARY_TEXT_COLOR:"#666666",CONTENT_HEADLINE_COLOR:"#333333"};c.id="gadget-lb-canvas";fco(c,fcl.min(498,k)+"px");c.maxHeight=k;c.keepMax&&(fco(c,k),fcTb(b.getContentElement(),"height",k+35+"px"));c["view-params"]=c["view-params"]||{};c["view-params"].opaque=!0;c["view-params"].skin=c["view-params"].skin||{};
fcIa(c["view-params"].skin,i);e.render(c);k={id:"gadget-signin",presentation:"canvas"};k.site=c.site;k.titleDivId="gfc-canvas-title";k["view-params"]={};k["view-params"].opaque=!0;k.keepMax=c.keepMax;c.securityToken&&(k.securityToken=c.securityToken);c=fcS(i);c.ALIGNMENT=d?"left":"right";e.ab(k,c);b.reposition()},fcb,b,c)};fc5[fc].hb=function(a,b){fc4.g!=fcc&&fc4.g.Ec(a,b)};fc5[fc].Va=function(a){fc4.g!=fcc&&fc4.g.na(a)};
fc5[fc].Ya=function(a,b,c,d,e,f,j,i,k,l){var h=this.f,a=a+(a[fcC]("?")>=0?"&":"?")+"iframeId="+h;fc4.sa(a,b,c,d,e,f,j,i,k,l,this.callback)};
fc9[fc].sa=function(a,b,c,d,e,f,j,i,k,l,h){var g=fcLb(fci);d!=fcc||(d=fcl[fct](g[fcN]*0.7));c!=fcc||(c=fcl[fct](g[fcs]*0.7));for(var m=[],g=0;g<arguments[fcr]&&g<10;g++)m[fcq](arguments[g]);!a[0]=="/"&&fca(fce("lightbox iframes must be relative to fc server"));var p=this,n=f?fcS(f):{},q=fch(fcl[fct](2147483647*fcl[fcma]())),o="gfc_lbox_iframe_"+q;fcd.rpc.setAuthToken(o,q);if(!b)b=fc4.openSocialSecurityToken;var r=fc4.openSocialSiteId;fc4.Z(function(c){p.lastIframeLightboxOpenArguments=m;var g="st="+
fcg(b)+"&parent="+fcg(fc4.T)+"&rpctoken="+fcg(q);if(!i)n.iframeId=o,n.iurl=a,a=fcf+"/friendconnect/lightbox";var f=d-54;fco(n,f);var h='<iframe id="'+o;h+='" width="100%" height="'+f+'" frameborder="0" scrolling="auto"></iframe>';c.setContent(h);e&&(c.setTitle(e),l&&(f=c.getTitleTextElement(),fcFb(f,"lightbox-dialog-title-small-text")));c.setVisible(!0);k||(n.fcauth=fc4.Na(r));a+=(a[fcC]("?")>=0?"&":"?")+g+"&communityId="+r;fcvc(o,a,"POST",n,fcc,fcc,fcc)},fcb,h,fcb,c,d)};
fc5[fc].Ja=function(){var a=fc$(this.f),a=fc4.w(a);return a.viewParams};fc5[fc].Ia=function(){return fcpc};fc5[fc].Za=function(a,b){var c=fc$(this.f),c=fc4.w(c);c.viewParams[a]=b};fc9[fc].Qb=function(a,b){fc4.g!=fcc&&fc4.g.bc(b)};fc9[fc].Rb=function(a,b){fc4.g!=fcc&&fc4.g.cc(b)};fc5[fc].Ga=function(a,b,c,d){fc4.g!=fcc&&fc4.g.ub(a,b,c,d)};fc9[fc].I=function(a){var b=this.B.Qa(a);a.render(b);this.B.postProcessGadget&&this.B.postProcessGadget(a)};
fc5[fc].signout=function(a){fc4.$a(fc4.fa(a));fc4.$a(fc4.la(a));fc4.Ha={};fc4.U();return!1};fc9[fc].$a=function(a){for(var b=fcj[fcA].pathname,b=b[fcx]("/"),c=0;c<b[fcr];c++){for(var d=fck(c+1),e=0;e<c+1;e++)d[e]=b[e];fcmb.remove(a,d[fcP]("/")+"/")}};
fc5[fc].eb=function(a){var b=fcj[fcy](this.f);b&&a>0&&fco(b[fcD],a+"px");(b=fcj[fcy](this.f+"_body"))&&a>0&&fco(b[fcD],a+"px");if(b=fc$(this.f)){var c=fc4.w(b);if(c){if((b=fcj[fcy](c.divId))&&a>0){if(c&&c[fcqa]&&c[fcqa]<a)a=c[fcqa],b[fcD].overflowY="auto";fco(b[fcD],a+"px")}!c.keepMax&&c.ma()=="canvas"&&fc4.lastLightboxDialog&&fc4.lastLightboxDialog.reposition();fcTb(c.chrome,"visibility","visible")}}};fc5[fc].setTitle=function(a){var b=fc$(this.f),b=fc4.w(b);(b=b.titleDivId)&&fcn(fcj[fcy](b),fcd[fcK].escapeString(a))};
fc5[fc].signin=function(a,b,c){fcmb.set(fc4.fa(a),b,31104E3,c);fcmb.set(fc4.la(a),b,-1,c);fc4.Ha[a]=b;fc4.U()};var fcCc=function(a){fcec(a,fcBc)};fc9[fc].nc=function(a,b){b&&this.m(b,a);var c={};c.url=fcf+"/friendconnect/gadgets/members.xml";this.render(this.s(a,c))};fc9[fc].pc=function(a,b){b&&this.m(b,a);var c={};c.url=fcf+"/friendconnect/gadgets/review.xml";c["view-params"]={startMaximized:"true",disableMinMax:"true",features:"review"};this.render(this.s(a,c))};
fc9[fc].ua=function(a,b){b&&this.m(b,a);var c={};c.url=fcf+"/friendconnect/gadgets/wall.xml";c["view-params"]={startMaximized:"true",disableMinMax:"true",features:"comment"};this.render(this.s(a,c))};fc9[fc].ab=function(a,b){b&&this.m(b,a);var c={};c.url=fcf+"/friendconnect/gadgets/signin.xml";fco(c,32);this.render(this.s(a,c))};
fc9[fc].kc=function(a,b){b&&this.m(b,a);a.prefs=a.prefs||{};a.sendViewParamsToServer=!0;a.prefs.hints=fci.google_hints;var c={};c.url=fcf+"/friendconnect/gadgets/ads.xml";fco(c,90);this.render(this.s(a,c))};fc9[fc].xa=function(a,b){if(a.id){b&&this.m(b,a);a["view-params"]=a["view-params"]||{};a["view-params"].opaque="true";this.g=new fc2(a);this.g.render();var c={};c.url=fcf+"/friendconnect/gadgets/friendbar.xml";a.id=this.g.t;fco(a,"1");this.render(this.s(a,c))}};fc9[fc].mc=fc9[fc].xa;
fc9[fc].wa=function(a,b){a=a||{};a.url=fcf+"/friendconnect/gadgets/signin.xml";a.site=a.site||fcd[fcK][fcB]().site;fco(a,32);this.va(a,b)};fc9[fc].lc=fc9[fc].wa;fc9[fc].rc=fc9[fc].ua;fc9[fc].m=function(a,b){var c=b["view-params"];c||(c={},b["view-params"]=c);c.skin=a};fc9[fc].s=function(a,b){var c=this.Xa(b,a);if(b["view-params"]){var d=b["view-params"];a["view-params"]&&(d=this.Xa(d,a["view-params"]));c["view-params"]=d}return c};fc9[fc].oc=function(a,b){b&&this.m(b,a);this.render(a)};
fc9[fc].Xa=function(a,b){var c={},d;for(d in b)c[d]=b[d];for(d in a)typeof c[d]=="undefined"&&(c[d]=a[d]);return c};
fc9[fc].render=function(a){this.openSocialSiteId=a.site;a["view-params"]=a["view-params"]||{};var b=this.N({divId:a.id,specUrl:a.url,communityId:a.site,height:a[fcN],locale:a.locale||this.ac,secureToken:a.securityToken,titleDivId:a.titleDivId,showEmbedThis:a.showEmbedThis,useLightBoxForCanvas:a.useLightBoxForCanvas||typeof a.useLightBoxForCanvas=="undefined"&&fci.friendconnect_lightbox,viewParams:a["view-params"],prefs:a.prefs,originalParams:a,debug:a.debug,maxHeight:a[fcqa],sendViewParamsToServer:a.sendViewParamsToServer,
keepMax:a.keepMax});a.presentation&&b.Cc(a.presentation);this.ob(b);this.B.pb(b.id,a.id);fcba(function(){fc4.I(b)},0);return b.id};fc9[fc].qc=function(a,b){a=a||{};a.presentation="canvas";this.bb(a,b)};
fc9[fc].bb=function(a,b,c){a=a||{};a.url=fcd[fcK][fcB]().url;a.site=fcd[fcK][fcB]().site||a.site;var d=fcd[fcK][fcB]()["view-params"];d&&(a["view-params"]=fcd[fcI].parse(decodeURIComponent(d)));if(c)a["view-params"]=a["view-params"]||{},a["view-params"].useFixedHeight=!0,fco(a["view-params"],c),b=b||{},b.HEIGHT=fch(c);this.va(a,b)};fc9[fc].va=function(a,b){a=a||{};b&&this.m(b,a);fcd[fcK][fcB]().canvas=="1"?a.presentation="canvas":fcd[fcK][fcB]().embed=="1"&&(a.presentation="embed");fc4.render(a)};
fc9[fc].Pb=function(){var a=fcd[fcK][fcB]().caller;a&&fcj[fcA][fcoa]!=a&&a[fcr]>8&&(a.substr(0,7)[fcya]()=="http://"||a.substr(0,8)[fcya]()=="https://")?fcj[fcA].href=a:(a=fcd[fcK][fcB]().site)?fcj[fcA].href=fcf+"/friendconnect/directory/site?id="+a:fci.history.go(-1)};fc9[fc].H="";fc9[fc].Lb=function(){return this.H};fc9[fc].uc=function(a){this.apiVersion=a};fc9[fc].aa=function(a){var b=fcj[fcH]("link");b[fcJ]("rel","stylesheet");b[fcJ]("type","text/css");b[fcJ]("href",a);fcj.getElementsByTagName("head")[0][fcp](b)};
fc9[fc].qb=function(a){var b=fcj[fcH]("script");b[fcJ]("src",a);b[fcJ]("type","text/javascript");fcj.getElementsByTagName("head")[0][fcp](b)};fc9[fc].Ea=function(a){fcj[fcla]?a():fci[fcna]?fci[fcna]("load",a,!1):fci.attachEvent("onload",a)};fc9[fc].oa=function(a){a.site||fca("API not loaded, please pass in a 'site'");this.aa(fci.friendconnect_serverBase+"/friendconnect/styles/container.css?d="+this.W);this.openSocialSiteId=a.site;this.apiLoadedCallback=a.onload;this.Ea(fcT(this.Wa,this,a,"fc-opensocial-api"))};
fc9[fc].$b=fc9[fc].oa;fc9[fc].Sb=function(a){var b={};b.site=this.openSocialSiteId;b["view-params"]={txnId:a};this.Wa(b,"gfc-"+a)};fc9[fc].jc=function(a){var b={},c;for(c in this.j){var d=this.j[c];if(d.viewParams&&d.viewParams.txnId==a)break;else b[c]=d}this.j=b;(a=fcj[fcy]("gfc-"+a))&&a.parentNode&&a.parentNode.removeChild&&a.parentNode.removeChild(a)};fc9[fc].Fb=function(){return"<Templates xmlns:fc='http://www.google.com/friendconnect/makeThisReal'>  <Namespace prefix='fc' url='http://www.google.com/friendconnect/makeThisReal'/>  <Template tag='fc:signIn'>    <div onAttach='google.friendconnect.renderSignInButton({element: this})'></div>  </Template></Templates>"};
fc9[fc].Mb=function(){return"<Templates xmlns:os='http://ns.opensocial.org/2008/markup'><Namespace prefix='os' url='http://ns.opensocial.org/2008/markup'/><Template tag='os:Name'>  <span if='${!My.person.profileUrl}'>${My.person.displayName}</span>  <a if='${My.person.profileUrl}' href='${My.person.profileUrl}'>      ${My.person.displayName}</a></Template><Template tag='os:Badge'>  <div><img if='${My.person.thumbnailUrl}' src='${My.person.thumbnailUrl}'/>   <os:Name person='${My.person}'/></div></Template><Template tag='os:PeopleSelector'>  <select onchange='google.friendconnect.PeopleSelectorOnChange(this)' name='${My.inputName}'          multiple='${My.multiple}' x-var='${My.var}' x-max='${My.max}'          x-onselect='${My.onselect}'>    <option repeat='${My.group}' value='${Cur.id}' selected='${Cur.id == My.selected}'>        ${Cur.displayName}    </option>  </select></Template></Templates>"};
var fcDc=function(a){var b;if(a.multiple){for(var b=[],c=0;c<a[fcG][fcr];c++)a[fcG][c].selected&&b[fcq](a[fcG][c].value);c=a.getAttribute("x-max");c*=1;if(c&&b[fcr]>c&&a["x-selected"]){b=a["x-selected"];for(c=0;c<a[fcG][fcr];c++){a[fcG][c].selected=!1;for(var d=0;d<b[fcr];d++)if(a[fcG][c].value==b[d]){a[fcG][c].selected=!0;break}}}}else b=a[fcG][a.selectedIndex].value;a["x-selected"]=b;(c=a.getAttribute("x-var"))&&fci.opensocial[fcja]&&fci.opensocial[fcja].getDataContext().putDataSet(c,b);if(c=a.getAttribute("x-onselect"))if(fci[c]&&
typeof fci[c]=="function")fci[c](b);else a["x-onselect-fn"]?a["x-onselect-fn"][fcL](a):a["x-onselect-fn"]=new Function(c)};
fc9[fc].Wa=function(a,b){fci.opensocial.template.Loader.loadContent(this.Mb());fci.opensocial.template.Loader.loadContent(this.Fb());fci.opensocial[fcja].processDocumentMarkup();var c=fcj[fcH]("div");c.id=b;fco(c[fcD],"0px");fcm(c[fcD],"0px");c[fcD].position="absolute";c[fcD].visibility="hidden";fcj[fcla][fcp](c);var d={};d.url=fcf+"/friendconnect/gadgets/osapi-"+this.apiVersion+".xml";fco(d,0);d.id=c.id;d.site=a.site;d["view-params"]=a["view-params"];this.render(d)};
fc5[fc].Ba=function(){fc4.H=this.f;fc4.openSocialSecurityToken=this.a[0];var a=fc4.openSocialSecurityToken;fci.opensocial[fcja].executeRequests();fci.opensocial.template.process();fc4.apiLoadedCallback&&(a=fcHa(fc4.apiLoadedCallback,a),fcba(a,0))};fc9[fc].Q=function(a){var b=fcc,c;for(c in this.j)if(this.j[c].divId==a){b=this.j[c];break}return b};fc9[fc].D=function(a,b){var c=this.Q(a),d=fcc;c&&(d=c.D(b));return d};fc9[fc].C=function(a,b){var c=this.Q(a),d=fcc;c&&(d=c.C(b));return d};
fc9[fc].Dc=function(a,b){this.Z(function(c){var d=fcj.createTextNode("Copy & paste this code into your site.");c.getContentElement()[fcp](d);c.getContentElement()[fcp](fcj[fcH]("br"));var d=fc4.C(a,b),e=fcj[fcH]("textarea");fcn(e,d);e[fcJ]("style","width:500px;");c.getContentElement()[fcp](e);c.setVisible(!0)})};var fcEc=["ar","dv","fa","iw","he","ku","pa","sd","tk","ug","ur","yi"],fcAc=function(a){var b=!1;a?(a=a[fcx]("_")[0],b=fctb(fcEc,a)):b=(a=fcUb(fcj[fcla],"direction"))&&a=="rtl";return b};
fc5[fc].jb=function(a,b){var c=0,d=fcc;try{var e=fc$(this.f),f=fc4.w(e),d=f.secureToken,c=f.communityId}catch(j){}b&&(c=b);fc4.za(a,c,this.callback,d)};fc9[fc].za=function(a,b,c,d){b=b||this.openSocialSiteId;a={keepMax:!0,presentation:"canvas",url:fcf+"/friendconnect/gadgets/members.xml",site:b,"view-params":{profileId:a}};d&&(a.securityToken=d);this.ib(a,c)};fc9[fc].Hb=function(a){var b=fcc;if((a=this.Q(a))&&a.secureToken)b=a.secureToken;return b};
fc9[fc].Gb=function(a){var b=fcc;if((a=this.Q(a))&&a.communityId)b=a.communityId;return b};var fcBc=function(a){fc4.H&&fc9b(fc4.H,a)},fcFc=function(){fc5[fc].signout(fc4.openSocialSiteId)},fcGc=function(){fcbc(fc4.H)},fcHc=function(a,b){fc6b(a,b)},fckc=function(){this.o={}};fckc[fc].register=function(){fcd.rpc[fcO]("subscribeEventType",fc5[fc].subscribe);fcd.rpc[fcO]("publishEvent",fc5[fc].publish)};fc5[fc].subscribe=function(a){var b=fcyc;b.o[a]=b.o[a]||[];a=b.o[a];a[a[fcr]]={frameId:this}};
fckc[fc].kb=function(a,b,c){var d=this;d.o[b]=d.o[b]||[];b=d.o[b];b[b[fcr]]={container:a,callback:c}};fc5[fc].publish=function(a){var b=fcyc,c=0;this.f&&(c=fc$(this.f));b.o[a]=b.o[a]||[];for(var b=b.o[a],d=0;d<b[fcr];d++)b[d].container?b[d].callback[fcE](b[d].container,a,c):fcd.rpc[fcE](b[d].frameId,a,fcc,a,c)};var fclc=fcT(fc5[fc].publish,new fc5),fcyc=new fckc,fc4=new fc9;fc4.Ea(fc4.yb);fcU("google.friendconnect.container",fc4);fcU("google.friendconnect.container.refreshGadgets",fc4.U);
fcU("google.friendconnect.container.setParentUrl",fc4.X);fcU("google.friendconnect.container.setServerBase",fc4.Y);fcU("google.friendconnect.container.setServerVersion",fc4.Bc);fcU("google.friendconnect.container.createGadget",fc4.N);fcU("google.friendconnect.container.openLightboxIframe",fc4.sa);fcU("google.friendconnect.container.renderGadget",fc4.I);fcU("google.friendconnect.container.render",fc4.render);fcU("google.friendconnect.container.goBackToSite",fc4.Pb);
fcU("google.friendconnect.container.renderMembersGadget",fc4.nc);fcU("google.friendconnect.container.renderReviewGadget",fc4.pc);fcU("google.friendconnect.container.renderCommentsGadget",fc4.ua);fcU("google.friendconnect.container.renderSignInGadget",fc4.ab);fcU("google.friendconnect.container.renderFriendBar",fc4.mc);fcU("google.friendconnect.container.renderSocialBar",fc4.xa);fcU("google.friendconnect.container.renderCanvasSignInGadget",fc4.lc);
fcU("google.friendconnect.container.renderUrlCanvasGadget",fc4.qc);fcU("google.friendconnect.container.renderEmbedSignInGadget",fc4.wa);fcU("google.friendconnect.container.renderUrlEmbedGadget",fc4.bb);fcU("google.friendconnect.container.renderEmbedGadget",fc4.va);fcU("google.friendconnect.container.renderWallGadget",fc4.rc);fcU("google.friendconnect.container.renderAdsGadget",fc4.kc);fcU("google.friendconnect.container.renderOpenSocialGadget",fc4.oc);
fcU("google.friendconnect.container.setNoCache",fc4.fb);fcU("google.friendconnect.container.enableProxy",fc4.Ka);fcU("google.friendconnect.container.setDomain",fc4.xc);fcU("google.friendconnect.container.setLockedDomainSuffix",fc4.Ac);fcU("google.friendconnect.container.setLocale",fc4.zc);fcU("google.friendconnect.container.loadOpenSocialApi",fc4.$b);fcU("google.friendconnect.container.initOpenSocialApi",fc4.oa);fcU("google.friendconnect.container.getOpenSocialApiIframeId",fc4.Lb);
fcU("google.friendconnect.container.setApiVersion",fc4.uc);fcU("google.friendconnect.container.getEmbedUrl",fc4.D);fcU("google.friendconnect.container.getEmbedHtml",fc4.C);fcU("google.friendconnect.container.getGadgetSecurityToken",fc4.Hb);fcU("google.friendconnect.container.getGadgetCommunityId",fc4.Gb);fcU("google.friendconnect.container.showEmbedDialog",fc4.Dc);fcU("google.friendconnect.container.showMemberProfile",fc4.za);fcU("google.friendconnect.requestSignIn",fcBc);
fcU("google.friendconnect.requestSignOut",fcFc);fcU("google.friendconnect.requestSettings",fcGc);fcU("google.friendconnect.requestInvite",fcHc);fcU("google.friendconnect.renderSignInButton",fcCc);fcU("google.friendconnect.container.invokeOpenSocialApiViaIframe",fc4.Sb);fcU("google.friendconnect.container.removeOpenSocialApiViaIframe",fc4.jc);fcU("google.friendconnect.userAgent.WEBKIT",fc5a);fcU("google.friendconnect.userAgent.IE",fcW);fcU("google.friendconnect.PeopleSelectorOnChange",fcDc);
fcU("google.friendconnect.container.setDateStamp_",fc4.wc);
google.friendconnect.container.setServerBase('http://www-a-fc-opensocial.googleusercontent.com/ps/');google.friendconnect.container.setServerVersion('0.558.7');google.friendconnect.container.setApiVersion('0.8');
google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/activities.xml', 'http://q8j0igk2u2f6kf7jogh6s66md2d7r154-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/ads.xml', 'http://t767uouk8skpac15v8ue0n16regb3m2t-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/ask.xml', 'http://uofgf6lm45rimd9jp6hn983ul6n2en81-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/friendbar.xml', 'http://p7rjrrl49ose4gob99eonlvp0drmce3d-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/content_reveal.xml', 'http://n0mc7q283f00tpk3uifa7sjv4hmrults-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/chat.xml', 'http://4mmefl67as0q39gf1o4pnocubqmdgei0-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/donate.xml', 'http://7v4nflqvq38notsghmcr5a9t6o9g6kn4-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/lamegame.xml', 'http://ffbrstu9puk7qmt45got9mqe5k7ijrs4-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/map.xml', 'http://k0dfp8trn0hi5d2spmo7jmc88n6kr1cc-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/members.xml', 'http://r1rk9np7bpcsfoeekl0khkd2juj27q3o-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/newsletterSubscribe.xml', 'http://k830suiki828goudg9448o6bp0tpu5r3-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/poll.xml', 'http://1ivjd75aqp679vbgohjv74tlhn13rgdu-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/recommended_pages.xml', 'http://iqavu79a908u5vcecp0pq80hhbhkv33b-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/review.xml', 'http://r85jiaoot111joesr8bilfhfeslcc496-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/sample.xml', 'http://785aoao97uti9iqffknjp5e0kn2ljlm4-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/signin.xml', 'http://8fkcem1ves287v3g5lu9gep1j91p3kk1-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/wall.xml', 'http://o29lt44ell30t7ljcdfr8lq2mjakv2co-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setDomain('http://www.google.com/friendconnect/gadgets/osapi-0.8.xml', 'http://mc8tdi0ripmbpds25eboaupdulritrp6-a-fc-opensocial.googleusercontent.com/ps/');

google.friendconnect.container.setLockedDomainSuffix('-a-fc-opensocial.googleusercontent.com/ps/');
window['__ps_loaded__'] = true; 
 }google.friendconnect_ = google.friendconnect;
google.friendconnect.container.setDateStamp_('130355fd5ae');