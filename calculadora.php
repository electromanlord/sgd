<html>
<head>
<title>Calculadora cient�fica</title>
<script language="javascript">
<!--
var broj = "0"
var tocka = 0
var eksp = 0
var eksponent = 3
var rjesenje = 0
var decimala = 0
var enter = "";
function memory(operator) {

	document.racunalo.zadatak.focus();

	if (operator == 1) {		// MS 
		document.racunalo.memorija.value = document.racunalo.rezultat.value
	}
	else if (operator == 2)	{	// MR
		var memorija = document.racunalo.memorija.value;
		if (memorija==0 || slovo(memorija.charAt(0))) {memorija = ""};
		document.racunalo.zadatak.value += memorija
	}
	else if (operator == 3) {	// CLS
		if (document.racunalo.zadatak.value == "") {
			document.racunalo.rezultat.value = ""
		}
		else {
			document.racunalo.zadatak.value = ""
		}
	}
}


function display(noviznak) {
	if (noviznak=="")
		{document.racunalo.zadatak.focus()}
	else
		{document.racunalo.rezultat.select()}
}


function dodajBroj(noviznak) {
	document.racunalo.zadatak.focus();
	document.racunalo.zadatak.value += noviznak
}


function izracunaj(zarez) {
	var pitanje = "";
	var mem = 0;

	if (zarez >= 1) {
		if (document.racunalo.zadatak.value == "") {
			broj = document.racunalo.rezultat.value
		}
		else {
	 	broj = document.racunalo.zadatak.value;
			if (ubacirezultat(broj.charAt(0))) {
				broj = document.racunalo.rezultat.value + broj
			}
		}
	}

	for (var i=0; i<broj.length; i++) {
		if (broj.charAt(i) == ",") {pitanje += "."}
		else if (broj.charAt(i) == " ") {}
		else {pitanje += broj.charAt(i)}
	}

	if (operator(broj.charAt(broj.length-1))) {return false};

	if (pitanje==''){
		pitanje=0;
	}
	
	/*if (isNaN(pitanje)){
		alert ("No se puede opear... \n\n El ingreso debe ser solo valor numerico");
		return false;
	}*/
	
	pitanje = eval("1*" + pitanje);

	if (zarez > 1) {
		pitanje = matematika(zarez, pitanje)
	}

	document.racunalo.oldrezultat.value = pitanje;

	zaokruzi(pitanje);

	document.racunalo.zadatak.value = "";
	document.racunalo.zadatak.focus()
}


function matematika(zarez, rjesenje) {
with (Math)
{
	if (zarez == 2) {
		rjesenje = pow(rjesenje, 2)
	}
	else if (zarez == 3) {
		rjesenje = sqrt(rjesenje)
	}
	else if (zarez == 4) {
		rjesenje = -rjesenje
	}
	else if (zarez == 5) {
		rjesenje = log(rjesenje)
	}
	else if (zarez == 6) {
		rjesenje = pow(E, rjesenje)
	}
	else if (zarez == 7) {
		rjesenje = 1/rjesenje
	}
	else if (zarez == 8) {
		rjesenje = log(rjesenje)/LN10
	}
	else if (zarez == 9) {
		rjesenje = pow(10, rjesenje)
	}
	else if (zarez >= 10 && zarez <= 12) {
		if (zarez == 10) {
			rjesenje = atan(rjesenje)
		}
		else if (zarez == 11) {
			rjesenje = acos(rjesenje)
		}
		else if (zarez == 12) {
			rjesenje = asin(rjesenje)
		}

		if (document.racunalo.stupnjevi[1].checked) {rjesenje = (rjesenje * 180) / PI}
	}
	else if (zarez >= 14 && zarez <= 16) {
		if (document.racunalo.stupnjevi[1].checked)
			{radijani = (rjesenje / 180) * PI}
		else
			{radijani = rjesenje};

		if (zarez == 14) {
			rjesenje = tan(radijani)
		}
		else if (zarez == 15) {
			rjesenje = cos(radijani)
		}
		else if (zarez == 16) {
			rjesenje = sin(radijani)
		}
	}
	else if (zarez == 17) {
		rjesenje = rjesenje/100
	}
	else if (zarez == 18) {
		rjesenje = rjesenje/1000000
	}
	else if (zarez == 20) {
		rjesenje = factorial(rjesenje)
	}
	else if (zarez == 21) {
		eksponent = prompt("Introduce exponente:", 3);
		rjesenje = pow(rjesenje, eksponent)
	}
	else if (zarez == 22) {
		eksponent = prompt("Introduce n�mero de ra�z:", 3);
		rjesenje = pow(rjesenje, (1/eksponent))
	}
	return rjesenje
}
}


function zaokruzi(ebroj) {

decimala=parseFloat(document.racunalo.izaZareza.options[document.racunalo.izaZareza.selectedIndex].value);
	var strbroj = ebroj + " ";
	if (strbroj.charAt(0) == ".") {strbroj = "0" + strbroj};
	var intbroj = strbroj.length - 1;
	deczarez(strbroj);

	if (intbroj > 16 && eksp == -1) {
		if (decimala == -1) {decimala = 14};
		strbroj = izazareza(strbroj.substring(0,intbroj)) + " ";
		intbroj = strbroj.length - 1;
		deczarez(strbroj)
	}

	if (decimala >= 0 && decimala != 14) {
		if (tocka > 0) {
			var odgovor = izazareza(strbroj.substring(0,intbroj))
		}
		else {
			ebroj = strbroj.substring(0,intbroj);
			if (decimala > 0) {
				ebroj += ".";
				for (var n = 0; n < decimala; n++) {
					ebroj += "0"
				}
			}
			var odgovor = ebroj
		}
	}
	else {
		decimala = 14;
		var odgovor = izazareza(strbroj)
	}

	if (odgovor.charAt(0) == ".") {odgovor = "0" + odgovor};

	document.racunalo.rezultat.value = odgovor;
}


function deczarez(novibroj) {
	tocka = 0;
	eksp = 0;

	tocka = novibroj.indexOf(".");
	eksp = novibroj.indexOf("e")
}


function izazareza(novibroj) {
with (Math) {

	if (eksp == -1) {
		var duzina = tocka;
		if (duzina == -1) {duzina = novibroj.length};
		var desni = "";

		if (duzina > 16) {
			var privremeni = round(novibroj*pow(10, 18)) + " ";
			var novie = privremeni.indexOf("e");
			var lijevi = (privremeni.substring(0,novie));

			lijevi = round(lijevi*pow(10, 15))/pow(10, 15) + " ";
			desni = (privremeni.substring(novie+2,privremeni.length-1));
			desni = "e+" + (desni-18)
		}
		else {
			var lijevi = round(novibroj*pow(10, decimala))/pow(10, decimala) + " "
		}
	}
	else {
		var lijevi = novibroj.substring(0,eksp);
		var desni = novibroj.substring(eksp,novibroj.length);

		lijevi = round(lijevi*pow(10, decimala))/pow(10, decimala) + " "
	}

	lijevi = lijevi.substring(0,lijevi.length - 1);

	if (lijevi.charAt(0) == ".") {lijevi = "0" + lijevi};

	if (decimala < 14) {
		if (lijevi.indexOf(".") == -1 && decimala != 0) {lijevi += "."};
		var nula = (tocka + decimala) - (lijevi.length - 1);
		if (nula > 0 && decimala > 0) {
			for (var n = 0; n < nula; n++) {
				lijevi += "0"
			}
		}
	}
	return (lijevi + " " + desni)
}
}


function factorial(n) {
	if ((n == 0) || (n == 1)) {
		return 1
	}
	else {
		var odgovor = (n * factorial(n-1));
		return odgovor
	}
}


function slovo(znak) {
	var slovo="(ABCDEFGHIKLMNOPRSTUVWXYZ";
    
	for (i=0; i<slovo.length; i++){
        if (znak == slovo.charAt(i)){
            return true;
        }
        else{
            return false;
        }
    }
		
}


function operator(znak) {
	var matoperator="*/+-";
	for (var i=0; i<matoperator.length; i++)
		if (znak == matoperator.charAt(i)) {return true}
	return false
}

function ubacirezultat(znak) {
	var ubacirezultat="*/+";
	for (var i=0; i<ubacirezultat.length; i++)
		if (znak == ubacirezultat.charAt(i)) {return true}
	return false
}

function Close(){
self.close();
//top.close();
}

-->
</script>
<style>A:link {
	COLOR: #0000cc; TEXT-DECORATION: none
}
A:visited {
	COLOR: #0000cc; TEXT-DECORATION: none
}
A:hover {
	COLOR: #123456; TEXT-DECORATION: none
}
BODY {
	FONT-SIZE: 10pt;
	FONT-FAMILY: "Arial", "Verdana";
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
TD {
	FONT-SIZE: 10pt; FONT-FAMILY: "Arial", "Verdana"
}
TH {
	FONT-SIZE: 10pt; FONT-FAMILY: "Arial", "Verdana"
}
</style>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body text="#234567" vLink="#000CC" aLink="#0000FF" link="#0000CC" bgColor="#FFFFFF" >
<form name="racunalo">
  <input type="hidden" name="oldrezultat"><input type="hidden" name="memorija">
  <table cellSpacing="0" cellPadding="1" width="280" align="center" bgColor="#efefef" border="4">
    <tr>
      <td vAlign="center" align="middle">
      <table cellSpacing="3" cellPadding="1" width="100%" bgColor="#cccccc" border="2">
        <tr>
          <td vAlign="center" align="middle" width="100%" bgColor="#efefef">
          <input style="font-size: 14pt; width: 260px; height: 30px; background: #efefef" onFocus="display(document.racunalo.rezultat.value)" size="13" name="rezultat">
          </td>
        </tr>
      </table>
      <table cellSpacing="3" cellPadding="0" bgColor="#efefef" border="2">
        <tr>
          <td vAlign="center" align="middle" colSpan="4"><nobr><font size="+0">
          <select title="Numero de Decimales" onChange="if (document.racunalo.oldrezultat.value != '') {zaokruzi(document.racunalo.oldrezultat.value)}; document.racunalo.zadatak.focus()" size="1" name="izaZareza">
          <option value="-1" selected>decimal</option>
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          </select> </font><font face="Arial" color="#226622" size="2">
          <input title="Radians" onClick="document.racunalo.zadatak.focus()" type="radio" CHECKED name="stupnjevi"><a onMouseOver="self.status='Radians'; return true" href="javascript:document.racunalo.stupnjevi[0].click()">Rad</a><input title="Stupnjevi" onClick="document.racunalo.zadatak.focus()" type="radio" name="stupnjevi"><a href="javascript:document.racunalo.stupnjevi[1].click()" onMouseOver="self.status='Degrees'; return true">Deg</a></font></nobr></td>
          <td align="middle">
          <input type="button" style="font-size: 10pt; width: 38px; height: 24px; background: #eeeeee"  onClick="Close();" name="cerrar" value="Cerrar">
         </td>
          <td>
          <input title="Borra pantalla" style="font-size: 10pt; width: 38px; height: 24px; background: #eeeeee" onClick="memory(3)" type="button" value="Borra" name="Cls" WIDTH="38" HEIGHT="24">
          </td>
        </tr>
        <tr>
          <td colSpan="6"></td>
        </tr>
        <tr bgColor="#efefef">
          <td vAlign="center" align="middle" width="100%" colSpan="6">
          <font color="#0000ff" size="3">
          <input onKeyDown="if (event.keyCode==13) {enter.click()}" style="FONT-WEIGHT: bold; FONT-SIZE: 10pt; WIDTH: 260px; HEIGHT: 25px" onChange="enter.click()" size="17" name="zadatak">
          </font></td>
        </tr>
        <tr>
          <td>
          <input title="Ra�z cuadrada" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(3)" type="button" value="sqrt" name="sqrt" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Ra�z" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(22)" type="button" value="root" name="root" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Logaritmo neperiano" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(5)" type="button" value="ln" name="ln" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Logaritmo com�n" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(8)" type="button" value="log" name="log" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Tangente" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(14)" type="button" value="tan" name="tan" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Arco tangente" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(10)" type="button" value="atan" name="atan" WIDTH="38" HEIGHT="28">
          </td>
        </tr>
        <tr>
          <td>
          <input title="Cuadrado" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(2)" type="button" value="x^2" name="kvadrat" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Potencia" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(21)" type="button" value="x^y" name="potencija" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Antilogaritmo neperiano" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(6)" type="button" value="e^x" name="aln" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Antilogaritmo" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(9)" type="button" value="10^x" name="alog" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Coseno" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(15)" type="button" value="cos" name="cos" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Arcocoseno" style="width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(11)" type="button" value="acos" name="acos" WIDTH="38" HEIGHT="28">
          </td>
        </tr>
        <tr>
          <td>
          <input title="Cambia signo" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(4)" type="button" value="+/-" name="sign" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(7)" type="button" value="1/x" name="1/x" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Factorial" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(20)" type="button" value="x!" name="fact" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Pi" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="dodajBroj(Math.PI)" type="button" value="Pi" name="PI" width="38" height="28">
          </td>
          <td>
          <input title="Seno" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(16)" type="button" value="sin" name="sin" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Arcoseno" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onClick="izracunaj(12)" type="button" value="asin" name="asin" WIDTH="38" HEIGHT="28">
          </td>
        </tr>
        <tr>
          <td colSpan="6"></td>
        </tr>
        <tr>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj(7)" type="button" value="7" name="7" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj(8)" type="button" value="8" name="8" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj(9)" type="button" value="9" name="9" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj('/')" type="button" value="/" name="djeljeno" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input title="Parte por mill�n" style="font-size: 10pt; width: 38px; height: 32px; background: #cdcdcd" onClick="izracunaj(18)" type="button" value="ppm" name="ppm" width="38" height="32">
          </td>
          <td>
          <input title="Guarda en memoria" style="font-size: 10pt; width: 38px; height: 32px; background: #eeeeee" onClick="memory(1)" type="button" value="MS" name="MS" width="38" height="32">
          </td>
        </tr>
        <tr>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj(4)" type="button" value="4" name="4" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj(5)" type="button" value="5" name="5" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj(6)" type="button" value="6" name="6" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj('*')" type="button" value="*" name="puta" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input title="Porcentaje" style="font-size: 10pt; width: 38px; height: 32px; background: #cdcdcd" onClick="izracunaj(17)" type="button" value="%" name="postotak" width="38" height="32">
          </td>
          <td>
          <input title="Visualiza memoria" style="font-size: 10pt; width: 38px; height: 32px; background: #eeeeee" onClick="memory(2)" type="button" value="MR" name="MR" width="38" height="32">
          </td>
        </tr>
        <tr>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj(1)" type="button" value="1" name="1" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj(2)" type="button" value="2" name="2" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj(3)" type="button" value="3" name="3" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj('-')" type="button" value="-" name="minus" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 10pt; width: 38px; height: 32px; background: #cdcdcd" onClick="dodajBroj('(')" type="button" value="(" name="lijevo" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 10pt; width: 38px; height: 32px; background: #cdcdcd" onClick="dodajBroj(')')" type="button" value=")" name="desno" WIDTH="38" HEIGHT="32">
          </td>
        </tr>
        <tr>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj(0)" type="button" value="0" name="0" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj('.')" type="button" value="." name="." WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 10pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj('e')" type="button" value="E" name="exp" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onClick="dodajBroj('+')" type="button" value="+" name="plus" WIDTH="38" HEIGHT="32">
          </td>
          <td colSpan="2">
          <input style="font-size: 12pt; width: 83px; height: 32px; background: #cdcdcd" onClick="izracunaj(1)" type="button" value="=" name="enter" WIDTH="82" HEIGHT="32">
          </td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
</form>
</body>
</html>