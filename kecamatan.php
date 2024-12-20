<?php
if (!isset($connection)) {
    die("Database connection not available");
}

switch($_GET['act']) {
    default:
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Data Kecamatan</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="index.php?menu=kecamatan&act=tambah" class="btn btn-primary">Tambah Data</a>
                            <form action="index.php?menu=kecamatan" method="POST" class="d-flex">
                                <input type="text" name="cari" value="<?php echo isset($_POST['cari']) ? $_POST['cari'] : ''; ?>" class="form-control mr-2">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kecamatan</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah Desa</th>
                                        <th>Jumlah Destinasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    $query = empty($_POST['cari']) 
                                        ? "SELECT * FROM kecamatan ORDER BY nama" 
                                        : "SELECT * FROM kecamatan WHERE nama LIKE '%".mysqli_real_escape_string($connection, $_POST['cari'])."%' ORDER BY nama";
                                    
                                    $tampil = mysqli_query($connection, $query);
                                    while($r = mysqli_fetch_array($tampil)) {
                                        $no++;
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo htmlspecialchars($r['nama']); ?></td>
                                            <td><?php echo htmlspecialchars($r['deskripsi']); ?></td>
                                            <td><?php echo $r['jumlah_desa']; ?></td>
                                            <td><?php echo $r['jumlah_destinasi']; ?></td>
                                            <td>
                                                <a href="index.php?menu=kecamatan&act=ubah&id=<?php echo $r['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="master.php?menu=kecamatan&act=hapus&id=<?php echo $r['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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
                        <h4 class="card-title">Tambah Data Kecamatan</h4>
                        <form action="master.php?menu=kecamatan&act=simpan" method="POST" class="mt-4">
                            <div class="form-group">
                                <label>Nama Kecamatan</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Desa</label>
                                <input type="number" name="jumlah_desa" class="form-control" value="0" required>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Destinasi</label>
                                <input type="number" name="jumlah_destinasi" class="form-control" value="0" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="index.php?menu=kecamatan" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;

    case "ubah":
        $tampil = mysqli_query($connection, "SELECT * FROM kecamatan WHERE id='".mysqli_real_escape_string($connection, $_GET['id'])."'");
        $r = mysqli_fetch_array($tampil);
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ubah Data Kecamatan</h4>
                        <form action="master.php?menu=kecamatan&act=update" method="POST" class="mt-4">
                            <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                            <div class="form-group">
                                <label>Nama Kecamatan</label>
                                <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($r['nama']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required><?php echo htmlspecialchars($r['deskripsi']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Desa</label>
                                <input type="number" name="jumlah_desa" class="form-control" value="<?php echo $r['jumlah_desa']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Destinasi</label>
                                <input type="number" name="jumlah_destinasi" class="form-control" value="<?php echo $r['jumlah_destinasi']; ?>" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="index.php?menu=kecamatan" class="btn btn-secondary">Kembali</a>
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