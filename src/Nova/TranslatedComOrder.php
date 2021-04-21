<?php

namespace Marshmallow\TranslatedCom\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Marshmallow\TranslatedCom\Nova\Filters\ConfirmedFilter;
use Marshmallow\TranslatedCom\Nova\Actions\ConfirmOrderAction;

class TranslatedComOrder extends Resource
{
    public static $group = 'Translated.com';

    public static $priority = 10;

    public static $group_icon = '<svg class="sidebar-icon" width="40px" height="40px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" strokewidth="1" class="icon__fill" fill-rule="evenodd" transform="translate(0, -4.000000)"><path fill="var(--sidebar-icon)" d="M19.6861268,6.76916917 C10.3528305,6.7799807 2.78940436,14.3178548 2.77855618,23.6196196 C2.77855618,32.9258664 10.3483334,40.4700701 19.6861268,40.4700701 C29.0239202,40.4700701 36.5936974,32.9258664 36.5936974,23.6196196 C36.5936974,14.3133728 29.0239202,6.76916917 19.6861268,6.76916917 Z M19.6861268,4 C30.5584744,4 39.3722536,12.7840029 39.3722536,23.6196196 C39.3722536,34.4552363 30.5584744,43.2392392 19.6861268,43.2392392 C8.81377919,43.2392392 -1.99826206e-15,34.4552363 0,23.6196196 C3.99652411e-15,12.7840029 8.81377919,4 19.6861268,4 Z M24.4417326,31.8570571 C23.4457424,32.5900935 22.231411,32.9681666 20.9938481,32.9305305 C19.2277213,32.9305305 17.8750031,32.3531532 17.0734965,31.0890891 C16.5785311,30.3463463 16.3844821,29.4662663 16.3844821,28.0620621 L16.3844821,20.4944945 L12.8437916,20.4944945 L12.8437916,18.1625626 L16.3844821,18.1625626 L16.3844821,14.2834835 L19.447081,14.2834835 L19.447081,28.1041041 C19.447081,29.5615616 20.1360954,30.2482482 21.4156937,30.2482482 C22.076794,30.2519909 22.7191344,30.029366 23.2352542,29.6176176 L24.4417326,31.8570571 Z M23.0271438,19.3005005 C23.0233997,18.8269825 23.2085586,18.3713778 23.5418844,18.0339218 C23.8752102,17.6964658 24.3293964,17.5048033 24.8045198,17.5011011 L24.8607659,17.5011011 C25.3358892,17.5048033 25.7900754,17.6964658 26.1234012,18.0339218 C26.4567271,18.3713778 26.6418859,18.8269825 26.6381419,19.3005005 C26.6443783,20.2854628 25.8490564,21.0893853 24.8607659,21.0970971 L24.8045198,21.0970971 C23.8162292,21.0893853 23.0209074,20.2854628 23.0271438,19.3005005 Z" id="Combined-Shape"></path></g></svg>';

    /**
     * Get the logical group associated with the resource.
     *
     * @return string
     */
    public static function group()
    {
        return __('Translated');
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Orders');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Order');
    }

    public function authorizedToUpdate(Request $request)
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
    public static $model = 'Marshmallow\TranslatedCom\Models\Order';

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
        'pid', 'text',
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
            MorphTo::make(__('Model'), 'model')->types(config('translated-com.morphables')),
            Text::make(__('Column'), 'column'),
            Text::make(__('ID'), 'pid'),
            Number::make(__('Words'), 'words'),
            Currency::make(__('Total'), 'total'),
            BelongsTo::make(__('Confirmed by'), 'confirmedBy', config('translated-com.resources.user')),
            DateTime::make(__('Confirmed at'), 'confirmed_at'),

            /**
             * Not in index
             */
            Code::make(__('Flex'), 'flex')->json()->hideFromIndex(),
            Text::make(__('Source language'), 's')->hideFromIndex(),
            Text::make(__('Target language'), 't')->hideFromIndex(),
            Text::make(__('Output format'), 'of')->hideFromIndex(),
            Text::make(__('Function'), 'f')->hideFromIndex(),
            Boolean::make(__('Sandbox'), 'sandbox')->hideFromIndex(),
            Text::make(__('Text'), 'text')->hideFromIndex(),
            Text::make(__('Project name'), 'pn')->hideFromIndex(),
            Select::make(__('Job Types'), 'jt')->options([
                't' => 'Professional',
                'r' => 'Premium',
                'p' => 'Economy',
            ])->hideFromIndex(),
            Text::make(__('Number of words'), 'w')->hideFromIndex(),
            Text::make(__('Data format'), 'df')->hideFromIndex(),
            Text::make(__('Translation memory'), 'tm')->hideFromIndex(),
            Text::make(__('Endpoint'), 'endpoint')->hideFromIndex(),
            Text::make(__('Subject'), 'subject')->hideFromIndex(),
            Text::make(__('Instructions'), 'instructions')->hideFromIndex(),
            Text::make(__('Code'), 'code')->hideFromIndex(),
            Text::make(__('Message'), 'message')->hideFromIndex(),
            DateTime::make(__('Delivery date'), 'delivery_date')->hideFromIndex(),

            HasMany::make(__('Confirmations'), 'confirmations', config('translated-com.resources.confirmation')),
            HasMany::make(__('Translations'), 'translations', config('translated-com.resources.result')),
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
        return [
            new ConfirmedFilter,
        ];
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
        return [
            (new ConfirmOrderAction)->canRun(function () {
                return true;
            }),
        ];
    }
}
