<?php

namespace Sstalle\php7cc\NodeVisitor;

use PhpParser\Node;
use Sstalle\php7cc\CompatibilityViolation\Message;

class AutoloadVisitor extends AbstractVisitor
{
    const LEVEL = Message::LEVEL_WARNING;

    /**
     * {@inheritdoc}
     */
    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Stmt\Function_) {
            if ($node->name === '__autoload') {
                $this->addContextMessage(
                    sprintf('Deprecated __autoload() defined.'),
                    $node
                );
            }
        }
    }
}
