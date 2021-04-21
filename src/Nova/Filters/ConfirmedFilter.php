<?php

namespace Marshmallow\TranslatedCom\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class ConfirmedFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed                                 $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        switch ($value) {
            case 'confirmed':
                $query->whereNotNull('confirmed_at');
                break;
            case 'not-confirmed':
                $query->whereNull('confirmed_at');
                break;
        }
        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Confirmed' => 'confirmed',
            'Not confirmed' => 'not-confirmed',
        ];
    }
}
