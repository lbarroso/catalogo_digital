<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Seleccionar almacen de tu ubicación </title>

    <!-- Font & Icon -->    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('mimity-retail/img/favicon/favicon.ico') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('mimity-retail/img/favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('mimity-retail/img/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('mimity-retail/img/favicon/touch-icon-iphone.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('mimity-retail/img/favicon/touch-icon-ipad.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('mimity-retail/img/favicon/touch-icon-iphone-retina.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('mimity-retail/img/favicon/touch-icon-ipad-retina.png') }}">    
        
    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('mimity-retail/plugins/swiper/swiper.min.css') }}">

    <!-- Main style -->
    <link rel="stylesheet" href="{{ asset('mimity-retail/dist/css/style.min.css') }}">

</head>
<body>

    <!-- TOP BAR -->
    <div class="topbar">
        <div class="container-fluid d-flex align-items-center">

            <nav class="nav mr-1 d-none d-md-flex text-white">
                <h1>APLICACI&Oacute;N CAT&Aacute;LOGO DIGITAL DE PRODUCTOS CON IM&Aacute;GENES</h1>
            </nav>

            <nav class="nav nav-circle d-none d-sm-flex">
                &nbsp;
            </nav>

            <div class="btn-group btn-group-toggle btn-group-sm ml-auto mr-1" data-toggle="buttons" hidden>
            &nbsp;
            </div>
            
            <nav class="nav nav-gap-x-1 ml-auto mr-1">
            &nbsp;
            </nav>
                
        </div>
    </div>
    <!-- /TOP BAR -->

    <div class="container-fluid my-3">
    <div class="row justify-content-center">
        <div class="col-md-auto d-flex justify-content-center">
            <div class="card shadow-sm" style="width: 350px">
                <div class="card-body">
                    <div class="modal fade modal-content-right modal-shown-static" id="signinModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content" id="signinContent">
                                <div class="text-center">
                                    <h3 class="modal-title">Iniciar una sesión</h3>
                                    <em>Seleccionar almacen de tu ubicación</em>
                                    <hr>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('setAlmcnt') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="regcve">SUCURSAL:</label>
                                            <select class="form-control" id="regcve" name="regcve">
                                                <option value="">SELECCIONAR UNA OPCION</option>
                                                <option value="47">OAXACA</option>
                                                <option value="43">NORTE CENTRO</option>
                                                <option value="45">OCCIDENTE</option>
                                                <option value="44">GOLFO</option>
                                                <option value="48">METROPOLITANA</option>
                                                <option value="50">SURESTE</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="uocve">UNIDAD OPERATIVA</label>
                                            <select name="uocve" id="uocve" class="form-control">
                                                <option value=""></option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="almcnt">ALMACEN</label>
                                            <select name="almcnt" id="almcnt" class="form-control">
                                                <option value=""></option>
                                            </select>
                                        </div>                        

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary"> Iniciar una sesión </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer"> 
                    <a href="http://10.101.21.24/catalogo/public/login" class="link"> Ir a administrar mi cat&aacute;logo  </a>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>
    document.getElementById('regcve').addEventListener('change', function() {
        const uocve = document.getElementById('uocve');
        uocve.innerHTML = ''; // Limpiar las opciones anteriores

        const regcveValue = this.value;

        if (regcveValue === '47') {
            uocve.options.add(new Option('SELECCIONAR UNA OPCION', ''));
            uocve.options.add(new Option('VALLES CENTRALES', '1'));
            uocve.options.add(new Option('ISTMO COSTA', '2'));
            uocve.options.add(new Option('MIXTECA', '3'));
        } else if (regcveValue === '43') {
            uocve.options.add(new Option('SELECCIONAR UNA OPCION', ''));
            uocve.options.add(new Option('CHIHUAHUA', '1'));
        } else if (regcveValue === '45') {
            uocve.options.add(new Option('SELECCIONAR UNA OPCION', ''));
            uocve.options.add(new Option('JALISCO', '1'));
        } else if (regcveValue === '44') {
            uocve.options.add(new Option('SELECCIONAR UNA OPCION', ''));
            uocve.options.add(new Option('TAMAULIPAS', '5'));
        }else if (regcveValue === '48') {
            uocve.options.add(new Option('SELECCIONAR UNA OPCION', ''));
            uocve.options.add(new Option('ESTADO DE MEXICO', '1'));
        }else if (regcveValue === '50') {
            uocve.options.add(new Option('SELECCIONAR UNA OPCION', ''));
            uocve.options.add(new Option('VILLAHERMOSA', '1'));
            uocve.options.add(new Option('TUXTLA', '2'));
            uocve.options.add(new Option('TAPACHULA', '3'));
        }

        // Limpiar el selector de Almacén cuando se cambia la Sucursal
        document.getElementById('almcnt').innerHTML = '';
    });

    document.getElementById('uocve').addEventListener('change', function() {
        const almRural = document.getElementById('almcnt');
        almRural.innerHTML = ''; // Limpiar las opciones anteriores

        const regcveValue = document.getElementById('regcve').value;
        const uocveValue = this.value;

        if (regcveValue === '47' && uocveValue === '1') {
            almRural.options.add(new Option('ALMACEN AYUTLA MIXES', '2010'));
            almRural.options.add(new Option('ALMACEN CUAJIMOLOYAS', '2014'));
            almRural.options.add(new Option('ALMACEN DE VALLES CENTRALES', '2039'));
            almRural.options.add(new Option('ALMACEN IXTLAN DE JUAREZ', '2017'));
            almRural.options.add(new Option('ALMACEN MAGDALENA OCOTLAN', '2020'));
            almRural.options.add(new Option('ALMACEN MATATLAN', '2031'));
            almRural.options.add(new Option('ALMACEN SAN ANDRES HIDALGO', '2024'));
            almRural.options.add(new Option('ALMACEN SAN JOSE EL CHILAR', '2025'));
            almRural.options.add(new Option('ALMACEN SAN PEDRO JUCHATENGO', '2026'));
            almRural.options.add(new Option('ALMACEN SANTA MARIA LACHIXIO', '2029'));
            almRural.options.add(new Option('ALMACEN TAMAZULAPAN', '2033'));
            almRural.options.add(new Option('ALMACEN TEOTITLAN', '2036'));
        } else if (regcveValue === '47' && uocveValue === '2') {
            almRural.options.add(new Option('ALMACEN MORRO MAZATAN', '2021'));
            almRural.options.add(new Option('ALMACEN PALOMARES', '2022'));
            almRural.options.add(new Option('ALMACEN RURAL EL TOMATAL', '2015'));
            almRural.options.add(new Option('ALMACEN RURAL HUAXPALTEPEC', '2027'));
            almRural.options.add(new Option('ALMACEN RURAL LOS IDEALES', '2019'));
            almRural.options.add(new Option('ALMACEN RURAL NILTEPEC', '2032'));
            almRural.options.add(new Option('ALMACEN RURAL PUEBLO NUEVO', '2023'));
            almRural.options.add(new Option('ALMACEN RURAL REFORMA', '2018'));
            almRural.options.add(new Option('ALMACEN STGO. LAOLLAGA', '2030'));
            almRural.options.add(new Option('SANTA MARIA HUATULCO', '2028'));
        } else if (regcveValue === '47' && uocveValue === '3') {
            almRural.options.add(new Option('ALMACEN CHALCATONGO DE HGO.', '2011'));
            almRural.options.add(new Option('ALMACEN COIXTLAHUACA', '2012'));
            almRural.options.add(new Option('ALMACEN CONSTANCIA DEL ROSARIO', '2013'));
            almRural.options.add(new Option('ALMACEN HUAJOLOTITLAN', '2016'));
            almRural.options.add(new Option('ALMACEN TACACHE DE MINA', '2034'));
            almRural.options.add(new Option('ALMACEN TECOMAXTLAHUACA', '2035'));
            almRural.options.add(new Option('ALMACEN TLAXIACO', '2037'));
            almRural.options.add(new Option('ALMACEN YANHUITLAN', '2038'));
            almRural.options.add(new Option('ALMACEN TLAXIACO', '2037'));

        }

        if (regcveValue === '43' && uocveValue === '1') {
            almRural.options.add(new Option('ALMACEN BAHUICHIVO', '810'));
            almRural.options.add(new Option('ALMACEN BUENAVENTURA', '811'));
            almRural.options.add(new Option('ALMACEN EL VERGEL', '813'));
            almRural.options.add(new Option('ALMACEN GUACHOCHI', '814'));
            almRural.options.add(new Option('ALMACEN MADERA', '815'));
            almRural.options.add(new Option('ALMACEN TOMOCHI', '816'));
            almRural.options.add(new Option('ALMACEN VALLE DE ALLENDE', '817'));

        } 

        if (regcveValue === '45' && uocveValue === '1') {
            almRural.options.add(new Option('ALMACEN COLIMA', '1418'));
            almRural.options.add(new Option('ALMACEN EL TUITO', '1411'));
            almRural.options.add(new Option('ALMACEN SAN CLEMENTE', '1415'));
            almRural.options.add(new Option('ALMACEN VALLE DE GUADALUPE', '1416'));
            almRural.options.add(new Option('ALMACEN ZAPOTLAN DEL REY', '1417'));
            almRural.options.add(new Option('ALMACEN COCULA', '1410'));
            almRural.options.add(new Option('ALMACEN HUESCALAPA', '1412'));
            almRural.options.add(new Option('ALMACEN LA CONCHA', '1401'));
            almRural.options.add(new Option('ALMACEN LO DE TERESA', '1414'));
            almRural.options.add(new Option('ALMACEN MARUATA', '611'));

        } 

        if(regcveValue === '44'){
            almRural.options.add(new Option('ALMACEN SOTO LA MARINA', '2812'));
            almRural.options.add(new Option('ALMACEN TULA', '2813'));
            almRural.options.add(new Option('ALMACEN FRANCISCO VILLA', '2811'));
            almRural.options.add(new Option('ALMACEN VICTORIA', '2814'));
            almRural.options.add(new Option('ALMACEN CHAPULTEPEC', '2810'));
        }

        if(regcveValue === '48'){
            almRural.options.add(new Option('ALMACEN TENANGO DEL VALLE', '1515'));
        }        


        if (regcveValue === '50' && uocveValue === '1') {
            almRural.options.add(new Option('ALMACEN TENOSIQUE', '2718'));
            almRural.options.add(new Option('ALMACEN SANTA CRUZ', '2716'));
            almRural.options.add(new Option('ALMACEN JALPA DE MENDEZ', '2714'));
            almRural.options.add(new Option('ALMACEN TULIPAN', '2719'));
            almRural.options.add(new Option('ALMACEN MACUSPANA', '2715'));
            almRural.options.add(new Option('ALMACEN CHONTALPA', '2713'));
            almRural.options.add(new Option('ALMACEN TACOTALPA', '2717'));
            almRural.options.add(new Option('ALMACEN CHABLE', '2712'));
            almRural.options.add(new Option('ALMACEN VILLA ALDAMA', '2720'));
            almRural.options.add(new Option('ALMACEN CARDENAS', '2710'));
            almRural.options.add(new Option('ALMACEN CENTRO', '2711'));
        } else if (regcveValue === '50' && uocveValue === '2') {
            almRural.options.add(new Option('ALMACEN BENEMENTO', '711'));
            almRural.options.add(new Option('ALMACEN BOCHIL', '712'));
            almRural.options.add(new Option('ALMACEN COPAINALA', '713'));
            almRural.options.add(new Option('ALMACEN ESPIRITU SANTO', '714'));
            almRural.options.add(new Option('ALMACEN JIQUIPILAS', '716'));
            almRural.options.add(new Option('ALMACEN LA CONCORDIA', '717'));
            almRural.options.add(new Option('ALMACEN LAS JOYAS', '718'));
            almRural.options.add(new Option('ALMACEN OCOSINGO', '720'));
            almRural.options.add(new Option('ALMACEN OXCHUC', '721'));
            almRural.options.add(new Option('ALMACEN PICHUCALCO', '723'));
            almRural.options.add(new Option('ALMACEN RIO CHANCALA', '725'));
            almRural.options.add(new Option('ALMACEN SAN JUAN CHAMULA', '726'));
            almRural.options.add(new Option('ALMACEN TENEJAPA', '728'));
            almRural.options.add(new Option('ALMACEN TUXTLA', '729'));
            almRural.options.add(new Option('ALMACEN VILLA CORZO', '732'));
            almRural.options.add(new Option('ALMACEN YAJALON', '733'));
            
        } else if (regcveValue === '50' && uocveValue === '3') {
            almRural.options.add(new Option('ALMACEN ACACOYAGUA', '710'));
            almRural.options.add(new Option('ALMACEN FRONTERA COMALAPA', '715'));
            almRural.options.add(new Option('ALMACEN MAZAPA DE MADERO', '719'));
            almRural.options.add(new Option('ALMACEN PAREDON', '722'));
            almRural.options.add(new Option('ALMACEN PIJIJIAPAN', '724'));
            almRural.options.add(new Option('ALMACEN TAPACHULA', '727'));
            almRural.options.add(new Option('ALMACEN TUXTLA CHICO', '730'));
            almRural.options.add(new Option('ALMACEN TUZANTAN', '731'));

        }


    });
</script>



</body>

</html>
