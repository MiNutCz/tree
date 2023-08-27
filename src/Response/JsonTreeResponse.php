<?php

namespace MiNutCz\Tree\Response;

use Nette;
use Nette\Application\Response;
use Nette\Utils\JsonException;

class JsonTreeResponse implements Response
{
    /** @var array<string,mixed> */
    private array $data = [];
    private bool $refreshTree = false;
    private string $contentType = 'application/json';


    public function refreshTree(bool $refreshTree = true): self
    {
        $this->refreshTree = $refreshTree;
        return $this;
    }

    /** @throws JsonException */
    function send(Nette\Http\IRequest $httpRequest, Nette\Http\IResponse $httpResponse): void
    {
        $httpResponse->setContentType($this->contentType, 'utf-8');
        echo Nette\Utils\Json::encode($this->getPayLoad());
    }

    /**
     * @return array<string, mixed>
     */
    private function getPayLoad(): array
    {
        return [
            'data' => $this->data,
            'refreshTree' => $this->refreshTree
        ];
    }
}