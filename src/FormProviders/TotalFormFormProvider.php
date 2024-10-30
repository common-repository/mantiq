<?php

namespace Mantiq\FormProviders;

use Mantiq\Models\DataType;
use Mantiq\Models\ExecutionArguments;
use Mantiq\Models\FormProvider;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\StartupDefinition;
use Mantiq\Models\TriggerForm;
use Mantiq\Support\Collection;
use Mantiq\Tasks\Workflows\Repository\GetWorkflow;
use Mantiq\Tasks\Workflows\RunWorkflow;
use TotalForm\Models\Form;
use TotalForm\Tasks\Forms\GetForms;

class TotalFormFormProvider extends FormProvider
{
    public function getName()
    {
        return 'TotalForm';
    }

    public function getId()
    {
        return 'totalform';
    }

    public function getTriggers()
    {
        if (!class_exists('TotalForm\Tasks\Forms\GetForms')) {
            return [];
        }

        $forms = Collection::create();

        foreach (GetForms::invoke(['per_page' => 1000])->getItems() as $form) {
            /* @var Form $form */
            $outputs = [];
            foreach ($form->sections as $section) {
                if ($section->blocks->isEmpty()) {
                    continue;
                }

                foreach ($section->blocks as $index => $block) {
                    if (!$block->isContent()) {
                        $outputs[] = [
                            'id'       => $block->getSlug() ?: ($block->type.'_'.$index),
                            'name'     => $block->title ?? $block->getSlug(),
                            'type'     => DataType::string(),
                            'required' => $block->isRequired(),
                        ];
                    }
                }
            }

            $forms[] = new TriggerForm(
                $this,
                [
                    'id'      => $form->uid,
                    'name'    => $form->title,
                    'outputs' => [
                        new OutputDefinition(
                            [
                                'id'   => 'form',
                                'name' => __('Form object', 'mantiq'),
                                'type' => DataType::object(
                                    [
                                        [
                                            'id'   => 'id',
                                            'name' => 'Form ID',
                                            'type' => DataType::integer(),
                                        ],
                                        [
                                            'id'   => 'uid',
                                            'name' => 'Form UID',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'title',
                                            'name' => 'Form title',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'slug',
                                            'name' => 'Form slug',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'published_at',
                                            'name' => 'Form publish date',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'updated_at',
                                            'name' => 'Form last update date',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'deleted_at',
                                            'name' => 'Form deletion date',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'user_id',
                                            'name' => 'Form creator user ID',
                                            'type' => DataType::integer(),
                                        ],
                                        [
                                            'id'   => 'url',
                                            'name' => 'Form url',
                                            'type' => DataType::string(),
                                        ],
                                    ]
                                ),
                            ]
                        ),
                        new OutputDefinition(
                            [
                                'id'   => 'entry',
                                'name' => __('Entry object', 'mantiq'),
                                'type' => DataType::object(
                                    [
                                        [
                                            'id'   => 'id',
                                            'name' => 'Entry ID',
                                            'type' => DataType::integer(),
                                        ],
                                        [
                                            'id'   => 'uid',
                                            'name' => 'Entry UID',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'map',
                                            'name' => 'Entry fields (name → value)',
                                            'type' => DataType::map($outputs),
                                        ],
                                        [
                                            'id'   => 'html',
                                            'name' => 'Entry data as HTML table',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'text',
                                            'name' => 'Entry data as text',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'ip',
                                            'name' => 'Entry user IP',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'user_agent',
                                            'name' => 'Entry user browser',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'created_at',
                                            'name' => 'Form creation date',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'deleted_at',
                                            'name' => 'Form deletion date',
                                            'type' => DataType::string(),
                                        ],
                                        [
                                            'id'   => 'user_id',
                                            'name' => 'Entry user ID',
                                            'type' => DataType::integer(),
                                        ],
                                        [
                                            'id'   => 'url',
                                            'name' => 'Entry url',
                                            'type' => DataType::string(),
                                        ],
                                    ]
                                ),
                            ]
                        ),
                    ],
                ]
            );
        }

        return $forms;
    }

    public function handleStartupDefinition(StartupDefinition $startupDefinition)
    {
        add_action(
            'totalform/entry/created',
            static function (...$args) use ($startupDefinition) {
                if ($args[0]->form->uid === $startupDefinition['arguments.formId']) {
                    RunWorkflow::invoke(
                        GetWorkflow::invoke($startupDefinition['workflowUid']),
                        ExecutionArguments::fromForm($startupDefinition, [
                            'form'  => $args[0]->form->toArray(),
                            'entry' => $args[0]->entry->toArray() + [
                                    'text' => $args[0]->entry->toText(),
                                    'html' => $args[0]->entry->toHtml(),
                                    'map'  => $args[0]->entry->toMap(),
                                ],
                        ])
                    );
                }
            },
            $startupDefinition['arguments.hookPriority'] ?? 10,
            999
        );
    }
}
