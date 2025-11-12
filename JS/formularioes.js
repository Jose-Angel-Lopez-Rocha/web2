const { createApp } = Vue;

createApp({
  data() {
    return {
      calzadoId: null,
      marca: '',
      talla: '',
      color: '',
      stock: '',
      precio: '',
      categoria: '',

      valid: {
        marca: true,
        talla: true,
        color: true,
        stock: true,
        precio: true,
        categoria: true,
      },

      tocado: {
        marca: false,
        talla: false,
        color: false,
        stock: false,
        precio: false,
        categoria: false,
      },

      cargando: false,
      enviando: false,
      error: false,
      exito: false,
      mensajeError: ''
    };
  },

  methods: {
    // Cargar datos del calzado
    async cargarCalzado(id) {
      this.cargando = true;
      this.calzadoId = id;

      try {
        console.log('📥 Cargando calzado ID:', id);
        const response = await fetch(`obtener_calzado.php?id=${id}`);
        const resultado = await response.json();

        if (resultado.success) {
          const calzado = resultado.data;
          this.marca = calzado.marca;
          this.talla = calzado.talla;
          this.color = calzado.color;
          this.stock = calzado.stock;
          this.precio = calzado.precio;
          this.categoria = calzado.categoria;

          console.log('✅ Calzado cargado:', calzado);
        } else {
          this.mensajeError = resultado.message;
          this.error = true;
        }
      } catch (err) {
        this.mensajeError = "Error al cargar el calzado";
        this.error = true;
        console.error('❌ Error:', err);
      } finally {
        this.cargando = false;
      }
    },

    regex(campo) {
      const reglas = {
        marca: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
        color: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
        stock: /^[1-9]\d*$/,
        precio: /^\d+(\.\d{1,2})?$/
      };
      return reglas[campo] || /.*/;
    },

    marcarComoTocado(campo) {
      this.tocado[campo] = true;
      this.validarCampo(campo);
    },

    validarCampo(campo) {
      if (campo === 'talla' || campo === 'categoria') {
        this.valid[campo] = this[campo] !== '';
      } else {
        this.valid[campo] = this.regex(campo).test(this[campo]);
      }
    },

    getClaseValidacion(campo) {
      if (!this.tocado[campo]) return '';
      return this.valid[campo] ? 'formulario_stock__grupo-correcto' : 'formulario_stock__grupo-incorrecto';
    },

    getClaseIcono(campo) {
      return this.valid[campo] ? 'fa-circle-check' : 'fa-circle-xmark';
    },

    validarFormulario() {
      Object.keys(this.tocado).forEach(c => this.tocado[c] = true);
      Object.keys(this.valid).forEach(c => this.validarCampo(c));

      const todosValidos = Object.values(this.valid).every(v => v);

      console.log('Validación:', this.valid);
      console.log('¿Válido?:', todosValidos);

      if (!todosValidos) {
        const invalidos = Object.keys(this.valid).filter(k => !this.valid[k]);
        console.log('Campos inválidos:', invalidos);
        
        this.mensajeError = "Completa todos los campos correctamente";
        this.error = true;
        setTimeout(() => this.error = false, 5000);
      }

      return todosValidos;
    },

    async actualizarCalzado() {
      if (!this.validarFormulario()) {
        console.log('❌ Validación falló');
        return;
      }

      console.log('=== ACTUALIZANDO CALZADO ===');
      this.enviando = true;

      const datos = {
        id: this.calzadoId,
        marca: this.marca,
        talla: this.talla,
        color: this.color,
        stock: this.stock,
        precio: this.precio,
        categoria: this.categoria
      };

      try {
        console.log('📤 Enviando:', datos);
        
        const response = await fetch('actualizar_calzado.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(datos)
        });

        console.log('📥 Status:', response.status);
        const resultado = await response.json();
        console.log('📥 Respuesta:', resultado);

        if (resultado.success) {
          this.exito = true;
          this.error = false;
          console.log('✅ Calzado actualizado');

          setTimeout(() => {
            this.exito = false;
            // Opcional: redirigir a lista de calzado
            // window.location.href = 'lista_calzado.html';
          }, 2000);
        } else {
          this.mensajeError = resultado.message;
          this.error = true;
          console.error('❌', resultado.message);
          setTimeout(() => this.error = false, 5000);
        }
      } catch (err) {
        this.mensajeError = "Error al actualizar el calzado";
        this.error = true;
        console.error('❌ Error:', err);
        setTimeout(() => this.error = false, 5000);
      } finally {
        this.enviando = false;
      }
    }
  },

  mounted() {
    console.log('✅ Formulario Editar Calzado cargado');
    
    // Obtener ID de la URL (ejemplo: editar_calzado.html?id=5)
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    if (id) {
      this.cargarCalzado(id);
    } else {
      this.mensajeError = "No se especificó ID de calzado";
      this.error = true;
    }
  }
}).mount("#app");