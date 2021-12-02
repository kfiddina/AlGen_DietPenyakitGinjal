<?php  

class Parameters {
	const FILE_NAME = 'bahan_makanan.txt';
	const COLUMNS = ['id' , 'nama', 'kalori', 'protein', 'lemak'];
	const POPULATION_SIZE = 10;
	const MIN_FIT = 0.003;
}

class Catalogue {
	
	function createProductColumn($listOfRawBahan) {
		foreach (array_keys($listOfRawBahan) as $listOfRawBahanKey) {
			$listOfRawBahan[Parameters::COLUMNS[$listOfRawBahanKey]] = $listOfRawBahan[$listOfRawBahanKey];
			unset($listOfRawBahan[$listOfRawBahanKey]);
		}
		return $listOfRawBahan;
	}

	function bahan() {
		$collectionOfListBahan = [];

		$raw_data = file(Parameters::FILE_NAME);
		foreach ($raw_data as $listOfRawBahan) {
			$collectionOfListBahan[] = $this->createProductColumn(explode(", ", $listOfRawBahan));
		}

		// foreach ($collectionOfListBahan as $listOfRawBahan) {
		// 	print_r($listOfRawBahan);
		// 	echo "<br>";
		// }

		// return [
		// 	'bahan' => $collectionOfListBahan,
		// 	'gen_length' => count($collectionOfListBahan)
		// ];
		// var_dump($collectionOfListBahan);
		return $collectionOfListBahan;
	}
}

class Individu {
	function createRandomIndividu() {
		$catalogue = new Catalogue;

		$ret = [];

		$karbo = array_slice($catalogue->bahan(), 0, 5);
		shuffle($karbo);

		$kacang = array_slice($catalogue->bahan(), 6, 5);
		shuffle($kacang);

		$sayur = array_slice($catalogue->bahan(), 11, 5);
		shuffle($sayur);

		$buah = array_slice($catalogue->bahan(), 16, 5);
		shuffle($buah);

		$umbi = array_slice($catalogue->bahan(), 21, 5);
		shuffle($umbi);

		$daging = array_slice($catalogue->bahan(), 26, 5);
		shuffle($daging);

		array_push($ret, $karbo[0], $kacang[0], $sayur[0], $buah[0], $umbi[0], $daging[0]);
		return $ret;
	}	
}

class Population {
	
	// function createIndividu() {
	// 	$catalogue = new Catalogue;
	// 	$lengthOfGen = $catalogue->bahan($parameters)['gen_length'];
	// 	for ($i = 0; $i <= $lengthOfGen-1; $i++) {
	// 		$ret[] = rand(0, 1);
	// 	}
	// 	return $ret;
	// }

	function createRandomPopulation() {
		$individu = new Individu;
		for ($i = 1; $i <= Parameters::POPULATION_SIZE; $i++) {
			$ret[] = $individu->createRandomIndividu();
		}
		// foreach ($ret as $key => $val) {
		// 	print_r($val);
		// 	echo "<br><br>";
		// }
		print_r(count($ret));
		return $ret;
	}
}

class Fitness {
	function selectingItems($individu) {
		$catalogue = new Catalogue;
		foreach ($individu as $individuKey){
			$ret[] = [
				'selectedKey' => $individuKey,
				'selectedKalori' => $catalogue->bahan()[$individuKey-1]['kalori'],
				'selectedProtein' => $catalogue->bahan()[$individuKey-1]['protein'],
				'selectedLemak' => $catalogue->bahan()[$individuKey-1]['lemak'],
			];
		}
		return $ret;
	}

	function calculateFitnessValue($individu) {
		// print_r($individu);
		// print_r($this->selectingItems($individu));
		// $indv = $this->selectingItems($individu);
		// var_dump($individu);
		// foreach ($indv as $listOfGenKey => $listOfGen) {
		// 	echo "<br><br>gen-".$listOfGenKey;
		// 	echo "<br>Kalori = ".$listOfGen['selectedKalori'];
		// 	echo "<br>Protein = ".$listOfGen['selectedProtein'];
		// 	echo "<br>Lemak = ".$listOfGen['selectedLemak'];
		// }

		$jk = "L";
		$usia = 10;
		$bb = 15;
		$tb = 100;
		$fAkt = 1.3;
		$fSts = 1.3;

		if ($jk == "L") {
			$amb = 66 + (13.7 * $bb) + (5 * $tb) - (6.8 * $usia);
		} else {
			$amb = 655 + (9.6 * $bb) + (1.8 * $tb) - (4.7 * $usia);
		}

		# bilkecil = nilai untuk menjauhi pengurangan dengan 0
		$bilkecil = rand(1,5);
		# a = jumlah kalori pada bahan makanan
		$a = array_sum(array_column($this->selectingItems($individu), 'selectedKalori'));
		echo "<br>a = ".$a;
		# b = jumlah protein pada bahan makanan
		$b = array_sum(array_column($this->selectingItems($individu), 'selectedProtein'));
		echo "<br>b = ".$b;
		# c = jumlah lemak pada bahan makanan
		$c = array_sum(array_column($this->selectingItems($individu), 'selectedLemak'));
		echo "<br>c = ".$c;
		# p = Kebutuhan Energi
		$p = $amb * $fAkt * $fSts;
		# q = Kebutuhan Protein
		$q = 0.8 * $bb;
		# r = Kebutuhan Lemak
		$r = (25/100) * $q;

		# Fitness
		$fitness = 1/((abs($p - $a) + abs($q - $b) + abs($r - $c)) + $bilkecil);
		echo "<br> bilkecil = ".$bilkecil;
		echo "<br> fitness = ".$fitness;
		return $fitness;
		// exit();

	}

	function isFit($fitnessValue) {
		if ($fitnessValue >= Parameters::MIN_FIT) {
			return TRUE;
		}
	}

	function fitnessEvaluation($population) {
		$catalogue = new Catalogue;
		foreach ($population as $listOfIndividuKey => $listOfIndividu) {
			echo "<br><br>individu-".$listOfIndividuKey."<br>";
			$listOfGen = [];
			foreach ($listOfIndividu as $individuKey) {
				print_r($individuKey);
				array_push($listOfGen, $individuKey['id']);
				echo "<br>";
			}
			$fitnessValue = $this->calculateFitnessValue($listOfGen);
			// echo "<br>Fitness Value = ".$fitnessValue;
			if ($this->isFit($fitnessValue)) {
				echo "(Fit)";
			} else {
				echo "(Not Fit)";
			}
		}
	}
}

$parameters = [
	'file_name' => 'bahan_makanan.txt',
	'columns' => ['id' , 'nama', 'kalori', 'protein', 'lemak'],
	'population_size' => 10
];

// $katalog = new Catalogue;
// $katalog->bahan($parameters);

echo "<br><br>Populasi ";
$initialPopulation = new Population;
$population = $initialPopulation->createRandomPopulation();

echo "<br>Fitness<br>";
$fitness = new Fitness;
$fitness->fitnessEvaluation($population);

// $individu = new Individu;
// print_r($individu->createRandomIndividu());

?>