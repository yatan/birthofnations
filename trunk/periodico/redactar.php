<script type="text/javascript" src="/js/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/js/markitup/sets/bbcode/set.js"></script>
<link rel="stylesheet" type="text/css" href="/js/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="/js/markitup/sets/bbcode/style.css" />

<script type="text/javascript" >
   $(document).ready(function() {
      $("#markItUp").markItUp(mySettings);
   });
</script>


<div id="redactar">
    <form id="articulo">
        <h2>Redactar articulo nuevo</h2>
        <label for="titulo">Titulo:<input tabindex="1" type="text" name="titulo"></label><br>
        <label for="markItUp">Mensaje:<textarea id="markItUp" cols="60" rows="10" tabindex="1" name="msj"></textarea></label><br>
        <input type="button" id="enviar" value="Enviar">
    </form>
</div><!--form de creacion de empresas-->
<script>
    $('#enviar').click(function() {
  	$.post("/periodico/crear_articulo.php", $("#articulo").serialize(),
        function(data){
                        alert(data);
                      } );
   
    });

</script>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>