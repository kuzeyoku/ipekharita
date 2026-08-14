<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

abstract class BaseAdminController extends Controller
{
    /**
     * Standardized view response helper.
     */
    protected function renderView(string $viewPath, array $data = []): View
    {
        return view($viewPath, $data);
    }

    /**
     * Redirect back with success Toast alert.
     */
    protected function redirectSuccess(string $routeName, string $message): RedirectResponse
    {
        return redirect()->route($routeName)->with('success', $message);
    }

    /**
     * Redirect back with error Toast alert.
     */
    protected function redirectError(string $routeName, string $message): RedirectResponse
    {
        return redirect()->route($routeName)->with('error', $message);
    }
}
