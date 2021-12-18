@extends('adminlte::page')

@section('title', 'Autenticación dáctilar')

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
<form method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
    <div class="row">
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

                </div>

                <div class="card-footer bg-transparent">
                    <div id="custom_verify"></div>
                </div>
            </div>
            <!-- End Test Finger capute -->
        </div>
    </div>
    </div>
</form>
@endsection

@section('js')
<script>
    var template_1 = "";
    var customers = "";

    // Start test finger

    function captureFP() {
        CallSGIFPGetData(SuccessFunc, ErrorFunc);
    }

    function getOthersTempleates() {
        $.ajax({
            type: 'GET',
            url: "{{url('fingers')}}/",
            success: (res) => {
                customers = res.customers
                matchScore(succMatch, failureFunc)
            },
            error: (err) => console.log(err)
        })
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
                template_1 = result.TemplateBase64;
                getOthersTempleates()
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
        xmlhttp.open("POST", uri, true);
        xmlhttp.send(params);

        xmlhttp.onerror = function() {
            failCall(xmlhttp.statusText);
        }
    }

    function matchScore(succFunction, failFunction) {
        if (template_1 == "") {
            alert("Por favor escanear el dedo!!");
            return;
        }
        var i = 0
        var enc = -1
        var uri = "https://localhost:8443/SGIMatchScore";

        while (i < customers.length && enc == -1) {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    fpobject = JSON.parse(xmlhttp.responseText);
                    if (verifyMatch(fpobject)) {
                        enc = customers[i].id
                        getCustomer(enc)
                    }
                    // succFunction(fpobject);
                } else if (xmlhttp.status == 404) {
                    failFunction(xmlhttp.status)
                }
            }

            xmlhttp.onerror = function() {
                failFunction(xmlhttp.status);
            }

            var params = "template1=" + encodeURIComponent(template_1);
            params += "&template2=" + encodeURIComponent(customers[i].finger);
            params += "&licstr=" + encodeURIComponent(secugen_lic);
            params += "&templateFormat=" + "ISO";
            xmlhttp.open("POST", uri, false);
            xmlhttp.send(params);

            i++
        }
    }

    function getCustomer(id) {
        $.ajax({
            type: 'GET',
            url: "{{url('fingers/show')}}/" + id,
            success: (res) => {
                let {
                    first_name,
                    last_name
                } = res.customer
                $('#custom_verify').text(`${first_name} ${last_name}`)
            },
            error: (err) => console.log(err)
        })
    }

    function succMatch(result) {
        // var idQuality = document.getElementById("quality").value;
        var idQuality = 100;
        if (result.ErrorCode == 0) {
            // return (result.MatchingScore >= idQuality)
            if (result.MatchingScore >= idQuality)
                alert("MATCHED ! (" + result.MatchingScore + ")");
            else
                alert("NOT MATCHED ! (" + result.MatchingScore + ")");
        } else {
            alert("Error Scanning Fingerprint ErrorCode = " + result.ErrorCode);
            // return false
        }
    }

    function verifyMatch(result) {
        var idQuality = 100;
        if (result.ErrorCode == 0) {
            return (result.MatchingScore >= idQuality)
        } else {
            return false
        }
    }

    function failureFunc(error) {
        alert("On Match Process, failure has been called");
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