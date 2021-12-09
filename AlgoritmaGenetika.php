<?php  

class Parameters {
	const FILE_NAME = 'bahan_makanan.txt';
	const COLUMNS = ['id' , 'nama', 'kalori', 'protein', 'lemak'];
	const POPULATION_SIZE = 10;
	const MIN_FIT = 0.0001;
	const STOPPING_VALUE = 0.003;
	const CROSSOVER_RATE = 0.9;
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
		return $ret;
	}
}

class Fitness {
	function selectingItems($individu) {
		$catalogue = new Catalogue;
		foreach ($individu as $individuKey){
			$ret[] = [
				'selectedKey' => $individuKey,
				'selectedKalori' => $catalogue->bahan()[$individuKey]['kalori'],
				'selectedProtein' => $catalogue->bahan()[$individuKey]['protein'],
				'selectedLemak' => $catalogue->bahan()[$individuKey]['lemak'],
			];
		}
		return $ret;
	}

	function calculateFitnessValue($dataPasien, $individu) {

		# bilkecil = nilai untuk menjauhi pengurangan dengan 0
		$bilkecil = rand(1,5);
		# a = jumlah kalori pada bahan makanan
		$a = array_sum(array_column($this->selectingItems($individu), 'selectedKalori'));
		// echo "<br>a = ".$a;
		# b = jumlah protein pada bahan makanan
		$b = array_sum(array_column($this->selectingItems($individu), 'selectedProtein'));
		// echo "&nbsp;b = ".$b;
		# c = jumlah lemak pada bahan makanan
		$c = array_sum(array_column($this->selectingItems($individu), 'selectedLemak'));
		// echo "&nbsp;c = ".$c;
		# p = Kebutuhan Energi
		$p = $dataPasien[0];
		# q = Kebutuhan Protein
		$q = $dataPasien[1];
		# r = Kebutuhan Lemak
		$r = $dataPasien[2];

		# Fitness
		$fitness = 1/((abs($p - $a) + abs($q - $b) + abs($r - $c)) + $bilkecil);
		// echo "&nbsp;bilkecil = ".$bilkecil;
		// echo "&nbsp;fitness = ".$fitness;
		return $fitness;
	}

	function searchBestIndividu($fits) {
		foreach ($fits as $key => $val) {
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
		echo "<br><b>BEST = ".$bestFitnessValue."</b>";
		$fitnessValues = [];
		foreach ($fits as $key => $val) {
			array_push($fitnessValues, $val['fitnessValue']);
			$fitnessValue = $val['fitnessValue'];
			$residual = $bestFitnessValue - $fitnessValue;
			if ($residual <= Parameters::STOPPING_VALUE && $residual > 0) {
				return FALSE;
			}
		}
		rsort($fitnessValues);
		for($x = 0; $x < count($fits); $x++) {
			// return TRUE;
			return FALSE;
		}
	}

	function isFit($fitnessValue) {
		if ($fitnessValue >= Parameters::MIN_FIT) {
			return true;
		}
		// return true;
	}

	function fitnessEvaluation($population) {
		$catalogue = new Catalogue;
		foreach ($population as $listOfIndividuKey => $listOfIndividu) {
			echo "<br><br>individu-".$listOfIndividuKey."<br>";
			$listOfGen = [];
			foreach ($listOfIndividu as $individuKey) {
				array_push($listOfGen, $individuKey['id']-1);
			}
			$fitnessValue = $this->calculateFitnessValue($listOfGen);
			echo "Fitness Value = ".$fitnessValue;
			if ($this->isFit($fitnessValue)) {
				echo " (Fit)";
				$fits[] = [
					'selectedIndividuKey' => $listOfIndividuKey,
					'fitnessValue' => $fitnessValue,
				];
			} else {
				echo " (Not Fit)";
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
			$offspring = $this->offspring($individu[$i], $individu[$i+1], Parameters::CROSSOVER_RATE);
			if ($offspring != NULL){
				$catalogue = new Catalogue();
				$offspring1 = [];
				$offspring2 = [];
				foreach ($offspring[0] as $key) {
					$offspring1[] = $catalogue->bahan()[$key];
				}
				foreach ($offspring[1] as $key) {
					$offspring2[] = $catalogue->bahan()[$key];
				}
				$offsprings[] = $offspring1;
				$offsprings[] = $offspring2;
			}
		}
		return $offsprings;
	}
}

class Randomizer {
	static function getRandomIndexOfGen() {
		return rand(0, 5);
	}

	static function getRandomIndexOfIndividu() {
		return rand(0, Parameters::POPULATION_SIZE - 1);
	}
}

class Mutation {
	function __construct($populations) {
		$this->population = $populations;
	}

	function calculateMutationRate() {
		return 1 / 6;
	}

	function calculateNumOfMutation() {
		return round($this->calculateMutationRate() * Parameters::POPULATION_SIZE);
	}

	function isMutation() {
		if ($this->calculateNumOfMutation() > 0) {
			return TRUE;
		}
	}

	function generateMutation($valueOfGen){
		# AMBIL INDEX GEN
		$genKey = (int) $valueOfGen['id'] - 1;

		# UBAH INDEX GEN
		if ($genKey == 29) {
			$newGenKey = 1;
		} elseif ($genKey == 28) {
			$newGenKey = 2;
		} else {
			$newGenKey = $genKey + 2;
		}

		# AMBIL DATA GEN DENGAN ID BARU
		$catalogue = new Catalogue();
		$ret = $catalogue->bahan()[$newGenKey];

		return $ret;
	}

	function mutation() {
		if ($this->isMutation()) {
			for ($i = 0; $i < $this->calculateNumOfMutation(); $i++) {
				$indexOfIndividu = Randomizer::getRandomIndexOfIndividu();
				$indexOfGen = Randomizer::getRandomIndexOfGen();
				$selectedIndividu = $this->population[$indexOfIndividu];
				$valueOfGen = $selectedIndividu[$indexOfGen];
				$mutatedGen = $this->generateMutation($valueOfGen);
				$selectedIndividu[$indexOfGen] = $mutatedGen;
				$ret[] = $selectedIndividu;
			}
			return $ret;
		}
	}
}

class Selection {
	function __construct($populations, $combinedOffspings, $dataPasien) {
		$this->population = $populations;
		$this->combinedOffspings = $combinedOffspings;
		$this->dataPasien = $dataPasien;
	}

	function createTemporaryPopulation() {
		// echo "<br> base population: ".count($this->population)." &nbsp;";
		foreach($this->combinedOffspings as $offspring) {
			$this->population[] = $offspring;
		}
		// echo " offspring: ".count($this->combinedOffspings)." temporary: ".count($this->population);
		return $this->population;
	}

	function getVariableValue($basePopulation, $fitTemporaryPopulation) {
		foreach ($fitTemporaryPopulation as $val) {
			$ret[] = $basePopulation[$val[1]];
		}
		return $ret;
	}

	function sortFitTemporaryPopulation() {
		$tempPopulation = $this->createTemporaryPopulation();
		$fitness = new Fitness;
		foreach ($tempPopulation as $key => $individus) {
			$listOfGen = [];
			foreach ($individus as $individuKey) {
				array_push($listOfGen, $individuKey['id']-1);
			}
			$fitnessValue = $fitness->calculateFitnessValue($this->dataPasien, $listOfGen);
			if ($fitness->isFit($fitnessValue)) {
				$fitTemporaryPopulation[] = [
					$fitnessValue,
					$key
				];
			}
		}
		rsort($fitTemporaryPopulation);
		$fitTemporaryPopulation = array_slice($fitTemporaryPopulation, 0, Parameters::POPULATION_SIZE);
		// echo "<p></p>"; print_r($fitTemporaryPopulation);

		return $this->getVariableValue($tempPopulation, $fitTemporaryPopulation);
	}

	function selectingIndividus() {
		$selected = $this->sortFitTemporaryPopulation();
		// echo "<br>data pasien:";print_r($this->dataPasien[0]);
		return $selected;
	}
}
/*
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
	$selection = new Selection($population, $crossoverOffsprings);
	$newGenerationPopulation = $selection->selectingIndividus();
	$population = array_replace($population, $newGenerationPopulation);
	// echo "<br>repl:"; print_r($population);
	$generation++;
}
*/

?>