<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Vlajky</title>
</head>

<body style="min-height:100vh" class="bg-dark d-flex flex-column justify-content-center align-items-center text-light">
    <?php
    session_start();
    require_once("db.php");

    $zapsane_staty = [];

    $kliknuto = isset($_GET["kliknuto"]) ? $_GET["kliknuto"] : null;
    $spravne = isset($_GET["spravne"]) ? $_GET["spravne"] : null;

    $uhadnute = isset($_SESSION["uhadnute"]) ? $_SESSION["uhadnute"] : 0;
    $pokusy = isset($_SESSION["pokusy"]) ? $_SESSION["pokusy"] : 0;

    $maximalni_pocet_pokusu = 10;
    if($pokusy>=$maximalni_pocet_pokusu){
        echo("<p>Z $maximalni_pocet_pokusu si měl správně $uhadnute</p>");
        echo("<a href='/Mraz/' class='btn btn-primary'>Hrát znovu</a>");
        session_destroy();
        die();
    }

    if (isset($_GET["kliknuto"])) {
        $kliknuto = $_GET["kliknuto"];
        $pokusy++;
    }

    if (isset($_GET["spravne"])) {
        $spravne = $_GET["spravne"];
    }

    if ($spravne != null) {
        if ($spravne === $kliknuto) {
            echo ("<p class='text-success'>Uhádl si!</p>");
            $uhadnute++;
        } else {
            echo ("<p class='text-danger'>Špatně!</p>");
        }
    }

    $_SESSION["uhadnute"] = $uhadnute;
    $_SESSION["pokusy"] = $pokusy;

    $uhadnute = 0;
    $pokusy = 0;

    $nahodne_staty = vratNahodnePrvky($staty, 3);
    vypisHru($nahodne_staty);

    function vypisHru($staty)
    {
        $cislo_vybraneho_statu = random_int(0, count($staty) - 1);
        $spravne_id = $staty[$cislo_vybraneho_statu]->id;

        echo ("<img src='/Mraz/vlajky/" . $staty[$cislo_vybraneho_statu]->obrazek . ".png' width='360'>");
        echo ("<div class='mt-1 d-flex gap-3'>");
        for ($i = 0; $i < count($staty); $i++) {
            echo ("<a class='btn btn-primary' href='/Mraz/?kliknuto=" . $staty[$i]->id . "&spravne=" . $spravne_id . "'>" . $staty[$i]->stat . "</a>");
        }
        echo ("</div>");
    }

    function vratNahodnePrvky($array, $kolik)
    {
        shuffle($array);
        return array_slice($array, 0, $kolik);
    }
    ?>
</body>

</html>