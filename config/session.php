<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Controlador de Sesión Predeterminado
    |--------------------------------------------------------------------------
    |
    | Esta opción controla el controlador de sesión "predeterminado" que se
    | utilizará en las solicitudes. Por defecto, utilizaremos el controlador
    | nativo ligero, pero puedes especificar cualquiera de los otros
    | controladores maravillosos proporcionados aquí.
    |
    | Soportado: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Duración de la Sesión
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar el número de minutos que deseas que la sesión
    | permanezca inactiva antes de que expire. Si deseas que expire
    | inmediatamente al cerrar el navegador, configura esta opción.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Encriptación de la Sesión
    |--------------------------------------------------------------------------
    |
    | Esta opción te permite especificar fácilmente que todos tus datos de
    | sesión deben ser encriptados antes de ser almacenados. Toda la
    | encriptación se realizará automáticamente por Laravel y puedes usar
    | la sesión como de costumbre.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | Ubicación de Archivos de Sesión
    |--------------------------------------------------------------------------
    |
    | Al usar el controlador de sesión nativo, necesitamos una ubicación donde
    | se puedan almacenar los archivos de sesión. Se ha establecido un valor
    | predeterminado para ti, pero se puede especificar una ubicación
    | diferente. Esto solo es necesario para sesiones de archivos.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Conexión de Base de Datos de Sesión
    |--------------------------------------------------------------------------
    |
    | Al usar los controladores de sesión "database" o "redis", puedes
    | especificar una conexión que se debe usar para gestionar estas sesiones.
    | Esto debe corresponder a una conexión en tus opciones de configuración
    | de base de datos.
    |
    */

    'connection' => env('SESSION_CONNECTION', null),

    /*
    |--------------------------------------------------------------------------
    | Tabla de Base de Datos de Sesión
    |--------------------------------------------------------------------------
    |
    | Al usar el controlador de sesión "database", puedes especificar la tabla
    | que debemos usar para gestionar las sesiones. Por supuesto, se ha
    | proporcionado un valor predeterminado sensato para ti; sin embargo,
    | eres libre de cambiar esto según sea necesario.
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Almacén de Caché de Sesión
    |--------------------------------------------------------------------------
    |
    | Al usar los controladores de sesión "apc", "memcached" o "dynamodb",
    | puedes listar un almacén de caché que se debe usar para estas sesiones.
    | Este valor debe corresponder con uno de los almacenes de caché
    | configurados en la aplicación.
    |
    */

    'store' => env('SESSION_STORE', null),

    /*
    |--------------------------------------------------------------------------
    | Lotería de Barrido de Sesión
    |--------------------------------------------------------------------------
    |
    | Algunos controladores de sesión deben barrer manualmente su ubicación de
    | almacenamiento para deshacerse de las sesiones antiguas. Aquí están las
    | probabilidades de que esto ocurra en una solicitud dada. Por defecto,
    | las probabilidades son 2 de 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Nombre de la Cookie de Sesión
    |--------------------------------------------------------------------------
    |
    | Aquí puedes cambiar el nombre de la cookie utilizada para identificar una
    | instancia de sesión por ID. El nombre especificado aquí se usará cada
    | vez que el marco cree una nueva cookie de sesión para cada controlador.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Ruta de la Cookie de Sesión
    |--------------------------------------------------------------------------
    |
    | La ruta de la cookie de sesión determina la ruta para la cual la cookie
    | será considerada disponible. Normalmente, esta será la ruta raíz de tu
    | aplicación, pero eres libre de cambiar esto cuando sea necesario.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Dominio de la Cookie de Sesión
    |--------------------------------------------------------------------------
    |
    | Aquí puedes cambiar el dominio de la cookie utilizada para identificar una
    | sesión en tu aplicación. Esto determinará a qué dominios estará
    | disponible la cookie en tu aplicación. Se ha establecido un valor
    | predeterminado sensato.
    |
    */

    'domain' => env('SESSION_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Cookies Solo HTTPS
    |--------------------------------------------------------------------------
    |
    | Al configurar esta opción en verdadero, las cookies de sesión solo se
    | enviarán de vuelta al servidor si el navegador tiene una conexión HTTPS.
    | Esto evitará que la cookie se envíe a ti si no se puede hacer de forma
    | segura.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE', false),

    /*
    |--------------------------------------------------------------------------
    | Solo Acceso HTTP
    |--------------------------------------------------------------------------
    |
    | Configurar este valor en verdadero evitará que JavaScript acceda al valor
    | de la cookie y la cookie solo será accesible a través del protocolo HTTP.
    | Eres libre de modificar esta opción si es necesario.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Cookies Same-Site
    |--------------------------------------------------------------------------
    |
    | Esta opción determina cómo se comportan tus cookies cuando se realizan
    | solicitudes entre sitios, y se puede usar para mitigar ataques CSRF.
    | Por defecto, no habilitamos esto ya que hay otros servicios de
    | protección CSRF en su lugar.
    |
    | Soportado: "lax", "strict", "none"
    |
    */

    'same_site' => 'lax',

];