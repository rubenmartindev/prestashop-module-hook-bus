# PrestaShop Hook Bus

This library provides a flexible and centralized way to **route and handle** PrestaShop hooks.

## Overview

As you develop your module and add hooks to the main file, the module can grow disproportionately; all logic ends up in a single place, breaking the SOLID Single Responsibility principle and making maintenance and readability chaotic.

Ideally, each hook should be self-contained and have a single responsibility. Making it easy to configure, use, and maintain.

Compared to managing hooks directly in your module's main class, Hook Bus offers:

- Better separation of concerns.
- Easier testing.
- Cleaner module classes.
- Dependency Injection friendly handlers.
- Reusable hook logic.

The library is composed of three main building blocks:

- **Identifier**: determines the hook identity.
- **Locator**: resolves the Handler for that identity.
- **Handler**: contains the hook business logic.

## Requirements

- PHP 5.6+
- PrestaShop 1.6.x / 1.7.x / 8.x / 9.x+

## Installation

Install via Composer in your PrestaShop module:

```bash
composer require rubenmartindev/prestashop-module-hook-bus
```

## Complete Example

A typical module structure could look like this:

```text
modules/
└── mymodule/
    ├── mymodule.php
    └── src/
        └── Hook/
            ├── DisplayHeaderHandler.php
            └── DisplayFooterHandler.php
```

Configure the Hook Bus once in the module constructor:

```php
use RubenMartinDev\PrestashopModuleHookBus\HookBusFactory;
use RubenMartinDev\PrestashopModuleHookBus\HookBusInterface;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\MethodHookIdentifier;

class MyModule extends Module
{
    /** @var HookBusInterface */
    private $hookBus;

    public function __construct()
    {
        // ...

        $this->hookBus = HookBusFactory::createWithArray(
            new MethodHookIdentifier(),
            [
                new DisplayHeaderHandler(),
                new DisplayFooterHandler(),
            ]
        );
    }

    public function hookDisplayHeader(array $params)
    {
        return $this->hookBus->dispatch(__FUNCTION__, $params);
    }

    public function hookDisplayFooter(array $params)
    {
        return $this->hookBus->dispatch(__FUNCTION__, $params);
    }
}
```

Each hook is implemented in its own Handler:

```php
use RubenMartinDev\PrestashopModuleHookBus\Handler\NamedHandlerInterface;

final class DisplayHeaderHandler implements NamedHandlerInterface
{
    public static function getIdentityName()
    {
        return 'displayHeader';
    }

    public function handle(array $params = [])
    {
        // Hook logic here
    }
}
```

## Factory

To make configuring and creating the Hook Bus easier, `HookBusFactory` provides static methods:

| Method                  | Best suited for                                       |
|-------------------------|-------------------------------------------------------|
| `create()`              | Full control over the Identifier and Locator.         |
| `createWithArray()`     | Quick setup using an array of handlers.               |
| `createWithCallable()`  | Dynamic handler resolution.                           |
| `createWithContainer()` | Symfony service containers and Dependency Injection.  |

### `HookBusFactory::create()`

| Argument          | Type                      | Description                                               |
| ------------------|---------------------------|-----------------------------------------------------------|
| `hookIdentifier`  | `HookIdentifierInterface` | The Identifier that will be used to locate the Handler.   |
| `handlerLocator`  | `HandlerLocatorInterface` | The Locator where the Handlers are registered.            |

#### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\HookBusFactory;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\LiteralIdentifier;
use RubenMartinDev\PrestashopModuleHookBus\Locator\ArrayLocator;

$arrayLocator = new ArrayLocator();
$arrayLocator->addHandler('displayHeader', new DisplayHeaderHandler());

HookBusFactory::create(
    new LiteralIdentifier(),
    $arrayLocator
);
```

### `HookBusFactory::createWithArray()`

| Argument          | Type                      | Description                                                                                                                                     |
| ------------------|---------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------|
| `hookIdentifier`  | `HookIdentifierInterface` | The Identifier that will be used to locate the Handler.                                                                                         |
| `handlers`        | `array`                   | An array with _key_ representing the Identifier and _value_ the Handler. If the handler implements `NamedHandlerInterface`, _key_ is optional.  |

#### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\HookBusFactory;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\LiteralIdentifier;

HookBusFactory::createWithArray(
    new LiteralIdentifier(),
    ['displayHeader' => new DisplayHeaderHandler()]
);
```

### `HookBusFactory::createWithCallable()`

| Argument          | Type                      | Description                                               |
| ------------------|---------------------------|-----------------------------------------------------------|
| `hookIdentifier`  | `HookIdentifierInterface` | The Identifier that will be used to locate the Handler.   |
| `callable`        | `callable`                | A callback that will resolve which Handler will be used.  |

#### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\HookBusFactory;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\LiteralIdentifier;

HookBusFactory::createWithCallable(
    new LiteralIdentifier(),
    function ($identifier) {
        if ('displayHeader' === $identifier) {
            return new DisplayHeaderHandler();
        }
    }
);
```

### `HookBusFactory::createWithContainer()`

| Argument          | Type                      | Description                                                                                                                                                         |
| ------------------|---------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `container`       | `ContainerInterface`      | Container where services are registered.                                                                                                                            |
| `hookIdentifier`  | `HookIdentifierInterface` | The Identifier that will be used to locate the Handler.                                                                                                             |
| `handlers`        | `array`                   | An array with _key_ representing the Identifier and _value_ the service to use as Handler. If the handler implements `NamedHandlerInterface`, _key_ is optional.  |

#### Example

> [!NOTE]
> Service container integration requires PrestaShop 1.7 or higher, as PrestaShop 1.6 does not use Symfony, or, use your own container, for example [`prestashop/module-lib-service-container`](https://github.com/PrestaShopCorp/module-lib-service-container).

```php
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use RubenMartinDev\PrestashopModuleHookBus\HookBusFactory;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\LiteralIdentifier;

$container = SymfonyContainer::getInstance();

HookBusFactory::createWithContainer(
    $container,
    new LiteralIdentifier(),
    ['displayHeader' => 'my_module.hook.handler.display_header']
);
```

## Identifier

Used to identify the hook and to locate the corresponding Handler during the dispatch cycle.

If the Identifier cannot resolve the identity, it will throw the exception `UnresolvedHookIdentifierException`.

### Literal

The provided string will be used literally as the identifier.

#### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\HookBusFactory;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\LiteralIdentifier;

class MyModule extends Module
{
    public function __construct()
    {
        // ...

        $this->hookBus = HookBusFactory::createWithArray(
            new LiteralIdentifier(),
            // ...
        );
    }

    public function hookDisplayHeader(array $params)
    {
        return $this->hookBus->dispatch('myCustomIdentity', $params);
    }
}
```

### Method Hook

Designed to be used inside the module's public `hook<hook_name>()` methods. It obtains the identifier from the method name; for example, the method `hookActionAdminControllerSetMedia()` will be the identifier `actionAdminControllerSetMedia`.

#### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\HookBusFactory;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\MethodHookIdentifier;

class MyModule extends Module
{
    public function __construct()
    {
        // ...

        $this->hookBus = HookBusFactory::createWithArray(
            new MethodHookIdentifier(),
            // ...
        );
    }

    public function hookDisplayHeader(array $params)
    {
        return $this->hookBus->dispatch(__FUNCTION__, $params);
    }
}
```

### Callable

Through a callback we can generate a custom identifier.

#### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\HookBusFactory;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\CallableIdentifier;

class MyModule extends Module
{
    public function __construct()
    {
        // ...

        $this->hookBus = HookBusFactory::createWithArray(
            new CallableIdentifier(function ($hookName) {
                if ('myCustomIdentity' === $hookName) {
                    return 'myCustomIdentityHandler';
                }
            }),
            // ...
        );
    }

    public function hookDisplayHeader(array $params)
    {
        return $this->hookBus->dispatch('myCustomIdentity', $params);
    }
}
```

### Custom Identifier

You can create your own Identifiers to generate custom identities. It should implement the interface `HookIdentifierInterface`.

#### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\Identifier\HookIdentifierInterface;

final class MyCustomIdentifier implements HookIdentifierInterface
{
    public function identify($hookName)
    {
        return \strtolower($hookName);
    }
}
```

## Locator

Where Handlers are located and which identities are associated with them.

If the Locator cannot resolve which Handler is assigned to the identity, it will throw the exception `MissingHandlerException`.

### Array

#### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\Locator\ArrayLocator;

$locator = new ArrayLocator();

$locator->addHandler('displayHeader', new DisplayHeaderHandler());
$locator->addHandler('displayFooter', new DisplayFooterHandler());
```

### Callable

#### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\Locator\CallableLocator;

$locator = new CallableLocator(function ($hookName) {
    if ('displayHeader' === $hookName) {
        return new DisplayHeaderHandler();
    }

    if ('displayFooter' === $hookName) {
        return new DisplayFooterHandler();
    }

    return null;
});
```

### Container

#### Example

```php
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use RubenMartinDev\PrestashopModuleHookBus\Locator\ContainerLocator;

$container = SymfonyContainer::getInstance();

$locator = new ContainerLocator($container);

$locator->addHandler('displayHeader', 'my_module.hook.handler.display_header');
$locator->addHandler('displayFooter', 'my_module.hook.handler.display_footer');
```

### Custom Locator

You can create your own Locators that return which Handler will manage the hook. It should implement the interface `HandlerLocatorInterface`.

If you want it to be compatible with the [Factory](#factory), you should implement the interface `AppendableHandlerLocatorInterface` to enable the `addHandler()` method.

#### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\Locator\HandlerLocatorInterface;

final class MyCustomLocator implements HandlerLocatorInterface
{
    public function getHandlerForIdentity($identity)
    {
        if ('displayHeader' === $identity) {
            return new DisplayHeaderHandler();
        }

        if ('displayFooter' === $identity) {
            return new DisplayFooterHandler();
        }

        throw MissingHandlerException::forIdentity($identity);
    }
}
```

## Handler

Handlers are responsible for resolving what to do with the hook. They must implement the interface `HookHandlerInterface`.

The `handle()` method receives the `$params` argument, which is the same argument that the native `hook<hook_name>()` method of the module received.

If the Handler implements the interface `NamedHandlerInterface`, the [Factory](#factory) can infer the identity automatically from the static method `getIdentityName()`.

### Example

```php
use RubenMartinDev\PrestashopModuleHookBus\Handler\NamedHandlerInterface;

final class DisplayHeaderHandler implements NamedHandlerInterface
{
    public static function getIdentityName()
    {
        return 'displayHeader';
    }

    public function handle(array $params = [])
    {
        $cartTotal = $params['cart']->getOrderTotal();

        return Tools::displayPrice($cartTotal);
    }
}
```

## Exceptions

All library exceptions extend `HookBusException`.

| Exception                           | Description                                     |
|-------------------------------------|-------------------------------------------------|
| `MissingHandlerException`           | No Handler was found for the resolved identity. |
| `UnresolvedHookIdentifierException` | The Identifier could not resolve an identity.   |

## Development Environment

The repository includes a Docker Compose environment for working with a
specific PrestaShop version. The PrestaShop core is mounted in
`prestashop/<PS_VERSION_TAG>` so it can be inspected and modified locally.
Those installation files are ignored by Git.

Copy the environment template and start the default instance:

```bash
cp .env.dist .env
make up
```

The Compose project name is generated from `PS_VERSION_TAG`. Different versions
can run simultaneously when using different host ports:

```bash
make up PS_VERSION_TAG=1.6 PS_HTTP_PORT=8080
make up PS_VERSION_TAG=9 PS_HTTP_PORT=8090
```

Manage an instance by passing its version again:

```bash
make logs PS_VERSION_TAG=1.6
make down PS_VERSION_TAG=1.6
```

Additional Docker Compose options can be passed after `--`. Instance variables
can still be provided through `.env`, the environment, or directly on the
`make` command:

```bash
# Remove the containers and their volumes
make down -- --volumes

# Recreate a specific PrestaShop instance
make up PS_VERSION_TAG=9 PS_HTTP_PORT=8090 -- --force-recreate

# Show the last 100 log lines
make logs -- --tail 100

# Show a specific service
make ps -- prestashop
```

The database image is MySQL and its tag can be changed with `DB_VERSION_TAG`.
