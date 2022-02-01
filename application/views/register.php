<div class="container">
  <div class="col-md-6 offset-md-3" style="margin-top: 60px;">
    <div class="card">
      <div class="card-header">
        Daftar | Tiara Kost Kota Sukabumi
      </div>
      <div class="card-body">
        <?= form_open_multipart('account/registerProccess') ?>
        <?= $this->session->flashdata('message') ?>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" value="<?= set_value('email') ?>">
          <?= form_error('email', '<small class="text-danger">', '</small>') ?>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukan Nama Lengkap" value="<?= set_value('nama') ?>">
          <?= form_error('nama', '<small class="text-danger">', '</small>') ?>

        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Alamat</label>
          <textarea name="alamat" class="form-control" placeholder="Masukan Alamat" value="<?= set_value('alamat') ?>"><?= set_value('alamat') ?></textarea>
          <?= form_error('alamat', '<small class="text-danger">', '</small>') ?>

        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Nomor HP</label>
          <input type="text" name="no_hp" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukan Nomor HP" value="<?= set_value('no_hp') ?>">
          <?= form_error('no_hp', '<small class="text-danger">', '</small>') ?>

        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Username</label>
          <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukan Username" value="<?= set_value('username') ?>">
          <?= form_error('username', '<small class="text-danger">', '</small>') ?>

        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Masukan Password">
          <?= form_error('password', '<small class="text-danger">', '</small>') ?>

        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Konfirmasi Password</label>
          <input type="password" name="c_password" class="form-control" id="exampleInputPassword1" placeholder="Masukan Konfirmasi Password">
        </div>

        <div class="form-group">
          <input type="hidden" name="image_hidden" value="">
          <label for="exampleInputPassword1">Foto Ktp <span class="text-danger">*</span></label>
          <input type="file" name="image" class="form-control" id="image">
          <?= form_error('image_hidden', '<small class="text-danger">', '</small>') ?>

        </div>

        <div class="form-group">
          Sudah mempunyai akun? <a href="<?= base_url('account/login') ?>">Masuk</a>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
      </div>
    </div>
  </div>
</div>