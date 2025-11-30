# ACF Flexible Components System z Vite.js

System dynamicznego ładowania CSS/JS dla komponentów ACF Flexible Fields z optymalizacją wydajności.

## 🚀 Jak to działa

1. **Automatyczne wykrywanie komponentów**: Vite automatycznie wykrywa pliki JS/SCSS w `src/js/components/acf/` i `src/scss/components/acf/`
2. **Budowanie osobnych bundli**: Każdy komponent otrzymuje swój własny plik CSS/JS w `dist/assets/acf/`
3. **Dynamiczne ładowanie**: PHP ładuje assety tylko dla komponentów używanych na stronie
4. **Zero konfiguracji**: Dodaj plik - działa automatycznie

## 📁 Struktura katalogów

```
src/
├── js/components/acf/
│   ├── image_left_content_right.js
│   ├── text_and_image.js
│   └── hero_banner.js
│
├── scss/components/acf/
│   ├── image_left_content_right.scss
│   ├── text_and_image.scss
│   └── hero_banner.scss
│
└── ...

dist/assets/acf/ (generowane przez Vite)
├── acf-image_left_content_right.js
├── acf-image_left_content_right.css
├── acf-text_and_image.js
├── acf-text_and_image.css
└── ...
```

## 🛠️ Tworzenie nowego komponentu

### Krok 1: Utwórz layout w ACF
W WordPress Admin → Custom Fields → Add New → Flexible Content

### Krok 2: Utwórz pliki komponentu

**PHP Template** (`components/acf/my_component.php`):
```php
<?php
$title = get_sub_field('title');
$content = get_sub_field('content');
?>

<section class="acf-component acf-my-component" data-component="my_component">
    <?php if($title): ?>
        <h2><?php echo esc_html($title); ?></h2>
    <?php endif; ?>
    
    <?php if($content): ?>
        <div class="content">
            <?php echo wp_kses_post($content); ?>
        </div>
    <?php endif; ?>
</section>
```

**JavaScript** (`src/js/components/acf/my_component.js`):
```javascript
import '../../scss/components/acf/my_component.scss';

class MyComponent {
  constructor() {
    this.components = document.querySelectorAll('.acf-my-component');
    this.init();
  }

  init() {
    if (this.components.length === 0) return;
    
    // Twoja logika JavaScript
    this.setupAnimations();
    this.addInteractions();
  }

  setupAnimations() {
    // Animacje scroll, hover, etc.
  }

  addInteractions() {
    // Event listenery, interakcje użytkownika
  }
}

document.addEventListener('DOMContentLoaded', () => {
  new MyComponent();
});

export default MyComponent;
```

**Styles** (`src/scss/components/acf/my_component.scss`):
```scss
.acf-my-component {
  // Twoje style komponenty
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.6s ease;

  &.animate-in {
    opacity: 1;
    transform: translateY(0);
  }

  h2 {
    // Style dla nagłówka
  }

  .content {
    // Style dla treści
  }

  // Responsive
  @media (max-width: 768px) {
    // Mobile styles
  }

  // Accessibility
  @media (prefers-reduced-motion: reduce) {
    * {
      animation: none !important;
      transition: none !important;
    }
  }
}
```

### Krok 3: Build i testuj
```bash
npm run build
# lub w trybie watch
npm run build:watch
```

## 🏗️ Build Process

### Konfiguracja Vite (`vite.config.js`)

```javascript
// Automatycznie wykrywa komponenty ACF
function getAcfComponents() {
  // Skanuje katalogi i tworzy entry points
  // Format: acf-{component_name}
}

// Output files:
// JS: dist/assets/acf/acf-{component}.js
// CSS: dist/assets/acf/acf-{component}.css
```

### PHP Integration (`functions.php`)

```php
function fajnestarocie_enqueue_acf_assets($layouts) {
  foreach($layouts as $layout) {
    // Sprawdza czy pliki CSS/JS istnieją
    // Enqueue'uje tylko istniejące assety
    wp_enqueue_style("acf-{$layout}-styles", ...);
    wp_enqueue_script("acf-{$layout}-scripts", ...);
  }
}
```

## 📊 Zalety systemu

### ⚡ Performance
- **Lazy loading**: Ładowane tylko używane komponenty
- **Code splitting**: Każdy komponent = osobny bundle
- **Tree shaking**: Nieużywany kod nie trafia do bundli

### 🔧 Developer Experience  
- **Zero config**: Dodaj plik → działa automatycznie
- **Hot reload**: Zmiany widoczne od razu w dev mode
- **TypeScript ready**: Można dodać .ts zamiast .js

### 🎨 CSS Architecture
- **Component isolation**: Style nie conflictują między komponentami
- **Tailwind integration**: Pełne wsparcie dla Tailwind CSS
- **SCSS support**: Zmienne, mixiny, nesting

### ♿ Accessibility
- **Keyboard navigation**: Automatyczne focus management
- **Screen readers**: Proper ARIA labels
- **Reduced motion**: Respect user preferences

## 🧪 Testowanie

### Development
```bash
npm run dev
# Vite dev server z hot reload
```

### Production Build
```bash
npm run build
# Tworzy zoptymalizowane bundles
```

### Watch Mode
```bash
npm run build:watch
# Przebudowuje przy zmianach
```

## 📋 Checklist dla nowego komponentu

- [ ] Utworzony layout ACF
- [ ] Plik PHP template w `components/acf/`
- [ ] Plik JS w `src/js/components/acf/`
- [ ] Plik SCSS w `src/scss/components/acf/`
- [ ] Import SCSS w pliku JS
- [ ] Klasa CSS `.acf-{layout-name}`
- [ ] Dostępność (alt, aria-labels, keyboard navigation)
- [ ] Responsive design
- [ ] Animacje z `prefers-reduced-motion`
- [ ] Test w przeglądarce
- [ ] Build production

## 🐛 Debugging

### Sprawdź czy assety się ładują:
```php
// W template PHP dodaj:
if (defined('WP_DEBUG') && WP_DEBUG) {
  echo "<!-- ACF Components used: " . implode(', ', $used_layouts) . " -->";
}
```

### Developer Tools:
- Network tab → sprawdź czy CSS/JS się ładują
- Console → błędy JavaScript
- Elements → czy klasy CSS są aplikowane

### Vite Logs:
```bash
npm run build:watch
# Pokaże błędy kompilacji w czasie rzeczywistym
```

## 🔗 Integracja z innymi narzędziami

### GSAP Animations
```javascript
import { gsap } from 'gsap';

// W komponencie:
setupAnimations() {
  gsap.from('.acf-my-component', {
    y: 50,
    opacity: 0,
    duration: 1,
    scrollTrigger: '.acf-my-component'
  });
}
```

### Intersection Observer
```javascript
setupScrollAnimations() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-in');
      }
    });
  });
  
  this.components.forEach(el => observer.observe(el));
}
```

## 🚀 Next Steps

1. **Dodaj TypeScript** support
2. **CSS Custom Properties** dla theme variables
3. **Storybook** dla documentation
4. **Unit tests** dla komponentów
5. **Performance monitoring** w production

