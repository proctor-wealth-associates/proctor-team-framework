<?php

namespace Elegon\Foundation\Flash;

class FlashNotifier
{
    /**
     * The messages collection.
     */
    public $messages;

    /**
     * Create a new FlashNotifier instance.
     */
    function __construct()
    {
        $this->messages = collect();
    }

    /**
     * Flash an information message.
     */
    public function info($message = null, $title = null)
    {
        return $this->message($message, 'info', $title);
    }

    /**
     * Flash a success message.
     */
    public function success($message = null, $title = null)
    {
        return $this->message($message, 'success', $title);
    }

    /**
     * Flash an error message.
     */
    public function error($message = null, $title = null)
    {
        return $this->message($message, 'error', $title);
    }

    /**
     * Flash a warning message.
     */
    public function warning($message = null, $title = null)
    {
        return $this->message($message, 'warning', $title);
    }

    /**
     * Flash a general message.
     */
    public function message($message = null, $level = null, $title = null)
    {
        if (! $message) {
            return $this->updateLastMessage(compact('level', 'title'));
        }

        if (! $message instanceof Message) {
            $message = new Message(compact('message', 'level', 'title'));
        }

        $this->messages->push($message);

        return $this->flash();
    }

    /**
     * Modify the most recently added message.
     */
    protected function updateLastMessage($overrides = [])
    {
        $this->messages->last()->update($overrides);

        return $this;
    }

    /**
     * Update message to make it non closable.
     */
    public function stuck()
    {
        return $this->updateLastMessage([ 'closable' => false ]);
    }

    /**
     * Update message to make it closable.
     */
    public function closable()
    {
        return $this->updateLastMessage([ 'closable' => true ]);
    }

    /**
     * Update message to give it a title.
     */
    public function title($title)
    {
        return $this->updateLastMessage(compact('title'));
    }

    /**
     * Clear all registered messages.
     */
    public function clear()
    {
        $this->messages = collect();

        return $this;
    }

    /**
     * Flash all messages to the session.
     */
    protected function flash()
    {
        session()->flash('flash_notification', $this->messages);

        return $this;
    }
}