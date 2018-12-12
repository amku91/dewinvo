<?php

class Transactions extends AppModel {
    
    public $primaryKey = 'id';
    
    public $belongTo = array('Members');
    
    public $hasOne = array(
        'TransactionItems' => array(
            'className' => 'TransactionItems',
            'foreignKey' => 'transaction_id',
            'dependent' => true
        )
    );
}