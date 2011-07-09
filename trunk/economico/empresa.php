<?

include_once($_SERVER['DOCUMENT_ROOT']."/include/funciones.php");


if(!isset($_GET['id_empresa']))
    die("Error: id no valido"); //Sustituir por error 404


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
        $empresa = sql("SELECT * FROM empresas WHERE id='$id'");
        
        $this->id_empresa = $id;
        $this->id_propietario = $empresa['id_propietario'];
        $this->nombre_empresa = $empresa['nombre_empresa'];
        $this->capital = $empresa['capital'];
        $this->stock = $empresa['stock'];
        $this->items_venta = $empresa['items_venta'];
        $this->precio_venta = $empresa['precio_venta'];
        $this->raw = $empresa['raw'];
    }
    
}

$empresa = new empresa($id_empresa);

echo "<h1>Empresa</h1>";
echo"<pre><code>";
var_dump($empresa);
echo"</code></pre>";
?>
