<?php

require_once __DIR__.'/../../../vendor/autoload.php';

use RapidWeb\SiteMapUrlChecker\Objects\UrlChecker;

UrlChecker::checkUrlListFromCsv(__DIR__.'/source.csv','url',__DIR__.'/destination.csv','UrlStatus');
