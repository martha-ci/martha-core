<?php

namespace Martha\Core\Domain\Entity\Test\PHPUnit;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * Class AbstractEntityTest
 * @package Uss\Domain\Model\Test\PHPUnit\Entity
 */
abstract class AbstractEntityTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $testClass = null;

    /**
     * Automagically tests the get() and set() methods of the specified class using Reflection.
     *
     * This will look for all set*() methods in an object of $this->testClass, use Reflection to grab the DocBlock
     * comments of the method to try to figure out what type of argument to pass, then retrieve the value with a
     * corresponding get*() method and assert that the passed and retrieved values are equal.
     *
     * Some caveats:
     *      1) The set method must have the params properly defined with the correct type of the argument, and, if
     *         the argument is a class, a fully qualified namespace (e.g. param \Uss\Domain\Model\User $user).
     *      2) This will only work on set*() methods that accept one argument. All other arguments will be ignored.
     *         Currently, none of the entities have more than one argument for any of their setters. This code will
     *         have to be tweaked if that ever changes.
     *      3) We currently do not support getter/setter testing for a property that is an array.  Currently we only
     *         use Doctrine's ArrayCollection, so it is not an issue.  If an array is used in the future, a new
     *         type will have to be added to the generateValue function.
     *
     * Overriding a test:
     *      If an inherited test class has a method named "testSet[PropertyName]" defined, this code will not test the
     *      setter (or getter) for PropertyName.
     */
    public function testGettersAndSetters()
    {
        if (!isset($this->testClass)) {
            $this->markTestIncomplete('No testClass specified');
            return;
        }

        $object = new $this->testClass();
        $class = new ReflectionClass($object);

        $reflectionTest = new ReflectionClass($this);

        $methods = $class->getMethods();

        foreach ($methods as $method) {
            if (substr($method->name, 0, 3) == 'set') {
                if ($reflectionTest->hasMethod('test' . $method->getName())) {
                    continue;
                }

                $methodName = substr($method->name, 3);
                $annotations = $method->getDocComment();

                if (preg_match_all('/\@param (.*) (.*)( (.*)|)/', $annotations, $matches) > 0) {
                    if (isset($matches[1])) {
                        $types = explode('|', current($matches[1]));
                        foreach ($types as $type) {
                            if ($type == 'null') {
                                continue;
                            }

                            if (class_exists($type, true) ||
                                class_exists($class->getNamespaceName() . '\\' . $type, true)) {
                                $value = new $type();
                            } else {
                                $value = $this->generateValue($type);
                            }

                            call_user_func(array($object, 'set' . $methodName), $value);
                            $result = call_user_func(array($object, 'get' . $methodName));
                            $this->assertNotNull(
                                $value,
                                'Getter/Setter test used null value for $' . lcfirst($methodName) .
                                ' in ' . get_class($this)
                            );
                            $this->assertEquals(
                                $value,
                                $result,
                                'Getter/Setter test failed for $' . lcfirst($methodName) . ' in ' . get_class($this)
                            );
                        }
                    }
                } else {
                    $this->markTestIncomplete(
                        '@param is not set for$' . lcfirst($methodName) .
                        ' in ' . get_class($this)
                    );
                }
            }
        }
    }

    /**
     * Generates a value of a requested data type.
     *
     * @param string $type
     * @return mixed
     */
    protected function generateValue($type)
    {
        switch ($type) {
            case 'boolean':
                $value = true;
                break;
            case 'int':
            case 'integer':
                $value = 42;
                break;
            case 'float':
                $value = 20.33;
                break;
            case 'string':
                $value = 'A test string';
                break;
            default:
                // let the test case fail
                $value = null;
        }

        return $value;
    }
}
