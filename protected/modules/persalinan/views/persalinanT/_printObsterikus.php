<?php

echo $this->renderPartial('_headerPrint'); 

$pbidan = PegawaiM::model()->findByPk($ps->bidan_id);

?>


<style>
	.tab_kala_iv th, .tab_kala_iv td {
		border: 1px solid black;
		padding: 3px;
	}
	
	.tab_list {
		float: left;
	}
	
	.tab_list td {
		vertical-align: top;
	}
</style>

<h2 style="text-align: center;">Catatan Persalinan</h2>

<table width="49%" class="tab_list">
	<tbody>
		<tr>
			<td style="text-align: right;">1. </td>
			<td width="100%">
				Tanggal : ..............................<!--u><?php // echo MyFormatter::formatDateTimeForUser($ob->create_time); ?></u-->
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">2. </td>
			<td>
				Nama Bidan : ..............................<!--u><?php // echo empty($pbidan)?"-":$pbidan->namaLengkap; ?></u-->
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">3. </td>
			<td>
				Tempat Persalinan : <?php 
				$alamatRS = "...................................";
				//if ($ps->islahirdirs) {
				//	$alamatRS = "<u>".Yii::app()->user->getState('alamatlokasi_rumahsakit')."</u>";
				//	echo "<u>Rumah Sakit</u>";
				//} else {
				?>
				<table width="100%">
					<tr>
						<td width="50%"><input type="checkbox" /> Rumah Ibu</td>
						<td width="50%"><input type="checkbox" /> Puskesmas</td>
					</tr>
					<tr>
						<td><input type="checkbox" /> Polindes</td>
						<td><input type="checkbox" /> Rumah Sakit</td>
					</tr>
					<tr>
						<td><input type="checkbox" /> Klinik Swasta</td>
						<td><input type="checkbox" /> Lainnya : ..............................</td>
					</tr>
				</table>
				<?php //} ?>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">4. </td>
			<td>
				Alamat Tempat Persalinan : <?php echo $alamatRS; ?>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">5. </td>
			<td>
				Catatan : <input type="checkbox"> Rujuk, kala : I / II / III / IV
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">6. </td>
			<td>
				Alasan Merujuk : ...........................................
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">7. </td>
			<td>
				Tempat Rujukan : ...........................................
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">8. </td>
			<td>
				Pendamping pada saat merujuk : <br/>
				<table width="100%">
					<tr>
						<td width="50%"><input type="checkbox" /> Bidan</td>
						<td width="50%"><input type="checkbox" /> Teman</td>
					</tr>
					<tr>
						<td><input type="checkbox" /> Suami</td>
						<td><input type="checkbox" /> Dukun</td>
					</tr>
					<tr>
						<td><input type="checkbox" /> Keluarga</td>
						<td><input type="checkbox" /> Tidak Ada : ..............................</td>
					</tr>
				</table>
			</td>
		</tr>


		
		<tr>
			<td colspan="2"><br/><h4>Kala I</h4></td>
		</tr>
		<tr>
			<td style="text-align: right;">9. </td>
			<td>
				Partogram melewati garis waspada : Y / T
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">10. </td>
			<td>
				Masalah Lain, sebutkan : .................................................................................
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">11. </td>
			<td>
				Penatalaksanaan masalah Tsb : .................................................................................
			</td>
		</tr>

		<tr>
			<td style="text-align: right;">12. </td>
			<td>
				Hasil : .................................................................................
			</td>
		</tr>


		<tr>
			<td colspan="2"><br/><h4>Kala II</h4></td>
		</tr>
		<tr>
			<td style="text-align: right;">13. </td><td>
				Episiotomi :<br/>
				<input type="checkbox" /> Ya, Indikasi : .................................... <br/>
				<input type="checkbox" /> Tidak
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">14. </td>
			<td>
				Pendamping pada saat persalinan : <br/>
				<table width="100%">
					<tr>
						<td width="30%"><input type="checkbox" /> Suami</td>
						<td width="30%"><input type="checkbox" /> Teman</td>
						<td width="30%"><input type="checkbox" /> Tidak Ada<td>
					<tr>
						<td><input type="checkbox" /> Keluarga</td>
						<td><input type="checkbox" /> Dukun</td>
					</tr>
					<tr>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">15. </td>
			<td>
				Gawat Janin :<br/>
				<input type="checkbox" /> Ya, tindakan yang dilakukan :<br/>
				<ol>
					<li>..............................................</li>
					<li>..............................................</li>
					<li>..............................................</li>
				</ol>
				<input type="checkbox" /> Tidak.
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">16. </td>
			<td>
				Distosia Bahu :<br/>
				<input type="checkbox" /> Ya, tindakan yang dilakukan :<br/>
				<ol>
					<li>..............................................</li>
					<li>..............................................</li>
					<li>..............................................</li>
				</ol>
				<input type="checkbox" /> Tidak.
			</td>
		</tr>
		
		<tr>
			<td style="text-align: right;">17. </td>
			<td>
				Masalah Lain, sebutkan : .................................................................................
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">18. </td>
			<td>
				Penatalaksanaan masalah Tsb : .................................................................................
			</td>
		</tr>

		<tr>
			<td style="text-align: right;">19. </td>
			<td>
				Hasil : .................................................................................
			</td>
		</tr>


		<tr>
			<td colspan="2"><br/><h4>Kala III</h4></td>
		</tr>
		<tr>
			<td style="text-align: right;">20. </td><td>Lama Kala III: ................... menit<!--u><?php // echo $ob->kala3_darahcc; ?> Menit</u--></td>
		</tr>
		<tr>
			<td style="text-align: right;">21. </td><td>
				Pemberian Olsitosin 10 U im?<br/>
				<input type="checkbox" /> Ya, waktu : ................... menit sesudah persalinan<br/>
				<input type="checkbox" /> Tidak, alasan : ....................................
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">22. </td><td>
				Pemberian Ulang Oksitosin (2x) ?<br/>
				<input type="checkbox" /> Ya, alasan : ....................................<br/>
				<input type="checkbox" /> Tidak
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">23. </td><td>
				Penegangan tali pusat terkendali ?<br/>
				<input type="checkbox" /> Ya <br/>
				<input type="checkbox" /> Tidak, alasan : ....................................
			</td>
		</tr>
		
	</tbody>
</table>

<table width="49%" class="tab_list">
	<tbody>
		<tr>
			<td style="text-align: right;">24. </td><td>
				Masase fundus uteri ?<br/>
				<input type="checkbox" /> Ya<br/>
				<input type="checkbox" /> Tidak, alasan : ....................................
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">25. </td>
			<td>
				Plasenta lahir lengkap (intact) : Y / T<br/>
				Jika tidak lengkap, tindakan yang dilakukan :<br/>
				<ol>
					<li>..............................................</li>
					<li>..............................................</li>
				</ol>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">26. </td>
			<td>
				Plasenta tidak lahir > 30 menit : Y / T<br/>
				Jika ya, tindakan :<br/>
					<ol>
						<li>..............................................</li>
						<li>..............................................</li>
					</ol>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">27. </td><td>
				Laserasi :<br/>
				<input type="checkbox" /> Ya, dimana : ....................................<br/>
				<input type="checkbox" /> Tidak
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">28. </td><td>
				Jika laserasi perineum, derajat : 1 / 2 / 3 / 4<br/>
				Tindakan : <br/>
				<input type="checkbox" /> Penjahitan, dengan / tanpa anestesi<br/>
				<input type="checkbox" /> Tidak dijahit, alasan : ....................................
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">29. </td><td>
				Atoni Uteri :<br/>	
				<input type="checkbox" /> Ya, tindakan :<br/>
				<ol>
					<li>..............................................</li>
					<li>..............................................</li>
					<li>..............................................</li>
				</ol>
				<input type="checkbox" /> Tidak
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">30. </td><td>
				Jumlah Pendarahan : ............... ml
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">31. </td>
			<td>
				Masalah Lain, sebutkan : .................................................................................
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">32. </td>
			<td>
				Penatalaksanaan masalah Tsb : .................................................................................
			</td>
		</tr>

		<tr>
			<td style="text-align: right;">33. </td>
			<td>
				Hasil : .................................................................................
			</td>
		</tr>
		
		
		
		<tr>
			<td colspan="2"><br/><h4>BAYI BARU LAHIR</h4></td>
		</tr>
		<tr>
			<td style="text-align: right;">34. </td>
			<td>
				Berat Badan : ..........................gram
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">35. </td>
			<td>
				Panjang : ..........................cm
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">36. </td>
			<td>
				Jenis Kelamin : L / P
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">37. </td>
			<td>
				Penilaian bayi baru kahir : baik / ada penyulit
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">38.</td>
			<td>
				Bayi Lahir : <br/>
				<input type="checkbox" /> Normal, tindakan :<br/>
				<ul>
					<li><input type="checkbox" /> Mengeringkan</li>
					<li><input type="checkbox" /> Menghangatkan</li>
					<li><input type="checkbox" /> Rangsang Taktil</li>
					<li><input type="checkbox" /> Bungkus Bayi dan tempatkan di sisi Ibu</li>
				</ul>
				<input type="checkbox" /> Aspiksia ringan/pucat/biru/lemas, tindakan :<br/>
				<ul>
					<li><input type="checkbox" /> Mengeringkan</li>
					<li><input type="checkbox" /> Bebaskan Jalan Nafas</li>
					<li><input type="checkbox" /> Menghangatkan</li>
					<li><input type="checkbox" /> Rangsang Taktil</li>
					<li><input type="checkbox" /> Bungkus Bayi dan tempatkan di sisi Ibu</li>
					<li><input type="checkbox" /> Lain-lain : ...........................</li>
				</ul>
				<input type="checkbox" /> Cacat Bawaan, tindakan :<br/>
				<ol>
					<li>..............................................</li>
					<li>..............................................</li>
					<li>..............................................</li>
				</ol>
				<input type="checkbox" /> Hipotermi, tindakan :<br/>
				<ol>
					<li>..............................................</li>
					<li>..............................................</li>
					<li>..............................................</li>
				</ol>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">39. </td><td>
				Pemberian ASI<br/>
				Tindakan : <br/>
				<input type="checkbox" /> Ya, waktu : ........ jam setelah bayi lahir	<br/>
				<input type="checkbox" /> Tidak, alasan : ....................................
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">40. </td>
			<td>
				Masalah Lain, sebutkan : .................................................................................<br/>
				Hasil : .................................................................................<
			</td>
		</tr>
	</tbody>
</table>

<div class="clear" style="clear: both;">	</div>
<br/>
<h4>Pemantauan Persalinan Kala IV</h4>
<table class="tab_kala_iv" width="100%">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>Waktu</th>
			<th>Tekanan Darah</th>
			<th>Nadi/ Pernafasan</th>
			<th>Tinggi Fundus</th>
			<th>Kontraksi Uterus</th>
			<th>Kandung Kemih</th>
			<th>Pendarahan (cc)</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($obdet as $item): ?>
		<tr>
			<td><?php echo MyFormatter::formatDateTimeForUser($item->kala4_tanggal); ?></td>
			<td><?php echo $item->kala4_waktu; ?></td>
			<td><?php echo $item->kala4_tekanandarah; ?></td>
			<td>
				<?php echo (empty($item->kala4_detaknadi))?"-":$item->kala4_detaknadi." / ".
				(empty($item->kala4_pernapasan)?"-":$item->kala4_pernapasan); ?>
			</td>
			<td><?php echo $item->kala4_tinggifundus; ?></td>
			<td><?php echo $item->kala4_kontraksi; ?></td>
			<td><?php echo $item->kala4_kandungkemih; ?></td>
			<td><?php echo $item->kala4_darahcc; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

