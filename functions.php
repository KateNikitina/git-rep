<?
namespace Mynamespace;

use Bitrix\Main\Type\DateTime as DateTime,
    Invest\BudgetListTable,
    Invest\HistoryTransactionsTable;

\CModule::IncludeModule("sale");
\CModule::IncludeModule("iblock");


class HistoryBudget{



  public static function TransactionAdd($title, $str_time, $summ, $id_deal) {  
	  $date_time = ConvertTimeStamp($str_time, "FULL"); // преобразуем дату
	  $time = new DateTime($date_time);
    
	  $new_balance = 1200;
	  $result = HistoryTransactionsTable::add([
	      'TITLE' => $title,
	      'TIME_CREATE' => $time,
	      'SUMM_CHANGE' => $summ, // насколько был изменен
	      'BEFORE_SUMM' => 1000, // был до изменения бюджет 
	      'AFTER_SUMM' => $new_balance, // стал после изменения бюджет
	      'DEAL_ID' => 25
	  ]);

      $return = ($result->isSuccess()) ? $result->getId() : $result->getErrorMessages();
      return $return;

  }


// удаление транзакции
  public static function TransactionDelete($id){
    $result = HistoryTransactionsTable::delete($id);
    $return = (!$result->isSuccess()) ? $result->getErrorMessages() : true;
    return $return;
  }

// обновление транзакции
  public static function TransactionUpdate($id, $fields){
    $result = HistoryTransactionsTable::update($id, $fields);
    $return = (!$result->isSuccess()) ? $result->getErrorMessages() : true;
    return $return;
  }

// история транзаций
  public static function TransactionsGetList($select, $arFilter=[], $arGroup=[], $arOrder=[]) {

    $fields = [
      'select' => $select,
      'count_total' => true,
      'filter' => $arFilter,
      'group' => $arGroup,
      'order' => $arOrder
    ];

    $result = HistoryTransactionsTable::getList($fields);
  
    while($row = $result->fetch()){
      $arRow[$row['DEAL_ID']][$row['ID']] = $row;
    }

    return $arRow;
  }
}
