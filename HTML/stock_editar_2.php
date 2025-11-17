
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
    <title>Editar Calzado</title>
    <link rel="stylesheet" href="../CSS/crear2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div id="app">
        <!-- Indicador de carga -->
        <div v-if="cargando" class="cargando">
            <p>⏳ Cargando datos del calzado...</p>
        </div>

        <!-- Formulario de edición -->
        <form @submit.prevent="actualizarCalzado" class="formulario_stock" v-if="!cargando">
            <h2>Editar Calzado #{{ calzadoId }}</h2>

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
                        @blur="marcarComoTocado('marca')">
                    <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('marca')" v-show="tocado.marca"></i>
                </div>
                <p class="formulario_stock__input_error" v-if="tocado.marca && !valid.marca">La marca solo debe contener letras</p>
            </div>

            <!-- Talla -->
            <div class="formulario_stock__grupo" :class="getClaseValidacion('talla')">
                <label for="talla" class="formulario_stock__label">Talla</label>
                <div class="formulario_stock__grupo_input">
                    <select 
                        v-model="talla" 
                        id="talla" 
                        class="formulario_stock__input"
                        @change="validarCampo('talla'); marcarComoTocado('talla')">
                        <option value="">Selecciona una talla</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
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
                        placeholder="Negro"
                        @input="validarCampo('color')"
                        @blur="marcarComoTocado('color')">
                    <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('color')" v-show="tocado.color"></i>
                </div>
                <p class="formulario_stock__input_error" v-if="tocado.color && !valid.color">El color solo debe contener letras</p>
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
                        placeholder="10"
                        min="1"
                        @input="validarCampo('stock')"
                        @blur="marcarComoTocado('stock')">
                    <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('stock')" v-show="tocado.stock"></i>
                </div>
                <p class="formulario_stock__input_error" v-if="tocado.stock && !valid.stock">La stock debe ser mayor a 0</p>
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
                        placeholder="999.99"
                        step="0.01"
                        min="0.01"
                        @input="validarCampo('precio')"
                        @blur="marcarComoTocado('precio')">
                    <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('precio')" v-show="tocado.precio"></i>
                </div>
                <p class="formulario_stock__input_error" v-if="tocado.precio && !valid.precio">Ingresa un precio válido</p>
            </div>

            <!-- Categoría -->
            <div class="formulario_stock__grupo" :class="getClaseValidacion('categoria')">
                <label for="categoria" class="formulario_stock__label">Categoría</label>
                <div class="formulario_stock__grupo_input">
                    <select 
                        v-model="categoria" 
                        id="categoria" 
                        class="formulario_stock__input"
                        @change="validarCampo('categoria'); marcarComoTocado('categoria')">
                        <option value="">Selecciona una categoría</option>
                        <option value="Deportivo">Deportivo</option>
                        <option value="Casual">Casual</option>
                        <option value="Formal">Formal</option>
                        <option value="Infantil">Infantil</option>
                    </select>
                    <i class="formulario_stock__validacion-estado fa-solid" :class="getClaseIcono('categoria')" v-show="tocado.categoria"></i>
                </div>
                <p class="formulario_stock__input_error" v-if="tocado.categoria && !valid.categoria">Selecciona una categoría</p>
            </div>

            <!-- Mensajes -->
            <div class="mensaje-error" v-if="error">
                ❌ {{ mensajeError }}
            </div>

            <div class="mensaje-exito" v-if="exito">
                ✅ Calzado actualizado exitosamente
            </div>

            <!-- Botones -->
            <div class="formulario_stock__grupo-botones">
                <button type="submit" class="formulario_stock__btn" :disabled="enviando">
                    {{ enviando ? 'Guardando...' : 'Actualizar Calzado' }}
                </button>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="../JS/formularioes.js"></script>
</body>
</html>