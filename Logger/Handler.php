<?php

namespace Hieunv\WineProducer\Logger;

use Monolog\Logger as MonologLogger;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * @var int
     */
    protected $loggerType = MonologLogger::DEBUG;

    /**
     * @var string
     */
    protected $fileName = '/var/log/producer-import.log';
}
