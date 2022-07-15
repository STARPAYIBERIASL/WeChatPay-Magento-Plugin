<?php

namespace ClassyLlama\LlamaCoin\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Logger
 * @package Barbanet\SampleModule\Console
 */
class Log extends Command
{

    /**
     * @var
     */
    private $logger;

    /**
     * @var
     */
    private $logger_custom;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Barbanet\SampleModule\Logger\Sample $logger_custom
     * @param null $name
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Barbanet\SampleModule\Logger\Sample $logger_custom,
        $name = null
    ) {
        $this->logger = $logger;
        $this->logger_custom = $logger_custom;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('wechatpay:logger');
        $this->setDescription('WechatPay Logger test command');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger->alert('Mensaje Alerta');
        $this->logger->critical('Mensaje Crítico');
        $this->logger->debug('Mensaje Debug');
        $this->logger->emergency('Mensaje Emergencia');
        $this->logger->error('Mensaje Error');
        $this->logger->info('Mensaje Info');
        $this->logger->notice('Mensaje Notice');
        $this->logger->warning('Mensaje Warning');

        $this->logger->log(\Psr\Log\LogLevel::INFO, 'Mensaje Log');

        $this->logger_custom->info('Estoy probando mi logger custom');

    }

}
