<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

// Categories
Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Categories', route('admin.categories'));
});
Breadcrumbs::for('categories_form', function (BreadcrumbTrail $trail) {
    $trail->parent('categories');
    $trail->push('Categories Form', route('admin.categories.form'));
});

// Services
Breadcrumbs::for('services', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Services', route('admin.services'));
});
Breadcrumbs::for('services_form', function (BreadcrumbTrail $trail) {
    $trail->parent('services');
    $trail->push('Services Form', route('admin.services.form'));
});

// Blogs
Breadcrumbs::for('blogs', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Blogs', route('admin.blogs'));
});
Breadcrumbs::for('blogs_form', function (BreadcrumbTrail $trail) {
    $trail->parent('blogs');
    $trail->push('Blogs Form', route('admin.blogs.form'));
});

// Banners
Breadcrumbs::for('banners', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Banners', route('admin.banners'));
});
Breadcrumbs::for('banners_form', function (BreadcrumbTrail $trail) {
    $trail->parent('banners');
    $trail->push('Banners Form', route('admin.banners.form'));
});

// Users
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('admin.users'));
});
Breadcrumbs::for('users_form', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Users Form', route('admin.users.form'));
});

// Creativers
Breadcrumbs::for('creativers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Creativers', route('admin.creativers'));
});
Breadcrumbs::for('creativers_form', function (BreadcrumbTrail $trail) {
    $trail->parent('creativers');
    $trail->push('Creativers Form', route('admin.creativers.form'));
});