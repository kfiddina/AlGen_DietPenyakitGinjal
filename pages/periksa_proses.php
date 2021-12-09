<?php 

$nama = $_POST['txtNama'];
$jk = $_POST['slJK'];
$usia = floatval($_POST['txtUsia']);
$bb = floatval($_POST['txtBB']);
$tb = floatval($_POST['txtTB']);
$fAkt = floatval($_POST['slAkt']);
$fSts = floatval($_POST['slSts']);

echo "<br/>Nama = ".$nama;
echo "<br/>JK = ".$jk;
echo "<br/>Usia = ".$usia.gettype($usia);
echo "<br/>BB = ".$bb.gettype($usia);;
echo "<br/>TB = ".$tb.gettype($usia);;
echo "<br/>Faktor Aktivitas = ".$fAkt.gettype($usia);;
echo "<br/>Faktor Stress = ".$fSts.gettype($usia);;

if ($jk == "L") {
	$amb = 66 + (13.7 * $bb) + (5 * $tb) - (6.8 * $usia);
} else {
	$amb = 655 + (9.6 * $bb) + (1.8 * $tb) - (4.7 * $usia);
}

/*
Diet untuk penyakit gagal ginjal akut adalah : 
	(1) energi = 30 kkal/kg BB; 
	(2) protein = 0,8 g/kg BB; 
	(3) lemak yaitu 25% dari kebutuhan total energi.
*/

# Kebutuhan Energi
	$p = $amb * $fAkt * $fSts;
# Kebutuhan Protein
	$q = 0.8 * $bb;
# Kebutuhan Lemak
	$r = (25/100) * $q;

 /*
a = jumlah kalori pada bahan makanan
b = jumlah protein pada bahan makanan
c = jumlah lemak pada bahan makanan
bilkecil = nilai untuk menjauhi pengurangan dengan 0
*/

echo "<br/>AMB = ".$amb;
echo "<br/>p = ".$p;
echo "<br/>q = ".$q;
echo "<br/>r = ".$r;
$data = [$p, $q, $r];
require_once 'AlgoritmaGenetika.php';


$initialPopulation = new Population;
$population = $initialPopulation->createRandomPopulation();

$generation = 1;
while ($generation <= 10) {
	echo "<p></p>Generation-".$generation;
	$crossover = new Crossover($population);
	$crossoverOffsprings = $crossover->crossover();
	$mutation = new Mutation($population);
	if ($mutationOffsprings = $mutation->mutation()){
		
		foreach ($mutationOffsprings as $mutationOffspringKey => $mutationOffspring) {
			$crossoverOffsprings[] = $mutationOffspring;
			// print_r($mutationOffspring);
		}
	}
	// echo "<br>init:"; print_r($population);
	$selection = new Selection($population, $crossoverOffsprings, $data);
	$newGenerationPopulation = $selection->selectingIndividus();
	$population = array_replace($population, $newGenerationPopulation);
	// echo "<br>repl:"; print_r($population);
	$generation++;
}
$res = $population[0];
echo "<p></p>"; print_r($res);
// echo "<p></p>";
// foreach ($res as $key => $value) {
// 	foreach ($value as $vkey => $val) {
// 	}
// 		print_r($value); echo "<br>";
// }

?>
<form action="?p=periksaHasil_view" method="post">
	<input type="text" name="data" value="<?= base64_encode(serialize($res)) ?>">
	<button class="btn btn-primary btn-sm" type="submit">Hasil</button>
</form>