<div style="width:800px; height: 600px; text-align: center;">
        <div style="background-color: red; font-size: 21px; font-weight: bold; text-align: center">Madrid<hr class="puntos"></div>
        <div style="background-color: blue; float:left; width: 240px"><div id="atacantes" style="background: blanchedalmond; float: left;">
    <div id="atacante">
        <p><B>ATACANTES RECIENTES:</B></p>
    </div>
    
    <div id="atacante_2">
       
    </div>
    
        <div id="atacante_2">
        
    </div>
    
        <div id="atacante_2">
        
    </div>
        <div id="atacante_2">
        
    </div>
    
        <div id="atacante_2">
        
    </div>    
</div>    </div>
        <div style="background-color: green; float:left; width: 340px"><p style="border:1px solid;">34:15</p><p>Ronda:5</p><div id="muro"></div>
            <div style="width: 50%; float:left;"><a id="top_a"></a><br><img src='/images/no_avatar.gif'/><br>Daño total:<a id="dano_a">0</a></div><div style="width: 50%; float:right;"><a id="top_d"></a><br><img src='/images/no_avatar.gif'/><br>Daño total: <a id="dano_d">0</a></div>
            <div style="margin-top: 200px;">
                <input type="button" id="pegar" style="font-size: large; background-color: red;" value="PEGAR"/>
            </div>
        </div>
        <div style="background-color: gray; float:left; width: 220px"><div id="defensores" style="background: blanchedalmond; float: left;">
    <div id="defensor">
        <p><B>DEFENSORES RECIENTES:</B></p>
    </div>
    
    <div id="defensor_2">
       
    </div>
    
        <div id="defensor_2">
        
    </div>
    
        <div id="defensor_2">
        
    </div>
        <div id="defensor_2">
        
    </div>
    
        <div id="defensor_2">
        
    </div>    
</div>    </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {
    $("#muro").progressbar({ value: 0 });
  });

function golpes() {
    var hits;
    hits = "<div style='display:none; margin: auto; width: 100px;'>nadie<br><img src='/images/no_avatar.gif'/><div style='color:red;'>nada</div></div>";
    $.get("/militar/historial.php",{id_guerra:"<? echo $_GET['id_guerra']; ?>"},
   function(data){
    hits = data;
    selector = "#atacantes";
   
			$(selector+" > div:last-child").fadeOut('300', function() {
				$(selector+" > div:last-child").remove();
				$(selector+" > div:nth-child(2)").before("<div style=\"height: 1px\"> </div>");
				$(selector+" > div:nth-child(2)").animate({height:'100px'}, function() {
					$(selector+" > div:nth-child(2)").append(hits.html);
					$(selector+" > div:nth-child(2) > div").fadeIn('300');
				});
				
			});   
   },"json")
   
   
   
    
}


function defensores() {
    var hits;
    hits = "<div style='display:none; margin: auto; width: 100px;'>nadie<br><img src='/images/no_avatar.gif'/><div style='color:red;'>nada</div></div>";
    $.get("/militar/historial.php",{id_guerra:"<? echo $_GET['id_guerra']; ?>"},
   function(data){
    hits = data;
    selector2 = "#defensores";
   
			$(selector2+" > div:last-child").fadeOut('300', function() {
				$(selector2+" > div:last-child").remove();
				$(selector2+" > div:nth-child(2)").before("<div style=\"height: 1px\"> </div>");
				$(selector2+" > div:nth-child(2)").animate({height:'100px'}, function() {
					$(selector2+" > div:nth-child(2)").append(hits.html);
					$(selector2+" > div:nth-child(2) > div").fadeIn('300');
				});
				
			});   
   },"json")
 
}

function top() {

var dataString = 'id_guerra=1';  
dataString += '&at=5841';
dataString += '&ci=5';

$.ajax({  
        type: "GET",
        url: "/militar/datos.php",
        data: dataString,
        dataType: "json",
        success: function(msg) {
            $("#dano_a").text(msg.dano_a);
            $("#dano_d").text(msg.dano_d);
            $("#top_a").text(msg.top_a);
            $("#top_d").text(msg.top_d);
            $("#muro").progressbar( "option", "value", parseInt(msg.muro) );
        }
});

 
}


$('#pegar').click(function() {
$.post("/militar/pegar.php", {id_usuario:"<? echo $_SESSION['id_usuario']; ?>"});
});   

setInterval(golpes,2000);
setInterval(defensores,2000);
setInterval(top,2000);
</script>
