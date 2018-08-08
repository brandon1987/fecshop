<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
return [
    'site' => [
        'class' => 'appbiz\local\local_modules\Site\Module',
        'controllerMap' =>[
            'error'=> 'appbiz\local\local_modules\Site\controllers\ErrorController'
        ]
    ]
];
