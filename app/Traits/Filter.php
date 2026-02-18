<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filter
{

    public function scopeFilter($query, Request $request): Builder
    {
        if ($request->has("name") && $request->get('name') != null) {
            $query->where('name', 'like', '%' . $request->get('name') . '%');
        }
        if ($request->has("slug") && $request->get('slug') != null) {
            $query->where('slug', $request->get('slug'));
        }
        if ($request->has("email") && $request->get('email') != null) {
            $query->where('email', 'like', '%' . $request->get('email') . '%');
        }
        if ($request->has("date_from") && $request->get('date_from') != null) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has("date_to") && $request->get('date_to') != null) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->has('status') && $request->get('status') != null) {
            if ($request->status == 'active') {
                $query->where('active', true);
            } else {
                $query->where(
                    'active',
                    false
                );
            }
        }
        return $query;
    }
}