<?php
require_once "include/include_db.php";
require_once "include/include_head.php";
?>

<body class="alert-primary">
    <main class="container bg-white p-2">

        <?php
        require_once "include/include_nav.php";
        ?>

        <?php
        $sql = "SELECT * FROM event";
        $stmt = $db->query($sql);
        $eventMonate = ["Jänner", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
        ?>

        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <h2>Event Liste</h2>
            </div>
        </div>

        <div class="row p-2">
            <?php
            $sql = "SELECT * FROM event";
            $stmt = $db->query($sql);
            while ($row = $stmt->fetch()) {
                echo "
                    <div class='col-md-4 my-2 p-1'>
                        <div class='border rounded bg-light p-3 text-center'>
                            <h4><a href='event-details.php?eventID=$row[eventID]' class='text-decoration-none'>$row[eventName]</a></h4>
                            <p><a href='event-details.php?eventID=$row[eventID]'><img src='img/$row[eventBild]' alt='$row[eventName]' class='img-fluid rounded'/></a></p>
                            <h5>$row[eventKategorie] in $row[eventBundesland]</h5>
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