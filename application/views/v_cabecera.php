<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="<?=base_url()?>/css/stylesheet.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="header"><h1>GALERIA REDOUTPUTS</h1></div>
        
        <div id="menu">
            <a href="<?=base_url()?>">Galeria </a>
            <?php
                if($this->session->userdata('usuario'))
                {
                    echo "<a href='".site_url()."/c_registro/logout'>Log out </a>";
                    echo "<a href='".site_url()."/c_galeria/propias'>Mis fotos </a>";
                    echo "<a href='".site_url()."/c_galeria/subirFoto'>Subir foto </a>";
                    echo "<a href='".site_url()."/c_albumes/misAlbumes'>Mis albumes</a>"; 
                }
                else
                {
                    echo "<a href='".site_url()."/c_registro/login'>Log in </a>";
                    echo "<a href='".site_url()."/c_registro/registro'>Registrarse </a>";
                }
            ?>
        </div>
        
        <div id="container">
        
            <div id="main">
                            