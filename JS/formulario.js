const { createApp } = Vue;

createApp({
    data() {
        return {
            // Campos del formulario
            nombre: "",
            apellido_paterno: "",
            apellido_materno: "",
            email: "",
            clave: "",
            telefono: "",
            fecha_nac: "",
            estado: "",
            ciudad: "",
            rol:"",
            terminos: false,

            // Estados de validación
            valid: {
                nombre: false,
                apellido_paterno: false,
                apellido_materno: false,
                email: false,
                clave: false,
                telefono: false,
                fecha_nac: false,
                estado: false,
                ciudad: false,
                rol: false
            },

            // Campos tocados
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
                rol: false
            },

            // Mensajes
            exito: false,
            error: false,
            mensajeError: "",
            enviando: false
        };
    },
    methods: {
        validarCampo(campo) {
            const expresiones = {
                nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
                apellido_paterno: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
                apellido_materno: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
                email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
                clave: /^.{4,12}$/,
                telefono: /^\d{7,14}$/,
                ciudad: /^[a-zA-ZÀ-ÿ\s]{1,40}$/
            };

            switch(campo) {
                case 'nombre':
                case 'apellido_paterno':
                case 'apellido_materno':
                case 'email':
                case 'clave':
                case 'telefono':
                case 'ciudad':
                    this.valid[campo] = expresiones[campo].test(this[campo].trim());
                    break;
                case 'fecha_nac':
                case 'estado':
                    this.valid[campo] = this[campo] !== "";
                    break;
                 case 'rol':
                    this.valid[campo] = this[campo] === "2" || this[campo] === "3";
                    break;
            }
        },

        marcarComoTocado(campo) {
            this.tocado[campo] = true;
            this.validarCampo(campo);
        },

        getClaseValidacion(campo) {
            return {
                'formulario1__grupo-correcto': this.tocado[campo] && this.valid[campo],
                'formulario1__grupo-incorrecto': this.tocado[campo] && !this.valid[campo]
            };
        },

        getClaseIcono(campo) {
            return this.valid[campo] ? 'fa-circle-check' : 'fa-circle-xmark';
        },

        validarFormulario() {
            Object.keys(this.tocado).forEach(campo => this.tocado[campo] = true);
            Object.keys(this.valid).forEach(campo => this.validarCampo(campo));

            const todosValidos = Object.values(this.valid).every(v => v) && this.terminos;

            // DEBUG: Ver qué campos fallan
            console.log('Estado de validación:', this.valid);
            console.log('Términos aceptados:', this.terminos);
            console.log('Todos válidos:', todosValidos);

            if(!todosValidos) {
                // Encontrar qué campos están inválidos
                const camposInvalidos = Object.keys(this.valid).filter(k => !this.valid[k]);
                console.log('Campos inválidos:', camposInvalidos);
                
                this.mensajeError = "Por favor completa todos los campos correctamente";
                this.error = true;
                this.exito = false;
                setTimeout(() => { this.error = false; }, 5000);
            }

            return todosValidos;
        },

        // Enviar formulario con fetch a PHP
        async enviarFormulario() {
            console.log('=== INICIO ENVÍO FORMULARIO ===');
            
            if(this.validarFormulario()) {
                console.log('✓ Validación exitosa, enviando datos...');
                this.enviando = true;

                const datos = {
                    nombre: this.nombre,
                    apellido_paterno: this.apellido_paterno,
                    apellido_materno: this.apellido_materno,
                    email: this.email,
                    clave: this.clave,
                    telefono: this.telefono,
                    fecha_nac: this.fecha_nac,
                    estado: this.estado,
                    ciudad: this.ciudad,
                    rol:this.rol
                };

                console.log('Datos a enviar:', datos);

                try {
                    console.log('Haciendo petición a guardar_cliente.php...');
                    const response = await fetch('guardar_cliente.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(datos)
                    });

                    console.log('Respuesta recibida, status:', response.status);
                    const resultado = await response.json();
                    console.log('Resultado parseado:', resultado);

                    if(resultado.success) {
                        this.exito = true;
                        this.error = false;
                        console.log('✓ Registro guardado con ID:', resultado.id);

                        setTimeout(() => {
                            this.exito = false;
                            this.resetFormulario();
                        }, 3000);
                    } else {
                        this.mensajeError = resultado.message;
                        this.error = true;
                        this.exito = false;
                        console.error('✗ Error del servidor:', resultado.message);
                        setTimeout(() => { this.error = false; }, 5000);
                    }
                } catch(err) {
                    this.mensajeError = "Error al conectar con el servidor";
                    this.error = true;
                    this.exito = false;
                    console.error('✗ Error de conexión:', err);
                    setTimeout(() => { this.error = false; }, 5000);
                } finally {
                    this.enviando = false;
                }
            } else {
                console.log('✗ Validación fallida, no se envía');
            }
        },

        resetFormulario() {
            this.nombre = "";
            this.apellido_paterno = "";
            this.apellido_materno = "";
            this.email = "";
            this.clave = "";
            this.telefono = "";
            this.fecha_nac = "";
            this.estado = "";
            this.ciudad = "";
            this.rol = "";
            this.terminos = false;

            Object.keys(this.valid).forEach(key => this.valid[key] = false);
            Object.keys(this.tocado).forEach(key => this.tocado[key] = false);
        }
    },
    mounted() {
        console.log('Formulario Vue.js cargado correctamente');
        
        // Debug para verificar que Vue esté montado correctamente
        console.log('Estado inicial términos:', this.terminos);
        
        // Verificar que el checkbox esté vinculado
        this.$nextTick(() => {
            const checkbox = document.querySelector('input[type="checkbox"]');
            console.log('Checkbox encontrado:', checkbox);
            if(checkbox) {
                console.log('Checkbox v-model:', checkbox.__vnode);
            }
        });
    }
}).mount("#app");