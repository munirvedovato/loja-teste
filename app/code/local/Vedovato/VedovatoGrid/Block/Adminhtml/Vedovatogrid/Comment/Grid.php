<?php
/**
 * Vedovato_VedovatoGrid extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Vedovato
 * @package        Vedovato_VedovatoGrid
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Vedovatogrid comments admin grid block
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Block_Adminhtml_Vedovatogrid_Comment_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('vedovatogridCommentGrid');
        $this->setDefaultSort('ct_comment_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Vedovato_VedovatoGrid_Block_Adminhtml_Vedovatogrid_Comment_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('vedovato_vedovatogrid/vedovatogrid_comment_vedovatogrid_collection');
        $collection->addStoreData();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Vedovato_VedovatoGrid_Block_Adminhtml_Vedovatogrid_Comment_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'ct_comment_id',
            array(
                'header'        => Mage::helper('vedovato_vedovatogrid')->__('Id'),
                'index'         => 'ct_comment_id',
                'type'          => 'number',
                'filter_index'  => 'ct.comment_id',
            )
        );
        $this->addColumn(
            'nome',
            array(
                'header'        => Mage::helper('vedovato_vedovatogrid')->__('Nome'),
                'index'         => 'nome',
                'filter_index'  => 'main_table.nome',
            )
        );
        $this->addColumn(
            'ct_title',
            array(
                'header'        => Mage::helper('vedovato_vedovatogrid')->__('Comment Title'),
                'index'         => 'ct_title',
                'filter_index'  => 'ct.title',
            )
        );
        $this->addColumn(
            'ct_name',
            array(
                'header'        => Mage::helper('vedovato_vedovatogrid')->__('Poster name'),
                'index'         => 'ct_name',
                'filter_index'  => 'ct.name',
            )
        );
        $this->addColumn(
            'ct_email',
            array(
                'header'        => Mage::helper('vedovato_vedovatogrid')->__('Poster email'),
                'index'         => 'ct_email',
                'filter_index'  => 'ct.email',
            )
        );
        $this->addColumn(
            'ct_status',
            array(
                'header'        => Mage::helper('vedovato_vedovatogrid')->__('Status'),
                'index'         => 'ct_status',
                'filter_index'  => 'ct.status',
                'type'          => 'options',
                'options'       => array(
                    Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment::STATUS_PENDING  =>
                        Mage::helper('vedovato_vedovatogrid')->__('Pending'),
                    Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment::STATUS_APPROVED =>
                        Mage::helper('vedovato_vedovatogrid')->__('Approved'),
                    Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment::STATUS_REJECTED =>
                        Mage::helper('vedovato_vedovatogrid')->__('Rejected'),
                )
            )
        );
        $this->addColumn(
            'ct_created_at',
            array(
                'header'        => Mage::helper('vedovato_vedovatogrid')->__('Created at'),
                'index'         => 'ct_created_at',
                'width'         => '120px',
                'type'          => 'datetime',
                'filter_index'  => 'ct.created_at',
            )
        );
        $this->addColumn(
            'ct_updated_at',
            array(
                'header'        => Mage::helper('vedovato_vedovatogrid')->__('Updated at'),
                'index'         => 'ct_updated_at',
                'width'         => '120px',
                'type'          => 'datetime',
                'filter_index'  => 'ct.updated_at',
            )
        );
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn(
                'stores',
                array(
                    'header'     => Mage::helper('vedovato_vedovatogrid')->__('Store Views'),
                    'index'      => 'stores',
                    'type'       => 'store',
                    'store_all'  => true,
                    'store_view' => true,
                    'sortable'   => false,
                    'filter_condition_callback' => array($this, '_filterStoreCondition'),
                )
            );
        }
        $this->addColumn(
            'action',
            array(
                'header'  => Mage::helper('vedovato_vedovatogrid')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getCtCommentId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('vedovato_vedovatogrid')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('vedovato_vedovatogrid')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('vedovato_vedovatogrid')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('vedovato_vedovatogrid')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Vedovato_VedovatoGrid_Block_Adminhtml_Vedovatogrid_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('ct_comment_id');
        $this->setMassactionIdFilter('ct.comment_id');
        $this->setMassactionIdFieldOnlyIndexValue(true);
        $this->getMassactionBlock()->setFormFieldName('comment');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('vedovato_vedovatogrid')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('vedovato_vedovatogrid')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label' => Mage::helper('vedovato_vedovatogrid')->__('Change status'),
                'url'   => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                            'name' => 'status',
                            'type' => 'select',
                            'class' => 'required-entry',
                            'label' => Mage::helper('vedovato_vedovatogrid')->__('Status'),
                            'values' => array(
                                Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment::STATUS_PENDING  =>
                                    Mage::helper('vedovato_vedovatogrid')->__('Pending'),
                                Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment::STATUS_APPROVED =>
                                    Mage::helper('vedovato_vedovatogrid')->__('Approved'),
                                Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment::STATUS_REJECTED =>
                                    Mage::helper('vedovato_vedovatogrid')->__('Rejected'),
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
     * @param Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getCtCommentId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * filter store column
     *
     * @access protected
     * @param Vedovato_VedovatoGrid_Model_Resource_Vedovatogrid_Comment_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Vedovato_VedovatoGrid_Block_Adminhtml_Vedovatogrid_Comment_Grid
     * @author Ultimate Module Creator
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->setStoreFilter($value);
        return $this;
    }
}
