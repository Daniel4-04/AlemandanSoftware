from flask import Flask, request, jsonify, send_file
import pandas as pd
import matplotlib
matplotlib.use('Agg')  # Usar backend sin GUI
import matplotlib.pyplot as plt
from flask_cors import CORS
from io import BytesIO
import json

app = Flask(__name__)
CORS(app)

# Función para procesar productos (JSON → texto legible)
def procesar_productos(cadena_json):
    try:
        productos = json.loads(cadena_json)
        if isinstance(productos, list):
            return "\n".join([f"{p['nombre']} x{p['cantidad']} (${p['precio']})" for p in productos])
        return str(productos)
    except:
        return str(cadena_json)

@app.route('/reporte/ventas', methods=['POST'])
def reporte_ventas():
    data = request.get_json()

    if not data or "ventas" not in data:
        return jsonify({"error": "No se enviaron datos válidos"}), 400

    df = pd.DataFrame(data["ventas"])

    if df.empty:
        return jsonify([])

    if "fecha" in df.columns:
        df["fecha"] = pd.to_datetime(df["fecha"], errors="coerce")

    # Filtros
    fecha_desde = data.get("fecha_desde")
    fecha_hasta = data.get("fecha_hasta")
    filtro_producto = data.get("producto")
    filtro_cajero = data.get("cajero")

    if fecha_desde and fecha_hasta:
        try:
            fecha_desde = pd.to_datetime(fecha_desde)
            fecha_hasta = pd.to_datetime(fecha_hasta)
            df = df[(df["fecha"] >= fecha_desde) & (df["fecha"] <= fecha_hasta)]
        except:
            return jsonify({"error": "Fechas inválidas"}), 400

    if filtro_cajero:
        df = df[df["cajero"].str.contains(filtro_cajero, case=False, na=False)]

    if filtro_producto:
        df = df[df["productos"].str.contains(filtro_producto, case=False, na=False)]

    resumen = df[["productos", "total"]]
    resumen = resumen.groupby("productos").sum().reset_index()
    resumen.columns = ["producto", "total_vendido"]
    resumen["total_vendido"] = resumen["total_vendido"].round(2)

    return jsonify(resumen.to_dict(orient="records"))

@app.route('/exportar/excel', methods=['POST'])
def exportar_excel():
    data = request.get_json()
    if not data or "ventas" not in data:
        return jsonify({"error": "Datos no válidos"}), 400

    df = pd.DataFrame(data["ventas"])
    if df.empty:
        return jsonify({"error": "No hay datos"}), 400

    # Procesar productos
    if "productos" in df.columns:
        df["productos"] = df["productos"].apply(procesar_productos)

    output = BytesIO()
    
    with pd.ExcelWriter(output, engine='openpyxl') as writer:
        df.to_excel(writer, index=False, sheet_name='Ventas')
        sheet = writer.sheets['Ventas']

        # Ajustar ancho de columnas según contenido
        for col in sheet.columns:
            max_length = 0
            column = col[0].column_letter  # Letra de la columna
            for cell in col:
                try:
                    if cell.value:
                        max_length = max(max_length, len(str(cell.value)))
                except:
                    pass
            adjusted_width = max_length + 2
            sheet.column_dimensions[column].width = adjusted_width

    output.seek(0)

    return send_file(
        output,
        mimetype='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        download_name='reporte_ventas.xlsx',
        as_attachment=True
    )


@app.route('/exportar/pdf', methods=['POST'])
def exportar_pdf():
    data = request.get_json()
    if not data or "ventas" not in data:
        return jsonify({"error": "Datos no válidos"}), 400

    df = pd.DataFrame(data["ventas"])
    if df.empty:
        return jsonify({"error": "No hay datos"}), 400

    # Procesar productos
    if "productos" in df.columns:
        df["productos"] = df["productos"].apply(procesar_productos)

    # Detectar si se requiere landscape
    promedio_largo_fila = df.astype(str).apply(lambda row: sum(len(str(cell)) for cell in row), axis=1).mean()
    usar_landscape = promedio_largo_fila > 150 or len(df.columns) > 5

    ancho = 18 if usar_landscape else 10
    alto = max(5, len(df) * 0.8)

    fig, ax = plt.subplots(figsize=(ancho, alto))
    ax.axis('off')

    tabla = ax.table(cellText=df.values, colLabels=df.columns, cellLoc='center', loc='center')
    tabla.auto_set_font_size(False)
    tabla.set_fontsize(8)

    # Ajustar tamaño base de toda la tabla
    tabla.scale(1.2, 1.5)

    # Ajustar altura por cada fila si hay muchas líneas
    for row_idx, row in enumerate(df.values):
        lineas_en_fila = max(len(str(cell).split("\n")) for cell in row)
        for col_idx in range(len(df.columns)):
            cell = tabla[(row_idx + 1, col_idx)]  # +1 porque row 0 es header
            cell.set_height(0.15 * lineas_en_fila)

    output = BytesIO()
    plt.savefig(output, format='pdf', bbox_inches='tight')
    output.seek(0)

    return send_file(
        output,
        mimetype='application/pdf',
        download_name='reporte_ventas.pdf',
        as_attachment=True
    )




if __name__ == '__main__':
    app.run(port=5000, debug=True)
