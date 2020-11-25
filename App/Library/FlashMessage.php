<?php

namespace App\Library;

/**
 * managing flash message.
 */
class FlashMessage
{
    const SUCCESS = 'success';
    const FAIL = 'failure';

    /** @var int */
    private $id = 1;

    /** @var array */
    private $storage = [];

    /**
     * @param string $key key = FlashMessage::SUCCESS or FAIL
     */
    public function addMessage(string $key, string $message): void
    {
        if (self::SUCCESS === $key) {
            $this->storage[self::SUCCESS] = $message;
        } else {
            if (!isset($this->storage[self::FAIL])) {
                $this->storage[self::FAIL] = [];
            }
            $this->storage[self::FAIL][$this->id] = $message;
            ++$this->id;
        }
    }

    /**
     * @return array all stored message
     */
    public function getMessages(): array
    {
        return $this->storage;
    }
}
