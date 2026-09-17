<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

trait DynamicPaginatable
{
    /**
     * Scope query to dynamically apply either Cursor or Length-Aware (Offset) pagination.
     *
     * @param Builder $query
     * @param int $perPage
     * @param string|null $type 'cursor' | 'offset' | null (auto-detected from request)
     * @return CursorPaginator|LengthAwarePaginator
     */
    public function scopeSmartPaginate(
        Builder $query,
        int $perPage = 15,
        ?string $type = null
    ): CursorPaginator|LengthAwarePaginator {
        $requestedType = $type ?? request()->get('pagination_type');

        // If explicitly requested cursor, or if request contains cursor token, or if API default
        $useCursor = $requestedType === 'cursor' ||
            request()->has('cursor') ||
            ($requestedType !== 'offset' && request()->is('api/*'));

        if ($useCursor) {
            return $query->cursorPaginate($perPage);
        }

        return $query->paginate($perPage);
    }
}
