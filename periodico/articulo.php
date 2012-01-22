<?php
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
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
echo <<< HTML
        <h2>$sql[titulo]</h2>$fechapublicacion by <a href="/es/perfil/$sql[id_autor]">$sql_autor[nick]</a><br>
HTML;
$megustavv = mysql_query("SELECT * FROM articulos_votos WHERE id_articulo=$id_articulo AND id_votador=$id_usuario");
if(mysql_num_rows($megustavv)>0){
$megustav = mysql_fetch_array($megustavv);
if($megustav[tipo]==1){
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
  	$.post("/periodico/gusta.php?doing=3&articulo_id=<?echo$sql[id_articulo];?>",
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
  	$.post("/periodico/gusta.php?doing=3&articulo_id=<?echo$sql[id_articulo];?>",
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
  	$.post("/periodico/gusta.php?doing=1&articulo_id=<?echo$sql[id_articulo];?>",
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
  	$.post("/periodico/gusta.php?doing=2&articulo_id=<?echo$sql[id_articulo];?>",
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
?>
