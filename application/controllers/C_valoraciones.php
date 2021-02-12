<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_valoraciones extends CI_Controller {
    //AQUI SE CREAN LAS FUNCIONES PARA CARGAR LAS VISTAS Y LAS FUNCIONES PARA LAS LLAMADAS DE POST O GET ETC...
    // (TODO TIPO DE GESTIONES QUE NO SEAN DE LA BASE DE DATOS)
        
        public function __construct() {
            parent::__construct();
            $this->load->model('m_bdgaleria');
        }
        
	public function cambionota($idval)
	{
            if(!isset($_POST['submit_cambio_val']))
            {
                redirect(base_url());
            }
            else
            {
                $this->m_bdgaleria->cambiarValoracion($idval,$_POST['nuevanota']);
                redirect('c_galeria/info/'.$this->session->flashdata('idfoto'));
            }
            
	}
        
        public function valorarfoto()
        {
            if(!isset($_POST['submit_valorar_foto']))
            {
                redirect(base_url());
            }
            else
            {
                $idfoto=$this->session->flashdata('idfoto');
                $this->m_bdgaleria->insertarValoracion($_POST['nota'],$idfoto,$this->session->userdata('usuario')->iduser);
                redirect('c_galeria/info/'.$idfoto);
            }
        }
        
        public function comentario()
        {
            if(!isset($_POST['submit_comentario']))
            {
                redirect(base_url());
            }
            else
            {
                $idfoto=$this->session->flashdata('idfoto');
                $fecha_actual = date("Y-m-d H:i:00",time());
                $this->m_bdgaleria->insertarComentario($_POST['comentario'],$idfoto,$this->session->userdata('usuario')->iduser,$fecha_actual);
                redirect('c_galeria/info/'.$idfoto);
            }
        }
}

