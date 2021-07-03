<?php
session_start();
session_regenerate_id(true);
if (empty($_SESSION["userID"])) {
    header("location:login.php");
}
require_once "include/include_db.php";
require_once "include/include_head.php";

if (isset($_REQUEST["eventID"])) {
    $eventID = (int)$_REQUEST["eventID"];
    $successMessage = "";
}

if (isset($_POST["speichern"])) {
    $eventName = trim(strip_tags($_POST["eventName"]));
    $eventKategorie = trim(strip_tags($_POST["eventKategorie"]));
    $eventBundesland = trim(strip_tags($_POST["eventBundesland"]));
    $eventBeschreibung = trim(strip_tags($_POST["eventBeschreibung"]));

    $startDatumTag = (int)trim(strip_tags($_POST["startDatumTag"]));
    $startDatumMonat = (int)trim(strip_tags($_POST["startDatumMonat"]));
    $startDatumJahr = (int)trim(strip_tags($_POST["startDatumJahr"]));

    $endDatumTag = (int)trim(strip_tags($_POST["endDatumTag"]));
    $endDatumMonat = (int)trim(strip_tags($_POST["endDatumMonat"]));
    $endDatumJahr = (int)trim(strip_tags($_POST["endDatumJahr"]));

    if ($endDatumTag < 10) {
        $endDatumTag = "0" . $endDatumTag;
    };
    if ($startDatumTag < 10) {
        $startDatumTag = "0" . $startDatumTag;
    };

    if ($endDatumMonat < 10) {
        $endDatumMonat = "0" . $endDatumMonat;
    };
    if ($startDatumMonat < 10) {
        $startDatumMonat = "0" . $startDatumMonat;
    };

    $eventStartDatum = $startDatumJahr . "-" . $startDatumMonat . "-" . $startDatumTag;
    $eventEndDatum = $endDatumJahr . "-" . $endDatumMonat . "-" . $endDatumTag;

    $successMessage = "<div class='alert alert-success text-center'>Event wurde aktualisiert.</div>";

    $sql = "
    UPDATE event SET
    eventName=:eventName,
    eventKategorie=:eventKategorie,
    eventBundesland=:eventBundesland,
    eventStartDatum=:eventStartDatum,
    eventEndDatum=:eventEndDatum,
    eventBeschreibung=:eventBeschreibung
    WHERE eventID=:eventID
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":eventID", $eventID);
    $stmt->bindParam(":eventName", $eventName);
    $stmt->bindParam(":eventKategorie", $eventKategorie);
    $stmt->bindParam(":eventBundesland", $eventBundesland);
    $stmt->bindParam(":eventStartDatum", $eventStartDatum);
    $stmt->bindParam(":eventEndDatum", $eventEndDatum);
    $stmt->bindParam(":eventBeschreibung", $eventBeschreibung);
    $stmt->execute();
}

?>

<body class="alert-primary">
    <main class="container bg-white p-2">

        <?php
        require_once "include/include_nav.php";

        $sql = "SELECT * FROM event 
        WHERE eventID=:eventID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":eventID", $eventID);
        $stmt->execute();
        $row = $stmt->fetch();

        $eventStartDatumExploded = explode("-", $row['eventStartDatum']);
        $eventEndDatumExploded = explode("-", $row['eventEndDatum']);

        $eventStartDatumExplodedTag = $eventStartDatumExploded[2];
        $eventStartDatumExplodedMonat = $eventStartDatumExploded[1];
        $eventStartDatumExplodedJahr = $eventStartDatumExploded[0];

        $eventEndDatumExplodedTag = $eventEndDatumExploded[2];
        $eventEndDatumExplodedMonat = $eventEndDatumExploded[1];
        $eventEndDatumExplodedJahr = $eventEndDatumExploded[0];

        echo "<h2  class='fw-light'>Event bearbeiten: $row[eventName]</h2>";
        echo $successMessage;
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="p-4 alert alert-warning">

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="eventNameInput" class="form-label">Event Name</label>
                            <input type="text" name="eventName" class="form-control" id="eventNameInput" value="<?php echo $row['eventName']; ?>" required><br>
                            <input type="hidden" name="eventID" value="<?php echo $row["eventID"]; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $eventKategorien = ["Ballett", "Klassikkonzert", "Kunstausstellung", "Musical", "Oper", "Operette", "Rave", "Rockkonzert"];
                            $eventMonate = ["Jänner", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
                            $eventBundeslaender = ["Burgenland", "Kärnten", "Niederösterreich", "Oberösterreich", "Salzburg", "Steiermark", "Tirol", "Vorarlberg", "Wien"];

                            echo "<label for='categoryInput' class='form-label'>Kategorie</label>";
                            echo "<select name='eventKategorie' id='categoryInput' class='form-select' >";
                            foreach ($eventKategorien as $einzelKategorie) {
                                $selected = '';
                                if ($row['eventKategorie'] == $einzelKategorie) {
                                    $selected = 'selected';
                                }
                                echo "<option value='$einzelKategorie' $selected>$einzelKategorie</option>";
                            }
                            echo "</select>";

                            echo "</div>";
                            echo "<div class='col-md-4'>";

                            echo "<label for='bundeslandInput' class='form-label'>Bundesland</label>";
                            echo "<select name='eventBundesland' id='bundeslandInput' class='form-select'>";
                            foreach ($eventBundeslaender as $eventBundesland) {
                                $selected = '';
                                if ($row['eventBundesland'] == $eventBundesland) {
                                    $selected = 'selected';
                                }
                                echo "<option value='$eventBundesland' $selected>$eventBundesland</option>";
                            }
                            echo "</select>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label for="eventStartDatumSelect" class="form-label">Startdatum</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <select name='startDatumTag' id="eventStartDatumSelect" class='form-select'>
                                <?php
                                for ($nummerTag = 1; $nummerTag <= 31; $nummerTag++) {
                                    $selected = "";
                                    if ($eventStartDatumExplodedTag == $nummerTag) {
                                        $selected = "selected";
                                    }
                                    echo "<option value='$nummerTag' $selected>$nummerTag</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name='startDatumMonat' class='form-select'>
                                <?php
                                foreach ($eventMonate as $monatsNummer => $monatName) {
                                    $selected = "";
                                    $eigentlicheMonatsnummer = $monatsNummer + 1;
                                    if ($eventStartDatumExplodedMonat == $eigentlicheMonatsnummer) {
                                        $selected = "selected";
                                    }
                                    echo "<option value='$eigentlicheMonatsnummer' $selected>$monatName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name='startDatumJahr' class='form-select'>
                                <?php
                                $currentYear = (int)date("Y");
                                $pastYear = $currentYear - 10;
                                $futureYear = (int)$currentYear + 10;
                                for ($yearIterator = $pastYear; $yearIterator <= $futureYear; $yearIterator++) {
                                    $selected = "";
                                    if ($eventStartDatumExplodedJahr == $yearIterator) {
                                        $selected = "selected";
                                    };
                                    echo "<option value='$yearIterator' $selected>$yearIterator</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label for="eventEndDatumSelect" class="form-label">Enddatum</label>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-2">
                            <select name="endDatumTag" id="eventEndDatumSelect" class='form-select'>
                                <?php
                                for ($nummerTag = 1; $nummerTag <= 31; $nummerTag++) {
                                    $selected = "";
                                    if ($eventEndDatumExplodedTag == $nummerTag) {
                                        $selected = "selected";
                                    }
                                    echo "<option value='$nummerTag' $selected>$nummerTag</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name='endDatumMonat' class='form-select'>
                                <?php
                                foreach ($eventMonate as $monatsNummer => $monatName) {
                                    $selected = "";
                                    $eigentlicheMonatsnummer = $monatsNummer + 1;
                                    if ($eventEndDatumExplodedMonat == $eigentlicheMonatsnummer) {
                                        $selected = "selected";
                                    }
                                    echo "<option value='$eigentlicheMonatsnummer' $selected>$monatName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name='endDatumJahr' class='form-select'>
                                <?php
                                $currentYear = (int)date("Y");
                                $pastYear = $currentYear - 10;
                                $futureYear = (int)$currentYear + 10;
                                for ($yearIterator = $pastYear; $yearIterator <= $futureYear; $yearIterator++) {
                                    $selected = "";
                                    if ($eventEndDatumExplodedJahr == $yearIterator) {
                                        $selected = "selected";
                                    };
                                    echo "<option value='$yearIterator' $selected>$yearIterator</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label for="BeschreibungInput" class="form-label">Beschreibung</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <textarea name="eventBeschreibung" id="BeschreibungInput" class='form-control' rows="6"><?php echo $row["eventBeschreibung"]; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <input type="submit" name="speichern" class="btn btn-primary" value="Event speichern">
                    <a href="editor-overview.php" class="btn btn-secondary">Zum Redaktionsbereich</a>
                </div>
            </div>
        </form>


    </main>

    <?php
    require_once "include/include_footer.php";
    ?>