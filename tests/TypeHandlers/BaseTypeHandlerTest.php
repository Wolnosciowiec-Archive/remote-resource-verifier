<?php

namespace Tests\TypeHandlers;

use Monolog\Handler\HandlerInterface;
use Tests\Functional\BaseTestCase;

abstract class BaseTypeHandlerTest extends BaseTestCase
{
    /**
     * @return HandlerInterface
     */
    abstract protected function getHandlerInstance();

    /**
     * @return array
     */
    abstract public function provideUrls(): array;

    /**
     * @return array
     */
    abstract public function provideValidationLinks(): array;

    /**
     * @dataProvider provideUrls
     *
     * @param string $url
     * @param bool $isValid
     *
     * @see UrlHandler::isAbleToHandle()
     */
    public function testIsAbleToHandle($url, $isValid)
    {
        $this->assertSame($isValid, $this->getHandlerInstance()->isAbleToHandle($url));
    }

    /**
     * @dataProvider provideValidationLinks
     *
     * @param string $url
     * @param bool   $isValid
     */
    public function testIsValid($url, $isValid)
    {
        $this->assertSame($isValid, $this->getHandlerInstance()->isValid($url));
    }
}