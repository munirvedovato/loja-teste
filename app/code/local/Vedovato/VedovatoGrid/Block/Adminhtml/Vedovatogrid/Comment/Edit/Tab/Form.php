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
 * Vedovatogrid comment edit form tab
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Block_Adminhtml_Vedovatogrid_Comment_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return VedovatoGrid_Vedovatogrid_Block_Adminhtml_Vedovatogrid_Comment_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $vedovatogrid = Mage::registry('current_vedovatogrid');
        $comment    = Mage::registry('current_comment');
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('comment_');
        $form->setFieldNameSuffix('comment');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'comment_form',
            array('legend'=>Mage::helper('vedovato_vedovatogrid')->__('Comment'))
        );
        $fieldset->addField(
            'vedovatogrid_id',
            'hidden',
            array(
                'name'  => 'vedovatogrid_id',
                'after_element_html' => '<a href="'.
                    Mage::helper('adminhtml')->getUrl(
                        'adminhtml/vedovatogrid_vedovatogrid/edit',
                        array(
                            'id'=>$vedovatogrid->getId()
                        )
                    ).
                    '" target="_blank">'.
                    Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrid').
                    ' : '.$vedovatogrid->getNome().'</a>'
            )
        );
        $fieldset->addField(
            'title',
            'text',
            array(
                'label'    => Mage::helper('vedovato_vedovatogrid')->__('Title'),
                'name'     => 'title',
                'required' => true,
                'class'    => 'required-entry',
            )
        );
        $fieldset->addField(
            'comment',
            'textarea',
            array(
                'label'    => Mage::helper('vedovato_vedovatogrid')->__('Comment'),
                'name'     => 'comment',
                'required' => true,
                'class'    => 'required-entry',
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'    => Mage::helper('vedovato_vedovatogrid')->__('Status'),
                'name'     => 'status',
                'required' => true,
                'class'    => 'required-entry',
                'values'   => array(
                    array(
                        'value' => Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment::STATUS_PENDING,
                        'label' => Mage::helper('vedovato_vedovatogrid')->__('Pending'),
                    ),
                    array(
                        'value' => Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment::STATUS_APPROVED,
                        'label' => Mage::helper('vedovato_vedovatogrid')->__('Approved'),
                    ),
                    array(
                        'value' => Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment::STATUS_REJECTED,
                        'label' => Mage::helper('vedovato_vedovatogrid')->__('Rejected'),
                    ),
                ),
            )
        );
        $configuration = array(
             'label' => Mage::helper('vedovato_vedovatogrid')->__('Poster name'),
             'name'  => 'name',
             'required'  => true,
             'class' => 'required-entry',
        );
        if ($comment->getCustomerId()) {
            $configuration['after_element_html'] = '<a href="'.
                Mage::helper('adminhtml')->getUrl(
                    'adminhtml/customer/edit',
                    array(
                        'id'=>$comment->getCustomerId()
                    )
                ).
                '" target="_blank">'.
                Mage::helper('vedovato_vedovatogrid')->__('Customer profile').'</a>';
        }
        $fieldset->addField('name', 'text', $configuration);
        $fieldset->addField(
            'email',
            'text',
            array(
                'label' => Mage::helper('vedovato_vedovatogrid')->__('Poster e-mail'),
                'name'  => 'email',
                'required'  => true,
                'class' => 'required-entry',
            )
        );
        $fieldset->addField(
            'customer_id',
            'hidden',
            array(
                'name'  => 'customer_id',
            )
        );
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_comment')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $form->addValues($this->getComment()->getData());
        return parent::_prepareForm();
    }

    /**
     * get the current comment
     *
     * @access public
     * @return Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment
     */
    public function getComment()
    {
        return Mage::registry('current_comment');
    }
}
