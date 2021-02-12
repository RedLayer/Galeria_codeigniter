<?php

echo "<h2>Login</h2>";
    echo $this->session->flashdata('mensaje_login')."</br>";
    echo $this->session->flashdata('cuenta')."</br>";
    echo form_open('c_registro/comprobarlogin');
        echo "<table>";
            echo "<tr>";
                echo "<td>Usuario</td>";
                echo "<td>".form_input('usuario')."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Password</td>";
                echo "<td>". form_password('pass')."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td></td>";
                echo "<td>".form_submit('submit_login',"Log in")."</td>";
            echo "</tr>";
        echo "</table>";
    echo form_close();
    echo "<p>No tienes cuenta?<a href='".site_url()."/c_registro/registro'> Registrate!</a></p>";

