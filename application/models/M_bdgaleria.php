<?php
class M_bdgaleria extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    //AQUI SE CREAN LAS LLAMADAS A LA BASE DE DATOS
    
    public function fotos()
    {
        $sql="SELECT idfoto, titulo, foto, iduser, fecha FROM fotos";
        $rs=$this->db->query($sql);
        return $rs->result();
    }
    
    public function fotosUsuario($iduser)
    {
        $sql="SELECT idfoto, titulo, foto, iduser, fecha FROM fotos WHERE iduser='$iduser'";
        $rs=$this->db->query($sql);
        return $rs->result();
    }
    
    public function devolverUsuario($username)
    {
        $sql="SELECT iduser, nombre, apellidos, username, password, correo, activo FROM usuarios WHERE username='$username'";
        $rs=$this->db->query($sql);
        return $rs->result();
    }
    
    public function foto($idfoto)
    {
        $sql="SELECT idfoto, titulo, foto, iduser, fecha FROM fotos WHERE idfoto=$idfoto";
        $rs=$this->db->query($sql);
        return $rs->result();
    }
    
    public function todasNotas()
    {
        $sql="SELECT idval, valoracion, idfoto, iduser FROM valoraciones";
        $rs=$this->db->query($sql);
        return $rs->result();
    }
    
    public function notas($idfoto)
    {
        $sql="SELECT idval, valoracion, idfoto, iduser FROM valoraciones WHERE idfoto=$idfoto";
        $rs=$this->db->query($sql);
        return $rs->result();
    }
    
    public function usuarios()
    {
        $sql="SELECT iduser, nombre, apellidos, username, password, correo, activo FROM usuarios";
        $rs=$this->db->query($sql);
        return $rs->result();
    }
    
    public function comentarios($idfoto)
    {
        $sql="SELECT idcomentario, comentario, fechacom, idfoto, iduser FROM comentarios WHERE idfoto=$idfoto";
        $rs=$this->db->query($sql);
        return $rs->result();
    }
    
    public function cambiarValoracion($idval,$val)
    {
        $sql="UPDATE valoraciones SET valoracion = $val WHERE idval = $idval";
        $this->db->query($sql);
        return true;
    }
    public function insertarValoracion($val,$idfoto,$iduser)
    {
        $sql="INSERT INTO valoraciones (idval, valoracion, idfoto, iduser) VALUES (NULL,$val,$idfoto,$iduser)";
        $this->db->query($sql);
        return true;
    }
    
    public function borrarFoto($idfoto)
    {
        $sql="DELETE FROM fotalb WHERE idfoto=$idfoto";
        $this->db->query($sql);
        $sql="DELETE FROM comentarios WHERE idfoto=$idfoto";
        $this->db->query($sql);
         $sql="DELETE FROM valoraciones WHERE idfoto=$idfoto";
        $this->db->query($sql);
         $sql="DELETE FROM fotos WHERE idfoto=$idfoto";
        $this->db->query($sql);
        return true;
    }
    
    public function registrarUsuarioInactivo($nombre,$apellido,$username,$pass,$mail)
    {
        $sql="INSERT INTO usuarios (iduser, nombre, apellidos, username, password, correo, activo) VALUES (NULL,'$nombre','$apellido','$username','$pass','$mail',0)";
        $this->db->query($sql);
        return true;
        
    }
    
    public function activarUsuario($username)
    {
        $sql="UPDATE usuarios SET activo = 1 WHERE username = '$username'";
        $this->db->query($sql);
        return true;
    }
    
    public function subirFoto($titulo, $imagen, $iduser, $fecha)
    {
        $sql="INSERT INTO fotos (idfoto, titulo, foto, iduser, fecha) VALUES (NULL,'$titulo','$imagen',$iduser,'$fecha')";
        $this->db->query($sql);
        return true;
    }
    public function insertarComentario($comentario,$idfoto,$iduser,$fecha)
    {
        $sql="INSERT INTO comentarios (idcomentario, comentario, fechacom, idfoto, iduser) VALUES (NULL,'".html_escape($comentario)."','".html_escape($idfoto)."',$idfoto,$iduser)";
        $this->db->query($sql);
        return true;
    }
    
    public function cambiarTitulo($titulonuevo,$idfoto)
    {
        $sql="UPDATE fotos SET titulo = '".html_escape($titulonuevo)."' WHERE idfoto = ".html_escape($idfoto)."";
        $this->db->query($sql);
        return true;
    }
    
    public function borrarComentario($idcomentario)
    {
        $sql="DELETE FROM comentarios WHERE idcomentario = $idcomentario";
        $this->db->query($sql);
        return true;
    }
    
    public function albumes($iduser)
    {
        $sql="SELECT idalbum, titulo, iduser FROM albumes WHERE iduser=$iduser";
        $rs=$this->db->query($sql);
        return $rs->result();
    }
    
    public function crearAlbum($titulo,$fotos,$iduser)
    {
        $sql="INSERT INTO albumes (idalbum,titulo,iduser) VALUES (null,'".html_escape($titulo)."',$iduser)";
        $this->db->query($sql);
        $idalbum=$this->db->insert_id();
        foreach ($fotos as $foto) {
            $sql="INSERT INTO fotalb (idalbum, idfoto) VALUES ($idalbum,$foto)";
            $this->db->query($sql);
        }
    }
    public function idFotosAlbum($idalbum)
    {
        $sql="SELECT idfoto FROM fotalb WHERE idalbum=$idalbum";
        $rs=$this->db->query($sql);
        return $rs->result();
    }
    public function album($idalbum){
        $sql="SELECT idalbum,titulo,iduser FROM albumes WHERE idalbum=$idalbum";
        $rs=$this->db->query($sql);
        return $rs->row();
    }
    public function buscarFoto($idfoto)
    {
        $sql="SELECT idfoto, titulo, foto, iduser, fecha FROM fotos WHERE idfoto=$idfoto";
        $rs=$this->db->query($sql);
        return $rs->row();
    }
    
    public function borrarAlbum($idalbum)
    {
        $sql="DELETE FROM fotalb WHERE idalbum=$idalbum";
        $this->db->query($sql);
        $sql="DELETE FROM albumes WHERE idalbum=$idalbum";
        $this->db->query($sql);
        return true;
    }
}



