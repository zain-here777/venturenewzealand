<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscribers;

class NewsletterSubscriberController extends Controller
{

    public function __construct()
    {

    }

    public function list()
    {
        $newsletterSubscribers = NewsletterSubscribers::all();

        return view('admin.newsletter_subscriber.newsletter_subscriber_list', [
            'newsletterSubscribers' => $newsletterSubscribers
        ]);
    }
    
    public function destroy($id)
    {
        NewsletterSubscribers::destroy($id);
        return redirect()->back()->with('success', 'Delete subscriber success!');
    }
}
