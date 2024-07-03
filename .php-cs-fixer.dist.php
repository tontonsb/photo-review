<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        'app',
        'bootstrap',
        // 'config',
        // 'database',
        'lang',
        'routes',
        'tests',
    ])
    ->exclude([
        'cache',
    ])
    ->notPath([
        'laravellocalization.php',
    ]);

return (new PhpCsFixer\Config)->setFinder($finder)
	// ->setIndent("\t")
	->setRiskyAllowed(true)
	->setLineEnding("\n")
	->setRules([
		'@PHP80Migration:risky' => true,
		'@PHP84Migration' => true,
        '@PER-CS2.0' => true,
        '@Symfony:risky' => true,
		'@Symfony' => true,

		// Overrides `@PHP80Migration:risky`
		'declare_strict_types' => false,
        'void_return' => false,

		// Overrides `@PHP84Migration`
		'nullable_type_declaration_for_default_null_value' => false,

		// Overrides `@Symfony:risky`
		'is_null' => false,

		// Overrides `@PER-CS2.0`
		'new_with_parentheses' => [
			'anonymous_class' => false,
			'named_class' => false,
		],
		'trailing_comma_in_multiline' => [
			'elements' => ['arrays', 'match', 'parameters'],
		],
		'control_structure_braces' => false,
		'concat_space' => [
			'spacing' => 'none',
		],
        'binary_operator_spaces' => false,
        'single_trait_insert_per_statement' => false,

		// Overrides `@Symfony`
		'phpdoc_summary' => false,
		'ordered_imports' => false, //
		'global_namespace_import' => false,
		'single_line_throw' => false,
		// Disabled to allow no separation between interface/abstract methods
		'class_attributes_separation' => false,
        'single_space_around_construct' => [
            'constructs_contain_a_single_space' => ['yield_from'],
            // not requiring spaces after catch and match
            'constructs_followed_by_a_single_space' => ['abstract', 'as', 'attribute', 'break', 'case', 'class', 'clone', 'comment', 'const', 'const_import', 'continue', 'do', 'echo', 'else', 'elseif', 'enum', 'extends', 'final', 'finally', 'for', 'foreach', 'function', 'function_import', 'global', 'goto', 'if', 'implements', 'include', 'include_once', 'instanceof', 'insteadof', 'interface', 'named_argument', 'namespace', 'new', 'open_tag_with_echo', 'php_doc', 'php_open', 'print', 'private', 'protected', 'public', 'readonly', 'require', 'require_once', 'return', 'static', 'switch', 'throw', 'trait', 'try', 'type_colon', 'use', 'use_lambda', 'use_trait', 'var', 'while', 'yield', 'yield_from'],
            'constructs_preceded_by_a_single_space' => ['as', 'use_lambda'],
        ],
		'function_declaration' => [
			'closure_fn_spacing' => 'none',
			'closure_function_spacing' => 'none',
		],
        'no_extra_blank_lines' => [
            'tokens' => ['attribute', 'case', 'continue', 'curly_brace_block', 'default', 'extra', 'parenthesis_brace_block', 'switch', 'throw', 'use'],
        ],
        'nullable_type_declaration' => false,
        'no_empty_comment' => false,
        'no_multiline_whitespace_around_double_arrow' => false,
        'phpdoc_align' => [
            'align' => 'left',
            'spacing' => [
                'param' => 2,
            ],
        ],

		// Additional
		'single_line_empty_body' => true,
        'no_superfluous_elseif' => true,
        'no_useless_else' => true,

	]);

