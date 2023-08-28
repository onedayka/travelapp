<?php

namespace TravelApp\Base;

/**
 * Класс Response представляет объект, который управляет отправкой HTTP-ответов.
 */
class Response {

    protected int $statusCode;
    protected $data;

    /**
     * Конструктор класса Response.
     *
     * @param int $statusCode Код статуса HTTP-ответа.
     * @param mixed|null $data Данные для отправки в ответе (по умолчанию null).
     */
    public function __construct(int $statusCode, $data = null) {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    /**
     * Отправляет HTTP-ответ с заданным статусным кодом и данными.
     *
     * @return string Строка в формате JSON, содержащая данные и текущее время.
     */
    public function send(): string {
        http_response_code($this->statusCode);
        if ($this->data !== null) {
            return json_encode([
                "data" => $this->data,
                "time" => \time()
            ]);
        }
    }
}

?>