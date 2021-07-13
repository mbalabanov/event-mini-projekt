<nav class="navbar navbar-expand-lg navbar-light mb-4 py-3 border-bottom border-primary">
    <div class="container-fluid">
        <a class="navbar-brand text-primary" href="index.php">DIGITAL ART ARCHIVEƒ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="event-list.php">Ausstellungsliste</a>
                </li>

                <?php if (isset($_SESSION["userID"])) {
                    echo "<li class='nav-item'><a class='nav-link' href='editor-overview.php'>Redaktionsübersicht</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='create-event.php'>Ausstellung erstellen</a></li>";
                }
                ?>

            </ul>
            <?php if (isset($_SESSION["userID"])) {
                echo "<span class='alert alert-primary'>Eingeloggt als <strong>$_SESSION[userName]</strong><a class='btn btn-danger mx-1' href='logout.php'>Logout</a></span>";
            }
            ?>
            <?php if (empty($_SESSION["userID"])) {
                echo "<a class='btn btn-warning mx-1' href='register.php'>Registrieren</a><a class='btn btn-primary' href='login.php'>Login</a>";
            }
            ?>
        </div>
    </div>
</nav>