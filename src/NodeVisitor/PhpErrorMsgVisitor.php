<?php

namespace Sstalle\php7cc\NodeVisitor;

use PhpParser\Node;
use Sstalle\php7cc\CompatibilityViolation\Message;

class PhpErrorMsgVisitor extends AbstractVisitor
{
    const LEVEL = Message::LEVEL_WARNING;

    /**
     * {@inheritdoc}
     */
    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Expr\Variable) {
            if ($node->name === 'php_errormsg') {
                $this->addContextMessage(
                    sprintf('Deprecated $php_errormsg variable is created.'),
                    $node
                );
            }
        }
    }
}
