<?php
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$description = array(
	'MAIN' => 'Оплата заказа через систему Uzcard',
);

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$host = $request->isHttps() ? 'https' : 'http';

$isAvailable = \Bitrix\Sale\PaySystem\Manager::HANDLER_AVAILABLE_TRUE;

$licensePrefix = \Bitrix\Main\Loader::includeModule("bitrix24") ? \CBitrix24::getLicensePrefix() : "";
if (IsModuleInstalled("bitrix24") && !in_array($licensePrefix, ["ru"]))
{
	$isAvailable = \Bitrix\Sale\PaySystem\Manager::HANDLER_AVAILABLE_FALSE;
}

$data = array(
	'NAME' => 'Uzcard',
	'SORT' => 500,
	'IS_AVAILABLE' => $isAvailable,
	'CODES' => array(
		"UZCARD_LOGIN" => array(
			"NAME" => 'Логин',
			"DESCRIPTION" => 'Логин',
			'SORT' => 100,
			'GROUP' => 'CONNECT_SETTINGS_UZCARD'
		),
		"UZCARD_PASSWORD" => array(
			"NAME" => 'Пароль',
			"DESCRIPTION" => 'Пароль',
			'SORT' => 200,
			'GROUP' => 'CONNECT_SETTINGS_UZCARD'
		),
		"UZCARD_KEY" => array(
			"NAME" => 'Ключ',
			"DESCRIPTION" => 'Отдельно выданный оригинал',
			'SORT' => 300,
			'GROUP' => 'CONNECT_SETTINGS_UZCARD'
		),
		"UZCARD_EPOSID" => array(
			"NAME" => 'Идентификатор',
			"DESCRIPTION" =>  'Идентификатор виртуального терминала',
			'SORT' => 400,
			'GROUP' => 'CONNECT_SETTINGS_UZCARD'
		),
		"PAYMENT_ID" => array(
			"NAME" => 'Номер оплаты',
			"SORT" => 500,
			"GROUP" => 'PAYMENT',
			"DEFAULT" => array (
				'PROVIDER_KEY' => 'PAYMENT',
				'PROVIDER_VALUE' => 'ACCOUNT_NUMBER'
			) 
		),
	)
);