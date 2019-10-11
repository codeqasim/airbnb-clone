<?php
use \yii\web\Request;


$baseUrl = str_replace('/backend/web', '', (new Request)->getBaseUrl()).'/admin';
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
    	'log',
    	[
    	'class' => 'backend\components\LanguageSelector',
    	],    	
    ],
    'modules' => [
				'admin'=>[
						'class' => 'backend\modules\admin\admin',

				],  
    ],
    'on beforeRequest' => function ($event) {
    \Yii::$app->language = Yii::$app->session->get('language');
    },
    'defaultRoute' => 'admins',
    'components' => [
    	'request' => [
    			'baseUrl' => $baseUrl,
    	],    
    	'i18n' => [
	    	'translations' => [
		    	'app*' => [
		    	'class' => 'yii\i18n\PhpMessageSource',
			    	//'basePath' => '@app/messages',
			    	//'sourceLanguage' => 'en-US',
			    	'fileMap' => [
			    	'app' => 'app.php',
			    	'app/error' => 'error.php',
			    	],
			    	//'on missingTranslation' => ['backend\components\TranslationEventHandler', 'handleMissingTranslation']
		    	],
	    	],
    	],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
           'identityCookie' => [
                'name' => '_backendUser', // unique for backend
                'path'=>'/backend/web'
            ]            
        ],
        'session' => [
            'name' => 'PHPBACKSESSID',
            'savePath' => sys_get_temp_dir(),
        ],        
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'admins/dashboard',  
        ],
    	'urlManager' => [
            'baseUrl' => $baseUrl,
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
            'rules' => [
                '/' => 'admins/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',       
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+><controller:\w+>/<action:update|delete>/<id:\d+>' => '<module>/<controller>/<action>',
                'login' => 'admins/login',
                'profile' => 'admins/profile',
                'loginvalidate' => 'admins/loginvalidate',
                'Autoupdatecurrency' => 'admins/autoupdatecurrency',
                'updatecurrencyprice' => 'admins/updatecurrencyprice',
                'getcurrencyvalue' => 'admins/getcurrencyvalue',
                
                
                'dashboard' => 'admins/dashboard',
                'logout' => 'admins/logout',
                'usermanagement' => 'admins/usermanagement',
                'userrolemanagement' => 'admins/userrolemanagement',
                'rolesmanagement' => 'admins/rolesmanagement',
                'reviewsmanagement' => 'admins/reviewsmanagement',

                'moderator' => 'admins/moderator',
                'blockedusermanagement' => 'admins/blockedusermanagement',
                'hostmanagement' => 'admins/hostmanagement',
                'blockedhostmanagement' => 'admins/blockedhostmanagement',
                'changeuserstatus' => 'admins/changeuserstatus',
                'changehoststatus' => 'admins/changehoststatus',
                'changeliststatus' => 'admins/changeliststatus',

                'getuserdetails' => 'admins/getuserdetails',
                'sendmessage' => 'admins/sendmessage',
                'sitemanagement' => 'admins/sitemanagement',
                'seomanagement' => 'admins/seomanagement',
                'emailmanagement' => 'admins/emailmanagement',
                'startfileupload' => 'admins/startfileupload',
                'startcountryfileupload' => 'admins/startcountryfileupload',
                'startadditionalfileupload' => 'admins/startadditionalfileupload',
                'startcommonfileupload' => 'admins/startcommonfileupload',
                'startspecialfileupload' => 'admins/startspecialfileupload',
                'homepagesettings' => 'admins/homepagesettings',
                'termsandconditions' => 'admins/termsandconditions',
                'listingproperties' => 'admins/listingproperties',
                'additionalamenities' => 'admins/additionalamenities',
                'cancellationpolicy' => 'admins/cancellationpolicy',
                'addadditionalamenity' => 'admins/addadditionalamenity',
                'commonamenities' => 'admins/commonamenities',
                'addcommonamenity' => 'admins/addcommonamenity',
                'safetycheck' => 'admins/safetycheck',
                'addsafetycheck' => 'admins/addsafetycheck',
                'specialfeatures' => 'admins/specialfeatures',
                'addspecialfeature' => 'admins/addspecialfeature',
                'emailmanage' => 'admins/emailmanage',
                'googlecodesettings' => 'admins/googlecodesettings',
                'language' => 'admins/language',
                'socialloginsettings' => 'admins/socialloginsettings',
                'mobilesmssettings' => 'admins/mobilesmssettings',
                '/admin/orders/vieworder/<id:\d+>'     => '/admin/orders/vieworder',
                '/admin/security/viewconversation/<id:\d+>' => '/admin/security/viewconversation',
                '/admin/security/viewclaimconversation/<id:\d+>' => '/admin/security/viewclaimconversation',
                '/admin/listing/<id:\d+>'     => '/admin/listing/index',
                '/admin/listing/blockedlisting/<id:\d+>'    => '/admin/listing/blockedindex',     
                'footersettings' => 'admins/footersettings',
                'paypalsettings' => 'admins/paypalsettings',
                'stripesettings' => 'admins/stripesettings',
                'addbuttonslider' => 'admins/addbuttonslider',
                'activelisting' => 'admins/activelisting',
                'blockedlisting' => 'admins/blockedlisting', 
                'alterliststatus' => 'admins/alterliststatus', 
                'alterfeaturelist' => 'admins/alterfeaturelist', 
            ],    
    	],
       
    ],
    'params' => $params,
];
