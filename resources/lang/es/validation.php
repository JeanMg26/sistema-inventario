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

   'accepted'             => 'El campo :attribute debe ser aceptado.',
   'active_url'           => 'El campo :attribute no es una URL válida.',
   'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
   'after_or_equal'       => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
   'alpha'                => 'El campo :attribute solo puede contener letras.',
   'alpha_dash'           => 'El campo :attribute solo puede contener letras, números, guiones y guiones bajos.',
   'alpha_num'            => 'El campo :attribute solo puede contener letras y números.',
   'array'                => 'El campo :attribute debe ser un array.',
   'before'               => 'El campo :attribute debe ser una fecha anterior a :date.',
   'before_or_equal'      => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
   'between'              => [
      'numeric' => 'El campo :attribute debe ser un valor entre :min y :max.',
      'file'    => 'El archivo :attribute debe pesar entre :min y :max kilobytes.',
      'string'  => 'El campo :attribute debe contener entre :min y :max caracteres.',
      'array'   => 'El campo :attribute debe contener entre :min y :max elementos.',
   ],
   'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
   'confirmed'            => 'El campo confirmación de :attribute no coincide.',
   'date'                 => 'El campo :attribute no corresponde con una fecha válida.',
   'date_equals'          => 'El campo :attribute debe ser una fecha igual a :date.',
   'date_format'          => 'El campo :attribute no corresponde con el formato de fecha :format.',
   'different'            => 'Los campos :attribute y :other deben ser diferentes.',
   'digits'               => 'El campo :attribute debe ser un número de :digits dígitos.',
   'digits_between'       => 'El campo :attribute debe contener entre :min y :max dígitos.',
   'dimensions'           => 'El campo :attribute tiene dimensiones de imagen inválidas.',
   'distinct'             => 'El campo :attribute tiene un valor duplicado.',
   'email'                => 'El campo :attribute debe ser una dirección de correo válida.',
   'ends_with'            => 'El campo :attribute debe finalizar con alguno de los siguientes valores: :values',
   'exists'               => 'El campo :attribute seleccionado no existe.',
   'file'                 => 'El campo :attribute debe ser un archivo.',
   'filled'               => 'El campo :attribute debe tener un valor.',
   'gt'                   => [
      'numeric' => 'El campo :attribute debe ser mayor a :value.',
      'file'    => 'El archivo :attribute debe pesar más de :value kilobytes.',
      'string'  => 'El campo :attribute debe contener más de :value caracteres.',
      'array'   => 'El campo :attribute debe contener más de :value elementos.',
   ],
   'gte'                  => [
      'numeric' => 'El campo :attribute debe ser mayor o igual a :value.',
      'file'    => 'El archivo :attribute debe pesar :value o más kilobytes.',
      'string'  => 'El campo :attribute debe contener :value o más caracteres.',
      'array'   => 'El campo :attribute debe contener :value o más elementos.',
   ],
   'image'                => 'El campo :attribute debe ser una imagen.',
   'in'                   => 'El campo :attribute es inválido.',
   'in_array'             => 'El campo :attribute no existe en :other.',
   'integer'              => 'El campo :attribute debe ser un número entero.',
   'ip'                   => 'El campo :attribute debe ser una dirección IP válida.',
   'ipv4'                 => 'El campo :attribute debe ser una dirección IPv4 válida.',
   'ipv6'                 => 'El campo :attribute debe ser una dirección IPv6 válida.',
   'json'                 => 'El campo :attribute debe ser una cadena de texto JSON válida.',
   'lt'                   => [
      'numeric' => 'El campo :attribute debe ser menor a :value.',
      'file'    => 'El archivo :attribute debe pesar menos de :value kilobytes.',
      'string'  => 'El campo :attribute debe contener menos de :value caracteres.',
      'array'   => 'El campo :attribute debe contener menos de :value elementos.',
   ],
   'lte'                  => [
      'numeric' => 'El campo :attribute debe ser menor o igual a :value.',
      'file'    => 'El archivo :attribute debe pesar :value o menos kilobytes.',
      'string'  => 'El campo :attribute debe contener :value o menos caracteres.',
      'array'   => 'El campo :attribute debe contener :value o menos elementos.',
   ],
   'max'                  => [
      'numeric' => 'El campo :attribute no debe ser mayor a :max.',
      'file'    => 'El archivo :attribute no debe pesar más de :max kilobytes.',
      'string'  => 'El campo :attribute no debe contener más de :max caracteres.',
      'array'   => 'El campo :attribute no debe contener más de :max elementos.',
   ],
   'mimes'                => 'El campo :attribute debe ser un archivo de tipo: :values.',
   'mimetypes'            => 'El campo :attribute debe ser un archivo de tipo: :values.',
   'min'                  => [
      'numeric' => 'El campo :attribute debe ser al menos :min.',
      'file'    => 'El archivo :attribute debe pesar al menos :min kilobytes.',
      'string'  => 'El campo :attribute debe contener al menos :min caracteres.',
      'array'   => 'El campo :attribute debe contener al menos :min elementos.',
   ],
   'not_in'               => 'El campo :attribute seleccionado es inválido.',
   'not_regex'            => 'El formato del campo :attribute es inválido.',
   'numeric'              => 'El campo :attribute debe ser un número.',
   'password'             => 'La contraseña es incorrecta.',
   'present'              => 'El campo :attribute debe estar presente.',
   'regex'                => 'El formato del campo :attribute es inválido.',
   'required'             => 'El campo :attribute es obligatorio.',
   'required_if'          => 'El campo :attribute es obligatorio cuando el campo :other es :value.',
   'required_unless'      => 'El campo :attribute es requerido a menos que :other se encuentre en :values.',
   'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
   'required_with_all'    => 'El campo :attribute es obligatorio cuando :values están presentes.',
   'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
   'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de los campos :values están presentes.',
   'same'                 => 'Los campos :attribute y :other deben coincidir.',
   'size'                 => [
      'numeric' => 'El campo :attribute debe ser :size.',
      'file'    => 'El archivo :attribute debe pesar :size kilobytes.',
      'string'  => 'El campo :attribute debe contener :size caracteres.',
      'array'   => 'El campo :attribute debe contener :size elementos.',
   ],
   'starts_with'          => 'El campo :attribute debe comenzar con uno de los siguientes valores: :values',
   'string'               => 'El campo :attribute debe ser una cadena de caracteres.',
   'timezone'             => 'El campo :attribute debe ser una zona horaria válida.',
   'unique'               => 'El valor del campo :attribute ya está en uso.',
   'uploaded'             => 'El campo :attribute no se pudo subir.',
   'url'                  => 'El formato del campo :attribute es inválido.',
   'uuid'                 => 'El campo :attribute debe ser un UUID válido.',

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

   'custom'               => [
      'attribute-name'     => [
         'rule-name' => 'custom-message',
      ],
      // *********** REGLAS PARA TABLA: ROLES ************
      'nom_rol'            => [
         'required' => 'Ingresar el nombre del rol.',
         'max'      => 'El nombre del rol debe contener como máximo 20 caracteres.',
         'unique'   => 'El nombre del rol ya esta siendo utilizado.',
      ],
      'permisos'           => [
         'required' => 'Seleccionar como mínimo un permiso.',
      ],
      'est_rol'            => [
         'required' => 'Selecciona estado del rol.',
      ],

      // *********** REGLAS PARA TABLA: PERMISOS ************
      'mod_permiso'        => [
         'required' => 'Ingresar nombre del módulo.',
         'max'      => 'El nombre del módulo debe contener como máximo 20 caracteres.',
      ],
      'nom_permiso_hidden' => [
         'required' => 'Ingresar nombre de la acción.',
         'max'      => 'El nombre de la acción debe contener como máximo 20 caracteres.',
         'unique'   => 'El nombre de la acción ya esta siendo utilizado para este módulo.',
      ],
      'est_permiso'        => [
         'required' => 'Selecciona el estado del permiso.',
      ],

      // *********** REGLAS PARA TABLA: EQUIPOS ************
      'nom_equi'           => [
         'required' => 'Ingresar nombre del equipo.',
         'max'      => 'El nombre del equipo debe contener como máximo 20 caracteres.',
         'unique'   => 'El nombre del equipo ya esta siendo utilizado.',
      ],
      'est_equi'           => [
         'required' => 'Selecciona estado del equipo.',
      ],

      // *********** REGLAS PARA TABLA: LOCALES ************
      'cod_local'          => [
         'required' => 'Ingresar el código del local.',
         'max'      => 'El código de local debe contener como máximo 3 caracteres.',
         'unique'   => 'El código de local ya esta siendo utilizado.',
      ],
      'des_local'          => [
         'required' => 'Ingresar el nombre de local.',
         'max'      => 'El nombre de local debe contener como máximo 50 caracteres.',
         'unique'   => 'El nombre de local ya esta siendo utilizado.',
      ],
      'est_local'          => [
         'required' => 'Selecciona estado del local.',
      ],

      // *********** REGLAS PARA TABLA: AREAS ************
      'local'              => [
         'required' => 'Seleccionar el local.',
      ],

      'cod_area'           => [
         'required' => 'Ingresar el código del área.',
         'max'      => 'El código de área debe contener como máximo 15 caracteres.',
         'unique'   => 'El código de área ya esta siendo utilizado.',
      ],

      'des_area'           => [
         'required' => 'Ingresa el nombre del área.',
         'max'      => 'La nombre de área debe contener como máximo 100 caracteres.',
         'unique'   => 'El nombre de área ya esta siendo utilizado.',
      ],

      'est_area'           => [
         'required' => 'Selecciona el estado del área.',
      ],

      // *********** REGLAS PARA TABLA: OFICINAS ************
      'cod_oficina'        => [
         'required' => 'Ingresar el código de la oficina.',
         'max'      => 'El código de oficina debe contener como máximo 15 caracteres.',
         'unique'   => 'El código de oficina ya esta siendo utilizado.',
      ],
      'des_oficina'        => [
         'required' => 'Ingresar el nombre de la oficina.',
         'max'      => 'El nombre de la oficina debe contener como máximo 100 caracteres.',
         'unique'   => 'El nombre de la oficina ya esta siendo utilizado.',
      ],
      'area'               => [
         'required' => 'Seleccionar el área.',
      ],
      'est_oficina'        => [
         'required' => 'Selecciona el estado de la oficina.',
      ],

      // *********** REGLAS PARA TABLA: EMPLEADOS ************
      'tipodoc_emp'        => [
         'required' => 'Seleccionar el tipo el de documento.',
         'max'      => 'El tipo de documento debe contener como máximo 50 caracteres.',
      ],
      'nrodoc_emp'         => [
         'required' => 'Ingresar el número de documento.',
         'min'      => 'El número de documento debe contener 8 caracteres.',
         'max'      => 'El número de documento debe contener como máximo 8 caracteres.',
         'unique'   => 'El número de documento ya esta siendo utilizado..',
      ],
      'fec_nac'            => [
         'required'    => 'Ingresar su fecha de nacimiento.',
         'date'        => 'Ingresar una fecha correcta.',
         'date_format' => 'El formato es incorrecto.',
      ],
      'nom_emp'            => [
         'required' => 'Ingresar los nombres del personal.',
         'max'      => 'Los nombres debe contener como máximo 40 caracteres.',
      ],
      'ape_emp'            => [
         'required' => 'Ingresar los apellidos del personal.',
         'max'      => 'Los apellidos deben contener como máximo 40 caracteres.',
      ],
      'gen_emp'            => [
         'required' => 'Seleccionar el genero del personal.',
      ],
      'email_emp'          => [
         'required' => 'Ingresar una dirección de correo.',
         'unique'   => 'La dirección de correo ya esta siendo utilizado..',
         'email'    => 'Ingrese una dirección de correo válida.',
      ],
      'cel_emp'            => [
         'max' => 'El número de celular debe contener como máximo 9 caracteres.',
         'min' => 'El número de celular debe contener al menos 9 caracteres.',
      ],
      'est_emp'            => [
         'required' => 'Selecciona estado del personal.',
      ],
      'prof_emp'           => [
         'required' => 'Seleccionar profesión del personal.',
      ],
      'cargo_emp'          => [
         'required' => 'Seleccionar el cargo del personal.',
      ],
      'equipo_emp'         => [
         'required' => 'Seleccionar el cargo del personal.',
      ],
      // *********** REGLAS PARA TABLA: USUARIOS ************
      'nom_usu'            => [
         'required' => 'Ingresar nombre de usuario.',
         'unique'   => 'El nombre de usuario ya esta siendo utilizado..',
      ],
      'rol_usu'            => [
         'required' => 'Seleccionar rol del usuario.',
      ],
      'pass_usu'           => [
         'required' => 'Ingresar una nueva contraseña.',
         'min'      => 'La contraseña debe contener al menos 4 caracteres.',
         'max'      => 'La contraseña debe contener como máximo 20 caracteres.',
      ],
      'oldpass_usu'        => [
         'required' => 'Ingresar la contraseña actual.',
      ],
      'repass_usu'         => [
         'required' => 'Confirmar la contraseña.',
         'min'      => 'La contraseña debe contener al menos 4 caracteres.',
         'max'      => 'La contraseña debe contener como máximo 20 caracteres.',
         'same'     => 'Las contraseñas no coinciden.',
      ],
      'email_usu'          => [
         'required' => 'Ingresar una dirección de correo.',
         'unique'   => 'La dirección de correo ya esta siendo utilizado..',
         'email'    => 'Ingrese una dirección de correo válida.',
      ],
      'est_usu'            => [
         'required' => 'Selecciona estado del usuario.',
      ],
      'imagen_usu'         => [
         'max' => 'La imagen no debe sobrepasar los 1024 KB.',
      ],

      // *********** REGLAS PARA TABLA: COORDINACIONES ************
      'nom_equipo'         => [
         'required' => 'Seleccionar un equipo.',
      ],
      'hoja_ent'           => [
         'required'       => 'Ingresar la cantidad de hojas de trabajo.',
         'numeric'        => 'Ingresar solo números.',
         'digits_between' => 'Ingresar de 1 a 4 digitos.',
      ],
      'hoja_ret'           => [
         'required'       => 'Ingresar la cantidad de hojas de trabajo.',
         'numeric'        => 'Ingresar solo números.',
         'digits_between' => 'Ingresar de 1 a 4 digitos.',
      ],
      'sticker_ent'        => [
         'required'       => 'Ingresar la cantidad de sticker.',
         'numeric'        => 'Ingresar solo números.',
         'digits_between' => 'Ingresar de 1 a 4 digitos.',
      ],
      'sticker_ret'        => [
         'required'       => 'Ingresar la cantidad de sticker.',
         'numeric'        => 'Ingresar solo números.',
         'digits_between' => 'Ingresar de 1 a 4 digitos.',
      ],
      'adic_ret'           => [
         'numeric'        => 'Ingresar solo números.',
         'digits_between' => 'Ingresar de 1 a 4 digitos.',
      ],
      'fec_ent'            => [
         'required'    => 'Ingresar una fecha válida.',
         'date_format' => 'Ingresar una fecha válida.',
      ],
      'fec_ret'            => [
         'required'       => 'Ingresar una fecha válida.',
         'date_format'    => 'Ingresar una fecha válida.',
         'after_or_equal' => 'La fecha de retorno debe ser igual o posterior a la fecha de entrega.',
      ],
      'bienes_ubi'         => [
         'required'       => 'Ingresar la cantidad de bienes ubicados.',
         'numeric'        => 'Ingresar solo números.',
         'digits_between' => 'Ingresar de 1 a 4 digitos.',
      ],
      'bienes_noubi'       => [
         'required'       => 'Ingresar la cantidad de bienes no ubicados.',
         'numeric'        => 'Ingresar solo números.',
         'digits_between' => 'Ingresar de 1 a 4 digitos.',
      ],
      'bienes_adic'        => [
         'numeric'        => 'Ingresar solo números.',
         'digits_between' => 'Ingresar de 1 a 4 digitos.',
      ],
      'oficina'            => [
         'required' => 'Seleccionar la oficina.',
      ],

      // *********** REGLAS PARA TABLA: SUPERVISIONES ************
      'equipo'             => [
         'required' => 'Seleccionar un equipo.',
      ],
      'bienes_enc'         => [
         'required' => 'Ingresar la cantidad de bienes encontrados.',
      ],

      // *********** REGLAS PARA TABLA: BIENES ************
      'local_db'           => [
         'required' => 'Seleccionar el local.',
      ],
      'area_db'            => [
         'required' => 'Seleccionar el area.',
      ],
      'oficina_db'         => [
         'required' => 'Seleccionar la oficina.',
      ],

      'local_enc'          => [
         'required' => 'Seleccionar el local.',
      ],
      'area_enc'           => [
         'required' => 'Seleccionar el area.',
      ],
      'oficina_enc'        => [
         'required' => 'Seleccionar la oficina.',
      ],

      'files'        => [
         'required' => 'Ingresar el archivo para importar.',
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

   'attributes'           => [],

];
