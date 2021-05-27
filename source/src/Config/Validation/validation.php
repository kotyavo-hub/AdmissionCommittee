<?php

namespace AC\Config\Validation;

return [
    ValidationConfigKeys::AUTHENTICATION()->getKey() => [
        ValidationConfigKeys::RULES_KEY => [
            'login' => 'required|min:2',
            'password' => 'required|min:6',
        ],
        ValidationConfigKeys::MESSAGES_KEY => [
            'login:required' => 'Не заполненно обязательное поле "Логин".',
            'login:min' => 'Минимальная длинна логина 2 символа.',
            'password:required' => 'Не заполненно обязательное поле "Пароль".',
            'password:min' => 'Минимальная длинна пароля 6 символов.',
        ]
    ],
    ValidationConfigKeys::REGISTRATION()->getKey() => [
        ValidationConfigKeys::RULES_KEY => [
            'login' => 'required|uniqueLogin|min:2',
            'email' => 'required|uniqueEmail|email',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password',
            'role' => 'required|numeric'
        ],
        ValidationConfigKeys::MESSAGES_KEY => [
            'login:required' => 'Не заполненно обязательное поле "Логин".',
            'login:uniqueLogin' => 'Аккаунт с логином :value уже существует.',
            'login:min' => 'Минимальная длинна логина 2 символа.',
            'email:required' => 'Не заполненно обязательное поле "Email".',
            'email:email' => 'Некорректный Email адрес.',
            'email:uniqueEmail' => 'Аккаунт с email :value уже существует.',
            'password:required' => 'Не заполненно обязательное поле "Пароль".',
            'password:min' => 'Минимальная длинна пароля 6 символов.',
            'confirmPassword:required' => 'Не заполненно обязательное поле "Подтверждение пароля".',
            'confirmPassword:same' => 'Подтверждаемый пароль не совпадает с введенным паролем.'
        ]
    ],
    ValidationConfigKeys::APPLYING_CONFIRM_EMAIL()->getKey() => [
        ValidationConfigKeys::RULES_KEY => [
            'email' => 'required|uniqueEmail|email',
        ],
        ValidationConfigKeys::MESSAGES_KEY => [
            'email:required' => 'Не заполненно обязательное поле "Email".',
            'email:email' => 'Некорректный Email адрес.',
            'email:uniqueEmail' => 'Абитуриент с email :value уже существует.',
        ]
    ],
];