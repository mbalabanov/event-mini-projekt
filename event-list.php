<?php
require_once "include/include_db.php";
$dateToday = date("Y-m-d");
$dateTodayExploded = explode("-", $dateToday);
$dateTodayExplodedTag = (int)$dateTodayExploded[2];
$dateTodayExplodedMonat = (int)$dateTodayExploded[1];
$dateTodayExplodedJahr = (int)$dateTodayExploded[0];
$eventName = "%";
$completeEventDatum = $dateTodayExplodedJahr . "-" . $dateTodayExplodedMonat . "-" . $dateTodayExplodedTag;
$eventMonate = ["Jänner", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];

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

        <form method="post" class="p-4 alert alert-secondary">
            <div class="row">
                <div class="col-md-3">
                    <label for="eventName" class="form-label">Suche nach Name</label>
                    <input type="text" name="eventName" id="eventName" class="form-control"><br>
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
                                    if ($dateTodayExplodedTag == $nummerTag) {
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
                                foreach ($eventMonate as $monatsNummer => $monatName) {
                                    $selected = "";
                                    $eigentlicheMonatsnummer = $monatsNummer + 1;
                                    if ($dateTodayExplodedMonat == $eigentlicheMonatsnummer) {
                                        $selected = "selected";
                                    }
                                    echo "<option value='$eigentlicheMonatsnummer' $selected>$monatName</option>";
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
                                    if ($dateTodayExplodedJahr == $yearIterator) {
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

            if (isset($_POST["suchen"])) {
                $eventName = trim(strip_tags($_POST["eventName"]));
                $eventName = $eventName . "%";
                $eventDatumTag = trim(strip_tags($_POST["eventDatumTag"]));
                if ($eventDatumTag < 10) {
                    $eventDatumTag = "0" . $eventDatumTag;
                };
                $eventDatumMonat = trim(strip_tags($_POST["eventDatumMonat"]));
                if ($eventDatumMonat < 10) {
                    $eventDatumMonat = "0" . $eventDatumMonat;
                };
                $eventDatumJahr = trim(strip_tags($_POST["eventDatumJahr"]));
                $completeEventDatum = $eventDatumJahr . "-" . $eventDatumMonat . "-" . $eventDatumTag;

                echo "<div class='row'>
                        <div class='col-12 text-center'>
                            <h4 class='fw-light'>Suchbegriff '" . substr($eventName, 0, -1) . "', ab dem Datum " . $eventDatumTag . ". " . $eventDatumMonat . ". " . $eventDatumJahr . "</h4>
                        </div>
                    </div>";
            }

            $sql = "SELECT *
                    FROM event 
                    WHERE eventStartDatum >= :eventDatum
                    AND eventName LIKE :eventName
                    ORDER BY eventStartDatum ASC";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(":eventDatum", $completeEventDatum);
            $stmt->bindParam(":eventName", $eventName);
            $stmt->execute();

            while ($row =  $stmt->fetch()) {
                echo "
            <div class='col-md-4 my-2 p-1'>
                <div class='border rounded bg-light p-3 text-center'>
                    <h4 class='fw-light'><a href='event-details.php?eventID=$row[eventID]' class='text-decoration-none'>$row[eventName]</a></h4>
                    <p><a href='event-details.php?eventID=$row[eventID]'><img src='img/$row[eventBild]' alt='$row[eventName]' class='img-fluid rounded'/></a></p>
                    <h5 class='fw-light'>$row[eventKategorie] in $row[eventBundesland]</h5>
            ";

                $eventStartDatumExploded = explode("-", $row["eventStartDatum"]);
                $eventEndDatumExploded = explode("-", $row["eventEndDatum"]);

                $eventStartMonatNumerisch = (int)$eventStartDatumExploded[1];
                $eventEndMonatNumerisch = (int)$eventEndDatumExploded[1];

                echo "
                    <p><strong>Start:</strong> $eventStartDatumExploded[2]. $eventMonate[$eventStartMonatNumerisch] $eventStartDatumExploded[0]<br/><strong>Ende:</strong> $eventEndDatumExploded[2]. $eventMonate[$eventEndMonatNumerisch] $eventEndDatumExploded[0]</p> 
                    <p><a href='event-details.php?eventID=$row[eventID]' class='btn btn-primary btn-sm'>Details</a></p>
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