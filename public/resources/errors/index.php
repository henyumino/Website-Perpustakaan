<?php

require '../../../vendor/autoload.php';

$Settings = array
            (
            	'custom_errors'    => ''
            );

use Flare\Network\Http\View;

View::setDirectory($Settings);

View::error_404();