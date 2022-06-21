<?php

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
      <li><a href="/<?php echo $_GET['lang']; ?>/">Home</a></li>
      <li><span class="divider divider-vert"></span></li>
      <li><a class="item-primary" href="#" target="_self"><?php echo getString('economico'); ?></a>
         <ul style="width:150px;">
            <?php
            $id_empresa = $objeto_usuario->id_empresa;
            if ($id_empresa != "0")
               echo "<li><a href='/" . $_GET['lang'] . "/empresa/" . $id_empresa . "'>" . getString('work') . "</a></li>";
            ?>

            <li><a href="<?php echo "/" . $_GET['lang'] . "/empresas"; ?>"><?php echo getString('mis_empresas'); ?></a></li>
            <!--<li><a href="<?php echo "/" . $_GET['lang'] . "/perfil/" . $_SESSION['id_usuario']; ?>"><?php echo getString('perfil'); ?></a></li>-->
         </ul>
      </li>
      <li><span class="divider divider-vert"></span></li>
      <li><a class="item-primary" href="#" target="_self"><?php echo getString('militar'); ?></a>
         <ul style="width:150px;">
            <li><a href="<?php echo "/" . $_GET['lang'] . "/entrenar"; ?>" title="Entrenamiento" target="_self"><?php echo getString('entrenamiento'); ?></a></li>
            <li><a href="<?php echo "/" . $_GET['lang'] . "/wars/" . $objeto_usuario->id_nacionalidad;; ?>"><?php echo getString('guerras'); ?></a></li>
         </ul>
      </li>
      <li><span class="divider divider-vert"></span></li>
      <li><a class="item-primary" href="#" target="_self"><?php echo getString('mercados'); ?></a>
         <ul style="width:150px;">
            <li><a href="<?php echo "/" . $_GET['lang'] . "/mercado"; ?>" title="Productos" target="_self"><?php echo getString('mercado_productos'); ?></a></li>
            <li><a href="<?php echo "/" . $_GET['lang'] . "/mercado_laboral"; ?>"><?php echo getString('mercado_laboral'); ?></a></li>
            <li><a href="<?php echo "/" . $_GET['lang'] . "/mercado_economico"; ?>"><?php echo getString('mercado_economico'); ?></a></li>
            <li><a href="<?php echo "/" . $_GET['lang'] . "/mercado_empresas"; ?>"><?php echo getString('mercado_empresas'); ?></a></li>
         </ul>
      </li>
      <li><span class="divider divider-vert"></span></li>
      <li><a class="item-primary" href="#" target="_self"><?php echo getString('pais'); ?></a>
         <ul style="width:150px;">
            <li><a href="<?php echo "/" . $_GET['lang'] . "/pais/" . $objeto_usuario->id_nacionalidad; ?>" title="Mi país" target="_self"><?php echo getString('mi_pais'); ?></a></li>
            <li><a href="<?php echo "/" . $_GET['lang'] . "/partidos/" . $objeto_usuario->id_nacionalidad; ?>" title="Partidos políticos" target="_self"><?php echo getString('partidos_politicos'); ?></a></li>
            <li><a href="<?php echo "/" . $_GET['lang'] . "/laws/" . $objeto_usuario->id_nacionalidad; ?>" title="Leyes" target="_self"><?php echo getString('laws'); ?></a></li>
            <!--<li><a href="#"><?php echo getString('ranking'); ?></a></li>-->
         </ul>
      </li>
      <li><span class="divider divider-vert"></span></li>
      <li><a class="item-primary" href="#" target="_self"><?php echo getString('soporte'); ?></a>
         <ul style="width:150px;">
            <li><a href="/forum" title="Foro" target="_blank"><?php echo getString('foro'); ?></a></li>
            <li><a href="/support" title="Soporte" target="_blank"><?php echo getString('soporte'); ?></a></li>
            <li><a href="/bugs" title="Bugs" target="_blank"><?php echo getString('bugs'); ?></a></li>
            <li><a href="/wiki" title="Wiki" target="_blank"><?php echo getString('wiki'); ?></a></li>
         </ul>
      </li>
      <li><span class="divider divider-vert"></span></li>
      <li><a class="item-primary" href="/logout" target="_self"><? echo getString('logout'); ?></a>
      </li>
      <li><span class="divider divider-vert"></span></li>
      <li class="clear">&nbsp;</li>
   </ul>
</div>