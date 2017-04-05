<?php
    class OTA_Contactus_Model_Observer extends Mage_Captcha_Model_Observer
    {
       /* protected function _getCustomerSession()
        {
            return Mage::getSingleton('customer/session');
        }

        protected function _getCaptchaString($request, $formId)
        {
            $captchaParams = $request->getPost(Mage_Captcha_Helper_Data::INPUT_NAME_FIELD_VALUE);
            return $captchaParams[$formId];
        }
        
         public function checkCaptcha($observer) {
            $formId = 'contactus_form'; // Identifier in config.xml      
            //$returnpath = Mage::getSingleton('core/session')->getPromotionId();  
            //Mage::getSingleton('customer/session')->setData('contactus', $observer->getControllerAction()->getRequest()->getPost());
             $this->_getCustomerSession()->setData('contactus', $observer->getControllerAction()->getRequest()->getPost());
            $captchaModel = Mage::helper('captcha')->getCaptcha($formId);
            if ($captchaModel->isRequired()) {
                $controller = $observer->getControllerAction();                
                if (!$captchaModel->isCorrect($this->_getCaptchaString($controller->getRequest(), $formId))) {
                    $this->_getCustomerSession()->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
                    $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                    $controller->getResponse()->setRedirect(Mage::getUrl('*\/*\/index'));
                }
            }
        }*/
    }
