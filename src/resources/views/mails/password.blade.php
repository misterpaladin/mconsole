@include('mconsole::mails.mail', [
    'heading' => trans('mconsole::mails.password.heading'),
    'text' => trans('mconsole::mails.password.text'),
    'action' => [
        'link' => url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()),
        'name' => trans('mconsole::mails.password.action'),
    ],
])