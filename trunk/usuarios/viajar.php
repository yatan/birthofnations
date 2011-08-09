<script language="javascript">
function cambiar_pais2(arg) {
 $("#regi").load("/usuarios/v_lista_regiones.php", {id_pais: arg});	
}
</script>
<?

echo "Aqui va el metodo de seleccion de regiones magico de yatan que no se hacer, asi que pongo un link y luego le quitais la variable del principio";
echo"<br><a href='../../usuarios/viaje.php'>Mueveme</a>";

?>
<form id="viajar2">
Pais:
<select name="pais" onchange="cambiar_pais2(this.value)">
    <?
    $sql = sql("SELECT idcountry, name FROM country");
    foreach ($sql as $pais) {
       echo "<option value='".$pais['idcountry']."'>".$pais['name']."</option>";
    }
    ?>
</select>
<a id="regi"></a>
<br/>
    <input type="button" value="Viajar" id="enviar2"/>
</form>

<script>
    $('#enviar2').click(function() {
  	$.post("/usuarios/viaje.php", $("#viajar2").serialize(),
        function(data){
                        alert(data);
                        window.location.reload();
                      } );
   
    });
</script>