<?php
class ASInfopengkajianaskepV extends InfopengkajianaskepV
{
	public $tgl_awal,$tgl_akhir,$instalasi_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('no_pengkajian',$this->no_pengkajian,true);
		$criteria->addBetweenCondition('DATE(pengkajianaskep_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('tglanamnesis',$this->tglanamnesis,true);
		$criteria->compare('keluhanutama',$this->keluhanutama,true);
		$criteria->compare('keluhantambahan',$this->keluhantambahan,true);
		$criteria->compare('riwayatpenyakitterdahulu',$this->riwayatpenyakitterdahulu,true);
		$criteria->compare('riwayatpenyakitkeluarga',$this->riwayatpenyakitkeluarga,true);
		$criteria->compare('riwayatimunisasi',$this->riwayatimunisasi,true);
		$criteria->compare('riwayatalergiobat',$this->riwayatalergiobat,true);
		$criteria->compare('riwayatmakanan',$this->riwayatmakanan,true);
		$criteria->compare('tglperiksafisik',$this->tglperiksafisik,true);
		$criteria->compare('keadaanumum',$this->keadaanumum,true);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('suhutubuh',$this->suhutubuh,true);
		$criteria->compare('pernapasan',$this->pernapasan,true);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('kelainanpadabagtubuh',$this->kelainanpadabagtubuh,true);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('jk',$this->jk,true);
		$criteria->compare('riwayatperjalananpasien',$this->riwayatperjalananpasien,true);
		$criteria->compare('pernahdirawat',$this->pernahdirawat);
		$criteria->compare('dirawatdimana',$this->dirawatdimana,true);
		$criteria->compare('lamasakit',$this->lamasakit,true);
		$criteria->compare('riwpenyakitkeldari',$this->riwpenyakitkeldari,true);
		$criteria->compare('penyakitmayor',$this->penyakitmayor,true);
		$criteria->compare('reaksialergiobat',$this->reaksialergiobat,true);
		$criteria->compare('reaksialergimakanan',$this->reaksialergimakanan,true);
		$criteria->compare('riwayatalergilainnya',$this->riwayatalergilainnya,true);
		$criteria->compare('reaksialergilainnya',$this->reaksialergilainnya,true);
		$criteria->compare('pengobatanygsudahdilakukan',$this->pengobatanygsudahdilakukan,true);
		$criteria->compare('riwayatkelahiran',$this->riwayatkelahiran,true);
		$criteria->compare('gelangtandaalergi',$this->gelangtandaalergi,true);
		$criteria->compare('statusmerokok',$this->statusmerokok);
		$criteria->compare('jmlrokok_btg_hr',$this->jmlrokok_btg_hr);
		$criteria->compare('statuspsikologis',$this->statuspsikologis,true);
		$criteria->compare('statusmental',$this->statusmental,true);
		$criteria->compare('masalahsebelumnya',$this->masalahsebelumnya,true);
		$criteria->compare('prilakukekerasansebelumnya',$this->prilakukekerasansebelumnya,true);
		$criteria->compare('penurunanbb_3bln',$this->penurunanbb_3bln);
		$criteria->compare('asupanberkurang',$this->asupanberkurang);
		$criteria->compare('aktifitas_mobilisasi',$this->aktifitas_mobilisasi,true);
		$criteria->compare('sebutkan_bantuan',$this->sebutkan_bantuan,true);
		$criteria->compare('resikocedera',$this->resikocedera);
		$criteria->compare('isgelangresiko',$this->isgelangresiko);
		$criteria->compare('tandasegitigaterpasang',$this->tandasegitigaterpasang,true);
		$criteria->compare('skriningnyeri',$this->skriningnyeri,true);
		$criteria->compare('skalanyeri',$this->skalanyeri,true);
		$criteria->compare('karakteristiknyeri',$this->karakteristiknyeri,true);
		$criteria->compare('lokasinyeri',$this->lokasinyeri,true);
		$criteria->compare('nyeriterasa',$this->nyeriterasa,true);
		$criteria->compare('nyerihilangbila',$this->nyerihilangbila,true);
		$criteria->compare('hubkeluarga',$this->hubkeluarga);
		$criteria->compare('tempattinggal',$this->tempattinggal,true);
		$criteria->compare('keterangananamesa',$this->keterangananamesa,true);
		$criteria->compare('meanarteripressure',$this->meanarteripressure);
		$criteria->compare('denyutjantung',$this->denyutjantung,true);
		$criteria->compare('inspeksi',$this->inspeksi,true);
		$criteria->compare('palpasi',$this->palpasi,true);
		$criteria->compare('perkusi',$this->perkusi,true);
		$criteria->compare('auskultasi',$this->auskultasi,true);
		$criteria->compare('jn_paten',$this->jn_paten);
		$criteria->compare('jn_obstruktifpartial',$this->jn_obstruktifpartial);
		$criteria->compare('jn_obstruktifnormal',$this->jn_obstruktifnormal);
		$criteria->compare('jn_stridor',$this->jn_stridor);
		$criteria->compare('jn_gargling',$this->jn_gargling);
		$criteria->compare('pgd_simetri',$this->pgd_simetri);
		$criteria->compare('pgd_asimetri',$this->pgd_asimetri);
		$criteria->compare('pgp_normal',$this->pgp_normal);
		$criteria->compare('pgp_kussmaul',$this->pgp_kussmaul);
		$criteria->compare('pgp_takipnea',$this->pgp_takipnea);
		$criteria->compare('pgp_retraktif',$this->pgp_retraktif);
		$criteria->compare('pgp_dangkal',$this->pgp_dangkal);
		$criteria->compare('sirkulasi_nadicarotis',$this->sirkulasi_nadicarotis);
		$criteria->compare('sirkulasi_nadiradialis',$this->sirkulasi_nadiradialis);
		$criteria->compare('cfr_kecil_2',$this->cfr_kecil_2);
		$criteria->compare('cfr_besar_2',$this->cfr_besar_2);
		$criteria->compare('kulit_normal',$this->kulit_normal);
		$criteria->compare('kulit_jaundice',$this->kulit_jaundice);
		$criteria->compare('kulit_cyanosis',$this->kulit_cyanosis);
		$criteria->compare('kulit_pucat',$this->kulit_pucat);
		$criteria->compare('kulit_berkeringat',$this->kulit_berkeringat);
		$criteria->compare('akral',$this->akral,true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('adakelgastrointestinal',$this->adakelgastrointestinal);
		$criteria->compare('gastrointestinal_sebutkan',$this->gastrointestinal_sebutkan,true);
		$criteria->compare('pembatasanmakanan',$this->pembatasanmakanan);
		$criteria->compare('batasmakanan_sebutkan',$this->batasmakanan_sebutkan,true);
		$criteria->compare('gigipalsu',$this->gigipalsu);
		$criteria->compare('gigipalsu_bagian',$this->gigipalsu_bagian,true);
		$criteria->compare('mual',$this->mual);
		$criteria->compare('muntah',$this->muntah);
		$criteria->compare('pendengaran',$this->pendengaran);
		$criteria->compare('pendengaran_sebutkan',$this->pendengaran_sebutkan,true);
		$criteria->compare('penglihatan',$this->penglihatan);
		$criteria->compare('penglihatan_sebutkan',$this->penglihatan_sebutkan,true);
		$criteria->compare('defekasi',$this->defekasi);
		$criteria->compare('defekasi_sebutkan',$this->defekasi_sebutkan,true);
		$criteria->compare('miksi',$this->miksi);
		$criteria->compare('miksi_sebutkan',$this->miksi_sebutkan,true);
		$criteria->compare('hamil',$this->hamil);
		$criteria->compare('hpht',$this->hpht,true);
		$criteria->compare('keluhanmenstruasi',$this->keluhanmenstruasi,true);
		$criteria->compare('skornorton',$this->skornorton);
		$criteria->compare('resikodekubitus',$this->resikodekubitus);
		$criteria->compare('terdapatluka',$this->terdapatluka);
		$criteria->compare('lokasiluka',$this->lokasiluka,true);
		$criteria->compare('hambatanpembelajaran',$this->hambatanpembelajaran);
		$criteria->compare('hambatanpembelajaran_ya',$this->hambatanpembelajaran_ya,true);
		$criteria->compare('butuhpenerjemah',$this->butuhpenerjemah);
		$criteria->compare('kebutuhanpembelajaran',$this->kebutuhanpembelajaran,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('no_pengkajian',$this->no_pengkajian,true);
//		$criteria->addCondition('DATE(pengkajianaskep_tgl) ='. $this->pengkajianaskep_tgl);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('tglanamnesis',$this->tglanamnesis,true);
		$criteria->compare('keluhanutama',$this->keluhanutama,true);
		$criteria->compare('keluhantambahan',$this->keluhantambahan,true);
		$criteria->compare('riwayatpenyakitterdahulu',$this->riwayatpenyakitterdahulu,true);
		$criteria->compare('riwayatpenyakitkeluarga',$this->riwayatpenyakitkeluarga,true);
		$criteria->compare('riwayatimunisasi',$this->riwayatimunisasi,true);
		$criteria->compare('riwayatalergiobat',$this->riwayatalergiobat,true);
		$criteria->compare('riwayatmakanan',$this->riwayatmakanan,true);
		$criteria->compare('tglperiksafisik',$this->tglperiksafisik,true);
		$criteria->compare('keadaanumum',$this->keadaanumum,true);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('suhutubuh',$this->suhutubuh,true);
		$criteria->compare('pernapasan',$this->pernapasan,true);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('kelainanpadabagtubuh',$this->kelainanpadabagtubuh,true);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('jk',$this->jk,true);
		$criteria->compare('riwayatperjalananpasien',$this->riwayatperjalananpasien,true);
		$criteria->compare('pernahdirawat',$this->pernahdirawat);
		$criteria->compare('dirawatdimana',$this->dirawatdimana,true);
		$criteria->compare('lamasakit',$this->lamasakit,true);
		$criteria->compare('riwpenyakitkeldari',$this->riwpenyakitkeldari,true);
		$criteria->compare('penyakitmayor',$this->penyakitmayor,true);
		$criteria->compare('reaksialergiobat',$this->reaksialergiobat,true);
		$criteria->compare('reaksialergimakanan',$this->reaksialergimakanan,true);
		$criteria->compare('riwayatalergilainnya',$this->riwayatalergilainnya,true);
		$criteria->compare('reaksialergilainnya',$this->reaksialergilainnya,true);
		$criteria->compare('pengobatanygsudahdilakukan',$this->pengobatanygsudahdilakukan,true);
		$criteria->compare('riwayatkelahiran',$this->riwayatkelahiran,true);
		$criteria->compare('gelangtandaalergi',$this->gelangtandaalergi,true);
		$criteria->compare('statusmerokok',$this->statusmerokok);
		$criteria->compare('jmlrokok_btg_hr',$this->jmlrokok_btg_hr);
		$criteria->compare('statuspsikologis',$this->statuspsikologis,true);
		$criteria->compare('statusmental',$this->statusmental,true);
		$criteria->compare('masalahsebelumnya',$this->masalahsebelumnya,true);
		$criteria->compare('prilakukekerasansebelumnya',$this->prilakukekerasansebelumnya,true);
		$criteria->compare('penurunanbb_3bln',$this->penurunanbb_3bln);
		$criteria->compare('asupanberkurang',$this->asupanberkurang);
		$criteria->compare('aktifitas_mobilisasi',$this->aktifitas_mobilisasi,true);
		$criteria->compare('sebutkan_bantuan',$this->sebutkan_bantuan,true);
		$criteria->compare('resikocedera',$this->resikocedera);
		$criteria->compare('isgelangresiko',$this->isgelangresiko);
		$criteria->compare('tandasegitigaterpasang',$this->tandasegitigaterpasang,true);
		$criteria->compare('skriningnyeri',$this->skriningnyeri,true);
		$criteria->compare('skalanyeri',$this->skalanyeri,true);
		$criteria->compare('karakteristiknyeri',$this->karakteristiknyeri,true);
		$criteria->compare('lokasinyeri',$this->lokasinyeri,true);
		$criteria->compare('nyeriterasa',$this->nyeriterasa,true);
		$criteria->compare('nyerihilangbila',$this->nyerihilangbila,true);
		$criteria->compare('hubkeluarga',$this->hubkeluarga);
		$criteria->compare('tempattinggal',$this->tempattinggal,true);
		$criteria->compare('keterangananamesa',$this->keterangananamesa,true);
		$criteria->compare('meanarteripressure',$this->meanarteripressure);
		$criteria->compare('denyutjantung',$this->denyutjantung,true);
		$criteria->compare('inspeksi',$this->inspeksi,true);
		$criteria->compare('palpasi',$this->palpasi,true);
		$criteria->compare('perkusi',$this->perkusi,true);
		$criteria->compare('auskultasi',$this->auskultasi,true);
		$criteria->compare('jn_paten',$this->jn_paten);
		$criteria->compare('jn_obstruktifpartial',$this->jn_obstruktifpartial);
		$criteria->compare('jn_obstruktifnormal',$this->jn_obstruktifnormal);
		$criteria->compare('jn_stridor',$this->jn_stridor);
		$criteria->compare('jn_gargling',$this->jn_gargling);
		$criteria->compare('pgd_simetri',$this->pgd_simetri);
		$criteria->compare('pgd_asimetri',$this->pgd_asimetri);
		$criteria->compare('pgp_normal',$this->pgp_normal);
		$criteria->compare('pgp_kussmaul',$this->pgp_kussmaul);
		$criteria->compare('pgp_takipnea',$this->pgp_takipnea);
		$criteria->compare('pgp_retraktif',$this->pgp_retraktif);
		$criteria->compare('pgp_dangkal',$this->pgp_dangkal);
		$criteria->compare('sirkulasi_nadicarotis',$this->sirkulasi_nadicarotis);
		$criteria->compare('sirkulasi_nadiradialis',$this->sirkulasi_nadiradialis);
		$criteria->compare('cfr_kecil_2',$this->cfr_kecil_2);
		$criteria->compare('cfr_besar_2',$this->cfr_besar_2);
		$criteria->compare('kulit_normal',$this->kulit_normal);
		$criteria->compare('kulit_jaundice',$this->kulit_jaundice);
		$criteria->compare('kulit_cyanosis',$this->kulit_cyanosis);
		$criteria->compare('kulit_pucat',$this->kulit_pucat);
		$criteria->compare('kulit_berkeringat',$this->kulit_berkeringat);
		$criteria->compare('akral',$this->akral,true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('adakelgastrointestinal',$this->adakelgastrointestinal);
		$criteria->compare('gastrointestinal_sebutkan',$this->gastrointestinal_sebutkan,true);
		$criteria->compare('pembatasanmakanan',$this->pembatasanmakanan);
		$criteria->compare('batasmakanan_sebutkan',$this->batasmakanan_sebutkan,true);
		$criteria->compare('gigipalsu',$this->gigipalsu);
		$criteria->compare('gigipalsu_bagian',$this->gigipalsu_bagian,true);
		$criteria->compare('mual',$this->mual);
		$criteria->compare('muntah',$this->muntah);
		$criteria->compare('pendengaran',$this->pendengaran);
		$criteria->compare('pendengaran_sebutkan',$this->pendengaran_sebutkan,true);
		$criteria->compare('penglihatan',$this->penglihatan);
		$criteria->compare('penglihatan_sebutkan',$this->penglihatan_sebutkan,true);
		$criteria->compare('defekasi',$this->defekasi);
		$criteria->compare('defekasi_sebutkan',$this->defekasi_sebutkan,true);
		$criteria->compare('miksi',$this->miksi);
		$criteria->compare('miksi_sebutkan',$this->miksi_sebutkan,true);
		$criteria->compare('hamil',$this->hamil);
		$criteria->compare('hpht',$this->hpht,true);
		$criteria->compare('keluhanmenstruasi',$this->keluhanmenstruasi,true);
		$criteria->compare('skornorton',$this->skornorton);
		$criteria->compare('resikodekubitus',$this->resikodekubitus);
		$criteria->compare('terdapatluka',$this->terdapatluka);
		$criteria->compare('lokasiluka',$this->lokasiluka,true);
		$criteria->compare('hambatanpembelajaran',$this->hambatanpembelajaran);
		$criteria->compare('hambatanpembelajaran_ya',$this->hambatanpembelajaran_ya,true);
		$criteria->compare('butuhpenerjemah',$this->butuhpenerjemah);
		$criteria->compare('kebutuhanpembelajaran',$this->kebutuhanpembelajaran,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
       public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('LOWER(no_pengkajian)',strtolower($this->no_pengkajian),true);
		if(!empty($this->pengkajianaskep_tgl)){
			$criteria->addCondition("DATE(pengkajianaskep_tgl) = '" . MyFormatter::formatDateTimeForDb($this->pengkajianaskep_tgl) . "'");
		}
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('tglanamnesis',$this->tglanamnesis,true);
		$criteria->compare('keluhanutama',$this->keluhanutama,true);
		$criteria->compare('keluhantambahan',$this->keluhantambahan,true);
		$criteria->compare('riwayatpenyakitterdahulu',$this->riwayatpenyakitterdahulu,true);
		$criteria->compare('riwayatpenyakitkeluarga',$this->riwayatpenyakitkeluarga,true);
		$criteria->compare('riwayatimunisasi',$this->riwayatimunisasi,true);
		$criteria->compare('riwayatalergiobat',$this->riwayatalergiobat,true);
		$criteria->compare('riwayatmakanan',$this->riwayatmakanan,true);
		$criteria->compare('tglperiksafisik',$this->tglperiksafisik,true);
		$criteria->compare('keadaanumum',$this->keadaanumum,true);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('suhutubuh',$this->suhutubuh,true);
		$criteria->compare('pernapasan',$this->pernapasan,true);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('kelainanpadabagtubuh',$this->kelainanpadabagtubuh,true);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('jk',$this->jk,true);
		$criteria->compare('riwayatperjalananpasien',$this->riwayatperjalananpasien,true);
		$criteria->compare('pernahdirawat',$this->pernahdirawat);
		$criteria->compare('dirawatdimana',$this->dirawatdimana,true);
		$criteria->compare('lamasakit',$this->lamasakit,true);
		$criteria->compare('riwpenyakitkeldari',$this->riwpenyakitkeldari,true);
		$criteria->compare('penyakitmayor',$this->penyakitmayor,true);
		$criteria->compare('reaksialergiobat',$this->reaksialergiobat,true);
		$criteria->compare('reaksialergimakanan',$this->reaksialergimakanan,true);
		$criteria->compare('riwayatalergilainnya',$this->riwayatalergilainnya,true);
		$criteria->compare('reaksialergilainnya',$this->reaksialergilainnya,true);
		$criteria->compare('pengobatanygsudahdilakukan',$this->pengobatanygsudahdilakukan,true);
		$criteria->compare('riwayatkelahiran',$this->riwayatkelahiran,true);
		$criteria->compare('gelangtandaalergi',$this->gelangtandaalergi,true);
		$criteria->compare('statusmerokok',$this->statusmerokok);
		$criteria->compare('jmlrokok_btg_hr',$this->jmlrokok_btg_hr);
		$criteria->compare('statuspsikologis',$this->statuspsikologis,true);
		$criteria->compare('statusmental',$this->statusmental,true);
		$criteria->compare('masalahsebelumnya',$this->masalahsebelumnya,true);
		$criteria->compare('prilakukekerasansebelumnya',$this->prilakukekerasansebelumnya,true);
		$criteria->compare('penurunanbb_3bln',$this->penurunanbb_3bln);
		$criteria->compare('asupanberkurang',$this->asupanberkurang);
		$criteria->compare('aktifitas_mobilisasi',$this->aktifitas_mobilisasi,true);
		$criteria->compare('sebutkan_bantuan',$this->sebutkan_bantuan,true);
		$criteria->compare('resikocedera',$this->resikocedera);
		$criteria->compare('isgelangresiko',$this->isgelangresiko);
		$criteria->compare('tandasegitigaterpasang',$this->tandasegitigaterpasang,true);
		$criteria->compare('skriningnyeri',$this->skriningnyeri,true);
		$criteria->compare('skalanyeri',$this->skalanyeri,true);
		$criteria->compare('karakteristiknyeri',$this->karakteristiknyeri,true);
		$criteria->compare('lokasinyeri',$this->lokasinyeri,true);
		$criteria->compare('nyeriterasa',$this->nyeriterasa,true);
		$criteria->compare('nyerihilangbila',$this->nyerihilangbila,true);
		$criteria->compare('hubkeluarga',$this->hubkeluarga);
		$criteria->compare('tempattinggal',$this->tempattinggal,true);
		$criteria->compare('keterangananamesa',$this->keterangananamesa,true);
		$criteria->compare('meanarteripressure',$this->meanarteripressure);
		$criteria->compare('denyutjantung',$this->denyutjantung,true);
		$criteria->compare('inspeksi',$this->inspeksi,true);
		$criteria->compare('palpasi',$this->palpasi,true);
		$criteria->compare('perkusi',$this->perkusi,true);
		$criteria->compare('auskultasi',$this->auskultasi,true);
		$criteria->compare('jn_paten',$this->jn_paten);
		$criteria->compare('jn_obstruktifpartial',$this->jn_obstruktifpartial);
		$criteria->compare('jn_obstruktifnormal',$this->jn_obstruktifnormal);
		$criteria->compare('jn_stridor',$this->jn_stridor);
		$criteria->compare('jn_gargling',$this->jn_gargling);
		$criteria->compare('pgd_simetri',$this->pgd_simetri);
		$criteria->compare('pgd_asimetri',$this->pgd_asimetri);
		$criteria->compare('pgp_normal',$this->pgp_normal);
		$criteria->compare('pgp_kussmaul',$this->pgp_kussmaul);
		$criteria->compare('pgp_takipnea',$this->pgp_takipnea);
		$criteria->compare('pgp_retraktif',$this->pgp_retraktif);
		$criteria->compare('pgp_dangkal',$this->pgp_dangkal);
		$criteria->compare('sirkulasi_nadicarotis',$this->sirkulasi_nadicarotis);
		$criteria->compare('sirkulasi_nadiradialis',$this->sirkulasi_nadiradialis);
		$criteria->compare('cfr_kecil_2',$this->cfr_kecil_2);
		$criteria->compare('cfr_besar_2',$this->cfr_besar_2);
		$criteria->compare('kulit_normal',$this->kulit_normal);
		$criteria->compare('kulit_jaundice',$this->kulit_jaundice);
		$criteria->compare('kulit_cyanosis',$this->kulit_cyanosis);
		$criteria->compare('kulit_pucat',$this->kulit_pucat);
		$criteria->compare('kulit_berkeringat',$this->kulit_berkeringat);
		$criteria->compare('akral',$this->akral,true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('adakelgastrointestinal',$this->adakelgastrointestinal);
		$criteria->compare('gastrointestinal_sebutkan',$this->gastrointestinal_sebutkan,true);
		$criteria->compare('pembatasanmakanan',$this->pembatasanmakanan);
		$criteria->compare('batasmakanan_sebutkan',$this->batasmakanan_sebutkan,true);
		$criteria->compare('gigipalsu',$this->gigipalsu);
		$criteria->compare('gigipalsu_bagian',$this->gigipalsu_bagian,true);
		$criteria->compare('mual',$this->mual);
		$criteria->compare('muntah',$this->muntah);
		$criteria->compare('pendengaran',$this->pendengaran);
		$criteria->compare('pendengaran_sebutkan',$this->pendengaran_sebutkan,true);
		$criteria->compare('penglihatan',$this->penglihatan);
		$criteria->compare('penglihatan_sebutkan',$this->penglihatan_sebutkan,true);
		$criteria->compare('defekasi',$this->defekasi);
		$criteria->compare('defekasi_sebutkan',$this->defekasi_sebutkan,true);
		$criteria->compare('miksi',$this->miksi);
		$criteria->compare('miksi_sebutkan',$this->miksi_sebutkan,true);
		$criteria->compare('hamil',$this->hamil);
		$criteria->compare('hpht',$this->hpht,true);
		$criteria->compare('keluhanmenstruasi',$this->keluhanmenstruasi,true);
		$criteria->compare('skornorton',$this->skornorton);
		$criteria->compare('resikodekubitus',$this->resikodekubitus);
		$criteria->compare('terdapatluka',$this->terdapatluka);
		$criteria->compare('lokasiluka',$this->lokasiluka,true);
		$criteria->compare('hambatanpembelajaran',$this->hambatanpembelajaran);
		$criteria->compare('hambatanpembelajaran_ya',$this->hambatanpembelajaran_ya,true);
		$criteria->compare('butuhpenerjemah',$this->butuhpenerjemah);
		$criteria->compare('kebutuhanpembelajaran',$this->kebutuhanpembelajaran,true);
		$criteria->limit = 5;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	public function getNoKamar($pendaftaran_id) {
		$no_kamar = '-';
		if (!empty($pendaftaran_id)) {
			$kamar = KamarruanganM::model()->findBySql('
			SELECT kamarruangan_m.kamarruangan_nokamar
			FROM kamarruangan_m
			JOIN masukkamar_t ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (count($kamar)) {
				$no_kamar = $kamar->kamarruangan_nokamar;
			}
		}
		return $no_kamar;
	}

	public function getNoBed($pendaftaran_id) {
		
		$no_bed = '-';
		if (!empty($pendaftaran_id)) {
			$kamar = KamarruanganM::model()->findBySql('
			SELECT kamarruangan_m.kamarruangan_nobed
			FROM kamarruangan_m
			JOIN masukkamar_t ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (count($kamar)) {
				$no_bed = $kamar->kamarruangan_nobed;
			}
		}
		return $pendaftaran_id;
	}

	public function getKelasPelayanan($pendaftaran_id) {

		$pelayanan = '-';
		if (!empty($pendaftaran_id)) {
			$kelas = KelaspelayananM::model()->findBySql('
			SELECT kelaspelayanan_m.kelaspelayanan_nama
			FROM kelaspelayanan_m
			JOIN masukkamar_t ON kelaspelayanan_m.kelaspelayanan_id = masukkamar_t.kelaspelayanan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (count($kelas)) {
				$pelayanan = $kelas->kelaspelayanan_nama;
			}
		}

		return $pelayanan;
	}

	public function getDiagnosaMedis($pasien_id, $pendaftaran_id) {
		$nama = '-';

		if (!empty($pasien_id) && !empty($pendaftaran_id)) {
			$diagnosa = ASDiagnosaM::model()->findBySql('
			SELECT diagnosa_m.diagnosa_nama
			FROM diagnosa_m
			JOIN pasienmorbiditas_t ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
			WHERE pasienmorbiditas_t.pasien_id = ' . $pasien_id . ' AND pendaftaran_id =' . $pendaftaran_id);
			if (count($diagnosa)) {
				$nama = $diagnosa->diagnosa_nama;
			}
		}
		return $nama;
	}

	public function getNamaDokter($pendaftaran_id) {
		$nama = '-';
		$dokter = ASPegawaiM::model()->findBySql('
			SELECT pegawai_m.nama_pegawai,pegawai_m.gelardepan,gelarbelakang_m.gelarbelakang_nama
			FROM pendaftaran_t 
			JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
			LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
			WHERE pendaftaran_id =' . $pendaftaran_id);
		if (count($dokter)) {
			$nama = (isset($dokter->gelardepan) ? $dokter->gelardepan : "") . (isset($dokter->nama_pegawai) ? $dokter->nama_pegawai : "") . (isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
		}
		return $nama;
	}
}