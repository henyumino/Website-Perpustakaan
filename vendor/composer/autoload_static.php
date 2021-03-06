<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0f6964990c779b2889b1e2c96077c877
{
    public static $classMap = array (
        'Flare\\Components\\Database\\QueryBuilder' => __DIR__ . '/..' . '/Flare/Components/Database/QueryBuilder.php',
        'Flare\\Components\\Encode' => __DIR__ . '/..' . '/Flare/Components/Encode.php',
        'Flare\\Components\\Environment' => __DIR__ . '/..' . '/Flare/Components/Environment.php',
        'Flare\\Components\\Loader' => __DIR__ . '/..' . '/Flare/Components/Loader.php',
        'Flare\\Components\\Mail' => __DIR__ . '/..' . '/Flare/Components/Mail.php',
        'Flare\\Components\\Validation' => __DIR__ . '/..' . '/Flare/Components/Validation.php',
        'Flare\\Network\\Http\\Ajax' => __DIR__ . '/..' . '/Flare/Network/Http/Ajax.php',
        'Flare\\Network\\Http\\Controller' => __DIR__ . '/..' . '/Flare/Network/Http/Controller.php',
        'Flare\\Network\\Http\\Cookie' => __DIR__ . '/..' . '/Flare/Network/Http/Cookie.php',
        'Flare\\Network\\Http\\Error' => __DIR__ . '/..' . '/Flare/Network/Http/Error.php',
        'Flare\\Network\\Http\\Model' => __DIR__ . '/..' . '/Flare/Network/Http/Model.php',
        'Flare\\Network\\Http\\Session' => __DIR__ . '/..' . '/Flare/Network/Http/Session.php',
        'Flare\\Network\\Http\\View' => __DIR__ . '/..' . '/Flare/Network/Http/View.php',
        'League\\OAuth2\\Client\\Provider\\Google' => __DIR__ . '/..' . '/phpmailer/get_oauth_token.php',
        'PHPMailer' => __DIR__ . '/..' . '/phpmailer/class.phpmailer.php',
        'PHPMailerOAuth' => __DIR__ . '/..' . '/phpmailer/class.phpmaileroauth.php',
        'PHPMailerOAuthGoogle' => __DIR__ . '/..' . '/phpmailer/class.phpmaileroauthgoogle.php',
        'POP3' => __DIR__ . '/..' . '/phpmailer/class.pop3.php',
        'SMTP' => __DIR__ . '/..' . '/phpmailer/class.smtp.php',
        'app\\http\\models\\Admin' => __DIR__ . '/../..' . '/app/http/models/Admin.php',
        'app\\http\\models\\Book' => __DIR__ . '/../..' . '/app/http/models/Book.php',
        'app\\http\\models\\Finance' => __DIR__ . '/../..' . '/app/http/models/Finance.php',
        'app\\http\\models\\Secretary' => __DIR__ . '/../..' . '/app/http/models/Secretary.php',
        'app\\http\\models\\Treasurer' => __DIR__ . '/../..' . '/app/http/models/Treasurer.php',
        'app\\http\\models\\Users' => __DIR__ . '/../..' . '/app/http/models/Users.php',
        'phpmailerException' => __DIR__ . '/..' . '/phpmailer/class.phpmailer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit0f6964990c779b2889b1e2c96077c877::$classMap;

        }, null, ClassLoader::class);
    }
}
