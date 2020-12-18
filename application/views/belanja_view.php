<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- <?php var_dump($belanja_all);?> -->
<!DOCTYPE html>
<html>
<head>
	<title>Belanja</title>
</head>
<body>
	<p>Subkomp/Kegiatan : <?=$subkomponen->deskripsi?></p>
	<p>MAK : <?=$akun->mak?> - <?=$akun->deskripsi?></p>
	<p>
		<table border="1">
			<tr>
				<td>Pagu</td>
				<td><?=number_format($akun->total_harga,'0',',','.')?></td>
			</tr>
			<tr>
				<td>Sisa</td>
				<td><?=number_format($sisa_pagu,'0',',','.')?></td>
			</tr>
		</table>
	</p>

<div>
	<form method="POST" action="<?=base_url('home/simpan')?>">
		<input type="hidden" name="mak" value="<?=$akun->mak?>">
		<div>
			<label>Tanggal pemakaian</label><br>
			<input type="date" name="tanggal_pakai_pagu">
		</div>
		<div>
			<label>Pengguna</label><br>
			<div>
				<input type="radio" name="pengguna[]" value="1">
				<label>PRR</label>
			</div>
			<div>
				<input type="radio" name="pengguna[]" value="2">
				<label>PRS</label>
			</div>
			<div>
				<input type="radio" name="pengguna[]" value="3">
				<label>Eximik</label>
			</div>
			<div>
				<input type="radio" name="pengguna[]" value="4">
				<label>TOP</label>
			</div>
		</div>
		<div>
			<label>Jumlah pemakaian pagu</label><br>
			<input type="number" name="jumlah_pakai_pagu">
		</div>
		<div>
			<label>Nomor kuitansi</label><br>
			<input type="text" name="nomor_kuitansi">
		</div>
		<div>
			<label>Keterangan pemakaian</label><br>
			<textarea name="keterangan_pemakaian" rows="5"></textarea>
		</div>
		<div>
			<button type="submit">Simpan</button>
			<button type="reset">Reset</button>
		</div>
	</form>
</div>

	<p>Riwayat pemakaian akun</p>
	<p>Jumlah transaksi : <?=$jumlah_data?> transaksi</p>
<table border="1">
	<thead>
		<tr>
			<th>ID transaksi</th>
			<th>Tanggal pakai</th>
			<th># Kuitansi</th>
			<th>Jumlah belanja</th>
			<th>Keterangan transaksi</th>
			<th>Pengguna</th>
			<th>Lengkap</th>
			<th>Benar</th>
		</tr>
	</thead>
	<tbody>
		<?php if(empty($belanja_all)):?>
			<tr>
				<td colspan="8" align="center">Belum ada transaksi.</td>
			</tr>
		<?php else:?>
			<?php foreach($belanja_all as $belanja):?>
				<tr>
					<td align="center"><?=$belanja['id']?></td>
					<td><?=date('d F Y', $belanja['epoch_transaksi'])?></td>
					<td><?=$belanja['nomor_kuitansi']?></td>
					<td align="right"><?=number_format($belanja['debet'],'0',',','.')?></td>
					<td><?=$belanja['keterangan_belanja']?></td>
					<td>
						<?php
						switch ($belanja['pengguna'])
						{
							case 1:
							echo 'PRR';
							break;

							case 2:
							echo 'PRS';
							break;

							case 3:
							echo 'Eximik';
							break;

							case 4:
							echo 'TOP';
							break;
						}
						?>
					</td>
					<td>
						<?php
						switch ($belanja['is_dokumen_lengkap']) {
							case 't':
								echo 'LENGKAP';
								break;
							
							case 'f':
								echo 'BELUM LENGKAP';
								break;
						}
						?>
					</td>
					<td>
						<?php
						switch ($belanja['is_dokumen_benar']) {
							case 't':
								echo 'BENAR';
								break;
							
							case 'f':
								echo 'KOREKSI';
								break;
						}
						?>
					</td>
				</tr>
			<?php endforeach;?>
		<?php endif;?>
	</tbody>
</table>
<p>Jumlah pemakaian pagu : Rp. <?=number_format($total_belanja,'0',',','.')?></p>

<p>
	<a href="<?=base_url()?>">Kembali</a>
</p>
</body>
</html>