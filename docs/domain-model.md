# Hogar Nazareth Web Platform
Domain Model

## 1. Overview

This document defines the **core domain entities and relationships** for the Hogar Nazareth web platform.

The platform is a **content-driven system** used to manage the public website of a non-profit foundation. The system allows staff to publish institutional content, activities, events, galleries, and transparency documents.

The domain model is designed to support:

- simple content publishing
- media management
- photo galleries
- transparency documentation
- institutional information

The system follows typical Laravel conventions for models and relationships.

---

# 2. Core Entities

The platform revolves around the following main entities.

Page  
Activity  
Gallery  
GalleryImage  
Event  
Document  
Media  
User

Some supporting entities may also exist.

DocumentCategory  
DocumentYear

---

# 3. Entity Definitions

---

# Page

Represents static institutional pages.

Examples:

- About the foundation
- Mission and vision
- Services
- Institutional information

Fields:

id  
title  
slug  
content  
status  
published_at  
created_at  
updated_at

Status values:

draft  
published  
archived

Relationships:

Page  
none required initially

---

# Activity

Represents posts describing activities organized by the foundation.

Examples:

- recreational activities
- celebrations
- volunteer visits
- community events

Fields:

id  
title  
slug  
excerpt  
content  
featured_image_id  
status  
published_at  
created_at  
updated_at

Relationships:

Activity  
belongsTo Media (featured_image)

---

# Gallery

Represents a collection of images documenting an event or activity.

Examples:

- Activities 2024
- Physiotherapy sessions
- Special celebrations

Fields:

id  
title  
slug  
description  
created_at  
updated_at

Relationships:

Gallery  
hasMany GalleryImage

---

# GalleryImage

Represents an image belonging to a gallery.

Fields:

id  
gallery_id  
media_id  
caption  
position  
created_at  
updated_at

Relationships:

GalleryImage  
belongsTo Gallery  
belongsTo Media

---

# Event

Represents events organized by the foundation.

Examples:

- community gatherings
- volunteer events
- celebrations

Fields:

id  
title  
slug  
description  
start_date  
end_date  
location  
featured_image_id  
created_at  
updated_at

Relationships:

Event  
belongsTo Media (featured_image)

---

# Document

Represents transparency or institutional documents.

Examples:

- DIAN registry
- annual documentation
- institutional reports

Fields:

id  
title  
description  
document_category_id  
document_year_id  
media_id  
created_at  
updated_at

Relationships:

Document  
belongsTo DocumentCategory  
belongsTo DocumentYear  
belongsTo Media

---

# DocumentCategory

Represents types of institutional documents.

Examples:

- DIAN Registry
- Annual Report
- Legal Documentation

Fields:

id  
name  
slug  
created_at  
updated_at

Relationships:

DocumentCategory  
hasMany Documents

---

# DocumentYear

Represents the year associated with a document.

Examples:

2023  
2024  
2025

Fields:

id  
year  
created_at  
updated_at

Relationships:

DocumentYear  
hasMany Documents

---

# Media

Represents uploaded files.

Supports:

- images
- documents

Fields:

id  
file_path  
file_name  
mime_type  
file_size  
alt_text  
created_at  
updated_at

Relationships:

Media  
usedBy many entities

Examples:

Activity  
Event  
GalleryImage  
Document

---

# User

Represents authenticated users of the admin panel.

Fields:

id  
name  
email  
password  
role  
created_at  
updated_at

Role values:

admin  
editor

Relationships:

User  
manages content

---

# 4. Relationships Summary

Page

(no required relationships)

Activity

belongsTo Media (featured image)

Gallery

hasMany GalleryImage

GalleryImage

belongsTo Gallery  
belongsTo Media

Event

belongsTo Media (featured image)

Document

belongsTo DocumentCategory  
belongsTo DocumentYear  
belongsTo Media

DocumentCategory

hasMany Documents

DocumentYear

hasMany Documents

---

# 5. Content Status Workflow

Content entities (Page, Activity) support the following status workflow.

draft  
published  
archived

This allows editors to prepare content before making it public.

---

# 6. Slug Usage

Entities that appear in public URLs use slugs.

Entities using slugs:

Page  
Activity  
Gallery  
Event

Example URLs:

/about  
/activities/community-visit  
/galleries/activities-2024  
/events/foundation-anniversary

---

# 7. Media Usage Strategy

Media files should be stored centrally.

Media may be used by:

Activities  
Events  
Galleries  
Documents

Images should support:

alt_text for accessibility

Documents will typically include:

PDF files

---

# 8. Future Extensions

The domain model allows future additions.

Potential extensions:

Volunteer entity  
Donation entity  
Newsletter entity  
Event registration

These features are not part of the initial scope.

---

# 9. Laravel Conventions

Expected model naming conventions.

Models:

Page  
Activity  
Gallery  
GalleryImage  
Event  
Document  
DocumentCategory  
DocumentYear  
Media  
User

Tables follow Laravel plural naming:

pages  
activities  
galleries  
gallery_images  
events  
documents  
document_categories  
document_years  
media