<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_albumes extends CI_Controller {
    //AQUI SE CREAN LAS FUNCIONES PARA CARGAR LAS VISTAS Y LAS FUNCIONES PARA LAS LLAMADAS DE POST O GET ETC...
    // (TODO TIPO DE GESTIONES QUE NO SEAN DE LA BASE DE DATOS)
        
        public function __construct() {
            parent::__construct();
            $this->load->model('m_bdgaleria');
        }
        
        public function misAlbumes()
        {
            $this->load->view('v_cabecera');

            $datos['albumes']=$this->m_bdgaleria->albumes($this->session->userdata('usuario')->iduser);
            $this->load->view('v_albumes',$datos);

            $this->load->view('v_pie');
        }
        
        public function crearAlbum(){
            $this->load->view('v_cabecera');

            $datos['fotos']=$this->m_bdgaleria->fotos();
            $this->load->view('v_crear_album',$datos);

            $this->load->view('v_pie');
        }
        
        public function crear()
        {
            if(!isset($_POST['submit_album']))
            {
                redirect(base_url());
            }
            else
            {
                if(isset($_POST['fotos']) && count($_POST['fotos'])>0)
                    $this->m_bdgaleria->crearAlbum($_POST['titulo'],$_POST['fotos'],$this->session->userdata('usuario')->iduser);
            
                $this->misAlbumes();
            }
        }
        public function ver_album($idalbum)
        {
            //ANTES DE QUE SE VEA EL ALBUM BORRO EL CONTENIDO DE LA CARPETA DONDE CREA EL ZIP JUNTO A LA CARPETA,
            //YA QUE NO ME DEJARIA BORRARLO DESPUES DE HABER DESCARGADO EL ZIP
            //ASI SI QUIERE DESCARGAR LAS FOTOS TENDRA QUE CREAR LA CARPETA Y METER LAS FOTOS
            $imagenes = glob(''.realpath(dirname(__FILE__)).'/../../files/images/'.$idalbum.'/*');
            foreach($imagenes as $imagen){
                unlink($imagen);
            }
            rmdir(''.realpath(dirname(__FILE__)).'/../../files/images/'.$idalbum.'');
            
            
            $this->load->view('v_cabecera');

            $idfotos=$this->m_bdgaleria->idFotosAlbum($idalbum);
            $fotos=array ();
            foreach ($idfotos as $idfoto)
            {
                $fotos[] = $this->m_bdgaleria->buscarFoto($idfoto->idfoto);
            }
            $datos['fotos']=$fotos;
            $datos['album']=$this->m_bdgaleria->album($idalbum);
            $this->load->view('v_album',$datos);

            $this->load->view('v_pie');
        }
        
        public function borrar($idalbum)
        {           
            //LO PONGO AQUI TAMBIEN POR SI EL USUARIO DECIDE BORRAR EL ALBUM JUSTO DESPUES DE DARLE A DESCARGAR
            $imagenes = glob(''.realpath(dirname(__FILE__)).'/../../files/images/'.$idalbum.'/*');
            foreach($imagenes as $imagen){
                unlink($imagen);
            }
            rmdir(''.realpath(dirname(__FILE__)).'/../../files/images/'.$idalbum.'');
            
            
            $this->m_bdgaleria->borrarAlbum($idalbum);
            $this->misAlbumes();
        }
        
        public function descargar($idalbum,$titulo)
        {
            $idfotos=$this->m_bdgaleria->idFotosAlbum($idalbum);
            $fotos=array ();
            foreach ($idfotos as $idfoto)
            {
                $fotos[] = $this->m_bdgaleria->buscarFoto($idfoto->idfoto);
            }
            mkdir(''.realpath(dirname(__FILE__)).'/../../files/images/'.$idalbum);
            foreach ($fotos as $foto)
            {
                file_put_contents(''.realpath(dirname(__FILE__)).'/../../files/images/'.$idalbum.'/'.$foto->titulo.'.jfif', $foto->foto);
            }
            $this->load->library('zip');
            $this->zip->read_dir(''.realpath(dirname(__FILE__)).'/../../files/images/'.$idalbum.'/',FALSE);
            $this->zip->download(''.$titulo.'.zip');
        }
}

