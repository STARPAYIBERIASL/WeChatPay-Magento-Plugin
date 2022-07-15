<?php

namespace ClassyLlama\LlamaCoin\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Log extends Base
{

    /**
     * @var string
     */
    protected $fileName = '/var/log/wechatpay.log';

    /**
     * @var
     */
    protected $loggerType = Logger::DEBUG;

}
