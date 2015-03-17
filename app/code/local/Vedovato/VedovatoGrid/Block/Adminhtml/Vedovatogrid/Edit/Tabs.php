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
 * Vedovatogrid admin edit tabs
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Block_Adminhtml_Vedovatogrid_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('vedovatogrid_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrid'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Vedovato_VedovatoGrid_Block_Adminhtml_Vedovatogrid_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_vedovatogrid',
            array(
                'label'   => Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrid'),
                'title'   => Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrid'),
                'content' => $this->getLayout()->createBlock(
                    'vedovato_vedovatogrid/adminhtml_vedovatogrid_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        $this->addTab(
            'form_meta_vedovatogrid',
            array(
                'label'   => Mage::helper('vedovato_vedovatogrid')->__('Meta'),
                'title'   => Mage::helper('vedovato_vedovatogrid')->__('Meta'),
                'content' => $this->getLayout()->createBlock(
                    'vedovato_vedovatogrid/adminhtml_vedovatogrid_edit_tab_meta'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_vedovatogrid',
                array(
                    'label'   => Mage::helper('vedovato_vedovatogrid')->__('Store views'),
                    'title'   => Mage::helper('vedovato_vedovatogrid')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'vedovato_vedovatogrid/adminhtml_vedovatogrid_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve vedovatogrid entity
     *
     * @access public
     * @return Vedovato_VedovatoGrid_Model_Vedovatogrid
     * @author Ultimate Module Creator
     */
    public function getVedovatogrid()
    {
        return Mage::registry('current_vedovatogrid');
    }
}
