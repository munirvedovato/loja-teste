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
 * Vedovatogrid view block
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Block_Vedovatogrid_View extends Mage_Core_Block_Template
{
    /**
     * get the current vedovatogrid
     *
     * @access public
     * @return mixed (Vedovato_VedovatoGrid_Model_Vedovatogrid|null)
     * @author Ultimate Module Creator
     */
    public function getCurrentVedovatogrid()
    {
        return Mage::registry('current_vedovatogrid');
    }
}
