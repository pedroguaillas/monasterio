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
                            <input type="text" style="text-transform: capitalize;" class="form-control form-control-sm" id="first_name" name="first_name" maxlength="300" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-4" for="last_name">Apellidos *</label>
                        <div class="col-sm-8">
                            <input type="text" style="text-transform: capitalize;" class="form-control form-control-sm" id="last_name" name="last_name" maxlength="300" required>
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
</script>
@endsection