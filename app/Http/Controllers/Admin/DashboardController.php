<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\PackageRequest;
use App\Models\MeetingRequest;
use App\Models\BlogPost;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'contacts'         => Contact::count(),
            'contacts_novos'   => Contact::novo()->count(),
            'package_requests' => PackageRequest::count(),
            'package_novos'    => PackageRequest::novo()->count(),
            'meetings'         => MeetingRequest::count(),
            'meetings_pending' => MeetingRequest::pendente()->count(),
            'blog_posts'       => BlogPost::count(),
            'blog_published'   => BlogPost::published()->count(),
        ];

        $recent_contacts = Contact::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_contacts'));
    }
}
