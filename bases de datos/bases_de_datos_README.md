# 📁 bases de datos – Descripción de las Bases de Datos del Proyecto Alemandan

Este directorio contiene los archivos `.sql` correspondientes a las dos bases de datos principales utilizadas en el proyecto **Alemandan CRM**. Cada una cumple funciones específicas en la arquitectura del sistema.

---

## 📌 rol.sql

- **Propósito**: Gestionar la autenticación y autorización de usuarios dentro del sistema.
- **Contenido principal**:
  - Tabla de `usuarios` con credenciales de acceso.
  - Tabla de `roles` (por ejemplo: Administrador, Empleado, etc.).
  - Relación entre usuarios y sus roles.
- **Funcionalidad**:
  - Control de acceso dinámico según el rol del usuario.
  - Validación para acceso a módulos según permisos definidos.

---

## 📌 alemandan_db.sql

- **Propósito**: Manejar la lógica principal del negocio y las operaciones de la aplicación CRM.
- **Contenido principal**:
  - **Ventas**: Registro de operaciones en caja.
  - **Empleados**: Gestión de datos del personal.
  - **Proveedores**: Administración de proveedores y contactos.
  - **Inventario**: Gestión de productos, cantidades, precios y stock disponible.
- **Funcionalidad**:
  - Soporte para reportes y filtros por múltiples criterios.
  - Integración con el módulo visual de ventas y registros históricos.

---

## 🛠️ Recomendación

Antes de iniciar el servidor web, asegúrate de importar correctamente ambas bases de datos en tu gestor MySQL o MariaDB (por ejemplo, usando **phpMyAdmin** o desde consola).
