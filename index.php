<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Project Algoritma Genetika Kelompok 4</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <!-- Page content-->
    <div class="container">
        <div class="container px-5 my-5">
            <?php  
            function periksa(){
                if (!isset($_POST['btn_submit'])){
                ?>
                <div class="d-flex justify-content-md-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Menentukan Bahan Makanan Bagi Penderita Gagal Ginjal Akut</h1>
                </div>
                <form action="" method="post" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="nama">Nama</label>
                        <input class="form-control" id="nama" type="text" placeholder="Nama" name="txtNama" required/>
                        <div class="invalid-feedback">Nama is required.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="jenisKelamin">Jenis Kelamin</label>
                        <select class="form-select" id="jenisKelamin" name="slJK" aria-label="Jenis Kelamin">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="usia">Usia</label>
                        <input class="form-control" id="usia" type="text" placeholder="Usia" name="txtUsia" required/>
                        <div class="invalid-feedback">Usia is required.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="beratBadan">Berat Badan</label>
                        <div class="input-group">
                            <input class="form-control" id="beratBadan" type="text" placeholder="Berat Badan" name="txtBB" required/>
                            <span class="input-group-text">Kg</span>
                            <div class="invalid-feedback">Berat Badan is required.</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="tinggiBadan">Tinggi Badan</label>
                        <div class="input-group">
                            <input class="form-control" id="tinggiBadan" type="text" placeholder="Tinggi Badan" name="txtTB" required/>
                            <span class="input-group-text">Cm</span>
                            <div class="invalid-feedback">Tinggi Badan is required.</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="aktivitas">Aktivitas</label>
                        <select class="form-select" id="aktivitas" name="slAkt" aria-label="Aktivitas">
                            <option value="1.2">Istirahat di tempat di tidur</option>
                            <option value="1.3">Tidak terikat di tempat tidur</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label" for="stress">Stress</label>
                        <select class="form-select" id="stress" name="slSts" aria-label="Stress">
                            <option value="1.3">Tidak ada stress, pasien dalam keadaan gizi baik</option>
                            <option value="1.4">Stress Ringan: peradangan saluran cerna, kanker, bedah elektif, trauma kerangka moderat</option>
                            <option value="1.5">Stress Sedang: sepsis, bedah tulang, luka bakar, trauma kerangka mayor</option>
                            <option value="1.6">Stress Berat: trauma multiple, sepsis dan bedah multisystem</option>
                            <option value="1.7">Stress Sangat Berat: luka kepala berat, sindroma penyakit pernapasan akut, luka bakar dan sepsis</option>
                            <option value="2.1">Luka bakar sangat berat</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg" id="submitButton" type="submit" name="btn_submit">Submit</button>
                    </div>
                </form>
                <?php  
                } elseif (isset($_POST['btn_submit'])){
                    $nama = $_POST['txtNama'];
                    $jk = $_POST['slJK'];
                    $usia = floatval($_POST['txtUsia']);
                    $bb = floatval($_POST['txtBB']);
                    $tb = floatval($_POST['txtTB']);
                    $fAkt = floatval($_POST['slAkt']);
                    $fSts = floatval($_POST['slSts']);
                    
                    if ($jk == "L") {
                        $amb = 66 + (13.7 * $bb) + (5 * $tb) - (6.8 * $usia);
                        $gender = "Laki-laki";
                    } else {
                        $amb = 655 + (9.6 * $bb) + (1.8 * $tb) - (4.7 * $usia);
                        $gender = "Perempuan";
                    }

                    switch($fAkt){
                        case 1.2:
                            $aktivitas = "Istirahat di tempat tidur";
                            break;
                        case 1.3:
                            $aktivitas = "Tidak terikat di tempat tidur";
                            break;
                        default:
                            echo "Tidak ada";
                    }

                    switch($fSts){
                        case 1.3:
                            $stress = "Tidak ada stress, pasien dalam keadaan gizi baik";
                            break;
                        case 1.4:
                            $stress = "Stress Ringan: peradangan saluran cerna, kanker, bedah elektif, trauma kerangka moderat";
                            break;
                        case 1.5:
                            $stress = "Stress Sedang: sepsis, bedah tulang, luka bakar, trauma kerangka mayor";
                            break;
                        case 1.6:
                            $stress = "Stress Berat: trauma multiple, sepsis dan bedah multisystem";
                            break;
                        case 1.7:
                            $stress = "Stress Sangat Berat: luka kepala berat, sindroma penyakit pernapasan akut, luka bakar dan sepsis";
                            break;
                        case 2.1:
                            $stress = "Luka bakar sangat berat";
                            break;
                        default:
                            echo "Tidak ada";
                    }

                    $dataDiri = [
                        'nama' => $nama,
                        'gender' => $gender,
                        'usia' => $usia,
                        'bb' => $bb,
                        'tb' => $tb,
                        'aktivitas' => $aktivitas,
                        'stress' => $stress,
                    ];
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

                        $data = [$p, $q, $r];
                     /*
                    a = jumlah kalori pada bahan makanan
                    b = jumlah protein pada bahan makanan
                    c = jumlah lemak pada bahan makanan
                    bilkecil = nilai untuk menjauhi pengurangan dengan 0
                    */
                    hasilPeriksa($data, $dataDiri);
                }
            }
            ?>
        </div>

        <?php  
        function hasilPeriksa($pqr, $dataDiriPasien) {
            require_once 'AlgoritmaGenetika.php';

            $initialPopulation = new Population;
            $population = $initialPopulation->createRandomPopulation();

            $generation = 1;
            while ($generation <= 10) {
                // echo "<p></p>Generation-".$generation;
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
                $selection = new Selection($population, $crossoverOffsprings, $pqr);
                $newGenerationPopulation = $selection->selectingIndividus();
                $population = array_replace($population, $newGenerationPopulation);
                // echo "<br>repl:"; print_r($population);
                $generation++;
            }
            $res = $population[0];
            ?>
            <div class="container px-5 my-5">
                <div class="d-flex justify-content-md-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Hasil Rekomendasi Bahan Makanan</h1>
                </div>
                <div class="row g-3 mb-5">
                    <div class="col-md-6">
                        <label class="form-label" for="nama">Nama</label>
                        <input class="form-control" type="text" placeholder="Nama" name="txtNama" value="<?= $dataDiriPasien['nama'] ?>" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="jenisKelamin">Jenis Kelamin</label>
                        <input class="form-control" type="text" placeholder="jenisKelamin" name="slJK" value="<?= $dataDiriPasien['gender'] ?>"/>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="usia">Usia</label>
                        <input class="form-control" type="text" placeholder="Usia" name="txtUsia" value="<?= $dataDiriPasien['usia'] ?>"/>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="beratBadan">Berat Badan</label>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Berat Badan" name="txtBB" value="<?= $dataDiriPasien['bb'] ?>"/>
                            <span class="input-group-text">Kg</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="tinggiBadan">Tinggi Badan</label>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Tinggi Badan" name="txtTB" value="<?= $dataDiriPasien['tb'] ?>"/>
                            <span class="input-group-text">Cm</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="aktivitas">Aktivitas</label>
                        <input class="form-control" type="text" placeholder="Usia" name="slAkt" value="<?= $dataDiriPasien['aktivitas'] ?>"/>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label" for="stress">Stress</label>
                        <input class="form-control" type="text" placeholder="Usia" name="slSts" value="<?= $dataDiriPasien['stress'] ?>"/>
                    </div>
                </div>

                <div class="row">
                    <table class="table table-striped">
                        <tr>
                            <th width="50px" class="text-center">No</th>
                            <th>Nama Bahan Makanan</th>
                            <th>Kalori</th>
                            <th>Protein</th>
                            <th>Lemak</th>
                        </tr>    
                        <?php 
                        $no = 0;
                        foreach ($res as $key => $value) {
                            echo "<tr>";
                            echo "<td>".($key+1)."</td>";
                            echo "<td>".$value['nama']."</td>";
                            echo "<td>".$value['kalori']."&nbsp;kkal</td>";
                            echo "<td>".$value['protein']."&nbsp;g</td>";
                            echo "<td>".$value['lemak']."&nbsp;g</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
                <div class="d-grid">
                    <a href="index.php" class="btn btn-primary btn-lg" name="btn_kembali">Periksa lagi</a>
                </div>
            </div>
            <?php
        }
        periksa();
        ?>
    </div>
    <!-- Bootstrap core JS-->
    <script src="assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- Core theme JS <script src="assets/js/scripts.js"></script>-->
</body>
</html>