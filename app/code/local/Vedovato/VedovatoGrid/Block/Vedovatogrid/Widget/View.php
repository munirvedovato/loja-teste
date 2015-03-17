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
 * Vedovatogrid widget block
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Block_Vedovatogrid_Widget_View extends Mage_Core_Block_Template implements
    Mage_Widget_Block_Interface
{
    protected $_htmlTemplate = 'vedovato_vedovatogrid/vedovatogrid/widget/view.phtml';

    /**
     * Prepare a for widget
     *
     * @access protected
     * @return Vedovato_VedovatoGrid_Block_Vedovatogrid_Widget_View
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $vedovatogridId = $this->getData('vedovatogrid_id');
        if ($vedovatogridId) {
            $vedovatogrid = Mage::getModel('vedovato_vedovatogrid/vedovatogrid')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($vedovatogridId);
            if ($vedovatogrid->getStatus()) {
                $this->setCurrentVedovatogrid($vedovatogrid);
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }
}
