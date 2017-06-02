<?php

require_once __DIR__.'/../../../vendor/autoload.php';

use RapidWeb\uxdm\Objects\Sources\CSVSource;
use RapidWeb\uxdm\Objects\Destinations\CSVDestination;
use RapidWeb\uxdm\Objects\Migrator;

$csvSource = new CSVSource(__DIR__.'/source.csv');
$csvDestination = new CSVDestination(__DIR__.'/destination.csv');

$migrator = new Migrator;
$migrator->setSource($csvSource)
         ->setDestination($csvDestination)
         ->setFieldsToMigrate(['Author'])
         ->setFieldMap(['Author' => 'Writer'])
         ->migrate();