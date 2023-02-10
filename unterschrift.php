<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Unterschrift</title>
    <script src="https://kit.fontawesome.com/77e99a4480.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script>
    window.onload = function() {
        var dwn = document.getElementById("convert-button"),
            canvas = document.getElementById("drawing-area"),
            context = canvas.getContext("2d");

        dwn.onclick = function() {
            download(canvas, "Unterschrift.png");
        };
    };

    function download(canvas, filename) {
        var lnk = document.createElement("a"),
            e;

        lnk.download = filename;

        lnk.dataURL = canvas.toDataURL("image/png;base64");

        $.ajax({
            type: "POST",
            url: "upload.php",
            data: {
                imgBase64: lnk.dataURL,
            },
        }).done(function(response) {
            console.log("saved: " + response);
        });
    }
    document.addEventListener("touchstart", function() {}, true);
    </script>
    <style>
    body {
        width: 100%;
    }

    #convert-button {
        border-radius: 20px;
        width: 125px;
        height: 85px;
        border: none;
        color: white;
        top: 8px;
        right: 75px;
        position: absolute;
        box-shadow: 0 4px #999;
        transition: all .2s ease-in-out;
    }

    .clear-button:active {
        transform: scale(0.9);
	transition: .05s;
    }

    #clear-button {
        border-radius: 20px;
        width: 125px;
        height: 85px;
        border: none;
        color: white;
        top: 98px;
        right: 75px;
        position: absolute;
        box-shadow: 0 4px #999;
        transition: all .2s ease-in-out;
    }

    .container {
        display: inline-block;
        width: auto;
        height: 200px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 95vh;
    }

    .drawing-area {
        box-shadow: 0 0 5px 0 #999;
    }
    </style>
</head>

<body>
    <div id="container" class="container">
        <canvas id="drawing-area" class="drawing-area" height="165" width="500"></canvas>
        <button style="background-color: hsla(120, 60%, 70%, 0.7)" id="convert-button" class="clear-button"
            type="button">
            Absenden</button><br />
        <button style="background-color: rgba(255, 0, 0, 0.7)" id="clear-button" class="clear-button" type="button">
            Löschen
        </button>
    </div>
    <script src="js/unterschrift.js"></script>
    <script>document.getElementById("convert-button").addEventListener("click", function() {
    window.parent.postMessage("convert-button-clicked", "*");
  });</script>
</body>

</html>