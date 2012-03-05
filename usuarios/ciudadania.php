<?php

/*
 * Code started by: yatan
 * Batamanta Team
 */
echo "<h1>".getString("ciudadania")."</h1>";

echo "<p>Actualmente tienes la ciudadania en: ".sql("SELECT name FROM country WHERE idcountry='$objeto_usuario->id_nacionalidad'")."</p>";

echo "<p>".  getString("pais_ciudadania"). "</p>";
?>

Pais:
<select style="width:200px;" name="pais" id="pais" onchange="cambiar_pais(this.value)">
<?
        $sql = sql("SELECT idcountry, name, url_bandera FROM country");
        foreach ($sql as $pais1) {
            if($pais1['idcountry']==$objeto_usuario->id_pais && !isset($_GET['pais']))
                $seleccionado = "selected='selected'";
            elseif($pais1['idcountry']==$_GET['pais'])
                $seleccionado = "selected='selected'";
            else
                $seleccionado = "";
            
            echo "<option title='".$pais1['url_bandera']."' $seleccionado value='".$pais1['idcountry']."'>".$pais1['name']."</option>";
        }
?>
</select>

<br>

<p>Coste: Gratis !</p>
<input id="bt_ciudadania" type="button" value="Solicitar ciudadania"/>


<script type="text/javascript">
    
    $('#bt_ciudadania').click(function() {
        var element = $("#pais");
        var Id = element.attr("value");
        
        
        var notice = $.pnotify({
        pnotify_title: "<? echo getstring('offer_cancel'); ?>",
        pnotify_type: 'info',
        pnotify_info_icon: 'picon picon-throbber',
        pnotify_hide: false,
        pnotify_sticker: false,
        pnotify_width: "275px",
        pnotify_text: "<center><img src='/images/loading.gif'/></center>"
    });
 
 
         $.post("/usuarios/solicitar_ciudadania.php", {id_pais: Id},
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