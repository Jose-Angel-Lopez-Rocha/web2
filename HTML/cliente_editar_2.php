
<?php
    include("..\PHP\conexion.php");
    session_start();
    if (!isset($_SESSION['cliente_rol']) || $_SESSION['cliente_rol'] != 1) {
            if (!isset($_SESSION['cliente_rol']) || $_SESSION['cliente_rol'] != 3) {
    echo "<div style='
        padding: 20px;
        margin: 20px auto;
        max-width: 400px;
        background: #ffe6e6;
        color: #b30000;
        border: 2px solid #ff4d4d;
        border-radius: 10px;
        font-family: Arial;
        text-align: center;
        font-size: 18px;
    '>❌ No tienes permiso para acceder a esta página.</div>";
    exit;
  }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar cliente</title>
    <link rel="stylesheet" href="..\CSS\crear.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
     <div id="app">
        <!-- Formulario de edición -->
        <form @submit.prevent="actualizarCliente" class="formulario1" v-if="!cargando">
            <h2>Editar cliente #{{ clienteId }}</h2>

            <!-- Nombre -->
            <div class="formulario1__grupo" :class="getClaseValidacion('nombre')">
                <label for="nombre" class="formulario1__label">Nombre</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="text" 
                        v-model="nombre" 
                        id="nombre" 
                        class="formulario1__input"
                        @input="validarCampo('nombre')"
                        @blur="marcarComoTocado('nombre')">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('nombre')" v-show="tocado.nombre"></i>
                </div>
                <p class="formulario1__input_error" v-if="tocado.nombre && !valid.nombre">El nombre solo debe tener letras</p>
            </div>

            <!-- Apellido Paterno -->
            <div class="formulario1__grupo" :class="getClaseValidacion('apellido_paterno')">
                <label for="apellido_paterno" class="formulario1__label">Apellido Paterno</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="text" 
                        v-model="apellido_paterno" 
                        id="apellido_paterno" 
                        class="formulario1__input"
                        @input="validarCampo('apellido_paterno')"
                        @blur="marcarComoTocado('apellido_paterno')">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('apellido_paterno')" v-show="tocado.apellido_paterno"></i>
                </div>
            </div>

            <!-- Apellido Materno -->
            <div class="formulario1__grupo" :class="getClaseValidacion('apellido_materno')">
                <label for="apellido_materno" class="formulario1__label">Apellido Materno</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="text" 
                        v-model="apellido_materno" 
                        id="apellido_materno" 
                        class="formulario1__input"
                        @input="validarCampo('apellido_materno')"
                        @blur="marcarComoTocado('apellido_materno')">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('apellido_materno')" v-show="tocado.apellido_materno"></i>
                </div>
            </div>

            <!-- Email -->
            <div class="formulario1__grupo" :class="getClaseValidacion('email')">
                <label for="email" class="formulario1__label">Email</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="email" 
                        v-model="email" 
                        id="email" 
                        class="formulario1__input"
                        @input="validarCampo('email')"
                        @blur="marcarComoTocado('email')">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('email')" v-show="tocado.email"></i>
                </div>
            </div>

            <!-- Contraseña (opcional) -->
            <div class="formulario1__grupo" :class="getClaseValidacion('clave')">
                <label for="clave" class="formulario1__label">Nueva Contraseña</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="password" 
                        v-model="clave" 
                        id="clave" 
                        class="formulario1__input"
                        placeholder="Dejar vacío si no deseas cambiarla"
                        @input="validarCampo('clave')"
                        @blur="marcarComoTocado('clave')">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('clave')" v-show="tocado.clave"></i>
                </div>
                <p class="formulario1__input_error" v-if="tocado.clave && clave && !valid.clave">La contraseña debe tener entre 4 y 12 caracteres</p>
            </div>

            <!-- Teléfono -->
            <div class="formulario1__grupo" :class="getClaseValidacion('telefono')">
                <label for="telefono" class="formulario1__label">Teléfono</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="tel" 
                        v-model="telefono" 
                        id="telefono" 
                        class="formulario1__input"
                        @input="validarCampo('telefono')"
                        @blur="marcarComoTocado('telefono')">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('telefono')" v-show="tocado.telefono"></i>
                </div>
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="formulario1__grupo" :class="getClaseValidacion('fecha_nac')">
                <label for="fecha_nac" class="formulario1__label">Fecha de Nacimiento</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="date" 
                        v-model="fecha_nac" 
                        id="fecha_nac" 
                        class="formulario1__input"
                        @change="validarCampo('fecha_nac'); marcarComoTocado('fecha_nac')">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('fecha_nac')" v-show="tocado.fecha_nac"></i>
                </div>
            </div>

            <!-- Estado -->
            <div class="formulario1__grupo" :class="getClaseValidacion('estado')">
                <label for="estado" class="formulario1__label">Estado</label>
                <div class="formulario1__grupo_input">
                    <select v-model="estado" id="estado" class="formulario1__input" @change="validarCampo('estado'); marcarComoTocado('estado')">
                        <option value="Ciudad de México">Ciudad de México</option>
                        <option value="Aguascalientes">Aguascalientes</option>
                        <option value="Baja California">Baja California</option>
                        <option value="Baja California Sur">Baja California Sur</option>
                        <option value="Campeche">Campeche</option>
                        <option value="Chiapas">Chiapas</option>
                        <option value="Chihuahua">Chihuahua</option>
                        <option value="Coahuila">Coahuila</option>
                        <option value="Colima">Colima</option>
                        <option value="Durango">Durango</option>
                        <option value="Guanajuato">Guanajuato</option>
                        <option value="Guerrero">Guerrero</option>
                        <option value="Hidalgo">Hidalgo</option>
                        <option value="Jalisco">Jalisco</option>
                        <option value="Estado de México">Estado de México</option>
                        <option value="Michoacán">Michoacán</option>
                        <option value="Morelos">Morelos</option>
                        <option value="Nayarit">Nayarit</option>
                        <option value="Nuevo León">Nuevo León</option>
                        <option value="Oaxaca">Oaxaca</option>
                        <option value="Puebla">Puebla</option>
                        <option value="Querétaro">Querétaro</option>
                        <option value="Quintana Roo">Quintana Roo</option>
                        <option value="San Luis Potosí">San Luis Potosí</option>
                        <option value="Sinaloa">Sinaloa</option>
                        <option value="Sonora">Sonora</option>
                        <option value="Tabasco">Tabasco</option>
                        <option value="Tamaulipas">Tamaulipas</option>
                        <option value="Tlaxcala">Tlaxcala</option>
                        <option value="Veracruz">Veracruz</option>
                        <option value="Yucatán">Yucatán</option>
                        <option value="Zacatecas">Zacatecas</option>
                    </select>
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('estado')" v-show="tocado.estado"></i>
                </div>
            </div>

            <!-- Ciudad -->
            <div class="formulario1__grupo" :class="getClaseValidacion('ciudad')">
                <label for="ciudad" class="formulario1__label">Ciudad</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="text" 
                        v-model="ciudad" 
                        id="ciudad" 
                        class="formulario1__input"
                        @input="validarCampo('ciudad')"
                        @blur="marcarComoTocado('ciudad')">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('ciudad')" v-show="tocado.ciudad"></i>
                </div>
            </div>

            <!-- Mensajes -->
            <div class="formulario1__mensaje-error" v-if="error">
                {{ mensajeError }}
            </div>

            <div class="formulario1__mensaje-exito" v-if="exito">
                ✓ Cliente actualizado exitosamente
            </div>

            <!-- Botones -->
            <div class="formulario1__grupo-botones">
                <button type="submit" class="formulario1__btn" :disabled="enviando">
                    {{ enviando ? 'Guardando...' : 'Actualizar Cliente' }}
                </button>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="../js/formularioec.js"></script>
</body>
</html>