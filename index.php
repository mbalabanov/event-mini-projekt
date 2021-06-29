<?php
require_once "include/include_db.php";
require_once "include/include_head.php";
$dateToday = date("Y-m-d");
?>



<body>

    <main class="container">

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
                                    <img src='img/$carouselItem[eventBild]' class='d-block w-100 rounded' alt='$carouselItem[eventName]'>
                                    <div class='carousel-caption d-none d-md-block'>
                                        <h5>$carouselItem[eventName]</h5>
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

        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Events demnächst</h2>
            </div>
        </div>

        <div class="row">
            <?php
            $sql = "SELECT * FROM event WHERE eventStartDatum > $dateToday ORDER BY eventStartDatum ASC LIMIT 6";
            $stmt = $db->query($sql);
            while ($row = $stmt->fetch()) {
                echo "
                    <div class='col-md-4 my-2 p-1'>
                        <div class='border rounded bg-light p-3 text-center'>
                            <h4>$row[eventName]</h4>
                            <p><img src='img/$row[eventBild]' alt='$row[eventName]' class='img-fluid rounded'/></p>
                            <h5>$row[eventKategorie] in $row[eventBundesland]</h5>
                    ";

                $eventStartDatumExploded = explode("-", $row["eventStartDatum"]);
                $eventEndDatumExploded = explode("-", $row["eventEndDatum"]);

                $eventStartMonatNumerisch = (int)$eventStartDatumExploded[1];
                $eventEndMonatNumerisch = (int)$eventEndDatumExploded[1];

                echo "
                            <p><strong>Start:</strong> $eventStartDatumExploded[2]. $eventMonate[$eventStartMonatNumerisch] $eventStartDatumExploded[0]<br/><strong>Ende:</strong> $eventEndDatumExploded[2]. $eventMonate[$eventEndMonatNumerisch] $eventEndDatumExploded[0]</p> 
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