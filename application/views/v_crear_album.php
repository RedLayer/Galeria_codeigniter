        <?php
            echo form_open('c_albumes/crear');
            echo "<div style='margin-bottom:15px;'>";
                $data = array(
                    'name'          => 'titulo',
                    'placeholder'   => 'Titulo del album',
                    'style'         => 'position:relative;left:40%;'
                );
                echo form_input($data);
            echo "</div>";
            echo "<div style='margin-left:50px;'>";
                foreach ($fotos as $foto)
                {
                    $data = array(
                            'name'          => 'fotos[]',
                            'value'         => ''.$foto->idfoto.'',
                            'style'         => 'position:relative;bottom:15px;'
                    );
                    echo "<div style='display:inline-block;width:245px;height:230px;'>".form_checkbox($data);
                    echo "<img style='width:30%' src='data:image/jpeg;base64,".base64_encode($foto->foto)."'>";
                    echo "<span style='position:relative;bottom:15px;'> ".$foto->titulo."</span></div>";
                }
            echo "</div>";
            echo "<div>";
                $data = array(
                    'name'          => 'submit_album',
                    'value'         => 'Crear album',
                    'style'         => 'text-align:center;width:200px;height:20px;color:white;background-color:#750707;border:1px solid black;display:block;margin:0 auto;'

                );
                echo form_submit($data);
            echo "</div>";
            echo form_close();
        ?>

