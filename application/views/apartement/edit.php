<div class="container">
  <div class="row">
    <div class="col-md-12" style="margin-top: 60px;">
      <div class="card">
        <div class="card-header">
          Edit Tiara Kost | Admin
        </div>
        <div class="card-body">

          <?=form_open_multipart()?>
          <?=$this->session->flashdata('message')?>
          

          <div class="form-group">
            <label for="exampleInputEmail1">Harga per Bulan</label>
            <input type="number" name="harga_bulan" value="<?=$detail->harga_bulan?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukan Harga per Bulan" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Harga per Tahun</label>
            <input type="number" name="harga_tahun" value="<?=$detail->harga_tahun?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukan Harga per Tahun" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Foto</label>
            <small class="text-bold">*File yang diizinkan : jpg,png,jpeg</small>
            <br><img class="img-thumbnail" style="width: 200px" src="<?=base_url('assets/images/apartement')."/".$detail->foto?>"><br><br>
            <input type="file" name="foto">
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>