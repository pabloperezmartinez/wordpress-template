# Template de Wordpress con Fomantic UI y Docker Compose
El objetivo del presente proyecto es tener una base para poder generar de manera rápida un sitio de wordpress con Fomantic UI que sea fácil de personalizar, de mantener y de modificar. El sitio se encuentra contenerizado y orquestado por docker-compose

## Acerca de Wordpress
Wordpress es el CMS más popular el cual sirve para la creación rápida de bitácoras. para mayor información visitar https://es.wordpress.org/

## Acerca de Fomantic UI
Fomantic UI es un un Framework de UI que se nace a partir de Semantic ui. Este permite generar rápidamente temas completos con íconos y una variedad de componentes gráficos. Para más información visita https://fomantic-ui.com

# Instalación
## Requerimientos
- docker y docker-compose
## Instalar y ejecutar
Para instalar se deben configurar los siguientes comandos
1. Instalar las dependencias
~~~
npm install
~~~
2. Encender los contenedores
~~~
docker-compose up
~~~
3. En la administración de wordpress se deberá seleccionar el tema 'Semantic'
# Modificar tema
Se pueden realizar distintas modificaciones en el tema como colores y otras personalizaciones
## Colores
Se pueden agregar colores en el archivo `semantic/src/site/globals/site.variables`. A continuación se añaden las guías desde Fomantic UI: https://fomantic-ui.com/usage/theming.html
## Clases CSS Personalizadas
Se pueden agregar clases personalizadas en el archivo `semantic/src/site/globals/site.overrides`