<?php

namespace MiNutCz\Tree\Plugins\ContextmenuPlugin;

use JsonSerializable;
use MiNutCz\Tree\Enum\KeyCode;
use MiNutCz\Tree\Exceptions\InvalidStateException;
use MiNutCz\Tree\Plugins\ContextmenuPlugin\Actions\MenuAction;
use MiNutCz\Tree\Plugins\TypesPlugin\Type;
use Nette\Utils\Strings;

class MenuItem implements JsonSerializable
{
    use SubItemsTrait;

    private bool $separatorBefore = false;
    private bool $separatorAfter = false;
    private bool $disabled = false;
    private ?MenuAction $action;
    private string $label;
    private string $name;
    private string $title = '';
    private string $icon = '';
    private KeyCode|null $shortcut = null;
    private ?string $confirmQuestion = null;
    /** @var string[] */
    private array $whitelistTypes = [];

    public function __construct(string $label, ?MenuAction $action = null)
    {
        $this->label = $label;
        $this->name = Strings::webalize($label);
        $this->action = $action;
    }


    public function isSeparatorBefore(): bool
    {
        return $this->separatorBefore;
    }

    public function isSeparatorAfter(): bool
    {
        return $this->separatorAfter;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function getAction(): ?MenuAction
    {
        return $this->action;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getShortcut(): KeyCode|null
    {
        return $this->shortcut;
    }

    /** @return string[] */
    public function getWhitelistTypes(): array
    {
        return $this->whitelistTypes;
    }


    public function getName(): string
    {
        return $this->name;
    }

    /**
     * If true, a separator line is displayed before this item.
     * @param bool $separatorBefore
     * @return $this
     */
    public function setSeparatorBefore(bool $separatorBefore = true): MenuItem
    {
        $this->separatorBefore = $separatorBefore;
        return $this;
    }

    /**
     * If true, a separator line is displayed after this item.
     * @param bool $separatorAfter
     * @return $this
     */
    public function setSeparatorAfter(bool $separatorAfter = true): MenuItem
    {
        $this->separatorAfter = $separatorAfter;
        return $this;
    }

    public function setDisabled(bool $disabled = true): MenuItem
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function setAction(?MenuAction $action): MenuItem
    {
        if (!empty($this->action)) {
            throw new InvalidStateException('Cannot set action to menu item with submenu!');
        }
        $this->action = $action;
        return $this;
    }

    public function setLabel(string $label): MenuItem
    {
        $this->label = $label;
        return $this;
    }

    public function setName(string $name): MenuItem
    {
        $this->name = $name;
        return $this;
    }

    public function setTitle(string $title): MenuItem
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Sets the icon for this menu item.
     * @param string $icon - class from font-awesome and similar libraries, for example 'fa fa-file'
     * @return $this
     */
    public function setIcon(string $icon): MenuItem
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Set keyboard shortcut for action.
     * @param KeyCode $shortcut
     * @return $this
     */
    public function setShortcut(KeyCode $shortcut): MenuItem
    {
        $this->shortcut = $shortcut;
        return $this;
    }

    /**
     * Required confirmation question for action. User js confirm() function.
     * @param string|null $confirmQuestion
     * @return $this
     */
    public function setConfirmQuestion(?string $confirmQuestion): MenuItem
    {
        $this->confirmQuestion = $confirmQuestion;
        return $this;
    }

    public function addItem(MenuItem $item): self
    {
        if ($this->getAction() != null) {
            throw new InvalidStateException('Cannot add submenu to menu item with action!');
        }
        $this->items[$item->getName()] = $item;
        return $this;
    }

    /**
     * Node type for which this menu item is available.
     * @param Type $type
     * @return $this
     */
    public function addWhitelistType(Type $type): self
    {
        $this->whitelistTypes[] = $type->getName();
        return $this;
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        $data = [
            'name' => $this->name,
            'separator_before' => $this->separatorBefore,
            'separator_after' => $this->separatorAfter,
            '_disabled' => $this->disabled,
            'label' => $this->label,
            'title' => $this->title,
            'icon' => $this->icon,
            'shortcut' => $this->shortcut,
            'whitelist_types' => $this->whitelistTypes,
            'submenu' => $this->items,
        ];
        if ($this->action !== null) {
            $data['actionType'] = $this->action->getType()->value;
        }
        if ($this->confirmQuestion !== null) {
            $data['confirm_question'] = $this->confirmQuestion;
        }
        if ($this->shortcut !== null) {
            $data['shortcut'] = $this->shortcut->value;
            $data['shortcut_label'] = $this->shortcut->keyName();
        }
        return $data;
    }

}