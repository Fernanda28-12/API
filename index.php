<?php

require 'flight/Flight.php';

Flight::register('db', 'PDO' ,array('mysql:host=localhost;dbname=api','root',''));

Flight::route('GET /clientes',function () {
    
    $sentencia= Flight::db()->prepare("SELECT * FROM `clientes`");
    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    Flight::json($datos);
    
});

// recepciona datos por metodo POST y hace un insert
Flight::route('POST /clientes', function () {
    $nombre=(Flight::request()->data->nombre);
    $apellido=(Flight::request()->data->apellido);
    $correo=(Flight::request()->data->correo);
    $edad=(Flight::request()->data->edad);

    $sql="INSERT INTO clientes (nombre,apellido,correo,edad) VALUES (?,?,?,?)";
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$nombre);
    $sentencia->bindParam(2,$apellido);
    $sentencia->bindParam(3,$correo);
    $sentencia->bindParam(4,$edad);
    $sentencia->execute();
    Flight::jsonp(["Cliente agregado"]);

});

//borrar registro
Flight::route('DELETE /clientes', function () {
    $id=(Flight::request()->data->id);
    $sql="DELETE FROM clientes WHERE id=?";
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$id);
    $sentencia->execute();
    Flight::jsonp(["Cliente eliminado"]);
    
});

//actulizar registros
Flight::route('PUT /clientes', function () {

    $id=(Flight::request()->data->id);
    $nombre=(Flight::request()->data->nombre);
    $apellido=(Flight::request()->data->apellido);
    $correo=(Flight::request()->data->correo);
    $edad=(Flight::request()->data->edad);

    $sql="UPDATE clientes SET nombre=? ,apellido=? ,correo=?, edad=? WHERE id=?";
    $sentencia= Flight::db()->prepare($sql);
    
    $sentencia->bindParam(1,$nombre);
    $sentencia->bindParam(2,$apellido);
    $sentencia->bindParam(3,$correo);
    $sentencia->bindParam(4,$edad);
    $sentencia->bindParam(5,$id);
    $sentencia->execute();
    Flight::jsonp(["Cliente actualizado"]);

});

//lectura de un registro determinado
Flight::route('GET /clientes/@id', function ($id) {
    $sentencia= Flight::db()->prepare("SELECT * FROM `clientes` WHERE id=?");
    $sentencia->bindParam(1,$id);

    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    Flight::json($datos);
});

Flight::start();
