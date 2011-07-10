<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");


if(!isset($_GET['id_empresa']))
    die("Error: id no valido"); //Substituir por error 404


$id_empresa = $_GET['id_empresa'];


class empresa
{
    public $id_empresa;
    public $id_propietario;
    public $nombre_empresa;
    public $capital;
    public $stock;
    public $items_venta;
    public $precio_venta;
    public $pais;
    public $region;
    public $zona;
    public $raw;
    
    function empresa($id){
        $empresa = sql("SELECT * FROM empresas WHERE id_empresa='$id'");
        
        $this->id_empresa = $id;
        $this->id_propietario = $empresa['id_propietario'];
        $this->nombre_empresa = $empresa['nombre_empresa'];
        $this->gold = $empresa['gold'];
        $this->stock = $empresa['stock'];
        $this->items_venta = $empresa['items_venta'];
        $this->precio_venta = $empresa['precio_venta'];
        $this->raw = $empresa['raw'];
        $this->pais = $empresa['pais'];
    }
    
}

$empresa = new empresa($id_empresa);

echo "<h1>Empresa</h1>";
if($empresa->id_propietario == $_SESSION['id_usuario'])
{   //Se envia por get la id para el include
   $var = $_GET['id_empresa']=$empresa->id_empresa;
   include("admin_empresa.php");
}
else
    var_dump($empresa);

?>
