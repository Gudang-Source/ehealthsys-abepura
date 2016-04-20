<?php

/**
 * This is the model class for table "tariftindakanruangandetail_v".
 *
 * The followings are the available columns in table 'tariftindakanruangandetail_v':
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_namalainnya
 * @property string $daftartindakan_katakunci
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property string $noperda
 * @property string $tglperda
 * @property string $perdatentang
 * @property string $ditetapkanoleh
 * @property string $tempatditetapkan
 * @property integer $jenistarif_id
 * @property string $jenistarif_nama
 * @property integer $tariftindakan_id
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property double $harga_tariftindakan
 * @property integer $persendiskon_tind
 * @property double $hargadiskon_tind
 * @property integer $persencyto_tind
 * @property integer $jeniskelas_id
 * @property string $jeniskelas_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $kelaspelayanan_namalainnya
 * @property integer $daftartindakan_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 */
class SATariftindakanruangandetailV extends TariftindakanruangandetailV {

    public $daftartindakan, $kelompoktindakan, $kategoritindakan, $ruangan, $ruangan_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TariftindakanruangandetailV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;

        if (!empty($this->kategoritindakan_id)) {
            $criteria->addCondition('kategoritindakan_id = ' . $this->kategoritindakan_id);
        }
        $criteria->compare('LOWER(kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
        if (!empty($this->kelompoktindakan_id)) {
            $criteria->addCondition('kelompoktindakan_id = ' . $this->kelompoktindakan_id);
        }
        $criteria->compare('LOWER(kelompoktindakan_nama)', strtolower($this->kelompoktindakan_nama), true);
        $criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
        $criteria->compare('LOWER(daftartindakan_namalainnya)', strtolower($this->daftartindakan_namalainnya), true);
        $criteria->compare('LOWER(daftartindakan_katakunci)', strtolower($this->daftartindakan_katakunci), true);
        if (!empty($this->perdatarif_id)) {
            $criteria->addCondition('perdatarif_id = ' . $this->perdatarif_id);
        }
        $criteria->compare('LOWER(perdanama_sk)', strtolower($this->perdanama_sk), true);
        $criteria->compare('LOWER(noperda)', strtolower($this->noperda), true);
        $criteria->compare('LOWER(tglperda)', strtolower($this->tglperda), true);
        $criteria->compare('LOWER(perdatentang)', strtolower($this->perdatentang), true);
        $criteria->compare('LOWER(ditetapkanoleh)', strtolower($this->ditetapkanoleh), true);
        $criteria->compare('LOWER(tempatditetapkan)', strtolower($this->tempatditetapkan), true);
        if (!empty($this->jenistarif_id)) {
            $criteria->addCondition('jenistarif_id = ' . $this->jenistarif_id);
        }
        $criteria->compare('LOWER(jenistarif_nama)', strtolower($this->jenistarif_nama), true);
        if (!empty($this->tariftindakan_id)) {
            $criteria->addCondition('tariftindakan_id = ' . $this->tariftindakan_id);
        }
        if (!empty($this->komponentarif_id)) {
            $criteria->addCondition('komponentarif_id = ' . $this->komponentarif_id);
        }
        $criteria->compare('LOWER(komponentarif_nama)', strtolower($this->komponentarif_nama), true);
        $criteria->compare('harga_tariftindakan', $this->harga_tariftindakan);
        if (!empty($this->persendiskon_tind)) {
            $criteria->addCondition('persendiskon_tind = ' . $this->persendiskon_tind);
        }
        $criteria->compare('hargadiskon_tind', $this->hargadiskon_tind);
        if (!empty($this->persencyto_tind)) {
            $criteria->addCondition('persencyto_tind = ' . $this->persencyto_tind);
        }
        if (!empty($this->jeniskelas_id)) {
            $criteria->addCondition('jeniskelas_id = ' . $this->jeniskelas_id);
        }
        $criteria->compare('LOWER(jeniskelas_nama)', strtolower($this->jeniskelas_nama), true);
        if (!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition('kelaspelayanan_id = ' . $this->kelaspelayanan_id);
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('LOWER(kelaspelayanan_namalainnya)', strtolower($this->kelaspelayanan_namalainnya), true);
        if (!empty($this->daftartindakan_id)) {
            $criteria->addCondition('daftartindakan_id = ' . $this->daftartindakan_id);
        }
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = $this->criteriaSearch();
        $criteria->group = "daftartindakan_id, daftartindakan_nama, ruangan_id, komponentarif_id, ruangan_nama, "
                . "komponentarif_nama, kelompoktindakan_nama, kategoritindakan_nama, daftartindakan_kode, "
                . "daftartindakan_nama";
        $criteria->select = $criteria->group;
        //$criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
