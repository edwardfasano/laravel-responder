<?php

namespace Flugg\Responder;

use Flugg\Responder\Contracts\Transformable;
use Illuminate\Database\Eloquent\Relations\Pivot;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract;

/**
 * An abstract base transformer. Yourr transformers should extend this, and this class
 * itself extends Fractal's transformer.
 *
 * @package Laravel Responder
 * @author  Alexander Tømmerås <flugged@gmail.com>
 * @license The MIT License
 */
abstract class Transformer extends TransformerAbstract
{
    /**
     * The transformable model associated with the transformer.
     *
     * @var Transformable
     */
    protected $model;

    /**
     * Constructor.
     *
     * @param Transformable|null $model
     */
    public function __construct( Transformable $model = null )
    {
        $this->model = $model;
    }

    /**
     * Get avilable includes.
     *
     * @return array
     */
    public function getAvailableIncludes()
    {
        return array_keys( $this->model->getRelations() );
    }

    /**
     * This method is fired to loop through available includes, see if any of
     * them are requested and permitted for this scope.
     *
     * @param  Scope $scope
     * @param  mixed $data
     * @return array
     */
    public function processIncludedResources( Scope $scope, $data )
    {
        $includedData = [ ];
        $includes = array_merge( $this->getDefaultIncludes(), $this->getAvailableIncludes() );

        foreach ( $includes as $include ) {
            $includedData = $this->includeResourceIfAvailable( $scope, $data, $includedData, $include );
        }

        return $includedData === [ ] ? false : $includedData;
    }

    /**
     * Include a resource only if it is available on the method.
     *
     * @param  Scope  $scope
     * @param  mixed  $data
     * @param  array  $includedData
     * @param  string $include
     * @return array
     */
    protected function includeResourceIfAvailable( Scope $scope, $data, $includedData, $include )
    {
        if ( $resource = $this->callIncludeMethod( $scope, $include, $data ) ) {
            $childScope = $scope->embedChildScope( $include, $resource );

            $includedData[ $include ] = $childScope->toArray();
        }

        return $includedData;
    }

    /**
     * Call Include Method.
     *
     * @param  Scope  $scope
     * @param  string $includeName
     * @param  mixed  $data
     * @return \League\Fractal\Resource\ResourceInterface|bool
     * @throws \Exception
     */
    protected function callIncludeMethod( Scope $scope, $includeName, $data )
    {
        if ( ! $data instanceof Transformable || ! $data->relationLoaded( $includeName ) ) {
            return false;
        }

        $relation = $data->$includeName;

        if ( $relation instanceof Pivot ) {
            return $this->includePivot( $relation );
        }

        return app( 'responder.success' )->transform( $relation );
    }

    /**
     * Include pivot table data to the response.
     *
     * @param  Pivot $pivot
     * @return \League\Fractal\Resource\ResourceInterface|bool
     */
    protected function includePivot( Pivot $pivot )
    {
        if ( method_exists( $this, 'transformPivot' ) ) {
            $data = $this->transformPivot( $pivot );

            return app( 'responder.success' )->transform( $pivot, function () use ( $data ) {
                return $data;
            } );
        }

        return false;
    }
}