<?php  

class Parameters {
	const FILE_NAME = 'bahan_makanan.txt';
	const COLUMNS = ['id' , 'nama', 'kalori', 'protein', 'lemak'];
	const POPULATION_SIZE = 10;
	const MIN_FIT = 0.003;
	const STOPPING_VALUE = 0.002;
	const CROSSOVER_RATE = 0.8;
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
	
	function createRandomPopulation() {
		$individu = new Individu;
		for ($i = 0; $i < Parameters::POPULATION_SIZE; $i++) {
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
		echo "a = ".$a;
		# b = jumlah protein pada bahan makanan
		$b = array_sum(array_column($this->selectingItems($individu), 'selectedProtein'));
		echo "&nbsp;b = ".$b;
		# c = jumlah lemak pada bahan makanan
		$c = array_sum(array_column($this->selectingItems($individu), 'selectedLemak'));
		echo "&nbsp;c = ".$c;
		# p = Kebutuhan Energi
		$p = $amb * $fAkt * $fSts;
		# q = Kebutuhan Protein
		$q = 0.8 * $bb;
		# r = Kebutuhan Lemak
		$r = (25/100) * $q;

		# Fitness
		$fitness = 1/((abs($p - $a) + abs($q - $b) + abs($r - $c)) + $bilkecil);
		echo "&nbsp;bilkecil = ".$bilkecil;
		echo "<br> fitness = ".$fitness;
		return $fitness;
	}

	function searchBestIndividu($fits) {
		foreach ($fits as $key => $val) {
			// echo "<br>indvKey ".$val['selectedIndividuKey']." fitVal ".$val['fitnessValue'];
			$ret[] = [
				'individuKey' => $val['selectedIndividuKey'],
				'fitnessValue' => $val['fitnessValue']
			];
		}
		if (count(array_unique(array_column($ret, 'fitnessValue'))) === 1) {
			$index = rand(0, count($ret) - 1);
		} else {
			$maxFitnessValue = max(array_column($ret, 'fitnessValue'));
			$index = array_search($maxFitnessValue, array_column($ret, 'fitnessValue'));
		}
		return $ret[$index];
	}

	function isFound($fits) {
		$bestFitnessValue = $this->searchBestIndividu($fits)['fitnessValue'];
		echo "&nbspBEST = ".$bestFitnessValue;
		$fitnessValues = [];
		foreach ($fits as $key => $val) {
			array_push($fitnessValues, $val['fitnessValue']);
			$fitnessValue = $val['fitnessValue'];
			$residual = $bestFitnessValue - $fitnessValue;
			if ($residual <= Parameters::STOPPING_VALUE && $residual > 0) {
			}
		}
		rsort($fitnessValues);
		// var_dump($sorted);
		for($x = 0; $x < count($fits); $x++) {
			return TRUE;
		}
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
				$fits[] = [
					'selectedIndividuKey' => $listOfIndividuKey,
					'fitnessValue' => $fitnessValue,
				];
			} else {
				echo "(Not Fit)";
			}
		}
		if ($this->isFound($fits)) {
			echo " found";
		} else {
			echo " >> NEXT GEN";
		}
	}
}

class Crossover {
	public $populations;

	function __construct($populations) {
		$this->populations = $populations;
	}

	function randomZeroToOne() {
		return (float) rand() / (float) getrandmax();
	}

	function generateCrossover(){
		for ($i = 0; $i < Parameters::POPULATION_SIZE; $i++) { 
			$randomZeroToOne = $this->randomZeroToOne();
			if ($randomZeroToOne < Parameters::CROSSOVER_RATE) {
				$parents[$i] = $randomZeroToOne;
			}
		}
		foreach (array_keys($parents) as $key) {
			foreach (array_keys($parents) as $subkey) {
				if ($key !== $subkey) {
					$ret[] = [$key, $subkey];
				}
			}
			array_shift($parents);
		}
		return $ret;
	}

	function offspring($parent1, $parent2, $r_cross) {
		$c1 = $parent1;
		$c2 = $parent2;
		$randomZeroToOne = $this->randomZeroToOne();
		if ($randomZeroToOne < $r_cross) {
			$cutPoint = (int) rand(1, count($parent1));
			$c1 =  array_merge(array_slice($parent1, 0, $cutPoint), array_slice($parent2, $cutPoint));
			$c2 = array_merge(array_slice($parent2, 0, $cutPoint), array_slice($parent1, $cutPoint));
			return [$c1, $c2];
		}
	}

	function cutPointRandom() {
		$lengthOfGen = 6;
		return rand(0, $lengthOfGen-1);
	}

	function crossover() {
		$listOfGen = [];
		$cutPointIndex = $this->cutPointRandom();
		foreach ($this->populations as $listOfIndividuKey => $listOfIndividu) {
			foreach ($listOfIndividu as $individuKey) {
				array_push($listOfGen, $individuKey['id']-1);
			}
		}
		for ($i = 0; $i < count($listOfGen); $i+=6) {
			$individu[] = array_slice($listOfGen, $i, 6);
		}
		for ($i=0; $i < Parameters::POPULATION_SIZE; $i+=2) { 
			echo "<br><br>Parents :<br>";
			foreach ($individu[$i] as $key) {
				echo $key;
			}
			echo "><";
			foreach ($individu[$i+1] as $key) {
				echo $key;
			}
			echo "<br>Offspring :<br>";
			$offspring = $this->offspring($individu[$i], $individu[$i+1], Parameters::CROSSOVER_RATE);
			// echo "<br>"; print_r($offspring);
			if ($offspring != NULL){
				foreach ($offspring[0] as $key) {
					echo $key;
				}
				echo "><";
				foreach ($offspring[1] as $key) {
					echo $key;
				}
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

$crossover = new Crossover($population);
$crossover->crossover();

// $individu = new Individu;
// print_r($individu->createRandomIndividu());

?>