# AI-Skills Directory (skill/) - Contexto Académico

Este directorio contiene las **skills operativas (runbooks)** estructuradas para que los agentes de IA colaboren de forma efectiva con cada integrante del equipo en su rama correspondiente.

## Índice de Skills y Asignaciones

| Archivo | Tarea Técnica | Responsable | Rama Git |
| :--- | :--- | :--- | :--- |
| [setup_skill.md](setup_skill.md) | Inicializar e instalar Laravel y MySQL 8.x. | **Líder Técnico** | `feature/00-setup` |
| [auth_skill.md](auth_skill.md) | Control de sesiones, registro, login y middleware. | **DEV-AUTH** | `feature/02-auth` |
| [productos_skill.md](productos_skill.md) | CRUD de productos y categorías, subida de imágenes. | **DEV-PROD** | `feature/05-crud-products` |
| [dashboard_skill.md](dashboard_skill.md) | Panel de administración privado y vistas de métricas. | **DEV-DASH** | `feature/04-dashboard` |
| [catalogo_skill.md](catalogo_skill.md) | Grid de catálogo, búsquedas y filtros en frontend. | **DEV-FRONT** | `feature/03-catalog` |
| [whatsapp_skill.md](whatsapp_skill.md) | LocalStorage y redirección codificada de WhatsApp API. | **LT / DEV-FRONT** | `feature/06-whatsapp` |
| [testing_skill.md](testing_skill.md) | Ejecución y creación de pruebas automatizadas. | **QA** | `feature/99-qa-testing` |
| [security_skill.md](security_skill.md) | Hardening contra CSRF, XSS y rate limits en login. | **QA** | `feature/99-qa-testing` |

## Flujo de Trabajo del Agente IA en el Proyecto
1.  **Validar Rama:** Antes de codificar, asegurar que estás posicionado en la rama de características asignada (ej. `feature/02-auth`).
2.  **Leer la Especificación Relacionada:** Consultar la especificación en `/spec/modulos/*.md`.
3.  **Ejecutar el Runbook:** Seguir de forma secuencial las instrucciones del archivo `.md` de skill correspondiente.
4.  **Confirmar Pruebas:** Correr el runbook `testing_skill.md` para validar los cambios localmente antes de crear la Pull Request.
