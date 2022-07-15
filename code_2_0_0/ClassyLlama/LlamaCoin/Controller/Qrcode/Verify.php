<?php

namespace ClassyLlama\LlamaCoin\Controller\Qrcode;

class Verify extends \Magento\Framework\App\Action\Action
{
    public function __construct(\Magento\Framework\App\Action\Context $context)
    {
        // $this->helperData = $helperData;
        parent::__construct($context);
    }

    public function execute()
    {
        try{
            $quote_id = $_GET["quote_id"];

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $tableName = $resource->getTableName('sales_order');

            $sql = "SELECT * FROM " . $tableName . " WHERE quote_id = " . $quote_id;
            $result = count($connection->fetchAll($sql));

            if ($result == 0) {
                echo 3;
            }
            else {
                $tableName = $resource->getTableName('quote');
                $sql = "SELECT reserved_order_id FROM " . $tableName . " WHERE entity_id = " . $quote_id;
                $result = $connection->fetchAll($sql);
                if(count($result) == 0){
                    echo 3;
                }
                else{
                    echo $result[0]['reserved_order_id'];
                }
            }
        }
        catch (Exception $e){
        	$idLogExc = generateIdLog();
        	escribirLog($idLogExc." -- Excepcion en la validacion: ".$e->getMessage(),"si");
        	die("Excepcion en la validacion");
        }
    }
}
