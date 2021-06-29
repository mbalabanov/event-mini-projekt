<?php
require_once "include/include_db.php";

// Neuen Event in DB einfügen
if (isset($_POST["senden"])) {
    $eventName = trim(strip_tags($_POST["eventName"]));

    $eventStartDatumTag = trim(strip_tags($_POST["eventStartDatumTag"]));
    $eventStartDatumMonat = trim(strip_tags($_POST["eventStartDatumMonat"]));
    $eventStartDatumJahr = trim(strip_tags($_POST["eventStartDatumJahr"]));
    $eventStartDatum = $eventStartDatumJahr . "-" . $eventStartDatumMonat . "-" . $eventStartDatumTag;

    $eventEndDatumTag = trim(strip_tags($_POST["eventEndDatumTag"]));
    $eventEndDatumMonat = trim(strip_tags($_POST["eventEndDatumMonat"]));
    $eventEndDatumJahr = trim(strip_tags($_POST["eventEndDatumJahr"]));
    $eventEndDatum = $eventEndDatumJahr . "-" . $eventEndDatumMonat . "-" . $eventEndDatumTag;


    $eventKategorie = trim(strip_tags($_POST["eventKategorie"]));
    $eventBundesland = trim(strip_tags($_POST["eventBundesland"]));
    $eventBeschreibung = trim(strip_tags($_POST["eventBeschreibung"]));

    $sql = "INSERT INTO event
    (eventName,eventStartDatum,eventEndDatum,eventKategorie,eventBundesland,eventBeschreibung)
    VALUES
    (:eventName,:eventStartDatum,:eventEndDatum,:eventKategorie,:eventBundesland,:eventBeschreibung)
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":eventName", $eventName);
    $stmt->bindParam(":eventStartDatum", $eventStartDatum);
    $stmt->bindParam(":eventEndDatum", $eventEndDatum);
    $stmt->bindParam(":eventKategorie", $eventKategorie);
    $stmt->bindParam(":eventBundesland", $eventBundesland);
    $stmt->bindParam(":eventBeschreibung", $eventBeschreibung);
    $stmt->execute();

    header("location:$_SERVER[PHP_SELF]");
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

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <main class="container">

    <?php
        require_once "include/include_nav.php";
    ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="p-24 alert alert-primary">

            <div class="row mt-2">
                <div class="col-md-12">
                    <h2>Neuen Event Erstellen</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="eventNameInput" class="form-label">Event Name</label>
                            <input type="text" name="eventName" class="form-control" id="eventNameInput" required><br>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $eventKategorien = ["Ballett", "Klassikkonzert", "Kunstausstellung", "Musical", "Oper", "Operette", "Rave", "Rockkonzert"];
                            $eventMonate = ["Jänner", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
                            $eventBundeslaender = ["Burgenland", "Kärnten", "Niederösterreich", "Oberösterreich", "Salzburg", "Steiermark", "Tirol", "Vorarlberg", "Wien"];

                            echo "<label for='categoryInput' class='form-label'>Kategorie</label>";
                            echo "<select name='eventKategorie' id='categoryInput' class='form-control'>";
                            foreach ($eventKategorien as $einzelKategorie) {
                                echo "<option value='$einzelKategorie'>$einzelKategorie</option>";
                            }
                            echo "</select>";

                            echo "</div>";
                            echo "<div class='col-md-4'>";

                            echo "<label for='bundeslandInput' class='form-label'>Bundesland</label>";
                            echo "<select name='eventBundesland' id='bundeslandInput' class='form-control'>";
                            foreach ($eventBundeslaender as $eventBundesland) {
                                echo "<option value='$eventBundesland'>$eventBundesland</option>";
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
                            <select name='startDatumTag' id="eventStartDatumSelect" class='form-control'>
                                <?php
                                for ($nummerTag = 1; $nummerTag <= 31; $nummerTag++) {
                                    echo "<option value='$nummerTag'>$nummerTag</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name='startDatumMonat' class='form-control'>
                                <?php
                                foreach ($eventMonate as $monatsNummer => $monatName) {
                                    echo "<option value='$monatsNummer'>$monatName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name='startDatumJahr' class='form-control'>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
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
                            <select name="endDatumTag" id="eventEndDatumSelect" class='form-control'>
                                <?php
                                for ($nummerEndTag = 1; $nummerEndTag <= 31; $nummerEndTag++) {
                                    echo "<option value='" . $nummerEndTag . "'>" . $nummerEndTag . "</option>";
                                };
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name='endDatumMonat' class='form-control'>
                                <?php
                                foreach ($eventMonate as $monatsEndNummer => $monatEndName) {
                                    echo "<option value='" . $monatsEndNummer + 1 . "'>$monatEndName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name='endDatumJahr' class='form-control'>
                                <option>2021</option>
                                <option>2022</option>
                                <option>2023</option>
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
                            <textarea name="eventBeschreibung" id="BeschreibungInput" class='form-control'></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <input type="submit" name="senden" class="btn btn-primary" value="Event speichern">
                </div>
            </div>
        </form>



        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Eventliste</h2>
            </div>
        </div>

        <div class="row">
            <?php
            $sql = "SELECT * FROM event";
            $stmt = $db->query($sql);

            while ($row = $stmt->fetch()) {
                echo "
                    <div class='col-md-4 my-2 p-1'>
                        <div class='border rounded bg-light p-3'>
                            <h4>$row[eventName]</h4>
                            <h5>$row[eventKategorie] in $row[eventBundesland]</h5>
                            <p>Start: $row[eventStartDatum]. Ende: $row[eventEndDatum]</p> 
                            <p><a class='btn btn-danger btn-sm' href='?loeschen=$row[eventID]' onclick='return loeschNachfrage()'>Löschen</a> 
                            <a class='btn btn-primary btn-sm' href='051artikel_update.php?eventID=$row[eventID]'>Ändern</a></p>
                        </div>
                    </div>
                    ";
            }

            ?>
        </div>
        </div>
    </main>
    <script>
        function loeschNachfrage() {
            return confirm("Wollen Sie den Event wirklich löschen?");
        }
    </script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>