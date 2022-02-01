
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          Form Pemesanan Kamar
        </div>
        <div class="card-body">
          <?=form_open('order/processOrder/'.$detail->id_apartemen)?>
          <?=$this->session->flashdata('message')?>
            <div class="form-group">
              <label for="exampleInputEmail1">Lamanya Kost</label>
              <select name="paket" id="sPaket" onchange="tJumlah()" class="form-control" required>
                <option value=""> Pilih Lamanya Kost</option>
                <?php 
                $paket = array('bulanan','tahunan');
                foreach($paket as $p){
                  echo '<option value="'.$p.'">'.ucwords($p).'</option>';
                }
                ?>
              </select>
            </div>
            <div class="form-group" id="divJumlah" style="display: none">
              <label for="exampleInputPassword1" id="lJumlah">Jumlah</label>
              <input type="text" name="jumlah_paket" class="form-control" onchange="countCheckOut()" id="iJumlah" placeholder="" required>
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Total Bayar</label><br>
              <p class="badge badge-primary" id="pHarga" style="font-size: 30px;font-weight: 300">Rp. 0,-</p>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Jenis Pembayaran</label>
              <select name="jenis_pembayaran"  class="form-control" required>
                <option value="">Pilih Jenis Pembayaran</option>
                <?php 
                $jenis_pembayaran = array('cash','transfer');
                foreach($jenis_pembayaran as $p){
                  echo '<option value="'.$p.'">'.ucwords($p).'</option>';
                }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Bayar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function tJumlah(){
    var paket = $('#sPaket').val();
    var npaket;
    if(paket!==''){
    if(paket=='bulanan'){
        npaket = 'Bulan';
      }else{
        npaket = 'Tahun';
      }
      $('#lJumlah').html('Jumlah '+npaket);
      $('#iJumlah').prop('placeholder','Masukan Jumlah '+npaket);
      $('#divJumlah').show();
    }else{
      $('#divJumlah').hide();
    }
    countCheckOut();
  }
  function countCheckOut(){
    var paket = $('#sPaket').val();
    var jumlah = $('#iJumlah').val();
    var checkIn = $('#iCheckIn').val();
    var day;
    if(paket!==''&&jumlah!==''&&checkIn!==''){
      if(paket=='bulanan'){
        day = 30;
      }else{
        day = 365;
      }
      var days = jumlah * day;

      var myDate = new Date(checkIn);

      var newDate = addDays(myDate,days);
      $('#tCheckOut').html(tanggalIndo(newDate));
    }
    countBayar();
  }
  function countBayar(){
    var paket = $('#sPaket').val();
    var jumlah = $('#iJumlah').val();
    var harga;
    if(paket!==''&&jumlah!==''){
      if(paket=='bulanan'){
        harga = <?=$detail->harga_bulan?>;
      }else{
        harga = <?=$detail->harga_tahun?>;
      }
      var total = jumlah * harga;
      $('#pHarga').html(rupiah(total));
    }

  }
</script>