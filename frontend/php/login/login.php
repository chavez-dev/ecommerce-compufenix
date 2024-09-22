<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Login - Compufenix</title>

	<!-- STYLE CSS -->
	<link rel="stylesheet" href="../../css/login/login.css"/>
	<link rel="stylesheet" href="../../../backend/validacion/validar_login.php"/>
	<!-- ICONOS -->
	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
	<!-- ALERTAS -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
	<div class="wrapper">
		<span class="bg-animate"></span>
		<span class="bg-animate2"></span>
		<div class="form-box login">
			<h2 class="animation" style="--i:0; --j:21;">Login</h2>
			<form method="post"  id="loginForm">
				<div class="input-box animation" style="--i:1; --j:22;">
					<input value="" id="logina" name="usuario" type="text" required />
					<label for="logina">Usuario</label>
					<i class="bx bxs-user"></i>
				</div>
				<div class="input-box animation" style="--i:2; --j:23;">
					<input value="" id="clavea" name="password" type="password" required />
					<label for="clavea">Password</label>
					<i class="bx bxs-lock-alt"></i>
				</div>
				<div class="form-group has-feedback" hidden>
					<!--<label>EMPRESA</label><br>-->
					<select name="empresa" id="empresa" class="form-control">
						<option value="ticom_wfacx" selected="true">
							ticom_wfacx						</option>
					</select>
					<span class="fa fa-bd form-control-feedback"></span>
				</div>
				<button id="btnIngresar" type="submit" class="btn animation" style="--i:3; --j:24;">Entrar</button>
				<div class="logreg-link animation" style="--i:4; --j:25;">
					<p>
						Olvidaste tu clave? <a href="#" class="register-link">Clic aqui</a>
					</p>
				</div>
			</form>
		</div>

		<div class="info-text login">
			<h2 class="animation" style="--i:0; --j:19;">COMPUFENIX</h2>
			<p class="animation" style="--i:1; --j:20;">Plataforma de Comercio de<br>Equipos de Cómputo</p>
		</div>

		<div class="form-box register">
			<h2 class="animation" style="--i:17; --j:0;">Recuperar Contraseña</h2>
			<form action="">
				<div class="input-box animation" style="--i:18; --j:1;">
					<input type="text" required />
					<label>Correo Electrónico</label>
					<i class="bx bxs-user"></i>
				</div>
				<div hidden class="input-box animation" style="--i:19; --j:2;">
					<input type="password" required />
					<label>Password</label>
					<i class="bx bxs-lock-alt"></i>
				</div>
				<button type="submit" class="btn animation" style="--i:20; --j:3;">Cambiar</button>
				<div class="logreg-link animation" style="--i:21; --j:4;">
					<p>
						Ya tienes cuenta? <a href="#" class="login-link">Clic aqui</a>
					</p>
				</div>
			</form>
		</div>

		<div class="info-text register">
			<h2 class="animation" style="--i:17; --j:0;">COMPUFENIX</h2>
			<p class="animation" style="--i:18; --j:1;">Plataforma de Comercio de<br>Equipos de Cómputo</p>
		</div>
	</div>


	<script>

		//Vinculamos el input con el boton para que funcione con INTRO
        var input = document.getElementById("clavea");
        var boton = document.getElementById("btnIngresar");
        input.addEventListener("keydown", function(event) {
        if (event.keyCode === 13) {
            boton.click();
        }
        });

		$(document).ready(function () {
			// Manejo del envío del formulario mediante AJAX
			$('#loginForm').on('submit', function(e) {
				e.preventDefault(); // Evita el envío tradicional del formulario

				// Realiza la solicitud AJAX
				$.ajax({
					type: 'POST',
					url: '../../../backend/validacion/validar_login.php',
					data: $(this).serialize(),
					success: function (response) {
						// Maneja la respuesta del servidor
						if (response === 'success') {
							// Redirige o realiza alguna acción después del inicio de sesión exitoso
							window.location.href = '../admin/dashboard.php';
						} else {
							// Muestra un mensaje de error o realiza alguna acción para manejar el inicio de sesión fallido
							Swal.fire({
								icon: "error",
								title: "Datos Invalidos",
								html: "Usuario o Password incorrectos,<br> Reintente otra vez!"
							});
						}
					}
				});
			});
		});
	</script>

	<script src="../../js/login/login.js"></script>
</body>

</html>