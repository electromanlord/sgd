<?php 

class Menu{

	function MenuIzquierdo(){

	if($_SESSION['session'][0]){

		/* SECCIONES */

        $array=Acceso::AccesoSecciones($_SESSION['session'][0]);

        if(is_array($array)){ ?>
			<table cellpadding="0" cellspacing="0"  width="100%" id="menu_izquierdo" >
    		<tr>
				<td class="date"><a href="javascript:history.go(-1)"><img src="public_root/imgs/back.png" alt="Retroceder" width="16" height="16" border="0" align="absmiddle" style="margin-bottom:4px"/></a> <strong>MODULOS DEL SISTEMA</strong> <a href="javascript:history.go(1)"><img src="public_root/imgs/forward.png" alt="Retroceder" width="16" height="16" border="0" align="absmiddle" style="margin-bottom:4px"/></a></td>
			</tr>
			<tr>
				<td>
            		<?php
					for($c=0;$c<sizeof($array);$c++){
					/*   PAGINAS  */
    				$paginas=Acceso::AccesoPaginasSecciones($array[$c]['id_modulo'], $_SESSION['session'][0]);

					if(is_array($paginas)){ 
						$submenu = array();
					?>
					<div style="float: left" id="my_menu" class="sdmenu">
					<?
                    for($z=0;$z<sizeof($paginas);$z++){?>                        
						<?
							if(!StartsWith(strtolower($paginas[$z]['pagina']),'administracion')){
						?>
							<div>
								<div class="item" id="menu<?=$paginas[$z]['id']?>">
									  <a href="<?php echo $paginas[$z]['url']?>"> <?php echo $paginas[$z]['pagina']?></a>								</div>
							</div>
							<? 
							}else{
							 	$submenu[]=$z;//guardamos los indices
							}
							?>								                      
                        <?php
					}
					if(count($submenu)>0){?>
						<div>
							<div class="item cerrado" id="admin"><a href="javascript:VerSubMenu()">Administraci&oacute;n</a></div>
							<div style="display:none" id="submenu">
							<? for($z=0;$z<sizeof($submenu);$z++){ 
								$index = $submenu[$z];
							?>
								<div class="item subitem">
									<a href="<?php echo $paginas[$index]['url']?>"> <?php echo $paginas[$index]['pagina']?></a>								</div>	
							<? }?>
							</div>
						</div>
					    <?
					}					
				}?>
				</div>
            <? }?>				</td>
			</tr>
        </table>
        <?php
		}
	}
    }
}
 ?>
