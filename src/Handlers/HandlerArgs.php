<?php

namespace MiNutCz\Tree\Handlers;


class HandlerArgs
{

    private string $src;
    private string $command;
    private ?HandlerArgsNode $node = null;

    /** @var array<string,mixed> */
    private array $rawJson;


    public function getSrc(): string
    {
        return $this->src;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getNode(): ?HandlerArgsNode
    {
        return $this->node;
    }

    /** @return array<string,mixed> */
    public function getRawJson(): array
    {
        return $this->rawJson;
    }

    /**
     * @param array<string,mixed> $params
     * @return HandlerArgs
     */
    public static function createFromParameters(array $params): HandlerArgs
    {
        $json = json_decode($params['prm'] ?? '{}', true, 1024);
        $instance = new self();
        $instance->command = $params['command'];
        $instance->src = $params['src'];
        if (!empty($json)) {
            $json = !isset($json['id']) && isset($json[0]) ? $json[0] : $json;
            $instance->rawJson = $json;
            if (isset($json['id'])) {
                if (isset($json['original']['id'])) {
                    $original = new HandlerArgsNode(
                        strval($json['original']['id']),
                        strval($json['original']['parent']),
                        strval($json['original']['text'])
                    );
                } else {
                    $original = null;
                }
                $node = new HandlerArgsNode(
                    strval($json['id']),
                    strval($json['parent']),
                    strval($json['text']),
                    $original
                );
                $instance->node = $node;
            }
        }
        return $instance;
    }
}