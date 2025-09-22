# 🚛 Transportes Río Negro - Landing Page Moderna

## 📋 Descripción

Landing page completamente renovada para **Transportes Río Negro**, una empresa líder en transporte responsable y cuidado del medio ambiente. El sitio web presenta un diseño moderno, profesional y completamente responsive con animaciones suaves y efectos visuales atractivos.

## ✨ Características Principales

### 🎨 Diseño Moderno
- **Paleta de colores profesional**: Azules corporativos con acentos dorados
- **Tipografía moderna**: Inter y Poppins para mejor legibilidad
- **Gradientes y sombras**: Efectos visuales modernos y atractivos
- **Glass morphism**: Efectos de transparencia y blur

### 🌍 Sistema Multilingüe
- **Cambio de idioma**: Español ↔ Inglés
- **Traducciones completas** de todo el contenido
- **Persistencia de preferencia** en localStorage
- **Selectores elegantes** con banderas y animaciones
- **Traducción automática** de formularios y contenido dinámico

### 🌙 Modo Oscuro/Claro
- **Cambio de tema** con un solo clic
- **Transiciones suaves** entre modos
- **Persistencia de preferencia** en localStorage
- **Iconos dinámicos** (luna/sol)
- **Colores optimizados** para ambos temas

### 🎭 Animaciones y Efectos
- **Animaciones de scroll**: Elementos que aparecen al hacer scroll
- **Efectos hover**: Interacciones suaves en botones y tarjetas
- **Partículas flotantes**: Elementos decorativos en el hero
- **Parallax**: Efectos de profundidad en el fondo
- **Transiciones suaves**: Todas las interacciones son fluidas

### 📱 Responsive Design
- **Mobile-first**: Optimizado para dispositivos móviles
- **Breakpoints**: Adaptable a tablets y desktop
- **Menú hamburguesa**: Navegación móvil intuitiva
- **Imágenes optimizadas**: Carga rápida en todos los dispositivos

### ⚡ Funcionalidades Avanzadas
- **Scroll suave**: Navegación fluida entre secciones
- **Formularios interactivos**: Validación en tiempo real
- **Chat de WhatsApp**: Botón flotante con funcionalidad
- **Notificaciones**: Sistema de alertas moderno
- **Lazy loading**: Carga optimizada de imágenes

## 🛠️ Tecnologías Utilizadas

### Frontend
- **HTML5**: Estructura semántica moderna
- **CSS3**: Variables CSS, Flexbox, Grid, Animaciones
- **JavaScript ES6+**: Funcionalidades interactivas
- **Tailwind CSS**: Framework de utilidades
- **Font Awesome**: Iconografía moderna

### Librerías
- **Swiper.js**: Carruseles y sliders
- **Google reCAPTCHA**: Seguridad en formularios
- **Google Fonts**: Tipografías web optimizadas

### Funcionalidades Avanzadas
- **Sistema de traducciones**: Archivo `translations.js` con soporte completo ES/EN
- **Gestión de temas**: Modo claro/oscuro con CSS variables
- **LocalStorage**: Persistencia de preferencias del usuario
- **Intersection Observer**: Animaciones optimizadas de scroll

## 📁 Estructura del Proyecto

```
LandingPageTRN/
├── assets/
│   └── img/                 # Imágenes del sitio
├── css/
│   └── style.css           # Estilos personalizados
├── js/
│   └── script.js           # Funcionalidades JavaScript
├── php/
│   ├── contacto.php        # Procesamiento de formularios
│   ├── canal_denuncia.php  # Sistema de denuncias
│   └── submit_application.php
├── index.html              # Página principal
├── trabaja-con.html        # Página de trabajo
└── README.md              # Documentación
```

## 🎯 Secciones del Sitio

### 1. **Header Moderno**
- Logo con animación flotante
- Navegación con efectos hover
- Menú móvil responsive
- Efecto de transparencia al hacer scroll

### 2. **Hero Section**
- Imagen de fondo con parallax
- Partículas flotantes decorativas
- Títulos con gradientes
- Botones CTA atractivos
- Indicador de scroll animado

### 3. **Sobre Nosotros**
- Misión y visión en tarjetas modernas
- Estadísticas animadas
- Imagen con efectos decorativos
- Animaciones de entrada

### 4. **Servicios**
- Tarjetas con iconos modernos
- Efectos hover avanzados
- Listas de características
- CTA personalizado

### 5. **Infraestructura**
- Galería de vehículos
- Efectos de zoom en imágenes
- Descripciones detalladas

### 6. **Certificados**
- Sección con gradiente de fondo
- Imagen circular con efectos
- Patrón de puntos decorativo

### 7. **Clientes**
- Carrusel automático de logos
- Efecto grayscale a color
- Animación continua

### 8. **Cobertura**
- Mapa interactivo
- Puntos con tooltips
- Animación de camión
- Versión móvil optimizada

### 9. **Contacto**
- Formulario moderno
- Validación en tiempo real
- Mapa de Google integrado
- Notificaciones de éxito

### 10. **Canal de Denuncia**
- Formulario especializado
- Diseño diferenciado
- Confidencialidad garantizada

### 11. **Footer**
- Información completa de la empresa
- Enlaces rápidos
- Redes sociales
- Información de contacto

## 🚀 Funcionalidades JavaScript

### Navegación
- Scroll suave entre secciones
- Header que se oculta/muestra
- Menú móvil interactivo
- Animaciones de scroll

### Formularios
- Validación en tiempo real
- Estados de carga
- Notificaciones de éxito/error
- reCAPTCHA integrado

### Efectos Visuales
- Parallax en hero section
- Animaciones de entrada
- Efectos hover en tarjetas
- Partículas flotantes

### Chat de WhatsApp
- Botón flotante animado
- Ventana de chat emergente
- Enlace directo a WhatsApp

## 🎨 Variables CSS Personalizadas

```css
:root {
  --primary-blue: #1e40af;
  --secondary-blue: #3b82f6;
  --accent-gold: #fbbf24;
  --accent-gold-dark: #f59e0b;
  --text-dark: #1f2937;
  --text-light: #6b7280;
  --bg-light: #f8fafc;
  --bg-white: #ffffff;
  --gradient-primary: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
  --gradient-gold: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-gold-dark) 100%);
}
```

## 📱 Responsive Breakpoints

- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

## 🔧 Instalación y Uso

1. **Clonar el repositorio**
   ```bash
   git clone [url-del-repositorio]
   cd LandingPageTRN
   ```

2. **Abrir en navegador**
   ```bash
   # Usar un servidor local (recomendado)
   python -m http.server 8000
   # O abrir directamente index.html
   ```

3. **Configurar PHP** (opcional)
   - Configurar servidor web con PHP
   - Ajustar rutas en formularios
   - Configurar reCAPTCHA

## 🎯 Optimizaciones Realizadas

### Performance
- ✅ Lazy loading de imágenes
- ✅ CSS y JS optimizados
- ✅ Fuentes web optimizadas
- ✅ Animaciones con GPU

### SEO
- ✅ Meta tags completos
- ✅ Estructura semántica
- ✅ Alt text en imágenes
- ✅ URLs amigables

### Accesibilidad
- ✅ ARIA labels
- ✅ Navegación por teclado
- ✅ Contraste adecuado
- ✅ Textos alternativos

### UX/UI
- ✅ Diseño intuitivo
- ✅ Feedback visual
- ✅ Estados de carga
- ✅ Mensajes de error claros

## 🌟 Características Destacadas

### Efectos Visuales Únicos
- Partículas flotantes en hero
- Gradientes animados
- Efectos de glass morphism
- Sombras dinámicas

### Interactividad Avanzada
- Formularios con validación
- Chat de WhatsApp integrado
- Mapa de cobertura interactivo
- Carrusel de clientes automático

### Profesionalismo
- Diseño corporativo moderno
- Paleta de colores profesional
- Tipografía legible
- Espaciado consistente

## 📞 Soporte

Para soporte técnico o consultas sobre el proyecto:
- **Email**: contacto@trn.cl
- **Teléfono**: +56 9 9736 7760
- **LinkedIn**: [Transportes Río Negro S.A.](https://www.linkedin.com/company/transportes-rio-negro-s-a/)

## 📄 Licencia

Este proyecto es propiedad de Transportes Río Negro S.A. Todos los derechos reservados.

---

**Desarrollado con ❤️ para Transportes Río Negro**
