<?

//registro.php?referer=[array codificado con base64]=>[referer][email]
if(!isset($_GET['referer']))
    die("Error en el enlace");

$datos = $_GET['referer'];
$datos = base64_decode($datos);
$array = explode(",", $datos);

$referer = $array[0];
$email = $array[1];


include_once("include/funciones.php");
select_lang();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="css/registro.css" rel="Stylesheet" />

<div class="wrapper">	
		<div class="section">

			<h1><?php echo $signup_form['signup_title']; ?></h1>
			
			<form id="form1" action="registro1.php" method="post">
				
				<label for="username"><?php echo $signup_form['signup_username']; ?> 
					
				<span style=color:green><?php echo $signup_form['signup_username_info']; ?></span> 
				</label>
				<input tabindex="2" name="username" id="username" type="text" class="text" value="" />
				
				<label for="password1"><?php echo $signup_form['signup_pass']; ?><span style=color:green><?php echo $signup_form['signup_pass_info']; ?>					números</span></label>
				<input tabindex="3" name="password1" id="password1" type="password" class="text" value="" />
				
				<label for="password2"><?php echo $signup_form['signup_pass2']; ?><span style=color:green><?php echo $signup_form['signup_pass_info2']; ?></span></label>
				<input tabindex="4" name="password2" id="password2" type="password" class="text" value="" />
				
                                
                                <label for="referer"><?php echo $signup_form['signup_referer']; ?> </label>					
		
                                
				<input tabindex="5" name="referer" disabled id="email" type="text" class="text" value="<? echo $referer; ?>" />
                                
				<label for="email"><?php echo $signup_form['signup_email']; ?></label>
                                <input tabindex="5" name="email" disabled id="email" type="text" class="text" value="<? echo $email; ?>" />
				<div>
					<input tabindex="6" name="send" id="send" type="submit" class="submit" value="Enviar formulario" />
				</div>
			</form>
			
			
		</div>
	</div>