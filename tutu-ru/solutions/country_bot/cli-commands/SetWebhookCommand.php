<?

namespace TuTuRu\Command;

use Longman\TelegramBot\Telegram;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
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
            $options = $this->makeOptions($output);
            $result = $telegram->setWebhook(
                $hook_url,
                $options
            );
            if ($result->isOk()) {
                $output->writeln('OK: ' . $result->getDescription());
            }
        } catch (\Exception $e) {
            // log telegram errors
            $output->writeln('Error: ' . $e->getMessage());
        }
    }

    /**
     * @param $output
     *
     * @return array
     * @throws \Exception
     */
    private function makeOptions($output): array{
        $options = [];
        if(
        $certPath = getenv('TELEGRAM_BOT_CERT')
        ){
            $output->writeln('Use certificate: ' . $certPath);
            $certFullPath = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$certPath;
            if(
                file_exists($certFullPath )
                &&
                is_file($certFullPath )
            ){
                $options ['certificate'] = $certFullPath ;
            }else{
                throw new \Exception('Cert file set in .env but not found: '.$certFullPath);
            }
        }else{
            $output->writeln('Running without attached certificate');
        }
        return $options;
    }
}