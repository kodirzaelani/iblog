<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //permission for settings
        Permission::create(['name' => 'settings.index']);
        Permission::create(['name' => 'settings.create']);
        Permission::create(['name' => 'settings.edit']);
        Permission::create(['name' => 'settings.delete']);
        //permission for greetings
        Permission::create(['name' => 'greetings.index']);
        Permission::create(['name' => 'greetings.create']);
        Permission::create(['name' => 'greetings.edit']);
        Permission::create(['name' => 'greetings.delete']);

        //permission for menu
        Permission::create(['name' => 'menu.index']);
        Permission::create(['name' => 'menu.create']);
        Permission::create(['name' => 'menu.edit']);
        Permission::create(['name' => 'menu.delete']);

        //permission for socialmedia
        Permission::create(['name' => 'socialmedia.index']);
        Permission::create(['name' => 'socialmedia.create']);
        Permission::create(['name' => 'socialmedia.edit']);
        Permission::create(['name' => 'socialmedia.delete']);

        //permission for categories
        Permission::create(['name' => 'categoryposts.index']);
        Permission::create(['name' => 'categoryposts.create']);
        Permission::create(['name' => 'categoryposts.edit']);
        Permission::create(['name' => 'categoryposts.delete']);

        //permission for postsubcategory
        Permission::create(['name' => 'postsubcategory.index']);
        Permission::create(['name' => 'postsubcategory.create']);
        Permission::create(['name' => 'postsubcategory.edit']);
        Permission::create(['name' => 'postsubcategory.delete']);

        //permission for setarticles
        Permission::create(['name' => 'setarticles.index']);
        Permission::create(['name' => 'setarticles.create']);
        Permission::create(['name' => 'setarticles.edit']);
        Permission::create(['name' => 'setarticles.delete']);


        //permission for tags
        Permission::create(['name' => 'tags.index']);
        Permission::create(['name' => 'tags.create']);
        Permission::create(['name' => 'tags.edit']);
        Permission::create(['name' => 'tags.delete']);

        //permission for posts
        Permission::create(['name' => 'posts.index']);
        Permission::create(['name' => 'posts.create']);
        Permission::create(['name' => 'posts.edit']);
        Permission::create(['name' => 'posts.delete']);

        //permission for pagecategories
        Permission::create(['name' => 'pagecategories.index']);
        Permission::create(['name' => 'pagecategories.create']);
        Permission::create(['name' => 'pagecategories.edit']);
        Permission::create(['name' => 'pagecategories.delete']);

        //permission for pages
        Permission::create(['name' => 'pages.index']);
        Permission::create(['name' => 'pages.create']);
        Permission::create(['name' => 'pages.edit']);
        Permission::create(['name' => 'pages.delete']);

        //permission for videocategories
        Permission::create(['name' => 'videocategories.index']);
        Permission::create(['name' => 'videocategories.create']);
        Permission::create(['name' => 'videocategories.edit']);
        Permission::create(['name' => 'videocategories.delete']);

        //permission for video
        Permission::create(['name' => 'video.index']);
        Permission::create(['name' => 'video.create']);
        Permission::create(['name' => 'video.edit']);
        Permission::create(['name' => 'video.delete']);

        //permission for albums
        Permission::create(['name' => 'albums.index']);
        Permission::create(['name' => 'albums.create']);
        Permission::create(['name' => 'albums.edit']);
        Permission::create(['name' => 'albums.delete']);

        //permission for photos
        Permission::create(['name' => 'photos.index']);
        Permission::create(['name' => 'photos.create']);
        Permission::create(['name' => 'photos.edit']);
        Permission::create(['name' => 'photos.delete']);

        //permission for sliders
        Permission::create(['name' => 'sliders.index']);
        Permission::create(['name' => 'sliders.create']);
        Permission::create(['name' => 'sliders.edit']);
        Permission::create(['name' => 'sliders.delete']);

        //permission for roles
        Permission::create(['name' => 'roles.index']);
        Permission::create(['name' => 'roles.create']);
        Permission::create(['name' => 'roles.edit']);
        Permission::create(['name' => 'roles.delete']);

        //permission for permissions
        Permission::create(['name' => 'permissions.index']);
        Permission::create(['name' => 'permissions.create']);
        Permission::create(['name' => 'permissions.edit']);
        Permission::create(['name' => 'permissions.delete']);

        //permission for users
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);

        //permission for advertisements
        Permission::create(['name' => 'advertisements.index']);
        Permission::create(['name' => 'advertisements.create']);
        Permission::create(['name' => 'advertisements.edit']);
        Permission::create(['name' => 'advertisements.delete']);

        //permission for downloadcategories
        Permission::create(['name' => 'downloadcategories.index']);
        Permission::create(['name' => 'downloadcategories.create']);
        Permission::create(['name' => 'downloadcategories.edit']);
        Permission::create(['name' => 'downloadcategories.delete']);

        //permission for downloadfiles
        Permission::create(['name' => 'downloadfiles.index']);
        Permission::create(['name' => 'downloadfiles.create']);
        Permission::create(['name' => 'downloadfiles.edit']);
        Permission::create(['name' => 'downloadfiles.delete']);

        //permission for widgets
        Permission::create(['name' => 'widgets.index']);
        Permission::create(['name' => 'widgets.create']);
        Permission::create(['name' => 'widgets.edit']);
        Permission::create(['name' => 'widgets.delete']);

        //permission for events
        Permission::create(['name' => 'events.index']);
        Permission::create(['name' => 'events.create']);
        Permission::create(['name' => 'events.edit']);
        Permission::create(['name' => 'events.delete']);

        //permission for agendas
        Permission::create(['name' => 'agendas.index']);
        Permission::create(['name' => 'agendas.create']);
        Permission::create(['name' => 'agendas.edit']);
        Permission::create(['name' => 'agendas.delete']);

        //permission for links
        Permission::create(['name' => 'links.index']);
        Permission::create(['name' => 'links.create']);
        Permission::create(['name' => 'links.edit']);
        Permission::create(['name' => 'links.delete']);
    }
}
