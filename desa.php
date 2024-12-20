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
                        <h4 class="card-title mb-4">Data Desa</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="index.php?menu=desa&act=tambah" class="btn btn-primary">Tambah Data</a>
                            <form action="index.php?menu=desa" method="POST" class="d-flex">
                                <input type="text" name="cari" value="<?php echo isset($_POST['cari']) ? htmlspecialchars($_POST['cari']) : ''; ?>" class="form-control mr-2">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Desa</th>
                                        <th>Deskripsi</th>
                                        <th>Kecamatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    $query = empty($_POST['cari']) 
                                        ? "SELECT desa.id, desa.nama, desa.deskripsi, kecamatan.nama AS kecamatan 
                                           FROM desa 
                                           JOIN kecamatan ON desa.kecamatan_id = kecamatan.id 
                                           ORDER BY desa.nama" 
                                        : "SELECT desa.id, desa.nama, desa.deskripsi, kecamatan.nama AS kecamatan 
                                           FROM desa 
                                           JOIN kecamatan ON desa.kecamatan_id = kecamatan.id 
                                           WHERE desa.nama LIKE '%".mysqli_real_escape_string($connection, $_POST['cari'])."%' 
                                           ORDER BY desa.nama";
                                    
                                    $tampil = mysqli_query($connection, $query);
                                    while($r = mysqli_fetch_array($tampil)) {
                                        $no++;
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo htmlspecialchars($r['nama']); ?></td>
                                            <td><?php echo htmlspecialchars($r['deskripsi']); ?></td>
                                            <td><?php echo htmlspecialchars($r['kecamatan']); ?></td>
                                            <td>
                                                <a href="index.php?menu=desa&act=ubah&id=<?php echo $r['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="master.php?menu=desa&act=hapus&id=<?php echo $r['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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
                        <h4 class="card-title">Tambah Data Desa</h4>
                        <form action="master.php?menu=desa&act=simpan" method="POST" class="mt-4">
                            <div class="form-group">
                                <label>Nama Desa</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select name="kecamatan_id" class="form-control" required>
                                    <?php
                                    $kecamatan = mysqli_query($connection, "SELECT id, nama FROM kecamatan ORDER BY nama");
                                    while ($k = mysqli_fetch_array($kecamatan)) {
                                        echo "<option value='".htmlspecialchars($k['id'])."'>".htmlspecialchars($k['nama'])."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="index.php?menu=desa" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;

    case "ubah":
        $tampil = mysqli_query($connection, "SELECT * FROM desa WHERE id='".mysqli_real_escape_string($connection, $_GET['id'])."'");
        $r = mysqli_fetch_array($tampil);
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ubah Data Desa</h4>
                        <form action="master.php?menu=desa&act=update" method="POST" class="mt-4">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($r['id']); ?>">
                            <div class="form-group">
                                <label>Nama Desa</label>
                                <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($r['nama']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required><?php echo htmlspecialchars($r['deskripsi']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select name="kecamatan_id" class="form-control" required>
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
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="index.php?menu=desa" class="btn btn-secondary">Kembali</a>
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