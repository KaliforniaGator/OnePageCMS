# Addon Controls

The addon controls system allows you to manage which addons load globally (on every page) versus on-demand (only when needed) for optimal performance.

## Configuration File

Location: `includes/addon-controls.php`

## Loading Strategies

### 1. **Global Loading**
Addons in the `global` array load their styles and scripts on every page.

**Use for:**
- Analytics/tracking scripts
- Chat widgets
- Cookie banners
- Site-wide features
- Global navigation enhancements

**Example:**
```php
'global' => [
    'analytics',
    'chat-widget',
    'cookie-banner'
]
```

### 2. **On-Demand Loading**
Addons in the `on-demand` array only load when their specific page is accessed.

**Use for:**
- Page builders
- Admin panels
- Tools/utilities
- Feature-specific pages

**Example:**
```php
'on-demand' => [
    'page-builder',
    'admin-dashboard',
    'form-builder'
]
```

### 3. **Disabled**
Addons in the `disabled` array won't load at all.

**Use for:**
- Temporarily disabling features
- Deprecated addons
- Testing/development

**Example:**
```php
'disabled' => [
    'old-feature',
    'beta-addon'
]
```

## How It Works

### Priority Order

1. **Disabled Check** - If addon is in `disabled`, it won't load at all
2. **Global Check** - If addon is in `global`, it loads on every page
3. **On-Demand Check** - If addon is in `on-demand`, it loads only on its page
4. **Fallback** - If not configured, uses `scope` from `entry.json`

### Style Loading Logic

```
┌─────────────────────────────────────┐
│ Is addon disabled?                  │
│ YES → Skip completely               │
│ NO → Continue                       │
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│ Is addon in 'global' array?         │
│ YES → Load all styles               │
│ NO → Continue                       │
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│ Is addon in 'on-demand' array?      │
│ YES → Load only on addon's page     │
│ NO → Continue                       │
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│ Use scope from entry.json           │
│ - global: Load on all pages         │
│ - page-only: Load on addon's page   │
└─────────────────────────────────────┘
```

## Configuration Examples

### Example 1: Performance-Optimized Site

```php
return [
    'global' => [
        // Only essential global features
        'analytics'
    ],
    'on-demand' => [
        // Everything else loads on-demand
        'page-builder',
        'admin-panel',
        'form-builder',
        'image-gallery'
    ],
    'disabled' => []
];
```

### Example 2: Feature-Rich Site

```php
return [
    'global' => [
        // Many features available everywhere
        'chat-widget',
        'analytics',
        'cookie-banner',
        'search-bar',
        'notifications'
    ],
    'on-demand' => [
        // Only heavy tools load on-demand
        'page-builder',
        'admin-dashboard'
    ],
    'disabled' => [
        'old-editor'
    ]
];
```

### Example 3: Development/Testing

```php
return [
    'global' => [],
    'on-demand' => [
        'page-builder'
    ],
    'disabled' => [
        // Disable features being tested
        'new-feature',
        'experimental-addon'
    ]
];
```

## Performance Impact

### Global Loading
- **Pros:** Features available immediately on all pages
- **Cons:** Increases initial page load time
- **Best for:** Lightweight addons (<10KB CSS/JS)

### On-Demand Loading
- **Pros:** Faster initial page loads, only loads when needed
- **Cons:** Slight delay when accessing addon page for first time
- **Best for:** Heavy addons (>50KB CSS/JS) or rarely-used features

## Helper Functions

### `should_addon_load_globally($addonId)`
Check if an addon should load on every page.

```php
if (should_addon_load_globally('analytics')) {
    // Load analytics everywhere
}
```

### `is_addon_disabled($addonId)`
Check if an addon is disabled.

```php
if (is_addon_disabled('old-feature')) {
    // Skip this addon
}
```

### `should_addon_load_on_demand($addonId)`
Check if an addon loads only on its page.

```php
if (should_addon_load_on_demand('page-builder')) {
    // Load only on /?page=page-builder
}
```

## Best Practices

### 1. Start Conservative
Begin with most addons in `on-demand`, then move to `global` only if needed.

### 2. Monitor Performance
Use browser DevTools to check:
- Total CSS size
- Total JS size
- Page load time

### 3. Group by Weight
- **Lightweight** (<10KB) → Consider `global`
- **Medium** (10-50KB) → Usually `on-demand`
- **Heavy** (>50KB) → Always `on-demand`

### 4. Consider Usage Frequency
- **Used on every page** → `global`
- **Used occasionally** → `on-demand`
- **Rarely used** → `on-demand`

### 5. Test Both Strategies
For critical addons, test both global and on-demand to see which provides better UX.

## Troubleshooting

### Addon Not Loading
1. Check if it's in `disabled` array
2. Verify `enabled: true` in `entry.json`
3. Check addon ID matches directory name
4. Clear browser cache

### Styles Not Applying
1. Check if addon is in correct array (`global` or `on-demand`)
2. Verify you're on the correct page for `on-demand` addons
3. Check browser Network tab for 404 errors
4. Verify CSS file path in `entry.json`

### Performance Issues
1. Move heavy addons from `global` to `on-demand`
2. Check total CSS size in browser DevTools
3. Consider lazy-loading images/assets
4. Minify CSS files

## Migration Guide

### From entry.json scope to addon-controls

**Before (entry.json only):**
```json
{
  "load": {
    "styles": [
      { "file": "style.css", "scope": "global" }
    ]
  }
}
```

**After (using addon-controls):**
```php
// In addon-controls.php
'global' => ['my-addon']

// In entry.json (scope is now optional)
{
  "load": {
    "styles": [
      { "file": "style.css" }
    ]
  }
}
```

## Summary

The addon controls system gives you fine-grained control over addon loading:

- ✅ Optimize performance by loading only what's needed
- ✅ Easy to enable/disable features
- ✅ Clear separation of global vs on-demand addons
- ✅ Fallback to entry.json scope if not configured
- ✅ Simple configuration in one central file
