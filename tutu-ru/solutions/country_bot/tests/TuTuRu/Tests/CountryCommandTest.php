<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Rolland
 * Date: 06.03.2019
 * Time: 08:14
 */

namespace TuTuRu\Tests;

use Longman\TelegramBot\Commands\UserCommands\CountryCommand;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Telegram;
use PHPUnit\Framework\TestCase;
use Stidges\CountryFlags\CountryFlag;

class CountryCommandTest extends TestCase
{
    const DUMMY_BOT_USERNAME = 'BotName';

    const COMMAND_PREFIX = 'country';
    const EXISTING_COUNTRY = 'Украина';
    const EXISTING_COUNTRY_LINK = 'https://en.wikipedia.org/wiki/Ukraine';
    const NOT_EXISTING_COUNTRY = 'qwerty';

    /**
     * @param array $updateData
     * @param string $expectedAnswer
     * @param bool $willBeCalled
     *
     * @dataProvider casesProvider
     *
     * @throws \Longman\TelegramBot\Exception\TelegramException
     * @throws \ReflectionException
     */
    public function testMakeAnswer(array $updateData, string $expectedAnswer, bool $willBeCalled)
    {
        /*
        заглушка для класса телеграма,
        переопределять не нужно, но сам объект класса создавать неудобно, ругается на отсутствие ключа и/или его формат
        а формат ключа протестирован в тестах пакета, не вижу смысла их повторять
        */
        $telegramStub = $this->createMock(Telegram::class);
        $update = new Update($updateData);
        $command = new CountryCommand($telegramStub, $update);
        // проверим, что с таким месседжем команда вообще будет запущена или не запущена
        $this->assertEquals( $willBeCalled,self::COMMAND_PREFIX == $update->getMessage()->getCommand());
        // а теперь уже что будет сгенерен верный результат по названию страны
        $answer = $command->makeAnswer($update->getMessage());
        $this->assertEquals($expectedAnswer,$answer);
    }

    public function casesProvider(){
        $countryFlag = new CountryFlag;
        $emoji = $countryFlag->get('UA');
        return [
            'command_right' => [
                self::makeUpdateData('command_right'),
                'Flag: '.$emoji.PHP_EOL
                    .'Link: '.self::EXISTING_COUNTRY_LINK,
                true
            ],
            'command_wrong' => [
                self::makeUpdateData('command_wrong'),
                'Country "'.self::NOT_EXISTING_COUNTRY.'" is not found :(',
                true
            ],
            'not_command_right' => [
                self::makeUpdateData('not_command_right'),
                'Flag: '.$emoji.PHP_EOL
                    .'Link: '.self::EXISTING_COUNTRY_LINK,
                false
            ],
            'not_command_wrong' => [
                self::makeUpdateData('not_command_wrong'),
                'Country "'.self::NOT_EXISTING_COUNTRY.'" is not found :(',
                false
            ],

        ];
    }

    /**
     * @param string $type
     *
     * @return Update
     * @throws \Longman\TelegramBot\Exception\TelegramException
     * @throws \InvalidArgumentException
     */
    protected function makeUpdateData(string $type){
        $post = array (
            'update_id' => 3, // fake int
            'message' =>
                array (
                    'message_id' => 2, // fake int
                    'from' =>
                        array (/*
                            'id' => int,
                            'is_bot' => bool,
                            'first_name' => string,
                            'last_name' => string,
                            'username' => string,
                            'language_code' => string,
                        */),
                    'chat' =>
                        array (
                            'id' => 1, // fake id
                            /*'first_name' => string,
                            'last_name' => string,
                            'username' => string,
                            'type' => string 'private|public',
                            */
                        ),
                    'date' => time(),
                    'text' => '/'.self::COMMAND_PREFIX, // initial command prefix
                    'entities' =>
                        array (
                            0 =>
                                array (
                                    'offset' => 0,
                                    'length' => 8, // strlen('/'.self::COMMAND_PREFIX)
                                    'type' => 'bot_command',
                                ),
                        ),
                ),
        );
        switch ($type){
            case 'command_right':
                $post['message']['text'] .= ' '.self::EXISTING_COUNTRY;
                break;
            case 'command_wrong':
                $post['message']['text'] .= ' '.self::NOT_EXISTING_COUNTRY ;
                break;
            case 'not_command_right':
                $post['message']['text'] = self::EXISTING_COUNTRY;
                break;
            case 'not_command_wrong':
                $post['message']['text'] = self::NOT_EXISTING_COUNTRY ;
                break;
            default:
                throw new \InvalidArgumentException('Type '.$type.' is not supported');
        }
        return $post;
    }
}
