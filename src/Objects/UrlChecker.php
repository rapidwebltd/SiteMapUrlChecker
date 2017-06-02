<?php

namespace RapidWeb\SiteMapUrlChecker\Objects;

use RapidWeb\uxdm\Objects\Sources\CSVSource;
use RapidWeb\uxdm\Objects\Destinations\CSVDestination;
use RapidWeb\uxdm\Objects\Migrator;
use RapidWeb\uxdm\Objects\DataItem;
use GuzzleHttp\Client;

abstract class UrlChecker
{
 
 function checkUrl($url){
    $client = new Client(['exceptions'=> false]);

    $response = $client->get($url);

    $urlStatus = $response->getStatusCode();

    return $urlStatus; 

  
  
 }

 function checkUrlListFromCsv($sourceFilename,$sourceField,$destinationCsvFileName,$destinationField){
        $sourceCsv = new CsvSource($sourceFilename);
        $destinationCsv = new csvDestination($destinationCsvFileName);

        $migrator = new Migrator;

        $migrator->setSource($sourceCsv)
                 ->setDestination($destinationCsv)
                 ->setFieldsToMigrate([$sourceField])
                 ->setFieldMap([$sourceField,$destinationField])
                 ->setDataRowManipulator(function($dataRow) use ($sourceField,$destinationField){   
                 $url =  $dataRow->getDataItemByFieldName($sourceField);

                   $urlResult = Self::checkUrl($url->value);
                   $dataRow->addDataItem(new DataItem($destinationField,$urlResult, true));

                 })
                 ->migrate();

 }

}