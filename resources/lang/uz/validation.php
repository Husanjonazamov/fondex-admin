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

   'accepted' => ':attribute qabul qilinishi shart.',
'accepted_if' => ':attribute :other :value bo‘lganda qabul qilinishi shart.',
'active_url' => ':attribute to‘g‘ri URL emas.',
'after' => ':attribute :date dan keyingi sana bo‘lishi shart.',
'after_or_equal' => ':attribute :date sanasiga teng yoki undan keyingi sana bo‘lishi shart.',
'alpha' => ':attribute faqat harflardan iborat bo‘lishi kerak.',
'alpha_dash' => ':attribute faqat harflar, raqamlar, tire va pastki chiziqdan iborat bo‘lishi kerak.',
'alpha_num' => ':attribute faqat harflar va raqamlardan iborat bo‘lishi kerak.',
'array' => ':attribute massiv bo‘lishi kerak.',
'before' => ':attribute :date sanasidan oldingi sana bo‘lishi shart.',
'before_or_equal' => ':attribute :date sanasiga teng yoki undan oldingi sana bo‘lishi shart.',
'between' => [
    'numeric' => ':attribute :min va :max orasida bo‘lishi kerak.',
    'file' => ':attribute :min va :max kilobayt orasida bo‘lishi kerak.',
    'string' => ':attribute :min va :max belgilar orasida bo‘lishi kerak.',
    'array' => ':attribute :min va :max elementlar orasida bo‘lishi kerak.',
],
'boolean' => ':attribute maydoni true yoki false bo‘lishi kerak.',
'confirmed' => ':attribute tasdiqlanishi mos kelmaydi.',
'current_password' => 'Parol noto‘g‘ri.',
'date' => ':attribute haqiqiy sana emas.',
'date_equals' => ':attribute :date sanasiga teng bo‘lishi kerak.',
'date_format' => ':attribute :format formatiga mos kelmaydi.',
'declined' => ':attribute rad etilishi kerak.',
'declined_if' => ':attribute :other :value bo‘lganda rad etilishi kerak.',
'different' => ':attribute va :other farq qilishi kerak.',
'digits' => ':attribute :digits raqamdan iborat bo‘lishi kerak.',
'digits_between' => ':attribute :min va :max raqamlar orasida bo‘lishi kerak.',
'dimensions' => ':attribute rasm o‘lchamlari noto‘g‘ri.',
'distinct' => ':attribute maydonida takroriy qiymat mavjud.',
'email' => ':attribute haqiqiy email manzil bo‘lishi kerak.',
'ends_with' => ':attribute quyidagi qiymatlardan biri bilan tugashi kerak: :values.',
'enum' => 'Tanlangan :attribute noto‘g‘ri.',
'exists' => 'Tanlangan :attribute noto‘g‘ri.',
'file' => ':attribute fayl bo‘lishi kerak.',
'filled' => ':attribute maydonida qiymat bo‘lishi kerak.',
'gt' => [
    'numeric' => ':attribute :value dan katta bo‘lishi kerak.',
    'file' => ':attribute :value kilobaytdan katta bo‘lishi kerak.',
    'string' => ':attribute :value belgidan katta bo‘lishi kerak.',
    'array' => ':attribute :value elementdan ko‘p bo‘lishi kerak.',
],
'gte' => [
    'numeric' => ':attribute :value ga teng yoki undan katta bo‘lishi kerak.',
    'file' => ':attribute :value kilobaytdan teng yoki katta bo‘lishi kerak.',
    'string' => ':attribute :value belgidan teng yoki katta bo‘lishi kerak.',
    'array' => ':attribute :value element yoki undan ko‘p bo‘lishi kerak.',
],
'image' => ':attribute rasm bo‘lishi kerak.',
'in' => 'Tanlangan :attribute noto‘g‘ri.',
'in_array' => ':attribute :other da mavjud emas.',
'integer' => ':attribute butun son bo‘lishi kerak.',
'ip' => ':attribute haqiqiy IP manzil bo‘lishi kerak.',
'ipv4' => ':attribute haqiqiy IPv4 manzil bo‘lishi kerak.',
'ipv6' => ':attribute haqiqiy IPv6 manzil bo‘lishi kerak.',
'json' => ':attribute haqiqiy JSON satri bo‘lishi kerak.',
'lt' => [
    'numeric' => ':attribute :value dan kichik bo‘lishi kerak.',
    'file' => ':attribute :value kilobaytdan kichik bo‘lishi kerak.',
    'string' => ':attribute :value belgidan kichik bo‘lishi kerak.',
    'array' => ':attribute :value elementdan kam bo‘lishi kerak.',
],
'lte' => [
    'numeric' => ':attribute :value ga teng yoki kichik bo‘lishi kerak.',
    'file' => ':attribute :value kilobaytdan teng yoki kichik bo‘lishi kerak.',
    'string' => ':attribute :value belgidan teng yoki kichik bo‘lishi kerak.',
    'array' => ':attribute :value elementdan ko‘p bo‘lmasligi kerak.',
],
'mac_address' => ':attribute haqiqiy MAC manzil bo‘lishi kerak.',
'max' => [
    'numeric' => ':attribute :max dan katta bo‘lmasligi kerak.',
    'file' => ':attribute :max kilobaytdan katta bo‘lmasligi kerak.',
    'string' => ':attribute :max belgidan katta bo‘lmasligi kerak.',
    'array' => ':attribute :max elementdan ko‘p bo‘lmasligi kerak.',
],
'mimes' => ':attribute :values turidagi fayl bo‘lishi kerak.',
'mimetypes' => ':attribute :values turidagi fayl bo‘lishi kerak.',
'min' => [
    'numeric' => ':attribute kamida :min bo‘lishi kerak.',
    'file' => ':attribute kamida :min kilobayt bo‘lishi kerak.',
    'string' => ':attribute kamida :min belgidan iborat bo‘lishi kerak.',
    'array' => ':attribute kamida :min elementga ega bo‘lishi kerak.',
],
'multiple_of' => ':attribute :value ko‘paytmasi bo‘lishi kerak.',
'not_in' => 'Tanlangan :attribute noto‘g‘ri.',
'not_regex' => ':attribute formati noto‘g‘ri.',
'numeric' => ':attribute raqam bo‘lishi kerak.',
'password' => 'Parol noto‘g‘ri.',
'present' => ':attribute maydoni mavjud bo‘lishi kerak.',
'prohibited' => ':attribute maydoni taqiqlangan.',
'prohibited_if' => ':attribute maydoni :other :value bo‘lganda taqiqlangan.',
'prohibited_unless' => ':attribute maydoni :other :values da bo‘lmaguncha taqiqlangan.',
'prohibits' => ':attribute maydoni :other mavjud bo‘lishini taqiqlaydi.',
'regex' => ':attribute formati noto‘g‘ri.',
'required' => ':attribute maydoni majburiy.',
'required_array_keys' => ':attribute maydoni quyidagi elementlarni o‘z ichiga olishi kerak: :values.',
'required_if' => ':attribute maydoni :other :value bo‘lganda majburiy.',
'required_unless' => ':attribute maydoni :other :values da bo‘lmaguncha majburiy.',
'required_with' => ':attribute maydoni :values mavjud bo‘lganda majburiy.',
'required_with_all' => ':attribute maydoni :values mavjud bo‘lganda majburiy.',
'required_without' => ':attribute maydoni :values mavjud bo‘lmaganda majburiy.',
'required_without_all' => ':attribute maydoni :values hech biri mavjud bo‘lmaganda majburiy.',
'same' => ':attribute va :other mos kelishi kerak.',
'size' => [
    'numeric' => ':attribute :size bo‘lishi kerak.',
    'file' => ':attribute :size kilobayt bo‘lishi kerak.',
    'string' => ':attribute :size belgidan iborat bo‘lishi kerak.',
    'array' => ':attribute :size elementga ega bo‘lishi kerak.',
],
'starts_with' => ':attribute quyidagilardan biri bilan boshlanishi kerak: :values.',
'string' => ':attribute satr bo‘lishi kerak.',
'timezone' => ':attribute haqiqiy vaqt zonasi bo‘lishi kerak.',
'unique' => ':attribute allaqachon mavjud.',
'uploaded' => ':attribute yuklashda xato yuz berdi.',
'url' => ':attribute haqiqiy URL bo‘lishi kerak.',
'uuid' => ':attribute haqiqiy UUID bo‘lishi kerak.',

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
