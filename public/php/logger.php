<?php

function logError(string $message): void
{
    error_log("[CHAT APP] " . $message);
}