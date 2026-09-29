# World Campus Moodle Theme (`theme_worldcampus`)

**World Campus** is an ultra-modern, standalone Moodle theme built from scratch with **Tailwind CSS v4** (without `theme_boost` dependencies). It combines the high-productivity layouts of President University PJJ with the global, futuristic visual aesthetics of `pjj_world`.

---

## 🚀 Key Features

* **100% Standalone (`$THEME->parents = []`):** Free from Bootstrap bloatware, ultra-lightweight CSS bundle (~40KB).
* **Tailwind CSS Engine:** Full control over design tokens, dark mode palette (`#0B0F19`), cyan/indigo glowing accents, and glassmorphism.
* **Fully Customized Page Layouts:**
  * 🔐 **Authentication Page (`login.php`):** Split-screen design with global campus telemetry card and University SSO button.
  * 🌍 **Frontpage (`frontpage.php`):** Futuristic hero banner, live statistics counter, featured course showcase, and global network badges.
  * 📊 **Student Dashboard (`dashboard.php`):** Semester metrics, AI Tutor (Demi AI) card, course progress rings, and active courses grid.
  * 📚 **My Courses (`mycourses.php`):** Course progress indicators, status badges, and direct room entry.
  * 🎓 **Course & Topic View (`course.php`):** Dynamic course banner, syllabus timeline, completion progress bar, and floating edit-mode switch.
  * ⚙️ **Settings & Forms (`moodle-core.css`):** Sleek dark form inputs, modern buttons, clean tables, and custom alerts.

---

## 🛠️ Development & Build Workflow

### Prerequisites
* Node.js v18+ & npm

### Commands
```bash
# Navigate to the theme directory
cd worldcampus

# Install dependencies
npm install

# Watch mode during development (auto-recompiles on file edit)
npm run dev

# Production build
npm run build
```

---

## 📁 Directory Structure

```text
worldcampus/
├── config.php                 # Theme configuration ($THEME->parents = []; $THEME->sheets = ['worldcampus'])
├── version.php                # Plugin release & version metadata
├── lib.php                    # Navigation & progress calculation helpers
├── settings.php               # Admin configuration for logo & hero content
├── package.json               # Tailwind CSS build scripts
├── style/
│   └── worldcampus.css        # Compiled production CSS
├── src/
│   ├── css/
│   │   ├── main.css           # Tailwind v4 directives & design tokens
│   │   └── moodle-core.css    # Core Moodle compatibility styling
│   └── js/
├── layout/
│   ├── drawers.php            # Base layout for standard and admin pages
│   ├── login.php              # Full custom Auth layout
│   ├── frontpage.php          # Full custom Landing layout
│   ├── dashboard.php          # Full custom Dashboard layout
│   ├── course.php             # Full custom Course & Topic view layout
│   ├── mycourses.php          # Full custom My Courses layout
│   ├── embedded.php           # Popups and embedded frames
│   ├── maintenance.php        # Maintenance screen
│   └── secure.php             # Secure exam browser
├── templates/
│   ├── head.mustache
│   ├── navbar.mustache
│   ├── footer.mustache
│   ├── drawers.mustache
│   ├── mycourses.mustache
│   ├── auth/login.mustache
│   ├── core/user_menu.mustache
│   ├── core_course/course.mustache
│   ├── dashboard/dashboard.mustache
│   └── frontpage/frontpage.mustache
└── lang/en/theme_worldcampus.php
```
