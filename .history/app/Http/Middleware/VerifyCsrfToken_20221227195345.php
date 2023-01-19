<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
       'edit-card',
       'cmplete','createAdminMessage',
       'displayTicketMessage','checkoutlogin','support-chat-media','exp-csv',
       'add-push-card','edit-push-card','edit-term','edit-Faq','editPrivacy','create-advert',
       'approve-reject','admin-push-noti','forget-password','reset-password','push-noti',
    ];
}
