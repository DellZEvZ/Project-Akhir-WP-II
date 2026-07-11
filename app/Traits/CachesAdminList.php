<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CachesAdminList
{
    /**
     * Cache the result of an admin list query (unfiltered variant only) for a
     * few minutes, since each DB query costs ~1s. Filtered/search results are
     * never cached (too many combinations, rarely repeated).
     *
     * The key includes a per-resource version number. The "file" cache driver
     * (used in docker-compose) doesn't support pattern-based deletion, so
     * forgetAdminList() just bumps the version instead -> old entries become
     * unreachable immediately and are cleaned up naturally once they expire,
     * no wildcard delete needed.
     */
    protected function rememberAdminList(string $resource, string $variant, \Closure $fn, int $minutes = 5)
    {
        $version = Cache::get("admin:{$resource}:version", 1);

        return Cache::remember("admin:{$resource}:v{$version}:{$variant}", now()->addMinutes($minutes), $fn);
    }

    /**
     * Call this after create/update/delete on this resource so admins see
     * their own change immediately instead of waiting for the cache to expire.
     */
    protected function forgetAdminList(string $resource): void
    {
        Cache::put("admin:{$resource}:version", Cache::get("admin:{$resource}:version", 1) + 1, now()->addDay());
    }
}
