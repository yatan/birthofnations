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

echo "<p>".getString('military_strength')." $fuerza</p>";
echo "<p>".getString('military_range').($p_combat) . "</p>";
echo "<p>".getString('military_points')."$p_combat</p>";

echo "<br>";

//Comprobaciones del user

if ($entrenado == 1)
    echo "<p>".getString('military_you_have_trained')."</p>";
elseif ($objeto_usuario->salud < $min_train_health)
    echo $txt['no_train_health'];
else
    echo "<button id='entrenar'>".getString('military_train')."</button>";
?>

<script>
    $(function() {
        $( "#dialog" ).dialog({draggable: false, resizable: false, autoOpen: false, buttons: [
                {
                    text: "<?echo getString('military_accept');?>",
                    click: function() { $(this).dialog("close"); window.location.reload(); }
                }
            ]
        });
    });
</script>

<div id="dialog" title="<? echo getString('military_train');?>">
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