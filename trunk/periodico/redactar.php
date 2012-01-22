<script type="text/javascript" src="/js/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/js/markitup/sets/bbcode/set.js"></script>
<link rel="stylesheet" type="text/css" href="/js/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="/js/markitup/sets/bbcode/style.css" />

<script type="text/javascript" >
   $(document).ready(function() {
      $("#markItUp").markItUp(mySettings);
   });
</script>



<input type="button" id="enviar" value="Publicar">
    <form id="articulo" method="post" onSubmit="return false;">
        <label for="titulo">Titulo:<input tabindex="1" type="text" name="titulo"></label><br>
        <label for="markItUp">Articulo:<textarea id="markItUp" cols="10" rows="8" tabindex="1" name="msj"></textarea></label><br>
       </form>  
   
<script>
    $('#enviar').click(function() {
  	$.post("/periodico/crear_articulo.php", $("#articulo").serialize(),
        function(data){
            if(data==1){
                alert("<?php echo getString("periodico_publicado");?>");
                window.location="/es/";
            } else{
                alert("<?php echo getString("periodico_caracter_blanco");?>");
            }
                      } );
   
    });

</script>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
