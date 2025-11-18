# SIgap TBC UI Implementation Checklist

1. Add stylesheet import
   - Link resources/css/si_gap_tbc.css after Bootstrap/Soft UI in your main Blade layout:
     <link rel="stylesheet" href="{{ mix(\'/css/si_gap_tbc.css\') }}">

2. Components
   - Use components:
     - resources/views/components/si_gap_card.blade.php
     - resources/views/components/si_gap_form.blade.php

3. Apply classes
   - Replace default card classes with `si-gap-card`
   - Use `btn-si-primary`, `btn-outline-si`, `btn-danger-si` for consistent buttons
   - Use `.table-si` for tables

4. Accessibility & Responsiveness
   - Ensure form labels are tied to inputs (add ids when needed)
   - Verify breakpoints on real devices (mobile-first)

5. Interactivity
   - Keep transitions subtle (200ms)
   - Prefer CSS hover/transform for light interactions

6. Review
   - Check color contrast for red accent on small text
   - Test each role view (5 roles) for spacing & hierarchy

7. Build
   - Recompile assets: run your usual build (e.g., npm run dev / prod) and clear view cache if necessary.

