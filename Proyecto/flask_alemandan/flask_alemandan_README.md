# Backend - flask_alemandan

API desarrollada en Flask para generar reportes PDF y Excel del historial de ventas del CRM Alemandan.

## Estructura

- `app.py` → Servidor Flask con endpoints `/exportar/pdf` y `/exportar/excel`.
- Utiliza Pandas y Matplotlib para manipular y exportar datos recibidos desde el frontend PHP.

## Requisitos

```bash
pip install flask flask-cors pandas matplotlib
```

## Uso

1. Desde el CRM, se envía un JSON con las ventas al backend.
2. El backend genera el archivo y lo devuelve como descarga automática.

## Ejecución

```bash
python app.py
```

El servidor correrá por defecto en `http://127.0.0.1:5000`.
