<?php

use App\Http\Controllers\Admin\ProjectController;;
use Illuminate\Support\Facades\Route;

Route::middleware('admin.auth')->prefix('admin/dashboard') ->group(function () {
// all admin route here

});

require __DIR__ . '/admin_auth.php';
