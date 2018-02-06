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

    'accepted'             => 'El :attribute Debe ser aceptado',
    'active_url'           => 'Esta :attribute no es una dirección correcta',
    'after'                => 'La :attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'la :attribute debe ser una fecha previa o igual a :date.',
    'alpha'                => 'El :attribute solo acepta letras',
    'alpha_dash'           => 'El :attribute solo puede obtener letras, numeros y guiones',
    'alpha_num'            => 'EL :attribute solo acepta letras y números',
    'array'                => 'Los :attribute debe estar en orden',
    'before'               => 'La :attribute debe ser una fecha previa a :date.',
    'before_or_equal'      => 'La :attribute debe ser una fecha antes o igual a :date.',
    'between'              => [
        'numeric' => 'El :attribute debe ser entre :min and :max.',
        'file'    => 'Los :attribute debe ser entre :min y :max kilobytes.',
        'string'  => 'los :attribute debe ser entre :min y  :max letras.',
        'array'   => 'Los :attribute deben ser entre :min y  :max artículos',
    ],
    'boolean'              => 'El :attribute campo debe ser entre verdadero o falso',
    'confirmed'            => 'La :attribute no concuerda con nuestros registros',
    'date'                 => 'La :attribute no es una fecha válida',
    'date_format'          => 'El :attribute no concuerda con los formatos :format.',
    'different'            => 'El :attribute y :other deben ser diferentes',
    'digits'               => 'Los :attribute deben poseer :digits digitos.',
    'digits_between'       => 'El :attribute debe estar entre :min y  :max de números',
    'dimensions'           => 'El :attribute posee dimensiones inválidas',
    'distinct'             => 'Los :attribute campo tiene valores duplicados',
    'email'                => 'El :attribute debe ser una dirección de correo válida',
    'exists'               => 'El :attribute seleccionado es invalido',
    'file'                 => 'El :attribute debe ser un archivo',
    'filled'               => 'El :attribute campo, debe tener un valor',
    'image'                => 'El :attribute debe ser una imagen.',
    'in'                   => 'El :attribute seleccionado es inválido.',
    'in_array'             => 'El :attribute no existe en :other.',
    'integer'              => 'El :attribute debe ser un entero.',
    'ip'                   => 'El :attribute debe ser una dirección IP válida.',
    'json'                 => 'El :attribute debe ser un string JSON válido.',
    'max'                  => [
        'numeric' => 'El :attribute no puede ser mayor que :max.',
        'file'    => 'El :attribute no puede ser mayor que :max kilobytes.',
        'string'  => 'El :attribute no puede ser mayor :max caracteres.',
        'array'   => 'El :attribute no puede tener más de :max artículos.',
    ],
    'mimes'                => 'El :attribute debe ser un archivo type: :values.',
    'mimetypes'            => 'El :attribute debe ser un archivo type: :values.',
    'min'                  => [
        'numeric' => 'El :attribute debe tener al menos :min.',
        'file'    => 'El :attribute debe tener al menos :min kilobytes.',
        'string'  => 'El :attribute debe tener al menos :min caracteres.',
        'array'   => 'El :attribute debe tener al menos :min artículos.',
    ],
    'not_in'               => 'El :attribute seleccionado es invalido.',
    'numeric'              => 'El :attribute debe ser un número.',
    'present'              => 'El campo :attribute debe estar presente .',
    'regex'                => ' :attribute es un formato inválido',
    'required'             => ' :attribute es un campo requerido.',
    'required_if'          => 'El :attribute es un campo requerido cuando :other tiene  :value.',
    'required_unless'      => 'El :attribute es un campo requerido a menos que :other esté en :values.',
    'required_with'        => 'El :attribute es un campo requerido cuando :values está presente.',
    'required_with_all'    => 'El :attribute es un campo requerido cuando :values está presente.',
    'required_without'     => 'El :attribute es un campo requerido cuando :values no está presente.',
    'required_without_all' => 'El :attribute es un campo requerido cuando :values están presentes.',
    'same'                 => 'El :attribute y :other deben coincidir',
    'size'                 => [
        'numeric' => 'El :attribute debe tener al menos :size.',
        'file'    => 'El :attribute debe tener :size kilobytes.',
        'string'  => 'El :attribute debe tener :size caracteres.',
        'array'   => 'El :attribute debe contener :size artículos.',
    ],
    'string'               => 'El :attribute debe ser una cadena.',
    'timezone'             => 'La :attribute debe ser una zona horaria válida.',
    'unique'               => 'El :attribute ya ha sido tomado.',
    'uploaded'             => 'El :attribute no se ha cargado correctamente.',
    'url'                  => 'El :attribute es un formato inválido.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
