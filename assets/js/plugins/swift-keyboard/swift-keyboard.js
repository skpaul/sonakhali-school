try {
	if ( typeof jQuery == 'undefined')
		throw 'err#gvsgy56283';
	else {
		var KeyMap = {
			Unijoy : new Array(),
			Phonetic : new Array()
		}
		KeyMap.Unijoy['j'] = '\u0995';
		KeyMap.Unijoy['j'] = '\u0995';
		KeyMap.Unijoy['d'] = '\u09BF';
		KeyMap.Unijoy['gd'] = '\u0987';
		KeyMap.Unijoy['D'] = '\u09C0';
		KeyMap.Unijoy['gD'] = '\u0988';
		KeyMap.Unijoy['c'] = '\u09C7';
		KeyMap.Unijoy['gc'] = '\u098F';
		KeyMap.Unijoy['gs'] = '\u0989';
		KeyMap.Unijoy['s'] = '\u09C1';
		KeyMap.Unijoy['S'] = '\u09C2';
		KeyMap.Unijoy['gS'] = '\u098A';
		KeyMap.Unijoy['v'] = '\u09B0';
		KeyMap.Unijoy['a'] = '\u098B';
		KeyMap.Unijoy['f'] = '\u09BE';
		KeyMap.Unijoy['gf'] = '\u0986';
		KeyMap.Unijoy['F'] = '\u0985';
		KeyMap.Unijoy['n'] = '\u09B8';
		KeyMap.Unijoy['t'] = '\u099f';
		KeyMap.Unijoy['J'] = '\u0996';
		KeyMap.Unijoy['b'] = '\u09A8';
		KeyMap.Unijoy['B'] = '\u09A3';
		KeyMap.Unijoy['k'] = '\u09A4';
		KeyMap.Unijoy['K'] = '\u09A5';
		KeyMap.Unijoy['e'] = '\u09A1';
		KeyMap.Unijoy['E'] = '\u09A2';
		KeyMap.Unijoy['h'] = '\u09AC';
		KeyMap.Unijoy['H'] = '\u09AD';
		KeyMap.Unijoy['p'] = '\u09DC';
		KeyMap.Unijoy['P'] = '\u09DD';
		KeyMap.Unijoy['o'] = '\u0997';
		KeyMap.Unijoy['O'] = '\u0998';
		KeyMap.Unijoy['i'] = '\u09B9';
		KeyMap.Unijoy['I'] = '\u099E';
		KeyMap.Unijoy['u'] = '\u099C';
		KeyMap.Unijoy['U'] = '\u099D';
		KeyMap.Unijoy['y'] = '\u099A';
		KeyMap.Unijoy['Y'] = '\u099B';
		KeyMap.Unijoy['T'] = '\u09A0';
		KeyMap.Unijoy['r'] = '\u09AA';
		KeyMap.Unijoy['R'] = '\u09AB';
		KeyMap.Unijoy['l'] = '\u09A6';
		KeyMap.Unijoy['L'] = '\u09A7';
		KeyMap.Unijoy['w'] = '\u09AF';
		KeyMap.Unijoy['W'] = '\u09DF';
		KeyMap.Unijoy['q'] = '\u0999';
		KeyMap.Unijoy['Q'] = '\u0982';
		KeyMap.Unijoy['V'] = '\u09B2';
		KeyMap.Unijoy['m'] = '\u09AE';
		KeyMap.Unijoy['M'] = '\u09B6';
		KeyMap.Unijoy['N'] = '\u09B7';
		KeyMap.Unijoy['gx'] = '\u0993';
		KeyMap.Unijoy['X'] = '\u09CC';
		KeyMap.Unijoy['gX'] = '\u0994';
		KeyMap.Unijoy['gC'] = '\u0990';
		KeyMap.Unijoy['\\'] = '\u09CE';
		KeyMap.Unijoy['|'] = '\u0983';
		KeyMap.Unijoy["G"] = "\u0964";
		KeyMap.Unijoy['g'] = ' ';
		KeyMap.Unijoy['&'] = '\u0981';
		KeyMap.Unijoy['Z'] = '\u09CD' + '\u09AF';
		KeyMap.Unijoy['gh'] = '\u09CD' + '\u09AC';
		KeyMap.Unijoy['ga'] = '\u098B';
		KeyMap.Unijoy['a'] = '\u09C3';
		KeyMap.Unijoy['rZ'] = KeyMap.Unijoy['r'] + '\u200c' + '\u09CD' + '\u09AF';
		KeyMap.Unijoy['z'] = '\u09CD' + KeyMap.Unijoy['v'];
		KeyMap.Unijoy['x'] = '\u09CB';
		KeyMap.Unijoy['C'] = '\u09C8';
		KeyMap.Unijoy['0'] = '\u09E6';
		KeyMap.Unijoy['1'] = '\u09E7';
		KeyMap.Unijoy['2'] = '\u09E8';
		KeyMap.Unijoy['3'] = '\u09E9';
		KeyMap.Unijoy['4'] = '\u09EA';
		KeyMap.Unijoy['5'] = '\u09EB';
		KeyMap.Unijoy['6'] = '\u09EC';
		KeyMap.Unijoy['7'] = '\u09ED';
		KeyMap.Unijoy['8'] = '\u09EE';
		KeyMap.Unijoy['9'] = '\u09EF';

		for (key in KeyMap.Unijoy) {
		    /* Note 
                Before Converting- KeyMap.Unijoy['9'] = '\u09EF';
                After Converting - KeyMap.Unijoy['\u09EF'] = '9';
            */
		    KeyMap.Unijoy[KeyMap.Unijoy[key]] = key;
		}


        //--> adding bangla charanter as per keystroke for phonectic
		KeyMap.Phonetic['0'] = '\u09E6';
		KeyMap.Phonetic['1'] = '\u09E7';
		KeyMap.Phonetic['2'] = '\u09E8';
		KeyMap.Phonetic['3'] = '\u09E9';
		KeyMap.Phonetic['4'] = '\u09EA';
		KeyMap.Phonetic['5'] = '\u09EB';
		KeyMap.Phonetic['6'] = '\u09EC';
		KeyMap.Phonetic['7'] = '\u09ED';
		KeyMap.Phonetic['8'] = '\u09EE';
		KeyMap.Phonetic['9'] = '\u09EF';
		KeyMap.Phonetic['k'] = '\u0995';
		KeyMap.Phonetic['i'] = '\u09BF';
		KeyMap.Phonetic['I'] = '\u0987';
		KeyMap.Phonetic['ii'] = '\u09C0';
		KeyMap.Phonetic['II'] = '\u0988';
		KeyMap.Phonetic['e'] = '\u09C7';
		KeyMap.Phonetic['E'] = '\u098F';
		KeyMap.Phonetic['U'] = '\u0989';
		KeyMap.Phonetic['u'] = '\u09C1';
		KeyMap.Phonetic['uu'] = '\u09C2';
		KeyMap.Phonetic['UU'] = '\u098A';
		KeyMap.Phonetic['r'] = '\u09B0';
		KeyMap.Phonetic['WR'] = '\u098B';
		KeyMap.Phonetic['a'] = '\u09BE';
		KeyMap.Phonetic['A'] = '\u0986';
		KeyMap.Phonetic['ao'] = '\u0985';
		KeyMap.Phonetic['o'] = '\u0985';
		KeyMap.Phonetic['s'] = '\u09B8';
		KeyMap.Phonetic['T'] = '\u099f';
		KeyMap.Phonetic['K'] = '\u0996';
		KeyMap.Phonetic['kh'] = '\u0996';
		KeyMap.Phonetic['n'] = '\u09A8';
		KeyMap.Phonetic['N'] = '\u09A3';
		KeyMap.Phonetic['t'] = '\u09A4';
		KeyMap.Phonetic['th'] = '\u09A5';
		KeyMap.Phonetic['D'] = '\u09A1';
		KeyMap.Phonetic['Dh'] = '\u09A2';
		KeyMap.Phonetic['b'] = '\u09AC';
		KeyMap.Phonetic['bh'] = '\u09AD';
		KeyMap.Phonetic['v'] = '\u09AD';
		KeyMap.Phonetic['R'] = '\u09DC';
		KeyMap.Phonetic['Rh'] = '\u09DD';
		KeyMap.Phonetic['g'] = '\u0997';
		KeyMap.Phonetic['G'] = '\u0998';
		KeyMap.Phonetic['gh'] = '\u0998';
		KeyMap.Phonetic['h'] = '\u09B9';
		KeyMap.Phonetic['NG'] = '\u099E';
		KeyMap.Phonetic['j'] = '\u099C';
		KeyMap.Phonetic['J'] = '\u099D';
		KeyMap.Phonetic['jh'] = '\u099D';
		KeyMap.Phonetic['c'] = '\u099A';
		KeyMap.Phonetic['ch'] = '\u099A';
		KeyMap.Phonetic['C'] = '\u099B';
		KeyMap.Phonetic['Th'] = '\u09A0';
		KeyMap.Phonetic['p'] = '\u09AA';
		KeyMap.Phonetic['f'] = '\u09AB';
		KeyMap.Phonetic['ph'] = '\u09AB';
		KeyMap.Phonetic['d'] = '\u09A6';
		KeyMap.Phonetic['dh'] = '\u09A7';
		KeyMap.Phonetic['z'] = '\u09AF';
		KeyMap.Phonetic['y'] = '\u09DF';
		KeyMap.Phonetic['Ng'] = '\u0999';
		KeyMap.Phonetic['ng'] = '\u0982';
		KeyMap.Phonetic['l'] = '\u09B2';
		KeyMap.Phonetic['m'] = '\u09AE';
		KeyMap.Phonetic['sh'] = '\u09B6';
		KeyMap.Phonetic['S'] = '\u09B7';
		KeyMap.Phonetic['O'] = '\u0993';
		KeyMap.Phonetic['ou'] = '\u099C';
		KeyMap.Phonetic['OU'] = '\u0994';
		KeyMap.Phonetic['Ou'] = '\u0994';
		KeyMap.Phonetic['Oi'] = '\u0990';
		KeyMap.Phonetic['OI'] = '\u0990';
		KeyMap.Phonetic['tt'] = '\u09CE';
		KeyMap.Phonetic['H'] = '\u0983';
		KeyMap.Phonetic["."] = '\u0964';
		KeyMap.Phonetic['HH'] = '\u09CD' + '\u200c';
		KeyMap.Phonetic['NN'] = '\u0981';
		KeyMap.Phonetic['Y'] = '\u09CD' + '\u09AF';
		KeyMap.Phonetic['w'] = '\u09CD' + '\u09AC';
		KeyMap.Phonetic['W'] = '\u09C3';
		KeyMap.Phonetic['wr'] = '\u09C3';
		KeyMap.Phonetic['rri'] = '\u09C3';
		KeyMap.Phonetic['x'] = '\u0995' + '\u09CD' + '\u09B8';
		KeyMap.Phonetic['kk'] = '\u0995' + '\u09cd' + '\u0995';
		KeyMap.Phonetic['kT'] = '\u0995' + '\u09cd' + '\u099f';
		KeyMap.Phonetic['kt'] = '\u0995' + '\u09cd' + '\u09a4';
		KeyMap.Phonetic['ktr'] = '\u0995' + '\u09cd' + '\u09a4' + '\u09cd' + '\u09b0';
		KeyMap.Phonetic['kw'] = '\u0995' + '\u09cd' + '\u09AC';
		KeyMap.Phonetic['km'] = '\u0995' + '\u09cd' + '\u09AE';
		KeyMap.Phonetic['ky'] = '\u0995' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['kZ'] = '\u0995' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['kl'] = '\u0995' + '\u09cd' + '\u09B2';
		KeyMap.Phonetic['gn'] = '\u0997' + '\u09cd' + '\u09A8';
		KeyMap.Phonetic['gw'] = '\u0997' + '\u09cd' + '\u09AC';
		KeyMap.Phonetic['gm'] = '\u0997' + '\u09cd' + '\u09AE';
		KeyMap.Phonetic['gl'] = '\u0997' + '\u09cd' + '\u09B2';
		KeyMap.Phonetic['gN'] = '\u0997' + '\u09cd' + '\u09A3';
		KeyMap.Phonetic['cc'] = '\u099A' + '\u09cd' + '\u099A';
		KeyMap.Phonetic['cy'] = '\u099A' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['cZ'] = '\u099A' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['jj'] = '\u099C' + '\u09cd' + '\u099C';
		KeyMap.Phonetic['jw'] = '\u099C' + '\u09cd' + '\u09AC';
		KeyMap.Phonetic['jy'] = '\u099C' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['jZ'] = '\u099C' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['Tw'] = '\u099F' + '\u09cd' + '\u09AC';
		KeyMap.Phonetic['Tm'] = '\u099F' + '\u09cd' + '\u09AE';
		KeyMap.Phonetic['Ty'] = '\u099F' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['TZ'] = '\u099F' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['DD'] = '\u09A1' + '\u09cd' + '\u09A1';
		KeyMap.Phonetic['Dy'] = '\u09A1' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['DZ'] = '\u09A1' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['NT'] = '\u09A3' + '\u09cd' + '\u099F';
		KeyMap.Phonetic['ND'] = '\u09A3' + '\u09cd' + '\u09A1';
		KeyMap.Phonetic['NDy'] = '\u09A3' + '\u09cd' + '\u09A1' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['NDZ'] = '\u09A3' + '\u09cd' + '\u09A1' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['TT'] = '\u099F' + '\u09cd' + '\u099F';
		KeyMap.Phonetic['tn'] = '\u09A4' + '\u09cd' + '\u09A8';
		KeyMap.Phonetic['tw'] = '\u09A4' + '\u09cd' + '\u09AC';
		KeyMap.Phonetic['tm'] = '\u09A4' + '\u09cd' + '\u09AE';
		KeyMap.Phonetic['tmy'] = '\u09A4' + '\u09cd' + '\u09AE' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['tmZ'] = '\u09A4' + '\u09cd' + '\u09AE' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['ty'] = '\u09A4' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['tZ'] = '\u09A4' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['dg'] = '\u09A6' + '\u09cd' + '\u0997';
		KeyMap.Phonetic['dd'] = '\u09A6' + '\u09cd' + '\u09A6';
		KeyMap.Phonetic['Nn'] = '\u09A3' + '\u09cd' + '\u09A3';
		KeyMap.Phonetic['Nw'] = '\u09A3' + '\u09cd' + '\u09AC';
		KeyMap.Phonetic['Nm'] = '\u09A3' + '\u09cd' + '\u09AE';
		KeyMap.Phonetic['Ny'] = '\u09A3' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['NZ'] = '\u09A3' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['nT'] = '\u09A8' + '\u09cd' + '\u099F';
		KeyMap.Phonetic['nD'] = '\u09A8' + '\u09cd' + '\u09A1';
		KeyMap.Phonetic['nt'] = '\u09A8' + '\u09cd' + '\u09A4';
		KeyMap.Phonetic['ntw'] = '\u09A8' + '\u09cd' + '\u09A4' + '\u09cd' + '\u09AC';
		KeyMap.Phonetic['nty'] = '\u09A8' + '\u09cd' + '\u09A4' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['ntZ'] = '\u09A8' + '\u09cd' + '\u09A4' + '\u09cd' + '\u09AF';
		KeyMap.Phonetic['rr'] = '\u09b0' + '\u09cd';
		KeyMap.Phonetic['rY'] = KeyMap.Phonetic['r'] + '\u200c' + '\u09CD' + '\u09AF';
		KeyMap.Phonetic['L'] = KeyMap.Phonetic['l'];
		KeyMap.Phonetic['Z'] = KeyMap.Phonetic['z'];
		KeyMap.Phonetic['P'] = KeyMap.Phonetic['p'];
		KeyMap.Phonetic['V'] = KeyMap.Phonetic['v'];
		KeyMap.Phonetic['B'] = KeyMap.Phonetic['b'];
		KeyMap.Phonetic['M'] = KeyMap.Phonetic['m'];
		KeyMap.Phonetic['V'] = KeyMap.Phonetic['v'];
		KeyMap.Phonetic['X'] = KeyMap.Phonetic['x'];
		KeyMap.Phonetic['V'] = KeyMap.Phonetic['v'];
		KeyMap.Phonetic['F'] = KeyMap.Phonetic['f'];

		for (key in KeyMap.Phonetic) {
		    /* Note 
               Before Converting- Phonetic['wr'] = '\u09C3';
               After Converting - KeyMap.Unijoy['\u09C3'] = 'wr';  //just reversing the above line.
           */
		    KeyMap.Phonetic[KeyMap.Phonetic[key]] = key;
		}
		KeyMap.Phonetic[".."] = ".";
	    //<-- adding bangla charanter as per keystroke for phonectic


		var lastInserted = "";
		var toBangla = "";
		var readKey = function(char, meth) {
			return (KeyMap[meth][char]) ? (KeyMap[meth][char]) : ("");
		}
		var insertPre = function(str, len) {
			lastInserted = str;
			toBangla = toBangla.substring(0, toBangla.length - len) + str;
		}
		var insertPro = function(str) {
			lastInserted = str;
			toBangla = toBangla + str;
		}
		var parseKeymap = function(tmp, meth) {
			var length = tmp.length;
			var charSet = new Array();
			for ( i = 0; i < length; i++)
				charSet[i] = tmp.substr(i, 1);
			var carry = "";
			var oldLen = 0;
			lastInserted = "";
			toBangla = "";
			if (meth == 'Unijoy') {
				for ( i = 0; i < length; i++) {
					var char = charSet[i];
					carry += char;
					var bangla = readKey(carry, meth);
					var tempBangla = readKey(char, meth);
					if (char == "g") {
						if (carry == "gg") {
							insertPre('\u09CD' + '\u200c', oldLen);
							oldLen = 1;
						} else {
							insertPro("\u09CD");
							oldLen = 1;
							carry = "g";
						}
					} else if (oldLen == 0) {
						if (bangla == "")
							insertPro(char);
						else
							insertPre(bangla, 1);
						oldLen = 1;
					} else if (char == "A") {
						var newChar = KeyMap.Unijoy['v'] + '\u09CD' + lastInserted;
						insertPre(newChar, lastInserted.length);
						oldLen = lastInserted.length;
					} else if ((bangla == "" && tempBangla != "")) {
						bangla = tempBangla;
						carry = char;
						insertPro(bangla);
						oldLen = bangla.length;
					} else if (bangla != "") {
						insertPre(bangla, oldLen);
						oldLen = bangla.length;
					} else {
						insertPro(char);
						oldLen = 1;
					}
				}
				return toBangla;
			} else if (meth == 'Phonetic') {
				for ( i = 0; i < length; i++) {
					var char = charSet[i];
					if (oldLen == 0) {
						if (char == 'a')
							char = 'A';
					}
					carry += char;
					var bangla = readKey(carry, meth);
					var tempBangla = readKey(char, meth);
					if (char == "`") {
						if (carry == "``") {
							insertPre("`", oldLen);
							oldLen = 1;
						} else {
							insertPro("\u09CD");
							oldLen = 1;
							carry = "`";
						}
					} else if (oldLen == 0) {
						if (bangla == "")
							insertPro(char);
						else
							insertPre(bangla, 1);
						oldLen = 1;
					} else if (carry == "ao") {
						insertPre(readKey("ao", meth), old_len);
						oldLen = 1;
					} else if (carry == "ii") {
						insertPre(readKey('ii', meth), 1);
						oldLen = 1;
					} else if (carry == "oi") {
						insertPre('\u09C8', 1);
					} else if (char == "o") {
						if (carry == 'oo') {
							insertPro('\u09CB');
							oldLen = 1;
						} else {
							carry = "o";
						}
					} else if (carry == "ou") {
						insertPre("\u09CC", oldLen);
						oldLen = 1;
					} else if ((bangla == "" && tempBangla != "")) {
						bangla = tempBangla;
						if (bangla == "") {
							carry = "";
						} else {
							carry = char;
							insertPro(bangla);
							oldLen = bangla.length;
						}
					} else if (bangla != "") {
						insertPre(bangla, oldLen);
						oldLen = bangla.length;
					} else {
						insertPro(char);
						oldLen = 1;
					}
				}
				return toBangla
			}
		};
		var Utf8 = {
			encode : function(string) {
				string = string.replace(/\r\n/g, "\n");
				var utftext = "";
				for (var n = 0; n < string.length; n++) {
					var c = string.charCodeAt(n);
					if (c < 128) {
						utftext += String.fromCharCode(c);
					} else if ((c > 127) && (c < 2048)) {
						utftext += String.fromCharCode((c >> 6) | 192);
						utftext += String.fromCharCode((c & 63) | 128);
					} else {
						utftext += String.fromCharCode((c >> 12) | 224);
						utftext += String.fromCharCode(((c >> 6) & 63) | 128);
						utftext += String.fromCharCode((c & 63) | 128);
					}
				}
				return utftext;
			},
			decode : function(utftext) {
				var string = "";
				var i = 0;
				var c = c1 = c2 = 0;
				while (i < utftext.length) {
					c = utftext.charCodeAt(i);
					if (c < 128) {
						string += String.fromCharCode(c);
						i++;
					} else if ((c > 191) && (c < 224)) {
						c2 = utftext.charCodeAt(i + 1);
						string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
						i += 2;
					} else {
						c2 = utftext.charCodeAt(i + 1);
						c3 = utftext.charCodeAt(i + 2);
						string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
						i += 3;
					}
				}
				return string;
			}
		};
	}
} catch($keyError) {}







try {

    if (typeof KeyMap == 'undefined' || typeof jQuery == 'undefined')
		throw 'err#gvsgy56283';
	else {
		var bangla;

		new function ($) { $.fn.setCursorPosition = function (pos) { if ($(this).get(0).setSelectionRange) { $(this).get(0).setSelectionRange(pos, pos); } else if ($(this).get(0).createTextRange) { var range = $(this).get(0).createTextRange(); range.collapse(true); range.moveEnd('character', pos); range.moveStart('character', pos); range.select(); } } }(jQuery);

		new function ($) { $.fn.domPosition = function () { var tmpPos = { left: ($(this).position()).left, top: ($(this).position()).top }; $(this).offsetParent().each(function (i) { if ($(this)[0].tagName != 'BODY' && $(this)[0].tagName != 'HTML') { tmpPos.left += ($(this, i).position()).left; tmpPos.top += ($(this, i).position()).top; } }); return tmpPos; } }(jQuery);

		new function ($) { $.fn.getCursorPosition = function () { if ($(document).get(0).selection) { var range = $(document).get(0).selection.createRange(); range.moveStart('character', -($(this).val()).length); return range.text.length; } else if ($(this).get(0).selectionStart || $(this).get(0).selectionStart == '0') { return $(this).get(0).selectionStart; } } }(jQuery);

		new function($){$.fn.replceOldText=function(newText,oldTextLen){if($(document).get(0).selection){$(this).focus();var range=$(document).get(0).selection.createRange();if(($(this).val()).length>=oldTextLen)range.moveStart('character',-1*oldTextLen);range.text=newText;range.collapse(true);range.select();}else if($(this).get(0).selectionStart||$(this).get(0).selectionStart==0){$(this).focus();var startPs=$(this).get(0).selectionStart-oldTextLen;var endPs=$(this).get(0).selectionEnd;var scrollTop=$(this).get(0).scrollTop;startPs=(startPs==-1)?($(this).val()).length:startPs;$(this).val(($(this).val()).substring(0,startPs)+newText+($(this).val()).substring(endPs,($(this).val()).length));$(this).focus();$(this).get(0).selectionStart=startPs+newText.length;$(this).get(0).selectionEnd=startPs+newText.length;$(this).get(0).scrollTop=scrollTop;}else{var scrollTop=$(this).get(0).scrollTop;$(this).val($(this).val()+newText);$(this).focus();$(this).get(0).scrollTop=scrollTop;}}}(jQuery);

		new function ($) {
			$.fn.offsetPosition=function(){
				var obj = $(this)[0];
				var obj2 = obj;
				var curtop = 0;
				var curleft = 0;
				if (document.getElementById || document.all) {
					do  {
						curleft += obj.offsetLeft-obj.scrollLeft;
						curtop += obj.offsetTop-obj.scrollTop;
						obj = obj.offsetParent;
						obj2 = obj2.parentNode;
						while (obj2!=obj) {
							curleft -= obj2.scrollLeft;
							curtop -= obj2.scrollTop;
							obj2 = obj2.parentNode;
						}
					} while (obj.offsetParent);
				} else if (document.layers) {
					curtop += obj.y;
					curleft += obj.x;
				}
				return {top:curtop, left:curleft};
			}
		}(jQuery);

		new function($){
			$.fn.jw_zIndex=function(){
				var ret = parseInt($(this).css('z-index'));
				if(isNaN(ret)) ret=1;
				$(this).parents().each(function(){
					var tmp = $(this).css('z-index');
					var tmpInt = parseInt(tmp);
					if(!isNaN(tmpInt) && tmpInt>ret) ret = tmpInt;
				});
				return (ret+1000)%99999;
			}
		}(jQuery);

		var KeyBoard = function () {
			this.container = '';
			this.endAt = ' ';
			this.firstTime = true;
			this.wrdStPos = 0;
			this.tmpWord = '';
			this.tmpParsedWord = '';
			this.actual = '';
			this.editable = true;
			this.tool = '#banglaToolTip';
			this.inpTool = '#banglaInpTool';
			this.banglaOn = true;
			this.keyMethod = 'Phonetic';
			this.intText = '';
			this.script = '';
			this.exData = '';
			this.callBack = '';
			this.keyPress = ''
			this.button = false;
			this.setKeyMethod = function(i) {
				switch(i) {
					case 85:
						this.keyMethod = 'Unijoy';
						break;
					case 80:
						this.keyMethod = 'Phonetic';
						break;
					default:
						return;
				}
				this.activeBtn();
			};
			this.stopDefault = function(e) {
				e.preventDefault();
				e.stopPropagation();
			};
			this.valid = function(key) {
				return (key >= 45 && key <= 59) || (key >= 65 && key <= 90) || (key >= 93 && key <= 125) || (key >= 186 && key <= 222) || key == 59 || key == 61 || key == 27 || key == 32 || key == 13 || key == 44 || key == 34;
			};
			this.addSuggestion = function (ob, m, fn) {
				var kb = this;
				var back = fn;
				var me = ob;
				$(this.tool).find('.bangla_suggestion').remove();
				for(i in me){
					var itm = $('<li>').attr('dbid',me[i].id).attr('dbvalue',me[i].value).html(me[i].value.toLowerCase().replace(m,'<b>'+m+'</b>')).addClass('bangla_suggestion');
					itm.hover(function(){
						$(kb.container).addClass('suggestion-hovered');
					}).on('mouseout',function(){
						$(kb.container).removeClass('suggestion-hovered');
					}).click(function(){
						var ret = {
							id:$(this).attr('dbid'),
							value:$(this).attr('dbvalue')
						}
						back(ret,kb);
						$(kb.container).removeClass('suggestion-hovered');
					});
					$(this.tool).append(itm);
				}
				if($(this.tool).find('.bangla_suggestion').length>0){
					this.toolShow();
				}
			};
			this.changeTool = function() {
				if (this.tmpWord.length > 0 && this.tmpWord != this.endKey) {
					$(this.tool).show();
					this.tmpParsedWord = parseKeymap(this.tmpWord, this.keyMethod);
					$(this.tool).html('<li>' + this.tmpParsedWord + '</li>');
					var tObj = this
				} else {
					$(this.tool).html('');
					$(this.tool).hide();
					this.tmpParsedWord = '';
					this.tmpWord = '';
					this.actual = '';
				}
			};
			this.toolShow = function() {
				var pos = $(this.container).offsetPosition();
				var zIndex = $(this.container).jw_zIndex();
				$(this.tool).show();
				$(this.tool).css({
					'top' : pos.top + $(this.container).outerHeight() - 2,
					'left' : pos.left,
					'z-index': zIndex
				});
			};
			this.activeBtn = function() {
				$('.banglaBtnActive').removeClass('banglaBtnActive');
				if (!this.banglaOn)
					$('.English').addClass('banglaBtnActive');
				else {
					$('.' + this.keyMethod).addClass('banglaBtnActive');
				}
			};
			this.inpToolManage = function(val) {
				if (!val) {
					$(this.inpTool).hide();
					return;
				}
				this.activeBtn();
				var pos = $(this.container).offsetPosition();
				var zIndex = $(this.container).jw_zIndex();
				$(this.inpTool).show();
				$(this.inpTool).css({
					'top' : pos.top - $(this.inpTool).outerHeight() - 2,
				   


				    //'left' : pos.left + $(this.container).outerWidth() + 2 - $(this.inpTool).outerWidth(),
					'left': pos.left,    //$('#mytextarea').position().left,
					'z-index': zIndex
				});
				$('.banglaActive2009').removeClass('banglaActive2009');
				$(this.container).addClass('banglaActive2009');
			};
			this.toggleBangla = function() {
				this.banglaOn = !this.banglaOn;
				this.activeBtn();
			};
			this.start = function(data) {
				this.container = data.element;
				if(data.hasOwnProperty('callBack'))this.callBack = data.callBack;
				if(data.hasOwnProperty('keyPress')){
					this.keyPress = data.keyPress;
				}
				this.endKey = data.endKey;
				var thisObj = this;
				$(thisObj.tool).hide();
				$(thisObj.inpTool).hide();
				$(thisObj.container).focus(function() {
					if($(this).hasClass('bangla-off')) return;
					thisObj.inpToolManage(true);
				}).blur(function() {
					if($(this).hasClass('suggestion-hovered')) return;
					if($(this).hasClass('bangla-off')) return;
					if (!thisObj.button){
						thisObj.inpToolManage(false);
						$(thisObj.tool).hide();
					}
					else {
						thisObj.button = false;
					}
				}).click(function() {
					if($(this).hasClass('bangla-off')) return;
					$(thisObj.tool).hide();
					$(thisObj.tool).html('');
					thisObj.tmpWord = '';
					this.tmpParsedWord = '';
				}).keydown(function(e) {
					if($(this).hasClass('bangla-off')) return;
					if (thisObj.banglaOn && e.ctrlKey && e.altKey && !e.shiftKey) {
						thisObj.stopDefault(e);
						thisObj.setKeyMethod(e.which);
						thisObj.editable = false;
					} else if (e.which == 123 && !e.ctrlKey && !e.altKey && !e.shiftKey) {
						thisObj.stopDefault(e);
						thisObj.toggleBangla();
						thisObj.editable = false;
					} else if (e.which == 46) {
						var tmpPos = $(thisObj.container).getCursorPosition() - thisObj.wrdStPos;
						thisObj.tmpWord = thisObj.tmpWord.substr(0, tmpPos) + thisObj.tmpWord.substr(tmpPos + 1, thisObj.tmpWord.length - tmpPos);
						thisObj.changeTool();
						thisObj.editable = false;
					} else if (e.which == 8) {
						var tmpPos = $(thisObj.container).getCursorPosition() - thisObj.wrdStPos;
						thisObj.tmpWord = thisObj.tmpWord.substr(0, tmpPos - 1) + thisObj.tmpWord.substr(tmpPos, thisObj.tmpWord.length - tmpPos);
						thisObj.changeTool();
						thisObj.editable = false;
					} else if (!thisObj.banglaOn || e.ctrlKey || e.altKey)
						thisObj.editable = false;
					else
						thisObj.editable = true;
				}).keypress(function(e) {
					if($(this).hasClass('bangla-off')) return;
					var char = String.fromCharCode(e.which);
					if (thisObj.editable && thisObj.banglaOn && thisObj.valid(e.which)) {
						if (thisObj.tmpWord == thisObj.endAt) {
							thisObj.tmpWord = '';
						}
						if (thisObj.tmpWord.length == 0) {
							thisObj.wrdStPos = $(thisObj.container).getCursorPosition();
							thisObj.toolShow();
						}
						if (char == thisObj.endAt || e.which == 13) {
							thisObj.replaceWord();
							$(thisObj.tool).hide();
							$(thisObj.tool).html('');
							if ( typeof thisObj.callBack == 'function' && thisObj.tmpParsedWord!='' && thisObj.tmpParsedWord!=thisObj.endAt)
								thisObj.callBack(thisObj.tmpParsedWord);
							thisObj.tmpWord = '';
							thisObj.tmpParsedWord = '';
						} else {
							var tmpPos = $(thisObj.container).getCursorPosition() - thisObj.wrdStPos;
							thisObj.tmpWord = thisObj.tmpWord.substr(0, tmpPos) + char + thisObj.tmpWord.substr(tmpPos, thisObj.tmpWord.length - tmpPos);
							thisObj.changeTool();
						}
					}
				}).keyup(function(e){
					if ( typeof thisObj.keyPress == 'function'){
						thisObj.keyPress($(thisObj.container),($(thisObj.container).val()).replace(thisObj.tmpWord,thisObj.tmpParsedWord),e.which,thisObj);
					}
				});
				return this;
			};
			this.setToolEffect = function() {
				thisObj = this;
				$(thisObj.tool).children().each(function(i) {
					$(this, i).mouseup(function() {
						thisObj.tmpParsedWord = $(this).html() + thisObj.endAt;
						thisObj.replaceWord();
						$(thisObj.tool).hide();
						$(thisObj.tool).html('');
						/*if ( typeof thisObj.callBack == 'function')
							thisObj.callBack(thisObj.tmpParsedWord);*/
						thisObj.tmpWord = '';
						thisObj.tmpParsedWord = '';
						//alert('s');
					});
				});
			};
			this.lastPos = function() {
				var x = $(thisObj.container).val().length;
				$(thisObj.container).setCursorPosition(x);
			}
			this.replaceWord = function() {
				thisObj = this;
				$(thisObj.container).setCursorPosition(thisObj.wrdStPos + thisObj.tmpWord.length);
				$(thisObj.container).replceOldText(thisObj.tmpParsedWord, thisObj.tmpWord.length);
				$(thisObj.container).setCursorPosition(thisObj.wrdStPos + thisObj.tmpParsedWord.length);
			};
			this.reset = function(){
				$(this.container).replceOldText('', 0);
				$(this.container).val('');
				$(this.container).setCursorPosition($(this.container).val().length);
				$(this.tool).html('').hide();
			}
			this.setOption = function(obj) {
				if ( typeof obj.keyMethod != 'undefined')
					this.keyMethod = obj.keyMethod;
				if ( typeof obj.banglaOn != 'undefined')
					this.banglaOn = obj.banglaOn;
				if ( typeof obj.script != 'undefined') {
					this.script = obj.script;
					if ( typeof obj.exData != 'undefined')
						this.exData = obj.exData;
				}
				if ( typeof obj.endAt != 'undefined')
					this.endAt = obj.endAt;
				/*if ( typeof obj.callBack == 'function')
					this.callBack = obj.callBack;*/
				if ( typeof obj.button != 'undefined') {
					this.button = obj.button;
					if (this.button) {
						//$(this.container).replceOldText('', 0);
						//$(this.container).setCursorPosition($(this.container).val().length);
						$(this.container).focus();
					}
				}
			};
		};
		var Bangla = function() {
			this.total = new Array();
			this.contArray = {};
			this.addOptions = function(obj) {
				$('.' + obj).mouseover(function() {
					$(this).addClass('banglaBtnHover');
					var id = $('.banglaActive2009')[0].id;
					bangla.setSuggestOption({
						cont : id,
						button : true
					});
				}).mouseout(function() {
					$(this).removeClass('banglaBtnHover');
					var id = $('.banglaActive2009')[0].id;
					bangla.setSuggestOption({
						cont : id,
						button : false
					});
				});

                //Tool button click event is handled here.
				$('.' + obj).mouseup(function() {
					var id = $('.banglaActive2009')[0].id;
					if (obj == 'English')
						bangla.setSuggestOption({
							cont : id,
							banglaOn : false,
							button : true
						});
					else
						bangla.setSuggestOption({
							cont : id,
							keyMethod : obj,
							banglaOn : true,
							button : true
						});
					$('.banglaBtnActive').removeClass('banglaBtnActive');
					$(this).removeClass('banglaBtnHover');
					$(this).addClass('banglaBtnActive');
				});
			};
			this.toolCreate = function(){
				if($('#banglaToolTip').length<=0)$('body').append('<ul id="banglaToolTip"></ul>')

				if ($('#banglaInpTool').length <= 0) {
					$('body').append('<div id="banglaInpTool"></div>')
					// $('#banglaInpTool').append('<a class="English"><b>English</b></a>');
					// this.addOptions('English');
					for (key in KeyMap) {
						$('#banglaInpTool').append('<a class="' + key + '"><b>' + key + '</b></a>');
						this.addOptions(key);
					}
				}
				$('#banglaToolTip').hide();
				$('#banglaInpTool').hide();
			}
			this.initialize = function() {
			    if (this.total.length) return;
			    
				this.total = $('.swift_keyboard').not('.bangla-enabled');
				if ($('#banglaToolTip').length)
					$('#banglaToolTip').remove();
				if ($('#banglaInpTool').length)
					$('#banglaInpTool').remove();
				this.toolCreate();
				var t = this;
				for (var i = 0; i < this.total.length; i++) {
					var x = new KeyBoard();
					if ($(this.total[i])[0].id==undefined || $(this.total[i])[0].id=='')
						$(this.total[i])[0].id = 'banglaEnabled' + i;
					this.contArray[$(this.total[i])[0].id] = x;
					$(this.total[i]).addClass('bangla-enabled').attr('index',i);
					x.start({
						element : this.total[i]
					});
					$(this.total[i]).bind('remove',function(){
						delete t.contArray[$(this).attr('id')];
						var index = parseInt($(this).attr('index'));
						delete t.total.splice(index,1);
					})
				}
				return this;
			};
			this.enable = function(ob){
				ob.removeClass('bangla-off');
			};
			this.disable = function(ob){
				ob.addClass('bangla-off')
			};
			this.initialize_after = function(ob,fn,f) {
				if(typeof bangla!='object'){
					alert('Bangla Keyboard Not Added');
					return;
				}
				ob = $(ob);
				if(ob.hasClass('bangla-enabled')){
					return;
				}
				this.toolCreate();
				this.total.push(ob);
				ob.addClass('bangla-enabled').attr('index',(this.total.length-1));
				var x = new KeyBoard();
				if ($(this.total[this.total.length-1])[0].id==undefined || $(this.total[this.total.length-1])[0].id=='');{
					$(this.total[this.total.length-1])[0].id = 'banglaEnabled' + (this.total.length-1);
				}
				this.contArray[$(this.total[this.total.length-1])[0].id] = x;
				x.start({
					element : this.total[this.total.length-1],
					keyPress: fn
				});
				if(f!=undefined){
					x.inpToolManage(true);
				}
				var t=this;
				$($(this.total[this.total.length-1])).bind('remove',function(){
					delete t.contArray[$(this).attr('id')];
					var index = parseInt($(this).attr('index'));
					delete t.total.splice(index,1);
				})
				return this;
			};
			this.setSuggestOption = function(obj) {
				var container = '#' + obj.cont;
				(this.contArray[$(container)[0].id]).setOption(obj);
			};
		};

		$(document).ready(function() {
			bangla = new Bangla();
			bangla.initialize();

			$('.swift_keyboard').focus(function(e){
				bangla.initialize_after($(this),null,true);
			});
		});
	}
} catch($keyError) {
}