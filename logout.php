<?php
    session_start();
    session_regenerate_id(true);
    unset($_SESSION);
    session_destroy();

    header("location:login.php");

    ?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Kalendar</title>
</head>

<body>
    <main>
        <h1>Logged out</h1>
    </main>
</body>

</html>