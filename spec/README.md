# Especificaciones Oficiales de SuperStock

`spec/` es la única fuente oficial de especificaciones funcionales, de datos, arquitectura, experiencia de usuario y planificación del proyecto **SuperStock**.

SuperStock es un Sistema Web de Gestión de Inventario para Supermercados construido sobre Laravel, arquitectura MVC y MySQL. Su primera versión administra usuarios internos, categorías, productos, proveedores, existencias y movimientos de entrada y salida.

## Gobierno documental

- Toda implementación deberá trazarse hacia un requisito, caso de uso, regla de negocio o decisión arquitectónica contenida en esta carpeta.
- Cuando exista contradicción con documentos históricos, prevalece `spec/`.
- Los documentos de `docs/` se consideran insumos de análisis y dejan de ser normativos después de esta consolidación.
- La incorporación de nuevas entidades, módulos, actores o cardinalidades requiere control de cambios y actualización coordinada de las especificaciones afectadas.
- Los documentos de módulo no duplican reglas ni casos de uso: los referencian mediante sus códigos oficiales.

## Alcance oficial

### Actores

- **Administrador:** gestiona usuarios, categorías, productos y proveedores; también consulta inventario, registra entradas y salidas, revisa movimientos y consulta el Dashboard.
- **Empleado:** inicia y cierra sesión, consulta productos e inventario, busca productos, registra entradas y salidas y consulta el Dashboard. No administra usuarios ni configuración.

### Módulos

- Autenticación y sesión.
- Usuarios.
- Categorías.
- Productos.
- Proveedores.
- Inventario y movimientos.
- Entradas.
- Salidas.
- Dashboard.

### Exclusiones

No forman parte de SuperStock: catálogo público, carrito, checkout, clientes, pedidos, entregas, pagos, facturación, ventas por WhatsApp ni registro público de administradores.

## Índice canónico

| Documento | Responsabilidad |
|---|---|
| [Visión](vision.md) | Problema, propuesta de valor, actores, alcance y criterios de éxito. |
| [Requerimientos](requerimientos.md) | Requisitos funcionales, no funcionales y reglas de negocio oficiales. |
| [Casos de uso](casos_de_uso.md) | Interacciones entre actores y sistema, flujos y trazabilidad. |
| [Arquitectura](arquitectura.md) | Estructura MVC, módulos, seguridad, flujo de datos y decisiones técnicas. |
| [Base de datos](base_datos.md) | Modelo conceptual y lógico, MER, diccionario, relaciones e integridad. |
| [Roadmap](roadmap.md) | Estrategia de adaptación, fases, riesgos y criterios de implementación. |
| [Módulos](modulos/README.md) | Especificaciones funcionales por área del sistema. |
| [Branding](design/branding.md) | Identidad, tono y aplicación de marca. |
| [Design System](design/design-system.md) | Tokens, principios y reglas visuales. |
| [Componentes UI](design/ui-components.md) | Patrones de interfaz reutilizables por módulo. |

## Trazabilidad

La trazabilidad oficial sigue esta cadena:

**Visión → RF/RNF → CU → RN → Módulo → Pruebas**

- `RF-xxx`: requisito funcional.
- `RNF-xxx`: requisito no funcional.
- `CU-xx`: caso de uso.
- `RN-xxx`: regla de negocio.

## Estado de la especificación

Esta versión reemplaza la especificación heredada de SnackConnect. La implementación actual todavía puede contener componentes del dominio anterior; su eliminación y sustitución se rige por [roadmap.md](roadmap.md).

