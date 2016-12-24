<?php
$user = @$_GET['user'];
$useApi = 'rn';
if(!$user) { die('Ung&uuml;ltiger Name!'); }
if($useApi == 'hk') {
	$data = json_decode(file_get_contents('http://bitkingdom.tk/r6stats.php?nick='.$user.'&platform=uplay&format=json'));
	echo $user.' ist aktuell Level '.$data->level.' und ';
	
} elseif ($useApi == 'rn') {
	$rank = file_get_contents('http://rainbowsix7nightbot.herokuapp.com/rainbowsix7.php?platform=uplay&nick='.$user.'&command=rank'); // Platinum III - matchmaking rating: 3511
	$stats = file_get_contents('http://rainbowsix7nightbot.herokuapp.com/rainbowsix7.php?platform=uplay&nick='.$user.'&command=stats'); // Lv.177 | 1.8 W/L ratio | 1.1 K/D ratio
	$time = file_get_contents('http://rainbowsix7nightbot.herokuapp.com/rainbowsix7.php?platform=uplay&nick='.$user.'&command=time'); // 603h 12m 00s

	if(!$rank || !$stats || !$time) { die('Fehler beim Abfragen der Daten. Versuche es in einigen Sekunden erneut.'); }
	// rank 
	$rank = explode(' ', $rank);
	$rankDesc = $rank[0];
	$rankNum = str_replace('Ⅰ', 'I', $rank[1]);

	//translate rank
	$en = array('Copper', 'Bronze', 'Silver', 'Gold', 'Platinum', 'Diamond');
	$de = array('Kupfer LUL', 'Bronze', 'Silber', 'Gold', 'Platin', 'Diamant');
	$rankDesc = str_replace($en, $de, $rankDesc);

	// stats
	$stats = explode(' | ', $stats);
	$level = str_replace('Lv.', '', $stats[0]);
	$wl = $stats[1];
	$kd = $stats[2];


	// time 
	$time = explode(' ', $time);
	$h = $time[0];
	$m = $time[1];
	$s = $time[2];

	echo $user.' ist aktuell Level '.$level.' und '.$rankDesc.' '.$rankNum.'. '.$user.' spielt seit '.$h.' und hat folgende Stats: '.$wl .' | '.$kd;
}
?>