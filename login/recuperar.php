<?php

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include($_SERVER['DOCUMENT_ROOT']."/index_head.php");

?>

<style>
    .central{
    position:absolute;
    top:50%;
    left: 50%;
    height: 200px;
    width: 325px;
    margin-top: -100px;
    margin-left: -100px;
    border: 1px solid #ccc;  
    background-color: #f3f3f3;
    text-align: center;
}

</style>

<div id="central" class="central">
    <h1><?  echo getString("login_recovery_title");?></h1>
    <form id="datos">
        <?  echo getString("login_recovery_email");?><input type="email" name="mail"/><br>
        <input id="reset" type="button" value="<?  echo getString("login_reset_password");?>"/>
    </form>
</div>
<div id="central2" class="central" style="display: none;">
    <img src='/images/loading.gif'/>
</div>

<script>
    $('#reset').click(function() {
        $("#central").hide();
        $("#central2").show();
  	$.post("enviar_mail_reset.php", $("#datos").serialize(),
        function(data){
                        $("#central").html(data);
                        $("#central2").hide();
                        $("#central").show();
                      } );
                      
   
    });
</script>