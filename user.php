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
                        <h4 class="card-title mb-4">Data User</h4>
                        <div class="d-flex justify-content-end mb-3">
                            <form action="index.php?menu=user" method="POST" class="d-flex">
                                <input type="text" name="cari" value="<?php echo isset($_POST['cari']) ? $_POST['cari'] : ''; ?>" class="form-control mr-2">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User Login</th>
                                        <th>Password</th>
                                        <th>Nama</th>
                                        <th>Level</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
									$query = empty($_POST['cari']) 
									? "SELECT * FROM user ORDER BY user_login" 
									: "SELECT * FROM user WHERE user_login LIKE '%".mysqli_real_escape_string($connection, $_POST['cari'])."%' ORDER BY user_login";
								
								$tampil = mysqli_query($connection, $query);
								while($r = mysqli_fetch_array($tampil)) {
									$no++;
									?>
									<tr>
										<td><?php echo $no; ?></td>
										<td><?php echo htmlspecialchars($r['user_login']); ?></td>
										<td><?php echo str_repeat('*', strlen($r['password'])); ?></td>
										<td><?php echo htmlspecialchars($r['nama']); ?></td>
										<td><?php echo htmlspecialchars($r['level']); ?></td>
										<td>
											<a href="index.php?menu=user&act=ubah&id=<?php echo $r['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
											<a href="master.php?menu=user&act=hapus&id=<?php echo $r['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
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
					<h4 class="card-title">Tambah Data User</h4>
					<form action="master.php?menu=user&act=simpan" method="POST" class="mt-4">
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="user_login" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Nama Lengkap</label>
							<input type="text" name="nama" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Level</label>
							<select name="level" class="form-control" required>
								<option value="">Pilih Level</option>
								<option value="admin">Admin</option>
								<option value="user">User</option>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<a href="index.php?menu=user" class="btn btn-secondary">Kembali</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	break;

case "ubah":
	$tampil = mysqli_query($connection, "SELECT * FROM user WHERE id='".mysqli_real_escape_string($connection, $_GET['id'])."'");
	$r = mysqli_fetch_array($tampil);
	?>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Ubah Data User</h4>
					<form action="master.php?menu=user&act=update" method="POST" class="mt-4">
						<input type="hidden" name="id" value="<?php echo $r['id']; ?>">
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="user_login" class="form-control" value="<?php echo htmlspecialchars($r['user_login']); ?>" required>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
						</div>
						<div class="form-group">
							<label>Nama Lengkap</label>
							<input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($r['nama']); ?>" required>
						</div>
						<div class="form-group">
							<label>Level</label>
							<select name="level" class="form-control" required>
								<option value="">Pilih Level</option>
								<option value="admin" <?php echo ($r['level'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
								<option value="user" <?php echo ($r['level'] == 'user') ? 'selected' : ''; ?>>User</option>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="index.php?menu=user" class="btn btn-secondary">Kembali</a>
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