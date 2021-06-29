<?php
require_once "include/include_db.php";
require_once "include/include_head.php";
?>

<body>
	<main class="container">

		<?php

		require_once "include/include_nav.php";

		//Hilfsvariablen
		$userName = "";
		$email = "";
		$password1 = "";
		$password2 = "";
		$zustimmung = "";

		$ok = true;
		$passwordError = "";

		if (isset($_POST["registrieren"])) {
			//Zuweisung an die Variablen
			$userName = strip_tags($_POST["userName"]);
			$email = $_POST["email"];
			$password1 = $_POST["password1"];
			$password2 = $_POST["password2"];

			//Prüfung ob AGB angehakt
			if (isset($_POST["zustimmung"])) {
				$zustimmung = $_POST["zustimmung"];
			} else {
				$ok = false;
				$passwordError .= "Sie müssen den AGB zustimmen!<br>";
			}

			//Prüfung ob Email
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$ok = false;
				$passwordError .= "Keine gültige email!<br>";
			} else {
				//Prüfen, ob Email existiert
				$sql = "SELECT * FROM user
			WHERE userEmail = :email";

				$stmt = $db->prepare($sql);
				$stmt->bindParam(":email", $email);
				$stmt->execute();
				$row = $stmt->fetch();

				if ($row !== false) {
					$ok = false;
					$passwordError .= "Email existiert bereits!<br>";
				}
			}

			//Prüfung PW Mind. 8 Zeichen hat
			if (strlen($password1) < 8) {
				$ok = false;
				$passwordError .= "<div class='alert alert-danger'>Das Passwort muss mind 8 Zeichen haben!</div>";
			}

			//Prüfung ob PW übereinstimmt
			if ($password1 <> $password2) {
				$ok = false;
				$passwordError .= "Das Passwort stimmt nicht!<br>";
			}

			// Passwort-Check
			$muster1 = "/[A-Z]/";
			$muster2 = "/[a-z]/";
			$muster3 = "/[0-9]/";

			if (
				preg_match($muster1, $password1) &&
				preg_match($muster2, $password1) &&
				preg_match($muster3, $password1)
			) {
			} else {
				$ok = false;
				$passwordError .= "<div class='alert alert-danger'>Bitte beachten Sie die Passwortrichtlinien.</div>";
			}

			//Wenn immer noch ok
			if ($ok === true) {
				$passwordError = "<div class='alert alert-success'>Vielen Dank für die Registrierung!<br><a href='login.php' class='btn btn-primary'>Zum Login</a></div>";

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

		<div class="row mt-5">
            <div class="col-md-12 text-center">
                <h2>Neuen User Registrieren</h2>
            </div>
        </div>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="row">
				<div class="col-md-8 offset-md-2 alert alert-secondary">
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
							<input type="checkbox" name="zustimmung" value="ok" <?php if ($zustimmung == "ok") {
																					echo "checked";
																				} ?>>&nbsp;Ich stimme zu<br>
							<input type="submit" name="registrieren" class="btn btn-primary btn-lg" value="Registrieren">
						</div>
					</div>
				</div>
			</div>
		</form>
	</main>

	<?php
	require_once "include/include_footer.php";
	?>