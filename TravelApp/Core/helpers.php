<?php

use TravelApp\Base\Response;

/**
 * Создает и отправляет HTTP-ответ с заданным статусным кодом и данными.
 *
 * @param int $statusCode Код статуса HTTP-ответа (по умолчанию 200 OK).
 * @param mixed $data Данные для отправки в ответе.
 * @return void
 */
function response($statusCode = 200, $data) {
    $response = new Response($statusCode, $data);
    echo $response->send();
    return $response;
}

/**
 * Экранирует HTML-сущности в строке.
 *
 * Функция `e` используется для безопасного вывода переменных
 * в HTML-контексте, предотвращая атаки типа Cross-Site Scripting (XSS).
 *
 * @param mixed $value Значение, которое нужно экранировать.
 * @return string Экранированное значение.
 */
function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}

?>