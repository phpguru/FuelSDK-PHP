<?php

namespace FuelSdk;

/**
 * Represents an asset associated with a campaign.
 */
class ET_Campaign_Asset extends ET_CUDSupportRest
{
    /**
     * Initializes a new instance of the class and will assign endpoint, urlProps, urlPropsRequired fields of parent ET_BaseObjectRest
     */
    function __construct()
    {
        $this->endpoint = "https://www.exacttargetapis.com/hub/v1/campaigns/{id}/assets/{assetId}";
        $this->urlProps = [
            "id",
            "assetId",
        ];
        $this->urlPropsRequired = ["id"];
    }
}
