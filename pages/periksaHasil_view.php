<div class="container px-5 my-5">
    <div class="d-flex justify-content-md-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hasil Rekomendasi Bahan Makanan</h1>
    </div>
    <div class="row">
        <?php 
        require_once 'AlgoritmaGenetika.php';
        $data = unserialize(base64_decode($_POST['data']));
        // print_r($data);
        ?>
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
            foreach ($data as $key => $value) {
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

</div>