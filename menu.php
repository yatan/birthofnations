<?

$trabajado = sql("SELECT work FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']);
if($trabajado==1)
    $trabajado = "<img src='/images/menu/si.png' alt='si'>";
elseif($trabajado==0)
    $trabajado = "<img src='/images/menu/no.png' alt='no' >";


$entrenado = sql("SELECT train FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']);
if($entrenado==1)
    $entrenado = "<img src='/images/menu/si.png' alt='si'>";
elseif($entrenado==0)
    $entrenado = "<img src='/images/menu/no.png' alt='no' >";

?>
<div class="menu">
    <ul>
        <li><a href="/" >Home</a></li>
        <li><a href="#" id="current"><? echo getString('economico'); ?></a>
    <ul>
        <?
        $id_empresa = $objeto_usuario->id_empresa;
        if($id_empresa != "0")
            echo "<li><a href='/".$_GET['lang']."/empresa/".$id_empresa."'>".getString('work')."$trabajado</a></li>";
        ?>
        <li><a href="<? echo "/".$_GET['lang']."/empresas"; ?>"><? echo getString('mis_empresas'); ?></a></li>
        <!--<li><a href="<? echo "/".$_GET['lang']."/perfil/".$_SESSION['id_usuario']; ?>"><? echo getString('perfil'); ?></a></li>-->
    </ul>
        </li>
        
        <li><a href="#"><? echo getString('militar'); ?></a>
        <ul>
            <li><a href="<? echo "/".$_GET['lang']."/entrenar"; ?>"><? echo getString('entrenamiento')." ".$entrenado; ?></a></li>
            <!--<li><a href="#"><? echo getString('guerras'); ?></a></li>-->
        </ul>
        </li>
        <li><a href="#"><? echo getString('mercados'); ?></a>
        <ul>
            <li><a href="<? echo "/".$_GET['lang']."/mercado"; ?>"><? echo getString('mercado_productos'); ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/mercado_laboral"; ?>"><? echo getString('mercado_laboral'); ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/mercado_economico"; ?>"><? echo getString('mercado_economico'); ?></a></li>
            <!--<li><a href="#"><? echo getString('mercado_empresas'); ?></a></li>-->
        </ul>   
        </li>     
        <li><a href="#"><? echo getString('pais'); ?></a>
        <ul>
            <li><a href="<? echo "/".$_GET['lang']."/pais/".$objeto_usuario->id_pais; ?>"><? echo getString('mi_pais'); ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/partidos/".$objeto_usuario->id_pais; ?>"><? echo getString('partidos_politicos'); ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/laws/".$objeto_usuario->id_pais; ?>"><? echo getString('laws'); ?></a></li>
            <!--<li><a href="#"><? echo getString('ranking'); ?></a></li>-->
        </ul>   
        </li>        
        <li><a href="#"><? echo getString('soporte'); ?></a>
        <ul>
            <li><a target="Foro" href="/forum"><? echo getString('foro'); ?></a></li>
            <li><a target="Soporte" href="/support"><? echo getString('soporte'); ?></a></li>
            <li><a target="Bugs" href="/bugs"><? echo getString('bugs'); ?></a></li>
            <li><a target="Wiki" href="/wiki"><? echo getString('wiki'); ?></a></li>
        </ul>
        </li>
        <li><a href="/logout"><?echo getString('logout');?></a></li>
        </ul>
</div>
