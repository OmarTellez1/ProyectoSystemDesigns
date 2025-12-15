# AsisControl – Sistema de Asistencia
Aplicación web para registrar entradas y salidas del personal, generar reportes en PDF y gestionar usuarios y roles.

# Instalacion
-Clonar el repositorio: https://github.com/OmarTellez1/ProyectoSystemDesigns.git
-Se necesita tener instalado XAMPP para poder correr la aplicación web mediante el localhost.
-Se necesita de nodejs para las dependencias que se utilizan de javascript
-Dentro de la carpeta src/admin esta la carpeta "sql" con los scripts a ejecutar para crear la base de datos mysql.
-Se necesita tener un archivo .env con las key y values de las variables de entorno. Guiarse con ".env.example"

# Ejecucion
-Buscar la carpeta xampp dentro de su sistema, dentro de ella busque "htdcos" y dentro de alli debe poner la carpeta del proyecto.
-Abrir su editor de codigo y luego asegurese de abrir el proyecto y que la raiz del proyecto sea "ProyectoSystemDesigns"
-ejecutar en "composer install" "npm install" de esta manera descarga las dependencias del proyecto.
-luego abra XAMPP CONTROL PANEL, haga correr apache y mysql, una vez haga eso, en el navegador escriba esta url http://localhost/ProyectoSystemDesigns/src/admin/vistas/login.php

# Estructura del Proyecto
```
ProyectoSystemDesigns/
│
├── docs/          # Entregas parciales y documentación
├── src/           # Código fuente principal (frontend + backend)
├── tests/         # Pruebas automatizadas
├── .github/       # Configuración de CI/CD
├── composer.json  # Dependencias de PHP (Composer)
|-- package.json   # Dependencias javascript
└── README.md      # Este archivo
```
# Tecnologías Utilizadas
- **Backend** : PHP
- **Frontend**: HTML5, CSS3, JavaScript
- **Dependencias**: Composer, Package.json
- **Generación de PDFs**: Librerías PHP
- **Control de versiones**: Git / GitHub
