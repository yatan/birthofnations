<?

/*$trabajado = sql("SELECT work FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']);
if($trabajado==1)
    $trabajado = "<img src='/images/menu/si.png' alt='si'>";
elseif($trabajado==0)
    $trabajado = "<img src='/images/menu/no.png' alt='no' >";


$entrenado = sql("SELECT train FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']);
if($entrenado==1)
    $entrenado = "<img src='/images/menu/si.png' alt='si'>";
elseif($entrenado==0)
    $entrenado = "<img src='/images/menu/no.png' alt='no' >";
*/
?>

<div class="nav-container-outer">
    
   <img src="/images/menu/nav-bg-l.jpg" alt="" class="float-left" />
   <img src="/images/menu/nav-bg-r.jpg" alt="" class="float-right" />
  <ul id="nav-container" class="nav-container">
      <li><a href="/" >Home</a></li>
       <li><span class="divider divider-vert" ></span></li>
      <li><a class="item-primary" href="" target="_self"><? echo getString('economico'); ?></a>
         <ul style="width:150px;">
        <?
        $id_empresa = $objeto_usuario->id_empresa;
        if($id_empresa != "0")
            echo "<li><a href='/".$_GET['lang']."/empresa/".$id_empresa."'>".getString('work')."</a></li>";
        ?>

            <li><a href="<? echo "/".$_GET['lang']."/empresas"; ?>"><? echo getString('mis_empresas'); ?></a></li>
            <!--<li><a href="<? echo "/".$_GET['lang']."/perfil/".$_SESSION['id_usuario']; ?>"><? echo getString('perfil'); ?></a></li>-->
         </ul>
	   </li>
       <li><span class="divider divider-vert" ></span></li>
      <li><a class="item-primary" href="" target="_self"><? echo getString('militar'); ?></a>
         <ul style="width:150px;">
            <li><a href="<? echo "/".$_GET['lang']."/entrenar"; ?>" title="Entrenamiento" target="_self" ><? echo getString('entrenamiento'); ?></a></li>
            <!--<li><a href="#"><? echo getString('guerras'); ?></a></li>-->
         </ul>
	   </li>
       <li><span class="divider divider-vert" ></span></li>
      <li><a class="item-primary" href="" target="_self"><? echo getString('mercados'); ?></a>
         <ul style="width:150px;">
            <li><a href="<? echo "/".$_GET['lang']."/mercado"; ?>" title="Productos" target="_self" ><? echo getString('mercado_productos'); ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/mercado_laboral"; ?>"><? echo getString('mercado_laboral'); ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/mercado_economico"; ?>"><? echo getString('mercado_economico'); ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/mercado_empresas"; ?>"><? echo getString('mercado_empresas'); ?></a></li>
         </ul>
	   </li>
       <li><span class="divider divider-vert" ></span></li>
      <li><a class="item-primary" href="" target="_self"><? echo getString('pais'); ?></a>
         <ul style="width:150px;">
            <li><a href="<? echo "/".$_GET['lang']."/pais/".$objeto_usuario->id_pais; ?>" title="Mi país" target="_self" ><? echo getString('mi_pais'); ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/partidos/".$objeto_usuario->id_pais; ?>" title="Partidos políticos" target="_self" ><? echo getString('partidos_politicos'); ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/laws/".$objeto_usuario->id_pais; ?>" title="Leyes" target="_self" ><? echo getString('laws'); ?></a></li>
            <!--<li><a href="#"><? echo getString('ranking'); ?></a></li>-->
         </ul>
	   </li>
       <li><span class="divider divider-vert" ></span></li>
      <li><a class="item-primary" href="" target="_self"><? echo getString('soporte'); ?></a>
         <ul style="width:150px;">
            <li><a href="/forum" title="Foro" target="_blank" ><? echo getString('foro'); ?></a></li>
            <li><a href="/support" title="Soporte" target="_blank" ><? echo getString('soporte'); ?></a></li>
            <li><a href="/bugs" title="Bugs" target="_blank" ><? echo getString('bugs'); ?></a></li>
            <li><a href="/wiki" title="Wiki" target="_blank" ><? echo getString('wiki'); ?></a></li>
         </ul>
	   </li>
       <li><span class="divider divider-vert" ></span></li>
      <li><a class="item-primary" href="" target="_self"><?echo getString('logout');?></a>
	   </li>
       <li><span class="divider divider-vert" ></span></li>
      <li class="clear">&nbsp;</li>
   </ul>
</div>
