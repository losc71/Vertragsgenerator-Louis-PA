<?php
session_start();
//check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Willkommen</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <script src="https://kit.fontawesome.com/e785ad1786.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link href="css/custom.css?ver=100" type="text/css" rel="stylesheet" />

    <link rel="icon" href="img/metaball_02.png" type="imgage/icon" />
    <link rel="apple-touch-icon" href="img/apple-touch-icon-180x180.png" />

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $("input[type=radio]").change(function () {
                $("input[type=radio]:checked").not(this).prop("checked", false);
            });
        });
    </script>
</head>

<body>
    <a class="iconLeft" href="admin.php"><i class="fa-solid fa-gear fa-xl"></i></a>
    <a class="iconRight" href="logout.php"><i class="fa-solid fa-right-from-bracket fa-xl"></i></a>
    <div id="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <img class="logo" name="logo.img" src="img/Logo_small.gif" width="40%" />
                    <div id="html_div">
                        <form id="dataForm" action="prevertrag.php" method="post" onsubmit="return validateForm()">
                            <input type="text" name="name" id="name" placeholder="Name*" required/>
                            <br />
                            <input type="text" name="prename" id="prename" placeholder="Vorname*" required/>
                            <br />
                            <input type="email" name="email" id="email" placeholder="Email*" required/>
                            <br />
                            <input type="text" name="enterprise" id="enterprise" placeholder="Enterprise*" required/>
                            <br />
                            <input type="text" name="address" id="address" placeholder="Address*" required/>
                            <br />
                            <input type="text" name="location" id="location" placeholder="Ort*" required/>
                            <br />
                            <input type="tel" name="telefon" id="telefon" class="telefon" placeholder="Telefonnumber*" required/>
                            <br />
                            <h4>Angebote*</h4>
                            <div>
                                <label class="rad-label"><input type="radio" class="rad-input" name="standart"
                                        id="standart" value="990" />
                                    <div class="rad-design"></div>
                                    <div class="rad-text">
                                        Basic animated logo
                                        <div id="hidden-standart">
                                            CHF 990.- statt
                                            <span class="priceOld">CHF 1490.-</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <label class="rad-label"><input type="radio" class="rad-input" name="pers" id="pers"
                                        value="1990" />
                                    <div class="rad-design"></div>
                                    <div class="rad-text">
                                        Premium animated logo
                                        <div id="hidden-pers">
                                            CHF 1990.- statt
                                            <span class="priceOld">CHF 2490.-</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <label class="rad-label"><input type="radio" class="rad-input" name="special"
                                        id="special" />
                                    <div class="rad-design"></div>
                                    <div class="rad-text">Sondervereinbarung</div>
                                </label>
                            </div>
                            <input type="number" class="specialinput" name="specialinput" id="specialinput" min="0"
                                placeholder="Enter Spezialpreis" />
                            <br />
                            <h4>Zusatzoptionen</h4>
                            <label class="rad-label" for="vektor"><input type="checkbox" class="rad-input" id="vektor"
                                    name="vektor" value="390" />
                                <div class="rad-design"></div>
                                <div class="rad-text">
                                    Vektorisiertes Logo<span id="hidden-vek">
                                        + CHF 390.-
                                    </span>
                                </div>
                            </label>
                            <label class="rad-label" for="modern"><input type="checkbox" class="rad-input" id="modern"
                                    name="modern" value="690" />
                                <div class="rad-design"></div>
                                <div class="rad-text">
                                    Modernisiertes Logo<span id="hidden-mod"> + CHF 690.-</span>
                                </div>
                            </label>
                            <br />
                            <h4>Bezahlung*</h4>
                            <label class="rad-label" for="bill"><input type="checkbox" class="rad-input" id="bill"
                                    name="bill" />
                                <div class="rad-design"></div>
                                <div class="rad-text">Rechnung</div>
                            </label>
                            <label class="rad-label" for="instant"><input type="checkbox" class="rad-input" id="instant"
                                    name="instant" />
                                <div class="rad-design"></div>
                                <div class="rad-text">Sofortbezahlung</div>
                            </label>
                            <br />
                            <input type="submit" name="submit_val" value="Offerte erstellen" />
                        </form>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </div>
</body>
<!-- <script>
document.getElementById("telefon").addEventListener("keyup", function() {
    txt = this.value;
    if (txt.length == 3 || txt.length == 7 || txt.length == 10)
        this.value = this.value + " ";
});
</script> -->
<script>
    //hide the specialprice field till radio selected
    $(".specialinput").hide();
    $("#special").click(function () {
        $(".specialinput")[this.checked ? "show" : "hide"]();
    });

    //check if one of the radio-buttons is selected
    var form = document.getElementById("dataForm");
  form.addEventListener("submit", function(event) {
    var radioChecked = false;
    var radios = document.querySelectorAll('input[type=radio]');
    for (var i = 0; i < radios.length; i++) {
      if (radios[i].checked) {
        radioChecked = true;
        break;
      }
    }
    if (!radioChecked) {
      alert("Wählen Sie bitte ein Angebot.");
      event.preventDefault();
    }
  });

  //One of the payment methods has to be selected
  function validateForm() {
  var bill = document.getElementById("bill").checked;
  var instant = document.getElementById("instant").checked;

  if (!bill && !instant) {
    alert("Wählen Sie bitte ein Bezahlung.");
    return false;
  } else if (bill && instant) {
    alert("Wählen Sie bitte ein nur eine Bezahlung.");
    return false;
  }

  return true;
}
</script>

</html>