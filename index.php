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

        <?php
        $sql = "SELECT * FROM event WHERE eventStartDatum > $dateToday ORDER BY eventStartDatum ASC LIMIT 3";
        $stmt = $db->query($sql);
        $eventMonate = ["Jänner", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
        ?>

        <div class="row">
            <div class="col-12">
                <div id="headerCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#headerCarouselCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#headerCarouselCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#headerCarouselCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <?php

                        $carouselIterator = 0;
                        $active = "active";
                        while ($carouselItem = $stmt->fetch()) {
                            echo "
                                <div class='carousel-item $active'>
                                <a href='event-details.php?eventID=$carouselItem[eventID]'><img src='img/$carouselItem[eventBild]' class='d-block w-100 rounded' alt='$carouselItem[eventName]'></a>
                                    <div class='carousel-caption d-none d-md-block'>
                                        <h5 class='fw-light'>$carouselItem[eventName]</h5>
                                        <p class='text-truncate'>$carouselItem[eventBeschreibung]</p>
                                    </div>
                                </div>";

                            $active = "";
                        };

                        ?>

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#headerCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#headerCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <form method="post" action="event-list.php" class="p-4 mt-5 alert alert-warning">
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

        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <h2 class="fw-light">Events demnächst</h2>
            </div>
        </div>

        <div class="row p-2">
            <?php
            $sql = "SELECT * FROM event WHERE eventStartDatum > $dateToday ORDER BY eventStartDatum ASC LIMIT 8";
            $stmt = $db->query($sql);
            while ($row =  $stmt->fetch()) {
                echo "<div class='col-md-3 my-2 p-1'>
                    <div class='border rounded bg-light p-3 text-center'>
                        <h4 class='fw-light'><a href='event-details.php?eventID=$row[eventID]' class='text-decoration-none'>$row[eventName]</a></h4>
                        <p><a href='event-details.php?eventID=$row[eventID]'><img src='img/$row[eventBild]' alt='$row[eventName]' class='img-fluid rounded'/></a></p>
                        <h5 class='fw-light'>$row[eventKategorie] in $row[eventBundesland]</h5>";

                $eventStartDatumExploded = explode("-", $row["eventStartDatum"]);
                $eventEndDatumExploded = explode("-", $row["eventEndDatum"]);

                $eventStartMonatNumerisch = (int)$eventStartDatumExploded[1];
                $eventEndMonatNumerisch = (int)$eventEndDatumExploded[1];

                if ($eventStartMonatNumerisch - 1 >= 0) {
                    $eventStartMonatNumerisch = $eventStartMonatNumerisch - 1;
                } else {
                    $eventStartMonatNumerisch = 0;
                }
                if ($eventEndMonatNumerisch - 1 >= 0) {
                    $eventEndMonatNumerisch = $eventEndMonatNumerisch - 1;
                } else {
                    $eventEndMonatNumerisch = 0;
                }

                if ($eventStartDatumExploded != $eventEndDatumExploded && $eventEndDatumExploded[0] != "0000") {
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
        <div class="row mt-2">
            <div class="col-md-12 text-center">
                <h2 class="fw-light">Einloggen</h2>
                <p>Einloggen mit folgendem Test-Account: eventuser, user@event.com, Test1234</p>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2 alert alert-secondary">
                <form method="post" class="row" action="<?php echo 'login.php'  ?>">
                    <div class="mb-3 col-md-6">
                        <label for="inputEmail" class="form-label">Email Adresse</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password">
                    </div>
                    <p class="text-end mt-2">
                        <a class="btn btn-secondary" href="index.php">Zurück</a>
                        <a class="btn btn-warning" href="register.php">Neu registrieren</a>
                        <button type="submit" class="btn btn-primary" name="einloggen">Login</button>
                    </p>
                </form>
            </div>
        </div>
    </main>

    <?php
    require_once "include/include_footer.php";
    ?>