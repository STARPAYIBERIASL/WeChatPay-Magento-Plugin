<?php

namespace ClassyLlama\LlamaCoin\Model;

class LlamaCoin extends \Magento\Payment\Model\Method\AbstractMethod
{
    const CODE = 'classyllama_llamacoin';

    protected $_code = self::CODE;
}
