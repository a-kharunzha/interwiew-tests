<?

namespace TuTuRu\Command;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
// use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

// load environment

class SetWebhookCommand extends Command
{

    protected static $defaultName = 'telegram_bot:set_hook';

    protected function Configure()
    {
        $this
            ->setDescription('Creates webhook for telegram bot');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bot_api_key  = getenv('TELEGRAM_BOT_TOKEN');
        $bot_username = getenv('TELEGRAM_BOT_NAME');
        $hook_url = getenv('TELEGRAM_WEBHOOK_URL');

        $output->writeln('TELEGRAM_BOT_NAME: ' . $bot_username);
        $output->writeln('TELEGRAM_WEBHOOK_URL: ' . $hook_url);

        try {
            // Create Telegram API object
            $telegram = new Telegram($bot_api_key, $bot_username);

            // Set webhook
            $result = $telegram->setWebhook(
                $hook_url,
                [
                    'certificate' => $_SERVER['DOCUMENT_ROOT'].getenv('TELEGRAM_BOT_CERT')
                ]
            );
            if ($result->isOk()) {
                $output->writeln('OK: ' . $result->getDescription());
            }
        } catch (TelegramException $e) {
            // log telegram errors
            $output->writeln('Error: ' . $e->getMessage());
        }
    }
}