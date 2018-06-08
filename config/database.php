<?php

use Flare\Components\Database\QueryBuilder;

use Flare\Components\Environment;

Environment::include();

QueryBuilder::settings(
	array
	(
		'Host'      => Environment::get('DATABASE_HOST'),
		'Username'  => Environment::get('DATABASE_USERNAME'),
		'Password'  => Environment::get('DATABASE_PASSWORD'),
		'Database'  => Environment::get('DATABASE_NAME')
	)
);