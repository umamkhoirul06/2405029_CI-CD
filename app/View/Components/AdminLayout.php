<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminLayout extends Component
{
    public $title;

    public function __construct($title = 'Admin Dashboard')
    {
        $this->title = $title;
    }

    public function render()
    {
        // Gunakan ?? null agar tidak error jika user tidak punya avatar
        $user_avatar = auth()->user()->avatar ?? null; 
        return view('admin.layouts.admin', compact('user_avatar'));
    }
}