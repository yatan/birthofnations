<link type="text/css" href="css/registro.css" rel="Stylesheet" />

<div class="wrapper">	
		<div class="section">

			<h1>Formulario de Registro</h1>
			
			<form id="form1" action="registro1.php" method="post">
				
				<label for="username">Nombre de usuario 
					
				<span style=color:green>Caracteres de A-z, mínimo 5 caracteres</span> 
				</label>
				<input tabindex="2" name="username" id="username" type="text" class="text value="" />
				
				<label for="password1">Contraseña<span style=color:green>Mínimo 5 caracteres, máximo 12 caracteres, letras y 					números</span></label>
				<input tabindex="3" name="password1" id="password1" type="password" class="text" value="" />
				
				<label for="password2">Repetir Contraseña <span style=color:green>Debe ser igual a la anterior</span></label>
				<input tabindex="4" name="password2" id="password2" type="password" class="text" value="" />
				
				<label for="email">Email <span>
					
				<span style=color:green>Escribe un email válido por favor</span>
						
				</label>
				<input tabindex="5" name="email" id="email" type="text" class="text" value="" />
				<div>
					<input tabindex="6" name="send" id="send" type="submit" class="submit" value="Enviar formulario" />
				</div>
			</form>
			
			
		</div>
	</div>