<?php
// app/Http/Middleware/PreventBackHistory.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistory
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Only apply to authenticated users for specific routes
        if (auth()->check() && $this->shouldPreventBack($request)) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            
            // Add script to prevent back navigation
            $content = $response->getContent();
            $preventionScript = $this->getPreventionScript();
            
            // Insert script before closing body tag
            if (strpos($content, '</body>') !== false) {
                $content = str_replace('</body>', $preventionScript . '</body>', $content);
                $response->setContent($content);
            }
        }
        
        return $response;
    }
    
    protected function shouldPreventBack(Request $request): bool
    {
        // Apply to dashboard and main pages
        $preventRoutes = [
            'dashboard', 
            'research-records',
            'settings',
            'profile'
        ];
        
        foreach ($preventRoutes as $route) {
            if (str_contains($request->path(), $route)) {
                return true;
            }
        }
        
        return false;
    }
    
    protected function getPreventionScript(): string
    {
        return '
        <script>
            // Prevent back button navigation
            history.pushState(null, null, location.href);
            window.onpopstate = function() {
                history.go(1);
            };
            
            // Additional protection
            window.addEventListener("beforeunload", function() {
                history.replaceState(null, null, location.href);
            });
        </script>
        ';
    }
}