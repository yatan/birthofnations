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
    public $avatar;
    public $id_pais;
    public $id_region;
    
    function usuario($id){
        $usuario = sql("SELECT * FROM usuarios WHERE id_usuario='$id'");
        if ($usuario==false)
            return false;
        
        $this->id_usuario = $id;
        $this->nick = $usuario['nick'];
        $this->exp = $usuario['exp'];
        $this->id_pais = $usuario['id_pais'];
        $this->id_region = $usuario['id_region'];
        
        
        if($usuario['avatar']==null)
        $this->avatar = "http://birthofnations.com/images/no_avatar.gif";
            else
        $this->avatar = $usuario['avatar'];
        
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
    
}

?>