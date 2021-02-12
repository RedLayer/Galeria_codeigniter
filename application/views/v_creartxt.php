<?php

echo "<h2>¿Quieres crear un archivo con los comentarios de tu foto antes de borrarlo?</h2>";
echo form_open('c_galeria/confirmarBorrado/'.$idfoto.'');
echo form_submit('si','Crear archivo y descargar'). "<p>".form_submit('borrar_foto','Borrar y volver')."</p>";
echo form_close();



