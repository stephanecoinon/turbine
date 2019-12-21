<?php

namespace StephaneCoinon\Turbine;

class ApiModel
{
    /**
     * Attributes on the model.
     *
     * Array keys are the attribute names.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Instantiate a new Model with its attributes.
     *
     * @param  array  $attributes
     */
    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the model attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get one model attribute value by name.
     *
     * @param  string  $name
     * @return null|mixed  null is returned when attribute named $name cannot be found
     */
    public function getAttribute($name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Set the value of one attribute on the model.
     *
     * @param  string  $name
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Does the model have the given attribute name?
     *
     * @param  string  $name
     * @return boolean
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Get the value of a model attribute like an instance property.
     *
     * @param  string  $name
     * @return null|mixed
     *
     * @see getAttribute()
     */
    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    /**
     * Set the value of an attribute on the model like an instance property.
     *
     * @param  string  $name
     * @param  mixed  $value
     *
     * @see setAttribute()
     */
    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    /**
     * Is the given attribute set on the model?
     *
     * @param  string  $name
     * @return boolean
     *
     * @see hasAttribute()
     */
    public function __isset($name)
    {
        return $this->hasAttribute($name);
    }
}
