<?php

class RKInfopasienpengunjungV extends InfopasienpengunjungV{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchDialogKunjungan() {
            $provider = $this->search();
            return $provider;
        }
}
