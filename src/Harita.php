<?php
namespace Ihyme\TapuKadastro;
class Harita {

	function haritadaGoster($tasinmaz_no)
	    {
        try {

            $koordinat = "";
            $jsonData = file_get_contents('https://cbsservis.tkgm.gov.tr/megsiswebapi.v3/api/zemin/'.$tasinmaz_no);

            $data = json_decode($jsonData);
            $dz = $data->geometry->coordinates;
            foreach ($dz as  $y) {
                foreach ($y as $x )
                {
                    $koordinat .="[".$x[1].",".$x[0]."],";
                }
            }

            $harita =["x"=>$data->geometry->coordinates[0][0][1],"y"=>$data->geometry->coordinates[0][0][0]];


        }
        catch (\ErrorException $e)
        {
            $harita = ["x"=>0,"y"=>0];
            $koordinat = '[0.00000,0.000000]';
        }

            return $this->htmlOlustur($harita, $koordinat);

        }




    function htmlOlustur($harita,$koordinat){

        return <<<EOL
                <!DOCTYPE html>
                <html lang="tr">
                <head>
                    <meta charset="UTF-8">
                    <title></title>
                    <script src="https://api-maps.yandex.ru/2.1/?apikey=8c9ff5f5-fce1-41de-99ff-5eb6bdab3776&lang=en_US" type="text/javascript"></script>
                    <script type="text/javascript">
                        ymaps.ready(init);
                        var myMap;

                        function init() {
                            myMap = new ymaps.Map("map", {
                                center: [ $harita[x] , $harita[y] ],
                                zoom: 17,
                                type: 'yandex#satellite',
                                controls: ["zoomControl", "fullscreenControl"]

                            });
                            var myPolygon = new ymaps.Polygon([
                                    [
                                        $koordinat
                                    ]

                                ],
                                // Defining properties of the geo object.
                                {
                                    // The contents of the balloon.
                                    balloonContent: "Aradığınız Yer"
                                }, {
                                    /**
                                     * Describing the geo object options.
                                     * Fill color.
                                     */
                                    fillImageHref: 'https://www.transparenttextures.com/patterns/3px-tile.png',
                                    // Type of background fill.
                                    fillMethod: 'stretch',
                                    // Hiding the stroke.
                                    stroke: true
                                }
                            );
                            myMap.geoObjects.add(myPolygon);

                        }
                    </script>
                    <style>
                        body,html{

                            padding:0;
                            margin:0;
                            height:100%;
                        }
                        #map{
                            width:100%;
                            height:100vh;
                        }
                    </style>
                </head>
                <body>
                <div id="map" style=" "></div>
                </body>
                </html>
                EOL;


    }
}
