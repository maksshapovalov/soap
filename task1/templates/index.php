<html>
<head>
	<title>SOAP I</title>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
	<meta charset="utf8">
</head>
</head>
<body>
	
	<div class="container">
		<h3>Temperature Converter</h3>
		<form method="post" action="" name="converter">
			<div class="form-row">
				<div class="form-group col-md-2">
					<label for="inputValue">Value</label>
					<input type="text" class="form-control" id="inputValue" name="postValue" required>
				</div>
				<div class="form-group col-md-4">
					<label for="inputConvert">Convert</label>
					<select id="inputConvert" class="form-control" name="convert" required>
						<option value="">Choose...</option>
						<option value="CelsiusToFahrenheit">Celsius to Fahrenheit</option>
						<option value="FahrenheitToCelsius">Fahrenheit to Celsius</option>
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-dark">Converte</button>
		</form>
	
	
	<?php include $content_view; ?>
	</div>
	
</body>
</html>
