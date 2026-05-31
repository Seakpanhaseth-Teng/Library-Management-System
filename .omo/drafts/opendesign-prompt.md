# OpenDesign Prompt: Library Management System Redesign

## Project Overview

**Library Management System (LibraryOS)** — a web app for librarians and members to manage book collections, track borrowings, handle returns, and process fines. Built with Laravel 12 (Blade templates) + TailwindCSS v4 + Vite 6. Currently has 20 Blade views across 2 layouts.

**Audience**: Librarians (daily power users), library members (occasional users), admins.
**Tone**: Professional, warm, trustworthy. Should feel like a serious tool, not a toy.
**Current theme**: Indigo (primary-600: #4f46e5) + Amber (accent-600: #d97706) — keep these colors but you may extend the palette.

## Core Design Goals

1. **Reader-friendly tables** — data-heavy pages need clear hierarchy, sticky headers, row hover states, responsive on mobile
2. **Consistent component system** — buttons, cards, inputs, badges, modals, empty states should be consistent patterns
3. **Dashboard as centerpiece** — this is the landing page for staff; stats, charts, activity feed need to feel alive
4. **Smooth auth flow** — login/register pages are the first impression; make them polished but fast
5. **Mobile responsive** — sidebar nav collapses to hamburger, tables scroll horizontally, forms stack vertically

## Technical Constraints

- **Laravel Blade**: All views use Blade templating (`@extends`, `@section`, `@include`). Keep this structure.
- **TailwindCSS v4**: Use Tailwind utility classes only. The existing `app.css` defines `--color-primary-*` (indigo) and `--color-accent-*` (amber) — use `text-primary-600`, `bg-accent-500`, etc. You can add new tokens.
- **Keep existing layouts**: The two layouts (`layouts/app.blade.php` and `layouts/guest.blade.php`) define the page shell. Redesign within them — don't break the sidebar, flash messages, or auth check sections.
- **No JS framework**: No Alpine.js, no Vue, no React. If you need JavaScript interactivity, use vanilla JS in `@stack('scripts')` blocks.
- **Form names/IDs**: Keep existing form field names (`name`, `email`, `password`, `title`, `author`, `isbn`, etc.) — backend controllers depend on them.
- **Route names**: Keep existing route helpers (`route('login')`, `route('borrowings.index')`, `url('/all/books')`, etc.).

## Design System Recommendation

I recommend the **Linear** design system for this project — it's clean, professional, and optimized for data-heavy dashboards. If not available, use **Modern Minimal** direction with:
- Clean sans-serif font (Inter or similar)
- Generous whitespace
- Subtle shadows for depth
- Color-coded status indicators
- Smooth micro-animations on hover/focus

## Pages to Redesign (20 views)

### LAYOUTS (2)

#### 1. layouts/app.blade.php
**Current**: Sidebar with icon navigation, user avatar, mobile hamburger toggle, flash message banners for success/error/warning/info.
**Needs**: 
- Make sidebar collapsible with smooth animation (already has toggle function, polish it)
- Add sidebar tooltips on collapsed state
- Make mobile hamburger transition smoother
- Flash messages should be auto-dismissing toasts, not static banners
- Add subtle active indicator animations
- Better user dropdown (instead of just "Sign out" link)

#### 2. layouts/guest.blade.php
**Current**: Centered card with logo and footer. Clean but minimal.
**Needs**:
- Add subtle background pattern or gradient
- Better card shadow/depth
- Animated logo entrance
- Social proof (add a small testimonial or stats line)

---

### AUTH (5 views)

#### 3. auth/login.blade.php
**Current**: Card with email/password fields, forgot password link, submit button.
**Needs**:
- Add decorative illustration or icon on the left (on wider screens)
- Better input focus states with smooth transitions
- Password visibility toggle
- "Remember me" checkbox styling
- Show login attempt countdown if rate-limited

#### 4. auth/register.blade.php
**Current**: Card with name/email/password/confirm fields, submit button.
**Needs**:
- Password strength indicator
- Visual confirmation match indicator
- Same decorative treatment as login
- Terms acceptance checkbox

#### 5. auth/verify-email.blade.php
**Current**: Simple notice card with resend button.
**Needs**:
- Better visual with mail/checkmark icon
- Countdown timer on resend button
- Option to logout from this page

#### 6. auth/forgot-password.blade.php
**Current**: Card with email field.
**Needs**:
- Better success state after sending
- Back to login link placement
- Icon enhancement

#### 7. auth/reset-password.blade.php
**Current**: Card with email/password/confirm + token.
**Needs**:
- Same polish as register form
- Hidden token field styling (or better UX)

---

### BOOKS (7 views)

#### 8. books/all_books.blade.php
**Current**: Table with 10 columns (index, title, author, publisher, year, genre, shelf, copies, status, actions). Search bar at top, filter buttons at bottom.
**Needs**:
- Sticky table header when scrolling
- Row expand/collapse on mobile instead of horizontal scroll
- Better search with clear button and search icon inside input
- Filter pills should be at top, not bottom
- Convert filter buttons to a horizontal scrollable pill group
- Add sorting indicators on column headers
- Striped rows or alternating background
- Cover image thumbnail in first column
- Better empty state with illustration
- Pagination should be at both top and bottom

#### 9. books/available.blade.php, books/fiction.blade.php, books/nonfiction.blade.php
**Current**: Same table style with genre-filtered data. Currently renders via `genre.blade.php` which is a shared template.
**Needs**:
- Same table improvements as all_books
- Active filter should be visually distinct (pill stays highlighted)
- Count badge showing number of results

#### 10. books/show.blade.php
**Current**: Split layout — left has cover image (or gradient placeholder), right has details grid (ISBN, genre, publisher, year, pages, shelf, copies) with action buttons.
**Needs**:
- Better cover image handling (lazy loading, fallback animation)
- Detail grid should use icons per field
- Add borrowing history for this book at the bottom
- Action buttons should have hover tooltips
- Add breadcrumb navigation
- Better color-coded status badge (pulsing green for available)

#### 11. books/create_book.blade.php + books/edit.blade.php + books/_form.blade.php
**Current**: 2-column form grid (title, author, isbn, genre, publisher, year, pages, shelf, copies, availability, cover upload). Shared `_form.blade.php` partial.
**Needs**:
- Floating labels or better label positioning
- Inline validation with real-time feedback
- Better file upload with drag-and-drop zone and preview
- Autocomplete suggestions for genre (allow typing freeform still)
- Helper text under each field
- Make cover image preview larger and draggable
- Keyboard shortcuts for save/cancel

---

### DASHBOARD (1 view)

#### 12. dashboard/index.blade.php
**Current**: 3 stat cards (total books, active borrowings, fines), genre distribution bar chart, borrowed vs available donut chart (SVG), popular books list, recent activity feed. Already decent.
**Needs**:
- Stat cards should have micro-animated counters (count up on load)
- Add trend indicators (up/down arrows with percentages)
- Genre bars should be animated on load
- Donut chart should animate on load (stroke-dashoffset animation)
- Add "Quick Actions" toolbar at top
- Recent activity should show relative time with color dots
- Add a calendar/date range filter
- Make cards clickable (link to filtered view)
- Sparkline mini-charts for weekly trends

---

### BORROWINGS (2 views)

#### 13. borrowings/index.blade.php
**Current**: Table with book info (icon + title/author), borrower (for staff), borrowed date, due date, status badge, fine column, return action.
**Needs**:
- Color-code overdue items (red row highlight, not just badge)
- Add days-remaining countdown for active borrowings
- Better book icon (small cover thumbnail instead of SVG icon)
- Filter tabs: All | Active | Overdue | Returned
- Bulk return action checkbox
- Sortable columns
- Quick-status tooltip on hover
- Pagination at both top and bottom

#### 14. borrowings/create.blade.php
**Current**: Form with member select (staff only), book select, loan terms info box, submit/cancel buttons.
**Needs**:
- Book search with autocomplete (typeahead)
- Member search with autocomplete (typeahead)
- Show book cover thumbnail next to selected book
- Show member avatar + details after selection
- Better info box styling (loan terms)
- Due date preview showing calculated return date
- Max borrowings count for the selected member

---

### FINES (1 view)

#### 15. fines/index.blade.php
**Current**: Table with book, member, reason (overdue days), amount, status badge, pay action.
**Needs**:
- Color-coded severity for fine amounts (small=amber, medium=orange, large=red)
- Paid/unpaid toggle filter
- Total outstanding amount at top (already there, make it a card)
- Pay action should open a confirmation modal, not browser confirm()
- Show payment date and method
- Summary row at bottom with totals

---

### WELCOME / MARKETING (1 view)

#### 16. welcome.blade.php
**Current**: Full marketing page with hero section, terminal-style stats widget, 6 feature cards, footer. Standalone (no layout).
**Needs**:
- Hero could have animated gradient or particle background
- Stats widget in hero is a "terminal" concept — modernize it to clean stat cards or keep the terminal vibe but polish it
- Feature cards should have staggered entrance animation on scroll
- Add a "how it works" section with 3-step flow
- Add social proof / testimonials section
- Better mobile layout for hero section
- Add floating navigation that becomes sticky on scroll
- CTA buttons should have subtle pulse/hover effect

---

### EMAIL (1 view)

#### 17. emails/password-reset.blade.php
**Current**: Plain email template.
**Needs**:
- Styled email with proper HTML email best practices
- Branded header and footer
- Responsive email layout
- Clear CTA button for reset

---

**Additional improvements across ALL pages:**
- Add page transition/fade animation on route change
- Consistent loading skeleton states
- Better "empty state" illustrations for every table
- Keyboard shortcuts for power users (`n` for new, `/` for search, `e` for edit)
- Focus trap in modals for accessibility
- Reduced motion media query for animations

## What NOT to Change

- Don't change the data model or add new DB columns
- Don't change route names or URLs
- Don't remove existing Laravel Blade directives (`@auth`, `@can`, `@error`, `@session`)
- Don't remove existing form field names or IDs
- Don't change the auth guard or middleware logic
- Don't remove the sidebar toggle JavaScript function
- Don't remove flash message session keys (`success`, `error`, `status`, `message`)

## Output Format

Write the redesigned Blade files directly to `resources/views/`. Use the existing file structure. Each view should be a complete `@extends('layouts.app')` or `@extends('layouts.guest')` file. Keep the `@section('content')` pattern.

For CSS, update `resources/css/app.css` with any new design tokens needed (new color stops, animation keyframes, component utilities).

For any JavaScript interactivity beyond what Tailwind provides, add it via `@stack('scripts')` in each view, or add a single `resources/js/app.js` enhancement.
