![Diagrama E-R de la Base de Datos](https://github.com/cpr0027-lgtm/P-rez_Repiso_Carmen_Desarrollo-Web-en-Entorno-Servidor/blob/main/Diagramas/4.4/diagrama_ER_tienda_zapatillas.png)
4.4. Diagrama E-R de la Base de Datos

La base de datos del sistema tienda_zapatillas ha sido diseñada para gestionar usuarios, productos y pedidos de una tienda online. El modelo Entidad-Relación (E-R) permite representar las entidades principales, sus atributos, las relaciones entre ellas y las cardinalidades.

El diagrama E-R está compuesto por las entidades Usuarios, Productos, Pedidos y Pedido_Producto, siendo esta última una entidad intermedia que resuelve la relación muchos a muchos (N:M) entre pedidos y productos.

Entidad: Usuarios
Propósito y alcance

La entidad Usuarios almacena la información de las personas que acceden al sistema. Su función es identificar a los usuarios y asociar los pedidos realizados a cada uno.

Clave primaria (PK)

id

Atributos

id: identificador del usuario.

nombre: nombre del usuario.

email: correo electrónico del usuario.

password: contraseña del usuario.

rol: tipo de usuario (administrador o cliente).

Claves foráneas (FK)

No tiene claves foráneas.

Relación y cardinalidad

Un usuario puede realizar varios pedidos.

Relación Usuarios – Pedidos: 1:N.

Entidad: Productos
Propósito y alcance

La entidad Productos representa los artículos disponibles en la tienda. Permite gestionar el catálogo, el precio y el stock.

Clave primaria (PK)

id

Atributos

id: identificador del producto.

nombre: nombre del producto.

descripcion: descripción del producto.

precio: precio del producto.

stock: cantidad disponible.

imagen: imagen asociada.

Claves foráneas (FK)

No tiene claves foráneas.

Relación y cardinalidad

Un producto puede aparecer en varios pedidos.

Relación Productos – Pedidos: N:M.

Entidad: Pedidos
Propósito y alcance

La entidad Pedidos almacena las compras realizadas por los usuarios. Cada pedido corresponde a una única compra y puede incluir varios productos.

Clave primaria (PK)

id

Atributos

id: identificador del pedido.

fecha: fecha de realización.

total: importe total.

id_usuario: usuario que realiza el pedido.

Claves foráneas (FK)

id_usuario → Usuarios(id)

Relación y cardinalidad

Cada pedido pertenece a un único usuario.

Relación Usuarios – Pedidos: 1:N.

Entidad: Pedido_Producto
Propósito y alcance

La entidad Pedido_Producto es una tabla intermedia que permite resolver la relación muchos a muchos (N:M) entre pedidos y productos, almacenando además la cantidad de cada producto.

Clave primaria (PK)

Clave primaria compuesta: id_pedido, id_producto

Atributos

id_pedido: identificador del pedido.

id_producto: identificador del producto.

cantidad: unidades del producto.

Claves foráneas (FK)

id_pedido → Pedidos(id)

id_producto → Productos(id)

Relación y cardinalidad

Un pedido puede tener varios productos.

Un producto puede aparecer en varios pedidos.

Relación Pedidos – Productos: N:M, resuelta mediante Pedido_Producto.

Resumen de cardinalidades

Usuarios – Pedidos: 1 : N

Pedidos – Productos: N : M
