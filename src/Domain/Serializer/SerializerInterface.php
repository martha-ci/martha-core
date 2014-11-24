<?php

namespace Martha\Core\Domain\Serializer;

/**
 * Class SerializerInterface
 * @package Martha\Core\Domain
 */
interface SerializerInterface
{
    /**
     * @param mixed $data
     * @param string $type
     * @return mixed
     */
    public function serialize($data, $type);
}
