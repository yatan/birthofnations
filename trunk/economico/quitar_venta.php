<?
include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_usuario = $_SESSION['id_usuario'];
if (isset($_GET['id_oferta']) && $_GET['id_oferta'] != "" && strlen($_GET['id_oferta'])>0 ){

//Ver cuanto habia en oferta
    
    $sql = sql("SELECT cantidad, id_empresa FROM mercado_objetos WHERE id_oferta = " . $_GET['id_oferta']);
    sql("UPDATE empresas SET stock = stock + ". $sql['cantidad']." WHERE id_empresa = " . $sql['id_empresa']);
    
//Mecanismo de quitar oferta
sql("DELETE FROM mercado_objetos WHERE id_oferta = '". $_GET['id_oferta'] ."'");

}
?>
<script>
    window.history.go(-1);
</script>