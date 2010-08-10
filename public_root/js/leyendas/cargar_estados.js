// JavaScript Document
$(document).ready(function(){
	
	mensaje = '<table width="161" border="0">\n\
                <tr>\n\
                    <td width="25">A </td>\n\
                    <td width="16"><div align="center">:</div></td>\n\
                    <td width="185">Archivado</td>\n\
                </tr>\n\
                <tr>\n\
                    <td>AA</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Archivo Aprobado </td>\n\
                </tr>\n\
                <tr>\n\
                    <td>AP</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Archivo Propuesto  </td>\n\
                </tr>\n\
                <tr>\n\
                    <td>B</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Borrador</td>\n\
                </tr>\n\
                <tr>\n\
                    <td>D</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Despachado</td>\n\
                </tr>\n\
                <tr>\n\
                    <td>DRA</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Derivaci&oacute;n Aprobrada</td>\n\
                  </tr>\n\
                  <tr>\n\
                    <td>DRP</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Derivaci&oacute;n Propuesta</td>\n\
                  </tr>\n\
                  <tr>\n\
                    <td>DA</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Despachado de Area</td>\n\
                  </tr>\n\
                  <tr>\n\
                    <td>DEV</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Devuelto</td>\n\
                  </tr>\n\
                  <tr>\n\
                    <td>DR</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Documento Derivado</td>\n\
                  </tr>\n\
                  <tr>\n\
                    <td>F</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Finalizado</td>\n\
                  </tr>\n\
                  <tr>\n\
                    <td>R</td>\n\
                    <td><div align="center">:</div></td>\n\
                    <td>Registrado</td>\n\
                  </tr>\n\
                </table>';
	
	$.jGrowl(mensaje, { 
		position : 'bottom-left',
		header: 'Estados',
		theme: 'iphone',
		sticky: true		
	});	
});		