<?php

namespace Marshmallow\TranslatedCom\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use App\Nova\TranslatedComOrder;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;

class TranslatedComConfirmation extends Resource
{
    public static $group = 'Translated.com';

    public static $priority = 20;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Confirmations');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Confirmation');
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Marshmallow\TranslatedCom\Models\Confirmation';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'pid';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'pid',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            BelongsTo::make(__('Order'), 'order', TranslatedComOrder::class),
            Text::make(__('Output format'), 'of'),
            Text::make(__('Function'), 'f')->hideFromIndex(),
            Boolean::make(__('Sandbox'), 'sandbox')->hideFromIndex(),
            Boolean::make(__('Confirm'), 'c')->hideFromIndex(),
            Boolean::make(__('Successfull'), 'code'),
            Text::make(__('Message'), 'message'),
            DateTime::make(__('Created at'), 'created_at'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
