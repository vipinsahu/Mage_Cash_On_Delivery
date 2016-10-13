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
class Netgo_Cod_Block_Adminhtml_Cod_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author NetGo
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('codGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Netgo_Cod_Block_Adminhtml_Cod_Grid
     * @author NetGo
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('netgo_cod/cod')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Netgo_Cod_Block_Adminhtml_Cod_Grid
     * @author NetGo
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('netgo_cod')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'zipcode',
            array(
                'header'    => Mage::helper('netgo_cod')->__('Zip Code'),
                'align'     => 'left',
                'index'     => 'zipcode',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('netgo_cod')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('netgo_cod')->__('Enabled'),
                    '0' => Mage::helper('netgo_cod')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'days',
            array(
                'header' => Mage::helper('netgo_cod')->__('Days'),
                'index'  => 'days',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('netgo_cod')->__('Created at'),
                'index'  => 'created_at',
                'width'  => '120px',
                'type'   => 'datetime',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('netgo_cod')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('netgo_cod')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('netgo_cod')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('netgo_cod')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('netgo_cod')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Netgo_Cod_Block_Adminhtml_Cod_Grid
     * @author NetGo
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('cod');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('netgo_cod')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('netgo_cod')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('netgo_cod')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('netgo_cod')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('netgo_cod')->__('Enabled'),
                            '0' => Mage::helper('netgo_cod')->__('Disabled'),
                        )
                    )
                )
            )
        );
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param Netgo_Cod_Model_Cod
     * @return string
     * @author NetGo
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author NetGo
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return Netgo_Cod_Block_Adminhtml_Cod_Grid
     * @author NetGo
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
