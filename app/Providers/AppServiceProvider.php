<?php

namespace App\Providers;

use App\Models\LibraryBook;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('view-dashboard', function (User $user) {
            return $user->isStaff();
        });

        Gate::define('manage-books', function (User $user) {
            return $user->isStaff();
        });

        Gate::define('manage-borrowings', function (User $user) {
            return $user->isStaff();
        });

        Gate::define('manage-fines', function (User $user) {
            return $user->isStaff();
        });

        Gate::define('borrow-books', function (User $user) {
            return $user->isMember();
        });

        Gate::define('view-book', function (User $user, LibraryBook $book) {
            return true;
        });
    }
}
