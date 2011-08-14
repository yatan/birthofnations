

<input type="button" id="pegar" style="font-size: large; background-color: red;" value="PEGAR"/>
<a id="historia"></a>
<script type="text/javascript">



function golpes() {
    $.get("/militar/historial.php",{id_guerra:"<? echo $_GET['id_guerra']; ?>"},
   function(data){
     $('#historia').html(data);
   })
    
}

$('#pegar').click(function() {
$.post("/militar/pegar.php", {id_usuario:"<? echo $_SESSION['id_usuario']; ?>"});
});   

setInterval(golpes,4000);
</script>