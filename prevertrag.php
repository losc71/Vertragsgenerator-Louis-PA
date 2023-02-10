<?php


if (!isset($_SESSION)) {
    session_start();
}



//Writing the From inputs into Sessions
$_SESSION['name'] = $_POST['name'];
$_SESSION['prename'] = $_POST['prename'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['enterprise'] = $_POST['enterprise'];
$_SESSION['address'] = $_POST['address'];
$telefon = $_POST['telefon'];
$formatted_telefon = preg_replace("/^(\d{3})(\d{3})(\d{2})(\d{2})$/", "$1 $2 $3 $4", $telefon);
$_SESSION['telefon'] = $formatted_telefon;
$_SESSION['standart'] = $_POST['standart'];
$_SESSION['pers'] = $_POST['pers'];
$_SESSION['vektor'] = $_POST['vektor'];
$_SESSION['modern'] = $_POST['modern'];
$_SESSION['instant'] = $_POST['instant'];
$_SESSION['special'] = $_POST['special'];
$_SESSION['specialinput'] = $_POST['specialinput'];
$_SESSION['location'] = $_POST['location'];


//Check if the inputs arent empty
if (isset($_POST['standart'])) {
    $_SESSION['standart'];
}
if (isset($_POST['pers'])) {
    $_SESSION['pers'];
}
if (isset($_POST['vektor'])) {
    $_SESSION['vektor'];
}
if (isset($_POST['modern'])) {
    $_SESSION['modern'];
}
if (isset($_POST['specialinput'])) {
    $_SESSION['specialinput'];
}
if (isset($_POST['instant'])) {
    $_SESSION['instant'];
}
//Calculating the price
$total = $_POST['standart'] + $_POST['pers'] + $_POST['vektor'] + $_POST['modern'] + $_POST['specialinput'];
$rabatt = $total / 100 * 10;
$instantPay = $total / 100 * 90;
$mwstRabatt = (round($instantPay / 100 * 7.7 / 0.05) * 0.05);
$mwst = (round($total / 100 * 7.7 / 0.05) * 0.05);
$totalMwstRabatt = $instantPay + (round($mwstRabatt / 0.05) * 0.05);
$totalMwst = $total + (round($mwst / 0.05) * 0.05);

//Write the calculated price into the Sessions
$_SESSION['totalMwst'] = $totalMwst;
$_SESSION['totalMwstRabatt'] = $totalMwstRabatt;
$_SESSION['mwst'] = $mwst;
$_SESSION['mwstRabatt'] = $mwstRabatt;
$_SESSION['total'] = $total;
$_SESSION['rabatt'] = $rabatt;
$_SESSION['instantPay'] = $instantPay;
$specialprice = $_POST['specialinput'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=100%" />
    <meta name="format-detection" content="telephone=no">

    <link rel="icon" href="img/apple-touch-icon-120x120.png" type="imgage/icon" />
    <link rel="apple-touch-icon" href="img/apple-touch-icon-180x180.png" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title>Offerte</title>
    <style>
        body {
            padding-left: 15%;
            padding-right: 15%;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding-left: 10%;
                padding-right: 10%;
                width: 725px;
            }
        }

        @media only screen and (max-height: 375px) {
            body {
                overflow: scroll;
            }
        }

        * {
            font-family: "DejaVuSans", sans-serif;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }

        .delete {
            text-decoration: line-through;
        }

        .block {
            padding-left: 19px;
        }

        .table {
            position: absolute;
            top: 400px;
            left: 200px;
            page-break-after: auto;
            margin-bottom: 20rem;
            white-space: nowrap;
        }

        .signature {
            border-bottom: 1px solid black;
            top: 20%;
        }

        .title {
            position: absolute;
            top: 150px;
            left: 200px;
            font-weight: 400;
        }

        .bild {
            margin-top: 50px;
            margin-left: 500px;
            width: 200px;
        }

        .submit-disabled {
            border-radius: 20px;
            background: linear-gradient(to right bottom,
                    hsl(209, 49%, 67%),
                    hsl(249, 66%, 62%));
            width: 100%;
            height: 35px;
            border: none;
            margin-top: 5px;
            color: white;
            margin-left: -5px;
            padding: 20px 0px 30px 0px;
            margin-bottom: 50px;
        }

        .submit-disabled:disabled {
            border-radius: 20px;
            background: linear-gradient(to right bottom,
                    hsl(209, 49%, 67%, 0.3),
                    hsl(249, 66%, 62%, 0.3));
            width: 100%;
            height: 35px;
            border: none;
            margin-top: 5px;
            color: white;
            margin-left: -5px;
        }

        .parts {
            margin-left: 50px;
            white-space: nowrap;
        }

        table.price {
            border-right: 0;
            border-top: 0.02em solid #ccc;
            border-bottom: 0;
            border-collapse: collapse;
        }

        table.price td {
            border-top: 0;
            border-bottom: 0.02em solid #ccc;
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <h1 class="title">Dienstleistungsvertrag</h1>
    <img class="bild" src="img/Logo_small.gif" />
    <table class="table">
        <tr>
            <td>Produkt :</td>
            <td>animated logo</td>
        </tr>
        <tr>
            <td>Verantwortlich :</td>
            <td>Carlos Correia</td>
        </tr>
        <tr>
            <td>Version :</td>
            <td>1.0</td>
        </tr>
        <tr>
            <td>Erstellungsdatum :</td>
            <td>
                <?php echo date('d.m.Y') ?>
            </td>
        </tr>
    </table>
    <div style="margin-top: 50rem">
        <p>
            Auf Basis unserer Korrespondenz offeriert animated logo by DOOR’42
            nachfolgendes Angebot. Bei Annahme kommt ein Vertrag zu Stande. Die
            Vertragspartner bestehen aus:
        </p>
        <table class="parts">
            <tr>
                <td style="font-weight: 700">Auftragnehmer :</td>
            </tr>
            <tr>
                <td>animated logo</td>
            </tr>
            <tr>
                <td>by DOOR 42</td>
            </tr>
            <tr>
                <td>Bergstrasse 3</td>
            </tr>
            <tr>
                <td>6004 Luzern</td>
            </tr>
        </table>
        <table style="margin-left: 400px; margin-bottom: 20px; margin-top: -2.9cm" class="parts">
            <tr>
                <td style="font-weight: 700">Auftraggeber :</td>
            </tr>
            <tr>
                <td>
                    <?php echo $_SESSION["enterprise"]; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $_SESSION["name"], ' ', $_SESSION["prename"]; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $_SESSION["address"]; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $_SESSION["telefon"]; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $_SESSION["email"]; ?>
                </td>
            </tr>
        </table>
        <br />
        <br />
        <div>
            <h4>1. Bestandteil der Dienstleistung</h4>
            <p class="block">Was Sie erhalten:</p>
            <ul>
                <li>
                    Datenpaket mit deinem „animated logo“ (.gif) mit hellem und dunklem
                    Hintergrund in unterschiedlichen Grössen (100px, 200px, 300px)
                </li>
                <li>Word-Dokument mit deiner neuen E-Mail-Signatur</li>
                <li>
                    Unterstützung bei der Integration des Logos bei der eigenen Webseite
                </li>
            </ul>
            <h4>2. Definition Basic animated logo</h4>
            <p class="block">
                Wir entwerfen anhand unseren Vorlagen fünf verschiedene passende
                Entwürfe Ihres animierten Logos. Am Schluss entscheiden Sie, welches
                Logo Sie am meisten bewegt. Dabei achten wir sehr darauf, dass die
                Animation Ihr Logo entsprechend in den Vordergrund bringt.
            </p>
            <h4>3. Definition Premium animated logo</h4>
            <p class="block">
                Sie können uns Ihren Wunsch äussern und wir kreieren für Sie Ihr
                persönliches animiertes Logo. Das Logo ist hochwertiger, da wir Ihre
                persönliche Geschichte in dem Logo wiedergeben. Daher ist der Preis
                auch höher im Vergleich zur Basic-Variante.
            </p>
            <h4>4. Konditionen</h4>
            <p class="block">
                Ein Projekt gilt 30 Tage nach der Abgabe als abgeschlossen. In dieser
                Zeit hat der Auftraggeber das Recht allfällige Fehler zu melden und
                diese werden innerhalb des offerierten Preises behoben. Nach Ablauf
                dieser Frist werden jegliche Arbeiten anhand des Stundenansatzes dem
                Auftraggeber verrechnet.
            </p>
            <p class="block">
                Das Angebot steht unter Vorbehalt des derzeit abschätzbaren Aufwands
                und kann nach genauer Abklärung mit Absprache des Auftraggebers
                variieren.
            </p>
        </div>
        <div>
            <h4>5. Vorauszahlung</h4>
            <p class="block">
                Bezahlen Sie im Voraus mit Twint oder Kreditkarte und erhalten Sie 10%
                Rabatt. Ansonsten senden wir Ihnen gerne eine Rechnung.
            </p>
        </div>
        <div>
            <h4>6. Timeline - Dauer</h4>
            <p class="block">
                Das animierte Logo mit einer unserer Vorlagen dauert 5 Werktage. Falls
                eine Vektorisierung des Logos notwendig ist, nimmt die Bearbeitung 10
                Werktage in Anspruch. Personalisierte Logos benötigen ebenfalls 10
                Werktage.
            </p>
        </div>
        <br />
        <div>
            <h4>7. More wishes</h4>
            <p class="block">
                Für alle weiteren Wünsche besprechen wir das weitere Vorgehen gerne
                mit Ihnen sowie auch unseren entsprechenden Stundenansatz.
            </p>
        </div>
        <p class="block">
            Bei Unklarheiten oder Fragen stehen wir Ihnen selbstverständlich gerne
            zur Verfügung. Über eine zukünftige Zusammenarbeit freuen wir uns sehr.
            “Let’s animate your logo. Now.”
        </p>
        <h4>8. Beschreibung</h4>
        <br />
        <div>
            <table class="price" style="width: 100%; border-collapse: collapse">
                <?php
                if (isset($_SESSION['standart'])) {
                    echo '<tr class="standart">
                <td style="width: 5%"></td>
                <td style="width: 50%">
                    <li>Basic animated logo (30 Beispiele)</li>
                </td>
                <td style="width: 30%"></td>
                <td style="width: 5%">CHF</td>
                <td style="width: 10%; text-align: right">990.00.-</td>
            </tr>';
                }
                if (isset($_SESSION['pers'])) {
                    echo
                        '<tr class="pers">
                <td style="width: 5%"></td>
                    <td style="width: 50%"><li>Premium animated logo</li></td>
                    <td style="width: 30%"></td>
                    <td style="width: 5%">CHF</td>
                    <td style="width: 10%; text-align: right">1990.00.-</td>
                </tr>';
                }
                if (isset($_SESSION['special'])) {
                    echo
                        '<tr class="special">
                <td style="width: 5%"></td>
                    <td style="width: 50%"><li>Sondervereinbarung</li></td>
                    <td style="width: 30%"></td>
                    <td style="width: 5%">CHF</td>
                    <td style="width: 10%; text-align: right">
                        ' . number_format($specialprice, 2) . '.-
                </td>
                </tr>';
                }
                if (isset($_SESSION['vektor'])) {
                    echo
                        '<tr class="vektor">
                <td style="width: 5%"></td>
                    <td><li>Vektorisiertes Logo (eps / ai.)</li></td>
                    <td style="width: 30%"></td>
                    <td style="width: 5%">CHF</td>
                    <td style="text-align: right">390.00.-</td>
                </tr>';
                }
                if (isset($_SESSION['modern'])) {
                    echo
                        '<tr class="modern">
                <td style="width: 5%"></td>
                    <td><li>Modernisiertes Logo</li></td>
                    <td style="width: 30%"></td>
                    <td style="width: 5%">CHF</td>
                    <td style="text-align: right">690.00.-</td>
                </tr>';
                }
                echo
                    '<tr style="font-weight: 600">
                <td style="width: 5%"></td>
                    <td style="width: 50%"></td>
                    <td style="width: 30%">Total :</td>
                    <td style="width: 5%">CHF</td>
                    <td style="text-align: right">' . number_format($total, 2) . '.- </td>
                </tr>';
                if (isset($_SESSION['instant'])) {
                    echo
                        '<tr class="instant">
                <td style="width: 5%"></td>
                    <td></td>
                    <td style="width: 30%">Rabatt bei Sofortbezahlung :</td>
                    <td style="width: 5%">CHF</td>
                    <td style="text-align: right">' . number_format($rabatt, 2) . '.-</td>
                </tr>

                <tr class="instant" style="font-weight: 700">
                <td style="width: 5%"></td>
                    <td></td>
                    <td style="width: 30%">Total Sofortbezahlung :</td>
                    <td style="width: 5%">CHF</td>
                    <td style="text-align: right">' . number_format($instantPay, 2) . '.-</td>
                </tr>

                <tr class="instant">
                <td style="width: 5%"></td>
                    <td style="width: 50%"></td>
                    <td style="width: 30%">Zzgl. MWST 7.70%</td>
                    <td style="width: 5%">CHF</td>
                    <td style="width: 10%; text-align: right">' . number_format($mwstRabatt, 2) . '.-</td>
                </tr>

                <tr class="instant" style="font-weight: 700">
                <td style="width: 5%"></td>
                    <td></td>
                    <td style="width: 30%">Betrag inkl. MWST</td>
                    <td style="width: 5%">CHF</td>
                    <td style="text-align: right">' . number_format($totalMwstRabatt, 2) . '.-</td>
                </tr>';
                }
                if (!isset($_SESSION['instant'])) {
                    echo
                        '<tr class="bill">
                <td style="width: 5%"></td>
                    <td style="width: 50%"></td>
                    <td style="width: 30%">Zzgl. MWST 7.70%</td>
                    <td style="width: 5%">CHF</td>
                    <td style="width: 10%; text-align: right">' . number_format($mwst, 2) . '.-</td>
                </tr>
                <tr class="bill" style="font-weight: 700">
                <td style="width: 5%"></td>
                    <td></td>
                    <td style="width: 30%">Betrag inkl. MWST</td>
                    <td style="width: 5%">CHF</td>
                    <td style="text-align: right">' . number_format($totalMwst, 2) . '.-</td>
                </tr>';
                }
                ?>
            </table>
        </div>
        <p>
            Ich bestätige hiermit, dass ich alles gelesen habe und damit
            einverstanden bin.
        </p>
        <div>
            <p>Offerte angenommen, Auftraggeber:</p>
            <iframe src="unterschrift.php" scrolling="no" frameborder="0" height="225" width="725"></iframe>
        </div>
        <form action="pdf.php" method="post">
            <input class="submit-disabled" type="submit" name="submit_val" id="sig-submit-button"
                value="Vertrag erstellen" disabled />
        </form>
    </div>

    <script>
        window.addEventListener("message", function (event) {
            if (event.data === "convert-button-clicked") {
                document.getElementById("sig-submit-button").removeAttribute("disabled");
            }
        });
    </script>
</body>

</html>