                <div class="grid-gallery">
                <?php
                    if(count($fotos)==0)
                    {
                        echo "<p>No tienes fotos subidas</p>";
                    }
                    else
                    {
                        foreach ($fotos as $foto)
                        {
                                echo "<a class='grid-gallery__item' href='". site_url()."/c_galeria/info/".$foto->idfoto."'>";
                                    echo "<img class='grid-gallery__image' src='data:image/jpeg;base64,".base64_encode($foto->foto)."'>";
                                    $contador=0;
                                    foreach ($notas as $nota)
                                    {
                                        if($nota->idfoto == $foto->idfoto)
                                        {
                                            $contador++;
                                        }
                                    }
                                    echo "<center>$contador valoraciones</center>";
                                echo "</a>";
                        }
                    }
                ?>
                </div>

