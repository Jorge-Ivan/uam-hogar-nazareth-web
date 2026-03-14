# Hogar Nazareth Web Platform
System Architecture

## 1. Overview

This document defines the architectural structure of the **Hogar Nazareth Web Platform**, a dynamic web platform built using **Laravel** to manage the public website of the Fundación Hogar del Anciano Nazareth.

The platform will allow non-technical staff to manage institutional content, activities, galleries, events, and transparency documents through a simple administrative interface.

The system is designed to be:

- modular
- maintainable
- scalable
- easy to use by non-technical staff

---

# 2. Architecture Style

The platform will follow a **modular MVC architecture** using Laravel.

Key principles:

- Separation of concerns
- Domain-oriented modules
- Clean controllers
- Reusable services
- Media management abstraction

Architecture layers:

Presentation Layer  
Application Layer  
Domain Layer  
Infrastructure Layer

---

# 3. High Level System Components

The system consists of two main areas.

## Public Website

Accessible to visitors.

Responsible for:

- displaying institutional information
- publishing activities
- showing galleries
- displaying events
- publishing transparency documents
- donation information
- contact information

## Administration Panel

Accessible only to authenticated users.

Allows staff to:

- manage pages
- publish activities
- upload images
- manage galleries
- manage events
- upload transparency documents
- manage site content

---

# 4. Core Modules

The system will be organized into logical modules.

## 4.1 Pages Module

Manages static institutional pages.

Examples:

- About the foundation
- Mission and vision
- Services
- Institutional information

Capabilities:

- create page
- edit page
- publish/unpublish
- manage page content

---

## 4.2 Activities Module

Used to publish updates about activities organized by the foundation.

Examples:

- recreational activities
- celebrations
- volunteer events
- community visits

Fields:

- title
- slug
- content
- featured image
- publication date
- status

---

## 4.3 Gallery Module

Manages collections of images documenting activities.

A gallery contains multiple images.

Examples:

- Activities 2024
- Physiotherapy sessions
- Special celebrations

Capabilities:

- create gallery
- upload multiple images
- reorder images
- add captions

---

## 4.4 Events Module

Manages events organized by the foundation.

Examples:

- volunteer events
- community celebrations
- institutional activities

Fields:

- title
- description
- start date
- end date
- location
- images

---

## 4.5 Transparency Documents Module

Manages institutional transparency documentation.

Examples:

- DIAN registry
- annual reports
- legal documentation

Capabilities:

- upload document
- categorize by year
- attach description
- download access

---

## 4.6 Donations Module

Displays information for donors.

Includes:

- bank account details
- donation instructions
- campaigns

This module may initially be informational only.

---

## 4.7 Media Module

Responsible for managing uploaded media.

Supports:

- images
- documents
- galleries

Features:

- file upload
- file organization
- file reuse
- image optimization

---

# 5. Core Domain Entities

The platform will revolve around the following entities.

Page  
Activity  
Gallery  
GalleryImage  
Event  
Document  
Media  
User

Relationships:

Gallery  
hasMany GalleryImage

Activity  
mayHave Media

Event  
mayHave Media

Document  
belongsTo YearCategory

User  
manages content

---

# 6. User Roles

Initially the system will support a simple role structure.

Admin

Full system access.

Editor

Can manage content but not system configuration.

Future roles may include:

Volunteer coordinator  
Content manager

---

# 7. Content Publishing Workflow

Content follows a simple lifecycle.

Draft  
Published  
Archived

Editors can:

- create draft content
- edit content
- publish content
- archive content

---

# 8. Media Strategy

Images and documents are core content types.

Media should support:

- image uploads
- document uploads
- gallery images
- featured images

Images should support:

- optimized storage
- responsive sizes
- alt text for accessibility

---

# 9. URL Structure

Example structure.

Home  
/

About  
/about

Activities  
/activities

Activity Detail  
/activities/{slug}

Galleries  
/galleries

Gallery Detail  
/galleries/{slug}

Events  
/events

Documents  
/transparency

Contact  
/contact

---

# 10. Administration Panel Principles

The admin interface must prioritize simplicity.

Key goals:

- minimal complexity
- clear forms
- simple content editing
- image uploads in one step

The system should avoid complex workflows.

---

# 11. Scalability Considerations

Although initially simple, the system should allow future growth.

Potential future features:

- volunteer management
- donation processing
- newsletters
- event registration
- API integrations

---

# 12. Deployment Considerations

The platform will run on a standard Laravel environment.

Typical stack:

PHP  
Laravel  
MySQL  
Nginx or Apache

Storage will handle:

- uploaded images
- transparency documents

---

# 13. Future Architecture Documents

Further documents will define:

database schema  
Laravel module structure  
API design  
admin UI structure  
deployment setup