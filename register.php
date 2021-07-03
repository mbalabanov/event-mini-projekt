<?php
if(isset($_SESSION["userID"]))
{
    session_destroy();
    unset($_SESSION["userID"]);
};
require_once "include/include_db.php";
require_once "include/include_head.php";
?>

<body class="alert-primary">
	<main class="container bg-white p-2">

		<?php
		require_once "include/include_nav.php";
		?>

		<div class="row mt-5">
			<div class="col-md-12 text-center">
				<h2 class="fw-light">Neuen User Registrieren</h2>
				<p>Das Passwort muss mindestens acht Zeichen lang sein.<br />Sie können mit folgedem bestehenden Test-User <a href="login.php">einloggen</a>: user@event.com, Test1234</p>
			</div>
		</div>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="row">
				<div class="col-md-8 offset-md-2 alert alert-secondary">

					<?php

					//Hilfsvariablen
					$userName = "";
					$email = "";
					$password1 = "";
					$password2 = "";
					$zustimmung = "";

					$nutzerZustimmung = true;
					$passwordError = "";

					if (isset($_POST["registrieren"])) {
						$userName = strip_tags($_POST["userName"]);
						$email = $_POST["email"];
						$password1 = $_POST["password1"];
						$password2 = $_POST["password2"];

						if (isset($_POST["zustimmung"])) {
							$zustimmung = $_POST["zustimmung"];
						} else {
							$nutzerZustimmung = false;
							$passwordError .= "<div class='alert alert-danger text-center'>Bitte stimmen Sie den Nutzungsbestimmungen zu.</div>";
						}

						if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
							$nutzerZustimmung = false;
							$passwordError .= "<div class='alert alert-danger text-center'>Das ist keine gültige Email-Adresse</div>";
						} else {
							$sql = "SELECT * FROM user
			WHERE userEmail = :email";

							$stmt = $db->prepare($sql);
							$stmt->bindParam(":email", $email);
							$stmt->execute();
							$row = $stmt->fetch();

							if ($row !== false) {
								$nutzerZustimmung = false;
								$passwordError .= "<div class='alert alert-danger text-center'>Diese Email-Adresse ist bereits registriert.</div>";
							}
						}

						if (strlen($password1) < 8) {
							$nutzerZustimmung = false;
							$passwordError .= "<div class='alert alert-danger text-center'>Das Passwort muss mindestens acht Zeichen lang sein.</div>";
						}

						if ($password1 <> $password2) {
							$nutzerZustimmung = false;
							$passwordError .= "<div class='alert alert-danger text-center'>Das eingegebene Passwort ist nicht korrekt</div>";
						}

						$muster1 = "/[A-Z]/";
						$muster2 = "/[a-z]/";
						$muster3 = "/[0-9]/";

						if (
							preg_match($muster1, $password1) &&
							preg_match($muster2, $password1) &&
							preg_match($muster3, $password1)
						) {
						} else {
							$nutzerZustimmung = false;
							$passwordError .= "<div class='alert alert-warning text-center'>Bitte beachten Sie die Passwortrichtlinien.</div>";
						}

						if ($nutzerZustimmung === true) {
							$passwordError = "<div class='alert alert-success text-center'>Vielen Dank für die Registrierung!<br><a href='login.php' class='btn btn-primary'>Zum Login</a></div>";

							$options = ["cost" => 12];
							$password1 = password_hash($password1, PASSWORD_BCRYPT, $options);

							$sql = "INSERT INTO user
			(userName,userEmail,userPassword)
			VALUES
			(:name,:email,:password)";

							$stmt = $db->prepare($sql);
							$stmt->bindParam(":name", $userName);
							$stmt->bindParam(":email", $email);
							$stmt->bindParam(":password", $password1);
							$stmt->execute();

							$userName = "";
							$userVorname = "";
							$email = "";
							$password1 = "";
							$password2 = "";
							$zustimmung = "";
						}
					}

					echo $passwordError;
					?>

					<div class="row">
						<div class="col-md-6">
							<label for="inputUsername" class="form-label">Username</label>
							<input type="text" name="userName" value="<?php echo $userName; ?>" id="inputUsername" class="form-control">

							<label for="inputEmail" class="form-label">Email</label>
							<input type="text" name="email" value="<?php echo $email; ?>" id="inputEmail" class="form-control">
						</div>
						<div class="col-md-6">
							<label for="inputPassword" class="form-label">Passwort</label>
							<input type="password" name="password1" value="<?php echo $password1; ?>" id="inputPassword" class="form-control">
							<label for="inputPasswordRepeat" class="form-label">Passwort wiederholen</label>
							<input type="password" name="password2" value="<?php echo $password2; ?>" id="inputPasswordRepeat" class="form-control">

							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="nutzerZustimmung" name="zustimmung" id="zustimmungCheckbox">
								<label class="form-check-label" for="zustimmungCheckbox" <?php if ($zustimmung == "nutzerZustimmung") {
																								echo "checked";
																							} ?>>
									Nutzungsbestimmungen zustimmen
								</label>
							</div>

						</div>
					</div>
					<p class="text-end"><a class="btn btn-secondary mx-1" href="index.php">Zurück</a><input type="submit" name="registrieren" class="btn btn-primary" value="Registrieren"></p>
				</div>
			</div>
		</form>
	</main>

	<?php
	require_once "include/include_footer.php";
	?>