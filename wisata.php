<?php
if (!isset($connection)) {
    die("Database connect not available");
}

switch($_GET['act']) {
    default:
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Data Wisata</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="index.php?menu=wisata&act=tambah" class="btn btn-primary">Tambah Data</a>
                            <form action="index.php?menu=wisata" method="POST" class="d-flex">
                                <input type="text" name="cari" value="<?php echo isset($_POST['cari']) ? htmlspecialchars($_POST['cari']) : ''; ?>" class="form-control mr-2">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Wisata</th>
                                        <th>Deskripsi</th>
                                        <th>Kecamatan</th>
                                        <th>Desa</th>
                                        <th>Harga Tiket</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    $query_base = "SELECT wisata.id, wisata.nama, wisata.deskripsi, 
                                                 kecamatan.nama AS kecamatan, desa.nama AS desa, 
                                                 wisata.harga_tiket 
                                                 FROM wisata 
                                                 JOIN kecamatan ON wisata.kecamatan_id = kecamatan.id 
                                                 JOIN desa ON wisata.desa_id = desa.id";
                                    
                                    if (empty($_POST['cari'])) {
                                        $query = $query_base . " ORDER BY wisata.nama";
                                    } else {
                                        $search = mysqli_real_escape_string($connection, $_POST['cari']);
                                        $query = $query_base . " WHERE wisata.nama LIKE '%$search%' ORDER BY wisata.nama";
                                    }
                                    
                                    $tampil = mysqli_query($connection, $query);
                                    while($r = mysqli_fetch_array($tampil)) {
                                        $no++;
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo htmlspecialchars($r['nama']); ?></td>
                                            <td><?php echo htmlspecialchars($r['deskripsi']); ?></td>
                                            <td><?php echo htmlspecialchars($r['kecamatan']); ?></td>
                                            <td><?php echo htmlspecialchars($r['desa']); ?></td>
                                            <td>Rp <?php echo number_format($r['harga_tiket'], 0, ',', '.'); ?></td>
                                            <td>
                                                <a href="index.php?menu=wisata&act=ubah&id=<?php echo $r['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="master.php?menu=wisata&act=hapus&id=<?php echo $r['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data wisata ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;

    case "tambah":
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah Data Wisata</h4>
                        <form action="master.php?menu=wisata&act=simpan" method="POST" enctype="multipart/form-data" class="mt-4">
                            <div class="form-group">
                                <label>Nama Wisata</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select name="kecamatan_id" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                    <?php
                                    $kecamatan = mysqli_query($connection, "SELECT id, nama FROM kecamatan ORDER BY nama");
                                    while ($k = mysqli_fetch_array($kecamatan)) {
                                        echo "<option value='".htmlspecialchars($k['id'])."'>".htmlspecialchars($k['nama'])."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Desa</label>
                                <select name="desa_id" class="form-control" required>
                                    <option value="">Pilih Desa</option>
                                    <?php
                                    $desa = mysqli_query($connection, "SELECT id, nama FROM desa ORDER BY nama");
                                    while ($d = mysqli_fetch_array($desa)) {
                                        echo "<option value='".htmlspecialchars($d['id'])."'>".htmlspecialchars($d['nama'])."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" rows="4" required></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Latitude</label>
                                        <input type="text" name="latitude" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Longitude</label>
                                        <input type="text" name="longitude" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="foto" class="form-control-file">
                            </div>
                            
                            <div class="form-group">
                                <label>Fasilitas</label>
                                <textarea name="fasilitas" class="form-control" rows="4"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Jam Operasional</label>
                                <input type="text" name="jam_operasional" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>Harga Tiket</label>
                                <input type="text" name="harga_tiket" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>Kontak</label>
                                <input type="text" name="kontak" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="index.php?menu=wisata" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;

    case "ubah":
        $id = mysqli_real_escape_string($connection, $_GET['id']);
        $tampil = mysqli_query($connection, "SELECT * FROM wisata WHERE id='$id'");
        $r = mysqli_fetch_array($tampil);
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ubah Data Wisata</h4>
                        <form action="master.php?menu=wisata&act=ubah" method="POST" enctype="multipart/form-data" class="mt-4">
                            <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                            
                            <div class="form-group">
                                <label>Nama Wisata</label>
                                <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($r['nama']); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required><?php echo htmlspecialchars($r['deskripsi']); ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select name="kecamatan_id" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                    <?php
                                    $kecamatan = mysqli_query($connection, "SELECT id, nama FROM kecamatan ORDER BY nama");
                                    while ($k = mysqli_fetch_array($kecamatan)) {
                                        $selected = ($k['id'] == $r['kecamatan_id']) ? 'selected' : '';
                                        echo "<option value='".htmlspecialchars($k['id'])."' $selected>".htmlspecialchars($k['nama'])."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Desa</label>
                                <select name="desa_id" class="form-control" required>
                                    <option value="">Pilih Desa</option>
                                    <?php
                                    $desa = mysqli_query($connection, "SELECT id, nama FROM desa ORDER BY nama");
                                    while ($d = mysqli_fetch_array($desa)) {
                                        $selected = ($d['id'] == $r['desa_id']) ? 'selected' : '';
                                        echo "<option value='".htmlspecialchars($d['id'])."' $selected>".htmlspecialchars($d['nama'])."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" rows="4" required><?php echo htmlspecialchars($r['alamat']); ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Latitude</label>
                                        <input type="text" name="latitude" class="form-control" value="<?php echo htmlspecialchars($r['latitude']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Longitude</label>
                                        <input type="text" name="longitude" class="form-control" value="<?php echo htmlspecialchars($r['longitude']); ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="foto" class="form-control-file">
                                <?php if(!empty($r['foto'])): ?>
                                    <small class="form-text text-muted">Foto saat ini: <?php echo htmlspecialchars($r['foto']); ?></small>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group">
                                <label>Fasilitas</label>
                                <textarea name="fasilitas" class="form-control" rows="4"><?php echo htmlspecialchars($r['fasilitas']); ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Jam Operasional</label>
                                <input type="text" name="jam_operasional" class="form-control" value="<?php echo htmlspecialchars($r['jam_operasional']); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label>Harga Tiket</label>
                                <input type="text" name="harga_tiket" class="form-control" value="<?php echo htmlspecialchars($r['harga_tiket']); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label>Kontak</label>
                                <input type="text" name="kontak" class="form-control" value="<?php echo htmlspecialchars($r['kontak']); ?>">
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="index.php?menu=wisata" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
}
?>