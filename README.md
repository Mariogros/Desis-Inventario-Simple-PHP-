# Proyecto Desis

Este repositorio contiene una pequeña aplicación PHP (archivos en la raíz y la carpeta `php/`), hojas de estilo en `css/` y scripts en `js/`.

Objetivo: instrucciones rápidas para inicializar un repositorio Git local y subirlo a GitHub con buenas prácticas.

Opciones para crear el repositorio remoto en GitHub:

- Opción A — Interfaz web de GitHub (fácil):
  1. Ve a https://github.com, inicia sesión y clic en "New repository".
  2. Elige nombre, visibilidad (público/privado) y NO marques "Initialize this repository with a README" (ya tienes uno local).
  3. Crea el repo y copia la URL remota (HTTPS o SSH).

- Opción B — gh CLI (rápido y reproducible):
  1. Instala la herramienta `gh` y autentícala: `gh auth login`.
  2. Desde la carpeta del proyecto ejecuta: `gh repo create <owner>/<repo> --private --source=. --remote=origin` (ajusta visibilidad).

- Opción C — Desde VS Code (UI integrada):
  1. Abre la carpeta en VS Code, ve a la extensión Git y haz "Publish to GitHub".

Pasos locales (PowerShell en Windows):

1. Inicializar git y hacer commit inicial

```powershell
git init
git checkout -b main
git add .
git commit -m "Initial commit"
```

2. Enlazar repo remoto y push (reemplaza la URL por la tuya)

```powershell
git remote add origin https://github.com/<usuario>/<repo>.git
git push -u origin main
```

Buenas prácticas y recomendaciones:
- No subas archivos con credenciales. Usa `.env` y agrega `.env` a `.gitignore`.
- Añade `LICENSE` si quieres especificar la licencia.
- Mantén la rama principal llamada `main` y crea ramas para features/bugfixes.
- Considera usar `composer.json` si usas dependencias PHP.
- Configura protección de ramas en GitHub y CI (GitHub Actions) para pruebas.

Si quieres, puedo:
- Inicializar el repo local y hacer el commit aquí.
- Crear el repo remoto usando `gh` (si instalas y autorizas `gh`).
- Guiarte paso a paso por la UI de GitHub o VS Code.
