<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nordpool prices.</title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
</head>
<body>
    <?php
    date_default_timezone_set('Europe/Riga');

    // Database information.
    $serverName ='127.0.0.1';
    $userName = 'dbman';
    $pass = 'pw';
    $db_name = 'karlis_barbars';

    try {
        // Connect to database
        $conn = new mysqli($serverName, $userName, $pass, $db_name);
    // If connection wasnt possible, throw out exception.
    } catch(SQLException $e){
        echo "Connection failed: " . $e->getMessage();
    }

    try {
        // Get json data.
        $jsondata = json_decode(file_get_contents('http://lax.lv/nordpool.json'), true);
        $lastimport = json_decode(file_get_contents('lastimport.json'), true);
    // If no file, throw out exception.
    } catch(Exception $e) {
        throw new Exception('Sorri, nav fails.');
    }

    $data = $jsondata['byPriceToday'];

    // Graph arrays, sort them.
    $graphDate = [];
    $graphPrice = [];
    foreach($data as $key => $value) {
        $graphDate[] = date('H', strtotime($key)).":00";
        $graphPrice[] = $value;
    }
    array_multisort($graphDate, $graphPrice);

    // If current date is not equal to current date, update items in database.
    if($lastimport['date'] != date('Y-m-d', time())) {
        $conn->query("TRUNCATE TABLE nordpool");
        foreach($data as $key => $value) {

            $time = date('H', strtotime($key));

            // Insert data into database.
            $conn->query("INSERT INTO `nordpool` (`time`, `price`) VALUES ('$time', '$value')");
        }
        // Import current date, when imported, into lastimport.json
        $lastimport['date'] = date('Y-m-d', time());
        file_put_contents('lastimport.json', json_encode($lastimport));
    }

    // Get the average price.
    $result = $conn->query("SELECT AVG(price) FROM nordpool");
    $avgprice = round($result->fetch_array()[0], 2);

    // Get the Max price
    $result = $conn->query("SELECT * FROM nordpool WHERE price = (SELECT MAX(price) FROM nordpool)");
    $maxprice = $result->fetch_array();

    // Get the Min price
    $result = $conn->query("SELECT * FROM nordpool WHERE price = (SELECT MIN(price) FROM nordpool)");
    $minprice = $result->fetch_array();

    // Get current hour and next two.
    $currentnext = $conn->query("SELECT * FROM nordpool WHERE `time` >= ".date('H')." ORDER BY time ASC LIMIT 2 ");
    
    // Set default sort to be 'time', if user clicks sort button, change it to that.
    $sortby = isset($_GET['sort']) ? $_GET['sort'] : 'time';
    $hideData = false;
    
    if ($sortby == 'lowprice') {
        $data = $conn->query("SELECT * FROM nordpool ORDER BY price ASC");
    } elseif ($sortby == 'highprice') {
        $data = $conn->query("SELECT * FROM nordpool ORDER BY price DESC");
    } elseif ($sortby == 'time') {
        $data = $conn->query("SELECT * FROM nordpool ORDER BY time ASC");
    } elseif ($sortby == 'underavg') {
        $data = $conn->query("SELECT * FROM nordpool WHERE `price` <= (SELECT AVG(price) FROM nordpool) ORDER BY time ASC");
    } elseif($sortby == 'graph'){
        $hideData = true;
    }else {
        $data = $conn->query("SELECT * FROM nordpool ORDER BY time ASC");
    }

    // If theres a selected hour, find the id from selected hour, change data to that.
    if(isset($_GET['selecthour'])) {
        $selectedhour = $_GET['selecthour'];
        $data = $conn->query("SELECT * FROM nordpool WHERE time = '$selectedhour'");
    }
    
    ?>
    <div class="container">
        <div class="box">
            <div class="title">
                <h1>Nordpool prices today. </h1>
                <span class="currentdate"><?= date('j. M H:i') ?></span>
            </div>
            <!-- NAVIGATION STARTS -->
            <nav>
                <div class="dropdown">
                    <div class="sortby">
                        <button>order by <i class="fas fa-caret-down"></i></button>
                        <ul>
                            <li><a href="index.php?sort=lowprice">Lowest Price</a></li>
                            <li><a href="index.php?sort=highprice">Highest Price</a></li>
                            <li><a href="index.php?sort=time">Time</a></li>
                        </ul>
                    </div>
                    <div class="underavg">
                        <a href="index.php?sort=underavg"><button>prices under average <i class="fab fa-pagelines"></i></button></a>
                    </div>
                    <div class="graph">
                        <a href="index.php?sort=graph"><button>graph <i class="fas fa-chart-line"></i></button></a>
                    </div>
                    <div class="searchhour">
                        <button>select hour <i class="fas fa-caret-down"></i></button>
                        <ul>
                            <? for($x = 1; $x <= 24; $x++) { ?>
                            <li><a href="index.php?selecthour=<?= $x ?>"><?= $x ?>:00</a></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- NAVIGATION ENDS -->

            <!-- DATA DISPLAY -->
            <div class="datacontainer">
                <? if($hideData == true){ ?>
                    <div style="width: 800px; height: 600px;">
                        <canvas id="myTemperatureChart"></canvas>
                    </div>
                <? } if($hideData == false){ ?>
                    <div class="data">
                        <ul>
                            <? while($nordpool = $data->fetch_array(MYSQLI_ASSOC)){ ?>
                                <li>
                                    <span class="time"><i>Hour: </i><b><?php echo $nordpool['time'].":00" ?></b></span>
                                    <span class="price"><i>Price:  </i><b><?php echo $nordpool['price'] ?></b></span>
                                </li>
                            <? }?>
                        </ul>
                    </div>
                    <div class="shortdata">
                        <ul>
                            <?  $i=0;
                                while($row = $currentnext->fetch_array(MYSQLI_ASSOC)){
                                    if($i<1){
                                        $text = "Current Hour";
                                    } else {
                                        $text = "Next Hour";
                                    } ?>
                                <li>
                                    <span class="time"><?= $text ?>: <b><?= $row['time'].":00" ?></b></span>
                                    <span class="price">Price:  <b><?= $row['price'] ?></b></span>
                                </li>
                            <? $i++; } ?>

                            <br><br>
                            <li><span>Average price: <b> <?= $avgprice ?> </b> </span></li>
                            <li><span>Highest price: <b> <?= $maxprice['price'] ?> </b> at <b><?= $maxprice['time'] ?>:00</b></span></li>
                            <li><span>Lowest price: <b> <?= $minprice['price'] ?> </b> at <b><?= $minprice['time'] ?>:00</b></span></li>

                        </ul>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
    <!-- DATA CHART -->
    <script>
			var ctx = document.getElementById('myTemperatureChart').getContext('2d');
			new Chart(ctx, {
				type: 'line',
				data: {
					labels: <?=json_encode($graphDate)?>,
					datasets: [{
						label: 'Price',
						data: <?=json_encode($graphPrice)?>,
						backgroundColor: 'transparent',
						borderColor: '#67b26f'
					}]
				}
			});
	</script>
</body>
</html>
