<?php

namespace App\Services;

use ReflectionProperty;

class ObjectMerger
{
    public static function mergeData($entity, $data, array $exclude = []) {
        foreach ($data as $propertyName => $propertyValue) {
            if (!in_array($propertyName, $exclude)) {
                if (is_array($propertyValue)) {
                   self::mergeData($entity->$propertyName, $propertyValue);
                } else {
                    $reflectionProperty = new ReflectionProperty(get_class($entity), $propertyName);
                    $reflectionProperty->setAccessible(true);
                    $reflectionProperty->setValue($entity, $propertyValue);
                }
            }
        }
    }
}
