# esolutions/laravel

Utilidades base para proyectos Laravel del ecosistema ESolutions.

## Instalación

```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/eriquegasparcarlos/esolutions-laravel" }
],
"require": {
    "esolutions/laravel": "^1.0"
}
```

```bash
composer require esolutions/laravel
```

## Namespace

```
Esolutions\Laravel\
```

---

## Auth — `AuthHelper`

Verifica que la contraseña del request coincida con la del usuario autenticado.

```php
use Esolutions\Laravel\Auth\AuthHelper;

if (!AuthHelper::checkPassword($request->input('password'))) {
    return ApiResponse::error('La contraseña es incorrecta', 403);
}
```

---

## Http — `ApiResponse`

Respuestas JSON estandarizadas con encoding UTF-8.

```php
use Esolutions\Laravel\Http\ApiResponse;

return ApiResponse::success('Registro guardado', 201, $data);
return ApiResponse::error('No encontrado', 404);
```

| Método | Parámetros | Descripción |
|---|---|---|
| `success($message, $code, $data)` | `string, int=200, array=null` | Respuesta exitosa |
| `error($message, $code, $errors)` | `string, int=500, array=null` | Respuesta de error |
| `response($data, $code)` | `array, int=200` | Respuesta genérica |

### Funciones globales

El paquete registra `apiSuccess()` y `apiError()` como funciones globales que delegan a `ApiResponse`:

```php
apiSuccess('Guardado correctamente', 200, $data);
apiError('Error al procesar', 500);
```

---

## Cache

### `TraitCache`

Trait base para clases de cache del proyecto. Proporciona nombre de clave y limpieza automática.
Al ejecutar `clearCache()` dispara el evento `CacheTableCleared`.

```php
use Esolutions\Laravel\Cache\TraitCache;

class PlanCache
{
    use TraitCache;

    static function getModel(): Plan
    {
        return new Plan();
    }

    static function getCache(): array
    {
        $key = self::getNameCache();

        return Cache::remember($key, 7200, function () {
            return Plan::query()->get()->map(fn($r) => [
                'id'    => $r->id,
                'name'  => $r->name,
                'label' => $r->name,
            ])->toArray();
        });
    }
}

// Uso
PlanCache::clearCache(); // limpia cache y dispara CacheTableCleared
$data = PlanCache::getCache();
```

**Métodos que provee el trait:**

| Método | Descripción |
|---|---|
| `getNameCache()` | Genera la clave de cache basada en la tabla del modelo |
| `clearCache()` | Olvida la cache y dispara el evento `CacheTableCleared` |

**Métodos que debe implementar la clase:**

| Método | Descripción |
|---|---|
| `getModel()` | Retorna instancia del modelo Eloquent |
| `getCache()` | Retorna los datos cacheados |

### `CacheRegistry`

Escanea `app/Cache/` automáticamente, llama `getCache()` en cada clase encontrada y agrega los resultados. Usado por `AppController::getTables()`.

```php
use Esolutions\Laravel\Cache\CacheRegistry;

$tables = CacheRegistry::getTables();
// → ['plans' => [...], 'translations' => [...]]
```

**Convención:** Las clases deben llamarse `{Nombre}Cache` y tener el método estático `getCache()`.

### `HelperCache`

Genera nombres de claves de cache consistentes.

```php
use Esolutions\Laravel\Cache\HelperCache;

$key = HelperCache::nameCache('plans'); // → "k_table_plans"
```

---

## Events — `CacheTableCleared`

Evento disparado automáticamente por `TraitCache::clearCache()`.
Los proyectos que necesiten reaccionar (broadcast, notificaciones, etc.) registran un listener.

```php
// app/Listeners/BroadcastCacheUpdate.php
use Esolutions\Laravel\Events\CacheTableCleared;

class BroadcastCacheUpdate
{
    public function handle(CacheTableCleared $event): void
    {
        broadcast(new SystemTableUpdated($event->table, $event->data))->toOthers();
    }
}

// app/Providers/EventServiceProvider.php
protected $listen = [
    CacheTableCleared::class => [BroadcastCacheUpdate::class],
];
```

Proyectos sin broadcast simplemente no registran el listener.

**Propiedades del evento:**

| Propiedad | Tipo | Descripción |
|---|---|---|
| `$table` | `string` | Nombre de la tabla (ej: `plans`, `translations`) |
| `$data` | `array` | Datos actualizados tras limpiar la cache |

---

## Support

### `StringHelper`

```php
use Esolutions\Laravel\Support\StringHelper;

StringHelper::upper('hola mundo');           // "HOLA MUNDO"
StringHelper::lower('HOLA MUNDO');           // "hola mundo"
StringHelper::removeSpaces('hola  mundo');   // "hola mundo"
StringHelper::removeNewLines("hola\nmundo"); // "hola | mundo"
StringHelper::random(8);                     // "A3KX92BM"
StringHelper::random(6, '0123456789');       // "482901"
```

### `NumberHelper`

```php
use Esolutions\Laravel\Support\NumberHelper;

NumberHelper::format(1234.5);     // "1234.50"
NumberHelper::format(1234.5, 4);  // "1234.5000"
```

### `SystemHelper`

```php
use Esolutions\Laravel\Support\SystemHelper;

SystemHelper::isWindows(); // true / false
SystemHelper::getDomain(); // "garcia.intipos13.oo"
```

---

## Logging — `LogHelper`

Registra excepciones con contexto completo en `storage/logs/user-{id}.log`.

```php
use Esolutions\Laravel\Logging\LogHelper;

try {
    // ...
} catch (Throwable $e) {
    LogHelper::logUserException($e, $request);
}
```

Captura: mensaje, archivo, línea, URL, método HTTP, input, usuario, IP, user agent, headers.

---

## Console — `ProgressBarHelper`

Barra de progreso visual para comandos Artisan.

```php
use Esolutions\Laravel\Console\ProgressBarHelper;

$bar = new ProgressBarHelper(barLength: 30);

foreach ($records as $i => $record) {
    // procesar...
    $bar->render($i + 1, count($records), 'success', $record->name);
}
```

```
Progreso: [████████████░░░░░░░░░░░░░░░░░░] 12/30 (40.0%) - García S.A.C.
```

| Status | Color |
|---|---|
| `success` | Verde |
| `error` | Rojo |
| `warning` | Amarillo |
| `info` | Blanco |
