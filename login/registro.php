<?php

////registro.php?referer=[array codificado con base64]=>[referer][email]
if (!isset($_GET['referer'])) {
	die("Error en el enlace");
}

$datos = $_GET['referer'];

include_once("../include/funciones.php");
select_lang();


$datos = sql("SELECT id_padrino, email FROM referals WHERE codigo='$datos'");
if ($datos == false) {
	die($txt['code_error']);
} else {
	$email = $datos['email'];
	$id_referer = $datos['id_padrino'];
	$referer = sql("SELECT nick FROM usuarios WHERE id_usuario='$id_referer'");
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="../css/registro.css" rel="Stylesheet" />

<div class="wrapper">
	<div class="section">

		<h1><?php echo getString("signup_title"); ?></h1>

		<form id="form1" action="registro1.php" method="post">

			<label for="username"><?php echo  getString("signup_username"); ?>

				<span style=color:green><?php echo getString("signup_username_info"); ?></span>
			</label>
			<input tabindex="2" name="username" id="username" type="text" class="text" value="" />

			<label for="password1"><?php echo getString("signup_pass"); ?><span style=color:green><?php echo getString("signup_pass_info"); ?> números</span></label>
			<input tabindex="3" name="password1" id="password1" type="password" class="text" value="" />

			<label for="password2"><?php echo getString("signup_pass2"); ?><span style=color:green><?php echo getString("signup_pass_info2"); ?></span></label>
			<input tabindex="4" name="password2" id="password2" type="password" class="text" value="" />


			<label for="referer"><?php echo getString('signup_referer'); ?> </label>

			<input type="hidden" name="email" value="<?php echo $email; ?>" />
			<input type="hidden" name="referer" value="<?php echo $referer; ?>" />
			<input tabindex="5" name="referer2" disabled id="referer2" type="text" class="text" value="<?php echo $referer; ?>" />

			<label for="email2"><?php echo getString('signup_mail'); ?></label>
			<input tabindex="5" name="email2" disabled id="email2" type="text" class="text" value="<?php echo $email; ?>" />
			<div>
				<?php
				// if (smtp_online() == true)
					echo "<input tabindex='6' name='send' id='send' type='submit' class='submit' value='" . getString('signup_mail_send_form') . "'/>";
				/* else
					echo "<h2>" . getString('signup_mail_error') . "</h2>"; */
				?>
			</div>
		</form>


	</div>
</div>