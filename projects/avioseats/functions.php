<?php
$data = @json_decode(file_get_contents('data.json'), true);

// If data doesn't exist, fill it up.
if(!$data or !is_array($data)) clearAvailableSeats(); 

// Calculate the next balanced seat, set it to be active.
function nextBalancedSeat() {
    global $data;
    $blocks = calculateBlocks();
    $row = floor($blocks[0]['length'] / 2) + $blocks[0]['start'];
    
    $data['seats'][$row][$blocks[0]['column']] = ['active' => 1, 'time' => date("H:i:s"), 'specific' => false];
}

// Calculate the number of empty seats in a row.
function calculateBlocks() {
    global $data;
    $blocks = [];
    $currentBlock = null;

    for($columns = 0; $columns < 5; $columns++) {
        for($row = 0; $row < MAX_ROWS; $row++) {
            if($data['seats'][$row][$columns]['active'] == 0){ 
                if($currentBlock == null){ // If current block is empty, make a block.
                    $currentBlock = [ 'start' => $row, 'length' => 1, 'column' => $columns];
                } else $currentBlock['length']++;
            } else { // If value hits something else other than 0, append the $blocks array.
                if($currentBlock) {
                    $blocks[] = $currentBlock;
                    $currentBlock = null;
                }
            }
            // If at the last row, append $blocks. ( I did this because if all seats are 0, it doesnt know when to append.)
            if($row == MAX_ROWS-1) {
                if($currentBlock) {
                    $blocks[] = $currentBlock;
                    $currentBlock = null;
                } 
            }
        }
    }
    sortByKey($blocks, 'length', true);
    return $blocks;
}

// Calculate the available seats that are left.
function availableSeatsTotal() {
    global $data;
    $counter = 0;

    foreach($data['seats'] as $row) {
        foreach($row as $column) {
            if($column['active'] == 0) $counter++;
        }
    }
    return $counter;
}

// Check if user input is valid.
function inputLimitCheck($input) {
    if($input <= 5 && $input >= 1 && $input <= availableSeatsTotal()){
        return true; // return true if 0-5, else false.
    } else return false;
}
function updateDepartures() {
    global $data;
    $destinations = ['Tallin/TLL', 'Vilnius/VNO', 'Moscow/SVO', 'Oslo/OSL', 'Frankfurt/FRA', 'Amsterdam/AMS', 'Minsk/MSQ', 'Barcelona/BCN', 'Berlin/BER'];

    array_unshift($data['departures'],['flight'=> $data['general']['flight'], 'date' => date("d.m.Y"), 'time' => date("H:i"), 'destination' => $data['general']['destination']]);
    unset($data['departures'][10]);
    $data['general'] = ['rows' => MAX_ROWS, 'flight' => $data['general']['flight'] + 1, 'destination' => $destinations[array_rand($destinations, 1)]];  // maybe create static for flight instead.
}

// Clear all the seats.
function clearAvailableSeats() {
    global $data;
    updateDepartures();

    $data['seats'] = [];

    for($row = 0; $row < MAX_ROWS; $row++) {
        for($column = 0; $column < 5; $column++) {
            $data['seats'][$row][$column] = [ 'active' => 0, 'time' => null, 'specific' => false];
        }
    }
}

// Create cells, set their colors accordingly.
function getCell($row, $column) {
    global $data;
    $style = '';
    $columnNames = ['A', 'B', 'C', 'D', 'E'];

    if($data['seats'][$row-1][$column]['active'] == 1) $style = 'background: tomato';
    if($data['seats'][$row-1][$column]['time'] == date("H:i:s")) $style = 'background: #ffdd33'; 
    if($data['seats'][$row-1][$column]['specific'] == true) $style = 'background: #00FF7F'; 
    if($row > 12) $row++; // This is to make the output be the correct row.. (e.g. row13 = 14) (frontend)

    return '<td style="' .$style .'">' .$columnNames[$column] .$row .'</td>';
}

// Sorting algorythm.
function sortByKey(&$array, $key, $descending = false) {
	usort($array, function($a, $b) use ($key, $descending) {
		if($a[$key] == $b[$key]) {
			return 0;
		}
		if($descending) {
			return ($a[$key] < $b[$key] ? 1 : -1);
		} else {
			return ($a[$key] > $b[$key] ? 1 : -1);
		}
	});	
}

// Validate if input is available.
function validateSpecific($seat) {
    global $data;
    $allowedLetters = ['A', 'B', 'C', 'D', 'E'];
    $row = preg_replace('~\D~', '', $seat); // Remove the letter.
    $column = array_search(strtoupper($seat[0]), $allowedLetters);
    
    if(in_array(strtoupper($seat[0]), $allowedLetters)) {
        if($row == 13){
            return false;
        } else if($row <= MAX_ROWS+1){
            if($row > 13) $row--;
            if($data['seats'][$row-1][$column]['active'] == 1){
                return false;
            } else return true;
        }
    } else return false;
}

// Set the desired seat to be active.
function setSpecific($seat) {
    global $data;
    $allowedLetters = ['A', 'B', 'C', 'D', 'E'];
    $row = preg_replace('~\D~', '', $seat); // Remove the letter.
    $column = array_search(strtoupper($seat[0]), $allowedLetters);

    if($row > 13) $row--;
    $data['seats'][$row-1][$column] = ['active' => 1, 'time' => date("H:i:s"), 'specific' => true];
}
