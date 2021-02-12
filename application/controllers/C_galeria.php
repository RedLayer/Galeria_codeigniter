<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_galeria extends CI_Controller {
    //AQUI SE CREAN LAS FUNCIONES PARA CARGAR LAS VISTAS Y LAS FUNCIONES PARA LAS LLAMADAS DE POST O GET ETC...
    // (TODO TIPO DE GESTIONES QUE NO SEAN DE LA BASE DE DATOS)
        
        public function __construct() {
            parent::__construct();
            $this->load->model('m_bdgaleria');
        }
        
	public function index()
	{           
            $this->load->view('v_cabecera');

            $datos['fotos']=$this->m_bdgaleria->fotos();
            $this->load->view('v_indice',$datos);

            $this->load->view('v_pie');
	}
        
        public function propias()
        {
            $this->load->view('v_cabecera');

            $datos['fotos']=$this->m_bdgaleria->fotosUsuario($this->session->userdata('usuario')->iduser);
            $datos['notas']=$this->m_bdgaleria->todasNotas();
            $this->load->view('v_misfotos',$datos);

            $this->load->view('v_pie');
        }
        
        public function info($idfoto)
        {
            $this->load->view('v_cabecera');

            $datos['foto']=$this->m_bdgaleria->foto($idfoto)[0];
            $datos['notas']=$this->m_bdgaleria->notas($idfoto);
            $datos['usuarios']=$this->m_bdgaleria->usuarios();
            $datos['comentarios']=$this->m_bdgaleria->comentarios($idfoto);
            $this->load->view('v_info',$datos);

            $this->load->view('v_pie');
        }
        
        public function cambioTitulo()
        {
            $idfoto=$this->session->flashdata('idfoto');
            if($_POST['nuevotitulo']!="")
            {
                $this->m_bdgaleria->cambiarTitulo($_POST['nuevotitulo'],$idfoto);
            }
            $this->info($idfoto);
        }
        
        public function borrarimagen($idfoto)
        {
            $this->load->view('v_cabecera');
            
            $datos['idfoto']=$idfoto;
            $this->load->view('v_creartxt',$datos);
            $this->load->view('v_pie');
        }
        
        public function confirmarBorrado($idfoto)
        {
            $this->load->helper('file');
            $this->load->library("utilBusqueda");
            if(isset($_POST['si']))
            {
                $usuarios=$this->m_bdgaleria->usuarios();
                $comentarios=$this->m_bdgaleria->comentarios($idfoto);
                if(count($comentarios)>0)
                {
                    unlink(''.realpath(dirname(__FILE__)).'/../../files/'.$idfoto.'.txt');
                    foreach ($comentarios as $comentario)
                    {
                       write_file(''.realpath(dirname(__FILE__)).'/../../files/'.$idfoto.'.txt', UtilBusqueda::buscarEnArray($usuarios, 'iduser', $comentario->iduser)->username."\n",'a');
                       write_file(''.realpath(dirname(__FILE__)).'/../../files/'.$idfoto.'.txt', $comentario->comentario."\n",'a');
                    }
                    $this->load->helper('download');
                    force_download(''.realpath(dirname(__FILE__)).'/../../files/'.$idfoto.'.txt', NULL);
                }
                else
                {
                    $this->borrarimagen($idfoto);
                }
            }
            if(isset($_POST['borrar_foto']))
            {
                $this->m_bdgaleria->borrarFoto($idfoto);
                redirect(base_url());
            }
        }
        
        public function subirFoto()
        {
            $this->load->view('v_cabecera');

            $this->load->view('v_subida');

            $this->load->view('v_pie');
        }
        
        public function confirmarFoto()
        {
            if(isset($_POST['subir_foto']))
            {
                if(is_uploaded_file($_FILES['foto']['tmp_name']))
                {
                    $file_size = $_FILES['foto']['size'];
                    if($file_size<16777215)
                    {
                        $formatos=array("jpeg","jfif","exif","tiff","gif","bmp","png","jpg","ppm","pgm","webp","bat","svg");
                        $extension= explode(".", $_FILES['foto']['name']);
                        $fecha_actual = date("Y-m-d H:i:00",time());
                        if(in_array($extension[(count($extension))-1], $formatos))
                        {
                            if($_POST['titulo']=="")
                            {
                                $this->session->set_flashdata('error_subida','Falta titulo de la foto');
                                $this->subirFoto(); 
                            }
                            else
                            {
                                $this->m_bdgaleria->subirFoto($_POST['titulo'],addslashes(file_get_contents($_FILES['foto']['tmp_name'])),$this->session->userdata('usuario')->iduser,$fecha_actual);
                                redirect(base_url());
                            }
                        }
                        else
                        {
                            $this->session->set_flashdata('error_subida','El archivo subido no es una imagen');
                            $this->subirFoto();
                        }
                    }
                }
                else
                {
                    $this->session->set_flashdata('error_subida','No se ha podido subir la imagen');
                    $this->subirFoto();
                }

            }
            else
            {
                redirect(base_url());
            }
        }
        
        public function borrarComentario($idcomentario)
        {
            $idfoto=$this->session->flashdata('idfoto');
            $this->m_bdgaleria->borrarComentario($idcomentario);
            redirect(''. site_url().'/c_galeria/info/'.$idfoto.'');
        }
}

