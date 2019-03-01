<?

namespace TuTuRu\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TuTuRu\Model\BotCountry;

/**
 * Class ImportBotCountriesCommand - для наполнения и, возможно, периодического обновления данных в таблице со списком стран, используемой ботом
 * @package Command
 *
 */
class ImportBotCountriesCommand extends Command
{

    protected static $defaultName = 'telegram_bot:import_countries';
    protected $input;
    protected $output;

    protected function Configure()
    {
        $this
            ->setDescription('Imports/updates data in Countries table')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $listEn = $this->getCountriesList('en');
        $listRu = $this->getCountriesList('ru');
        $created = 0;
        $updated = 0;
        foreach($listEn as $code => $nameEn){
            /*
            так как скрипт для заполнения почти одноразовый, и стран всего 255 штук,
            то нет особого смысла делать запрос на все существующие и проверку на недостающие
            гораздо проще сделать запрос на каждую страну
            */
            try {
                // пытаемся найти строку, которая уже в БД
                $row = new BotCountry($code);
                $updated ++;
            } catch (\fNotFoundException $e) {
                // не нашлось, создаем новую
                $row = new BotCountry();
                $row->setCode($code);
                $created ++;
            }
            $row -> setNameEn($nameEn) ;
            $row -> setNameRu($listRu[$code]) ;
            $row -> setWikiLink($this->getCountryWikiLink($nameEn));
            $row -> store();
        }
        $output->writeln(
            'Created: '.$created.PHP_EOL
            .'Updated: '.$updated
        );
    }

    /**
     * returns array of countries [['code'=>'name']...]
     *
     * @param $lang
     *
     * @return array
     * @throws \Exception
     */
    protected function getCountriesList($lang){
        /** @todo: find some not-hardcoded way to determine files path*/
        $path = $_SERVER['DOCUMENT_ROOT'].'/vendor/umpirsky/country-list/data/'.$lang.'/country.php';
        if(!file_exists($path )){
            throw new \Exception('Lang file not found: '.$path );
        }
        $list = require $path;
        return $list;
    }

    /**
     * returns URL to Country's page on Wikipedia
     *
     * @param string $countryNameEn English Country name
     *
     * @return string
     */
    protected function getCountryWikiLink(string $countryNameEn){
        /*
         * на текущий момент все названия стран, включая те, что с пробелами, скобками, амперсандами и другими странностями,
         * нормально разбираются самой википедией и 301м редиректом оттуда пользователя перекидывает на нужную страницу
         * Так что, если тут прям нужна будет _правильная ссылка_, то можно отсюда дернуть запрос на вики, получить хедеры и оттуда взять полноценный урл
         * UPD: urlencode вредит, при замене пробелов плюсами википедия дает 404
         */
        // return "https://en.wikipedia.org/wiki/".urlencode($countryNameEn);
        return "https://en.wikipedia.org/wiki/".$countryNameEn;
    }
}