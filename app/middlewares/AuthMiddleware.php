<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthMiddleware
{
    public function handle(Closure $next)
    {
        $session = lava_instance()->call->library('session');

        if (!$session->has_userdata('logged_in') || !$session->userdata('logged_in')) {
            $session->set_flashdata('error', 'You must be logged in to enter the nursery.');
            redirect('/login');
        }

        return $next();
    }
}
