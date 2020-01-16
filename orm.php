<?namespace Mynamespace;

use Bitrix\Main\Entity,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\Relations\Reference,
    Bitrix\Main\ORM\Query\Join,
    Invest\BudgetListTable;

class HistoryTransactionsTable extends Entity\DataManager{

  public static function getTableName(){
    return 'history_transactions';
  }

  public static function getMap(){ 
    return [
      new Entity\IntegerField('ID', [
        'primary' => true,
        'autocomplete' => true
      ]),
      new Entity\StringField('TITLE'),
      new Entity\DateTimeField('TIME_CREATE'), 
      new Entity\IntegerField('SUMM_CHANGE'), 
      new Entity\IntegerField('BEFORE_SUMM'),  
      new Entity\IntegerField('AFTER_SUMM'), 
      new Entity\IntegerField('DEAL_ID'), 
      (new Reference(
        'DEAL',
        BudgetListTable::class,
        Join::on('this.DEAL_ID', 'ref.ID')
      ))->configureJoinType('inner')
    ];
  }

  public static function onAfterAdd(Entity\Event $event){ 
    $result = new Entity\EventResult;
    $data = $event->getParameter("fields");
  }
}
