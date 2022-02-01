<div class="center" style="margin-top: 30px;">
	</div>
	
	<div class="row">
		<?php 
		$i=1;
		if(empty($list)){
			echo "<div class='col-md-12'><center><h2>Data tidak ditemukan</h2></center></div>";
		}else{
		foreach($list as $l){
			?>
				
					<div class="card-body">
					<center><a class="btn btn-primary btn-lg" href="<?=base_url('order/make/'.$l->id_apartemen)?>" role="button">Pesan Sekarang</a>
					</div></center>
				
			</div>
					
		<center><div class="card-body">
		 <img src="<?= base_url('assets/images/depan.jpg') ?>" width="300" height="550" alt="">
         <img src="<?= base_url('assets/images/kamar.jpg') ?>" width="300" height="550" alt="">
         <img src="<?= base_url('assets/images/window.jpg') ?>" width="300" height="550" alt="">
     	 <img src="<?= base_url('assets/images/wc.jpg') ?>" width="300" height="550" alt="">
     	</center></div>

			<div class="col-md-4" style="margin-bottom: 20px;">
			<?php $i++; } 
		} ?>
		</div>
	</div>