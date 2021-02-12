<?php
    $this->load->library("utilBusqueda");
    echo "<h2 style='text-align:center;'>".$foto->titulo."</h2>";
    if($this->session->userdata('usuario') && ($this->session->userdata('usuario')->iduser==0 || $foto->iduser==$this->session->userdata('usuario')->iduser))
    {
        $this->session->set_flashdata('idfoto',$foto->idfoto);
        echo form_open('c_galeria/cambioTitulo/'); 
        $datostit = array(
            'name'        => 'nuevotitulo',
            'id'          => 'nuevotitulo',
            'value'       => $foto->titulo,
        );
        echo "<div align='center'>".form_input($datostit) . " " . form_submit('submit_cambio_titulo','Cambiar titulo')."</div>";
        echo form_close();
    }
    echo "<p><img class='grid-gallery__image' src='data:image/jpeg;base64,".base64_encode($foto->foto)."' style='width:60%;height:60%;margin-left:auto;margin-right:auto;padding:10px;border:1px solid black;background-color:white;display:block;'></p>";
    if($this->session->userdata('usuario'))
    {
        echo "<h3>Valoraciones de los usuarios</h3>";
        $tiene=false;
        if(count($notas)!=0)
        {
            echo "<ul>";
            $idnota="";
            $valornota;
            foreach ($notas as $nota)
            {
                if($nota->iduser==$this->session->userdata('usuario')->iduser)
                {
                    $tiene=true;
                    $idnota=$nota->idval;
                    $valornota=$nota->valoracion;
                }
                echo "<li>".$nota->valoracion." - ".UtilBusqueda::buscarEnArray($usuarios, 'iduser', $nota->iduser)->username."</li>";
            }
            echo "</ul>";
        }
        else
        {
            echo "<p>Esta foto no tiene valoraciones</p>";
        }
        if($this->session->userdata('usuario')->iduser==0 || $foto->iduser==$this->session->userdata('usuario')->iduser)
        {
            if(count($notas)!=0)
            {
                $notamedia=0;
                foreach ($notas as $nota)
                {
                    $notamedia+=$nota->valoracion;
                }
                $notamedia=$notamedia/count($notas);
                echo "<h3>Nota media de tu foto</h3>";
                echo "<p><strong>$notamedia</strong></p>";
            }
        }
        else
        {
            $this->session->set_flashdata('idfoto',$foto->idfoto);
            if($tiene)
            {
                echo "<h3>Puedes cambiar tu valoracion en cualquier momento</h3>";
                echo form_open('c_valoraciones/cambionota/'.$idnota);
                $opciones = array(
                        '0'        => '0',
                        '1'        => '1',
                        '2'        => '2',
                        '3'        => '3',
                        '4'        => '4',
                        '5'        => '5',
                        '6'        => '6',
                        '7'        => '7',
                        '8'        => '8',
                        '9'        => '9',
                        '10'       => '10'
                );
                echo "<p>".form_dropdown('nuevanota', $opciones, ''.$valornota.'')." ".form_submit('submit_cambio_val','Cambiar valoracion')."</p>";
                echo form_close();
            }
            else
            {
                echo "<h3>Sientete libre de valorar la foto</h3>";
                echo form_open('c_valoraciones/valorarfoto');
                $opciones = array(
                        '0'        => '0',
                        '1'        => '1',
                        '2'        => '2',
                        '3'        => '3',
                        '4'        => '4',
                        '5'        => '5',
                        '6'        => '6',
                        '7'        => '7',
                        '8'        => '8',
                        '9'        => '9',
                        '10'       => '10'
                );

                echo "<p>".form_dropdown('nota', $opciones, '0')." ".form_submit('submit_valorar_foto','Valorar foto')."</p>";
                echo form_close();
            }
        }
        echo "<h3>Comentarios de la foto</h3>";
        if(count($comentarios)==0)
        {
            echo "<p>No hay comentarios en esta foto</p>";
        }
        else
        {
            $this->session->set_flashdata('idfoto',$foto->idfoto);
            echo "<div style='padding:5px;border:1px solid lightgray;width:80%;'>";
             foreach ($comentarios as $comentario)
             {
                 echo "<p>";
                 echo "<strong>".UtilBusqueda::buscarEnArray($usuarios, 'iduser', $comentario->iduser)->username."</strong>";
                 if($this->session->userdata('usuario')->iduser==0 || $foto->iduser==$this->session->userdata('usuario')->iduser)
                     echo "\t<a href='". site_url()."/c_galeria/borrarcomentario/".$comentario->idcomentario."'>"
                         . "<strong>(Borrar comentario)</strong></a>";
                 echo "<br>";
                 echo $comentario->comentario."\t\t(".date('d-m-Y',strtotime($comentario->fechacom)).")";
                 echo "</p>";
             }
             echo "</div>";
        }
        if($this->session->userdata('usuario')->iduser!=0 && $foto->iduser!=$this->session->userdata('usuario')->iduser)
        {
            echo "<h4>Comenta</h4>";
            echo form_open('c_valoraciones/comentario');
            $data = array(
                 'name'        => 'comentario',
                 'id'          => 'comentario',
                 'value'       => set_value('comentario'),
                 'rows'        => '10',
                 'cols'        => '50',
                 'style'       => 'width:50%',
                 'class'       => 'form-control'
             );

               echo form_textarea($data)."<br>";
               echo form_submit('submit_comentario',"Comentar");
               echo form_close();
        }
        else
        {
            echo "<h3>Borrar foto</h3>";
            echo form_open('c_galeria/borrarimagen/'.$foto->idfoto);
            echo "<p>".form_submit('submit_borrado','Borrar foto')."</p>";
            echo form_close();
        }
    }
    else
    {
        echo "<p style='text-align:center;'><a href='".site_url()."/c_registro/login'>Inicia sesión</a> o <a href='".site_url()."/c_registro/registro'>registrate</a> para poder comentar y valorar</p>";
    }
?>