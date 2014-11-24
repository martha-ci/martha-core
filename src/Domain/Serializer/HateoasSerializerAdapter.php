<?php

namespace Martha\Core\Domain\Serializer;

/**
 * Class HalSerializer
 * @package Martha\Core\Domain\Serializer
 */
class HateoasSerializerAdapter implements SerializerInterface
{
    protected $hateoas;

    public function __construct($hateoas)
    {
        $this->hateoas = $hateoas;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize($data, $type)
    {
        return $this->hateoas->serialize($data, $type);
    }
}
