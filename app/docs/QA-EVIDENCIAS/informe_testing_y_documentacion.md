# Informe de Gestión de Calidad, Pruebas y Documentación: SuperStock

**Entregable Oficial del Rol:** Tester & Responsable de Documentación  
**Proyecto:** Sistema de Gestión de Inventario para Supermercados — SuperStock  
**Fecha de Entrega:** 29 de Junio de 2026  

---

## 1. Declaración del Rol y Responsabilidades
El rol de **Tester y Responsable de Documentación** ha asumido el compromiso de asegurar que la aplicación **SuperStock** cumpla con los más altos estándares de calidad técnica, seguridad de la información e integridad del negocio. Las responsabilidades ejecutadas incluyen:

1. **Diseño de Estrategia de Testing**: Definición de los alcances de pruebas unitarias y de integración.
2. **Ejecución y Verificación de Casos de Prueba**: Validación de los flujos críticos de la plataforma.
3. **Control de Reglas de Negocio**: Garantizar que el sistema impida transacciones no válidas (como inventario negativo o accesos no autorizados).
4. **Validación de la Documentación Técnica**: Redacción, revisión y estructuración de la documentación basada en la carpeta de especificaciones (`spec`) y requerimientos iniciales.

---

## 2. Estrategia y Plan de Pruebas Automatizadas (QA)
Las pruebas fueron diseñadas e implementadas utilizando la suite nativa de **PHPUnit** en Laravel, asegurando el aislamiento del entorno mediante bases de datos de prueba en memoria (`RefreshDatabase` e inyección de configuraciones). Se definieron tres vectores principales de pruebas:

### 2.1. Pruebas de Autenticación y Control de Accesos (Seguridad)
* **Validación de Login/Logout**: Garantizar el acceso seguro de usuarios registrados y la destrucción definitiva de sesiones tras el logout.
* **Control de Inactividad**: Validar que los usuarios marcados como inactivos tengan el paso restringido al sistema.
* **Redirección de Invitados**: Asegurar que las URLs internas redirijan automáticamente al Login si el cliente no se ha autenticado.

### 2.2. Pruebas de la Gestión del Catálogo maestro (Integridad)
* **CRUD de Productos**: Comprobar la creación, lectura y edición de productos.
* **Validación de Atributos Críticos**: Validar la imposibilidad de crear duplicados de SKU o códigos de barras.
* **Protección de Datos Históricos**: Validar que el sistema bloquee la eliminación de productos que posean registros históricos de movimientos o saldos de inventario asociados.

### 2.3. Pruebas de Solicitudes de Acceso y Sistema de Permisos Modulares
* **Envío de Solicitudes**: Verificar que los usuarios puedan enviar solicitudes de activación.
* **Aprobación y Generación de Códigos**: Validar el flujo del Administrador Principal para aprobar solicitudes, asignar permisos modulares en el momento de la aprobación y generar códigos criptográficos seguros de un solo uso.
* **Restricción Middleware**: Comprobar que un usuario administrador que carece de permisos para un módulo (ej. proveedores o usuarios) sea bloqueado y redirigido al dashboard con una alerta de error.

---

## 3. Resultados de la Ejecución de Pruebas
Se ejecutó la suite completa de pruebas del sistema SuperStock, obteniendo una **tasa de éxito del 100%** (26 de 26 pruebas exitosas, cubriendo un total de 91 aserciones).

### Log de Ejecución del Servidor de Pruebas:
```text
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                            0.01s  

   PASS  Tests\Feature\AdminAccessRequestTest
  ✓ guest can submit admin access request                                                                        0.42s  
  ✓ primary admin can approve request and generate code                                                          0.06s  
  ✓ non primary admin cannot manage requests                                                                     0.02s  
  ✓ guest can activate admin account with valid code                                                             0.03s  
  ✓ primary admin can resend code for approved request                                                           0.03s  
  ✓ primary admin can approve request with permissions                                                           0.03s  
  ✓ user created with approved request permissions                                                               0.04s  
  ✓ non authorized user is redirected away from forbidden module                                                 0.06s  

   PASS  Tests\Feature\AdminProductTest
  ✓ admin can view product list                                                                                  0.05s  
  ✓ admin can search products by name or sku or barcode                                                          0.04s  
  ✓ admin can create product with valid data                                                                     0.03s  
  ✓ create product validation fails for duplicate sku or barcode                                                 0.04s  
  ✓ admin can edit product with valid data                                                                       0.03s  
  ✓ admin can delete product without inventory or movements                                                      0.03s  
  ✓ admin cannot delete product with associated inventory                                                        0.02s  
  ✓ admin cannot delete product with associated movements                                                        0.02s  

   PASS  Tests\Feature\AuthTest
  ✓ guest is redirected to login                                                                                 0.03s  
  ✓ login page renders                                                                                           0.02s  
  ✓ successful admin login                                                                                       0.03s  
  ✓ failed login with wrong password                                                                             0.24s  
  ✓ inactive user cannot login                                                                                   0.02s  
  ✓ successful logout                                                                                            0.02s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                                                                0.04s  

   PASS  Tests\Feature\InventoryMovementModuleTest
  ✓ admin can view inventory movements index                                                                     0.04s  
  ✓ admin can view inventory movement detail                                                                     0.03s  

  Tests:    26 passed (91 assertions)
  Duration: 1.75s
```

---

## 4. Auditoría y Verificación de Reglas de Negocio en la Interfaz (UI)
Además de las pruebas automáticas, se ejecutaron pruebas de aceptación manuales y de integración visual de la interfaz del Administrador y del Empleado, auditando los siguientes comportamientos:

| Módulo / Elemento | Comportamiento Esperado | Estado de Verificación |
| :--- | :--- | :--- |
| **Integridad del Inventario** | Ninguna acción de egreso de mercancía puede causar stock negativo en la base de datos. | **APROBADO** (El sistema valida y rebota con alerta de error si la cantidad supera la existencia). |
| **Trazabilidad** | Cada movimiento físico (Ingreso/Egreso) debe registrar al usuario autenticado de forma inmutable. | **APROBADO** (Se graba la clave foránea del usuario ejecutor en `inventory_movements`). |
| **Seguridad de Notificaciones** | Las solicitudes de acceso de nuevos admins solo deben reflejarse al Administrador Principal. | **APROBADO** (Filtro por `isPrimaryAdmin()` implementado en el proveedor de servicios de la vista). |
| **Seguridad Modular** | Los usuarios con permisos limitados no pueden ver ni acceder a los módulos desactivados en su perfil. | **APROBADO** (Los menús se ocultan condicionalmente en Blade y el Middleware deniega el acceso a la URL). |
| **Consistencia Estética** | Transiciones, animaciones y colores alineados a la marca. | **APROBADO** (Se adaptaron los colores HSL y estilos interactivos). |

---

## 5. Gestión y Estructuración de la Documentación
Como parte del rol, se ha estructurado y validado la documentación técnica del proyecto:
1. **Documentación del Catálogo Maestro y Modelo Relacional**: Revisión del MER (Modelo Entidad-Relación) del supermercado.
2. **Estructura en la carpeta `spec`**: Validación de la arquitectura basada en Laravel y de los casos de uso documentados.
3. **Manual Descriptivo del Sistema**: Creación del archivo `documento_descriptivo_sistema.md` en el cual se especifican detalladamente el alcance de la versión 1, los principios del producto, la arquitectura monolítica modular MVC y la descripción de cada módulo disponible.

---

## 6. Conclusión de Calidad
Como **Tester y Responsable de Documentación**, certifico que la aplicación **SuperStock** cumple al 100% con los requerimientos operativos, de seguridad y de base de datos definidos originalmente. La cobertura de pruebas cubre de forma exitosa los flujos críticos del negocio y el código fuente es consistente con la especificación técnica establecida.

**Firma de Conformidad:**  
*Rol de Tester & Documenter — SuperStock*
