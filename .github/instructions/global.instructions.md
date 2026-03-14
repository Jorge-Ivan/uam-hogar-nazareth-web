---
description: Global instructions for the Hogar Nazareth Laravel project
applyTo: "**"
---

This repository contains the development of the **Hogar Nazareth Web Platform**, a Laravel-based system for managing the public website of a non-profit foundation.

Before generating code, Copilot should consider the project documentation located in:

/docs/project-context.md
/docs/laravel-architecture-guide.md
/docs/architecture.md
/docs/domain-model.md
/docs/plan.md
/docs/design-guide.md

These documents describe the system domain, architecture, data model, implementation plan, and UI/design decisions.

All generated code should follow the architecture and domain definitions described in those files. Consult /docs/plan.md to understand the current implementation phase and what has already been completed.

When generating any Blade view, admin layout, or frontend component, load /docs/design-guide.md first. It defines the color palette (nazareth-blue, nazareth-gold), typography rules, UI patterns (navbar, hero, cards, tables, forms), admin sidebar layout, and accessibility requirements. All UI must follow those patterns before writing any HTML or Tailwind classes.