@extends('adminlte::page')

@section('title', 'Registrar nuevo usuario')

@section('content')
<br />

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form class="form-horizontal" role="form" method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Información del Usuario</h3>
                </div>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="identification">Cédula</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="identification" name="identification" maxlength="13">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="first_name">Nombres *</label>
                        <div class="col-sm-8">
                            <input type="text" onkeyup="mayusculas(this);" style="text-transform: capitalize;" class="form-control form-control-sm" id="first_name" name="first_name" maxlength="300" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="last_name">Apellidos *</label>
                        <div class="col-sm-8">
                            <input type="text" onkeyup="mayusculas(this);" style="text-transform: capitalize;" class="form-control form-control-sm" id="last_name" name="last_name" maxlength="300" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="alias">Alias</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="alias" name="alias" maxlength="300">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="gender">Genero *</label>
                        <div class="col-sm-8">
                            <select class="form-control form-control-sm" id="gender" name="gender" required>
                                <option>Seleccione</option>
                                <option value="femenino">Femenimo</option>
                                <option value="masculino">Masculino</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="date_of_birth">Fecha de nacimiento *</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control form-control-sm" id="date_of_birth" name="date_of_birth" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="phone">Celular</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone" maxlength="10">
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-- right column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Foto del Usuario</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <video muted="muted" id="video" style="width: 100%;"></video>
                            <canvas id="canvas" style="display: none;"></canvas>
                            <input id="photo_customer" type="hidden" name="photo" />
                        </div>
                        <div class="col-sm-3">
                            <select name="listaDeDispositivos" id="listaDeDispositivos" style="display: none;">
                            </select>
                            <p id="estado"></p>

                            <button class="btn btn-success" id="boton" type="button">
                                Tomar foto
                            </button>
                            <button class="btn btn-success" id="botonTomarNuevo" type="button" style="display: none;">
                                Nuevo foto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Pago</h3>
                </div>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="date_payment">Fecha de inscripción</label>
                        <div class="col-sm-4">
                            <input type="date" value="{{ date('Y-m-d') }}" class="form-control form-control-sm" id="date_payment" name="date" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="month_payment">Servicios</label>
                        <div class="col-sm-5">
                            <select class="custom-select form-control form-control-sm" id="payment_method_id" name="payment_method_id" required>
                                @foreach($paymentmethods as $item)
                                <option value="{{$item->id}}">{{$item->amount . ' ' .$item->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-4">Fecha mes próximo</label>
                        <span class="control-label col-sm-4" id="date_next_month">{{date('d/m/Y', strtotime(date('Y-m-d'). ' +1 month'))}}</span>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="amount_payment">Valor a pagar ($)</label>
                        <div class="col-sm-2">
                            <input type="number" value="20" min="10" class="form-control form-control-sm" id="amount_payment" name="amount" required>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- right column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <!-- Start Test Finger capute -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Reconcimiento dactilar</h3>
                </div>

                <div class="card-body">

                    <input id="finger" type="hidden" name="finger" />
                    <img id="FPImage1" alt="Fingerpint Image" height="300" width="210" align="center" src="{{ asset('images/Huella.jpg') }}">
                    <input class="btn btn-success" type="button" value="Click para escanear" onclick="captureFP()" />
                    <!-- <p id="result">.</p> -->
                    <!-- <OBJECT classid="CLSID: 6283f7ea-608c-11dc-8314-0800200c9a66" codebase="objSecuBSP.cab#version=1,4,0,0" height=0 width=0 id="objSecuBSP" name="objSecuBSP"> </OBJECT>
                    <input type="hidden" name="FIRTextData" id="FIRTextData">
                    User ID : <input type="text" name="UserID" id="UserID" size="20">
                    <p>
                        <input class="btn btn-success" type="button" value="Click para escanear" onclick="regist()" />
                    </p> -->
                </div>
            </div>
            <!-- End Test Finger capute -->

            <div class="modal-footer">
                <button class="btn btn-success" type="submit">
                    Guardar
                </button>
                <button class="btn btn-warning" type="button">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
    let service = undefined

    $('#identification').mask('0000000000')

    function mayusculas(e) {
        e.value = e.value.toUpperCase()
    }

    $('#date_payment').change(e => {
        e.preventDefault()

        if (service === undefined) {
            getService()
        }
        update()
    })

    $('#payment_method_id').change(e => {
        e.preventDefault()
        getService()
    })

    const update = () => {
        $('#date_next_month').text(sumMonth($('#date_payment').val(), service.months))
        $('#amount_payment').val(service.amount)
    }

    const getService = () => {
        $.ajax({
            type: 'GET',
            url: "{{url('admin/services')}}/" + $('#payment_method_id').val(),
            success: (res) => {
                service = res.paymentMethod
                update()
            },
            error: (err) => console.log(err)
        })
    }

    function sumMonth(date, val_sum) {

        let date_str = date.split("-")
        let month = parseInt(date_str[1])
        let sum = month + val_sum

        if (sum < 10) {
            // Suma mes
            date_str[1] = '0' + sum
        } else {
            if (sum <= 12) {
                // Suma mes
                date_str[1] = sum
            } else {
                // Suma año
                date_str[0] = parseInt(date_str[0]) + 1
                // Asigna el mes 1
                date_str[1] = '0' + (sum - 12)
            }
        }
        let new_ret = [date_str[2], date_str[1], date_str[0]]

        return new_ret.join('/')
    }

    /*
    Tomar una fotografía y guardarla en un archivo v3
    @date 2018-10-22
    @author parzibyte
    @web parzibyte.me/blog
*/
    function tieneSoporteUserMedia() {
        return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
    }

    function _getUserMedia() {
        return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
    }

    // Declaramos elementos del DOM
    const $video = document.querySelector("#video"),
        $canvas = document.querySelector("#canvas"),
        $boton = document.querySelector("#boton"),
        $botonTomarNuevo = document.querySelector("#botonTomarNuevo"),
        $estado = document.querySelector("#estado"),
        $listaDeDispositivos = document.querySelector("#listaDeDispositivos");

    // La función que es llamada después de que ya se dieron los permisos
    // Lo que hace es llenar el select con los dispositivos obtenidos
    const llenarSelectConDispositivosDisponibles = () => {

        navigator
            .mediaDevices
            .enumerateDevices()
            .then(function(dispositivos) {
                const dispositivosDeVideo = [];
                dispositivos.forEach(function(dispositivo) {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                if (dispositivosDeVideo.length > 0) {
                    // Llenar el select
                    dispositivosDeVideo.forEach(dispositivo => {
                        const option = document.createElement('option');
                        option.value = dispositivo.deviceId;
                        option.text = dispositivo.label;
                        $listaDeDispositivos.appendChild(option);
                        console.log("$listaDeDispositivos => ", $listaDeDispositivos)
                    });
                }
            });
    }

    (function() {
        // Comenzamos viendo si tiene soporte, si no, nos detenemos
        if (!tieneSoporteUserMedia()) {
            alert("Lo siento. Tu navegador no soporta esta característica");
            $estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
            return;
        }
        //Aquí guardaremos el stream globalmente
        let stream;


        // Comenzamos pidiendo los dispositivos
        navigator
            .mediaDevices
            .enumerateDevices()
            .then(function(dispositivos) {
                // Vamos a filtrarlos y guardar aquí los de vídeo
                const dispositivosDeVideo = [];

                // Recorrer y filtrar
                dispositivos.forEach(function(dispositivo) {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                // y le pasamos el id de dispositivo
                if (dispositivosDeVideo.length > 0) {
                    // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                    mostrarStream(dispositivosDeVideo[0].deviceId);
                }
            });

        const mostrarStream = idDeDispositivo => {
            _getUserMedia({
                    video: {
                        // Justo aquí indicamos cuál dispositivo usar
                        deviceId: idDeDispositivo,
                    }
                },
                function(streamObtenido) {
                    // Aquí ya tenemos permisos, ahora sí llenamos el select,
                    // pues si no, no nos daría el nombre de los dispositivos
                    llenarSelectConDispositivosDisponibles();

                    // Escuchar cuando seleccionen otra opción y entonces llamar a esta función
                    $listaDeDispositivos.onchange = () => {
                        // Detener el stream
                        if (stream) {
                            stream.getTracks().forEach(function(track) {
                                track.stop();
                            });
                        }
                        // Mostrar el nuevo stream con el dispositivo seleccionado
                        mostrarStream($listaDeDispositivos.value);
                    }

                    // Simple asignación
                    stream = streamObtenido;

                    // Mandamos el stream de la cámara al elemento de vídeo
                    $video.srcObject = stream;
                    $video.play();

                    //Escuchar el click del botón para tomar la foto
                    $boton.addEventListener("click", function() {

                        //Pausar reproducción
                        $video.pause();

                        //Obtener contexto del canvas y dibujar sobre él
                        let contexto = $canvas.getContext("2d");
                        $canvas.width = $video.videoWidth;
                        $canvas.height = $video.videoHeight;
                        contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

                        // let foto = $canvas.toDataURL(); //Esta es la foto, en base 64

                        $('#photo_customer').val($canvas.toDataURL())
                        $('#botonTomarNuevo').css("display", "inline-block")
                        $('#boton').css("display", "none")

                        //Reanudar reproducción
                        // $video.play();
                    });

                    //Escuchar el click del botón para tomar la foto
                    $botonTomarNuevo.addEventListener("click", function() {
                        $('#boton').css("display", "inline-block")
                        $('#botonTomarNuevo').css("display", "none")

                        //Reanudar reproducción
                        $video.play();
                    });
                },
                function(error) {
                    console.log("Permiso denegado o error: ", error);
                    $estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
                });
        }
    })();

    // Start test finger

    function captureFP() {
        CallSGIFPGetData(SuccessFunc, ErrorFunc);
    }

    /* 
        This functions is called if the service sucessfully returns some data in JSON object
     */
    function SuccessFunc(result) {
        if (result.ErrorCode == 0) {
            /* 	Display BMP data in image tag
                BMP data is in base 64 format 
            */
            if (result != null && result.BMPBase64.length > 0) {
                document.getElementById("FPImage1").src = "data:image/bmp;base64," + result.BMPBase64;
                $('#finger').val(result.TemplateBase64)
            }
        } else {
            alert("Fingerprint Capture Error Code:  " + result.ErrorCode + ".\nDescription:  " + ErrorCodeToString(result.ErrorCode) + ".");
        }
    }

    function ErrorFunc(status) {

        /* 	
            If you reach here, user is probabaly not running the 
            service. Redirect the user to a page where he can download the
            executable and install it. 
        */
        alert("Check if SGIBIOSRV is running; Status = " + status + ":");

    }

    function CallSGIFPGetData(successCall, failCall) {
        // 8.16.2017 - At this time, only SSL client will be supported.
        var uri = "https://localhost:8443/SGIFPCapture";

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                fpobject = JSON.parse(xmlhttp.responseText);
                successCall(fpobject);
            } else if (xmlhttp.status == 404) {
                failCall(xmlhttp.status)
            }
        }
        var params = "Timeout=" + "10000";
        params += "&Quality=" + "50";
        params += "&licstr=" + encodeURIComponent(secugen_lic);
        params += "&templateFormat=" + "ISO";
        params += "&imageWSQRate=" + "0.75";
        console.log
        xmlhttp.open("POST", uri, true);
        xmlhttp.send(params);

        xmlhttp.onerror = function() {
            failCall(xmlhttp.statusText);
        }
    }

    // nice global area, so that only 1 location, contains this information
    // var secugen_lic = "hE/78I5oOUJnm5fa5zDDRrEJb5tdqU71AVe+/Jc2RK0=";   // webapi.secugen.com
    var secugen_lic = "";

    function ErrorCodeToString(ErrorCode) {
        var Description;
        switch (ErrorCode) {
            // 0 - 999 - Comes from SgFplib.h
            // 1,000 - 9,999 - SGIBioSrv errors 
            // 10,000 - 99,999 license errors
            case 51:
                Description = "System file load failure";
                break;
            case 52:
                Description = "Sensor chip initialization failed";
                break;
            case 53:
                Description = "Device not found";
                break;
            case 54:
                Description = "Fingerprint image capture timeout";
                break;
            case 55:
                Description = "No device available";
                break;
            case 56:
                Description = "Driver load failed";
                break;
            case 57:
                Description = "Wrong Image";
                break;
            case 58:
                Description = "Lack of bandwidth";
                break;
            case 59:
                Description = "Device Busy";
                break;
            case 60:
                Description = "Cannot get serial number of the device";
                break;
            case 61:
                Description = "Unsupported device";
                break;
            case 63:
                Description = "SgiBioSrv didn't start; Try image capture again";
                break;
            default:
                Description = "Unknown error code or Update code to reflect latest result";
                break;
        }
        return Description;
    }
    // End test finger

    // New Start test finger

    function regist() {
        var err, payload
        // Check ID is not NULL 
        // if (document.MainForm.UserID.value == '') {
        //     alert('Please enter user id !');
        //     return (false);
        // }
        try {
            // Exception handling 
            // Open device [AUTO_DETECT] 
            // You must open device before enrollment
            DEVICE_FDU03 = 4;
            DEVICE_FDU04 = 5;
            DEVICE_FDU05 = 6;
            DEVICE_FDU06 = 7;
            DEVICE_FDU07 = 8;
            DEVICE_FDU07A = 9;
            DEVICE_FDU08 = 10;
            DEVICE_FDU06P = 13;
            DEVICE_FDU08A = 17;
            DEVICE_FDU09A = 18;
            DEVICE_FDU10A = 19;
            DEVICE_AUTO_DETECT = 255;

            document.objSecuBSP.OpenDevice(DEVICE_AUTO_DETECT);
            err = document.objSecuBSP.ErrorCode;
            if (err != 0) {
                alert('Device open failed !');
                return (false);
            }
            // Enroll user's fingerprint.   document.objSecuBSP.Enroll(payload);   err = document.objSecuBSP.ErrorCode; 
            if (err != 0) {
                alert('Registration failed ! Error Number : [' + err + ']');
                document.objSecuBSP.CloseDevice(255);
                return (false);
            } else {
                // Get text encoded FIR data from SecuBSP module 
                document.MainForm.FIRTextData.value = document.objSecuBSP.FIRTextData;
                alert('Registration success !');
            }
            // Close device [AUTO_DETECT] 
            document.objSecuBSP.CloseDevice(DEVICE_AUTO_DETECT);
        } catch (e) {
            alert(e.message);
            return (false);
        }
        // Submit main form 
        // document.MainForm.submit();
        return (true);
    }
    // New Emd test finger
</script>
@endsection