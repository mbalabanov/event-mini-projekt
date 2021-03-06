<?php
session_start();
session_regenerate_id(true);
require_once "include/include_db.php";

if (isset($_POST["einloggen"])) {
    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) !== false) {
        $sql = "SELECT * FROM user
        WHERE userEmail = :email";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $_POST["email"]);
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row !== false) {
            if (password_verify($_POST["password"], $row["userPassword"])) {
                $_SESSION["userID"] = $row["userID"];
                $_SESSION["userName"] = $row["userName"];
                $_SESSION["userRole"] = $row["userRole"];

                header("location:editor-overview.php");
            }
        }
    }
}

require_once "include/include_head.php";
?>

<body class="alert-primary">
    <main class="container bg-white p-2">

        <?php
        require_once "include/include_nav.php";
        ?>

        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <h2 class="fw-light">Einloggen</h2>
                <p>Einloggen mit folgendem Test-Account:<br/><code>user@event.com</code><br/><code>Test1234</code></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2 alert alert-secondary">
                <form method="post" class="row" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);  ?>">
                    <div class="mb-3 col-md-6">
                        <label for="inputEmail" class="form-label">Email Adresse</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" aria-describedby="emailHelp"  required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password" required>
                    </div>
                    <p class="text-end mt-2">
                        <a class="btn btn-secondary" href="index.php">Zur??ck</a>
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