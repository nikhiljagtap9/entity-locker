<?php

if (!function_exists('arrayToXml')) {
    function arrayToXml(array $data, \SimpleXMLElement $xml)
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item'; // Default tag name for numeric keys
            }

            if ($key === '@attributes') {
                // Add attributes directly to the current XML element
                foreach ($value as $attrKey => $attrValue) {
                    $xml->addAttribute($attrKey, $attrValue);
                }
            } elseif (is_array($value)) {
                if (isset($value['@attributes'])) {
                    $subnode = $xml->addChild($key);
                    // Add attributes
                    foreach ($value['@attributes'] as $attrKey => $attrValue) {
                        $subnode->addAttribute($attrKey, $attrValue);
                    }
                    // Add value if it exists
                    if (isset($value['@value'])) {
                        $subnode[0] = $value['@value'];
                    }
                    // Recursively process child elements
                    $children = array_filter($value, function ($k) {
                        return $k !== '@attributes' && $k !== '@value';
                    }, ARRAY_FILTER_USE_KEY);
                    arrayToXml($children, $subnode);
                } else {
                    // Add nested elements
                    $subnode = $xml->addChild($key);
                    arrayToXml($value, $subnode);
                }
            } else {
                // Add simple elements
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
        return $xml;
    }

}
