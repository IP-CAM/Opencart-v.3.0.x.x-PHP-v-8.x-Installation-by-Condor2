<?php
// Site
$_['site_url']          = HTTP_SERVER;

// Language
$_['language_default']  = 'en-gb';
$_['language_autoload'] = array('en-gb');

// Session
$_['session_autostart']  = true;
$_['session_engine']     = 'file'; // db or file
$_['session_name']       = 'OCSESSID';

// Template
$_['template_engine']   = 'twig';
$_['template_cache']    = true;

// Error
$_['error_display']     = true;

// Actions
$_['action_default']    = 'install/step_1';
$_['action_router']     = 'startup/router';
$_['action_error']      = 'error/not_found';
$_['action_pre_action'] = array(
	'startup/language',
	'startup/upgrade',
	'startup/database'
);

// Action Events
$_['action_event'] = array(
	'view/*/before' => array(
		'event/theme'
	)
);
