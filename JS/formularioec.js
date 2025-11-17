const { createApp } = Vue;

createApp({
  data() {
    return {
      clienteId: null,

      nombre: '',
      apellido_paterno: '',
      apellido_materno: '',
      email: '',
      clave: '',
      telefono: '',
      fecha_nac: '',
      estado: '',
      ciudad: '',
      rol: '',

      valid: {
        nombre: true,
        apellido_paterno: true,
        apellido_materno: true,
        email: true,
        clave: true,
        telefono: true,
        fecha_nac: true,
        estado: true,
        ciudad: true,
        rol: true,
      },

      tocado: {
        nombre: false,
        apellido_paterno: false,
        apellido_materno: false,
        email: false,
        clave: false,
        telefono: false,
        fecha_nac: false,
        estado: false,
        ciudad: false,
        rol: false,
      },

      cargando: false,
      enviando: false,
      error: false,
      exito: false,
      mensajeError: ''
    };
  },

  methods: {
    async cargarCliente(id) {
      this.cargando = true;
      this.clienteId = id;

      try {
        const response = await fetch(`obtener_cliente.php?id=${id}`);
        const resultado = await response.json();

        if (resultado.success) {
          const u = resultado.data;

          this.nombre = u.nombre;
          this.apellido_paterno = u.apellido_paterno;
          this.apellido_materno = u.apellido_materno;
          this.email = u.email;
          this.telefono = u.telefono;
          this.fecha_nac = u.fecha_nac;
          this.estado = u.estado;
          this.ciudad = u.ciudad;
          this.rol = u.rol;
          this.clave = '';

        } else {
          this.mensajeError = resultado.message;
          this.error = true;
        }
      } catch (err) {
        this.mensajeError = "Error al cargar el cliente";
        this.error = true;
      } finally {
        this.cargando = false;
      }
    },

    regex(campo) {
      const reglas = {
        nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
        apellido_paterno: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
        apellido_materno: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
        email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
        telefono: /^[0-9]{10}$/, 
        estado: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
        ciudad: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
      };
      return reglas[campo] || /.*/;
    },

    marcarComoTocado(campo) {
      this.tocado[campo] = true;
      this.validarCampo(campo);
    },

    validarCampo(campo) {
      if (campo === 'fecha_nac') {
        this.valid[campo] = this[campo] !== '';
        return;
      }

      if (campo === 'rol') {
        this.valid[campo] = this.rol !== '';
        return;
      }

      if (campo === 'clave') {
        if (this.clave === '') {
          this.valid.clave = true;
        } else {
          this.valid.clave = this.clave.length >= 4;
        }
        return;
      }

      this.valid[campo] = this.regex(campo).test(this[campo]);
    },

    getClaseValidacion(campo) {
      if (!this.tocado[campo]) return '';
      return this.valid[campo] ? 'formulario1__grupo-correcto' : 'formulario1__grupo-incorrecto';
    },

    getClaseIcono(campo) {
      return this.valid[campo] ? 'fa-circle-check' : 'fa-circle-xmark';
    },

    validarFormulario() {
      Object.keys(this.tocado).forEach(c => this.tocado[c] = true);
      Object.keys(this.valid).forEach(c => this.validarCampo(c));

      const todosValidos = Object.values(this.valid).every(v => v);

      if (!todosValidos) {
        this.mensajeError = "Completa todos los campos correctamente";
        this.error = true;
        setTimeout(() => this.error = false, 5000);
      }

      return todosValidos;
    },

    async actualizarCliente() {
      if (!this.validarFormulario()) return;

      this.enviando = true;

      const datos = {
        id: this.clienteId,
        nombre: this.nombre,
        apellido_paterno: this.apellido_paterno,
        apellido_materno: this.apellido_materno,
        email: this.email,
        telefono: this.telefono,
        fecha_nac: this.fecha_nac,
        estado: this.estado,
        ciudad: this.ciudad,
        rol: this.rol,
      };

      if (this.clave !== '') {
        datos.clave = this.clave;
      }

      try {
        const response = await fetch('actualizar_cliente.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(datos)
        });

        const resultado = await response.json();

        if (resultado.success) {
          this.exito = true;
          setTimeout(() => this.exito = false, 2000);
        } else {
          this.mensajeError = resultado.message;
          this.error = true;
          setTimeout(() => this.error = false, 5000);
        }
      } catch (err) {
        this.mensajeError = "Error al actualizar cliente";
        this.error = true;
        setTimeout(() => this.error = false, 5000);
      } finally {
        this.enviando = false;
      }
    }
  },

  mounted() {
    const id = new URLSearchParams(window.location.search).get('id');
    if (id) {
      this.cargarCliente(id);
    } else {
      this.mensajeError = "No se especificó ID del cliente";
      this.error = true;
    }
  }
}).mount("#app");