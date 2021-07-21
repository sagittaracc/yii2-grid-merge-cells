<?php
namespace sagittaracc\grid;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;

class MergeDataColumn extends DataColumn {
  public $align = "top:left";

  public function init() {
    parent::init();

    $columnData = ArrayHelper::getColumn($this->grid->dataProvider->getModels(), $this->attribute);

    $this->contentOptions = function($model, $key, $index, $column) use ($columnData) {
      $curr = $columnData[$key];
      $prev = $index > 0 ? $columnData[$key - 1] : null;

      if ($curr !== $prev) {
        $rowSpan = 1;

        while (key($columnData) !== $key) next($columnData);

        for ($i = $index; $i < count($columnData); $i++)
          if (current($columnData) === next($columnData))
            $rowSpan++;
          else
            break;

        $verticalAlign = explode(":", $this->align)[0];
        $horizontalAlign = explode(":", $this->align)[1];

        return [
          'rowspan' => $rowSpan,
          'style' => "vertical-align: $verticalAlign;".
                     "text-align: $horizontalAlign"
        ];
      } else {
        return ['class' => 'hide'];
      }
    };
  }
}
