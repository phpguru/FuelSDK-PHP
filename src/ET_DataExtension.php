<?php

namespace FuelSdk;

/**
 * ETDataExtension - Represents a data extension within an account.
 */
class ET_DataExtension extends ET_CUDSupport
{
    /**
     * @var ET_DataExtension_Column[]      Gets or sets array of DE columns.
     */
    public $columns;

    /**
     * Initializes a new instance of the class.
     */
    function __construct()
    {
        $this->obj = "DataExtension";
    }

    /**
     * Post this instance.
     * @return ET_Post     Object of type ET_Post which contains http status code, response, etc from the POST SOAP service
     */
    public function post($upsert = false, $debug = false)
    {
        $originalProps = $this->props;
        if (ET_Util::isAssoc($this->props)) {
            $this->props["Fields"] = ["Field" => []];
            if (!is_null($this->columns) && is_array($this->columns)) {
                foreach ($this->columns as $column) {
                    array_push($this->props['Fields']['Field'], $column);
                }
            }
        } else {
            $newProps = [];
            foreach ($this->props as $DE) {
                $newDE = $DE;
                $newDE["Fields"] = ["Field" => []];
                if (!is_null($DE['columns']) && is_array($DE['columns'])) {
                    foreach ($DE['columns'] as $column) {
                        array_push($newDE['Fields']['Field'], $column);
                    }
                }
                array_push($newProps, $newDE);
            }
            $this->props = $newProps;
        }

        $response = parent::post($upsert, $debug);

        $this->props = $originalProps;
        return $response;
    }

    /**
     * Patch this instance.
     * @param bool $upsert
     * @return ET_Patch     Object of type ET_Patch which contains http status code, response, etc from the PATCH SOAP service
     */
    public function patch($upsert = false)
    {
        $this->props["Fields"] = ["Field" => []];
        foreach ($this->columns as $column) {
            array_push($this->props['Fields']['Field'], $column);
        }
        $response = parent::patch();
        unset($this->props["Fields"]);
        return $response;
    }
}
