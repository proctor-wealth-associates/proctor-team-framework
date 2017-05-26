<?php

namespace Elegon\Foundation\Flash;

class Message
{
    /**
     * The title of the message.
     */
    public $title;

    /**
     * The body of the message.
     */
    public $message;

    /**
     * The message level.
     */
    public $level = 'info';

    /**
     * Whether the message should auto-hide.
     */
    public $closable = true;

    /**
     * Create a new message instance.
     */
    public function __construct($attributes = [])
    {
        $this->update($attributes);
    }

    /**
     * Update the attributes.
     */
    public function update($attributes = [])
    {
        $attributes = array_filter($attributes, function($value) { 
            return ! is_null($value);
        });

        foreach ($attributes as $key => $attribute) {
            $this->$key = $attribute;
        }

        return $this;
    }
}