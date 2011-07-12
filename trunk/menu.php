<div class="menu">
    <ul>
        <li><a href="/" >Home</a></li>
        <li><a href="#" id="current">Economico</a>
    <ul>
        <li><a href="<? echo "/".$_GET['lang']."/crear_empresa"; ?>">Crear Empresa</a></li>
        <li><a href="<? echo "/".$_GET['lang']."/empresas"; ?>">Empresa</a></li>
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
            <li><a href="#">Mercado de productos</a></li>
            <li><a href="<? echo "/".$_GET['lang']."/mercado_laboral"; ?>">Mercado laboral</a></li>
            <li><a href="#">Mercado de empresas</a></li>
        </ul>   
        </li>     
        <li><a href="#">Pais</a>
        <ul>
            <li><a href="#">Mi pais</a></li>
            <li><a href="#">Partidos politicos</a></li>
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