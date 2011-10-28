<h1>Entrenamiento Militar</h1>

  
<?

$militar = sql("SELECT fuerza, rango, p_combat FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");
$entrenado = sql("SELECT train FROM diario WHERE id_usuario='".$_SESSION['id_usuario']."'");

$fuerza = $militar['fuerza'];
$rango = $militar['rango'];
$p_combat = $militar['p_combat'];

echo <<<EOT

<p>Fuerza: $fuerza</p>
<p>Rango: $rango</p>
<p>Puntos de combate: $p_combat</p>


  
<div id="progressbar" style="width:100px; height:20px;"></div>
<br>
EOT;

if($entrenado==0)
    echo "<button id='entrenar'>Entrenar</button>";
else
    echo "<p>Hoy ya has entrenado, vuelve mañana</p>";

?>

<script>
    $(function() {
            $( "#dialog" ).dialog({draggable: false, resizable: false, autoOpen: false, buttons: [
{
    text: "Aceptar",
    click: function() { $(this).dialog("close"); window.location.reload(); }
}
]
});
    });
</script>

<div id="dialog" title="Entrenar">
</div>

  <script>

  $(document).ready(function() {
    $("#progressbar").progressbar({ value: 37 });
    $("#entrenar").button();
  });
  
  $('#entrenar').click(function() {
        
            $.post("/militar/entrenamiento.php",
    function(data){
                    $("#dialog").append(data);
                    $( "#dialog" ).dialog('open');
                  } );

    });  
  </script>