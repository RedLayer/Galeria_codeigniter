
<?php
        echo "<h2 style='text-align:center'>".$album->titulo."</h2>";
        if(count($fotos)>0)
        {
            echo "<div class='grid-gallery'>";

                foreach ($fotos as $foto)
                {
                        echo "<a class='grid-gallery__item' href='". site_url()."/c_galeria/info/".$foto->idfoto."'>";
                            echo "<img class='grid-gallery__image' src='data:image/jpeg;base64,".base64_encode($foto->foto)."'>";
                        echo "</a>";
                }

            echo "</div>";

            echo "<div style='margin-top:20px;'>";
                echo "<a style='text-align:center;width:200px;height:20px;color:white;background-color:#750707;border:1px solid black;display:block;margin:0 auto;' href='". site_url()."/c_albumes/descargar/".$album->idalbum."/".$album->titulo."'>Descargar Album</a>";
            echo "</div>";
        }
        else
        {
            echo "<p>No hay fotos en este album</p>";
        }
        echo "<div style='margin-top:20px;'>";
            echo "<a style='text-align:center;width:200px;height:20px;color:white;background-color:#750707;border:1px solid black;display:block;margin:0 auto;' href='". site_url()."/c_albumes/borrar/".$album->idalbum."'>Borrar Album</a>";
        echo "</div>";



