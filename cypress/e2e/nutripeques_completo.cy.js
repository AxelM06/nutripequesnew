describe('Pruebas E2E Exactas - Nutripeques (Laravel + Firebase)', () => {

  // Tu URL base configurada
  const baseUrl = 'http://localhost:81/goddess/public';

  // ============================================================
  // MÓDULO 1: AUTENTICACIÓN (Usando login.blade.php)
  // ============================================================
  context('1. Flujos de Inicio de Sesión', () => {
    
    beforeEach(() => {
      cy.visit(`${baseUrl}/login`);
    });

    it('Debería denegar el acceso con credenciales incorrectas y mostrar .error-msg', () => {
      // Usando exactamente los name="" de tu form en login.blade.php
      cy.get('input[name="email"]').type('correo_falso@ejemplo.com');
      cy.get('input[name="password"]').type('ClaveFalsa123');
      
      // En tu login, el botón tiene la clase .btn-primary y type="submit"
      cy.get('button[type="submit"].btn-primary').click();
      
      // Tu login.blade.php muestra el error en un div con clase "error-msg"
      cy.get('.error-msg').should('be.visible');
    });

    it('Debería iniciar sesión correctamente como usuario', () => {
      // Reemplaza esto con un usuario que sí exista en tu Firebase
      cy.get('input[name="email"]').type('alana1@gmail.com');
      cy.get('input[name="password"]').type('Nombre Editado Cypress');
      cy.get('button[type="submit"].btn-primary').click();
      
      // Dependiendo del rol, Laravel redirige. Asumimos que va al panel de usuario
      cy.url().should('not.include', '/login');
    });
  });

  // ============================================================
  // MÓDULO 2: VISTA DE "MIS HIJOS" (hijos_registrados.blade.php)
  // ============================================================
  context('2. Panel del Padre - Mis Hijos', () => {

    beforeEach(() => {
      // Iniciar sesión antes de entrar
      cy.visit(`${baseUrl}/login`);
      cy.get('input[name="email"]').type('alana1@gmail.com'); // PON TU CORREO REAL
      cy.get('input[name="password"]').type('Nombre Editado Cypress'); // PON TU CLAVE REAL
      cy.get('button[type="submit"].btn-primary').click();
    });

    it('Debería cargar la vista de hijos registrados con sus tarjetas y botón de plan', () => {
      // Visitamos la ruta exacta definida en routes/web.php
      cy.visit(`${baseUrl}/hijos-registrados`);
      
      // Verificamos que cargue el título exacto de tu Blade
      cy.contains('Mis Hijos Registrados').should('be.visible');

      // Verificamos que se renderice al menos una tarjeta de hijo (clase .child-card en tu CSS)
      // Nota: Esta prueba pasará si el padre tiene al menos 1 hijo registrado.
      cy.get('.child-card').should('exist');

      // Verificamos que el botón "Ver Plan Nutricional" (clase .btn-plan) esté presente
      cy.get('.btn-plan').first().should('contain', 'Ver Plan Nutricional');
    });
  });

  // ============================================================
  // MÓDULO 3: EDICIÓN DE PERFIL (editar_perfil.blade.php)
  // ============================================================
  context('3. Actualización de Perfil Dinámica', () => {

    beforeEach(() => {
      cy.visit(`${baseUrl}/login`);
      cy.get('input[name="email"]').type('alana1@gmail.com'); 
      cy.get('input[name="password"]').type('Nombre Editado Cypress');
      cy.get('button[type="submit"].btn-primary').click();
    });

    it('Debería llenar el formulario de edición y enviarlo', () => {
      // Pon aquí un ID real de Firebase para probar la ruta
      const idUsuarioTest = 'NTH3HJQxAarMjZTCJwSP'; 
      cy.visit(`${baseUrl}/editar-perfil/${idUsuarioTest}`);

      // Tu Blade genera inputs dinámicos. Vamos a simular que cambiamos el nombre
      cy.get('form input.form-control').first().clear().type('Nombre Editado Cypress');
      
      // Clic en el botón que definiste en tu Blade con la clase .btn-update
      cy.get('button[type="submit"].btn-update').click();

      // Tu ViewController hace: redirect()->back()->with('status', '¡Perfil actualizado...')
      // Validamos que aparezca ese mensaje exacto (si lo estás imprimiendo en la vista)
      // cy.contains('Perfil actualizado').should('be.visible'); 
    });
  });

  // ============================================================
  // MÓDULO 4: ASIGNACIÓN DE PLANES POR ADMINISTRADOR
  // ============================================================
  context('4. Flujo Administrador - Prescribir Plan a Niño', () => {

    beforeEach(() => {
      // 1. Iniciar sesión con las credenciales exactas del Admin
      cy.visit(`${baseUrl}/login`);
      cy.get('input[name="email"]').type('12vargasleosarturonew@gmail.com');
      cy.get('input[name="password"]').type('12345678');
      cy.get('button[type="submit"].btn-primary').click();
    });

    it('Debería navegar al expediente del niño, llenar el plan y guardarlo como Admin', () => {
      
      // 2. Entrar al home (como lo haces manualmente)
      cy.visit(`${baseUrl}/home`);
      
      // 3. Ir a la vista de "Niños registrados" (que en tus rutas es /ver-ninos)
      cy.visit(`${baseUrl}/ver-ninos`);

      // 4. Entrar al formulario de asignar plan con el ID real de tu Firebase
      const idNinoTest = 'nfNDYJEL6ZSnvrQe2luf'; 
      cy.visit(`${baseUrl}/asignar-plan-nino/${idNinoTest}`);
      
      // Verificamos que cargó la vista de asignación
      cy.contains('Prescribir Plan Nutricional').should('be.visible');

      // 5. Llenamos los campos exactos del formulario
      cy.get('input[name="titulo_plan"]').type('Plan de Control de Peso Cypress');
      cy.get('textarea[name="detalle_plan"]').clear().type('Incrementar verduras en la comida. Tomar 2 litros de agua.');
      cy.get('input[name="calorias"]').type('1600');
      // Ponemos una fecha futura válida
      cy.get('input[name="proxima_cita"]').type('2026-05-20');

      // 6. Simulamos la subida del archivo PDF 
      // (Asegúrate de tener un archivo llamado dummy.pdf en la carpeta cypress/fixtures/)
      cy.get('input[name="archivo_adjunto"]').selectFile('cypress/fixtures/dummy.pdf');

      // 7. Clic en el botón "Guardar y Notificar"
      cy.get('button[type="submit"].btn-assign').click();

      // 8. Validación de redirección y mensaje de éxito del Administrador
      cy.url().should('include', '/ver-ninos');
      //cy.contains('¡Plan nutricional guardado correctamente como Administrador!').should('be.visible');
    });
  });

  // ============================================================
  // MÓDULO 5: REGISTRO DE CUENTA NUEVA (register.blade.php)
  // ============================================================
  context('5. Flujo de Registro de Usuario', () => {

    beforeEach(() => {
      // Entramos directamente a la ruta de registro
      cy.visit(`${baseUrl}/register`);
    });

    it('Debería crear una cuenta exitosamente con un correo nuevo', () => {
      
      // Comprobamos que cargó bien la vista
      cy.contains('Crear Cuenta').should('be.visible');

      // Llenamos el formulario con los 'name' exactos de tu código
      cy.get('input[name="name"]').type('Nuevo Usuario');
      cy.get('input[name="last_name"]').type('De Prueba');
      
      // Generamos un correo aleatorio para evitar el error de Firebase "El correo ya existe"
      // Ejemplo: usuario_5342@nutripeques.com
      const randomId = Math.floor(Math.random() * 10000);
      cy.get('input[name="email"]').type(`usuario_${randomId}@nutripeques.com`);
      
      cy.get('input[name="password"]').type('Seguridad123!');

      // Clic en el botón de registrarme
      cy.get('button[type="submit"].btn-primary').click();

      // Al guardar exitosamente, Laravel suele redirigir al Login o al Dashboard.
      // Validamos que ya no estemos en la página de registro
      cy.url().should('not.include', '/register');
    });
  });

});