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
        <li><a href="#" id="current"><? echo $txt['economico']; ?></a>
    <ul>
        <?
        $id_empresa = $objeto_usuario->id_empresa;
        if($id_empresa != "0")
            echo "<li><a href='/".$_GET['lang']."/empresa/".$id_empresa."'>Trabajar $trabajado</a></li>";
        ?>
        <li><a href="<? echo "/".$_GET['lang']."/empresas"; ?>"><? echo $txt['mis_empresas']; ?></a></li>
        <li><a href="<? echo "/".$_GET['lang']."/perfil/".$_SESSION['id_usuario']; ?>"><? echo $txt['perfil']; ?></a></li>
    </ul>
        </li>
        
        <li><a href="#"><? echo $txt['militar']; ?></a>
        <ul>
            <li><a href="<? echo "/".$_GET['lang']."/entrenar"; ?>"><? echo $txt['entrenamiento']." ".$entrenado; ?></a></li>
            <li><a href="#"><? echo $txt['guerras']; ?></a></li>
        </ul>
        </li>
        <li><a href="#"><? echo $txt['mercados']; ?></a>
        <ul>
            <li><a href="<? echo "/".$_GET['lang']."/mercado"; ?>"><? echo $txt['mercado_productos']; ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/mercado_laboral"; ?>"><? echo $txt['mercado_laboral']; ?></a></li>
            <li><a href="#"><? echo $txt['mercado_empresas']; ?></a></li>
        </ul>   
        </li>     
        <li><a href="#"><? echo $txt['pais']; ?></a>
        <ul>
            <li><a href="<? echo "/".$_GET['lang']."/pais/".$objeto_usuario->id_pais; ?>"><? echo $txt['mi_pais']; ?></a></li>
            <li><a href="<? echo "/".$_GET['lang']."/partidos/".$objeto_usuario->id_pais; ?>"><? echo $txt['partidos_politicos']; ?></a></li>
            <li><a href="#"><? echo $txt['ranking']; ?></a></li>
        </ul>   
        </li>        
        <li><a href="#"><? echo $txt['soporte']; ?></a>
        <ul>
            <li><a target="Foro" href="/forum"><? echo $txt['foro']; ?></a></li>
            <li><a target="Soporte" href="/support"><? echo $txt['soporte']; ?></a></li>
            <li><a target="Bugs" href="/bugs"><? echo $txt['bugs']; ?></a></li>
            <li><a target="Wiki" href="/wiki"><? echo $txt['wiki']; ?></a></li>
        </ul>
        </li>
                <li><a href="/logout">Logout</a></li>
        </ul>
</div>
