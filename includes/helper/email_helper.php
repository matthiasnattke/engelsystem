<?php

/**
 * @param array  $recipient_user
 * @param string $title
 * @param string $message
 * @param bool   $not_if_its_me
 * @return bool
 */
function engelsystem_email_to_user($recipient_user, $title, $message, $not_if_its_me = false)
{
    global $user;

    if ($not_if_its_me && $user['UID'] == $recipient_user['UID']) {
        return true;
    }

    /** @var \Engelsystem\Helpers\Translator $translator */
    $translator = app()->get('translator');
    $locale = $translator->getLocale();

    $translator->setLocale($recipient_user['Sprache']);
    $message = sprintf(__('Hi %s,'), $recipient_user['Nick']) . "\n\n"
        . __('here is a message for you from the engelsystem:') . "\n\n"
        . $message . "\n\n"
        . __('This email is autogenerated and has not been signed. You got this email because you are registered in the engelsystem.');
    $translator->setLocale($locale);

    return engelsystem_email($recipient_user['email'], $title, $message);
}

/**
 * @param string $address
 * @param string $title
 * @param string $message
 * @return bool
 */
function engelsystem_email($address, $title, $message)
{
    $result = mail(
        $address,
        $title,
        $message,
        sprintf(
            "Content-Type: text/plain; charset=UTF-8\r\nFrom: Engelsystem <%s>",
            config('no_reply_email')
        )
    );

    if ($result === false) {
        engelsystem_error('Unable to send email.');
    }

    return true;
}
