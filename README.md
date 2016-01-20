# WooMercadoPagosChile

Sistema de Pagos con MercadoPago para Chile.

## Requerimientos

* PHP5
* CURL
* extensión PHP-CURL

## Instalación

### Usando GIT

En el directorio de plugins de wordpress ejeutar el siguiente comando en consola.
    git clone https://github.com/ctala/WooMercadoPagosChile.git

Con esto ahora en el modo de desarrollo puedes actualizar a la ultima version sin problemas.


## Usuarios de Prueba

### VENDEDOR
Con este usuario enlazaremos woocommerce para las pruebas.

```
    {
        "id":203742794,
        "nickname":"TETE1929073",
        "password":"qatest6585",
        "site_status":"active",
        "email":"test_user_54452469@testuser.com"
    }

```
    id : 341939702052072
    Secret : ct9eEw4SLtPz5uFvj5OGiF21YWEJAfgG

### Comprador
Sera el encargado de realizar las compras.

```
    {
        "id":203745580,
        "nickname":"TESTEWHQDQKI",
        "password":"qatest4174",
        "site_status":"active",
        "email":
        "test_user_53956050@testuser.com"
    }

```

### Datos tarjetas de credito

Fuente : https://www.mercadopago.com.br/developers/es/related/test-payments/

#### Chile

* Visa : 4168 8188 4444 7115
* Master Card : 5416 7526 0258 2580
* American Express : 3757 781744 61804

## Usuario Real

Para obtener los datos reales para utilizar el plugin, logueate en MercadoPago.cl 
y luego ve al siguiente link : https://www.mercadopago.com/mlc/herramientas/aplicaciones 