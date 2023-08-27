<?php

namespace MiNutCz\Tree\Handlers;


class HandlerArgsNode
{

    private string $id;
    private string $parent;
    private string $text;
    private ?HandlerArgsNode $original;

    public function __construct(string $id, string $parent, string $text, ?HandlerArgsNode $original = null)
    {
        $this->id = $id;
        $this->parent = $parent;
        $this->text = $text;
        $this->original = $original;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getParent(): string
    {
        return $this->parent;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getOriginal(): ?HandlerArgsNode
    {
        return $this->original;
    }


}