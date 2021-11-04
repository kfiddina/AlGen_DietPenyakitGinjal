<div class="container px-5 my-5">
    <div class="d-flex justify-content-md-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Menentukan Bahan Makanan Bagi Penderita Gagal Ginjal Akut</h1>
    </div>
    <form action="?p=periksa_proses" method="post" class="row g-3">
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
            <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button>
        </div>
    </form>
</div>