<!-- Dialog Konfirmasi -->
<div class="modal fade custom-width" id="dialog_konfirmasi">
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Anda yakin untuk data yang anda input ?</h4>
			</div>
			<div class="modal-body">
				<div class="panel-body">
					<div class="panel panel-body panel-primary col-sm-12">
						<div class="panel-heading panel-heading2">
							<div class="panel-title">Data Anggota</div>  
						</div>
						<div class="panel-body col-sm-12">
							<table width="100%">
								<tr>
									<th>Nomor Anggota</th>
									<td id="k_nokeanggotaan"></td>
									<th>No Permohonan</th>
									<td id="k_nopermohonan"></td>
								</tr>
								<tr>
									<th>Nama Anggota</th>
									<td id="k_namaanggota"></td>
									<th>Jumlah Pinjaman</th>
									<td id="k_jmlpinjaman"></td>
								</tr>
								<tr>
									<th>Unit Kerja</th>
									<td id="k_unit"></td>
									<th>Disetujui Oleh</th>
									<td id="k_disetujui"></td>
								</tr>
								<tr>
									<th>Golongan</th>
									<td id="k_golongan"></td>
									<th>Untuk Keperluan</th>
									<td id="k_pkeperluan"></td>
								</tr>
								<tr>
									<th>Tgl Lahir / Umur</th>
									<td id="k_tglumur"></td>
									<th>Batas Plafon</th>
									<td id="k_plafon"></td>
								</tr>
								<tr>
									<th>Status Permohonan</th>
									<td id="k_statuspermohonan"></td>
									<th>Tunggakan Pinjaman</th>
									<td id="k_tunggakanpinjam"></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<th>Tunggakan Barang</td>
									<td id="k_tunggakanbarang"></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<th>Jenis Pinjaman</td>
									<td id="k_jenispinjaman"></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="panel panel-body panel-primary col-sm-12">
						<div class="panel-heading panel-heading2">
							<div class="panel-title">Pinjaman</div>  
						</div>
						<div class="panel-body col-sm-12">
							<table width="100%">
								<tr>
									<th>Tgl Pinjaman</th>
									<td id="kp_tglpinjaman"></td>
									<th>Tgl Jatuh Tempo</th>
									<td id="kp_tgljatuhtempo"></td>
								</tr>
								<tr>
									<th>Jml Pinjaman</th>
									<td id="kp_jmlpinjaman"></td>
									<th>Jaminan</th>
									<td id="kp_jaminanberupa"></td>
								</tr>
								<tr>
									<th>Jasa Pinjaman</th>
									<td id="kp_jasapinjam"></td>
									<th>Cara Bayar</th>
									<td id="kp_carabayar"></td>
								</tr>
								<tr>
									<th>Jangka Waktu</th>
									<td id="kp_jangkawaktu"></td>
									<th>Angsuran Sebanyak</th>
									<td id="kp_jmlangsuran"></td>
								</tr>
								<tr>
									<th>Keterangan</th>
									<td id="kp_keperluan" colspan="3"></td>
								</tr>
							</table>
						</div>
						<div class="panel-heading panel-heading2">
							<div class="panel-title">Potongan</div>  
						</div>
						<div class="panel-body col-sm-12">
							<table width="100%">
								<tr>
									<th width="16.6%">Gaji</th>
									<td width="16.6%" id="k_gaji" class="num"></td>
									<th width="16.6%">Insentif</th>
									<td width="16.6%" id="k_insentif" class="num"></td>
									<th width="16.6%">Simpanan</th>
									<td width="16.6%" id="k_simpanan" class="num"></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="panel panel-body panel-primary col-sm-12">
						<div class="panel-heading panel-heading2">
							<div class="panel-title">Kas Keluar</div>  
						</div>
						<div class="panel-body col-sm-12">
							<table width="100%">
								<tr>
									<th width="25%" rowspan="6" style="vertical-align: top;">Keterangan</td>
									<td width="25%"  rowspan="6" style="vertical-align: top;"  id="bkk_keterangan"></td>
									<th width="25%" >Jml Pinjaman</th>
									<td width="25%"  id="bkk_jmlpinjaman"></td>
								</tr>
								<!--tr>
									<th>Biaya Administrasi</th>
									<td id="bkk_admin"></td>
								</tr-->
								<tr>
									<th>Biaya Materai</th>
									<td id="bkk_materai"></td>
								</tr>
								<tr>
									<th>Biaya Asuransi</th>
									<td id="bkk_asuransi"></td>
								</tr>
								<tr>
									<th>Biaya Provisi</th>
									<td id="bkk_provisi"></td>
								</tr>
								<tr>
									<th>Jml Kas Keluar</th>
									<td id="bkk_kaskeluar"></td>
								</tr>
							</table>
						</div>
						<div class="panel-heading panel-heading2">
							<div class="panel-title">Persetujuan</div>  
						</div>
						<div class="panel-body col-sm-12">
							<table width="100%">
								<tr>
									<th width="16.6%">Dibuat Oleh</th>
									<td width="16.6%" id="per_dibuat"></td>
									<th width="16.6%">Diperiksa Oleh</th>
									<td width="16.6%" id="per_diperiksa"></td>
									<th width="16.6%">Disetujui Oleh</th>
									<td width="16.6%" id="per_disetujui"></td>
								</tr>
								<tr>
									<th>Tgl</th>
									<td id="per_dibuattgl"></td>
									<th>Tgl</th>
									<td id="per_diperiksatgl"></td>
									<th>Tgl</th>
									<td id="per_disetujuitgl"></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div style="text-align: center" class="panel-body">
						<?php 
						$this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'button',
							'type'=>'primary',
							'label'=>'OK',
							'htmlOptions'=>array('class'=>'btn btn-success', 'onclick'=>'$("#dialog_konfirmasi").modal("hide"); $("#pinjaman-form").submit();'),
						)); echo " ";
						$this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'button',
							'type'=>'primary',
							'label'=>'Batal',
							'htmlOptions'=>array('class'=>'btn btn-white', 'onclick'=>'$("#dialog_konfirmasi").modal("hide");'),
						));
						?>
				</div>
			</div>
		</div>
	</div>
</div>