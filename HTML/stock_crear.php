
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
  <title>Formulario de Stock</title>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- CSS del formulario -->
  <link href="../CSS/crear2.css" rel="stylesheet">
  
  <!-- Vue.js -->
  <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
  <div id="app">
    <form @submit.prevent="enviarFormulario" class="formulario_stock" id="formulario_stock">

      <!-- Marca -->
      <div class="formulario_stock__grupo" :class="getClaseValidacion('marca')">
        <label for="marca" class="formulario_stock__label">Marca</label>
        <div class="formulario_stock__grupo_input">
          <input 
            type="text" 
            v-model="marca" 
            id="marca" 
            class="formulario_stock__input" 
            placeholder="Nike" 
            @input="validarCampo('marca')"
            @blur="marcarComoTocado('marca')"
            autocomplete="off">
          <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('marca')" v-show="tocado.marca"></i>
        </div>
        <p class="formulario_stock__input_error" v-if="tocado.marca && marca && !valid.marca">La marca solo debe tener letras</p>
      </div>

      <!-- Talla -->
      <div class="formulario_stock__grupo" :class="getClaseValidacion('talla')">
        <label for="talla" class="formulario_stock__label">Talla</label>
        <div class="formulario_stock__grupo_input">
          <select v-model="talla" id="talla" class="formulario_stock__input" @change="validarCampo('talla'); marcarComoTocado('talla')">
            <option value="">Selecciona una talla</option>
            <option value="XS">XS</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
          </select>
          <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('talla')" v-show="tocado.talla"></i>
        </div>
        <p class="formulario_stock__input_error" v-if="tocado.talla && !valid.talla">Selecciona una talla</p>
      </div>

      <!-- Color -->
      <div class="formulario_stock__grupo" :class="getClaseValidacion('color')">
        <label for="color" class="formulario_stock__label">Color</label>
        <div class="formulario_stock__grupo_input">
          <input 
            type="text" 
            v-model="color" 
            id="color" 
            class="formulario_stock__input" 
            placeholder="Rojo" 
            @input="validarCampo('color')"
            @blur="marcarComoTocado('color')"
            autocomplete="off">
          <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('color')" v-show="tocado.color"></i>
        </div>
        <p class="formulario_stock__input_error" v-if="tocado.color && color && !valid.color">El color solo debe tener letras</p>
      </div>

      <!-- stock -->
      <div class="formulario_stock__grupo" :class="getClaseValidacion('stock')">
        <label for="stock" class="formulario_stock__label">stock</label>
        <div class="formulario_stock__grupo_input">
          <input 
            type="number" 
            v-model="stock" 
            id="stock" 
            class="formulario_stock__input" 
            placeholder="100" 
            @input="validarCampo('stock')"
            @blur="marcarComoTocado('stock')"
            min="1"
            autocomplete="off">
          <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('stock')" v-show="tocado.stock"></i>
        </div>
        <p class="formulario_stock__input_error" v-if="tocado.stock && stock && !valid.stock">La stock debe ser mayor a 0</p>
      </div>

      <!-- Precio -->
      <div class="formulario_stock__grupo" :class="getClaseValidacion('precio')">
        <label for="precio" class="formulario_stock__label">Precio</label>
        <div class="formulario_stock__grupo_input">
          <input 
            type="number" 
            v-model="precio" 
            id="precio" 
            class="formulario_stock__input" 
            placeholder="200" 
            @input="validarCampo('precio')"
            @blur="marcarComoTocado('precio')"
            min="0.01"
            step="0.01"
            autocomplete="off">
          <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('precio')" v-show="tocado.precio"></i>
        </div>
        <p class="formulario_stock__input_error" v-if="tocado.precio && precio && !valid.precio">El precio debe ser mayor a 0</p>
      </div>

      <!-- Categoría -->
      <div class="formulario_stock__grupo" :class="getClaseValidacion('categoria')">
        <label for="categoria" class="formulario_stock__label">Categoría</label>
        <div class="formulario_stock__grupo_input">
          <select v-model="categoria" id="categoria" class="formulario_stock__input" @change="validarCampo('categoria'); marcarComoTocado('categoria')">
            <option value="">Selecciona una categoría</option>
            <option value="casual">Casual</option>
            <option value="formal">Formal</option>
            <option value="deportivo">Deportivo</option>
          </select>
          <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('categoria')" v-show="tocado.categoria"></i>
        </div>
        <p class="formulario_stock__input_error" v-if="tocado.categoria && !valid.categoria">Selecciona una categoría</p>
      </div>

      <!-- Términos -->
      <div class="formulario_stock__grupo-terminos">
        <label>
          <input type="checkbox" v-model="terminos" id="terminos">
          Acepto los términos y condiciones
        </label>
      </div>

    
      <!-- Mensajes de error/éxito -->
  <div v-if="error" class="mensaje-error">
    {{ mensajeError }}
  </div>

  <div v-if="exito" class="mensaje-exito">
    ✓ Calzado registrado exitosamente
  </div>

<!-- Botón enviar -->
<button class="formulario_stock__btn" type="submit" :disabled="enviando">
    {{ enviando ? 'Guardando...' : 'Agregar Calzado' }}
</button>

    </form>
  </div>
<footer class="footer">
        <h4>Información</h4>
        <ul>
            <li><a href="mailto:lopezrochaangel30@gmail.com">Enviar correo</a></li>    
        </ul>
        <p>
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

  <!-- JavaScript del formulario -->
  <script src="../js/formulario2.js"></script>
</body>
</html>
