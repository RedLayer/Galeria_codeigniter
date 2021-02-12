            <?php
                if(count($albumes)==0)
                {
                    echo "<p>No tienes albumes creados</p>";
                }
                else
                {
                    echo "<div>";
                        foreach ($albumes as $album)
                        {
                            echo "<a style='display:inline-block;width:120px;height:100px;border:1px solid black;text-align:center;font-weight:bold;background-color:#750707;color:white;margin-left:30px;' href='". site_url()."/c_albumes/ver_album/".$album->idalbum."'>";
                            echo "".$album->titulo."</a>";
                        }
                    echo "</div>";
                }
                echo "<div>";
                    echo "<a style='text-align:center;width:200px;height:20px;color:white;background-color:#750707;border:1px solid black;display:block;margin:0 auto;' href='". site_url()."/c_albumes/crearAlbum'>Crear album</a>";
                echo "</div>";
            ?>
