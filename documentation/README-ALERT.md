# Alert Block

The Alert block creates customizable alert messages with different types and styles for user notifications.

## Features

- **4 Alert Types**: Info, Success, Warning, Error
- **4 Alert Styles**: Inline, Banner, Toast, Popup
- **Dismissible**: Optional close button
- **Auto-dismiss**: Automatic dismissal for toast notifications
- **Icons**: Automatic or custom icons
- **Positioning**: Multiple position options for toast and popup styles
- **Animations**: Smooth entrance and exit animations

## Basic Usage

```php
echo block_alert([
    'message' => 'This is an alert message',
    'type' => 'info',
    'style' => 'inline'
]);
```

## Configuration Options

### Required
- `message` - The alert message content (string)

### Optional
- `type` - Alert type: 'info', 'success', 'warning', 'error' (default: 'info')
- `style` - Alert style: 'inline', 'banner', 'toast', 'popup' (default: 'inline')
- `dismissible` - Whether alert can be dismissed (boolean, default: true)
- `icon` - Icon class (string, optional - uses default icon if not provided)
- `title` - Alert title (string, optional)
- `duration` - Auto-dismiss duration in milliseconds for toast (integer, default: 5000, 0 = no auto-dismiss)
- `position` - Position for toast/popup: 'top-right', 'top-left', 'bottom-right', 'bottom-left', 'top-center', 'bottom-center' (default: 'top-right')
- `id` - Custom ID for the alert (string, optional)
- `class` - Additional CSS classes (string, optional)

## Alert Types

### Info Alert
```php
echo block_alert([
    'message' => 'This is an informational message',
    'type' => 'info'
]);
```

### Success Alert
```php
echo block_alert([
    'message' => 'Operation completed successfully!',
    'type' => 'success'
]);
```

### Warning Alert
```php
echo block_alert([
    'message' => 'Please be careful with this action',
    'type' => 'warning'
]);
```

### Error Alert
```php
echo block_alert([
    'message' => 'An error occurred. Please try again.',
    'type' => 'error'
]);
```

## Alert Styles

### Inline Alert (Default)
Standard alert displayed within the page content flow.

```php
echo block_alert([
    'message' => 'This is an inline alert',
    'style' => 'inline',
    'type' => 'info'
]);
```

### Banner Alert
Full-width alert displayed at the top or within a section.

```php
echo block_alert([
    'message' => 'This is a banner alert',
    'style' => 'banner',
    'type' => 'warning'
]);
```

### Toast Notification
Floating notification that appears in a corner of the screen.

```php
echo block_alert([
    'message' => 'This is a toast notification',
    'style' => 'toast',
    'type' => 'success',
    'position' => 'top-right',
    'duration' => 5000
]);
```

### Popup/Modal Alert
Centered popup alert that appears over the content.

```php
echo block_alert([
    'message' => 'This is a popup alert',
    'style' => 'popup',
    'type' => 'error',
    'position' => 'top-center'
]);
```

## Advanced Examples

### Alert with Title
```php
echo block_alert([
    'title' => 'Important Notice',
    'message' => 'Please read this carefully before proceeding.',
    'type' => 'warning',
    'style' => 'inline'
]);
```

### Alert with Custom Icon
```php
echo block_alert([
    'message' => 'Your profile has been updated',
    'type' => 'success',
    'icon' => 'fas fa-user-check'
]);
```

### Non-dismissible Alert
```php
echo block_alert([
    'message' => 'This alert cannot be closed',
    'type' => 'info',
    'dismissible' => false
]);
```

### Toast with Custom Duration
```php
echo block_alert([
    'message' => 'This will disappear in 3 seconds',
    'style' => 'toast',
    'type' => 'info',
    'duration' => 3000,
    'position' => 'bottom-right'
]);
```

### Toast that Doesn't Auto-dismiss
```php
echo block_alert([
    'message' => 'This toast stays until manually closed',
    'style' => 'toast',
    'type' => 'success',
    'duration' => 0,
    'position' => 'top-center'
]);
```

## Position Options

For `toast` and `popup` styles, you can use these positions:

- `top-right` - Top right corner (default)
- `top-left` - Top left corner
- `top-center` - Top center
- `bottom-right` - Bottom right corner
- `bottom-left` - Bottom left corner
- `bottom-center` - Bottom center

## JavaScript Integration

### Dismissing Alerts Programmatically
```javascript
dismissAlert('alert-id');
```

### Creating Dynamic Alerts with JavaScript
```php
// Use block_alert_js() to generate JavaScript that creates an alert
echo block_alert_js([
    'message' => 'This alert is created via JavaScript',
    'style' => 'toast',
    'type' => 'success'
]);
```

## Form Validation Example

```php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['email'])) {
        $message = block_alert([
            'message' => 'Email is required',
            'type' => 'error',
            'style' => 'inline'
        ]);
    } else {
        $message = block_alert([
            'message' => 'Form submitted successfully!',
            'type' => 'success',
            'style' => 'toast',
            'position' => 'top-right'
        ]);
    }
}

echo $message;
```

## Styling

All alert styles are defined in `/framework-styles/blocks.css`. You can customize colors and animations by modifying the CSS variables or the alert classes.

## Accessibility

- Alerts include `role="alert"` for screen readers
- Close buttons have `aria-label="Close"` for accessibility
- Color contrast meets WCAG guidelines

## Browser Support

Works in all modern browsers with CSS animations and JavaScript support.
