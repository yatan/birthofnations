<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");
include_once("objeto_empresa.php");

if(!isset($_GET['id_empresa']))
    die("Error: id no valido"); //Substituir por error 404


$id_empresa = $_GET['id_empresa'];


$empresa = new empresa($id_empresa);

echo "<h1> {$empresa->nombre_empresa} </h1>";

//Mostrar link para trabajar y despedirme si es en esta empresa donde trabajo
$donde_trabajo = sql("SELECT id_empresa FROM usuarios WHERE id_usuario='".$_SESSION['id_usuario']."'");
$ya_trabaje = sql("SELECT work FROM diario WHERE id_usuario = " . $_SESSION['id_usuario']);
if($id_empresa==$donde_trabajo)
{
    if($ya_trabaje != 1){echo "<button id='trabajar' style='background-color:#1E679A ; border: 1px solid #1E679A;' href='#'>Trabajar</button><br>";}
    echo "<a id='despedir' href='../../economico/despedir.php?id_worker=".$_SESSION['id_usuario']."'>Dejar Empresa</a>";
   ?>
    <style>

div.ui-dialog a.ui-dialog-titlebar-close {
display: none;
}
.ui-dialog .ui-dialog-buttonpane { 
    text-align: center;
}
.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset { 
    float: none;
}
</style>

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

<div id="dialog" title="Trabajar">

</div>

<script>
    $(document).ready(function() {
        $("#trabajar").button();
    });

    $('#trabajar').click(function() {
  	$.post("/economico/trabajar.php",
        function(data){
                        $("#dialog").append(data);
                        $( "#dialog" ).dialog('open');
                      } );
   
    });
</script>
<?
}
    
//Ahora es un link, pero mas tarde se podria mostrar con show dialog los resultados del trabajo


if($empresa->id_propietario == $_SESSION['id_usuario'])
{   //Se envia por get la id para el include
   $var = $_GET['id_empresa']=$empresa->id_empresa;
   include("admin_empresa.php");
}
else
{
//Aqui se mostrara publicamente a todo el mundo
    //var_dump($empresa);
    echo "<p>Propietario: ".$empresa->get_nick_propietario()."</p>";
    echo "<p>Tipo:".$empresa->get_tipo()."</p>";
       
}
?>
