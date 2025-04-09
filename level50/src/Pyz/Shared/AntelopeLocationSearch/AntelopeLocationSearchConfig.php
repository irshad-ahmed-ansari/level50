<?php

namespace Pyz\Shared\AntelopeLocationSearch;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class AntelopeLocationSearchConfig extends AbstractBundleConfig
{
    /**
     * Specification:
     * - Defines queue name as used for processing antelope publish messages.
     *
     * @api
     *
     * @var string
     */
    public const ANTELOPE_LOCATION_PUBLISH_SEARCH_QUEUE = 'publish.search.antelope.location';

    /**
     * Specification:
     * - Defines queue name as used for processing antelope sync messages.
     *
     * @api
     *
     * @var string
     */
    public const ANTELOPE_LOCATION_SYNC_SEARCH_QUEUE = 'sync.search.antelope.location';

    /**
     * Specification:
     * - Represents pyz_antelope entity creation event.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_PYZ_ANTELOPE_LOCATION_CREATE = 'Entity.pyz_antelope.location.create';

    /**
     * Specification:
     * - Represents pyz_antelope entity change event.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_PYZ_ANTELOPE_LOCAITON_UPDATE = 'Entity.pyz_antelope.location.update';

    /**
     * Specification:
     * - Represents pyz_antelope entity deletion event.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_PYZ_ANTELOPE_LOCAITON_DELETE = 'Entity.pyz_antelope.location.delete';

    /**
     * Specification:
     * - This event is used for antelope publishing.
     *
     * @api
     *
     * @var string
     */
    public const ANTELOPE_LOCAITON_PUBLISH = 'AntelopeSearch.antelope.location.publish';

    /**
     * Specification:
     * - This event is used for antelope unpublishing.
     *
     * @api
     */
    public const ANTELOPE_LOCAITON_UNPUBLISH = 'AntelopeSearch.antelope.location.unpublish';
}
