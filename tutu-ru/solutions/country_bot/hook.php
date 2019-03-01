<?php

// Load composer
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;

require __DIR__ . '/bootstrap.php';

$bot_api_key = getenv('TELEGRAM_BOT_TOKEN');
$bot_username = getenv('TELEGRAM_BOT_NAME');

try {
    TelegramLog::initUpdateLog(__DIR__ . '/_update.log');
    TelegramLog::initErrorLog(__DIR__ . '/_error.log');
    TelegramLog::initDebugLog(__DIR__ . '/_debug.log');

    // Create Telegram API object
    $telegram = new Telegram($bot_api_key, $bot_username);

    $telegram->addCommandsPaths([
        __DIR__ . '/bot-commands/',
    ]);

    // Handle telegram webhook request
    $telegram->handle();
} catch (TelegramException $e) {
    // Silence is golden!
    // log telegram errors
    echo 'ERROR: '.$e->getMessage();
}