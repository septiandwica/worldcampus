# 🌍 AGENTS.md — World Campus Moodle Theme (`theme_worldcampus`)

> **Theme Architecture & Developer Guidelines**  
> Pure Bootstrap 5.3 • Moodle `theme_boost` Child Architecture • Coursera-Style Course Marketplace

---

## 📌 1. Project Overview

`theme_worldcampus` adalah tema modern untuk Moodle LMS yang dibangun sebagai **Child Theme dari `theme_boost`** dengan standar **Bootstrap 5.3**. Tema ini menggabungkan stabilitas dan kompatibilitas 100% dengan ekosistem Moodle (Drawer, Course Index, Filemanager, Forms, Gradebook) dengan pengalaman antarmuka bergaya **Course Marketplace (ala Coursera)** pada Frontpage.

### ✨ Prinsip Arsitektur:
1. **Pure Bootstrap 5.3 & Moodle Native:** Tidak menggunakan runtime/build layer eksternal (bebas dari React/Vite runtime overhead), seluruh rendering ditangani secara native melalui PHP, Mustache, dan SCSS bawaan Moodle.
2. **100% Boost Compatibility:** Meng-extend `$THEME->parents = ['boost']` sehingga seluruh plugin pihak ketiga, modul aktivitas (Quiz, Assignment, H5P), dan drawer navigasi berfungsi tanpa regresi.
3. **Coursera-Style Frontpage:** Menyediakan landing page marketplace modern dengan fitur pencarian kursus, filter kategori, kartu spesialisasi, review rating bintang, dan banner enterprise.

---

## 📁 2. Struktur File & Direktori

```
worldcampus/
├── classes/                          # PHP Classes, Output Renderers & Utilities
│   ├── api/                          # External & AJAX API Endpoints
│   │   └── accessibility.php         # Font sizing & color contrast preferences
│   ├── output/                       # Moodle Output Renderers
│   │   ├── core/
│   │   │   ├── admin_renderer.php    # Admin tree & management renderers
│   │   │   └── course_renderer.php   # Course list, category & pagination renderers
│   │   ├── core_course/
│   │   │   └── activity_navigation.php # Next/Previous activity module navigation
│   │   ├── boostnavbar.php           # Breadcrumb navbar customizer
│   │   ├── core_renderer.php         # Main theme renderer extending Boost
│   │   ├── core_renderer_maintenance.php # Maintenance renderer
│   │   └── renderer.php              # Generic renderer factory
│   ├── privacy/
│   │   └── provider.php              # GDPR & User preferences privacy provider
│   └── util/                         # Helper & Service Utilities
│       ├── course.php                # Course contacts, summary image & custom fields
│       ├── course_pagination.php     # Pagination & filtering helper
│       ├── extras.php                # Profile header buttons & extra helpers
│       ├── settings.php              # Clean theme settings accessor
│       └── user.php                  # User avatar & metadata helpers
│
├── db/                               # Moodle Database & Services
│   ├── install.php                   # Post-installation default config
│   ├── services.php                  # External AJAX accessibility service definitions
│   └── upgrade.php                   # Version upgrade steps
│
├── lang/en/                          # Localization Strings
│   └── theme_worldcampus.php         # All theme UI strings & settings labels
│
├── layout/                           # Moodle Page Layouts
│   ├── course.php                    # In-depth course view layout
│   ├── custom.php                    # Custom informative pages (About, FAQ, etc.)
│   ├── drawers.php                   # Standard Boost layout with side drawers
│   ├── embedded.php                  # Embedded/iFrame/Pop-up layout
│   ├── frontpage.php                 # Coursera-style Marketplace landing page layout
│   ├── incourse.php                  # Activity/Module view layout
│   ├── login.php                     # Clean modern login screen layout
│   ├── maintenance.php               # System maintenance layout
│   ├── mypublic.php                  # Public user profile layout
│   └── secure.php                    # Secure window / Safe exam browser layout
│
├── pix/                              # Images & Icons
│   ├── favicon.ico
│   ├── logo.png                      # Light theme brand logo
│   ├── logo-dark.png                 # Dark theme brand logo
│   ├── footer-logo.png               # Footer brand logo
│   └── loginbg.png                   # Auth background visual
│
├── scss/                             # Modular Bootstrap 5.3 SCSS
│   ├── preset/
│   │   └── default.scss              # SCSS Preset file
│   ├── worldcampus/                  # Modular SCSS Components
│   │   ├── _variables.scss           # Brand colors (Navy, Cyan, Slate), font tokens, radiuses
│   │   ├── _navbar.scss              # Header navbar, search bar & user dropdown
│   │   ├── _footer.scss              # 4-Column footer & copyright bar
│   │   ├── _drawers.scss             # Course index & block drawers styling
│   │   ├── _frontpage.scss           # Coursera marketplace hero, pills, cards, enterprise
│   │   ├── _course.scss              # Course modules, activity cards & completion status
│   │   ├── _coursecards.scss         # Marketplace course cards & hover elevation
│   │   ├── _dashboard.scss           # Student dashboard & quick resume widgets
│   │   ├── _darkmode.scss            # CSS variables & dark palette overrides
│   │   ├── _accessibility.scss       # Accessibility toolbar & high-contrast modes
│   │   └── _login.scss               # Centered login panel & SSO button styling
│   └── default.scss                  # Main SCSS entry point compiling Boost + WorldCampus
│
├── templates/                        # Mustache HTML Templates
│   ├── block_myoverview/             # Dashboard Course Overview Block
│   │   ├── course-action-menu.mustache
│   │   ├── progress-bar.mustache
│   │   └── view-cards.mustache
│   ├── core/                         # Moodle Core Templates
│   │   ├── full_header.mustache      # Breadcrumbs & page title header
│   │   ├── loginform.mustache        # Modern login card with SSO button
│   │   └── user_menu.mustache        # User avatar & account dropdown menu
│   ├── core_course/                  # Core Course Templates
│   │   ├── activity_navigation.mustache # Next/Previous activity buttons
│   │   ├── coursecard.mustache       # Grid course cards
│   │   └── favouriteicon.mustache    # Course bookmarking star
│   ├── core_message/                 # Messaging
│   │   └── message_popover.mustache  # Message dropdown popover
│   ├── message_popup/                # Notifications
│   │   └── notification_popover.mustache # Notification dropdown popover
│   ├── accessibilitybar.mustache     # Accessibility toolbar (A+, A-, Contrast)
│   ├── accessibilitysettings_modal.mustache # Accessibility modal
│   ├── drawers.mustache              # Main drawer layout template (Extends theme_boost)
│   ├── footer.mustache               # Global footer with university links & support
│   ├── frontpage.mustache            # Coursera-style course marketplace landing page
│   ├── head.mustache                 # HTML `<head>` with dark mode detection & Google Fonts
│   ├── language_menu.mustache        # Language selector dropdown
│   ├── loading-overlay.mustache      # Smooth redirect loading indicator
│   ├── login.mustache                # Standalone login page template
│   ├── navbar.mustache               # Top navigation bar
│   ├── primary-drawer-mobile.mustache # Offcanvas mobile menu drawer
│   └── worldcampus_coursecard.mustache # Coursera-style marketplace card component
│
├── config.php                        # Moodle Theme Configuration (Boost parent, layouts)
├── lib.php                           # SCSS Callbacks, Asset Injections, Nav Extenders
├── settings.php                      # Site Administration Theme Settings Tabs
└── version.php                       # Moodle Plugin Version & Boost Dependency Info
```

---

## 🎨 3. Design Tokens & Palet Warna

| Token Name | Hex Code | Penggunaan |
|---|---|---|
| `--worldcampus-navy-900` | `#05234a` | Background hero card, header aksen utama |
| `--worldcampus-navy-800` | `#07366c` | Gradient primer, status badge |
| `--worldcampus-navy-700` | `#0b477f` | Hover state komponen navbar |
| `--worldcampus-blue` | `#0056d2` | Coursera Blue — Link, tombol utama, CTA |
| `--worldcampus-red` | `#ed171c` | President Red — Tag penanda, badge spesial |
| `--worldcampus-bg-light` | `#f8fafc` | Background halaman utama / marketplace |
| `--worldcampus-card-border` | `#e2e8f0` | Border halus kartu kursus & widget |

### Font Typography
- **Primary Body Font**: `DM Sans`, `Inter`, sans-serif
- **Headings & Display**: `Plus Jakarta Sans`, sans-serif

---

## ⚙️ 4. Panduan Pengembangan (Development Guidelines)

1. **Mustache Template Conventions:**
   - Selalu sertakan standard hook Moodle pada template layout:
     - `{{{ output.standard_top_of_body_html }}}` (awal tag `<body>`)
     - `{{{ output.standard_after_main_region_html }}}`
     - `{{{ output.standard_end_of_body_html }}}` (sebelum penutup `</body>`)
   - Pertahankan attribute data Moodle JS: `data-region="mainpage"`, `data-toggler="drawers"`, `data-action="toggle"`, `data-course-id`.

2. **SCSS Compilation Workflow:**
   - Semua modifikasi styling diletakkan dalam file terpisah di `scss/worldcampus/` (misal: `_frontpage.scss`, `_navbar.scss`).
   - Entry point berada di `scss/default.scss` yang di-load otomatis oleh Moodle melalui `theme_worldcampus_get_main_scss_content($theme)`.

3. **Frontpage Data Flow:**
   - `layout/frontpage.php` bertugas mengambil data courses aktif, kategori, dan user enrolled courses dari database Moodle (`$DB`), kemudian mem-pass data ke `templates/frontpage.mustache`.

---

## 🛠️ 5. Cheat Sheet Perintah & Debugging

| Perintah | Deskripsi |
|---|---|
| `php admin/cli/purge_caches.php` | Menghapus seluruh cache Moodle melalui terminal |
| `$CFG->themedesignermode = true;` | Aktifkan di `config.php` Moodle agar SCSS & Mustache di-recompile setiap refresh halaman tanpa perlu purge cache manual |
| `git status` / `git push origin main` | Sinkronisasi perubahan tema ke remote repo |

---

## 🗺️ 6. Roadmap Pengembangan

- [x] **Fase 1:** Reset dan pembersihan tema ke arsitektur Pure Boost.
- [x] **Fase 2:** Pembuatan arsitektur SCSS modular Bootstrap 5.3 & Design Tokens.
- [x] **Fase 3:** Implementasi Frontpage Course Marketplace ala Coursera (`layout/frontpage.php` & `templates/frontpage.mustache`).
- [ ] **Fase 4:** Pengayaan komponen Course Card (`templates/worldcampus_coursecard.mustache`) dan halaman detail kursus.
- [ ] **Fase 5:** Polish Accessibility toolbar, Dark Mode switch, dan User Profile Menu.
