# eCommerce MercadoPago Chile

Sistema de Pagos con MercadoPago para Chile.

## Requerimientos

* PHP5
* CURL
* extensión PHP-CURL

## Instalación

### Usando GIT

En el directorio de plugins de wordpress ejecutar el siguiente comando en consola.
```bash
    git clone https://github.com/ctala/WooMercadoPagosChile.git
```
Con esto ahora en el modo de desarrollo puedes actualizar a la ultima version sin problemas.

### Utilizando el ZIP

Descargar la última versión del repositorio en el siguiente link :
```
https://github.com/ctala/WooMercadoPagosChile/archive/master.zip
```
Luego simplemente agregar el plugin como cualquier otro que agregarías a wordpress al subirlo.

## TODO
* ~~Añadir tipos de pago para poder excluir de manera selectiva.~~ **25/01/2015**
* Eliminar debug de la redirección

## Usuarios de Prueba

### VENDEDOR
Con este usuario enlazaremos woocommerce para las pruebas.

```bash
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


# Changelog
* V1.4.2 Se agregan mensajes a la orden para validar su estado.
* V1.4.1 Se carga el CSS solo cuando es necesario.
* V1.4 Acepta pago en cuotas.
* V1.3 Se elimina JQuery y se usa directamente desde wordpress.
* V1.2 Se incluye JQuery como archivo en vez de url.
* V1.1 Se incluyen las librerías de Bootstrap de manera local.
* V1.0 Version Inicial