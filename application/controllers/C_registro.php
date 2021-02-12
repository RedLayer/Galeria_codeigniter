<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_registro extends CI_Controller {
    //AQUI SE CREAN LAS FUNCIONES PARA CARGAR LAS VISTAS Y LAS FUNCIONES PARA LAS LLAMADAS DE POST O GET ETC...
    // (TODO TIPO DE GESTIONES QUE NO SEAN DE LA BASE DE DATOS)
        
        public function __construct() {
            parent::__construct();
            $this->load->model('m_bdgaleria');
        }
        
	public function login()
	{
           $this->load->view('v_cabecera');
           $this->load->view('v_login');
           $this->load->view('v_pie');
	}
        
        public function comprobarlogin()
        {
            if(!isset($_POST['submit_login']))
            {
                redirect(base_url());
            }
            else
            {
                $this->load->library('password');
                $usuario=$this->m_bdgaleria->devolverUsuario($_POST['usuario']);
                if(count($usuario)!=1 || !$this->password->check($_POST['pass'], $usuario[0]->password))
                {
                    $this->session->set_flashdata('mensaje_login','Los datos introducidos no son correctos');
                    $this->login();
                }
                else
                {
                    if($usuario[0]->activo==0)
                    {
                        $this->session->set_flashdata('mensaje_login','El usuario no esta activo');
                        $this->login();
                    }
                    else
                    {
                        $this->session->set_userdata('usuario',$usuario[0]);
                        redirect(base_url());
                    }
                }
            }
        }
        
        public function logout()
        {
            $this->session->unset_userdata('usuario');
            redirect(base_url());
        }
        
        public function registro()
        {
            $this->load->view('v_cabecera');
            $this->load->view('v_registro');
            $this->load->view('v_pie');
        }
        
        public function comprobar_registro()
        {
            $this->load->library('password');
            $this->load->library('utilbusqueda');
            if(!isset($_POST['submit_registro']))
            {
                redirect(base_url());
            }
            else
            {
                $this->session->set_flashdata('nombre',$_POST['nombre']);
                $this->session->set_flashdata('apellido',$_POST['apellido']);
                $this->session->set_flashdata('user',$_POST['user']);
                $this->session->set_flashdata('mail',$_POST['mail']);
                if($_POST['nombre']=="" || $_POST['apellido']=="" || $_POST['user']=="" || $_POST['pass']=="" || $_POST['pass2']=="" || $_POST['mail']=="")
                {
                    $this->session->set_flashdata('mensaje_registro','Debes rellenar todos los campos');
                    $this->registro();
                }
                else
                {
                    if($_POST['pass']!=$_POST['pass2'])
                    {
                        $this->session->set_flashdata('mensaje_registro','Las contraseñas no coinciden');
                        $this->registro();
                    }
                    else
                    {
                        $usuarios=$this->m_bdgaleria->usuarios();
                        if(UtilBusqueda::buscarEnArray($usuarios, 'username', $_POST['user'])!=null)
                        {
                            $this->session->set_flashdata('mensaje_registro','El nombre de usuario ya existe, cambielo');
                            $this->registro();
                        }
                        else
                        {
                            $passcodif=$this->password->hash($_POST['pass']);
                            //MANDAR CORREO
                            $this->load->library('email');

                            $config = Array(
                                'protocol' => 'smtp',
                                'smtp_host' => 'smtp.googlemail.com',
                                'smtp_port' => 587,
                                'smtp_user' => 'dwes.ciudadjardin@gmail.com',
                                'smtp_pass' => 'dwes2019',
                                'mailtype'  => 'html', 
                                'charset'   => 'iso-8859-1',
                                'smtp_crypto' => 'tls'
                            );
                            $this->email->initialize($config);
                            $this->email->set_newline("\r\n");
                            $email_html ="<p>Usted esta recibiendo este correo para registrarse en Galeria RedOutputs<p>"
                                . "<a href='". site_url()."/c_registro/confirmacionRegistro/".$_POST['user']."'>Pincha aqui para verificar su registro</a>";
                            $this->email->from('pablof.a3f.4@gmail.com', 'Galeria RedOutputs');
                            $this->email->to(''.$_POST['mail'].'');
                            $this->email->subject('Registro de cuenta');
                            $this->email->message($email_html);
                            $this->email->set_mailtype("html");
                            if ($this->email->send())
                            {  
                                if($this->m_bdgaleria->registrarUsuarioInactivo($_POST['nombre'],$_POST['apellido'],$_POST['user'],$passcodif,$_POST['mail']))
                                {
                                    $this->session->set_flashdata('mensaje_registro','Le hemos enviado un correo para que confirme la cuenta');
                                    $this->registro();
                                }
                            }
                        }
                    }
                }
            }
        }
        
        public function confirmacionRegistro($username)
        {
            $this->m_bdgaleria->activarUsuario($username);
            $this->session->set_flashdata('mensaje_login','Ha verificado su usuario, pruebe a loguearse');
            $this->login();
        }
}

