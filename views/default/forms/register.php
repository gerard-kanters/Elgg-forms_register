<?php

if (elgg_is_sticky_form('register')) {
	$values = elgg_get_sticky_values('register');
	elgg_clear_sticky_form('register');
} else {
	$values = [];
}

$header = elgg_echo('forms:register:header');
if ($header) {
	echo elgg_format_element('div', [
		'class' => 'elgg-form-register-header',
			], $header);
}

if (elgg_get_plugin_setting('first_last_name', 'forms_register', false)) {
	// show first and last name fields
	$first_name = elgg_extract('first_name', $values, get_input('fn'));
	$last_name = elgg_extract('last_name', $values, get_input('ln'));
	echo elgg_view_input('text', [
		'name' => 'first_name',
		'value' => $first_name,
		'required' => true,
		'label' => elgg_echo('forms:register:first_name'),
	]);
	echo elgg_view_input('text', [
		'name' => 'last_name',
		'value' => $last_name,
		'required' => true,
		'label' => elgg_echo('forms:register:last_name'),
	]);
} else if (elgg_get_plugin_setting('autogen_name', 'forms_register', false)) {
// do not display anything if name is autogenerated
} else {
	$name = elgg_extract('name', $values, get_input('n'));
	echo elgg_view_input('text', [
		'name' => 'name',
		'value' => $name,
		'autofocus' => true,
		'required' => true,
		'label' => elgg_echo('name'),
	]);
}

$email = elgg_extract('email', $values, get_input('e'));
echo elgg_view_input('email', [
	'name' => 'email',
	'value' => $email,
	'required' => true,
	'label' => elgg_echo('email'),
]);

if (elgg_get_plugin_setting('autogen_username', 'forms_register', false)) {
	// do not display anything if username is autogenerated
} else {
	$username = elgg_extract('username', $values, get_input('u'));
	echo elgg_view_input('text', [
		'name' => 'username',
		'value' => $username,
		'required' => true,
		'label' => elgg_echo('username'),
		'minlength' => elgg_get_config('minusername') ? : 4,
		'data-parsley-validusername' => 1,
		'data-parsley-availableusername' => 1,
	]);
}

if (elgg_get_plugin_setting('autogen_password', 'forms_register', false)) {
	// do not display anything if password is autogenerated
} else {
	echo elgg_view_input('password', [
		'id' => 'password',
		'name' => 'password',
		'required' => true,
		'label' => elgg_echo('password'),
		'minlength' => elgg_get_config('min_password_length') ? : 6, 'data-parsley-minstrength' => elgg_get_plugin_setting('min_password_strength', 'forms_register', 0),
	]);

	echo elgg_view_input('password', [
		'name' => 'password2',
		'required' => true,
		'label' => elgg_echo('passwordagain'),
		'data-parsley-equalto' => '#password',
	]);
}


// view to extend to add more fields to the registration form
echo elgg_view('register/extend', $vars);

// Add captcha hook
echo elgg_view('input/captcha', $vars);

echo elgg_view('input/hidden', [ 'name' => 'friend_guid', 'value' => $vars['friend_guid']]);
echo elgg_view('input/hidden', ['name' => 'invitecode', 'value' => $vars['invitecode']]);

$footer = elgg_echo('forms:register:footer');
if ($header) {
	echo elgg_format_element('div', [
		'class' => 'elgg-form-register-footer',
			], $footer);
}

echo elgg_view_input('submit', array(
	'value' => elgg_echo('register'),
	'field_class' => 'elgg-foot',
));