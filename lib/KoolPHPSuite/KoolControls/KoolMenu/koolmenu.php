<?php $_kl0="1\0565.0.0"; function _kO0() { $_kl1=_kO1("\134","\057",strtolower($_SERVER["SCRI\120\124_NAME"])); $_kl1=_kO1(strrchr($_kl1,"\057"),"",$_kl1); $_kl2=_kO1("\134","/",realpath("\056")); $_kO2=_kO1($_kl1,"",strtolower($_kl2)); return $_kO2; } function _kl3($_kO3) { return md5($_kO3); } function _kO1($_kl4,$_kO4,$_kl5) { return str_replace($_kl4,$_kO4,$_kl5); } class _ki10 { static $_ki10="\1730}<d\151\166 id='\173\151d}' \143\154ass='\173\163tyle}\113\115U'\040\163tyl\145\075'z-in\144\145x:500\060\073'>\173\162\157ot} \173\061} \173s\145\164ting\175\040\173sel\145\143t}</d\151\166>\1732\175"; } function _kO5() { header("Conten\164\055\164ype\072\040text/\152\141\166asc\162\151\160t"); } function _kl6() { echo "\166ar _ki\117\061\0750;"; } function _kO6() { return exit (); } function _kl7() { return _ki10::$_ki10; } function _kO7( &$_kl8) { for ($_kO8=0; $_kO8<3; $_kO8 ++) $_kl8=_kO1("\173".$_kO8."\175","",$_kl8); return TRUE; } if ( isset ($_GET[_kl3("js")])) { _kO5(); ?> function _kO(_ko){return (_ko!=null); }function _kY(_ky){return document.getElementById(_ky); }function _kI(_ki,_kA){var _ka=document.createElement(_ki); _kA.appendChild(_ka); return _ka; }function _kE(_ko,_ke){if (!_kO(_ke))_ke=1; for (var i=0; i<_ke; i++)_ko=_ko.firstChild; return _ko; }function _kU(_ko,_ke){if (!_kO(_ke))_ke=1; for (var i=0; i<_ke; i++)_ko=_ko.nextSibling; return _ko; }function _ku(_ko,_ke){if (!_kO(_ke))_ke=1; for (var i=0; i<_ke; i++)_ko=_ko.parentNode; return _ko; }function _kZ(){return (typeof(_kiO1)=="undefined");}function _kz(_ko,_kX){_ko.style.top=_kO(_kX)?_kX+"px": ""; }function _kx(_ko){return parseInt(_ko.style.top); }function _kW(_ko,_kX){_ko.style.left=_kO(_kX)?_kX+"px": ""; }function _kw(_ko){return parseInt(_ko.style.left); }function _kV(_ko,_kX){_ko.style.height=_kX+"px"; }function _kv(_ko,_kX){_ko.style.width=_kX+"px"; }function _kT(_ko){return parseInt(_ko.style.width); }function _kt(_ko){return parseInt(_ko.style.height); }function _kS(_ko,_kX){_ko.style.zIndex=_kO(_kX)?_kX:null; }function _ks(_ko){if (_ko.style.zIndex!=null)return parseInt(_ko.style.zIndex); else return 0; }function _kR(_kr,_kQ,_kq){_kq=_kO(_kq)?_kq:document.body; var _kP=_kq.getElementsByTagName(_kr); var _kp=new Array(); for (var i=0; i<_kP.length; i++)if (_kP[i].className.indexOf(_kQ)>=0){_kp.push(_kP[i]); }return _kp; }function _kN(_ko,_kX){_ko.style.display=(_kX)?"": "none"; }function _kn(_ko){return (_ko.style.display!="none"); }function _kM(_ko){return _ko.className; }function _km(_ko,_kX){_ko.className=_kX; }function _kL(_kl,_kK,_kk){_km(_kk,_kM(_kk).replace(_kl,_kK)); }function _kJ(_ko,_kQ){if (_ko.className.indexOf(_kQ)<0){var _kj=_ko.className.split(" "); _kj.push(_kQ); _ko.className=_kj.join(" "); }}function _kH(_ko,_kQ){if (_ko.className.indexOf(_kQ)>-1){_kL(_kQ,"",_ko);var _kj=_ko.className.split(" "); _ko.className=_kj.join(" "); }}function _kh(_kG,_kg,_kF,_kf){if (_kG.addEventListener){_kG.addEventListener(_kg,_kF,_kf); return true; }else if (_kG.attachEvent){if (_kf){return false; }else {var _kD= function (){_kF.apply(_kG,[window.event]); };if (!_kG["ref"+_kg])_kG["ref"+_kg]=[]; else {for (var _kd in _kG["ref"+_kg]){if (_kG["ref"+_kg][_kd]._kF === _kF)return false; }}var _kC=_kG.attachEvent("on"+_kg,_kD); if (_kC)_kG["ref"+_kg].push( {_kF:_kF,_kD:_kD } ); return _kC; }}else {return false; }}function _kc(_kG,_kg,_kF,_kf){if (_kG.removeEventListener){_kG.removeEventListener(_kg,_kF,_kf); return true; }else if (_kG.detachEvent){if (_kG["ref"+_kg]){for (var _kd in _kG["ref"+_kg]){if (_kG["ref"+_kg][_kd]._kF === _kF){_kG.detachEvent("on"+_kg,_kG["ref"+_kg][_kd]._kD); _kG["ref"+_kg][_kd]._kF=null; _kG["ref"+_kg][_kd]._kD=null; delete _kG["ref"+_kg][_kd]; return true; }}}return false; }else {return false; }}function _kB(_kb){if (_kb.stopPropagation)_kb.stopPropagation(); else _kb.cancelBubble= true; }function _ko0(_kb){if (_kb.preventDefault)_kb.preventDefault(); else event.returnValue= false; return false; }function _kO0(_kl0){var a=_kl0.attributes,i,_ki0,_kI0; if (a){_ki0=a.length; for (i=0; i<_ki0; i+=1){if (a[i])_kI0=a[i].name; if (typeof _kl0[_kI0] === "function"){_kl0[_kI0]=null; }}}a=_kl0.childNodes; if (a){_ki0=a.length; for (i=0; i<_ki0; i+=1){_kO0(_kl0.childNodes[i]); }}}function _ko1(_kk){var _kO1=""; var _kl1=(_kk instanceof Array); for (var _ki1 in _kk){switch (typeof(_kk[_ki1])){case "string":_kO1+=(_kl1)?"\""+_kk[_ki1]+"\",": "\""+_ki1+"\":\""+_kk[_ki1]+"\","; break; case "number":_kO1+=(_kl1)?_kk[_ki1]+",": "\""+_ki1+"\":"+_kk[_ki1]+","; break; case "boolean":_kO1+=(_kl1)?(_kk[_ki1]?"true": "false")+",": "\""+_ki1+"\":"+(_kk[_ki1]?"true": "false")+","; break; case "object":_kO1+=(_kl1)?_ko1(_kk[_ki1])+",": "\""+_ki1+"\":"+_ko1(_kk[_ki1])+","; break; }}if (_kO1.length>0)_kO1=_kO1.substring(0,_kO1.length-1); _kO1=(_kl1)?"["+_kO1+"]": "{"+_kO1+"}"; if (_kO1=="{}")_kO1="null"; return _kO1; }function _kI1(_kl,_ko2){return _ko2.indexOf(_kl); }function _kO2(_kl2){if (_kl2.pageX || _kl2.pageY){return {_ki2:_kl2.pageX,_kI2:_kl2.pageY } ; }else if (_kl2.clientX || _kl2.clientY){return {_ki2:_kl2.clientX+(document.documentElement.scrollLeft?document.documentElement.scrollLeft:document.body.scrollLeft),_kI2:_kl2.clientY+(document.documentElement.scrollTop?document.documentElement.scrollTop:document.body.scrollTop)} ; }else {return {_ki2:null,_kI2:null } ; }}function _ko3(){var _kO3=navigator.userAgent.toLowerCase(); if (_kI1("opera",_kO3)!=-1){return "opera"; }else if (_kI1("firefox",_kO3)!=-1){return "firefox"; }else if (_kI1("safari",_kO3)!=-1){return "safari"; }else if ((_kI1("msie 6",_kO3)!=-1) && (_kI1("msie 7",_kO3)==-1) && (_kI1("msie 8",_kO3)==-1) && (_kI1("opera",_kO3)==-1)){return "ie6"; }else if ((_kI1("msie 7",_kO3)!=-1) && (_kI1("opera",_kO3)==-1)){return "ie7"; }else if ((_kI1("msie 8",_kO3)!=-1) && (_kI1("opera",_kO3)==-1)){return "ie8"; }else if ((_kI1("msie",_kO3)!=-1) && (_kI1("opera",_kO3)==-1)){return "ie"; }else if (_kI1("chrome",_kO3)!=-1){return "chrome"; }else {return "firefox"; }}function _kl3(_ki1){switch (_ki1.toLowerCase()){case "linear":return function (_ki3,b,_kI3,_kl0){return _kI3*_ki3/_kl0+b; } ; break; case "easein":return function (_ki3,b,_kI3,_kl0){return _kI3*(_ki3 /= _kl0)*_ki3+b; } ; break; case "easeout":return function (_ki3,b,_kI3,_kl0){return -_kI3*(_ki3 /= _kl0)*(_ki3-2)+b; } ; break; case "easeboth":return function (_ki3,b,_kI3,_kl0){if ((_ki3 /= _kl0/2)<1)return _kI3/2*_ki3*_ki3+b; return -_kI3/2*(( --_ki3)*(_ki3-2)-1)+b; } ; break; case "easeinstrong":return function (_ki3,b,_kI3,_kl0){return _kI3*(_ki3 /= _kl0)*_ki3*_ki3*_ki3+b; } ; break; case "easeoutstrong":return function (_ki3,b,_kI3,_kl0){return -_kI3*((_ki3=_ki3/_kl0-1)*_ki3*_ki3*_ki3-1)+b; } ; break; case "easebothstrong":return function (_ki3,b,_kI3,_kl0){if ((_ki3 /= _kl0/2)<1){return _kI3/2*_ki3*_ki3*_ki3*_ki3+b; }return -_kI3/2*((_ki3-=2)*_ki3*_ki3*_ki3-2)+b; } ; break; case "bouncein":return function (_ki3,b,_kI3,_kl0){return _kI3-(_kl3("bounceout"))(_kl0-_ki3,0,_kI3,_kl0)+b; } ; break; case "bounceout":return function (_ki3,b,_kI3,_kl0){if ((_ki3 /= _kl0)<(1/.275e1)){return _kI3*(.75625e1*_ki3*_ki3)+b; }else if (_ki3<(2/.275e1)){return _kI3*(.75625e1*(_ki3-=(.15e1/.275e1))*_ki3+.75)+b; }else if (_ki3<(.25e1/.275e1)){return _kI3*(.75625e1*(_ki3-=(.225e1/.275e1))*_ki3+.9375)+b; }return _kI3*(.75625e1*(_ki3-=(.2625e1/.275e1))*_ki3+.984375)+b; } ; break; case "bounceboth":return function (_ki3,b,_kI3,_kl0){if (_ki3<_kl0/2){return (_kl3("bouncein"))(_ki3*2,0,_kI3,_kl0)*.5+b; }return (_kl3("bounceout"))(_ki3*2-_kl0,0,_kI3,_kl0)*.5+_kI3*.5+b; } ; break; case "elasticin":return function (_ki3,b,_kI3,_kl0,a,p){if (_ki3==0){return b; }if ((_ki3 /= _kl0)==1){return b+_kI3; }if (!p){p=_kl0*.3; }if (!a || a<Math.abs(_kI3)){a=_kI3; var s=p/4; }else {var s=p/(2*Math.PI)*Math.asin(_kI3/a); }return -(a*Math.pow(2,10*(_ki3-=1))*Math.sin((_ki3*_kl0-s)*(2*Math.PI)/p))+b; } ; break; case "elasticout":return function (_ki3,b,_kI3,_kl0,a,p){if (_ki3==0){return b; }if ((_ki3 /= _kl0)==1){return b+_kI3; }if (!p){p=_kl0*.3; }if (!a || a<Math.abs(_kI3)){a=_kI3; var s=p/4; }else {var s=p/(2*Math.PI)*Math.asin(_kI3/a); }return a*Math.pow(2,-10*_ki3)*Math.sin((_ki3*_kl0-s)*(2*Math.PI)/p)+_kI3+b; } ; break; case "elasticboth":return function (_ki3,b,_kI3,_kl0,a,p){if (_ki3==0){return b; }if ((_ki3 /= _kl0/2)==2){return b+_kI3; }if (!p){p=_kl0*(.3*.15e1); }if (!a || a<Math.abs(_kI3)){a=_kI3; var s=p/4; }else {var s=p/(2*Math.PI)*Math.asin(_kI3/a); }if (_ki3<1){return -.5*(a*Math.pow(2,10*(_ki3-=1))*Math.sin((_ki3*_kl0-s)*(2*Math.PI)/p))+b; }return a*Math.pow(2,-10*(_ki3-=1))*Math.sin((_ki3*_kl0-s)*(2*Math.PI)/p)*.5+_kI3+b; } ; break; case "backin":return function (_ki3,b,_kI3,_kl0,s){if (typeof s=="undefined"){s=.170158e1; }return _kI3*(_ki3 /= _kl0)*_ki3*((s+1)*_ki3-s)+b; } ; break; case "backout":return function (_ki3,b,_kI3,_kl0){if (typeof s=="undefined"){s=.170158e1; }return _kI3*((_ki3=_ki3/_kl0-1)*_ki3*((s+1)*_ki3+s)+1)+b; } ; break; case "backboth":return function (_ki3,b,_kI3,_kl0,s){if (typeof s=="undefined"){s=.170158e1; }if ((_ki3 /= _kl0/2)<1){return _kI3/2*(_ki3*_ki3*(((s *= (.1525e1))+1)*_ki3-s))+b; }return _kI3/2*((_ki3-=2)*_ki3*(((s *= (.1525e1))+1)*_ki3+s)+2)+b; } ; break; case "none":default:return function (_ki3,b,_kI3,_kl0){return _kI3+b; } ; break; }}function KoolMenuItem(_ky){ this._ky=_ky; }KoolMenuItem.prototype= {_ko4:function (){return eval("__="+_kY(this._ky+"_setting").value); } ,_kO4:function (_kl4){var _ki4=_kY(this._ky+"_setting"); _ki4.value=_ko1(_kl4); } ,_kI4:function (){var _ko5=_kY(this._ky); var _kO5=_ku(_ko5); while (_kO5.nodeName!="DIV" || _kI1("KMU",_kM(_kO5))<0){_kO5=_ku(_kO5); if (_kO5.nodeName=="BODY")return null; }return eval(_kO5.id); } ,enable:function (_kl5){var _ki5=_kE(_kI5(this._ky)); if (_kl5){_kH(_ki5,"kmuDisabled"); }else {_kJ(_ki5,"kmuDisabled"); }} ,select:function (){var _ko6=this._kI4(); if (!_ko6._kO6("OnBeforeItemSelect", { "ItemId": this._ky } ))return; _ko6._kl6(this._ky); _ki6=_ko6._ko4(); _ko6._kO6("OnItemSelect", { "ItemId": this._ky } ); if (_ki6["PostBackOnSelect"]){_ko6._kI6(); }} ,isEnabled:function (){var _ki5=_kE(_kY(this._ky)); return (_kI1("Disabled",_kM(_ki5))<0); } ,_ko7:function (){var _ko5=_kY(this._ky); return (_kI1("Template",_kM(_ko5))>0); } ,_kO7:function (){var _ko5=_kY(this._ky); var _kl7=_kY(this._ky+"_group"); var _ki7=_ku(_kl7); if (_kI1("kmuPrem",_kM(_ki7))>0){if (_kI1("Vertical",_kM(_kl7))>0){var _kI7=0; for (var i=0; i<_kl7.childNodes.length; i++){var _ko8=_kl7.childNodes[i]; if (_ko8.nodeName=="LI"){if (_kI1("Separator",_kM(_ko8))<0){var _kO8=_kE(_ko8); if (_kI7<_kO8.offsetWidth){_kI7=_kO8.offsetWidth; }}}}_kI7+=5; for (var i=0; i<_kl7.childNodes.length; i++){var _ko8=_kl7.childNodes[i]; if (_ko8.nodeName=="LI"){var _kO8=_kE(_ko8); _kv(_kO8,_kI7); }}}var _kl8=_kT(_ki7); var _ki8=_kt(_ki7); if (isNaN(_kl8)){_kl8=_ki7.offsetWidth; _kv(_ki7,_kl8); }if (isNaN(_ki8)){_ki8=_ki7.offsetHeight; _kV(_ki7,_ki8); }if (_ko3()=="ie6"){var _kI8=_ks(_ki7)-1; var _ko9=document.createElement("div"); _ko9.innerHTML="\x3ciframe src=\"javascript:\'\';\" tabindex=\'-1\' style=\'position:absolute;width:"+_kl8+"px;height:"+_ki8+"px;display:none;border:0px;z-index:"+_kI8+";filter:progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)'>Your browser does not support inline iframe.</frame>"; var _kO9=_kE(_ko9); _ko5.insertBefore(_kO9,_ki7); }_kH(_ki7,"kmuPrem"); }} ,_kl9:function (){ this._ki9(); var _ko6=this._kI4(); var _ki6=_ko6._ko4(); var _kI9=this._ko4(); _kI9["TimeoutID"]=setTimeout("(new KoolMenuItem('"+this._ky+"')).expand();",_ki6["ExpandDelay"]); this._kO4(_kI9); } ,expand:function (){if (this.hasChild() && !this.isExpanded()){var _ko6=this._kI4(); var _ki6=_ko6._ko4(); if (_ki6["ClickToOpen"]){var _koa=_ku(_kY(this._ky)); if (_kI1("RootGroup",_kM(_koa))>0){_ko6.collapse(); _ko6._kOa(1); }}if (!_ko6._kO6("OnBeforeItemExpand", { "ItemId": this._ky } ))return; var _ko5=_kY(this._ky); var _ki6=_ko6._ko4(); var _kI9=this._ko4(); var _kla=_ki6["ExpandAnimation"]; var _kia=_kla["Type"]; var _kIa=_kla["Duration"]; var _kob=20; var _kOb=_kIa/_kob; _kI9["TimeoutID"]=null; this._kO4(_kI9); var _ki7=_ku(_kY(this._ky+"_group")); _kN(_ki7,1); _ki7.style.overflow="visible"; this._kO7(); _ki7.style.overflow="hidden"; _kS(_ko5,1); var _klb=_kT(_ki7); var _kib=_kt(_ki7); var _kIb=_ko5.offsetWidth; var _koc=_ko5.offsetHeight; var _kOc=_kI9["OffsetX"]; var _klc=_kI9["OffsetY"]; var _kic=_kI9["ExpandDirection"].toLowerCase(); if (_kic=="auto"){var _kIc=_ku(_ko5); if (_kI1("kmuVertical",_kM(_kIc))<0){_kic="down"; }else {_kic="right"; }}switch (_kic){case "up":_kz(_ki7,_klc-_kib); _kW(_ki7,_kOc); break; case "down":_kz(_ki7,_klc+_koc); _kW(_ki7,_kOc); break; case "left":_kz(_ki7,_klc); _kW(_ki7,_kOc-_klb); break; case "right":_kz(_ki7,_klc); _kW(_ki7,_kOc+_kIb); break; }if (_ko3()=="ie6"){var _kO9=_ki7.previousSibling; _kz(_kO9,_kx(_ki7)); _kW(_kO9,_kw(_ki7)); _kN(_kO9,1); }var _kod=_kE(_ko5); _kJ(_kod,"kmuExpanded"); if (_kO(_kI9["AnimTimeoutID"])){clearTimeout(_kI9["AnimTimeoutID"]); } this._kOd( { "func": "expand","direction":_kic,"type":_kia,"duration":_kIa,"step":_kOb,"current": 0 } ); }} ,_kld:function (){var _ko5=_kY(this._ky); var _kod=_kE(_ko5); _kJ(_kod,"kmuExpanded"); var _kl7=_kY(this._ky+"_group"); var _ki7=_ku(_kl7); _ki7.style.overflow="visible"; _kN(_ki7,1); _kz(_kl7,null); _kW(_kl7,null); if (_ko3()=="ie6"){var _kO9=_ki7.previousSibling; _kN(_kO9,1); } this._kI4()._kO6("OnItemExpand", { "ItemId": this._ky } ); } ,_kid:function (){ this._ki9(); var _ko6=this._kI4(); var _ki6=_ko6._ko4(); var _kI9=this._ko4(); _kI9["TimeoutID"]=setTimeout("(new KoolMenuItem('"+this._ky+"')).collapse();",_ki6["CollapseDelay"]); this._kO4(_kI9); } ,collapse:function (){if (_kZ())return; if (this.hasChild() && this.isExpanded()){var _ko6=this._kI4(); if (!_ko6._kO6("OnBeforeItemCollapse", { "ItemId": this._ky } ))return; var _ko5=_kY(this._ky); var _kod=_kE(_ko5); _kH(_kod,"kmuExpanded"); var _ki6=_ko6._ko4(); var _kI9=this._ko4(); var _kId=_ki6["CollapseAnimation"]; var _kia=_kId["Type"]; var _kIa=_kId["Duration"]; var _kob=20; var _kOb=_kIa/_kob; _kI9["TimeoutID"]=null; this._kO4(_kI9); var _ki7=_ku(_kY(this._ky+"_group")); _ki7.style.overflow="hidden"; _kS(_ko5,0); var _kic=_kI9["ExpandDirection"].toLowerCase(); if (_kic=="auto"){var _kIc=_ku(_ko5); if (_kI1("kmuVertical",_kM(_kIc))<0){_kic="down"; }else {_kic="right"; }}if (_kO(_kI9["AnimTimeoutID"])){clearTimeout(_kI9["AnimTimeoutID"]); } this._kOd( { "func": "collapse","direction":_kic,"type":_kia,"duration":_kIa,"step":_kOb,"current":_kOb } ); }} ,_koe:function (){var _ko5=_kY(this._ky); var _kod=_kE(_ko5); _kH(_kod,"kmuExpanded"); var _kOe=_kY(this._ky+"_group"); var _ki7=_ku(_kOe); _kN(_ki7,0); _kz(_kOe,null); _kW(_kOe,null); if (_ko3()=="ie6"){var _kO9=_ki7.previousSibling; _kN(_kO9,0); } this._kI4()._kO6("OnItemCollapse", { "ItemId": this._ky } ); } ,isExpanded:function (){var _kod=_kE(_kY(this._ky)); return (_kI1("kmuExpanded",_kM(_kod))>=0); } ,hasChild:function (){return _kO(_kY(this._ky+"_group")); } ,getChildItems:function (){var _kO1=new Array(); if (this.hasChild()){var _kl7=_kY(this._ky+"_group"); for (var i=0; i<_kl7.childNodes.length; i++){var _ko8=_kl7.childNodes[i]; if (_ko8.nodeName=="LI" && _kI1("Separator",_kM(_ko8))<0){_kO1.push(new KoolMenuItem(_ko8.id)); }}}return _kO1; } ,_kOd:function (_kle){var _kl4=this._ko4(); var _kia=_kle["type"]; var _kIa=_kle["duration"]; var _kOb=_kle["step"]; var _kie=_kle["current"]; var _kic=_kle["direction"]; var _kob=_kIa/_kOb; var _kl7=_kY(this._ky+"_group"); var _ki7=_ku(_kl7); var _klb=_kT(_ki7); var _kib=_kt(_ki7); var _kIe=_kl3(_kle["type"]); var _kof=0; switch (_kic){case "up":_kof=_kib; break; case "down":_kof=-_kib; break; case "left":_kof=_klb; break; case "right":_kof=-_klb; break; }_kOf=-_kof; switch (_kle["func"]){case "expand":if (_kie>=_kOb || _kle["type"]=="none"){ this._kld(); }else {var _kIf=_kIe(_kie,_kof,_kOf,_kOb); if (_kic=="down" || _kic=="up"){_kz(_kl7,_kIf); }else if (_kic=="left" || _kic=="right"){_kW(_kl7,_kIf); }_kle["current"]=_kie+1; _kl4["AnimTimeoutID"]=setTimeout("kmu_animate('"+this._ky+"',"+_ko1(_kle)+")",_kob); this._kO4(_kl4); }break; case "collapse":if (_kie<=0 || _kle["type"]=="none"){ this._koe(); }else {var _kIf=_kIe(_kie,_kof,_kOf,_kOb); if (_kic=="down" || _kic=="up"){_kz(_kl7,_kIf); }else if (_kic=="left" || _kic=="right"){_kW(_kl7,_kIf); }_kle["current"]=_kie-1; _kl4["AnimTimeoutID"]=setTimeout("kmu_animate('"+this._ky+"',"+_ko1(_kle)+")",_kob); this._kO4(_kl4); }break; }} ,_ki9:function (){var _kI9=this._ko4(); var _kog=_kI9["TimeoutID"]; if (_kO(_kog)){clearTimeout(_kog); }} ,_kOg:function (_kb){var _ko6=this._kI4(); var _ki6=_ko6._ko4(); if (!_ko6._kO6("OnBeforeItemMouseOver", { "ItemId": this._ky } ))return; var _ki6=_ko6._ko4(); if (this.isEnabled() && this.hasChild() && _ko6._klg()){ this._kl9(); }_ko6._kO6("OnItemMouseOver", { "ItemId": this._ky } ); } ,_kig:function (_kb){if (_kZ())return; var _ko6=this._kI4(); var _ki6=_ko6._ko4(); if (!_ko6._kO6("OnBeforeItemMouseOut", { "ItemId": this._ky } ))return; if (this.isEnabled() && this.hasChild()){ this._ki9(); if (_ki6["ClickToOpen"]){var _koa=_ku(_kY(this._ky)); if (_kI1("RootGroup",_kM(_koa))<0){ this._kid(); }}else { this._kid(); }}_ko6._kO6("OnItemMouseOut", { "ItemId": this._ky } ); } ,_kIg:function (_kb){if (_kZ())return; var _ko6=this._kI4(); var _ki6=_ko6._ko4(); if (!_ko6._kO6("OnBeforeItemClick", { "ItemId": this._ky } ))return; if (this.isEnabled()){if (this.hasChild()){ this.expand(); if (_ki6["ClickToOpen"]){_ko6._kOa(1); }}else if (!this._ko7()){ this._ki9(); this.select(); _ko6.collapse(); _kB(_kb); }}_ko6._kO6("OnItemClick", { "ItemId": this._ky } ); }};function KoolMenu(_ky){ this._ky=_ky; this.id=_ky; this._koh=new Array(); this._kOh(); this.targetId=""; }KoolMenu.prototype= {_kOh:function (){var _ko5=_kY(this._ky); var _klh=_kY(this._ky+"_select"); _klh.value=""; var _kl4=this._ko4(); var _kih=_kl4["ContextMenu"]; if (_kih){var _kIh=_kY(this._ky+"_ctmnu"); var _koi=_ku(_kIh); var _kOi=_kE(_kIh); var _kli="width:0px;height:0px;padding:0px;margin:0px;border:0px;"; _ko5.style.cssText=_kli; _kIh.style.cssText=_kli; _koi.style.cssText=_kli; _kOi.style.cssText=_kli; _ko5.style.position="absolute"; var _kii=_kl4["AttachTo"]; _kh(window,"load",eval("__=function(){kmu_window_onload('"+this._ky+"')}"), false); _kIi.push(this._ky); }var _koj=_kR("li","kmuItem",_ko5); for (var i=0; i<_koj.length; i++){if (_kI1("Separator",_kM(_koj[i]))<0 && _koj[i].id!=(this._ky+"_ctmnu")){_kh(_koj[i],"mouseover",_kOj, false); _kh(_koj[i],"mouseout",_klj, false); _kh(_koj[i],"click",_kij, false); }}if (!_kih){var _kIj=_kE(_kY(this._ky)); if (_kI1("kmuVertical",_kM(_kIj))>-1){var _kI7=0; for (var i=0; i<_kIj.childNodes.length; i++){var _ko8=_kIj.childNodes[i]; if (_ko8.nodeName=="LI"){if (_kI1("Separator",_kM(_ko8))<0){var _kO8=_kE(_ko8); if (_kI7<_kO8.offsetWidth){_kI7=_kO8.offsetWidth; }}}}for (var i=0; i<_kIj.childNodes.length; i++){var _ko8=_kIj.childNodes[i]; if (_ko8.nodeName=="LI"){var _kO8=_kE(_ko8); _kv(_kO8,_kI7); }}}if (_kl4["ClickToOpen"]){_kIi.push(this._ky); }}_kh(_ko5,"mouseup",_kok, false); } ,_kOa:function (_kl5){var _kIj=_kE(_kY(this._ky)); if (_kl5){_kJ(_kIj,"kmuActive"); }else {_kH(_kIj,"kmuActive"); }} ,_klg:function (){var _kl4=this._ko4(); if (_kl4["ClickToOpen"]){var _kIj=_kE(_kY(this._ky)); return (_kI1("Active",_kM(_kIj))>0);}else {return true; }} ,_kl6:function (_ky){var _klh=_kY(this._ky+"_select"); _klh.value=_ky; } ,_kI6:function (){var _kOk=_kY(this._ky); while (_kOk.nodeName!="FORM"){if (_kOk.nodeName=="BODY")return; _kOk=_ku(_kOk); }_kOk.submit(); } ,_ko4:function (){return eval("__="+_kY(this._ky+"_setting").value); } ,_kO4:function (_kl4){var _ki4=_kY(this._ky+"_setting"); _ki4.value=_ko1(_kl4); } ,collapse:function (){var _ko5=_kY(this._ky); var _klk=_kR("a","kmuExpanded",_ko5); for (var i=_klk.length-1; i>=0; i--){var _kik=new KoolMenuItem(_ku(_klk[i]).id); _kik.collapse(); } this._kOa(0); } ,getItem:function (_ky){return new KoolMenuItem(_ky); } ,getRootItems:function (){var _kl4=this._ko4(); var _kO1=new Array(); var _kl7=_kE(_kY(this._ky)); if (_kl4["ContextMenu"]){_kl7=_kY(this._ky+"_ctmnu_group"); }for (var i=0; i<_kl7.childNodes.length; i++){var _ko8=_kl7.childNodes[i]; if (_ko8.nodeName=="LI" && _kI1("Separator",_kM(_ko8))<0){_kO1.push(new KoolMenuItem(_ko8.id)); }}return _kO1; } ,registerEvent:function (_ki1,_kIk){ this._koh[_ki1]=_kIk; } ,_kO6:function (_ki1,_kol){return (_kO(this._koh[_ki1]))?this._koh[_ki1](this,_kol): true; } ,_kll:function (_kb,_kil){if (_kZ())return; var _ko5=_kY(this._ky); var _kIl=_kO2(_kb); if (_ko3()=="firefox"){_kW(_ko5,_kIl._ki2+1); _kz(_ko5,_kIl._kI2+1); }else {_kW(_ko5,_kIl._ki2); _kz(_ko5,_kIl._kI2); }var _kom=new KoolMenuItem(this._ky+"_ctmnu"); _kom.expand(); this.targetId=_kil.id; } ,_kOm:function (_kl5){var _kii=this._ko4()["AttachTo"]; for (var i=0; i<_kii.length; i++){var _kil=_kY(_kii[i]); if (_kO(_kil)){if (_kl5){_kh(_kil,"contextmenu",eval("__=function(e){return kmu_target_contextmenu(e,this,'"+this._ky+"');}"), false); }else {_kc(_kil,"contextmenu",eval("__=function(e){return kmu_target_contextmenu(e,this,'"+this._ky+"');}"), false); }}}} ,_kIm:function (_kb){ this._kOm(1); } ,attachTo:function (_kon){ this._kOm(0); var _kl4=this._ko4(); _kl4["AttachTo"]=_kon.split(","); this._kO4(_kl4); this._kOm(1); } ,reAttach:function (){ this._kOm(0); this._kOm(1); }};function _klj(_kb){ (new KoolMenuItem(this.id))._kig(_kb); }function _kOj(_kb){ (new KoolMenuItem(this.id))._kOg(_kb); }function _kij(_kb){ (new KoolMenuItem(this.id))._kIg(_kb); }function _kok(_kb){_kB(_kb); return _ko0(_kb); }function kmu_window_onload(_ky){var _ko6=eval("__="+_ky); _ko6._kIm(); }function kmu_animate(_ky,_kle){ (new KoolMenuItem(_ky))._kOd(_kle); }function kmu_target_contextmenu(_kb,_kil,_ky){var _ko6=eval("__="+_ky); _ko6._kll(_kb,_kil); return _ko0(_kb); }var _kIi=new Array(); function _kOn(_kb){for (var i=0; i<_kIi.length; i++){var _ko6=eval("__="+_kIi[i]); if (_kO(_ko6)){_ko6.collapse(); }}}_kh(document,"mouseup",_kOn, false); if (typeof(__KMUInits)!="undefined" && _kO(__KMUInits)){for (var i=0; i<__KMUInits.length; i++){__KMUInits[i](); }} <?php _kl6(); _kO6(); } if (!class_exists("\113oolM\145\156u",FALSE)) { class _kl9 { var $Height; var $Width; var $ExpandDirection; var $Flow; var $_kO9; var $_kla; function _kOa($_klb) { if ($this->Height === NULL) $this->Height =$_klb->GroupSettings_Height; if ($this->Width === NULL) $this->Width =$_klb->GroupSettings_Width; if ($this->ExpandDirection === NULL) $this->ExpandDirection =$_klb->GroupSettings_ExpandDirection; if ($this->Flow === NULL) $this->Flow =$_klb->GroupSettings_Flow; if ($this->_kO9 === NULL) $this->_kO9 =$_klb->GroupSettings_OffsetX; if ($this->_kla === NULL) $this->_kla =$_klb->GroupSettings_OffsetY; } } class koolmenuitem { var $GroupSettings; var $_kOb; var $_klc; var $id; var $_kOc; var $Text; var $Link; var $ImageUrl; var $ToolTip; var $Target; var $Enabled=TRUE; var $Width; var $Template; var $_kld; function __construct() { $this->GroupSettings =new _kl9(); $this->_kOc =array(); } function _kOa() { $this->GroupSettings->_kOa($this->_klc); if ($this->Target === NULL) $this->Target =$this->_klc->Target; foreach ($this->_kOc as $_kOd) { $_kOd->_kOa(); } } function addchild($_kle) { $_kle->_kOb =$this; $_kle->_kld =$this->_kld +1; $_kle->_klc =$this->_klc; array_push($this->_kOc ,$_kle); } function addseparator() { array_push($this->_kOc ,new koolmenuseparator()); } function _kOe() { $_klf="<li id\075\047\173\151\144}' cl\141\163s='\153\155uItem\040\173te\155\160late\175\040\173f\151\162stlas\164\175' >\173\143\157nten\164\175\173sl\151\144e}\173s\145\164ting}\074\057li>"; $_kOf="\074a cl\141\163s='kmu\114\151nk \173\145\156able\144\175' \173\150\162ef}\040\164itle=\047\173toolt\151\160}' \173\164\141rget\175\040\173st\171\154e} >\173\151\155g} \173\164\145xt}\074\057a>"; $_klg="\074img cla\163\163='kmu\111\155age' \163\162c='\173\163\162c}' \141\154t='\047\040/>"; $_kOg="<spa\156\040class=\047\153muText\040\173expan\144\175'>\173t\145\170t}</\163\160an>"; $_klh="\074\144iv class\075\047kmuSl\151\144e kmu\120\162\145m' \163\164yle='\173\163tyle}\047\076\173ul\175\074\057div\076"; $_kOh="\074ul id=\047\173\151d}_g\162\157\165p' c\154\141ss='k\155\165\107rou\160\040\173flo\167\175 \173lev\145\154}'>\173l\151\163}</ul\076"; $_kOi="<\144\151\166 clas\163\075\047kmuT\145\170t'>\173\164\145\155pla\164\145}</d\151\166\076"; $_klj="\074\151nput i\144\075'\173id\175\137\163etti\156\147\047 ty\160\145='hid\144\145n' val\165\145='\173v\141\154\165e}' \141\165\164ocom\160\154ete='\157\146\146' />"; $_kOj=""; if (!$this->Template) { $_klk=""; if ($this->ImageUrl) { $_klk=_kO1("\173src}",$this->ImageUrl ,$_klg); } $_kO3=_kO1("\173\164ext}",$this->Text ,$_kOg); $_kOk=""; if (sizeof($this->_kOc)>0) { switch (strtolower($this->GroupSettings->ExpandDirection)) { case "up": $_kOk="\153\155uExpa\156\144Up"; break; case "\144own": $_kOk="kmuExp\141\156\144Down"; break; case "left": $_kOk="kmuExpa\156\144\114eft"; break; case "\162ight": $_kOk="km\165\105\170pandR\151\147\150t"; break; case "auto": default : if (strtolower($this->_kOb->GroupSettings->Flow) == "hori\172\157\156tal") { $_kOk="\153\155uExpand\104\157\167n"; } else { $_kOk="kmuExpa\156\144\122ight"; } break; } } $_kO3=_kO1("\173ex\160\141\156d}",$_kOk,$_kO3); $_kll=_kO1("\173img}",$_klk,$_kOf); $_kll=_kO1("\173\164\145\170t}",$_kO3,$_kll); $_kll=_kO1("\173\150\162ef}",($this->Link !== NULL) ? "\150\162ef='".$this->Link."'": "",$_kll); $_kll=_kO1("\173t\157\157\154tip}",$this->ToolTip ,$_kll); $_kll=_kO1("\173target\175",($this->Target !== NULL) ? "\164\141\162get='".$this->Target."'": "",$_kll); $_kll=_kO1("\173enabl\145\144}",($this->Enabled) ? "": "\153\155uDisabl\145\144",$_kll); if ($this->Width !== NULL) { $_kll=_kO1("\173\163tyle}","\163\164yle='wi\144\164\150:".$this->Width.";'",$_kll); } else { $_kll=_kO1("\173\163\164\171le}","",$_kll); } $_kOj=$_kll; } else { $_klm=_kO1("\173templ\141\164\145}",$this->Template ,$_kOi); $_kOj=$_klm; } $_kOm=""; if (sizeof($this->_kOc)>0) { $_kln=""; for ($_kO8=0; $_kO8<sizeof($this->_kOc); $_kO8 ++) { $_kOd=$this->_kOc[$_kO8]; $_kOn=$_kOd->_kOe(); if ($_kO8 == sizeof($this->_kOc)-1) { $_kOn=_kO1("\173first\154\141\163t}","\153muLast",$_kOn); } else if ($_kO8 == 0) { $_kOn=_kO1("\173\146irstlast\175","k\155\165\106irst",$_kOn); } else { $_kOn=_kO1("\173\146irstla\163\164\175","",$_kOn); } $_kln.=$_kOn; } $_klo=_kO1("\173id}",$this->id ,$_kOh); $_klo=_kO1("\173\146\154ow}",(strtolower($this->GroupSettings->Flow) == "vertica\154") ? "kmuV\145\162tica\154": "\153muHor\151\172\157ntal",$_klo); $_klo=_kO1("\173leve\154\175","\153muLeve\154".$this->_kld ,$_klo); $_klo=_kO1("\173lis}",$_kln,$_klo); $_kOm=_kO1("\173ul}",$_klo,$_klh); if ($this->GroupSettings->Width !== NULL) { $_kOm=_kO1("\173\163\164yle}","width:".$this->GroupSettings->Width.";\173sty\154\145\175",$_kOm); } if ($this->GroupSettings->Height !== NULL) { $_kOm=_kO1("\173\163\164yle}","\150eight:".$this->GroupSettings->Height."\073\173st\171\154\145}",$_kOm); } $_kOm=_kO1("\173st\171\154e}","disp\154\141\171:none\073\157verfl\157\167\072hid\144\145n;z-i\156\144ex:".$this->_kld *3,$_kOm); } $_kOo=array("\117\146\146setX" => $this->GroupSettings->_kO9 ,"O\146\146\163etY" => $this->GroupSettings->_kla ,"\105\170pandDi\162\145\143tion" => $this->GroupSettings->ExpandDirection); $_klp=_kO1("\173value}",json_encode($_kOo),$_klj); $_klp=_kO1("\173id}",$this->id ,$_klp); $_kOn=_kO1("\173\151\144}",$this->id ,$_klf); $_kOn=_kO1("\173templ\141\164\145}",(!$this->Template) ? "": "kmuTempl\141\164\145",$_kOn); $_kOn=_kO1("\173conte\156\164}",$_kOj,$_kOn); $_kOn=_kO1("\173\163etting\175",$_klp,$_kOn); $_kOn=_kO1("\173\163lide}",$_kOm,$_kOn); return $_kOn; } } class koolmenuseparator { function _kOe() { $_klf="\074\154i clas\163\075'kmuI\164\145m kmu\123\145parat\157\162'><\163\160an c\154\141ss='k\155\165Sub'>\074\163pan><\057\163pan>\074\057spa\156\076</li>"; return $_klf; } function _kOa() { } } class _kOp { var $GroupSettings; var $_kOc; var $_klc; var $_kld=0; function __construct($_klb) { $this->_kOc =array(); $this->GroupSettings =new _kl9(); $this->_klc =$_klb; } function _kOa() { $this->GroupSettings->_kOa($this->_klc); $this->GroupSettings->Flow =$this->_klc->Flow; $this->GroupSettings->ExpandDirection =$this->_klc->ExpandDirection; foreach ($this->_kOc as $_kOd) { $_kOd->_kOa(); } } function addchild($_kle) { $_kle->_kOb =$this; $_kle->_kld =$this->_kld +1; $_kle->_klc =$this->_klc; array_push($this->_kOc ,$_kle); } function _kOe() { $_kOh="<ul cla\163\163\075'km\165\122\157otG\162\157\165p \173\146\154ow}'\076\173lis}\074\057ul>"; $_kln=""; for ($_kO8=0; $_kO8<sizeof($this->_kOc); $_kO8 ++) { $_kOd=$this->_kOc[$_kO8]; $_kOn=$_kOd->_kOe(); if ($_kO8 == sizeof($this->_kOc)-1) { $_kOn=_kO1("\173firs\164\154ast}","\153\155uLast",$_kOn); } else if ($_kO8 == 0) { $_kOn=_kO1("\173\146\151rstla\163\164\175","kmuFir\163\164",$_kOn); } else { $_kOn=_kO1("\173\146\151rstlas\164\175","",$_kOn); } $_kln.=$_kOn; } $_klo=_kO1("\173\146low}",(strtolower($this->_klc->Flow) == "\166\145rtical") ? "\153\155\165Verti\143\141\154": "\153\155uHorizon\164\141\154",$_kOh); $_klo=_kO1("\173\154is}",$_kln,$_klo); return $_klo; } } class _klq extends _kOp { var $_kOq; function __construct($_klb) { parent:: __construct($_klb); $_klr=new koolmenuitem(); $_klr->id =$_klb->id."_ctmn\165"; parent::addchild($_klr); $this->_kOq =$_klr; } function _kOa() { $this->_kOq->GroupSettings->Flow =$this->_klc->Flow; $this->_kOq->GroupSettings->ExpandDirection =$this->_klc->ExpandDirection; parent::_kOa(); } function addchild($_kle) { $this->_kOq->addchild($_kle); } function addseparator() { $this->_kOq->addseparator(); } } class _kls { var $Duration=0310; var $Type="\105aseBo\164\150"; } class koolmenu { var $_kl0="\061.5.0.0"; var $id; var $_kOs; var $_klt; var $_kOt; var $styleFolder; var $scriptFolder; var $Target; var $ExpandAnimation; var $CollapseAnimation; var $Flow="Horizont\141\154"; var $ExpandDirection="\101\165\164o"; var $ClickToOpen=FALSE; var $ExpandDelay=0322; var $CollapseDelay=0322; var $GroupSettings_Flow="\126ertica\154"; var $GroupSettings_OffsetX=0; var $GroupSettings_OffsetY=0; var $GroupSettings_ExpandDirection="Aut\157"; var $GroupSettings_Width; var $GroupSettings_Height; var $Width; var $Height; var $PostBackOnSelect=FALSE; var $SelectedId; var $_klu=FALSE; function __construct($_kOu) { $this->id =$_kOu; $this->_kOs =new _kOp($this); $this->ExpandAnimation =new _kls(); $this->CollapseAnimation =new _kls(); if ( isset ($_POST[$_kOu."_select"])) { $this->SelectedId =$_POST[$_kOu."_selec\164"]; } else if ( isset ($_GET[$_kOu."\137\163elect"])) { $this->SelectedId =$_GET[$_kOu."_sel\145\143\164"]; } } function add($_klv,$_kOu,$_kO3="",$_kOv=NULL,$_klw=NULL) { $_kOw=new koolmenuitem(); $_kOw->id =$_kOu; $_kOw->Text =$_kO3; $_kOw->Link =$_kOv; $_kOw->ImageUrl =$_klw; $_klx=NULL; if ( isset ($this->_kOt[$_klv])) { $_klx=$this->_kOt[$_klv]; } else { $_klx=$this->_kOs; } $_klx->addchild($_kOw); $this->_kOt[$_kOu]=$_kOw; return $_kOw; } function getitem($_kOu) { return $this->_kOt[$_kOu]; } function addseparator($_klv) { $_klx=NULL; if ( isset ($this->_kOt[$_klv])) { $_klx=$this->_kOt[$_klv]; } else { $_klx=$this->_kOs; } $_klx->addseparator(); } function _kOa() { $this->_kOs->_kOa(); } function render() { $_kOx="\n\074!--Ko\157\154\115enu v\145\162sion ".$this->_kl0."\040- www\056\153oolphp.\156\145t -->\n"; $_kOx.=$this->registercss(); $_kOx.=$this->rendermenu(); $_kly= isset ($_POST["\137_koola\152\141\170"]) || isset ($_GET["__k\157\157\154ajax"]); $_kOx.=($_kly) ? "": $this->registerscript(); $_kOx.="\074\163cript \164\171\160e='te\170\164/java\163\143\162ipt'\076"; $_kOx.=$this->startupscript(); $_kOx.="\074/scr\151\160t>"; return $_kOx; } function rendermenu() { $this->_kOa(); $_klj="<\151\156pu\164\040id=\047\173id\175_set\164\151ng\047\040t\171\160e\075'hi\144\144en\047\040va\154\165e='\173\166alue\175\047 a\165toco\155\160le\164\145='o\146\146' \057>"; $_kOy="<\151nput \151\144='\173\151d}\137\163ele\143\164' \156\141me\075'\173\151\144}\137\163ele\143\164' \164\171pe=\047hidd\145\156' \141utoc\157\155pl\145\164e=\047\157ff\047\040/\076"; $_klz=array("\105xpan\144\104elay" => $this->ExpandDelay ,"\103\157llapseD\145\154ay" => $this->CollapseDelay ,"Clic\153\124oOpe\156" => $this->ClickToOpen ,"Exp\141\156dAnim\141\164ion" => $this->ExpandAnimation ,"C\157\154la\160\163eA\156imat\151on" => $this->CollapseAnimation ,"\120ost\102\141ck\117\156Sel\145ct" => $this->PostBackOnSelect ,"C\157\156te\170\164Me\156\165" => $this->_klu); if ($this->_klu) { $_kOz="\173\060}\173\061\175<div \151\144='\173i\144\175' cl\141\163s='\173\163tyle\175\113MU \173\163\164yle}\113\115U_Con\164\145\170tM\145\156u' s\164\171le='w\151\144\164h:0\160\170;heig\150\164:0px;\146\157nt-si\172\145:0pt;\047\076\173r\157\157t} \173\163\145tti\156\147} \173\163\145lect\175\074/div>\173\062}"; $_klz["Attach\124\157"]=explode("\054",$this->AttachTo); } $_kl10=json_encode($_klz); $_klp=_kO1("\173id}",$this->id ,$_klj); $_klp=_kO1("\173\166alue\175",$_kl10,$_klp); $_kO10=_kO1("\173\151d}",$this->id ,$_kOy); $_kl8=_kO1("\173id}",$this->id ,_kl7()); $_kl8=_kO1("\173st\171\154e}",$this->_klt ,$_kl8); $_kl8=_kO1("\173\162\157\157t}",$this->_kOs->_kOe(),$_kl8); $_kl8=_kO1("\173\163etti\156\147}",$_klp,$_kl8); if (_kO7($_kl8)) { $_kl8=_kO1("\173\163\145lect}",$_kO10,$_kl8); } $_kl8=_kO1("\173\166ersion\175",$this->_kl0 ,$_kl8); return $_kl8; } function registerscript() { $_kl11="<\163\143\162ipt t\171\160\145='t\145\170\164/jav\141\163cript\047\076if\050\164ypeof \137\154ibKMU=\075\047undefi\156\145d')\173\144\157cumen\164\056\167rite\050\165nesca\160\145\050\042%\063\103script\040\164ype='\164\145\170t/ja\166\141\163crip\164\047 src\075\047\173sr\143\175'%3E \045\063C/scr\151\160t%3E\042\051\051;_li\142\113MU=1;\175\074\057scr\151\160\164>"; $_kOx=_kO1("\173src}",$this->_kO11()."\077".md5("js"),$_kl11); return $_kOx; } function _kl12() { $this->styleFolder =_kO1("\134","/",$this->styleFolder); $_kO12=trim($this->styleFolder ,"/"); $_kl13=strrpos($_kO12,"\057"); $this->_klt =substr($_kO12,($_kl13 ? $_kl13: -1)+1); } function registercss() { $this->_kl12(); $_kl11="\074\163cript\040\164ype=\047\164ext/\152\141vascr\151\160t'>i\146\040(do\143\165ment.\147\145tElem\145\156tById\050\047__\173\163\164yle}\113\115U')==\156\165ll)\173\166\141r _he\141\144 = do\143\165ment.\147\145tElem\145\156tsByT\141\147Name(\047\150ead'\051\1330];\166\141r _li\156\153 = do\143\165ment.\143\162eate\105\154ement\050\047link\047\051; _l\151\156k.id\040\075 '__\173\163tyle}\113\115U';_\154\151nk.re\154\075'sty\154\145shee\164\047; _l\151\156k.hr\145\146='\173\163\164ylepa\164\150}/\173\163\164yl\145\175/\173s\164\171le}.\143\163s';_\150\145ad.a\160\160endC\150\151ld(_\154\151nk);\175\074/scr\151\160t>"; $_kOx=_kO1("\173\163\164yle}",$this->_klt ,$_kl11); $_kOx=_kO1("\173\163tyle\160\141th}",$this->_kO13(),$_kOx); return $_kOx; } function startupscript() { $_kl11="\166ar \173\151\144}; fun\143\164ion \173\151d}_in\151\164()\173\040\173id\175\040= new\040\113oolM\145\156\165('\173\151\144}')\073\175"; $_kl11.="if (ty\160\145\157f(K\157\157\154Men\165\051=='fu\156\143tion\047\051\173\173\151\144}_i\156\151t();}"; $_kl11.="\145lse\173i\146\050typeo\146\050__KMU\111\156its)=\075\047unde\146\151ned\047\051\173__\113\115UInit\163\075new A\162\162ay();\175\040__KM\125\111nits.\160\165sh(\173\151\144}_ini\164\051;\173r\145\147ister\137\163cript\175\175"; $_kl14="if\050\164ypeof(_\154\151bKMU)\075\075'und\145\146ined'\051\173var\040\137hea\144\040= doc\165\155ent.g\145\164Eleme\156\164sByTa\147\116ame('\150\145ad')[\060\135;var\040\137scrip\164\040= doc\165\155ent.c\162\145ateEl\145\155ent('\163\143ript\047\051; _s\143\162ipt.\164\171pe='t\145\170t/ja\166\141\163\143ri\160\164';\040_scr\151\160t.src\075\047\173s\162\143\175'; \137\150ead.\141\160pendC\150\151ld(_\163\143\162ipt\051\073_li\142\113MU=1;\175"; $_kO14=_kO1("\173\163\162c}",$this->_kO11()."\077".md5("\152s"),$_kl14); $_kOx=_kO1("\173\151d}",$this->id ,$_kl11); $_kOx=_kO1("\173regist\145\162_scrip\164\175",$_kO14,$_kOx); return $_kOx; } function _kO11() { if ($this->scriptFolder == "") { $_kO2=_kO0(); $_kl15=substr(_kO1("\134","/",__FILE__),strlen($_kO2)); return $_kl15; } else { $_kl15=_kO1("\134","\057",__FILE__); $_kl15=$this->scriptFolder.substr($_kl15,strrpos($_kl15,"\057")); return $_kl15; } } function _kO13() { $_kO15=$this->_kO11(); $_kl16=_kO1(strrchr($_kO15,"/"),"",$_kO15)."/style\163"; return $_kl16; } } class koolcontextmenu extends koolmenu { var $Flow="\126\145rtical"; var $_klu=TRUE; var $AttachTo; function __construct($_kOu) { parent:: __construct($_kOu); $this->_kOs =new _klq($this); } } } ?> 