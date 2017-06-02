<?php

require_once __DIR__.'/../../vendor/autoload.php';

use RapidWeb\SiteMapUrlChecker\Objects\UrlChecker;

UrlChecker::checkUrlListFromCsv(__DIR__.'/url-list.csv','url',__DIR__.'/url-list-with-status.csv','url status');
