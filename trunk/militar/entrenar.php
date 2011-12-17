<h1>Entrenamiento Militar</h1>


<?
include_once($_SERVER['DOCUMENT_ROOT'] . "/usuarios/objeto_usuario.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/config_variables.php");

$objeto_usuario = new usuario($_SESSION['id_usuario']);
$militar = sql("SELECT fuerza, rango, p_combat FROM usuarios WHERE id_usuario='" . $_SESSION['id_usuario'] . "'");
$entrenado = sql("SELECT train FROM diario WHERE id_usuario='" . $_SESSION['id_usuario'] . "'");

$fuerza = $militar['fuerza'];
$rango = $militar['rango'];
$p_combat = $militar['p_combat'];

echo "<p>Fuerza: $fuerza</p>";
echo "<p>Rango: " . rango($p_combat) . "</p>";
echo "<p>Puntos de combate: $p_combat</p>";

echo "<br>";

//Comprobaciones del user

if ($entrenado == 1)
    echo "<p>Hoy ya has entrenado, vuelve mañana</p>";
elseif ($objeto_usuario->salud < $min_train_health)
    echo $txt['no_train_health'];
else
    echo "<button id='entrenar'>Entrenar</button>";
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