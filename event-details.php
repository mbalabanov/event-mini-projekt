<?php
require_once "include/include_db.php";
require_once "include/include_head.php";

if (isset($_REQUEST["eventID"])) {
    $eventID = (int)$_REQUEST["eventID"];
    $idErrorMessage = "";
}

if (!isset($_REQUEST["eventID"])) {
    $idErrorMessage = "<div class='alert alert-danger text-center'>Es wurde kein Event gefunden.</div>";
}

?>

<body class="alert-primary">
    <main class="container bg-white p-2">

        <?php
        require_once "include/include_nav.php";

        echo $idErrorMessage;

        $eventMonate = ["Jänner", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];

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

        ?>

        <?php echo "<h2>$row[eventName]</h2>"; ?>
        <div class="row mb-5">
            <div class="col-md-6">
                <?php
                echo "<img class='img-fluid rounded my-2' src='img/$row[eventBild]' alt='$row[eventName]'/>";
                ?>
            </div>
            <div class="col-md-6">
                <?php
                $endMonatsIndex = $eventEndDatumExplodedMonat - 1;
                $startMonatsIndex = $eventStartDatumExplodedMonat - 1;
                echo "<p><strong>Name: </strong>$row[eventName]</p>";
                echo "<p><strong>Kategorie: </strong>$row[eventKategorie]</p>";
                echo "<p><strong>Bundesland: </strong>$row[eventBundesland]</p>";
                echo "<p><strong>Start: </strong>$eventStartDatumExplodedTag. $eventMonate[$startMonatsIndex] $eventStartDatumExplodedJahr<br/>";
                echo "<strong>Ende: </strong>$eventEndDatumExplodedTag. $eventMonate[$endMonatsIndex] $eventEndDatumExplodedJahr</p>";
                echo "<p><strong>Beschreibung:</strong><br/>$row[eventBeschreibung]</p>";
                ?>
                <a href="event-list.php" class="btn btn-primary">Zur Event-Liste</a>
            </div>
        </div>
    </main>

    <?php
    require_once "include/include_footer.php";
    ?>