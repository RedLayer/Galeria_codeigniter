<?php

if(!$this->session->userdata('usuario'))
{
    redirect(base_url());
}
else
{
    echo $this->session->flashdata('error_subida')."</br>";
    echo "<form method='POST' action='".site_url()."/c_galeria/confirmarFoto' enctype='multipart/form-data'>";
        echo "<table>";
            echo "<tr>";
                echo "<td>Título de la foto</td>";
                echo "<td><input type='input' name='titulo'/>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Imagen a subir</td>";
                echo "<td><input type='file' name='foto'/>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><input type='submit' name='subir_foto' value='Subir'</td>";
                echo "<td></td>";
            echo "</tr>";
        echo "</table>";
    echo "</form>";
}