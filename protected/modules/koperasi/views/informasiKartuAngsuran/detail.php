<table width="100%">
	<tr>
		<td>Nama Anggota</td>
		<td>:</td>
		<td width="100%"><?php echo $pinjaman->nama_pegawai; ?></td>
		<td>Tgl Pinjaman</td>
		<td>:</td>
		<td><?php echo date("d/m/Y", strtotime($pinjaman->tglpinjaman)); ?></td>
	</tr>
	<tr>
		<td nowrap>Nomor Anggota</td>
		<td>:</td>
		<td><?php echo $pinjaman->nokeanggotaan; ?></td>
		<td>Tgl Jatuh Tempo</td>
		<td>:</td>
		<td><?php echo date("d/m/Y", strtotime($pinjaman->jatuh_tempo)); ?></td>
	</tr>
	<tr>
		<td>Unit</td>
		<td>:</td>
		<td><?php echo $pinjaman->namaunit; ?></td>
		<td nowrap>Nomor Pinjaman</td>
		<td>:</td>
		<td><?php echo $pinjaman->no_pinjaman; ?></td>
	</tr>
	<tr>
		<td>Golongan</td>
		<td>:</td>
		<td><?php echo $pinjaman->golonganpegawai_nama; ?></td>
		<td>Jml Pinjaman</td>
		<td>:</td>
		<td><?php echo MyFormatter::formatNumberForPrint($pinjaman->jml_pinjaman); ?></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td>Jasa Pinjaman</td>
		<td>:</td>
		<td><?php echo MyFormatter::formatNumberForPrint($pinjaman->jasapinjaman); ?></td>
	</tr>
</table>