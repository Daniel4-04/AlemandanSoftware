# CRM Alemandan (Frontend PHP)

Interfaz administrativa para la gestión de:

- 🧾 Ventas
- 🧍 Empleados
- 📦 Inventario
- 📬 Proveedores
- 📊 Reportes con filtros por fecha, cajero o producto

## Funcionalidades principales

✅ Login y autenticación  
✅ Panel con roles (administrador)  
✅ CRUD completo de empleados y productos  
✅ Historial de ventas filtrable  
✅ Exportación a PDF y Excel usando backend Flask  
✅ Estilo visual limpio y navegación clara  
✅ Páginas legales (Términos, PQR, FAQ, etc.)  
✅ Páginas de error 404 y 500 personalizadas  

## Estructura recomendada

- `/includes/db.php` → Conexión a base de datos
- `/roles/administrador/actividades/ventas.php` → Módulo de ventas
- `/assets/css/ventas.css` → Estilo del panel

## Cómo abrir

1. Ejecutar en un lector de codigo de preferencia (Visual Studio Code)
2. Ejecutar "index.php" opcion= PHP Server: Serve project.
---

### 🚀 Recomendación

Verifica que el archivo `ventas.php` tenga acceso al backend Flask en la ruta:

```
http://127.0.0.1:5000/exportar/pdf
```
