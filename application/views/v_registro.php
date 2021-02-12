<?php
    echo "<h2>Registro</h2>";
    echo "<p style='color:red;'>".$this->session->flashdata('mensaje_registro')."</p>";
    echo "Para registrarse, rellena el siguiente formulario</br>";
    echo form_open('c_registro/comprobar_registro');
        echo "<table>";
            echo "<tr>";
                echo "<td>Nombre</td>";
                $datosnom = array(
                        'name'          => 'nombre',
                        'id'            => 'nombre',
                        'value'         => ''.$this->session->flashdata('nombre').''
                );
                echo "<td>". form_input($datosnom)."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Apellidos</td>";
                $datosape = array(
                        'name'          => 'apellido',
                        'id'            => 'apellido',
                        'value'         => ''.$this->session->flashdata('apellido').''
                );
                echo "<td>". form_input($datosape)."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Usuario</td>";
                $datosuser = array(
                        'name'          => 'user',
                        'id'            => 'user',
                        'value'         => ''.$this->session->flashdata('user').''
                );
                echo "<td>". form_input($datosuser)."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Password</td>";
                $datospass = array(
                    'name'          => 'pass',
                    'id'            => 'pass',
                );
                echo "<td>". form_password($datospass)."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Repite password</td>";
                $datospass2 = array(
                    'name'          => 'pass2',
                    'id'            => 'pass2',
                );
                echo "<td>". form_password($datospass2)."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Email</td>";
                $datosmail = array(
                    'name'          => 'mail',
                    'id'            => 'mail',
                    'value'         => ''.$this->session->flashdata('mail').''
                );
                echo "<td>". form_input($datosmail)."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td></td>";
                echo "<td>". form_submit('submit_registro','Registrarse')."</td>";
            echo "</tr>";
        echo "</table>";
    echo form_close();
?>

