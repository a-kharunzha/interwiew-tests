Структура 

bot-commands/ - обработчики команд боту. В данном случае, одна
cli-commands/ - команды для крона, заполнение таблицы и регистрация вебхука
db/ - миграции 
Model/ - ORM для таблицы
tests/ юнит-тесты
.env.example - шаблон .env файла конфига
cli.php файл для запуска команд из командной строки
hook.php - файл для коллбеков от телеграма
phinx.php - конфиг для миграций

основные команды:

сделать подписку на вебхук, выполняется один раз после деплоя
```
php tutu-ru/solutions/country_bot/cli.php telegram_bot:set_hook
```


остальные многоразовые и продублированы в composer scripts:

накатить миграции
```
composer bot:migrate 
or
vendor/bin/phinx migrate -c tutu-ru/solutions/country_bot/phinx.php
```

откат миграции
```
composer bot:rollback
or
vendor/bin/phinx rollback -c tutu-ru/solutions/country_bot/phinx.php
```

дернуть команду заполнения/обновления таблицы со списком стран
```
bot:seed_countries
or
php tutu-ru/solutions/country_bot/cli.php telegram_bot:import_countries
```


запустить phpunit
```
composer bot:test
or
vendor/bin/phpunit -c tutu-ru/solutions/country_bot/phpunit.xml
```

запустить phpunit с перегенерацией code-coverage отчета 
```
composer bot:test_update_coverage
or
vendor/bin/phpunit --coverage-html tutu-ru/solutions/country_bot/build/coverage -c tutu-ru/solutions/country_bot/phpunit.xml
```