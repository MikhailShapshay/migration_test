<?php

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'name' => 'My Console Application',

        'components' => array(
            'db' => array(
                'connectionString' => 'mysql:host=db;dbname=yii1_todo',
                'emulatePrepare' => true,
                'username' => 'yii',
                'password' => 'yii',
                'charset' => 'utf8',
                'enableParamLogging' => true,
                'enableProfiling' => true,
            ),
        ),
    )
);
