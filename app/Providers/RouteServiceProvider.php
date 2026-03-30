<?php
// File: app/Providers/RouteServiceProvider.php (Add to boot method)

public function boot()
{
    // ... existing code ...
    
    // Register middleware aliases
    $this->app['router']->aliasMiddleware('check.session', \App\Http\Middleware\CheckSession::class);
    $this->app['router']->aliasMiddleware('unique_email', \App\Http\Middleware\UniqueEmailValidation::class);
}