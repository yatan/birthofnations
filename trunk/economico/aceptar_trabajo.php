<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");

$id_usuario = $_SESSION['id_usuario'];

if (isset($_GET['oferta']) && $_GET['oferta'] != "" && strlen($_GET['oferta'])>0 ){
    $res = sql("SELECT id_empresa FROM usuarios WHERE id_usuario = " . $id_usuario );
    
    if ($res['id_empresa'] != 0){//Miramos que no este en ninguna empresa
        
        die("Necesitas salir de tu trabajo");
    }
    
    $res = sql("SELECT * FROM mercado_trabajo WHERE id_oferta = " . $_GET['oferta']);
    
    sql("UPDATE usuarios SET id_empresa = " . $res['id_empresa'] . ", salario = " . $res['salario'] . ", moneda = " . $res['id_pais'] . " WHERE id_usuario = $id_usuario"); //Ponemos al usuario en su empresa
        
    if ($res['cantidad'] == 1 ){//Si la oferta es la ultima
        sql("DELETE FROM mercado_trabajo WHERE id_oferta = " . $_GET['oferta']);
        
    } else {
        
        sql("UPDATE mercado_trabajo SET cantidad = cantidad - 1 WHERE id_oferta = " . $_GET['oferta']);
    }
        //header("Location: ../");<- Redireccion a algun sitio
    echo "Has entrado correctamente en la empresa";
} else {
    
    die("Algo falla");
}
?>
