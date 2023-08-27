<?php

namespace MiNutCz\Tree\Plugins\TypesPlugin;

use JsonSerializable;

class Type implements JsonSerializable
{
    private int $maxChildren = -1;
    private int $maxDepth = -1;
    /** @var string[]|null */
    private ?array $validChildren = null;
    private string $icon = '';
    private bool $draggable = true;

    public function __construct(private readonly string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxChildren(): int
    {
        return $this->maxChildren;
    }

    public function getMaxDepth(): int
    {
        return $this->maxDepth;
    }

    /**
     * @return string[]|null
     */
    public function getValidChildren(): ?array
    {
        return $this->validChildren;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function isDraggable(): bool
    {
        return $this->draggable;
    }

    /**
     * Sets the maximum number of children a node of this type can have.
     * @param int|null $maxChildren
     * @return $this
     */
    public function setMaxChildren(?int $maxChildren): Type
    {
        $this->maxChildren = $maxChildren ?? -1;
        return $this;
    }

    /**
     * Maximum number of nesting this node type can have.A value of 1 would mean that the node can have children, but no grandchildren.
     * @param int|null $maxDepth
     * @return $this
     */
    public function setMaxDepth(?int $maxDepth): Type
    {
        $this->maxDepth = $maxDepth ?? -1;
        return $this;
    }

    /**
     * Sets the icon for the type.
     * @param string $icon - class from font-awesome and similar libraries, for example 'fa fa-file'
     * @return $this
     */
    public function setIcon(string $icon): Type
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Determines if the type is draggable.
     * @param bool $draggable
     * @return $this
     */
    public function setDraggable(bool $draggable = true): Type
    {
        $this->draggable = $draggable;
        return $this;
    }

    public function isValidChild(Type $child): bool
    {
        return in_array($child->getName(), $this->validChildren ?? [$child->getName()]);
    }

    /**
     * Determines if the type is a valid child of the given type.
     * @param Type|null $validChildren If null, type cannot have descendant of any type
     *
     * @return Type
     */
    public function addValidChildren(?Type $validChildren = null): Type
    {
        if ($validChildren === null) {
            $this->validChildren = [];
            return $this;
        }
        $this->validChildren[] = $validChildren->getName();
        return $this;
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        $data = [
            'icon' => $this->icon,
            'max_children' => $this->maxChildren,
            'max_depth' => $this->maxDepth,
            'li_attr' => [],
            'a_attr' => [],
            'draggable' => $this->draggable,
        ];
        if ($this->validChildren !== null) {
            $data['valid_children'] = $this->validChildren;

        }
        return $data;
    }
}