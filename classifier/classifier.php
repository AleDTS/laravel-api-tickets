<?php

var_dump($argv);

require_once __DIR__ . "/php-vadersentiment-master/vadersentiment.php";
require_once __DIR__ . '/vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;

/******FUNCTIONS******/

function median($arr) {
    $count = count($arr);
    $middle = floor(($count-1)/2); 

    if($count % 2) { 
        $median = $arr[$middle];
    } else { 
        $low = $arr[$middle];
        $high = $arr[$middle+1];
        $median = (($low+$high)/2);
    }
    return $median;
}

function average($arr) {
    $count = count($arr); 
    $sum = array_sum($arr);
    $average = ($sum/$count);
    return $average;
}

function contains($haystack, $needle){
    return strpos($haystack, $needle) !== false;
}

function array_insert_after( array $array, $key, array $new ) {
	$keys = array_keys( $array );
	$index = array_search( $key, $keys );
	$pos = false === $index ? count( $array ) : $index + 1;
	return array_merge( array_slice( $array, 0, $pos ), $new, array_slice( $array, $pos ) );
}

/*********************/

// Open JSON
$json = file_get_contents($argv[1]);
$tickets = json_decode($json);

// Instantiate packages
$tr = new GoogleTranslate();
$tr->setSource('pt')->setTarget('en');
$sentimenter = new SentimentIntensityAnalyzer();

$score_sentimenter = 0;

foreach ($tickets as $ticket) {
	$found_exp = false;
	$found_word = false;
	$minor_score = 0;

	foreach (array_reverse($ticket->Interactions, true) as $interaction) {

		if ($score_sentimenter < $minor_score){
				$minor_score = $score_sentimenter;
		}

		// Translate message and do the sentiment analysis
		if ($interaction->Sender == "Customer"){
			$msg = $interaction->Message;
			$msg_trans =  $tr->translate($msg);

			$result = $sentimenter->getSentiment($msg_trans);
			$score_sentimenter = (int)round($result['compound']*100);
		}			

		// Find keywords
		if ($found_word == false && $interaction->Sender == "Customer"){
			$found_word = contains(strtoupper(
				$interaction->Message), "PAGTO")
				|| contains(strtoupper(
				$interaction->Message), 'RECLAMEAQUI')
				|| contains(strtoupper(
				$interaction->Message), 'RECLAME AQUI')
			;
		}

		// Get DateCreate's last Customer and Expert's reply
		if ($interaction->Sender == "Expert"){
			$date_exp = date_create($interaction->DateCreate);
			$found_exp = true;
		}
		if ($found_exp == true && $interaction->Sender == "Customer"){
			$date_cus = date_create($interaction->DateCreate);
			break;
		}
	}

	// Determine the resolution time
	$diff = date_diff($date_cus, $date_exp);
	$score_time = (int)$diff->format('%a');

	$scores[] = array(
		'TicketID' => $ticket->TicketID,
		'sentiment' => $minor_score,
		'time' => $score_time,
		'complain' => ($found_word) ? 1:0,
		'first' => ($found_exp) ? 0:1
	);
}

// Metric to define what is a high resolution time (median or avg)
usort($scores, function($a, $b){
	return ($a['time'] >= $b['time']) ? -1 : 1;
});
$median = median(array_column($scores, 'time'));
$avg = average(array_column($scores, 'time'));
$res_time = ($median > $avg ? $median : (int)$avg);

$tickets_arr = json_decode($json, true);

foreach ($scores as $score) {
	$high_priority = false;
	$points = 0;

	// Is the customer unhappy?
	if ($score['sentiment'] < 0){
		$points++;
	}
	// Is the customer threatening to complain in 'procon' or 'reclame aqui'?
	if ($score['complain'] == 1){
		$points++;
	}
	// Is the resolution time too high?
	if($score['time'] >= $res_time){
		$points++;		
	}
	// Isn't this the customer's fisrt interaction ?
	if($score['first'] == 1){
		$points = 0;
	}

	$id = strval($score['TicketID']);

	$key = key(array_filter($tickets_arr, function($ar) use ($id) {
	   return ($ar['TicketID'] == $id);
	}));

	// Insert column 'PriorityScore' into ticket
	$tickets_arr[$key] = array_insert_after($tickets_arr[$key], 'DateUpdate', array('PriorityScore' => (int)$points ));
}

// Save output JSON file
$fp = fopen($argv[2], 'w');
fwrite($fp, json_encode($tickets_arr));
fclose($fp);

?>