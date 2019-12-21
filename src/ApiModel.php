<?php

namespace StephaneCoinon\Turbine;

use Carbon\Carbon;

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
     * Attributes to cast to a native type.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Format to use when casting dates.
     *
     * @var string
     */
    protected $dateFormat;

    /**
     * Instantiate a new Model with its attributes.
     *
     * @param  array  $attributes
     */
    public function __construct($attributes = [])
    {
        $this->fill($attributes);
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
        $this->attributes[$name] = $this->castAttribute($name, $value);

        return $this;
    }

    /**
     * Set an array of attributes on the model.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function fill($attributes = [])
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }

        return $this;
    }

    /**
     * Cast an attribute if its name is in static::$casts.
     *
     * Returns the unchanged value if $name is not in static::$casts.
     *
     * @param  string  $name
     * @param  mixed  $value
     * @return mixed
     */
    public function castAttribute($name, $value)
    {
        // Return the unchanged value if the attribute should not be cast
        if (!array_key_exists($name, $this->casts)) {
            return $value;
        }

        switch ($this->casts[$name]) {
            case 'date':
            case 'datetime':
                return Carbon::createFromFormat($this->getDateFormat(), $value);
        }

        // Return the unchanged value if cast type is not supported
        return $value;
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
     * Get the date format used for casting dates.
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat ?: 'Y-m-d H:i:s';
    }

    /**
     * Set the date format to use for casting dates.
     *
     * @param  string  $format
     * @return $this
     */
    public function setDateFormat($format)
    {
        $this->dateFormat = $format;

        return $this;
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
