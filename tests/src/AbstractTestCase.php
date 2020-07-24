<?php


namespace Test;


use PHPUnit\Framework\TestCase;

/**
 * This class should use setup and teardown to wrap DB operations and nested DB transactions in a 0-level transaction.
 * This is so we can have auto-rollback of the DB after each test, and the ability to override this behaviour as needed in subclasses.
 * Class AbstractTestCase
 * @package Test
 */
class AbstractTestCase extends TestCase
{

}