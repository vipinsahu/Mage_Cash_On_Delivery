<?php
/***************************************
 *** Cash On Delivery ***
 ***************************************
 *
 * @copyright   Copyright (c) 2015
 * @company     NetAttingo Technologies
 * @package     Netgo_Cod
 * @author 		NetGo
 * @dev			netattingomails@gmail.com
 *
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('netgo_cod/cod'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'COD ID'
    )
    ->addColumn(
        'zipcode',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Zip Code'
    )
    ->addColumn(
        'days',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Days'
    )
    ->addColumn(
        'csvfile',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'File'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Enabled'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'COD Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'COD Creation Time'
    ) 
    ->setComment('COD Table');
$this->getConnection()->createTable($table);
$this->endSetup();
