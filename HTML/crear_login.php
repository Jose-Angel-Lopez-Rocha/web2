<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link href="../CSS/crear.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/62d309d756.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>

<div id="app">
        <form @submit.prevent="enviarFormulario" class="formulario1">
            
            <!-- Nombre -->
            <div class="formulario1__grupo" :class="getClaseValidacion('nombre')">
                <label for="nombre" class="formulario1__label">Nombre</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="text" 
                        v-model="nombre" 
                        id="nombre" 
                        class="formulario1__input" 
                        placeholder="Angel"
                        @input="validarCampo('nombre')"
                        @blur="marcarComoTocado('nombre')"
                        autocomplete="off">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('nombre')" v-show="tocado.nombre"></i>
                </div>
                <p class="formulario1__input_error" v-if="tocado.nombre && nombre && !valid.nombre">El nombre solo debe tener letras</p>
            </div>

            <!-- Apellido Paterno -->
            <div class="formulario1__grupo" :class="getClaseValidacion('apellido_paterno')">
                <label for="apellido_paterno" class="formulario1__label">Apellido paterno</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="text" 
                        v-model="apellido_paterno" 
                        id="apellido_paterno" 
                        class="formulario1__input" 
                        placeholder="Lopez"
                        @input="validarCampo('apellido_paterno')"
                        @blur="marcarComoTocado('apellido_paterno')"
                        autocomplete="off">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('apellido_paterno')" v-show="tocado.apellido_paterno"></i>
                </div>
                <p class="formulario1__input_error" v-if="tocado.apellido_paterno && apellido_paterno && !valid.apellido_paterno">El apellido solo debe tener letras</p>
            </div>

            <!-- Apellido Materno -->
            <div class="formulario1__grupo" :class="getClaseValidacion('apellido_materno')">
                <label for="apellido_materno" class="formulario1__label">Apellido materno</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="text" 
                        v-model="apellido_materno" 
                        id="apellido_materno" 
                        class="formulario1__input" 
                        placeholder="Rocha"
                        @input="validarCampo('apellido_materno')"
                        @blur="marcarComoTocado('apellido_materno')"
                        autocomplete="off">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('apellido_materno')" v-show="tocado.apellido_materno"></i>
                </div>
                <p class="formulario1__input_error" v-if="tocado.apellido_materno && apellido_materno && !valid.apellido_materno">El apellido solo debe tener letras</p>
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
                        placeholder="1234jose@gmail.com"
                        @input="validarCampo('email')"
                        @blur="marcarComoTocado('email')"
                        autocomplete="off">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('email')" v-show="tocado.email"></i>
                </div>
                <p class="formulario1__input_error" v-if="tocado.email && email && !valid.email">El email no es válido</p>
            </div>

            <!-- Contraseña -->
            <div class="formulario1__grupo" :class="getClaseValidacion('clave')">
                <label for="clave" class="formulario1__label">Contraseña</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="password" 
                        v-model="clave" 
                        id="clave" 
                        class="formulario1__input" 
                        placeholder="****"
                        @input="validarCampo('clave')"
                        @blur="marcarComoTocado('clave')"
                        autocomplete="off">
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
                        placeholder="4431000550"
                        @input="validarCampo('telefono')"
                        @blur="marcarComoTocado('telefono')"
                        autocomplete="off">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('telefono')" v-show="tocado.telefono"></i>
                </div>
                <p class="formulario1__input_error" v-if="tocado.telefono && telefono && !valid.telefono">El teléfono solo debe contener números (7-14 dígitos)</p>
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="formulario1__grupo" :class="getClaseValidacion('fecha_nac')">
                <label for="fecha_nac" class="formulario1__label">Fecha de nacimiento</label>
                <div class="formulario1__grupo_input">
                    <input 
                        type="date" 
                        v-model="fecha_nac" 
                        id="fecha_nac" 
                        class="formulario1__input"
                        @change="validarCampo('fecha_nac'); marcarComoTocado('fecha_nac')">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('fecha_nac')" v-show="tocado.fecha_nac"></i>
                </div>
                <p class="formulario1__input_error" v-if="tocado.fecha_nac && !valid.fecha_nac">Selecciona tu fecha de nacimiento</p>
            </div>

            <!-- Estado -->
            <div class="formulario1__grupo" :class="getClaseValidacion('estado')">
                <label for="estado" class="formulario1__label">Estado</label>
                <div class="formulario1__grupo_input">
                    <select v-model="estado" id="estado" class="formulario1__input" @change="validarCampo('estado'); marcarComoTocado('estado')">
                        <option value="">Selecciona un estado</option>
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
                <p class="formulario1__input_error" v-if="tocado.estado && !valid.estado">Selecciona tu estado</p>
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
                        placeholder="Morelia"
                        @input="validarCampo('ciudad')"
                        @blur="marcarComoTocado('ciudad')"
                        autocomplete="off">
                    <i class="formulario1__validacion-estado fa-solid" :class="getClaseIcono('ciudad')" v-show="tocado.ciudad"></i>
                </div>
                <p class="formulario1__input_error" v-if="tocado.ciudad && ciudad && !valid.ciudad">La ciudad solo debe tener letras</p>
            </div>

<div class="formulario1__grupo" :class="getClaseValidacion('rol')">
    <label for="rol" class="formulario1__label">Rol</label>
    <div class="formulario1__grupo_input">
        <select 
            v-model="rol" 
            id="rol" 
            class="formulario1__input"
            @change="validarCampo('rol'); marcarComoTocado('rol')">
            <option value="">Selecciona un rol</option>
            <option value="2">Cliente</option>
            <option value="3">Vendedor</option>
        </select>
        <i class="formulario1__validacion-estado fa-solid" 
           :class="getClaseIcono('rol')" 
           v-show="tocado.rol && rol !== ''"></i>
    </div>
    <p class="formulario1__input_error" 
       v-if="tocado.rol && !valid.rol">
        El rol es obligatorio
    </p>
</div>


        <!-- Términos -->
<div class="formulario1__grupo formulario1__grupo-terminos">
    <label>
        <input 
            type="checkbox" 
            v-model="terminos" 
            id="terminos"
            class="formulario1__checkbox"
            @change="console.log('Checkbox cambió:', terminos)">
        Acepto los términos y condiciones
    </label>
    <p style="color: #666; font-size: 12px; margin-top: 5px;">
        Estado actual: {{ terminos ? '✓ Aceptado' : '✗ No aceptado' }}
    </p>
</div>

<div class="formulario1__grupo formulario1__grupo-btn-enviar">
    <button type="submit" class="formulario1__btn" :disabled="enviando">
        {{ enviando ? 'Enviando...' : 'Confirmar' }}
    </button>
    <p class="formulario1__mensaje-exito" v-if="exito">✓ Formulario enviado exitosamente</p>
</div>
        </form>
        </div>

        

        <footer class="footer">
        <h4>Información</h4>
        <ul>
            <li><a href="mailto:lopezrochaangel30@gmail.com">Enviar correo</a></li>    
        </ul>
            <a href="https://jigsaw.w3.org/css-validator/validator?lang=en&profile=css3svg&uri=https%3A%2F%2Fjose-angel-lopez-rocha.github.io%2Fweb%2FConexion%2FCSS%2Fformularios.css&usermedium=all&vextwarning=&warning=1">
                <img style="border:0;width:88px;height:31px" src="https://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!">
            </a>
        </p>
        <p>
            <a href="https://jigsaw.w3.org/css-validator/validator?lang=en&profile=css3svg&uri=https%3A%2F%2Fjose-angel-lopez-rocha.github.io%2Fweb%2FConexion%2FCSS%2Fformularios.css&usermedium=all&vextwarning=&warning=1">
                <img style="border:0;width:88px;height:31px" src="https://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS!">
            </a>
        </p>      
    </footer>
</div>
<script src="../js/formulario.js"></script>

</body>
</html>
