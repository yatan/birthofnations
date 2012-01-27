<style type="text/css">
    .comentario
    {
        border: 1px solid #781351;
        width:600px;
        margin:5px;
        min-height:100px;
    }
</style>
<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
$id_usuario = $_SESSION['id_usuario'];

if(!isset($_GET['id_articulo']))
    die("Error: id no valido"); //Substituir por error 404

$id_articulo = $_GET['id_articulo'];

  $sql = sql("SELECT * FROM articulos WHERE id_articulo = '" . $id_articulo ."'");//Comprobamos que exista el articulo.
    if($sql == false )
       echo getString('periodico_articulo_noexiste');
    else
    {
        $sql_autor = sql("SELECT * FROM usuarios WHERE id_usuario = '" . $sql['id_autor'] ."'");
        $fechapublicacion=date('Y-m-d G:i', $sql['fecha']);
echo "<h2>".$sql['titulo']."</h2>$fechapublicacion by <a href='/es/perfil/".$sql['id_autor']."'>".$sql_autor['nick']."</a><br>";

$megustavv = mysql_query("SELECT * FROM articulos_votos WHERE id_articulo=$id_articulo AND id_votador=$id_usuario");
if(mysql_num_rows($megustavv)>0){
$megustav = mysql_fetch_array($megustavv);
if($megustav['tipo']==1){
?>
<script>
	$(function() {
		$( "#dialog" ).dialog({draggable: false, resizable: false, autoOpen: false, buttons: [
    {
        text: "<? echo getString('aceptar'); ?>",
        click: function() { $(this).dialog("close"); window.location.reload(); }
    }
]
});
	});
</script>
<div id="dialog" title="Ya no me gusta">
</div>
<script>
    $(document).ready(function() {
        $("#yanomegusta").button();
          $("#yanomegusta").click(function() {
  	$.post("/periodico/gusta.php?doing=3&articulo_id=<? echo $sql['id_articulo']; ?>",
        function(data){
        $("#dialog").empty();
        $("#dialog").append(data);
        $( "#dialog" ).dialog('open');
        } );
      });
    });
</script>
<?
echo <<< HTML
<button id='yanomegusta' style='background-color:#1E679A ; border: 1px solid #1E679A;' href='#'>Ya no me gusta</button>
HTML;
} else {
?>
<script>
	$(function() {
		$( "#dialog" ).dialog({draggable: false, resizable: false, autoOpen: false, buttons: [
    {
        text: "<? echo getString('aceptar'); ?>",
        click: function() { $(this).dialog("close"); window.location.reload(); }
    }
]
});
	});
</script>
<div id="dialog" title="Ya no no me gusta">
</div>
<script>
    $(document).ready(function() {
        $("#yanonomegusta").button();
          $("#yanonomegusta").click(function() {
  	$.post("/periodico/gusta.php?doing=3&articulo_id=<? echo $sql['id_articulo']; ?>",
        function(data){
        $("#dialog").empty();
        $("#dialog").append(data);
        $( "#dialog" ).dialog('open');
        } );
      });
    });
</script>
<?
echo <<< HTML
<button id='yanonomegusta' style='background-color:#1E679A ; border: 1px solid #1E679A;' href='#'>Ya no no me gusta</button>
HTML;
}
} else {
?>
<script>
	$(function() {
		$( "#dialogm" ).dialog({draggable: false, resizable: false, autoOpen: false, buttons: [
    {
        text: "<? echo getString('aceptar'); ?>",
        click: function() { $(this).dialog("close"); window.location.reload(); }
    }
]
});
	});
</script>
<div id="dialogm" title="Me gusta">
</div>
<script>
    $(document).ready(function() {
        $("#megusta").button();
          $("#megusta").click(function() {
  	$.post("/periodico/gusta.php?doing=1&articulo_id=<? echo $sql['id_articulo']; ?>",
        function(data){
        $("#dialogm").empty();
        $("#dialogm").append(data);
        $( "#dialogm" ).dialog('open');
        } );
      });
    });
</script>
<script>
	$(function() {
		$( "#dialogn" ).dialog({draggable: false, resizable: false, autoOpen: false, buttons: [
    {
        text: "<? echo getString('aceptar'); ?>",
        click: function() { $(this).dialog("close"); window.location.reload(); }
    }
]
});
	});
</script>
<div id="dialogn" title="No me gusta">
</div>
<script>
    $(document).ready(function() {
        $("#nomegusta").button();
          $("#nomegusta").click(function() {
  	$.post("/periodico/gusta.php?doing=2&articulo_id=<? echo $sql['id_articulo']; ?>",
        function(data){
        $("#dialogn").empty();
        $("#dialogn").append(data);
        $( "#dialogn" ).dialog('open');
        } );
      });
    });
</script>
<?
echo <<< HTML
        <button id='megusta' style='background-color:#1E679A ; border: 1px solid #1E679A;' href='#'>Me gusta</button>
        <button id='nomegusta' style='background-color:#1E679A ; border: 1px solid #1E679A;' href='#'>No me gusta</button>
HTML;
    }
echo <<< HTML
            <hr>
            $sql[msg]
HTML;
    }
    echo "<br><br><h2 style='color:black;'>Comentarios</h2>";
    
    $comentarios = sql2("SELECT * FROM comentarios_articulos WHERE id_articulo = $id_articulo ORDER BY fecha ASC");
    foreach ($comentarios as $comentario) {
        
        echo "<div class='comentario'>";
        
        echo "<div style='margin-left:10px; float:left;'><a href='/".$_GET['lang']."/perfil/".$comentario['id_autor']."'>Autor: ".id2nick($comentario['id_autor'])."<br><br>";
        echo "<img style='height:42px; width:42px;' src='".sql("SELECT avatar FROM usuarios WHERE id_usuario='{$comentario['id_autor']}'")."'/></a></div>";
        echo "<div style='text-align:left; margin-left:150px;'>".$comentario['comentario']."</div>";
        
        if($objeto_usuario->id_usuario == $comentario['id_autor'])
            echo "<div style='float:right;'><a style='background:red; color:black;'>Borrar</a></div>";
        echo "</div>";
    }
?>
<br><hr><br>
<form id="form_comentario" action="/periodico/nuevo_comentario.php" method="post">
    <div style="text-align: center; font-size: 15px; font-weight: bold; color: #111">Nuevo comentario:</div>
    <textarea name="comentario" maxlength="1000" style="width:450px; height: 150px;"></textarea><br>
    <input type="hidden" name="id_articulo" value="<? echo $id_articulo; ?>"/>
    <input type="button" class="enviar_comentario" value="Enviar comentario">
</form>

<script type="text/javascript">
    
    $('.enviar_comentario').click(function() {
        
        var notice = $.pnotify({
        pnotify_title: "<? echo getstring('publicar_comentario'); ?>",
        pnotify_type: 'info',
        pnotify_info_icon: 'picon picon-throbber',
        pnotify_hide: false,
        pnotify_sticker: false,
        pnotify_width: "275px",
        pnotify_text: "<center><img src='/images/loading.gif'/></center>"
    });
 
 
         $.post("/periodico/nuevo_comentario.php", $('#form_comentario').serialize(),
         function(data) {
          var options = {
                pnotify_text: data
            };
            notice.pnotify(options);
                setTimeout(function() { 
                window.location.reload();
                },750);
         });
 
 
    }); 
    
</script>    
