<?php

namespace RapidWeb\SiteMapUrlChecker\Objects;

use RapidWeb\uxdm\Objects\Sources\CSVSource;
use RapidWeb\uxdm\Objects\Sources\XMLSource;
use RapidWeb\uxdm\Objects\Destinations\CSVDestination;
use RapidWeb\uxdm\Objects\Migrator;
use RapidWeb\uxdm\Objects\DataItem;
use GuzzleHttp\Client;

abstract class UrlChecker
{
  private static $sourceFile;
  private static $destinationFile;
 
 private static function checkUrl($url){
    $client = new Client(['exceptions'=> false]);

    $response = $client->get($url);

    $urlStatusText = $response->getReasonPhrase();
    $urlStatusCode = $response->getStatusCode();

    $urlStatus = $urlStatusText."|".$urlStatusCode;
    return $urlStatus; 

  
  
 }
 private static function migrate($sourceField,$destinationField)
 {
    $migrator = new Migrator;

        $migrator->setSource(self::$sourceFile)
                 ->setDestination(self::$destinationFile)
                 ->setFieldsToMigrate([$sourceField])
                 ->setDataRowManipulator(function($dataRow) use ($sourceField,$destinationField){   
                 $url =  $dataRow->getDataItemByFieldName($sourceField);

                   $urlResult = Self::checkUrl($url->value);
                   $dataRow->addDataItem(new DataItem($destinationField,$urlResult, true));

                 })
                 ->migrate();
 }

 public static function checkUrlListFromCsv($sourceFilename,$sourceField,$destinationCsvFileName,$destinationField){
        self::$sourceFile = new CsvSource($sourceFilename);
        self::$destinationFile = new csvDestination($destinationCsvFileName);

       Self::migrate($sourceField,$destinationField);

 }

 public static function checkUrlFromXmlSiteMap($sourceFilename,$destinationCsvFileName,$destinationField)
 {
        self::$sourceFile = new XMLSource($sourceFilename, '/ns:urlset/ns:url');
        self::$sourceFile->addXMLNamespace('ns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        self::$destinationFile = new csvDestination($destinationCsvFileName);

       Self::migrate('loc',$destinationField);

       
 }

}