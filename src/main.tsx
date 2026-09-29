import React from 'react';
import { createRoot } from 'react-dom/client';
import { Navbar } from '@/components/Navbar';
import { FrontpageHero } from '@/components/FrontpageHero';
import { DashboardView } from '@/components/DashboardView';
import { CourseCatalog } from '@/components/CourseCatalog';
import { AuthScreen } from '@/components/AuthScreen';
import './css/main.css';

const COMPONENT_MAP: Record<string, React.ComponentType<any>> = {
  Navbar,
  FrontpageHero,
  DashboardView,
  CourseCatalog,
  AuthScreen,
};

function mountReactComponents() {
  const mountElements = document.querySelectorAll<HTMLElement>('[data-react-mount]');

  mountElements.forEach((el) => {
    const componentName = el.getAttribute('data-react-mount');
    if (!componentName || !COMPONENT_MAP[componentName]) return;

    let props = {};
    const rawProps = el.getAttribute('data-props');
    if (rawProps) {
      try {
        props = JSON.parse(rawProps);
      } catch (e) {
        console.warn(`[WorldCampus React] Failed to parse props for ${componentName}`, e);
      }
    }

    const Component = COMPONENT_MAP[componentName];
    const root = createRoot(el);
    root.render(
      <React.StrictMode>
        <Component {...props} />
      </React.StrictMode>
    );
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', mountReactComponents);
} else {
  mountReactComponents();
}
