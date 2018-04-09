<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler\Tests\Faker;

use CCT\Component\RestExceptionHandler\Request\Exception\ApiGatewayException;

class FakeObject
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function thowException()
    {
        throw new \RuntimeException('Example of exception');
    }

}
