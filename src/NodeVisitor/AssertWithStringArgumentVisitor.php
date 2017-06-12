<?php

namespace Sstalle\php7cc\NodeVisitor;

use PhpParser\Node;
use Sstalle\php7cc\CompatibilityViolation\Message;
use Sstalle\php7cc\NodeAnalyzer\FunctionAnalyzer;

class AssertWithStringArgumentVisitor extends AbstractVisitor
{
    const LEVEL = Message::LEVEL_WARNING;

    /**
     * @var FunctionAnalyzer
     */
    protected $functionAnalyzer;

    /**
     * @param FunctionAnalyzer $functionAnalyzer
     */
    public function __construct(FunctionAnalyzer $functionAnalyzer)
    {
        $this->functionAnalyzer = $functionAnalyzer;
    }

    /**
     * {@inheritdoc}
     */
    public function enterNode(Node $node)
    {
        if (!$this->functionAnalyzer->isFunctionCallByStaticName($node, 'assert')) {
            return;
        }

        if ($node->args[0]->value instanceof Node\Scalar\String_) {
            $this->addContextMessage(
                sprintf('Deprecated assert() with string argument called.'),
                $node
            );
        }
    }
}
