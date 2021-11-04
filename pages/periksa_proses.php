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

echo "<br/>AMB = ".$amb;
echo "<br/>p = ".$p;
echo "<br/>q = ".$q;
echo "<br/>r = ".$r;

?>