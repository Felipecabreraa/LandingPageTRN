// ========================================
// TRANSPORTES RÍO NEGRO - JAVASCRIPT MODERNO
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    // Inicializar todas las funcionalidades
    initLanguageSystem();
    initThemeSystem();
    initHeaderScroll();
    initSmoothScrolling();
    initScrollAnimations();
    initMobileMenu();
    initContactForms();
    initWhatsAppChat();
    initParallaxEffects();
    initServiceCards();
    initInfrastructureCards();
    initClientLogos();
    initCoverageMap();
    initCertificateSection();
}

// ========================================
// HEADER Y NAVEGACIÓN
// ========================================

function initHeaderScroll() {
    const header = document.querySelector('header');
    let lastScrollTop = 0;

    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Efecto de transparencia y blur en el header
        if (scrollTop > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        // Ocultar/mostrar header al hacer scroll
        if (scrollTop > lastScrollTop && scrollTop > 200) {
            header.style.transform = 'translateY(-100%)';
        } else {
            header.style.transform = 'translateY(0)';
        }

        lastScrollTop = scrollTop;
    });
}

// ========================================
// SCROLL SUAVE
// ========================================

function initSmoothScrolling() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const offsetTop = targetSection.offsetTop - 100;
                
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ========================================
// ANIMACIONES DE SCROLL
// ========================================

function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    // Observar elementos con clases de animación
    const animatedElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    animatedElements.forEach(el => observer.observe(el));
}

// ========================================
// MENÚ MÓVIL
// ========================================

function initMobileMenu() {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const navLinks = mobileMenu.querySelectorAll('a');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            
            // Animación del icono hamburguesa
            const icon = menuToggle.querySelector('svg');
            icon.classList.toggle('rotate-90');
        });

        // Cerrar menú al hacer clic en un enlace
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });

        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (!menuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.remove('active');
            }
        });
    }
}

// ========================================
// FORMULARIOS DE CONTACTO
// ========================================

function initContactForms() {
    // Formulario principal de contacto
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactSubmit);
    }

    // Formulario de denuncia (solo modo AJAX si se marca explícitamente)
    const denunciaForm = document.getElementById('form-denuncia');
    if (denunciaForm && denunciaForm.dataset.ajax === 'true') {
        denunciaForm.addEventListener('submit', handleDenunciaSubmit);
    }

    // Validación en tiempo real
    initFormValidation();
}

function handleContactSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Mostrar estado de carga
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    
    // Simular envío (reemplazar con tu lógica real)
    setTimeout(() => {
        showNotification('Mensaje enviado correctamente', 'success');
        form.reset();
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Enviar';
    }, 2000);
}

function handleDenunciaSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="button"]');
    
    // Mostrar estado de carga
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    
    // Simular envío (reemplazar con tu lógica real)
    setTimeout(() => {
        showNotification('Denuncia enviada correctamente', 'success');
        form.reset();
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Enviar Denuncia';
    }, 2000);
}

function initFormValidation() {
    const inputs = document.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearFieldError);
    });
}

function validateField(e) {
    const field = e.target;
    const value = field.value.trim();
    
    // Remover clases de error previas
    field.classList.remove('error');
    
    // Validaciones específicas
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'Este campo es requerido');
    } else if (field.type === 'email' && value && !isValidEmail(value)) {
        showFieldError(field, 'Email inválido');
    }
}

function showFieldError(field, message) {
    field.classList.add('error');
    
    // Crear o actualizar mensaje de error
    let errorElement = field.parentNode.querySelector('.error-message');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'error-message text-red-500 text-sm mt-1';
        field.parentNode.appendChild(errorElement);
    }
    errorElement.textContent = message;
}

function clearFieldError(e) {
    const field = e.target;
    field.classList.remove('error');
    
    const errorElement = field.parentNode.querySelector('.error-message');
    if (errorElement) {
        errorElement.remove();
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// ========================================
// CHAT DE WHATSAPP
// ========================================

function initWhatsAppChat() {
    const chatToggle = document.getElementById('chat-toggle');
    const chatBox = document.getElementById('whatsapp-chat');
    const closeChat = document.getElementById('close-chat');

    if (chatToggle && chatBox && closeChat) {
        chatToggle.addEventListener('click', toggleChat);
        closeChat.addEventListener('click', closeChatBox);
        
        // Cerrar chat al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (!chatToggle.contains(e.target) && !chatBox.contains(e.target)) {
                closeChatBox();
            }
        });
    }
}

function toggleChat() {
    const chatBox = document.getElementById('whatsapp-chat');
    const isOpen = chatBox.style.opacity === '1';
    
    if (isOpen) {
        closeChatBox();
    } else {
        openChatBox();
    }
}

function openChatBox() {
    const chatBox = document.getElementById('whatsapp-chat');
    chatBox.style.opacity = '1';
    chatBox.style.pointerEvents = 'auto';
    chatBox.style.transform = 'translateY(0)';
}

function closeChatBox() {
    const chatBox = document.getElementById('whatsapp-chat');
    chatBox.style.opacity = '0';
    chatBox.style.pointerEvents = 'none';
    chatBox.style.transform = 'translateY(20px)';
}

// ========================================
// EFECTOS PARALLAX
// ========================================

function initParallaxEffects() {
    const parallaxElements = document.querySelectorAll('.hero-bg');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        
        parallaxElements.forEach(element => {
            const speed = 0.5;
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
}

// ========================================
// TARJETAS DE SERVICIOS
// ========================================

function initServiceCards() {
    const serviceCards = document.querySelectorAll('.service-card');
    
    serviceCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
        });
    });
}

// ========================================
// TARJETAS DE INFRAESTRUCTURA
// ========================================

function initInfrastructureCards() {
    const infrastructureCards = document.querySelectorAll('.infrastructure-card');
    
    infrastructureCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            const image = card.querySelector('.infrastructure-image');
            if (image) {
                image.style.transform = 'scale(1.05)';
            }
        });
        
        card.addEventListener('mouseleave', () => {
            const image = card.querySelector('.infrastructure-image');
            if (image) {
                image.style.transform = 'scale(1)';
            }
        });
    });
}

// ========================================
// LOGOS DE CLIENTES
// ========================================

function initClientLogos() {
    const clientLogos = document.querySelectorAll('.client-logo');
    
    clientLogos.forEach(logo => {
        logo.addEventListener('mouseenter', () => {
            logo.style.filter = 'grayscale(0%)';
            logo.style.transform = 'scale(1.05)';
        });
        
        logo.addEventListener('mouseleave', () => {
            logo.style.filter = 'grayscale(100%)';
            logo.style.transform = 'scale(1)';
        });
    });
}

// ========================================
// MAPA DE COBERTURA
// ========================================

function initCoverageMap() {
    const coveragePoints = document.querySelectorAll('.coverage-point');
    
    coveragePoints.forEach(point => {
        point.addEventListener('mouseenter', () => {
            const tooltip = point.querySelector('.coverage-tooltip');
            if (tooltip) {
                tooltip.style.opacity = '1';
                tooltip.style.transform = 'translateY(-10px)';
            }
        });
        
        point.addEventListener('mouseleave', () => {
            const tooltip = point.querySelector('.coverage-tooltip');
            if (tooltip) {
                tooltip.style.opacity = '0';
                tooltip.style.transform = 'translateY(0)';
            }
        });
    });
}

// ========================================
// SECCIÓN DE CERTIFICADOS
// ========================================

function initCertificateSection() {
    const certificateImage = document.querySelector('.certificate-image');
    
    if (certificateImage) {
        certificateImage.addEventListener('mouseenter', () => {
            certificateImage.style.transform = 'scale(1.05) rotate(5deg)';
        });
        
        certificateImage.addEventListener('mouseleave', () => {
            certificateImage.style.transform = 'scale(1) rotate(0deg)';
        });
    }
}

// ========================================
// NOTIFICACIONES
// ========================================

function showNotification(message, type = 'info') {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${getNotificationIcon(type)}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Agregar estilos
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${getNotificationColor(type)};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 300px;
    `;
    
    // Agregar al DOM
    document.body.appendChild(notification);
    
    // Animar entrada
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remover después de 5 segundos
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 5000);
}

function getNotificationIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'exclamation-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

function getNotificationColor(type) {
    const colors = {
        success: '#10b981',
        error: '#ef4444',
        warning: '#f59e0b',
        info: '#3b82f6'
    };
    return colors[type] || '#3b82f6';
}

// ========================================
// UTILIDADES
// ========================================

// Función para debounce
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Función para throttle
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Optimizar eventos de scroll
const optimizedScrollHandler = throttle(() => {
    // Aquí van las funciones que se ejecutan en scroll
}, 16); // ~60fps

window.addEventListener('scroll', optimizedScrollHandler);

// ========================================
// INICIALIZACIÓN ADICIONAL
// ========================================

// Lazy loading para imágenes
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Inicializar lazy loading
initLazyLoading();

// Preloader
function initPreloader() {
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        window.addEventListener('load', () => {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 300);
        });
    }
}

// Inicializar preloader
initPreloader();

// ========================================
// SISTEMA DE IDIOMAS
// ========================================

let currentLanguage = 'es';

function initLanguageSystem() {
    // Cargar idioma guardado
    const savedLanguage = localStorage.getItem('language') || 'es';
    setLanguage(savedLanguage);
    
    // Event listeners para selectores de idioma
    const languageOptions = document.querySelectorAll('.language-option, .language-option-mobile');
    languageOptions.forEach(option => {
        option.addEventListener('click', (e) => {
            const lang = e.target.closest('button').dataset.lang;
            setLanguage(lang);
        });
    });
    
    // Toggle dropdown desktop
    const languageToggle = document.getElementById('language-toggle');
    const languageDropdown = document.getElementById('language-dropdown');
    
    if (languageToggle && languageDropdown) {
        languageToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            languageDropdown.classList.toggle('hidden');
        });
        
        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', () => {
            languageDropdown.classList.add('hidden');
        });
    }
}

function setLanguage(lang) {
    currentLanguage = lang;
    localStorage.setItem('language', lang);
    
    // Actualizar UI
    updateLanguageUI(lang);
    
    // Traducir contenido
    translateContent(lang);
}

function updateLanguageUI(lang) {
    // Actualizar indicador de idioma actual
    const currentLangElement = document.getElementById('current-lang');
    if (currentLangElement) {
        const translation = getTranslation('language.current', lang);
        if (translation) {
            currentLangElement.textContent = translation;
        } else {
            currentLangElement.textContent = lang.toUpperCase();
        }
    }
    
    // Actualizar botones móviles
    const mobileOptions = document.querySelectorAll('.language-option-mobile');
    mobileOptions.forEach(option => {
        option.classList.remove('active');
        if (option.dataset.lang === lang) {
            option.classList.add('active');
        }
    });
    
    // Actualizar dropdown desktop
    const dropdownOptions = document.querySelectorAll('.language-option');
    dropdownOptions.forEach(option => {
        option.classList.remove('active');
        if (option.dataset.lang === lang) {
            option.classList.add('active');
        }
    });
}

function translateContent(lang) {
    const elements = document.querySelectorAll('[data-i18n]');
    
    elements.forEach(element => {
        const key = element.getAttribute('data-i18n');
        const translation = getTranslation(key, lang);
        
        if (translation) {
            // Si la traducción contiene HTML (como <strong>), usar innerHTML
            if (translation.includes('<') && translation.includes('>')) {
                element.innerHTML = translation;
            } else {
                // Si no contiene HTML, usar textContent para mayor seguridad
                element.textContent = translation;
            }
        }
    });
    
    // Traducir placeholders de formularios
    translatePlaceholders(lang);
    
    // Actualizar el título de la página
    updatePageTitle(lang);
}

function translatePlaceholders(lang) {
    const elements = document.querySelectorAll('[data-i18n-placeholder]');
    
    elements.forEach(element => {
        const key = element.getAttribute('data-i18n-placeholder');
        const translation = getTranslation(key, lang);
        
        if (translation) {
            element.placeholder = translation;
        }
    });
}

function updatePageTitle(lang) {
    const title = lang === 'en' ? 
        'Transportes Río Negro - Leaders in Responsible Transportation' : 
        'Transportes Río Negro - Líder en Transporte Responsable';
    document.title = title;
}

function getTranslation(key, lang) {
    // Primero intentar con la clave directa (para características de servicios)
    if (window.translations[lang] && window.translations[lang][key]) {
        return window.translations[lang][key];
    }
    
    // Luego intentar con la estructura anidada
    const keys = key.split('.');
    let translation = window.translations[lang];
    
    for (const k of keys) {
        if (translation && translation[k]) {
            translation = translation[k];
        } else {
            return null;
        }
    }
    
    return translation;
}

// ========================================
// SISTEMA DE TEMAS
// ========================================

function initThemeSystem() {
    // Cargar tema guardado
    const savedTheme = localStorage.getItem('theme') || 'light';
    setTheme(savedTheme);
    
    // Event listeners para botones de tema
    const themeToggles = document.querySelectorAll('#theme-toggle, #theme-toggle-mobile');
    themeToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        });
    });
}

function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    
    // Actualizar iconos
    updateThemeIcons(theme);
}

function updateThemeIcons(theme) {
    const icons = document.querySelectorAll('#theme-icon, #theme-icon-mobile');
    
    icons.forEach(icon => {
        if (theme === 'dark') {
            icon.className = 'fas fa-sun text-lg';
        } else {
            icon.className = 'fas fa-moon text-lg';
        }
    });
}


