<?php


namespace App\Message;


class ReadComCommand
{
    private $commandType;
    private $data;

    const COMMAND_TYPE_CONNECT = 1;
    const COMMAND_TYPE_DISCONNECT = 2;
    const COMMAND_TYPE_START_READING = 3;
    const COMMAND_TYPE_STOP_READING = 4;
    const COMMAND_TYPE_SET_TIME = 5;
    const COMMAND_TYPE_UPDATE = 6;

    public function __construct(int $commandType, \stdClass $data)
    {
        $this->commandType = $commandType;
        $this->data = $data;
    }

    public function getCommandType(): int
    {
        return $this->commandType;
    }
    public function getData(): \stdClass
    {
        return $this->data;
    }
}
