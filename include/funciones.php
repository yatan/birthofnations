<?

session_start();
include_once("config.php");
include_once('config_variables.php');
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
    $titulo = getString('referer_title');

// message
    $mensaje = getstring('referer_mail1') . $nick_padrino . getString('referer_mail2') . $code;

// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
    $cabeceras .= 'From: BirthofNations <admin@birthofnations.com>' . "\r\n";

// Mail it
    mail($destino, $titulo, $mensaje, $cabeceras);
}

function mail_bienvenida($nick, $destino) {


    $titulo = getString('mail_bienvenida_title');

    // message
    $mensaje = getString('mail_bienvenida1') . $nick . getString('mail_bienvenida2');

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

function check_lang($lengua) {

    $lengua_defecto = "es";

    $fichero = "./i18n/" . $lengua . ".php";

    if (!file_exists($fichero)) {
        $lengua = $lengua_defecto;
    }



    $_SESSION['i18n'] = $lengua;
    $_SESSION['i18n_default'] = $lengua_defecto;
}

function getString($text) {
    if (!isset($i18n_array)) {

        include $_SERVER['DOCUMENT_ROOT'] . '/i18n/' . $_SESSION['i18n_default'] . ".php";
        include $_SERVER['DOCUMENT_ROOT'] . '/i18n/' . $_SESSION['i18n'] . ".php";
    }

    return $i18n_array[$text];
}

function select_lang() {
    /* global $mail_activation;
      global $signup_form;
      global $login_form;
      global $txt; */
    //Cualquier metodo que vaya aqui para elegir el idioma Y cargar el archivo. De momento solo hay español

    if (isset($_GET['lang']))
        check_lang($_GET['lang']);
    else
        check_lang("es");




    //include_once($_SERVER['DOCUMENT_ROOT'] . "/i18n/es_ES.php");
}

function dar_exp($id, $cantidad) {

    //Subirsela al jugador
    sql("UPDATE usuarios SET exp = exp + " . $cantidad . " WHERE id_usuario = " . $id);
    //Sacar la ciudadania la jugador
    $cs = sql("SELECT id_nacionalidad FROM usuarios WHERE id_usuario = " . $id);
    //Ponerla al pais
    sql("UPDATE country SET exp = exp + " . $cantidad . " WHERE idcountry = " . $cs);

    //Ahora comprobamos si entre en un nuevo tipo de gobierno
    //Exp del pais
    $country = sql("SELECT exp,tipo_gobierno FROM country WHERE idcountry = " . $cs);

    global $gov_exp;



    if (in_array($country['exp'], $gov_exp)) {//Si es un punto clave
        $country = sql("SELECT tipo_gobierno FROM country WHERE idcountry = " . $cs);
        $time = time();
        $fin = $time + 86400;
        switch ($country):

            case 1://Salimos de la anarquia
                //Abrir votacion
                sql("INSERT INTO votaciones (tipo_votacion,comienzo,fin,restricciones,solved,is_cargo,id_pais) VALUES (2," . $time . ",
                    " . $fin . ",'C+" . $cs . "!E+10!S+1',0,0," . $cs . ")");
                //Sacar id de la votacion
                $id = sql("SELECT id_votacion FROM votaciones WHERE comienzo = " . $time . " AND id_pais = " . $cs);
                //Introducir candidatos
                sql("INSERT INTO candidatos_elecciones (id_votacion,id_candidato,tipo_elecciones,votos,solved) VALUES (" . $id . ",2,2,0,0) ");
                sql("INSERT INTO candidatos_elecciones (id_votacion,id_candidato,tipo_elecciones,votos,solved) VALUES (" . $id . ",3,2,0,0) ");

                break;

        endswitch;
    }
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

function id2item($id) {
    $sql = sql("SELECT nombre FROM items WHERE id_item = '$id'");
    return $sql;
}

function id2itemimg($id) {
    $sql = sql("SELECT url_imagen_grande FROM items WHERE id_item = '$id'");
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
    //Si la votacion ya esta cerrada pues nada
    $time = time();
    $fin = sql("SELECT fin FROM votaciones WHERE id_votacion = " . $id_votacion);
    if ($fin < $time) {
        return false;
    }
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
    if ($tipo >= 100 || $tipo == 2) {//Votaciones para cargos de un pais O cambio de gobierno
        $sql = sql("SELECT * FROM votaciones WHERE id_votacion = " . $id_votacion);
        $rest = explode("!", $sql['restricciones']); //Sacamos las restricciones para votar
        foreach ($rest as $res) {
            $rest2[] = explode("+", $res); //Separamos cada una de ellas
        }
        $ret = true; //En principio se podria votar
        //objeto usuario
        include_once($_SERVER['DOCUMENT_ROOT'] . "/usuarios/objeto_usuario.php");

        $objeto_usuario = new usuario($id_usuario);

        foreach ($rest2 as $condicion) {//Comprobamos cada una de ellas
            switch ($condicion[0]):
                case "C": //Ciudadania
                    if ($objeto_usuario->id_nacionalidad != $condicion[1]) {
                        $ret = false;
                    }
                    break;
                case "E": //Puntos de experiencia
                    if ($objeto_usuario->exp < $condicion[1]) {
                        $ret = false;
                    }
                    break;
                case "R"://Rango
                    if (!check_leader($condicion[1], $objeto_usuario->id_usuario)) {
                        $ret = false;
                    }
                    break;
                case "G": //Gold, siempre debe ser la ultima
                    if ($ret == true) {//S�lo se paga si el resto de condiciones ya se han cumplido
                        if ($objeto_usuario->gold >= $condicion[1]) {//Si tiene gold suficiente
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
    $sql3 = sql("SELECT * FROM candidatos_elecciones WHERE id_votacion = " . $id_votacion . " AND id_candidato = " . $id_usuario); //Si ya esta postulado
    if ($sql3 != false) { //Si ya esta postulado.
        return false;
    }

    if ($tipo == 1) {//Presi de partido
        $sql = sql("SELECT id_partido, ant_partido FROM usuarios WHERE id_usuario = " . $id_usuario); //Su partido y antiguedad
        $sql2 = sql("SELECT param1 FROM votaciones WHERE id_votacion = " . $id_votacion); //El partido de la votacion
        $sql4 = sql("SELECT ant_votaciones FROM partidos WHERE id_partido = " . $sql2);


        if ($sql['id_partido'] == $sql2 && $sql['ant_partido'] >= $sql4) {//Esta afiliado al partido Y tiene X antiguedad
            return true;
        } else {
            return false;
        }
    } elseif ($tipo >= 100) {//Votaciones para cargos de un pais
        $sql = sql("SELECT * FROM votaciones WHERE id_votacion = " . $id_votacion);
        $rest = explode("!", $sql['restricciones']); //Sacamos las restricciones para postularse
        foreach ($rest as $res) {
            $rest2[] = explode("+", $res); //Separamos cada una de ellas
        }
        $ret = true; //En principio se podria postular
        foreach ($rest2 as $condicion) {//Comprobamos cada una de ellas
            switch ($condicion[0]):
                case "C": //Ciudadania
                    if ($objeto_usuario->id_nacionalidad != $condicion[1]) {
                        return false;
                    }
                    break;
                case "E": //Puntos de experiencia
                    if ($objeto_usuario->exp < $condicion[1]) {
                        return false;
                    }
                    break;
                case "R"://Rango
                    if (check_leader($condicion[1], $objeto_usuario->id_usuario)) {
                        $ret = false;
                    }
                    break;
                case "G": //Gold, siempre debe ser la ultima
                    if ($ret == true) {//S�lo se paga si el resto de condiciones ya se han cumplido
                        $gold = sql("SELECT Gold FROM money WHERE id_usuario = " . $id_usuario);
                        if ($gold >= $condicion[1]) {//Si tiene gold suficiente
                            sql("UPDATE money SET gold = gold - " . $condicion[1] . " WHERE id_usuario = " . $id_usuario);
                        } else {//Si no tiene dinero suficiente
                            return false;
                        }
                    }
            endswitch;
        }
    }
    return $ret;
}

function puedo_tech_upgrade($id, $tech) {
    return true;
}

function precio_tech($tech, $country) {
    $sql = sql("SELECT precio" . $tech . " FROM country_tech WHERE id_country = " . $country);
    return $sql;
}

function time_tech($tech) {

    switch ($tech):
        case 1:
        case 2:
            $ret = 15;
            break;
    endswitch;

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

//Eta tb deberia estar obsoleta

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

function check_gov($id, $country) {
    //Primero sacamos la lista cargos del pais

    $down = $country * 100;
    $up = $down + 99;

    $sql = sql2("SELECT id_cargo FROM country_leaders WHERE id_cargo >= " . $down . " AND id_cargo <= " . $up);

    $ret = false;

    if (count($sql) == 1) {
        $ret = check_leader($sql[0][0], $id);
    } else {
        foreach ($sql as $cargo) {
            var_dump($cargo);
            $ret = check_leader($cargo['id_cargo'], $id);
            if ($ret == true) {
                break;
            }
        }
    }

    return $ret;
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

    $sql = sql("SELECT laws FROM country_leaders WHERE id_cargo = " . $cargo); //Sacamos la lista codificada


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
    //unset($sql[count($sql) - 1]); //Eliminamos el ultimo que nos sale en blanco
    //Pues parece que ya no sale en blanco
    return($sql);
}

function check_law($cargo, $tochecklaw) {//Dado un carho dice si peude usar una ley o no
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


    switch ($votacion['tipo_votacion']):
        case 2: //Cambio de sistema politico
            //Ver que sistema ha ganado
            $sql = sql2("SELECT votos, id_candidato FROM candidatos_elecciones WHERE id_votacion = " . $vot);

            $winner = array('id' => 0, 'votos' => -1);

            foreach ($sql as $cand) {//Ver quien es el ganador
                if ($cand['votos'] > $winner['votos']) {//Comparamos los votos con los del ganador
                    $winner['id'] = $cand['id_candidato'];
                    $winner['votos'] = $cand['votos'];
                } elseif ($cand['votos'] == $winner['votos']) {//Si empatan utilizamos los criterios de desempate (que no tenemos)
                }
            }

            //Borrar el gobierno anterior
            $down = $votacion['id_pais'] * 100;
            $up = $down + 99;

            sql("DELETE FROM country_leaders WHERE id_cargo >= " . $down . " AND id_cargo <= " . $up);
            //Elegir quien va en los nuevos cargos
            switch ($winner['id']):
                case 1://Anarquia
                    //Nadie
                    break;
                case 2://Consejo de sabios
                    //Cambiamos el sistema del pais
                    sql("UPDATE country SET tipo_gobierno = 2 WHERE idcountry = " . $votacion['id_pais']);
                    //Ponemos el puesto
                    sql("INSERT INTO country_leaders(id_cargo,nombre,votacion,laws,tech_manager) VALUES (" . $down . ",'" . getString('cargo_2_1') . "','A','100-V.R+" . $down . ",105-V.R+" . $down . "',1)");
                    $gente = sql("SELECT id_usuario FROM usuarios WHERE id_nacionalidad = " . $votacion['id_pais'] . " ORDER BY exp DESC LIMIT 9");
                    foreach ($gente as $id) {
                        add_leader($down, $id['id_usuario']);
                    }
                    break;
                case 3://Consejo de guerreros
                    //Cambiamos el sistema del pais
                    sql("UPDATE country SET tipo_gobierno = 3 WHERE idcountry = " . $votacion['id_pais']);

                    sql("INSERT INTO country_leaders(id_cargo,nombre,votacion,laws,tech_manager) VALUES (" . $down . ",'" . getString('cargo_3_1') . "','A','100-V.R+" . $down . ",105-V.R+" . $down . "',1)");
                    $gente = sql("SELECT id_usuario FROM usuarios WHERE id_nacionalidad = " . $votacion['id_pais'] . " ORDER BY fuerza DESC LIMIT 9");
                    foreach ($gente as $id) {
                        add_leader($down, $id['id_usuario']);
                    }
                    break;
            endswitch; //Aqui acaba el cambio de sistema politico
            break;
        case 100: //Cambio de nombre del pais        
            sql("UPDATE country SET name = '" . $p[0] . "' WHERE idcountry = " . $votacion['id_pais']);
            break;
        case 101://A�adir cargo
            //Lista de cargos
            $sql = sql2("SELECT id_cargo FROM country_leaders WHERE id_cargo >= " . $votacion['id_pais'] * 100 . " AND id_cargo <= " . ($votacion['id_pais'] * 100 + 99));
            //Reordenamos bajando un nivel
            foreach ($sql as $cargo) {
                $ids[] = $cargo[0];
            }
            //Buscamos el menor no ocupado
            for ($c = $votacion['id_pais'] * 100; $c < $votacion['id_pais'] * 100 + 100; $c++) {

                if (!in_array($c, $ids)) {
                    break;
                }
            }

            if ($c == $votacion['id_pais'] * 100 + 100) {
                echo "No puedes poner mas cargos, borra otro antes";
            } else {
                sql("INSERT INTO country_leaders (id_cargo, nombre) VALUES ('$c','$p[0]')");
            }
            break;
        case 102://Quitar cargo
            if ($p[0] >= $votacion['id_pais'] * 100 && $p[0] < $votacion['id_pais'] * 100 + 100) {
                sql("DELETE FROM country_leaders WHERE id_cargo = " . $p[0]);
            }
            break;
        case 103: //1:id del cargo 2:id jugador //Dar cargo 1 a usuario 2
            //Comprobamos que el cargo pertenece al pais desde el cual se envia la ley
            if ($p[0] >= $votacion['id_pais'] * 100 && $p[0] < $votacion['id_pais'] * 100 + 100) {
                //Comprobamos que no tenga ya el cargo
                if (!check_leader($p[0], $p[1])) {
                    //Entonces le a�adimos al cargo
                    add_leader($p[0], $p[1]);
                }
            }
            break;
        case 104://1:id del cargo 2:id jugador //Quitar cargo 1 a usuario 2
            //Comprobamos que el cargo pertenece al pais desde el cual se envia la ley
            if ($p[0] >= $votacion['id_pais'] * 100 && $p[0] < $votacion['id_pais'] * 100 + 100) {
                //Comprobamos que ya tenga el cargo
                //Entonces le quitamos el cargo
                del_leader($p[0], $p[1]); //La funcion ya comprueba que lo tenga
            }
            break;
        case 105://Cambio de bandera
            $sql = sql("UPDATE country SET url_bandera = '" . $votacion['param1'] . "' WHERE idcountry = " . $votacion['id_pais']);

            break;
        case 106://Cambio nombre moneda
            $monedas = sql("SELECT moneda FROM country");

            $flag = true;
            $p[0] = strtoupper($p[0]);

            foreach ($monedas as $coin) {
                if ($p[0] == $coin['moneda']) {//Su nombre es el de alguna moneda
                    $flag = false;
                }
            }

            if ($flag == true) {
                sql("ALTER TABLE empresas CHANGE " . moneda_pais($votacion['id_pais']) . " " . $p[0] . " decimal (11,3) NOT NULL DEFAULT 0");
                sql("ALTER TABLE money CHANGE " . moneda_pais($votacion['id_pais']) . " " . $p[0] . " decimal (11,3) NOT NULL DEFAULT 0");
                sql("ALTER TABLE money_pais CHANGE " . moneda_pais($votacion['id_pais']) . " " . $p[0] . " decimal (11,3) NOT NULL DEFAULT 0");
                sql("UPDATE country SET moneda = '" . $p[0] . "' WHERE idcountry = " . $votacion['id_pais']);
            }
            break;
        case 200:

            $currency_per_gold = 100; //De momento dejamos esto aqui, aunqueo ideal seria enlazarlo desde config_variables.php, pero no se porque no consigo que vaya ahora mismo.
            //Sacamos la cantidad de gold del pais;
            $gold = sql("SELECT Gold FROM money_pais WHERE idcountry = " . $votacion['id_pais']);
            $nombre_moneda = moneda_pais($votacion['id_pais']);

            //Vemos si tiene el Gold necesario para crearla:

            if ($gold >= $p[0] / $currency_per_gold) {//Gold >= gold necesario [Esp / (Esp/Gold)]
                //Quitar gold
                sql("UPDATE money_pais SET Gold = Gold - " . $p[0] / $currency_per_gold . " WHERE idcountry = " . $votacion['id_pais']);
                //Poner moneda local
                sql("UPDATE money_pais SET " . $nombre_moneda . " = " . $nombre_moneda . " + " . $p[0] . " WHERE idcountry = " . $votacion['id_pais']);
            }


            break;
        case 201:
            //Sacamos la lista de nombres de monedas
            $monedas = sql("SELECT moneda FROM country");

            $flag = true;
            $p[1] = strtoupper($p[1]);

            foreach ($monedas as $coin) {
                if ($p[1] == $coin['moneda']) {//Su nombre es el de alguna moneda
                    $flag = false;
                    break;
                }
            }

            //Si no es ninguna moneda puede que sea gold

            if ($flag == true && strtoupper($p[1]) == "GOLD") {
                $p[1] = "Gold";
                $flag = false;
            }

            if ($flag == false) {//Si es el nombre de alguna moneda
                //Sacamos cuanta moneda de esa tiene el pais
                $money = sql("SELECT " . $p[1] . " FROM money_pais WHERE idcountry = " . $votacion['id_pais']);

                //Si tienen tanta como quieren sacar
                if ($money >= $p[0]) {
                    //Se la quitamos al pais
                    sql("UPDATE money_pais SET " . $p[1] . " = " . $p[1] . " - " . $p[0] . " WHERE idcountry = " . $votacion['id_pais']);
                    //Se la ponemos al user
                    sql("UPDATE money SET " . $p[1] . " = " . $p[1] . " + " . $p[0] . " WHERE id_usuario= " . $p[2]);
                }
            }
            break;
        case 300:
            //Añadir la guerra
            $time = time();
            sql("INSERT INTO wars(id_pais_atacante,id_pais_defensor,tipo,estado,hora_inicio) VALUES(".$votacion['id_pais'].",".$p[0].",0,1,".$time.")");
            
            break;
    endswitch;

    if ($votacion['solved'] == 0) {
        sql("UPDATE votaciones SET solved = 1 WHERE id_votacion = " . $votacion['id_votacion']);
        sql("UPDATE candidatos_elecciones SET solved = 1 WHERE id_votacion = " . $votacion['id_votacion']);
    }
}

function check_laws() {
    $time = time();
    $sql = sql2("SELECT id_votacion,tipo_votacion FROM votaciones WHERE solved = 0 AND fin < " . $time . " AND is_cargo = 0 AND (tipo_votacion >= 100 OR tipo_votacion = 2)");

    foreach ($sql as $vot) {
        if ($vot['tipo_votacion'] >= 100) {
            $si = sql("SELECT votos FROM candidatos_elecciones WHERE id_candidato = -1 AND id_votacion = " . $vot['id_votacion']);
            $no = sql("SELECT votos FROM candidatos_elecciones WHERE id_candidato = -2 AND id_votacion = " . $vot['id_votacion']);

            //Aqui se podrian cambiar las normas para que segun no se que pollas la votacion se ganara o perdiera peeeeeeeeeero ya para mas tarde xD

            if ($si >= $no) {//De momento mayoria simple :yao:
                apply_law($vot['id_votacion']);
            } else {//Obviamente aqui va que no xD
                apply_law($vot['id_votacion']);
            }
        } elseif ($vot['tipo_votacion'] == 2) {//Ejecutan automaticamente
            apply_law($vot['id_votacion']);
        }
    }
}

function rango($puntos) {
    global $txt;
    //De 0 a 14 puntos de combate
    if ($puntos >= 0 && $puntos < 15)
        return getString("rango_0");
    //A partir de 15 puntos de combate
    elseif ($puntos >= 15)
        return getString("rango_1");
}

function item2img($item) {//devuelve la imagen a partir de la id del item
    $imagen = sql("SELECT url_imagen_grande FROM items WHERE id_item='$item'");
    return "<img src='$imagen' />";
}

function reset_mail($mail) {
    $pin = sql("SELECT pin FROM settings");
    $token = md5($mail) + $pin;
    $link = "http://birthofnations.com/usuarios/recuperar.php?token=" . $token . "&mail=" . $mail;
    mail($mail, "Recuperacion password cuenta Birth of Nations", "El siguiente link es para resetear: $link ");
}

function reset_pass($mail, $token) {
    $pin = sql("SELECT pin FROM settings");
    $token_bueno = md5($mail) + $pin;

    if ($token != $token_bueno)
        return false;
    elseif ($token == $token_bueno)
        return true;
}

function new_password($password1, $password2, $mail) {
    if ($password1 != $password2)
        die("Password no coincide");
    elseif ($password1 == $password2) {
        echo "password cambiado correctamente";
        $nuevo_pass = md5($password1);
        sql("UPDATE usuarios SET password = '$nuevo_pass' WHERE email = '$mail'");
    }
}

//Para enviar la alerta
function send_alert($emisor, $receptor, $tipo, $r1) {
    sql("INSERT INTO alertas(id_emisor,id_receptor,tipo,r1,fecha) VALUES ('" . $emisor . "','" . $receptor . "','" . $tipo . "','" . $r1 . "', Now())");
}

//rfloor(12.12946321,2); //12.12 -- drop everything after the number of decimal places
function rfloor($real, $decimals = 2) {
    return substr($real, 0, strrpos($real, '.', 0) + (1 + $decimals));
}

function incidencia($usuario, $tipo, $respuesta) {
    sql("INSERT INTO incidencias(id_usuario, tipo, respuesta, hora) VALUES ('" . $usuario . "','" . $tipo . "','" . $respuesta . "', Now())");
}

?>
