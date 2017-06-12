<?php

namespace Sstalle\php7cc\NodeVisitor;

use PhpParser\Node;
use Sstalle\php7cc\CompatibilityViolation\Message;
use Sstalle\php7cc\NodeAnalyzer\FunctionAnalyzer;

class ErrorContextArgumentOfErrorHandlerVisitor extends AbstractVisitor
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
        if (!$this->functionAnalyzer->isFunctionCallByStaticName($node, 'set_error_handler')) {
            return;
        }

        if (isset($node->args[0]) && $node->args[0] instanceof Node\Arg) {
            /** @var Node\Arg $arg */
            $arg = $node->args[0];
            if ($arg->value instanceof Node\FunctionLike) {
                if (count($arg->value->getParams()) > 4) {
                    $this->addContextMessage(
                        sprintf('Fifth parameter $errcontext became deprecated.'),
                        $node
                    );
                }
            }
        }


    }
}
