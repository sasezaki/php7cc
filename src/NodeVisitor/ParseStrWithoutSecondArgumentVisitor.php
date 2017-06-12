<?php

namespace Sstalle\php7cc\NodeVisitor;

use PhpParser\Node;
use Sstalle\php7cc\CompatibilityViolation\Message;
use Sstalle\php7cc\NodeAnalyzer\FunctionAnalyzer;

class ParseStrWithoutSecondArgumentVisitor extends AbstractVisitor
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

        if (!$this->functionAnalyzer->isFunctionCallByStaticName($node, 'parse_str')) {
            return;
        }

        if (!isset($node->args[1])) {
            $this->addContextMessage(
                sprintf('Deprecated parse_str() called without second argument.'),
                $node
            );
        }
    }
}
