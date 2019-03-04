<?php

declare(strict_types=1);

namespace Longman\TelegramBot\Commands\UserCommands;

use fRecordSet;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Request;
use Stidges\CountryFlags\CountryFlag;
use TuTuRu\Model\BotCountry;

/**
 * Generic message command
 */
class CountryCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'country';

    /**
     * @var string
     */
    protected $description = 'Handle generic message';

    /**
     * @var string
     */
    protected $version = '1.1.0';

    /**
     * @var bool
     */
    protected $need_mysql = false;

    /**
     * Execution if MySQL is required but not available
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     */
    public function executeNoDb()
    {
        //Do nothing
        return Request::emptyResponse();
    }

    /**
     * Execute command
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();            // Get Message object
        $chat_id = $message->getChat()->getId();   // Get the current Chat ID
        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => $this->makeAnswer($message)
        ];
        return Request::sendMessage($data);        // Send message!
    }


    protected function makeAnswer(Message $message): string {
        // получаем из текста то, что может быть названием страны
        $name = $message->getText(true);
        // ищем эту страну
        $country = $this->searchCountry($name);
        if($country ){
            return $this->makeCountryAnswer($country);
        }
        return $this->makeNotFoundAnswer($name);
    }

    protected function makeCountryAnswer(BotCountry $country): string {
        $countryFlag = new CountryFlag;
        $emoji = $countryFlag->get($country->getCode());
        return 'Flag: '.$emoji.PHP_EOL
            .'Link: '.$country->getWikiLink();

    }

    /**
     * Searches Country by english or russian name
     *
     * @param string $name
     *
     * @return BotCountry|null
     */
    protected function searchCountry(string $name) : ?BotCountry{
        $recordSet = fRecordSet::build(
            BotCountry::class,
            array('name_en|name_ru~' => $name),
            array(),
            1
        );
        if($recordSet->count()){
            return $recordSet[0];
        }
        return null;
    }

    protected function makeNotFoundAnswer(string $name): string {
        return 'Country "'.$name.'" is not found :(';
    }
}
