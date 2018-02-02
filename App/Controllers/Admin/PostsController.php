<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;

class PostsController extends BaseController {
    public function index() {
        self::render('admin/posts/index');
    }

    public function edit() {
        self::render('admin/posts/edit');
    }

    public function create() {
        self::render('admin/posts/create');
    }

    public function store() {
        // TODO: Add Post to Database and redirect to index
    }

    public function update() {
        // TODO: Update Post and redirect to index or show post
    }

    public function destroy() {
        // TODO: Delete post from database and redirect to index 
    }
}