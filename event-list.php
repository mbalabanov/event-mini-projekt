<?php
session_start();
session_regenerate_id(true);

require_once "include/include_db.php";
$eventMonate = ["Jänner", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
$dateToday = date("Y-m-d");

$dateTodayExploded = explode("-", $dateToday);
$eventDatumTag = $dateTodayExploded[2];
$eventDatumMonat = $dateTodayExploded[1];
$eventDatumJahr = $dateTodayExploded[0];
$eventName = "%";
$completeEventDatum = $eventDatumJahr . "-" . $eventDatumMonat . "-" . $eventDatumTag;

$eventDatumTag = (int)$eventDatumTag;
$eventDatumMonat = (int)$eventDatumMonat;
$eventDatumJahr = (int)$eventDatumJahr;

require_once "include/include_head.php";
?>

<body class="alert-primary">
    <main class="container bg-white p-2">

        <?php
        require_once "include/include_nav.php";
        ?>

        <div class='row'>
            <div class='col-12 text-center'>
                <h2 class='fw-light'>Eventliste</h2>
            </div>
        </div>

        <?php

        if (isset($_POST["suchen"])) {
            $eventName = trim(strip_tags($_POST["eventName"]));
            $eventName = $eventName . "%";
            $eventDatumTag = trim(strip_tags($_POST["eventDatumTag"]));
            $eventDatumMonat = trim(strip_tags($_POST["eventDatumMonat"]));
            $eventDatumJahr = trim(strip_tags($_POST["eventDatumJahr"]));
            if ($eventDatumTag < 10) {
                $eventDatumTagZweistellig = "0" . $eventDatumTag;
            } else {
                $eventDatumTagZweistellig = $eventDatumTag;
            };
            if ($eventDatumMonat < 10) {
                $eventDatumMonatZweistellig = "0" . $eventDatumMonat;
            } else {
                $eventDatumMonatZweistellig = $eventDatumMonat;
            };
            $completeEventDatum = $eventDatumJahr . "-" . $eventDatumMonatZweistellig . "-" . $eventDatumTagZweistellig;

            $eventDatumTag = (int)$eventDatumTag;
            $eventDatumMonat = (int)$eventDatumMonat;
            $eventDatumJahr = (int)$eventDatumJahr;

            echo "<div class='row'>
                        <div class='col-12 text-center'>
                            <h4 class='fw-light'>Suchbegriff '" . substr($eventName, 0, -1) . "', ab dem Datum " . $eventDatumTag . ". " . $eventDatumMonat . ". " . $eventDatumJahr . "</h4>
                        </div>
                    </div>";
        }
        ?>

        <form method="post" class="p-4 alert alert-warning">
            <div class="row">
                <div class="col-md-3">
                    <label for="eventName" class="form-label">Suche nach Name</label>
                    <?php
                            echo "<input type='text' name='eventName' id='eventName' class='form-control' value='" . substr($eventName, 0, -1) . "'><br>";
                    ?>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="eventDatumSelect" class="form-label">Suche nach Datum</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <select name='eventDatumTag' id="eventDatumSelect" class='form-select'>
                                <?php
                                for ($nummerTag = 1; $nummerTag <= 31; $nummerTag++) {
                                    $selected = "";
                                    if ($eventDatumTag == $nummerTag) {
                                        $selected = "selected";
                                    }
                                    echo "<option value='$nummerTag' $selected>$nummerTag</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name='eventDatumMonat' class='form-select'>
                                <?php
                                foreach ($eventMonate as $monatsNummer => $monatsName) {
                                    $selected = "";
                                    $eigentlicheMonatsnummer = $monatsNummer + 1;
                                    if ($eventDatumMonat == $eigentlicheMonatsnummer) {
                                        $selected = "selected";
                                    }
                                    echo "<option value='$eigentlicheMonatsnummer' $selected>$monatsName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name='eventDatumJahr' class='form-select'>
                                <?php
                                $currentYear = (int)date("Y");
                                $pastYear = $currentYear - 10;
                                $futureYear = (int)$currentYear + 10;
                                for ($yearIterator = $pastYear; $yearIterator <= $futureYear; $yearIterator++) {
                                    $selected = "";
                                    if ($eventDatumJahr == $yearIterator) {
                                        $selected = "selected";
                                    };
                                    echo "<option value='$yearIterator' $selected>$yearIterator</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 pt-4">
                    <input type="submit" name="suchen" class="btn btn-primary mt-2 form-control" value="Suchen">
                </div>
            </div>
        </form>

        <div class="row p-2 mt-2">
            <?php
            $sql = "SELECT *
                    FROM event 
                    WHERE eventStartDatum >= :eventDatum
                    AND eventName LIKE :eventName
                    ORDER BY eventStartDatum ASC";

            $stmt = $db->prepare($sql);
            $correctEventDate = date("Y-m-d", strtotime($completeEventDatum));
            $stmt->bindParam(":eventDatum", $correctEventDate);
            $stmt->bindParam(":eventName", $eventName);
            $stmt->execute();

            while ($row =  $stmt->fetch()) {
                echo "<div class='col-md-4 my-2 p-1'>
                    <div class='border rounded bg-light p-3 text-center'>
                        <h4 class='fw-light'><a href='event-details.php?eventID=$row[eventID]' class='text-decoration-none'>$row[eventName]</a></h4>
                        <p><a href='event-details.php?eventID=$row[eventID]'><img src='img/$row[eventBild]' alt='$row[eventName]' class='img-fluid rounded'/></a></p>
                        <h5 class='fw-light'>$row[eventKategorie] in $row[eventBundesland]</h5>";

                $eventStartDatumExploded = explode("-", $row["eventStartDatum"]);
                $eventEndDatumExploded = explode("-", $row["eventEndDatum"]);

                $eventStartMonatNumerisch = (int)$eventStartDatumExploded[1];
                $eventEndMonatNumerisch = (int)$eventEndDatumExploded[1];

                if ( $eventStartMonatNumerisch - 1 >= 0) {
                    $eventStartMonatNumerisch = $eventStartMonatNumerisch - 1;
                } else {
                    $eventStartMonatNumerisch = 0;
                }
                if ( $eventEndMonatNumerisch - 1 >= 0) {
                    $eventEndMonatNumerisch = $eventEndMonatNumerisch - 1;
                } else {
                    $eventEndMonatNumerisch = 0;
                }

                if ( $eventStartDatumExploded != $eventEndDatumExploded && $eventEndDatumExploded[0] != "0000")
                {
                    echo "<p>Startet am <strong>$eventStartDatumExploded[2]. $eventMonate[$eventStartMonatNumerisch] $eventStartDatumExploded[0]</strong><br/>und läuft bis <strong>$eventEndDatumExploded[2]. $eventMonate[$eventEndMonatNumerisch] $eventEndDatumExploded[0]</strong></p>";
                } else {
                    echo "<p>Am <strong>$eventStartDatumExploded[2]. $eventMonate[$eventStartMonatNumerisch] $eventStartDatumExploded[0]</strong></p>";
                }

                echo "<p><a href='event-details.php?eventID=$row[eventID]' class='btn btn-primary btn-sm'>Details</a>";
                if (isset($_SESSION["userID"])) {
                    echo "<a class='btn btn-warning btn-sm mx-1' href='edit-event.php?eventID=$row[eventID]'>Bearbeiten</a>";
                }
                echo "</p>
                </div>
            </div>
            ";
            }
            ?>
        </div>
    </main>

    <?php
    require_once "include/include_footer.php";
    ?>