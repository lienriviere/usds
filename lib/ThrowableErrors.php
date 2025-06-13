<?php

class ThrowableErrors extends Exception
{
    /**
     * Custom error message for API errors.
     *
     * @param string $message The error message.
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }

    public static function apiDataError($message): Throwable
    {
        return new self("API Data Error: {$message}");
    }

    public static function apiConnectionError($message): Throwable
    {
        return new self("API Connection Error: {$message}");
    }

    public static function apiResponseError($message): Throwable
    {
        return new self("API Response Error: {$message}");
    }

    public static function apiRequestError($message): Throwable
    {
        return new self("API Request Error: {$message}");
    }

    public static function dataStorageError($message): Throwable
    {
        return new self("Data Storage Error: {$message}");
    }

    /**
     * Custom string representation of the error.
     *
     * @return string
     */
    public function __toString()
    {
        return "Error: {$this->message}\n";
    }
}