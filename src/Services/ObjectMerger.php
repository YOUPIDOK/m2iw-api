<?php

namespace App\Services;

class ObjectMerger
{
    public function merge($object1, $object2)
    {
        if ($object1 === null) {
            return $object2;
        } elseif ($object2 === null) {
            return $object1;
        }

        $objectReflection = new \ReflectionClass($object2);

        foreach ($objectReflection->getProperties() as $property) {
            $propertyName = $property->getName();
            $setterMethod = 'set' . ucfirst($propertyName);
            $setterMethod = $this->toCamelCase($setterMethod);

            if (method_exists($object2, $setterMethod)) {
                $propertyValue1 = $property->getValue($object1);
                $propertyValue2 = $property->getValue($object2);

                if (!$property->getType()->isBuiltin()) {
                    $mergedValue = $this->merge($propertyValue1, $propertyValue2);
                } else {
                    $mergedValue = $propertyValue2;
                }

                $object1->{$setterMethod}($mergedValue);
            }
        }

        foreach ()

        return $object1;
    }

    private function toCamelCase($str): string
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
        $str = lcfirst($str);
        return $str;
    }
}
