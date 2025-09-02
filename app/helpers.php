<?php

// app/helpers.php (adicionar no composer.json: "files": ["app/helpers.php"])

if (!function_exists('toast')) {
    /**
     * Flash toast message to session
     */
    function toast(string $type, string $title, string $message = ''): void
    {
        session()->flash('toast', [
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ]);
    }
}

if (!function_exists('toast_success')) {
    function toast_success(string $title, string $message = ''): void
    {
        toast('success', $title, $message);
    }
}

if (!function_exists('toast_error')) {
    function toast_error(string $title, string $message = ''): void
    {
        toast('error', $title, $message);
    }
}

if (!function_exists('toast_warning')) {
    function toast_warning(string $title, string $message = ''): void
    {
        toast('warning', $title, $message);
    }
}

if (!function_exists('toast_info')) {
    function toast_info(string $title, string $message = ''): void
    {
        toast('info', $title, $message);
    }
}
