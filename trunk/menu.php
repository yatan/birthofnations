	<div class="menu">
		<ul>
			<li><a href="/" >Home</a></li>
			<li><a href="#" id="current">Economico</a>
				<ul>
					<li><a href="<? echo "/".$_GET['lang']."/crear_empresa"; ?>">Crear Empresa</a></li>
					<li><a href="<? echo "/".$_GET['lang']."/empresa/2"; ?>">Empresa</a></li>
					<li><a href="<? echo "/".$_GET['lang']."/perfil/".$_SESSION['id_usuario']; ?>">Perfil</a></li>
			   </ul>
		  </li>
			<li><a href="#">Soporte</a>
                <ul>
                <li><a href="/foro">Foro</a></li>
                <li><a href="/support">Tickets de soporte</a></li>
                <li><a href="/bugs">Reporte de bugs</a></li>
                </ul>
          </li>
			<li><a href="/logout">Logout</a></li>
		</ul>
	</div>