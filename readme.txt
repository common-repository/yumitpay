=== YumitPay Paga con criptomonedas ===
Contributors: jonthanyumit
Tags: Payment, cryptocurrency, Bitcoin, Ethereum, Solana
Requires at least: 4.7
Tested up to: 6.4
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

YumitPay facilita a comercios aceptar criptomonedas con WooCommerce, ofreciendo transacciones seguras sin volatilidad.

== Description ==

YumitPay es una pasarela de pagos que le permite a tus usuarios pagar con criptomonedas. Ofrece una integración simple con WooCommerce, permitiendo a los comercios aceptar Bitcoin, USDC, USDT, Solana, entre otras criptomonedas, sin tener que preocuparse por la volatilidad de recaudación.

## Paises Disponibles:
- Chile

https://www.youtube.com/watch?v=Cd_-ZV1Rhb4

== Installation ==

### Requisitos

Para instalar YumitPay, se necesita:

- WordPress Version 5.3 o más reciente (instalado)
- WooCommerce Version 3.9 o más reciente (instalado y activado)
- PHP Version 7.2 o más reciente
- Cuenta en YumiPay

### Alta en YumitPay y Generación de Claves

1. Ingresa a [YumitPay](https://www.yumitpay.com) y selecciona el botón "Abrir cuenta" o ve directamente a [Crear cuenta](https://app.yumitpay.com/signup).
2. Sigue los pasos para crear tu cuenta. Si tienes problemas puedes consultar la guía de creación de cuenta en Yumit "aquí" o póngase en contacto con [contacto@yumitpay.com](mailto:contacto@yumitpay.com).
3. Una vez creada la cuenta puedes acceder al portal de YumitPay a través [app.yumitpay.com](https://app.yumitpay.com) (tener en cuenta que las funcionalidades se encuentran limitadas ya que primero tiene que solicitar la alta de comercio).
4. Solicita Alta de Comercio a [contacto@yumitpay.com](mailto:contacto@yumitpay.com).
5. En el portal de YumitPay selecciona la opción "APIs Keys".
6. Genera una nueva APIKEY (Se mostrará en modal con la información del "Client ID" y "Clave API", guárdalos en un borrador ya que nos servirá más adelante en la configuración de Yumitpay con WooCommerce en Wordpress).

### Instrucciones para WordPress

1. Inicie sesión en el administrador de WordPress.
2. Vaya a Plugins > Plugins Instalados.
3. Busque el complemento de Yumit Pay.
4. Haga clic en Instalar ahora y espere hasta que el complemento se instale correctamente.
5. Puede activar el complemento inmediatamente haciendo clic en Activar ahora en la página de éxito. Si desea activarlo más tarde, puede hacerlo a través de Plugins > Complementos instalados.

### Instalación manual:

1. Descargue el archivo [zip](https://downloads.wordpress.org/plugin/yumitpay.zip) ahora o desde el [Directorio].
2. Descomprima la carpeta y cambie el nombre a 'yumitpay'.
3. Copie el archivo 'yumitpay' en su directorio de WordPress, dentro de la carpeta 'Plugins'.

### Instalación y configuración en WordPress

Siga los pasos a continuación para conectar el plugin a su cuenta de Yumit:

Siga los pasos a continuación para conectar el plugin a su cuenta de Yumit:

1. Una vez que haya activado el complemento YumitPay, diríjase a WooCommerce > Ajustes.
2. En la pestaña "Pagos", busque YumitPay en la lista de métodos de pago y haga clic en "Configurar" o "Manage".
3. En la página de configuración de YumitPay:

    •	Registre la siguiente información:
        - **Habilitar/Deshabilitar**: Marque la casilla para habilitar YumitPay.
        - **Título**: Este campo controla el título que el usuario ve durante el proceso de pago.
        - **Descripción**: Este campo controla la descripción que el usuario ve durante el proceso de pago.
        - **Cliente ID**: Ingrese el ID de cliente que obtuvo al generar su API Key en YumitPay.
        - **Clave API**: Ingrese la Clave API que obtuvo al su API Key en YumitPay.
        - **Webhook**: Copie este enlace y péguelo en la configuración de su cuenta de YumitPay para recibir notificaciones de las transacciones.

4. Haga clic en "Guardar cambios".

¡Felicidades! Ahora ha configurado con éxito la pasarela de pago de YumitPay en su tienda WooCommerce.

== ¿Qué es YumitPay? ==

YumitPay es un sistema de recaudación y pagos desarrollado para que los comercios, negocios y empresas de servicios puedan recibir pagos de sus clientes con criptomonedas, sin tener que pagar comisión de recaudación. Lo puedes usar en tu negocio sin necesidad de hacer una integración técnica y sin tener que preocuparte por la volatilidad de las criptomonedas. En YumitPay te lo hacemos fácil.
Paises Disponibles:
Chile

### ¿Por qué aceptar pagos con criptomonedas?

- Más de 20 millones de personas en Latam tienen criptomonedas y están dispuestos a usarlas para pagar.
- Más opciones de pago para tus clientes aumentan la posibilidad de cerrar la venta.
- Elimina totalmente los costos de fraude y contracargos.
- Obtén una ventaja competitiva para tu negocio.
- Permite pagos internacionales sin el uso de tarjetas de crédito.

### ¿Quién puede usar YumitPay?

Si vendes productos de consumo masivo, servicios, entradas para espectáculos, autos, casas... lo que sea, YumitPay es para ti. Yumitpay fue desarrollado para todo el comercio minorista, independiente de su tamaño e independiente de los canales de venta, presencial o digital.

## ¿Cuáles son los beneficios de YumitPay?

- Sin comisión: Acepta pagos en las criptomonedas de mayor uso sin pagar comisión.
- Gratis: Nunca pagarás por abrir o mantener tu cuenta.
- Control: Accede a un panel con toda la información de los pagos que recibiste.
- Integración simple: La integración es muy simple, puedes usar el widget de YumitPay y las herramientas a tu disposición.
- 100% Protegido: Estas protegido con el sistema Anti-Lavado de Activos y el monitoreo de las transacciones.
- Directo a tu cuenta: Puedes recibir tu dinero directo en tu cuenta bancaria sin retrasos.

## Servicios Externos

Este plugin se basa en varios servicios externos para funcionar correctamente:

1. **YumitPay**: Este es el servicio principal que permite a los usuarios realizar pagos con criptomonedas. 
   - Enlace al servicio: https://merchants-api.yumitpay.com/api, https://payments-api.yumitpay.com/api
   - Términos de uso: https://www.yumitpay.com/terms-conditions/
   - Política de privacidad: https://www.yumitpay.com/privacy-policy/

2. **Microsoft Online**: Este servicio se utiliza para la autenticación de usuarios.
   - Enlace al servicio: https://login.microsoftonline.com/
   - Términos de uso: https://learn.microsoft.com/es-mx/legal/termsofuse
   - Política de privacidad: https://privacy.microsoft.com/es-mx/privacystatement

Por favor, asegúrate de revisar los términos de uso y las políticas de privacidad de estos servicios antes de utilizar nuestro plugin.

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png
3. screenshot-3.png
4. screenshot-4.png
5. screenshot-5.png
6. screenshot-6.png
7. screenshot-7.png
8. screenshot-8.png
9. screenshot-9.png

== Frequently Asked Questions ==

= ¿Qué es YumitPay? =
Es una plataforma de pagos que permite a los comercios cobrar por productos y servicios en criptomonedas, sin la necesidad de lidiar con la volatilidad en el valor de las monedas, la dificultad tecnológica o los aspectos regulatorios.

### ¿Quién puede usar YumitPay? 
YumitPay fue diseñado para que los procesadores de pago puedan proveer capacidades de recaudación con criptomonedas a sus clientes, cualquier negocio minorista legalmente registrado en su país que no sea una actividad prohibida. Los comercios también son bienvenidos a usar YumitPay directamente. Por ahora no puedes usar YumitPay para recaudar como persona natural. Si aún no has abierto tu negocio, puedes de igual forma abrir una cuenta en YumitPay y usarla con algunas restricciones para poder probar y configurar, pero no puedes usarla de forma productiva.
¡Haz clic en Abrir Cuenta y ya puedes comenzar a usar YumitPay!
¿Quién puede pagar con criptomonedas?
Cualquier persona que tenga una wallet con BTC, USDC, ETH u otros tokens, puede usarla para pagar en un comercio que acepte criptomonedas con YumitPay.

### ¿Por qué esto sería conveniente aceptar criptomonedas para mi negocio y mis clientes?
Hay muchas razones para aceptar criptomonedas como forma de pago, pero hay 3 argumentos que nos gustan mucho:
	•	Hay más de 300 millones de personas que compraron criptomonedas para invertir y tienen dinero “estancado” porque no hay forma fácil de usarlo directamente. La evidencia muestra que cuando se abren alternativas para gastar ese dinero, los holders agradecen estos avances y privilegian estos comercios.
	•	Ganar preferencia de compra. Los clientes prefieren aquellos comercios que proveen las formas de pago que ellos quieren usar. Tener la opción de pago con criptomonedas representa una ventaja frente a competidores que no lo tienen.
	•	Mejorar el margen de la operación. Recaudar con criptomonedas no tiene costo lo que significa que te ahorras en promedio un 3% de comisión, que pagas cuando recaudas con tarjetas de crédito. Estos 3 puntos porcentuales pueden representar entre un 10% y 20% del margen de tus productos. Ya sea que mejoras el margen de tu negocio o que traspasas este menor costo al precio de los clientes, existe un beneficio económico asociado a la recaudación con criptomonedas.
### ¿Es legal recaudar pagos en criptomonedas?
Si, es perfectamente legal, al igual como es legal comprar y vender criptomonedas, con excepción de aquellos países que específicamente las han prohibido, por ejemplo, China o Arabia Saudita.
¿Dónde puedo usar YumitPay para recaudar?
En cualquier dispositivo que permita desplegar un código QR en una pantalla o clicar un link, por ejemplo: web checkouts, POS móvil, Redes Sociales, cajas registradoras con pantalla, ATMs, IoT, etc.

### ¿Cómo recibo mi dinero?
Puedes elegir entre recibir en moneda local en tu cuenta bancaria o en una billetera critpo de Stablecoin.

### ¿Cuánto cuesta usar YumitPay? 
YumitPay es gratis y libre gratis para tu comercio o para tu procesadora de pagos, sin restricciones ni limitaciones y por siempre. Algunos servicios que tienen costo para nosotros se cobran para cubrir ese costo. Por ejemplo, el servicio de ramp-off a una cuenta bancaria local tiene un costo asociado.
Si YumitPay es gratis y libre, ¿por qué tengo que pasar por un proceso de revisión y aceptación de términos y condiciones?
Porque queremos que YumitPay sea una plataforma de recaudación legal y segura para todos. Por esto nos tomamos con mucha seriedad la revisión de los antecedentes de las empresas que lo utilizan, así como el origen de los fondos de las personas que lo utilizan para pagar, de esta manera evitamos que se use YumitPay para actividades ilegales o prohibidas.

### ¿Qué actividades prohíben?
Todas las actividades de comercio que sean ilegales como por ejemplo venta de drogas, más otras actividades que hemos prohibido como apuestas, pornografía, venta de armas, entre otras.
¿Cómo evito tener una pérdida económica por la volatilidad de las criptomonedas?
Esto es justamente uno de los aspectos más importantes de YumitPay, y es que tu recibirás el monto total de la recaudación del producto en la moneda en que lo vendes, sin importar qué sucedió con el valor de la criptomoneda. Por ejemplo, si tu producto se vendió en $10.000 pesos locales, tu recibes $10.000 pesos locales sin importar lo que haya pasado con el valor de las monedas.

### ¿Es fácil de integrar? 
La respuesta corta es que sí. La respuesta menos corta, es que puedes usar YumitPay sin hacer una integración tecnológica, accediendo al Portal Yumit desde donde creas una orden de pago que posteriormente puedes distribuir a tu cliente por email, RRSS, Whatsapp o cualquier medio que tu elijas. Si tienes un sitio de comercio electrónico o un negocio digital, seguramente vas a querer usar YumitPay por medio de la API, desde donde puedes generar las órdenes de pago de forma integrada a tu e-commerce. Los tiempos de integración fluctúan entre 1 y 2 semanas para una persona que tenga experiencia previa integrando APIs.

### Tengo una idea para desarrollar basado en las capacidades de YumitPay, ¿Puedo hacerlo?
¡Por supuesto, por favor hazlo! Revisa la información del motor transaccional YumitCo, que es la tecnología sobre la que se construyó YumitPay.

### ¿En que paises opera Yumitpay?
Actualmente solo estamos operando en Chile, en proximas actualizaciones se estaran agregando el soporte a mas paises.

### Todavía tengo preguntas, ¿puedo hablar con alguien?
Si, escríbenos a [b2b@yumitpay.com](mailto:b2b@yumitpay.com).
Mas información en  [YumitPay](https://www.yumitpay.com/faq)

== Changelog ==

= 1.0.0 =
- Lanzamiento inicial del plugin.

== Upgrade Notice ==

= 1.0.0 =
- Versión inicial.



