CREATE DATABASE tienda_php;

USE tienda_php;

CREATE TABLE usuarios(
    id              int(255) not null auto_increment,
    nombre          varchar(100) not null,
    apellidos       varchar(255),
    email           varchar(255) not null,
    password        varchar(255) not null,
    rol             varchar(20) not null,
    imagen          varchar(255),
    CONSTRAINT pk_usuarios PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDb;

INSERT INTO usuarios VALUES(NULL, 'Admin', 'Admin', 'admin@admin.com', 'contraseña', 'admin', NULL);

CREATE TABLE categorias(
    id              int(255) not null auto_increment,
    nombre          varchar(100) not null,
    CONSTRAINT pk_categorias PRIMARY KEY(id)
)ENGINE=InnoDb;

INSERT INTO categorias VALUES(NULL, 'Manga corta');
INSERT INTO categorias VALUES(NULL, 'Tirantes');
INSERT INTO categorias VALUES(NULL, 'Manga larga');
INSERT INTO categorias VALUES(NULL, 'Sudaderas');

CREATE TABLE productos(
    id              int(255) not null auto_increment,
    categoria_id    int(255) not null,
    nombre          varchar(100) not null,
    descripcion     TEXT,
    precio          FLOAT(100,2) not null,
    stock           int(255) not null,
    oferta          varchar(2),
    fecha           date not null,
    imagen          varchar(255),
    CONSTRAINT pk_productos PRIMARY KEY(id),
    CONSTRAINT fk_producto_categoria FOREIGN KEY(categoria_id) REFERENCES categorias(id)
)ENGINE=InnoDb;

CREATE TABLE pedidos(
    id              int(255) not null auto_increment,
    usuario_id      int(255) not null,
    provincia       varchar(100) not null,
    localidad       varchar(100) not null,
    direccion       varchar(255) not null,
    coste           FLOAT(200,2) not null,
    estado          varchar(20) not null,
    fecha           date,
    hora            time,
    CONSTRAINT pk_pedidos PRIMARY KEY(id),
    CONSTRAINT fk_pedido_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
)ENGINE=InnoDb;

CREATE TABLE lineas_pedidos(
    id              int(255) not null auto_increment,
    pedido_id       int(255) not null,
    producto_id     int(255) not null,
    unidades        int(255) not null,
    CONSTRAINT pk_lineas_pedidos PRIMARY KEY(id),
    CONSTRAINT fk_linea_pedido FOREIGN KEY(pedido_id) REFERENCES pedidos(id),
    CONSTRAINT fk_linea_producto FOREIGN KEY (producto_id) REFERENCES productos(id)
)ENGINE=InnoDb;