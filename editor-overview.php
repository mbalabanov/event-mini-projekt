<?php
session_start();
session_regenerate_id(true);
if (empty($_SESSION["userID"])) {
    header("location:login.php");
}
require_once "include/include_db.php";
require_once "include/include_head.php";

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

<body class="alert-primary">
<main class="container bg-white p-2">

        <?php
        require_once "include/include_nav.php";
        ?>

        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <h2 class="fw-light">Events Redaktionsbereich</h2>
                <p><a href="create-event.php" class="btn btn-primary btn-lg">Neuen Event anlegen</a></p>
            </div>
        </div>

        <div class="row p-2">
            <?php
            $sql = "SELECT * FROM event";
            $stmt = $db->query($sql);

            $eventMonate = ["Jänner", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];

            while ($row = $stmt->fetch()) {
                echo "
                    <div class='col-md-4 my-2 p-1'>
                        <div class='border rounded bg-light p-3 text-center'>
                            <h4 class='fw-light'>$row[eventName]</h4>
                            <p><img src='img/$row[eventBild]' alt='$row[eventName]' class='img-fluid rounded'/></p>
                            <h5 class='fw-light'>$row[eventKategorie] in $row[eventBundesland]</h5>
                    ";

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

                echo "
                            <p><a class='btn btn-danger btn-sm' href='?loeschen=$row[eventID]' onclick='return loeschNachfrage()'>Löschen</a> 
                            <a class='btn btn-warning btn-sm' href='edit-event.php?eventID=$row[eventID]'>Bearbeiten</a></p>
                        </div>
                    </div>
                    ";
            }

            ?>
        </div>
    </main>
    <script>
        function loeschNachfrage() {
            return confirm("Wollen Sie den Event wirklich löschen?");
        }
    </script>

<?php
require_once "include/include_footer.php";
?>