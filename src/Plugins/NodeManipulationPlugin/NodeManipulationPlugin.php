<?php

namespace MiNutCz\Tree\Plugins\NodeManipulationPlugin;

use MiNutCz\Tree\Exceptions\InvalidStateException;
use MiNutCz\Tree\Plugins\PluginInterface;

class NodeManipulationPlugin implements PluginInterface
{
    /** @var string[] */
    private array $openedNodes = [];
    /** @var string[] */
    private array $selectedNodes = [];
    /** @var string[] */
    private array $disabledNodes = [];
    /** @var string[] */
    private array $enabledNodes = [];
    private bool $disabledTree = false;
    private bool $openSelectedNode = true;

    public function getName(): string
    {
        return 'nodeManipulation';
    }

    public function getConfig(): ?array
    {
        $data = [
            "openNodes" => $this->openedNodes,
            "selectedNodes" => $this->selectedNodes,
            "openSelectedNode" => $this->openSelectedNode,
            'disabledTree' => $this->disabledTree,
        ];

        if ($this->disabledTree) {
            $data['enabledNodes'] = $this->enabledNodes;
        } else {
            $data['disabledNodes'] = $this->disabledNodes;
        }

        return $data;
    }

    /**
     * @param string[] $openedNodes
     * @return $this
     */
    public function setOpenedNodes(array $openedNodes): self
    {
        $this->openedNodes = $openedNodes;
        return $this;
    }

    /**
     * @param string[] $selectedNodes
     * @param bool $openSelectedNode
     * @return $this
     */
    public function setSelectedNodes(array $selectedNodes, $openSelectedNode = true): self
    {
        $this->selectedNodes = $selectedNodes;
        $this->openSelectedNode = $openSelectedNode;
        return $this;
    }

    /**
     * @param string[] $disabledNodes
     * @return $this
     */
    public function setDisabledNodes(array $disabledNodes): NodeManipulationPlugin
    {
        if ($this->disabledTree) {
            throw new InvalidStateException('You can not set disabledNodes when you have disabledTree set');
        }
        if (!empty($this->enabledNodes)) {
            throw new InvalidStateException('You can not set disabledNodes when you have enabledNodes set');
        }
        $this->disabledNodes = $disabledNodes;
        return $this;
    }

    /**
     * @param string[] $enabledNodes
     * @return $this
     */
    public function setEnabledNodes(array $enabledNodes): NodeManipulationPlugin
    {
        if (!empty($this->disabledNodes)) {
            throw new InvalidStateException('You can not set enabledNodes when you have disabledNodes set');
        }
        $this->enabledNodes = $enabledNodes;
        return $this;
    }

    public function setDisabledTree(bool $disabledTree = true): NodeManipulationPlugin
    {
        if (!empty($this->disabledNodes)) {
            throw new InvalidStateException('You can not set disabledTree to true when you have disabledNodes set');
        }
        $this->disabledTree = $disabledTree;
        return $this;
    }


}