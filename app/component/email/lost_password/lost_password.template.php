<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Recuperar contraseña</title>
	</head>
	<body>
		<p>¡Hola <?php echo $values['name'] ?>!</p>

		<p>
			Hemos recibido una solicitud para solicitar una nueva contraseña. En caso de que no hayas sido tú, simplemente ignora este email. Si quieres solicitar una nueva contraseña haz click en este enlace:
		</p>

		<p>
			<a href="https://casa.osumi.es/new-password/<?php echo $values['token'] ?>">
				https://casa.osumi.es/new-password/<?php echo $values['token'] ?>
			</a>
		</p>

		<p>Este enlace será valido durante 24 horas. Una vez transcurrido ese tiempo tendrás que solicitar uno nuevo.</p>

		<p>¡Gracias!</p>
	</body>
</html>
