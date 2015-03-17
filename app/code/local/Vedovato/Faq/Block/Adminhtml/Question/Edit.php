<?php
/**
 * Vedovato_Faq extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Vedovato
 * @package        Vedovato_Faq
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Question admin edit form
 *
 * @category    Vedovato
 * @package     Vedovato_Faq
 * @author      Ultimate Module Creator
 */
class Vedovato_Faq_Block_Adminhtml_Question_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'vedovato_faq';
        $this->_controller = 'adminhtml_question';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('vedovato_faq')->__('Save Question')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('vedovato_faq')->__('Delete Question')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('vedovato_faq')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_question') && Mage::registry('current_question')->getId()) {
            return Mage::helper('vedovato_faq')->__(
                "Edit Question '%s'",
                $this->escapeHtml(Mage::registry('current_question')->getPergunta())
            );
        } else {
            return Mage::helper('vedovato_faq')->__('Add Question');
        }
    }
}
