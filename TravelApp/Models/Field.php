<?php

namespace TravelApp\Models;

use Attribute;

/**
 * Атрибут, указывающий на поле модели данных.
 * Применяется к свойствам классов моделей для указания информации о поле в таблице базы данных.
 *
 * @package TravelApp\Models
 */

#[Attribute(Attribute::TARGET_PROPERTY)]
class Field {
    /**
     * Конструктор атрибута.
     *
     * @param string $column Имя столбца в базе данных, связанного с полем.
     * @param string $type Тип данных поля.
     * @param bool $primary Является ли поле первичным ключом.
     */
    public function __construct(
        public string $column,
        public string $type,
        public bool $primary = false
    ) {}
}

?>