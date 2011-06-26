<?

//registro.php?referer=[array codificado con base64]=>[referer][email]
if(!isset($_GET['referer']))
    die("Error en el enlace");

$datos = $_GET['referer'];
$datos = base64_decode($datos);
$array = explode(",", $datos);

$referer = $array[0];
$email = $array[1];


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="css/registro.css" rel="Stylesheet" />

<div class="wrapper">	
		<div class="section">

			<h1>Formulario de Registro</h1>
			
			<form id="form1" action="registro1.php" method="post">
				
				<label for="username">Nombre de usuario 
					
				<span style=color:green>Caracteres de A-z, mínimo 5 caracteres</span> 
				</label>
				<input tabindex="2" name="username" id="username" type="text" class="text" value="" />
				
				<label for="password1">Contraseña<span style=color:green>Mínimo 5 caracteres, máximo 12 caracteres, letras y 					números</span></label>
				<input tabindex="3" name="password1" id="password1" type="password" class="text" value="" />
				
				<label for="password2">Repetir Contraseña <span style=color:green>Debe ser igual a la anterior</span></label>
				<input tabindex="4" name="password2" id="password2" type="password" class="text" value="" />
				
                                
                                <label for="referer">Referido </label>					
		
                                
				<input tabindex="5" name="referer" disabled id="email" type="text" class="text" value="<? echo $referer; ?>" />
                                
				<label for="email">Email</label>
                                <input tabindex="5" name="email" disabled id="email" type="text" class="text" value="<? echo $email; ?>" />
				<div>
					<input tabindex="6" name="send" id="send" type="submit" class="submit" value="Enviar formulario" />
				</div>
			</form>
			
			
		</div>
	</div>