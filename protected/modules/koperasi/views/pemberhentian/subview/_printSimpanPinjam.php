<style>
@page {
	size: A4;
}

body , table td , table th {
	font-size: 10px;
}

body {
	width: 210mm;
}

table td , table th {
	padding: 3px;
}

.header td {
	padding: 2px;
}

.header tr:last-child > td {
	border-bottom: 2px black;
	border-bottom-style: double;
}

.header-judul {
	font-size: 20px;
}
.header-alamat {
	font-size: 14px;	
}

.center {
	text-align: center;
}

.right {
	text-align: right;
}

.kwitansi-judul {
	font-weight: bold;
	font-size: 12px;
	text-decoration: underline;
}

.table-margin {
	margin-top: 5px;
	margin-bottom: 10px;
}

.table-detail td , .table-detail th {
	border: 1px solid black;
}
.table-detail tfoot td {
	font-weight: bold;
}
.detail-judul {
	text-decoration: underline;
}
</style>


<?php $profil = ProfilS::model()->find(); ?>
<table width="100%" class="header">
	<tr>
		<td><?php echo CHtml::image(Params::urlProfilGambar().$profil->path_valuesimage1, '', array('width'=>90)); ?></td>
		<td>
		<div class="header-judul center"><?php echo strtoupper($profil->nama_profil); ?></div>
		<div class="header-alamat center"><?php echo $profil->alamat_profil.", Telp.".$profil->telp_profil; ?></div>
		</td>
		<tr>
			<td colspan="2" class="kwitansi-judul center">INFORMASI SIMPAN PINJAM ANGGOTA</td>
		</tr>
	</tr>
</table>

<table width="100%" class="table-margin">
	<tbody>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td width="100%"><?php echo $anggota->nama_pegawai; ?></td>
			
			<td>Unit</td>
			<td>:</td>
			<td nowrap><?php echo $anggota->namaunit; ?></td>
		</tr>
		<tr>
			<td nowrap>Nomor Anggota</td>
			<td>:</td>
			<td><?php echo $anggota->nokeanggotaan; ?></td>
			
			<td>Golongan</td>
			<td>:</td>
			<td nowrap><?php echo $golongan->golonganpegawai_nama; ?></td>
		</tr>
	</tbody>
</table>

<div class="detail-judul center">SIMPANAN</div>
<table width="100%" class="table-margin table-detail">
	<thead>
		<tr>
			<th>Tgl Simpanan</th>
			<th>Jenis Simpanan</th>
			<th>Pokok Simpanan</th>
			<th>Jasa Simpanan</th>
			<th>Total Simpanan</th>
		</tr>
	</thead>
	<tbody><?php echo $res['simpanan']['tab']; ?></tbody>
	<tfoot>
		<tr>
			<td colspan="4">Total Simpanan</td>
			<td class="right"><?php echo MyFormatter::formatNumberForPrint($res['simpanan']['total']); ?></td>
		</tr>
	</tfoot>
</table>

<div class="detail-judul center">ANGSURAN</div>
<table width="100%" class="table-margin table-detail">
	<thead>
		<tr>
			<th>Tgl Pinjaman</th>
			<th>Pokok Angsuran</th>
			<th>Jasa Angsuran</th>
			<th>Total Angsuran</th>
			<th>Bayar</th>
			<th>Sisa</th>
		</tr>
	</thead>
	<tbody><?php echo $res['angsuran']['tab']; ?></tbody>
	<tfoot>
		<tr>
			<td colspan="5">Total Sisa Angsuran</td>
			<td class="right"><?php echo MyFormatter::formatNumberForPrint($res['angsuran']['total']); ?></td>
		</tr>
	</tfoot>
</table>