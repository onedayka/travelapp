<?php

namespace TravelApp\Core;

/**
 * Класс для валидации параметров запроса.
 */

class QueryParamsValidator {
    /**
     * Проверяет корректность параметра сортировки (order).
     *
     * @param string $order Значение параметра сортировки.
     * @return bool true, если параметр корректен, иначе false.
     */
    public static function validateOrder(string $order): bool {
        return in_array(strtolower($order), ['asc', 'desc']);
    }

    /**
     * Проверяет корректность поля для сортировки (field).
     *
     * @param string $field Значение параметра field.
     * @param array $allowedFields Массив разрешенных полей для сортировки.
     * @return bool true, если поле корректно, иначе false.
     */
    public static function validateField(string $field, array $allowedFields): bool {
        return in_array($field, $allowedFields);
    }
}

?>