<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PhpCsFixer\Fixer\FunctionNotation;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Tokens;

/**
 * @author Mark Scherer
 * @author Lucas Manzke <lmanzke@outlook.com>
 * @author Gregor Harlan <gharlan@web.de>
 */
final class NoDefaultArgumentValueFixer extends AbstractFixer
{
    public function getName(): string
    {
        return 'Custom/no_default_argument_value';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new FixerDefinition(
            'In function arguments there must not be arguments without default values.',
            [
                new CodeSample(
                    '<?php
function example($foo = "two words", $bar) {}
'
                ),
            ],
            null,
            'Modifies the signature of functions; therefore risky when using systems (such as some Symfony components) that rely on those (for example through reflection).'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isCandidate(Tokens $tokens)
    {
        return $tokens->isTokenKindFound(T_FUNCTION);
    }

    /**
     * {@inheritdoc}
     */
    public function isRisky()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function applyFix(\SplFileInfo $file, Tokens $tokens)
    {
        for ($i = 0, $l = $tokens->count(); $i < $l; ++$i) {
            if (!$tokens[$i]->isGivenKind(T_FUNCTION)) {
                continue;
            }

            $startIndex = $tokens->getNextTokenOfKind($i, ['(']);
            $i = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $startIndex);

            $this->fixFunctionDefinition($tokens, $startIndex, $i);
        }
    }

    /**
     * @param Tokens $tokens
     * @param int    $startIndex
     * @param int    $endIndex
     */
    private function fixFunctionDefinition(Tokens $tokens, $startIndex, $endIndex)
    {
		for ($i = $startIndex; $i <= $endIndex; $i++) {
            $token = $tokens[$i];

			if (!$token->isGivenKind(T_VARIABLE)) {
				continue;
			}

			$nextToken = $tokens[$tokens->getNextMeaningfulToken($i)];

			if (in_array($nextToken->getContent(), ['='])) {
				continue;
			}

			$content = $token->getContent() . '=null';
			$token->setContent($content);

			$tokens[$i] = $token;
		}
    }
}
