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
      $curr = $columnData[$index];
      $prev = $index > 0 ? $columnData[$index - 1] : null;

      if ($curr !== $prev) {
        $rowSpan = 1;

        for ($i = $index; $i < count($columnData) - 1; $i++)
          if ($curr === $columnData[$i + 1])
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
