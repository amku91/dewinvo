<?php

class TransactionItems extends AppModel {
    
    public $primaryKey = 'id';
    
    public $belongTo = array('Transactions');
    
    public $belongsTo = array(
        'Transactions' => array(
            'className' => 'Transactions',
            'foreignKey' => 'transaction_id'
        )
    );
    
    
}