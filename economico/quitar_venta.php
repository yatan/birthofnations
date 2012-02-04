<?
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

$id_usuario = $_SESSION['id_usuario'];
if (isset($_GET['id_oferta']) && $_GET['id_oferta'] != "" && strlen($_GET['id_oferta']) > 0) {

//Ver cuanto habia en oferta

    $list_items = list_items();

    $sql = sql("SELECT id_item, cantidad, id_empresa FROM mercado_objetos WHERE id_oferta = " . $_GET['id_oferta']);

    //Poner en el inventario de la empresa

    sql("UPDATE inventario_empresas SET " . $list_items[$sql['id_item']] . " = " . $list_items[$sql['id_item']] . " + " . $sql['cantidad']." WHERE id_empresa='".$sql['id_empresa']."'");

//Mecanismo de quitar oferta
    sql("DELETE FROM mercado_objetos WHERE id_oferta = '" . $_GET['id_oferta'] . "'");
}
?>
<script>
    window.history.go(-1);
</script>