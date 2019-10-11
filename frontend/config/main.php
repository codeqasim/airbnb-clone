<?php
use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
		    [
			    'class' => 'app\components\LanguageSelector',
			    'supportedLanguages' => ['en_US', 'ru_RU','zh-CN' => 'Chinese'],
		    ],
    ],
   'language' => ['en-US', 'en', 'fr', 'de','zh', 'es-*'],
   /**** Yandex translator ****/
    //'bootstrap' => ['translate'],
   /**** Yandex translator ****/
    'controllerNamespace' => 'frontend\controllers',    
    'modules' => [
				'user'=>[
						'class' => 'frontend\modules\user\user',

				],  
    ],
    'on beforeRequest' => function ($event) {
    \Yii::$app->language = Yii::$app->session->get('language');
    },	
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],    
    	'request' => [
    			'baseUrl' => $baseUrl,
    	], 
	 'assetManager' => [
        'bundles' => [
            'yii\bootstrap\BootstrapPluginAsset' => [
                'js'=>[]
            ],
            'yii\web\JqueryAsset' => [
                'js'=>[]
            ],            
        ],
        ],
    	'mycomponent' => [
    			'class' => 'frontend\components\MyComponent',
    	],    		
    	'myclass' => [
    	'class' => 'frontend\components\MyClass',
    	],    	
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
        		'identityCookie' => [
        				'name' => '_frontendUser', // unique for frontend
        				'path'=>'/frontend/web'
        		]        		
        ],
    	'session' => [
    			'name' => 'PHPFRONTSESSID',
    			'savePath' => sys_get_temp_dir(),
    	],    		
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'categories' => ['mycat'],
                    'logVars' => [],
                    'logFile' => '@app/runtime/logs/mycat.log'
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    		'authClientCollection' => [
    				'class' => 'yii\authclient\Collection',
    				'clients' => [
    						'facebook' => [
								'class' => 'yii\authclient\clients\Facebook',
								'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                                'attributeNames' => ['name', 'email', 'first_name', 'last_name','picture'],
    						], 
				            /*'google' => [
				                  'class' => 'yii\authclient\clients\GoogleOAuth',
				             ],*/   						
    				],
    		],
    	'urlManager' => [
    			'baseUrl' => $baseUrl,
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => true,
    		'rules' => [
    				
    				'/' => 'users/index',
                    '<action:(profile)>/<details>'=>'users/profile',
                    '<action:(social)>/<details>'=>'users/social', 
    				'<action:(paysettings)>/<details>'=>'users/paysettings',
                    '<action:(addreport)>/<details>'=>'users/addreport',
    				'<action:(verify)>/<details>'=>'users/<action>',
    				'search/<place>' => 'user/listing/search',
                    'search/<place>/<countryid>' => 'user/listing/search',
				    '<controller:\w+>/<id:\d+>' => '<controller>/view',
				    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				   	'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				   	'<controller:(api)>/<action:\w+>'=>'<controller>/<action>',
    				
    				
    				'signup'=>'users/signup',
    				'register'=>'users/register', 
    				'signin'=>'users/signin',
    				'login'=>'users/login',
    				'dashboard'=>'users/dashboard',
    				'logout'=>'users/logout',
    				'auth'=>'users/auth',
    				'validatedata' => 'users/validatedata',
    				'loginvalidate' => 'users/loginvalidate',
    				'forgotpassword' => 'users/forgotpassword',
    				'resetpassword' => 'users/resetpassword',
    				'<action:(resetpassword)>'=>'users/<action>',
    				'validateforgot' => 'users/validateforgot',
    				'create' => 'users/create',
                    'editprofile' => 'users/editprofile',
    				'saveprofile' => 'users/saveprofile',
                    'trust' => 'users/trust',
                   // 'paysettings' => 'users/paysettings',
                    'payupdate' => 'users/payupdate',
                    'currencyupdate' => 'users/currencyupdate', 
					'paysave' => 'users/paysave',
					'sendtrustmail' => 'users/sendtrustmail',
    				'changepassword' => 'users/changepassword',
    				'invitefriends' => 'users/invitefriends',
                    'sendmail' => 'users/sendmail',
    				'mobileverificationstatus' => 'users/mobileverificationstatus',
    				'<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
    				'<module:\w+><controller:\w+>/<action:update|delete>/<id:\d+>' => '<module>/<controller>/<action>',
    				'<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                    '/user/listing/view/<details>' => '/user/listing/view',
                    '/user/listing/viewdetail/<details>' => '/user/listing/viewdetail',
    				'/user/listing/vieworder/<details>' => '/user/listing/vieworder', 
                    '/user/listing/view/<details>/<userrole>' => '/user/listing/view',
    				'/user/listing/resized/<id1:\d+>/<id2:\d+>/<details>' => '/user/listing/resized',
    				'/user/listing/claim/<details>' => '/user/listing/claim',
    				'/user/listing/wishlist/<details>' => '/user/listing/wishlist',
    				'/user/listing/editwishlist/<details>' => '/user/listing/editwishlist',
                    '/user/messages/viewmessage/<details>' => '/user/messages/viewmessage',
    				'/user/messages/inbox/<details>' => '/user/messages/inbox',
    				'/user/messages/adminviewmessage/<details>' => '/user/messages/adminviewmessage',
                    '/user/help/view/<id>' => '/user/help/view',
    				'language' => 'users/language',
                    ['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],
    				
    				
    			]
    	],    		
    ],
	
    'params' => $params,
];
