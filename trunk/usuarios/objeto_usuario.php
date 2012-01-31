<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class usuario
{
    public $id_usuario;
    public $nick;
    public $exp;
    public $level;
    public $avatar;
    public $id_pais;
    public $id_region;
    public $id_nacionalidad;
    public $estoy_viajando;
    public $status;
    
    public $n_pais;
    public $n_region;
    public $n_nacionalidad;

    
    function usuario($id){
        $usuario = sql("SELECT * FROM usuarios WHERE id_usuario='$id'");
        if ($usuario==false)
            return false;
        
        $this->id_usuario = $id;
        $this->nick = $usuario['nick'];
        $this->exp = $usuario['exp'];
        $this->level = $usuario['level'];
        $this->salud = $usuario['salud'];
        $this->gold = sql("SELECT gold FROM money WHERE id_usuario='$id'");
        $this->status = $usuario['status'];
        $this->id_region = $usuario['id_region'];
        $this->id_pais = sql("SELECT idcountry FROM region WHERE idregion = " . $this->id_region);
        $this->id_nacionalidad = $usuario['id_nacionalidad'];
        $this->moneda = $usuario['moneda'];
        
        if($usuario['avatar']==null || $usuario['avatar']=="")
        $this->avatar = "http://birthofnations.com/images/no_avatar.gif";
            else
        $this->avatar = $usuario['avatar'];
            
        $this->n_pais = sql("SELECT name FROM country WHERE idcountry= '{$this->id_pais}'");
        $this->n_region = sql("SELECT name FROM region WHERE idregion = '{$this->id_region}'"); 
        $this->n_nacionalidad = sql("SELECT name FROM country WHERE idcountry = '{$this->id_nacionalidad}'");
        
        $this->id_empresa = $usuario['id_empresa'];
        
        if($this->level != $this->check_lvl())
            $this->set_lvl();
        
        //Se mira si esta viajando
        if($this->check_travel() == true)
            $this->estoy_viajando = true;
        else
            $this->estoy_viajando = false;
        
    }
    
    function soy_yo($mi_id)
    {
        if($this->id_usuario == $mi_id)
           return true;
        else
           return false;
    }
    function get_nick()
    {
        return $this->nick;
    }
    function get_url_avatar()
    {
        return $this->avatar;
    }
    function somos_amigos($mi_id)
    {
        $somos = sql("SELECT id_amigo2 FROM friends WHERE id_amigo1='$mi_id' AND id_amigo2='$this->id_usuario'");
        if($somos == true)
            return true;
        else
            return false;
                
    }
    function get_n_pais()
    {
        return $this->n_pais;
    }
    function get_n_region()
    {
        return $this->n_region;
    }
    function get_n_nacionalidad()
    {
        return $this->n_nacionalidad;
    }
    
    function check_lvl()
    {
        if($this->exp >= 0 && $this->exp <14)
            return 1;
        elseif($this->exp >= 14 && $this->exp <32)
            return 2;
        elseif($this->exp >= 32 && $this->exp <64)
            return 3;
        elseif($this->exp >= 64 && $this->exp <128)
            return 4;   
        elseif($this->exp >= 128 )//&& $this->exp <256 <-- Para cuando hayan mas lvls
            return 5;         
    }
    
    function set_lvl()
    {
        $nuevo_lvl = $this->check_lvl();
        sql("UPDATE usuarios SET level='$nuevo_lvl' WHERE id_usuario='$this->id_usuario'");
        $this->level = $nuevo_lvl;
        
        //Aqui se envia una alerta del nuevo lvl
        sql("INSERT INTO alertas(id_receptor, tipo, r1) VALUES ('$this->id_usuario','3','$nuevo_lvl')");
    }
    
    //Funcion para comprobar si esta viajando, si el viaje ha terminado se pone a null el temporizador
    function check_travel()
    {
        $time = time();
        $tiempo = sql("SELECT hora_final FROM viajes WHERE id_usuario='$this->id_usuario'");
        
        if($tiempo == NULL)
            return false;
        elseif($tiempo <= $time)    //Si ya ha pasado la hora, se pone a null el tiempo
        {
            $destino = sql("SELECT id_region_destino FROM viajes WHERE id_usuario='$this->id_usuario'");
            sql("UPDATE usuarios SET id_region = '$destino' WHERE id_usuario='$this->id_usuario'");
            sql("DELETE FROM viajes WHERE id_usuario='$this->id_usuario'");
            $this->del_status("v");
            $this->id_region = $destino;
            $this->id_pais = sql("SELECT idcountry FROM region WHERE idregion = " . $this->id_region);
            return false;
        }
        elseif($tiempo > $time)
            return true;
        
    }
    //Funcion para añadir al jugador un estado
    function add_status($status)
    {
        //Primero despedazamos los estados actuales
        $a_status = explode(",",$this->status);
        //Si el status que queremos añadir no esta, lo añadimos, sino return false
        if(in_array($status, $a_status) == false)
            {
                $a_status[] = "$status";
                $f_status = implode(",", $a_status);
                sql("UPDATE usuarios SET status ='$f_status' WHERE id_usuario = '$this->id_usuario'");
                $this->status=$a_status;
                return true;
            }
        else
            return false;
                
    }
    
    //Funcion para quitar un estado alterado al jugador
    function del_status($status)
    {
        //Primero despedazamos los estados actuales
        $a_status = explode(",",$this->status);        
        if(in_array($status, $a_status) == true)
        {
            unset($a_status[array_search($status, $a_status)]);
            $f_status = implode(",", $a_status);
            sql("UPDATE usuarios SET status ='$f_status' WHERE id_usuario = '$this->id_usuario'");
            $this->status=$f_status;
            return true;
        }
        else
            return false;
    }
    
     //Funcion para comprobar un estado alterado al jugador
    function check_status($status)
    {
        //Primero despedazamos los estados actuales
        $a_status = explode(",",$this->status);        
        if(in_array($status, $a_status) == true)
            return true;
        else
            return false;
    }   
    

}

?>
