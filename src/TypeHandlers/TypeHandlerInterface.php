<?php

namespace TypeHandlers;

interface TypeHandlerInterface
{
    /**
     * Is type handler able to validate the resource?
     *
     * @param string $url
     * @return bool
     */
    public function isAbleToHandle(string $url) : bool;

    /**
     * Is the resource still valid?
     *
     * Examples:
     *   - The file still exists on a HTTP server?
     *   - Does the FTP server contains the file?
     *   - Does the guest viewer has access to browse that resource?
     *
     * @param string $url
     * @return bool
     */
    public function isValid(string $url) : bool;
}