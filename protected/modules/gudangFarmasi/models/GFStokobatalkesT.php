<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class GFStokobatalkesT extends StokobatalkesT {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanstokprodukposV the static model class
	 */
                public $tgl_awal, $tgl_akhir;
                public $tick;
                public $data;
                public $jumlah;
                public $qty;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanstokprodukpos_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, subcategory_id, satuanbesar_id, satuankecil_id, jmldalamkemasan, minimalstok', 'numerical', 'integerOnly'=>true),
			array('hargajual, discount, ppn_persen, qtystok_in, qtystok_out, qtystok_current', 'numerical'),
			array('category_name, stock_code, satuanbesar_nama, satuankecil_nama', 'length', 'max'=>50),
			array('subcategory_code', 'length', 'max'=>10),
			array('subcategory_name', 'length', 'max'=>100),
			array('stock_name, barang_barcode', 'length', 'max'=>200),
			array('ruangan_id, tglstok_in', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('category_id, category_name, tgl_awal, tgl_akhir, subcategory_id, subcategory_code, subcategory_name, stock_code, satuanbesar_id, satuanbesar_nama, satuankecil_id, satuankecil_nama, stock_name, jmldalamkemasan, hargajual, discount, minimalstok, barang_barcode, ppn_persen, qtystok_in, qtystok_out, qtystok_current, ruangan_id, tglstok_in', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => 'Jenis Obat Alkes',
			'category_name' => 'Category Name',
                                                'subcategory_id' => 'Sub Category',
			'subcategory_code' => 'Sub Category Code',
			'subcategory_name' => 'Sub Category Name',
			'stock_code' => 'Kode Obat Alkes',
			'satuanbesar_id' => 'Satuan Besar',
			'satuanbesar_nama' => 'Nama Satuan Besar',
			'satuankecil_id' => 'Satuan Kecil',
			'satuankecil_nama' => 'Nama Satuan Kecil',
			'stock_name' => 'Nama Obat Alkes',
			'jmldalamkemasan' => 'Jml Dalam Kemasan',
			'hargajual' => 'Harga Jual',
			'discount' => 'Discount',
			'minimalstok' => 'Minimal Stock',
			'barang_barcode' => 'Barang Barcode',
			'ppn_persen' => 'Ppn Persen',
			'qtystok_in' => 'QTY Stock In',
			'qtystok_out' => 'QTY Stock Out',
			'qtystok_current' => 'QTY Stock Current',
			'ruangan_id' => 'Ruangan',
			'tglstok_in' => 'Tgl. Stock In',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteria(),
                                                'pagination'=>array(
                                                    'pageSize'=>10,
                                                )
		));
	}
        
        public function searchPrint()
        {
                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteria(),
                        'pagination'=>false,
                ));
        }
        
        
         public function getCategoryItems()
        {
            return JenisobatalkesM::model()->findAll('jenisobatalkes_aktif=TRUE AND jenisobatalkes_farmasi=TRUE ORDER BY jenisobatalkes_nama');
        }
        
        public function getSubCategoryItems()
        {
            return SubjenisM::model()->findAll();
        }
		public function Criteria()
		{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

			$criteria=new CDbCriteria;

			$criteria->select = 'stock_code, hargajual, stock_name, SUM(qtystok_current) AS qty, tglstok_in';
			$criteria->group = 'stock_code, hargajual, stock_name,tglstok_in';
			if(!empty($this->category_id)){
				$criteria->addCondition('category_id = '.$this->category_id);
			}
			$criteria->addCondition('ruangan_id = '.Yii::app()->user->ruangan_id);
			$criteria->addBetweenCondition('tglstok_in',$this->tgl_awal, $this->tgl_akhir);

			return $criteria;
		}
                
         public function getQtystock_in()
         {
             $criteria=$this->criteria();
             $criteria->select = 'SUM(qtystok_in)';
             return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
         }
                
         public function getTotalqtystok_in()
        {
            $criteria=$this->Criteria();
            $criteria->select = 'SUM(qtystok_in)';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function getTotalhargajual()
        {
            $criteria=$this->criteria();
            $criteria->select = 'SUM(hargajual)';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function getTotalharga()
        {
            $criteria=$this->criteria();
            $criteria->select = '(SUM(hargajual) * SUM(qtystok_in)) AS totalharga';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function searchGrafik()
        {
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->select = 'count(stock_code) as jumlah, stock_name as data';
			$criteria->group = 'stock_name';
			$criteria->addBetweenCondition('tglstok_in', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->category_id)){
				$criteria->addCondition('category_id = '.$this->category_id);
			}
			$criteria->compare('LOWER(category_name)',strtolower($this->category_name),true);
			if(!empty($this->subcategory_id)){
				$criteria->addCondition('subcategory_id = '.$this->subcategory_id);
			}
			$criteria->compare('LOWER(subcategory_code)',strtolower($this->subcategory_code),true);
			$criteria->compare('LOWER(subcategory_name)',strtolower($this->subcategory_name),true);
			$criteria->compare('LOWER(stock_code)',strtolower($this->stock_code),true);
			if(!empty($this->satuanbesar_id)){
				$criteria->addCondition('satuanbesar_id = '.$this->satuanbesar_id);
			}
			$criteria->compare('LOWER(satuanbesar_nama)',strtolower($this->satuanbesar_nama),true);
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
			}
			$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
			$criteria->compare('LOWER(stock_name)',strtolower($this->stock_name),true);
			$criteria->compare('jmldalamkemasan',$this->jmldalamkemasan);
			$criteria->compare('hargajual',$this->hargajual);
			$criteria->compare('discount',$this->discount);
			$criteria->compare('minimalstok',$this->minimalstok);
			$criteria->compare('LOWER(barang_barcode)',strtolower($this->barang_barcode),true);
			$criteria->compare('ppn_persen',$this->ppn_persen);
			$criteria->compare('qtystok_in',$this->qtystok_in);
			$criteria->compare('qtystok_out',$this->qtystok_out);
			$criteria->compare('qtystok_current',$this->qtystok_current);
			$criteria->compare('LOWER(ruangan_id)',strtolower($this->ruangan_id),true);
			$criteria->compare('LOWER(tglstok_in)',strtolower($this->tglstok_in),true);
			$criteria->addBetweenCondition('tglstok_in',$this->tgl_awal, $this->tgl_akhir);
			// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		   // $criteria->limit=-1; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
			));
        }

}

?>
