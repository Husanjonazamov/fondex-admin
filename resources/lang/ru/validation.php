<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute должно быть принято.',
'accepted_if' => ':attribute должно быть принято, когда :other равно :value.',
'active_url' => ':attribute не является допустимым URL.',
'after' => ':attribute должно быть датой после :date.',
'after_or_equal' => ':attribute должно быть датой после или равной :date.',
'alpha' => ':attribute может содержать только буквы.',
'alpha_dash' => ':attribute может содержать только буквы, цифры, дефисы и подчеркивания.',
'alpha_num' => ':attribute может содержать только буквы и цифры.',
'array' => ':attribute должно быть массивом.',
'before' => ':attribute должно быть датой до :date.',
'before_or_equal' => ':attribute должно быть датой до или равной :date.',
'between' => [
    'numeric' => ':attribute должно быть между :min и :max.',
    'file' => ':attribute должно быть между :min и :max килобайт.',
    'string' => ':attribute должно быть между :min и :max символами.',
    'array' => ':attribute должно содержать от :min до :max элементов.',
],
'boolean' => 'Поле :attribute должно быть истинным или ложным.',
'confirmed' => 'Подтверждение :attribute не совпадает.',
'current_password' => 'Неверный пароль.',
'date' => ':attribute не является допустимой датой.',
'date_equals' => ':attribute должно быть датой, равной :date.',
'date_format' => ':attribute не соответствует формату :format.',
'declined' => ':attribute должно быть отклонено.',
'declined_if' => ':attribute должно быть отклонено, когда :other равно :value.',
'different' => ':attribute и :other должны различаться.',
'digits' => ':attribute должно быть :digits цифр.',
'digits_between' => ':attribute должно быть между :min и :max цифрами.',
'dimensions' => 'У :attribute недопустимые размеры изображения.',
'distinct' => 'Поле :attribute содержит повторяющееся значение.',
'email' => ':attribute должно быть допустимым email адресом.',
'ends_with' => ':attribute должно заканчиваться одним из следующих значений: :values.',
'enum' => 'Выбранный :attribute недействителен.',
'exists' => 'Выбранный :attribute недействителен.',
'file' => ':attribute должно быть файлом.',
'filled' => 'Поле :attribute должно иметь значение.',
'gt' => [
    'numeric' => ':attribute должно быть больше :value.',
    'file' => ':attribute должно быть больше :value килобайт.',
    'string' => ':attribute должно быть больше :value символов.',
    'array' => ':attribute должно содержать больше :value элементов.',
],
'gte' => [
    'numeric' => ':attribute должно быть больше или равно :value.',
    'file' => ':attribute должно быть больше или равно :value килобайт.',
    'string' => ':attribute должно быть больше или равно :value символов.',
    'array' => ':attribute должно содержать :value элементов или больше.',
],
'image' => ':attribute должно быть изображением.',
'in' => 'Выбранный :attribute недействителен.',
'in_array' => 'Поле :attribute отсутствует в :other.',
'integer' => ':attribute должно быть целым числом.',
'ip' => ':attribute должно быть допустимым IP адресом.',
'ipv4' => ':attribute должно быть допустимым IPv4 адресом.',
'ipv6' => ':attribute должно быть допустимым IPv6 адресом.',
'json' => ':attribute должно быть допустимой JSON строкой.',
'lt' => [
    'numeric' => ':attribute должно быть меньше :value.',
    'file' => ':attribute должно быть меньше :value килобайт.',
    'string' => ':attribute должно быть меньше :value символов.',
    'array' => ':attribute должно содержать меньше :value элементов.',
],
'lte' => [
    'numeric' => ':attribute должно быть меньше или равно :value.',
    'file' => ':attribute должно быть меньше или равно :value килобайт.',
    'string' => ':attribute должно быть меньше или равно :value символов.',
    'array' => ':attribute не должно содержать более :value элементов.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
