<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!DOCTYPE html>
<html>
<head>
	<title>Simbah</title>
</head>
<body>
<table border="1">
	<thead>
		<tr>
			<th>No</th>
			<th>MAK</th>
			<th>Deskripsi</th>
			<th>Pagu</th>
			<th>Sisa</th>
			<th>Depth</th>
		</tr>
	</thead>
	<?php $i=1;?>
	<tbody>
		<?php foreach($pok as $p):?>
			<tr>
				<td><?=$i?></td>
				<?php if($p['depth'] == 4 || $p['depth'] == 5):?>
					<td><?=$p['mak']?></td>
				<?php else:?>
					<td><a href="<?=base_url('home/belanja/').$p['mak']?>"><?=$p['mak']?></a></td>
				<?php endif;?>
				<td><?=$p['deskripsi']?></td>
				<?php if($p['depth'] == 6):?>
					<td align="right">
						<?=number_format($p['total_harga'], '0',',', '.')?>
					</td>
					<td align="right">
						<?=($p['sisa'] == 0 ? number_format($p['total_harga'], '0',',', '.'):number_format($p['sisa'], '0',',', '.'))?>
					</td>
				<?php else:?>
					<td></td>
					<td></td>
				<?php endif;?>	
				<td><?=$p['depth']?></td>
			</tr>
			<?php $i++;?>
		<?php endforeach;?>
	</tbody>
</table>
</body>
</html>