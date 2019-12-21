<?php

namespace StephaneCoinon\Turbine\Tests;

use StephaneCoinon\Turbine\ApiModel;
use StephaneCoinon\Turbine\Tests\TestCase;

class ApiModelTest extends TestCase
{
    /** @test */
    function get_an_attribute_like_an_instance_property()
    {
        $model = new ApiModel(['name' => 'John']);

        $this->assertEquals('John', $model->name);
    }

    /** @test */
    function get_an_unexisting_attribute_like_an_instance_property_returns_null()
    {
        $model = new ApiModel(['name' => 'John']);

        $this->assertNull($model->age);
    }

    /** @test */
    function set_an_existing_attribute_like_an_instance_property()
    {
        $model = new ApiModel(['count' => 1]);

        $model->count++;

        $this->assertEquals(2, $model->count);
        $this->assertSame(
            [],
            array_keys(get_object_vars($model)),
            '$count should not have been set as a property on the model instance'
        );
        $this->assertEquals(2, $model->getAttribute('count'));
    }

    /** @test */
    function check_whether_an_attribute_exists()
    {
        $model = new ApiModel(['name' => 'John']);

        $this->assertTrue($model->hasAttribute('name'));
        $this->assertTrue(isset($model->name));

        $this->assertFalse($model->hasAttribute('age'));
        $this->assertFalse(isset($model->age));
    }
}
