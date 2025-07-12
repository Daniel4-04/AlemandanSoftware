# Proyecto ALEMANDAN FINAL

Sistema CRM para gestión de inventario, empleados, proveedores y ventas, con generación de reportes en Excel y PDF.

## Estructura del Proyecto

- 📁 `bases de datos/`  
  Contiene los archivos `.sql` con la estructura y datos de las bases de datos `alemandan_db` y `rol`.
        
- 📁 `flask_alemandan/`  
  Backend en Flask para exportar los reportes en formato Excel y PDF usando Pandas y Matplotlib.

- 📁 `NewAlemandan/`  
  Aplicación web principal (CRM) desarrollada en PHP. Incluye panel de administración con login, control de roles, historial de ventas, inventario, y empleados.

---

## Requisitos Generales

- Servidor web local (como XAMPP o Laragon) con soporte PHP y MySQL.
- Python 3.11+ con Flask, Pandas y Matplotlib instalados.
- Navegador actualizado.

## Ejecución

### 1. Restaurar las bases de datos
Importar los archivos `.sql` en phpMyAdmin o desde terminal:

```
alemandan_db.sql
rol.sql
```

### 2. Ejecutar el backend Flask
```bash
cd flask_alemandan
python app.py
```

### 3. Abrir el CRM en navegador
Iniciar Apache y MySQL. Ir a:
```
http://localhost/NewAlemandan/index.php
```

---

## Créditos
Equipo de desarrollo: Daniel García, Laura Velandia, Santiago Calao, Camilo Lozada, Esteban Socha. 🇨🇴  
Proyecto desarrollado como parte del componente técnico del SENA.
