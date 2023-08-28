<?php

/**
 * Модель для представления данных о рейтингах.
 * Используется для взаимодействия с таблицей "ratings" в базе данных.
 */

namespace TravelApp\Models;

use TravelApp\Base\BaseModel;

#[Model(table: 'ratings')]
class Rating extends BaseModel {
    #[Field(column: 'id', type: 'int', primary: true)]
    public int $id;

    #[Field(column: 'traveler_id', type: 'int')]
    public int $traveler_id;

    #[Field(column: 'attraction_id', type: 'int')]
    public int $attraction_id;

    #[Field(column: 'rating', type: 'decimal')]
    public float $rating;

    public function __construct() {
        parent::__construct();
    }
}

?>