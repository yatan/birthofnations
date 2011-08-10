<?

$trabajado = sql("SELECT work FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']);
if($trabajado==1)
    $trabajado = "<img src='/images/menu/no.png' alt='no'>";
elseif($trabajado==0)
    $trabajado = "<img src='/images/menu/si.png' alt='si' >";

?>
<div class="menu">
    <ul>
        <li><a href="/" >Home</a></li>
        <li><a href="#" id="current">Economico</a>
    <ul>
        <?
        $id_empresa = sql("SELECT id_empresa FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");
        if($id_empresa != "0")
            echo "<li><a href='/".$_GET['lang']."/empresa/".$id_empresa."'>Trabajar $trabajado</a></li>";
        ?>
        <li><a href="<? echo "/".$_GET['lang']."/empresas"; ?>">Mis Empresas</a></li>
        <li><a href="<? echo "/".$_GET['lang']."/perfil/".$_SESSION['id_usuario']; ?>">Perfil</a></li>
    </ul>
        </li>
        
        <li><a href="#">Militar</a>
        <ul>
            <li><a href="#">Entrenamiento</a></li>
        </ul>
        </li>
        <li><a href="#">Mercados</a>
        <ul>
            <li><a href="<? echo "/".$_GET['lang']."/mercado"; ?>">Mercado de productos</a></li>
            <li><a href="<? echo "/".$_GET['lang']."/mercado_laboral"; ?>">Mercado laboral</a></li>
            <li><a href="#">Mercado de empresas</a></li>
        </ul>   
        </li>     
        <li><a href="#">Pais</a>
        <ul>
            <li><a href="<? echo "/".$_GET['lang']."/pais/".sql("SELECT id_nacionalidad FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'"); ?>">Mi pais</a></li>
            <li><a href="<? echo "/".$_GET['lang']."/partidos/".sql("SELECT id_nacionalidad FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'"); ?>">Partidos politicos</a></li>
            <li><a href="#">Clasificacion</a></li>
        </ul>   
        </li>        
        <li><a href="#">Soporte</a>
        <ul>
            <li><a href="/forum">Foro</a></li>
            <li><a href="/support">Tickets de soporte</a></li>
            <li><a href="/bugs">Reporte de bugs</a></li>
        </ul>
        </li>
                <li><a href="/logout">Logout</a></li>
        </ul>
</div>
