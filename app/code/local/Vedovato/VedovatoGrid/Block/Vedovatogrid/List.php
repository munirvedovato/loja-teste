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
 * Vedovatogrid list block
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Block_Vedovatogrid_List extends Mage_Core_Block_Template
{
    /**
     * initialize
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $vedovatogrids = Mage::getResourceModel('vedovato_vedovatogrid/vedovatogrid_collection')
                         ->addStoreFilter(Mage::app()->getStore())
                         ->addFieldToFilter('status', 1);
        $vedovatogrids->setOrder('nome', 'asc');
        $this->setVedovatogrids($vedovatogrids);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return Vedovato_VedovatoGrid_Block_Vedovatogrid_List
     * @author Ultimate Module Creator
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'vedovato_vedovatogrid.vedovatogrid.html.pager'
        )
        ->setCollection($this->getVedovatogrids());
        $this->setChild('pager', $pager);
        $this->getVedovatogrids()->load();
        return $this;
    }

    /**
     * get the pager html
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
