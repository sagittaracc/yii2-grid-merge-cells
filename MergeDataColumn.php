<?php
namespace sagittaracc\grid;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;

class MergeDataColumn extends DataColumn {
  public function init() {
    parent::init();

    $columnData = ArrayHelper::getColumn($this->grid->dataProvider->getModels(), $this->attribute);

    $this->contentOptions = function($model, $key, $index, $column) use ($columnData) {
      $curr = $columnData[$index];
      $prev = $key > 0 ? $columnData[$index - 1] : null;

      if ($curr !== $prev) {
        $rowSpan = 1;

        for ($i = $index; $i < count($columnData) - 1; $i++)
        if ($curr === $columnData[$i + 1])
          $rowSpan++;
        else
          break;

        return ['rowspan' => $rowSpan];
      } else {
        return ['class' => 'hide'];
      }
    };
  }
}
