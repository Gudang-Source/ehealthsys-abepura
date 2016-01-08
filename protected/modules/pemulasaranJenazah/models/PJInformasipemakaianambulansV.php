<?php
class PJInformasipemakaianambulansV extends InformasipemakaianambulansV
{
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'pesanambulans_t' => 'Pesanambulans T',
			'pesanambulans_tgl' => 'Pesanambulans Tgl',
			'pesanambulans_no' => 'Pesanambulans No',
			'pemakaianambulans_id' => 'Pemakaianambulans',
			'tglpemakaianambulans' => 'Tglpemakaianambulans',
			'tglkembaliambulans' => 'Tanggal Kembali Mobil Jenazah',
			'untukkeperluan' => 'Untukkeperluan',
			'mobilambulans_id' => 'Mobilambulans',
			'mobilambulans_kode' => 'Mobilambulans Kode',
			'nopolisi' => 'No. Polisi',
			'jeniskendaraan' => 'Jeniskendaraan',
			'isibbmliter' => 'Isibbmliter',
			'kmterakhirkend' => 'Kmterakhirkend',
			'photokendaraan' => 'Photokendaraan',
			'hargabbmliter' => 'Hargabbmliter',
			'formulajasars' => 'Formulajasars',
			'formulajasaba' => 'Formulajasaba',
			'formulajasapel' => 'Formulajasapel',
			'pasien_id' => 'Pasien',
			'pemakai_nomorrekammedis' => 'Pemakai Nomorrekammedis',
			'no_rekam_medik' => 'No. Rekam Medik',
			'pemakai_noidentitas' => 'Pemakai Noidentitas',
			'pasien_jenisidentitas' => 'Pasien Jenisidentitas',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'namadepan' => 'Namadepan',
			'pemakai_nama' => 'Nama Pemakai',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jeniskelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'Rt',
			'rw' => 'Rw',
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Mobile Pasien',
			'warga_negara' => 'Warga Negara',
			'photopasien' => 'Photopasien',
			'nama_ibu' => 'Nama Ibu',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'tempattujuan' => 'Tempat Tujuan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'alamattujuan' => 'Alamat Tujuan',
			'rt_rw' => 'Rt Rw',
			'nomobile' => 'No. Mobile',
			'notelepon' => 'No. Telepon',
			'namapj' => 'Namapj',
			'hubunganpj' => 'Hubunganpj',
			'alamatpj' => 'Alamatpj',
			'kmawal' => 'Km Awal',
			'kmakhir' => 'Km Akhir',
			'jmlbbmliter' => 'Jmlbbmliter',
			'jumlahkm' => 'Jumlah Km',
			'tarifperkm' => 'Tarif / Km',
			'totaltarifambulans' => 'Total Tarif Mobil Jenazah',
			'supir_id' => 'Supir',
			'supir_nip' => 'Supir Nip',
			'supir_jenisidentitas' => 'Supir Jenisidentitas',
			'supir_noidentitas' => 'Supir Noidentitas',
			'supir_gelardepan' => 'Supir Gelardepan',
			'supir_nama' => 'Supir Nama',
			'supir_gelarbelakang' => 'Supir Gelarbelakang',
			'paramedis1_id' => 'Paramedis1',
			'paramedis1_nip' => 'Paramedis1 Nip',
			'paramedis1_jenisidentitas' => 'Paramedis1 Jenisidentitas',
			'paramedis1_noidentitas' => 'Paramedis1 Noidentitas',
			'paramedis1_gelardepan' => 'Paramedis1 Gelardepan',
			'paramedis1_nama' => 'Paramedis1 Nama',
			'paramedis1_gelarbelakang' => 'Paramedis1 Gelarbelakang',
			'paramedis2_id' => 'Paramedis2',
			'paramedis2_nip' => 'Paramedis2 Nip',
			'paramedis2_jenisidentitas' => 'Paramedis2 Jenisidentitas',
			'paramedis2_noidentitas' => 'Paramedis2 Noidentitas',
			'paramedis2_gelardepan' => 'Paramedis2 Gelardepan',
			'paramedis2_nama' => 'Paramedis2 Nama',
			'paramedis2_gelarbelakang' => 'Paramedis2 Gelarbelakang',
		);
	}

    public function searchPemakaian()
    {
        $criteria=$this->criteriaSearch();
        $criteria->addBetweenCondition('tglpemakaianambulans',$this->tgl_awal,$this->tgl_akhir);
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}
