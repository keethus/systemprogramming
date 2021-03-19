<?
 
$data = file_get_contents('https://emo.lv/weather-api/forecast/?city=cesis,latvia');
$data = json_decode($data);
 
$days = [];
$temperatures = [];
 
foreach($data->list as $day) {
	$days[] = date('Y-m-d', $day->dt);
	$temperatures[] = $day->temp->day;
}
 
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Mans Grafiks</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
	</head>
	<body>
 
		<h1>Temperatūra Cēsīs</h1>
		Turpmākajās 14 dienās
 
		<div style="width: 800px; height: 600px;">
			<canvas id="myTemperatureChart"></canvas>
		</div>
 
		La, la la...
 
		<script>
			var ctx = document.getElementById('myTemperatureChart').getContext('2d');
			new Chart(ctx, {
				type: 'line',
				data: {
					labels: <?=json_encode($days)?>,
					datasets: [{
						label: 'Temperatūra',
						data: <?=json_encode($temperatures)?>,
						backgroundColor: 'transparent',
						borderColor: 'blue'
					}]
				}
			});
		</script>
 
	</body>
</html>