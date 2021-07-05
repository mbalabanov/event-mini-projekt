<?php
session_start();
session_regenerate_id(true);
if (empty($_SESSION["userID"])) {
    header("location:logout.php");
}

$uploadedImage = "default.jpg";
$imageFolder = "img";
$imagePath = __DIR__;
$fileName = "";

require_once "include/include_db.php";

if (isset($_POST["senden"])) {
    $eventName = trim(strip_tags($_POST["eventName"]));

    $fileName = $_FILES["imageFile"]["name"];

    if ($_FILES["imageFile"]["name"] !== "") {

        $endung = @end(explode(".", $fileName));
        $uploadedImage = rand(0, 100) . time() . "." . strtolower($endung);
        move_uploaded_file(
            $_FILES["imageFile"]["tmp_name"],
            "$imagePath/$imageFolder/$uploadedImage"
        );
    }
    $eventStartDatumTag = (int)trim(strip_tags($_POST["startDatumTag"]));
    $eventStartDatumMonat = (int)trim(strip_tags($_POST["startDatumMonat"]));
    $eventStartDatumJahr = (int)trim(strip_tags($_POST["startDatumJahr"]));

    $eventEndDatumTag = (int)trim(strip_tags($_POST["endDatumTag"]));
    $eventEndDatumMonat = (int)trim(strip_tags($_POST["endDatumMonat"]));
    $eventEndDatumJahr = (int)trim(strip_tags($_POST["endDatumJahr"]));

    if ($eventStartDatumTag < 10) {
        $eventStartDatumTag = "0" . $eventStartDatumTag;
    };
    if ($eventEndDatumTag < 10) {
        $eventEndDatumTag = "0" . $eventEndDatumTag;
    };

    if ($eventStartDatumMonat < 10) {
        $eventStartDatumMonat = "0" . $eventStartDatumMonat;
    };
    if ($eventEndDatumMonat < 10) {
        $eventEndDatumMonat = "0" . $eventEndDatumMonat;
    };

    $eventStartDatum = $eventStartDatumJahr . "-" . $eventStartDatumMonat . "-" . $eventStartDatumTag;
    $eventEndDatum = $eventEndDatumJahr . "-" . $eventEndDatumMonat . "-" . $eventEndDatumTag;

    $eventKategorie = trim(strip_tags($_POST["eventKategorie"]));
    $eventBundesland = trim(strip_tags($_POST["eventBundesland"]));
    $eventBeschreibung = trim(strip_tags($_POST["eventBeschreibung"]));

    $sql = "INSERT INTO event
    (eventName,eventStartDatum,eventEndDatum,eventKategorie,eventBundesland,eventBeschreibung,eventBild)
    VALUES
    (:eventName,:eventStartDatum,:eventEndDatum,:eventKategorie,:eventBundesland,:eventBeschreibung,:eventBild)
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":eventName", $eventName);
    $stmt->bindParam(":eventStartDatum", $eventStartDatum);
    $stmt->bindParam(":eventEndDatum", $eventEndDatum);
    $stmt->bindParam(":eventKategorie", $eventKategorie);
    $stmt->bindParam(":eventBundesland", $eventBundesland);
    $stmt->bindParam(":eventBeschreibung", $eventBeschreibung);
    $stmt->bindParam(":eventBild", $uploadedImage);
    $stmt->execute();

    header("location:editor-overview.php");
}

// Bestehenden Event aus DB löschen
if (isset($_GET["loeschen"])) {
    $eventID = (int)$_GET["loeschen"];
    $sql = "DELETE FROM event 
    WHERE eventID = :eventID";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":eventID", $eventID);
    $stmt->execute();

    header("location:$_SERVER[PHP_SELF]");
}

?>

<?php require_once "include/include_head.php"; ?>

<body class="alert-primary">
    <main class="container bg-white p-2">

        <?php require_once "include/include_nav.php"; ?>

        <div class="row mt-2">
            <div class="col-md-12">
                <h2 class="fw-light">Neuen Event Erstellen</h2>
            </div>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" class="p-4 alert alert-secondary">

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="eventNameInput" class="form-label">Event Name</label>
                            <input type="text" name="eventName" class="form-control" id="eventNameInput" required><br>
                        </div>
                        <div class="col-md-3">
                            <?php
                            $eventKategorien = ["Ballett", "Klassikkonzert", "Kunstausstellung", "Musical", "Oper", "Operette", "Rave", "Rockkonzert"];
                            $eventMonate = ["Jänner", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
                            $eventBundeslaender = ["Burgenland", "Kärnten", "Niederösterreich", "Oberösterreich", "Salzburg", "Steiermark", "Tirol", "Vorarlberg", "Wien"];

                            echo "<label for='categoryInput' class='form-label'>Kategorie</label>";
                            echo "<select name='eventKategorie' id='categoryInput' class='form-select' >";
                            foreach ($eventKategorien as $einzelKategorie) {
                                echo "<option value='$einzelKategorie'>$einzelKategorie</option>";
                            }
                            echo "</select>";

                            echo "</div>";
                            echo "<div class='col-md-3'>";

                            echo "<label for='bundeslandInput' class='form-label'>Bundesland</label>";
                            echo "<select name='eventBundesland' id='bundeslandInput' class='form-select'>";
                            foreach ($eventBundeslaender as $eventBundesland) {
                                echo "<option value='$eventBundesland'>$eventBundesland</option>";
                            }
                            echo "</select></div>";
                            ?>
                            <div class="col-md-3">
                                <label for="imageFile" class="form-label">Bild Datei</label>
                                <input class="form-control" type="file" name="imageFile" id="imageFile">
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
                            <div class="col-md-3">
                                <select name='startDatumTag' id="eventStartDatumSelect" class='form-select'>
                                    <?php
                                    for ($nummerTag = 1; $nummerTag <= 31; $nummerTag++) {
                                        echo "<option value='$nummerTag'>$nummerTag</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name='startDatumMonat' class='form-select'>
                                    <?php
                                    foreach ($eventMonate as $monatsNummer => $monatName) {
                                        $eigentlicheMonatsnummer = $monatsNummer + 1;
                                        echo "<option value='" . $eigentlicheMonatsnummer . "'>$monatName</option>";
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
                                        if ($currentYear == $yearIterator) {
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
                            <div class="col-md-3">
                                <select name="endDatumTag" id="eventEndDatumSelect" class='form-select'>
                                    <?php
                                    for ($nummerEndTag = 1; $nummerEndTag <= 31; $nummerEndTag++) {
                                        echo "<option value='" . $nummerEndTag . "'>" . $nummerEndTag . "</option>";
                                    };
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name='endDatumMonat' class='form-select'>
                                    <?php
                                    foreach ($eventMonate as $monatsNummer => $monatName) {
                                        $eigentlicheMonatsnummer = $monatsNummer + 1;
                                        echo "<option value='" . $eigentlicheMonatsnummer . "'>$monatName</option>";
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
                                        if ($currentYear == $yearIterator) {
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
                                <textarea name="eventBeschreibung" id="BeschreibungInput" class='form-control' rows="6"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <input type="submit" name="senden" class="btn btn-primary" value="Event speichern">
                        <a href="editor-overview.php" class="btn btn-secondary">Zum Redaktionsbereich</a>
                    </div>
                </div>
        </form>
    </main>

    <?php
    require_once "include/include_footer.php";
    ?>