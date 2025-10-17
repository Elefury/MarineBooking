@component('mail::message')
# @lang('Сброс пароля')

@lang('Вы получили это письмо, потому что был запрошен сброс пароля для вашего аккаунта.')

@component('mail::button', ['url' => $resetUrl, 'color' => 'primary'])
@lang('Сбросить пароль')
@endcomponent

@lang('Ссылка действительна :count минут.', ['count' => $count])

@lang('Если вы не запрашивали сброс пароля, проигнорируйте это письмо.')

@lang('С уважением'),<br>
{{ config('app.name') }}
@endcomponent