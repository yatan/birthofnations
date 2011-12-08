<?

session_start();
include_once("config.php");
select_lang();
/*

  Script con varias funciones:


  online(): Muestra si el servidor mysql esta disponible o no
  sql($sql): Ejecuta la sentencia sql, si da error muestra mensaje de error con die()
 *         devuelve un array con los valores obtenidos si hay mas de 1,
 * 			o el valor sin array si solo devuelve 1 valor
  enviar_mail($destino, $nick, $id)
 *        Envia un correo para activar la cuenta --EN DESARROLLO--
  anadir_foro($usuario, $password, $email)
 *         Añade un usuario al foro smf

 */

function mysql_online() {
    $ip = "localhost";
    $puerto = 3306;

    if ($fp = @fsockopen($ip, $puerto, $ERROR_NO, $ERROR_STR, (float) 0.5)) {
        fclose($fp);
        echo "<font color='Green'>Online</font>";
    } else {
        echo "<font color='Red'>OFFLINE</font>";
    }
}

function smtp_online() {
    $ip = "localhost";
    $puerto = 26;

    if ($fp = @fsockopen($ip, $puerto, $ERROR_NO, $ERROR_STR, (float) 0.5)) {
        fclose($fp);
        return true;
    } else {
        return false;
    }
}

//Funcion que devuelve true o false segun estado mysql
function mysql_online2() {
    $ip = "localhost";
    $puerto = 3306;

    if ($fp = @fsockopen($ip, $puerto, $ERROR_NO, $ERROR_STR, (float) 0.5)) {
        fclose($fp);
        return true;
    } else {
        return false;
    }
}

function sql_error($sql) {

    $result = mysql_query($sql);

    if ($result == false) {
        //error_log("SQL error: ".mysql_error()."\n\nOriginal query: $sql\n");
        // Remove following line from production servers 
        die("SQL error: " . mysql_error() . "\b<br>\n<br>Original query: $sql \n<br>\n<br>");
    }
    return $result;
}

function sql_data($result) {

    //$result = sql_error($sql);

    if ($lst = mysql_fetch_assoc($result)) {
        mysql_free_result($result);
        return $lst;
    }
    return false;
}

function sql($sql) {

    $result = sql_error($sql);

    //Si no devuelve nada sale de la funcion
    if ($result == 1)
        return true;

    if (mysql_num_rows($result) == 1) {
        if (mysql_num_fields($result) == 1) {

            $dato = mysql_fetch_row($result);
            return $dato[0];
        }
        else
            $table = sql_data($result);
    }
    else {

        $table = array();
        if (mysql_num_rows($result) > 0) {
            $i = 0;
            while ($table[$i] = mysql_fetch_assoc($result))
                $i++;
            unset($table[$i]);
        }
        mysql_free_result($result);
    }
    return $table;
}

function sql2($sql) {

    $result = sql_error($sql);

    //Si no devuelve nada sale de la funcion
    if ($result == 1)
        return true;

    if (mysql_num_rows($result) == 1) {
        if (mysql_num_fields($result) == 1) {
            $dato = array();
            $dato[0] = mysql_fetch_row($result);
            return $dato;
        } else {
            $table = array();
            $table[0] = sql_data($result);
        }
    } else {

        $table = array();
        if (mysql_num_rows($result) > 0) {
            $i = 0;
            while ($table[$i] = mysql_fetch_assoc($result))
                $i++;
            unset($table[$i]);
        }
        mysql_free_result($result);
    }
    return $table;
}

select_lang();

function enviar_mail($destino, $nick) {

    global $mail_activation;
//var_dump($mail_activation);
// subject
    $titulo = $mail_activation['activacion_titulo'];

// message
    $mensaje = $mail_activation['activacion_mensaje_titulo'] . $mail_activation['activacion_mensaje_cuerpo'];

// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
    $cabeceras .= 'From: BirthofNations <admin@birthofnations.com>' . "\r\n";

// Mail it
    mail($destino, $titulo, $mensaje, $cabeceras);
}

function mail_referido($nick_padrino, $destino, $code) {
    global $txt;

// subject
    $titulo = $txt['referer_title'];

// message
    $mensaje = $txt['referer_mail1'] . $nick_padrino . $txt['referer_mail2'] . $code;

// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
    $cabeceras .= 'From: BirthofNations <admin@birthofnations.com>' . "\r\n";

// Mail it
    mail($destino, $titulo, $mensaje, $cabeceras);
}

function mail_bienvenida($nick, $destino) {
    global $txt;

    $titulo = $txt['mail_bienvenida_title'];

    // message
    $mensaje = $txt['mail_bienvenida1'] . $nick . $txt['mail_bienvenida2'] . $code;

    // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Cabeceras adicionales
    $cabeceras .= 'From: BirthofNations <admin@birthofnations.com>' . "\r\n";

    // Mail it
    mail($destino, $titulo, $mensaje, $cabeceras);
}

function anadir_foro($usuario, $password, $email) {

    $server = $GLOBALS["server"];
    $forouser = $GLOBALS["forouser"];
    ; /* Usuario DB foro smf */
    $foropass = $GLOBALS["foropass"];
    ; /* Password DB foro smf */
    $forodb = $GLOBALS["forodb"];
    ; /* DB foro smf */

    $link2 = mysql_connect($server, $forouser, $foropass);

    mysql_select_db($forodb, $link2);


    $salt = substr(md5(mt_rand()), 0, 4);
    $contrasena = sha1(strtolower($usuario) . $password);
    $hora = time();

    mysql_query("INSERT INTO smf_members (member_name, date_registered, real_name, passwd, email_address, password_salt) VALUES ('$usuario', '$hora', '$usuario', '$contrasena', '$email', '$salt')");
}

function anadir_bugs($usuario, $password, $email) {

    $server = $GLOBALS["server"];
    $forouser = $GLOBALS["bugsuser"];
    ; /* Usuario DB foro smf */
    $foropass = $GLOBALS["bugspass"];
    ; /* Password DB foro smf */
    $forodb = $GLOBALS["bugsdb"];
    ; /* DB foro smf */

    $link3 = mysql_connect($server, $forouser, $foropass);

    mysql_select_db($forodb, $link3);

    $hora = time();
    $contrasena = md5($password);
    $rand = rand();
    mysql_query("INSERT INTO mantis_user_table (username, email, password, cookie_string, date_created, access_level) VALUES ('$usuario', '$email', '$contrasena','$rand', '$hora', '25')");
}

function checkban($id) {

    include("config.php");

    $sql = sql("SELECT * FROM bans WHERE ( is_perm = 1 OR fecha_fin > " . time() . " ) AND id_usuario = " . $id);
    // (es permanente O no ha caducado ) Y esta asignado a su id -> Sigue ban
    if ($sql != false) { //Si ha devuelto algo es que esta ban
        return true;
    } else {
        return false;
    }
}

function select_lang() {
    global $mail_activation;
    global $signup_form;
    global $login_form;
    global $txt;
    //Cualquier metodo que vaya aqui para elegir el idioma Y cargar el archivo. De momento solo hay español

    include_once($_SERVER['DOCUMENT_ROOT'] . "/i18n/es_ES.php");
}

function id2nick($id) {
    return sql("SELECT nick FROM usuarios WHERE id_usuario='$id'");
}

//Devuelve el nombre de una empresa a partir de una id
function id2empresa($id) {
    return sql("SELECT nombre_empresa FROM empresas WHERE id_empresa='$id'");
}

function item2id($item) {

    $sql = sql("SELECT id_item FROM items WHERE nombre = '" . $item . "'");
    return $sql;
}

function id2item($id){
    $sql = sql("SELECT nombre FROM items WHERE id_item = '$id'");
    return $sql;   
}

function next_elecciones($DA, $DE, $FE) {//Actual/Resto del dia de las elecciones/Frecuencia
    if ($DA % $FE > $DE) {
        $prox = $DA - $DA % $FE + $DE + $FE;
    } else {
        $prox = $DA - $DA % $FE + $DE;
    }
    return $prox;
}

function puedo_votar($id_usuario, $tipo, $id_votacion) {//Determina si puedes votar o no, segun el tipo de votacion
    $sql3 = sql("SELECT * FROM log_votos WHERE id_votacion = " . $id_votacion . " AND id_usuario = " . $id_usuario); //Si ya ha votado
    if ($sql3 != false) { //Si ya ha votado
        return false;
    }

    switch ($tipo):
        case 1://Presi de partido
            $sql = sql("SELECT id_partido, ant_partido FROM usuarios WHERE id_usuario = " . $id_usuario); //Su partido y antiguedad
            $sql2 = sql("SELECT param1 FROM votaciones WHERE id_votacion = " . $id_votacion); //El partido de la votacion
            $sql4 = sql("SELECT ant_votaciones FROM partidos WHERE id_partido = " . $sql2);


            if ($sql['id_partido'] == $sql2 && $sql['ant_partido'] >= $sql4) {//Esta afiliado al partido Y tiene X antiguedad
                $ret = true;
            } else {
                $ret = false;
            }
            break;
        default:
            $ret = false;
            break;
    endswitch;
    if ($tipo >= 100) {//Votaciones para cargos de un pais
        $sql = sql("SELECT * FROM votaciones WHERE id_votacion = " . $id_votacion);
        $rest = explode("!", $sql['restricciones']); //Sacamos las restricciones para votar
        foreach ($rest as $res) {
            $rest2[] = explode("+", $res); //Separamos cada una de ellas
        }
        $ret = true; //En principio se podria votar
        foreach ($rest2 as $condicion) {//Comprobamos cada una de ellas
            switch ($condicion[0]):
                case "C": //Ciudadania
                    $cs = sql("SELECT id_nacionalidad FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']);
                    if ($cs != $condicion[1]) {
                        $ret = false;
                    }
                    break;
                case "E": //Puntos de experiencia
                    $exp = sql("SELECT exp FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']);
                    if ($exp < $condicion[1]) {
                        $ret = false;
                    }
                    break;
                case "G": //Gold, siempre debe ser la ultima
                    if ($ret == true) {//S�lo se paga si el resto de condiciones ya se han cumplido
                        $gold = sql("SELECT Gold FROM money WHERE id_usuario = " . $_SESSION['id_usuario']);
                        if ($gold >= $condicion[1]) {//Si tiene gold suficiente
                            sql("UPDATE money SET gold = gold - " . $condicion[1] . " WHERE id_usuario = " . $_SESSION['id_usuario']);
                        } else {//Si no tiene dinero suficiente
                            $ret = false;
                        }
                    }
            endswitch;
        }
    }
    return $ret;
}

function puedo_postularme($id_usuario, $tipo, $id_votacion) {//Determina si puedes postularte o no, segun el tipo de votacion
    $sql3 = sql("SELECT * FROM candidatos_elecciones WHERE id_votacion = " . $id_votacion . " AND id_candidato = " . $id_usuario); //Si ya ha votado
    if ($sql3 != false) { //Si ya esta postulado.
        return false;
    }

    switch ($tipo):
        case 1://Presi de partido
            $sql = sql("SELECT id_partido, ant_partido FROM usuarios WHERE id_usuario = " . $id_usuario); //Su partido y antiguedad
            $sql2 = sql("SELECT param1 FROM votaciones WHERE id_votacion = " . $id_votacion); //El partido de la votacion
            $sql4 = sql("SELECT ant_votaciones FROM partidos WHERE id_partido = " . $sql2);


            if ($sql['id_partido'] == $sql2 && $sql['ant_partido'] >= $sql4) {//Esta afiliado al partido Y tiene X antiguedad
                $ret = true;
            } else {
                $ret = false;
            }
            break;
        default:
            $ret = false;
            break;
    endswitch;
    if ($tipo >= 100) {//Votaciones para cargos de un pais
        $sql = sql("SELECT * FROM votaciones WHERE id_votacion = " . $id_votacion);
        $rest = explode("!", $sql['param1']); //Sacamos las restricciones para postularse
        foreach ($rest as $res) {
            $rest2[] = explode("+", $res); //Separamos cada una de ellas
        }
        $ret = true; //En principio se podria postular
        foreach ($rest2 as $condicion) {//Comprobamos cada una de ellas
            switch ($condicion[0]):
                case "C": //Ciudadania
                    $cs = sql("SELECT id_nacionalidad FROM usuarios WHERE id_usuario = ".$_SESSION['id_usuario']);
                    if ($cs != $condicion[1]) {
                        $ret = false;
                    }
                    break;
                case "E": //Puntos de experiencia
                    $exp = sql("SELECT exp FROM usuarios WHERE id_usuario = " . $_SESSION['id_usuario']);
                    if ($exp < $condicion[1]) {
                        $ret = false;
                    }
                    break;
                case "G": //Gold, siempre debe ser la ultima
                    if ($ret == true) {//S�lo se paga si el resto de condiciones ya se han cumplido
                        $gold = sql("SELECT Gold FROM money WHERE id_usuario = " . $_SESSION['id_usuario']);
                        if ($gold >= $condicion[1]) {//Si tiene gold suficiente
                            sql("UPDATE money SET gold = gold - " . $condicion[1] . " WHERE id_usuario = " . $_SESSION['id_usuario']);
                        } else {//Si no tiene dinero suficiente
                            $ret = false;
                        }
                    }
            endswitch;
        }
    }
    return $ret;
}

function check_stat($stat, $id) {

    $sql = sql("SELECT status FROM usuarios WHERE id_usuario = " . $id);
    $sql = explode(',', $sql);

    $flag = false;

    foreach ($sql as $status) {
        if ($status == $stat) {
            $flag = true;
            break;
        }
    }

    return $flag;
}

function add_stat($stat, $id) {
    if (check_stat($stat, $id) == false) {
        $sql = sql("SELECT status FROM usuarios WHERE id_usuario = " . $id);
        $sql .= $stat . ',';
        sql("UPDATE usuarios SET status = '" . $sql . "' WHERE id_usuario = " . $id);
        $sql = true;
    } else {
        $sql = false;
    }
    return $sql;
}

function list_stat($id) {

    $sql = sql("SELECT status FROM usuarios WHERE id_usuario = " . $id);
    $sql = explode(',', $sql);

    foreach ($sql as $status) {
        $list[] = $status;
    }
    unset($list[count($list) - 1]);

    return $list;
}

function del_stat($stat, $id) {
    if (check_stat($stat, $id) == true) {
        $list = list_stat($id);
        $new_stat = "";
        foreach ($list as $status) {
            if ($status != $stat) {
                $new_stat .= $status . ",";
            }
        }
        sql("UPDATE usuarios SET status = '" . $new_stat . "' WHERE id_usuario = " . $id);
    }
    return $new_stat;
}

function list_items() {//Genera un array $array[id_item] -> nombre item;
    $sql = sql("SELECT id_item, nombre FROM items");
    foreach ($sql as $item) {
        $list[$item['id_item']] = $item['nombre'];
    }
    return $list;
}

function parse_raw($tipo) {
    //de la casilla de raw_needed a un array [idraw] -> cantidad necesaria

    $sql = sql("SELECT raw_needed FROM items WHERE id_item = " . $tipo);
    $sql = explode(',', $sql);
    foreach ($sql as $raw1) {
        $raw[] = explode('-', $raw1);
    }
    foreach ($raw as $each) {
        $raw2[$each[0]] = $each[1];
    }
    return $raw2;
}

function nombre_item($tipo) {
    return sql("SELECT nombre FROM items WHERE id_item='$tipo'");
}

function obj_to_id($obj) {
    return sql("SELECT id_item FROM items WHERE nombre='$obj'");
}

function moneda_pais($pais) {
    return sql("SELECT moneda FROM country WHERE idcountry='$pais'");
}

function ventana_js($mensaje, $link="ventana", $titulo="", $tipo=1) {

    $id_ventana = rand();
    $id_link = rand();
    if ($id_link == $id_ventana)
        $id_link += 1;

    echo <<<EOT
       

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
EOT;


    switch ($tipo) {
        case 1:
            echo <<<EOT
            <script>
                    $(function() {
                            $( "#$id_ventana" ).dialog({draggable: false, resizable: false, autoOpen: false, buttons: [
                {
                    text: "Aceptar",
                    click: function() { $(this).dialog("close"); window.location.reload(); }
                }
            ]
            });
                    });
            </script>
EOT;
            break;

        case 2:
            echo <<<EOT
            <script>
                    $(function() {
                            $( "#$id_ventana" ).dialog({draggable: false, resizable: false, autoOpen: false, buttons: [
                {
                    text: "Aceptar",
                    click: function() { $(this).dialog("close"); }
                }
            ]
            });
                    });
            </script>
EOT;
            break;
    }


    echo <<<EOT
<div id="$id_ventana" title="$titulo" style="display:none">
$mensaje
</div>

<a href="#" id="$id_link">$link</a>

<script>
    $('#$id_link').click(function() {
        $( "#$id_ventana" ).dialog('open');

    });   
</script>
EOT;
}

function check_leader($cargo, $id) {

    $sql = sql("SELECT id_gente FROM country_leaders WHERE id_cargo = " . $cargo);
    $sql = explode(',', $sql);

    $flag = false;

    foreach ($sql as $persona) {
        if ($persona == $id) {
            $flag = true;
            break;
        }
    }

    return $flag;
}

function add_leader($cargo, $id) {
    if (check_leader($cargo, $id) == false) {
        $sql = sql("SELECT id_gente FROM country_leaders WHERE id_cargo = " . $cargo);
        $sql .= $id . ',';
        sql("UPDATE country_leaders SET id_gente = '" . $sql . "' WHERE id_cargo = " . $cargo);
        $sql = true;
    } else {
        $sql = false;
    }
    return $sql;
}

function list_leaders($cargo) {

    $sql = sql("SELECT id_gente FROM country_leaders WHERE id_cargo = " . $cargo);
    $sql = explode(',', $sql);

    foreach ($sql as $status) {
        $list[] = $status;
    }
    unset($list[count($list) - 1]);

    return $list;
}

function del_leader($cargo, $id) {
    if (check_leader($cargo, $id) == true) {
        $list = list_leaders($cargo);
        $new_stat = "";
        foreach ($list as $gente) {
            if ($gente != $id) {
                $new_stat .= $gente . ",";
            }
        }
        sql("UPDATE country_leaders SET id_gente = '" . $new_stat . "' WHERE id_cargo = " . $cargo);
    }
    return $new_stat;
}

function list_laws($cargo) {

    $sql = sql2("SELECT laws FROM country_leaders WHERE id_cargo = " . $cargo); //Sacamos la lista codificada


    $sql = explode(',', $sql); //Separamos la info de cada ley

    unset($sql[count($sql) - 1]); //Eliminamos el ultimo que nos sale en blanco

    foreach ($sql as $law) {
        $sql2[] = explode('-', $law); //Separamos la info de cada ley en trocitos
    }

    return($sql2);
}

function list_laws_raw($cargo) {

    $sql = sql("SELECT laws FROM country_leaders WHERE id_cargo = " . $cargo); //Sacamos la lista codificada


    $sql = explode(',', $sql); //Separamos la info de cada ley

    unset($sql[count($sql) - 1]); //Eliminamos el ultimo que nos sale en blanco

    return($sql);
}

function check_law($cargo, $tochecklaw) {

    $laws = list_laws($cargo);
    $flag = false;

    foreach ($laws as $law) {
        if ($law[0] == $tochecklaw) {
            $flag = true;
            break;
        }
    }

    return $flag;
}

function add_law($cargo, $id_ley, $vot, $p1 = 0) {

    $flag = check_law($cargo, $id_ley); //Comprobamos que no tenga el poder
    if ($flag == false) {
        //Si no lo tiene se lo añadimos
        $text = sql("SELECT laws FROM country_leaders WHERE id_cargo = " . $cargo);
        $text .= $id_ley . "-" . $vot . "-" . $p1 . ",";
        sql("UPDATE country_leaders SET laws = '" . $text . "' WHERE id_cargo = " . $cargo);
    }

    return!$flag;
}

function del_law($cargo, $id_ley) {

    $flag = check_law($cargo, $id_ley);
    if ($flag == true) { //Comprobamos que podia lanzar la ley
        $leyes = list_laws($cargo);
        $text = "";

        foreach ($leyes as $ley) {//Vamos comprobando una por una
            if ($ley[0] != $id_ley) {//Las que no sean las que queremos quitar
                $text .= $ley[0] . "-" . $ley[1] . ","; //Las vamos a�adiendo
            } else {
                continue;
            }
        }
        //Al final, actualizamos en la BD
        sql("UPDATE country_leaders SET laws = '" . $text . "' WHERE id_cargo = " . $cargo);
    }

    return $flag;
}

function apply_law($vot) {

    $votacion = sql("SELECT * FROM votaciones WHERE id_votacion = " . $vot);

    $p = explode('.', $votacion['param1']);
//    unset($p[count($p) - 1]);
//P[0] Es siempre el id del pais    

    switch ($votacion['tipo_votacion']):
        case 100: //Cambio de nombre del pais        
            sql("UPDATE country SET name = '" . $p[1] . "' WHERE idcountry = " . $p[0]);
            break;
        case 101://A�adir cargo
            //Lista de cargos
            $sql = sql2("SELECT id_cargo FROM country_leaders WHERE id_cargo >= " . $p[0] * 100 . " AND id_cargo <= " . ($p[0] * 100 + 99));
            //Reordenamos bajando un nivel
            foreach ($sql as $cargo) {
                $ids[] = $cargo[0];
            }
            //Buscamos el menor no ocupado
            for ($c = $p[0] * 100; $c < $p[0] * 100 + 100; $c++) {

                if (!in_array($c, $ids)) {
                    break;
                }
            }

            if ($c == $p[0] * 100 + 100) {
                echo "No puedes poner mas cargos, borra otro antes";
            } else {
                sql("INSERT INTO country_leaders (id_cargo, nombre) VALUES ('$c','$p[1]')");
            }
            break;
        case 102://Quitar cargo
            if ($p[1] >= $p[0] * 100 && $p[1] < $p[0] * 100 + 100) {
                sql("DELETE FROM country_leaders WHERE id_cargo = " . $p[1]);
            }
            break;
        case 103: //1:id del cargo 2:id jugador //Dar cargo 1 a usuario 2
            //Comprobamos que el cargo pertenece al pais desde el cual se envia la ley
            if ($p[1] >= $p[0] * 100 && $p[1] < $p[0] * 100 + 100) {
                //Comprobamos que no tenga ya el cargo
                if (!check_leader($p[1], $p[2])) {
                    //Entonces le a�adimos al cargo
                    add_leader($p[1], $p[2]);
                }
            }
            break;
        case 104://1:id del cargo 2:id jugador //Quitar cargo 1 a usuario 2
            //Comprobamos que el cargo pertenece al pais desde el cual se envia la ley
            if ($p[1] >= $p[0] * 100 && $p[1] < $p[0] * 100 + 100) {
                //Comprobamos que ya tenga el cargo
                //Entonces le quitamos el cargo
                del_leader($p[1], $p[2]); //La funcion ya comprueba que lo tenga
            }
            break;

    endswitch;
}

function rango($puntos) {
    global $txt;
    //De 0 a 14 puntos de combate
    if ($puntos >= 0 && $puntos < 15)
        return $txt["rango_0"];
    //A partir de 15 puntos de combate
    elseif ($puntos >= 15)
        return $txt["rango_1"];
}

?>