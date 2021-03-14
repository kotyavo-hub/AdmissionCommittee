<?php

namespace AC\Config\Validation;

return [
    ValidationConfigKeys::REGISTRATION()->getKey() => [
        ValidationConfigKeys::RULES_KEY => [
            'login' => 'required|min:2',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password',
            'role' => 'required|numeric'
        ],
        ValidationConfigKeys::MESSAGES_KEY => [
            'login:required' => 'Не заполненно обязательное поле "Логин".',
            'login:min' => 'Минимальная длинна логина 2 символа.',
            'email:required' => 'Не заполненно обязательное поле "Email".',
            'email:email' => 'Некорректный Email адрес.',
            'password:required' => 'Не заполненно обязательное поле "Пароль".',
            'password:min' => 'Минимальная длинна пароля 6 символов.',
            'confirmPassword:required' => 'Не заполненно обязательное поле "Подтверждение пароля".',
            'confirmPassword:same' => 'Подтверждаемый пароль не совпадает с введенным паролем.'
        ]
    ],
];