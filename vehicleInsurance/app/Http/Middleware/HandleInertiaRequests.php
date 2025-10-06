<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Participant;
use App\Models\User;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        'auth' => [
            'user' => function () {
                $auth = Auth::user();

                if (!$auth) {
                    return null; // لم يتم تسجيل الدخول
                }

                // مستخدم موجود، نحدد علاقاته حسب المستوى
                if (in_array($auth->user_level, [3, 4])) {
                    return User::with(['company', 'office'])->find($auth->id);
                }

                if (in_array($auth->user_level, [1, 2])) {
                    return User::with('company')->find($auth->id);
                }

                return $auth; // fallback إذا لم ينطبق أي شرط
            }
        ],
    ]);
}
}
