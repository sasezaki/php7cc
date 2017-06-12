<?php

namespace Sstalle\php7cc\NodeVisitor;

use PhpParser\Node;
use Sstalle\php7cc\CompatibilityViolation\Message;
use Sstalle\php7cc\NodeAnalyzer\FunctionAnalyzer;

class GmpRandomVisitor extends AbstractVisitor
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
        if (!$this->functionAnalyzer->isFunctionCallByStaticName($node, 'gmp_random')) {
            return;
        }

        $this->addContextMessage(
            sprintf('Deprecated gmp_random() called.'),
            $node
        );
    }
}
