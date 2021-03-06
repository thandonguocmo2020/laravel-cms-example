<?php

use Czim\CmsModels\Support\Enums;
use Czim\CmsModels\Http\Controllers\FormFieldStrategies as FormFieldStoreStrategies;
use Czim\CmsModels\Repositories\SortStrategies;
use Czim\CmsModels\Support\Exporting\Strategies as ExportStrategies;
use Czim\CmsModels\Support\Exporting\ColumnStrategies as ExportColumnStrategies;
use Czim\CmsModels\View\ActionStrategies;
use Czim\CmsModels\View\FilterStrategies;
use Czim\CmsModels\View\FormFieldStrategies;
use Czim\CmsModels\View\ListStrategies;
use Czim\CmsModels\View\ReferenceStrategies;

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Which models to analyze and include model information for.
    |
    */

    'models' => [
        \App\Models\Brand::class,
        \App\Models\Category::class,
        \App\Models\Product::class,
        \App\Models\Variant::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    |
    | The base route prefix to prepend for all CMS model module routes.
    |
    */

    'route' => [

        'prefix'      => 'model',
        'name-prefix' => 'models.',

        'meta' => [
            'prefix'      => 'models-meta',
            'name-prefix' => 'models-meta.',
        ],

        // Meta-information endpoint(s) for modelinformation
        'api' => [
            'meta' => [
                'information' => 'models',
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Defaults
    |--------------------------------------------------------------------------
    |
    | Some defaults that the CMS will fall back to if no specific
    | value is set in a model configuration.
    |
    */

    'defaults' => [

        // Whether to ask a user to provide extra confirmation before deleting models.
        'confirm_delete' => false,

    ],

    /*
    |--------------------------------------------------------------------------
    | Repository
    |--------------------------------------------------------------------------
    |
    | Settings that concern the behaviour of the model information repository.
    |
    */

    'repository' => [

        // Whether the mode information should be cached
        'cache' => false,

    ],

    /*
    |--------------------------------------------------------------------------
    | Collector
    |--------------------------------------------------------------------------
    |
    | Model information is collected by a dedicated class defined here.
    |
    */

    'collector' => [

        // The main collector that will be bound to the collector interface
        'class' => Czim\CmsModels\Repositories\Collectors\ModelInformationCollector::class,

        'source' => [

            // The directory that contains the model representations
            'dir' => app_path('Cms/Models'),

            // The base directory that contains the application's models,
            // and the corresponding namespace
            'models-dir'       => app_path('Models'),
            'models-namespace' => 'App\\Models\\',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Analyzer
    |--------------------------------------------------------------------------
    |
    | Settings for the analyzer that builds model information based on
    | Eloquent models.
    |
    */

    'analyzer' => [

        'reference' => [

            // Default attributes to look for when automatically picking a reference source for a model.
            // The first attribute in this list that matches is used.
            'sources' => [
                'name',
                'title',
                'label',
                'code',
                'slug',
                'last_name',
                'surname',
                'handle',
            ],
        ],

        'attributes' => [
        ],

        'filters' => [

            // Whether to create a single search-for-any string filter, instead of separate filters
            'single-any-string' => true,

            // The filter key to use for a combined any-string filter
            'any-string-key' => 'any',
        ],

        'scopes' => [

            // Scopes (without the scope prefix) to always ignore
            'ignore' => [
                // translatable
                'translatedIn',
                'notTranslatedIn',
                'translated',
                'listsTranslations',
                'withTranslation',
                'whereTranslation',
                'whereTranslationLike',
                // listify
                'name',
                'listifyScope',
                'inList',
                // taggable
                'withAllTags',
                'withAnyTag',
                // sluggable
                'findSimilarSlugs',
            ],
        ],

        'relations' => [

            // Relations to always ignore
            'ignore' => [
                'translations',
            ],
        ],

        'traits' => [
            // Trait FQNs for translated models
            'translatable' => [
                'Dimsav\Translatable\Translatable',
            ],

            // Trait FQNs for translated models
            'listify' => [
                'Czim\Listify\Listify',
                'Lookitsatravis\Listify\Listify',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Controllers
    |--------------------------------------------------------------------------
    |
    | The controllers that handle the model routes for web and API requests.
    |
    */

    'controllers' => [
        'models' => [
            'web' => Czim\CmsModels\Http\Controllers\DefaultModelController::class,
            'api' => Czim\CmsModels\Http\Controllers\Api\DefaultModelController::class,
        ],
        'meta' => [
            'web' => Czim\CmsModels\Http\Controllers\ModelMetaController::class,
            'api' => Czim\CmsModels\Http\Controllers\Api\ModelMetaController::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Strategies
    |--------------------------------------------------------------------------
    |
    | Strategies for displaying list and form field content.
    |
    */

    'strategies' => [

        // Strategies for default context/criteria on the repository
        'repository' => [

            // The default namespace to prefix for relative strategy class names
            'default-namespace' => 'Czim\\CmsModels\\Repositories\\ContextStrategies\\',
            'default-strategy'  => null,

            // Aliases for repository context strategy classes
            'aliases' => [
            ],
        ],

        // Strategies for making model reference strings
        'reference' => [

            // The default namespace to prefix for relative strategy class names
            'default-namespace' => 'Czim\\CmsModels\\View\\ReferenceStrategies\\',
            'default-strategy'  => ReferenceStrategies\IdAndAttribute::class,

            // Aliases for reference display strategy classes
            'aliases' => [
                'default'          => ReferenceStrategies\DefaultReference::class,
                'id-and-attribute' => ReferenceStrategies\IdAndAttribute::class,
            ],
        ],

        'list' => [

            // The default page size and selectable page size options
            'page-size'         => 25,
            'page-size-options' => [ 25, 50, 100 ],

            // The default namespace to prefix for relative strategy class names
            'default-namespace' => 'Czim\\CmsModels\\View\\ListStrategies\\',
            'default-strategy'  => ListStrategies\DefaultStrategy::class,

            // The default strategy for sorting columns
            'default-sort-namespace' => 'Czim\\CmsModels\\Repositories\\SortStrategies\\',
            'default-sort-strategy'  => SortStrategies\NullLast::class,

            // The default strategy namespace for action links
            'default-action-namespace' => 'Czim\\CmsModels\\View\\ActionStrategies\\',

            // Aliases for list display strategy classes
            'aliases' => [
                Enums\ListDisplayStrategy::CHECK                   => 'Check',
                Enums\ListDisplayStrategy::CHECK_NULLABLE          => 'CheckNullable',
                Enums\ListDisplayStrategy::DATE                    => 'Date',
                Enums\ListDisplayStrategy::TIME                    => 'Time',
                Enums\ListDisplayStrategy::DATETIME                => 'DateTime',
                Enums\ListDisplayStrategy::STAPLER_THUMBNAIL       => 'StaplerImage',
                Enums\ListDisplayStrategy::STAPLER_FILENAME        => 'StaplerFile',
                Enums\ListDisplayStrategy::RELATION_COUNT          => 'RelationCount',
                Enums\ListDisplayStrategy::RELATION_REFERENCE      => 'RelationReference',
                Enums\ListDisplayStrategy::RELATION_REFERENCE_LINK => 'RelationReferenceLink',
                Enums\ListDisplayStrategy::RELATION_COUNT_LINK     => 'RelationCountChildrenLink',
                Enums\ListDisplayStrategy::TAGS                    => 'TagList',
            ],

            // Aliases for sort strategy classes
            'sort-aliases' => [
                'null-last'  => SortStrategies\NullLast::class,
                'translated' => SortStrategies\TranslatedAttribute::class,
            ],

            // Aliases for action link strategy classes
            'action-aliases' => [
                Enums\ActionReferenceType::EDIT     => ActionStrategies\EditStrategy::class,
                Enums\ActionReferenceType::SHOW     => ActionStrategies\ShowStrategy::class,
                Enums\ActionReferenceType::CHILDREN => ActionStrategies\ChildrenStrategy::class,
            ],
        ],

        'filter' => [

            // The default namespace to prefix for relative strategy class names
            'default-namespace' => 'Czim\\CmsModels\\View\\FilterStrategies\\',

            // Aliases for filter strategy classes
            'aliases' => [
                Enums\FilterStrategy::BOOLEAN      => FilterStrategies\DropdownBoolean::class,
                Enums\FilterStrategy::DATE         => FilterStrategies\Datepicker::class,
                Enums\FilterStrategy::DROPDOWN     => FilterStrategies\DropdownEnum::class,
                Enums\FilterStrategy::STRING       => FilterStrategies\BasicString::class,
                Enums\FilterStrategy::STRING_SPLIT => FilterStrategies\BasicSplitString::class,
            ],
        ],

        'form' => [

            // The default namespace to prefix for relative form field display strategy class names
            'default-namespace' => 'Czim\\CmsModels\\View\\FormFieldStrategies\\',
            'default-strategy'  => FormFieldStrategies\DefaultStrategy::class,

            // The default strategy for storing/retrieving values from models
            'default-store-namespace' => 'Czim\\CmsModels\\Http\\Controllers\\FormFieldStrategies\\',
            'default-store-strategy'  => FormFieldStoreStrategies\DefaultStrategy::class,

            // Aliases for field display strategy classes
            'aliases' => [
                Enums\FormDisplayStrategy::TEXT             => 'DefaultStrategy',
                Enums\FormDisplayStrategy::BOOLEAN_CHECKBOX => 'BooleanCheckboxStrategy',
                Enums\FormDisplayStrategy::BOOLEAN_DROPDOWN => 'BooleanDropdownStrategy',
                Enums\FormDisplayStrategy::TEXTAREA         => 'TextAreaStrategy',
                Enums\FormDisplayStrategy::WYSIWYG          => 'WysiwygStrategy',
                Enums\FormDisplayStrategy::DROPDOWN         => 'DropdownStrategy',

                Enums\FormDisplayStrategy::STATIC_FIELD     => 'StaticStrategy',

                Enums\FormDisplayStrategy::DATEPICKER_DATETIME => 'DateTimeStrategy',
                Enums\FormDisplayStrategy::DATEPICKER_DATE     => 'DateStrategy',
                Enums\FormDisplayStrategy::DATEPICKER_TIME     => 'TimeStrategy',
                Enums\FormDisplayStrategy::DATEPICKER_RANGE    => 'DateRangeStrategy',
                Enums\FormDisplayStrategy::COLORPICKER         => 'ColorStrategy',
                Enums\FormDisplayStrategy::LOCATIONPICKER      => 'LocationStrategy',
                Enums\FormDisplayStrategy::TAGGABLE            => 'TaggableAutocompleteStrategy',

                Enums\FormDisplayStrategy::ATTACHMENT_STAPLER_IMAGE => 'AttachmentStaplerImageStrategy',
                Enums\FormDisplayStrategy::ATTACHMENT_STAPLER_FILE  => 'AttachmentStaplerFileStrategy',

                Enums\FormDisplayStrategy::RELATION_SINGLE_DROPDOWN     => 'RelationSingleDropdownStrategy',
                Enums\FormDisplayStrategy::RELATION_SINGLE_AUTOCOMPLETE => 'RelationSingleAutocompleteStrategy',
                Enums\FormDisplayStrategy::RELATION_PLURAL_MULTISELECT  => 'RelationPluralMultiselectStrategy',
                Enums\FormDisplayStrategy::RELATION_PLURAL_AUTOCOMPLETE => 'RelationPluralAutocompleteStrategy',
                Enums\FormDisplayStrategy::RELATION_PIVOT_ORDERABLE     => 'RelationPivotOrderableStrategy',

                Enums\FormDisplayStrategy::RELATION_SINGLE_MORPH_DROPDOWN     => 'RelationSingleMorphDropdownStrategy',
                Enums\FormDisplayStrategy::RELATION_SINGLE_MORPH_AUTOCOMPLETE => 'RelationSingleMorphAutocompleteStrategy',
            ],

            // Aliases for store strategy classes
            'store-aliases' => [
                Enums\FormStoreStrategy::BOOLEAN                => 'BooleanStrategy',
                Enums\FormStoreStrategy::DATE                   => 'DateStrategy',
                Enums\FormStoreStrategy::DATE_RANGE             => 'DateRangeStrategy',
                Enums\FormStoreStrategy::LOCATION_FIELDS        => 'LocationFieldsStrategy',
                Enums\FormStoreStrategy::STAPLER                => 'StaplerStrategy',
                Enums\FormStoreStrategy::TAGGABLE               => 'TaggableStrategy',
                Enums\FormStoreStrategy::RELATION_SINGLE_KEY    => 'RelationSingleKey',
                Enums\FormStoreStrategy::RELATION_PLURAL_KEYS   => 'RelationPluralKeys',
                Enums\FormStoreStrategy::RELATION_PIVOT_ORDERED => 'RelationPivotOrdered',
                Enums\FormStoreStrategy::RELATION_SINGLE_MORPH  => 'RelationSingleMorph',
            ],

        ],

        'show' => [

            // The default namespace to prefix for relative strategy class names
            'default-namespace' => 'Czim\\CmsModels\\View\\ListStrategies\\',
            'default-strategy'  => ListStrategies\DefaultStrategy::class,

            // Aliases for show field display strategy classes
            // If no match is found, falls back to list.aliases
            'aliases' => [
            ],
        ],

        'delete' => [

            // The default namespace to prefix for relative strategy class names
            'default-namespace' => 'Czim\\CmsModels\\Repositories\\DeleteStrategies\\',

            // Aliases for delete strategy classes
            'aliases' => [
            ],

            // The default namespace to prefix for relative strategy class names
            'default-condition-namespace' => 'Czim\\CmsModels\\Repositories\\DeleteConditionStrategies\\',

            // Aliases for delete condition strategy classes
            'condition-aliases' => [
            ],
        ],

        'export' => [

            // The default namespace to prefix for relative strategy class names
            'default-namespace' => 'Czim\\CmsModels\\Support\\Exporting\\Strategies\\',

            // The default namespace to prefix for relative strategy class names
            'default-column-namespace' => 'Czim\\CmsModels\\Support\\Exporting\\ColumnStrategies\\',
            'default-column-strategy'  => ExportColumnStrategies\DefaultStrategy::class,

            // Aliases for exporter strategy classes
            'aliases' => [
                Enums\ExportStrategy::CSV   => ExportStrategies\CsvExportStrategy::class,
                Enums\ExportStrategy::XML   => ExportStrategies\XmlExportStrategy::class,
                Enums\ExportStrategy::EXCEL => ExportStrategies\ExcelExportStrategy::class,
            ],

            // Aliases for export column strategy classes
            'column-aliases' => [
                Enums\ExportColumnStrategy::BOOLEAN_STRING    => 'BooleanStringStrategy',
                Enums\ExportColumnStrategy::DATE              => 'DateStrategy',
                Enums\ExportColumnStrategy::STAPLER_FILE_LINK => 'StaplerFileLinkStrategy',
                Enums\ExportColumnStrategy::TAG_LIST          => 'TagListStrategy',
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Model References
    |--------------------------------------------------------------------------
    |
    | Model reference handling, mainly for relation dropdown filling and
    | searching/sorting for autocomplete lookups.
    |
    */

    'meta-references' => [

        // The default filter strategy to use for model meta reference lookups
        'filter-strategy' => FilterStrategies\BasicSplitString::class,

        // The default sorting strategy to use for model meta references
        'sort-strategy' => SortStrategies\ReferenceResolvingRelay::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    |
    | Default views to use for viewing and editing models.
    |
    */

    'views' => [
        'index'  => 'cms-models::model.index',
        'create' => 'cms-models::model.edit',
        'edit'   => 'cms-models::model.edit',
        'show'   => 'cms-models::model.show',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification & Flash Messages
    |--------------------------------------------------------------------------
    |
    | Settings for handling notifications and flash messages for model updates.
    |
    */

    'notifications' => [

        // Whether to flash for specific types of updates
        'flash' => [
            'position' => true,
            'activate' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | WYSIWYG / CKEditor Configuration
    |--------------------------------------------------------------------------
    |
    | The default behavior for the 'wysiwyg' form display strategy's
    | use of CKEditor may be configured here.
    |
    */

    'ckeditor' => [

        // Base path for configuration files, relative to the public/ path.
        'path' => '_cms/js/ckeditor/config',

        // Default configuration file to use, relative to the base path
        'config' => 'default.js',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Keys
    |--------------------------------------------------------------------------
    |
    | Third party service API keys.
    |
    */

    'api-keys' => [

        'google-maps' => env('GOOGLE_MAPS_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Strategy Settings
    |--------------------------------------------------------------------------
    |
    | Settings for custom form, list and other strategies.
    |
    */

    'custom-strategies' => [

        'location' => [
            'default' => [
                'location'  => '2312 HZ Leiden, Netherlands',
                'latitude'  => 52.1601144,
                'longitude' => 4.497009700000035,
            ]
        ],

    ],

];
