<?php

namespace App\Http\Controllers\Botman;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use Botman\Botman\Drivers\DriverManager;
use Botman\Drivers\Telegram\TelegramDriver;

class BotmanController extends Controller
{
    public function teleSetup()
    {
        $settings = Settings::find(1);

        $config = [
            'telegram' => [
                'token' => $settings->telegram_bot_api,
            ],
        ];

        DriverManager::loadDriver(TelegramDriver::class);

        // Create an instance
        $botman = BotManFactory::create($config, new LaravelCache());

        // Give the bot something to listen for.
        $botman->hears('Start Bot', function (BotMan $bot) {
            $bot->startConversation(new SignalConversation());
        })->skipsConversation();

        $botman->fallback(function ($bot) {
            // $bot->reply('Sorry, I did not understand this command. Enter Hi to start a coversation');
        });

        // Start listening
        $botman->listen();
    }
}
