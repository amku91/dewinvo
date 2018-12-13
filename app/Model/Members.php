<?php

class Members extends AppModel {

    public $primaryKey = 'id';
    public $hasOne = array(
        'Transactions' => array(
            'className' => 'Transactions',
            'foreignKey' => 'member_id',
            'dependent' => true
        )
    );

}
