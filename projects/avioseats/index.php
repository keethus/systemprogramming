<?
    include_once 'functions.php';

    const MAX_ROWS = 24; // Change how many rows you want. 
    if($data['general']['rows'] != MAX_ROWS) clearAvailableSeats(); 
    // might change it into a function where it doesn't clear the seats but adds/removes to current seats.
    $seatWarning = '';

    if(isset($_POST['userInput'])) { 
        $userInput = $_POST['userInput'];
        if(validateSpecific($userInput)){ // check if input starts with a letter and is valid.
            setSpecific($userInput);
        } else {
            if(inputLimitCheck($userInput)) { // check if input is 1-5.
                do{ 
                    nextBalancedSeat(); 
                    $userInput--; 
                } while($userInput > 0);
            } else if($userInput == 666) { // Secret key to clear seats.
                clearAvailableSeats();
                $seatWarning =  "Plane seats successfully reset!";
            } else $seatWarning =  "You entered wrong parameters. Try again!";
        }
    }
    // If at last 5 empty seats or lower, notify user.
    if(availableSeatsTotal() <= 5) $seatWarning = "Last ". availableSeatsTotal(). " seats left!";
    
    file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));
?>
<html>
	<head>
		<title>Avio Seats</title>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
	</head>
	<body>
        <div class="left">
            <h3 class="welcome">Welcome<br>to flight<br> <span class="flightNr">Nr. <?=$data['general']['flight']?></span></h3>
            <h3 class="destination">Destinaton: <?=$data['general']['destination'] ?></h3>
            <h1 class="seat-info">SEATS: <?=(MAX_ROWS*5)-availableSeatsTotal() ?>/<?=MAX_ROWS*5?></h1>
            <h1 class="seat-warning"><?=$seatWarning?></h1>
    
        </div>
        <div class="right">
            <h3>DEPARTURES</h3>
            <table style="margin: 0 auto;">
                <tr>
                    <th>Nr</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Destination</th>
                </tr>
                <? for($i = 0; $i <= 9; $i++) {?>
                <tr>
                    <td><?=$data['departures'][$i]['flight']?></td>
                    <td><?=$data['departures'][$i]['date']?></td>
                    <td><?=$data['departures'][$i]['time']?></td>
                    <td><?=$data['departures'][$i]['destination']?></td>
                </tr>
                <?};  ?>
            </table>
        </div>
        <div class="middle">
            <form action="" method="POST">
                <input style="width: 120px;" type="text" name="userInput" placeholder="Input 1-5 tickets." autocomplete="off" required>
                <button type="submit" value="Submit" class="sort-btn">Sort</button>
            </form>
            <table style="margin: 0 auto;">
                <tr>
                    <th class="gray"></th>
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th class="gray"></th>
                    <th>D</th>
                    <th>E</th>
                </tr>
                <? for($i = 1; $i <= MAX_ROWS; $i++) { $dr = ($i < 13 ? $i : $i+1); ?>
                <tr>
                    <td class="bold"><?=$dr?></td>  <!-- row -->
                    <?=getCell($i, 0)?>             <!--  A -->
                    <?=getCell($i, 1)?>             <!--  B -->
                    <?=getCell($i, 2)?>             <!--  C -->
                    <th class="gray"></th>          <!-- blank -->
                    <?=getCell($i, 3)?>             <!--  D -->
                    <?=getCell($i, 4)?>             <!--  E -->
                </tr>
                <?};  ?>
            </table>
        </div>
	</body>
</html>