# Plan: comentarios anónimos

## Contexto

Actualmente los comentarios en el blog están limitados a usuarios autenticados. Se eliminará esa restricción para permitir comentarios anónimos (sin login). El visitante solo deberá escribir su comentario; el campo de nombre vendrá pre-llenado con un nickname aleatorio para reducir fricción.

**Alcance**: comentarios en la sección pública del blog (`comment-section` Livewire, insertada en `posts.show`). El panel admin (gestión de comentarios) se actualiza para soportar la visualización de comentarios anónimos, pero no se modifica su lógica de negocio.

**Fuera de alcance**: moderación manual de comentarios anónimos, notificaciones, sistema de suscripción a respuestas.

---

## Estado de lo existente

### ✅ Ya existe y funciona
- Migración `2025_12_31_195231_create_comments_table` con `user_id` FK NOT NULL
- Modelo `Comment` con relaciones `user()`, `post()`, `parent()`, `replies()`
- Livewire `CommentSection` con `submitComment()`, `replyTo()`, `editComment()`, `updateComment()`, `deleteComment()`
- Vista `comment-section.blade.php` con `@auth`/`@endauth` envolviendo formulario y botón responder
- Policy `CommentPolicy` con `update()` y `delete()` — solo autor o admin
- Admin: `CommentController`, vistas `index.blade.php` y `pending.blade.php`, dashboard

### ❌ Falta completar
- `user_id` en la tabla `comments` es NOT NULL — hay que hacerlo nullable
- No existen campos para almacenar datos del comentarista anónimo
- El Livewire tiene `Auth::check()` como guard en `submitComment()` y `replyTo()`
- La vista oculta el formulario a usuarios no autenticados
- La vista accede a `$comment->user->avatar_url` y `$comment->user->name` sin null-safe
- Las vistas admin también referencian `$comment->user->*` directamente

---

## Arquitectura

- **Framework**: Laravel + Livewire (componente `CommentSection` full-page en `@livewire`)
- **Auth**: Socialite (Google OAuth) + login tradicional. Se mantiene para editar/borrar comentarios propios.
- **Flujo anónimo**: visitante escribe comentario → `submitComment()` valida sin `Auth::check()` → guarda `author_name` (con nickname pre-llenado si no lo cambió) + `user_id = null`
- **Nickname pre-llenado**: se genera aleatoriamente combinando letras (a-z) seguidas de números (0-9), entre 5 y 8 caracteres totales (ej. "kxrt93", "abmzpq12"). Sin arrays predefinidos, puramente aleatorio. La generación está aislada en un método propio del componente para facilitar cambios futuros.
- **Avatar anónimo**: SVG inline de un icono de usuario genérico (círculo con inicial), generado desde el modelo.
- **Edición/eliminación**: solo para usuarios autenticados (dueño del comentario o admin). Los comentarios anónimos no se pueden editar ni eliminar desde el frontend público.
- **Seguridad**: `submitComment()` aplica rate limiting implícito vía validación de Livewire. El campo `content` sigue con validación `required|string|max:1000|min:3`.

---

## Archivos críticos a modificar o crear

| Acción | Archivo |
|--------|---------|
| Nueva migración | `database/migrations/2026_06_13_000000_allow_anonymous_comments.php` |
| Actualizar | `app/Models/Comment.php` |
| Actualizar | `app/Livewire/CommentSection.php` |
| Actualizar | `resources/views/livewire/comment-section.blade.php` |
| Actualizar | `resources/views/admin/comments/index.blade.php` |
| Actualizar | `resources/views/admin/comments/pending.blade.php` |
| Actualizar | `resources/views/admin/dashboard.blade.php` |

---

## Fases con tareas atómicas

### Fase 1: Base de datos y modelo

- [x] 1.1 Crear migración `2026_06_13_174306_allow_anonymous_comments.php`:
  - `user_id` → `nullable()->change()`
  - Agregar `author_name` (string, nullable) después de `user_id`
  - Agregar `author_email` (string, nullable) después de `author_name` (reservado para futuro, no se expone en UI)
- [x] 1.2 Correr `php artisan migrate` y verificar que la tabla `comments` se alteró correctamente
- [x] 1.3 Actualizar `Comment` model:
  - Agregar `author_name` y `author_email` al `$fillable`
  - Agregar accessor `displayNameAttribute`: si `user` existe → `$this->user->name`, sino → `$this->author_name`
  - Agregar accessor `avatarUrlAttribute`: si `user` existe → `$this->user->avatar_url`, sino → asset para avatar SVG por defecto
  - Agregar método `isAnonymous(): bool` → `$this->user_id === null`
  - Agregar método `canBeManagedBy(?User $user): bool` → solo si hay usuario autenticado y es dueño o admin

### Fase 2: Livewire Component

- [x] 2.1 Agregar propiedades públicas a `CommentSection`:
  - `$authorName = ''` — nombre del comentarista anónimo
  - `$authorEmail = ''` — reservado, no se muestra en UI
- [x] 2.2 Modificar `mount()` para pre-llenar `$authorName` con nickname aleatorio cuando `!Auth::check()`
- [x] 2.3 Modificar `submitComment()`:
  - Quitar `Auth::check()` guard inicial
  - Si `Auth::check()` → guardar `user_id = Auth::id()`
  - Si no → validar que `author_name` tenga valor (el pre-llenado garantiza esto), guardar `user_id = null` + `author_name`
- [x] 2.4 Modificar `replyTo()`: quitar `Auth::check()` guard
- [x] 2.5 Mantener `editComment()`, `updateComment()`, `deleteComment()` con auth checks existentes
- [x] 2.6 Actualizar reglas de validación: convertir `$rules` en método `rules()` con validación condicional de `authorName`

### Fase 3: Vista pública (comment-section)

- [x] 3.1 Quitar `@auth`/`@else`/`@endauth` del bloque del formulario. El form se muestra siempre.
- [x] 3.2 Agregar campo `author_name` visible solo si `@guest`: input text con nickname pre-llenado, label "Nombre"
- [x] 3.3 Quitar `@auth` del botón "Responder". Mostrar siempre (con `@if($editingCommentId !== $comment->id)`)
- [x] 3.4 Mantener `@auth` en menús de editar/eliminar (sin cambios)
- [x] 3.5 Reemplazar `$comment->user->avatar_url` → `$comment->avatar_url` (accessor del modelo)
- [x] 3.6 Reemplazar `$comment->user->name` → `$comment->display_name` (accessor del modelo)
- [x] 3.7 Aplicar mismos cambios de `avatar_url`/`display_name` en la sección de replies

### Fase 4: Vistas admin

- [~] 4.1 `admin/comments/index.blade.php`: reemplazar `$comment->user->*` → accessors del modelo
- [~] 4.2 `admin/comments/pending.blade.php`: mismo reemplazo
- [~] 4.3 `admin/dashboard.blade.php`: mismo reemplazo

### Fase 5: Verificación

- [ ] 5.1 Probar: usuario no autenticado ve el formulario con nickname pre-llenado, escribe comentario, envía → aparece en la lista
- [ ] 5.2 Probar: usuario no autenticado puede responder a un comentario existente
- [ ] 5.3 Probar: usuario autenticado sigue pudiendo comentar normalmente (sin ver campo nombre)
- [ ] 5.4 Probar: comentario anónimo NO muestra menú editar/eliminar
- [ ] 5.5 Probar: admin puede ver comentarios anónimos en panel admin (nombre + avatar por defecto)
- [ ] 5.6 Probar: dark mode — campo de nombre y textarea se ven correctamente

---

### Fase 6: UX — Reply inline en la card del comentario

- [~] 6.1 Formulario principal (arriba): solo visible cuando no se está respondiendo (`!$replyingToCommentId`). Para comentarios de nivel superior.
- [~] 6.2 Formulario inline dentro de cada card de comentario: visible cuando `$replyingToCommentId === $comment->id`. Incluye textarea de respuesta, banner "Respondiendo a...", botones Cancelar/Enviar, y campo nombre (`@guest`).
- [~] 6.3 Formulario inline dentro de cada card de reply: mismo patrón para replies (`$replyingToCommentId === $reply->id`). Incluye botón "Responder" adicional en cada reply.
- [~] 6.4 Verificar: clic en "Responder" muestra textarea inline sin scroll; "Cancelar" lo oculta; submit limpia el formulario correctamente.

---

## Fuera de alcance

- Email del comentarista anónimo (la columna `author_email` se crea pero no se expone en UI)
- Moderación de comentarios anónimos (siguen con `is_approved = true` por defecto)
- Captcha o protección anti-spam adicional
- Sistema de notificaciones por email a comentaristas anónimos
- Avatar Gravatar para anónimos (se usa SVG genérico)

---

## Decisiones tomadas

- **Solo nombre, sin email**: el campo `author_email` se crea en la migración para uso futuro, pero la UI actual no lo expone. KISS.
- **Nickname pre-llenado**: combinación aleatoria de letras (a-z) + números (0-9), entre 5 y 8 caracteres totales. Generado por un método aislado (`generateNickname()`) en el componente Livewire, sin arrays predefinidos. Permite cambiar la estrategia de generación sin tocar el resto del código.
- **Accessors en el modelo**: `displayNameAttribute` y `avatarUrlAttribute` centralizan la lógica de "qué mostrar". Las vistas nunca acceden a `$comment->user` directamente, evitando errores de null.
- **Anónimos no editan ni borran**: coherencia con el sistema actual donde solo el dueño (autenticado) puede gestionar su comentario. Un anónimo no tiene credenciales para probar ownership.
- **`user_id` nullable en vez de crear tabla aparte**: más simple que tener una tabla `anonymous_commenters`. Mantiene una sola relación polimórfica implícita (user_id = null → anónimo).
