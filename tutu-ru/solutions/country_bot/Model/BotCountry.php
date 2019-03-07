<?
namespace TuTuRu\Model;

use \fActiveRecord;

/**
 * Class BotCountry
 * @package Model
 *
 * @method setCode(string $value)
 * @method setNameEn(string $value)
 * @method setNameRu(string $value)
 * @method setWikiLink(string $value)
 * @method getCode(): string
 * @method getNameEn(): string
 * @method getNameRu(): string
 * @method getWikiLink(): string
 */
class BotCountry extends fActiveRecord{
	
	protected function configure()
    {

    }
}
\fORM::mapClassToTable('BotCountry', 'bot_countries');