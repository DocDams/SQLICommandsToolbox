<?php

namespace SQLI\CommandsToolboxBundle\QueryType;

use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\Core\QueryType\QueryType;

class ChildrenQueryType implements QueryType
{
    public function getQuery( array $parameters = [] )
    {
        $criteria = [
            new Query\Criterion\Visibility( Query\Criterion\Visibility::VISIBLE ),
        ];

        if( !empty( $parameters['parent_location_id'] ) )
        {
            $criteria[] = new Query\Criterion\ParentLocationId( $parameters['parent_location_id'] );
        }
        else
        {
            $criteria[] = new Query\Criterion\MatchNone();
        }

        if( !empty( $parameters['included_content_type_identifier'] ) )
        {
            $criteria[] = new Query\Criterion\ContentTypeIdentifier( $parameters['included_content_type_identifier'] );
        }

        return new LocationQuery(
            [
                'filter'      => new Query\Criterion\LogicalAnd( $criteria ),
                'sortClauses' => [
                    new Query\SortClause\Location\Priority(),
                    new Query\SortClause\DatePublished( Query::SORT_DESC )
                ]
            ]
        );
    }

    public static function getName()
    {
        return 'SQLI:LocationChildren';
    }

    public function getSupportedParameters()
    {
        return [
            'parent_location_id',
            'included_content_type_identifier',
        ];
    }
}
