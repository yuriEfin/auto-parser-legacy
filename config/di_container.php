<?php

use app\component\Parser\AutoRu\Interfaces\AutoParserServiceInterface;
use app\component\Parser\AutoRu\AutoParserService;

Yii::$container->setDefinitions(
    [
        AutoParserServiceInterface::class => AutoParserService::class,
    ]
);