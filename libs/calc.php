<?
function calcs(){
$htmlcal='
<form name="racunalo">
  <input type="hidden" name="oldrezultat"><input type="hidden" name="memorija">
  <table cellSpacing="0" cellPadding="1" width="280" align="center" bgColor="#efefef" border="4">
    <tr>
      <td vAlign="center" align="middle">
      <table cellSpacing="3" cellPadding="1" width="100%" bgColor="#cccccc" border="2">
        <tr>
          <td vAlign="center" align="middle" width="100%" bgColor="#efefef">
          <input style="font-size: 14pt; width: 260px; height: 30px; background: #efefef" onfocus="display(document.racunalo.rezultat.value)" size="13" name="rezultat">
          </td>
        </tr>
      </table>
      <table cellSpacing="3" cellPadding="0" bgColor="#efefef" border="2">
        <tr>
          <td vAlign="center" align="middle" colSpan="4"><nobr><font size="+0">
          <select title="Numero de Decimales" onchange="if (document.racunalo.oldrezultat.value != \'\') {zaokruzi(document.racunalo.oldrezultat.value)}; document.racunalo.zadatak.focus()" size="1" name="izaZareza">
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
          <input title="Radians" onclick="document.racunalo.zadatak.focus()" type="radio" CHECKED name="stupnjevi"><a onmouseover="self.status=\'Radians\'; return true" href="javascript:document.racunalo.stupnjevi[0].click()">Rad</a><input title="Stupnjevi" onclick="document.racunalo.zadatak.focus()" type="radio" name="stupnjevi"><a onmouseover="self.status=\'Degrees\'; return true" href="javascript:document.racunalo.stupnjevi[1].click()">Deg</a></font></nobr></td>
          <td align="middle">
          <input type="button" style="font-size: 10pt; width: 38px; height: 24px; background: #eeeeee"  name="cerrar" value="Cerrar">
          </td>
          <td>
          <input title="Borra pantalla" style="font-size: 10pt; width: 38px; height: 24px; background: #eeeeee" onclick="memory(3)" type="button" value="Borra" name="Cls" WIDTH="38" HEIGHT="24">
          </td>
        </tr>
        <tr>
          <td colSpan="6"></td>
        </tr>
        <tr bgColor="#efefef">
          <td vAlign="center" align="middle" width="100%" colSpan="6">
          <font color="#0000ff" size="3">
          <input onkeydown="if (event.keyCode==13) {enter.click()}" style="FONT-WEIGHT: bold; FONT-SIZE: 10pt; WIDTH: 260px; HEIGHT: 25px" onchange="enter.click()" size="17" name="zadatak">
          </font></td>
        </tr>
        <tr>
          <td>
          <input title="Raíz cuadrada" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(3)" type="button" value="sqrt" name="sqrt" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Raíz" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(22)" type="button" value="root" name="root" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Logaritmo neperiano" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(5)" type="button" value="ln" name="ln" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Logaritmo común" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(8)" type="button" value="log" name="log" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Tangente" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(14)" type="button" value="tan" name="tan" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Arco tangente" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(10)" type="button" value="atan" name="atan" WIDTH="38" HEIGHT="28">
          </td>
        </tr>
        <tr>
          <td>
          <input title="Cuadrado" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(2)" type="button" value="x^2" name="kvadrat" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Potencia" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(21)" type="button" value="x^y" name="potencija" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Antilogaritmo neperiano" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(6)" type="button" value="e^x" name="aln" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Antilogaritmo" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(9)" type="button" value="10^x" name="alog" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Coseno" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(15)" type="button" value="cos" name="cos" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Arcocoseno" style="width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(11)" type="button" value="acos" name="acos" WIDTH="38" HEIGHT="28">
          </td>
        </tr>
        <tr>
          <td>
          <input title="Cambia signo" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(4)" type="button" value="+/-" name="sign" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(7)" type="button" value="1/x" name="1/x" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Factorial" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(20)" type="button" value="x!" name="fact" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Pi" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="dodajBroj(Math.PI)" type="button" value="Pi" name="PI" width="38" height="28">
          </td>
          <td>
          <input title="Seno" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(16)" type="button" value="sin" name="sin" WIDTH="38" HEIGHT="28">
          </td>
          <td>
          <input title="Arcoseno" style="font-size: 10pt; width: 38px; height: 28px; background: #cdcdcd" onclick="izracunaj(12)" type="button" value="asin" name="asin" WIDTH="38" HEIGHT="28">
          </td>
        </tr>
        <tr>
          <td colSpan="6"></td>
        </tr>
        <tr>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(7)" type="button" value="7" name="7" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(8)" type="button" value="8" name="8" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(9)" type="button" value="9" name="9" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(\'/\')" type="button" value="/" name="djeljeno" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input title="Parte por millón" style="font-size: 10pt; width: 38px; height: 32px; background: #cdcdcd" onclick="izracunaj(18)" type="button" value="ppm" name="ppm" width="38" height="32">
          </td>
          <td>
          <input title="Guarda en memoria" style="font-size: 10pt; width: 38px; height: 32px; background: #eeeeee" onclick="memory(1)" type="button" value="MS" name="MS" width="38" height="32">
          </td>
        </tr>
        <tr>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(4)" type="button" value="4" name="4" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(5)" type="button" value="5" name="5" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(6)" type="button" value="6" name="6" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(\'*\')" type="button" value="*" name="puta" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input title="Porcentaje" style="font-size: 10pt; width: 38px; height: 32px; background: #cdcdcd" onclick="izracunaj(17)" type="button" value="%" name="postotak" width="38" height="32">
          </td>
          <td>
          <input title="Visualiza memoria" style="font-size: 10pt; width: 38px; height: 32px; background: #eeeeee" onclick="memory(2)" type="button" value="MR" name="MR" width="38" height="32">
          </td>
        </tr>
        <tr>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(1)" type="button" value="1" name="1" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(2)" type="button" value="2" name="2" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(3)" type="button" value="3" name="3" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(\'-\')" type="button" value="-" name="minus" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 10pt; width: 38px; height: 32px; background: #cdcdcd" onclick="dodajBroj(\'(\')" type="button" value="(" name="lijevo" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 10pt; width: 38px; height: 32px; background: #cdcdcd" onclick="dodajBroj(\')\')" type="button" value=")" name="desno" WIDTH="38" HEIGHT="32">
          </td>
        </tr>
        <tr>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(0)" type="button" value="0" name="0" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(\'.\')" type="button" value="." name="." WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 10pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(\'e\')" type="button" value="E" name="exp" WIDTH="38" HEIGHT="32">
          </td>
          <td>
          <input style="font-size: 12pt; width: 38px; height: 32px; background: #dedede" onclick="dodajBroj(\'+\')" type="button" value="+" name="plus" WIDTH="38" HEIGHT="32">
          </td>
          <td colSpan="2">
          <input style="font-size: 12pt; width: 83px; height: 32px; background: #cdcdcd" onclick="izracunaj(1)" type="button" value="=" name="enter" WIDTH="82" HEIGHT="32">
          </td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
</form>';
return $htmlcal;

}?>