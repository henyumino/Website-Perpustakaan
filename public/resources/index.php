<?php

require '../../vendor/autoload.php';

$Settings = array
            (
            	'custom_errors' => 'errors/'
            );

use Flare\Network\Http\View;

View::setDirectory($Settings);

View::error_404();