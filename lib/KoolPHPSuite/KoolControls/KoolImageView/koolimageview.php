<?php $_hl0="\061.4.\061\0560"; if (!class_exists("KoolS\143\162iptin\147",FALSE)) { class koolscripting { static function start() { ob_start(); return ""; } static function end() { $_hO0=ob_get_clean(); $_hl1=""; $_hO1=new domdocument(); $_hO1->loadxml($_hO0); $_hl2=$_hO1->documentElement; $id=$_hl2->getattribute("id"); $name=$_hl2->nodeName; $id=($id == "") ? "\144ump": $id; if (class_exists($name,FALSE)) { eval ("\044".$id."\040\075 new ".$name."('".$id."\047\051;"); $$id->loadxml($_hl2); $_hl1=$$id->render(); } else { $_hl1.=$_hO0; } return $_hl1; } } } if ( isset ($_GET[md5("js")])) { header("Con\164\145nt-typ\145\072 tex\164\057java\163\143ript"); ?> function _hO(_ho){return document.getElementById(_ho); }function _hY(_hy){return (_hy!=null); }function _hI(_hi,_hA){var _ha=document.createElement(_hi); _hA.appendChild(_ha); return _ha; }function _hE(_he,_hU,_hu){return _hu.replace(eval("/"+_he+"/g"),_hU); }function _hZ(_hy,_hz){_hz=(_hY(_hz))?_hz: 1; for (var i=0; i<_hz; i++)_hy=_hy.parentNode; return _hy; }function _hX(_hy,_hz){_hz=(_hY(_hz))?_hz: 1; for (var i=0; i<_hz; i++)_hy=_hy.firstChild; return _hy; }function _hx(_hy,_hz){_hz=(_hY(_hz))?_hz: 1; for (var i=0; i<_hz; i++)_hy=_hy.nextSibling; return _hy; }function _hW(_hy,_hz){_hz=(_hY(_hz))?_hz: 1; for (var i=0; i<_hz; i++)_hy=_hy.previousSibling; return _hy; }function _hW(_hy,_hz){_hz=(_hY(_hz))?_hz: 1; for (var i=0; i<_hz; i++)_hy=_hy.previousSibling; return _hy; }function _hw(_hy,_hV){_hy.style.display=(_hV)?"": "none"; }function _hv(_hy){return (_hy.style.display!="none"); }function _hT(_hy,_hV){_hy.style._ht=_hY(_hV)?_hV/100: ""; _hy.style.filter=_hY(_hV)?"alpha(opacity="+_hV+")": ""; ; _hy.style.opacity=_hY(_hV)?_hV/100: ""; }function _hS(_hy,_hV){_hy.style.height=_hY(_hV)?_hV+"px": ""; }function _hs(_hy){return parseInt(_hy.style.height); }function _hR(_hy,_hV){_hy.style.width=_hY(_hV)?_hV+"px": ""; }function _hr(_hy){return parseInt(_hy.style.width); }function _hQ(_hy,_hV){_hy.style.top=_hY(_hV)?_hV+"px": ""; }function _hq(_hy){return parseInt(_hy.style.top); }function _hP(_hy,_hV){_hy.style.left=_hY(_hV)?_hV+"px": ""; }function _hp(_hy){return parseInt(_hy.style.left); }function _hN(_hy,_hV){_hy.style.zIndex=_hY(_hV)?_hV:null; }function _hn(_hy){return parseInt(_hy.style.zIndex); }function _hM(_hy){return _hy.className; }function _hm(_hy,_hV){_hy.className=_hV; }function _hL(_hl,_hK){return _hK.indexOf(_hl); }function _hk(_hl,_hJ,_hj){_hm(_hj,_hM(_hj).replace(_hl,_hJ)); }function _hH(_hy,_hh){if (_hy.className.indexOf(_hh)<0){var _hG=_hy.className.split(" "); _hG.push(_hh); _hy.className=_hG.join(" "); }}function _hg(_hy,_hh){if (_hy.className.indexOf(_hh)>-1){_hk(_hh,"",_hy);var _hG=_hy.className.split(" "); _hy.className=_hG.join(" "); }}function _hF(_hf,_hh,_hD){_hD=_hY(_hD)?_hD:document.body; var _hd=_hD.getElementsByTagName(_hf); var _hC=new Array(); for (var i=0; i<_hd.length; i++)if (_hd[i].className.indexOf(_hh)>=0){_hC.push(_hd[i]); }return _hC; }function _hc(_hB,_hb,_ho0,_hO0){if (_hB.addEventListener){_hB.addEventListener(_hb,_ho0,_hO0); return true; }else if (_hB.attachEvent){if (_hO0){return false; }else {var _hl0= function (){_ho0.apply(_hB,[window.event]); };if (!_hB["ref"+_hb])_hB["ref"+_hb]=[]; else {for (var _hi0 in _hB["ref"+_hb]){if (_hB["ref"+_hb][_hi0]._ho0 === _ho0)return false; }}var _hI0=_hB.attachEvent("on"+_hb,_hl0); if (_hI0)_hB["ref"+_hb].push( {_ho0:_ho0,_hl0:_hl0 } ); return _hI0; }}else {return false; }}function _ho1(_hO1){var a=_hO1.attributes,i,_hl1,_hi1; if (a){_hl1=a.length; for (i=0; i<_hl1; i+=1){_hi1=a[i].name; if (typeof _hO1[_hi1] === "function"){_hO1[_hi1]=null; }}}a=_hO1.childNodes; if (a){_hl1=a.length; for (i=0; i<_hl1; i+=1){_ho1(_hO1.childNodes[i]); }}}function _hI1(){var _ho2=0,_hO2=0; if (typeof(window.innerWidth)=="number"){_ho2=window.innerWidth; _hO2=window.innerHeight; }else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)){_ho2=document.documentElement.clientWidth; _hO2=document.documentElement.clientHeight; }else if (document.body && (document.body.clientWidth || document.body.clientHeight)){_ho2=document.body.clientWidth; _hO2=document.body.clientHeight; }return {_ho2:_ho2,_hO2:_hO2 } ; }function _hl2(){var _ho2=(document.body.scrollWidth>document.documentElement.scrollWidth)?document.body.scrollWidth:document.documentElement.scrollWidth; var _hO2=(document.body.scrollHeight>document.documentElement.scrollHeight)?document.body.scrollHeight:document.documentElement.scrollHeight; return {_ho2:_ho2,_hO2:_hO2 } ; }function _hi2(_hI2,_ho3){var _hO3=""; if (document.defaultView && document.defaultView.getComputedStyle){var _hl3=document.defaultView.getComputedStyle(_hI2,null); if (!_hl3){try {if (_hI2.style.display=="none"){_hI2.style.display=""; _hl3=document.defaultView.getComputedStyle(_hI2,null); if (_hl3){_hO3=_hl3.getPropertyValue(_ho3); }_hI2.style.display="none"; }}catch (_hi3){}}if (_hl3 && _hO3==""){_hO3=_hl3.getPropertyValue(_ho3); }}else if (_hI2.currentStyle){try {_ho3=_ho3.replace(/-(\w)/g, function (_hI3,_ho4){return _ho4.toUpperCase(); } ); _hO3=_hI2.currentStyle[_ho3]; }catch (_hi3){}}return _hO3; } ; function _hO4(_hl4){var _hi4=0; var _hI4=new Array(); var _ho5=_hl4; var _hO5=_hl5(); while (_hl4.offsetParent){_hI4.push(_hl4); if (this._hi5 && _hl4.nodeName=="TR")_hi4+=_hl4.firstChild.offsetTop-_hl4.firstChild.scrollTop; else _hi4+=_hl4.offsetTop-((_hO5=="opera" || _hl4.nodeName=="TR")?0:_hl4.scrollTop); _hl4=_hl4.offsetParent; }if (_hO5=="safari")_hi4+=document.body.offsetTop; if (_hO5=="ie")if (document.documentElement && document.documentElement.clientWidth)if (document.body.topMargin){try {_hI5=_hi2(document.body,"margin-top"); if (_hI5=="auto")_hI5="0"; _hi4+=parseInt((_hI5!="")?_hI5:document.body.topMargin); }catch (_ho6){}}if ((_hO5=="safari" || _hO5=="firefox" || _hO5=="opera") && _hI4.length>0){_hl4=_ho5; while (_hl4.offsetParent){var _hO6= false; if (_hl4.nodeName.toLowerCase()=="div" && _hl4.style.position!="absolute" && _hl4.style.position!="relative" && _hl4.style.position!="fixed"){for (var _hl6=0; _hl6<_hI4.length; _hl6++){if (_hI4[_hl6]==_hl4){_hO6= true; break; }}if (_hO6== false){_hi4-=_hl4.scrollTop; }}_hl4=_hl4.parentNode; }}return _hi4; } ; function _hi6(_hl4){var _hi4=0; var _hI4=new Array(); var _ho5=_hl4; var _hO5=_hl5(); while (_hl4.offsetParent){_hI4.push(_hl4); if (this._hi5 && _hl4.nodeName=="TR")_hi4+=_hl4.firstChild.offsetLeft-_hl4.firstChild.scrollLeft; else _hi4+=_hl4.offsetLeft-((_hO5=="opera" || _hl4.nodeName=="TR")?0:_hl4.scrollLeft); _hl4=_hl4.offsetParent; }if (_hO5=="safari")_hi4+=document.body.offsetLeft; if (_hO5=="ie")if (document.documentElement && document.documentElement.clientWidth)if (document.body.leftMargin){try {_hI6=_hi2(document.body,"margin-left"); if (_hI6=="auto")_hI6="0"; _hi4+=parseInt(((_hI6!="")?_hI6:document.body.leftMargin)); }catch (_ho6){}}if ((_hO5=="safari" || _hO5=="firefox" || _hO5=="opera") && _hI4.length>0){_hl4=_ho5; while (_hl4.offsetParent){var _hO6= false; if (_hl4.nodeName.toLowerCase()=="div" && _hl4.style.position!="absolute" && _hl4.style.position!="relative" && _hl4.style.position!="fixed"){for (var _hl6=0; _hl6<_hI4.length; _hl6++){if (_hI4[_hl6]==_hl4){_hO6= true; break; }}if (_hO6== false){_hi4-=_hl4.scrollLeft; }}_hl4=_hl4.parentNode; }}return _hi4; } ; function _ho7(){return (document.body.scrollLeft+document.documentElement.scrollLeft); }function _hO7(){return (document.body.scrollTop+document.documentElement.scrollTop); }function _hl7(_hi7,_hI7,_ho8,_hO8){return _ho8*_hi7/_hO8+_hI7; }function _hl8(_hi7,_hI7,_ho8,_hO8){return _ho8*(_hi7 /= _hO8)*_hi7+_hI7; }function _hi8(_hi7,_hI7,_ho8,_hO8){if ((_hi7 /= _hO8/2)<1)return _ho8/2*_hi7*_hi7+_hI7; return -_ho8/2*(( --_hi7)*(_hi7-2)-1)+_hI7; }function _hl5(){var _hI8=navigator.userAgent.toLowerCase(); if (_hL("opera",_hI8)!=-1){return "opera"; }else if (_hL("firefox",_hI8)!=-1){return "firefox"; }else if (_hL("safari",_hI8)!=-1){return "safari"; }else if ((_hL("msie",_hI8)!=-1) && (_hL("opera",_hI8)==-1)){return "ie"; }else {return "firefox"; }}function KoolImageView(_ho9,_hO9,_hl9,_hi9,_hI9,_hoa,_hOa,_hla,_hia,_hIa){ this._ho9=_ho9; this._hO9=_hO9; this._hob=_hl9; this._hi9=_hi9; this._hOb=_hoa; this._hlb=_hOa; this._hI9=_hI9; this._hla=_hla; this._hia=_hia; this._hIa=_hIa; this._hib="closed"; this._hIb=new Array(); this._hoc(); }KoolImageView.prototype= {_hoc:function (){var _hOc=_hZ(_hO(this._ho9+".zoompanel")); document.body.insertBefore(_hOc,document.body.firstChild); var _hlc=_hO(this._ho9); var _hic=_hO(this._ho9+".bigimage"); _hc(_hlc,"click",_hIc, false); _hc(_hlc,"mouseover",_hod, false); _hc(_hlc,"mouseout",_hOd, false); _hc(_hic,"load",_hld, false); _hc(_hic,"click",_hid, false); _hc(window,"resize",eval("__=function(_e){"+this._ho9+".WRS(_e);}"), false); if (this._hi9>0){var _hId=_hO(this._ho9+".background"); _hc(_hId,"click",_hoe, false); }var _hOe=_hO(this._ho9+".zoompanel"); _hc(_hOe,"mouseover",_hle, false); _hc(_hOe,"mouseout",_hie, false); var _hIe=_hF("a","CloseButton",_hOe); for (var i in _hIe)if (typeof _hIe[i]!="function")_hc(_hIe[i],"click",_hof, false); } ,open:function (){if (!this._hOf("OnBeforeOpen",null))return; this._hib="loading"; if (this._hob){ this._hl9(1); }var _hic=_hO(this._ho9+".bigimage"); _hic.src=this._hO9; } ,_hIf:function (){var _hOe=_hO(this._ho9+".zoompanel"); var _hic=_hO(this._ho9+".bigimage"); var _hog=_ho7(); var _hOg=_hO7(); var _hlg=_hI1(); _hH(_hOe,"kivTransparent"); _hQ(_hOe,0); _hP(_hOe,0); _hw(_hOe,1); var _hig=_hOe.offsetWidth; var _hIg=_hOe.offsetHeight; var _hlc=_hO(this._ho9); var _hoh=_hi6(_hlc); var _hOh=_hO4(_hlc); var _hlh=_hlc.offsetWidth; var _hih=_hlc.offsetHeight; switch (this._hla){case "RELATIVE":var _hIh=_hoh+this._hia; var _hoi=_hOh+this._hIa; break; case "IMAGE_CENTER":var _hIh=_hoh-(_hig-_hlh)/2; var _hoi=_hOh-(_hIg-_hih)/2; break; case "SCREEN_CENTER":default:var _hIh=(_hlg._ho2-_hig)/2+_hog; var _hoi=(_hlg._hO2-_hIg)/2+_hOg; break; }_hP(_hOe,_hIh); _hQ(_hOe,_hoi); this._hOi=this._hli(); this._hii=new Object(); this._hii._hIi=_hic.width; this._hii._hoj=_hic.height; this._hii._hig=_hig; this._hii._hIg=_hIg; _hw(_hOe,0); _hg(_hOe,"kivTransparent"); if (_hl5()!="safari" && _hl5()!="ie"){var _hOj=_hF("span","OpacityRender",_hOe); for (var i in _hOj)if (typeof _hOj[i]!="function"){_hT(_hOj[i],0); }}} ,_hli:function (){var _hic=_hO(this._ho9+".bigimage"); var _hOe=_hO(this._ho9+".zoompanel"); var _top=0; var _hlj=0; var _hD=_hic; while (_hD!=_hOe){_top+=_hD.offsetTop; _hlj+=_hD.offsetLeft; _hD=_hD.offsetParent; }return {_hlj:_hlj,_top:_top } ; } ,_hij:function (){var _hOe=_hO(this._ho9+".zoompanel"); _hT(_hOe,null); _hw(_hOe,1); if (this._hi9>0){var _hId=_hO(this._ho9+".background"); _hT(_hId,this._hi9); this._hIj(1); } this._hib="opened"; this._hOf("OnOpen",null); if (_hl5()!="safari" && _hl5()!="ie"){ this.ORD(0,1); }} ,close:function (){if (!this._hOf("OnBeforeClose",null))return; this._hib="closing"; this.DZM(this._hlb,-1); } ,getStatus:function (){return this._hib; } ,_hok:function (){var _hOe=_hO(this._ho9+".zoompanel"); var _hic=_hO(this._ho9+".bigimage"); _hw(_hOe,0); _hic.src=""; if (_hl5()=="opera"){var _hD=_hZ(_hic); _ho1(_hic); var _hOk=_hI("img",_hD); _hD.insertBefore(_hOk,_hic); _hOk.id=this._ho9+".bigimage"; _hm(_hOk,"kivBigImage"); _hc(_hOk,"load",_hld, false); _hc(_hOk,"click",_hid, false); _hD.removeChild(_hic); }if (this._hi9>0){var _hId=_hO(this._ho9+".background"); _hT(_hId,this._hi9); this._hIj(0); } this._hib="closed"; this._hOf("OnClose",null); } ,DZM:function (_hlk,_hik){if (_hlk<=0 && _hik<0){ this._hIk(_hlk,1); this._hok(); return; }if (_hlk>=this._hlb && _hik>0){ this._hIk(_hlk,1); this._hij(); return; } this._hIk(_hlk,0); setTimeout(this._ho9+".DZM("+(_hlk+_hik)+","+_hik+")",this._hOb/this._hlb); } ,_hIk:function (_hlk,_hol){switch (this._hI9){case "fading":var _hOe=_hO(this._ho9+".zoompanel"); var _hll=_hl7(_hlk,0,100-0,this._hlb); _hT(_hOe,_hll); _hw(_hOe,1); if (this._hi9>0){var _hll=_hl7(_hlk,0,this._hi9-0,this._hlb); var _hId=_hO(this._ho9+".background"); _hT(_hId,_hll); this._hIj(1); }break; case "zooming":var _hil=_hO(this._ho9+".effectpanel"); var _hIl=_hO(this._ho9+".effectimage"); var _hOe=_hO(this._ho9+".zoompanel"); var _hlc=_hO(this._ho9); var _hic=_hO(this._ho9+".bigimage"); if (_hol){_hw(_hil,0); _hw(_hIl,0); _hIl.src=""; if (_hlk==0){_hT(_hlc,null); }return; }if (_hlk==0){_hIl.src=this._hO9; _hT(_hlc,0); }if (_hlk==this._hlb){_hIl.src=this._hO9; _hw(_hOe,0); if (this._hi9>0){var _hId=_hO(this._ho9+".background"); _hw(_hId,0); }}var _hoh=_hi6(_hlc); var _hOh=_hO4(_hlc); var _hlh=_hlc.width; var _hih=_hlc.height; var _hIh=_hp(_hOe); var _hoi=_hq(_hOe); var _hig=this._hii._hig; var _hIg=this._hii._hIg; var _hIi=this._hii._hIi; var _hoj=this._hii._hoj; var _hom=(_hlh/_hIi)*_hig; var _hOm=(_hih/_hoj)*_hIg; var _hIm=_hi8(_hlk,_hom,_hig-_hom,this._hlb); var _hon=_hi8(_hlk,_hOm,_hIg-_hOm,this._hlb); var _hOn=(_hlh/_hIi)*this._hOi._hlj; var _hIn=(_hlh/_hIi)*this._hOi._top; var _hoo=_hoh-_hOn; var _hOo=_hOh-_hIn; var _hIo=_hi8(_hlk,_hoo,_hIh-_hoo,this._hlb); var _hop=_hi8(_hlk,_hOo,_hoi-_hOo,this._hlb); var _hOp=_hIh+this._hOi._hlj; var _hlp=_hoi+this._hOi._top; var _hip=_hi8(_hlk,_hoh,_hOp-_hoh,this._hlb); var _hIp=_hi8(_hlk,_hOh,_hlp-_hOh,this._hlb); var _hoq=_hi8(_hlk,_hlh,_hIi-_hlh,this._hlb); var _hOq=_hi8(_hlk,_hih,_hoj-_hih,this._hlb); _hP(_hil,_hIo); _hQ(_hil,_hop); _hR(_hil,_hIm); _hS(_hil,_hon); _hw(_hil,1); _hP(_hIl,_hip); _hQ(_hIl,_hIp); _hR(_hIl,_hoq); _hS(_hIl,_hOq); _hw(_hIl,1); break; }} ,ORD:function (_hlk,_hik){var _hOe=_hO(this._ho9+".zoompanel"); var _hOj=_hF("span","OpacityRender",_hOe); if (_hOj.length>0){if (_hlk<=0 && _hik<0){return; }if (_hlk>=this._hlb && _hik>0){for (var i in _hOj)if (typeof _hOj[i]!="function"){_hT(_hOj[i],null); }return; }var _hll=_hl7(_hlk,0,100-0,this._hlb); for (var i in _hOj)if (typeof _hOj[i]!="function"){_hT(_hOj[i],_hll); }setTimeout(this._ho9+".ORD("+(_hlk+_hik)+","+_hik+")",this._hOb/this._hlb); }} ,registerEvent:function (_hlq,_hiq){ this._hIb[_hlq]=_hiq; } ,_hOf:function (_hlq,_hIq){return (_hY(this._hIb[_hlq]))?this._hIb[_hlq](this,_hIq): true; } ,_hl9:function (_hor){var _hOr=_hO(this._ho9+".loading"); if (_hor){var _hlc=_hO(this._ho9); var _hoh=_hi6(_hlc); var _hOh=_hO4(_hlc); var _hlh=_hlc.offsetWidth; var _hih=_hlc.offsetHeight; if (isNaN(_hih) || isNaN(_hlh)){return; }_hH(_hOr,"kivTransparent"); _hw(_hOr,1); _hP(_hOr,0); _hQ(_hOr,0); var _hlr=_hOr.offsetWidth; var _hir=_hOr.offsetHeight; var _hIr=(_hlh-_hlr)/2+_hoh; var _hos=(_hih-_hir)/2+_hOh; _hP(_hOr,_hIr); _hQ(_hOr,_hos); _hg(_hOr,"kivTransparent"); }else {_hw(_hOr,0); }} ,_hOs:function (_hls){if (!this._hOf("OnBeforeImageClick",null))return; if (this._hib=="closed"){ this.open(); } this._hOf("OnImageClick",null); } ,_his:function (_hls){ this._hOf("OnImageMouseOver",null); } ,_hIs:function (_hls){ this._hOf("OnImageMouseOut",null); } ,_hot:function (){if (this._hob){ this._hl9(0); } this._hIf(); if (this._hi9>0){var _hId=_hO(this._ho9+".background"); _hT(_hId,this._hi9); this._hIj(1); } this._hib="opening"; this.DZM(0,1); } ,_hOt:function (){if (!this._hOf("OnBeforeBigImageClick",null))return; this.close(); this._hOf("OnBigImageClick",null); } ,_hlt:function (){if (!this._hOf("OnBeforeBackgroundClick",null))return; this.close(); this._hOf("OnBackgroundClick",null); } ,_hit:function (_hls){if (!this._hOf("OnBeforeCloseButtonClick",null))return; this.close(); this._hOf("OnCloseButtonClick",null); } ,_hIt:function (_hls){ this._hOf("OnZoomPanelMouseOver",null); } ,_hou:function (_hls){ this._hOf("OnZoomPanelMouseOut",null); } ,_hIj:function (_hor){if (this._hi9>0){var _hId=_hO(this._ho9+".background"); if (_hor){var _hOu=_hl2(); var _hlg=_hI1(); var _ho2=(_hOu._ho2>_hlg._ho2)?_hOu._ho2:_hlg._ho2; var _hO2=(_hOu._hO2>_hlg._hO2)?_hOu._hO2:_hlg._hO2; _hR(_hId,_ho2); _hS(_hId,_hO2); _hQ(_hId,0); _hP(_hId,0); _hw(_hId,1); }else {_hw(_hId,0); }}} ,WRS:function (_hls){if (this._hi9>0 && this._hib=="opened"){var _hId=_hO(this._ho9+".background"); _hw(_hId,0); this._hIj(1); }}};function _hIc(_hls){var _hlu=eval("__="+this.id); _hlu._hOs(_hls); }function _hOd(_hls){var _hlu=eval("__="+this.id); _hlu._hIs(); }function _hod(_hls){var _hlu=eval("__="+this.id); _hlu._his(); }function _hid(_hls){var _hlu=eval("__="+_hE(".bigimage","",this.id)); _hlu._hOt(); }function _hld(_hls){var _hlu=eval("__="+_hE(".bigimage","",this.id)); _hlu._hot(); }function _hoe(_hls){var _hlu=eval("__="+_hE(".background","",this.id)); _hlu._hlt(); }function _hie(_hls){var _hlu=eval("__="+_hE(".zoompanel","",this.id)); _hlu._hou(); }function _hle(_hls){var _hlu=eval("__="+_hE(".zoompanel","",this.id)); _hlu._hIt(); }function _hof(_hls){var _hD=_hZ(this ); while (_hL(".zoompanel",_hD.id)<0){_hD=_hZ(_hD); }var _hlu=eval("__="+_hE(".zoompanel","",_hD.id)); _hlu._hit(_hls); }if (typeof(__KIVInits)!="undefined" && _hY(__KIVInits)){for (var i=0; i<__KIVInits.length; i++){__KIVInits[i](); }} <?php exit (); } function _hO2() { $_hl3=_hO3("\134","/",strtolower($_SERVER["\123\103RIPT_N\101\115E"])); $_hl3=_hO3(strrchr($_hl3,"\057"),"",$_hl3); $_hl4=_hO3("\134","/",realpath(".")); $_hO4=_hO3($_hl3,"",strtolower($_hl4)); return $_hO4; } function _hl5($_hO5,$_hl6) { $_hO6=""; foreach ($_hO5->childNodes as $_hl7) { $_hO6.=$_hl6->savexml($_hl7); } return trim($_hO6); } function _hO3($_hO7,$_hl8,$_hO8) { return str_replace($_hO7,$_hl8,$_hO8); } if (!class_exists("Koo\154\111mageVi\145\167",FALSE)) { class koolimageview { var $_hl0="\061\0564.1.0"; var $id; var $styleFolder=""; var $_hl9; var $scriptFolder=""; var $imageUrl=""; var $cssClass=""; var $bigImageUrl=""; var $effect="zoo\155\151ng"; var $backgroundOpacity=031; var $openTime=0310; var $frameNumber=017; var $_hO9=TRUE; var $description=""; var $zIndex=01750; var $position="SCR\105\105N_CEN\124\105R"; var $relativeLeft=0; var $relativeTop=0; var $alternative=""; var $thumbnailWidth=NULL; var $imageWidth=NULL; var $thumbnailHeight=NULL; var $imageHeight=NULL; function __construct($_hla) { $this->id =$_hla; } function loadxml($_hOa) { if (gettype($_hOa) == "\163tring") { $_hlb=new domdocument(); $_hlb->loadxml($_hOa); $_hOa=$_hlb->documentElement; } $_hla=$_hOa->getattribute("\151d"); if ($_hla != "") $this->id =$_hla; $_hOb=$_hOa->getattribute("\163\164yleF\157\154der"); if ($_hOb != "") $this->styleFolder =$_hOb; } function render() { $_hlc="\n<!-\055\113oolIm\141\147\145Vi\145\167 vers\151\157n ".$this->_hl0."\040\055 www.ko\157\154php.n\145\164 -->\n"; $_hlc.=$this->registercss(); $_hlc.=$this->renderimageview(); $_hOc= isset ($_POST["__k\157\157lajax"]) || isset ($_GET["__koolaj\141\170"]); $_hlc.=($_hOc) ? "": $this->registerscript(); $_hlc.="\074scrip\164\040ty\160\145=\047text\057\152av\141\163cri\160\164'\076"; $_hlc.=$this->startupscript(); $_hlc.="</sc\162ipt>"; return $_hlc; } function renderimageview() { $this->_hld(); $_hOd="\173B\151\147Im\141\147e}"; $_hle="Lo\141\144in\147\056.\056"; $_hOe=""; $_hlf=""; $_hOf="\074img\040\151d=\047\173id\175\047 \163\162c='\173\151m\141\147eUr\154\175' al\164\075'\173a\154\164ernat\151\166e}' c\154\141ss\075\047\173s\164\171le}Zo\157\155Out \173\143\163sCla\163\163}' st\171\154e='\173\167\151dth};\173\150eight\175\047/><d\151\166 cla\163\163='\173\163\164yle}K\111\126' sty\154\145='di\163\160lay\072\151nlin\145\073'\076\173l\157\141di\156\147}\173\142ack\147\162ou\156d}\173\145ffe\143tpan\145l}\173\145ffe\143tim\141\147e}\173\172o\157\155pa\156\145l}<\057\144iv>"; $_hlg="<div i\144\075'\173id\175\056zoom\160\141nel' \143\154ass='\153\151vZo\157\155Pane\154\047 styl\145\075'dis\160\154\141y:n\157\156e;z-\151\156dex:\173\172\111ndex\175\073'>\173\164\160l_zoo\155\160anel}\074\057div>"; $_hOg="\074\144iv id\075\047\173id\175\056load\151\156g' cl\141\163s='k\151\166Loa\144\151ng' s\164\171le='p\157\163\151tio\156\072abso\154\165te;di\163\160lay:n\157\156\145;z-\151\156dex:\173\172\111ndex\175\073'>\173\164\160\154_lo\141\144ing}<\057\144iv>"; $_hlh="\074\144iv id='\173\151d}.ba\143\153groun\144\047 cla\163\163='ki\166\102ackg\162\157und'\040\163tyle=\047\144ispla\171\072none;\172\055inde\170\072\173zI\156\144ex};'\076\173tpl_b\141\143kgrou\156\144}</di\166\076"; $_hOh="\074\144iv id=\047\173id}.e\146\146ectpa\156\145l' cl\141\163s='k\151\166Effe\143\164Panel\047\040styl\145\075'disp\154\141y:non\145\073posit\151\157n:abs\157\154ute;z\055\151ndex\072\173zInde\170\175;'>\173\164\160l_ef\146\145\143tpa\156\145l}</d\151\166>"; $_hOi="\074img i\144\075'\173i\144\175.bigi\155\141ge' c\154\141ss='\153\151vBig\111\155age' \141\154t='' \163\164yle='\173\167idth}\073\173heig\150\164\175'/>"; $_hlj="\074img \151\144='\173i\144\175.effec\164\151mage\047\040clas\163\075'ki\166\105ffect\111\155age' \163\164yle='d\151\163play:\156\157ne;po\163\151tion:\141\142solut\145\073z-ind\145\170:\173z\111\156\144ex}\073\047 alt\075\047'/>"; $_hOj="<s\160\141\156 cla\163\163='kivD\145\163crip\164\151on'>\173\144\145scr\151\160tion\175\074/span\076"; $_hlk="<a\040\143lass='k\151\166Close\102\165tton'\076\040</a>"; $_hOk="\074\141 clas\163\075'kivM\157\166eButt\157\156'> </\141\076"; $_hlb=new domdocument(); $_hlb->load((($this->scriptFolder == "") ? _hO2(): "").$this->_hll()."/".$this->_hl9."\057".$this->_hl9.".xm\154"); $_hlm=$_hlb->getelementsbytagname("\172oomp\141\156el"); if ($_hlm->length >0) { $_hOd=_hl5($_hlm->item(0),$_hlb); } $_hlm=$_hlb->getelementsbytagname("\154oading"); if ($_hlm->length >0) { $_hle=_hl5($_hlm->item(0),$_hlb); } $_hlm=$_hlb->getelementsbytagname("back\147\162ound"); if ($_hlm->length >0) { $_hOe=_hl5($_hlm->item(0),$_hlb); } $_hlm=$_hlb->getelementsbytagname("\145\146fectpa\156\145l"); if ($_hlm->length >0) { $_hlf=_hl5($_hlm->item(0),$_hlb); } $_hOm=_hO3("\173id}",$this->id ,$_hOg); $_hOm=_hO3("\173\164pl_loa\144\151ng}",$_hle,$_hOm); $_hOm=_hO3("\173zInde\170\175",$this->zIndex ,$_hOm); $_hln=_hO3("\173\151d}",$this->id ,$_hlh); $_hln=_hO3("\173\164\160l_bac\153\147round}",$_hOe,$_hln); $_hln=_hO3("\173\172\111ndex\175",$this->zIndex +1,$_hln); $_hOn=_hO3("\173id}",$this->id ,$_hOh); $_hOn=_hO3("\173tpl_eff\145\143tpanel\175",$_hlf,$_hOn); $_hOn=_hO3("\173\172In\144\145x}",$this->zIndex +2,$_hOn); $_hlo=_hO3("\173\151\144}",$this->id ,$_hlj); $_hlo=_hO3("\173zInd\145\170}",$this->zIndex +3,$_hlo); $_hOo=_hO3("\173id}",$this->id ,$_hOi); $_hlp=_hO3("\173id}",$this->id ,$_hlg); $_hlp=_hO3("\173\164pl_zoo\155\160anel}",$_hOd,$_hlp); $_hlp=_hO3("\173Big\111\155\141ge}",$_hOo,$_hlp); $_hOp=_hO3("\173\144escript\151\157n}",$this->description ,$_hOj); $_hlp=_hO3("\173\104escri\160\164ion}",$_hOp,$_hlp); $_hlp=_hO3("\173\103\154oseButt\157\156}",$_hlk,$_hlp); $_hlp=_hO3("\173Mov\145\102\165tton\175",$_hOk,$_hlp); $_hlp=_hO3("\173zInd\145\170\175",$this->zIndex +4,$_hlp); $_hlp=_hO3("\173\167\151dth}",isset ($this->imageWidth) ? "wi\144\164h:$this->imageWidth" : "",$_hlp); $_hlp=_hO3("\173heigh\164\175",isset ($this->imageHeight) ? "h\145\151\147ht:$this->imageHeight" : "",$_hlp); $_hlq=_hO3("\173\151d}",$this->id ,$_hOf); $_hlq=_hO3("\173\163tyle}",$this->_hl9 ,$_hlq); $_hlq=_hO3("\173\141lternati\166\145}",$this->alternative ,$_hlq); $_hlq=_hO3("\173\143ssCla\163\163}",$this->cssClass ,$_hlq); $_hlq=_hO3("\173im\141\147\145Url}",$this->imageUrl ,$_hlq); $_hlq=_hO3("\173\172\157\157mpan\145\154}",$_hlp,$_hlq); $_hlq=_hO3("\173l\157\141ding}",$_hOm,$_hlq); $_hlq=_hO3("\173back\147\162\157und}",$_hln,$_hlq); $_hlq=_hO3("\173e\146\146ect\160\141ne\154\175",$_hOn,$_hlq); $_hlq=_hO3("\173eff\145\143ti\155\141ge}",$_hlo,$_hlq); $_hlq=_hO3("\173\167\151\144th}",isset ($this->thumbnailWidth) ? "widt\150\072$this->thumbnailWidth" : "",$_hlq); $_hlq=_hO3("\173\150\145ight\175",isset ($this->thumbnailHeight) ? "\150eight\072$this->thumbnailHeight" : "",$_hlq); return $_hlq; } function _hld() { $this->styleFolder =_hO3("\134","\057",$this->styleFolder); $_hOb=trim($this->styleFolder ,"/"); $_hOq=strrpos($_hOb,"\057"); $this->_hl9 =substr($_hOb,($_hOq ? $_hOq: -1)+1); } function registercss() { $this->_hld(); $_hlr="\074script \164\171pe='te\170\164/jav\141\163\143rip\164\047>if\040\050do\143\165ment\056\147etEle\155\145\156tBy\111\144('__\173\163tyle}\113\111V')==\156\165\154l)\173\166\141r _h\145\141d = d\157\143ument\056\147etEl\145\155\145nts\102\171TagNa\155\145('he\141\144')[0\135\073var \137\154ink =\040\144ocum\145\156\164.cr\145\141teEl\145\155\145nt(\047\154ink'\051\073 _li\156\153.id \075\040'__\173\163\164yle\175\113IV';_\154\151nk.r\145\154='st\171\154eshee\164\047; _l\151\156k.hr\145\146='\173\163\164yle\160\141th\175\057\173\163ty\154\145}\057\173styl\145\175.css\047\073_he\141\144.app\145\156dChi\154\144(_li\156\153);}<\057\163cri\160\164>"; $_hlc=_hO3("\173\163\164\171le}",$this->_hl9 ,$_hlr); $_hlc=_hO3("\173stylep\141\164\150}",$this->_hll(),$_hlc); return $_hlc; } function registerscript() { $this->_hld(); $_hlr="\074script\040\164ype='t\145\170t/jav\141\163cript\047\076if(t\171\160eo\146\040_libK\111\126=='un\144\145fined\047\051\173do\143\165ment\056\167rite\050\165nesca\160\145(\042%\063\103scrip\164\040type=\047\164ext/\152\141vascr\151\160t' sr\143\075'\173s\162\143}'%3\105\040%3C/\163\143ript%\063\105\042)\051\073_lib\113\111V=1;\175\040</sc\162\151\160t>"; $_hlc=_hO3("\173\163\162c}",$this->_hls()."?".md5("\152s"),$_hlr); return $_hlc; } function startupscript() { $this->_hld(); $_hlr="var\040\173id}; \146\165nction\040\173id}_\151\156it()\173\040\173i\144\175=new\040\113oolI\155\141geVie\167\050'\173i\144\175','\173\142\151gIm\141\147eUrl}\047\054\173sh\157\167Loadi\156\147},\173b\141\143kgrou\156\144Opa\143\151ty}\054\047\173\145ffe\143\164}'\054\173o\160\145n\124\151me\175\054\173f\162\141meNu\155\142er},\047\173posi\164\151on}',\173\162elat\151\166eLeft\175\054\173re\154\141tive\124\157p});\175"; $_hlr.="if (\164\171peof(K\157\157\154Ima\147\145View)\075\075'fun\143\164ion\047\051\173\173\151\144}_in\151\164();}"; $_hlr.="\145lse\173\151\146(type\157\146(__KIV\111\156its)=\075\047unde\146\151ned\047\051\173_\137\113\111VIn\151\164s=new\040\101rray(\051\073} _\137\113IVIni\164\163.push\050\173id}_i\156\151t);\173\162\145giste\162\137scrip\164\175}"; $_hOs="if(\164\171\160eof\050\137libKIV\051\075='u\156\144efine\144\047)\173\166\141r _\150\145ad = \144\157\143ume\156\164.getE\154\145ment\163\102\171Tag\116\141me('h\145\141d')[0\135\073var \137\163cript\040\075 doc\165\155ent.c\162\145ateEl\145\155ent('\163\143rip\164\047); _\163\143ript.\164\171pe='\164\145xt/ja\166\141scri\160\164'; _s\143\162ipt.s\162\143='\173\163\162c}';\040\137head\056\141ppen\144\103hild\050\137scri\160\164);_l\151\142KIV=1\073\175"; $_hlt=_hO3("\173\163\162\143}",$this->_hls()."?".md5("js"),$_hOs); $_hlc=_hO3("\173id}",$this->id ,$_hlr); $_hlc=_hO3("\173\163\164yle}",$this->_hl9 ,$_hlc); $_hlc=_hO3("\173bigIma\147\145Url}",$this->bigImageUrl ,$_hlc); $_hlc=_hO3("\173showLo\141\144ing}",($this->_hO9) ? "\061": "\060",$_hlc); $_hlc=_hO3("\173backg\162\157\165ndOp\141\143ity}",$this->backgroundOpacity ,$_hlc); $_hlc=_hO3("\173effec\164\175",$this->effect ,$_hlc); $_hlc=_hO3("\173openT\151\155e}",$this->openTime ,$_hlc); $_hlc=_hO3("\173\146rameN\165\155ber}",$this->frameNumber ,$_hlc); $_hlc=_hO3("\173\160osition\175",$this->position ,$_hlc); $_hlc=_hO3("\173relati\166\145Left}",$this->relativeLeft ,$_hlc); $_hlc=_hO3("\173\162elati\166\145Top}",$this->relativeTop ,$_hlc); $_hlc=_hO3("\173re\147\151\163ter_\163\143\162ipt\175",$_hlt,$_hlc); return $_hlc; } function _hls() { if ($this->scriptFolder == "") { $_hO4=_hO2(); $_hOt=substr(_hO3("\134","\057",__FILE__),strlen($_hO4)); return $_hOt; } else { $_hOt=_hO3("\134","\057",__FILE__); $_hOt=$this->scriptFolder.substr($_hOt,strrpos($_hOt,"\057")); return $_hOt; } } function _hll() { $_hlu=$this->_hls(); $_hOu=_hO3(strrchr($_hlu,"\057"),"",$_hlu)."/s\164yles"; return $_hOu; } } } ?> 
