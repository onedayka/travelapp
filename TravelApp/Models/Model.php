<?php

namespace TravelApp\Models;

/**
 * Атрибут, указывающий на модель данных.
 * Применяется к классам моделей для указания имени таблицы в базе данных.
 *
 * @package TravelApp\Models
 */
#[Attribute(Attribute::TARGET_CLASS)]
class Model {
    public function __construct(public string $table) {}
}

?>