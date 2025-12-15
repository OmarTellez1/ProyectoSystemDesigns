describe('Prueba E2E en Producción (Heroku)', () => {
  
  beforeEach(() => {
    // Visitamos tu URL real
    // Le damos 2 minutos (120000 ms) por si Heroku está "dormido"
    cy.visit('https://mi-app-asistencia-aa9b764d7d3a.herokuapp.com/vistas/login.php', { timeout: 120000 });
  });

  it('CP-01: Validación de Acceso Denegado (Producción)', () => {
    // 1. Verificar que la página cargó (buscamos el botón de ingresar)
    cy.get('button[type="submit"]').should('be.visible');

    // 2. Intentar entrar con datos falsos
    cy.get('input[name="logina"]').type('usuario_falso_test');
    cy.get('input[name="clavea"]').type('clave_erronea_123');
    
    // 3. Click en Ingresar
    cy.get('button[type="submit"]').click();

    // 4. Validación:
    // Aseguramos que NO nos saque del login.php
    cy.url().should('include', 'login.php');
  });

  it('CP-02: Acceso Exitoso - Happy Path (Producción)', () => {
    
    cy.get('input[name="logina"]').type('admin'); 
    cy.get('input[name="clavea"]').type('admin');
    
    // 2. Click en Ingresar
    cy.get('button[type="submit"]').click();

    // 3. Validación de Redirección:
    // Esperamos llegar a 'escritorio.php'
    cy.url().should('include', 'escritorio.php');
    
    // 4. Verificamos que cargó el contenido visual
    cy.get('body').should('contain', 'Escritorio');
  });
});