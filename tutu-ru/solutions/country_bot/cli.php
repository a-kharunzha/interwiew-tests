<?php

// cli.php

require __DIR__ . '/bootstrap.php';

use TuTuRu\Command\ImportBotCountriesCommand;
use TuTuRu\Command\SetWebhookCommand;
use Symfony\Component\Console\Application;


$application = new Application();

// ... register cli-bot-commands
$application->add(new SetWebhookCommand());
$application->add(new ImportBotCountriesCommand());

$application->run();