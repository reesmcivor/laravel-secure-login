<?php

namespace ReesMcIvor\SecureLogin\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\ManyToManyCreationRules;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Hidden;
use App\Models\Exercise;
use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use ReesMcIvor\Labels\Nova\Labels;
use Whitecube\NovaFlexibleContent\Flexible;

class TrustedIp extends Resource
{

    public static $model = \ReesMcIvor\SecureLogin\Models\TrustedIp::class;
    public static $title = 'ip_address';
    public static $search = [
        'ip_address'
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('IP Address')->required(),
            Number::make('Attempts'),
            DateTime::make('Verified At'),
            DateTime::make('Notified At'),
            DateTime::make('Verified At')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
