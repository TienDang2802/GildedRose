<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Commenting\DocCommentSniff;
use PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use Symplify\EasyCodingStandard\ValueObject\Option;

return function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(SetList::PSR_12);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/public', __DIR__ . '/tests']);
    $parameters->set(Option::LINE_ENDING, "\r\n");

    $services = $containerConfigurator->services();
    $services->set(BlankLineBeforeStatementFixer::class)
        ->call('configure', [
                [
                    'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
                ],
            ]
        );
    $services->set(FunctionTypehintSpaceFixer::class);
};