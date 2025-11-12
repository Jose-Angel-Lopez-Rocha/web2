const { createApp } = Vue;

createApp({
  data() {
    return {
      marca: '',
      talla: '',
      color: '',
      stock: '',
      precio: '',
      categoria: '',
      terminos: false,

      valid: {
        marca: false,
        talla: false,
        color: false,
        stock: false,
        precio: false,
        categoria: false,
      },

      tocado: {
        marca: false,
        talla: false,
        color: false,
        stock: false,
        precio: false,
        categoria: false,
      },

      error: false,
      exito: false,
      mensajeError: '',
      enviando: false
    };
  },

  methods: {
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

      const todosValidos = Object.values(this.valid).every(v => v) && this.terminos;

      console.log('Validación:', this.valid);
      console.log('Términos:', this.terminos);
      console.log('¿Válido?:', todosValidos);

      if (!todosValidos) {
        const invalidos = Object.keys(this.valid).filter(k => !this.valid[k]);
        console.log('Campos inválidos:', invalidos);
        
        this.mensajeError = "Completa todos los campos y acepta los términos";
        this.error = true;
        setTimeout(() => this.error = false, 5000);
      }

      return todosValidos;
    },

    async enviarFormulario() {
      console.log('=== ENVIANDO FORMULARIO ===');
      
      if (!this.validarFormulario()) {
        console.log('❌ Validación falló');
        return;
      }

      console.log('✅ Validación exitosa');
      this.enviando = true;

      const datos = {
        marca: this.marca,
        talla: this.talla,
        color: this.color,
        stock: this.stock,
        precio: this.precio,
        categoria: this.categoria
      };

      try {
        console.log('📤 Enviando:', datos);
        
        const response = await fetch('guardar_calzado.php', {
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
          console.log('✅ Guardado con ID:', resultado.id);

          setTimeout(() => {
            this.exito = false;
            this.resetFormulario();
          }, 3000);
        } else {
          this.mensajeError = resultado.message;
          this.error = true;
          console.error('❌', resultado.message);
          setTimeout(() => this.error = false, 5000);
        }
      } catch (err) {
        this.mensajeError = "Error de conexión con el servidor";
        this.error = true;
        console.error('❌ Error:', err);
        setTimeout(() => this.error = false, 5000);
      } finally {
        this.enviando = false;
      }
    },

    resetFormulario() {
      this.marca = '';
      this.talla = '';
      this.color = '';
      this.stock = '';
      this.precio = '';
      this.categoria = '';
      this.terminos = false;

      Object.keys(this.valid).forEach(k => this.valid[k] = false);
      Object.keys(this.tocado).forEach(k => this.tocado[k] = false);
    }
  },

  mounted() {
    console.log('✅ Formulario Calzado cargado');
    console.log('Métodos disponibles:', Object.keys(this));
  }
}).mount("#app");