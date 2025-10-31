<?php

namespace App\Services\Response;

use Illuminate\Http\RedirectResponse;

class ResponseService
{
    /**
     * Create success flash message.
     *
     * @param string $message
     * @param string $route Route name to redirect to
     * @param array $routeParams Parameters for route
     * @return RedirectResponse
     */
    public function success(string $message, string $route, array $routeParams = []): RedirectResponse
    {
        return redirect()->route($route, $routeParams)->with('status', [
            'type' => 'success',
            'message' => $message,
        ]);
    }

    /**
     * Create error flash message.
     *
     * @param string $message
     * @param string $route Route name to redirect to
     * @param array $routeParams Parameters for route
     * @return RedirectResponse
     */
    public function error(string $message, string $route, array $routeParams = []): RedirectResponse
    {
        return redirect()->route($route, $routeParams)->with('status', [
            'type' => 'error',
            'message' => $message,
        ]);
    }

    /**
     * Create warning flash message.
     *
     * @param string $message
     * @param string $route Route name to redirect to
     * @param array $routeParams Parameters for route
     * @return RedirectResponse
     */
    public function warning(string $message, string $route, array $routeParams = []): RedirectResponse
    {
        return redirect()->route($route, $routeParams)->with('status', [
            'type' => 'warning',
            'message' => $message,
        ]);
    }

    /**
     * Create info flash message.
     *
     * @param string $message
     * @param string $route Route name to redirect to
     * @param array $routeParams Parameters for route
     * @return RedirectResponse
     */
    public function info(string $message, string $route, array $routeParams = []): RedirectResponse
    {
        return redirect()->route($route, $routeParams)->with('status', [
            'type' => 'info',
            'message' => $message,
        ]);
    }

    /**
     * Redirect back with success message.
     *
     * @param string $message
     * @return RedirectResponse
     */
    public function successBack(string $message): RedirectResponse
    {
        return redirect()->back()->with('status', [
            'type' => 'success',
            'message' => $message,
        ]);
    }

    /**
     * Redirect back with error message.
     *
     * @param string $message
     * @return RedirectResponse
     */
    public function errorBack(string $message): RedirectResponse
    {
        return redirect()->back()->with('status', [
            'type' => 'error',
            'message' => $message,
        ]);
    }

    /**
     * Redirect back with warning message.
     *
     * @param string $message
     * @return RedirectResponse
     */
    public function warningBack(string $message): RedirectResponse
    {
        return redirect()->back()->with('status', [
            'type' => 'warning',
            'message' => $message,
        ]);
    }

    /**
     * Redirect back with info message.
     *
     * @param string $message
     * @return RedirectResponse
     */
    public function infoBack(string $message): RedirectResponse
    {
        return redirect()->back()->with('status', [
            'type' => 'info',
            'message' => $message,
        ]);
    }

    /**
     * Create success flash with input data (useful for forms).
     *
     * @param string $message
     * @param string $route
     * @param array $routeParams
     * @return RedirectResponse
     */
    public function successWithInput(string $message, string $route, array $routeParams = []): RedirectResponse
    {
        return redirect()->route($route, $routeParams)
            ->withInput()
            ->with('status', [
                'type' => 'success',
                'message' => $message,
            ]);
    }

    /**
     * Create error flash with input data (useful for forms).
     *
     * @param string $message
     * @param string $route
     * @param array $routeParams
     * @return RedirectResponse
     */
    public function errorWithInput(string $message, string $route, array $routeParams = []): RedirectResponse
    {
        return redirect()->route($route, $routeParams)
            ->withInput()
            ->with('status', [
                'type' => 'error',
                'message' => $message,
            ]);
    }
}
